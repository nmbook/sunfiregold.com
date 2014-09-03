<?php

// please include templ first, before other includes

// must set variable $templ_page_valid before this include so that
// direct page load of the page /util/templ.php will result in redirect

$templ_page_body_ready = false;

if (!isset($templ_page_valid)) {
  header('Location: /');
  exit();
}

// this function returns the file name of this page.
function get_page_file_name() {
  $script_name = $_SERVER['SCRIPT_NAME'];
  $start = strpos($script_name, '/');
  return substr($script_name, $start + 1, -4);
}

// this function returns the name from known pages of this page.
function get_page_name() {
  global $_DB;
  $sql = 
  "SELECT `title`
   FROM `$_DB[dbname]`.`pages`
   WHERE `location` = '".get_page_file_name()."'
   LIMIT 1";
  $result = db_query($sql);
  $row = mysql_fetch_row($result);
  return $row[0];
}

function get_page_id() {
  global $_DB;
  $sql = 
  "SELECT `id`
   FROM `$_DB[dbname]`.`pages`
   WHERE `location` = '".get_page_file_name()."'
   LIMIT 1";
  $result = db_query($sql);
  $row = mysql_fetch_row($result);
  return $row[0];
}

// this function returns the last edit time of this page.
function get_last_edit($page) {
  global $_DB;
  
  // default to return current page edit time
  $mtime = filemtime($page . '.php');
  
  $sql = 
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
?>
<!--
 - Sunfire Golden Retrievers - <?php echo(get_page_name()); ?> -
 - Last Edited on: <?php echo(date('l, F j, Y', get_last_edit(get_page_file_name()))); ?> -
 - Nate Book -
-->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
  <head>
    <title>Sunfire Golden Retrievers - <?php echo(get_page_name()); if ($act != 0) echo " - $verb"; ?></title>
<?php
  if (get_page_file_name() == 'index') {
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
  if (get_page_file_name() != 'error') {
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
  global $templ_page_body_ready;
  global $act;
  global $verb;
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
      <h2><?php echo(get_page_name()); if ($act != 0) echo " - $verb"; ?></h2>
      
      <hr />
<?php
}

// this function writes the navigation section of the page.
function get_page_sect_nav() {
  global $_DB;
?>
    <div class="nav">
      <h5>Navigation</h5>
<?php
  $sql = 
  "SELECT *
   FROM `$_DB[dbname]`.`pages`
   WHERE `index` > 0
   ORDER BY `index` ASC";
  $result = db_query($sql);
  while ($row = mysql_fetch_array($result)) {
?>
      <a href="<?php echo "/$row[location].php"; ?>" title="<?php echo $row['title']; ?>"><?php echo $row['anchor']; ?></a>
<?php
  }
?>
    </div>
<?php
}

// this function writes the end section of the page.
function get_page_sect_bottom() {
  global $is_signed_in, $logout;
?>
    </div>
    <div class="bottom">
      <a href="#Top" title="Go to the top of the page.">Top</a>
<?php
  if (get_page_file_name() != 'identify') {
    if ($is_signed_in) {
?>
    | <a href="/identify.php?out=1&referer=<?php echo get_page_file_name().'.php'; ?>" title="Sign out of edit system.">Sign out</a>
<?php
    } /*else {
?>
    | <a href="/identify.php?referer=<?php echo get_page_file_name().'.php'; ?>" title="Sign in to edit this page.">Edit</a>
<?php
    }*/
  }
?>
      <p>This page was last modified on <?php echo(date('l, F j, Y', get_last_edit(get_page_file_name()))); ?>.</p>
    </div>
  </body>
</html>
<?php
}
?>