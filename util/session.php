<?php

if (!isset($templ_page_valid)) {
  header('Location: /');
  exit();
}

$is_logged_in = false;

function hash_password($pass) {
  return md5($pass.'.fkl;uv0');
}

function start_session($username, $password) {
  global $_DB;
  global $account;
  $sql =
  "SELECT COUNT(*) AS `count`, `id`, `username`
   FROM `$_DB[dbname]`.`accounts`
   WHERE `username` = '".db_sanitize($username)."'
    AND `password` = '".hash_password($password)."'
   LIMIT 1";
  $result = db_query($sql);
  $row = mysql_fetch_array($result);
  if ($row['count'] == 0) {
    return false;
  } else {
    $sql =
    "INSERT INTO `$_DB[dbname]`.`sessions`
     ( `user_id`, `start`, `open` )
     VALUES
     ( '$row[id]', '".db_date(time())."', 1 )";
    db_query($sql);
    $sql =
    "SELECT `id` FROM `$_DB[dbname]`.`sessions`
     ORDER BY `id` DESC
     LIMIT 1";
    $row_ = mysql_fetch_row(db_query($sql));
    
    $_SESSION['user_id'] = $row['id'];
    $_SESSION['sess_id'] = $row_[0];
    $_SESSION['sess_hash'] = hash_password("$_SESSION[sess_id]$row[id]$row[username]");
    
    $row_a = get_user($_SESSION['user_id']);
    if ($row_a && $_SESSION['sess_hash'] == hash_password("$_SESSION[sess_id]$row[id]$row[username]")) {
      $is_signed_in = true;
      $account = array('id' => $row_a['id'],
                       'sign_in_name' => $row_a['username'],
                       'full_name' => $row_a['first_name'].' '.$row_a['last_name'],
                       'access' => $row_a['access']
                      );
    } else {
      $is_signed_in = false;
      $account = false;
      end_session();
      return false;
    }
    
    return true;
  }
}

function end_session() {
  global $_DB;
  // End db session
  if (isset($_SESSION['user_id'])) {
    $sql =
    "UPDATE `$_DB[dbname]`.`sessions`
     SET `open` = 0, `end` = '".db_date(time())."'
     WHERE `user_id` = '$_SESSION[user_id]'
       AND `id` = $_SESSION[sess_id]";
    db_query($sql);
  }
  
  // Unset all of the session variables.
  $_SESSION = array();

  // If it's desired to kill the session, also delete the session cookie.
  // Note: This will destroy the session, and not just the session data!
  if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
      $params["path"], $params["domain"],
      $params["secure"], $params["httponly"]
    );
  }

  // Finally, destroy the session.
  session_destroy();
}

function check_session() {
  global $is_signed_in, $account;
  
  session_start();
  
  if (isset($_SESSION['user_id'])) {
    $row = get_user($_SESSION['user_id']);
    if ($row && $_SESSION['sess_hash'] == hash_password("$_SESSION[sess_id]$row[id]$row[username]")) {
      $is_signed_in = true;
      $account = array('id' => $row['id'],
                       'sign_in_name' => $row['username'],
                       'full_name' => $row['first_name'].' '.$row['last_name'],
                       'access' => $row['access']
                      );
      return $row;
    } else {
      $is_signed_in = false;
      $account = false;
      end_session();
      return false;
    }
  }
}

function get_user($user_id) {
  global $_DB;
  $sql =
  "SELECT COUNT(*) AS `count`, `id`, `username`, `password`, `first_name`, `last_name`, `access`
   FROM `$_DB[dbname]`.`accounts`
   WHERE `id` = '$user_id'
   LIMIT 1";
  $result = db_query($sql);
  $row = mysql_fetch_array($result);
  if ($row['count'] == 1) {
    return $row;
  } else {
    return false;
  }
}
?>