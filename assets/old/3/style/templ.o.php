<?php

if (!isset($templ_page_valid)) {
  header('Location: /../');
  exit();
}

function get_page_file_name() {
  $r_uri = $_SERVER['REQUEST_URI'];
  $start = strpos($r_uri, '/');
  return substr($r_uri, $start + 1, -4);
}

function get_page_name() {
  switch (get_page_file_name()) {
    case 'albums': return 'Albums';
    case 'contactus': return 'Contact Us';
    case 'ourdogs': return 'Our Dogs';
    case 'stories': return 'Stories';
    case 'pedigrees': return 'Pedigrees';
    case 'links': return 'Links';
    case 'litters': return 'Litters';
    default: return 'Home and News';
  }
}

function get_page_last_edit() {
  $filemtime = filemtime(get_page_file_name() . '.php');
  return date('l, F j, Y', $filemtime);
}

function get_page_sect_head() {
?>
<!--
 - Sunfire Golden Retrievers - <?php echo(get_page_name()); ?> -
 - Last Edited on: <?php echo(get_page_last_edit()); ?> -
 - Nate Book -
-->
<!DOCTYPE html>
<html>
  <head>
    <title>Sunfire Golden Retrievers - <?php echo(get_page_name()); ?></title>
<?php
if (get_page_file_name == 'index') {
?>
    <!-- Search Engine Information -->
    <meta name="keywords" content="Sunfire,golden retriever,golden retrievers,dog,dogs,puppy,puppies,Sunfire Golden Retrievers,SunfireGold" />
    <meta name="description" content="This is the Sunfire Golden Retrievers homepage" />
<?php
}
?>

    <!-- Page Links -->
    <link href="style/style.css" rel="stylesheet" type="text/css" />
  </head>
<?php
}

function get_page_sect_top() {
?>
  <body>
    <a name="Top"></a>
<?php
// page navigation
get_page_sect_nav();
?>  
    <div class="main">
      <a href="index.html">
        <img src="style/logo.png" alt="Sunfire Golden Retrievers Logo; Link Home; from Suffield, Connecticut" title="Sunfire Golden Retrievers, from Suffield, Connecticut" />
      </a>
<?php
}

function get_page_sect_nav() {
?>
    <div class="nav">
      <h5>Navigation</h5>

      <a href="index.php" title="Home and News">Home</a>
      <a href="albums.php" title="Albums">Albums</a>
      <a href="stories.php" title="Stories">Stories</a>
      <a href="litters.php" title="Litters">Litters</a>
      <a href="pedigrees.php" title="Pedigrees">Pedigrees</a>
      <a href="ourdogs.php" title="Our Dogs">Our Dogs</a>
      <a href="links.php" title="Links">Links</a>
      <a href="contact.php" title="Contact">Contact</a>
    </div>
<?php
}

function get_page_sect_bottom() {
?>
    <div class="bottom">
      <a href="#Top" title="Go to the top of the page.">Top</a>
      <p>This page was last modified on <?php echo(get_page_last_edit()); ?>.</p>
    </div>
  </body>
</html>
<?php
}
?>