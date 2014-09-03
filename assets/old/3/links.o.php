<?php

$templ_page_valid = TRUE;

$filemtime = mktime(0, 0, 0, 8, 18, 2009);

include('style/templ.php');

// start and <head> tags
get_page_sect_head();

// top of page
get_page_sect_top();

?>
      <h2>Links</h2>

      <hr />

      <dl>
        <dt><a href="http://www.k9data.com/" target="_blank" title="K9Data">K9Data</a></dt>
          <dd>URL: www.k9data.com</dd>
        <dt><a href="http://www.grca.org/" target="_blank" title="Golden Retriever Club of America">Golden Retriever Club of America</a></dt>
          <dd>URL: www.grca.org</dd>
        <dt><a href="http://www.sbgrc.org/" target="_blank" title="Southern Berkshire Golden Retriever Club">Southern Berkshire Golden Retriever Club</a></dt>
          <dd>URL: www.sbgrc.org</dd>
        <dt><a href="http://www.offa.org/" target="_blank" title="The Orthopedic Foundation for Animals">The Orthopedic Foundation for Animals</a></dt>
          <dd>URL: www.offa.org</dd>
        <dt><a href="http://web.me.com/comstock/Site/Welcome.html" target="_blank" title="Comstock Golden Retrievers">Comstock Golden Retrievers</a></dt>
          <dd>URL: web.me.com/comstock/Site/Welcome.html</dd>
        <dt><a href="http://www.ambertrail.com/" target="_blank" title="Ambertrail">Ambertrail</a></dt>
          <dd>URL: www.ambertrail.com</dd>
        <dt><a href="http://www.undeniablegoldens.com/" target="_blank" title="Undeniable Goldens">Undeniable Goldens</a></dt>
          <dd>URL: www.undeniablegoldens.com</dd>
        <dt><a href="http://www.golddreamgoldens.com/" target="_blank" title="Gold Dream Golden Retrievers">Gold Dream Golden Retrievers</a></dt>
          <dd>URL: www.golddreamgoldens.com</dd>
        <!--<dt><a href="http://www.myfloridadog.org/casanova/" target="_blank" title="Casanova Goldens">Casanova Goldens</a></dt>
          <dd>URL: www.myfloridadog.org/casanova/</dd>-->
      </dl>
    </div>
<?php

// bottom of page
get_page_sect_bottom();

?>