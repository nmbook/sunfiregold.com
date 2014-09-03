<?php

include_once('db.php');
include_once('message.php');
include_once('dogs.php');
include_once('strfuncs.php');
include_once('edit.php');

$act = isset($_GET['act']) ? $_GET['act'] : '';
$q = isset($_GET['q']) ? $_GET['q'] : '';
$filter = isset($_GET['f']) ? $_GET['f'] : '';

switch ($act) {
  default:
    break;
  case 'getdogbyid':
    db_connect();
    
    $sql =
    "SELECT `id`, `name_full`
     FROM `$_DB[dbname]`.`dogs`
     WHERE `id` = '".db_sanitize($q)."'
     LIMIT 1";
    $result = db_query($sql);
    $row = mysql_fetch_array($result);
    echo $row['name_full'];
    break;
  case 'getdog':
    db_connect();
    
    if ($filter == 'm') {
      $g = "AND `gender` = 'MALE'";
    } else if ($filter == 'f') {
      $g = "AND `gender` = 'FEMALE'";
    } else {
      $g = '';
    }
    
    $sql =
    "SELECT `id`, `name_full`
     FROM `$_DB[dbname]`.`dogs`
     WHERE (`name_full` LIKE '".db_sanitize($q)."%'
      OR `name_full` LIKE '% ".db_sanitize($q)."%')
      $g
     ORDER BY `name_full` ASC";
    $result = db_query($sql);
?>
<ul>
<?php
    while ($row = mysql_fetch_array($result)) {
?>
<li id="<?php echo $row['id']; ?>"><?php echo $row['name_full']; ?></li>
<?php
    }
    
?>
</ul>
<?php
    break;
}

?>