<?php

if (!isset($templ_page_valid)) {
  header('Location: /');
  exit();
}

$is_logged_in = false;

function start_session($username, $password) {
  global $DBCONN;
  global $account;
  global $is_signed_in;
  $account_obj = api_session_account_login($DBCONN, $username, $password);
  if ($account_obj['result'] === false) {
    return false;
  } else {
    $session_obj = api_session_start($DBCONN, $account_obj['id'], time());
    $_SESSION['user_id'] = $account_obj['id'];
    $_SESSION['sess_id'] = $session_obj['id'];
    $_SESSION['sess_hash'] = hash_password2("$_SESSION[sess_id]$account_obj[id]$account_obj[username]");
    
    //$account_obj = get_user($_SESSION['user_id']);
    if ($_SESSION['sess_hash'] == hash_password2("$_SESSION[sess_id]$account_obj[id]$account_obj[username]")) {
      $is_signed_in = true;
      $account = array('id' => $account_obj['id'],
                       'sign_in_name' => $account_obj['username'],
                       'full_name' => $account_obj['first_name'].' '.$account_obj['last_name'],
                       'access' => $account_obj['access']
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
  global $DBCONN;
  // End db session
  if (isset($_SESSION['user_id'])) {
    api_session_end($DBCONN, $_SESSION['user_id'], $_SESSION['sess_id'], time());
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
    $row = api_session_account_check($_SESSION['user_id']);
    if ($row['result'] === true && $_SESSION['sess_hash'] == hash_password("$_SESSION[sess_id]$row[id]$row[username]")) {
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
