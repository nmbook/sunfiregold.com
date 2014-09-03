<?php

$templ_page_valid = TRUE;

include_once('db.php');
include_once('k9data.php');
include_once('message.php');
include_once('q.php');
include_once('session.php');
include_once('strfuncs.php');

$act = isset($_GET['act']) ? $_GET['act'] : '';
$q = isset($_GET['q']) ? $_GET['q'] : '';
$filter = isset($_GET['f']) ? $_GET['f'] : '';

switch ($act) {
  default:
    break;
  case 'printdog':
    db_connect();
    
    echo print_dog(db_sanitize($q));
    break;
  case 'printped':
    db_connect();
    
    echo print_pedigree_link(db_sanitize($q), 1);
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
  case 'getpedbyid':
    db_connect();
    
    $sql =
    "SELECT `id`, `location`
     FROM `$_DB[dbname]`.`pedigrees`
     WHERE `id` = '".db_sanitize($q)."' 
     LIMIT 1";
    $result = db_query($sql);
    $row = mysql_fetch_array($result);
    echo $row['location'];
    break;
  case 'findk9datapage':
    db_connect();
    
    $query_result = k9data_post_search(db_sanitize($q));
    echo $query_result;
    break;
  case 'findpedfile':
    db_connect();
    
    $q_x = explode(',', $q);
    if (count($q_x) != 3) {
      echo '0';
      exit;
    }
    $sire = $q_x[0];
    $dam = $q_x[1];
    $date = $q_x[2];
    $sql =
    "SELECT `id`
     FROM `$_DB[dbname]`.`pedigrees`
     WHERE `sire_id` = '".db_sanitize($sire)."'
       AND `dam_id` = '".db_sanitize($dam)."'
       AND `date_birth` = '".db_sanitize($date)."'
     LIMIT 1";
    $row = mysql_fetch_row(db_query($sql));
    
    if ($row[0])
      echo $row[0];
    else 
      echo '0';
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