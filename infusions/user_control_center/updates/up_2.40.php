<?php
/*---------------------------------------------------+
| PHP-Fusion 6 Content Management System
+----------------------------------------------------+
| Copyright � 2002 - 2005 Nick Jones
| http://www.php-fusion.co.uk/
+----------------------------------------------------+
| Released under the terms & conditions of v2 of the
| GNU General Public License. For details refer to
| the included gpl.txt file or visit http://gnu.org
+----------------------------------------------------+
| User Control Center made by:
| Sebastian "slaughter" Sch�ssler
| http://basti2web.de
+----------------------------------------------------*/
require_once "../../../maincore.php";
require_once THEMES."templates/admin_header.php";

if (!checkrights("IP") || !defined("iAUTH") || $aid != iAUTH || !defined("IN_FUSION")) fallback("index.php");

if (file_exists(INFUSIONS."user_control_center/locale/".$settings['locale'].".php")) {
include INFUSIONS."user_control_center/locale/".$settings['locale'].".php";
} else {
include INFUSIONS."user_control_center/locale/English/ucc_global.php";
}

opentable("Update: v2.32 => v2.40");

//-----------

$res1 = dbquery("UPDATE ".$db_prefix."ucc_settings SET ucc_version = '2.40'");

$res2 = dbquery("UPDATE ".$db_prefix."infusions SET inf_version='2.40' WHERE inf_folder='user_control_center'");

$res3 = dbquery("ALTER TABLE ".$db_prefix."ucc_settings ADD ucc_version_temp VARCHAR(100) NOT NULL");

$res4 = dbquery("ALTER TABLE ".$db_prefix."ucc_settings ADD ucc_version_time INT(10) UNSIGNED NOT NULL DEFAULT '0'");


if ($res1 && $res2 && $res3 && $res4) {
echo "<br>".$locale['ucc_183']; 
} else {
echo "<br>".$locale['ucc_184']; 
}

echo "<br><br><a href='".INFUSIONS."user_control_center/ucc_admin.php".$aidlink."'>".$locale['ucc_185']."</a>";

//-----------
closetable();
tablebreak();

require_once THEMES."templates/admin_footer.php";
?>