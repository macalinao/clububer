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
| Filename: trade.inc.php
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

if (file_exists(GOLD_LANG.LOCALESET."trade.php")) {
	include_once GOLD_LANG.LOCALESET."trade.php";
} else {
	include_once GOLD_LANG."English/trade.php";
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function trade_start() { //Entry Screen Includes list of trade items
	global $userdata, $locale, $golddata;
	table_top($locale['urg_trade_100']);	
	echo "<table width='100%' cellpadding='3' cellspacing='3' class='tbl-border'>\n<tr>\n";
	echo "<td><h3>".$locale['urg_trade_106']."</h3></td>\n";
	echo "<td rowspan='3' align='right' valign='bottom'><img src='".GOLD_IMAGE."logo_trade.png' alt='logo_trade'></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td>".$locale['urg_trade_107']."</td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td>".$locale['urg_trade_112']."</td>\n";
	echo "</tr>\n</table>\n";
	
	echo "<div style='margin:5px'></div>\n";
	
	echo "<table width='100%' cellpadding='3' cellspacing='3' class='tbl-border'>\n<tr valign='top' class='tbl1'>\n";
	echo "<td style='width: 100%;'>".$locale['urg_trade_108']."<br /><br />\n";
	echo "<table width='100%' cellpadding='3' cellspacing='3'>\n<tr valign='top' class='tbl1'>\n";
	echo "<td width='32'><strong>".$locale['urg_trade_109']."</strong></td>\n";
	echo "<td><strong>".$locale['urg_trade_110']."</strong></td>\n";
	echo "<td><strong>".$locale['urg_trade_111']."</strong></td>\n";
	echo "<td width='18%'><strong>".$locale['urg_trade_102']."</strong></td>\n";
	echo "</tr>\n";

	$alternating = "tbl2";

	$result = dbquery(
		"SELECT it.name, it.description, it.image, inv.id, u.user_name as owner_name, inv.tradecost, inv.ownerid
		FROM ".DB_UG3_INVENTORY." inv
		LEFT JOIN ".DB_UG3_USAGE." it ON inv.itemid = it.id
		LEFT JOIN ".DB_USERS." u ON inv.ownerid = u.user_id
		WHERE inv.trading = '1'"
	);
								
	if (dbrows($result)) {
		while ($item = dbarray($result)) {
			echo "<tr valign='top' class='".$alternating."'>\n";
			echo "<td><img border='0' width='32' height='32' src='".GOLD_DIR."images/item_images/".$item['image']."' title='".$item['name']."' alt='".$item['name']."' /></td>\n";
			echo "<td width='20%'>".$item['name']."</td>\n";
			echo "<td>".$item['description']."<br /><i>".sprintf($locale['urg_trade_101'], $item['owner_name'])."</i></td>\n";
			echo "<td style='width: 18%;'>".$locale['urg_trade_102']." ".formatMoney($item['tradecost'])."<br />\n";
			if ($item['ownerid'] == $userdata['user_id'])	{
				echo $locale['urg_trade_103'];
			} elseif ($golddata['cash'] >= $item['tradecost']) {
				echo "<a href='".GOLD_DIR."index.php?op=trade_buy&id=".$item['id']."'>".$locale['urg_trade_104']."</a>\n";
			} else {
				echo "<font style='weight: bold;'>".sprintf($locale['urg_trade_105'], formatMoney($item['tradecost'] - $golddata['cash']))."</font>\n";
			}
			echo "</td>\n";
			echo "</tr>\n";
			$alternating = ($alternating == "tbl2") ? "tbl1" : "tbl2";
		}
	} else {
		echo "<tr><td colspan='4' align='center'>".$locale['urg_trade_127']."</td></tr>\n";
	}
	echo "</table>\n<br />\n";
	echo "</td>\n</tr>\n</table>\n";
	closetable();
} //trade_start()

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function trade_buy() { //Buy An Item available from another user
	global $locale, $golddata;
	table_top($locale['urg_trade_113']);
	if (isset($_POST['id']) && !isNum($_POST['id'])) redirect("index.php");

	//Get information on the item in  question	
	$result = dbquery(
		"SELECT it.*, inv.*, u.user_name as owner_name
		FROM ".DB_UG3_INVENTORY." inv
		LEFT JOIN ".DB_UG3_USAGE." it ON inv.itemid = it.id
		LEFT JOIN ".DB_USERS." u ON inv.ownerid = u.user_id
		WHERE inv.id = '".$_GET['id']."'
		LIMIT 1"
	);
	
	if (dbrows($result)) {
		$item = dbarray($result);
		if ($item['trading'] != 1) {
			echo $locale['urg_trade_114'];
			print_r($item);
		} elseif ($golddata['cash'] < $item['tradecost']) {
			echo sprintf($locale['urg_trade_115'], $cost - $golddata['cash']);
		} else {
			//change item info
			$result = dbquery("UPDATE ".DB_UG3_INVENTORY." SET ownerid = '".$golddata['owner_id']."', amtpaid = '".$item['tradecost']."', trading = '0' WHERE id = '".$_GET['id']."' LIMIT 1");
	
			//decrease user's money
			takegold2($golddata['owner_id'], $item['tradecost'], 'cash');
	
			//give money to old owner
			payuser($item['owner_id'], $item['tradecost'], 'cash');
			
			//prepare message
			$subject = sprintf($locale['urg_trade_116'], $item['name']);
			$message = sprintf($locale['urg_trade_117'], $golddata['owner_id'], $golddata['owner_name'], $item['name'], formatMoney($item['tradecost']));
			
			//send
			sendpm($item['ownerid'], $subject, $message, $golddata['owner_id'], $golddata['owner_name']);
			echo sprintf($locale['urg_trade_118'], $item['name'], $item['owner_name']);
		}
	} else {
		echo $locale['urg_trade_128'];
	}
	pagerefresh('meta','2',FUSION_SELF.'?op=trade_start');
closetable();

} //trade_buy()

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function trade_sell() { //Sell An Item
	global $locale;
	if (isset($_POST['id']) && !isNum($_POST['id'])) redirect("index.php");
	$result = dbquery("SELECT amtpaid FROM ".DB_UG3_INVENTORY." WHERE id = '".$_POST['id']."' LIMIT 1");
	$row = dbarray($result);
	table_top($locale['urg_trade_119']);
	echo "<table width='100%' cellpadding='5' cellspacing='0' border='0' class='tbl2'><tr valign='top' class='tbl1'>\n";
	echo "<td style='width: 100%;'>\n";
	echo "<form action='".FUSION_SELF."?op=trade_finalise' method='post'>\n";
	echo "<input type='hidden' name='id' value='".$_POST['id']."' />\n";
	echo $locale['urg_trade_102']."<input type='text' class='textbox' name='sellfor' value='".$row['amtpaid']."' />\n";
	echo "<input type='submit' class='button' value='".$locale['urg_trade_120']."' /><br /><br />\n";
	echo $locale['urg_trade_121'];
	echo "</form>\n";
	echo "</td>\n";
	echo "</tr></table>\n";
	closetable();
}//trade_sell()

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function trade_finalise() { //Finalise transaction
global $userdata, $locale;
	if (isset($_POST['id']) && !isNum($_POST['id'])) redirect("index.php");
	$_POST['sellfor'] = stripinput($_POST['sellfor']);
	$result = dbquery("SELECT ownerid FROM ".DB_UG3_INVENTORY." WHERE id = '".$_POST['id']."' LIMIT 1");
table_top($locale['urg_trade_122']);
	$row = dbarray($result);
	if ($_POST['sellfor'] <= 0) {
		echo $locale['urg_trade_114'];
	} elseif ($row['ownerid'] !== $userdata['user_id']) { //trying to steal other person's item
		echo $locale['urg_trade_123'];
	} else {
		$result = dbquery("UPDATE ".DB_UG3_INVENTORY." SET trading = '1', tradecost = '".$_POST['sellfor']."' WHERE id = '".$_POST['id']."' LIMIT 1");
		echo $locale['urg_trade_124'];
	}
	pagerefresh('meta','2',FUSION_SELF.'?op=user_inventory_start');
closetable();
} //trade_finalise()

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function trade_stop() { //Remove item from trade list
global $userdata, $locale, $txt;
if (isset($_POST['id']) && !isNum($_POST['id'])) redirect("index.php");
table_top($locale['urg_trade_125']);	
	$result = dbquery("SELECT ownerid FROM ".DB_UG3_INVENTORY." WHERE id = '".$_POST['id']."' LIMIT 1");
	$row = dbarray($result);
	if ($row['ownerid'] !== $userdata['user_id']) { //trying to steal other person's item
		echo $locale['urg_trade_123'];
	} else {
		$result = dbquery("UPDATE ".DB_UG3_INVENTORY." SET trading = '0', tradecost = '0' WHERE id = '".$_POST['id']."' LIMIT 1");
		echo $locale['urg_trade_126'];
	}
	pagerefresh('meta','2',FUSION_SELF.'?op=user_inventory_start');
	closetable();
}//trade_stop()
?>