<?php

$templ_page_valid = TRUE;

include_once('util/incl.php');

db_connect();

check_session();

$code = isset($_GET['e']) ? $_GET['e'] : 0;


switch ($code) {
  case 0: // no error
    header('Location: /index.php');
    exit;
  case 400: // bad request
    $status = 'Bad Request';
    $desc = 'The request could not be understood.';
    $specific_wtdn = '';
    break;
  case 401: // unauthorized
    $status = 'Unauthorized';
    $desc = 'Logon credentials were incorrect or not provided to access this page.';
    $specific_wtdn = '';
    break;
  case 402: // payment required
    $status = 'Payment Required';
    $desc = '?';
    $specific_wtdn = '';
    break;
  case 403: // forbidden
    $status = 'Forbidden';
    $desc = 'You are not allowed to access this page.';
    $specific_wtdn = '';
    break;
  case 404: // not found
    $status = 'Not Found';
    $desc = 'The requested page was not found on this server.';
    $specific_wtdn = '<li>Check your spelling of the URL.</li>';
    break;
  case 410: // gone
    $status = 'Gone';
    $desc = 'The requested page was not found on this server, but it may have existed in the past.';
    $specific_wtdn = '';
    break;
  case 500: // internal server error
    $status = 'Internal Server Error';
    $desc = 'The website server has encountered a problem and could not complete your request.';
    $specific_wtdn = '<li>Try again later.</li>';
    break;
  case 503: // service unavailable
    $status = 'Service Unavailable';
    $desc = 'The website server appears to be overloaded and could not complete your request.';
    $specific_wtdn = '<li>Try again later.</li>';
    break;
  default: // unknown
    if ($code >= 400 && $code < 500) { // client
      $status = "Unknown Client Error $code";
      $code = 499;
    } elseif ($code >= 500 && $code < 600) { // server
      $status = "Unknown Server Error $code";
      $code = 599;
    } else { // not error
      header('Location: /index.php');
      exit;
    }
    break;
}

$act = 1; // enable postfixing the $verb to the <title> and the <h2> title
$verb = "$code: $status";

// start and <head> tags
get_page_sect_head();

// top of page
get_page_sect_top();

?>
      <h4><?php echo $desc; ?></h4>
      
      <p>Requested page: <b><?php echo utf8_decode(urldecode($_SERVER['REQUEST_URI'])); ?></b></p>
<?php

switch ($code) {
  case 400: // bad request
?>
      <p>Possible reasons for this error:</p>
      
      <ul>
        <li>You have provided a malformed URL to the server.</li>
      </ul>
<?php
    break;
  case 401: // unauthorized
?>
      <p>Possible reasons for this error:</p>
      
      <ul>
        <li>You are not authorized to access this page.</li>
        <li>You have provided the wrong username and/or password.</li>
        <li>You cancelled the credentials prompt.</li>
      </ul>
<?php
    break;
  case 402: // payment required
    break;
  case 403: // forbidden
?>
      <p>Possible reasons for this error:</p>
      
      <ul>
        <li>This page was purposely made private.</li>
      </ul>
<?php
    break;
  case 404: // not found
?>
      <p>Possible reasons for this error:</p>
      
      <ul>
        <li>You have followed a broken link.</li>
        <li>You have mistyped a URL to an existing page.</li>
      </ul>
<?php
    break;
  case 410: // gone
?>
      <p>Possible reasons for this error:</p>
      
      <ul>
        <li>This page has moved locations.</li>
        <li>You have followed an old, broken link.</li>
        <li>You have followed an outdated bookmark.</li>
        <li>You have mistyped a URL to an existing page.</li>
      </ul>
<?php
    break;
  case 500: // internal server error
?>
      <p>Possible reasons for this error:</p>
      
      <ul>
        <li>The server is misconfigured to handle your request.</li>
      </ul>
<?php
    break;
  case 503: // internal server error
?>
      <p>Possible reasons for this error:</p>
      
      <ul>
        <li>The server is being overloaded.</li>
      </ul>
<?php
    break;
  default:
    break;
}
?>
      <p>What to do now:</p>
      
      <ul>
        <?php echo $specific_wtdn; ?>
        <li>Go back to the page that brought you here.</li>
        <li>Navigate to a page on the left sidebar.</li>
        <li>Contact the webmaster at <b>nmbook@sunfiregold.com</b>.</li>
      </ul>
      
      <p>
        The erroneous request will be logged in order to help identify possible broken links
        or other problems with our site.
      </p>
<?php

// bottom of page
get_page_sect_bottom();

?>