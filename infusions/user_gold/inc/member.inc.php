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
| Filename: member.inc.php
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

if (file_exists(GOLD_LANG.LOCALESET."member.php")) {
	include GOLD_LANG.LOCALESET."member.php";
} else {
	include GOLD_LANG."English/member.php";
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function member_menu() { //Member menu
	global $locale, $golddata;
	table_top($locale['urg_member_100']);
	echo "<table width='100%' cellpadding='3' cellspacing='3'class='tbl-border'>\n<tr>\n";
	echo "<td><h3>".$locale['urg_member_101a']."</h3></td>\n";
	echo "<td rowspan='3' align='right' valign='bottom'><img src='".GOLD_IMAGE."logo_member.png' alt='logo_member'></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td>".sprintf($locale['urg_member_101b'], UGLD_GOLDTEXT)."</td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td>".$locale['urg_member_101c']."</td>\n";
	echo "</tr>\n</table>\n";
	
	echo "<div style='margin:5px'></div>\n";
	
	echo "<table width='100%' cellpadding='0' cellspacing='0'class='tbl-border'>\n<tr>\n";
	echo "<td class='tbl2'><a href='index.php?op=member_inventory_start'>".$locale['urg_member_102']."</a>\n";
	if (GLD_STEAL && $golddata['steal'] < date('Ymd')) {
		echo " - <a href='index.php?op=member_steal'>".$locale['urg_member_103']."</a><br />\n";
	} else {
		echo $locale['urg_member_103']." ".$locale['urg_member_104']."<br />\n";
	}
	echo "</td>\n";
	echo "</tr>\n</table>\n";
	closetable();
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function member_inventory_start() { //Members inventory start page
	global $tpl_member, $HTTP_POST_VARS, $userdata, $locale, $settings, $golddata;
	table_top($locale['urg_member_109']);
	echo "<form action='index.php' method='post'>\n";
	echo "<table width='100%' cellpadding='3' cellspacing='3' class='tbl-border'>\n<tr valign='top'>\n";
	echo "<td width='100%' colspan='2'><br />".$locale['urg_member_105']."</td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td>&nbsp;</td>\n";
	echo "<td>".$locale['urg_member_106']."\n";
	echo "<input type='hidden' name='op' value='member_viewinventory' />\n";
	echo "<input type='text' class='textbox' name='member' size='25' />\n";
	echo "<a style='cursor:help;' href='javascript:void(window.open(\"findmember.php?title=findmember\",\"\",\"width=350,height=400\"));'>\n";
	echo "<img src='images/find.png' title='".$locale['urg_member_107']."' alt='".$locale['urg_member_107']."' style='border: 0;' />\n";
	echo "</a></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td colspan='2' align='center'><input class='button' type='submit' value='".$locale['urg_member_108']."' /></td>\n";
	echo "</tr>\n</table>\n";
	echo "</form>\n";
	closetable();
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function member_viewinventory() { //View a members inventory
	global $HTTP_POST_VARS, $userdata, $locale, $settings, $golddata;

	$member = stripinput($_POST['member']);
	$result = dbquery(
		"SELECT g.owner_id, u.user_name as owner_name
		FROM ".DB_UG3." g
		LEFT JOIN ".DB_USERS." u ON g.owner_id = u.user_id
		WHERE user_name = '".$member."' OR owner_id = '".$member."'
		LIMIT 1"
	);
	$row = dbarray($result);
	
	table_top(sprintf($locale['urg_member_135'], $member),'');
	echo "<table width='100%' cellpadding='5' cellspacing='0' class='tbl-border'>\n";
		if (($row['owner_id'] <> $member) && $row['owner_name'] <> $member) {
			echo "<tr><td align='center'>".sprintf($locale['urg_member_110'], $member)."</td></tr>\n";
		} else {
			$usersid = $row['owner_id'];
			$usersname = $row['owner_name'];
		echo "<tr>\n";
		echo "<td style='font-weigh: bold; text-align: center;' colspan='3'><strong>".sprintf($locale['urg_member_111'], $usersid, $usersname)."</strong></td>\n";
		echo "</tr>\n<tr valign='top' class='windowbg'>\n";
		echo "<td style='padding-bottom: 2px;' width='32px'><strong>".$locale['urg_member_112']."</strong></td>\n";
		echo "<td><strong>".$locale['urg_member_113']."</strong></td>\n";
		echo "<td><strong>".$locale['urg_member_114']."</strong></td>\n";
		echo "<td><strong>".$locale['urg_member_136']."</strong></td>\n";
		echo "</tr>\n";
		$i = 0;//color

		$result = dbquery("SELECT it.name, it.description, it.image, inv.id, inv.trading 
		  FROM ".DB_UG3_INVENTORY." AS inv, ".DB_UG3_USAGE." AS it 
		  WHERE ownerid = '".$usersid."' AND inv.itemid = it.id");

		while ($row = dbarray($result)) {
			if ($i % 2 == 0) { $alternating = "tbl2"; } else { $alternating = "tbl1"; }
				echo "<tr valign='top' class='".$alternating."'>\n";
				echo "<td><img src='images/item_images/".$row['image']."' title='".$row['name']."' alt='".$row['name']."' style='border: 0; width: 32px; height: 32px;' /></td>\n";
				echo "<td style='padding-bottom: 2px;' width='20%'>".$row['name']."</td>\n";
				echo "<td>".$row['description']."</td>\n";
				echo "<td>".($row['trading'] == 1 ? $locale['urg_member_115'] : $locale['urg_member_116'])."</td>\n";
				echo "</tr>\n";
				$i++;
			}
		}
	
	echo "</table>\n";
	closetable();
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function member_steal() { //Steal Money	
	global $HTTP_POST_VARS, $userdata, $locale, $settings, $golddata;
	//set an amount in case its missed later
	$success = '20';
	table_top($locale['urg_member_103']);	
	/*
	First things first.. Can Only steal from users cash amounts never from bank.
	Lots of things can happen here. If steal is good stuff could happen to stealee
	if steal is bad stuff could happen to stealer.
	Maybe we need a jail now to go with this?
	Fail to steal go to jail and jail means loss of all owned stuff?
	*/

	//lets trim the useage of this damn thing
	if ($golddata['steal'] < date('Ymd')) {
		global $stealfrom_id, $stealfrom_name, $steal_amount;
		if(isset($_POST['stealfrom']) != '') {
			//there must be something in the steal from box
			$stealfrom = stripinput($_POST['stealfrom']);
			//its not an numewral so select useing the name
			//sort out the name to id situation
			$id_query = dbquery(
				"SELECT g.*, u.user_name as owner_name
				FROM ".DB_UG3." g
				LEFT JOIN ".DB_USERS." u ON g.owner_id = u.user_id
				WHERE user_name = '".$stealfrom."'
				LIMIT 1"
			);
				//$id_query = dbquery("SELECT * FROM ".DB_UG3." WHERE owner_name='".$stealfrom."' LIMIT 1");
			//$id_result = dbfetch_array($id_query);
			$id_result = dbarray($id_query);
			$stealfrom_id = $id_result['owner_id'];
			$stealfrom_name = $id_result['owner_name'];

			//timer for daily steal only
			$result = dbquery("UPDATE ".DB_UG3." SET steal = '".date('Ymd')."' WHERE owner_id = '".$golddata['owner_id']."' LIMIT 1");
			$result = dbquery(
				"SELECT g.*, u.user_name as owner_name
				FROM ".DB_UG3." g
				LEFT JOIN ".DB_USERS." u ON g.owner_id = u.user_id
				WHERE owner_id = '".$stealfrom_id."'
				LIMIT 1"
			);
				//$result = dbquery("SELECT * FROM ".DB_UG3." WHERE owner_id='".$stealfrom_id."' LIMIT 1");
			//ok its all so unfair aint it?
			//so lets play a little
			//if the theif has more money than the selected target
			$target_query = dbquery(
				"SELECT g.*, u.user_name as owner_name
				FROM ".DB_UG3." g
				LEFT JOIN ".DB_USERS." u ON g.owner_id = u.user_id
				WHERE owner_id = '".$stealfrom_id."'
				LIMIT 1"
			);
				//$target_query = dbquery("SELECT * FROM ".DB_UG3." WHERE owner_id='".$stealfrom_id."' LIMIT 1");
			//$target_result = dbfetch_array($target_query);
			$target_result = dbarray($target_query);
			$targets_total = $target_result['cash'] + $target_result['bank'];
			if($targets_total < '100' || $targets_total < '') {
				opentable($locale['urg_member_117']);
				echo $locale['urg_member_118'];
				closetable();
				include "footer.php";
				exit;
			}
			$my_total = $golddata['cash'] + $golddata['bank'];
			if($targets_total < $my_total) {//less than theif
				//set the success percentage low
				$success = '10';
			} elseif($targets_total > $my_total*2) {//more than double of theif
				//set the success percentage low
				$success = '70';
			} elseif($targets_total > $my_total/2) {//more than half of theif
				//set the success percentage low
				$success = '45';
			} else {
				$success = '35';
			}

			//get a random number between 0 and 100
			$try = rand(0, 100);//percentage probability will work on
			//if successfull
			if ($try < $success) { // ??% chance of success
				$stealee = getusergold($stealfrom_id, 'cash');
				$steal_amount = rand(0, $stealee);

				//take this money away from stealee...
				takegold2($stealfrom_id, $steal_amount, 'cash');
				payuser($userdata['user_id'], $steal_amount, 'cash');

				if($steal_amount < 50) {
					echo $locale['urg_member_119']." ".$steal_amount."!";
				} else {
					echo $locale['urg_member_120']." ".$steal_amount." ".$locale['urg_member_121']." ".$stealfrom_name."".$locale['urg_member_122']." ".$stealfrom_name." ".$locale['urg_member_123'];
				}
			} else {
				if($golddata['cash'] + $golddata['cash'] <= $steal_amount){ $opt = '2'; } else { $opt = '4'; }
				//ok its punishment time..
				$punishment_id = rand(0, $opt);//grab a random punishment

				if($punishment_id == 0) {
					echo $locale['urg_member_124'];
				} elseif($punishment_id == 1) {
					//take karma (must be forced to go negative)
					takegold2($userdata['user_id'], '10', 'karma', 1);
					echo $locale['urg_member_125'];
				} elseif($punishment_id == 2) {
					//take gold (force it)
					//$fine = $golddata[cash]/2;
					$fine_amount = rand(0, $golddata['cash'] + $golddata['bank']);
					takegold2($userdata['user_id'], $fine_amount, 'cash', 1);
					echo $locale['urg_member_126'].formatMoney($fine_amount)."!<br />";
				} elseif($punishment_id == 3) {
					//the stealee robs you
					//$returnsteal = $golddata['cash']/2;
					//$returnsteal = $golddata['cash'];
					$returnsteal = $golddata['cash'] + $golddata['bank'];
					payuser($stealfrom_id, $returnsteal, 'cash');
					takegold2($userdata['user_id'], $returnsteal, 'cash', '1');
					echo $stealfrom_name.$locale['urg_member_128'].formatMoney($returnsteal).$locale['urg_member_129'];

				} elseif($punishment_id == 4) {
					//the stealee robs you
					//$returnsteal = $golddata['cash']/2;
					$returnsteal = $golddata['cash'];
					payuser($stealfrom_id, $returnsteal, 'cash');
					takegold2($userdata['user_id'], $returnsteal, 'cash', '1');
					echo $locale['urg_member_127'].$stealfrom_name.$locale['urg_member_128'].formatMoney($returnsteal).$locale['urg_member_129'];

				} else {
					echo $locale['urg_member_124'];
				}
			}
		} else {
			echo "<form action='index.php' method='post'>\n";
			echo "<table width='100%' cellpadding='3' cellspacing='3' class='tbl-border'>\n<tr valign='top'>\n";
			echo "<td width='100%' colspan='2'><br />".$locale['urg_member_130']."</td>\n";
			echo "</tr>\n<tr valign='top'>\n";
			echo "<td width='100%' colspan='2'><br />".$locale['urg_member_131']."</td>\n";
			echo "</tr>\n<tr valign='top'>\n";
			echo "<td width='100%' colspan='2'><br />".$locale['urg_member_132']."</td>\n";
			echo "</tr>\n<tr class='tbl2'>\n";
			echo "<td><input type='hidden' name='op' value='member_steal' /></td>\n";
			echo "<td>".$locale['urg_member_133']."<input type='text' class='textbox' name='stealfrom' size='50' />\n";
			echo "<a style='cursor:help;' href='javascript:void(window.open(\"findmember.php?title=findmember\",\"\",\"width=350,height=400\"));'>\n";
			echo "<img src='images/find.png' title='".$locale['urg_member_107']."' alt='".$locale['urg_member_107']."' style='border: 0;' />\n";
			echo "</a></td>\n";
			echo "</tr>\n<tr>\n";
			echo "<td colspan='2' align='center'><input class='button' type='submit' value='".$locale['urg_member_108']."' /></td>\n";
			echo "</tr>\n</table>\n";
			echo "</form>";
		}
	} else {
		echo $locale['urg_member_134'];
	}
	closetable();
}
?>