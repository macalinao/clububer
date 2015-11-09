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
| Filename: panels.inc.php
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

if (file_exists(GOLD_LANG.LOCALESET."panels.php")) {
	include_once GOLD_LANG.LOCALESET."panels.php";
} else {
	include_once GOLD_LANG."English/panels.php";
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
/*function panel_gold_user_info($user_id) { //Users table . gives current totals
global $locale, $golddata;
	$image = "<img src='".THEME."images/bullet.gif' alt='*' />&nbsp;";
	echo "<hr /><div align='center'><a href='".INFUSIONS."user_gold/'><strong>".$locale['urg_panels_100']."</strong></a></div><br />";
	echo "<img src='".GOLD_IMAGE."cash.png' title='".$locale['urg_panels_118']."' alt='".$locale['urg_panels_118']."' />&nbsp;".$locale['urg_panels_101'].formatMoney($golddata['cash'])."<br />";
	echo "<img src='".GOLD_IMAGE."bank.png' title='".$locale['urg_panels_119']."' alt='".$locale['urg_panels_119']."' />&nbsp;".$locale['urg_panels_102'].formatMoney($golddata['bank'])."<br />";
	echo "<img src='".GOLD_IMAGE."karma.png' title='".$locale['urg_panels_120']."' alt='".$locale['urg_panels_120']."' />&nbsp;".$locale['urg_panels_103'].$golddata['karma']."<br />";
	echo "<img src='".GOLD_IMAGE."chips.png' title='".$locale['urg_panels_121']."' alt='".$locale['urg_panels_121']."' />&nbsp;".$locale['urg_panels_104'].$golddata['chips']."<br /><hr />";
	echo "<div align='center'>".$locale['urg_panels_105']."<br />".showribbons($golddata['owner_id'], false)."</div><br />";
}*/

function panel_gold_user_info($user_id) { //Users table . gives current totals
global $locale, $golddata;
	$image = "<img src='".THEME."images/bullet.gif' alt='*' />&nbsp;";
	echo "<hr /><div align='center'><a href='".INFUSIONS."user_gold/'><strong>".$locale['urg_panels_100']."</strong></a></div><br />";
	echo "<img src='".GOLD_IMAGE."cash.png' title='".$locale['urg_panels_118']."' alt='".$locale['urg_panels_118']."' />&nbsp;".formatMoney($golddata['cash'])."<br />";
	echo "<img src='".GOLD_IMAGE."bank.png' title='".$locale['urg_panels_119']."' alt='".$locale['urg_panels_119']."' />&nbsp;".formatMoney($golddata['bank'])."<br />";
	echo "<img src='".GOLD_IMAGE."karma.png' title='".$locale['urg_panels_120']."' alt='".$locale['urg_panels_120']."' />&nbsp;".$golddata['karma']."<br />";
	echo "<img src='".GOLD_IMAGE."chips.png' title='".$locale['urg_panels_121']."' alt='".$locale['urg_panels_121']."' />&nbsp;".$golddata['chips']."<br /><hr />";
	echo "<div align='center'>".$locale['urg_panels_105']."<br />".showribbons($golddata['owner_id'], false)."</div><br />";
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function panel_topten_cash() { //Top ten . gives top ten cash members
	$topcashq = dbquery(
		"SELECT g.owner_id, g.cash, u.user_name as owner_name
		FROM ".DB_UG3." g
		LEFT JOIN ".DB_USERS." u ON g.owner_id = u.user_id
		ORDER BY g.cash DESC, owner_name ASC
		LIMIT 10"
	);
	$content = "";
	while ($topcash = dbarray($topcashq)) {
		$content .= goldmod_user($topcash['owner_id'], $topcash['owner_name'])." - ".formatMoney($topcash['cash'])."<br />";
	}
	return $content;
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function panel_topten_bank() { //Top ten . gives top ten bank members
	$topbankq = dbquery(
		"SELECT g.owner_id, g.bank, u.user_name as owner_name
		FROM ".DB_UG3." g
		LEFT JOIN ".DB_USERS." u ON g.owner_id = u.user_id
		ORDER BY g.bank DESC, owner_name ASC
		LIMIT 10"
	);
	$content = "";
	while ($topbank = dbarray($topbankq)) {
		$content .= goldmod_user($topbank['owner_id'], $topbank['owner_name'])." - ".formatMoney($topbank['bank'])."<br />";
	}
	return $content;
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function panel_topten_karma() { //Top ten . gives top ten karma members
	$result = dbquery(
		"SELECT g.owner_id, g.karma, u.user_name as owner_name
		FROM ".DB_UG3." g
		LEFT JOIN ".DB_USERS." u ON g.owner_id = u.user_id
		ORDER BY g.karma DESC, owner_name ASC
		LIMIT 10"
	);
	$content = "";
	while ($row = dbarray($result)) {
		$content .= goldmod_user($row['owner_id'], $row['owner_name'])." - ".$row['karma']."<br />";
	}
	return $content;
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function panel_topten_chips() { //Top ten . gives top ten chips members
	$result = dbquery(
		"SELECT g.owner_id, g.chips, u.user_name as owner_name
		FROM ".DB_UG3." g
		LEFT JOIN ".DB_USERS." u ON g.owner_id = u.user_id
		ORDER BY g.chips DESC, owner_name ASC
		LIMIT 10"
	);
	$content = "";
	while ($row = dbarray($result)) {
		$content .= goldmod_user($row['owner_id'], $row['owner_name'])." - ".$row['chips']."<br />";
	}
	return $content;
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function panel_tenmostwanted() { //Top ten . gives top ten karma members
	$result = dbquery("SELECT owner_id, owner_name, karma FROM ".DB_UG3." ORDER BY karma ASC, owner_name LIMIT 10");
	$content = "";
	while ($row = dbarray($result)) {
		$content .= goldmod_user($row['owner_id'], $row['owner_name'])." - ".$row['karma']."<br />";
	}
	return $content;
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function panel_itemdisplay() {
global $locale;
	$content = "<table border='0' cellspacing='5' cellpadding='0' width='100%'>";
	$content .= "<tr>";
	$content .= "<td style='width: 100%;'>";
	$content .= "<table width='100%' cellspacing='2' cellpadding='2' border='0'>";
	$content .= "<tr class='tbl2'>";
	$content .= "<td align='center' width='55%'><strong>".$locale['urg_panels_106']."</strong></td>";
	$content .= "<td align='center' width='55%'><strong>".$locale['urg_panels_107']."</strong></td>";
	$content .= "<td align='center' width='20%'><strong>".$locale['urg_panels_108']."</strong></td>";
	$content .= "</tr>";
	$content .= "</table>";
	$content .= "</td>";
	$content .= "<tr>";
	$content .= "<td width='100%'>";
	$result = dbquery ("SELECT image, description, cost FROM ".DB_UG3_USAGE." WHERE active = '1' AND purchase = '1'");
	if (dbrows($result))	{
		$i = 0;//reset rows
		while ($itm_data = dbarray($result)) {
			if ($i % 2 == 0) { $class='tbl1'; } else { $class='tbl2'; }
			$content .= "<table width='100%' cellspacing='2' cellpadding='2' border='0'>";
			$content .= "<tr class='".$class."'>";
			$content .= "<td align='center' width='25%'><img src='images/item_images/".$itm_data['image']."' style='border: 0;' alt='".$itm_data['image']."' title='".$itm_data['image']."' /></td>";
			$content .= "<td width='55%'>".$itm_data['description']."</td>";
			$content .= "<td align='center' width='20%'>".display_current('gold', $itm_data['cost'])."</td>";
			$content .= "</tr>";

			$content .= "</table>";
			$i++;
		}
	} else {
		$content .= $locale['urg_panels_109'];
	}
	$content .= "</td></tr></table>";
	return $content;
}
?>