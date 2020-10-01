<?php

$templ_page_valid = TRUE;

include_once('util/incl.php');

//db_connect();

check_session();

$act = 0;
if ($is_signed_in) {
  $act = isset($_GET['act']) ? $_GET['act'] : '';
  $act_n = $act;
  switch ($act) {
    case 'add':
      $verb = 'Upload Pedigree';
      $cmd = 'Upload';
      $act = 1;
      break;
    case 'edit':
      $verb = 'Edit Pedigree Details';
      $cmd = 'Save';
      $act = 2;
      $id = isset($_GET['id']) ? $_GET['id'] : 0;
      break;
    case 'remove':
      $verb = 'Remove Pedigree';
      $cmd = 'Confirm';
      $act = 3;
      $id = isset($_GET['id']) ? $_GET['id'] : 0;
      break;
    default: // view
      $act = 0;
      break;
  }
  
  if (isset($id)) {
    $sql =
    "SELECT *
     FROM `$_DB[dbname]`.`pedigrees`
     WHERE `id` = '".db_sanitize($id)."'
     LIMIT 1";
    $result = db_query($sql);
    $row = mysql_fetch_array($result);
    if ($row['id'] != $id) {
      show_message("Pedigree File ID '$id' not found.", 'error');
      $act = 0;
    }
  }
  
  $submit = isset($_GET['submit']) ? $_GET['submit'] : 0;
  if ($submit) {
    switch ($act) {
      case 1:
        switch ($_FILES['pedigree']['error']) {
          case UPLOAD_ERR_OK:
            $dateb = isset($_POST['date_birth']) ? $_POST['date_birth'] : '';
            $dateb_v = (bool) preg_match('/\d{4}-\d{2}-\d{2}/', $dateb);
            if (!$dateb_v) $dateb = db_date(time());
            $sid = isset($_POST['sire']) ? $_POST['sire'] : 0;
            $sid_v = (bool) preg_match('/\d+/', $sid);
            if (!$sid_v) $sid = 0;
            $did = isset($_POST['dam']) ? $_POST['dam'] : 0;
            $did_v = (bool) preg_match('/\d+/', $did);
            if (!$did_v) $did = 0;
            $active = (bool) (isset($_POST['active']) ? $_POST['active'] : '');
            
            $fname = basename($_FILES['pedigree']['name']);
            $fext = substr($fname, strrpos($fname, '.'));
            if ($fext != '.pdf') {
              show_message("Provided file was not a PDF.", 'error');
              break;
            }
            $target = "pedigrees/$fname";
            
            // 512 KILABYTES
            if ($_FILES['pedigree']['size'] > 524288) {
              show_message("Provided file was too large.", 'error');
              break;
            }
            
            if (move_uploaded_file($_FILES['pedigree']['tmp_name'], $target)) {
              $sql =
              "INSERT INTO `$_DB[dbname]`.`pedigrees` (
               `sire_id`, `dam_id`, `date_birth`, `location`, `active`
               ) VALUES (
               '$sid', '$did', '$dateb', '".db_sanitize($fname)."', '$active'
               )";
              db_query($sql);
              
              $sql =
              "SELECT `id` FROM `$_DB[dbname]`.`pedigrees`
               ORDER BY `id` DESC
               LIMIT 1";
              $row_ = mysql_fetch_row(db_query($sql));
              $id = $row_[0];
        
              $sql =
              "INSERT INTO `$_DB[dbname]`.`actions` (
               `user_id`, `page_id`, `date`, `edit_type`, `data_desc`
               ) VALUES (
               '$_SESSION[user_id]', '".get_page_id()."',
               '".db_date(time())."', '".($act == 1 ? 'ADD' : 'EDIT')."',
               'Uploaded ".db_sanitize($fname)." pedigree file (ID=$id).'
               )";
              db_query($sql);
              
              show_message("Upload of pedigree file '$fname' (ID=$id) succeeded.", 'notice');
            } else {
              show_message('Unknown upload failure (could not move temporary file).', 'error');
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
        $act = 0;
        header("Location: pedigrees.php");
        exit;
      case 2:
        $dateb = isset($_POST['date_birth']) ? $_POST['date_birth'] : '';
        $dateb_v = (bool) preg_match('/\d{4}-\d{2}-\d{2}/', $dateb);
        $sid = isset($_POST['sire']) ? $_POST['sire'] : 0;
        $sid_v = (bool) preg_match('/\d+/', $sid);
        $did = isset($_POST['dam']) ? $_POST['dam'] : 0;
        $did_v = (bool) preg_match('/\d+/', $did);
        $active = (bool) (isset($_POST['active']) ? $_POST['active'] : '');
        
        $sql =
        "UPDATE `$_DB[dbname]`.`pedigrees`
         SET `sire_id` = '$sid',
             `dam_id` = '$did',
             `date_birth` = '$dateb',
             `active` = '$active'
         WHERE `id` = '$id'";
        db_query($sql);
        
        $sql =
        "INSERT INTO `$_DB[dbname]`.`actions` (
         `user_id`, `page_id`, `date`, `edit_type`, `data_desc`
         ) VALUES (
         '$_SESSION[user_id]', '".get_page_id()."',
         '".db_date(time())."', 'REMOVE',
         'Updated ".db_sanitize($row['location'])." pedigree file (ID=$row[id]).'
         )";
        db_query($sql);
        
        show_message("Updated '$row[location]' pedigree file (ID=$row[id]).", 'notice');
        
        $act = 0;
        header("Location: pedigrees.php");
        exit;
      case 3:
        $sql =
        "SELECT `location`
         FROM `$_DB[dbname]`.`pedigrees`
         WHERE `id` = '$id'";
        $result = mysql_fetch_row(db_query($sql));
        $location = "pedigrees/$result[0]";
        @unlink($location);
        
        $sql =
        "DELETE FROM `$_DB[dbname]`.`pedigrees`
         WHERE `id` = '$id'";
        db_query($sql);
        
        $sql =
        "INSERT INTO `$_DB[dbname]`.`actions` (
         `user_id`, `page_id`, `date`, `edit_type`, `data_desc`
         ) VALUES (
         '$_SESSION[user_id]', '".get_page_id()."',
         '".db_date(time())."', 'REMOVE',
         'Removed '".db_sanitize($row['location'])."' pedigree file (ID=$row[id]).'
         )";
        db_query($sql);
        
        show_message("Removed '$row[location]' pedigree file (ID=$row[id]).", 'notice');
        
        $act = 0;
        header("Location: pedigrees.php");
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
?>
      <p>
        Here are pedigrees from past litters since 2007.
        Adobe Reader or a similar program is required to view them.
      </p> 
<?php
    
    $order_by = '`date_birth` DESC';
    $objs = api_pedigrees_list($DBCONN, '', '', 1000, 0, '`active` = 1', $order_by, true);
    echo $objs['html'];
    if ($is_signed_in)
    {
        $objs = api_pedigrees_list($DBCONN, '', '', 1000, 0, '`active` = 0', $order_by, false);
        echo $objs['html'];
    }
    break;
  case 1: // upload
?>
      <h3>Upload New Pedigree File</h3>
      
      <form enctype="multipart/form-data" method="post" action="pedigrees.php?act=<?php echo $act_n; ?>&submit=1">
        <input type="hidden" name="MAX_FILE_SIZE" value="524288" />
        <label for="date_birth">Litter date of birth:</label>
        <input name="date_birth" class="input_date" type="text" value="">
        <label for="sire">Litter's father:</label>
        <input name="sire" class="input_dog" type="text" value="">
        <label for="dam">Litter's mother:</label>
        <input name="dam" class="input_dog" type="text" value="">
        <label for="active">Visible:</label>
        <select name="active" class="short">
          <option value="1" selected="selected">Yes</option>
          <option value="0">No</option>
        </select>
        <label for="pedigree">Pedigree file:</label>
        <div class="multi_input_wrapper">
          <input name="pedigree" class="input_file" type="file" value="">
        </div>
        <small>File type: pdf | Maximum size: 512 KB</small>
        <div class="input_button_wrapper">
          <input type="button" value="Cancel" class="cancel" href="pedigrees.php">
          <input type="submit" value="<?php echo $cmd; ?>" class="submit">
        </div>
      </form>
<?php
    break;
  case 2: // edit
    if (!file_exists("./pedigrees/$row[location]")) {
      $ftype = 'File not found.';
    } else {
      $ftype = 'Type: pdf';
    }
    $active = $row['active'];
?>
      <h3>Edit Pedigree File "<?php echo htmlentities($row['location']); ?>"</h3>
      
      <form method="post" action="pedigrees.php?act=<?php echo $act_n; ?>&id=<?php echo $row['id']; ?>&submit=1">
        <label for="date_birth">Litter date of birth:</label>
        <input name="date_birth" class="input_date" type="text" value="<?php echo $row['date_birth']; ?>">
        <label for="sire">Litter's father:</label>
        <input name="sire" class="input_dog" type="text" value="<?php echo $row['sire_id']; ?>">
        <label for="dam">Litter's mother:</label>
        <input name="dam" class="input_dog" type="text" value="<?php echo $row['dam_id']; ?>">
        <label for="active">Visible:</label>
        <select name="active" class="short">
          <option value="1"<?php if ($active) echo ' selected="selected"'; ?>>Yes</option>
          <option value="0"<?php if (!$active) echo ' selected="selected"'; ?>>No</option>
        </select>
        <label for="pedigree">Pedigree file:</label>
        <a class="edit" href="pedigrees/<?php echo $row['location']; ?>" target="_blank" title="Pedigree File">
        <img src="pdficon.png" class="pdficon" title="This document requires Adobe Acrobat Reader" Alt="[PDF]" />
        Pedigree File</a><br />
        <div class="input_preview">Location: /pedigrees/<?php echo htmlentities($row['location']); ?> | <?php echo $ftype; ?></div>
        <label for="remove">Remove Pedigree:</label>
        <a name="remove" href="pedigrees.php?act=remove&id=<?php echo $row['id']; ?>" class="edit">Click to Remove</a>
        <div class="input_button_wrapper">
          <input type="button" value="Cancel" class="cancel" href="pedigrees.php">
          <input type="submit" value="<?php echo $cmd; ?>" class="submit">
        </div>
      </form>
<?php
    break;
  case 3: // confirm remove
?>
      <h3>Confirm Removing Pedigree File "<?php echo htmlentities($row['location']); ?>"</h3>
      
      <p>
        Are you sure you want to remove this pedigree? Instead of completely removing,
        consider setting 'Visible' to 'No' so that it is hidden but not gone forever.
        Note that the associated pedigree file will be removed.
      </p>
      
      <form method="post" action="pedigrees.php?act=<?php echo $act_n; ?>&id=<?php echo $row['id']; ?>&submit=1">
        <div class="input_button_wrapper">
          <input type="button" value="Cancel" class="cancel" href="pedigrees.php?act=edit&id=<?php echo $row['id']; ?>">
          <input type="submit" value="<?php echo $cmd; ?>" class="submit">
        </div>
      </form>
<?php
    break;
}

// bottom of page
get_page_sect_bottom();
