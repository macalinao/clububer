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
+----------------------------------------------------+
| User Control Center made by:
| Sebastian "slaughter" Schüssler
| http://basti2web.de
+----------------------------------------------------*/
require_once "../../../maincore.php";
require_once BASEDIR."subheader.php";
require_once ADMIN."navigation.php";

if (!checkrights("IP") || !defined("iAUTH") || $aid != iAUTH || !defined("IN_FUSION")) fallback("index.php");

if (file_exists(INFUSIONS."user_control_center/locale/".$settings['locale'].".php")) {
include INFUSIONS."user_control_center/locale/".$settings['locale'].".php";
} else {
include INFUSIONS."user_control_center/locale/English.php";
}

opentable("Update: v2.30 => v2.31");

//-----------

$res1 = dbquery("UPDATE ".$db_prefix."ucc_settings SET ucc_version = '2.31'");

$res2 = dbquery("UPDATE ".$db_prefix."infusions SET inf_version='2.31' WHERE inf_folder='user_control_center'");


if ($res1 && $res2 ) {
echo "<br>".$locale['ucc_183']; 
} else {
echo "<br>".$locale['ucc_184']; 
}

echo "<br><br><a href='".INFUSIONS."user_control_center/ucc_admin.php".$aidlink."'>".$locale['ucc_185']."</a>";

//-----------
closetable();
tablebreak();

require_once BASEDIR."footer.php";
?>