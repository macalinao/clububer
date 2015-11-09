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
| Filename: infusion.php
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
if (!defined("IN_FUSION")) { die("Access Denied"); }

require_once INFUSIONS."user_gold/infusion_db.php";

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."user_gold/locale/".$settings['locale']."/global.php")) {
	// Load the locale file matching the current site locale setting.
	include INFUSIONS."user_gold/locale/".$settings['locale']."/global.php";
} else {
	// Load the infusion's default locale file.
	include INFUSIONS."user_gold/locale/English/global.php";
}

if (file_exists(INFUSIONS."user_gold/locale/".$settings['locale']."/admin/upgrade.php")) {
	include_once INFUSIONS."user_gold/locale/".$settings['locale']."/admin/upgrade.php";
} else {
	include_once INFUSIONS."user_gold/locale/English/admin/upgrade.php";
}
// Infusion general information
$inf_title = $locale['urg_title'];
$inf_description = $locale['urg_desc'];
$inf_version = "3.0.1";
$inf_developer = $locale['urg_dev'];
$inf_email = "support@starglowone.com";
$inf_weburl = "http://www.starglowone.com";
$inf_folder = "user_gold";

// Delete any items not required here.
$inf_newtable[1] = DB_UG3." (
owner_id int(5) NOT NULL default '0',
cash decimal(9,2) NOT NULL default '0.00',
bank decimal(9,2) NOT NULL default '0.00',
interest varchar(100) NOT NULL,
karma int(10) NOT NULL default '0',
chips int(20) NOT NULL default '0',
steal varchar(10) NOT NULL,
username_color varchar(20) NOT NULL,
donated int(11) NOT NULL default '0',
ribbon smallint(5) NOT NULL default '0',
gamble varchar(10) NOT NULL,
userlevel varchar(100) NOT NULL default '".$ug3_upgrade['change_me']."',
PRIMARY KEY (owner_id),
UNIQUE KEY owner_id (owner_id)
) TYPE = MYISAM ;";


$inf_newtable[2] = DB_UG3_CATEGORIES." (
cat_id mediumint(8) unsigned NOT NULL auto_increment,
cat_name varchar(100) NOT NULL,
cat_image varchar(100) NOT NULL default 'blank.gif',
cat_description varchar(100) NOT NULL,
cat_sorting varchar(100) NOT NULL default 'price',
cat_access tinyint(3) unsigned NOT NULL default '101',
PRIMARY KEY (cat_id)
) TYPE = MYISAM ;";

$inf_newtable[3] = DB_UG3_INVENTORY." (
id int(10) unsigned NOT NULL auto_increment,
ownerid int(10) unsigned NOT NULL,
itemid int(10) unsigned NOT NULL,
itemname varchar(100) NOT NULL,
amtpaid decimal(8,2) unsigned NOT NULL default '0.00',
trading tinyint(1) unsigned NOT NULL,
tradecost decimal(8,2) NOT NULL,
PRIMARY KEY (id)
) TYPE = MYISAM ;";

$inf_newtable[4] = DB_UG3_SETTINGS." (
name varchar(100) NOT NULL,
value text NOT NULL,
description text NOT NULL,
PRIMARY KEY (name),
UNIQUE KEY name (name)
) TYPE = MYISAM ;";

$inf_newtable[5] = DB_UG3_USAGE." (
id int(5) NOT NULL auto_increment,
name varchar(100) NOT NULL,
description tinytext NOT NULL,
purchase enum('0','1') NOT NULL default '0',
cost decimal(9,2) NOT NULL,
stock varchar(100) NOT NULL,
image varchar(255) NOT NULL default 'blank.gif',
category int(5) NOT NULL default '0',
active enum('0','1') NOT NULL default '0',
PRIMARY KEY (id),
UNIQUE KEY name (name)
) TYPE = MYISAM ;";

$inf_newtable[6] = DB_UG3_TRANSACTIONS." (
transaction_id mediumint(8) NOT NULL auto_increment,
transaction_user_id mediumint(5) NOT NULL default '0',
transaction_status tinyint(1) NOT NULL default '0',
transaction_type varchar(50) NOT NULL default '',
transaction_value int(10) NOT NULL default '0',
transaction_timestamp timestamp NOT NULL default CURRENT_TIMESTAMP,
PRIMARY KEY (transaction_id)
) TYPE = MYISAM ;";

$inf_insertdbrow[1] = DB_UG3_SETTINGS." ( name, value, description ) VALUES ('UGLD_REGISTER', '100', '".$ug3_upgrade['UGLD_REGISTER']."')";
$inf_insertdbrow[2] = DB_UG3_SETTINGS." ( name, value, description ) VALUES ('USERGOLD', '1', '".$ug3_upgrade['USERGOLD']."')";
$inf_insertdbrow[3] = DB_UG3_SETTINGS." ( name, value, description ) VALUES ('UGLD_TEMPLATE', 'default', '".$ug3_upgrade['UGLD_TEMPLATE']."')";
$inf_insertdbrow[4] = DB_UG3_SETTINGS." ( name, value, description ) VALUES ('UGLD_CURRENCY_PREFIX', '$', '".$ug3_upgrade['UGLD_CURRENCY_PREFIX']."')";
$inf_insertdbrow[5] = DB_UG3_SETTINGS." ( name, value, description ) VALUES ('UGLD_CURRENCY_SUFFIX', '', '".$ug3_upgrade['UGLD_CURRENCY_SUFFIX']."')";
$inf_insertdbrow[6] = DB_UG3_SETTINGS." ( name, value, description ) VALUES ('UGLD_DECIMAL', '2', '".$ug3_upgrade['UGLD_DECIMAL']."')";
$inf_insertdbrow[7] = DB_UG3_SETTINGS." ( name, value, description ) VALUES ('UGLD_DECPOINT', '.', '".$ug3_upgrade['UGLD_DECPOINT']."')";
$inf_insertdbrow[8] = DB_UG3_SETTINGS." ( name, value, description ) VALUES ('UGLD_THOUSANDS', ',', '".$ug3_upgrade['UGLD_THOUSANDS']."')";
$inf_insertdbrow[9] = DB_UG3_SETTINGS." ( name, value, description ) VALUES ('UGLD_BANK_ENABLED', '1', '".$ug3_upgrade['UGLD_BANK_ENABLED']."')";
$inf_insertdbrow[10] = DB_UG3_SETTINGS." ( name, value, description ) VALUES ('UGLD_BANK_NAME', 'User Gold 3 Bank', '".$ug3_upgrade['UGLD_BANK_NAME']."')";
$inf_insertdbrow[11] = DB_UG3_SETTINGS." ( name, value, description ) VALUES ('UGLD_BANK_INTEREST', '10', '".$ug3_upgrade['UGLD_BANK_INTEREST']."')";
$inf_insertdbrow[12] = DB_UG3_SETTINGS." ( name, value, description ) VALUES ('UGLD_DISPLAY_USAGE_INDEX', '0', '".$ug3_upgrade['UGLD_DISPLAY_USAGE_INDEX']."')";
$inf_insertdbrow[13] = DB_UG3_SETTINGS." ( name, value, description ) VALUES ('UGLD_VISABLE_COPY', '0', '".$ug3_upgrade['UGLD_VISABLE_COPY']."')";
$inf_insertdbrow[14] = DB_UG3_SETTINGS." ( name, value, description ) VALUES ('UGLD_SELFDONATE_ALLOW', '50','".$ug3_upgrade['UGLD_SELFDONATE_ALLOW']."')";
$inf_insertdbrow[15] = DB_UG3_SETTINGS." ( name, value, description ) VALUES ('UGLD_SELFDONATE_MIN', '1', '".$ug3_upgrade['UGLD_SELFDONATE_MIN']."')";
$inf_insertdbrow[16] = DB_UG3_SETTINGS." ( name, value, description ) VALUES ('UGLD_SELFDONATE_MAX', '100', '".$ug3_upgrade['UGLD_SELFDONATE_MAX']."')";
$inf_insertdbrow[17] = DB_UG3_SETTINGS." ( name, value, description ) VALUES ('UGLD_GOLDTEXT', 'Dollars', '".$ug3_upgrade['UGLD_GOLDTEXT']."')";
$inf_insertdbrow[18] = DB_UG3_SETTINGS." ( name, value, description ) VALUES ('UGLD_BANK_DEPOSIT_MIN', '100', '".$ug3_upgrade['UGLD_BANK_DEPOSIT_MIN']."')";
$inf_insertdbrow[19] = DB_UG3_SETTINGS." ( name, value, description ) VALUES ('UGLD_BANK_WITHDRAW_MIN', '50', '".$ug3_upgrade['UGLD_BANK_WITHDRAW_MIN']."')";
$inf_insertdbrow[20] = DB_UG3_SETTINGS." ( name, value, description ) VALUES ('UGLD_IMAGE_HEIGHT', '50','".$ug3_upgrade['UGLD_IMAGE_HEIGHT']."')";
$inf_insertdbrow[21] = DB_UG3_SETTINGS." ( name, value, description ) VALUES ('UGLD_IMAGE_WIDTH', '50','".$ug3_upgrade['UGLD_IMAGE_WIDTH']."')";
$inf_insertdbrow[22] = DB_UG3_SETTINGS." ( name, value, description ) VALUES ('GLD_KARMA', '0','".$ug3_upgrade['GLD_KARMA']."')";
$inf_insertdbrow[23] = DB_UG3_SETTINGS." ( name, value, description ) VALUES ('GLD_STEAL', '1','".$ug3_upgrade['GLD_STEAL']."')";
$inf_insertdbrow[24] = DB_UG3_SETTINGS." ( name, value, description ) VALUES ('GLD_STEAL_BUY', '2000','".$ug3_upgrade['GLD_STEAL_BUY']."')";
$inf_insertdbrow[25] = DB_UG3_SETTINGS." ( name, value, description ) VALUES ('GLD_FORUM_ADD_POSTS', '0','".$ug3_upgrade['GLD_FORUM_ADD_POSTS']."')";
$inf_insertdbrow[26] = DB_UG3_SETTINGS." ( name, value, description ) VALUES ('GLD_FORUM_ADD_POSTS_COST', '10','".$ug3_upgrade['GLD_FORUM_ADD_POSTS_COST']."')";
$inf_insertdbrow[27] = DB_UG3_SETTINGS." ( name, value, description ) VALUES ('GLD_FORUM_ADD_POSTS_PERCENT', '10','".$ug3_upgrade['GLD_FORUM_ADD_POSTS_PERCENT']."')";
$inf_insertdbrow[28] = DB_UG3_SETTINGS." ( name, value, description ) VALUES ('GLD_GAMBLE', '1','".$ug3_upgrade['GLD_GAMBLE']."')";
$inf_insertdbrow[29] = DB_UG3_SETTINGS." ( name, value, description ) VALUES ('GLD_JOINED', '100','".$ug3_upgrade['GLD_JOINED']."')";
$inf_insertdbrow[30] = DB_UG3_SETTINGS." ( name, value, description ) VALUES ('GLD_CRIME', '0','".$ug3_upgrade['GLD_CRIME']."')";
$inf_insertdbrow[31] = DB_UG3_SETTINGS." ( name, value, description ) VALUES ('UGLD_GAMBLE_LOW', '50000','".$ug3_upgrade['UGLD_GAMBLE_LOW']."')";
$inf_insertdbrow[32] = DB_UG3_SETTINGS." ( name, value, description ) VALUES ('UGLD_GAMBLE_HIGH', '100000','".$ug3_upgrade['UGLD_GAMBLE_HIGH']."')";
$inf_insertdbrow[33] = DB_UG3_SETTINGS." ( name, value, description ) VALUES ('UGLD_GAMBLE_ALLOW', '100000','".$ug3_upgrade['UGLD_GAMBLE_ALLOW']."')";
$inf_insertdbrow[34] = DB_UG3_SETTINGS." ( name, value, description ) VALUES ('UGLD_DONATE_RIBBON', '999999999','".$ug3_upgrade['UGLD_DONATE_RIBBON']."')";
$inf_insertdbrow[35] = DB_UG3_SETTINGS." ( name, value, description ) VALUES ('UGLD_USERLEVEL_DISALLOW', '', '".$ug3_upgrade['UGLD_USERLEVEL_DISALLOW']."')";
$inf_insertdbrow[36] = DB_UG3_SETTINGS." ( name, value, description ) VALUES ('UGLD_WELCOME_PM', '1', '".$ug3_upgrade['UGLD_WELCOME_PM']."')";
$inf_insertdbrow[37] = DB_UG3_SETTINGS." ( name, value, description ) VALUES ('UGLD_WELCOME_PM_SUBJECT', '".$ug3_upgrade['welcome_to']." ".$settings['sitename']."!', '".$ug3_upgrade['UGLD_WELCOME_PM_SUBJECT']."')";
$inf_insertdbrow[38] = DB_UG3_SETTINGS." ( name, value, description ) VALUES ('UGLD_WELCOME_PM_MESSAGE', '".$ug3_upgrade['hello']." %s! <br />', '".$ug3_upgrade['UGLD_WELCOME_PM_MESSAGE']."')";

$inf_insertdbrow[39] = DB_UG3_USAGE." ( id, name, description, purchase, cost, stock, image, category, active ) VALUES (1, 'GLD_FORUM_QUICK_REPLY', '".$ug3_upgrade['GLD_FORUM_QUICK_REPLY']."', '0', 5.00, '', 'blank.gif', '1', '1')";
$inf_insertdbrow[40] = DB_UG3_USAGE." ( id, name, description, purchase, cost, stock, image, category, active ) VALUES (2, 'GLD_FORUM_POST_REPLY', '".$ug3_upgrade['GLD_FORUM_POST_REPLY']."', '0', 10.00, '', 'blank.gif', '1', '1')";
$inf_insertdbrow[41] = DB_UG3_USAGE." ( id, name, description, purchase, cost, stock, image, category, active ) VALUES (3, 'GLD_FORUM_NEW_THREAD', '".$ug3_upgrade['GLD_FORUM_NEW_THREAD']."', '0', 20.00, '', 'blank.gif', '1', '1')";
$inf_insertdbrow[42] = DB_UG3_USAGE." ( id, name, description, purchase, cost, stock, image, category, active ) VALUES (4, 'GLD_FORUM_ATTACHMENT', '".$ug3_upgrade['GLD_FORUM_ATTACHMENT']."', '0', 10.00, '', 'blank.gif', '1', '1')";
$inf_insertdbrow[43] = DB_UG3_USAGE." ( id, name, description, purchase, cost, stock, image, category, active ) VALUES (5, 'GLD_FORUM_SIG', '".$ug3_upgrade['GLD_FORUM_SIG']."', '1', 1000.00, '1000', 'user_signature.gif', '1', '1')";
$inf_insertdbrow[44] = DB_UG3_USAGE." ( id, name, description, purchase, cost, stock, image, category, active ) VALUES (6, 'GLD_AVATAR', '".$ug3_upgrade['GLD_AVATAR']."', '1', 1000.00, '983', 'user_avatar.gif', '1', '1')";
$inf_insertdbrow[45] = DB_UG3_USAGE." ( id, name, description, purchase, cost, stock, image, category, active ) VALUES (7, 'GLD_THEME_SELECT', '".$ug3_upgrade['GLD_THEME_SELECT']."', '1', 200.00, '1000', 'user_themes.gif', '1', '1')";
$inf_insertdbrow[46] = DB_UG3_USAGE." ( id, name, description, purchase, cost, stock, image, category, active ) VALUES (8, 'GLD_USERNAME_COLOR', '".$ug3_upgrade['GLD_USERNAME_COLOR']."', '1', 1000.00, '1000', 'username_color.gif', '2', '1')";
$inf_insertdbrow[47] = DB_UG3_USAGE." ( id, name, description, purchase, cost, stock, image, category, active ) VALUES (9, 'GLD_USERNAME_BLINK', '".$ug3_upgrade['GLD_USERNAME_BLINK']."', '1', 1000.00, '1000', 'username_blink.gif', '2', '1')";
$inf_insertdbrow[48] = DB_UG3_USAGE." ( id, name, description, purchase, cost, stock, image, category, active ) VALUES (10, 'GLD_USERNAME_BOLD', '".$ug3_upgrade['GLD_USERNAME_BOLD']."', '1', 1000.00, '1000', 'username_bold.gif', '2', '1')";
$inf_insertdbrow[49] = DB_UG3_USAGE." ( id, name, description, purchase, cost, stock, image, category, active ) VALUES (11, 'GLD_USERNAME_ITALIC', '".$ug3_upgrade['GLD_USERNAME_ITALIC']."', '1', 1000.00, '1000', 'username_italic.gif', '2', '1')";
$inf_insertdbrow[50] = DB_UG3_USAGE." ( id, name, description, purchase, cost, stock, image, category, active ) VALUES (12, 'GLD_USERNAMESTRIKE', '".$ug3_upgrade['GLD_USERNAME_STRIKE']."', '1', 1000.00, '1000', 'username_strike.gif', '2', '1')";
$inf_insertdbrow[51] = DB_UG3_USAGE." ( id, name, description, purchase, cost, stock, image, category, active ) VALUES (13, 'GLD_USERLEVEL', '".$ug3_upgrade['GLD_USERLEVEL']."', '1', 100000.00, '1000', 'userlevel.gif', '1', '1')";
$inf_insertdbrow[52] = DB_UG3_USAGE." ( id, name, description, purchase, cost, stock, image, category, active ) VALUES (14, 'GLD_BANK_ACCOUNT', '".$ug3_upgrade['GLD_BANK_ACCOUNT']."', '1', 200.00, '1000', 'bank_account.gif', '1', '1')";
$inf_insertdbrow[53] = DB_UG3_USAGE." ( id, name, description, purchase, cost, stock, image, category, active ) VALUES (15, 'GLD_USERNAME_BLINK_BLOCK', '".$ug3_upgrade['GLD_USERNAME_BLINK_BLOCK']."', '1', 200.00, '1000', 'blink_block.gif', '2', '1')";
$inf_insertdbrow[54] = DB_UG3_USAGE." ( id, name, description, purchase, cost, stock, image, category, active ) VALUES (16, 'GLD_FORUM_POLL', '".$ug3_upgrade['GLD_FORUM_POLL']."', '0', 5.00, '', 'blank.gif', '1', '1')";
$inf_insertdbrow[55] = DB_UG3_USAGE." ( id, name, description, purchase, cost, stock, image, category, active ) VALUES (17, 'GLD_FORUM_POLL_VOTE', '".$ug3_upgrade['GLD_FORUM_POLL_VOTE']."', '0', 2.50, '', 'blank.gif', '1', '1')";
$inf_insertdbrow[56] = DB_UG3_USAGE." ( id, name, description, purchase, cost, stock, image, category, active ) VALUES (18, 'GLD_WEBLINK_SUBMIT', '".$ug3_upgrade['GLD_WEBLINK_SUBMIT']."', '0', 5.00, '', 'blank.gif', '1', '1')";
$inf_insertdbrow[57] = DB_UG3_USAGE." ( id, name, description, purchase, cost, stock, image, category, active ) VALUES (19, 'GLD_NEWS_SUBMIT', '".$ug3_upgrade['GLD_NEWS_SUBMIT']."', '0', 20.00, '', 'blank.gif', '1', '1')";
$inf_insertdbrow[58] = DB_UG3_USAGE." ( id, name, description, purchase, cost, stock, image, category, active ) VALUES (20, 'GLD_ARTICLE_SUBMIT', '".$ug3_upgrade['GLD_ARTICLE_SUBMIT']."', '0', 20.00, '', 'blank.gif', '1', '1')";
$inf_insertdbrow[59] = DB_UG3_USAGE." ( id, name, description, purchase, cost, stock, image, category, active ) VALUES (21, 'GLD_PHOTO_SUBMIT', '".$ug3_upgrade['GLD_PHOTO_SUBMIT']."', '0', 5.00, '', 'blank.gif', '1', '1')";
$inf_insertdbrow[60] = DB_UG3_USAGE." ( id, name, description, purchase, cost, stock, image, category, active ) VALUES (21, 'GLD_SHOUTBOX', '".$ug3_upgrade['GLD_SHOUTBOX']."', '0', 2.00, '', 'blank.gif', '1', '1')";

$inf_insertdbrow[61] = DB_UG3_CATEGORIES." ( cat_id, cat_name, cat_image, cat_description, cat_sorting, cat_access ) VALUES ( 1, '".$ug3_upgrade['USER_GOLD_3_CAT_TITLE']."', 'cat_usergold.gif', '".$ug3_upgrade['USER_GOLD_3_CAT_DESC']."', 'price', '101')";
$inf_insertdbrow[62] = DB_UG3_CATEGORIES." ( cat_id, cat_name, cat_image, cat_description, cat_sorting, cat_access ) VALUES ( 2, '".$ug3_upgrade['USERNAME_CAT_TITLE']."', 'cat_username.gif', '".$ug3_upgrade['USERNAME_CAT_DESC']."', 'price', '101')";

$inf_droptable[1] = DB_UG3;
$inf_droptable[2] = DB_UG3_INVENTORY;
$inf_droptable[3] = DB_UG3_SETTINGS;
$inf_droptable[4] = DB_UG3_USAGE;
$inf_droptable[5] = DB_UG3_CATEGORIES;
$inf_droptable[6] = DB_UG3_TRANSACTIONS;

$inf_adminpanel[1] = array(
	"title" => $locale['urg_admin1'],
	"image" => "user_gold.gif",
	"panel" => "admin/index.php",
	"rights" => "UG3"
);

$inf_sitelink[1] = array(
	"title" => $locale['urg_link1'],
	"url" => "index.php",
	"visibility" => "101"
);

?>