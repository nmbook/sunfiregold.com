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
      $verb = 'Create New Litter';
      $cmd = 'Create';
      $act = 1;
      break;
    case 'edit':
      $verb = 'Edit Litter';
      $cmd = 'Save';
      $act = 2;
      $id = isset($_GET['id']) ? $_GET['id'] : 0;
      break;
    case 'remove':
      $verb = 'Remove Litter';
      $cmd = 'Confirm';
      $act = 3;
      $id = isset($_GET['id']) ? $_GET['id'] : 0;
      break;
    default: // view
      $act = 0;
      break;
  }
  
  if (isset($id)) {
    $row = api_get_litter_by_id($DBCONN, $id);
    if ($row['result'] === false) {
      show_message("Litter ID '$id' not found.", 'error');
      $act = 0;
    }
  }
  
  $submit = isset($_GET['submit']) ? $_GET['submit'] : 0;
  if ($submit) {
    switch ($act) {
      case 1:
      case 2:
        $dateb = isset($_POST['litter_date']) ? $_POST['litter_date'] : '';
        $born = isset($_POST['litter_verb']) ? intval($_POST['litter_verb']) : 0;
        $ownb = isset($_POST['own_by']) ? $_POST['own_by'] : '';
        $countm = isset($_POST['count_males']) ? intval($_POST['count_males']) : 0;
        $countf = isset($_POST['count_females']) ? intval($_POST['count_females']) : 0;
        $descs = isset($_POST['desc_short']) ? $_POST['desc_short'] : '';
        $descl = isset($_POST['desc_long']) ? $_POST['desc_long'] : '';
        $sid = isset($_POST['sire']) ? $_POST['sire'] : 0;
        $did = isset($_POST['dam']) ? $_POST['dam'] : 0;
        $pid = isset($_POST['pedigree']) ? $_POST['pedigree'] : '';
        $active = (bool) (isset($_POST['active']) ? $_POST['active'] : 0);

        $dateb_v = intval(preg_match('/\d{4}-\d{2}-\d{2}/', $dateb));
        $sid_v = (bool) preg_match('/\d+/', $sid);
        $did_v = (bool) preg_match('/\d+/', $did);
        $pid_v = (bool) preg_match('/\d+/', $pid);

        $params = [];
        $params['date_birth'] = $dateb;
        $params['born'] = $born;
        $params['own_by'] = $ownb;
        if ($born)
        {
            $params['count_males'] = $countm;
            $params['count_females'] = $countf;
            $params['desc_short'] = $descs;
        }
        $params['desc_long'] = $descl;
        if ($sid_v) { $params['sire_id'] = $sid; }
        if ($did_v) { $params['dam_id'] = $did; }
        if ($pid_v) { $params['pedigree_id'] = $pid; }
        $params['active'] = $active;

        $act_descr = ($act == 1 ? 'Added ' : 'Updated ')
                .api_print_dog($DBCONN, $row['sire_id'], '', 3)['text']
                .' x '
                .api_print_dog($DBCONN, $row['dam_id'], '', 3)['text']
                .' litter '
                .($born ? 'born' : 'due').
                " on $dateb (ID=$id).";

        if ($act == 1)
        {
            $result = api_litter_insert($DBCONN, $params, $act_descr);
            if ($result['result'] === true)
            {
                $id = $result['id'];
            }
        }
        else
        {
            $result = api_litter_update($DBCONN, $id, $params, $act_descr);
        }

        show_message($act_descr, 'notice');

        $act = 0;
        header("Location: litters.php");
        exit;
      case 3:
        $act_descr = 'Removed '
                .api_print_dog($DBCONN, $row['sire_id'], '', 3)['text']
                .' x '
                .api_print_dog($DBCONN, $row['dam_id'], '', 3)['text']
                .' litter '
                .($row['born'] ? 'born' : 'due').
                " on $row[date_birth] (ID=$row[id]).";

        $result = api_litter_delete($DBCONN, $row['id'], $act_descr);
        
        show_message($act_descr, 'notice');
        
        $act = 0;
        header("Location: litters.php");
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
  case 0: // normal, view
  case 4: // error, completed action
?>
      <p>
        All parents are
        <a href="http://www.offa.org/" target="_blank" title="The Orthopedic Foundation for Animals">OFA</a> certified hips,
        <a href="http://www.offa.org/" target="_blank" title="The Orthopedic Foundation for Animals">OFA</a> certified elbows,
        cardiologist certified, and ophthalmologist certified.
      </p>
      
      <p>
        To see the parents' pedigrees, go to
        <a href="http://www.k9data.com/" target="_blank" title="K9Data">K9data.com</a>,
        and type in the dog's registered name in the searchbox.
      </p>
      
      <p>
        You can find pedigrees of the litters if you follow the link next to a litter,
        and relevent links about the parents next to parents (such as K9Data or the dog's homepage).
      </p>
      
      <hr />
<?php
    
    $order_by = '`date_birth` ASC';
    $born_no = [3, 2, 1, 0];
    $count = 0;
    for ($i = 0; $i < 4; $i++)
    {
        $where = "`active` = 1 AND `born` = $born_no[$i]";
        $litters = api_litters_list($DBCONN, '', '', 1000, 0, $where, $order_by);
        $count += count($litters['results']);
        echo $litters['html'];
    }
    $order_by = '`date_birth` ASC';
    if ($count == 0)
    {
        echo '      <p><i>There are no litters here. Please check back soon!</i></p>';
    }
    
    if ($is_signed_in) {
?>
      <h3>Hidden Litters</h3>
<?php
        $order_by = '`date_birth` DESC';
        $where = '`active` = 0';
        $litters = api_litters_list($DBCONN, '', '', 1000, 0, $where, $order_by);
        echo $litters['html'];
    }
    break;
  case 1: // create
  case 2: // edit
    if ($act == 1) {
      $row = array('date_birth' => db_date(time(), 1),
                   'born' => 0,
                   'own_by' => '',
                   'count_males' => '',
                   'count_females' => '',
                   'desc_short' => '',
                   'desc_long' => '',
                   'sire_id' => '',
                   'dam_id' => '',
                   'pedigree_id' => '',
                   'active' => 1);
    }
    
    $born = intval($row['born']);
    $c_m = intval($row['count_males']);
    $c_f = intval($row['count_females']);
    $active = (intval($row['active']) == 1);

    if ($act == 1) {
?>
      <h3>Create New Litter</h3>
<?php
    } elseif ($act == 2) {
?>
      <h3>Edit <?php echo api_print_dog($DBCONN, $row['sire_id'], '', 3)['text'].' x '.api_print_dog($DBCONN, $row['dam_id'], '', 3)['text']; ?> Litter</h3>
<?php
    }
?>
      <form method="post" action="litters.php?act=<?php echo $act_n; if (isset($row['id'])) echo "&id=$row[id]"; ?>&submit=1">
        <label for="litter_verb">Litter Status:</label>
        <select name="litter_verb">
          <option value="0"<?php if ($born == 0) echo ' selected="selected"'; ?>>Upcoming (due)</option>
          <option value="1"<?php if ($born == 1) echo ' selected="selected"'; ?>>Current (born)</option>
          <option value="2"<?php if ($born == 2) echo ' selected="selected"'; ?>>Non-litter (for dogs)</option>
          <option value="3"<?php if ($born == 3) echo ' selected="selected"'; ?>>Special (note only)</option>
        </select>
        <label for="litter_date">Date <?php if ($born != 0) echo 'Born'; else echo 'Due'; ?>:</label>
        <input name="litter_date" class="input_date date_birth_for_pedigree" type="text" value="<?php echo $row['date_birth']; ?>">
        <label for="own_by">Owned by field:</label>
        <input name="own_by" type="text" maxlength="50" value="<?php echo htmlentities($row['own_by']); ?>">
        <div id="sect_born"<?php if ($born) echo ' style="display: block;"'; ?>>
          <label for="count_males">Number of males:</label>
          <select name="count_males" class="short">
            <option value="-1"<?php if ($born != 0) echo ' selected="selected"'; ?>>No value</option>
<?php
    for ($i = 0; $i < 11; $i++) {
      echo '<option value="';
      echo $i;
      echo '"';
      if ($born == 1 && $c_m == $i) echo ' selected="selected"';
      echo ">$i</option>";
    }
?>
          </select>
          <label for="count_females">Number of females:</label>
          <select name="count_females" class="short">
            <option value="-1"<?php if ($born != 0) echo ' selected="selected"'; ?>>No value</option>
<?php
    for ($i = 0; $i < 11; $i++) {
      echo '<option value="';
      echo $i;
      echo '"';
      if ($born == 1 && $c_f == $i) echo ' selected="selected"';
      echo ">$i</option>";
    }
?>
          </select>
          <label for="desc_short">Litter description:</label>
          <input name="desc_short" type="text" maxlength="50" value="<?php if ($born) echo htmlentities($row['desc_short']); ?>">
        </div>
        <label for="desc_long">Litter note field:</label>
        <input name="desc_long" class="long" type="text" maxlength="200" value="<?php echo htmlentities($row['desc_long']); ?>">
        <label for="sire">Litter's father:</label>
        <input name="sire" class="input_dog sire_id_for_pedigree" gender="m" type="text" value="<?php echo $row['sire_id']; ?>">
        <label for="dam">Litter's mother:</label>
        <input name="dam" class="input_dog dam_id_for_pedigree" gender="f" type="text" value="<?php echo $row['dam_id']; ?>">
        <label for="pedigree">Pedigree File:</label>
        <input name="pedigree" class="input_ped" type="text" value="<?php echo $row['pedigree_id']; ?>">
        <label for="active">Visible:</label>
        <select name="active" class="short">
          <option value="1"<?php if ($active) echo ' selected="selected"'; ?>>Yes</option>
          <option value="0"<?php if (!$active) echo ' selected="selected"'; ?>>No</option>
        </select>
<?php
    if ($act == 2) {
?>
        <label for="remove">Remove Litter:</label>
        <a name="remove" href="litters.php?act=remove&id=<?php echo $row['id']; ?>" class="edit">Click to Remove</a>
<?php
    }
?>
        <div class="input_button_wrapper">
          <input type="button" value="Cancel" class="cancel" href="litters.php">
          <input type="submit" value="<?php echo $cmd; ?>" class="submit">
        </div>
      </form>
<?php
    break;
  case 3: // confirm remove
?>
      <h3>Remove <?php echo api_print_dog($DBCONN, $row['sire_id'], '', 3).' x '.api_print_dog($DBCONN, $row['dam_id'], '', 3); ?> Litter</h3>

      <p>
        Are you sure you want to remove this litter? Instead of completely removing,
        consider setting 'Visible' to 'No' so that it is hidden but not gone forever.
      </p>

      <form method="post" action="litters.php?act=<?php echo $act_n; if (isset($row['id'])) echo "&id=$row[id]"; ?>&submit=1">
        <div class="input_button_wrapper">
          <input type="button" value="Cancel" class="cancel" href="litters.php?act=edit&id=<?php echo $row['id']; ?>">
          <input type="submit" value="<?php echo $cmd; ?>" class="submit">
        </div>
      </form>
<?php
    break;
}

// bottom of page
get_page_sect_bottom();
