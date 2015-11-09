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
| Filename: index.php
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
include INFUSIONS."ug_lottery_panel/inc/version_checker/version_checker.php";

if (!checkrights("UGLY") || !defined("iAUTH") || $_GET['aid'] != iAUTH) { redirect("../index.php"); }

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."ug_lottery_panel/locale/".$settings['locale'].".php")) {
	// Load the locale file matching the current site locale setting.
	include INFUSIONS."ug_lottery_panel/locale/".$settings['locale'].".php";
} else {
	// Load the infusion's default locale file.
	include INFUSIONS."ug_lottery_panel/locale/English.php";
}

if (isset($_POST['addlot_final']) && $_POST['addlot_final'] == '0') {
	global $locale, $aidlink;
	$lots = stripinput($_POST['lots']);
	$lot_price = stripinput($_POST['lot_price']);
	$prize = stripinput($_POST['prize']);
	$endtime = $_POST['endtime'];
	$end_time = time() + $endtime;
	$jtype = stripinput($_POST['jtype']);
	$result = dbquery("INSERT INTO ".DB_UG_LOTTERY_DRAWINGS." (draw_id, lots, lot_price, prize, endtime, ended, prize_winner_name, prize_winner_id, lot_amnt, jtype) VALUES('', '".$lots."', '".$lot_price."', '".$prize."', '".$end_time."', '0', '', '', '".$lots."', '".$jtype."')");
	
	opentable($locale['ugly_930']);
	echo "<div align='center'><b>".$locale['ugly_930']."</b></div>\n";
	//pagerefresh('meta','2',FUSION_SELF.$aidlink);
	closetable();
}

opentable($locale['ugly_900']);
echo "<br /><div align='center' class='tbl2'><a href='".FUSION_SELF.$aidlink."'><b>".$locale['ugly_901']."</b></a> | <a href='del_drawings.php".$aidlink."'><b>".$locale['ugly_914']."</b></a>";
echo "</div><br />";
echo "<div align='center' style='font-weight: bold;'>".$locale['ugly_901']."</div><br />";
echo "<div align='center'><form action='".FUSION_SELF.$aidlink."' method='post'>";
echo "<input type='hidden' name='addlot_final' value='0' />";
echo "<table><tr><td>";
echo $locale['ugly_902'].":</td><td><input type='text' name='lots' class='textbox' />";
echo "</td></tr>";
echo "<tr><td>";
echo $locale['ugly_903'].":</td><td><input type='text' name='lot_price' class='textbox' />";
echo "</td></tr>";
echo "<tr><td>";
echo $locale['ugly_904'].":</td><td><input type='text' name='prize' class='textbox' />";
echo "</td></tr>";
echo "<tr><td>";
echo $locale['ugly_905'].":</td><td>";
echo "<select name='jtype' class='textbox'>";
echo "<option value='cash' selected='selected'>".UGLD_GOLDTEXT."</option>";
echo "<option value='karma'>".$locale['ugly_906']."</option>";
echo "<option value='chips'>".$locale['ugly_907']."</option>";
echo "<option value='ribbon'>".$locale['ugly_908']."</option>";
echo "</select></td></tr>";
echo "<tr><td>";
echo $locale['ugly_909']."</td><td>";
echo "<select name='endtime' class='textbox'>";
echo "<option value='60'>1 ".$locale['ugly_910']."</option>";
echo "<option value='1800'>30 ".$locale['ugly_910']."</option>";
echo "<option value='3600'>1 ".$locale['ugly_911']."</option>";
echo "<option value='21600'>6 ".$locale['ugly_911']."</option>";
echo "<option value='43200'>12 ".$locale['ugly_911']."</option>";
echo "<option value='86400'>1 ".$locale['ugly_912']."</option>";
echo "<option value='129600'>36 ".$locale['ugly_911']."</option>";
echo "<option value='172800'>2 ".$locale['ugly_912']."</option>";
echo "<option value='604800'>7 ".$locale['ugly_912']."</option>";
echo "<option value='2419200'>28 ".$locale['ugly_912']."</option>";
echo "</select></td></tr></table>";
echo " <br /><input type='submit' name='add' value='".$locale['ugly_913']."' class='button' /></form></div>";
closetable();
//Start Copywrite Link removal is NOT ALLOWED.
	echo "<div align='center' class='small'>".$locale['ugly_title']." ".$locale['ugly_version']." &copy; 2008 <a href='http://www.starglowone.com'>Stars Heaven</a>\n";
	echo "<br />\n";
	echo checkversion($locale['ugly_version']);
	echo "</div>\n";
//END Copywrite Link removal is NOT ALLOWED.
require_once THEMES."templates/footer.php";
?>