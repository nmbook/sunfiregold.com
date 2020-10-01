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
      <style> .cen-il-fr { display: inline; vertical-align: middle; border: 3px outset #008; } </style>

      <h1>Welcome!</h1>

      <p style="text-align: center;">
        Golden Retrievers bred for soundness, trainability, retrieving instinct, and the desire to please. &nbsp;Since 1971.
      </p>
      
      <hr />

      <h3>Thor Dock Diving</h3>

      <img class="cen-il-fr" src="util/thumb.php?src=../albums/thordock2016/thor dock diving.jpg&conv=view1024" alt="Thor Dock Diving" />
      
      <hr />

      <h3>SUNFIRE is 2014 AKC Breeder of the Year for Obedience!</h3>

      <a href="albums.php?id=63#img_1"><img class="cen-il-fr" width="320" src="util/thumb.php?src=../albums/botyob2014/letter.jpg&conv=thumbsq320" alt="AKC Letter acknowledging Breeder of the Year in Obedience for 2014" /></a>
      <a href="albums.php?id=63#img_2"><img class="cen-il-fr" width="320" src="util/thumb.php?src=../albums/botyob2014/family.JPG&conv=thumbsq320" alt="Babara, Michael, and Ripley x Indigo puppy, with rosette" /></a>
      <a href="albums.php?id=63#img_3"><img class="cen-il-fr" width="320" src="util/thumb.php?src=../albums/botyob2014/rosette.jpg&conv=thumbsq320" alt="Rosette in shadow box" /></a>

      <p>This is also a reflection of the dedication and talent of the many people who have trusted our breeding program and accomplished amazing things with our puppies. &nbsp;We must also acknowledge the contribution of the stud dogs and their owners that made such an impact on our breeding program.</p>
      
      <hr />
      
      <h3>Sunfire Puppies Slideshow</h3>
      
      <p>Jodie Broussard shared this video compilation of some puppy pictures!</p>
      
      <iframe class="cen-il-fr" title="YouTube video player" width="480" height="360" src="https://www.youtube.com/embed/30AvudaCiGs?rel=0" frameborder="0" allowfullscreen></iframe>
      
      <hr />
      
      <h3>Breeze Puppy and Annabeth</h3>
      
      <img width="640" class="cen-il-fr" src="util/thumb.php?src=../albums/brinksxbreeze-12/IMG_9866.jpg&conv=thumbsq640" alt="Brinks and Breeze Puppy Looking at Annabeth" />
      
      <p>Annabeth and Brinks and Breeze Puppy watching each other, wondering who the other is.</p>
      
      <!--h3>Eddy</h3>
      
      <img src="albums/honordogs/Master%20National%202011%20218.jpg" alt="Claire and Eddy next to Master National AKC Logo Sign" />
      
      <p class="leftbold">
        <?php echo stml_parse('{dog|201|2} qualified to run in the Master National!  He and Claire went in October 2011.  Eddy is a brother to Breeze.'); ?>
      </p-->
      
      <hr />
      
      <h3>Sunfire's Honor Roll</h3>
      
      <p>Check out the <a href="honordogs.php">Sunfire’s Honor Roll</a> page! &nbsp;This page lists dogs that have achieved high levels in show, field, obedience, and agility as well as outstanding producers.</p>
      
      <hr />
      
      <h3>Chloe Puppies Howling</h3>
      
      <iframe class="cen-il-fr" title="YouTube video player" width="480" height="360" src="https://www.youtube.com/embed/GmkjtrgSD2w?rel=0" frameborder="0" allowfullscreen></iframe>
      
      <hr />

      <h3>Breeze and Nate</h3>
      
      <img class="cen-il-fr" src="util/thumb.php?src=../albums/breeze/frontpage.jpg&conv=view1024" alt="Nate and Breeze with reserve trophy and ribbon at Big E" />
      
      <p class="leftbold">
        This is Breeze and Nate at the Big E in September, 2007 after winning Reserve Highest Scoring Off-Leash Obedience in the 4-H dog show.<br />
        <a href="albums/breeze/" title="Breeze">View more Breeze images.</a>
      </p>
<?php

// bottom of page
get_page_sect_bottom();
