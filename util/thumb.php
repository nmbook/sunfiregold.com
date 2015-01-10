<?php

$src = isset($_GET['src']) ? $_GET['src'] : '';
$conv = isset($_GET['conv']) ? $_GET['conv'] : 'thumb';

// Content type
//header('Content-type: image/jpeg');

if (file_exists($src)) {
  $info = pathinfo($src);
  
  header('Content-type: image/jpeg');
  
  list($width, $height) = getimagesize($src);
  $top = $left = 0;
  switch ($conv) {
    case 'thumb':
      $newwidth = 100;
      if ($newwidth > $width) $newwidth = $width;
      $newheight = $height / ($width / $newwidth);
      break;
    case 'thumbsq':
      $newwidth = $newheight = 100;
      if ($width > $height) {
        $diff = $width - $height;
        $left = round($diff / 2);
        $width -= $diff;
      } elseif ($height > $width) {
        $diff = $height - $width;
        $top = round($diff / 2);
        $height -= $diff;
      }
      break;
    case 'thumbsq320':
      $newwidth = $newheight = 320;
      if ($width > $height) {
        $diff = $width - $height;
        $left = round($diff / 2);
        $width -= $diff;
      } elseif ($height > $width) {
        $diff = $height - $width;
        $top = round($diff / 2);
        $height -= $diff;
      }
      break;
    case 'thumbsq640':
      $newwidth = $newheight = 640;
      if ($width > $height) {
        $diff = $width - $height;
        $left = round($diff / 2);
        $width -= $diff;
      } elseif ($height > $width) {
        $diff = $height - $width;
        $top = round($diff / 2);
        $height -= $diff;
      }
      break;
    case 'view':
      $newwidth = 320;
      if ($newwidth > $width) $newwidth = $width;
      $newheight = $height / ($width / $newwidth);
      break;
    case 'view1024':
      $newwidth = 1024;
      if ($newwidth > $width) $newwidth = $width;
      $newheight = $height / ($width / $newwidth);
      break;
    case 'full':
      $newwidth = $width;
      $newheight = $height;
      break;
  }
  
  $canvas = imagecreatetruecolor($newwidth, $newheight);
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
  imagecopyresized($canvas, $source, 0, 0, $left, $top, $newwidth, $newheight, $width, $height);
  
  // Output
  imagejpeg($canvas);
} else {
  if (strlen($src) == 0)
    header('Location: /');
  else
    header("Location: $src");
}

?>
