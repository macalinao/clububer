<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: upgrade_functions.php
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
require_once "../../../maincore.php";
require_once THEMES."templates/admin_header.php";

if (!checkrights("GIFT")) fallback("../index.php");

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."sf_gift_system/locale/".LOCALESET."/upgrade.php")) {
	// Load the locale file matching the current site locale setting.
	include INFUSIONS."sf_gift_system/locale/".LOCALESET."/upgrade.php";
} else {
	// Load the infusion's default locale file.
	include INFUSIONS."sf_gift_system/locale/English/upgrade.php";
}

require_once INFUSIONS."sf_gift_system/includes/functions.php";
require_once INFUSIONS."sf_gift_system/includes/infusion_db.php";
require_once INFUSIONS."sf_gift_system/includes/upgrade_functions.php";

//Upgrade Message
$message = "";

//Upgade Errors
$error = "0";

//New Version
$new_version = $myversion;	

//Upgrade - Stage 1
if (isset($_POST['stage1']) && $_POST['stage1'] == 1) {
	
	//Normal Upgrade - Stage 1
	if (isset($_POST['upgrade1'])) {
			
		if (!dbquery("UPDATE ".DB_GIFT_VERSION." SET gift_version='$new_version' WHERE gift_version_id='1'")) {
			$message = "<font color='red'>ERROR</font>: could not update the version";
			$error = "1";
		} else {
			$message = "<font color='green'><font color='green'>OK</font></font> - version sucsessfully updated";
		}
		
		//Updatelog for Normal upgrade for Stage 1
		opentable($locale['sfgift1010']);
		echo "<span class='small'>".$message."</span><br /><br />";
		
		if ($error == "1") {
			echo "<font color='red'><strong>".$locale['sfgift1011']." <strong>Normal upgrade - Stage 1</strong>.</strong></font>";	
		} else {
			echo "<font color='green'><strong>".$locale['sfgift1012']."</strong></font>";
		}
		
		echo "<br /><br />\n";
		closetable();
	}
}

opentable("Navigation - SF Gift System v.".$version['gift_version']."");
	echo "<table class='tbl-border' width='100%'>\n<tr>\n";
	echo "<td class='tbl1' align='center' width='50%'><a href='".GIFT_ADMIN."index.php'>".$locale['sfgift1001']."</a></td>\n";
	echo "<td class='tbl2' align='center' width='50%'><b>".$locale['sfgift1002']."</b></td>\n";
	echo "</tr>\n</table>\n";
closetable();

tablebreak();

opentable($locale['sfgift1000']);

//Display Upgrade Form
$result = dbquery("SELECT * FROM ".DB_GIFT_VERSION."");	
$data = dbarray($result);	
//Check if the version in the table is not current version
if ($data['gift_version'] < $new_version) {		
	echo "<form name='upgradeform' method='post' action='".FUSION_SELF."'>\n";
	echo "<table align='center' cellpadding='0' cellspacing='0' class='body'>\n<tr>\n";
	echo "<td>\n<center>\n";
	echo $locale['sfgift1003']."<br />\n";
	echo $locale['sfgift1005']."<br /><br />\n";
	echo "<input type='hidden' name='stage1' value='1' />\n";
	echo "<input type='submit' name='upgrade1' value='".$locale['sfgift1006']."' class='button' />\n";
	echo "</center>\n</td>\n";
	echo "</tr>\n</table>\n</form>\n";
//If it is, do not upgrade
} else {
	echo "<center><br />\n".$locale['sfgift1008']."<br /><br />\n</center>\n";
}

closetable();

require_once(GIFT_SYSTEM."footer.php");

require_once THEMES."templates/footer.php";
?>