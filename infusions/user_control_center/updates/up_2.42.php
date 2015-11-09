<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright � 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| User Control Center 2.42a
| Author: Sebastian Sch�ssler (slaughter)
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

require_once "../../../maincore.php";

// Check: iAUTH and $aid
if (!defined("iAUTH") || $_GET['aid'] != iAUTH) redirect("index.php");

// Includes
require_once INFUSIONS."user_control_center/infusion_db.php";
require_once INFUSIONS."user_control_center/includes/functions.php";

require_once INFUSIONS."user_control_center/version.php";

// Check: Admin Rights
//if (!defined("UCC_ADMIN") || !UCC_ADMIN) redirect("index.php");

// Header
switch(UCC_PHPF_VER) {
case 6:
	require_once BASEDIR."subheader.php";
	require_once ADMIN."navigation.php";
	break;
case 7:
	require_once THEMES."templates/admin_header.php";
	break;
default:
	die("error ucc002: UCC_PHPF_VER does not contain any version number");
}


if (file_exists(INFUSIONS."user_control_center/locale/".$settings['locale']."/ucc_global.php")) {
include INFUSIONS."user_control_center/locale/".$settings['locale']."/ucc_global.php";
} else {
include INFUSIONS."user_control_center/locale/English/ucc_global.php";
}

opentable("Update: v2.40 => v2.42");

//-----------

$res1 = dbquery("UPDATE ".$db_prefix."ucc_settings SET ucc_version = '2.42'");

$res2 = dbquery("UPDATE ".$db_prefix."infusions SET inf_version='2.42' WHERE inf_folder='user_control_center'");

if ($res1 && $res2) {
echo "<br>".$locale['ucc_183']; 
} else {
echo "<br>".$locale['ucc_184']; 
}

echo "<br><br><a href='".INFUSIONS."user_control_center/ucc_admin.php".$aidlink."'>".$locale['ucc_185']."</a>";

//-----------
closetable();

// Footer
switch(UCC_PHPF_VER) {
case 6:
	echo "</td>\n";
	require_once BASEDIR."footer.php";
	break;
case 7:
require_once THEMES."templates/footer.php";
	break;
default:
	die("error ucc003: UCC_PHPF_VER does not contain any version number");
}
?>