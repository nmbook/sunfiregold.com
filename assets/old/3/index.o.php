<?php

$templ_page_valid = TRUE;

include_once('style/templ.php');

$filemtime = mktime(0, 0, 0, 8, 8, 2009);

// start and <head> tags
get_page_sect_head();

// top of page
get_page_sect_top();

?>
      <h1>Welcome!</h1>

      <hr />

      <p class="leftbold">
        Golden Retrievers bred for soundness, trainability, retrieving instinct, and the desire to please.<br />
        Since 1971.
      </p>
      
      <hr />

      <h3>Breeze and Nate</h3>
      
      <img src="album/breeze/frontpage.jpg" />
      
      <p class="leftbold">
        This is Breeze and Nate at the Big E in September, 2007 after winning Reserve Highest Scoring Off-Leash Obedience in the 4-H dog show.<br />
        <a href="albums.html#album_breeze" title="Breeze">View more Breeze images.</a>
      </p>
    </div>
<?php

// bottom of page
get_page_sect_bottom();

?>