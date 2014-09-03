<?php

$templ_page_valid = TRUE;

include_once('style/templ.php');

$filemtime = '2009-08-08';

// start and <head> tags
get_page_sect_head();

// top of page
get_page_sect_top();

?>
    <script type="text/javascript">
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
      var currStoryName = "";
      var currStoryNum = -1;
      
      //this writes the story view//
      function writeStoryView() {
        document.writeln("<a name=\"story_index\" id=\"story_index_a\"><\/a>");
        if (stories.length == 0)
          document.writeln("<p>No stories found.<\/p>");
        else {
          document.writeln("<div id=\"story_index\" class=\"story_index\">");
          document.writeln("  <h6>Begin by clicking a story below:<\/h6>");
          for (var i = 0; i < stories.length; i++) {
            document.writeln("  <a href=\"#\" onclick=\"viewStory('" + stories[i][0] + "'); return false;\" title=\"" + stories[i][1] + "\">" + stories[i][1] + "<\/a>");
          }
          document.writeln("<\/div>");

          for (var i = 0; i < stories.length; i++) {
            var firstText, previousText, nextText, lastText;
            if (i == 0) {
              firstText       = "disabled=\"disabled\" class=\"disabled\"";
              previousText    = "disabled=\"disabled\" class=\"disabled\"";
            } else {
              firstText       = "title=\"" + stories[0][1] + "\"";
              previousText    = "title=\"" + stories[i - 1][1] + "\"";
            }
            if (i == stories.length - 1) {
              nextText = "disabled=\"disabled\" class=\"disabled\"";
              lastText = "disabled=\"disabled\" class=\"disabled\"";
            } else {                              
              nextText = "title=\"" + stories[i + 1][1] + "\"";
              lastText = "title=\"" + stories[stories.length - 1][1] + "\"";
            }
            document.writeln("<div id=\"story_" + stories[i][0] + "\">");
            document.writeln("  <div id=\"story_" + stories[i][0] + "_nav\" class=\"story_nav\">");
            document.writeln("    <a name=\"story\" id=\"story_" + stories[i][0] + "_a\"><\/a>");
            document.writeln("    <h6>Navigate through stories:<\/h6>");
            document.writeln("    <button onmouseover=\"overBtn(this);\" onmouseout=\"outBtn(this);\" onmousedown=\"downBtn(this);\" onmouseup=\"overBtn(this);\" onclick=\"viewStoryFRST();\" " + firstText + " id=\"story_" + stories[i][0] + "_nav_first\">&lt;&lt;-- First<\/button>");
            document.writeln("    <button onmouseover=\"overBtn(this);\" onmouseout=\"outBtn(this);\" onmousedown=\"downBtn(this);\" onmouseup=\"overBtn(this);\" onclick=\"viewStoryPREV();\" " + previousText + " id=\"story_" + stories[i][0] + "_nav_prev\">&lt;-- Previous<\/button>");
            document.writeln("    <button onmouseover=\"overBtn(this);\" onmouseout=\"outBtn(this);\" onmousedown=\"downBtn(this);\" onmouseup=\"overBtn(this);\" onclick=\"viewStoryINDX();\" id=\"story_" + stories[i][0] + "_nav_index\" title=\"Index of Stories\">Index<\/button>");
            document.writeln("    <button onmouseover=\"overBtn(this);\" onmouseout=\"outBtn(this);\" onmousedown=\"downBtn(this);\" onmouseup=\"overBtn(this);\" onclick=\"viewStoryNEXT();\" "  + nextText + " id=\"story_" + stories[i][0] + "_nav_next\">Next --&gt;<\/button>");
            document.writeln("    <button onmouseover=\"overBtn(this);\" onmouseout=\"outBtn(this);\" onmousedown=\"downBtn(this);\" onmouseup=\"overBtn(this);\" onclick=\"viewStoryLAST();\" " + lastText + " id=\"story_" + stories[i][0] + "_nav_last\">Last --&gt;&gt;<\/button>");
            document.writeln("  <\/div>");

            document.writeln("  <div id=\"story_" + stories[i][0] + "_story\">");

            document.writeln("    <h3>" + stories[i][1] + "<\/h3>");

            if (stories[i][2] != "")
              document.writeln("    <h4>" + stories[i][2] + "<\/h4>");

            document.writeln("    <div class=\"story_content\">");
            writeStory(i);
            document.writeln("    <\/div>");

            document.writeln("  <\/div>");
            document.writeln("<\/div>");
          }
        }
        
        currStoryNum = -1;
        currStoryName = "";
        
        var div;
        for (var i = 0; i < stories.length; i++) {
          div = document.getElementById("story_" + stories[i][0]);
          div.style.display = "none";
        } 

        div = document.getElementById("story_index");
        div.style.display = "block";
        
        if (location.href.indexOf("#") < 0) {
          window.location = "#story_index";
          currUrl = location.href;
        }
      }

      //writes a story from a paragraph array//
      function writeStory(story) {
        var para = "";
        var list; var li = "";
        var firstchar = ' ';
        for (var i = 0; i < stories[story][3].length; i++) {
          if (stories[story][3][i].substr(0, 6) == "LIST::") {
            list = stories[story][3][i].split("::");
            document.writeln("       <ul>");
            for (var j = 1; j < list.length; j++) {
              li = list[j];
              document.writeln("         <li>" + li + "<\/li>");
            }
            document.writeln("       <\/ul>");
          } else {
            para = stories[story][3][i];
            document.writeln("       <p>" + para + "<\/p>");
          }
        }
      }

      //shows a story//
      function viewStory(name) {
        currStoryNum = -1;
        currStoryName = name;
        for (var i = 0; i < stories.length; i++)
          if (stories[i][0] == name)
            currStoryNum = i;

        if (currStoryNum == -1) {
          alert("Unknown story '" + name + "'.");
          return;
        }

        document.title = "Sunfire Golden Retrievers - Stories - " + stories[currStoryNum][1];

        var div;
        for (var i = 0; i < stories.length; i++) {
          div = document.getElementById("story_" + stories[i][0]);
          div.style.display = "none";
        }
        div = document.getElementById("story_index");
        div.style.display = "none";
        div = document.getElementById("story_" + name);
        div.style.display = "block";

        var a;
        a = document.getElementById("story_" + currStoryName + "_a");
        a.name = "story_" + currStoryName;
        
        window.location = "#" + a.name;
        currUrl = location.href;
      }

      //shows the index//
      function viewStoryINDX() {
        currStoryNum = -1;
        currStoryName = "";

        document.title = "Sunfire Golden Retrievers - Stories";

        var div;
        for (var i = 0; i < stories.length; i++) {
          div = document.getElementById("story_" + stories[i][0]);
          div.style.display = "none";
        }

        div = document.getElementById("story_index");
        div.style.display = "block";
        
        window.location = "#story_index";
        currUrl = location.href;
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
        viewStory(stories[stories.length - 1][0]);
      }
      
      //these functions disable and enable buttons
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
      
      //allows the back, refresh, and direct link capabilities to go to the specific story, rather than the index
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
            if (loc == "story_index") {
              viewStoryINDX();
            } else if (loc.substring(0, 6) == "story_") {
              var locarr = loc.split("_");
              if (locarr.length == 2 || locarr.length == 3) {
                viewStory(locarr[1]);
              } else {
                alert("Invalid story locator.");
              }
            }
          }
        }
        
        backTimer = setTimeout("backTick();", 1000);
      }
    </script>

      <h2>Stories</h2>

      <hr />

      <script type="text/javascript">writeStoryView();</script>
    </div>
<?php

// bottom of page
get_page_sect_bottom();

?>