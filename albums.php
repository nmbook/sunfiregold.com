<?php

$templ_page_valid = TRUE;

include_once('util/incl.php');

db_connect();

check_session();

$findbydir = isset($_GET['findbydir']) ? $_GET['findbydir'] : '';
if (strlen($findbydir) > 0) {
  $sql =
  "SELECT `id`
   FROM `$_DB[dbname]`.`albums`
   WHERE `location` = '".db_sanitize($findbydir)."'
   LIMIT 1";
  $result = mysql_fetch_row(db_query($sql));
  if ($result[0] > 0) {
    header("Location: /albums.php?id=$result[0]");
  } else {
    header("Location: /albums.php");
  }
  exit;
}

$id = isset($_GET['id']) ? $_GET['id'] : $set_id;
if (isset($id) && $id != 0 && $id != '') {
  $sql =
  "SELECT *
   FROM `$_DB[dbname]`.`albums`
   WHERE `id` = '".db_sanitize($id)."'
   LIMIT 1";
  $result = db_query($sql);
  $row = mysql_fetch_array($result);
  if ($row['id'] != $id) {
    show_message("Album ID '$id' was not found.", 'error');
    $id_error = true;
  }
} else {
  $id = 0; // index
}

$act = 0;
if ($is_signed_in) {
  $act = isset($_GET['act']) ? $_GET['act'] : '';
  $act_n = $act;
  switch ($act) {
    case 'add':
      $verb = 'Create New Album';
      $cmd = 'Create';
      $act = 1;
      break;
    case 'edit':
      $verb = 'Edit Album Details';
      $cmd = 'Save';
      $act = 2;
      break;
    case 'remove':
      $verb = 'Remove Album';
      $cmd = 'Confirm';
      $act = 3;
      break;
    case 'up':
      $verb = 'Move Up';
      $cmd = 'Confirm';
      $act = 4;
      break;
    case 'down':
      $verb = 'Move Down';
      $cmd = 'Confirm';
      $act = 5;
      break;
    case 'imgs':
      $verb = 'Edit Album Images';
      $cmd = 'Save';
      $act = 10;
      break;
    case 'iadd':
      $verb = 'Upload New Image';
      $cmd = 'Upload';
      $act = 11;
      $image_id = isset($_GET['img']) ? $_GET['img'] : 0;
      break;
    case 'iedit':
      $verb = 'Edit Image Details';
      $cmd = 'Save';
      $act = 12;
      $image_id = isset($_GET['img']) ? $_GET['img'] : 0;
      break;
    case 'iremove':
      $verb = 'Remove Image';
      $cmd = 'Confirm';
      $act = 13;
      $image_id = isset($_GET['img']) ? $_GET['img'] : 0;
      break;
    case 'iup':
      $verb = 'Move Up';
      $cmd = 'Confirm';
      $act = 14;
      $image_id = isset($_GET['img']) ? $_GET['img'] : 0;
      break;
    case 'idown':
      $verb = 'Move Down';
      $cmd = 'Confirm';
      $act = 15;
      $image_id = isset($_GET['img']) ? $_GET['img'] : 0;
      break;
    default: // view
      $act = 0;
      break;
  }
  
  if (isset($id_error)) {
    $act = 0;
    $id = 0;
  }
  
  if (isset($image_id)) {
    $image_sql =
    "SELECT *
     FROM `$_DB[dbname]`.`album_images`
     WHERE `id` = '".db_sanitize($image_id)."'
      AND `album_id` = '".db_sanitize($id)."'
     LIMIT 1";
    $image_result = db_query($image_sql);
    $image_row = mysql_fetch_array($image_result);
    if ($image_row['id'] != $image_id) {
      show_message("Image ID '$id' was not found in album.", 'error');
      $act = 10;
    }
  }
  
  $submit = isset($_GET['submit']) ? $_GET['submit'] : 0;
  if ($submit || $act == 4 || $act == 5 || $act == 14 || $act == 15) {
    switch ($act) {
      case 1: // add
      case 2: // edit
        $title = isset($_POST['title']) ? $_POST['title'] : '';
        $location = isset($_POST['location']) ? $_POST['location'] : '';
        $datetext = isset($_POST['datetext']) ? $_POST['datetext'] : '';
        $active = isset($_POST['active']) ? $_POST['active'] : '';
        
        $dir_location = "./albums/$location/";
        $index_location = $dir_location.'index.php';
        
        if ($act == 1) {
          if (!file_exists($dir_location)) {
            if (!mkdir($dir_location)) {
              show_message("Could not create the $location directory for the new album.", 'error');
              break;
            }
          }
          
          if (file_exists($dir_location)) {
            if (!file_exists($index_location)) {
              if ($f = @fopen($index_location, 'x')) {
                fwrite($f, "<?php\n\nheader('Location: /albums.php?findbydir=".addslashes($location)."');\n\n?>");
                fclose($f);
              }
            }
          }
        }
        
        $sql =
        "SELECT COUNT(*)
         FROM `$_DB[dbname]`.`albums`
         WHERE `index` > 0
          AND `id` = '$id'";
        $result = mysql_fetch_row(db_query($sql));
        $prev_active = $result[0];
        
        $sql =
        "SELECT `index`
         FROM `$_DB[dbname]`.`albums`
         WHERE `id` = '$id'";
        $result = mysql_fetch_row(db_query($sql));
        $old_index = $result[0];
        
        if ($active) {
          if (!$prev_active) {
            $sql =
            "SELECT COUNT(*)
             FROM `$_DB[dbname]`.`albums`
             WHERE `index` > 0";
            $result = mysql_fetch_row(db_query($sql));
            $album_count = $result[0];
            $new_index = $album_count + 1;
          } else {
            $new_index = $old_index;
          }
        } else {
          $new_index = 0;
          if ($prev_active) {
            $sql =
            "UPDATE `$_DB[dbname]`.`albums`
             SET `index` = `index` - 1
             WHERE `index` > '$old_index'";
            db_query($sql);
          }
        }
        
        if ($act == 1) {
          $sql =
          "INSERT INTO `$_DB[dbname]`.`albums` (
           `title`, `location`, `datetext`, `index`
           ) VALUES (
           '".db_sanitize($title)."',
           '".db_sanitize($location)."',
           '".db_sanitize($datetext)."',
           '".db_sanitize($new_index)."'
           )";
        } else {
          $sql =
          "UPDATE `$_DB[dbname]`.`albums`
           SET `title` = '".db_sanitize($title)."',
               `datetext` = '".db_sanitize($datetext)."',
               `index` = '".db_sanitize($new_index)."'
           WHERE `id` = '$id'";
        }
        db_query($sql);
        if ($act == 1) {
          $sql =
          "SELECT `id` FROM `$_DB[dbname]`.`albums`
           ORDER BY `id` DESC
           LIMIT 1";
          $row_ = mysql_fetch_row(db_query($sql));
          $id = $row_[0];
        }
        
        $sql =
        "INSERT INTO `$_DB[dbname]`.`actions` (
         `user_id`, `page_id`, `date`, `edit_type`, `data_desc`
         ) VALUES (
         '$_SESSION[user_id]', '".get_page_id()."',
         '".db_date(time())."', '".($act == 1 ? 'ADD' : 'EDIT')."',
         '".($act == 1 ? 'Added' : 'Updated').' '.db_sanitize($title)." album (ID=$id).'
         )";
        db_query($sql);
        
        show_message(($act == 1 ? 'Added ' : 'Updated')." '$title' album (ID=$id).", 'notice');
        
        $act = $id = 0;
        header("Location: albums.php");
        exit;
      case 3: // remove
        $sql =
        "SELECT `index`, `location`
         FROM `$_DB[dbname]`.`albums`
         WHERE `id` = '$id'";
        $result = mysql_fetch_row(db_query($sql));
        $index = $result[0];
        $location = $result[1];
        $dir_location = "./albums/$location/";
        $index_location = $dir_location.'index.php';
        
        if (is_dir($dir_location)) {
          $fcount = 0;
          if ($d = @opendir($dir_location)) {
            while (false !== ($fname = readdir($d))) {
              if ($fname != 'index.php' && is_file($dir_location.$fname)) {
                $fcount++;
              }
            }
            closedir($d);
          }
          
          if ($fcount == 0) {
            @unlink($index_location);
            @rmdir($dir_location);
          }
        }
        
        $sql =
        "DELETE FROM `$_DB[dbname]`.`albums`
         WHERE `id` = '$id'";
        db_query($sql);
        
        $sql =
        "UPDATE `$_DB[dbname]`.`albums`
         SET `index` = `index` - 1
         WHERE `index` > '$index'";
        db_query($sql);
        
        $sql =
        "INSERT INTO `$_DB[dbname]`.`actions` (
         `user_id`, `page_id`, `date`, `edit_type`, `data_desc`
         ) VALUES (
         '$_SESSION[user_id]', '".get_page_id()."',
         '".db_date(time())."', 'REMOVE',
         'Removed ".db_sanitize($row['title'])." album (ID=$row[id]).'
         )";
        db_query($sql);
        
        show_message("Removed '$row[title]' album (ID=$row[id]) from the database.", 'notice');
        
        $act = $id = 0;
        header("Location: albums.php");
        exit;
      case 4: // up (index -> inf)
        $old_index = $row['index'];
        $new_index = $old_index + 1;
        
        $sql =
        "SELECT COUNT(*)
         FROM `$_DB[dbname]`.`albums`
         WHERE `index` > 0";
        $result = mysql_fetch_row(db_query($sql));
        $album_count = $result[0];
        
        if ($new_index > $album_count) {
          show_message("Album '$row[title]' is already at the top.", 'error');
          $act = $id = 0;
          break;
        }
        $sql =
        "SELECT `id`
         FROM `$_DB[dbname]`.`albums`
         WHERE `index` = '$new_index'";
        $result = mysql_fetch_row(db_query($sql));
        $swap_id = $result[0];
        $sql =
        "UPDATE `$_DB[dbname]`.`albums`
         SET `index` = '".db_sanitize($new_index)."'
         WHERE `id` = '$id'";
        db_query($sql);
        $sql =
        "UPDATE `$_DB[dbname]`.`albums`
         SET `index` = '".db_sanitize($old_index)."'
         WHERE `id` = '$swap_id'";
        db_query($sql);
        
        $sql =
        "INSERT INTO `$_DB[dbname]`.`actions` (
         `user_id`, `page_id`, `date`, `edit_type`, `data_desc`
         ) VALUES (
         '$_SESSION[user_id]', '".get_page_id()."',
         '".db_date(time())."', 'PROMOTE',
         'Promoted ".db_sanitize($row['title'])." album (ID=$row[id]).'
         )";
        db_query($sql);
        
        show_message("Promoted '$row[title]' album (ID=$row[id]) up one position.", 'notice');
        
        $act = $id = 0;
        header("Location: albums.php");
        exit;
      case 5: // down (index -> 0)
        $old_index = $row['index'];
        $new_index = $old_index - 1;
        
        if ($new_index <= 0) {
          show_message("Album '$row[title]' is already at the bottom.", 'error');
          $act = $id = 0;
          break;
        }
        $sql =
        "SELECT `id`
         FROM `$_DB[dbname]`.`albums`
         WHERE `index` = '$new_index'";
        $result = mysql_fetch_row(db_query($sql));
        $swap_id = $result[0];
        $sql =
        "UPDATE `$_DB[dbname]`.`albums`
         SET `index` = '".db_sanitize($new_index)."'
         WHERE `id` = '$id'";
        db_query($sql);
        $sql =
        "UPDATE `$_DB[dbname]`.`albums`
         SET `index` = '".db_sanitize($old_index)."'
         WHERE `id` = '$swap_id'";
        db_query($sql);
        
        $sql =
        "INSERT INTO `$_DB[dbname]`.`actions` (
         `user_id`, `page_id`, `date`, `edit_type`, `data_desc`
         ) VALUES (
         '$_SESSION[user_id]', '".get_page_id()."',
         '".db_date(time())."', 'DEMOTE',
         'Demoted ".db_sanitize($row['title'])." album (ID=$row[id]).'
         )";
        db_query($sql);
        
        show_message("Demoted '$row[title]' album (ID=$row[id]) down one position.", 'notice');
        
        $act = $id = 0;
        header("Location: albums.php");
        exit;
      case 11: // image add 
        $img_count = isset($_POST['img_count']) ? $_POST['img_count'] : '';
        $img_count_v = true;//(bool) preg_match('/\d+/', $img_count);
        
        $sql =
        "SELECT COUNT(*)
         FROM `$_DB[dbname]`.`album_images`
         WHERE `album_id` = '$id'
          AND `index` > 0";
        $result = mysql_fetch_row(db_query($sql));
        $next_index = $result[0];
        $next_index++;
        
        $uploaded = 0;
        
        if ($img_count_v) {
          for ($img = 1; $img <= $img_count; $img++) {
            switch ($_FILES["image_$img"]['error']) {
              case UPLOAD_ERR_OK:
                $descs = isset($_POST["desc_short_$img"]) ? $_POST["desc_short_$img"] : '';
                $descl = isset($_POST["desc_long_$img"]) ? $_POST["desc_long_$img"] : '';
                $desct = isset($_POST["desc_time_$img"]) ? $_POST["desc_time_$img"] : '';
                $active = isset($_POST["active_$img"]) ? $_POST["active_$img"] : 0;
                
                $dir = $row['location'];
                $fname = basename($_FILES["image_$img"]['name']);
                $fext = substr($fname, strrpos($fname, '.'));
                $target = "albums/$dir/$fname";
                
                $index = $active ? $next_index : 0;
                
                if (file_exists($target)) {
                  show_message("$fname is already present in $dir.", 'error');
                  break;
                }
                
                // 512 MEGABYTES
                if ($_FILES["image_$img"]['size'] > 536870912) {
                  show_message("$fname is too large.", 'error');
                  break;
                }
                
                if (move_uploaded_file($_FILES["image_$img"]['tmp_name'], $target)) {
                  $exif_img_type = exif_imagetype($target);
                  if ($exif_img_type == 0) {
                    @unlink($target);
                    show_message("$fname is not an image.", 'error');
                    break;
                  }
                  
                  $sql =
                  "INSERT INTO `$_DB[dbname]`.`album_images` (
                   `index`, `album_id`,
                   `desc_short`, `desc_long`,
                   `desc_time`, `location`
                   ) VALUES (
                   '$index', '$id',
                   '".db_sanitize($descs)."', '".db_sanitize($descl)."',
                   '".db_sanitize($desct)."', '".db_sanitize($fname)."'
                   )";
                  db_query($sql);
                  
                  $sql =
                  "SELECT `id` FROM `$_DB[dbname]`.`album_images`
                   ORDER BY `id` DESC
                   LIMIT 1";
                  $row_ = mysql_fetch_row(db_query($sql));
                  $new_img_id = $row_[0];
                  
                  $sql =
                  "INSERT INTO `$_DB[dbname]`.`actions` (
                   `user_id`, `page_id`, `date`, `edit_type`, `data_desc`
                   ) VALUES (
                   '$_SESSION[user_id]', '".get_page_id()."',
                   '".db_date(time())."', 'ADD',
                   'Uploaded ".db_sanitize($fname)." image (ID=$new_img_id) into ".db_sanitize($row['title'])." album (ID=$row[id]).'
                   )";
                  db_query($sql);
                  
                  $uploaded++;
                  
                  if ($active) {
                    $next_index++;
                  }
                  show_message("Image upload succeeded: '$fname' (ID=$new_img_id).", 'notice');
                } else {
                  show_message("Unknown upload failure (could not move temporary file): $fname", 'error');
                }
                break;
              case UPLOAD_ERR_INI_SIZE:
              case UPLOAD_ERR_FORM_SIZE:
                show_message('Upload failed: File too large.', 'error');
                break;
              case UPLOAD_ERR_PARTIAL:
                show_message('The upload failed to complete.', 'error');
                break;
              case UPLOAD_ERR_NO_FILE:
                show_message('No file uploaded.', 'error');
                break;
              case UPLOAD_ERR_NO_TMP_DIR:
                show_message('Internal upload failure (no temporary directory).', 'error');
                break;
              case UPLOAD_ERR_CANT_WRITE:
                show_message('Internal upload failure (could not write temporary file).', 'error');
                break;
              case UPLOAD_ERR_EXTENSION:
                show_message('Internal upload failure (extension stopped upload).', 'error');
                break;
              default:
                show_message('Unknown upload failure.', 'error');
                break;
            }
          }
          
          if ($uploaded > 0) {
            show_message("Uploaded $uploaded images to the '$row[title]' album (ID=$row[id]).", 'notice');
          } else {
            show_message('No images were uploaded.', 'error');
          }
        } else {
          show_message('Could not count images.', 'error');
        }
        $act = 10;
        header("Location: albums.php?act=imgs&id=$id");
        exit;
      case 12: // image edit
        $descs = isset($_POST["desc_short"]) ? $_POST["desc_short"] : '';
        $descl = isset($_POST["desc_long"]) ? $_POST["desc_long"] : '';
        $desct = isset($_POST["desc_time"]) ? $_POST["desc_time"] : '';
        $active = isset($_POST["active"]) ? $_POST["active"] : 0;
        
        $sql =
        "SELECT COUNT(*)
         FROM `$_DB[dbname]`.`album_images`
         WHERE `index` > 0
          AND `id` = '$image_id'";
        $result = mysql_fetch_row(db_query($sql));
        $prev_active = $result[0];
        
        $sql =
        "SELECT `index`
         FROM `$_DB[dbname]`.`album_images`
         WHERE `id` = '$image_id'";
        $result = mysql_fetch_row(db_query($sql));
        $old_index = $result[0];
        
        if ($active) {
          if (!$prev_active) {
            $sql =
            "SELECT COUNT(*)
             FROM `$_DB[dbname]`.`album_images`
             WHERE `album_id` = '$id'
              AND `index` > 0";
            $result = mysql_fetch_row(db_query($sql));
            $image_count = $result[0];
            $new_index = $image_count + 1;
          } else {
            $new_index = $old_index;
          }
        } else {
          $new_index = 0;
          if ($prev_active) {
            $sql =
            "UPDATE `$_DB[dbname]`.`album_images`
             SET `index` = `index` - 1
             WHERE `album_id` = '$id'
              AND `index` > '$old_index'";
            db_query($sql);
          }
        }
        
        $sql =
        "UPDATE `$_DB[dbname]`.`album_images`
         SET `desc_short` = '".db_sanitize($descs)."',
             `desc_long` = '".db_sanitize($descl)."',
             `desc_time` = '".db_sanitize($desct)."',
             `index` = '".db_sanitize($new_index)."'
         WHERE `id` = '$image_id'";
        db_query($sql);
        
        $sql =
        "INSERT INTO `$_DB[dbname]`.`actions` (
         `user_id`, `page_id`, `date`, `edit_type`, `data_desc`
         ) VALUES (
         '$_SESSION[user_id]', '".get_page_id()."',
         '".db_date(time())."', 'EDIT',
         'Updated ".db_sanitize($image_row['desc_short'])." image (ID=$image_row[id]) in the ".db_sanitize($row['title'])." album (ID=$row[id]).'
         )";
        db_query($sql);
        
        show_message("Updated '$image_row[desc_short]' image (ID=$image_row[id]) in the '$row[title]' album (ID=$row[id]).", 'notice');
        
        $act = 10;
        header("Location: albums.php?act=imgs&id=$id");
        exit;
      case 13: // image remove
        $sql =
        "SELECT `index`, `location`
         FROM `$_DB[dbname]`.`album_images`
         WHERE `id` = '$image_id'";
        $result = mysql_fetch_row(db_query($sql));
        $index = $result[0];
        $location = "albums/$row[location]/$result[1]";
        @unlink($location);
        
        $sql =
        "DELETE FROM `$_DB[dbname]`.`album_images`
         WHERE `id` = '$image_id'";
        db_query($sql);
        
        $sql =
        "UPDATE `$_DB[dbname]`.`album_images`
         SET `index` = `index` - 1
         WHERE `album_id` = '$id'
          AND `index` > '$index'";
        db_query($sql);
        
        $sql =
        "INSERT INTO `$_DB[dbname]`.`actions` (
         `user_id`, `page_id`, `date`, `edit_type`, `data_desc`
         ) VALUES (
         '$_SESSION[user_id]', '".get_page_id()."',
         '".db_date(time())."', 'REMOVE',
         'Removed ".db_sanitize($image_row['desc_short'])." image (ID=$image_row[id]) from ".db_sanitize($row['title'])." album (ID=$row[id]).'
         )";
        db_query($sql);
        
        show_message("Removed '$image_row[desc_short]' image (ID=$image_row[id]) from the '$row[title]' album (ID=$row[id]).", 'notice');
        
        $act = 10;
        header("Location: albums.php?act=imgs&id=$id");
        exit;
      case 14: // image up (index -> 0)
        $old_index = $image_row['index'];
        $new_index = $old_index - 1;
        
        if ($new_index <= 0) {
          show_message("Image '$image_row[desc_short]' is already at the top.", 'error');
          $act = 10;
          break;
        }
        $sql =
        "SELECT `id`
         FROM `$_DB[dbname]`.`album_images`
         WHERE `album_id` = '$id'
          AND `index` = '$new_index'";
        $result = mysql_fetch_row(db_query($sql));
        $swap_id = $result[0];
        
        $sql =
        "UPDATE `$_DB[dbname]`.`album_images`
         SET `index` = '".db_sanitize($new_index)."'
         WHERE `id` = '$image_id'";
        db_query($sql);
        
        $sql =
        "UPDATE `$_DB[dbname]`.`album_images`
         SET `index` = '".db_sanitize($old_index)."'
         WHERE `id` = '$swap_id'";
        db_query($sql);
        
        $sql =
        "INSERT INTO `$_DB[dbname]`.`actions` (
         `user_id`, `page_id`, `date`, `edit_type`, `data_desc`
         ) VALUES (
         '$_SESSION[user_id]', '".get_page_id()."',
         '".db_date(time())."', 'PROMOTE',
         'Promoted ".db_sanitize($image_row['desc_short'])." image (ID=$image_row[id]).'
         )";
        db_query($sql);
        
        show_message("Promoted '$image_row[desc_short]' image (ID=$image_row[id]) up one position.", 'notice');
        
        $act = 10;
        header("Location: albums.php?act=imgs&id=$id");
        exit;
      case 15: // image down (index -> inf)
        $old_index = $image_row['index'];
        $new_index = $old_index + 1;
        
        $sql =
        "SELECT COUNT(*)
         FROM `$_DB[dbname]`.`album_images`
         WHERE `album_id` = '$id'
          AND `index` > 0";
        $result = mysql_fetch_row(db_query($sql));
        $image_count = $result[0];
        
        if ($new_index > $image_count) {
          show_message("Image '$image_row[desc_short]' is already at the bottom.", 'error');
          $act = 10;
          break;
        }
        $sql =
        "SELECT `id`
         FROM `$_DB[dbname]`.`album_images`
         WHERE `album_id` = '$id'
          AND `index` = '$new_index'";
        $result = mysql_fetch_row(db_query($sql));
        $swap_id = $result[0];
        $sql =
        "UPDATE `$_DB[dbname]`.`album_images`
         SET `index` = '".db_sanitize($new_index)."'
         WHERE `id` = '$image_id'";
        db_query($sql);
        $sql =
        "UPDATE `$_DB[dbname]`.`album_images`
         SET `index` = '".db_sanitize($old_index)."'
         WHERE `id` = '$swap_id'";
        db_query($sql);
        
        $sql =
        "INSERT INTO `$_DB[dbname]`.`actions` (
         `user_id`, `page_id`, `date`, `edit_type`, `data_desc`
         ) VALUES (
         '$_SESSION[user_id]', '".get_page_id()."',
         '".db_date(time())."', 'DEMOTE',
         'Demoted ".db_sanitize($image_row['desc_short'])." image (ID=$image_row[id]).'
         )";
        db_query($sql);
        
        show_message("Demoted '$image_row[desc_short]' image (ID=$image_row[id]) down one position.", 'notice');
        
        $act = 10;
        header("Location: albums.php?act=imgs&id=$id");
        exit;
    }
  }
}

// start and <head> tags
get_page_sect_head();

// top of page
get_page_sect_top();

switch ($act) {
  default:
  case 0: // normal, view, completed action, error
    if ($id == 0) {
      // show index
?>
      <h3>Album Index</h3>
      
      <p>Begin by clicking an album below:</p>
<?php
      if ($is_signed_in) {
?>
      <p><a class="edit" href="albums.php?act=add">Create New</a></p>
<?php
      }
?>
      <dl>
<?php
      $sql =
      "SELECT COUNT(*)
       FROM `$_DB[dbname]`.`albums`
       WHERE `index` > 0";
      $result = mysql_fetch_row(db_query($sql));
      $album_count = $result[0];
      
      $sql =
      "SELECT *
       FROM `$_DB[dbname]`.`albums`
       WHERE `index` > 0
       ORDER BY `index` DESC";
      $result = db_query($sql);
      while ($row = mysql_fetch_array($result)) {
        $sql_icount =
        "SELECT COUNT(*)
         FROM `$_DB[dbname]`.`album_images`
         WHERE `album_id` = '$row[id]'
          AND `index` > 0";
        $result_icount = mysql_fetch_row(db_query($sql_icount));
        $icount = $result_icount[0];
?>
        <dt><a href="albums.php?id=<?php echo $row['id']; ?>" title="<?php echo $row['title']; ?>"><?php echo $row['title']; ?></a></dt>
<?php
        if (strlen($row['datetext']) > 0) {
?>
        <dd>Taken <?php echo $row['datetext']; ?> (<?php echo $icount; ?> picture<?php echo plural($icount); ?>)</dd>
<?php
        } else {
?>
        <dd>(<?php echo $icount; ?> picture<?php echo plural($icount); ?>)</dd>
<?php
        }
        
        if ($is_signed_in) {
          if ($row['index'] < $album_count) {
?>
        <a class="edit" href="albums.php?act=up&id=<?php echo $row['id']; ?>">Move Up</a>
<?php
          }
          if ($row['index'] > 1) {
?>
        <a class="edit" href="albums.php?act=down&id=<?php echo $row['id']; ?>">Move Down</a>
<?php
          }
?>
        <?php if ($album_count > 1) echo '|'; ?> <a class="edit" href="albums.php?act=edit&id=<?php echo $row['id']; ?>">Edit Details</a>
        <a class="edit" href="albums.php?act=imgs&id=<?php echo $row['id']; ?>">Edit Images</a>
<?php
        }
      }
?>
      </dl>
<?php
      if ($is_signed_in) {
        $h_hidden = false;
        $sql =
        "SELECT *
         FROM `$_DB[dbname]`.`albums`
         WHERE `index` = 0
         ORDER BY `id` ASC";
        $result = db_query($sql);
        while ($row = mysql_fetch_array($result)) {
          if (!$h_hidden) {
            $h_hidden = true;
?>
      <h3>Hidden Albums</h3>
<?php
      if ($is_signed_in) {
?>
      <p><a class="edit" href="albums.php?act=add">Create New</a></p>
<?php
      }
?>
      <dl>
<?php
          }
          
          $sql_icount =
          "SELECT COUNT(*)
           FROM `$_DB[dbname]`.`album_images`
           WHERE `album_id` = '$row[id]'
            AND `index` > 0";
          $result_icount = mysql_fetch_row(db_query($sql_icount));
          $icount = $result_icount[0];
?>
        <dt><a href="albums.php?id=<?php echo $row['id']; ?>" title="<?php echo $row['title']; ?>"><?php echo $row['title']; ?></a></dt>
<?php
          if (strlen($row['datetext']) > 0) {
?>
        <dd>Taken <?php echo stml_parse($row['datetext']); ?> (<?php echo $icount; ?> picture<?php echo plural($icount); ?>)</dd>
<?php
          }
?>
        <a class="edit" href="albums.php?act=edit&id=<?php echo $row['id']; ?>">Edit Details</a>
        <a class="edit" href="albums.php?act=imgs&id=<?php echo $row['id']; ?>">Edit Images</a>
<?php
        }
        
        if ($h_hidden) {
?>
      </dl>
<?php
        }
      }
    } else {
      // view album & images
?>
      <div class="album_nav">
        <h6>Navigate through albums:</h6>
<?php
      $sql_index = // get current album index
      "SELECT `index`
       FROM `$_DB[dbname]`.`albums`
       WHERE `id` = '$id'";
      $result_index = mysql_fetch_row(db_query($sql_index));
      $album_index = $result_index[0];
      $sql_count = // get album count
      "SELECT COUNT(*)
       FROM `$_DB[dbname]`.`albums`
       WHERE `index` > 0";
      $result_count = mysql_fetch_row(db_query($sql_count));
      $album_count = $result_count[0];
      $last_index = $album_count;
      $sql_prev = // get previous album index
      "SELECT MAX(`index`) AS `prev`
       FROM `$_DB[dbname]`.`albums`
       WHERE `index` > 0
        AND `index` < '$album_index'";
      $result_prev = mysql_fetch_row(db_query($sql_prev));
      $prev_index = $result_prev[0];
      if ($prev_index == '') $prev_index = 1;
      $sql_next = // get next album index
      "SELECT MIN(`index`) AS `next`
       FROM `$_DB[dbname]`.`albums`
       WHERE `index` > 0
        AND `index` > '$album_index'";
      $result_next = mysql_fetch_row(db_query($sql_next));
      $next_index = $result_next[0];
      if ($next_index == '') $next_index = $album_count;
      
      $sql_first = // get first album info
      "SELECT `index`, `id`, `title`
       FROM `$_DB[dbname]`.`albums`
       WHERE `index` = '1'
       LIMIT 1";
      $row_first = mysql_fetch_array(db_query($sql_first));
      $sql_prev = // get prev album info
      "SELECT `index`, `id`, `title`
       FROM `$_DB[dbname]`.`albums`
       WHERE `index` = '$prev_index'
       LIMIT 1";
      $row_prev = mysql_fetch_array(db_query($sql_prev));
      $sql_next = // get next album info
      "SELECT `index`, `id`, `title`
       FROM `$_DB[dbname]`.`albums`
       WHERE `index` = '$next_index'
       LIMIT 1";
      $row_next = mysql_fetch_array(db_query($sql_next));
      $sql_last = // get last album info
      "SELECT `index`, `id`, `title`
       FROM `$_DB[dbname]`.`albums`
       WHERE `index` = '$last_index'
       LIMIT 1";
      $row_last = mysql_fetch_array(db_query($sql_last));
      
      if ($album_index == 1) {
        $first_text = $prev_text = 'nohref="nohref" class="disabled"';
      } else {
        $first_text = 'href="albums.php?id='.$row_first['id'].'" title="'.stml_parse($row_first['title']).'"';
        $prev_text = 'href="albums.php?id='.$row_prev['id'].'" title="'.stml_parse($row_prev['title']).'"';
      }
      if ($album_index == $last_index) {
        $last_text = $next_text = 'nohref="nohref" class="disabled"';
      } else {
        $last_text = 'href="albums.php?id='.$row_last['id'].'" title="'.stml_parse($row_last['title']).'"';
        $next_text = 'href="albums.php?id='.$row_next['id'].'" title="'.stml_parse($row_next['title']).'"';
      }
?>
        <a <?php echo $first_text; ?>>&lt;&lt;-- First</a>
        <a <?php echo $prev_text; ?>>&lt;-- Previous</a>
        <a href="albums.php" title="Index of Albums">Index</a>
        <a <?php echo $next_text; ?>>Next --&gt;</a>
        <a <?php echo $last_text; ?>>Last --&gt;&gt;</a>
      </div>

<?php
      $sql_album =
      "SELECT *
       FROM `$_DB[dbname]`.`albums`
       WHERE `id` = '$id'
       LIMIT 1";
      $result_album = db_query($sql_album);
      $row_album = mysql_fetch_array($result_album);
      $and_visible_condition = "AND `index` > '0'";
      if ($is_signed_in) {
        $and_visible_condition = '';
      }
      $sql_images =
      "SELECT *
       FROM `$_DB[dbname]`.`album_images`
       WHERE `album_id` = '$id'
         $and_visible_condition
       ORDER BY `index` ASC";
      $result_images = db_query($sql_images);
?>

      <h3><?php echo stml_parse($row_album['title']); ?></h3>
<?php
      if ($is_signed_in) {
?>
      <p>
        <a class="edit" href="albums.php?act=edit&id=<?php echo $row_album['id']; ?>">Edit Details</a>
        <a class="edit" href="albums.php?act=imgs&id=<?php echo $row_album['id']; ?>">Edit Images</a>
      </p>
<?php
      }
      
      $table_create = false;
      
      $count = 0;
      while ($row_image = mysql_fetch_array($result_images)) {
        if (!$table_create) {
          $table_create = true;
?>
      <div class="album_thumbs_div">
        <table class="album_thumbs">
          <tbody>
             <tr>
<?php
        }
        
        $location = "$row_album[location]/$row_image[location]";
        $thumb = "util/thumb.php?src=../albums/$location&conv=thumbsq";
        $index = $count + 1;
        $sdesc = $row_image['desc_short'];
        $ldesc = $row_image['desc_long'];
        $tdesc = $row_image['desc_time'];
        if ($row_image['index'] == 0) {
          $append = '  (this picture is hidden)';
        } else {
          $append = '';
        }
?>
              <td onclick="viewImage(<?php echo $index; ?>);" title="<?php echo stml_parse($sdesc); ?>">
                <img id="img_<?php echo $index; ?>"
                     src="<?php echo stml_parse($thumb); ?>"
                     alt="<?php echo stml_parse($sdesc); ?>"
                     title="<?php echo stml_parse($sdesc.$append); ?>"
                     ldesc="<?php echo stml_parse($ldesc); ?>"
                     tdesc="<?php echo stml_parse($tdesc); ?>"
                     loc="<?php echo htmlentities($location); ?>" />
              </td>
<?php
        $count++;
      }
      
      
      if ($table_create) {
?>
            </tr>
          </tbody>
        </table>
      </div>
<?php
      }
      
      if ($count == 0) {
?>
      <p>No images are in this album.</p>
<?php
      }
?>
      <div id="album_img" class="album_img">
        <a name="album_img"></a>
        <img class="album_img_img" id="album_img_img" src="" alt="" title="" />
        <span class="album_img_sdesc" id="album_img_sdesc">sdesc</span>
        <span class="album_img_ldesc" id="album_img_ldesc">ldesc</span>
        <span class="album_img_tdesc" id="album_img_tdesc">datetime</span>
        <h6>Navigate through pictures:</h6>
        <button class="album_img_nav" id="album_img_nav_first">&lt;&lt;-- First</button>
        <button class="album_img_nav" id="album_img_nav_prev">&lt;-- Previous</button>
        <button class="album_img_nav" id="album_img_nav_hide">Hide</button>
        <button class="album_img_nav" id="album_img_nav_next">Next --&gt;</button>
        <button class="album_img_nav" id="album_img_nav_last">Last --&gt;&gt;</button>
      </div>

      <script type="text/javascript">
var currImageNum;
var length;
var fragChecker;
var currLoc;
$(document).ready(function() {
  length = $('table.album_thumbs tbody tr td').length;
  
  var img = $('#album_img_img');
  img.attr('src', '');
  img.attr('alt', '');
  img.attr('title', '');
  img.hide();
  
  $('button.album_img_nav').mouseover(function() {
    if (this.disabled)
      return;
    $(this).css({
      'background-position': '0px -64px',
      'text-decoration': 'underline',
      'color': '#ffcc22'
    });
  });
  
  $('button.album_img_nav').mouseout(function() {
    if (this.disabled)
      return;
    $(this).css({
      'background-position': '0px -32px',
      'text-decoration': 'none',
      'color': '#ff8800'
    });
  });
  
  $('button.album_img_nav').mousedown(function() {
    if (this.disabled)
      return;
    $(this).css({
      'background-position': '0px -96px',
      'text-decoration': 'underline',
      'color': '#ffee44'
    });
  });
  
  $('button.album_img_nav').mouseup(function() {
    $(this).mouseover();
  });
  
  $('button#album_img_nav_first').click(function() {
    viewImage(1);
  });
  
  $('button#album_img_nav_prev').click(function() {
    viewImage(currImageNum - 1);
  });
  
  $('button#album_img_nav_hide').click(function() {
    viewImage(0);
  });
  
  $('button#album_img_nav_next').click(function() {
    viewImage(currImageNum + 1);
  });
  
  $('button#album_img_nav_last').click(function() {
    viewImage(length);
  });
  
  $(document).keyup(function(e) {
    var key = (window.event) ? event.keyCode : e.keyCode
    switch (key) {
      case 37: // LEFT ARROW KEY
        viewImage(currImageNum - 1);
        return false;
      case 38: // UP ARROW KEY
        return true;
      case 39: // RIGHT ARROW KEY
        viewImage(currImageNum + 1);
        return false;
      case 40: // DOWN ARROW KEY
        return true;
    }
    return true;
  });
  
  currImageNum = 0;
  loadText('Click a thumbnail above to see the picture larger with its description.',
  '', '', 0, null, false);
  $('#album_img').show();
  
  if (!checkFragment()) {
    // view first image if only one
    if (length == 1) {
      viewImage(1);
    }
  }
});

// returns true if fragment changed
function checkFragment() {
  var loc = window.location.toString();
  if (loc != currLoc) {
    var i, imgNum;
    if (loc.indexOf('#') > 0) {
      i = loc.substr(loc.indexOf('#') + 5);
      imgNum = Number(i);
    } else {
      imgNum = 0;
    }
    if (!isFinite(imgNum) || imgNum < 0 || imgNum > length) {
      imgNum = 0;
    }
    return viewImage(imgNum);
    currLoc = loc;
  }
  fragChecker = setTimeout('checkFragment();', 100);
  return false;
}

function disableBtn(btn) {
  btn.each(function() {
    $(this).css({
      'background-position': '0px 0px',
      'color': '#aaaaaa',
      'cursor': 'default',
      'text-decoration': 'none'
    }).attr({
      'disabled': true,
      'title': ''
    });
  });
}

function enableBtn(btn, title) {
  btn.each(function() {
    $(this).css({
      'background-position': '0px -32px',
      'color': '#ff8800',
      'cursor': 'pointer',
      'underline': 'none'
    }).attr({
      'disabled': false,
      'title': title
    });
  });
}

// show an image
function viewImage(imgNum) {
  if (!isFinite(imgNum) || imgNum < 0 || imgNum > length) {
    //alert("Unknown image '" + imgNum + "' in album <?php echo $row_album['title']; ?>.");
    return false;
  }
  if (imgNum == 0) {
    loadText('Click a thumbnail above to see the picture larger with its description.',
    '', '', 0, null, true);
    
    var img = $('#album_img_img');
    img.slideUp();
  } else {
    var img, thumb, path;
    img = $('#album_img_img');
    thumb = $('#img_' + imgNum);
    path = 'util/thumb.php?src=../albums/' + thumb.attr('loc') + '&conv=view1024';
    sdesc = thumb.attr('title');
    ldesc = thumb.attr('ldesc');
    tdesc = thumb.attr('tdesc');
    
    if (currImageNum >= 1) {
      if (img.attr('src') == path) {
        img.css({'opacity': 1});
        loadText(sdesc, ldesc, tdesc, imgNum, thumb, true);
      } else {
        loadText('Loading...', '', '', -1, null, true);
        img.css({'opacity': 0});
        img.bind('load', function() {
          $(this).animate({'opacity': 1});
          $(this).unbind();
          loadText(sdesc, ldesc, tdesc, imgNum, thumb, true);
        });
        img.attr({
          'src': '',
          'src': path,
          'alt': sdesc,
          'title': sdesc
        });
      }
    } else {
      loadText('Loading...', '', '', -1, null, true);
      img.bind('load', function() {
        $(this).slideDown('swing', function() {
          loadText(sdesc, ldesc, tdesc, imgNum, thumb, true);
        });
        $(this).unbind();
      });
      img.attr({
        'src': '',
        'src': path,
        'alt': sdesc,
        'title': sdesc
      });
    }
  }
  
  if (currImageNum != imgNum) {
    currImageNum = imgNum;
    return true;
  } else {
    return false;
  }
}

function loadText(sdesc, ldesc, tdesc, imgNum, thumb, changeFragment) {
  var span;
  span = $('#album_img_sdesc');
  if (sdesc == '')
    span.html('&nbsp;');
  else
    span.text(sdesc);
  span.show();
  span = $('#album_img_ldesc');
  if (ldesc == '')
    span.html('&nbsp;');
  else
    span.text(ldesc);
  span.show();
  span = $('#album_img_tdesc');
  if (tdesc == '')
    span.html('&nbsp;');
  else
    span.text('Picture taken ' + tdesc);
  span.show();
 
  var btn;
  if (imgNum <= 1) {
    btn = $('#album_img_nav_first');
    disableBtn(btn);
    btn = $('#album_img_nav_prev');
    disableBtn(btn);
  } else {
    btn = $('#album_img_nav_first');
    enableBtn(btn, $($(thumb.parent().siblings()[0]).children('img')).attr('sdesc'));
    btn = $('#album_img_nav_prev');
    enableBtn(btn, $(thumb.parent().prev().children('img')).attr('sdesc'));
  }
  
  if (imgNum <= 0 || imgNum >= length) {
    btn = $('#album_img_nav_next');
    disableBtn(btn);
    btn = $('#album_img_nav_last');
    disableBtn(btn);
  } else {
    btn = $('#album_img_nav_next');
    enableBtn(btn, $(thumb.parent().next().children('img')).attr('sdesc'));
    btn = $('#album_img_nav_last');
    enableBtn(btn, $($(thumb.parent().siblings()[length - 2]).children('img')).attr('sdesc'));
  }
 
  btn = $('#album_img_nav_hide');
  if (imgNum <= 0) {
    disableBtn(btn);
  } else {
    enableBtn(btn, "Hide large image");
  }
  
  if (changeFragment) {
    if (imgNum == 0) {
      var newLoc = window.location.toString();
      if (newLoc.indexOf('#') > 0) {
        newLoc = newLoc.substr(0, newLoc.indexOf('#'));
        window.location = newLoc + '#';
      }
      currLoc = newLoc;
    } else if (imgNum > 0) {
      var newLoc = window.location.toString();
      if (newLoc.indexOf('#') > 0) {
        newLoc = newLoc.substr(0, newLoc.indexOf('#'));
      }
      newLoc += '#img_' + imgNum;
      window.location = newLoc;
      currLoc = newLoc;
    }
  }
}
      </script>
<?php
    }
    break;
  case 1: // create album
  case 2: // edit album details
    if ($act == 1) {
      $row = array('title' => '',
                   'location' => '',
                   'datetext' => '',
                   'index' => 1);
    }
    
    $active = ($row['index'] > 0);
    
    if ($act == 1) {
?>
      <h3>Create New Album</h3>
<?php
    } elseif ($act == 2) {
?>
      <h3>Edit "<?php echo stml_parse($row['title']); ?>" Album Details</h3>
      
      <p>
        <a class="edit" href="albums.php?id=<?php echo $row['id']; ?>">View Album</a>
        <a class="edit" href="albums.php?act=imgs&id=<?php echo $row['id']; ?>">Edit Images</a>
      </p>
<?php
    }
?>
      <form method="post" action="albums.php?act=<?php echo $act_n; if (isset($row['id'])) echo "&id=$row[id]"; ?>&submit=1">
        <label for="title">Title:</label>
        <input name="title" class="long" type="text" maxlength="50" value="<?php echo htmlentities($row['title']); ?>">
        <label for="location">Location (Folder Name):</label>
<?php
    if ($act == 1) {
?>
        <input name="location" class="long" type="text" maxlength="50" value="">
<?php
    } elseif ($act == 2) {
?>
        <small>/albums/<?php echo htmlentities($row['location']); ?>/</small>
<?php
    }
?>
        <label for="datetext">Taken (Date Text):</label>
        <input name="datetext" class="long" type="text" maxlength="50" value="<?php echo htmlentities($row['datetext']); ?>">
        <label for="active">Visible:</label>
        <select name="active" class="short">
          <option value="1"<?php if ($active) echo ' selected="selected"'; ?>>Yes</option>
          <option value="0"<?php if (!$active) echo ' selected="selected"'; ?>>No</option>
        </select>
<?php
    if ($act == 2) {
?>
        <label for="remove">Remove Album:</label>
        <a name="remove" href="albums.php?act=remove&id=<?php echo $row['id']; ?>" class="edit">Click to Remove</a>
<?php
    }
?>
        <div class="input_button_wrapper">
          <input type="button" value="Cancel" class="cancel" href="albums.php">
          <input type="submit" value="<?php echo $cmd; ?>" class="submit">
        </div>
      </form>
<?php
    break;
  case 3: // confirm remove
?>
      <h3>Confirm Removing "<?php echo stml_parse($row['title']); ?>" Album</h3>
      
      <p>
        Are you sure you want to remove this album? Instead of completely removing,
        consider setting 'Visible' to 'No' so that it is hidden but not gone forever.
        Note that the associated folder and images will not be removed unless the
        folder is empty.
      </p>
      
      <form method="post" action="albums.php?act=<?php echo $act_n; ?>&id=<?php echo $row['id']; ?>&submit=1">
        <div class="input_button_wrapper">
          <input type="button" value="Cancel" class="cancel" href="albums.php?act=edit&id=<?php echo $row['id']; ?>">
          <input type="submit" value="<?php echo $cmd; ?>" class="submit">
        </div>
      </form>
<?php
    break;
  case 10: // edit images
?>
      <h3>Images in <?php echo stml_parse($row['title']); ?> Album</h3>
      
      <p>
        <a class="edit" href="albums.php?act=iadd&id=<?php echo $row['id']; ?>">Upload Images</a>
        <a class="edit" href="albums.php?id=<?php echo $row['id']; ?>">View Album</a>
        <a class="edit" href="albums.php?act=edit&id=<?php echo $row['id']; ?>">Edit Album Details</a>
        <a class="edit" href="albums.php">Back to Index</a>
      </p>
    
      <dl class="edit_mlf">
<?php
    $sql =
    "SELECT COUNT(*)
     FROM `$_DB[dbname]`.`album_images`
     WHERE `album_id` = '$id'";
    $result = mysql_fetch_row(db_query($sql));
    $image_count = $result[0];
    
    $sql =
    "SELECT *
     FROM `$_DB[dbname]`.`album_images`
     WHERE `album_id` = '$id'
     ORDER BY `index` ASC";
    $result = db_query($sql);
    while ($image_row = mysql_fetch_array($result)) {
      $location = "/albums/$row[location]/$image_row[location]";
      $thumb = "util/thumb.php?src=..$location&conv=thumbsq";
      $sdesc = $image_row['desc_short'];
      $ldesc = $image_row['desc_long'];
      $tdesc = $image_row['desc_time'];
      if ($image_row['index'] == 0) {
        $append = '  {i|(this picture is hidden)}';
      } else {
        $append = '';
      }
?>
        <div>
          <img class="edit_thumb edit_fllf" id="img_<?php echo $index; ?>" src="<?php echo htmlentities($thumb); ?>" alt="<?php echo stml_parse($sdesc); ?>" title="<?php echo stml_parse($sdesc); ?>" />
          <dt><?php echo stml_parse($sdesc.$append); ?></dt>
<?php
      if (strlen($ldesc) > 0) {
?>
          <dd>Subtext: <?php echo stml_parse($ldesc); ?></dd>
<?php
      }
      
      if (strlen($tdesc) > 0) {
?>
          <dd>Taken on <?php echo stml_parse($tdesc); ?></dd>
<?php
      }
?>
          <dd>Location: <?php echo htmlentities($location); ?></dd>
<?php
      if (file_exists(".$location")) {
        $imginfo = getimagesize(".$location");
?>
          <dd>Size: <?php echo "$imginfo[0] x $imginfo[1]"; ?> | Type: <?php echo substr($imginfo['mime'], strpos($imginfo['mime'], '/') + 1); ?></dd>
<?php
      } else {
?>
          <dd>File not found.</dd>
<?php
      }
      
      if ($image_row['index'] > 1) {
?>
          <a class="edit" href="albums.php?act=iup&id=<?php echo $row['id']; ?>&img=<?php echo $image_row['id']; ?>">Move Up</a>
<?php
      }
      
      if ($image_row['index'] < $image_count) {
?>
          <a class="edit" href="albums.php?act=idown&id=<?php echo $row['id']; ?>&img=<?php echo $image_row['id']; ?>">Move Down</a>
<?php
      }
?>
        <?php if ($image_count > 1) echo '|'; ?> <a class="edit" href="albums.php?act=iedit&id=<?php echo $row['id']; ?>&img=<?php echo $image_row['id']; ?>">Edit Details</a>
        </div>
<?php
    }
?>
      </dl>
<?php
    break;
  case 11: // upload image
?>
      <h3>Upload New Image to <?php echo stml_parse($row['title']); ?> Album</h3>
      
      <form enctype="multipart/form-data" method="post" action="albums.php?act=<?php echo $act_n; ?>&id=<?php echo $row['id']; ?>&submit=1">
        <input type="hidden" name="MAX_FILE_SIZE" value="536870912" />
        <input type="hidden" name="img_count" id="img_count" value="1">
        <label for="desc_short_1">Title:</label>
        <input name="desc_short_1" type="text" maxlength="100" value="">
        <label for="desc_long_1">Subtext:</label>
        <input name="desc_long_1" class="long" type="text" maxlength="200" value="">
        <label for="desc_time_1">Taken on:</label>
        <input name="desc_time_1" type="text" maxlength="50" value="">
        <label for="active_1">Visible:</label>
        <select name="active_1" class="short">
          <option value="1" selected="selected">Yes</option>
          <option value="0">No</option>
        </select>
        <label for="image_1">Image file:</label>
        <div class="multi_input_wrapper">
          <input name="image_1" class="input_file" type="file" value="">
        </div>
        <small>File type: image; Maximum size: 512 MB</small>
        <br /><br />
        <a class="edit" href="#img_count" id="image_more" value="1">Upload Another</a>
        <div class="input_button_wrapper">
          <input type="button" value="Cancel" class="cancel" href="albums.php?act=imgs&id=<?php echo $row['id']; ?>">
          <input type="submit" value="<?php echo $cmd; ?>" class="submit">
        </div>
      </form>
<?php
    break;
  case 12: // edit image details
    $location = "/albums/$row[location]/$image_row[location]";
    $thumb = "util/thumb.php?src=..$location&conv=thumbsq";
    $sdesc = $image_row['desc_short'];
    $ldesc = $image_row['desc_long'];
    $tdesc = $image_row['desc_time'];
    
    if (file_exists(".$location")) {
      $imginfo = getimagesize(".$location");
      $mime = $imginfo['mime'];
      $mime = substr($mime, strpos($mime, '/') + 1);
      $ftype = "Size: $imginfo[0] x $imginfo[1] | Type: $mime";
    } else {
      $ftype = 'File not found.';
    }
    
    $active = ($image_row['index'] > 0);
?>
      <h3>Edit Image "<?php echo $image_row['desc_short']; ?>" Details in <?php echo stml_parse($row['title']); ?> Album</h3>
      
      <form method="post" action="albums.php?act=<?php echo $act_n; ?>&id=<?php echo $row['id']; ?>&img=<?php echo $image_row['id']; ?>&submit=1">
        <label for="desc_short">Title:</label>
        <input name="desc_short" type="text" maxlength="100" value="<?php echo htmlentities($sdesc); ?>">
        <label for="desc_long">Subtext:</label>
        <input name="desc_long" class="long" type="text" maxlength="200" value="<?php echo htmlentities($ldesc); ?>">
        <label for="desc_time">Taken on:</label>
        <input name="desc_time" type="text" maxlength="50" value="<?php echo htmlentities($tdesc); ?>">
        <label for="active">Visible:</label>
        <select name="active" class="short">
          <option value="1"<?php if ($active) echo ' selected="selected"'; ?>>Yes</option>
          <option value="0"<?php if (!$active) echo ' selected="selected"'; ?>>No</option>
        </select>
        <label for="image">Image file:</label>
        <img class="edit_thumb" src="<?php echo htmlentities($thumb); ?>" alt="<?php echo htmlentities($sdesc); ?>" title="<?php echo htmlentities($sdesc); ?>" />
        <div class="input_preview">Location: <?php echo htmlentities($location); ?><br />
        <?php echo $ftype; ?></div>
        <label for="remove">Remove Image:</label>
        <a name="remove" href="albums.php?act=iremove&id=<?php echo $row['id']; ?>&img=<?php echo $image_row['id']; ?>" class="edit">Click to Remove</a>
        <div class="input_button_wrapper">
          <input type="button" value="Cancel" class="cancel" href="albums.php?act=imgs&id=<?php echo $row['id']; ?>">
          <input type="submit" value="<?php echo $cmd; ?>" class="submit">
        </div>
      </form>
<?php
    break;
  case 13: // confirm remove image
?>
      <h3>Confirm Removing Image "<?php echo stml_parse($image_row['desc_short']); ?>" from <?php echo stml_parse($row['title']); ?> Album</h3>
      
      <p>
        Are you sure you want to remove this image? Instead of completely removing,
        consider setting 'Visible' to 'No' so that it is hidden but not gone forever.
        Note that the associated image file will be removed.
      </p>
      
      <form method="post" action="albums.php?act=<?php echo $act_n; ?>&id=<?php echo $row['id']; ?>&img=<?php echo $image_row['id']; ?>&submit=1">
        <div class="input_button_wrapper">
          <input type="button" value="Cancel" class="cancel" href="albums.php?act=iedit&id=<?php echo $row['id']; ?>&img=<?php echo $image_row['id']; ?>">
          <input type="submit" value="<?php echo $cmd; ?>" class="submit">
        </div>
      </form>
<?php
    break;
}

// bottom of page
get_page_sect_bottom();

?>