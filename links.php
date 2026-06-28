<?php

$templ_page_valid = TRUE;

include_once('util/incl.php');

//db_connect();

check_session();

$act = 0;
if ($is_signed_in) {
  $act = $_GET['act'] ?? '';
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
      $id = $_GET['id'] ?? 0;
      break;
    case 'remove':
      $verb = 'Remove Link';
      $cmd = 'Confirm';
      $act = 3;
      $id = $_GET['id'] ?? 0;
      break;
    case 'up':
      $verb = 'Move Up';
      $cmd = 'Confirm';
      $act = 4;
      $id = $_GET['id'] ?? 0;
      break;
    case 'down':
      $verb = 'Move Down';
      $cmd = 'Confirm';
      $act = 5;
      $id = $_GET['id'] ?? 0;
      break;
    default: // view
      $act = 0;
      break;
  }
  
  if (isset($id)) {
    $row = api_get_link_by_id($DBCONN, $id);
    if ($row['result'] === false) {
      show_message("Link ID '$id' not found.", 'error');
      $act = 0;
    }
  }
  
  $submit = $_GET['submit'] ?? 0;
  if ($submit || $act == 4 || $act == 5) {
    switch ($act) {
      case 1:
      case 2:
        $title = $_POST['title'] ?? '';
        $location = $_POST['location'] ?? '';
        $active = (bool) ($_POST['active'] ?? '');
        
        $params = [];
        $params['title'] = $title;
        $params['location'] = $location;
        if ($act == 1)
        {
          if ($active)
          {
            // visible=true, add to end
            $params['index'] = as_count(api_links_count($DBCONN, true));
          }
          else
          {
            // visible=false, add as 0
            $params['index'] = 0;
          }
        }
        else
        {
          if ($active && $row['index'] == 0)
          {
            // visible=true and invisible before, add to end
            $params['index'] = as_count(api_links_count($DBCONN, true));
          }
          else if (!$active && $row['index'] > 0)
          {
            // visible=false and visible before, set to 0
            $params['index'] = 0;
          }
        }

        $act_descr = ($act == 1 ? 'Added link ' : 'Updated link ')."$title.";

        if ($act == 1)
        {
          $result = api_link_insert($DBCONN, $params, $act_descr);
        }
        else
        {
          $result = api_link_update($DBCONN, $id, $params, $act_descr);
        }

        show_message(as_text($result), 'notice');

        $act = 0;
        header("Location: links.php");
        exit;
      case 3:
        $act_descr = "Removed link $row[title].";

        $result = api_link_delete($DBCONN, $row['id'], $act_descr);

        show_message(as_text($result), 'notice');

        $act = 0;
        header("Location: links.php");
        exit;
      case 4:
        $old_index = $row['index'];

        if ($old_index == 0)
        {
          show_message("Link $row[title] is hidden and can't be moved.", 'error');
          $act = 0;
          break;
        }

        $new_index = $old_index - 1;
        
        if ($new_index <= 0) {
          show_message("Link $row[title] is already at the top.", 'error');
          $act = 0;
          break;
        }

        $params = [];
        $params['index'] = $new_index;

        $act_descr = "Moved $row[title] link up one position.";

        $result = api_link_update($DBCONN, $id, $params, $act_descr);

        show_message(as_text($result), 'notice');

        $act = 0;
        header("Location: links.php");
        exit;
      case 5:
        $old_index = $row['index'];

        if ($old_index == 0)
        {
          show_message("Link $row[title] is hidden and can't be moved.", 'error');
          $act = 0;
          break;
        }

        $new_index = $old_index + 1;
        
        $link_count = as_count(api_links_count($DBCONN, true));
        if ($new_index >= $link_count) {
          show_message("Link $row[title] is already at the bottom.", 'error');
          $act = 0;
          break;
        }

        $params = [];
        $params['index'] = $new_index;

        $act_descr = "Moved $row[title] link down one position.";

        $result = api_link_update($DBCONN, $id, $params, $act_descr);

        show_message(as_text($result), 'notice');

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
    
    $order_by = '`index` ASC';
    echo as_html(api_links_list($DBCONN, '', '', 1000, 0, '`index` > 0', $order_by));
    
    if ($is_signed_in)
    {
      $hidden_link_count = as_count(api_links_count($DBCONN, false));
      if ($hidden_link_count > 0)
      {
?>
      <h3>Hidden Links</h3>
<?php
      }
      echo as_html(api_links_list($DBCONN, '', '', 1000, 0, '`index` = 0'));
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
