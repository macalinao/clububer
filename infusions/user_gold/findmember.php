<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| User Gold 3
| Copyright © 2007 - 2008 UG3 Developement Team
| http://www.starglowone.com/
+--------------------------------------------------------+
| Filename: findmember.php
| Author: UG3 Developement Team
+--------------------------------------------------------+
| This program is released as free software under the
| Stars Heaven Licence. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included licence.html.
| Removal of this copyright header is strictly
| prohibited without written permission
| from the original author(s).
+--------------------------------------------------------*/
require_once "../../maincore.php";
require_once THEME."theme.php";
require_once BASEDIR."includes/output_handling_include.php";

include_once INFUSIONS."user_gold/infusion_db.php";
include_once INFUSIONS."user_gold/functions.php";

if (file_exists(GOLD_LANG.LOCALESET."findmember.php")) {
	include_once GOLD_LANG.LOCALESET."findmember.php";
} else {
	include_once GOLD_LANG."English/findmember.php";
}

echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>\n";
echo "<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='".$locale['xml_lang']."' lang='".$locale['xml_lang']."'>\n";
echo "<head>\n";
echo "<title>".$locale['urg_findmember_104']." ". GOLD_VERSION."</title>\n";
echo "<meta http-equiv='Content-Type' content='text/html; charset=".$locale['charset']."' />\n";
echo "<link rel='stylesheet' href='".THEME."styles.css' type='text/css' />\n";
echo "</head>\n<body>\n";
opentable($locale['urg_findmember_100']);
	echo "<div style='padding: 5px;'>";
	if(!empty($_POST['stext'])) {
		if (isset($stext)) $stext = stripinput($stext);
		if (!isset($stext)) $stext = isset($_POST['stext']) ? $_POST['stext'] : "";
		$stext = descript($stext);
		$result = dbquery("SELECT user_id,user_name FROM ".DB_USERS." WHERE user_name LIKE '%$stext%' OR user_id LIKE '%$stext%' ORDER BY user_name");
		while ($data = dbarray($result)) {
			echo "<a href='".BASEDIR."profile.php?lookup=".$data['user_id']."'>".$data['user_name']."</a><br>\n";
		}
	} else {
		echo $locale['urg_findmember_101'];
		echo "<form name='searchform' method='post' action='findmember.php'>\n";
		echo "<input type='text' name='stext' value='".isset($stext)."' class='textbox' style='width:200px' />\n";
		echo "<input type='submit' name='search' value='".$locale['urg_findmember_102']."' class='button' /></form>\n";
	}
	echo "</div>";
	echo "<div style='text-align: center;'><p>\n";
	echo "<a href='javascript:window.close();'><img border='0' src='images/close.png' title='".$locale['urg_findmember_103']."' alt='".$locale['urg_findmember_103']."' /></a>\n";
	echo "</p></div>\n";
closetable();
echo "</body>\n";
echo "</html>\n";
?>