<?php
/*---------------------------------------------------+
| PHP-Fusion 6 Content Management System
+----------------------------------------------------+
| Copyright © 2002 - 2006 Nick Jones
| http://www.php-fusion.co.uk/
+----------------------------------------------------+
| Released under the terms & conditions of v2 of the
| GNU General Public License. For details refer to
| the included gpl.txt file or visit http://gnu.org
+----------------------------------------------------*/
require_once "../../../maincore.php";
if (!iADMIN || !checkrights('IP')) redirect(BASEDIR."index.php");
require_once BASEDIR."subheader.php";
require_once ADMIN."navigation.php";
opentable("seoFusion :: Update");

$result = dbquery("ALTER TABLE ".DB_PREFIX."settings ADD seofusion TINYINT(1) UNSIGNED NOT NULL DEFAULT '0'");	
$result = dbquery("INSERT INTO ".$db_prefix."panels (panel_name, panel_filename, panel_content, panel_side, panel_order, panel_type, panel_access, panel_display, panel_status) VALUES ('Tags', 'seofusion_panel', '', '1', '1', 'file', '0', '0', '1')");
if ($result) {
echo "<br />".$locale['SEO53'];	
echo '<br><br><center><a href="admin.php">Admin</a></center><br>';
}

closetable();
require_once BASEDIR."footer.php";
?>