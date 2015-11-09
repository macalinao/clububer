<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright � 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| User Gold 3
| Copyright � 2007 - 2008 UG3 Developement Team
| http://www.starglowone.com/
+--------------------------------------------------------+
| Filename: index.php
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
include "header.php";

if (file_exists(GOLD_LANG.LOCALESET."index.php")) {
	include_once GOLD_LANG.LOCALESET."index.php";
} else {
	include_once GOLD_LANG."English/index.php";
}

if (!iMEMBER) { redirect(BASEDIR."index.php"); exit; }

define("GOLDOK" , TRUE);

//Start safty accountant
if(($golddata['cash'] + $golddata['bank'] <= UGLD_SELFDONATE_ALLOW) && $op != "donate_self_donate") {
	opentable($locale['urg_index_109']);
	echo "<p>".$locale['urg_index_110']."<br />".$locale['urg_index_111']."</p>\n";
	echo "<p>".$locale['urg_index_112']."<a href='".FUSION_SELF."?op=donate_self_donate'>".$locale['urg_index_113']."</a></p>\n";
	closetable();
	include "footer.php";
	exit;
}

if($golddata['cash'] > "0" && $golddata['bank'] < "0") {
	$owe = 0 - $golddata['bank'];
	$left = $golddata['cash'] - $owe;
	$pay = $golddata['bank'] + $owe;
	$fixsql = "UPDATE ".DB_UG3." SET bank = '".$pay."', cash = '".$left."' WHERE owner_id = '".$golddata['owner_id']."' LIMIT 1 ;";
	dbquery($fixsql);
	$subject = $locale['urg_index_114'];
	$message = sprintf($locale['urg_index_115'].$locale['urg_index_116'], UGLD_BANK_NAME);
	sendpm($golddata['owner_id'], $subject, $message, '0', $locale['urg_index_117']);
}

if($golddata['cash'] < "0" && $golddata['bank'] > "0") {
	$owe = 0 - $golddata['cash'];
	$left = $golddata['bank'] - $owe;
	$pay = $golddata['cash'] + $owe;
	$fixsql = "UPDATE ".DB_UG3." SET cash = '".$pay."', bank = '".$left."' WHERE owner_id = '".$golddata['owner_id']."' LIMIT 1 ;";
	dbquery($fixsql);
	$subject = $locale['urg_index_114'];
	$message = sprintf($locale['urg_index_115'].$locale['urg_index_116'], UGLD_BANK_NAME);
	sendpm($golddata['owner_id'], $subject, $message, '0', $locale['urg_index_117']);
}
//End safty accountant

function index() {
	global $HTTP_POST_VARS, $userdata, $locale, $settings, $golddata;
	table_top($locale['urg_index_100']);
		$rows = 2;
		if (UGLD_BANK_ENABLED) { $rows++; }
		if (UGLD_DISPLAY_USAGE_INDEX) { $rows++; }
		
		echo "<table width='100%' cellpadding='3' cellspacing='3' class='tbl-border'>\n<tr>\n";
		echo "<td align='left' valign='top'><h3>".sprintf($locale['urg_index_101'], $userdata['user_name'])."</h3></td>\n";
		echo "<td rowspan='3' align='right' valign='bottom'><img src='".GOLD_IMAGE."logo_home.png' alt='logo_home' /></td>\n";
		echo "</tr>\n<tr>\n";
		echo "<td align='left' valign='top'>".sprintf($locale['urg_index_102'], "<strong>".formatMoney($golddata['cash'])."</strong>")."</td>\n";
		echo "</tr>\n";
			if (UGLD_BANK_ENABLED) {
				echo "<tr><td align='left' valign='top'>".sprintf($locale['urg_index_103'], UGLD_BANKLINK,"<strong>".UGLD_BANK_INTEREST."</strong>","<strong>".formatMoney($golddata['bank'])."</strong>",UGLD_BANKLINK)."</td></tr>\n";
			}
			if (UGLD_DISPLAY_USAGE_INDEX) {
				echo "<tr><td align='left' valign='top'>".panel_itemdisplay()."</td></tr>\n";
			}
		echo "</table><br />\n";
		//This is a double sided table to contain some panels			
		echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'>\n<tr>\n";
		echo "<td style='vertical-align: top; width: 48%;'>\n";		
		
		//Top Ten Chash
		openside($locale['urg_index_105']);
		echo "<table width='100%' cellpadding='5' cellspacing='1' border='0'>\n<tr>\n";
		echo "<td valign='top' width='100%'>";
		echo panel_topten_cash();
		echo "<br /></td></tr></table>\n";
		closeside(); 
				
		//Top Ten Chips
		openside($locale['urg_index_106']);
		echo "<table width='100%' cellpadding='5' cellspacing='1' border='0'>\n<tr>\n";
		echo "<td valign='top' width='100%'>\n";
		echo panel_topten_chips();
		echo "<br /></td></tr></table>\n";
		closeside();
		
		echo "</td>\n";
		echo "<td  valign='top' width='1%'></td>\n";
		echo "<td valign='top' width='48%'>\n";
			
		//Top Ten Bank
		if(UGLD_BANK_ENABLED) {
			openside($locale['urg_index_107']);
			echo "<table width='100%' cellpadding='5' cellspacing='1' border='0'>\n<tr>\n";
			echo "<td valign='top' width='100%'>\n";
			echo panel_topten_bank();
			echo "<br /></td></tr></table>\n";
			closeside();
		}

		//Top Ten Karma
		openside($locale['urg_index_108']);
		echo "<table width='100%' cellpadding='5' cellspacing='1' border='0'>\n<tr>\n";
		echo "<td valign='top' width='100%'>\n";
		echo panel_topten_karma();
		echo "<br /></td></tr></table>\n";
		closeside();
		
		echo "</td>\n</tr>\n</table>\n";
	closetable();
}

//Include as required
if (!empty($op)) {
	$ops = explode("_", $op);
	if (file_exists(INFUSIONS."user_gold/inc/".$ops[0].".inc.php")) {
		include_once (INFUSIONS."user_gold/inc/".$ops[0].".inc.php");
	}
}

switch($op) {
	//usergold system (no prefix)
	case "start":
		index();
		break;
	case "list":
		item_display();
		break;
	case "showmembers":
		showmembers();
		break;
		//gamble system
	case "gamble_menu":
		gamble_menu();
		break;
	case "gamble_gamble":
		gamble_gamble();
		break;
	case "gamble_games":
		//include_once GOLD_INC."games.inc.php";
		gamble_games();
		break;
		//extras system
	case "extras_start":
		extras_start();
		break;
		//Bank System
	case "bank_menu":
		bank_menu();
		break;
	case "bank_interest":
		bank_interest();
		break;
	case "bank_start":
		bank_start();
		break;
	case "bank_complete":
		bank_complete();
		break;
	case "bank_transactions":
		bank_transactions();
		break;
		//donation system
	case "donate_centre_start":
		donate_centre_start();
		break;
	case "donate_gold_start":
		donate_gold_start();
		break;
	case "donate_gold_send":
		donate_gold_send();
		break;
	case "donate_item_send":
		donate_item_send();
		break;
	case "donate_item_start":
		donate_item_start();
		break;
	case "donate_self_donate":
		donate_self_donate();
		break;
		//Shop System
	case "shop_menu":
		shop_menu();
		break;
	case "shop_intro":
		shop_intro();
		break;
	case "shop_start":
		shop_start();
		break;
	case "shop_finalise":
		shop_finalize();
		break;
	case "shop_ribbon_start":
		shop_ribbon_start();
		break;
	case "shop_item":
		shop_item();
		break;
	case "shop_ribbon_finalize":
		shop_ribbon_finalize();
		break;
	case "shop_buysteal":
		shop_buysteal();
		break;
	case "shop_addposts":
		shop_addposts();
		break;
	case "shop_signup":
		shop_signup();
		break;
	case "shop_karma":
		shop_karma();
		break;
	case "trade_stop":
		trade_stop();
		break;
	case "trade_finalise":
		trade_finalise();
		break;
	case "trade_sell":
		trade_sell();
		break;
	case "trade_buy":
		trade_buy();
		break;
	case "trade_start":
		trade_start();
		break;
	case "user_menu":
		user_menu();
		break;
	case "user_inventory_start":
		user_inventory_start();
		break;
	case "user_settings_start":
		user_settings_start();
		break;
	case "user_settings_save":
		user_settings_save();
		break;
	case "member_menu":
		member_menu();
		break;
	case "member_inventory_start":
		member_inventory_start();
		break;
	case "member_viewinventory":
		member_viewinventory();
		break;
	case "member_steal":
		member_steal();
		break;
	default:
		if(!$op) index();
		break;
}

include "footer.php";
?>