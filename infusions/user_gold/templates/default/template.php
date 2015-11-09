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
| Filename: template.php
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
if (!defined("IN_FUSION")) { die("Access Denied"); }

function render_shop_intro() {
	global $aidlink, $locale, $settings, $golddata, $_REQUEST, $_POST, $_GET;
	redirect("index.php?op=shop_start");
}

function render_shop($field, $table, $conditions, $sortQuery, $sortDirQuery, $rowstart) {
	global $aidlink, $locale, $settings, $golddata, $_REQUEST, $_POST, $_GET;
	
	echo "<table width='100%'>\n<tr valign='top' class='tbl1'>\n";
	echo "<td><strong>".$locale['urg_shop_115']."</strong></td>\n";
	echo "<td><strong>".$locale['urg_shop_110']."</strong></td>\n";
	echo "<td style='width: 18%;'><strong>".$locale['urg_shop_116']."</strong></td>\n";
	echo "</tr>\n";
	
	$i = 0;
	$result = dbquery("SELECT $field FROM $table WHERE $conditions ORDER BY $sortQuery $sortDirQuery");
	$rows = dbrows($result);
	if ($rows != 0) {
		while ($row = dbarray($result)) {
			if ($i % 2 == 0) { $alternating = "tbl2"; } else { $alternating = "tbl1"; }
			echo "<tr  valign='top' class='".$alternating."'>\n";
			echo "<td><img border='0' width='".UGLD_IMAGE_WIDTH."' height='".UGLD_IMAGE_HEIGHT."' src='images/item_images/".$row['image']."' title='".$row['name']."' alt='".$row['name']."' border='0' /></td>\n";
			echo "<td>".$row['description']."</td>\n";
			echo "<td style='width: 18%;'>".$locale['urg_shop_109']." ".formatMoney($row['cost'])."<br />".$locale['urg_shop_117']." ".$row['stock']."<br />\n";
			if ($golddata['cash'] >= $row['cost']) {
				echo "<a href='index.php?op=shop_finalise&amp;id=".$row['id']."'>".$locale['urg_shop_119']."</a>\n";
			} elseif ($row['stock'] == 0) {
				echo "<strong>".$locale['urg_shop_120']."</strong>\n";
			} else {
				echo "<strong>".sprintf($locale['urg_shop_121']." %s", formatMoney($row['cost'] - $golddata['cash']))."</strong>\n";
			}
			echo "</td>\n";
			echo "</tr>\n";
			$i++;
		}
	} else {
		echo "<tr><td colspan='3'>".$locale['urg_shop_120']."</td></tr>\n";
	}	
	echo "</table>\n";
}
?>