<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: profile_include.php
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
if (!defined("IN_FUSION")) { die("Access Denied"); }

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."sf_gift_system/locale/".LOCALESET."/profile_include.php")) {
	// Load the locale file matching the current site locale setting.
	include INFUSIONS."sf_gift_system/locale/".LOCALESET."/profile_include.php";
} else {
	// Load the infusion's default locale file.
	include INFUSIONS."sf_gift_system/locale/English/profile_include.php";
}

if ($_GET['lookup'] == $userdata['user_id']) {
	$access = "2";
} else {
	$access = "1";
}

$result = dbquery("SELECT * FROM ".DB_GIFT_GIVEN." WHERE gift_given_to='".$_GET['lookup']."' AND gift_given_visibillity<='$access' ORDER BY RAND() LIMIT 4");
if (dbrows($result)) {
	echo "<center>\n<table width='100%'>\n<tr>\n";
	while ($data = dbarray($result)) {
		$user2 = dbarray(dbquery("SELECT * FROM ".$db_prefix."users WHERE user_id='".$data['gift_given_from']."'"));
		$gift = dbarray(dbquery("SELECT * FROM ".$db_prefix."sf_gift WHERE gift_id='".$data['gift_given_gift_id']."'"));
		echo "<td class='tbl1' align='center'>\n";
		echo "<a href='".INFUSIONS."sf_gift_system/show_gift.php?lookup=".$data['gift_given_to']."&amp;gift_id=".$data['gift_given_id']."'>\n";
		echo "<img src='".INFUSIONS."sf_gift_system/images/".$gift['gift_image']."' border='0'></a><br>\n";
		if (($data['gift_given_visibillity'] == '1') && ($lookup != $userdata['user_id'])) {
			echo "Anonymous\n";
		} else {
			echo "<a href='".BASEDIR."profile.php?lookup=".$user2['user_id']."'>".$user2['user_name']."</a>\n";
		}
		echo "</td>\n";
	}
	echo "</tr>\n</table>\n</center>\n";
	echo "<p align='right'><a href='".INFUSIONS."sf_gift_system/show_all.php?lookup=".$_GET['lookup']."'>".$locale['sfgift401']."</a></p>\n";
} else {
	echo "<center><strong>".$locale['sfgift402']."</strong></center>\n";
}
?>