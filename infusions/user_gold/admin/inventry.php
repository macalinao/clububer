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
| Filename: inventory.php
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

if (file_exists(GOLD_LANG.LOCALESET."admin/inventry.php")) {
	include GOLD_LANG.LOCALESET."admin/inventry.php";
} else {
	include GOLD_LANG."English/admin/inventry.php";
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function start_inventory() {
	global $locale, $aidlink;
	opentable($locale['urg_a_inventry_100'],'');
	echo "<table width='100%' class='tbl-border' cellpadding='5' cellspacing='0'>\n<tr valign='top'>\n";
	echo "<td width='100%'>".$locale['urg_a_inventry_101']."<br />\n";
	echo "<form action='index.php".$aidlink."&amp;op=viewmember' method='post'>\n";
	echo "<input name='searchfor' class='textbox' type='text' size='70' />\n";
	echo "<a style='cursor:help;' href='javascript:void(window.open(\"../findmember.php?title=findmember\",\"\",\"width=350,height=400\"));'>\n";
	echo "<img alt='find_members' src='../images/find.png' style='border: 0;' /></a><br />\n";
	echo "<input type='submit' class='button' value='".$locale['urg_a_inventry_103']."' />\n";
	echo "</form>\n";
	echo "</td>\n";
	echo "</tr>\n</table>\n";
	closetable();
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function viewmember() { // view the members inventory
	global $locale, $aidlink;
	$searchfor = stripinput($_POST['searchfor']);
	
	opentable(sprintf($locale['urg_a_inventry_104'], $searchfor),'');

	$id_searchq = dbquery("SELECT user_id 
	FROM ".DB_USERS." WHERE user_name = '".$searchfor."'");
	$id_searchr = dbarray($id_searchq);
	$id_search = $id_searchr['user_id'];
	
	if ($id_searchr == 0) {
		$context['shop_inventory_search'] = 2;
		echo sprintf($locale['urg_a_inventry_105'],$searchfor);
	} else {
		echo "<br /><strong>Owns</strong><br />\n";
		echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'>\n<tr valign='top' class='tbl1'>\n";
		echo "<td style='padding: 2px;'><strong>".$locale['urg_a_inventry_106']."</strong></td>\n";
		echo "<td style='padding: 2px;'><strong>".$locale['urg_a_inventry_107']."</strong></td>\n";
		echo "<td style='padding: 2px;'><strong>".$locale['urg_a_inventry_108']."</strong></td>\n";
		echo "<td style='padding: 2px;'><strong>".$locale['urg_a_inventry_109']."</strong></td>\n";
		echo "<td style='padding: 2px;'><strong>".$locale['urg_a_inventry_110']."</strong></td>\n";
		echo "<td style='padding: 2px;'><strong>".$locale['urg_a_inventry_111']."</strong></td>\n";
		echo "</tr>\n";
		
		$i = 0;//color
		$OwnedResult = dbquery("SELECT it.name, it.description, it.purchase, it.cost, it.image, it.active, inv.amtpaid, inv.id, inv.trading, inv.tradecost 
		FROM ".DB_UG3_INVENTORY." AS inv, ".DB_UG3_USAGE." AS it WHERE inv.ownerid = '".$id_search."' 
		AND inv.itemid = it.id ORDER BY it.name ASC");
		
		while ($OwnedRow = dbarray($OwnedResult)) {
			if ($i % 2 == 0) { $OwnedAlternating = "tbl2"; } else { $OwnedAlternating = "tbl1"; }
				echo "<tr valign='top' class='".$OwnedAlternating."'>\n";
				echo "<td align='center'><img border='0' width='".UGLD_IMAGE_WIDTH."' height='".UGLD_IMAGE_HEIGHT."' src='../images/item_images/".$OwnedRow['image']."' /></td>\n";
				echo "<td style='padding: 2px;'>".$OwnedRow['name']."</td>\n";
				echo "<td style='padding: 2px;'>".$OwnedRow['description']."</td>\n";
				echo "<td style='padding: 2px;'>".formatMoney($OwnedRow['amtpaid'])."</td>\n";
				echo "<td style='padding: 2px;' align='center'>\n";
			
				if ($OwnedRow['trading'] == "1") {
					echo $locale['urg_a_inventry_112']."</td>\n";
				} else {
					echo $locale['urg_a_inventry_113']."</td>\n";
				}
			
				echo "<td align='center' style='padding: 2px;'>\n";
				echo "<a href='index.php".$aidlink."&amp;op=admin_sell&amp;id=".$OwnedRow['id']."&amp;username=".$searchfor."&amp;userid=".$id_search."&amp;amtpaid=".$OwnedRow['amtpaid']."'>\n";
				echo $locale['urg_a_inventry_114']."</a></td></tr>\n";
			$i++;
		}
		
		echo "</table>\n";
		
		echo "<br /><hr /><br /><strong>".$locale['urg_a_inventry_116']."</strong><br />\n";
		
		$AvailResult = dbquery("SELECT name, description, cost, image, active 
		FROM ".DB_UG3_USAGE." WHERE purchase > 1 
		AND id NOT IN (SELECT itemid FROM ".DB_UG3_INVENTORY." WHERE ownerid = '".$id_search."') 
		ORDER BY name ASC");
		
		echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'>\n<tr valign='top' class='tbl1'>\n";
		echo "<td style='padding: 2px;'><strong>".$locale['urg_a_inventry_106']."</strong></td>\n";
		echo "<td style='padding: 2px;'><strong>".$locale['urg_a_inventry_107']."</strong></td>\n";
		echo "<td style='padding: 2px;'><strong>".$locale['urg_a_inventry_108']."</strong></td>\n";
		echo "<td style='padding: 2px;'><strong>".$locale['urg_a_inventry_115']."</strong></td>\n";
		echo "</tr>\n";
		
		$j = 0;//color
			
		while ($AvailRow = dbarray($AvailResult)) {
			if ($j % 2 == 0) { $AvailAlternating = "tbl2"; } else { $AvailAlternating = "tbl1"; }
			echo "<tr valign='top' class='".$AvailAlternating."'>\n";
			echo "<td align='center'><img border='0' width='".UGLD_IMAGE_WIDTH."' height='".UGLD_IMAGE_HEIGHT."' src='../images/item_images/".$AvailRow['image']."' alt='' /></td>\n";
			echo "<td style='padding: 2px;'>".$AvailRow['name']."</td>\n";
			echo "<td style='padding: 2px;'>".$AvailRow['description']."</td>\n";
			echo "<td style='padding: 2px;'>".formatMoney($AvailRow['cost'])."</td>\n";
			echo "</tr>\n";
			$j++;
		}
		
		echo "</table>\n";
		
		$EditResult = dbquery("SELECT * FROM ".DB_UG3." WHERE owner_id = '".$id_search."' LIMIT 1");
		$EditRow = dbarray($EditResult);
		
		if ($EditRow == 0) { //If this member doesn't exist
			echo sprintf($locale['urg_a_inventry_105'],$searchfor);
		} else {
			echo "<br /><hr /><br /><strong>".$locale['urg_a_inventry_117']."</strong><br />\n";
			echo "<form action='index.php".$aidlink."&amp;op=admineditmoney' method='post'>\n";
			echo "<input type='hidden' name='userid' value='".$EditRow['owner_id']."' />\n";
			echo "<input type='hidden' name='username' value='".$searchfor."' />\n";
			echo "<table width='100%' border='0' cellspacing='3' cellpadding='3'>\n<tr>\n";
			echo "<td>".$locale['urg_a_inventry_118']."</td>\n";
			echo "<td><input class='textbox' type='text' value='".$EditRow['cash']."' name='money_pocket' /></td>\n";
			echo "</tr>\n<tr>\n";
			echo "<td>".$locale['urg_a_inventry_119']."</td>\n";
			echo "<td><input class='textbox' type='text' value='".$EditRow['bank']."' name='money_bank' /></td>\n";
			echo "</tr>\n<tr>\n";
			echo "<td>".$locale['urg_a_inventry_120']."</td>\n";
			echo "<td><input class='textbox' type='text' value='".$EditRow['chips']."' name='chips' /></td>\n";
			echo "</tr>\n<tr>\n";
			echo "<td>".$locale['urg_a_inventry_121']."</td>\n";
			echo "<td><input class='textbox' type='text' value='".$EditRow['karma']."' name='karma' /></td>\n";
			echo "</tr>\n<tr>\n";
			echo "<td>".$locale['urg_a_inventry_122']."</td>\n";
			echo "<td><input class='textbox' type='text' value='".$EditRow['ribbon']."' name='ribbon' /></td>\n";
			echo "</tr>\n<tr>\n";
			echo "<td></td>\n";
			echo "<td><input class='button' type='submit' value='".$locale['urg_a_inventry_123']."' /></td>\n";
			echo "</tr>\n</table>\n";
			echo "</form>\n";
			//echo $context['shop_inventory_list'];
		}
	}
	closetable();
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function admin_sell() { //executes the admin sale of a members item
	global $locale, $aidlink;
	$searchfor = stripinput($_POST['searchfor']);
	$userid = stripinput($_GET['userid']);
	$username = stripinput($_GET['username']);
	$id = stripinput($_GET['id']);
	$amtpaid = stripinput($_GET['amtpaid']);
	opentable(stripslash($username.'\'s Item sold'),'');
	$context['shop_inventory_search'] = 2;
	$result = dbquery("DELETE FROM ".DB_UG3_INVENTORY." WHERE id = '".$id."' LIMIT 1");
	payuser($userid, $amtpaid, 'cash');
	echo "<div align='center'>".sprintf('item %s has been sold for the amount of %s.', $id, $amtpaid);
	echo "<form action='index.php".$aidlink."&amp;op=viewmember' method='post'>\n";
	echo "<input name='searchfor' class='textbox' type='hidden' value='".$username."'>\n";
	echo "<input type='submit' class='button' value='".$locale['urg_a_inventry_125']."'>\n";
	echo "</form>\n";	
	closetable();
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function admineditmoney(){ // Saves the changes done to the users account by admin
	global $userdata, $locale, $aidlink;
	$userid = stripinput($_POST['userid']);
	$username = stripinput($_POST['username']);
	$money_pocket = stripinput($_POST['money_pocket']);
	$money_bank = stripinput($_POST['money_bank']);
	$chips = stripinput($_POST['chips']);
	$karma = stripinput($_POST['karma']);
	$ribbon = stripinput($_POST['ribbon']);
	opentable($locale['urg_a_inventry_100'],'');
	echo "<div align='center'>\n";
	$context['shop_inventory_search'] = 2;
	$result = dbquery("UPDATE ".DB_UG3." SET cash = '".$money_pocket."', bank = '".$money_bank."', chips = '".$chips."', karma = '".$karma."', ribbon = '".$ribbon."' WHERE owner_id = '".$userid."' LIMIT 1");
	echo sprintf($locale['urg_a_inventry_124'], $username, $money_pocket, $money_bank, $chips, $karma, $ribbon);
	echo "<form action='index.php".$aidlink."&amp;op=viewmember' method='post'>\n";
	echo "<input name='searchfor' class='textbox' type='hidden' value='".$username."' />\n";
	echo "<input type='submit' class='button' value='".$locale['urg_a_inventry_125']."' />\n";
	echo "</form>\n";
   
	$subject = $locale['urg_a_inventry_126'];
	$message = sprintf($locale['urg_a_inventry_127'], $userdata['user_name'], $money_pocket, $money_bank, $chips, $karma, $ribbon);
	sendpm($userid , $subject, $message, $$userdata['user_id'], $userdata['user_name']);
   
	echo "</div>\n";
	closetable();
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~  	*/
?>