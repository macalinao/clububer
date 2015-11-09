<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: infusion.php
| Author: Starefossen
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

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."sf_gift_system/locale/".LOCALESET."/infusion.php")) {
	// Load the locale file matching the current site locale setting.
	include INFUSIONS."sf_gift_system/locale/".LOCALESET."/infusion.php";
} else {
	// Load the infusion's default locale file.
	include INFUSIONS."sf_gift_system/locale/English/infusion.php";
}

require_once INFUSIONS."sf_gift_system/includes/upgrade_functions.php";
require_once INFUSIONS."sf_gift_system/includes/infusion_db.php";

// Infusion general information
$inf_title = $locale['sfgift100'];
$inf_description = $locale['sfgift101'];
$inf_version = $myversion;
$inf_developer = "Starefossen";
$inf_email = "hans@starefossen.com";
$inf_weburl = "http://dev.starsheaven.com";
$inf_folder = "sf_gift_system";

// Delete any items not required here.
$inf_newtable[1] = DB_GIFT." (
gift_id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
gift_image VARCHAR(200) NOT NULL,
gift_price INT(11) UNSIGNED NOT NULL,
gift_stock INT(11) UNSIGNED NOT NULL,
gift_bought INT(11) UNSIGNED NOT NULL,
PRIMARY KEY (gift_id)
) TYPE=MyISAM;";

$inf_newtable[2] = DB_GIFT_VERSION." (
gift_version_id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
gift_version varchar(10) NOT NULL default '".$myversion."',
PRIMARY KEY (gift_version_id)
) TYPE=MyISAM;";

$inf_newtable[3] = DB_GIFT_GIVEN." (
gift_given_id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
gift_given_gift_id INT(11) UNSIGNED NOT NULL,
gift_given_from INT(11) UNSIGNED NOT NULL,
gift_given_to INT(11) UNSIGNED NOT NULL,
gift_given_visibillity INT(1) UNSIGNED NOT NULL DEFAULT '0',
gift_given_message TEXT NOT NULL,
PRIMARY KEY (gift_given_id)
) TYPE=MyISAM;";

$inf_insertdbrow[1] = DB_GIFT_VERSION." (gift_version_id, gift_version) VALUES('', '".$myversion."')";

$inf_droptable[1] = DB_GIFT;
$inf_droptable[3] = DB_GIFT_VERSION;
$inf_droptable[2] = DB_GIFT_GIVEN;

$inf_adminpanel[1] = array(
	"title" => $locale['sfgift100'],
	"image" => "sf_gift_system.gif",
	"panel" => "admin/index.php",
	"rights" => "GIFT"
);

$inf_sitelink[1] = array(
	"title" => $locale['sfgift100'],
	"url" => "brows_gifts.php",
	"visibility" => "101"
);

?>