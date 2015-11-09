--------------------------------------------------
VArcade 1.7
PHP-Fusion v 7.0 --->
Author: Domi/Fetloser
Some code is re-used from Ausimods, Thank you!
Some code is re-used from Rene, Thank you!
Some code is re-used from Nick Jones, Thank you!
--------------------------------------------------

DESCRIPTION
-----------
A clean & nice Arcade system for your site.

WHATS IN THE BOX?
-----------------

First of all a big thank you to (no particular order) 
Ausimods, Rene, and of course Digitanium (Nick) , KEFF (did i miss anyone?)

Ausimods for enableing the scoreing system큦 & technique큦 used to collect scores from games.
We actually support 3 methods, IPB,PHPBB,ARCADE V2.
Rene who have done so many good mods to the Arcade, iam sorry he is no longer active!
So in contribution to Rene who said we could continue his work if we wanted.
We now use the following that is produced by him, altho some have been re-written.
Digitanium for haveing tons of good snipets all over his PHP-Fusion system ready to use! ;)
KEFF for introducing AGPL system to PHP-Fusion.

1 The sound system 
2 The index system 
3 The Personal Favorites system
4 The PM on Hi-score system (altho i think he got the code idea from me? hehe)
5 The king큦 system.
6 The neat total hi-score큦 from a player system.
(did i miss anything?)

Whats in the VArcade box >>>

- Automated tournament system that saves records & displays latest tournaments with winners.
- Automated game size detection for games with new embed rutines.
- Users have their own personal favorite system & easy access & manageing from the Arcade index.
- Users can send neat game tip큦 to friends.
- Users can report broken games.
- Users Comment every game (uses fusions comment table type (G).
- Users can click on a Hi-Score holder큦 name in game to see all Hi-Scores from that player.
- Hi-scores will be PMed to a member when a Hi-score is beated & a neat sound is played.
- A new PHP-Fusion style listings when browsing games with options from settings.
- Fast Ajax search function that will list hit큦 just as they would be shown in category browseing.
- Games can be turned off / on when testing and evaluating, they will be found in the Parked area in the admin section.
- Fusions own group access system can be applied to individual games and/or to whole categories, If a game that is public is listed in a category that have costume group status it will not work either.
- Administrators have an easy & quick admin for the games when browsing, wich wont re-load page or relocate you when new values is beeing saved.
- Game size can be shown in top right corner.
- Ajax 5 star voteing system.
- Quick jump category selection bar in top right corner.
- Randomize game function, for people who just can큧 decide !
- Allow or disallow guests to play, with nice redirects to make em register or to keep playing anonymous.
- Allow gamers to either play in popup or embed mode.
- Almost all user & automated features is optional ,everything can be on or off verry easy via the settings page.
- You can run our upgrade script if you wanto keep records & stats from your old Arcade.
- User gold support
- Keep alive큦 (Players who play will stay online)
- And much more !!


UPGRADING
---------
Wanto upgrade your old arcade to VArcade ?, please read the upgrade.txt file.


USAGE
-----
Admin:
1. Go to Administration > System admin, click the "infusions" icon.
2. Makesure activegames.php & switcher.swf is in your index/news.php folder if you use the center panel and have playing now activated.
3. To add games, simply have them in your varcade/games/upload folder & images in the /thumb folder & name them the same, then use the autoloader, 3 games is with this pack!
4. To edit a game, select, edit and save
5. VArcade will probably work just fine on its own, but you can via the settings section adjust some settings - such as:
use of popups
Auto detection of game size
Tournaments on or off etc.


UNINSTALLATION
--------------
1. Go to Infusion Management, uninstall "VArcade".
2. Deactivate/delete any used panels.
-----------------------------------------

Change log 1.6 :
Added express installation of flash feature to auto upgrade flash to 9 series, requires flash > 6 to work.
Added a url & Download Flash Player link if you dont have flash version over 6 or at all. 
Fixed the issue where no subjects would be sent in Tournament PM큦. (thank you wolfcore)
Fixed a issue where gold system & ratings on together would move stars way right. (thank you poet)
Added a score cleaning procedure, we dont need to save scores that dont make top 25 list. (If you currently have big individual score entry큦 they will slowly be cleaned for every new score submitted until they are down to 25 top scores, we only delete 1 score (lowest or highest depending on reversed or not) each time a score is submitted thats is above 25 count).
Added the BoxOver script to VArcade center panel, displaying Title, icon & Hi-score holder.
Added path to banner instead of useing sitebanner, primarly for the tip a friend system (thank you dusk).
Added a extra tracking feature for what game is beeing played and what type of users is playing (guests/members) it can have some nice future possibilites like gamer큦 online etc, works pretty much like fusions online users system,except this is ajax driven & will keep users & games alive aslong as they are playing without reloading page , wich btw took me quite a while to get the function to work so enjoy it!
2 new tables was required. 
Added locale큦 under 
//Settings
//misc
Fixed so all VArcade related scores,comments & ratings is deleted on game deletion. (thank you wolfcore)
Added an image error check for centerpage / listings / related, /img/arcade.gif is now default image if no image is found.
Changed some http_post_vars / get_vars to _post / _get. (thank you slaughter)
Added some various scoreing security.
Fixed an issue where some games would take a nasty orange backgound color (thank you aulophobia)
Reversed scoreing is now working properly.
Guests can nolonger try to score in tournament큦, even tho the score cleaning procedure took care of that.
Parked games will not be counted in main index anymore (thank you dusk).
Parked & Error tagged games will now start in popup mode when test is initated by admin.
Add German locale큦 (Thank you slaughter)


Change log 1.5 :
We will nolonger count parked games in the totals.
Fixed the play again button.
Games that was picked for Tournament will no longer be locked in Tournament mode when tournaments is turned off.
Fixed some lose locale큦
Added a instant click create point큦 table if turned on & required table큦 dont exist. (translators check //settings)
Changed layout so comment큦 / tip a friend / ratings now can be turned off individualy ingame큦 , made a side panel wich is optional.
Added related game큦 bar, (will random 5 games from current category), optional
Added 
$locale['VARC324'] ="There is no parked or lose games to be found";
Under //parked above 325.
re added localization to error section in score files, i some how lost it.
Added
$locale['VARC324'] ="There is no parked or lose games to be found";
$locale['VARC162'] = "Related games";
Added some more locale큦 to //settings.
Fixed a locale mixup issue in admin/error큦, (remove error tag was listed twice where one should be delete the game).


Change log 1.4 :

Fixed a quick edit problem where the numbers would be set to blank instead of 0큦 wich screwed auto detection override.
Fixed the issues where sides would include even in popup mode from clicking name or score in game큦.
Fixed so guest play settings dosent only apply in popup mode!
Changed the way favourites read its content vs game table so titels wont mather.
Fixed the arcade_center_panel centering problem with Firefox. (Thank you Matonor).
Including the events panel
Fixed so the gameover.php links properly when in popup mode.
Fixed player_hiscore pageination will work properly when in popup mode.
Added support for user gold, if Gold system is on & guest큦 is allowed to play, the games will work anyway for the guests.
Added Onlinestatus function, (will keep players online when they play games) (optional).
Added Rateings, comments, tip a friend options from ingame, this will only work if all 3 of these is activated due to layout.
Fixed access issues with random.php, it now actually look for access & game status.
Fixed a redirect of users when they try to access a game they do not have access to so they know what happens,
Added a autodetection of members_bewerb infusion to this where they can apply to your user groups.
If the infusion dont exist we simply link to the standard contact form.
Added a nice Admin icon, make sure you copy it to the administration/images.
Added top rated games section to center panel
Added Dutch locale (Thank you dusk)


Change log 1.3

Updated missing locale큦 (Thank you helmuth)
Changed the path back to uploads/, point taken, (Thank you Starglowone).
(Dont worry just copy all files rename "games" folder to "uploads" and youre done).
Fixed so users will play in popup mode if option is on when Hi-score beated PM is sent.
Fixed so scores beated in tournaments also cleared lower scores & send PM properly.
Fixed the issue where no guest play option enabled also would kick out members.
Added Italan language, (Thank you GameAction, Ps check //MISC)

Change log 1.2

Notice큦 for Tournament locale큦 fixed.
Fixed special char problems with certain servers in the search.
Fixed a locale issue in admin where hi-score date was listed twice.
Fixed the path issue with Tournament center panel.
Added Danish locale, (thank you helmuth).
Added a quick game search function in administration.


Change log 1.1
Its now possible to set individual width & height on games even with automatic size detection on, because some games are just to small or simply to big.

For it to work we need to run this in a costume page, 
(only do this if you run automatic detetion).
[code]
<?php
$result = dbquery("UPDATE ".$db_prefix."varcade_games SET width='0'"); 
$result = dbquery("UPDATE ".$db_prefix."varcade_games SET height='0'");
?>
[/code]
Once this is run, everything with a value will be read so individual games can get its own values. (
Fixed a admin bug where lastplayed & hiscore would reset on edit saves.

