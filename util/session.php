<?php

if (!isset($templ_page_valid))
{
    header('Location: /');
    exit();
}

$is_signed_in = false;

function create_account_obj($account_obj)
{
    return [
        'id' => $account_obj['id'],
        'sign_in_name' => $account_obj['username'],
        'first_name' => $account_obj['first_name'],
        'last_name' => $account_obj['last_name'],
        'full_name' => $account_obj['first_name'].' '.$account_obj['last_name'],
        'access' => $account_obj['access']
    ];
}

function get_session_hash($account_obj)
{
    return password_hash("$_SESSION[sess_id]$account_obj[id]$account_obj[username]", PASSWORD_BCRYPT);
}

function check_session_hash($account_obj, $hash)
{
    return password_verify("$_SESSION[sess_id]$account_obj[id]$account_obj[username]", $hash);
}

function start_session($username, $password)
{
    global $DBCONN;
    global $account;
    global $is_signed_in;
    $account_obj = api_session_account_login($DBCONN, $username, $password);
    if ($account_obj['result'] === false)
    {
        return false;
    }
    else
    {
        $session_obj = api_session_start($DBCONN, $account_obj['id'], time());
        if ($session_obj['result'] === false)
        {
            return false;
        }
        else
        {
            $_SESSION['user_id'] = $account_obj['id'];
            $_SESSION['sess_id'] = $session_obj['id'];
            $_SESSION['sess_hash'] = get_session_hash($account_obj);

            $is_signed_in = true;
            $account = create_account_obj($account_obj);
            return $account;
        }
    }
}

function end_session()
{
    global $DBCONN;
    // End db session
    if (isset($_SESSION['user_id']) && isset($_SESSION['sess_id']))
    {
        api_session_end($DBCONN, $_SESSION['user_id'], $_SESSION['sess_id'], time());
    }

    // Unset all of the session variables.
    $_SESSION = array();

    // If it's desired to kill the session, also delete the session cookie.
    // Note: This will destroy the session, and not just the session data!
    if (ini_get("session.use_cookies"))
    {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // Finally, destroy the session.
    session_destroy();
}

function check_session()
{
    global $DBCONN;
    global $account;
    global $is_signed_in;

    session_start();

    if (isset($_SESSION['user_id']))
    {
        $account_obj = api_session_account_check($DBCONN, $_SESSION['user_id']);
        if ($account_obj['result'] === true && check_session_hash($account_obj, $_SESSION['sess_hash']))
        {
            $is_signed_in = true;
            $account = create_account_obj($account_obj);
            return $account;
        }
        else
        {
            $is_signed_in = false;
            $account = false;
            end_session();
            return false;
        }
    }
}
