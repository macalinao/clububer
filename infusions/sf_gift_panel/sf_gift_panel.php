<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: infusion.php
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
if (!defined("IN_FUSION")) { die("Access Denied"); }

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."sf_gift_system/locale/".LOCALESET."/sf_gift_panel.php")) {
	// Load the locale file matching the current site locale setting.
	include INFUSIONS."sf_gift_system/locale/".LOCALESET."/sf_gift_panel.php";
} else {
	// Load the infusion's default locale file.
	include INFUSIONS."sf_gift_system/locale/English/sf_gift_panel.php";
}

require_once INFUSIONS."sf_gift_system/includes/infusion_db.php";

openside($locale['sfgift600']);
$result = dbquery("SELECT * FROM ".DB_GIFT." ORDER BY gift_id DESC LIMIT 1");
if (dbrows($result)) {
	while ($data = dbarray($result)) {
		echo "<table width='100%'>\n<tr>\n";
		echo "<td>".$locale['sfgift601']." <span class='small'>(".$data['gift_price']." ".$locale['sfgift602'].")</span></td>\n";
		echo "</tr>\n<tr>\n";
		echo "<td>\n";
		echo "<a href='".INFUSIONS."sf_gift_system/give_gift.php?gift_id=".$data['gift_id']."'>\n";
		echo "<img src='".INFUSIONS."sf_gift_system/images/".$data['gift_image']."'align='left' border='0' alt='' />\n";
		echo "</a>\n";
		echo "<span class='small'>".$locale['sfgift603']."<br />".$locale['sfgift604']."<br />".$locale['sfgift605']."<br />".($data['gift_stock']-$data['gift_bought'])."</span>\n";
		echo "</td>\n</tr>\n";
		if (iMEMBER) {
			echo "<tr>\n";
			echo "<td><a href='".INFUSIONS."sf_gift_system/give_gift.php?gift_id=".$data['gift_id']."'>".$locale['sfgift606']."</a> \n";
			echo "| <a href='".INFUSIONS."sf_gift_system/brows_gifts.php'>".$locale['sfgift607']."</a></td>\n";
			echo "</tr>\n";
		}
		echo "</table>\n";
	}
} else {
	echo $locale['sfgift608'];
}
closeside();
?>