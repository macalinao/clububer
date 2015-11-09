<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: show_all.php
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
if (file_exists(INFUSIONS."sf_gift_system/locale/".LOCALESET."/show_all.php")) {
	// Load the locale file matching the current site locale setting.
	include INFUSIONS."sf_gift_system/locale/".LOCALESET."/show_all.php";
} else {
	// Load the infusion's default locale file.
	include INFUSIONS."sf_gift_system/locale/English/show_all.php";
}

require_once INFUSIONS."sf_gift_system/includes/functions.php";
require_once INFUSIONS."sf_gift_system/includes/infusion_db.php";

if ($_GET['lookup'] == $userdata['user_id']) {
	$access = "2";
} else {
	$access = "1";
}

if (!isset($_GET['status'])) $_GET['status'] = "";

$gift_images = true;

$user2 = dbarray(dbquery("SELECT * FROM ".DB_USERS." WHERE user_id='".$_GET['lookup']."' LIMIT 1"));

if (($_GET['lookup'] == $userdata['user_id']) && (isset($_GET['lookup'])) && (isNum($_GET['lookup'])) && (isset($_GET['step'])) && ($_GET['step']=="delete") && (isset($_GET['gift_id'])) && (isNum($_GET['gift_id']))) {
	$result = dbquery("SELECT * FROM ".DB_GIFT_GIVEN." WHERE gift_given_to='".$_GET['lookup']."' AND gift_given_id='".$_GET['gift_id']."'");
	if (dbrows($result)) {
		$data = dbarray($result);
		$gift = dbarray(dbquery("SELECT * FROM ".DB_GIFT." WHERE gift_id='".$data['gift_given_gift_id']."'"));
		$result = dbquery("DELETE FROM ".DB_GIFT_GIVEN." WHERE gift_given_id='".$_GET['gift_id']."'"); // Delete the Gift
		$result = dbquery("UPDATE ".DB_GIFT." SET gift_bought=gift_bought-1 WHERE gift_id='".$gift['gift_id']."'"); //Update Gifts Bought
		redirect(FUSION_SELF."?lookup=".$_GET['lookup']."&status=deleted");
	} else {
		redirect(FUSION_SELF."?lookup=".$_GET['lookup']."&status=error1");
	}
}

if ((isset($_GET['lookup'])) && (isNum($_GET['lookup']))) {
	opentable($locale['sfgift500']." ".$user2['user_name']);
	if (isset($_GET['status']) && $_GET['status'] == "deleted") echo "<table width='100%' align='center'>\n<tr>\n<td align='center'><b>".$locale['sfgift510']."</b><br /><br /></td>\n</tr>\n</table>\n";
	if (isset($_GET['status']) && $_GET['status'] == "error1") echo "<table width='100%' align='center'>\n<tr>\n<td align='center'><b>".$locale['sfgift511']."</b><br /><br /></td>\n</tr>\n</table>\n";
	echo "<table align='center' cellpadding='0' cellspacing='1' width='100%' class='tbl-border'>\n<tr>\n";
	echo "<td colspan='4' class='tbl1'>\n";
	$result = dbquery("SELECT * FROM ".DB_GIFT_GIVEN." WHERE gift_given_to='".$_GET['lookup']."' AND gift_given_visibillity<='$access' ORDER BY gift_given_id");
	$rows = dbrows($result);
	if ($rows != 0) {
		$counter = 0; $columns = 4;
		$align = $gift_images ? "center" : "left";
		echo "<table cellpadding='0' cellspacing='0' width='100%'>\n<tr>\n";
		while ($data = dbarray($result)) {
		
			$gift = dbarray(dbquery("SELECT * FROM ".DB_GIFT." WHERE gift_id='".$data['gift_given_gift_id']."'"));
			
			$user = dbarray(dbquery("SELECT * FROM ".DB_USERS." WHERE user_id='".$data['gift_given_from']."'"));
			
			if ($counter != 0 && ($counter % $columns == 0)) echo "</tr>\n<tr>\n";
			echo "<td align='$align' width='25%' class='tbl'>\n";
			echo "<a href='".INFUSIONS."sf_gift_system/show_gift.php?gift_id=".$data['gift_given_id']."'>\n";
			echo "<img src='".INFUSIONS."sf_gift_system/images/".$gift['gift_image']."' alt='".$gift['gift_image']."' style='border:0px;'>\n";
			echo "</a><br>\n";
				if (($data['gift_given_visibillity'] == '1') && ($_GET['lookup'] != $userdata['user_id'])) {
					echo "Anonymous\n";
				} else {
					echo "<a href='".BASEDIR."profile.php?lookup=".$user['user_id']."'>".$user['user_name']."</a>\n";
				}
			if ($_GET['lookup'] == $userdata['user_id']) {
				echo " - <a href='".FUSION_SELF."?lookup=".$_GET['lookup']."&amp;step=delete&amp;gift_id=".$data['gift_given_id']."'>Delete</a>\n";
			}
			echo "</td>\n";
			$counter++;
		}
		echo "</tr>\n</table>\n";
	} else {
		echo "<center><br>\n".$locale['sfgift501']."<br><br>\n</center>\n";
	}
	echo "</td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td colspan='4' align='right' class='tbl1'><a href='".BASEDIR."profile.php?lookup=".$_GET['lookup']."'>".$locale['sfgift502']."</a></td>\n";
	echo "</tr>\n</table>\n";
	closetable();
} else {
	redirect(BASEDIR."index.php");
}

require_once(GIFT_SYSTEM."footer.php");

require_once THEMES."templates/footer.php";
?>