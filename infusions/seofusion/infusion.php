<?php
/*---------------------------------------------------+
| PHP-Fusion 6 Content Management System
+----------------------------------------------------+
| Copyright © 2002 - 2005 Nick Jones
| http://www.php-fusion.co.uk/
+----------------------------------------------------+
| Released under the terms & conditions of v2 of the
| GNU General Public License. For details refer to
| the included gpl.txt file or visit http://gnu.org
+----------------------------------------------------*/
if (!defined("IN_FUSION") || !checkrights("I")) { header("Location: ../../index.php"); exit; }

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."seofusion/locale/".$settings['locale'].".php")) {
	// Load the locale file matching the current site locale setting.
	include INFUSIONS."seofusion/locale/".$settings['locale'].".php";
} else {
	// Load the infusion's default locale file.
	include INFUSIONS."seofusion/locale/German.php";
}

// Infusion general information
$inf_title = "seoFUSION";
$inf_description = $locale['SEO59'];
$inf_version = "2.0";
$inf_developer = "Freakz";
$inf_email = "info@game-land.eu";
$inf_weburl = "http://www.seofusion.de";

$inf_folder = "seofusion"; // The folder in which the infusion resides.
$inf_admin_image = ""; // Leave blank to use the default image.
$inf_admin_panel = "admin/admin.php"; // The admin panel filename if required.

$inf_newtables = 0; // Number of new db tables to create or drop.
$inf_insertdbrows = 0; // Numbers rows added into created db tables.
$inf_altertables = 0; // Number of db tables to alter (upgrade).
$inf_deldbrows = 0; // Number of db tables to delete data from.

?>