<?php

if (!isset($templ_page_valid)) {
  header('Location: /');
  exit();
}

$_SESSION['messages'] = array();

// this will show a message to the screen.
// if the page is not loaded, then save messages until it is
// type is any class-name that will be applied to the message as well as class-name "message"
function show_message($msg, $type = 'error') {
  global $templ_page_body_ready; // var comes from templ.php
  global $messages;
  if ($templ_page_body_ready) {
    // print
?>
<div class="message <?php echo $type; ?>"><?php echo $msg; ?></div>
<?php
  } else {
    // store
    $_SESSION['messages'][] = array('msg' => $msg, 'type' => $type);
  }
}

// this will call show_message for every stored message,
// only if it will succeed, then clears stored messages.
function dump_messages() {
  global $templ_page_body_ready; // var comes from templ.php
  global $messages;
  if ($templ_page_body_ready) {
    if (isset($_SESSION['messages'])) {
      for ($i = 0; $i < count($_SESSION['messages']); $i++) {
        show_message($_SESSION['messages'][$i]['msg'], $_SESSION['messages'][$i]['type']);
      }
    }
    // clear array
    $_SESSION['messages'] = array();
    if (isset($_GET['_msg']) &&
        $_GET['_msg'] == 'out') {
      show_message("You have signed out.", 'notice');
    }
  } // else do nothing
}
?>
