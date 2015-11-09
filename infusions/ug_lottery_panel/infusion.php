<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| UG Lottery Panel
| Copyright © 2007 - 2008 Stephan Hansson (StarglowOne)
| http://www.starglowone.com/
+--------------------------------------------------------+
| Filename: infusion.php
| Author: Stephan Hansson (StarglowOne)
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

include INFUSIONS."ug_lottery_panel/infusion_db.php";

//Needed for the UG Lottery settings variables to be inserted in DB_UG_SETTINGS table
include_once INFUSIONS."user_gold/infusion_db.php";

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."ug_lottery_panel/locale/".$settings['locale'].".php")) {
	// Load the locale file matching the current site locale setting.
	include INFUSIONS."ug_lottery_panel/locale/".$settings['locale'].".php";
} else {
	// Load the infusion's default locale file.
	include INFUSIONS."ug_lottery_panel/locale/English.php";
}
// Infusion general information
$inf_title = $locale['ugly_title'];
$inf_description = $locale['ugly_desc'];
$inf_version = $locale['ugly_version'];
$inf_developer = "StarglowOne";
$inf_email = "support@starglowone.com";
$inf_weburl = "http://www.starglowone.com";

$inf_folder = "ug_lottery_panel"; // The folder in which the infusion resides.

//ug_lottery_drawings table.
$inf_newtable[1] = DB_UG_LOTTERY_DRAWINGS." (
draw_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
lots INT(11) NOT NULL DEFAULT '0',
lot_price INT(11) NOT NULL DEFAULT '0',
prize INT(11) NOT NULL DEFAULT '0',
endtime INT(11) NOT NULL DEFAULT '0',
ended TINYINT(1) NOT NULL DEFAULT '0',
prize_winner_name VARCHAR(255) NOT NULL,
prize_winner_id BIGINT(20) NOT NULL DEFAULT '0',
lot_amnt INT(11) NOT NULL DEFAULT '0',
jtype VARCHAR(10) NOT NULL,
PRIMARY KEY (draw_id)
) TYPE=MyISAM;";

// ug_lottery_lots table.
$inf_newtable[2] = DB_UG_LOTTERY_LOTS." (
lot_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
lot_draw INT(11) NOT NULL DEFAULT '0',
lot_owner INT(11) NOT NULL DEFAULT '0',
lot_owner_name VARCHAR(255) NOT NULL,
PRIMARY KEY  (lot_id)
) TYPE=MyISAM;";

$inf_insertdbrow[1] = DB_UG3_SETTINGS." (name, value, description) VALUES ('UGLY_SEND_ADMIN_PM', '1', '".$locale['ugly_103']."')";
$inf_insertdbrow[2] = DB_UG3_SETTINGS." (name, value, description) VALUES ('UGLY_SEND_NOT_ENOUGH_TICKETS_PM', '1', '".$locale['ugly_104']."')";
$inf_insertdbrow[3] = DB_UG3_SETTINGS." (name, value, description) VALUES ('UGLY_SEND_WINNER_PM', '1', '".$locale['ugly_105']."')";
$inf_insertdbrow[4] = DB_UG3_SETTINGS." (name, value, description) VALUES ('UGLY_DEFAULT_AMOUNT', '1000', '".$locale['ugly_106']."')";
$inf_insertdbrow[5] = DB_UG3_SETTINGS." (name, value, description) VALUES ('UGLY_DEFAULT_PRICE', '100', '".$locale['ugly_107']."')";
$inf_insertdbrow[6] = DB_UG3_SETTINGS." (name, value, description) VALUES ('UGLY_DEFAULT_JACKPOT', '1000', '".$locale['ugly_108']."')";
$inf_insertdbrow[7] = DB_UG3_SETTINGS." (name, value, description) VALUES ('UGLY_DEFAULT_TYPE', 'cash', '".$locale['ugly_109']."')";
$inf_insertdbrow[8] = DB_UG3_SETTINGS." (name, value, description) VALUES ('UGLY_DEFAULT_ENDTIME', '608400', '".$locale['ugly_110']."')";
$inf_insertdbrow[9] = DB_UG3_SETTINGS." (name, value, description) VALUES ('UGLY_DEFAULT_START_NEW_DRAW', '608400', '".$locale['ugly_111']."')";

$inf_deldbrow[1] = DB_UG3_SETTINGS." WHERE name = 'UGLY_SEND_ADMIN_PM'";
$inf_deldbrow[2] = DB_UG3_SETTINGS." WHERE name = 'UGLY_SEND_NOT_ENOUGH_TICKETS_PM'";
$inf_deldbrow[3] = DB_UG3_SETTINGS." WHERE name = 'UGLY_SEND_WINNER_PM'";
$inf_deldbrow[4] = DB_UG3_SETTINGS." WHERE name = 'UGLY_DEFAULT_AMOUNT'";
$inf_deldbrow[5] = DB_UG3_SETTINGS." WHERE name = 'UGLY_DEFAULT_PRICE'";
$inf_deldbrow[6] = DB_UG3_SETTINGS." WHERE name = 'UGLY_DEFAULT_JACKPOT'";
$inf_deldbrow[7] = DB_UG3_SETTINGS." WHERE name = 'UGLY_DEFAULT_TYPE'";
$inf_deldbrow[8] = DB_UG3_SETTINGS." WHERE name = 'UGLY_DEFAULT_ENDTIME'";
$inf_deldbrow[9] = DB_UG3_SETTINGS." WHERE name = 'UGLY_DEFAULT_START_NEW_DRAW'";

$inf_droptable[1] = DB_UG_LOTTERY_DRAWINGS;
$inf_droptable[2] = DB_UG_LOTTERY_LOTS;

$inf_adminpanel[1] = array(
	"title" => $locale['ugly_admin1'],
	"image" => "ug_lottery.gif",
	"panel" => "admin/index.php",
	"rights" => "UGLY"
);

$inf_sitelink[1] = array(
	"title" => $locale['ugly_link1'],
	"url" => "index.php",
	"visibility" => "101"
);
?>