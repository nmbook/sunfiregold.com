<?php

$src = isset($_GET['src']) ? $_GET['src'] : '';
$conv = isset($_GET['conv']) ? $_GET['conv'] : 'thumb';

// Content type
//header('Content-type: image/jpeg');

if (file_exists($src)) {
  $info = pathinfo($src);
  
  header('Content-type: image/jpeg');
  
  list($width, $height) = getimagesize($src);
  switch ($conv) {
    case 'thumb':
      $newwidth = 100;
      $newheight = $height / ($width / $newwidth);
      break;
    case 'view':
      $newwidth = 320;
      $newheight = $height / ($width / $newwidth);
      break;
    case 'view1024':
      $newwidth = 1024;
      $newheight = $height / ($width / $newwidth);
      break;
    case 'full':
      $newwidth = $width;
      $newheight = $height;
      break;
  }
  
  $thumb = imagecreatetruecolor($newwidth, $newheight);
  switch (strtolower($info['extension'])) {
    case 'bmp':
      $source = imagecreatefrombmp($src);
      break;
    case 'png':
      $source = imagecreatefrompng($src);
      break;
    case 'gif':
      $source = imagecreatefromgif($src);
      break;
    case 'jpg':
      $source = imagecreatefromjpeg($src);
      break;
  }
  
  // Resize
  imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
  
  // Output
  imagejpeg($thumb);
} else {
  exit("File not found: $src\r\n");
}

?>