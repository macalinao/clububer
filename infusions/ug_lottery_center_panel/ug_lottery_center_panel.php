<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| UG Lottery Center Panel
| Copyright © 2007 - 2008 Stephan Hansson (StarglowOne)
| http://www.starglowone.com/
+--------------------------------------------------------+
| Filename: ug_lottery_center_panel.php
| Author: Stephan Hansson (StarglowOne)
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

include INFUSIONS."ug_lottery_panel/infusion_db.php";

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."ug_lottery_panel/locale/".$settings['locale'].".php")) {
	// Load the locale file matching the current site locale setting.
	include INFUSIONS."ug_lottery_panel/locale/".$settings['locale'].".php";
} else {
	// Load the infusion's default locale file.
	include INFUSIONS."ug_lottery_panel/locale/English.php";
}

opentable($locale['ugly_title'].": ".$locale['ugly_203']);
$result = dbquery("SELECT * FROM ".DB_UG_LOTTERY_DRAWINGS." WHERE ended='1' ORDER BY draw_id DESC LIMIT 0,1");
$drawdata = dbarray($result);
$result2 = dbquery("SELECT * FROM ".DB_UG_LOTTERY_DRAWINGS." WHERE ended='0' ORDER BY draw_id DESC LIMIT 0,1");
$drawdata2 = dbarray($result2);
if (file_exists(INFUSIONS."ug_lottery_panel/images/banners/".$settings['locale']."_ug_lottery.jpg")) {
	echo "<div align='center'>\n";
	echo "<a href='".INFUSIONS."ug_lottery_panel/index.php'>\n";
	echo "<img src='".INFUSIONS."ug_lottery_panel/images/banners/".$settings['locale']."_ug_lottery.jpg' alt='".$locale['ugly_209']."' title='".$locale['ugly_209']."' style='border: 0px' />\n";
	echo "</a></div><br />\n";
} else {
	echo "<div align='center'>\n";
	echo "<a href='".INFUSIONS."ug_lottery_panel/index.php'>\n";
	echo "<img src='".INFUSIONS."ug_lottery_panel/images/banners/English_ug_lottery.jpg' alt='".$locale['ugly_209']."' title='".$locale['ugly_209']."' style='border: 0px' />\n";
	echo "</a></div><br />\n";
}
	echo "<div align='center' style='font-weight: bold;'>\n";

if($drawdata['endtime'] > time()) {
	echo sprintf($locale['ugly_204'], ucwords(showdate("longdate", $drawdata['endtime'])));
	echo "<br />\n";
	echo sprintf($locale['ugly_205'], $drawdata['lot_price'], UGLD_GOLDTEXT, $drawdata['prize'], $drawdata['jtype'], $drawdata['lots'], $drawdata['lot_amnt']);
	echo "<br />\n";
	echo THEME_BULLET."\n";
	echo "<a href='".INFUSIONS."ug_lottery_panel/index.php?op=prev_drawings'>".$locale['ugly_219'];
	echo "</a><br />\n";
} else {
	if(empty($drawdata)) {
		echo $locale['ugly_220']."<br />\n";
	} else {
		echo sprintf($locale['ugly_212'], ucwords(showdate("longdate", $drawdata['endtime'])));
		echo "<br />\n";
		if ($drawdata['prize_winner_name'] == $locale['ugly_920']) {
			$prize_winner_name = $locale['ugly_920'];
		} else {
			$prize_winner_name = goldmod_user($drawdata['prize_winner_id'], $drawdata['prize_winner_name']);
		}
		echo sprintf($locale['ugly_221'], $prize_winner_name, $drawdata['prize'], $drawdata['jtype']);
		echo "<br />\n";
	}
		if(empty($drawdata2)) {
			echo $locale['ugly_222']."<br />\n";
		} else {
			echo sprintf($locale['ugly_204'], ucwords(showdate("longdate", $drawdata2['endtime'])));
			echo "<br />\n";
			echo sprintf($locale['ugly_205'], $drawdata2['lot_price'], UGLD_GOLDTEXT, $drawdata2['prize'], $drawdata2['jtype'], $drawdata2['lots'], $drawdata2['lot_amnt']);
			echo "<br />\n";
			if(empty($drawdata)) {
			} else {
				echo THEME_BULLET."\n";
				echo "<a href='".INFUSIONS."ug_lottery_panel/index.php?op=prev_drawings'>".$locale['ugly_219']."</a>\n";
				echo "<br />\n";
			}
		}
}
	echo "</div>\n";
closetable();
?>