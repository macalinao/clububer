<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| User Gold 3
| Copyright © 2007 - 2008 UG3 Developement Team
| http://www.starglowone.com/
+--------------------------------------------------------+
| Filename: upgrade.php
| Author: UG3 Developement Team
+--------------------------------------------------------+
| This program is released as free software under the
| Stars Heaven Licence. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included licence.html.
| Removal of this copyright header is strictly
| prohibited without written permission
| from the original author(s).
+--------------------------------------------------------*/
require_once "../../../maincore.php";
require_once THEMES."templates/admin_header.php";

include_once INFUSIONS."user_gold/infusion_db.php";
include_once INFUSIONS."user_gold/functions.php";

if (file_exists(GOLD_LANG.LOCALESET."admin/global.php")) {
	include GOLD_LANG.LOCALESET."admin/global.php";
} else {
	include GOLD_LANG."English/admin/global.php";
}

include_once INFUSIONS."user_gold/admin/admin_functions.php";

if(!defined("UGLD_BANK_ENABLED")) { define("UGLD_BANK_ENABLED" , "1"); }
if(!defined("UGLD_VISABLE_COPY")) { define("UGLD_VISABLE_COPY" , "1"); }

if (file_exists(GOLD_LANG.LOCALESET."admin/upgrade.php")) {
	include_once GOLD_LANG.LOCALESET."admin/upgrade.php";
} else {
	include_once GOLD_LANG."English/admin/upgrade.php";
}
opentable($ug3_upgrade['upg_000']);

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
/*					Install start page				*/
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function intro() {
	global $HTTP_POST_VARS, $userdata, $ug3_upgrade, $locale, $settings, $golddata, $aidlink;
	echo $ug3_upgrade['upg_001'];
	echo "<div align='center'>\n";
	echo "<form action='upgrade.php".$aidlink."' method='post'>\n";
	echo "<input type='hidden' name='op' value='buildtablesquestion' />\n";
	echo "<label for='".$ug3_upgrade['agree']."'>".$ug3_upgrade['upg_002']."</label>\n";
	echo "<input type='checkbox' id='".$ug3_upgrade['agree']."' name='".$ug3_upgrade['agree']."' value='1' />\n";
	echo "<hr />\n";
	echo "<input type='submit' value='".$ug3_upgrade['continue']."' class='button' />\n";
	echo "<input type='submit' name='cancel' value='".$ug3_upgrade['cancel']."' class='button' />\n";
	echo "</form>\n";
	echo "</center>\n";
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
/*					Table creation question page					                */
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function buildtablesquestion() {
	global $HTTP_POST_VARS, $userdata, $ug3_upgrade,$locale, $settings, $golddata, $aidlink;
	echo $ug3_upgrade['upg_006'];
	echo "<div align='center'>\n";
	echo "<form action='upgrade.php".$aidlink."' method='post'>\n";
	echo "<input type='hidden' name='op' value='buildtablesaction' />\n";
	echo "<input type='hidden' name='removetables' value='1' />\n";
	//echo $ug3_upgrade['upg_007']."<input type='checkbox' name='removetables' value='1' checked='checked' />\n";
	echo "<hr />\n";
	echo $ug3_upgrade['upg_008'];	
	echo "<input type='submit' value='".$ug3_upgrade['continue']."' class='button' />\n";
	echo "<input type='submit' name='cancel' value='".$ug3_upgrade['cancel']."' class='button' />\n";
	echo "</form>\n";
	echo "</div>\n";
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
/*					Table creation 							                */
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function buildtablesaction() {
	global $HTTP_POST_VARS, $userdata, $ug3_upgrade,$locale, $settings, $golddata, $aidlink, $ug3_upgrade;
	$error='0';
	if(isset($_POST['removetables']) == '1') {
		$result1 = dbquery("DROP TABLE IF EXISTS ".DB_PREFIX."user_gold;");
		/*if($result1) {
			echo "<hr style='background-color:green; color:green; height:4px;' />\n";
			echo DB_UG3." Table removed<hr style='background-color: green; color: green; height: 4px;' />\n";
		} else {
			echo "<hr style='background-color:red; color:red; height:4px;' />\n";
			echo DB_UG3." Table Not removed<hr style='background-color: red; color: red; height: 4px;' />\n";
			$error = "1";
		}*/
	}
	
	$result2 = dbquery("CREATE TABLE IF NOT EXISTS ".DB_UG3." (
	`owner_id` int(5) NOT NULL default '0',
	`cash` decimal(9,2) NOT NULL default '0.00',
	`bank` decimal(9,2) NOT NULL default '0.00',
	`interest` varchar(100) NOT NULL,
	`karma` int(10) NOT NULL default '0',
	`chips` int(20) NOT NULL default '0',
	`steal` varchar(10) NOT NULL,
	`username_color` varchar(20) NOT NULL,
	`donated` int(11) NOT NULL default '0',
	`ribbon` smallint(5) NOT NULL default '0',
	`gamble` varchar(10) NOT NULL,
	`userlevel` varchar(100) NOT NULL default '".$ug3_upgrade['change_me']."',
	PRIMARY KEY  (`owner_id`),
	UNIQUE KEY owner_id (`owner_id`)
	) ENGINE=MyISAM;");

	if($result2) {
		echo "<hr style='background-color: green; color: green; height: 4px;' />\n";
		echo DB_UG3." Table Created<hr style='background-color: green; color: green; height: 4px;' />\n";
	} else {
		echo "<hr style='background-color: red; color: red; height: 4px;' />\n";
		echo DB_UG3." Table Not Created<hr style='background-color: red; color: red; height: 4px;' />\n";
		$error = "1";
	}
	
	if(isset($_POST['removetables']) == '1') {
		$result1 = dbquery("DROP TABLE IF EXISTS ".DB_PREFIX."user_gold_categories;");
		/*if($result1) {
			echo "<hr style='background-color:green; color:green; height:4px;' />\n";
			echo DB_UG3_CATEGORIES." Table removed<hr style='background-color: green; color: green; height: 4px;' />\n";
		} else {
			echo "<hr style='background-color:red; color:red; height:4px;' />\n";
			echo DB_UG3_CATEGORIES." Table Not removed<hr style='background-color: red; color: red; height: 4px;' />\n";
			$error = "1";
		}*/
	}
	
	$result2 = dbquery("CREATE TABLE IF NOT EXISTS ".DB_UG3_CATEGORIES." (
	`cat_id` mediumint(8) unsigned NOT NULL auto_increment,
	`cat_name` varchar(100) NOT NULL,
	`cat_image` varchar(100) NOT NULL default 'blank.gif',
	`cat_description` varchar(100) NOT NULL,
	`cat_sorting` varchar(100) NOT NULL default 'price',
	`cat_access` tinyint(3) unsigned NOT NULL default '101',
	PRIMARY KEY  (`cat_id`)
	) ENGINE=MyISAM;");

	if($result2) {
		echo "<hr style='background-color: green; color: green; height: 4px;' />\n";
		echo DB_UG3_CATEGORIES." Table Created<hr style='background-color: green; color: green; height: 4px;' />\n";
	} else {
		echo "<hr style='background-color: red; color: red; height: 4px;' />\n";
		echo DB_UG3_CATEGORIES." Table Not Created<hr style='background-color: red; color: red; height: 4px;' />\n";
		$error = "1";
	}

	if(isset($_POST['removetables']) == '1') {
		$result1 = dbquery("DROP TABLE IF EXISTS ".DB_PREFIX."user_gold_inventory;");
		/*if($result1) {
			echo "<hr style='background-color:green; color:green; height:4px;' />\n";
			echo DB_UG3_INVENTORY." Table removed<hr style='background-color: green; color: green; height: 4px;' />\n";
		} else {
			echo "<hr style='background-color:red; color:red; height:4px;' />\n";
			echo DB_UG3_INVENTORY." Table Not removed<hr style='background-color: red; color: red; height: 4px;' />\n";
			$error = "1";
		}*/
	}
	
	$result2 = dbquery("CREATE TABLE IF NOT EXISTS ".DB_UG3_INVENTORY." (
	`id` int(10) unsigned NOT NULL auto_increment,
	`ownerid` int(10) unsigned NOT NULL,
	`itemid` int(10) unsigned NOT NULL,
	`itemname` varchar(100) NOT NULL,
	`amtpaid` decimal(8,2) unsigned NOT NULL default '0.00',
	`trading` tinyint(1) unsigned NOT NULL,
	`tradecost` decimal(8,2) NOT NULL,
	PRIMARY KEY  (`id`)
	) ENGINE=MyISAM;");

	if($result2) {
		echo "<hr style='background-color: green; color: green; height: 4px;' />\n";
		echo DB_UG3_INVENTORY." Table Created<hr style='background-color: green; color: green; height: 4px;' />\n";
	} else {
		echo "<hr style='background-color: red; color: red; height: 4px;' />\n";
		echo DB_UG3_INVENTORY." Table Not Created<hr style='background-color: red; color: red; height: 4px;' />\n";
		$error = "1";
	}
	
	if(isset($_POST['removetables']) == '1') {
		$result1 = dbquery("DROP TABLE IF EXISTS `".DB_PREFIX."user_gold_settings`;");
		/*if($result1) {
			echo "<hr style='background-color:green; color:green; height:4px;' />\n";
			echo DB_UG3_SETTINGS." Table removed<hr style='background-color: green; color: green; height: 4px;' />\n";
		} else {
			echo "<hr style='background-color:red; color:red; height:4px;' />\n";
			echo DB_UG3_SETTINGS." Table Not removed<hr style='background-color: red; color: red; height: 4px;' />\n";
			$error = "1";
		}*/
	}
	
	$result2 = dbquery("CREATE TABLE IF NOT EXISTS ".DB_UG3_SETTINGS." (
	`name` varchar(100) NOT NULL,
	`value` text NOT NULL,
	`description` text NOT NULL,
	PRIMARY KEY  (`name`),
	UNIQUE KEY `name` (`name`)
	) ENGINE=MyISAM;");

	if($result2) {
		echo "<hr style='background-color: green; color: green; height: 4px;' />\n";
		echo DB_UG3_SETTINGS." Table Created<hr style='background-color: green; color: green; height: 4px;' />\n";
	} else {
		echo "<hr style='background-color: red; color: red; height: 4px;' />\n";
		echo DB_UG3_SETTINGS." Table Not Created<hr style='background-color: red; color: red; height: 4px;' />\n";
		$error = "1";
	}
	
	if(isset($_POST['removetables']) == '1') {
		$result1 = dbquery("DROP TABLE IF EXISTS `".DB_PREFIX."user_gold_usage`;");
		/*if($result1) {
			echo "<hr style='background-color:green; color:green; height:4px;' />\n";
			echo DB_UG3_USAGE." Table removed<hr style='background-color: green; color: green; height: 4px;' />\n";
		} else {
			echo "<hr style='background-color:red; color:red; height:4px;' />\n";
			echo DB_UG3_USAGE." Table Not removed<hr style='background-color: red; color: red; height: 4px;' />\n";
			$error = "1";
		}*/
	}
	
	$result2 = dbquery("CREATE TABLE IF NOT EXISTS ".DB_UG3_USAGE." (
	`id` int(5) NOT NULL auto_increment,
	`name` varchar(100) NOT NULL,
	`description` tinytext NOT NULL,
	`purchase` enum('0','1') NOT NULL default '0',
	`cost` decimal(9,2) NOT NULL,
	`stock` varchar(100) NOT NULL,
	`image` varchar(255) NOT NULL default 'blank.gif',
	`category` int(5) NOT NULL default '0',
	`active` enum('0','1') NOT NULL default '0',
	PRIMARY KEY  (`id`),
	UNIQUE KEY `name` (`name`)
	) ENGINE=MyISAM;");
	
	if($result2) {
		echo "<hr style='background-color: green; color: green; height: 4px;' />\n";
		echo DB_UG3_USAGE." Table Created<hr style='background-color: green; color: green; height: 4px;' />\n";
	} else {
		echo "<hr style='background-color: red; color: red; height: 4px;' />\n";
		echo DB_UG3_USAGE." Table Not Created<hr style='background-color: red; color: red; height: 4px;' />\n";
		$error = "1";
	}

	if(isset($_POST['removetables']) == '1') {
		$result1 = dbquery("DROP TABLE IF EXISTS `".DB_PREFIX."user_gold_transactions`;");
		/*if($result1) {
			echo "<hr style='background-color:green; color:green; height:4px;' />\n";
			echo DB_UG3_TRANSACTIONS." Table removed<hr style='background-color: green; color: green; height: 4px;' />\n";
		} else {
			echo "<hr style='background-color:red; color:red; height:4px;' />\n";
			echo DB_UG3_TRANSACTIONS." Table Not removed<hr style='background-color: red; color: red; height: 4px;' />\n";
			$error = "1";
		}*/
	}
	
	$result2 = dbquery("CREATE TABLE IF NOT EXISTS ".DB_UG3_TRANSACTIONS." (
	`transaction_id` mediumint(8) NOT NULL auto_increment,
	`transaction_user_id` mediumint(5) NOT NULL default '0',
	`transaction_status` tinyint(1) NOT NULL default '0',
	`transaction_type` varchar(50) NOT NULL default '',
	`transaction_value` int(10) NOT NULL default '0',
	`transaction_timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP,
	PRIMARY KEY (`transaction_id`)
	) ENGINE=MyISAM;");
	
	if($result2) {
		echo "<hr style='background-color: green; color: green; height: 4px;' />\n";
		echo DB_UG3_TRANSACTIONS." Table Created<hr style='background-color: green; color: green; height: 4px;' />\n";
	} else {
		echo "<hr style='background-color: red; color: red; height: 4px;' />\n";
		echo DB_UG3_TRANSACTIONS." Table Not Created<hr style='background-color: red; color: red; height: 4px;' />\n";
		$error = "1";
	}
	
	if(!$error == '1') {
		echo $ug3_upgrade['upg_009'];
		echo "<div='center'>\n";
		echo "<form action='upgrade.php".$aidlink."' method='post'>\n";
		echo "<input type='hidden' name='op' value='default_data' />\n";
		echo $ug3_upgrade['upg_010'];
		echo "<hr />\n";
		echo "<input type='submit' value='".$ug3_upgrade['continue']."' class='button' />\n";
		echo "<input type='submit' name='cancel' value='".$ug3_upgrade['cancel']."' class='button' />\n";
		echo "</form>\n";
		echo "</div>\n";
	} else {
		echo $ug3_upgrade['upg_0011'];
	}
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
/*					Insert default data in tables 					                */
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function default_data() {
	global $HTTP_POST_VARS, $userdata, $ug3_upgrade,$locale, $ug3_upgrade, $settings, $golddata, $aidlink;
	$error='0';
	//default settings data
	$result3 = dbquery("INSERT INTO ".DB_UG3_SETTINGS." 
		( name, value, description ) 
			VALUES 
		('UGLD_REGISTER', '100', '".$ug3_upgrade['UGLD_REGISTER']."'),
		('USERGOLD', '1', '".$ug3_upgrade['USERGOLD']."'),
		('UGLD_TEMPLATE', 'default', '".$ug3_upgrade['UGLD_TEMPLATE']."'),
		('UGLD_CURRENCY_PREFIX', '$', '".$ug3_upgrade['UGLD_CURRENCY_PREFIX']."'),
		('UGLD_CURRENCY_SUFFIX', '', '".$ug3_upgrade['UGLD_CURRENCY_SUFFIX']."'),
		('UGLD_DECIMAL', '2', '".$ug3_upgrade['UGLD_DECIMAL']."'),
		('UGLD_DECPOINT', '.', '".$ug3_upgrade['UGLD_DECPOINT']."'),
		('UGLD_THOUSANDS', ',', '".$ug3_upgrade['UGLD_THOUSANDS']."'),
		('UGLD_BANK_ENABLED', '1', '".$ug3_upgrade['UGLD_BANK_ENABLED']."'),
		('UGLD_BANK_NAME', 'User Gold 3 Bank', '".$ug3_upgrade['UGLD_BANK_NAME']."'),
		('UGLD_BANK_INTEREST', '10', '".$ug3_upgrade['UGLD_BANK_INTEREST']."'),
		('UGLD_DISPLAY_USAGE_INDEX', '0', '".$ug3_upgrade['UGLD_DISPLAY_USAGE_INDEX']."'),
		('UGLD_VISABLE_COPY', '0', '".$ug3_upgrade['UGLD_VISABLE_COPY']."'),
		('UGLD_SELFDONATE_ALLOW', '50','".$ug3_upgrade['UGLD_SELFDONATE_ALLOW']."'),
		('UGLD_SELFDONATE_MIN', '1', '".$ug3_upgrade['UGLD_SELFDONATE_MIN']."'),
		('UGLD_SELFDONATE_MAX', '100', '".$ug3_upgrade['UGLD_SELFDONATE_MAX']."'),
		('UGLD_GOLDTEXT', 'Dollars', '".$ug3_upgrade['UGLD_GOLDTEXT']."'),
		('UGLD_BANK_DEPOSIT_MIN', '100', '".$ug3_upgrade['UGLD_BANK_DEPOSIT_MIN']."'),
		('UGLD_BANK_WITHDRAW_MIN', '50', '".$ug3_upgrade['UGLD_BANK_WITHDRAW_MIN']."'),
		('UGLD_IMAGE_HEIGHT', '50','".$ug3_upgrade['UGLD_IMAGE_HEIGHT']."'),
		('UGLD_IMAGE_WIDTH', '50','".$ug3_upgrade['UGLD_IMAGE_WIDTH']."'),
		('GLD_KARMA', '0','".$ug3_upgrade['GLD_KARMA']."'),
		('GLD_STEAL', '1','".$ug3_upgrade['GLD_STEAL']."'),
		('GLD_STEAL_BUY', '2000','".$ug3_upgrade['GLD_STEAL_BUY']."'),
		('GLD_FORUM_ADD_POSTS', '0','".$ug3_upgrade['GLD_FORUM_ADD_POSTS']."'),
		('GLD_FORUM_ADD_POSTS_COST', '10','".$ug3_upgrade['GLD_FORUM_ADD_POSTS_COST']."'),
		('GLD_FORUM_ADD_POSTS_PERCENT', '10','".$ug3_upgrade['GLD_FORUM_ADD_POSTS_PERCENT']."'),
		('GLD_GAMBLE', '1','".$ug3_upgrade['GLD_GAMBLE']."'),
		('GLD_JOINED', '100','".$ug3_upgrade['GLD_JOINED']."'),
		('GLD_CRIME', '0','".$ug3_upgrade['GLD_CRIME']."'),
		('UGLD_GAMBLE_LOW', '50000','".$ug3_upgrade['UGLD_GAMBLE_LOW']."'),
		('UGLD_GAMBLE_HIGH', '100000','".$ug3_upgrade['UGLD_GAMBLE_HIGH']."'),
		('UGLD_GAMBLE_ALLOW', '100000','".$ug3_upgrade['UGLD_GAMBLE_ALLOW']."'),
		('UGLD_DONATE_RIBBON', '999999999','".$ug3_upgrade['UGLD_DONATE_RIBBON']."'),
		('UGLD_USERLEVEL_DISALLOW', '', '".$ug3_upgrade['UGLD_USERLEVEL_DISALLOW']."'),
		('UGLD_WELCOME_PM', '1', '".$ug3_upgrade['UGLD_WELCOME_PM']."'),
		('UGLD_WELCOME_PM_SUBJECT', '".$ug3_upgrade['welcome_to']." ".$settings['sitename']."!', '".$ug3_upgrade['UGLD_WELCOME_PM_SUBJECT']."'),
		('UGLD_WELCOME_PM_MESSAGE', '".$ug3_upgrade['hello']." %s! <br />', '".$ug3_upgrade['UGLD_WELCOME_PM_MESSAGE']."');
	");
	
	$result3 = dbquery("INSERT INTO ".DB_UG3_USAGE." 
		( id, name, description, purchase, cost, stock, image, category, active ) 
			VALUES 
		(1, 'GLD_FORUM_QUICK_REPLY', '".$ug3_upgrade['GLD_FORUM_QUICK_REPLY']."', '0', 5.00, '', 'blank.gif', '1', '1'),
		(2, 'GLD_FORUM_POST_REPLY', '".$ug3_upgrade['GLD_FORUM_POST_REPLY']."', '0', 10.00, '', 'blank.gif', '1', '1'),
		(3, 'GLD_FORUM_NEW_THREAD', '".$ug3_upgrade['GLD_FORUM_NEW_THREAD']."', '0', 20.00, '', 'blank.gif', '1', '1'),
		(4, 'GLD_FORUM_ATTACHMENT', '".$ug3_upgrade['GLD_FORUM_ATTACHMENT']."', '0', 10.00, '', 'blank.gif', '1', '1'),
		(5, 'GLD_FORUM_SIG', '".$ug3_upgrade['GLD_FORUM_SIG']."', '1', 1000.00, '1000', 'user_signature.gif', '1', '1'),
		(6, 'GLD_FORUM_POLL', '".$ug3_upgrade['GLD_FORUM_POLL']."', '0', 5.00, '', 'blank.gif', '1', '1'),
		(7, 'GLD_FORUM_POLL_VOTE', '".$ug3_upgrade['GLD_FORUM_POLL_VOTE']."', '0', 2.50, '', 'blank.gif', '1', '1'),
		(8, 'GLD_AVATAR', '".$ug3_upgrade['GLD_AVATAR']."', '1', 1000.00, '983', 'user_avatar.gif', '1', '1'),
		(9, 'GLD_THEME_SELECT', '".$ug3_upgrade['GLD_THEME_SELECT']."', '1', 200.00, '1000', 'user_themes.gif', '1', '1'),
		(10, 'GLD_USERNAME_COLOR', '".$ug3_upgrade['GLD_USERNAME_COLOR']."', '1', 1000.00, '1000', 'username_color.gif', '2', '1'),
		(11, 'GLD_USERNAME_BLINK', '".$ug3_upgrade['GLD_USERNAME_BLINK']."', '1', 1000.00, '1000', 'username_blink.gif', '2', '1'),
		(12, 'GLD_USERNAME_BOLD', '".$ug3_upgrade['GLD_USERNAME_BOLD']."', '1', 1000.00, '1000', 'username_bold.gif', '2', '1'),
		(13, 'GLD_USERNAME_ITALIC', '".$ug3_upgrade['GLD_USERNAME_ITALIC']."', '1', 1000.00, '1000', 'username_italic.gif', '2', '1'),
		(14, 'GLD_USERNAME_STRIKE', '".$ug3_upgrade['GLD_USERNAMESTRIKE']."', '1', 1000.00, '1000', 'username_strike.gif', '2', '1'),
		(15, 'GLD_USERLEVEL', '".$ug3_upgrade['GLD_USERLEVEL']."', '1', 100000.00, '1000', 'userlevel.gif', '1', '1'),
		(16, 'GLD_BANK_ACCOUNT', '".$ug3_upgrade['GLD_BANK_ACCOUNT']."', '1', 200.00, '1000', 'bank_account.gif', '1', '1'),
		(17, 'GLD_USERNAME_BLINK_BLOCK', '".$ug3_upgrade['GLD_USERNAME_BLINK_BLOCK']."', '1', 200.00, '1000', 'blink_block.gif', '2', '1'), 
		(18, 'GLD_WEBLINK_SUBMIT', '".$ug3_upgrade['GLD_WEBLINK_SUBMIT']."', '0', 5.00, '', 'blank.gif', '1', '1'),
		(19, 'GLD_NEWS_SUBMIT', '".$ug3_upgrade['GLD_NEWS_SUBMIT']."', '0', 20.00, '', 'blank.gif', '1', '1'),
		(20, 'GLD_ARTICLE_SUBMIT', '".$ug3_upgrade['GLD_ARTICLE_SUBMIT']."', '0', 20.00, '', 'blank.gif', '1', '1'),
		(21, 'GLD_PHOTO_SUBMIT', '".$ug3_upgrade['GLD_PHOTO_SUBMIT']."', '0', 5.00, '', 'blank.gif', '1', '1'),
		(22, 'GLD_SHOUTBOX', '".$ug3_upgrade['GLD_SHOUTBOX']."', '0', 2.00, '', 'blank.gif', '1', '1');
	");
		
	$result3 = dbquery("INSERT INTO ".DB_UG3_CATEGORIES." 
		( cat_id, cat_name, cat_image, cat_description, cat_sorting, cat_access ) 
			VALUES 
		( 1, '".$ug3_upgrade['USER_GOLD_3_CAT_TITLE']."', 'cat_usergold.gif', '".$ug3_upgrade['USER_GOLD_3_CAT_DESC']."', 'price', '101'),
		( 2, '".$ug3_upgrade['USERNAME_CAT_TITLE']."', 'cat_username.gif', '".$ug3_upgrade['USERNAME_CAT_DESC']."', 'price', '101');
	");

	if($result3) {
		echo "<hr style='background-color: green; color: green; height: 4px;' />\n";
		echo $ug3_upgrade['upg_026'];
		echo "<hr style='background-color: green; color: green; height: 4px;' />\n";
	} else {
		echo "<hr style='background-color: red; color: red; height: 4px;' />\n";
		echo $ug3_upgrade['upg_027'];
		echo "<hr style='background-color: red; color: red; height: 4px;' />\n";
		$error = "1";
	}
	
	if(!$error == '1') {
		echo $ug3_upgrade['upg_012'];
		echo "<div align='center'>\n";
		echo "<form action='upgrade.php".$aidlink."' method='post'>\n";
		echo $ug3_upgrade['upg_013'];
		echo "<input type='radio' name='op' value='moveusersaction' checked='checked' />".$ug3_upgrade['yes'];
		echo "<input type='radio' name='op' value='finish' />".$ug3_upgrade['no'];
		echo "<hr />\n";
		echo "<input type='submit' value='".$ug3_upgrade['continue']."' class='button' />\n";
		echo "<input type='submit' name='cancel' value='".$ug3_upgrade['cancel']."' class='button' />\n";
		echo "</form>\n";
		echo "</div>\n";
	} else {
		echo $ug3_upgrade['upg_014'];
	}
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
/*			Move users from the original table to the new table question 			    */
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function moveusersquestion() {
	global $HTTP_POST_VARS, $userdata, $ug3_upgrade,$locale, $settings, $golddata, $aidlink;
	$error = "0";
	echo "<div align='center'>\n";
	echo "<form action='upgrade.php".$aidlink."' method='post'>\n";
	echo $ug3_upgrade['upg_015'];
	echo "<input type='radio' name='op' value='moveusersaction' checked='checked'>".$ug3_upgrade['yes'];
	echo "<input type='radio' name='op' value='finish'>".$ug3_upgrade['no'];	
	echo "<hr />\n";
	echo "<input type='submit' value='".$ug3_upgrade['continue']."' class='button' />\n";
	echo "<input type='submit' name='cancel' value='".$ug3_upgrade['cancel']."' class='button' />\n";
	echo "</form>\n";
	echo "</div>\n";
}//moveusersquestion

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
/*			Move the users from the original table to the new table	 			    */
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function moveusersaction() {
	global $HTTP_POST_VARS, $userdata, $ug3_upgrade,$locale, $settings, $golddata, $op, $aidlink;
	//transfer users to the new system
	$sql = dbquery("Select ".DB_PREFIX."users_points.owner_id, ".DB_PREFIX."users_points.points_total, ".DB_PREFIX."users.user_id, ".DB_PREFIX."users.user_name From ".DB_PREFIX."users_points, ".DB_PREFIX."users WHERE ".DB_PREFIX."users_points.owner_id = ".DB_PREFIX."users.user_id;");
	if($sql) {
		while($data=dbarray($sql)) {
			if($data['owner_id'] >=1) {
				$result = dbquery("INSERT INTO `".DB_PREFIX."user_gold` ( `owner_id` , `cash` , `bank` , `interest` , `karma` , `chips`, `steal`, `username_color`, `donated`, `ribbon`, `gamble`, `userlevel` )VALUES ('".$data['owner_id']."', '".$data['points_total']."', '0.00', '".date('Ymd')."', '0', '0', '', '', '0', '0', '', '".$ug3_upgrade['change_me']."');");
				if($result) {
					echo "<span style='color: green;'>".$ug3_upgrade['upg_016']." ".$data['user_name']." (".$data['owner_id'].") [".$data['points_total']."]</span><br />\n";
				} else {
					echo "<span style='color: red;'>".$ug3_upgrade['upg_017']." ".$data['user_name']." (".$data['owner_id'].") [".$data['points_total']."]</span><br />\n";
				}
			} else {
				echo "<span style='color: orange;'>".$ug3_upgrade['upg_018']." ".$data['owner_id']." ".$ug3_upgrade['upg_019']."</span><br /> <i>".$ug3_upgrade['upg_020']."</i><br />\n";
			}
		}//while
		echo "<div align='center'>\n";
		echo "<form action='upgrade.php".$aidlink."' method='post'><hr />\n";
		echo $ug3_upgrade['upg_022'];
		echo "<input type='hidden' name='op' value='finish' />\n";
		echo "<hr />\n";
		echo "<input type='submit' value='". $ug3_upgrade['finish']."' class='button' />\n";
		echo "</form>\n";
		echo "</div>\n";
	} else {
		echo "<hr style='background-color: red; color: red; height: 4px;' />\n";
		echo $ug3_upgrade['upg_021'];
		echo "<hr style='background-color: red; color: red; height: 4px;' /><br />\n";
		echo $ug3_upgrade['upg_022']." \n";
		echo "<a href='upgrade.php".$aidlink."&amp;op=finish'>".$ug3_upgrade['upg_023']."</a> \n";
		echo $ug3_upgrade['upg_024'].".\n";
	}
}//moveusersaction

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
/*						Finishing the installation		 			    */
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function finish() {
	global $HTTP_POST_VARS, $userdata, $ug3_upgrade, $locale, $settings, $golddata, $aidlink;
	$error = "0";
	echo $ug3_upgrade['upg_025'];
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
/*							Switchboard			 			    */
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
if(!isset($_REQUEST['op'])) { $op = "intro"; } else {$op = $_REQUEST['op']; }
if(isset($_REQUEST['cancel'])) { $op = "intro"; }

switch($op) {
	case "intro":
		intro();
		break;
	case "buildtablesquestion":
		buildtablesquestion();
		break;
	case "buildtablesaction":
		buildtablesaction();
		break;
	case "loadbasicaction":
		moveusersaction();
		break;
	case "loadbasicquestion":
		moveusersquestion();
		break;
	case "default_data":
		default_data();
		break;
	case "moveusersaction":
		moveusersaction();
		break;
	case "moveusersquestion":
		moveusersquestion();
		break;
	case "finish":
		finish();
		break;
	default:
		if(!$op) {
			intro();
		}
		break;
}
closetable();
//Start Copywrite Link removal is NOT ALLOWED.
echo "<div align='center' class='small'>".$locale['urg_title']." ".GOLD_VERSION." &copy; 2007-2008 <a href='http://www.starglowone.com'>".$locale['urg_dev']." @ Stars Heaven</a></div>\n";
//END Copywrite Link removal is NOT ALLOWED.

require_once THEMES."templates/footer.php";
?>