<?php

$templ_page_valid = TRUE;

include_once('util/incl.php');

db_connect();

check_session();

$id = isset($_GET['id']) ? $_GET['id'] : (isset($set_id) ? $set_id : 0);
if (isset($id) && $id != 0 && $id != '') {
  $sql =
  "SELECT *
   FROM `$_DB[dbname]`.`stories`
   WHERE `id` = '".db_sanitize($id)."'
   LIMIT 1";
  $result = db_query($sql);
  $row = mysql_fetch_array($result);
  if ($row['id'] != $id) {
    show_message("Story ID '$id' was not found.", 'error');
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
      $verb = 'Create New Story';
      $cmd = 'Create';
      $act = 1;
      break;
    case 'edit':
      $verb = 'Edit Story';
      $cmd = 'Save';
      $act = 2;
      break;
    case 'remove':
      $verb = 'Remove Story';
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
    default: // view
      $act = 0;
      break;
  }
  
  if (isset($id_error)) {
    $act = 0;
    $id = 0;
  }
  
  $submit = isset($_GET['submit']) ? $_GET['submit'] : 0;
  if ($submit || $act == 4 || $act == 5) {
    switch ($act) {
      case 1: // add
      case 2: // edit
        $title = isset($_POST['title']) ? $_POST['title'] : '';
        $subtitle = isset($_POST['subtitle']) ? $_POST['subtitle'] : '';
        $fulltext = isset($_POST['fulltext']) ? $_POST['fulltext'] : '';
        $active = isset($_POST['active']) ? $_POST['active'] : '';
        
        $sql =
        "SELECT COUNT(*)
         FROM `$_DB[dbname]`.`stories`
         WHERE `index` > 0
          AND `id` = '$id'";
        $result = mysql_fetch_row(db_query($sql));
        $prev_active = $result[0];
        
        $sql =
        "SELECT `index`
         FROM `$_DB[dbname]`.`stories`
         WHERE `id` = '$id'";
        $result = mysql_fetch_row(db_query($sql));
        $old_index = $result[0];
        
        if ($active) {
          if (!$prev_active) {
            $sql =
            "SELECT COUNT(*)
             FROM `$_DB[dbname]`.`stories`
             WHERE `index` > 0";
            $result = mysql_fetch_row(db_query($sql));
            $story_count = $result[0];
            $new_index = $story_count + 1;
          } else {
            $new_index = $old_index;
          }
        } else {
          $new_index = 0;
          if ($prev_active) {
            $sql =
            "UPDATE `$_DB[dbname]`.`stories`
             SET `index` = `index` - 1
             WHERE `index` > '$old_index'";
            db_query($sql);
          }
        }
        
        if ($act == 1) {
          $sql =
          "INSERT INTO `$_DB[dbname]`.`stories` (
           `title`, `subtitle`, `fulltext`, `index`
           ) VALUES (
           '".db_sanitize($title)."',
           '".db_sanitize($subtitle)."',
           '".db_sanitize($fulltext)."',
           '".db_sanitize($new_index)."'
           )";
        } else {
          $sql =
          "UPDATE `$_DB[dbname]`.`stories`
           SET `title` = '".db_sanitize($title)."',
               `subtitle` = '".db_sanitize($subtitle)."',
               `fulltext` = '".db_sanitize($fulltext)."',
               `index` = '".db_sanitize($new_index)."'
           WHERE `id` = '$id'";
        }
        db_query($sql);
        if ($act == 1) {
          $sql =
          "SELECT `id` FROM `$_DB[dbname]`.`stories`
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
         '".($act == 1 ? 'Added' : 'Updated').' '.db_sanitize($title)." story (ID=$id).'
         )";
        db_query($sql);
        
        show_message(($act == 1 ? 'Added ' : 'Updated')." '$title' story (ID=$id).", 'notice');
        
        $act = 0;
        header("Location: stories.php?id=$id");
        exit;
      case 3: // remove
        $sql =
        "SELECT `index`
         FROM `$_DB[dbname]`.`stories`
         WHERE `id` = '$id'";
        $result = mysql_fetch_row(db_query($sql));
        $index = $result[0];
        
        $sql =
        "DELETE FROM `$_DB[dbname]`.`stories`
         WHERE `id` = '$id'";
        db_query($sql);
        
        $sql =
        "UPDATE `$_DB[dbname]`.`stories`
         SET `index` = `index` - 1
         WHERE `index` > '$index'";
        db_query($sql);
        
        $sql =
        "INSERT INTO `$_DB[dbname]`.`actions` (
         `user_id`, `page_id`, `date`, `edit_type`, `data_desc`
         ) VALUES (
         '$_SESSION[user_id]', '".get_page_id()."',
         '".db_date(time())."', 'REMOVE',
         'Removed ".db_sanitize($row['title'])." story (ID=$row[id]).'
         )";
        db_query($sql);
        
        show_message("Removed '$row[title]' story (ID=$row[id]) from the database.", 'notice');
        
        $act = $id = 0;
        header("Location: stories.php");
        exit;
      case 4: // up (index -> inf)
        $old_index = $row['index'];
        $new_index = $old_index + 1;
        
        $sql =
        "SELECT COUNT(*)
         FROM `$_DB[dbname]`.`stories`
         WHERE `index` > 0";
        $result = mysql_fetch_row(db_query($sql));
        $story_count = $result[0];
        
        if ($new_index > $story_count) {
          show_message("Story '$row[title]' is already at the top.", 'error');
          $act = $id = 0;
          break;
        }
        $sql =
        "SELECT `id`
         FROM `$_DB[dbname]`.`stories`
         WHERE `index` = '$new_index'";
        $result = mysql_fetch_row(db_query($sql));
        $swap_id = $result[0];
        $sql =
        "UPDATE `$_DB[dbname]`.`stories`
         SET `index` = '".db_sanitize($new_index)."'
         WHERE `id` = '$id'";
        db_query($sql);
        $sql =
        "UPDATE `$_DB[dbname]`.`stories`
         SET `index` = '".db_sanitize($old_index)."'
         WHERE `id` = '$swap_id'";
        db_query($sql);
        
        $sql =
        "INSERT INTO `$_DB[dbname]`.`actions` (
         `user_id`, `page_id`, `date`, `edit_type`, `data_desc`
         ) VALUES (
         '$_SESSION[user_id]', '".get_page_id()."',
         '".db_date(time())."', 'PROMOTE',
         'Promoted ".db_sanitize($row['title'])." story (ID=$row[id]).'
         )";
        db_query($sql);
        
        show_message("Promoted '$row[title]' story (ID=$row[id]) up one position.", 'notice');
        
        $act = $id = 0;
        header("Location: stories.php");
        exit;
      case 5: // down (index -> 0)
        $old_index = $row['index'];
        $new_index = $old_index - 1;
        
        if ($new_index <= 0) {
          show_message("Story '$row[title]' is already at the bottom.", 'error');
          $act = $id = 0;
          break;
        }
        $sql =
        "SELECT `id`
         FROM `$_DB[dbname]`.`stories`
         WHERE `index` = '$new_index'";
        $result = mysql_fetch_row(db_query($sql));
        $swap_id = $result[0];
        $sql =
        "UPDATE `$_DB[dbname]`.`stories`
         SET `index` = '".db_sanitize($new_index)."'
         WHERE `id` = '$id'";
        db_query($sql);
        $sql =
        "UPDATE `$_DB[dbname]`.`stories`
         SET `index` = '".db_sanitize($old_index)."'
         WHERE `id` = '$swap_id'";
        db_query($sql);
        
        $sql =
        "INSERT INTO `$_DB[dbname]`.`actions` (
         `user_id`, `page_id`, `date`, `edit_type`, `data_desc`
         ) VALUES (
         '$_SESSION[user_id]', '".get_page_id()."',
         '".db_date(time())."', 'DEMOTE',
         'Demoted ".db_sanitize($row['title'])." story (ID=$row[id]).'
         )";
        db_query($sql);
        
        show_message("Demoted '$row[title]' story (ID=$row[id]) down one position.", 'notice');
        
        $act = $id = 0;
        header("Location: stories.php");
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
      <h3>Stories Index</h3>
      
      <p>Begin by clicking a story below:</p>
<?php
      if ($is_signed_in) {
?>
      <p><a class="edit" href="stories.php?act=add">Create New</a></p>
<?php
      }
?>
      <dl>
<?php
      $sql =
      "SELECT COUNT(*)
       FROM `$_DB[dbname]`.`stories`
       WHERE `index` > 0";
      $result = mysql_fetch_row(db_query($sql));
      $story_count = $result[0];
      
      $sql =
      "SELECT *
       FROM `$_DB[dbname]`.`stories`
       WHERE `index` > 0
       ORDER BY `index` DESC";
      $result = db_query($sql);
      while ($row = mysql_fetch_array($result)) {
?>
        <dt><a href="stories.php?id=<?php echo $row['id']; ?>" title="<?php echo stml_parse($row['title']); ?>"><?php echo stml_parse($row['title']); ?></a></dt>
<?php
        if (strlen($row['subtitle']) > 0) {
?>
        <dd><?php echo stml_parse($row['subtitle']); ?></dd>
<?php
        }
        
        if ($is_signed_in) {
          if ($row['index'] < $story_count) {
?>
        <a class="edit" href="stories.php?act=up&id=<?php echo $row['id']; ?>">Move Up</a>
<?php
          }
          if ($row['index'] > 1) {
?>
        <a class="edit" href="stories.php?act=down&id=<?php echo $row['id']; ?>">Move Down</a>
<?php
          }
?>
        <?php if ($story_count > 1) echo '|'; ?> <a class="edit" href="stories.php?act=edit&id=<?php echo $row['id']; ?>">Edit</a>
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
         FROM `$_DB[dbname]`.`stories`
         WHERE `index` = 0
         ORDER BY `id` ASC";
        $result = db_query($sql);
        while ($row = mysql_fetch_array($result)) {
          if (!$h_hidden) {
            $h_hidden = true;
?>
      <h3>Hidden Stories</h3>
<?php
      if ($is_signed_in) {
?>
      <p><a class="edit" href="stories.php?act=add">Create New</a></p>
<?php
      }
?>
      <dl>
<?php
          }
?>
        <dt><a href="stories.php?id=<?php echo $row['id']; ?>" title="<?php echo stml_parse($row['title']); ?>"><?php echo stml_parse($row['title']); ?></a></dt>
<?php
          if (strlen($row['subtitle']) > 0) {
?>
        <dd><?php echo stml_parse($row['subtitle']); ?></dd>
<?php
          }
?>
        <a class="edit" href="stories.php?act=edit&id=<?php echo $row['id']; ?>">Edit</a>
<?php
        }
        
        if ($h_hidden) {
?>
      </dl>
<?php
        }
      }
    } else {
      // view story
      
      if ($is_signed_in) {
?>
      <p>
        <a class="edit" href="stories.php?act=edit&id=<?php echo $row['id']; ?>">Edit Story</a>
      </p>
<?php
      }
?>
      <div class="story_nav">
        <h6>Navigate through stories:</h6>
<?php
      $sql_index = // get current story index
      "SELECT `index`
       FROM `$_DB[dbname]`.`stories`
       WHERE `id` = '$id'";
      $result_index = mysql_fetch_row(db_query($sql_index));
      $story_index = $result_index[0];
      $sql_count = // get story count
      "SELECT COUNT(*)
       FROM `$_DB[dbname]`.`stories`
       WHERE `index` > 0";
      $result_count = mysql_fetch_row(db_query($sql_count));
      $story_count = $result_count[0];
      $last_index = $story_count;
      $sql_prev = // get previous story index
      "SELECT MAX(`index`) AS `prev`
       FROM `$_DB[dbname]`.`stories`
       WHERE `index` > 0
        AND `index` < '$story_index'";
      $result_prev = mysql_fetch_row(db_query($sql_prev));
      $prev_index = $result_prev[0];
      if ($prev_index == '') $prev_index = 1;
      $sql_next = // get next story index
      "SELECT MIN(`index`) AS `next`
       FROM `$_DB[dbname]`.`stories`
       WHERE `index` > 0
        AND `index` > '$story_index'";
      $result_next = mysql_fetch_row(db_query($sql_next));
      $next_index = $result_next[0];
      if ($next_index == '') $next_index = $story_count;
      
      $sql_first = // get first story info
      "SELECT `index`, `id`, `title`
       FROM `$_DB[dbname]`.`stories`
       WHERE `index` = '1'
       LIMIT 1";
      $row_first = mysql_fetch_array(db_query($sql_first));
      $sql_prev = // get prev story info
      "SELECT `index`, `id`, `title`
       FROM `$_DB[dbname]`.`stories`
       WHERE `index` = '$prev_index'
       LIMIT 1";
      $row_prev = mysql_fetch_array(db_query($sql_prev));
      $sql_next = // get next story info
      "SELECT `index`, `id`, `title`
       FROM `$_DB[dbname]`.`stories`
       WHERE `index` = '$next_index'
       LIMIT 1";
      $row_next = mysql_fetch_array(db_query($sql_next));
      $sql_last = // get last story info
      "SELECT `index`, `id`, `title`
       FROM `$_DB[dbname]`.`stories`
       WHERE `index` = '$last_index'
       LIMIT 1";
      $row_last = mysql_fetch_array(db_query($sql_last));
      
      if ($story_index == 1) {
        $first_text = $prev_text = 'nohref="nohref" class="disabled"';
      } else {
        $first_text = 'href="stories.php?id='.$row_first['id'].'" title="'.stml_parse($row_first['title']).'"';
        $prev_text = 'href="stories.php?id='.$row_prev['id'].'" title="'.stml_parse($row_prev['title']).'"';
      }
      if ($story_index == $last_index) {
        $last_text = $next_text = 'nohref="nohref" class="disabled"';
      } else {
        $last_text = 'href="stories.php?id='.$row_last['id'].'" title="'.stml_parse($row_last['title']).'"';
        $next_text = 'href="stories.php?id='.$row_next['id'].'" title="'.stml_parse($row_next['title']).'"';
      }
?>
        <a <?php echo $first_text; ?>>&lt;&lt;-- First</a>
        <a <?php echo $prev_text; ?>>&lt;-- Previous</a>
        <a href="stories.php" title="Index of Stories">Index</a>
        <a <?php echo $next_text; ?>>Next --&gt;</a>
        <a <?php echo $last_text; ?>>Last --&gt;&gt;</a>
      </div>

<?php
      $sql_story =
      "SELECT *
       FROM `$_DB[dbname]`.`stories`
       WHERE `id` = '$id'
       LIMIT 1";
      $result_story = db_query($sql_story);
      $row_story = mysql_fetch_array($result_story);
?>
      <h3><?php echo stml_parse($row_story['title']); ?></h3>
      <h4><?php echo stml_parse($row_story['subtitle']); ?></h4>
<?php
      echo stml_parse_multiline($row_story['fulltext']);
    }
    break;
  case 1: // create story
  case 2: // edit story
    if ($act == 1) {
      $row = array('title' => '',
                   'subtitle' => '',
                   'fulltext' => '',
                   'index' => 1);
    }
    
    $active = ($row['index'] > 0);
    
    if ($act == 1) {
?>
      <h3>Create New Story</h3>
<?php
    } elseif ($act == 2) {
?>
      <h3>Edit "<?php echo stml_parse($row['title']); ?>" Story</h3>
      
      <p>
        <a class="edit" href="stories.php?id=<?php echo $row['id']; ?>">View Story</a>
      </p>
<?php
    }
?>
      <form method="post" action="stories.php?act=<?php echo $act_n; if (isset($row['id'])) echo "&id=$row[id]"; ?>&submit=1">
        <label for="title">Title:</label>
        <input name="title" class="long" type="text" maxlength="50" value="<?php echo htmlentities($row['title']); ?>">
        <label for="subtitle">Sub-Title:</label>
        <input name="subtitle" class="long" type="text" maxlength="100" value="<?php echo htmlentities($row['subtitle']); ?>">
        <label for="active">Visible:</label>
        <select name="active" class="short">
          <option value="1"<?php if ($active) echo ' selected="selected"'; ?>>Yes</option>
          <option value="0"<?php if (!$active) echo ' selected="selected"'; ?>>No</option>
        </select>
        <label for="fulltext">Story Text:</label>
        <textarea cols="100" rows="25" name="fulltext"><?php echo htmlentities($row['fulltext']); ?></textarea>
<?php
    if ($act == 2) {
?>
        <label for="remove">Remove Story:</label>
        <a name="remove" href="stories.php?act=remove&id=<?php echo $row['id']; ?>" class="edit">Click to Remove</a>
<?php
    }
?>
        <div class="input_button_wrapper">
          <input type="button" value="Cancel" class="cancel" href="stories.php">
          <input type="submit" value="<?php echo $cmd; ?>" class="submit">
        </div>
      </form>
<?php
    break;
  case 3: // confirm remove
?>
      <h3>Confirm Removing "<?php echo stml_parse($row['title']); ?>" Story</h3>
      
      <p>
        Are you sure you want to remove this story? Instead of completely removing,
        consider setting 'Visible' to 'No' so that it is hidden but not gone forever.
      </p>
      
      <form method="post" action="stories.php?act=<?php echo $act_n; ?>&id=<?php echo $row['id']; ?>&submit=1">
        <div class="input_button_wrapper">
          <input type="button" value="Cancel" class="cancel" href="stories.php?act=edit&id=<?php echo $row['id']; ?>">
          <input type="submit" value="<?php echo $cmd; ?>" class="submit">
        </div>
      </form>
<?php
    break;
}

// bottom of page
get_page_sect_bottom();

?>