<?php

$templ_page_valid = TRUE;

include_once('util/incl.php');

db_connect();

check_session();

$act = 0;
if ($is_signed_in) {
  $act = isset($_GET['act']) ? $_GET['act'] : '';
  $act_n = $act;
  switch ($act) {
    case 'add':
      $verb = 'Create New Link';
      $cmd = 'Create';
      $act = 1;
      break;
    case 'edit':
      $verb = 'Edit Link';
      $cmd = 'Save';
      $act = 2;
      $id = isset($_GET['id']) ? $_GET['id'] : 0;
      break;
    case 'remove':
      $verb = 'Remove Link';
      $cmd = 'Confirm';
      $act = 3;
      $id = isset($_GET['id']) ? $_GET['id'] : 0;
      break;
    case 'up':
      $verb = 'Move Up';
      $cmd = 'Confirm';
      $act = 4;
      $id = isset($_GET['id']) ? $_GET['id'] : 0;
      break;
    case 'down':
      $verb = 'Move Down';
      $cmd = 'Confirm';
      $act = 5;
      $id = isset($_GET['id']) ? $_GET['id'] : 0;
      break;
    default: // view
      $act = 0;
      break;
  }
  
  if (isset($id)) {
    $sql =
    "SELECT *
     FROM `$_DB[dbname]`.`links`
     WHERE `id` = '".db_sanitize($id)."'
     LIMIT 1";
    $result = db_query($sql);
    $row = mysql_fetch_array($result);
    if ($row['id'] != $id) {
      show_message("Link ID '$id' was not found.", 'error');
      $act = 0;
    }
  }
  
  $submit = isset($_GET['submit']) ? $_GET['submit'] : 0;
  if ($submit || $act == 4 || $act == 5) {
    switch ($act) {
      case 1:
      case 2:
        $title = isset($_POST['title']) ? $_POST['title'] : '';
        $location = isset($_POST['location']) ? $_POST['location'] : '';
        $active = isset($_POST['active']) ? $_POST['active'] : '';
        
        $sql =
        "SELECT COUNT(*)
         FROM `$_DB[dbname]`.`links`
         WHERE `index` > 0
          AND `id` = '$id'";
        $result = mysql_fetch_row(db_query($sql));
        $prev_active = $result[0];
        
        $sql =
        "SELECT `index`
         FROM `$_DB[dbname]`.`links`
         WHERE `id` = '$id'";
        $result = mysql_fetch_row(db_query($sql));
        $old_index = $result[0];
        
        if ($active) {
          if (!$prev_active) {
            $sql =
            "SELECT COUNT(*)
             FROM `$_DB[dbname]`.`links`
             WHERE `index` > 0";
            $result = mysql_fetch_row(db_query($sql));
            $link_count = $result[0];
            $new_index = $link_count + 1;
          } else {
            $new_index = $old_index;
          }
        } else {
          $new_index = 0;
          if ($prev_active) {
            $sql =
            "UPDATE `$_DB[dbname]`.`links`
             SET `index` = `index` - 1
             WHERE `index` > '$old_index'";
            db_query($sql);
          }
        }
        
        if ($act == 1) {
          $sql =
          "INSERT INTO `$_DB[dbname]`.`links` (
           `title`, `location`, `index`
           ) VALUES (
           '".db_sanitize($title)."',
           '".db_sanitize($location)."',
           '".db_sanitize($new_index)."'
           )";
        } else {
          $sql =
          "UPDATE `$_DB[dbname]`.`links`
           SET `title` = '".db_sanitize($title)."',
               `location` = '".db_sanitize($location)."',
               `index` = '".db_sanitize($new_index)."'
           WHERE `id` = '$id'";
        }
        db_query($sql);
        if ($act == 1) {
          $sql =
          "SELECT `id` FROM `$_DB[dbname]`.`links`
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
         '".($act == 1 ? 'Added ' : 'Updated ').db_sanitize($title)." link (ID=$id).'
         )";
        db_query($sql);
        
        show_message(($act == 1 ? 'Added' : 'Updated')." '$title' link (ID=$id).", 'notice');
        
        $act = 0;
        header("Location: links.php");
        exit;
      case 3:
        $sql =
        "SELECT `index`
         FROM `$_DB[dbname]`.`links`
         WHERE `id` = '$id'";
        $result = mysql_fetch_row(db_query($sql));
        $index = $result[0];
        
        $sql =
        "DELETE FROM `$_DB[dbname]`.`links`
         WHERE `id` = '$id'";
        db_query($sql);
        
        $sql =
        "UPDATE `$_DB[dbname]`.`links`
         SET `index` = `index` - 1
         WHERE `index` > '$index'";
        db_query($sql);
        
        $sql =
        "INSERT INTO `$_DB[dbname]`.`actions` (
         `user_id`, `page_id`, `date`, `edit_type`, `data_desc`
         ) VALUES (
         '$_SESSION[user_id]', '".get_page_id()."',
         '".db_date(time())."', 'REMOVE',
         'Removed ".db_sanitize($row['title'])." link.'
         )";
        db_query($sql);
        
        show_message("Removed '$row[title]' link (ID=$row[id]).", 'notice');
        
        $act = 0;
        header("Location: links.php");
        exit;
      case 4:
        $old_index = $row['index'];
        $new_index = $old_index - 1;
        
        if ($new_index <= 0) {
          show_message("Link '$row[title]' is already at the top.", 'error');
          $act = 0;
          break;
        }
        $sql =
        "SELECT `id`
         FROM `$_DB[dbname]`.`links`
         WHERE `index` = '$new_index'";
        $result = mysql_fetch_row(db_query($sql));
        $swap_id = $result[0];
        $sql =
        "UPDATE `$_DB[dbname]`.`links`
         SET `index` = '".db_sanitize($new_index)."'
         WHERE `id` = '$id'";
        db_query($sql);
        $sql =
        "UPDATE `$_DB[dbname]`.`links`
         SET `index` = '".db_sanitize($old_index)."'
         WHERE `id` = '$swap_id'";
        db_query($sql);
        
        $sql =
        "INSERT INTO `$_DB[dbname]`.`actions` (
         `user_id`, `page_id`, `date`, `edit_type`, `data_desc`
         ) VALUES (
         '$_SESSION[user_id]', '".get_page_id()."',
         '".db_date(time())."', 'PROMOTE',
         'Promoted ".db_sanitize($row['title'])." link (ID=$id).'
         )";
        db_query($sql);
        
        show_message("Promoted '$row[title]' link (ID=$id) up one position.", 'notice');
        
        $act = 0;
        header("Location: links.php");
        exit;
      case 5:
        $old_index = $row['index'];
        $new_index = $old_index + 1;
        
        $sql =
        "SELECT COUNT(*)
         FROM `$_DB[dbname]`.`links`
         WHERE `index` > 0";
        $result = mysql_fetch_row(db_query($sql));
        $link_count = $result[0];
        
        if ($new_index >= $link_count) {
          show_message("Link '$row[title]' is already at the bottom.", 'error');
          $act = 0;
          break;
        }
        $sql =
        "SELECT `id`
         FROM `$_DB[dbname]`.`links`
         WHERE `index` = '$new_index'";
        $result = mysql_fetch_row(db_query($sql));
        $swap_id = $result[0];
        $sql =
        "UPDATE `$_DB[dbname]`.`links`
         SET `index` = '".db_sanitize($new_index)."'
         WHERE `id` = '$id'";
        db_query($sql);
        $sql =
        "UPDATE `$_DB[dbname]`.`links`
         SET `index` = '".db_sanitize($old_index)."'
         WHERE `id` = '$swap_id'";
        db_query($sql);
        
        $sql =
        "INSERT INTO `$_DB[dbname]`.`actions` (
         `user_id`, `page_id`, `date`, `edit_type`, `data_desc`
         ) VALUES (
         '$_SESSION[user_id]', '".get_page_id()."',
         '".db_date(time())."', 'DEMOTE',
         'Demoted ".db_sanitize($row['title'])." link (ID=$id).'
         )";
        db_query($sql);
        
        show_message("Demoted '$row[title]' link (ID=$id) down one position.", 'notice');
        
        $act = 0;
        header("Location: links.php");
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
    if ($is_signed_in) {
?>
      <p><a class="edit" href="links.php?act=add">Create New</a></p>
<?php
    }
?>
      <dl>
<?php
    
    $sql =
    "SELECT COUNT(*)
     FROM `$_DB[dbname]`.`links`
     WHERE `index` > 0";
    $result = mysql_fetch_row(db_query($sql));
    $link_count = $result[0];
    
    $sql =
    "SELECT *
     FROM `$_DB[dbname]`.`links`
     WHERE `index` > 0
     ORDER BY `index` ASC";
    $result = db_query($sql);

    while ($row = mysql_fetch_array($result)) {
      $location = $row['location'];
      $title = $row['title'];
      if (strtolower(substr($location, 0, 7)) == 'http://') {
        if (substr_count($location, '/') == 2) {
          $location .= '/';
        }
      } else {
        if (substr_count($location, '/') == 0) {
          $location .= '/';
        }
        $location = "http://$location";
      }
      
      $location_friendly = substr($location, 7);
      if (substr_count($location_friendly, '/') == 1) {
        $location_friendly = substr($location_friendly, 0, strlen($location_friendly) - 1);
      }
      
?>
        <dt><a href="<?php echo $location; ?>" target="_blank" title="<?php echo $title; ?>"><?php echo $title; ?></a></dt>
          <dd>URL: <?php echo $location_friendly; ?></dd>
<?php
      if ($is_signed_in) {
        if ($row['index'] > 1) {
?>
          <a class="edit" href="links.php?act=up&id=<?php echo $row['id']; ?>">Move Up</a>
<?php
        }
        if ($row['index'] < $link_count) {
?>
          <a class="edit" href="links.php?act=down&id=<?php echo $row['id']; ?>">Move Down</a>
<?php
        }
?>
        <?php if ($link_count > 1) echo '|'; ?> <a class="edit" href="links.php?act=edit&id=<?php echo $row['id']; ?>">Edit</a>
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
       FROM `$_DB[dbname]`.`links`
       WHERE `index` = 0
       ORDER BY `id` ASC";
      $result = db_query($sql);
    
      while ($row = mysql_fetch_array($result)) {
        if (!$h_hidden) {
          $h_hidden = true;
?>
      <h3>Hidden Links</h3>
<?php
    if ($is_signed_in) {
?>
      <p><a class="edit" href="links.php?act=add">Create New</a></p>
<?php
    }
?>
      <dl>
<?php
        }
        
        $location = $row['location'];
        $title = $row['title'];
        if (strtolower(substr($location, 0, 7)) == 'http://') {
          if (substr_count($location, '/') == 2) {
            $location .= '/';
          }
        } else {
          if (substr_count($location, '/') == 0) {
            $location .= '/';
          }
          $location = "http://$location";
        }
        
        $location_friendly = substr($location, 7);
        if (substr_count($location_friendly, '/') == 1) {
          $location_friendly = substr($location_friendly, 0, strlen($location_friendly) - 1);
        }
        
?>
        <dt><a href="<?php echo $location; ?>" target="_blank" title="<?php echo $title; ?>"><?php echo $title; ?></a></dt>
          <dd>URL: <?php echo $location_friendly; ?></dd>
          <a class="edit" href="links.php?act=edit&id=<?php echo $row['id']; ?>">Edit</a>
<?php
      }
      
      if ($h_hidden) {
?>
      </dl>
<?php
      }
    }
    break;
  case 1: // create
  case 2: // edit
    if ($act == 1) {
      $row = array('title' => '',
                   'location' => '',
                   'index' => 1);
    }
    
    $active = ($row['index'] > 0);
    
    if ($act == 1) {
?>
      <h3>Add New Link</h3>
<?php
    } elseif ($act == 2) {
?>
      <h3>Edit "<?php echo $row['title']; ?>" Link</h3>
<?php
    }
?>
      
      <form method="post" action="links.php?act=<?php echo $act_n; if (isset($row['id'])) echo "&id=$row[id]"; ?>&submit=1">
        <label for="title">Title:</label>
        <input name="title" class="long" type="text" maxlength="100" value="<?php echo $row['title']; ?>">
        <label for="location">Location (URL):</label>
        <input name="location" class="long" type="text" maxlength="100" value="<?php echo $row['location']; ?>">
        <label for="active">Visible:</label>
        <select name="active" class="short">
          <option value="1"<?php if ($active) echo ' selected="selected"'; ?>>Yes</option>
          <option value="0"<?php if (!$active) echo ' selected="selected"'; ?>>No</option>
        </select>
<?php
    if ($act == 2) {
?>
        <label for="remove">Remove Link:</label>
        <a name="remove" href="links.php?act=remove&id=<?php echo $row['id']; ?>" class="edit">Click to Remove</a>
<?php
    }
?>
        <div class="input_button_wrapper">
          <input type="button" value="Cancel" class="cancel" href="links.php">
          <input type="submit" value="<?php echo $cmd; ?>" class="submit">
        </div>
      </form>
<?php
    break;
  case 3: // confirm remove
?>
      <h3>Confirm Removing "<?php echo $row['title']; ?>" Link</h3>
      
      <p>
        Are you sure you want to remove this link? Instead of completely removing,
        consider setting 'Visible' to 'No' so that it is hidden but not gone forever.
      </p>
      
      <form method="post" action="links.php?act=<?php echo $act_n; ?>&id=<?php echo $row['id']; ?>&submit=1">
        <div class="input_button_wrapper">
          <input type="button" value="Cancel" class="cancel" href="links.php?act=edit&id=<?php echo $row['id']; ?>">
          <input type="submit" value="<?php echo $cmd; ?>" class="submit">
        </div>
      </form>
<?php
    break;
}

// bottom of page
get_page_sect_bottom();

?>