<?php

$templ_page_valid = TRUE;

include_once('util/incl.php');

db_connect();

check_session();

$returnto = isset($_GET['returnto']) ? $_GET['returnto'] : 'ourdogs';
if ($returnto != 'honordogs') $returnto = 'ourdogs';

$act = 0;
if ($is_signed_in) {
  $act = isset($_GET['act']) ? $_GET['act'] : '';
  $act_n = $act;
  switch ($act) {
    case 'add':
      $verb = 'Create New Dog';
      $cmd = 'Create';
      $act = 1;
      break;
    case 'edit':
      $verb = 'Edit Dog';
      $cmd = 'Save';
      $act = 2;
      $id = isset($_GET['id']) ? $_GET['id'] : 0;
      break;
    case 'remove':
      $verb = 'Remove Dog';
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
     FROM `$_DB[dbname]`.`dogs`
     WHERE `id` = '".db_sanitize($id)."'
     LIMIT 1";
    $result = db_query($sql);
    $row = mysql_fetch_array($result);
    if ($row['id'] != $id) {
      show_message("Dog ID '$id' not found.", 'error');
      $act = 0;
    }
  }
  
  $submit = isset($_GET['submit']) ? $_GET['submit'] : 0;
  if ($submit) {
    switch ($act) {
      case 1:
      case 2:
        $dateb = isset($_POST['date_birth']) ? $_POST['date_birth'] : '';
        $dateb_v = (bool) preg_match('/\d{4}-\d{2}-\d{2}/', $dateb);
        $dated = isset($_POST['date_death']) ? $_POST['date_death'] : '';
        $dated_v = (bool) preg_match('/\d{4}-\d{2}-\d{2}/', $dated);
        $datedp = isset($_POST['dog_past']) ? $_POST['dog_past'] : 0;
        $datedmask = $datedp;
        if ($datedp && strlen($dated) > 0) {
          if ($dated == '0000-00-00')
            $datedmask = 4;
          else if (substr($dated, 5, 2) == '00')
            $datedmask = 3;
          else if (substr($dated, 8, 2) == '00')
            $datedmask = 2;
        }
        $gender = isset($_POST['gender']) ? $_POST['gender'] : 'MALE';
        $owns = isset($_POST['dog_own_state']) ? $_POST['dog_own_state'] : '';
        $ownc = isset($_POST['dog_own_cat']) ? $_POST['dog_own_cat'] : 'NOLIST';
        $ownb = isset($_POST['own_by']) ? $_POST['own_by'] : '';
        $honorc = isset($_POST['honor_cat']) ? $_POST['honor_cat'] : 'NOLIST';
        $namef = isset($_POST['dog_name']) ? $_POST['dog_name'] : '';
        $names = isset($_POST['dog_nick']) ? $_POST['dog_nick'] : '';
        $titlep = isset($_POST['dog_pre']) ? $_POST['dog_pre'] : '';
        $titles = isset($_POST['dog_post']) ? $_POST['dog_post'] : '';
        $sid = isset($_POST['sire']) ? $_POST['sire'] : 0;
        $sid_v = (bool) preg_match('/\d+/', $sid);
        $did = isset($_POST['dam']) ? $_POST['dam'] : 0;
        $did_v = (bool) preg_match('/\d+/', $did);
        $pid = isset($_POST['pedigree']) ? $_POST['pedigree'] : '';
        $pid_v = (bool) preg_match('/\d+/', $pid);
        $kid = isset($_POST['k9data_id']) ? $_POST['k9data_id'] : '';
        $kid_v = (bool) preg_match('/\d+/', $kid);
        
        if ($act == 1) {
          $sql =
          "INSERT INTO `$_DB[dbname]`.`dogs` (
           ".($dateb_v ? "`date_birth`," : '')."
           ".($dated_v ? "`date_death`," : '')."
           `date_death_mask`,
           `gender`, `own_state`, `own_cat`, `own_by`,
           `honor_cat`,
           `name_full`, `name_short`, `titles_pre`, `titles_post`
           ".($sid_v ? ", `sire_id`" : '')."
           ".($did_v ? ", `dam_id`" : '')."
           ".($pid_v ? ", `pedigree_id`" : '')."
           ".($kid_v ? ", `k9data_id`" : '')."
           ) VALUES (
           ".($dateb_v ? "'$dateb'," : '')."
           ".($dated_v ? "'$dated'," : '')."
           '$datedmask',
           '$gender', '$owns', '$ownc',
           '".db_sanitize($ownb)."',
           '$honorc',
           '".db_sanitize($namef)."',
           '".db_sanitize($names)."',
           '".db_sanitize($titlep)."',
           '".db_sanitize($titles)."'
           ".($sid_v ? ", '$sid'" : '')."
           ".($did_v ? ", '$did'" : '')."
           ".($pid_v ? ", '$pid'" : '')."
           ".($kid_v ? ", '$kid'" : '')."
           )";
        } else {
          $sql =
          "UPDATE `$_DB[dbname]`.`dogs`
           SET
            ".($dateb_v ? "`date_birth` = '$dateb'," : '')."
            ".($dated_v ? "`date_death` = '$dated'," : '')."
            `date_death_mask` = '$datedmask',
            `gender` = '$gender', `own_state` = '$owns',
            `own_cat` = '$ownc', `own_by` = '".db_sanitize($ownb)."',
            `honor_cat` = '$honorc',
            `name_full` = '".db_sanitize($namef)."', `name_short` = '".db_sanitize($names)."',
            `titles_pre` = '".db_sanitize($titlep)."', `titles_post` = '".db_sanitize($titles)."'
            ".($sid_v ? ", `sire_id` = '$sid'" : '')."
            ".($did_v ? ", `dam_id` = '$did'" : '')."
            ".($pid_v ? ", `pedigree_id` = '$pid'" : '')."
            ".($kid_v ? ", `k9data_id` = '$kid'" : '')."
           WHERE `id` = '$id'";
        }
        db_query($sql);
        if ($act == 1) {
          $sql =
          "SELECT `id` FROM `$_DB[dbname]`.`dogs`
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
         '".($act == 1 ?'Added dog ':'Updated dog ').db_sanitize($namef)." (ID=$id).'
         )";
        db_query($sql);
        
        show_message(($act == 1 ? 'Added' : 'Updated')." dog '$namef' (ID=$id).", 'notice');
        
        $act = 0;
        header("Location: $returnto.php");
        exit;
      case 3:
        $sql =
        "DELETE FROM `$_DB[dbname]`.`dogs`
         WHERE `id` = '$id'";
        db_query($sql);
        
        $sql =
        "INSERT INTO `$_DB[dbname]`.`actions` (
         `user_id`, `page_id`, `date`, `edit_type`, `data_desc`
         ) VALUES (
         '$_SESSION[user_id]', '".get_page_id()."',
         '".db_date(time())."', 'REMOVE',
         'Removed dog ".db_sanitize($row['name_full'])." (ID=$row[id]).'
         )";
        db_query($sql);
        
        show_message("Removed dog '$row[name_full]' (ID=$row[id]).", 'notice');
        
        $act = 0;
        header("Location: $returnto.php");
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
    $order_by = '`date_birth` ASC';
    echo "      <h3>Present</h3>\r\n";
    echo print_dog_list("`own_cat` = 'OLD'", $order_by, 4, 'Retired');
    echo print_dog_list("`own_cat` = 'MAIN'", $order_by, 4, 'Main Dogs');
    echo print_dog_list("`own_cat` = 'YOUNG'", $order_by, 4, 'Up and Coming Youngsters');
    echo print_dog_list("`own_cat` = 'PUP'", $order_by, 4, 'Puppies');
    echo print_dog_list("`own_cat` = 'PAST'", $order_by, 3, 'Past');
    if ($is_signed_in) {
      echo print_dog_list("`own_cat` = 'NOLIST'", $order_by, 3, 'Hidden Dogs');
    }
    break;
  case 1: // create
  case 2: // edit
    if ($act == 1) {
      $row = array('date_birth' => db_date(time(), 1),
                   'date_death' => '0000-00-00',
                   'date_death_mask' => 0,
                   'gender' => 'MALE',
                   'own_state' => 'NONE',
                   'own_cat' => 'NOLIST',
                   'own_by' => '',
                   'honor_cat' => 'NOLIST',
                   'name_full' => '',
                   'name_short' => '',
                   'titles_pre' => '',
                   'titles_post' => '',
                   'sire_id' => '',
                   'dam_id' => '',
                   'pedigree_id' => '',
                   'k9data_id' => '');
    }
    
    $o_c = $row['own_cat'];
    $o_s = $row['own_state'];
    $o_b_isshown = ($o_s == 'LW' || $o_s == 'SW' || $o_s == 'OW' || $o_s == 'OB' || $o_s == 'A' || $o_s == 'X');
    $o_b_text = array('LW' => 'Live'.($o_c == 'PAST' ? 'd' : 's').' with', 'SW' => 'Shared with', 'OW' => 'Owned with', 'OB' => 'Owned by', 'A' => 'Available for', 'X' => 'Custom Subtitle:');
    $h_c = $row['honor_cat'];
    $gender = $row['gender'];
    $dog_past = ($row['date_death_mask'] > 0);
    $temp_datemask = $row['date_death_mask'];
    if ($temp_datemask == 0)
      $temp_datemask = 1;
    
    if ($act == 1) {
?>
      <h3>Add New Dog</h3>
<?php
    } elseif ($act == 2) {
?>
      <h3>Edit Dog "<?php echo htmlentities($row['name_short']); ?>"</h3>
<?php
    }
?>
      <form method="post" action="ourdogs.php?act=<?php echo $act_n; if (isset($row['id'])) echo "&id=$row[id]"; ?>&submit=1&returnto=<?php echo $returnto; ?>">
        <label for="dog_name">Dog AKC Name:</label>
        <input name="dog_name" class="long dog_name_for_k9data_id" type="text" value="<?php echo htmlentities($row['name_full']); ?>">
        <label for="dog_nick">Dog Nick Name:</label>
        <input name="dog_nick" type="text" value="<?php echo htmlentities($row['name_short']); ?>">
        <label for="dog_pre">Dog Prefix Titles:</label>
        <input name="dog_pre" class="long" type="text" value="<?php echo htmlentities($row['titles_pre']); ?>">
        <label for="dog_post">Dog Postfix Titles:</label>
        <input name="dog_post" class="long" type="text" value="<?php echo htmlentities($row['titles_post']); ?>">
        <label for="gender">Dog Gender:</label>
        <select name="gender" class="short">
          <option value="MALE"<?php if ($gender == 'MALE') echo ' selected="selected"'; ?>>Male</option>
          <option value="FEMALE"<?php if ($gender == 'FEMALE') echo ' selected="selected"'; ?>>Female</option>
        </select>
        <label for="dog_own_cat">Location on &quot;Our Dogs&quot;:</label>
        <select name="dog_own_cat">
          <option value="PUP"<?php if ($o_c == 'PUP') echo ' selected="selected"'; ?>>Puppy</option>
          <option value="YOUNG"<?php if ($o_c == 'YOUNG') echo ' selected="selected"'; ?>>Up and Coming Youngster</option>
          <option value="MAIN"<?php if ($o_c == 'MAIN') echo ' selected="selected"'; ?>>Main Dog</option>
          <option value="OLD"<?php if ($o_c == 'OLD') echo ' selected="selected"'; ?>>Retired</option>
          <option value="PAST"<?php if ($o_c == 'PAST') echo ' selected="selected"'; ?>>Past Dog</option>
          <option value="NOLIST"<?php if ($o_c == 'NOLIST') echo ' selected="selected"'; ?>>Do Not List</option>
        </select>
        <label for="honor_cat">List on &quot;Honor Roll&quot;:</label>
        <select name="honor_cat" class="short">
          <option value="LIST"<?php if ($h_c == 'LIST') echo ' selected="selected"'; ?>>Yes</option>
          <option value="NOLIST"<?php if ($h_c == 'NOLIST') echo ' selected="selected"'; ?>>No</option>
        </select>
        <label for="dog_own_state">Owner:</label>
        <select name="dog_own_state">
          <option value="LW"<?php if ($o_s == 'LW') echo ' selected="selected"'; ?>><?php echo $o_b_text['LW']; ?>...</option>
          <option value="LWP"<?php if ($o_s == 'LWP') echo ' selected="selected"'; ?>><?php echo $o_b_text['LW']; ?> pet home</option>
          <option value="SW"<?php if ($o_s == 'SW') echo ' selected="selected"'; ?>><?php echo $o_b_text['SW']; ?>...</option>
          <option value="OW"<?php if ($o_s == 'OW') echo ' selected="selected"'; ?>><?php echo $o_b_text['OW']; ?>...</option>
          <option value="OB"<?php if ($o_s == 'OB') echo ' selected="selected"'; ?>><?php echo $o_b_text['OB']; ?>...</option>
          <option value="AF"<?php if ($o_s == 'AF') echo ' selected="selected"'; ?>>Available for foster home</option>
          <option value="AS"<?php if ($o_s == 'AS') echo ' selected="selected"'; ?>>Available for sale</option>
          <option value="AA"<?php if ($o_s == 'AA') echo ' selected="selected"'; ?>>Available for adoptive home</option>
          <option value="A"<?php if ($o_s == 'A') echo ' selected="selected"'; ?>>Available for...</option>
          <option value="X"<?php if ($o_s == 'X') echo ' selected="selected"'; ?>>... (Custom Subtitle)</option>
          <option value="NONE"<?php if ($o_s == 'NONE') echo ' selected="selected"'; ?>>Us (No Subtitle)</option>
        </select>
        <div id="sect_ob"<?php if ($o_b_isshown) echo ' style="display: block;"'; ?>>
          <label for="own_by"><?php echo $o_b_text[$o_s]; ?>:</label>
          <input name="own_by" type="text" value="<?php echo htmlentities($row['own_by']); ?>">
        </div>
        <label for="date_birth">Date Born:</label>
        <input name="date_birth" class="input_date date_birth_for_pedigree" type="text" value="<?php echo $row['date_birth']; ?>">
        <label for="dog_past">Passed Away:</label>
        <select name="dog_past" class="short">
          <option value="1"<?php if ($dog_past) echo ' selected="selected"'; ?>>Yes</option>
          <option value="0"<?php if (!$dog_past) echo ' selected="selected"'; ?>>No</option>
        </select>
        <div id="sect_died"<?php if ($dog_past) echo ' style="display: block;"'; ?>>
          <label for="date_death">Date Died:</label>
          <input name="date_death" class="input_date" type="text" datemask="<?php echo $temp_datemask; ?>" value="<?php echo $row['date_death']; ?>">
        </div>
        <label for="sire">Dog's Father:</label>
        <input name="sire" class="input_dog sire_id_for_pedigree" type="text" gender="m" value="<?php echo $row['sire_id']; ?>">
        <label for="dam">Dog's Mother:</label>
        <input name="dam" class="input_dog dam_id_for_pedigree" type="text" gender="f" value="<?php echo $row['dam_id']; ?>">
        <label for="pedigree">Pedigree File:</label>
        <input name="pedigree" class="input_ped" type="text" value="<?php echo $row['pedigree_id']; ?>">
        <label for="k9data_id">K9Data ID:</label>
        <input name="k9data_id" class="input_k9data" type="text" value="<?php echo $row['k9data_id']; ?>">
<?php
    if ($act == 2) {
?>
        <label for="remove">Remove Dog:</label>
        <a name="remove" href="ourdogs.php?act=remove&id=<?php echo $row['id']; ?>&returnto=<?php echo $returnto; ?>" class="edit">Click to Remove</a>
<?php
    }
?>
        <div class="input_button_wrapper">
          <input type="button" value="Cancel" class="cancel" href="<?php echo $returnto; ?>.php">
          <input type="submit" value="<?php echo $cmd; ?>" class="submit">
        </div>
      </form>
<?php
    break;
  case 3: // confirm remove
?>
      <h3>Confirm Removing Dog "<?php echo htmlentities($row['name_short']); ?>"</h3>
      
      <p>
        Are you sure you want to remove this dog? Instead of completely removing,
        consider setting 'Where to show in List' to 'Do Not List' so that it is hidden but not gone forever.
      </p>
      
      <form method="post" action="ourdogs.php?act=<?php echo $act_n; if (isset($row['id'])) echo "&id=$row[id]"; ?>&submit=1&returnto=<?php echo $returnto; ?>">
        <div class="input_button_wrapper">
          <input type="button" value="Cancel" class="cancel" href="ourdogs.php?act=edit&id=<?php echo $row['id']; ?>&returnto=<?php echo $returnto; ?>">
          <input type="submit" value="<?php echo $cmd; ?>" class="submit">
        </div>
      </form>
<?php
    break;
}

// bottom of page
get_page_sect_bottom();

?>
