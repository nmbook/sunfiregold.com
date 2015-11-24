<?php

if (!isset($templ_page_valid)) {
  header('Location: /');
  exit();
}

$_DB = array (
  'host' => '',
  'uname' => '',
  'upass' => '',
  'dbname' => ''
);

include_once('db_creds.php');

function db_connect() {
  global $_DB;
  @mysql_connect($_DB['host'], $_DB['uname'], $_DB['upass']) or
    show_message('An error has occured when connecting to the MySQL database:<br /><pre>'.mysql_error().'</pre>', 'error');
  
  db_setup();
}

function db_setup() {
  global $_DB;
  db_query(
"CREATE DATABASE IF NOT EXISTS `$_DB[dbname]`",
'An error has occured when creating the MySQL database:'
  );
  
  db_query(
"CREATE TABLE IF NOT EXISTS `$_DB[dbname]`.`litters` (
 `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
 `date_birth` DATE NOT NULL,
 `born` BOOL NOT NULL,
 `own_by` VARCHAR(50) NULL,
 `count_males` INT(3) NULL,
 `count_females` INT(3) NULL,
 `desc_short` VARCHAR(50) NULL,
 `desc_long` VARCHAR(200) NULL,
 `dam_id` INT(11) NOT NULL,
 `sire_id` INT(11) NOT NULL,
 `pedigree_id` INT(11) NULL,
 `active` BOOL NOT NULL
)",
'An error has occured when creating the <b>litters</b> table:'
  );
  
  db_query(
"CREATE TABLE IF NOT EXISTS `$_DB[dbname]`.`dogs` (
 `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
 `date_birth` DATE NOT NULL,
 `date_death` DATE NULL,
 `gender` ENUM('MALE', 'FEMALE') NOT NULL DEFAULT 'MALE',
 `own_cat` ENUM('PUP', 'YOUNG', 'MAIN', 'OLD', 'PAST', 'NOLIST') NOT NULL DEFAULT 'NOLIST',
 `own_by` VARCHAR(50) NULL,
 `name_full` VARCHAR(50) NOT NULL,
 `name_short` VARCHAR(20) NULL,
 `sire_id` INT(11) NULL,
 `dam_id` INT(11) NULL,
 `pedigree_id` INT(11) NULL,
 `titles_pre` VARCHAR(50) NULL,
 `titles_post` VARCHAR(50) NULL
)",
'An error has occured when creating the <b>dogs</b> table:'
  );
  
  db_query(
"CREATE TABLE IF NOT EXISTS `$_DB[dbname]`.`pedigrees` (
 `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
 `sire_id` INT(11) NOT NULL,
 `dam_id` INT(11) NOT NULL,
 `date_birth` DATE NOT NULL,
 `location` VARCHAR(100) NOT NULL
)",
'An error has occured when creating the <b>pedigrees</b> table:'
  );
  
  db_query(
"CREATE TABLE IF NOT EXISTS `$_DB[dbname]`.`pages` (
 `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
 `name_file` VARCHAR(10) NOT NULL,
 `name_title` VARCHAR(20) NOT NULL,
 `name_anchor` VARCHAR(20) NOT NULL,
 `index` INT(3) NOT NULL
)",
'An error has occured when creating the <b>pages</b> table:'
  );
  
  db_query(
"CREATE TABLE IF NOT EXISTS `$_DB[dbname]`.`accounts` (
 `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
 `username` VARCHAR(20) NOT NULL,
 `password` CHAR(32) NOT NULL,
 `first_name` VARCHAR(10) NOT NULL,
 `last_name` VARCHAR(10) NOT NULL,
 `access` ENUM('EDIT','ADMIN') NOT NULL
)",
'An error has occured when creating the <b>accounts</b> table:'
  );
  
  db_query(
"CREATE TABLE IF NOT EXISTS `$_DB[dbname]`.`sessions` (
 `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
 `user_id` VARCHAR(20) NOT NULL,
 `php_hash` CHAR(32) NOT NULL,
 `start` DATETIME NOT NULL,
 `end` DATETIME NOT NULL,
 `open` BOOL NOT NULL
)",
'An error has occured when creating the <b>sessions</b> table:'
  );
  
  db_query(
"CREATE TABLE IF NOT EXISTS `$_DB[dbname]`.`actions` (
 `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
 `user_id` VARCHAR(20) NOT NULL,
 `page_id` DATETIME NOT NULL,
 `edit_type` ENUM('ADD','EDIT','REMOVE') NOT NULL,
 `data_desc` VARCHAR(100) NOT NULL
)",
'An error has occured when creating the <b>actions</b> table:'
  );
}

function db_query($sql, $err = 'An error has occured when querying the MySQL database:') {
  global $_DB;
  $result = @mysql_query($sql) or
    show_message("$err<br /><pre>".mysql_error().'</pre>', 'error');
  return $result;
}

function db_sanitize($input) {
  $output = mysql_real_escape_string($input);
  return $output;
}

// return a MySQL date
// Style 0: DATETIME
// Style 1: DATE
// Style 2: TIME
function db_date($date, $style = 0) {
  switch ($style) {
    default:
    case 0:
      return date('Y-m-d H:i:s', $date);
    case 1:
      return date('Y-m-d', $date);
    case 2:
      return date('H:i:s', $date);
  }
}

function db_close() {
  // mysql_close(); - this is not necessary @ http://www.php.net/manual/en/function.mysql-close.php
}
?>
