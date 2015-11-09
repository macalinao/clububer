<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| UG Lottery Panel
| Copyright © 2007 - 2008 Stephan Hansson (StarglowOne)
| http://www.starglowone.com/
+--------------------------------------------------------+
| Filename: del_drawings.php
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
require_once "../../../maincore.php";
require_once THEMES."templates/admin_header.php";

include INFUSIONS."ug_lottery_panel/infusion_db.php";

if (!checkrights("UGLY") || !defined("iAUTH") || $_GET['aid'] != iAUTH) { redirect("../index.php"); }

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."ug_lottery_panel/locale/".$settings['locale'].".php")) {
	// Load the locale file matching the current site locale setting.
	include INFUSIONS."ug_lottery_panel/locale/".$settings['locale'].".php";
} else {
	// Load the infusion's default locale file.
	include INFUSIONS."ug_lottery_panel/locale/English.php";
}
if (isset($_POST['prune_draws']) && $_POST['prune_draws'] == '0') {
	$prune_days = stripinput($_POST['prune_days']);
	opentable($locale['ugly_914']);
	$expired = time() - (86400 * $prune_days);
	// Check number of posts & threads older than expired date and delete them
	$result = dbquery("DELETE FROM ".DB_UG_LOTTERY_DRAWINGS." WHERE endtime < $expired");
	echo $locale['ugly_928'].$delposts;
	closetable();
}

$draws = "SELECT * FROM ".DB_UG_LOTTERY_DRAWINGS." order by draw_id DESC";
$drawings = dbquery($draws);
$count = dbrows($drawings);
opentable($locale['ugly_900']);
echo "<br /><div align='center' class='tbl2'><a href='".INFUSIONS."ug_lottery_panel/admin/index.php".$aidlink."'><b>".$locale['ugly_901']."</b></a> | <a href='".INFUSIONS."ug_lottery_panel/admin/index.php".$aidlink."&amp;op=del_draw'><b>".$locale['ugly_914']."</b></a>";
echo "</div><br />";
echo "<div align='center' style='font-weight: bold;'>".$locale['ugly_915']."</div><br />";
echo "<div align='center'>\n";
echo "<table width='100%' border='0' cellpadding='3' cellspacing='1'><tr>\n";
echo "<td class='tbl2' style='font-weight: bold;'>".$locale['ugly_916']."</td>\n";
echo "<td class='tbl2' style='font-weight: bold;'>".$locale['ugly_902']."</td>\n";
echo "<td class='tbl2' style='font-weight: bold;'>".$locale['ugly_903']."</td>\n";
echo "<td class='tbl2' style='font-weight: bold;'>".$locale['ugly_904']."</td>\n";
echo "<td class='tbl2' style='font-weight: bold;'>".$locale['ugly_917']."</td>\n";
echo "<td class='tbl2' style='font-weight: bold;'>".$locale['ugly_918']."</td>\n";
echo "<td class='tbl2' style='text-align: center; font-weight: bold;'>".$locale['ugly_919']."</td>\n";
echo "</tr>\n";
while($rows = dbarray($drawings)) {
	echo "<tr>\n";
	echo "<td>".$rows['draw_id']."</td>\n";
	echo "<td>".$rows['lots']."</td>\n";
	echo "<td>".$rows['lot_price']."</td>\n";
	echo "<td>".$rows['prize']."</td>\n";
	echo "<td>\n";
		if ($rows['prize_winner_name'] == "") {
			echo $locale['ugly_920'];
		} else {
			echo goldmod_user($rows['prize_winner_id'], $rows['prize_winner_name']);
		}
	echo "</td>\n";
	echo "<td>".ucwords(showdate("longdate", $rows['endtime']))."</td>\n";
	echo "<td style='text-align: center;'>\n";
		if ($rows['ended'] == "0") {
			echo "<img src='".INFUSIONS."ug_lottery_panel/images/active.png' title='".$locale['ugly_921']."' alt='".$locale['ugly_921']."' />\n";
		} else {
			echo "<img src='".INFUSIONS."ug_lottery_panel/images/ended.png' title='".$locale['ugly_922']."' alt='".$locale['ugly_922']."' />\n";
		}
	echo "</td></tr>\n";
}
echo "</table></div><hr />\n";
echo "<br /><div align='center' style='font-weight: bold;'>".$locale['ugly_923']."</div><br />";
echo "<form name='settingsform' method='post' action='".FUSION_SELF.$aidlink."&amp;prune_draws=0'>\n";
echo "<table align='center' cellpadding='0' cellspacing='0' width='500'><tr>\n";
echo "<td style='width: 50%;' class='tbl'>\n";
echo "<span class='small2'><font style='color: red;'>".$locale['ugly_924']."</font> ".$locale['ugly_925']."</span></td>\n";
echo "<td style='width: 50%;' class='tbl'><input type='submit' name='prune' value='".$locale['ugly_926']."' class='button' />\n";
echo "<select name='prune_days' class='textbox' style='width: 50px;'>\n";
echo "<option>2</option>\n";
echo "<option>10</option>\n";
echo "<option>20</option>\n";
echo "<option>30</option>\n";
echo "<option>60</option>\n";
echo "<option>90</option>\n";
echo "<option>120</option>\n";
echo "<option selected='selected'>180</option>\n";
echo "</select>".$locale['ugly_927'];
echo "</td></tr></table></form>\n";
closetable();
//Start Copywrite Link removal is NOT ALLOWED.
	echo "<div align='center' class='small'>".$locale['ugly_title']." ".$locale['ugly_version']." &copy; 2008 <a href='http://www.starglowone.com'>Stars Heaven</a></div>\n";
//END Copywrite Link removal is NOT ALLOWED.
require_once THEMES."templates/footer.php";
?>