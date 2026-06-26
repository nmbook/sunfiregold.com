<?php

$src = $_GET['src'] ?? '';
$conv = $_GET['conv'] ?? 'thumb';

ini_set('memory_limit', '500M');

// Content type
//header('Content-type: image/jpeg');

try {
  if (strlen($src) === 0) {
    header('Location: /');
  }
  
  $info = pathinfo($src);

  if (!file_exists($src)) {
    throw new Exception("Not allowed"); //throw new Exception("File not found {$info['basename']}");
  }

  if (strlen($info['basename']) > 0 && ($info['basename'][0] == '.' || $info['basename'] == 'php.ini')) {
    throw new Exception("Not allowed");
  }

  $known_format = match (strtolower($info['extension'])) {
    'bmp', 'png', 'gif', 'jpg', 'jpeg', 'webp', 'tga' => true,
    default => false
  };

  if ($known_format === false) {
    // Error on interpreting format
    throw new Exception("Not allowed"); //throw new Exception("Format not known image type {$info['extension']}");
  }

  $width_height = getimagesize($src);
  if ($width_height === null) {
    // Error on reading width/height
    throw new Exception("Not allowed"); //throw new Exception("Unable to get width/height from {$info['basename']}");
  }
  list($width, $height) = $width_height;
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
    default:
      throw new Exception("Invalid conv mode $conv");
  }
  
  $source = match (strtolower($info['extension'])) {
    'bmp' => imagecreatefrombmp($src),
    'png' => imagecreatefrompng($src),
    'gif' => imagecreatefromgif($src),
    'jpg', 'jpeg' => imagecreatefromjpeg($src),
    'webp' => imagecreatefromwebp($src),
    'tga' => imagecreatefromtga($src),
    default => null
  };

  if ($source === null) {
    // Error on interpreting format
    throw new Exception("Format not known image type {$info['extension']}");
  }

  if ($source === false) {
    // Error on reading file
    throw new Exception("Unable to read {$info['basename']}");
  }

  $canvas = imagecreatetruecolor($newwidth, $newheight);
  
  // Resize
  imagecopyresized($canvas, $source, 0, 0, $left, $top, $newwidth, $newheight, $width, $height);
  
  // Output
  header('Content-type: image/jpeg');
  imagejpeg($canvas);
} catch (Exception $conv_failure) {
  echo htmlspecialchars($conv_failure->getMessage());
}
