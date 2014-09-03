<?php


function page_curl($url, $post=false, $postdata='') {
  global $s;
  
  // create a new cURL resource
  $ch = curl_init();

  // set URL and other appropriate options
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_REFERER, 'http://whitehouse.gov');
  curl_setopt($ch, CURLOPT_USERAGENT, 'NCSA_Mosaic/2.0 (Windows 3.1)');
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
  
  return $str;
}

$url = 'http://www.hacker.org/challenge/misc/past.php';
echo page_curl($url);

//echo 'pewter scooter';
?>