/*//SFG JAVASCRIPT//*/
//this file makes it easy to modify common objects all at once//

//
/* ~~ DATA ARRAYS ~~ */
//
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
 *             etc
 *         }
 *     },
 *     album_2 {},
 *     etc
 * }
 */
var albums;
albums = new Array (
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
                "Two at Two Weeks Old",
                "Another View",
                "Early April, 2008",
                "2.jpg",
                "640x480"
            ),
            new Array (
                "Two at Two Weeks Old",
                "Looking Around",
                "Early April, 2008",
                "3.jpg",
                "640x480"
            ),
            new Array (
                "Two at Two Weeks Old",
                "Happy",
                "Early April, 2008",
                "4.jpg",
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
        "breeze",
        "Breeze",
        "Breeze's lifetime",
        new Array (
            new Array (
                "Nate with Breeze",
                "",
                "",
                ".jpg"
            ),
            new Array (
                "Dan with Breeze",
                "at five months old.",
                "",
                ".jpg"
            ),
            new Array (
                "Breeze at Seven Weeks",
                "front",
                "",
                ".jpg"
            ),
            new Array (
                "Breeze at Seven Weeks",
                "side",
                "",
                ".jpg"
            ),
            new Array (
                "Breeze and Nate at the Big E",
                "This picture is on the front page of the website.",
                "September 2007",
                "frontpage.jpg",
                "640x905"
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
        "June through August 2007",
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
        "about 1980 to 1994",
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

//THIS stores all the story info an array of arrays//
/* how it is stuctured
 * stories {
 *     story_1 {
 *         internal_story_name,
 *         story_sdesc,
 *         story_ldesc,
 *         paragraphs {
 *             text_in_para_1,
 *             text_in_para_2,
 *             etc
 *         }
 *     },
 *     story_2 {},
 *     etc
 * }
 */
var stories;
stories = new Array (
    new Array (
        "beginnings",
        "Beginnings",
        "",
        new Array (
            "In 1971 Mike (physics) and Barbara (medical genetics)\
            were graduate students at the University of Wisconsin in\
            Madison. &nbsp;Barb had a blue merle smooth collie, Bobbie, who\
            was a guide dog reject. &nbsp;Mike decided to get an Irish Setter,\
            but someone in the physics department suggested a Golden\
            Retriever, a breed of which we had never heard. &nbsp;One puppy\
            was left in the litter that their dog had sired. &nbsp;She was\
            \"swimming in the water dish\", ten weeks old, and the family\
            just wanted to get rid of their last puppy. &nbsp;Years later\
            we realized this was no ordinary pup, but from a remarkable\
            pedigree. &nbsp;Her sire was bred by Handjem kennel, a breeding\
            of <b>Duke of Handjem***<\/b> to <b>Ch.Torch of Handjem***<\/b>. &nbsp;The dam\
            was the family hunting dog with prominent names of the day\
            in her pedigree, Hammerlock and Gayhaven.",

            "Tanya was from the beginning just a wonderful all around\
            dog, and spent her formative years being our friend, traveling\
            around the country, retrieving tennis balls from Lake Mendota,\
            and later from the rivers outside of Pittsburgh, and finally\
            in the ponds of Nod Brook in Connecticut. &nbsp;In her later years\
            we discovered obedience and field competition and she earned\
            her CD and WC, but she was always the best tennis ball retriever.",

            "Tanya's first litter of nine pups was born in 1973 in Madison,\
            from a golden we met about campus. &nbsp;We kept Sunshine, a big red\
            girl, who was Barb's first UD and WCX. &nbsp;From Sunshine we discovered\
            obedience classes and competition. &nbsp;And we also realized the\
            importance of studying a pedigree, producing a certain moderate\
            size of Golden and the desire. &nbsp;Although Sunshine was sweet, biddable,\
            and steady, she had no drive, which Tanya showed in abundance.\
            Sunshine was Barb's steady friend in the years of change after\
            college. &nbsp;Sunshine was the \"SUN\" in Sunfire, and Tanya was the\
            \"FIRE\".",

            "Our second Tanya litter was from a prominent dog in Connecticut.\
            This is when we started using the Sunfire kennel name, in 1977.\
            Moriah was Mike's first CDX, his first UD, and his first WCX. &nbsp;She\
            was a willing dog, a great one to learn the basics. &nbsp;But although\
            she had hip and eye clearances, her litters were disasters of hip\
            dysplasia, even though she was bred to two different sound sires.\
            We realized the importance of studying the pedigree for sound\
            dogs, not only the parents but grandparents and siblings of the\
            parents. &nbsp;All offspring of Moriah were spayed or neutered, we\
            later learned her father was not from a sound line, and this was\
            a hard lesson.",

            "Back to Tanya, and her pedigree, we realized her grandfather\
            was from an astounding litter that produced four field champions.\
            One was a female Coquette, one was Chancellor, who was from an older\
            litter and not producing any longer, one was Sir Jim, (Red Devil's\
            sire) who was changing ownership and we couldn't locate, and the\
            fourth was <b>FC-AFC Kinike Oro de Rojo<\/b> owned by Jim and Sally Venerable.\
            We line bred Tanya to her grandfather's brother, Rojo, and this\
            was the start of our line, which is behind every Sunfire dog today.\
            Here was the fire and desire that we feel important to see in a\
            sporting dog, always willing to do whatever one could want. &nbsp;We\
            kept two females, Cascade who was bright and cooperative, and Ruffian\
            who was as strong willed as her namesake the race horse filly.\
            Ruffian was perhaps the smartest Golden we ever knew, but she wasn't\
            using it cooperatively.",

            "Cascade was so trainable and talented. &nbsp;When Cascade was two, we\
            saw our first Golden Retriever national field trial. &nbsp;We sent Cas\
            for field training along with Mike Lardy, a \"new\" pro whose father\
            owned Handjem kennels, on his first trip south. &nbsp;We did some field\
            trialing, but family and time constraints never allowed us to seriously\
            go into field trialing. &nbsp;The following year after Cas' field training,\
            we decided to go back in the obedience ring with Cas, she had a CDX\
            and WCX prior to being sent with the pro. &nbsp;Within three months span,\
            Cas not only learned all of utility but she earned her American and\
            Canadian UD, while also picking up a High in Trial in Canada from open.\
            After that Mike and Cas concentrated on field, and mostly the new \"game\"\
            of hunt tests in AKC. &nbsp;Mike developed his interest in the hunt tests\
            with her, and he went into judging hunt tests. &nbsp;Cas was one of the first\
            Goldens with a UD and a MH. &nbsp;We had three litters from Cascade from\
            three different field champions, and from each we had special dogs,\
            Tide and Dash, Zest, and Luke.",

            "Ruffian, on the other hand, was all but impossible to get a CD or\
            WC&#59; she was thinking way too much. &nbsp;The stories of her brilliance,\
            and deliberate naughtiness, are endless. &nbsp;Structurally, she was remarkably\
            sound, but it was hidden in a red coat, so people often discounted her\
            looks. &nbsp;She went to live with friends, Sue and Rich Simmons, but came\
            back home for litters. &nbsp;We bred Ruffian to easy going biddable show\
            dogs. &nbsp;Her first litter was her best, producing Dynamite, a dog with\
            incredible marking ability in the field, and incredible willingness\
            and desire in obedience. &nbsp;From this litter there was another bitch,\
            Thumper, who became the foundation for Virginia Goertz' Otterbrook Goldens.\
            Thumper had the body and marking ability from Ruffian, but also the\
            willfullness which gave Gin a run for her money.",

            "In 1981, Bonnie came from Sydney Waller's Clark Golden Retrievers.\
            When she ran for her first bird at eleven months old, she was like a\
            white fox, fast and determined. &nbsp;She loved her birds, even tho her pedigree\
            was generations of show breeding. &nbsp;Her desire for bumpers was minimal\
            unlike our field lines, but she did go as far as earning a WCX on her\
            desire for birds. &nbsp;She spent her life between Sydney's and our house,\
            always the love of everyone's life. &nbsp;I always say, the Goldens motto\
            is \"Love the one you're with.\" Everyone who spent time with Bonnie,\
            and the same with her offspring, always felt they were the only one she\
            loved. &nbsp;Sydney bred her to two show champions (from which we kept Winchester,\
            she kept Remington), and we bred her to a field champion (producing Jack,\
            Dream, and Breila), and an obedience trial champion (Flash, Rowdy, Crispy,\
            and Sugar Pop). &nbsp;Bonnie's last litter was to an all around dog, and from\
            this we kept Jimi and Costa. &nbsp;Most of our obedience and agility dogs\
            are descended from Bonnie, often mixed with Dynamite's lines. &nbsp;Several\
            of these Bonnie kids and descendants went on to be intrical parts of\
            other kennels, such as Highland, Flashfire, Sunsplash, Sparklin, and Comstock.\
            Bonnie produced a certain love, and beauty, that she passed on, and that\
            Golden desire to please.",

            "Many sires that we bred to over the years were intrigal in developing\
            our line. &nbsp;There were significant field trial champions: Rojo, Brier,\
            Buckshot, Red Devil, Mo, and Sprint. &nbsp;On the show/obedience lines, ones that\
            were signicant in today's Sunfire dogs were Can CH. &nbsp;Jazz UDTX SH, CH. &nbsp;Target\
            DX, OTCH Crackle, OTCH Rocky, and CH James.",

            "Starting with our first \"pet\" dog Tanya in Wisconsin, we then moved to\
            Pittsburgh where we joined the Golden Triangle Obedience Club, and the Greater\
            Pittsburgh Golden Retriever Club. &nbsp;Our two years there helped us find our\
            way in the world of dogs. &nbsp;Moving to Connecticut in 1975, we soon became\
            active members of Southern Berkshire Golden Retriever Club, Shoreline Retriever\
            Club, and Hartford Obedience Training Club. &nbsp;Mike was president or treasurer\
            of these clubs, and Barb was SBGRC secy for 19 years, and is still on the board.",

            "Another big factor in our Sunfire Golden Retrievers has been our three kids.\
            Becca (1979) started going to dog events from two weeks old until her teens,\
            and since we were most active when she was young, everyone knew her. &nbsp;Her old-time\
            favorites were Sunshine, Colleen the Collie, Dream, and Winchester. &nbsp;Dan (1987)\
            was the one who instinctively knew how to show in obedience, taking the retired\
            dogs into the ring from age three, Dynamite, Dream, Montana, Sky, and then his\
            own, Sunny and Chiri. &nbsp;Nate (1992) missed much of the competition time with the\
            dogs, we had stepped back from many dog events by the time he was young, getting\
            involved in other aspects of life. &nbsp;He has fond memories of Winchester and Dream,\
            and he has two dogs in 4-H, Mississippi and Breeze. &nbsp;The biggest contribution from\
            the family has been and still is the puppy socialization, and Nate in particular\
            likes when we do puppy temperment testing."
        )
    ),
    new Array (
        "dove",
        "Dove",
        "Sunfire's Mighty Dove SH WCX OD (11/27/1991-11/17/2006)",
        new Array (
            "Fifteen years. &nbsp;What a lifetime.",

            "Little Dove started out as this meek little puppy. &nbsp;Co-owner\
            Mark couldn't understand why we kept such a wimpy little\
            girl. &nbsp;Hah.",

            "One of her first escapades was getting lost on the mountain\
            behind our house. &nbsp;Nick Mickelson (who lived on the other\
            side) found this little four-month-old girl while out\
            walking his dogs, and she was such a wimp, he had to carry\
            her home.",

            "But as time and training went on, this was one incredible\
            little dog, tremendous marking, focus and desire. &nbsp;Some\
            remember her going to pick up a pigeon at a trial, and it\
            taking off skimming across the field with Dove chasing\
            after it. &nbsp;Finally Dove leaped up and got it. &nbsp;Michael\
            remembers the many hours he spent trying to train her not\
            to break, especially for ducks on the water. &nbsp;Even the\
            collar couldn't keep her back.",

            "Unfortunately for Dove, Mike stopped competing when she was\
            in her prime. &nbsp;So, periodically she would take off, to go\
            do some hunting on her own, if you dared to turn your back\
            on her. &nbsp;Her quest was always to find someone who would do\
            something with her. &nbsp;If she didnt find anyone, she would\
            come home in an hour or so.",

            "LIST::" +
                "In the middle of winter, neighbors brought her and\
                half-brother Geri back from their carousing.::" +
                "Another time \"lost\", Dove was found at the foot of a\
                ladder, while a neighbor worked on putting on his roof on\
                his barn. &nbsp;She was content to wait all day for a few pats\
                whenever he came down.::" +
                "O<\/b>nce while out driving looking for her, I spotted a\
                neighbor jogging, and Dove was running right along with\
                her, of course down the middle of the road, oblivious to\
                traffic.::" +
                "Another time, she took off with her granddaughter and\
                ended up a mile down the ridge. &nbsp;A new Golden fancier\
                lived there, and their neighbor thought it was her dogs,\
                and gave her a terrifying call at work to let her know\
                her dogs were out, one old greyfaced one, and a younger\
                blonde one. &nbsp;She rushed home to find hers safe inside,\
                and two \"happy to see you\" strange Goldens in her\
                outdoor run.::" +
                "One day, when she was about eleven, she didnt come home\
                all day, so I put up signs to see if anyone had seen her.\
                About 10:30 at night, she came dragging up the driveway. &nbsp;A\
                neighbor a mile away saw the signs the next day, and said\
                she had been there all day, fetching sticks from their pond\
                for them all day. &nbsp;They finally went to bed, and she came\
                home.::" +
                "Of course the naughtiest running-off was a rainy, overcast\
                day, and I let her out for a few minutes with her litter of\
                puppies that were six weeks old. &nbsp;(of course she wouldn't run\
                away with her pups there?) I come out to find only half\
                her litter, and finally after calling her, Dove comes\
                running up the driveway, with <b>no<\/b> pups. &nbsp;I walked her back\
                down the driveway, and found a puppy poop, so I knew we\
                were on the right track. &nbsp;But do you think she would help\
                find her kids? <b>No.<\/b> She was just delighted that I was out\
                taking her for a walk. &nbsp;As the day wore on, more people\
                helped look, and as it started to become dusk, we were\
                really panicking, pups lost in the woods, with coyotes and\
                other wildlife always a threat! Finally a call to a\
                neighbor, down the driveway, through a field, more than a\
                half mile away, he had found the three pups cold and\
                whimpering hiding in his stone wall.",

            "All the escapades came to an end, not with her old age,\
            because she would use her old-age-hard-of-hearing reason\
            to not come when called, but because of the half-acre fence\
            we installed, special for Dove.",

            "When I called her in the last several years, no matter what\
            hand waving I would use, she would just stand and watch.\
            So I would have to get a bumper, give it a toss, she would\
            run and get it, and always deliver to hand. &nbsp;And then come\
            in for a cookie. &nbsp;Just one more retrieve.",

            "Her last months as age was beginning to show, she would\
            barely eat, but she still had her incredible retriever\
            fetish. &nbsp;Always with a hoard of tennis balls. &nbsp;If a younger\
            dog approached her, she would \"chase\" them off, away from\
            \"her\" balls, and the funny thing was, all the youngsters\
            ran away from her discipline. &nbsp;And she would stand with her\
            ball, imploring you to throw it just once more.",

            "Dove has had several great offspring with great achievements who can be found on\
            <a href=\"http://www.k9data.com/pedigree.asp?ID=41108\" title=\"K9Data -> Sunfire's Mighty Dove SH WCX OD (11/27/1991-11/17/2006)\">K9Data.com (a direct link to Dove's information)<\/a>."
        )
    ),
    new Array (
        "bounce",
        "Bounce",
        "Sunfire's Too Hot to Handle OD (7/14/1992-9/7/2006)",
        new Array (
            "Bounce was sold as a puppy to a lady in Florida, who wanted an\
            obedience dog for her young child (she showed Rottwilers in obedience).\
            &nbsp;After a few months, Bounce came bouncing back to Connecticut,\
            way too much energy for her daughter, and she settled back home here\
            at Sunfire. &nbsp;I do remember some frustrating sessions of over-exhuberant\
            tries at retrieving, she would get the bird, return, but not release\
            it with her steel jaws. &nbsp;But mostly she came back to an easy life,\
            being a beautiful exhuberant, Winchester daughter, and part of the\
            Sunfire family.",

            "Bounce's fame came from her litters, two from OTCH Rocky (whose most\
            famous offspring was NOC2-OTCH Sunfire's Toast of the Town UDX), and\
            two from Geronimo SH WCX CD. &nbsp;From these litters came several great\
            competitors, but most of all devoted, loving companions.",

            "Bounce's biggest attribute was her devotion. &nbsp;She was the epitomy\
            of that song, …Love the one you are with…. &nbsp;Her very favorite time\
            of the year was to go to the Big E as part of the Responsible Dog Booth,\
            and her job was to see how many people would pet her.",

            "At age nine, Bounce's life took on a pleasant change. &nbsp;Rather than being\
            one of many, she went home with a distraught dog lover, who had just lost an\
            older half sister to Bounce. &nbsp;This was going to be a temporary situation,\
            until a pup from an upcoming litter was available. &nbsp;Well, within days, Rita\
            knew that Bounce was her soulmate, and there she lived out her remaining four\
            and a half years. &nbsp;I warned Rita about the agony of taking an older girl home,\
            but they had several healthy and uplifting years together. &nbsp;Now Baby Bounce\
            (Bounce's youngest daughter) will go to try to fill in Rita's soft spot in her\
            heart."
        )
    )
);

//
/* ~~ GLOBAL VARS ~~ */
//
var currAlbumName = "";
var currAlbumNum = -1;
var currImageNum = -1;
var currStoryName = "";
var currStoryNum = -1;
var IE;


//
/* ~~ PAGE ~~ */
//
//onload//
IE = false;
if (navigator.appName == "Microsoft Internet Explorer") {
    IE = true;
    //document.writeln("<style>", "    body { font-size: small; } ", "<\/style>");
}

//
/* ~~ ALBUMS ~~ */
//
//this writes the album view//
function writeAlbumView() {
    if (albums.length == 0)
        document.writeln("<p>No albums found.<\/p>");
    else {
        document.writeln("<div id=\"ALBUMS_INDEX\">");
        document.writeln("    <b>Begin by clicking an album below:<\/b><br \/>");
        document.writeln("    <table class=\"album_index\">");
        document.writeln("        <thead>");
        document.writeln("            <tr>");
        document.writeln("                <td>Album<\/td>");
        document.writeln("                <td>Date/Time<\/td>");
        document.writeln("                <td>Number of Pictures<\/td>");
        document.writeln("            <\/tr>");
        document.writeln("        <\/thead>");
        document.writeln("        <tbody>");
        for (var i = 0; i < albums.length; i++) {
            document.writeln("            <tr>");
            document.writeln("                <td><a href=\"#\" onclick=\"viewAlbum('" + albums[i][0] + "');\" title=\"" + albums[i][1] + "\">" + albums[i][1] + "<\/a><\/td>");
            document.writeln("                <td>" + albums[i][2] + "<\/b><\/td>");
            document.writeln("                <td>" + (albums[i][3].length).toString() + "<\/td>");
            document.writeln("            <\/tr>");
        }
        document.writeln("    <\/table>");
        document.writeln("<\/div>");

        for (var i = 0; i < albums.length; i++) {
            var firstText, previousText, nextText, lastText;
            if (i == 0) {
                firstText       = "disabled=\"disabled\"";
                previousText    = "disabled=\"disabled\"";
            } else {
                firstText       = "title=\"" + albums[0][1] + "\"";
                previousText    = "title=\"" + albums[i - 1][1] + "\"";
            }
            if (i == albums.length - 1) {
                nextText = "disabled=\"disabled\"";
                lastText = "disabled=\"disabled\"";
            } else {
                nextText = "title=\"" + albums[i + 1][1] + "\"";
                lastText = "title=\"" + albums[albums.length - 1][1] + "\"";
            }
            document.writeln("<div id=\"ALBUMS_ALBUM_" + albums[i][0] + "_NAV\" class=\"album_nav\">");
            document.writeln("    Navigate through albums:<br \/>");
            document.writeln("    <button onclick=\"viewAlbumFRST();\" " + firstText + " id=\"ALBUMS_ALBUM_" + albums[i][0] + "_NAV_FRST\">&lt;&lt;-- First<\/button>&nbsp;");
            document.writeln("    <button onclick=\"viewAlbumPREV();\" " + previousText + " id=\"ALBUMS_ALBUM_" + albums[i][0] + "_NAV_PREV\">&lt;-- Previous<\/button>&nbsp;");
            document.writeln("    <button onclick=\"viewAlbumINDX();\" id=\"ALBUMS_ALBUM_" + albums[i][0] + "_NAV_INDX\" title=\"Index of Albums\">Index of Albums<\/button>&nbsp;");
            document.writeln("    <button onclick=\"viewAlbumNEXT();\" "  + nextText + " id=\"ALBUMS_ALBUM_" + albums[i][0] + "_NAV_NEXT\">Next --&gt;<\/button>&nbsp;");
            document.writeln("    <button onclick=\"viewAlbumLAST();\" " + lastText + " id=\"ALBUMS_ALBUM_" + albums[i][0] + "_NAV_LAST\">Last --&gt;&gt;<\/button>");
            document.writeln("    <br \/>");

            document.writeln("    <h3>" + albums[i][1] + "<\/h3>");

            document.writeln("<\/div>");

            document.writeln("<div id=\"ALBUMS_ALBUM_" + albums[i][0] + "_THUMBS\" style=\"width: " + (screen.availWidth - 200).toString() + "px;\" class=\"album_thumbs\">");
            document.writeln("    <table>");
            document.writeln("        <tr>");

            if (albums[i][3].length == 0) {
                document.writeln("            <td>No images found.<\/td>");
            } else {
                var path, sdesc, dim, width, height, ratio, swidth, sheight;
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
                    path = "album/" + albums[i][0] + "/" + path;
                    sdesc = albums[i][3][j][0];
                    width = Number(dim.split("x")[0]);
                    height = Number(dim.split("x")[1]);
                    try {
                        if (width > height) {
                            ratio = height / width;
                            swidth = (100).toString();
                            sheight = (Math.floor(100 * ratio)).toString();
                        } else {
                            ratio = width / height;
                            sheight = (100).toString();
                            swidth = (Math.floor(100 * ratio)).toString();
                        }
                    } catch (ex) {
                        alert(i.toString() + ":" + j.toString());
                    }

                    document.writeln("            <td onclick=\"window.location='#ALBUMS_IMAGE'; viewImage(" + j.toString() + ");\" title=\"" + sdesc + "\">");
                    document.writeln("                <a href=\"#ALBUMS_IMAGE\" onclick=\"viewImage(" + j.toString() + ");\">");
                    document.writeln("                    <img src=\"\" onmouseover=\"this.filters.alpha.opacity=100;\" onmouseout=\"this.filters.alpha.opacity=70;\" id=\"ALBUMS_ALBUM_" + albums[i][0] + "_THUMB_" + j.toString() + "\" name=\"" + path + "\" style=\"width: " + swidth + "px; height: " + sheight + "px;\" alt=\"" + sdesc + "\" title=\"" + sdesc + "\" \/>");
                    document.writeln("                <\/a>");
                    document.writeln("            <\/td>");
                }
            }

            document.writeln("        <\/tr>");
            document.writeln("    <\/table><\/center>");

            document.writeln("<\/div>");
        }

        document.writeln("<br \/>");

        document.writeln("<div id=\"ALBUMS_IMAGE_DIV\" class=\"album_img\">");

        document.writeln("    <a name=\"ALBUMS_IMAGE\"><\/a>");
        document.writeln("    <img class=\"album_img\" id=\"ALBUMS_IMAGE_IMG\" src=\"\" alt=\"\" title=\"\" \/><br \/>");
        document.writeln("    <span class=\"album_sdesc\" id=\"ALBUMS_IMAGE_SDESC\">sdesc<\/span><br \/>");
        document.writeln("    <span class=\"album_ldesc\" id=\"ALBUMS_IMAGE_LDESC\">ldesc<\/span><br \/>");
        document.writeln("    <span class=\"album_datetime\" id=\"ALBUMS_IMAGE_DATETIME\">datetime<\/span><br \/><br \/>");

        document.writeln("    Navigate through pictures:<br \/>");
        document.writeln("    <button onclick=\"viewImageFRST(); window.location='#ALBUMS_IMAGE';\" id=\"ALBUMS_IMAGE_NAV_FRST\">&lt;&lt;-- First<\/button>&nbsp;");
        document.writeln("    <button onclick=\"viewImagePREV(); window.location='#ALBUMS_IMAGE';\" id=\"ALBUMS_IMAGE_NAV_PREV\">&lt;-- Previous<\/button>&nbsp;");
        document.writeln("    <button onclick=\"viewAlbum(currAlbumName);\" id=\"ALBUMS_IMAGE_HIDE\" title=\"Hide large image\">Hide<\/button>&nbsp;");
        document.writeln("    <button onclick=\"viewImageNEXT(); window.location='#ALBUMS_IMAGE';\" id=\"ALBUMS_IMAGE_NAV_NEXT\">Next --&gt;<\/button>&nbsp;");
        document.writeln("    <button onclick=\"viewImageLAST(); window.location='#ALBUMS_IMAGE';\" id=\"ALBUMS_IMAGE_NAV_LAST\">Last --&gt;&gt;<\/button>");

        document.writeln("    <br \/>");
        document.writeln("<\/div>");
    }

    viewAlbumINDX();
}

//shows an album//
function viewAlbum(name) {
    viewAlbumINDX();

    currAlbumName = name;
    for (var i = 0; i < albums.length; i++)
        if (albums[i][0] == name)
            currAlbumNum = i;

    document.title = "Sunfire Golden Retrievers - Albums - " + albums[currAlbumNum][1];

    var div;
    div = document.getElementById("ALBUMS_INDEX");
    div.style.display = "none";
    div = document.getElementById("ALBUMS_ALBUM_" + name + "_NAV");
    div.style.display = "";
    div = document.getElementById("ALBUMS_ALBUM_" + name + "_THUMBS");
    div.style.display = "";
    div = document.getElementById("ALBUMS_IMAGE_DIV");
    div.style.display = "";

    var img;
    for (var j = 0; j < albums[currAlbumNum][3].length; j++) {
        img = document.getElementById("ALBUMS_ALBUM_" + name + "_THUMB_" + j.toString());
        if (img.name == "LOADED")
            continue;
        img.src = "";
        img.src = img.name;
        img.name = "LOADED";
    }

    var btn;
    btn = document.getElementById("ALBUMS_IMAGE_NAV_FRST");
    btn.disabled = true;
    btn.title = "";

    btn = document.getElementById("ALBUMS_IMAGE_NAV_PREV");
    btn.disabled = true;
    btn.title = "";

    btn = document.getElementById("ALBUMS_IMAGE_NAV_NEXT");
    btn.disabled = true;
    btn.title = "";

    btn = document.getElementById("ALBUMS_IMAGE_NAV_LAST");
    btn.disabled = true;
    btn.title = "";

    btn = document.getElementById("ALBUMS_IMAGE_HIDE");
    btn.disabled = true;

    var span;
    span = document.getElementById("ALBUMS_IMAGE_SDESC");
    span.firstChild.nodeValue = "Click an image above to see it larger with its description.";
    span = document.getElementById("ALBUMS_IMAGE_LDESC");
    span.firstChild.nodeValue = " ";
    span = document.getElementById("ALBUMS_IMAGE_DATETIME");
    span.firstChild.nodeValue = " ";
}

//shows the index//
function viewAlbumINDX() {
    currAlbumNum = -1;
    currAlbumName = "";

    document.title = "Sunfire Golden Retrievers - Albums";

    var div;
    for (var i = 0; i < albums.length; i++) {
        div = document.getElementById("ALBUMS_ALBUM_" + albums[i][0] + "_NAV");
        div.style.display = "none";
        div = document.getElementById("ALBUMS_ALBUM_" + albums[i][0] + "_THUMBS");
        div.style.display = "none";
    }

    div = document.getElementById("ALBUMS_INDEX");
    div.style.display = "";
    div = document.getElementById("ALBUMS_IMAGE_DIV");
    div.style.display = "none";

    var img;
    img = document.getElementById("ALBUMS_IMAGE_IMG");

    img.src = "";
    img.alt = "";
    img.title = "";
    img.style.width = "0px";
    img.style.height = "0px";
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
    if (currAlbumName == "" || currAlbumNum == -1) return;

    var img, sdesc, ldesc, datetime, path, dim, apercent, awidth, width, height, ratio, lwidth, lheight;
    img = document.getElementById("ALBUMS_IMAGE_IMG");

    switch (albums[currAlbumNum][3][imgNum].length) {
        case 3:
            dim = "640x480";
            path = imgNum.toString() + ".png";
            break;
        case 4:
            if (albums[currAlbumNum][3][imgNum][3].indexOf("x") == -1) {
                dim = "640x480";
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
            if (albums[currAlbumNum][3][imgNum][4].indexOf("x") == -1) {
                dim = "640x480";
            } else {
                dim = albums[currAlbumNum][3][imgNum][4];
            }
            break;
    }
    path = "album/" + albums[currAlbumNum][0] + "/" + path;
    sdesc = albums[currAlbumNum][3][imgNum][0];
    ldesc = albums[currAlbumNum][3][imgNum][1];
    datetime = albums[currAlbumNum][3][imgNum][2];
    if (datetime != "")
        datetime = "Picture taken " + datetime;

    document.title = "Sunfire Golden Retrievers - Albums - " + albums[currAlbumNum][1] + " - " + sdesc;

    apercent = 0.5;
    awidth = screen.availWidth * apercent;
    width = Number(dim.split("x")[0]);
    height = Number(dim.split("x")[1]);
    if (width > height) {
        ratio = height / width;
        lwidth = awidth.toString();
        lheight = (Math.floor(awidth * ratio)).toString();
    } else {
        ratio = width / height;
        lheight = awidth.toString();
        lwidth = (Math.floor(awidth * ratio)).toString();
    }

    img.src = "";
    img.src = path;
    img.alt = sdesc;
    img.title = sdesc;
    img.style.width = lwidth + "px";
    img.style.height = lheight + "px";

    var span;
    span = document.getElementById("ALBUMS_IMAGE_SDESC");
    span.firstChild.nodeValue = sdesc;
    span = document.getElementById("ALBUMS_IMAGE_LDESC");
    span.firstChild.nodeValue = ldesc;
    span = document.getElementById("ALBUMS_IMAGE_DATETIME");
    span.firstChild.nodeValue = datetime;

    var btn;
    if (imgNum == 0) {
        btn = document.getElementById("ALBUMS_IMAGE_NAV_FRST");
        btn.disabled = true;
        btn.title = "";

        btn = document.getElementById("ALBUMS_IMAGE_NAV_PREV");
        btn.disabled = true;
        btn.title = "";
    } else {
        btn = document.getElementById("ALBUMS_IMAGE_NAV_FRST");
        btn.disabled = false;
        btn.title = albums[currAlbumNum][3][0][0];

        btn = document.getElementById("ALBUMS_IMAGE_NAV_PREV");
        btn.disabled = false;
        btn.title = albums[currAlbumNum][3][imgNum - 1][0];
    }

    if (imgNum == albums[currAlbumNum][3].length - 1) {
        btn = document.getElementById("ALBUMS_IMAGE_NAV_NEXT");
        btn.disabled = true;
        btn.title = "";

        btn = document.getElementById("ALBUMS_IMAGE_NAV_LAST");
        btn.disabled = true;
        btn.title = "";
    } else {
        btn = document.getElementById("ALBUMS_IMAGE_NAV_NEXT");
        btn.disabled = false;
        btn.title = albums[currAlbumNum][3][imgNum + 1][0];

        btn = document.getElementById("ALBUMS_IMAGE_NAV_LAST");
        btn.disabled = false;
        btn.title = albums[currAlbumNum][3][albums[currAlbumNum][3].length - 1][0];
    }

    btn = document.getElementById("ALBUMS_IMAGE_HIDE");
    btn.disabled = false;

    var div;
    div = document.getElementById("ALBUMS_IMAGE_DIV");
    if (div.style.display == "none")
        div.style.display = "";

    currImageNum = imgNum;
}

//these functions are called by the image buttons to quick move from image to image//
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
//
/* ~~ STORIES ~~ */
//
//this writes the story view//
function writeStoryView() {
    if (stories.length == 0)
        document.writeln("<p>No stories found.<\/p>");
    else {
        document.writeln("<div id=\"STORIES_INDEX\" class=\"stories\">");
        document.writeln("    Begin by clicking a story below:<br \/>");
        for (var i = 0; i < stories.length; i++) {
            document.writeln("    <a href=\"#\" onclick=\"viewStory('" + stories[i][0] + "');\" title=\"" + stories[i][1] + "\" onfocus=\"if (this.blur()) this.blur();\">" + stories[i][1] + "<\/a><br \/>");
        }
        document.writeln("<\/div>");

        for (var i = 0; i < stories.length; i++) {
            var firstText, previousText, nextText, lastText;
            if (i == 0) {
                firstText       = "disabled=\"disabled\"";
                previousText    = "disabled=\"disabled\"";
            } else {
                firstText       = "onclick=\"viewStoryFRST()\" title=\"" + stories[0][1] + "\"";
                previousText    = "onclick=\"viewStoryPREV()\" title=\"" + stories[i - 1][1] + "\"";
            }
            if (i == stories.length - 1) {
                nextText = "disabled=\"disabled\"";
                lastText = "disabled=\"disabled\"";
            } else {
                nextText = "title=\"" + stories[i + 1][1] + "\"";
                lastText = "title=\"" + stories[stories.length - 1][1] + "\"";
            }
            document.writeln("<div id=\"STORIES_STORY_" + stories[i][0] + "_NAV\" class=\"story_nav\">");
            document.writeln("    <b>Navigate through stories:<\/b><br \/>");
            document.writeln("    <button onfocus=\"if (this.blur()) this.blur();\" onclick=\"viewStoryFRST();\" " + firstText + " id=\"STORIES_STORY_" + stories[i][0] + "_NAV_FRST\">&lt;&lt;-- First<\/button>");
            document.writeln("    &nbsp;");
            document.writeln("    <button onfocus=\"if (this.blur()) this.blur();\" onclick=\"viewStoryPREV();\" " + previousText + " id=\"STORIES_STORY_" + stories[i][0] + "_NAV_PREV\">&lt;-- Previous<\/button>");
            document.writeln("    &nbsp;");
            document.writeln("    <button onfocus=\"if (this.blur()) this.blur();\" onclick=\"viewStoryINDX();\" id=\"STORIES_STORY_" + stories[i][0] + "_NAV_INDX\" title=\"Index of Stories\">Index of Stories<\/button>");
            document.writeln("    &nbsp;");
            document.writeln("    <button onfocus=\"if (this.blur()) this.blur();\" onclick=\"viewStoryNEXT();\" "  + nextText + " id=\"STORIES_STORY_" + stories[i][0] + "_NAV_NEXT\">Next --&gt;<\/button>");
            document.writeln("    &nbsp;");
            document.writeln("    <button onfocus=\"if (this.blur()) this.blur();\" onclick=\"viewStoryLAST();\" " + lastText + " id=\"STORIES_STORY_" + stories[i][0] + "_NAV_LAST\">Last --&gt;&gt;<\/button>");
            document.writeln("    <br \/><br \/>");
            document.writeln("<\/div>");

            document.writeln("<div id=\"STORIES_STORY_" + stories[i][0] + "_STORY\">");

            document.writeln("    <h3>" + stories[i][1] + "<\/h3>");

            if (stories[i][2] != "")
                document.writeln("    <h4>" + stories[i][2] + "<\/h4>");

            document.writeln("    <div class=\"story\">");
            writeStory(i);
            document.writeln("    <\/div>");

            document.writeln("<\/div>");
        }

        document.writeln("<br \/>");
    }

    viewStoryINDX();
}

//writes a story from a paragraph array//
function writeStory(story) {
    var para = "";
    var list; var li = "";
    var firstchar = ' ';
    for (var i = 0; i < stories[story][3].length; i++) {
        if (stories[story][3][i].substr(0, 6) == "LIST::") {
            list = stories[story][3][i].split("::");
            document.writeln("        <ul>");
            for (var j = 1; j < list.length; j++) {
                li = list[j];
                document.writeln("            <li>" + li + "<\/li>");
            }
            document.writeln("        <\/ul>");
        } else {
            para = stories[story][3][i];
            document.writeln("        <p>" + para + "<\/p>");
        }
    }
}

//shows a story//
function viewStory(name) {
    viewStoryINDX();

    currStoryName = name;
    for (var i = 0; i < stories.length; i++) {
        if (stories[i][0] == name) currStoryNum = i;
    }

    document.title = "Sunfire Golden Retrievers - Stories - " + stories[currStoryNum][1];

    var div;
    div = document.getElementById("STORIES_INDEX");
    div.style.display = "none";
    div = document.getElementById("STORIES_STORY_" + name + "_NAV");
    div.style.display = "";
    div = document.getElementById("STORIES_STORY_" + name + "_STORY");
    div.style.display = "";
}

//shows the index//
function viewStoryINDX() {
    currStoryNum = -1;
    currStoryName = "";

    document.title = "Sunfire Golden Retrievers - Stories";

    var div;
    for (var i = 0; i < stories.length; i++) {
        div = document.getElementById("STORIES_STORY_" + stories[i][0] + "_NAV");
        div.style.display = "none";
        div = document.getElementById("STORIES_STORY_" + stories[i][0] + "_STORY");
        div.style.display = "none";
    }

    div = document.getElementById("STORIES_INDEX");
    div.style.display = "";
}

//these functions are called by the story buttons to quick move from story to story//
function viewStoryFRST() {
    viewStory(stories[0][0]);
}
function viewStoryPREV() {
    viewStory(stories[currStoryNum - 1][0]);
}
function viewStoryNEXT() {
    viewStory(stories[currStoryNum + 1][0]);
}
function viewStoryLAST() {
    var end = stories[currStoryNum][3].length - 1;
    viewStory(stories[end][0]);
}
