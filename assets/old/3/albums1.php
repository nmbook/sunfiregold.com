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
    <script type="text/javascript">
      //this file makes it easy to modify common objects all at once//

      //THIS stores all the album info an array of arrays//
      /* how it is stuctured
      * albums {
      *     album_1 {
      *         internal_album_name,
      *         external_album_name,
      *         album_datetime,
      *         pictures {
      *             picture_1_data {
      *                 picture_sdesc,
      *                 picture_ldesc,
      *                 picture_datetime,
      *                 [picture_source = "picture_number.png"], //if = ".jpg" then = "picture_number.jpg"
      *                 [widthxheight = "640x480"]
      *             },
      *             picture_2_data {},
      *         }
      *     },
      *     album_2 {},
      *             etc
      *     etc
      * }
      */
      {
      var albums;
      albums = new Array (
        new Array (
          "darwinxalley-10-2",
          "Darwin and Alley Puppies",
          "March 2010",
          new Array (
            new Array (
              "Running",
              "Two puppies running",
              "March 27, 2010",
              "DSCF0169.JPG"
            ),
            new Array (
              "Running To Me",
              "All three puppies in view",
              "March 27, 2010",
              "DSCF0172.JPG"
            ),
            new Array (
              "Playing",
              "",
              "March 27, 2010",
              "DSCF0174.JPG"
            ),
            new Array (
              "Puppy's Head",
              "Picture of a puppy's head",
              "March 27, 2010",
              "DSCF0175.JPG"
            ),
            new Array (
              "Another Puppy's Head",
              "",
              "March 27, 2010",
              "DSCF0176.JPG"
            ),
            new Array (
              "Standing",
              "Close-up of puppy standing on a table",
              "March 27, 2010",
              "DSCF0177.JPG"
            ),
            new Array (
              "Sitting",
              "",
              "March 27, 2010",
              "DSCF0178.JPG"
            ),
            new Array (
              "Sitting",
              "Side of head",
              "March 27, 2010",
              "DSCF0179.JPG"
            )
          )
        ),
        new Array (
          "darwinxalley-10",
          "Darwin and Alley Puppies",
          "Winter 2010",
          new Array (
            new Array (
              "Getting ready for Valentine's Day",
              "Females",
              "February 6, 2010",
              "0206102033b.jpg"
            ),
            new Array (
              "Five puppies",
              "",
              "February 6, 2010",
              "0206102035.jpg"
            ),
            new Array (
              "Following tracks",
              "",
              "February 27, 2010",
              "0227101426.jpg"
            ),
            new Array (
              "Playing outside",
              "",
              "February 27, 2010",
              "0227101428.jpg"
            ),
            new Array (
              "Grabbing a stick",
              "",
              "February 27, 2010",
              "0227101428a.jpg"
            ),
            new Array (
              "Tracks",
              "",
              "February 27, 2010",
              "0227101428b.jpg"
            ),
            new Array (
              "Walking down the driveway",
              "Mud season",
              "February 27, 2010",
              "0227101429a.jpg"
            ),
            new Array (
              "Jumping out of the mud",
              "",
              "February 27, 2010",
              "0227101429b.jpg"
            ),
            new Array (
              "Stick in the snow",
              "",
              "February 27, 2010",
              "0227101431.jpg"
            ),
            new Array (
              "Running",
              "",
              "February 27, 2010",
              "0227101431a.jpg"
            ),
            new Array (
              "Running in a winter wonderland",
              "",
              "February 27, 2010",
              "0227101432.jpg"
            ),
            new Array (
              "Happily running",
              "",
              "February 27, 2010",
              "0227101432c.jpg"
            ),
            new Array (
              "Catching up",
              "",
              "February 27, 2010",
              "0227101433a.jpg"
            ),
            new Array (
              "Dry rug",
              "",
              "February 27, 2010",
              "0227101434.jpg"
            ),
            new Array (
              "Sitting",
              "",
              "February 27, 2010",
              "0227101434a.jpg"
            ),
            new Array (
              "Following tracks",
              "",
              "February 27, 2010",
              "0227101426.jpg"
            )
          )
        ),
        new Array (
          "missixtank-09",
          "Tank and Mississippi Puppies",
          "October 2009",
          new Array (
            new Array (
              "Big Boy and Little Girl",
              "",
              "October 15, 2009",
              "DSC_0938.JPG"
            ),
            new Array (
              "Puppy Profile",
              "",
              "October 15, 2009",
              "DSC_0943.JPG"
            ),
            new Array (
              "Funny Puppy",
              "",
              "October 15, 2009",
              "DSC_0949.JPG"
            ),
            new Array (
              "\"What's Going On?\"",
              "",
              "October 15, 2009",
              "DSC_0952.JPG"
            ),
            new Array (
              "\"We're Watching You\"",
              "",
              "October 15, 2009",
              "DSC_0953.JPG"
            )
          )
        ),
        new Array (
          "summerlitters-09",
          "Summer Litters 2009",
          "August 2009",
          new Array (
            new Array (
              "Cherokee with Bumper",
              "",
              "August 20, 2009",
              "DSC00873.JPG"
            ),
            new Array (
              "Cherokee Lying Down",
              "",
              "August 20, 2009",
              "DSC00874.JPG"
            ),
            new Array (
              "Cherokee Standing",
              "",
              "August 20, 2009",
              "DSC00875.JPG"
            ),
            new Array (
              "Puppies Running",
              "",
              "August 20, 2009",
              "DSC00877.JPG"
            ),
            new Array (
              "Puppies in the Water",
              "",
              "August 20, 2009",
              "DSC00884.JPG"
            ),
            new Array (
              "Puppies Coming Out of the Water",
              "",
              "August 20, 2009",
              "DSC00885.JPG"
            ),
            new Array (
              "Puppies in the Water 2",
              "",
              "August 20, 2009",
              "DSC00886.JPG"
            ),
            new Array (
              "Puppies in the Water Playing",
              "",
              "August 20, 2009",
              "DSC00887.JPG"
            ),
            new Array (
              "Where Did Everyone Else Go?",
              "",
              "August 20, 2009",
              "DSC00888.JPG"
            ),
            new Array (
              "Cooperative Bumper Carrying",
              "",
              "August 20, 2009",
              "DSC00889.JPG"
            ),
            new Array (
              "A Puppy Standing Nice",
              "",
              "August 20, 2009",
              "DSC00890.JPG"
            ),
            new Array (
              "Playing in the Water Until Muddy",
              "",
              "August 20, 2009",
              "DSC00891.JPG"
            ),
            new Array (
              "Swimming Like a Fish",
              "",
              "August 20, 2009",
              "DSC00893.JPG"
            ),
            new Array (
              "Two Puppies Follow in the Water",
              "",
              "August 20, 2009",
              "DSC00894.JPG"
            ),
            new Array (
              "All Five as a Herd",
              "",
              "August 20, 2009",
              "DSC00895.JPG"
            ),
            new Array (
              "Two of the Herd",
              "",
              "August 20, 2009",
              "DSC00896.JPG"
            ),
            new Array (
              "Swimming Like a Fish",
              "",
              "August 20, 2009",
              "DSC00897.JPG"
            ),
            new Array (
              "Puppies Swimming Like Ducklings",
              "",
              "August 20, 2009",
              "DSC00898.JPG"
            ),
            new Array (
              "Swim to Catch Up!",
              "",
              "August 20, 2009",
              "DSC00899.JPG"
            ),
            new Array (
              "Waiting for Two",
              "",
              "August 20, 2009",
              "DSC00901.JPG"
            ),
            new Array (
              "Let's Go See the Guy on Land",
              "",
              "August 20, 2009",
              "DSC00902.JPG"
            ),
            new Array (
              "Puppies Running",
              "",
              "August 20, 2009",
              "DSC00903.JPG"
            ),
            new Array (
              "Lying Down to Dry Off",
              "",
              "August 20, 2009",
              "DSC00904.JPG"
            ),
            new Array (
              "Time To Go Again?",
              "",
              "August 20, 2009",
              "DSC00905.JPG"
            ),
            new Array (
              "Cooperative Bumper Carrying Again",
              "",
              "August 20, 2009",
              "DSC00906.JPG"
            ),
            new Array (
              "Coming from the Distance",
              "",
              "August 20, 2009",
              "DSC00908.JPG"
            ),
            new Array (
              "But I Wanted It!",
              "",
              "August 20, 2009",
              "DSC00909.JPG"
            ),
            new Array (
              "Look What I Have!",
              "",
              "August 20, 2009",
              "DSC00910.JPG"
            ),
            new Array (
              "Puppy Picking Up Bumper",
              "",
              "August 20, 2009",
              "DSC00911.JPG"
            ),
            new Array (
              "Two Puppies",
              "Puppy with bumper by the string",
              "August 20, 2009",
              "DSC00914.JPG"
            ),
            new Array (
              "Puppy Holding Red Bumper",
              "",
              "August 20, 2009",
              "DSC00915.JPG"
            ),
            new Array (
              "I Want That!",
              "",
              "August 20, 2009",
              "DSC00916.JPG"
            ),
            new Array (
              "I Want the White One Too!",
              "",
              "August 20, 2009",
              "DSC00917.JPG"
            ),
            new Array (
              "Puppies Fighting Over Bumper",
              "",
              "August 20, 2009",
              "DSC00918.JPG"
            ),
            new Array (
              "Puppy Holding White Bumper",
              "",
              "August 20, 2009",
              "DSC00919.JPG"
            ),
            new Array (
              "Cullen x Kimber \"Pink\" Female's Trying to Pick it Up",
              "",
              "August 20, 2009",
              "DSC00921.JPG"
            ),
            new Array (
              "\"Pink\" Got the Bird",
              "",
              "August 20, 2009",
              "DSC00920.JPG"
            ),
            new Array (
              "\"Pink\" Got It",
              "",
              "August 20, 2009",
              "DSC00922.JPG"
            ),
            new Array (
              "\"Pink\" Is Not So Sure About the Duck",
              "",
              "August 20, 2009",
              "DSC00923.JPG"
            ),
            new Array (
              "Darwin x Allie Male \"Chuckie\" Finding Bird",
              "",
              "August 20, 2009",
              "DSC00924.JPG"
            ),
            new Array (
              "\"Chuckie\" Found It",
              "",
              "August 20, 2009",
              "DSC00925.JPG"
            ),
            new Array (
              "\"Chuckie\" Trying to Pick Up Bird",
              "",
              "August 20, 2009",
              "DSC00926.JPG"
            ),
            new Array (
              "\"Chuckie\" Still Trying to Pick Up Bird",
              "",
              "August 20, 2009",
              "DSC00927.JPG"
            ),
            new Array (
              "\"Chuckie\" Got The Bird",
              "",
              "August 20, 2009",
              "DSC00928.JPG"
            ),
            new Array (
              "\"Chuckie\" Bringing The Bird",
              "",
              "August 20, 2009",
              "DSC00929.JPG"
            ),
            new Array (
              "\"Chuckie\" Bringing The Bird Again",
              "",
              "August 20, 2009",
              "DSC00930.JPG"
            ),
            new Array (
              "\"Chuckie\" Bringing The Bird One More Time",
              "",
              "August 20, 2009",
              "DSC00931.JPG"
            ),
            new Array (
              "\"Chuckie\" Swimming",
              "",
              "August 20, 2009",
              "DSC00932.JPG"
            ),
            new Array (
              "Cullen x Kimber \"Purple\" Male's Got The Bird",
              "",
              "August 20, 2009",
              "DSC00933.JPG"
            ),
            new Array (
              "\"Purple\" Bringing The Bird",
              "",
              "August 20, 2009",
              "DSC00934.JPG"
            ),
            new Array (
              "\"Purple\" Bringing The Duck",
              "",
              "August 20, 2009",
              "DSC00935.JPG"
            ),
            new Array (
              "\"Purple\" Swimming",
              "",
              "August 20, 2009",
              "DSC00937.JPG"
            ),
            new Array (
              "\"Purple\" Finding The Duck",
              "",
              "August 20, 2009",
              "DSC00938.JPG"
            ),
            new Array (
              "We Were Watched By",
              "This red-tailed hawk",
              "August 20, 2009",
              "DSC00939.JPG"
            ),
            new Array (
              "Chiri x Indigo \"White\" Female Has a Tight Hold",
              "",
              "August 20, 2009",
              "DSC00940.JPG"
            ),
            new Array (
              "\"White\" Has Got the Duck",
              "",
              "August 20, 2009",
              "DSC00943.JPG"
            ),
            new Array (
              "\"White\" Trying to Get the Duck Again",
              "",
              "August 20, 2009",
              "DSC00944.JPG"
            ),
            new Array (
              "\"White\" Has Got the Duck Again",
              "",
              "August 20, 2009",
              "DSC00945.JPG"
            ),
            new Array (
              "\"White\" Carrying it in",
              "",
              "August 20, 2009",
              "DSC00946.JPG"
            ),
            new Array (
              "\"White\" Pulling it in",
              "",
              "August 20, 2009",
              "DSC00947.JPG"
            ),
            new Array (
              "Chiri x Indigo \"Blue\" Male Got the Bird",
              "",
              "August 20, 2009",
              "DSC00948.JPG"
            ),
            new Array (
              "\"Blue\" Won't Let Go Either",
              "",
              "August 20, 2009",
              "DSC00950.JPG"
            ),
            new Array (
              "\"Blue\" Got The Bird Again",
              "",
              "August 20, 2009",
              "DSC00951.JPG"
            ),
            new Array (
              "\"Blue\" Swimming",
              "",
              "August 20, 2009",
              "DSC00952.JPG"
            ),
            new Array (
              "\"Blue\" Swimming With The Duck",
              "",
              "August 20, 2009",
              "DSC00953.JPG"
            ),
            new Array (
              "\"Blue\" Got The Duck",
              "",
              "August 20, 2009",
              "DSC00954.JPG"
            ),
            new Array (
              "\"Blue\" Bringing it in",
              "",
              "August 20, 2009",
              "DSC00955.JPG"
            ),
            new Array (
              "\"Blue\" Bringing it in Again",
              "",
              "August 20, 2009",
              "DSC00956.JPG"
            ),
            new Array (
              "\"Blue\" Carrying the Duck",
              "",
              "August 20, 2009",
              "0820091330.jpg"
            ),
            new Array (
              "Five Summer Litter Puppies Together",
              "",
              "August 20, 2009",
              "0820091621.jpg"
            ),
            new Array (
              "Five Summer Litter Puppies Together",
              "",
              "August 20, 2009",
              "0820091621a.jpg"
            )
          )
        ),
        new Array (
          "breeze",
          "Breeze",
          "Breeze's lifetime",
          new Array (
            new Array (
              "Breeze at Seven Weeks",
              "front",
              "",
              "2.jpg"
            ),
            new Array (
              "Breeze at Seven Weeks",
              "side",
              "",
              "3.jpg"
            ),
            new Array (
              "Nate with Breeze",
              "",
              "",
              "0.jpg"
            ),
            new Array (
              "Dan with Breeze",
              "at five months old.",
              "",
              "1.jpg"
            ),
            new Array (
              "Breeze and Nate at the Big E",
              "This picture is on the front page of the website.",
              "September 2007",
              "frontpage.jpg",
              "640x905"
            ),
            new Array (
              "Breeze and Nate at Northwest Park",
              "Breeze stands to read the entrance sign to the Braille Trail (Bog Trail) at Northwest Park.",
              "May 25, 2008",
              "readingentrancesign.jpg",
              "640x480"
            ),
            new Array (
              "Breeze Reading Braille with Nate",
              "Breeze \"reads\" a Braille sign on the Braille Trail at Northwest Park.",
              "May 25, 2008",
              "readingbraillesign.jpg",
              "640x480"
            ),
            new Array (
              "Breeze Walking with Nate",
              "Breeze takes a walk on the Braille Trail at Northwest Park with Nate.",
              "May 25, 2008",
              "onawalk.jpg",
              "640x480"
            ),
            new Array (
              "Nate and Breeze for Nate's Senior Pictures",
              "",
              "June, 2009",
              "nate-breeze-school.png"
            ),
            new Array (
              "Breeze Coming out of Water",
              "",
              "August 20, 2009",
              "DSC00876.JPG"
            ),
            new Array (
              "Breeze Retrieving Duck",
              "",
              "August 20, 2009",
              "0820091335a.jpg"
            ),
            new Array (
              "Breeze Retrieving Duck Again",
              "",
              "August 20, 2009",
              "0820091336.jpg"
            )
          )
        ),
        new Array (
          "alliexdarwin-09",
          "Darwin and Allie Puppies",
          "August 2009",
          new Array(
            new Array(
              "Bill Biewer and Two Darwin Males",
              "Seven weeks old.",
              "August 9th 2009",
              "0809091442a.jpg"
            ),
            new Array(
              "Close-up of Two Darwin Males",
              "Seven weeks old.",
              "August 9th 2009",
              "0809091442.jpg"
            ),
            new Array(
              "Two Darwin Females",
              "Seven weeks old.",
              "August 9th 2009",
              "0809091446a.jpg"
            ),
            new Array(
              "Close-up of Two Darwin Females",
              "Seven weeks old.",
              "August 9th 2009",
              "0809091446.jpg"
            )
          )
        ),
        new Array (
          "shimmerxripple-08",
          "Ripple and Shimmer Puppies",
          "November 2008",
          new Array (
            new Array (
              "Sitting",
              "One Shimmer puppy sits alone.",
              "November 11, 2008",
              "1111081512.jpg"
            ),
            new Array (
              "Playing",
              "Two Shimmer puppies play together.",
              "November 11, 2008",
              "1111081513.jpg"
            ),
            new Array (
              "Running",
              "Three Shimmer puppies run and play.",
              "November 11, 2008",
              "1111081513b.jpg"
            ),
            new Array (
              "New Friend",
              "Five Shimmer puppies find a new friend.",
              "November 11, 2008",
              "1111081519.jpg"
            ),
            new Array (
              "Chewing",
              "Five Shimmer puppies lick, chew, and play with their new friend.",
              "November 11, 2008",
              "1111081518.jpg"
            ),
            new Array (
              "Climbing High",
              "More puppies are coming, one goes for the face.",
              "November 11, 2008",
              "1111081520.jpg"
            ),
            new Array (
              "Six",
              "More have learned of the friend.",
              "November 11, 2008",
              "1111081521.jpg"
            ),
            new Array (
              "Eight",
              "All eight are visible ...",
              "November 11, 2008",
              "1111081521a.jpg"
            ),
            new Array (
              "Unknown Doom",
              "... and getting ready for attack.",
              "November 11, 2008",
              "1111081521b.jpg"
            ),
            new Array (
              "Plots",
              "The puppies may appear to be losing interest, but ...",
              "November 11, 2008",
              "1111081523.jpg"
            ),
            new Array (
              "Surrounded",
              ".. they are strategizing; seven puppies in front, and the tail of one behind.",
              "November 11, 2008",
              "1111081522.jpg"
            ),
            new Array (
              "Down!",
              "Shimmer puppies have taken over.",
              "November 11, 2008",
              "1111081519a.jpg"
            ),
            new Array (
              "Play",
              "Puppies playing.",
              "December 6, 2008",
              "1206081217a.jpg"
            ),
            new Array (
              "Puppy",
              "One Shimmer puppy.",
              "December 6, 2008",
              "1206081218a.jpg"
            ),
            new Array (
              "On The Move",
              "Shimmer puppies running.",
              "December 6, 2008",
              "1206081220.jpg"
            ),
            new Array (
              "Sitting Still",
              "Puppy sitting still for the camera.",
              "December 6, 2008",
              "1206081222a.jpg"
            ),
            new Array (
              "Sitting Still 2",
              "",
              "December 6, 2008",
              "1206081222b.jpg"
            ),
            new Array (
              "Lost?",
              "Puppy looking lost.",
              "December 6, 2008",
              "1206081223a.jpg"
            )
          )
        ),
        new Array (
          "rockettextank-08",
          "Tank and Rockette Puppies",
          "August and September 2008",
          new Array (
            new Array (
              "A Litter of Two",
              "",
              "August 21, 2008",
              "0821081730.jpg"
            ),
            new Array (
              "Playing",
              "Playing on a hill",
              "August 31, 2008",
              "0831081623.jpg"
            ),
            new Array (
              "Running",
              "Running down a hill",
              "August 31, 2008",
              "0831081624.jpg"
            ),
            new Array (
              "Running 2",
              "Running towards the camara",
              "August 31, 2008",
              "0831081625.jpg"
            ),
            new Array (
              "Looking Away",
              "",
              "August 31, 2008",
              "0831081625a.jpg"
            ),
            new Array (
              "Running 3",
              "Running some more",
              "August 31, 2008",
              "0831081629.jpg"
            ),
            new Array (
              "Sitting on the Hill",
              "",
              "August 31, 2008",
              "0831081634.jpg"
            ),
            new Array (
              "Sitting on the Hill Closer",
              "",
              "August 31, 2008",
              "0831081634a.png"
            ),
            new Array (
              "Running Up the Hill Distance",
              "",
              "August 31, 2008",
              "0831081636.jpg"
            ),
            new Array (
              "Running Up the Hill Distance 2",
              "",
              "August 31, 2008",
              "0831081637.jpg"
            )
          )
        ),
        new Array (
          "echoxchiri-08_rockettextank-08",
          "Chiri and Echo Puppies with Tank and Rockette Female",
          "September 2008",
          new Array (
            new Array (
              "Puppy Stampede",
              "Here they come running!",
              "September 20, 2008",
              "0920081627.jpg"
            ),
            new Array (
              "Puppy Stampede 2",
              "Watch out camara man!",
              "September 20, 2008",
              "0920081627b.jpg"
            ),
            new Array (
              "Puppy Stampede 3",
              "Some have got him, and more are coming!",
              "September 20, 2008",
              "0920081628.jpg"
            ),
            new Array (
              "Puppies Playing",
              "The right-most puppy in this picture is the Tank and Rockette female",
              "September 20, 2008",
              "0920081636.jpg"
            ),
            new Array (
              "Puppy Looking Disgusted",
              "The puppy was probably chewing the grass...",
              "September 20, 2008",
              "0920081636a.jpg"
            ),
            new Array (
              "Three Puppy Play",
              "",
              "September 20, 2008",
              "0920081637.jpg"
            )
          )
        ),
        new Array (
          "echoxchiri-08",
          "Chiri and Echo Puppies",
          "August 2008",
          new Array (
            new Array (
              "Sleeping Pair",
              "Two of the puppies at four weeks.",
              "August 17, 2008",
              "puppies.jpg"
            ),
            new Array (
              "Sleeping Pair Close-Up",
              "Another two of the puppies sleeping.",
              "August 17, 2008",
              "puppiessleeping.jpg"
            ),
            new Array (
              "Resting",
              "You can count all eight puppies in the pile sleeping soundly.",
              "August 17, 2008",
              "puppies2.jpg"
            ),
            new Array (
              "Restless",
              "The puppies starting to mill around.",
              "August 17, 2008",
              "puppies3.jpg"
            ),
            new Array (
              "Resting Again",
              "All eight visible again, from above.",
              "August 17, 2008",
              "puppies4.jpg"
            ),
            new Array (
              "Restless Again",
              "Blonde puppy yawns and stretches.",
              "August 17, 2008",
              "puppiesyawn.jpg"
            ),
            new Array (
              "Close-Up",
              "One puppy from the pile.",
              "August 17, 2008",
              "puppyinpile.jpg"
            ),
            new Array (
              "Puppy Pile in Basket",
              "Sleeping at four and a half weeks.",
              "August 21, 2008",
              "puppypile.jpg"
            ),
            new Array (
              "Puppy Pile Getting Comfortable",
              "",
              "August 21, 2008",
              "puppypile2.jpg"
            ),
            new Array (
              "Puppy Pile",
              "",
              "August 21, 2008",
              "puppypile3.jpg"
            ),
            new Array (
              "Puppy Pile Again",
              "",
              "August 21, 2008",
              "puppypile4.jpg"
            ),
            new Array (
              "Single Puppy",
              "Under the umbrella and ready for a picture.",
              "August 21, 2008",
              "puppy.jpg"
            ),
            new Array (
              "Puppy",
              "Will it yawn?",
              "August 21, 2008",
              "puppy2.jpg"
            ),
            new Array (
              "Puppy Yawn",
              "Yes.",
              "August 21, 2008",
              "puppyyawn.jpg"
            )
          )
        ),
        new Array (
          "echo_chickie",
          "Echo and Chickie",
          "August 21, 2008",
          new Array (
            new Array (
              "Echo and Chickie Stand",
              "Two-year-old Echo and nine-year-old Chickie stand with the same expression and stance.",
              "August 21, 2008",
              "echoandchickie2.jpg"
            ),
            new Array (
              "Echo and Chickie Go Different Ways",
              "Echo looks up for a treat; Chickie sniffs the ground.",
              "August 21, 2008",
              "echoandchickie.jpg"
            ),
            new Array (
              "Sunfire's Rocky MT Chickadee \"Chickie\"",
              "Head View",
              "August 21, 2008",
              "chickie.jpg"
            ),
            new Array (
              "Sunfire's Echo of Cascade \"Echo\"",
              "Walking along...",
              "August 21, 2008",
              "echo.jpg"
            ),
            new Array (
              "Echo",
              "Walking along...",
              "August 21, 2008",
              "echo2.jpg"
            )
          )
        ),
        new Array (
          "chickiextank-08",
          "Tank and Chickie Puppies",
          "Spring 2008",
          new Array(
            new Array (
              "Two at Two Weeks Old",
              "",
              "Early April, 2008",
              "1.jpg",
              "640x480"
            ),
            new Array (
              "Another View",
              "Two Weeks",
              "Early April, 2008",
              "2.jpg",
              "640x480"
            ),
            new Array (
              "Looking Around",
              "Two Weeks",
              "Early April, 2008",
              "3.jpg",
              "640x480"
            ),
            new Array (
              "Happy",
              "Two Weeks",
              "Early April, 2008",
              "4.jpg",
              "640x480"
            ),
            new Array (
              "Maddie and New Owner",
              "Three Months",
              "Late June, 2008",
              "maddie_3mo_2.jpg",
              "640x480"
            ),
            new Array (
              "Maddie",
              "Three Months",
              "Late June, 2008",
              "maddie_3mo_1.jpg",
              "640x480"
            )
          )
        ),
        new Array (
          "bellexcullen-08",
          "Cullen and Belle Puppies",
          "Spring 2008",
          new Array (
            new Array (
              "Sleeping at Two Weeks",
              "",
              "Late March",
              "001_1.JPG",
              "640x427"
            ),
            new Array (
              "Two Piles of Four",
              "",
              "Late March",
              "002_2.JPG",
              "640x427"
            ),
            new Array (
              "Sleeping",
              "",
              "Late March",
              "003_3.JPG",
              "640x427"
            ),
            new Array (
              "Sleeping from Another Angle",
              "",
              "Late March",
              "004_4.JPG",
              "640x427"
            ),
            new Array (
              "Sleeping Close Up",
              "",
              "Late March",
              "005_5.JPG",
              "640x427"
            ),
            new Array (
              "Starting to Stand",
              "",
              "Late March",
              "006_6.JPG",
              "640x427"
            ),
            new Array (
              "Lying on the Back",
              "",
              "Late March",
              "007_7.JPG",
              "640x427"
            ),
            new Array (
              "Tired from Play",
              "",
              "Late March",
              "008_8.JPG",
              "640x427"
            ),
            new Array (
              "All Sleeping",
              "",
              "Late March",
              "009_9.JPG",
              "640x427"
            ),
            new Array (
              "Ready to be a Retriever",
              "",
              "Late March",
              "010_10.JPG",
              "640x427"
            ),
            new Array (
              "Sleeping in the Corner",
              "",
              "Late March",
              "011_11.JPG",
              "640x426"
            ),
            new Array (
              "Sleeping in the Corner",
              "from above",
              "Late March",
              "012_12.JPG",
              "640x427"
            ),
            new Array (
              "Sleeping Some More",
              "",
              "Late March",
              "013_13.JPG",
              "640x427"
            ),
            new Array (
              "Comfortable on My Back",
              "",
              "Late March",
              "014_14.JPG",
              "640x427"
            ),
            new Array (
              "Food Time!",
              "with Mother, Belle.",
              "Early April",
              "015_15.JPG",
              "640x427"
            ),
            new Array (
              "Nursing Some More",
              "",
              "Early April",
              "016_16.JPG",
              "640x427"
            ),
            new Array (
              "Eating",
              "",
              "Early April",
              "017_17.JPG",
              "640x427"
            ),
            new Array (
              "Eating a Lot",
              "",
              "Early April",
              "018_18.JPG",
              "640x427"
            ),
            new Array (
              "Eating Close Up",
              "",
              "Early April",
              "019_19.JPG",
              "640x427"
            ),
            new Array (
              "The Look",
              "",
              "Early April",
              "020_20.JPG",
              "640x427"
            ),
            new Array (
              "After-Food Nap",
              "",
              "Early April",
              "022_22.JPG",
              "640x427"
            ),
            new Array (
              "Sleeping in the Food",
              "",
              "Early April",
              "024_24.JPG",
              "640x427"
            ),
            new Array (
              "Sleeping in the Food, Close Up",
              "",
              "Early April",
              "023_23.JPG",
              "640x427"
            ),
            new Array (
              "The Cute Look",
              "",
              "Early April",
              "025_25.JPG",
              "640x427"
            ),
            new Array (
              "The Cute Look, Close Up",
              "",
              "Early April",
              "026_26.JPG",
              "640x457"
            ),
            new Array (
              "Early Playing",
              "",
              "Early April",
              "027_27.JPG",
              "640x427"
            ),
            new Array (
              "Playing More",
              "",
              "Early April",
              "028_28.JPG",
              "640x427"
            ),
            new Array (
              "Surprised",
              "",
              "Early April",
              "029_29.JPG",
              "640x427"
            ),
            new Array (
              "Getting Close and Comfortable",
              "",
              "Early April",
              "030_30.JPG",
              "640x427"
            )
          )
        ),
        new Array (
          "luxxripple-08",
          "Ripple and Lux Puppies",
          "Spring 2008",
          new Array (
            new Array (
                "Three Puppies Nursing",
                "at one week old",
                "March 8, 2008",
                "3puppies.jpg",
                "640x480"
            ),
            new Array (
                "Cute Newborn Puppies Close-Up",
                "",
                "March 8, 2008",
                "newborns.jpg",
                "640x480"
            ),
            new Array (
                "Cute Newborn Puppies Close-Up (2)",
                "",
                "March 8, 2008",
                "newborns2.jpg",
                "640x480"
            ),
            new Array (
                "Now at Five Weeks Old",
                "Sitting",
                "April 12, 2008",
                "puppies001.jpg",
                "640x480"
            ),
            new Array (
                "Sitting",
                "",
                "April 12, 2008",
                "puppies002.jpg",
                "640x480"
            ),
            new Array (
                "Playing",
                "",
                "April 12, 2008",
                "puppies003.jpg",
                "640x480"
            ),
            new Array (
                "Laughing",
                "",
                "April 12, 2008",
                "puppies004.jpg",
                "640x600"
            ),
            new Array (
                "Standing",
                "",
                "April 12, 2008",
                "puppies005.jpg",
                "640x632"
            ),
            new Array (
                "Happy",
                "",
                "April 12, 2008",
                "puppies006.jpg",
                "640x543"
            ),
            new Array (
                "Sniffing",
                "",
                "April 12, 2008",
                "puppies007.jpg",
                "640x690"
            ),
            new Array (
                "Sniffing More",
                "",
                "April 12, 2008",
                "puppies008.jpg",
                "640x544"
            ),
            new Array (
                "Sitting More",
                "",
                "April 12, 2008",
                "puppies009.jpg",
                "640x480"
            ),
            new Array (
                "Sitting Again",
                "",
                "April 12, 2008",
                "puppies011.jpg",
                "640x480"
            )
          )
        ),
        new Array (
          "hannahxspeedy-07",
          "Oscar at 5 months",
          "December 2007",
          new Array (
            new Array (
                "Oscar and Penny Climbing",
                "",
                "December 15, 2007",
                "1215071454a.jpg"
            ),
            new Array (
                "Oscar and Penny",
                "",
                "December 15, 2007",
                "1215071454b.jpg"
            ),
            new Array (
                "Oscar Standing",
                "",
                "December 15, 2007",
                "1215071455.jpg"
            ),
            new Array (
                "Oscar With Nate",
                "",
                "December 15, 2007",
                "1215071500.jpg"
            ),
            new Array (
                "Oscar With Nate",
                "",
                "December 15, 2007",
                "1215071502.jpg"
            ),
            new Array (
                "Oscar in the Snow",
                "",
                "December 15, 2007",
                "1215071504.jpg"
            ),
            new Array (
                "Oscar With Nate",
                "",
                "December 15, 2007",
                "1215071507a.jpg"
            ),
            new Array (
                "Oscar",
                "",
                "December 15, 2007",
                "1215071509.jpg"
            ),
            new Array (
                "Oscar Jumping",
                "",
                "December 15, 2007",
                "1215071512.jpg"
            ),
            new Array (
                "Oscar Sitting",
                "",
                "December 15, 2007",
                "1215071514.jpg"
            )
          )
        ),
        new Array (
          "summerlitters-07",
          "Summer Litters",
          "Summer 2007",
          new Array (
            new Array (
                "Party of five",
                "\"Oscar\", \"Tula\", \"Chloe\", \"Moose\", \"Drake\"",
                "September 23, 2007"
            )
          )
        ),
        new Array (
          "skyxdrake-07",
          "Sky and Drake Puppies",
          "Fall 2007",
          new Array (
            new Array (
                "Litter at 3 days old",
                "",
                "August 30, 2007"
            ),
            new Array (
                "Litter at 3 days old",
                "Close-up",
                "August 30, 2007"
            ),
            new Array (
                "Litter at 17 days old",
                "Eyes open",
                "September 13, 2007"
            ),
            new Array (
                "Puppies waking up",
                "17 days old",
                "September 13, 2007"
            ),
            new Array (
                "Chow Time",
                "",
                "September 13, 2007"
            ),
            new Array (
                "Range of color",
                "17 days old",
                "September 13, 2007"
            ),
            new Array (
                "Puppies at 26 days old",
                "wtih Grandma Angel",
                "September 22, 2007"
            ),
            new Array (
                "Puppies at 26 days old",
                "",
                "September 22, 2007"
            ),
            new Array (
                "Puppies at 26 days old",
                "",
                "September 22, 2007"
            ),
            new Array (
                "Puppies at 26 days old",
                "",
                "September 22, 2007"
            ),
            new Array (
                "Puppies at 26 days old",
                "",
                "September 22, 2007"
            ),
            new Array (
                "Puppies at 26 days old",
                "",
                "September 22, 2007"
            ),
            new Array (
                "Puppies at 26 days old",
                "",
                "September 22, 2007"
            )
          )
        ),
        new Array (
          "breezexbritain-07",
          "Breeze and Britain Puppies",
          "Summer 2007",
          new Array (
            new Array (
                "Two males",
                "",
                "July 15, 2007",
                ".jpg"
            ),
            new Array (
                "Three darker females",
                "",
                "July 15, 2007",
                ".jpg"
            ),
            new Array (
                "Two lighter females",
                "",
                "July 15, 2007",
                ".jpg"
            ),
            new Array (
                "One of the three darker females",
                "this one has a strange \"backwards mohawk\" where the hair stands up on either side of a flat streak on her head (this is the middle one on the other picture)",
                "July 15, 2007",
                ".jpg"
            ),
            new Array (
                "Breeze Puppy",
                "This puppy is now six weeks old.",
                "August 3, 2007",
                ".jpg"
            ),
            new Array (
                "Two Puppies",
                "",
                "August 3, 2007",
                ".jpg"
            ),
            new Array (
                "Galloping",
                "This puppy runs at full speed, and it appears to gallop.",
                "August 3, 2007",
                ".jpg"
            ),
            new Array (
                "Cute",
                "A Breeze puppy, cute.",
                "August 3, 2007",
                ".jpg"
            ),
            new Array (
                "Coming Out from Hiding",
                "",
                "August 3, 2007",
                ".jpg"
            ),
            new Array (
                "Relaxed",
                "",
                "August 3, 2007",
                ".jpg"
            ),
            new Array (
                "Relaxed in the Grass",
                "",
                "August 3, 2007",
                ".jpg"
            ),
            new Array (
                "Time to Run",
                "",
                "August 3, 2007",
                ".jpg"
            ),
            new Array (
                "Walking the Path",
                "",
                "August 4, 2007",
                ".jpg"
            ),
            new Array (
                "Sniffing the Grass",
                "",
                "August 4, 2007",
                ".jpg"
            ),
            new Array (
                "Walking",
                "",
                "August 4, 2007",
                ".jpg"
            ),
            new Array (
                "Playing on Her Back",
                "",
                "August 4, 2007",
                ".jpg",
                "642x856"
            ),
            new Array (
                "Back on Her Feet",
                "",
                "August 4, 2007",
                ".jpg"
            ),
            new Array (
                "Running to go Play",
                "",
                "August 4, 2007",
                ".jpg"
            ),
            new Array (
                "Playing by an Igloo",
                "",
                "August 4, 2007",
                ".jpg"
            ),
            new Array (
                "Two of the Puppies",
                "Here is the blondest in front and the reddest in back.",
                "August 4, 2007",
                ".jpg"
            ),
            new Array (
                "Looking Through the Grass",
                "",
                "August 4, 2007",
                ".jpg"
            ),
            new Array (
                "Running",
                "",
                "August 4, 2007",
                ".jpg"
            ),
            new Array (
                "Playing",
                "",
                "August 4, 2007",
                ".jpg"
            ),
            new Array (
                "Sniffing the Ground",
                "",
                "August 4, 2007",
                ".jpg"
            ),
            new Array (
                "Licking a Person",
                "",
                "August 4, 2007",
                ".jpg"
            )
          )
        ),
        new Array (
          "luxxpush-07",
          "Lux and Push Puppies",
          "Summer 2007",
          new Array (
            new Array (
                "A Lux and Push Puppy",
                "At four and a half weeks old.",
                "July 21, 2007",
                ".jpg"
            ),
            new Array (
                "Two Lux and Push Puppies",
                "",
                "July 21, 2007",
                ".jpg"
            ),
            new Array (
                "A Lux and Push Puppy",
                "",
                "July 21, 2007",
                ".jpg"
            ),
            new Array (
                "A Lux and Push Puppy",
                "This one hides in the grass...",
                "July 21, 2007",
                ".jpg"
            ),
            new Array (
                "Three Lux and Push Puppies",
                "",
                "July 21, 2007",
                ".jpg"
            ),
            new Array (
                "An Areal View of a Puppy",
                "",
                "July 21, 2007",
                ".jpg"
            ),
            new Array (
                "Four Puppies",
                "",
                "July 21, 2007",
                ".jpg"
            ),
            new Array (
                "",
                "",
                "July 21, 2007",
                ".jpg"
            ),
            new Array (
                "",
                "",
                "July 21, 2007",
                ".jpg"
            ),
            new Array (
                "Six All Together",
                "",
                "July 21, 2007",
                ".jpg"
            ),
            new Array (
                "Close-up",
                "A close-up of their faces.",
                "July 21, 2007",
                ".jpg"
            ),
            new Array (
                "Lux!",
                "Lux has come, and all the puppies look for food. (A week and a half later.)",
                "July 30, 2007",
                ".jpg",
                "850x833"
            ),
            new Array (
                "Lux and Some Puppies",
                "",
                "July 30, 2007",
                ".jpg",
                "904x1144"
            ),
            new Array (
                "Lux and Some Puppies",
                "",
                "July 30, 2007",
                ".jpg",
                "709x634"
            ),
            new Array (
                "Puppies",
                "Now, at six weeks...",
                "August 3, 2007",
                ".jpg"
            ),
            new Array (
                "Puppies",
                "... They are ready to play!",
                "August 3, 2007",
                ".jpg"
            ),
            new Array (
                "Three",
                "They come to my call.",
                "August 3, 2007",
                ".jpg"
            ),
            new Array (
                "Follow",
                "They play follow the leader.",
                "August 3, 2007",
                ".jpg"
            ),
            new Array (
                "A Little Hole",
                "They will come out of their hole.",
                "August 3, 2007",
                ".jpg"
            ),
            new Array (
                "A Little Hole",
                "They are coming out of their hole.",
                "August 3, 2007",
                ".jpg"
            ),
            new Array (
                "A Little Hole",
                "They have come out of their hole.",
                "August 3, 2007",
                ".jpg"
            )
          )
        ),
        new Array (
          "shimmerxscuba-07",
          "Shimmer and Scuba Puppies",
          "Summer 2007",
          new Array (
            new Array (
                "Shimmer and Her Ten Puppies",
                "",
                "July 16, 2007",
                ".jpg"
            ),
            new Array (
                "Shimmer and Her Ten Puppies, Closer",
                "",
                "July 16, 2007",
                ".jpg"
            ),
            new Array (
                "Shimmer and Her Ten Puppies, Side",
                "You can count all ten here.",
                "July 16, 2007",
                ".jpg"
            ),
            new Array (
                "Ten Puppies, Again",
                "",
                "Juky 16, 2007",
                ".jpg"
            ),
            new Array (
                "Now at Seven Weeks...",
                "They're still hungry!",
                "August 28, 2007",
                ".jpg"
            ),
            new Array (
                "Feeding",
                "Front view.",
                "August 28, 2007",
                ".jpg"
            ),
            new Array (
                "All Ten in their Outside Pen",
                "",
                "August 27, 2007",
                ".jpg"
            ),
            new Array (
                "In their Outside Pen",
                "A clearer picture, but you can only see seven.",
                "August 27, 2007",
                ".jpg"
            ),
            new Array (
                "Teasing",
                "Here, they tease the older puppies outside their pen.",
                "August 28, 2007",
                ".jpg"
            ),
            new Array (
                "Playing",
                "Two puppies playing while one watches and one speeds off towards the cameraman.",
                "August 28, 2007",
                ".jpg"
            ),
            new Array (
                "Sitting Atop a Hill",
                "",
                "August 28, 2007",
                ".jpg"
            ),
            new Array (
                "A Canoe Ride",
                "Some went to play in the canoe.",
                "August 28, 2007",
                ".jpg"
            ),
            new Array (
                "After the Canoe Ride",
                "",
                "August 28, 2007",
                ".jpg"
            ),
            new Array (
                "Playing with Mom",
                "Mother dog Shimmer plays as if she were a puppy too, while her puppies \"trust the lion\".",
                "August 28, 2007",
                ".jpg"
            ),
            new Array (
                "A Shimmer Pujppy",
                "",
                "August 28, 2007",
                ".jpg"
            )
          )
        ),
        new Array (
          "chickie_blue",
          "Chickie and Blue",
          "Summer 2006",
          new Array (
            new Array (
                "Chickie and Blue",
                "",
                "2006",
                ".jpg"
            ),
            new Array (
                "Chickie",
                "Chickie standing nice.",
                "2006",
                ".jpg"
            )
          )
        ),
        new Array (
          "bbouncex-05",
          "Baby Bounce Puppies",
          "Late 2005",
          new Array (
            new Array (
                "Rockette and Rene",
                "Two Baby Bounce pups, Rocket and Rene, sitting in the snow ...",
                "at 2:40 PM on December 17, 2007",
                ".jpg"
            ),
            new Array (
                "Rockette and Rene",
                "... watching the camera ... (It's starting to get redundant)",
                "at 2:40 PM on December 17, 2007",
                ".jpg"
            ),
            new Array (
                "Rockette and Rene",
                "Oh! Their tails moved.",
                "at 2:40 PM on December 17, 2007",
                ".jpg"
            ),
            new Array (
                "Rockette and ...",
                "Where's Rene?",
                "at 2:40 PM on December 17, 2007",
                ".jpg"
            ),
            new Array (
                "Searching for Rockette",
                "Is she in the snow?",
                "at 2:40 PM on December 17, 2007",
                ".jpg"
            ),
            new Array (
                "Searching for Rockette",
                "Is she under the ice?",
                "at 2:40 PM on December 17, 2007",
                ".jpg"
            ),
            new Array (
                "Where, Here?",
                "Hm ..., I think ...",
                "at 2:40 PM on December 17, 2007",
                ".jpg"
            ),
            new Array (
                "Or There?",
                "... She's OVER THERE!",
                "at 2:40 PM on December 17, 2007",
                ".jpg"
            ),
            new Array (
                "Found Her!",
                "In the woods!",
                "at 2:40 PM on December 17, 2007",
                ".jpg"
            ),
            new Array (
                "Hey!",
                "Hey, what's over there?",
                "at 2:40 PM on December 17, 2007",
                ".jpg"
            ),
            new Array (
                "What is it?",
                "Let's go see! Are you coming?",
                "at 2:40 PM on December 17, 2007",
                ".jpg"
            ),
            new Array (
                "It's Time to Play!",
                "Oh, it's just a person. Let's go play!",
                "at 2:40 PM on December 17, 2007",
                ".jpg"
            ),
            new Array (
                "Let's play...",
                "Let's play \"Try to Trip the Human\"!",
                "at 2:40 PM on December 17, 2007",
                ".jpg"
            ),
            new Array (
                "Awww.",
                "That didn't work. Let's go this way!",
                "at 2:40 PM on December 17, 2007",
                ".jpg"
            ),
            new Array (
                "Are you coming?",
                "... Wait, where are you going?",
                "at 2:40 PM on December 17, 2007",
                ".jpg"
            ),
            new Array (
                "No,",
                "I want to go over here!",
                "at 2:40 PM on December 17, 2007",
                ".jpg"
            ),
            new Array (
                "Ok",
                "What did you want?",
                "at 2:40 PM on December 17, 2007",
                ".jpg"
            ),
            new Array (
                "I want ...",
                "I want to play!!",
                "at 2:40 PM on December 17, 2007",
                ".jpg"
            ),
            new Array (
                "Hey human, want to play with us?",
                "Please?",
                "at 2:40 PM on December 17, 2007",
                ".jpg"
            ),
            new Array (
                "I don't think she wants to.",
                "Let's play hide and track, you look for me first.",
                "at 2:40 PM on December 17, 2007",
                ".jpg"
            ),
            new Array (
                "I will find you. I will!",
                "",
                "at 2:40 PM on December 17, 2007",
                ".jpg"
            )/*,
              "21: :640:480",
              "22: :640:480",
              "23: :640:480",
              "24: :640:480",
              "25: :640:480",
              "26: :640:480",
              "27: :640:480"*/
          )
        ),
        new Array (
          "missixscuba-06",
          "Missi and Scuba Puppies",
          "2006",
          new Array (
            new Array (
                "Puppy",
                "A Missi puppy with Nate.",
                "December 16, 2006",
                ".png",
                "640x418"
            ),
            new Array (
                "Sleeping",
                "Three puppies sleeping.",
                "December 16, 2006",
                ".png",
                "640x422"
            ),
            new Array (
                "Cute",
                "At six and a half weeks old, here are all five Missi x Scuba puppies.",
                "December 29, 2006",
                ".png",
                "640x426"
            )
          )
        ),
        new Array (
          "originals",
          "Past Sunfire Dogs",
          "About 1980 to 1994",
          new Array (
            new Array (
                "Some of the Original Sunfire Dogs",
                "(Back) Cascade, Gusty, Bonnie, Dynamite, Badger, Addie, Colleen. (Front) Moriah, Sunshine.",
                "September 1982",
                ".png",
                "640x456"
            ),
            new Array (
                "Some of the Original Sunfire Dogs",
                "(Goldens) Cascade, Tanya, Ruffian, Moriah, Sunshine. (Smooth Collies) Colleen, Addie, Bobbie, Tabitha.",
                "July 1980",
                ".png",
                "640x399"
            ),
            new Array (
                "Some of the Original Sunfire Dogs",
                "Addie, Cascade, Tanya, Horizon, Bonnie, Sunshine, Gusty, Colleen, Moriah.",
                "Fall 1981",
                ".png",
                "640x394"
            ),
            new Array (
                "Some of the Original Sunfire Dogs",
                "Addie, Tanya, Sunshine, Cascade, Horizon, Gusty, Bonnie, Colleen, Moriah. (With Mike, Barbara, and Becca)",
                "Fall 1981",
                ".png",
                "640x442"
            ),
            new Array (
                "Five Sunfire UD-WCX Dogs",
                "Bonnie, Dynamite, Cascade, Moriah, Sunshine.",
                "in 1985",
                ".png",
                "640x426"
            ),
            new Array (
                "Cascade",
                "Mike and Cascade at Nod Brook",
                "",
                ".png",
                "640x426"
            ),
            new Array (
                "Sparky",
                "AFC Wildfire of Riverview \"Sparky\"",
                "",
                ".png",
                "343x480"
            ),
            new Array (
                "Cascade",
                "Sunfire's Kinetic Cascade UD MH WCX Can UD WCX OD \"Cascade\"",
                "in June 1983",
                ".png",
                "640x437"
            ),
            new Array (
                "Tanya",
                "Tanya du Shanka WC Am/Can CD (OD) \"Tanya\"",
                "",
                ".png",
                "640x425"
            ),
            new Array (
                "Winchester",
                "Am./Can. CH. Clark Sunfire's Bullseye JH CDX WCX; Can. CDX WCI (OS) \"Winchester\"",
                "",
                ".png",
                "349x480"
            ),
            new Array (
                "Winchester: Best in Show",
                "Winchester: Best in Show in Canada",
                "",
                ".png",
                "640x457"
            ),
            new Array (
                "Some of the Original Sunfire Dogs",
                "Cascade, Bonnie, and Dynamite",
                "",
                ".png",
                "640x437"
            ),
            new Array (
                "Sunshine",
                "Sunshine Lollipop UD WCX Can.CDX \"Sunshine\"",
                "",
                ".png",
                "480x480"
            ),
            new Array (
                "Three Dogs Finishing Their CD",
                "Leroy, Sky, and Geri.",
                "July 1994",
                ".png",
                "640x508"
            ),
            new Array (
                "Tanya",
                "The classical Tanya jumping into the water picture.",
                "",
                ".png",
                "640x365"
            )
          )
        ),
        new Array (
          "sky",
          "Sunfire's Autumn Sky",
          "Fall 2006",
          new Array (
            new Array (
                "Sky",
                "Sky pictured with nine of her sixteen geese she retrieved.",
                "Fall 2006",
                ".png",
                "815x615"
            ),
            new Array (
                "Sky is a Goose Dog",
                "",
                "Fall 2006",
                ".png",
                "658x588"
            ),
            new Array (
                "Sky",
                "",
                "Fall 2006",
                ".png",
                "512x620"
            )
          )
        ),
        new Array (
          "angel_push",
          "Angel and Push",
          "",
          new Array (
            new Array (
                "Angel in the Duck Blind",
                "",
                "",
                ".png",
                "520x416"
            ),
            new Array (
                "Angel Goose Retrieve",
                "",
                "",
                ".png",
                "520x322"
            ),
            new Array (
                "Angel Hunt Test",
                "",
                "",
                ".png",
                "380x307"
            ),
            new Array (
                "Push Finishes his AFTCH",
                "",
                "",
                ".png",
                "531x415"
            )
          )
        ),
        new Array (
          "joy",
          "Joy",
          "Joy's lifetime",
          new Array (
            new Array (
                "Charlotte with Joy",
                "",
                "",
                ".jpg"
            ),
            new Array (
                "Charlotte with Joy",
                "",
                "",
                ".jpg",
                "480x640"
            ),
            new Array (
                "Charlotte with Joy",
                "",
                "",
                ".jpg"
            )
          )
        )
      );
      }

      var currAlbumName = "";
      var currAlbumNum = -1;
      var currImageNum = -1;

      //this writes the album view//
      function writeAlbumView() {
        document.writeln("<a name=\"album_index\" id=\"album_index_a\"><\/a>");
        if (albums.length == 0)
          document.writeln("<p>No albums found.<\/p>");
        else {
          document.writeln("<table class=\"album_index\" id=\"album_index_table\">");
          document.writeln("  <caption>Begin by clicking an album below:<\/caption>");
          document.writeln("  <thead>");
          document.writeln("    <tr>");
          document.writeln("      <td>Album<\/td>");
          document.writeln("      <td>Date/Time<\/td>");
          document.writeln("      <td>Number of Pictures<\/td>");
          document.writeln("    <\/tr>");
          document.writeln("  <\/thead>");
          document.writeln("  <tbody>");
          for (var i = 0; i < albums.length; i++) {
            document.writeln("    <tr>");
            document.writeln("      <td class=\"album_index_col_a\"><a href=\"#\" onclick=\"currUrl = location.href; viewAlbum('" + albums[i][0] + "'); return false;\" title=\"" + albums[i][1] + "\">" + albums[i][1] + "<\/a><\/td>");
            document.writeln("      <td class=\"album_index_col_b\">" + albums[i][2] + "<\/td>");
            document.writeln("      <td class=\"album_index_col_c\">" + (albums[i][3].length).toString() + "<\/td>");
            document.writeln("    <\/tr>");
          }
          document.writeln("  <\/tbody>");
          document.writeln("<\/table>");

          for (var i = 0; i < albums.length; i++) {
            var firstText, previousText, nextText, lastText;
            if (i == 0) {
              firstText       = "disabled=\"disabled\" class=\"disabled\"";
              previousText    = "disabled=\"disabled\" class=\"disabled\"";
            } else {
              firstText       = "title=\"" + albums[0][1] + "\"";
              previousText    = "title=\"" + albums[i - 1][1] + "\"";
            }
            if (i == albums.length - 1) {
              nextText = "disabled=\"disabled\" class=\"disabled\"";
              lastText = "disabled=\"disabled\" class=\"disabled\"";
            } else {
              nextText = "title=\"" + albums[i + 1][1] + "\"";
              lastText = "title=\"" + albums[albums.length - 1][1] + "\"";
            }
            document.writeln("<div id=\"album_" + albums[i][0] + "\">");
            document.writeln("  <div id=\"album_" + albums[i][0] + "_nav\" class=\"album_nav\">");
            document.writeln("    <a name=\"album\" id=\"album_" + albums[i][0] + "_a\"><\/a>");
            document.writeln("    <h6>Navigate through albums:<\/h6>");
            document.writeln("    <button onmouseover=\"overBtn(this);\" onmouseout=\"outBtn(this);\" onmousedown=\"downBtn(this);\" onmouseup=\"overBtn(this);\" onclick=\"viewAlbumFRST();\" " + firstText + " id=\"album_" + albums[i][0] + "_nav_first\">&lt;&lt;-- First<\/button>");
            document.writeln("    <button onmouseover=\"overBtn(this);\" onmouseout=\"outBtn(this);\" onmousedown=\"downBtn(this);\" onmouseup=\"overBtn(this);\" onclick=\"viewAlbumPREV();\" " + previousText + " id=\"album_" + albums[i][0] + "_nav_prev\">&lt;-- Previous<\/button>");
            document.writeln("    <button onmouseover=\"overBtn(this);\" onmouseout=\"outBtn(this);\" onmousedown=\"downBtn(this);\" onmouseup=\"overBtn(this);\" onclick=\"viewAlbumINDX();\" id=\"album_" + albums[i][0] + "_nav_index\" title=\"Index of Albums\">Index<\/button>");
            document.writeln("    <button onmouseover=\"overBtn(this);\" onmouseout=\"outBtn(this);\" onmousedown=\"downBtn(this);\" onmouseup=\"overBtn(this);\" onclick=\"viewAlbumNEXT();\" "  + nextText + " id=\"album_" + albums[i][0] + "_nav_next\">Next --&gt;<\/button>");
            document.writeln("    <button onmouseover=\"overBtn(this);\" onmouseout=\"outBtn(this);\" onmousedown=\"downBtn(this);\" onmouseup=\"overBtn(this);\" onclick=\"viewAlbumLAST();\" " + lastText + " id=\"album_" + albums[i][0] + "_nav_last\">Last --&gt;&gt;<\/button>");
            document.writeln("  <\/div>");

            document.writeln("  <h3>" + albums[i][1] + "<\/h3>");

            document.writeln("  <div class=\"album_thumbs_div\">");
            document.writeln("    <table id=\"album_" + albums[i][0] + "_thumbs\" class=\"album_thumbs\">");
            document.writeln("      <tbody>");
            document.writeln("        <tr>");

            if (albums[i][3].length == 0) {
              document.writeln("          <td>No images found.<\/td>");
            } else {
              var path, sdesc, dim;
              for (var j = 0; j < albums[i][3].length; j++) {
                switch (albums[i][3][j].length) {
                  case 3:
                    dim = "640x480";
                    path = j.toString() + ".png";
                    break;
                  case 4:
                    if (albums[i][3][j][3].indexOf("x") == -1) {
                      dim = "640x480";
                      if (albums[i][3][j][3].indexOf(".") == 0) {
                        path = j.toString() + albums[i][3][j][3];
                      } else if (albums[i][3][j][3].indexOf(".") == -1) {
                        path = albums[i][3][j][3] + ".png";
                      } else {
                        path = albums[i][3][j][3];
                      }
                    } else {
                      dim = albums[i][3][j][3];
                    }
                    break;
                  case 5:
                    if (albums[i][3][j][3].indexOf(".") == 0) {
                      path = j.toString() + albums[i][3][j][3];
                    } else if (albums[i][3][j][3].indexOf(".") == -1) {
                      path = albums[i][3][j][3] + ".png";
                    } else {
                      path = albums[i][3][j][3];
                    }
                    if (albums[i][3][j][4].indexOf("x") == -1) {
                      dim = "640x480";
                    } else {
                      dim = albums[i][3][j][4];
                    }
                    break;
                }
                path = "util/thumb.php?src=../album/" + albums[i][0] + "/" + path + "&conv=thumb";
                sdesc = albums[i][3][j][0];

                document.writeln("          <td onclick=\"viewImage(" + j.toString() + ");\" title=\"" + sdesc + "\">");
                document.writeln("            <img src=\"\" id=\"album_" + albums[i][0] + "_thumb_" + j.toString() + "\" name=\"" + path + "\" alt=\"" + sdesc + "\" title=\"" + sdesc + "\" \/>");
                document.writeln("          <\/td>");
              }
            }

            document.writeln("        <\/tr>");
            document.writeln("      <\/tbody>");
            document.writeln("    <\/table>");
            document.writeln("  <\/div>");
            document.writeln("<\/div>");
          }                           

          document.writeln("<div id=\"album_img_div\" class=\"album_img\">");
          document.writeln("  <a name=\"album_img\" id=\"album_img_a\"><\/a>");
          document.writeln("  <img class=\"album_img_img\" id=\"album_img_img\" src=\"\" alt=\"\" title=\"\" \/>");
          document.writeln("  <span class=\"album_img_sdesc\" id=\"album_img_sdesc\">sdesc<\/span>");
          document.writeln("  <span class=\"album_img_ldesc\" id=\"album_img_ldesc\">ldesc<\/span>");
          document.writeln("  <span class=\"album_img_dt\" id=\"album_img_dt\">datetime<\/span>");
          document.writeln("  <h6>Navigate through pictures:<\/h6>");
          document.writeln("  <button onmouseover=\"overBtn(this);\" onmouseout=\"outBtn(this);\" onmousedown=\"downBtn(this);\" onmouseup=\"overBtn(this);\" onclick=\"viewImageFRST();\" id=\"album_img_nav_first\">&lt;&lt;-- First<\/button>");
          document.writeln("  <button onmouseover=\"overBtn(this);\" onmouseout=\"outBtn(this);\" onmousedown=\"downBtn(this);\" onmouseup=\"overBtn(this);\" onclick=\"viewImagePREV();\" id=\"album_img_nav_prev\">&lt;-- Previous<\/button>");
          document.writeln("  <button onmouseover=\"overBtn(this);\" onmouseout=\"outBtn(this);\" onmousedown=\"downBtn(this);\" onmouseup=\"overBtn(this);\" onclick=\"viewAlbum(currAlbumName);\" id=\"album_img_nav_hide\">Hide<\/button>");
          document.writeln("  <button onmouseover=\"overBtn(this);\" onmouseout=\"outBtn(this);\" onmousedown=\"downBtn(this);\" onmouseup=\"overBtn(this);\" onclick=\"viewImageNEXT();\" id=\"album_img_nav_next\">Next --&gt;<\/button>");
          document.writeln("  <button onmouseover=\"overBtn(this);\" onmouseout=\"outBtn(this);\" onmousedown=\"downBtn(this);\" onmouseup=\"overBtn(this);\" onclick=\"viewImageLAST();\" id=\"album_img_nav_last\">Last --&gt;&gt;<\/button>");
          document.writeln("<\/div>");                                                                         
        }
        
        currAlbumNum = -1;
        currAlbumName = "";
        
        var div;
        for (var i = 0; i < albums.length; i++) {
          div = document.getElementById("album_" + albums[i][0]);
          div.style.display = "none";
        } 

        div = document.getElementById("album_index");
        div.style.display = "block";
        div = document.getElementById("album_img_div");
        div.style.display = "none";

        var img;
        img = document.getElementById("album_img_img");
        img.src = "";
        img.alt = "";
        img.title = "";
        img.style.display = "none";
        
        if (location.href.indexOf("#") < 0) {
          window.location = "#album_index";
          currUrl = location.href;
        }
      }

      //shows an album//
      function viewAlbum(name) {
        currAlbumNum = -1;
        currAlbumName = name;
        for (var i = 0; i < albums.length; i++)
          if (albums[i][0] == name)
            currAlbumNum = i;

        if (currAlbumNum == -1) {
          alert("Unknown album '" + name + "'.");
          return false;
        }
        
        document.title = "Sunfire Golden Retrievers - Albums - " + albums[currAlbumNum][1];
        
        var div;
        for (var i = 0; i < albums.length; i++) {
          div = document.getElementById("album_" + albums[i][0]);
          div.style.display = "none";
        }
        
        div = document.getElementById("album_index_table");
        div.style.display = "none";
        div = document.getElementById("album_" + name);
        div.style.display = "block";
        div = document.getElementById("album_img_div");
        div.style.display = "block";
        
        var img;
        img = document.getElementById("album_img_img");
        img.src = "";
        img.alt = "";
        img.title = "";
        img.style.display = "none";

        for (var j = 0; j < albums[currAlbumNum][3].length; j++) {
          img = document.getElementById("album_" + name + "_thumb_" + j.toString());
          if (img.name == "LOADED")
            continue;
          img.src = "";
          img.src = img.name;
          img.name = "LOADED";
        }

        var btn;
        btn = document.getElementById("album_img_nav_first");
        disableBtn(btn);
        btn = document.getElementById("album_img_nav_prev");
        disableBtn(btn);
        btn = document.getElementById("album_img_nav_next");
        disableBtn(btn);
        btn = document.getElementById("album_img_nav_last");
        disableBtn(btn);
        btn = document.getElementById("album_img_nav_hide");
        disableBtn(btn);
        
        var span;
        span = document.getElementById("album_img_sdesc");
        span.innerHTML = "Click an image above to see it larger with its description.";
        span = document.getElementById("album_img_ldesc");
        span.innerHTML = " ";
        span = document.getElementById("album_img_dt");
        span.innerHTML = " ";

        var a;
        a = document.getElementById("album_" + currAlbumName + "_a");
        a.name = "album_" + currAlbumName;
        
        window.location = "#" + a.name;
        currUrl = location.href;
        
        return true;
      }

      //shows the index//
      function viewAlbumINDX() {
        currAlbumNum = -1;
        currAlbumName = "";

        document.title = "Sunfire Golden Retrievers - Albums";
        
        var div;
        for (var i = 0; i < albums.length; i++) {
          div = document.getElementById("album_" + albums[i][0]);
          div.style.display = "none";
        }

        div = document.getElementById("album_index_table");
        div.style.display = "block";
        div = document.getElementById("album_img_div");
        div.style.display = "none";

        var img;
        img = document.getElementById("album_img_img");
        img.src = "";
        img.alt = "";
        img.title = "";
        img.style.display = "none";
        
        window.location = "#album_index";
        currUrl = location.href;
      }

      //these functions are called by the album buttons to quick move from album to album//
      function viewAlbumFRST() {
        viewAlbum(albums[0][0]);
      }

      function viewAlbumPREV() {
        viewAlbum(albums[currAlbumNum - 1][0]);
      }

      function viewAlbumNEXT() {
        viewAlbum(albums[currAlbumNum + 1][0]);
      }

      function viewAlbumLAST() {
        var length = albums.length;
        viewAlbum(albums[length - 1][0]);
      }

      //shows an image//
      function viewImage(imgNum) {
        if (currAlbumNum < 0 || currAlbumNum >= albums.length) {
          alert("Select an album before selecting an image.");
          return;
        }
        
        if (!isFinite(imgNum) || imgNum < 0 || imgNum >= albums[currAlbumNum][3].length) {
          alert("Unknown image '" + imgNum + "' in album " + currAlbumName + ".");
          return;
        }

        var img, sdesc, ldesc, datetime, path;
        img = document.getElementById("album_img_img");

        switch (albums[currAlbumNum][3][imgNum].length) {
          case 3:
            path = imgNum.toString() + ".png";
            break;
          case 4:
            if (albums[currAlbumNum][3][imgNum][3].indexOf("x") == -1) {
              if (albums[currAlbumNum][3][imgNum][3].indexOf(".") == 0) {
                path = imgNum.toString() + albums[currAlbumNum][3][imgNum][3];
              } else if (albums[currAlbumNum][3][imgNum][3].indexOf(".") == -1) {
                path = albums[currAlbumNum][3][imgNum][3] + ".png";
              } else {
                path = albums[currAlbumNum][3][imgNum][3];
              }
            } else {
              dim = albums[currAlbumNum][3][imgNum][3];
            }
            break;
          case 5:
            if (albums[currAlbumNum][3][imgNum][3].indexOf(".") == 0) {
              path = imgNum.toString() + albums[currAlbumNum][3][imgNum][3];
            } else if (albums[currAlbumNum][3][imgNum][3].indexOf(".") == -1) {
              path = albums[currAlbumNum][3][imgNum][3] + ".png";
            } else {
              path = albums[currAlbumNum][3][imgNum][3];
            }
            break;
        }
        path = "util/thumb.php?src=../album/" + albums[currAlbumNum][0] + "/" + path + "&conv=view1024";
        sdesc = albums[currAlbumNum][3][imgNum][0];
        ldesc = albums[currAlbumNum][3][imgNum][1];
        datetime = albums[currAlbumNum][3][imgNum][2];
        if (datetime != "")
          datetime = "Picture taken " + datetime;

        document.title = "Sunfire Golden Retrievers - Albums - " + albums[currAlbumNum][1] + " - " + sdesc;

        img.src = "";
        img.src = path;
        img.alt = sdesc;
        img.title = sdesc;
        img.style.display = "block";

        var span;
        span = document.getElementById("album_img_sdesc");
        span.innerHTML = sdesc;
        span = document.getElementById("album_img_ldesc");
        span.innerHTML = ldesc;
        span = document.getElementById("album_img_dt");
        span.innerHTML = datetime;

        var btn;
        if (imgNum == 0) {
          btn = document.getElementById("album_img_nav_first");
          disableBtn(btn);
          btn = document.getElementById("album_img_nav_prev");
          disableBtn(btn);
        } else {
          btn = document.getElementById("album_img_nav_first");
          enableBtn(btn, albums[currAlbumNum][3][0][0]);
          btn = document.getElementById("album_img_nav_prev");
          enableBtn(btn, albums[currAlbumNum][3][imgNum - 1][0]);
        }

        if (imgNum == albums[currAlbumNum][3].length - 1) {
          btn = document.getElementById("album_img_nav_next");
          disableBtn(btn);
          btn = document.getElementById("album_img_nav_last");
          disableBtn(btn);
        } else {
          btn = document.getElementById("album_img_nav_next");
          enableBtn(btn, albums[currAlbumNum][3][imgNum + 1][0]);
          btn = document.getElementById("album_img_nav_last");
          enableBtn(btn, albums[currAlbumNum][3][albums[currAlbumNum][3].length - 1][0]);
        }

        btn = document.getElementById("album_img_nav_hide");
        enableBtn(btn, "Hide large image");
        
        var div;
        div = document.getElementById("album_img_div");
        div.style.display = "block";
        
        var a;
        a = document.getElementById("album_img_a");
        a.name = "album_" + currAlbumName + "_" + imgNum;
        
        window.location = "#" + a.name;
        
        currUrl = location.href;

        currImageNum = imgNum;
      }

      //these functions are called by the image nav buttons to quick move from image to image//
      function viewImageFRST() {
        viewImage(0);
      }

      function viewImagePREV() {
        viewImage(currImageNum - 1);
      }

      function viewImageNEXT() {
        viewImage(currImageNum + 1);
      }

      function viewImageLAST() {
        var length = albums[currAlbumNum][3].length;
        viewImage(length - 1);
      }
      
      //these functions disable and enable buttons
      function disableBtn(btn) {
        btn.style.backgroundPosition = "0px 0px";
        btn.style.color = "#aaaaaa";
        btn.style.cursor = "default";
        btn.disabled = true;
        btn.title = "";
      }
      
      function enableBtn(btn, title) {
        btn.style.backgroundPosition = "0px -32px";
        btn.style.color = "#ff8800";
        btn.style.cursor = "pointer";
        btn.disabled = false;
        btn.title = title;
      }
      
      function overBtn(btn) {
        if (btn.disabled)
          return;
        btn.style.backgroundPosition = "0px -64px";
        btn.style.textDecoration = "underline";
        btn.style.color = "#ffcc22";
      }
      
      function downBtn(btn) {
        if (btn.disabled)
          return;
        btn.style.backgroundPosition = "0px -96px";
        btn.style.textDecoration = "underline";
        btn.style.color = "#ffee44";
      }
      
      function outBtn(btn) {
        if (btn.disabled)
          return;
        btn.style.backgroundPosition = "0px -32px";
        btn.style.textDecoration = "none";
        btn.style.color = "#ff8800";
      }
      
      var backTimer;
      var currUrl;
      
      window.onload = function () {
        backTick();
      }
      
      function backTick() {
        clearTimeout(backTimer);
        
        if (currUrl != location.href) {
          currUrl = location.href;
          
          if (currUrl.indexOf("#") > 0) {
            var loc = currUrl.split("#")[1];
            if (loc == "album_index") {
              viewAlbumINDX();
            } else if (loc.substring(0, 6) == "album_") {
              var locarr = loc.split("_");
              if (locarr.length == 2 || locarr.length == 3) {
                if (viewAlbum(locarr[1]) && locarr.length == 3) {
                  viewImage(Number(locarr[2]));
                }
              } else {
                alert("Invalid album/image locator.");
              }
            }
          }
        }
        
        backTimer = setTimeout("backTick();", 1000);
      }
    </script>
      <h2>Albums</h2>

      <hr />

      <script type="text/javascript"> writeAlbumView(); </script>
<?php

// bottom of page
get_page_sect_bottom();

?>