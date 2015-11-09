<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: show_gift.php
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
require_once "../../maincore.php";
require_once THEMES."templates/header.php";

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."sf_gift_system/locale/".LOCALESET."/show_gift.php")) {
	// Load the locale file matching the current site locale setting.
	include INFUSIONS."sf_gift_system/locale/".LOCALESET."/show_gift.php";
} else {
	// Load the infusion's default locale file.
	include INFUSIONS."sf_gift_system/locale/English/show_gift.php";
}

require_once INFUSIONS."sf_gift_system/includes/functions.php";
require_once INFUSIONS."sf_gift_system/includes/infusion_db.php";

if (!isset($_GET['lookup'])) $_GET['lookup'] = "";

$result = dbquery("SELECT * FROM ".DB_GIFT_GIVEN." WHERE gift_given_id='".$_GET['gift_id']."'");
$data = dbarray($result);

$_GET['lookup'] = $data['gift_given_to'];

if ($_GET['lookup'] == $userdata['user_id']) {
	$access = "2";
} else {
	$access = "1";
}

if ((isset($_GET['gift_id'])) && (isNum($_GET['gift_id']))) {
	opentable($locale['sfgift300']);
	$result = dbquery("SELECT * FROM ".DB_GIFT_GIVEN." WHERE gift_given_id='".$_GET['gift_id']."' AND gift_given_visibillity<='$access' ORDER BY gift_given_id");
	$rows = dbrows($result);
	if ($rows != 0) {
		$data = dbarray($result);
		$gift = dbarray(dbquery("SELECT * FROM ".DB_GIFT." WHERE gift_id='".$data['gift_given_gift_id']."'"));
		$from = dbarray(dbquery("SELECT * FROM ".DB_USERS." WHERE user_id='".$data['gift_given_from']."'"));
		$to = dbarray(dbquery("SELECT * FROM ".DB_USERS." WHERE user_id='".$data['gift_given_to']."'"));
		echo "<table cellpadding='0' cellspacing='0' width='100%'>\n<tr>\n";
		echo "<td class='tbl' align='center'>\n";
		echo "<a href='".GIFT_SYSTEM."show_all.php?lookup=".$to['user_id']."'>".$locale['sfgift320']." ".$to['user_name']."'s ".$locale['sfgift321']."</a>\n";
		echo "</td>\n<td class='tbl' align='center'>\n";
		echo "<a href='".BASEDIR."profile.php?lookup=".$to['user_id']."'>".$locale['sfgift320']." ".$to['user_name']."'s ".$locale['sfgift322']."</a>\n";
		echo "</td>\n";
		if ($userdata['user_id'] != $to['user_id']) {
			echo "<td class='tbl' align='center'><a href='".GIFT_SYSTEM."brows_gifts.php?user_id=".$to['user_id']."'>".$locale['sfgift323']." ".$to['user_name']."</a></td>\n";
			$colspan = "3";
		} else {
			$colspan = "2";
		}
		echo "</tr>\n<tr>\n";
		echo "<td colspan='".$colspan."'><hr></td>\n";
		echo "</tr>\n</table>\n";		
		echo "<table cellpadding='0' cellspacing='0' width='100%'><tr>\n";
		echo "<td align='center' valign='top' width='100' rowspan='3'><img src='".GIFT_IMAGES.$gift['gift_image']."' alt='".$gift['gift_image']."' style='border:0px;' border='' /></td>\n";
		if (($data['gift_given_visibillity'] == "1") && ($data['gift_given_to'] != $userdata['user_id'])) {
			echo "<td><h2>".$locale['sfgift301']."</h2></td>\n";
		} else {
			echo "<td><h2>".$locale['sfgift302']." ".$from['user_name']."</h2></td>\n";
		}
		echo "</tr>\n<tr>\n";
		echo "<td>";
		if ($data['gift_given_visibillity'] == "0") {
			echo "<strong>".$locale['sfgift303']."</strong><br />".$locale['sfgift304']."";
		} else if ($data['gift_given_visibillity'] == "1") {
			echo "<strong>".$locale['sfgift305']."</strong><br />".$locale['sfgift306']."";
		} else if ($data['gift_given_visibillity'] == "2") {
			echo "<strong>".$locale['sfgift307']."</strong><br />".$locale['sfgift308']."";
		}
		echo "</td>\n</tr>\n";
		if ($data['gift_given_message'] != "") {
			echo "<tr><td><br /><br /><img src='quote.gif' alt='' align='top' border='0' /> ".$data['gift_given_message']." <img src='quote.gif' alt='' align='bottom' border='0' /></td></tr>\n";
		}
		echo "</table>\n";
	} else {
		echo "<center><br />".$locale['sfgift309']."<br /><br />\n</center>\n";
	}
	closetable();
} else {
	redirect(BASEDIR."index.php");
}

require_once(GIFT_SYSTEM."footer.php");

require_once THEMES."templates/footer.php";
?>