<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: vc_config.php
| CVS Version: 1.1.1
| Author: Starefossen
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
if (!defined("IN_FUSION") || !checkrights("I")) { die("Access Denied"); }

// Check if locale file is available matching the current site locale setting.
if (file_exists("locale/".$settings['locale'].".php")) {
	// Load the locale file matching the current site locale setting.
	include ("locale/".$settings['locale'].".php");
} else {
	// Load the infusion's default locale file.
	include ("locale/English.php");
}

/*---------------------------------------------------+
| Definitions should be filled out correctly in order| 
| to get the versiuon updater to work correctly.     |
| Place read the manual on how to setup vc_config.php|
| correctly!										 |
+----------------------------------------------------*/

//Path to the verion_checker folder.
define("CHECKER_PATH", INFUSIONS."sf_gift_system/includes/");

//Full name to the prioject you want to check for.
define("CHECK_PROJECT_NAME", "SF Gift System"); 

//Shortcut name to the prioject you want to check for.
define("CHECK_PROJECT_SC", "sfgif1"); 

//SUpport site for the infusion if automatic check should fail.
define("SUPPORT_SITE_URL", "http://www.starglowone.com"); 

//Name of the support site
define("SUPPORT_SITE_NAME", "Stars Heaven");


?>