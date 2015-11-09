<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| User Control Center 2.42a
| Author: Sebastian Schüssler (slaughter)
| Download:
| http://basti2web.de
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/

if (!defined("IN_FUSION") || !checkrights("I")) { header("Location:index.php"); exit; }

require_once INFUSIONS."user_control_center/infusion_db.php";

// Load locale file
if (file_exists(INFUSIONS."user_control_center/locale/".$settings['locale']."/ucc_global.php")) {
include INFUSIONS."user_control_center/locale/".$settings['locale']."/ucc_global.php";
} else {
include INFUSIONS."user_control_center/locale/English/ucc_global.php";
}

// Infusion general information
$inf_title = $locale['ucc_100'];
$inf_description = $locale['ucc_101'];
$inf_version = "2.42";
$inf_developer = "Sebastian Schüssler (slaughter)";
$inf_email = "";
$inf_weburl = "http://www.basti2web.de";

$inf_folder = "user_control_center";


// PHP-Fusion version check
require_once INFUSIONS."user_control_center/includes/check_version.php";


// Load Database information; v6 and v7 Compatibility
switch(UCC_PHPF_VER) {
case 6:
	require_once INFUSIONS."user_control_center/infusion_v6.php";
	break;
case 7:
	require_once INFUSIONS."user_control_center/infusion_v7.php";
	break;
default:
	die("error ucc001: UCC_PHPF_VER does not contain any version number");
}

?>
