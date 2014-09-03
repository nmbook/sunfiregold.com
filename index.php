<?php

$templ_page_valid = TRUE;

include_once('util/incl.php');

db_connect();

check_session();

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
      
      <h3>Sunfire Puppies Slideshow</h3>
      
      <p>Jodie Broussard shared this video compilation of some puppy pictures!</p>
      
      <iframe title="YouTube video player" width="480" height="360" src="http://www.youtube.com/embed/30AvudaCiGs?rel=0" frameborder="0" allowfullscreen></iframe>
      
      <hr />
      
      <h3>Breeze Puppy and Annabeth</h3>
      
      <img width="640" src="albums/brinksxbreeze-12/IMG_9866.jpg" alt="Brinks and Breeze Puppy Looking at Annabeth" />
      
      <p>Annabeth and Brinks and Breeze Puppy watching each other, wondering who the other is.</p>
      
      <!--h3>Eddy</h3>
      
      <img src="albums/honordogs/Master%20National%202011%20218.jpg" alt="Claire and Eddy next to Master National AKC Logo Sign" />
      
      <p class="leftbold">
        <?php echo stml_parse('{dog|201|2} qualified to run in the Master National!  He and Claire went in October 2011.  Eddy is a brother to Breeze.'); ?>
      </p-->
      
      <hr />
      
      <h3>Sunfire's Honor Roll</h3>
      
      <p>Check out the new <a href="honordogs.php">Sunfire's Honor Roll</a> page! This page lists dogs who have achieved in show, field, agility, or obedience.</p>
      
      <hr />
      
      <h3>Chloe Puppies Howling</h3>
      
      <iframe title="YouTube video player" width="480" height="360" src="http://www.youtube.com/embed/GmkjtrgSD2w?rel=0" frameborder="0" allowfullscreen></iframe>
      
      <hr />

      <h3>Breeze and Nate</h3>
      
      <img src="albums/breeze/frontpage.jpg" alt="Nate and Breeze with reserve trophy and ribbon at Big E" />
      
      <p class="leftbold">
        This is Breeze and Nate at the Big E in September, 2007 after winning Reserve Highest Scoring Off-Leash Obedience in the 4-H dog show.<br />
        <a href="albums/breeze/" title="Breeze">View more Breeze images.</a>
      </p>
<?php

// bottom of page
get_page_sect_bottom();

?>