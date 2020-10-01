<?php

$templ_page_valid = TRUE;

include_once('util/incl.php');

//db_connect();

check_session();

$submit = isset($_GET['submit']) ? $_GET['submit'] : 0;
$referer = isset($_GET['referer']) ? $_GET['referer'] : '';
$logout = isset($_GET['out']) ? $_GET['out'] : 0;
if ($submit) {
  $username = isset($_POST['username']) ? $_POST['username'] : '';
  $password = isset($_POST['password']) ? $_POST['password'] : '';
  if (start_session($username, $password)) {
    show_message("Welcome $account[full_name], you have signed in.", 'notice');
    if (strlen($referer) > 0 && $referer != 'identify.php') {
      header("Location: /$referer");
    } else {
      header("Location: /");
    }
    exit();
  } else {
    show_message('Incorrect username or password.', 'error');
  }
} elseif ($logout) {
  if ($is_signed_in) {
    end_session();
    if (strlen($referer) > 0 && $referer != 'identify.php') {
      header("Location: /$referer?_msg=out");
    } else {
      header("Location: /index.php?_msg=out");
    }
    exit();
  } else {
    show_message('You were not signed in!', 'error');
  }
}

// start and <head> tags
get_page_sect_head();

// top of page
get_page_sect_top();

?>
      <form method="post" action="identify.php?submit=1&referer=<?php echo $referer; ?>">
        <label for="username">Username:</label>
        <input name="username" type="text">
        <label for="password">Password:</label>
        <input name="password" type="password">
        <div class="input_button_wrapper">
          <input type="button" value="Cancel" class="cancel" href="<?php echo $referer; ?>">
          <input type="submit" value="Sign In" class="submit">
        </div>
      </form>
<?php

// bottom of page
get_page_sect_bottom();
