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
| Filename: configurations.php
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

if (file_exists(GOLD_LANG.LOCALESET."admin/configuration.php")) {
	include GOLD_LANG.LOCALESET."admin/configuration.php";
} else {
	include GOLD_LANG."English/admin/configuration.php";
}

if (!isset($_GET['rowstart']) || !isNum($_GET['rowstart'])) { $rowstart = 0; } else { $rowstart = $_GET['rowstart']; }

opentable($locale['urg_a_config_103'],'');
echo "<table width='100%' cellpadding='0' cellspacing='5' border='0'>\n<tr align='center'>\n";
echo "<td><a href='".FUSION_SELF.$aidlink."&amp;op=config&amp;pre=ALL'><img src='icons/conf_all.png' alt='".$locale["urg_a_config_113"]."' title='".$locale["urg_a_config_113"]."' border='0' /><br />".$locale["urg_a_config_113"]."</a></td>\n";
echo "<td><a href='".FUSION_SELF.$aidlink."&amp;op=config&amp;pre=UGLD_'><img src='icons/conf_core.png' alt='".$locale["urg_a_config_114"]."' title='".$locale["urg_a_config_114"]."' border='0' /><br />".$locale["urg_a_config_114"]."</a></td>\n";
echo "<td><a href='".FUSION_SELF.$aidlink."&amp;op=config&amp;pre=GLD_'><img src='icons/conf_shop.png' alt='".$locale["urg_a_config_115"]."' title='".$locale["urg_a_config_115"]."' border='0' /><br />".$locale["urg_a_config_115"]."</a></td>\n";
echo "<td><a href='".FUSION_SELF.$aidlink."&amp;op=config&amp;pre=UGLY_'><img src='icons/conf_ug_lottery.png' alt='".$locale["urg_a_config_116"]."' title='".$locale["urg_a_config_116"]."' border='0' /><br />".$locale["urg_a_config_116"]."</a></td>\n";
echo "</tr>\n<tr align='center'>\n";
echo "<td><a href='".FUSION_SELF.$aidlink."&amp;op=config&amp;pre=UGWG_'><img src='icons/conf_ug_word_games.png' alt='".$locale["urg_a_config_117"]."' title='".$locale["urg_a_config_117"]."' border='0' /><br />".$locale["urg_a_config_117"]."</a></td>\n";
echo "<td><a href='".FUSION_SELF.$aidlink."&amp;op=config&amp;pre=UGCAS_'><img src='icons/conf_ug_casino.png' alt='".$locale["urg_a_config_118"]."' title='".$locale["urg_a_config_118"]."' border='0' /><br />".$locale["urg_a_config_118"]."</a></td>\n";
echo "<td><a href='".FUSION_SELF.$aidlink."&amp;op=config&amp;pre=UGPWR_'><img src='icons/conf_ug_prizewinner.png' alt='".$locale["urg_a_config_119"]."' title='".$locale["urg_a_config_119"]."' border='0' /><br />".$locale["urg_a_config_119"]."</a></td>\n";
echo "<td><a href='".FUSION_SELF.$aidlink."&amp;op=config&amp;pre=UGPALS_'><img src='icons/conf_ug_pals.png' alt='".$locale["urg_a_config_120"]."' title='".$locale["urg_a_config_120"]."' border='0' /><br />".$locale["urg_a_config_120"]."</a></td>\n";
echo "</tr>\n<tr align='center'>\n";
echo "<td><a href='".FUSION_SELF.$aidlink."&amp;op=config&amp;pre=UGSCR_'><img src='icons/conf_ug_scratch_card.png' alt='".$locale["urg_a_config_121"]."' title='".$locale["urg_a_config_121"]."' border='0' /><br />".$locale["urg_a_config_121"]."</a></td>\n";
echo "<td><a href='".FUSION_SELF.$aidlink."&amp;op=config&amp;pre=UGDICE_'><img src='icons/conf_ug_dice.png' alt='".$locale["urg_a_config_122"]."' title='".$locale["urg_a_config_122"]."' border='0' /><br />".$locale["urg_a_config_122"]."</a></td>\n";
echo "<td><a href='".FUSION_SELF.$aidlink."&amp;op=config&amp;pre=UGBRE_'><img src='icons/conf_ug_barren_realms.png' alt='".$locale["urg_a_config_123"]."' title='".$locale["urg_a_config_123"]."' border='0' /><br />".$locale["urg_a_config_123"]."</a></td>\n";
echo "<td><a href='".FUSION_SELF.$aidlink."&amp;op=config&amp;pre=UGRAN_'><img src='icons/conf_ug_random_quote.png' alt='".$locale["urg_a_config_124"]."' title='".$locale["urg_a_config_124"]."' border='0' /><br />".$locale["urg_a_config_124"]."</a></td>\n";
echo "</tr>\n<tr align='center'>\n";
echo "<td><a href='".FUSION_SELF.$aidlink."&amp;op=config&amp;pre=UGDND_'><img src='icons/conf_ug_dealer.png' alt='".$locale["urg_a_config_125"]."' title='".$locale["urg_a_config_125"]."' border='0' /><br />".$locale["urg_a_config_125"]."</a></td>\n";
echo "<td><a href='".FUSION_SELF.$aidlink."&amp;op=config&amp;pre=UGTH_'><img src='icons/conf_ug_treasure_hunt.png' alt='".$locale["urg_a_config_126"]."' title='".$locale["urg_a_config_126"]."' border='0' /><br />".$locale["urg_a_config_126"]."</a></td>\n";
echo "<td><a href='".FUSION_SELF.$aidlink."&amp;op=config&amp;pre=UGAM_'><img src='icons/conf_ug_avatarmaker.png' alt='".$locale["urg_a_config_127"]."' title='".$locale["urg_a_config_127"]."' border='0' /><br />".$locale["urg_a_config_127"]."</a></td>\n";
echo "<td><a href='".FUSION_SELF.$aidlink."&amp;op=config&amp;pre='><img src='icons/conf_default.png' alt='".$locale["urg_a_config_187"]."' title='".$locale["urg_a_config_187"]."' border='0' /><br />".$locale["urg_a_config_187"]."</a></td>\n";
echo "</tr>\n</table>\n";
closetable();

$query1 = dbquery("SELECT name, value FROM ".DB_UG3_SETTINGS." ORDER BY name DESC");
if (isset($_POST['save_cat'])) {
	$valuechecked = stripinput($_POST['value']);
	$name = stripinput($_GET['name']);
	$result = dbquery("UPDATE ".DB_UG3_SETTINGS." SET value = '$valuechecked'  WHERE name = '$name' LIMIT 1 ;");
	redirect(FUSION_SELF.$aidlink."&amp;op=config&amp;pre=".$_REQUEST['pre']."");
}

if (isset($_GET['step']) && $_GET['step'] == "edit") {
	$result = dbquery("SELECT name, value, description FROM ".DB_UG3_SETTINGS." WHERE name = '".$_GET['name']."'");
	$data = dbarray($result);
	$formaction = FUSION_SELF.$aidlink."&amp;op=config&amp;pre=".$_REQUEST['pre']."&amp;name=".$data['name'];
	opentable($locale['urg_a_config_104']);
	echo "<form id='addcat' name='addcat' method='post' action='".$formaction."'>\n";
	echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>\n<tr>\n";
	echo "<td colspan='2' class='tbl2'>".$locale['urg_a_config_105']."</td>\n";
	echo "<td class='tbl2'>".$locale['urg_a_config_106']."</td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td><strong>".$locale['urg_a_config_107']."</strong></td>\n";
	echo "<td>".$data['name']."</td>\n";
	echo "<td>".$data['description']."</td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td><strong>".$locale['urg_a_config_108']."</strong></td>\n";
	echo "<td><input type='text' name='value' value='".$data['value']."' class='textbox' style='width: 200px;' /></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td style='text-align: center;' colspan='3'><input type='submit' name='save_cat' value='".$locale['urg_a_config_109']."' class='button' /></td>\n";
	echo "</tr>\n</table>\n";
	echo "</form>\n";
	closetable();
} else {
}

opentable($locale['urg_a_config_111']);
	echo "<div align='center'><strong>".$locale['urg_a_config_110']."</strong></div>\n";

echo "<table align='center' width='90%' cellspacing='0' cellpadding='0' class='tbl'>\n";

if(empty($_REQUEST['pre'])  || $_REQUEST['pre']=='ALL' || !$_REQUEST['pre']) {
	$where = '';
	$and = '';
} else {
	$where = " WHERE `name` LIKE '".$_REQUEST['pre']."%'";
	$and = "`name` LIKE '".$_REQUEST['pre']."%'"; 
}

$sql = "SELECT * FROM `".DB_UG3_SETTINGS."`$where ORDER BY name LIMIT $rowstart,20";
$result = dbquery($sql);
if (dbrows($result) != 0) {
	echo "<tr>\n";
	echo "<td class='tbl2' width='40%'><strong>".$locale['urg_a_config_180']."</strong></td>\n";
	echo "<td class='tbl2'><strong>".$locale['urg_a_config_181']."</strong></td>\n";
	echo "<td class='tbl2' align='right' width='60px'><strong>".$locale['urg_a_config_182']."</strong></td>\n";
	echo "</tr>\n";
	$i=0;//color	
	while ($data = dbarray($result)) {
		if ($data['description'] != '') {
			$help = $data['description'];
		} else {
			$help = $locale['urg_a_config_183'];
		}
		if ($i % 2 == 0) { $row_color = "tbl1";	} else { $row_color = "tbl2"; }		
		echo "<tr class='".$row_color."'>\n";
		echo "<td>".$data['name']."</td>\n";
		echo "<td>".$data['value']."</td>\n";
		echo "<td align='right' valign='top'>\n";
		//echo "<img src='".INFUSIONS."user_gold/images/help.png'  style='border: 0; cursor:help;' title='".$help."' alt='".$help."' />\n";
		ug_adminhelp($data['name'],$data['name'], '400', '100');
		echo "&nbsp;&nbsp;\n";
		echo "<a href='".FUSION_SELF.$aidlink."&amp;op=config&amp;pre=".$_REQUEST['pre']."&amp;step=edit&amp;name=".$data['name']."'>\n";
		echo "<img src='../images/edit.png' alt='".$locale['urg_a_config_185']."' title='".$locale['urg_a_config_185']."' style='border: 0;' /></a>\n";
		echo "</td>\n";
		echo "</tr>\n<tr>\n";
		echo "<td colspan='3'><hr /></td>\n";
		echo "</tr>\n";
		$i++;
	}
	echo "</table>\n";
	$total_rows = dbcount("(*)", DB_UG3_SETTINGS, $and);
	if ($total_rows > 20) echo "<div align='center' style='margin-top:5px;'>\n".makePageNav($rowstart,20,$total_rows,3,FUSION_SELF.$aidlink."&amp;op=config&amp;pre=".$_REQUEST['pre']."&amp;")."\n</div>\n";
} else {
	echo "<tr><td align='center'>".$locale['urg_a_config_186']."</td></tr></table>\n";
}
closetable();

?>