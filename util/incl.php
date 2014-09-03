<?php

if (!isset($templ_page_valid)) {
  header('Location: /');
  exit();
}

include_once('util/templ.php');
include_once('util/db.php');
include_once('util/k9data.php');
include_once('util/message.php');
include_once('util/q.php');
include_once('util/session.php');
include_once('util/stml.php');
include_once('util/strfuncs.php');

?>