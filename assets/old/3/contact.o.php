<?php

$templ_page_valid = TRUE;

include_once('style/templ.php');

$filemtime = mktime(0, 0, 0, 8, 8, 2009);

// start and <head> tags
get_page_sect_head();

// top of page
get_page_sect_top();

?>
      <h2>Contact Us</h2>

      <hr />

      <dl>
        <dt>E-mail:&nbsp;&nbsp;&nbsp;<script type="text/javascript">document.writeln("<a href=\"mail" + "to:" + "sunfiregold" + String.fromCharCode(64) + "yahoo" + "." + "com\" target=\"_blank\" title=\"sunfiregold" + String.fromCharCode(64) + "yahoo" + "." + "com\">");</script>Sunfire Golden Retrievers<script type="text/javascript">document.writeln("<\/a>");</script></dt>
          <dd>Address: <script type="text/javascript">document.writeln("sunfiregold" + String.fromCharCode(64) + "yahoo" + "." + "com");</script></dd>

        <dt>Telephone Number:&nbsp;&nbsp;&nbsp;(860)-668-6143</dt>

        <dt>Fax Number:&nbsp;&nbsp;&nbsp;(503)-218-8111</dt>
      </dl>
    </div>
<?php

// bottom of page
get_page_sect_bottom();

?>