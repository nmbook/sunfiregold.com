<?php

// please include templ first, before other includes

// must set variable $templ_page_valid before this include so that
// direct page load of the page /util/templ.php will result in redirect

$templ_page_body_ready = false;

if (!isset($templ_page_valid))
{
    header('Location: /');
    exit();
}

// this function returns the file name of this page.
function get_page_file_name()
{
    $script_name = $_SERVER['SCRIPT_NAME'];
    $start = strpos($script_name, '/');
    return substr($script_name, $start + 1, -4);
}

function get_page_id()
{
    global $DBCONN;
    $fname = get_page_file_name();
    $page_obj = api_pages_find($DBCONN, $fname);
    $page_id = $page_obj['result'] ? $page_obj['id'] : 0;
    return $page_id;
}

// this function returns the last edit time of this page.
// TODO: why does SELECT `UPDATE_TIME` take so long?
function get_last_edit($page) {
  global $_DB;
  
  //$t1=time();
  // default to return current page edit time
  $mtime = filemtime($page . '.php');
  
  /*$sql = 
  "SELECT `primary_table`
   FROM `$_DB[dbname]`.`pages`
   WHERE `location` = '".$page."'
   LIMIT 1";
  $result = db_query($sql);
  $row = mysql_fetch_row($result);
  $primary_table = $row[0];
  if (strlen($primary_table) > 0) {
    if (strpos($primary_table, ',') !== false) {
      $primary_table = explode(',', $primary_table);
    } else {
      $primary_table = array($primary_table);
    }
  } else {
    $primary_table = array();
  }
  
  foreach ($primary_table as $table) {
    $sql =
    "SELECT `UPDATE_TIME`
     FROM `information_schema`.`TABLES`
     WHERE `TABLE_NAME` = '$table'
     LIMIT 1";
     
    $result = db_query($sql);
    $row = mysql_fetch_row($result);
    $utime = strtotime($row[0], time());
    if ($utime > $mtime)
      $mtime = $utime;
  }
  */
  //$t2 = time();
  //echo ($t2-$t1).'s';
  
  return $mtime;
}

// this function returns $_SERVER['HTTP_REFERER'] processed for this domain only
// the returned address is a relative link with no query string or # location
function get_valid_referer() {
  $referer = $_SERVER['HTTP_REFERER'];
  $server_name = $_SERVER['SERVER_NAME'];
  if (substr($referer, 0, 12 + strlen($server_name)) == "http://www.$server_name/" ||
      substr($referer, 0, 8 + strlen($server_name)) == "http://$server_name/") {
    $referer = substr($referer, strpos(substr($referer, 7), '/') + 8);
    $referer = substr($referer, 0, strpos($referer, '.php') + 4);
    return $referer;
  } else {
    return '';
  }
}

// this function writes the head section of the page.
// upon completion, will call get_page_sect_top
function get_page_sect_head() {
  global $DBCONN;
  global $act;
  global $verb;
  header('Content-Type: text/html; charset=utf-8');

  $fname = get_page_file_name();
  $page_obj = api_pages_find($DBCONN, $fname);
  $page_title = $page_obj['result'] ? $page_obj['title'] : $fname;
?>
<!DOCTYPE html>
<!--
 - Sunfire Golden Retrievers - <?php echo($page_title); ?> -
 - Last Edited on: <?php echo(date('l, F j, Y', get_last_edit($fname))); ?> -
 - Nate Book -
-->
<html>
  <head>
    <title>Sunfire Golden Retrievers - <?php echo($page_title); if ($act != 0) echo " - $verb"; ?></title>
<?php
  if ($fname == 'index') {
?>
    <!-- Search Engine Information -->
    <meta name="keywords" content="Sunfire,golden retriever,golden retrievers,dog,dogs,puppy,puppies,Sunfire Golden Retrievers,SunfireGold" />
    <meta name="description" content="This is the Sunfire Golden Retrievers homepage" />
<?php
  }
?>

    <!-- Page Links -->
    <link href="/style/style.css" rel="stylesheet" type="text/css" />
<?php
  if ($fname != 'error') {
?>
    <script type="text/javascript" src="/style/jquery.js"></script>
    <script type="text/javascript" src="/style/global.js"></script>
<?php
  }
?>
  </head>
<?php
}

// this function writes the top section of the page.
// after completion, will set $templ_page_body_ready to true
// and print pending messages
function get_page_sect_top() {
  global $DBCONN;
  global $templ_page_body_ready;
  global $act;
  global $verb;

  $fname = get_page_file_name();
  $page_obj = api_pages_find($DBCONN, $fname);
  $page_title = $page_obj['result'] ? $page_obj['title'] : $fname;
?>
  <body>
    <a name="Top"></a>
<?php
  // page navigation
  get_page_sect_nav();
?>  
    <div class="main">
      <a href="/index.html" class="header">
        <img src="/style/logo.png" alt="Sunfire Golden Retrievers, from Suffield, Connecticut" title="Sunfire Golden Retrievers, from Suffield, Connecticut" />
      </a>
<?php
  $templ_page_body_ready = true;
  
  dump_messages();

?>
      <h2><?php echo($page_title); if ($act != 0) echo " - $verb"; ?></h2>
      
      <hr />
<?php
}

// this function writes the navigation section of the page.
function get_page_sect_nav() {
  global $DBCONN;

  $fname = get_page_file_name();
  $page_obj = api_pages_find($DBCONN, $fname);
  $page_title = $page_obj['result'] ? $page_obj['title'] : $fname;
?>
    <div class="nav"><?php /*      <h5>Navigation</h5> */ ?>
<?php
  $obj = api_pages_list($DBCONN);
  echo $obj['html'];
?>
    </div>
<?php
}

// this function writes the end section of the page.
function get_page_sect_bottom() {
    global $is_signed_in;
    $fname = get_page_file_name();
?>
    </div>
    <div class="bottom">
      <a href="#Top" title="Go to the top of the page.">Top</a>
<?php
    if ($fname != 'identify') {
        if ($is_signed_in) {
?>
    | <a href="/identify.php?out=1&referer=<?php echo $fname.'.php'; ?>" title="Sign out of edit system.">Sign out</a>
<?php
        } /*else {
?>
    | <a href="/identify.php?referer=<?php echo $fname.'.php'; ?>" title="Sign in to edit this page.">Edit</a>
<?php
        }*/
    }
?>
      <p>This page was last modified on <?php echo(date('l, F j, Y', get_last_edit($fname))); ?>.</p>
    </div>
  </body>
</html>
<?php
    exit();
}
