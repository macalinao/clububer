<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: functions.php
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

// SF Gift System Path definitions
define("GIFT_SYSTEM", INFUSIONS."sf_gift_system/");
define("GIFT_ADMIN", INFUSIONS."sf_gift_system/admin/");
define("GIFT_INCLUDES", GIFT_SYSTEM."includes/");
define("GIFT_INCLUDES_JS", GIFT_SYSTEM."includes/js/");
define("GIFT_VERSIONCHECKER", GIFT_INCLUDES."version_checker/");
define("GIFT_VERSIONCHECKER_IMAGES", GIFT_INCLUDES."version_checker/images/");
define("GIFT_IMAGES", GIFT_SYSTEM."images/");
define("GIFT_LOCALE", GIFT_SYSTEM."locale/");

define("GIFT_PANEL", INFUSIONS."sf_gift_panel/");

// Includes
add_to_head("<script type='text/javascript' src='".GIFT_INCLUDES_JS."jscript.js'></script>");
require_once GIFT_INCLUDES."infusion_db.php";
require_once INFUSIONS."user_gold/functions.php";
require_once GIFT_INCLUDES."upgrade_functions.php";

//Check if table exist, used in upgrade
function table_exists($table_name) {
	$Table = mysql_query("show tables like '".$table_name."'");

	if (mysql_fetch_row($Table) === false) {
		return(false);
		exit;
	} else {
		return(true);
		exit;
	}
}

//The version your are running
if (!table_exists(DB_GIFT_VERSION)) {
	include GIFT_SYSTEM."infusion.php";
	$result = dbquery("CREATE TABLE ".$inf_newtable[2]);
	$result = dbquery("INSERT INTO ".$inf_insertdbrow[1]);
}

$result = dbquery("SELECT gift_version FROM ".DB_GIFT_VERSION." LIMIT 1");
if (dbrows($result)) {
	$version = dbarray($result);
} else {
	include GIFT_SYSTEM."infusion.php";
	$result = dbquery("INSERT INTO ".$inf_insertdbrow[1]);
	$result = dbquery("SELECT gift_version FROM ".DB_GIFT_VERSION." LIMIT 1");
	if (dbrows($result)) {
		$version = dbarray($result);
	} else {
		echo "Fatal Error Occured!";
	}
}

?>