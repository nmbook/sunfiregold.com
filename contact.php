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

      <dl>
        <dt>E-mail:&nbsp;&nbsp;<script type="text/javascript">document.writeln("<a href=\"mail" + "to:" + "sunfiregold" + String.fromCharCode(64) + "yahoo" + "." + "com\" target=\"_blank\" title=\"sunfiregold" + String.fromCharCode(64) + "yahoo" + "." + "com\">");</script>Sunfire Golden Retrievers<script type="text/javascript">document.writeln("<\/a>");</script></dt>
          <dd>Address:&nbsp;&nbsp;<script type="text/javascript">document.writeln("sunfiregold" + String.fromCharCode(64) + "yahoo" + "." + "com");</script></dd>

        <dt>Telephone Number:&nbsp;&nbsp;860-668-6143</dt>

        <dt>Fax Number:&nbsp;&nbsp;860-683-6016</dt>
      </dl>
<?php

// bottom of page
get_page_sect_bottom();
