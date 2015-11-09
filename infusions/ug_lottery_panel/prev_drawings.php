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
| Filename: prev_drawings.php
| Author: StarglowOne
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

include INFUSIONS."ug_lottery_panel/infusion_db.php";

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."ug_lottery_panel/locale/".$settings['locale'].".php")) {
	// Load the locale file matching the current site locale setting.
	include INFUSIONS."ug_lottery_panel/locale/".$settings['locale'].".php";
} else {
	// Load the infusion's default locale file.
	include INFUSIONS."ug_lottery_panel/locale/English.php";
}

opentable($locale['ugly_100'].": ".$locale['ugly_214']);
//choose the correct banner depening on language settings
echo "<div align='center'>\n";
if (file_exists("images/banners/".$settings['locale']."_ug_lottery.jpg")) {
	echo "<img src='images/banners/".$settings['locale']."_ug_lottery.jpg' title='".$locale['ugly_100']."' alt='".$locale['ugly_100']."' />\n";
} else {
	echo "<img src='images/banners/English_ug_lottery.jpg' title='".$locale['ugly_100']."' alt='".$locale['ugly_100']."' />\n";
}
echo "</div><br /><br />\n";
echo "<div align='center' class='tbl2'><strong>\n";
echo "<a href='index.php'>".$locale['ugly_200']."</a> | \n";
echo "<a href='prev_drawings.php'>".$locale['ugly_201']."</a>\n";
if(iADMIN){
	echo " | <a href='admin/index.php".$aidlink."'>".$locale['ugly_202']."</a>\n";
}
echo "</strong></div><br />\n";
echo "<table align='center' width='100%' cellspacing='0' cellpadding='2' class='tbl-border'>\n";
echo "<tr class='tbl1'><td colspan='3' style='text-align: center;'></td></tr>\n";
$rows = dbcount("(draw_id)", DB_UG_LOTTERY_DRAWINGS);
if (!isset($_GET['rowstart']) || !isnum($_GET['rowstart'])) $_GET['rowstart'] = 0;
if ($rows != 0) {
	$i = 0;
	$result = dbquery("SELECT * FROM ".DB_UG_LOTTERY_DRAWINGS." WHERE ended='1' order by draw_id DESC LIMIT ".$_GET['rowstart'].",20");
	echo "<tr>\n";
	echo "<td class='tbl2'><strong>".$locale['ugly_215']."</strong></td>\n";
	echo "<td class='tbl2'><strong>".$locale['ugly_216']."</strong></td>\n";
	echo "<td class='tbl2'><strong>".$locale['ugly_217']."</strong></td>\n";
	echo "</tr>\n";
	$c = 0;//color
	while ($prev_data = dbarray($result)) {
		if ($c % 2 == 0) { $row_color = 'tbl1'; } else { $row_color = 'tbl2'; }
		echo "<tr class='".$row_color."'>\n";
		echo "<td>".goldmod_user($prev_data['prize_winner_id'], $prev_data['prize_winner_name'])."</td>\n";
		echo "<td>".$prev_data['prize']."</td>\n";
		echo "<td>".ucwords(showdate("longdate", $prev_data['endtime']))."</td>\n";
		echo "</tr>\n";
		$c++;
	}
	$i++;
} else {
	echo "<tr><td style='text-align: center;' class='tbl'>".$locale['ugly_218']."</td></tr>\n";
}
echo "</table>\n";
echo "<div align='center' style='margin-top: 5px;'>\n".makePageNav($_GET['rowstart'],20,$rows,3,FUSION_SELF."?op=prev_drawings&amp;")."\n</div>\n";

closetable();
//Start Copywrite Link removal is NOT ALLOWED.
	echo "<div align='center' class='small'>".$locale['ugly_title']." ".$locale['ugly_version']." &copy; 2008 <a href='http://www.starglowone.com'>Stars Heaven</a></div>\n";
//END Copywrite Link removal is NOT ALLOWED.
require_once THEMES."templates/footer.php";
?>