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

//Needed for the UG Lottery settings variables to be inserted in DB_UG_SETTINGS table
include_once INFUSIONS."user_gold/infusion_db.php";

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."ug_avatarmaker/locale/".$settings['locale'].".php")) {
	// Load the locale file matching the current site locale setting.
	include INFUSIONS."ug_avatarmaker/locale/".$settings['locale'].".php";
} else {
	// Load the infusion's default locale file.
	include INFUSIONS."ug_avatarmaker/locale/English.php";
}
// Infusion general information
$inf_title = $locale['ugam_title'];
$inf_description = $locale['ugam_desc'];
$inf_version = $locale['ugam_version'];
$inf_developer = "StarglowOne";
$inf_email = "support@starglowone.com";
$inf_weburl = "http://www.starglowone.com";

$inf_folder = "ug_avatarmaker"; // The folder in which the infusion resides.

$inf_insertdbrow[1] = DB_UG3_SETTINGS." (name, value, description) VALUES ('UGAM_AVATAR_MAKER_WIDTH', '50', '".$ug_help_locale['UGAM_AVATAR_MAKER_WIDTH']."') ";
$inf_insertdbrow[2] = DB_UG3_SETTINGS." (name, value, description) VALUES ('UGAM_AVATAR_MAKER_HEIGHT', '50', '".$ug_help_locale['UGAM_AVATAR_MAKER_HEIGHT']."')";
$inf_insertdbrow[3] = DB_UG3_SETTINGS." (name, value, description) VALUES ('UGAM_AVATAR_MAKER_IMAGE', '11', '".$ug_help_locale['UGAM_AVATAR_MAKER_IMAGE']."')";
$inf_insertdbrow[4] = DB_UG3_SETTINGS." (name, value, description) VALUES ('UGAM_IMAGE_TYPE', 'PNG', '".$ug_help_locale['UGAM_IMAGE_TYPE']."')";
$inf_insertdbrow[5] = DB_UG3_SETTINGS." (name, value, description) VALUES ('UGAM_IMAGESINROW', '5', '".$ug_help_locale['UGAM_IMAGESINROW']."')";

$inf_deldbrow[1] = DB_UG3_SETTINGS." WHERE name = 'UGAM_AVATAR_MAKER_WIDTH'";
$inf_deldbrow[2] = DB_UG3_SETTINGS." WHERE name = 'UGAM_AVATAR_MAKER_HEIGHT'";
$inf_deldbrow[3] = DB_UG3_SETTINGS." WHERE name = 'UGAM_AVATAR_MAKER_IMAGE'";
$inf_deldbrow[4] = DB_UG3_SETTINGS." WHERE name = 'UGAM_IMAGE_TYPE'";
$inf_deldbrow[5] = DB_UG3_SETTINGS." WHERE name = 'UGAM_IMAGESINROW'";

?>