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
require_once "../../../maincore.php";
require_once BASEDIR."subheader.php";
require_once ADMIN."navigation.php";
if (!iADMIN || !checkrights("IP")) redirect(BASEDIR."index.php");
if(!isset($settings['seofusion'])) redirect(INFUSIONS."seofusion/admin/update.php");

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."seofusion/".$settings['locale'].".php")) {
	// Load the locale file matching the current site locale setting.
	require_once INFUSIONS."seofusion/locale/".$settings['locale'].".php";
} else {
	// Load the infusion's default locale file.
	require_once INFUSIONS."seofusion/locale/German.php";
}


if (isset($_POST['savesettings'])) {
$seofusion = intval($_POST['seofusion']);
$result = dbquery("UPDATE ".DB_PREFIX."settings SET seofusion='$seofusion'");	
	if ($result) {
	redirect(INFUSIONS."seofusion/admin/".FUSION_SELF.$aidlink);
	}
}
 
opentable( $locale['SEO54'] );

echo "<form action='".INFUSIONS."seofusion/admin/".FUSION_SELF.$aidlink."' method='post' name='settingform'>";
echo "<table border='0' cellspacing='0' cellpadding='1'><tr><td>";
echo $locale['SEO55'].": </td><td><select name='seofusion' class='textbox'><option value='1'".($settings['seofusion']==1? ' selected' : '').">".$locale['SEO56']."</option><option value='0'".($settings['seofusion']==0? ' selected' : '').">".$locale['SEO57']."</option></select></td></tr><tr><td colspan='2' class='tbl'><input type='submit' name='savesettings' value='Speichern' class='button'>";
echo "</td></tr></table></form>";

closetable();


require_once BASEDIR."footer.php";
?>