<?PHP
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| User Gold 3
| Copyright © 2007 - 2008 UG3 Developement Team
| http://www.starglowone.com/
+--------------------------------------------------------+
| Filename: English/admin/upgrade.php
| Author: UG3 Developement Team
| Note: This file is used by the infusion.php too
+--------------------------------------------------------+
| This program is released as free software under the
| Stars Heaven Licence. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included licence.html.
| Removal of this copyright header is strictly
| prohibited without written permission
| from the original author(s).
+--------------------------------------------------------*/
global $aidlink;
$ug3_upgrade['upg_000'] = "INSTALL";
$ug3_upgrade['upg_001'] = "Welcome to the new user gold system version 3.00<br />
	The new system has many features i am sure you will like as well as the normal features you wont like and things it should have in your opinion.
	<br />
	However here it is and if you dont like it then i sugest you dont use it.
	<br />
	The usergold infusion is not open source and is released under the terms and conditions stated in the licence.
	<br />
	Under no circumstances may you distribute or allow to be distributed this code or any dirivitives of this code.
	<br />
	Mild encryption has been used on the code in an attempt to at least slow down the continual code theft. If you have objections to this again i recommend that you do not install the infusion.
	<br />
	This infusion includes simple one line functions that will allow you to do pretty much anything you want within your own scripts or sites and is completely templated to allow your modification of the apearence.
	<br />
	The user gold infusion has a version check system built in which will cause it to visit the version server in an attempt to verify your version is up to date. The version check is only run from the administration area and at no time should it interfere with the normal speed of your site and does not send any information it recieves the version number only. If this is a problem again dont use it.
	<br />
	Everything that has been done is for the benifit of you and your site with no other intention but with that said we do understand that some people dont see a reason for anything that works inside an open source project to be anything but open source.
	<br />";
$ug3_upgrade['upg_002'] = "I agree to the terms and conditions of use.";
$ug3_upgrade['upg_006'] = "You have chosen to continue with the installation so here we are at step one \"The table creation process\".<br />During this process several new tables will be added to your database<br /> All of these tables are required for the successful install of the system and you should not do anything until the operation is completed.";
$ug3_upgrade['upg_007'] = "I want any exsisting tables removed.";
$ug3_upgrade['upg_008'] = "On continue the tables will be created nothing else.";
$ug3_upgrade['upg_009'] = "Your new tables have been created<br /> The next step is to add some default information to the system to prepare it for your first use<br />";
$ug3_upgrade['upg_010'] = "Sorry but there is no point in giving you any options here becouse without some defualt data nothing works :)<br />
	So click continue to get it over with<br />
	You can alter any of these settings later from the admin area<br />";
$ug3_upgrade['upg_011'] = "Theres been a problem createing the new tables<br />";
$ug3_upgrade['upg_012'] = "The basic settings have been added to the system<br /> The next step is to move your current users if you have any into the new system with their gold intact.<br />";
$ug3_upgrade['upg_013'] = "Do you want to move your current user_gold users into the new system inclusive of current gold totals?";
$ug3_upgrade['upg_014'] = "There are many reasons that problems may have occured here and you may know them but i dont so please select from the following list what you want to do now.
		<br />
			If you want to ignore the problem and continue <a href=\"install.php".$aidlink."&amp;op=moveusersquestion\">click here</a>
		<br />
		if you want to restart the database entries <a href=\"install.php".$aidlink."&amp;op=buildtablesaction&removetables=1\">click here</a>. Warning: All Tables will be recreated using this recovery method!
		<br />
		Finally if you just give up you can go to the <a href=\"install.php".$aidlink."\">Start</a> or <a href=\"install.php?op=finish\">Finish</a>
		<br />";
$ug3_upgrade['upg_015'] = "Do you want to move your current user_gold users into the new system inclusive of current gold totals?";
$ug3_upgrade['upg_016'] = "Successful transfer of";
$ug3_upgrade['upg_017'] = "Failed to transfer";
$ug3_upgrade['upg_018'] = "Illegal user";
$ug3_upgrade['upg_019'] = "Was not transferred";
$ug3_upgrade['upg_020'] = "Users with an id less than zero are not part of this system so the user was not moved to ensure its security is not at risk.";
$ug3_upgrade['upg_021'] = "Doesnt seem to be a user points table available so i cant move the data for you.";
$ug3_upgrade['upg_022'] = "Since there is nothing more i can do to assist you with this update please";
$ug3_upgrade['upg_023'] = "click here";
$ug3_upgrade['upg_024'] = "to finalise your new install";
$ug3_upgrade['upg_025'] = "Thankyou for useing the user gold infusion version 3 i hope you and your users enjoy the many functions available to add to the interaction on your site.
<br />
It is important that you now check the configuration settings to ensure i got everything correct after all i am just lines of text really and cant read or do anything i am not told to do.<br />
I did not remove any of the original user gold system so if you want to get rid of me the flasher new version please enter the administration area of your site and simply defuse me and i will be gone.<br />
<strong>Allthough this file is accessable only by super administrators it is advised strongly that you now remove it from your server for security reasons</strong><br />
 Click <a href='index.php".$aidlink."'>here</a> to go to the admin area or <a href='".BASEDIR."index.php'>here</a> to go to your site.";
$ug3_upgrade['upg_026'] = "Default Settings and a few basic items have been added";
$ug3_upgrade['upg_027'] = "There was a problem adding the default data";
$ug3_upgrade['yes'] = "Yes";
$ug3_upgrade['no'] = "No";
$ug3_upgrade['finish'] = "Finish";
$ug3_upgrade['change_me'] = "Change Me!";
$ug3_upgrade['welcome_to'] = "Welcome To";
$ug3_upgrade['hello'] = "Hello";
$ug3_upgrade['agree'] = "AGREE";
$ug3_upgrade['continue'] = "Continue";
$ug3_upgrade['cancel'] = "Cancel";
		
$ug3_upgrade['UGLD_TEMPLATE'] = "What template you want to use (Default: default)";
$ug3_upgrade['UGLD_GOLDTEXT'] = "What is the name of your currency (Default: Dollars)";
$ug3_upgrade['UGLD_SELFDONATE_ALLOW'] = "Nothing worse than being broke. Do you want to allow your users to donate to themselves if they have limited funds? The number you place here must be above 0 to activate the system and is the maximum amount a user may have in bank and cash to be allowed to donate (Default: 100)";
$ug3_upgrade['UGLD_BANK_NAME'] = "What is the name of your bank (Default: UgBank)";
$ug3_upgrade['UGLD_BANK_ENABLED'] = "Bank Doors so to speak either 1 to open the bank or 0 to close it (Default: 1)";
$ug3_upgrade['UGLD_BANK_INTEREST'] = "What is the current inerest rate at your bank? (Default: 10)";
$ug3_upgrade['UGLD_CURRENCY_PREFIX'] = "What prefix if any do you want to use for your currency (Default: $)";
$ug3_upgrade['UGLD_CURRENCY_SUFFIX'] = "What is the last thing seen after your currency is displayed (Default: &yen;)";
$ug3_upgrade['UGLD_DECIMAL'] = "Where should the decimal be placed (Default: 2)";
$ug3_upgrade['UGLD_DECPOINT'] = "What is the symbol for your decimals (Default: .)";
$ug3_upgrade['UGLD_DISPLAY_USAGE_INDEX'] = "Do you want to display a usage list in the front (Default: 1)";
$ug3_upgrade['UGLD_SELFDONATE_MAX'] = "What is the maximum a user is able to randomly get in the auto donate system (Default: 100)";
$ug3_upgrade['UGLD_BANK_DEPOSIT_MIN'] = "What is the minimum deposit accepted by your bank?(Default: 100)";
$ug3_upgrade['UGLD_SELFDONATE_MIN'] = "What is the minimum a user is able to randomly get in the auto donate system(Default: 1)";
$ug3_upgrade['UGLD_BANK_WITHDRAW_MIN'] = "What is the minimum auser can withdraw from the bank(Default: 50)";
$ug3_upgrade['UGLD_THOUSANDS'] = "What is the symbol for your thousands (Default: ,)";
$ug3_upgrade['USERGOLD'] = "Turn the complete gold system on or off (Default: 1)";
$ug3_upgrade['UGLD_REGISTER'] = "How much do you want to give your users on registration. 0 will turn this off (Default:  100)";
$ug3_upgrade['UGLD_VISABLE_COPY'] = "Setting this to 0 will remove the visable copywrite and leave in its place a hidden notice that is seen by no-one who is not looking for it.<br />It is not allowed to remove the copywrite!! (Default: 0)";
$ug3_upgrade['GLD_FORUM_ADD_POSTS_PERCENT'] = "The % of posts a user gets when buying extra forum posts (Default: 10)";
$ug3_upgrade['UGLD_IMAGE_HEIGHT'] = "The image height on images in inventory, shop etc (Default: 50)";
$ug3_upgrade['UGLD_IMAGE_WIDTH'] = "The image width on images in inventory, shop etc (Default: 50)";
$ug3_upgrade['GLD_KARMA'] = "Turn the karma system on or off (Default: 1)";
$ug3_upgrade['GLD_STEAL'] = "Turn the steal system on or off (Default: 1)";
$ug3_upgrade['GLD_STEAL_BUY'] = "The amount to charge when a user buys a newchance to steal (Default: 2000)";
$ug3_upgrade['GLD_FORUM_ADD_POSTS'] = "Turn the addposts system on or off (Default: 0)";
$ug3_upgrade['GLD_FORUM_ADD_POSTS_COST'] = "Cost per post, when buying extra forum posts (Default: 10)";
$ug3_upgrade['GLD_GAMBLE'] = "Turn the gamble system on or off (Default: 1)";
$ug3_upgrade['GLD_JOINED'] = "The amount to charge when a user buys a new join date (Default: )";
$ug3_upgrade['GLD_CRIME'] = "Turn the crime system on or off (Default: 0)";
$ug3_upgrade['UGLD_GAMBLE_LOW'] = "Minimum amount to recieve when gambling (Default: 10000)";
$ug3_upgrade['UGLD_GAMBLE_HIGH'] = "Maximum amount to recieve when gambling (Default: 100000)";
$ug3_upgrade['UGLD_GAMBLE_ALLOW'] = "Maximum amount a user can have to gamble (Default: 100000)";
$ug3_upgrade['UGLD_DONATE_RIBBON'] = "The amount required for a user to get a ribbon (Default: 999999999)";
$ug3_upgrade['UGLD_USERLEVEL_DISALLOW'] = "Names not allowed to be used as userlevel names (Separate every name with an :)";

$ug3_upgrade['GLD_FORUM_QUICK_REPLY'] = "Payout for quick reply (Default: 5)";
$ug3_upgrade['GLD_FORUM_POST_REPLY'] = "Payout for forum response (Default: 10)";
$ug3_upgrade['GLD_FORUM_NEW_THREAD'] = "Payout for a new forum thread (Default: 20)";
$ug3_upgrade['GLD_FORUM_ATTACHMENT'] = "Payout for a forum attachment (Default: 10)";
$ug3_upgrade['GLD_FORUM_SIG'] = "Allow user to have a personalised signature (Default: 1000)";
$ug3_upgrade['GLD_AVATAR'] = "Allow user to have a personalised avatar (Default: 1000)";
$ug3_upgrade['GLD_THEME_SELECT'] = "Allow user to select from the available themes (Default: 200)";
$ug3_upgrade['GLD_USERNAME_COLOR'] = "Allow user to choose a color for his/hers username (Default: 1000)";
$ug3_upgrade['GLD_USERNAME_BLINK'] = "Allow user to get their username to blink (Default: 1000)";
$ug3_upgrade['GLD_USERNAME_BOLD'] = "Allow user to get their username in bold (Default: 1000)";
$ug3_upgrade['GLD_USERNAME_ITALIC'] = "Allow user to get their username in italic (Default: 1000)";
$ug3_upgrade['GLD_USERNAME_STRIKE'] = "Allow user to get their username in strike (Default: 1000)";
$ug3_upgrade['GLD_USERLEVEL'] = "Allow user to change the name of the userlevel (Default: 100000)";
$ug3_upgrade['GLD_BANK_ACCOUNT'] = "Allow users to have their own bank account (Default 200)";
$ug3_upgrade['GLD_USERNAME_BLINK_BLOCK'] = "Allow user to block blinking usernames (Default: 100)";
$ug3_upgrade['GLD_FORUM_POLL'] = "Payout for creating a poll in the forum (Default: 5)";
$ug3_upgrade['GLD_FORUM_POLL_VOTE'] = "Payout for voting on a poll in the forum (Default: 2.5)";
$ug3_upgrade['UGLD_WELCOME_PM'] = "Turn the Welcome PM on or off (Default: 1)";
$ug3_upgrade['UGLD_WELCOME_PM_SUBJECT'] = "The subject of the welcome pm used when sending welcome pm on register";
$ug3_upgrade['UGLD_WELCOME_PM_MESSAGE'] = "The message in the welcome pm used when sending welcome pm on register (%s is replaced by the username in the message)";
$ug3_upgrade['GLD_WEBLINK_SUBMIT'] = "Payout for submitting a weblink (Default: 5)";
$ug3_upgrade['GLD_NEWS_SUBMIT'] = "Payout for submitting news (Default: 20)";
$ug3_upgrade['GLD_ARTICLE_SUBMIT'] = "Payout for submitting an article (Default: 20)";
$ug3_upgrade['GLD_PHOTO_SUBMIT'] = "Payout for submitting a photo (Default: 5)";
$ug3_upgrade['GLD_SHOUTBOX'] = "Payout for posting in the shoutbox (Default: 2)";

$ug3_upgrade['USER_GOLD_3_CAT_TITLE'] = "User Gold 3";
$ug3_upgrade['USER_GOLD_3_CAT_DESC'] = "Default User Gold 3 Category";
$ug3_upgrade['USERNAME_CAT_TITLE'] = "Username";
$ug3_upgrade['USERNAME_CAT_DESC'] = "Items that alters usernames";


?>