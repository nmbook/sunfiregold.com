<?php

if (!isset($templ_page_valid)) {
  header('Location: /');
  exit();
}

function page_curl($url, $post=false, $postdata='') {
  global $s;
  
  // create a new cURL resource
  $ch = curl_init();

  // set URL and other appropriate options
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_HEADER, false);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  
  if ($post) {
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
  }

  // grab URL and pass it to the browser
  $str = curl_exec($ch);

  // close cURL resource, and free up system resources
  curl_close($ch);
  
  // wait a second, this may mean this script will
  // take a long time
  sleep(1);
  
  return $str;
}

// does a search on k9data.com for the specified name,
// if found 1 result, returns the dog's ID
// if no results found, returns 0
// if multiple results found, returns negative number of dogs found
function k9data_post_search($query) {
  $postdata =
      'name='.urlencode($query).
      '&B1=Search'.
      '&nojump=on';
  $results_page =
      page_curl(
          'http://www.k9data.com/verify.asp?breed=1',
          true,
          $postdata);
  
  $results = array();
  
  $pos = 0;
  
  do {
    $pos = strpos($results_page, '<a href="pedigree.asp?ID=', $pos);
    if ($pos === false)
      break;
    $pos += 25;
    
    $e = strpos($results_page, '">', $pos);
    if ($e === false)
      break;
      
    $pos2 = $e + 2;
    $e2 = strpos($results_page, '</a>', $pos2);
    if ($e2 === false)
      break;
    
    $results[] = array(
      'id' => (int) substr($results_page, $pos, $e - $pos),
      'anchor' => substr($results_page, $pos2, $e2 - $pos2)
      );
  } while ($pos > 0);
  
  if (count($results) == 0)
    return 0;
  else if (count($results) == 1)
    return $results[0]['id'];
  else
    return -1 * count($results);
}

function k9data_get($page, $id) {
  return page_curl("http://www.k9data.com/$page.asp?ID=$id");
}

function parse_dogdata($id) {
  $pedigree_page = k9data_get('pedigree', $id);
  
  $data = array();
  $pos = 0;
  
  $pos = strpos($pedigree_page, '<font size="4">', $pos);
  if ($pos === false)
    return array();
  $pos += 15;
  
  $e = strpos($pedigree_page, '</font>', $pos);
  if ($e === false)
    return array();
  
  $data['name'] = substr($pedigree_page, $pos, $e - $pos);
  
  do {
    $pos = strpos($pedigree_page, '<td width="23%">', $pos);
    if ($pos === false)
      break;
    
    $pos += 16;
    $e = strpos($pedigree_page, ':</td>', $pos);
    if ($e === false)
      break;
    
    $key = substr($pedigree_page, $pos, $e - $pos);

    $pos = strpos($pedigree_page, '<td width="77%">', $pos);
    if ($pos === false)
      break;
    
    $pos += 16;
    $e = strpos($pedigree_page, '</td>', $pos);
    if ($e === false)
      break;
    
    $val = substr($pedigree_page, $pos, $e - $pos);
    
    $data[$key] = $val;
  } while ($pos > 0);
  
  return $data;
}

function parse_offspring($id) {
  $offspring_page = k9data_get('offspring', $id);
  $pos = 0;
  
  $offspring_groups = array();
  do {
    $pos = strpos($offspring_page, '<strong>By ', $pos);
    if ($pos === false)
      break;
    
    $pos += 11;
    
    $e = strpos($offspring_page, ':</strong>', $pos);
    if ($e === false)
      break;
    
    $other_parent = substr($offspring_page, $pos, $e - $pos);
    
    $offspring = array();
    $pos2 = $pos;
    do {
      $pos_next = strpos($offspring_page, '<strong>By ', $pos);
    
      $pos2 = strpos($offspring_page, '<a href="pedigree.asp?ID=', $pos2);
      if ($pos2 === false || ($pos2 > $pos_next && $pos_next > 0))
        break;
      
      $pos2 += 25;
      
      $e = strpos($offspring_page, '">', $pos2);
      if ($e === false)
        break;
      
      $offspring[] = substr($offspring_page, $pos2, $e - $pos2);
      
    } while ($pos2 > 0);
    $offspring_groups[] =
      array('other' => $other_parent,
            'offspring' => $offspring);
    
  } while ($pos > 0);
  
  return $offspring_groups;
}

$checked_off = array();
$checked_ped = array();

$recur = 0;
$s = 0;

function find_offspring_titled($id) {
  global $recur;
  global $checked_off;
  global $checked_ped;
  global $s;
  //if ($recur > 100)
  //  return array();
  $recur++;
  foreach ($checked_off as $x) {
    if ($x == $id)
      return array();
  }
  $checked_off[] = $id;
  $off_titled = array();
  $offspring_groups = parse_offspring($id);
  foreach ($offspring_groups as $grp) {
    foreach ($grp['offspring'] as $off_id) {
      $checked = false;
      foreach ($checked_ped as $x) {
        if ($x == $off_id)
          $checked = true;
      }
      $checked_ped[] = $off_id;
      if (!$checked) {
        $dog_data = parse_dogdata($off_id);
        if (is_titled($dog_data['name'])) {
          $off_titled["#$off_id"] = $dog_data['name'];
        }
        
        if (is_us($dog_data['Owner'])) {
          $s++;
          $off_titled =
                array_merge((array)$off_titled,
                (array)find_offspring_titled($off_id));
          $s--;
        }
      }
    }
  }
  return $off_titled;
}

function is_us($dog_owner) {
  global $s;
  $dog_owner = strtolower($dog_owner);
  $dog_owner = str_replace('. ', ' ', $dog_owner);
  $dog_owner = str_replace('.', ' ', $dog_owner);
  if (strpos($dog_owner, 'barbara f biewer') !== false ||
      strpos($dog_owner, 'barbara biewer') !== false ||
      strpos($dog_owner, 'michael a book') !== false ||
      strpos($dog_owner, 'michael book') !== false) {
    echo str_repeat(' ', $s)."OWNED BY?YES $dog_owner\r\n";
    return true;
  } else {
    echo str_repeat(' ', $s)."OWNED BY?NO $dog_owner\r\n";
    return false;
  }
}

function is_titled($dog_name) {
  global $s;
  echo $dog_name."\r\n";
  $dog_name = str_replace('AmUD', 'AM UD', $dog_name);
  $dog_name = str_replace(',', ' ', $dog_name);
  $dog_name = str_replace(';', ' ', $dog_name);
  $dog_name = str_replace('-', ' ', $dog_name);
  $dog_name = str_replace(':', ' ', $dog_name);
  $dog_name = str_replace('0', '#', $dog_name);
  $dog_name = str_replace('1', '#', $dog_name);
  $dog_name = str_replace('2', '#', $dog_name);
  $dog_name = str_replace('3', '#', $dog_name);
  $dog_name = str_replace('4', '#', $dog_name);
  $dog_name = str_replace('5', '#', $dog_name);
  $dog_name = str_replace('6', '#', $dog_name);
  $dog_name = str_replace('7', '#', $dog_name);
  $dog_name = str_replace('8', '#', $dog_name);
  $dog_name = str_replace('9', '#', $dog_name);
  $dog_name = strtoupper($dog_name);
  $words_sp = explode(' ', $dog_name);
  foreach ($words_sp as $w) {
    switch ($w) {
      case 'UD':
      case 'UDX':
      case 'UDT':
      case 'UDTX':
      case 'UDX#':
      case 'UDX##':
      case 'OTCH':
        echo str_repeat(' ', $s)."FOUND TITLE? $w\r\n";
        return true;
    }
  }
  return false;
}

//$id = 474;

//$off_list = find_offspring_titled($id);

//print_r($off_list);

//print_r(parse_dogdata(474));
?>
