<?php

if (!isset($templ_page_valid)) {
  header('Location: /');
  exit();
}

function print_dog_list($where, $order_by, $header_level = 3, $header_text = '', $return_to = 'ourdogs') {
  global $_DB;
  global $is_signed_in;
  
  $o = '';

  $sql =
  "SELECT `id`, `name_short`
   FROM `$_DB[dbname]`.`dogs`
   WHERE $where
   ORDER BY $order_by, `name_short` ASC";
  $result = db_query($sql);
  
  $count = 0;
  while ($row = mysql_fetch_array($result)) {
    $count++;
    if ($count == 1) {
      if ($header_level >= 1) {
        $o .= "<h$header_level>$header_text</h$header_level>"
           .  "<dl>";
      }
      
      if ($is_signed_in) {
        $o .= ' <p><a class="edit" href="'
           .  'ourdogs.php?act=add';
        if ($return_to != 'ourdogs')
          $o .= "&returnto=$return_to";
        $o .= '">Create New</a></p>';
      }
    }
    
    $o .= '<div class="list_element">'.print_dog($row['id'], 1, $return_to).'</div>';
  }
  
  if ($count > 0) {
    $o .= "</dl>";
  }
  
  return $o;
}

// prints a dog from the dogs database in one of a few styles.
// Style 0: one line, for litters page
// Style 1: two lines, for our dogs page
// Style 2: no links with birth & death, for stories
// Style 3: nickname only
// Style 4: one line, text only
function print_dog($id, $style = 0, $return_to = 'ourdogs') {
  global $_DB;
  global $is_signed_in;
  
  $o = '';
  
  $sql =
  "SELECT
     DATEDIFF(
              IF(`date_death_mask` = 0,
                 DATE(NOW()),
                 IF(`date_death_mask` = 1,
                    `date_death`,
                    IF(`date_death_mask` = 2,
                       DATE_ADD(MAKEDATE(YEAR(`date_death`), 1),
                                INTERVAL MONTH(`date_death`) MONTH),
                       IF(`date_death_mask` = 3,
                          MAKEDATE(YEAR(`date_death`), 1),
                          `date_birth`)))),
              `date_birth`) AS `age_days`,
     `id`,
     `name_short`, `name_full`,
     `titles_pre`, `titles_post`,
     `gender`,
     `k9data_id`, `pedigree_id`,
     `own_state`, `own_by`,
     `date_birth`, `date_death`,
     `date_death_mask`
   FROM `$_DB[dbname]`.`dogs`
   WHERE `id` = '$id'
   LIMIT 1";
  $row = mysql_fetch_array(db_query($sql));
  
  //$death_known =
  //    $row['date_death_mask'] == 1 ||
  //    $row['date_death_mask'] == 2 ||
  //    $row['date_death_mask'] == 3;
  
  if ($style == 3) {
    return htmlentities($row['name_short']);
  }
  
  if ($style == 1) {
    $o .= '<dt>';
  }
  
  //$row['age_days'] /= 365.25;
  //echo '('.($row[age_days]/365.25).')';
  
  if ($style == 1) {
    $age_years = $row['age_days'] / 365.25;
    $age_years += 0.05;
    if ($age_years >= 15) {
      $o .= '<span class="honor_age" title="This dog has lived for '.floor($age_years).' years">&bull;&bull;</span>';
    } else if ($age_years >= 14) {
      $o .= '<span class="honor_age" title="This dog has lived for 14 years">&bull;</span>';
    }
  }
  
  $o .= print_titles($row['titles_pre'], 'PRE', $style != 4);
  $o .= $row['name_full'];
  $o .= print_titles($row['titles_post'], 'POST', $style != 4);
  
  if (strlen($row['name_short']) > 0) {
    if ($style == 4) {
      $o .= ' "';
    } else {
      $o .= ' <q class="';
    
      if ($row['gender'] == 'MALE')
        $o .= 'm';
      else
        $o .= 'f';
      
      $o .= '">';
    }
    
    $o .= $row['name_short'];
    
    if ($style == 4) {
      $o .= '"';
    } else {
      $o .= '</q>';
    }
  }

  if (strlen($row['k9data_id']) > 0 &&
      ($style == 0 || $style == 1)) {
    $o .= ' <a href="http://www.k9data.com/pedigree.asp?ID=';
    $o .= $row['k9data_id'];
    $o .= '" target="_blank" title="K9Data Entry" class="dog_link">K9Data</a>';
  }
  
  if (strlen($row['pedigree_id']) > 0 &&
      ($style == 0 || $style == 1)) {
    $o .= print_pedigree_link($row['pedigree_id'], 0, false, 'dog_link');
  }
  
  if ($style == 2 || $style == 4) {
    $date_b = $row['date_birth'];
    $date_d = $row['date_death'];
    
    $date_b = date('m/d/Y', strtotime($date_b));
    $date_d = str_replace('-00', '-01', $date_d);
    $date_d = strtotime($date_d);
    
    $o .= "($date_b - ";
    switch ($row['date_death_mask']) {
      case 0: // alive
        $o .= 'present'; break;
      case 1: // not alive, ####-##-##
        $o .= date('m/d/Y', $date_d); break;
      case 2: // not alive, ####-##-00
        $o .= date('d/Y', $date_d); break;
      case 3: // not alive, ####-00-00
        $o .= date('Y', $date_d); break;
      case 4: // not alive, 0000-00-00
        $o .= 'unknown'; break;
    }
    $o .= ")";
  }

  if ($is_signed_in && $style == 1) {
    $o .= ' <a class="edit" href="ourdogs.php?act=edit&id=';
    $o .= $row['id'];
    if ($return_to != 'ourdogs')
        $o .= '&returnto=' . $return_to;
    $o .= '">Edit'."</a>\r\n";
  }
  
  if ($style == 1) {
    $o .= '</dt>';
    $alive = $row['date_death_mask'] == 0;
    switch ($row['own_state']) {
      default:
      case 'NONE': $own_state = ''; break;
      case 'LW': $own_state = 'Live'.($alive ? 's' : 'd').' with *'; break;
      case 'LWP': $own_state = 'Live'.($alive ? 's' : 'd').' with pet home'; break;
      case 'OW': $own_state = 'Owned with *'; break;
      case 'OB': $own_state = 'Owned by *'; break;
      case 'AF': $own_state = $alive ? 'Available for foster home' : ''; break;
      case 'AS': $own_state = $alive ? 'Available for sale' : ''; break;
      case 'AA': $own_state = $alive ? 'Available for adoptive home' : ''; break;
      case 'A': $own_state = $alive ? 'Available for *' : ''; break;
      case 'X': $own_state = '*'; break;
      case 'SW': $own_state = 'Shared with *'; break;
    }
    
    if (strlen($own_state) > 0) {
      $own_state = stml_parse(str_replace('*', $row['own_by'], $own_state));
      $o .= "<dd>$own_state</dd>\r\n";
    }
  }
  
  if ($style == 4)
    return htmlentities($o);
  else
    return $o;
}

function print_titles($title_str, $affix_pos, $show_abbr = false) {
  global $_DB;
  
  $o = '';
  
  if (strlen(trim($title_str)) == 0) {
    return '';
  }
  
  $titles = explode(' ', $title_str);
  
  $title_m = '';
  foreach ($titles as $title) {
    if (substr($title, -1, 1) == '.' ||
        substr($title, -1, 1) == ',' ||
        substr($title, -1, 1) == ';') {
      $title_x = strtoupper(substr($title, 0, strlen($title) - 1));
    } else {
      $title_x = strtoupper($title);
    }
    
    if ($title_x == 'AM' ||
        $title_x == 'CAN' ||
        $title_x == 'AM/CAN' ||
        $title_x == 'CAN/AM' ||
        $title_x == '_') {
      $title_m = $title_x;
      $title_modifier_printed = false;
      continue;
    }
    
    switch ($title_m) {
      case '':
      case '_':
        $title_modifier = '';
        $descr_modifier = '';
        break;
      case 'AM/CAN':
      case 'CAN/AM':
        $title_modifier = 'Am./Can. ';
        $descr_modifier = ' (American and Canadian)';
        break;
      case 'CAN':
        $title_modifier = 'Can. ';
        $descr_modifier = ' (Canadian)';
        break;
      case 'AM':
        $title_modifier = 'Am. ';
        $descr_modifier = ' (American)';
        break;
    }
    
    $i = 1;
    $title_number = '1';
    while (ctype_digit(substr($title_x, -$i, 1))) {
      if ($i == 1)
        $title_number = $title_x{strlen($title_x) - $i};
      else
        $title_number = $title_x{strlen($title_x) - $i}
                       .$title_number;
      $title_x{strlen($title_x) - $i} = '#';
      $title_x = str_replace('##', '#', $title_x);
      $i++;
    }
    
    $sql =
    "SELECT *
     FROM `$_DB[dbname]`.`titles`
     WHERE `abbr` = '$title_x'
     AND `type` = '$affix_pos'
     LIMIT 1";
    
    $row = mysql_fetch_array(db_query($sql));
    
    $row['abbr'] = str_replace('#', $title_number, $row['abbr']);
    $row['descr'] = str_replace('#', $title_number, $row['descr']);
    
    $title_x = str_replace('#', $title_number, $title_x);
    
    if ($title_modifier_printed) {
      $title_modifier = '';
    } else {
      $title_modifier_printed = true;
    }
    
    if ($affix_pos == 'POST') {
      $o .= ' ';
    }
    if (strlen($row['abbr']) > 0) {
      if ($show_abbr) {
        $o .= "$title_modifier<abbr title=\"$row[descr]$descr_modifier\">$row[abbr]</abbr>";
      } else {
        $o .= "$title_modifier$row[abbr]";
      }
    } else {
      $o .= "$title_modifier$title_x";
    }
    if ($affix_pos == 'PRE') {
      $o .= ' ';
    }
  }
  
  return $o;
}

function print_pedigree_link_list($where, $order_by, $year_headers = false) {
  global $_DB;
  global $is_signed_in;
  
  $o = '';
  
  $sql =
  "SELECT `id`, `date_birth`
   FROM `$_DB[dbname]`.`pedigrees`
   WHERE $where
   ORDER BY $order_by";
  $result = db_query($sql);
  
  $h_year = array();
  $dl_open = false;
  $count = 0;
  while ($row = mysql_fetch_array($result)) {
    $count++;
    $yr = substr($row['date_birth'], 0, 4);
    if (!$h_year[$yr]) {
      if ($dl_open) {
        $o .= "</dl>";
        $dl_open = false;
      }
      
      if ($year_headers) {
        $o .= "<h3>$yr</h3>\r\n";
      }
      
      $h_year[$yr] = true;
      
      if ($is_signed_in) {
        $o .= '<p><a class="edit" href="pedigrees.php?act=add">Create New</a></p>';
      }
    }
    
    if (!$dl_open) {
      $o .= "<dl>";
      $dl_open = true;
    }
    
    $o .= '<div class="list_element">'.print_pedigree_link($row['id'], 1, true).'</div>';
  }

  if ($dl_open) {
    $o .= "</dl>";
  }
  
  return $o;
}

// prints a pedigree link from the pedigrees database in one of two styles.
// Style 0: compact, for litters page
// Style 1: with dogs' names in anchor text, for pedigrees page
function print_pedigree_link($id, $style = 0, $show_edit = false, $class = '') {
  global $_DB;
  global $is_signed_in;
  
  $o = '';
  
  $sql =
  "SELECT PEDS.`id`, PEDS.`location`, PEDS.`date_birth`,
    DOGS.`name_short` AS `sire_name`,
    DOGS2.`name_short` AS `dam_name`
   FROM `$_DB[dbname]`.`pedigrees` AS PEDS
   INNER JOIN `$_DB[dbname]`.`dogs` AS DOGS
    ON PEDS.`sire_id` = DOGS.`id`
   INNER JOIN `$_DB[dbname]`.`dogs` AS DOGS2
    ON PEDS.`dam_id` = DOGS2.`id`
   WHERE PEDS.`id` = '$id' 
   LIMIT 1";
  $row = mysql_fetch_array(db_query($sql));
  $yr = substr($row['date_birth'], 0, 4);
  if ($style == 1) {
    $o .= "<dt>";
  }
  
  $o .= '<a ';
  if (strlen($class) > 0)
    $o .= 'class="'.$class.'" ';
  $o .= 'href="pedigrees/';
  $o .= $row['location'];
  $o .= '" target="_blank" title="';
  $o .= $row['sire_name'];
  $o .= ' and ';
  $o .= $row['dam_name'];
  $o .= ' Puppies\' Pedigree (';
  $o .= $yr;
  $o .= ')">';
  $o .= '<img src="/pdficon.png" class="pdficon" title="This document requires Adobe Acrobat Reader" Alt="[PDF]" />';
  if ($style == 1) {
    $o .= "$row[sire_name] x $row[dam_name] Litter";
  } else {
    $o .= "Pedigree";
  }
  $o .= '</a>';
  
  if ($show_edit && $is_signed_in) {
    $o .= ' <a class="edit" href="pedigrees.php?act=edit&id=';
    $o .= $row['id'];
    $o .= '">Edit Details</a>';
  }
  if ($style == 1) {
    $o .= '</dt>';
  }
  
  return $o;
}

function print_litter_list($where, $order_by) {
  global $_DB;
  global $is_signed_in;

  $o = '';
  
  $sql =
  "SELECT `id`
   FROM `$_DB[dbname]`.`litters`
   WHERE $where
   ORDER BY $order_by";
  $result = db_query($sql);
  
  $count = 0;
  while ($row = mysql_fetch_array($result)) {
    $count++;
    if ($count == 1) {
      if ($is_signed_in) {
        $o .= '        <p><a class="edit" href="litters.php?act=add">Create New</a></p>'."\r\n";
      }
    }
    
    $o .= '<div class="list_element">'.print_litter($row['id']).'</div>';
  }
  
  return $o;
}

function print_litter($id) {
  global $_DB;
  global $is_signed_in;
  
  $o = '';
  $type_noun = '';
  $born_verb = '';

  $sql =
  "SELECT *
   FROM `$_DB[dbname]`.`litters`
   WHERE `id` = '$id'
   LIMIT 1";
  $row = mysql_fetch_array(db_query($sql));
  $born = intval($row['born']);
  if ($born == 1) { // BORN
    $born_verb = 'born';
    $type_noun = 'Litter ';
  } elseif ($born == 2) { // NONLITTER
    $born_verb = 'Born';
    $type_noun = '';
  } elseif ($born == 3) { // SPECIALNOTE
    if (strlen($row['desc_long']) > 0) {
    
      $o .= '        <p><i>';
      $o .= stml_parse($row['desc_long']);
      $o .= "</i>\r\n";
    }
  
    if ($is_signed_in) {
      $o .= '          <a class="edit" href="litters.php?act=edit&id=';
      $o .= $row['id'];
      $o .= '">Edit</a>';
      $o .= "\r\n";
    }

    $o .= "      </p>\r\n";
    return $o;
  } else { // DUE
    $born_verb = 'due';
    $type_noun = 'Litter ';
  }
  $born_date = date('F j, Y', strtotime($row['date_birth']));
  
  $o .= '      <p class="litter">'."\r\n";
  $o .= '        <span class="litter_head"><b>';
  $o .= "$type_noun$born_verb $born_date:</b>\r\n";
  if (strlen($row['pedigree_id']) > 0) {
    $o .= print_pedigree_link($row['pedigree_id']);
  }
  
  if ($is_signed_in) {
    $o .= '          <a class="edit" href="litters.php?act=edit&id=';
    $o .= $row['id'];
    $o .= '">Edit</a>';
  }
  
  $o .= "        </span>\r\n";
  
  if (strlen($row['own_by']) > 0) {
    $o .= '        <span class="litter_note"><b>Owned by:</b> ';
    $o .= stml_parse($row['own_by']);
    $o .= "</span>\r\n";
  }
      
  if ($born == 1) {
    $litter_text = number_to_words($row['count_males'], 1).' male'.plural($row['count_males']).' and '.
                   number_to_words($row['count_females']).' female'.plural($row['count_females']);
    if (strlen($row['desc_short']) > 0) {
      $litter_text .='; '.stml_parse($row['desc_short']);
    }
    
    $o .= '        <span class="litter_pups"><b>Litter:</b> ';
    $o .= $litter_text;
    $o .= "</span>\r\n";
  }
  
  $o .= '        <span class="litter_sire"><b>Sire:</b> ';
  $o .= print_dog($row['sire_id'], 0, true);
  $o .= "</span>\r\n";
  
  $o .= '        <span class="litter_dam"><b>Dam:</b> ';
  $o .= print_dog($row['dam_id'], 0, true);
  $o .= "</span>\r\n";
  
  if (strlen($row['desc_long']) > 0) {
  
    $o .= '        <span class="litter_note"><b>Note:</b> ';
    $o .= stml_parse($row['desc_long']);
    $o .= "</span>\r\n";
  }
  
  $o .= "      </p>\r\n";
  
  return $o;
}

?>
