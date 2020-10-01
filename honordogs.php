<?php

$templ_page_valid = TRUE;

include_once('util/incl.php');

//db_connect();

check_session();

// start and <head> tags
get_page_sect_head();

// top of page
get_page_sect_top();

?>
      <p>
        These dogs are dogs from our breeding who have made significant
        achievements in show, field, agility, or obedience.
      </p>
      <p>
        Also listed are dogs who have the
        <abbr title="GRCA Outstanding Sire">OS</abbr> or the
        <abbr title="GRCA Outstanding Dam">OD</abbr> title or who
        have lived a long, healthy life.  Dogs marked with
        <span class="honor_age honor_age_no_titletext">&bull;</span>
        have lived for 14 years, and dogs marked with
        <span class="honor_age honor_age_no_titletext">&bull;&bull;</span>
        have lived for 15 years or more.
      </p>
      <hr />
<?php

$order_by = '`date_birth` ASC';
$return_to = 'honordogs';
$where = "`honor_cat` = 'LIST'";
$header_text = "Sunfire's Honor Roll";
$dogs = api_dogs_list($DBCONN, '', '', 1000, 0, $where, $order_by, 3, $header_text, $return_to);
echo $dogs['html'];

// bottom of page
get_page_sect_bottom();
