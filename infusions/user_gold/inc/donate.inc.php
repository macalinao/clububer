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
| Filename: donate.inc.php
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

if (file_exists(GOLD_LANG.LOCALESET."donate.php")) {
	include GOLD_LANG.LOCALESET."donate.php";
} else {
	include GOLD_LANG."English/donate.php";
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function donate_centre_start() {
	global $locale;
	table_top($locale['urg_donate_100']);
	echo "<table width='100%' cellpadding='3' cellspacing='3'class='tbl-border'>\n<tr>\n";
	echo "<td><h3>".$locale['urg_donate_101']."</h3></td>\n";
	echo "<td rowspan='3' align='right' valign='bottom'><img src='".GOLD_IMAGE."logo_donate.png' alt='logo_donate'></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td>".sprintf($locale['urg_donate_102'],UGLD_GOLDTEXT)."</td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td>".$locale['urg_donate_103']."</td>\n";
	echo "</tr>\n</table>\n";
	
	echo "<div style='margin:5px'></div>\n";
	
	echo "<table width='100%' cellpadding='0' cellspacing='0'class='tbl-border'>\n<tr>\n";
	echo "<td class='tbl2'><a href='index.php?op=donate_gold_start'>".sprintf($locale['urg_donate_104'],UGLD_GOLDTEXT)."</a>\n";
	echo " - <a href='index.php?op=donate_item_start'>".$locale['urg_donate_105']."</a></td>\n";
	echo "</tr>\n</table>\n";
	closetable();
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function donate_gold_start() {
	global $locale;
	isset($_GET['member']) ? $SendMoneyMember = $_GET['member'] : $SendMoneyMember = "";
	
	table_top($locale['urg_donate_106']);
	echo "<form action='index.php' method='post'>\n";
	echo "<table width='100%' cellpadding='3' cellspacing='3' class='tbl-border'>\n<tr valign='top'>\n";
	echo "<td width='100%' colspan='2'><br />".$locale['urg_donate_107']."</td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td><input type='hidden' name='op' value='donate_gold_send' />".$locale['urg_donate_108']."</td>\n";
	echo "<td><input class='textbox' type='text' name='give_name' size='25' value='".$SendMoneyMember."' />\n";
	echo "<a style='cursor:help;' href='javascript:void(window.open(\"findmember.php?title=findmember\",\"\",\"width=350,height=400\"));'>\n";
	echo "<img src='images/find.png' title='".$locale['urg_donate_109']."' alt='".$locale['urg_donate_109']."' style='border: 0;' />\n";
	echo "</a></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td>".$locale['urg_donate_110']."</td>\n";
	echo "<td>".UGLD_CURRENCY_PREFIX."<input class='textbox' type='text' name='amount' size='8' />".UGLD_CURRENCY_SUFFIX."</td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td>".$locale['urg_donate_111']."</td>\n";
	echo "<td><textarea class='textbox' name='message' cols='50' rows='5'></textarea></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td colspan='2' align='center'><input class='button' type='submit' value='".sprintf($locale['urg_donate_112'],UGLD_GOLDTEXT)."' /></td>\n";
	echo "</tr>\n</table>\n";
	echo "</form>\n";
	closetable();
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function donate_gold_send() { //Execute the donation of gold
	global $userdata, $locale, $settings, $golddata, $newdonate, $newribbon;
	if (isset($_POST['amount']) && !intval($_POST['amount'])) redirect("index.php");
	if (!isset($_POST['give_name'])){ redirect("index.php"); exit; }
	$amount = $_POST['amount'];
	$_POST['give_name'] = stripinput($_POST['give_name']);
	
	table_top(sprintf($locale['urg_donate_104'],UGLD_GOLDTEXT));	
	echo "<div>\n";
	
	if ($golddata['cash'] < $amount) { //trying to give more than they have
		echo sprintf($locale['urg_donate_131'],$amount);
	} elseif($amount < 0) {
		echo$locale['urg_donate_113'];
	} elseif ($amount == 0) {
		echo $locale['urg_donate_114'];
	} elseif ($_POST['give_name'] == $golddata['owner_name']) {
		echo $locale['urg_donate_115'];
	} else {
		$result = dbquery(
			"SELECT g.owner_id, u.user_name as owner_name
			FROM ".DB_UG3." g
			LEFT JOIN ".DB_USERS." u ON g.owner_id = u.user_id
			WHERE u.user_name = '".$_POST['give_name']."'
			LIMIT 1"
		);
		$row = dbarray($result);
		if ($row['owner_name'] !== $_POST['give_name']) {
			$result = dbquery("SELECT user_id, user_name FROM ".DB_USERS." WHERE user_name = '".$_POST['give_name']."' LIMIT 1");
			$row = dbarray($result);
			$exist = dbrows($result);
			if ($exist != 0) { 
				$karma = floor($amount / 1000 / 2);
				payuser($golddata['owner_id'], $karma, 'karma' );
				payuser($golddata['owner_id'], $amount, 'donated' );
				//payuser($golddata['owner_id'],$newribbon,'ribbon' ); <= Unexpected Error == Missing $newribbon

				takegold2($golddata['owner_id'], $amount, 'cash');
				if(($golddata['donated'] + $amount) >= UGLD_DONATE_RIBBON) {
					donate_to_ribbon($golddata['owner_id']);
				}

				payuser($row['user_id'], $amount, 'cash');
				echo sprintf($locale['urg_donate_116'], formatMoney($amount), $row['user_name']);

				$subject = sprintf($locale['urg_donate_117'], formatMoney($amount), $golddata['owner_name']);
				$message = sprintf($locale['urg_donate_118'], $golddata['owner_name'], formatMoney($amount), $_POST['message'], $settings['siteusername']);
				sendpm($row['user_id'], $subject, $message, $golddata['owner_id'], $golddata['owner_name']);
			} else {
				echo $locale['urg_donate_132'];
			}
		} else {
			$result = dbquery("SELECT user_id, user_name FROM ".DB_USERS." WHERE user_id = '".$row['owner_id']."' LIMIT 1");
			$exist = dbrows($result);
			if ($exist != 0) { 
				$karma = floor($amount / 1000 / 2);;
				payuser($golddata['owner_id'], $karma, 'karma' );
				payuser($golddata['owner_id'], $amount, 'donated' );
				takegold2($golddata['owner_id'], $amount, 'cash');

				if(($golddata['donated'] + $amount) >= UGLD_DONATE_RIBBON)	{
					//donate_to_ribbon($golddata['owner_id']);
				}

				payuser($row['owner_id'], $amount, 'cash');

				$subject = sprintf($locale['urg_donate_117'], formatMoney($amount), $golddata['owner_name']);
				$message = sprintf($locale['urg_donate_118'], $golddata['owner_name'], formatMoney($amount), $_POST['message'], $settings['siteusername']);
				sendpm($row['owner_id'], $subject, $message, $golddata['owner_id'], $golddata['owner_name']);
				echo sprintf($locale['urg_donate_116'], formatMoney($amount), $row['owner_name']);
			} else {
				echo $locale['urg_donate_132'];
			}
		}
	}
	echo "</div>\n";
	pagerefresh('meta',3,FUSION_SELF.'?op=donate_gold_start');
	closetable();
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function donate_item_start() {
	global $tpl_donate, $HTTP_POST_VARS, $userdata, $locale, $settings, $golddata;
	table_top($locale['urg_donate_119']);
	echo "<form action='index.php' method='post'>\n";
	echo "<table width='100%' cellpadding='3' cellspacing='3' class='tbl-border'>\n<tr valign='top'>\n";
	echo "<td colspan='2' width='100%'><br />".$locale['urg_donate_120']."</td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td>".$locale['urg_donate_108']."</td>\n";
	echo "<td><input type='hidden' value='donate_item_send' name='op' />\n";
	echo "<input class='textbox' type='text' name='membername' size='25' />\n";
	echo "<a style='cursor:help;' href='javascript:void(window.open(\"findmember.php?title=findmember\",\"\",\"width=350,height=400\"));'>\n";
	echo "<img src='images/find.png' title='".$locale['urg_donate_109']."' alt='".$locale['urg_donate_109']."'  style='border: 0;' />\n";
	echo "</a></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td>".$locale['urg_donate_121']."</td>\n";
	echo "<td><select name='giftid' class='textbox'>\n";
	echo "<option>".$locale['urg_donate_133']."</option>\n";					
	$result = dbquery("SELECT it.name, inv.id AS ivid, inv.trading 
	  FROM ".DB_UG3_INVENTORY." AS inv, ".DB_UG3_USAGE." AS it 
	  WHERE inv.ownerid = ".$userdata['user_id']." 
	  AND inv.itemid = it.id 
	  AND inv.trading = 0 
	  GROUP BY it.id 
	  ORDER BY it.name ASC 
	");
						
	while ($row = dbarray($result)) {
		echo "<option value = '".$row['ivid']."'>".$row['name']."</option>\n";
	}
						
	echo "</select></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td>".$locale['urg_donate_111']."</td>\n";
	echo "<td><textarea class='textbox' name='message' cols='50' rows='5'></textarea></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td colspan='2' align='center'><input type='submit' value='".$locale['urg_donate_122']."' class='button' /></td>\n";
	echo "</tr>\n</table>\n";
	echo "</form>\n";
	closetable();
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function donate_item_send() {
	global $userdata, $locale, $settings, $golddata;
	if (!isset($_POST['giftid'])) { header("location:".BASEDIR); exit; }
	if (!isset($_POST['membername'])) { header("location:".BASEDIR); exit; }
	$giftid = stripinput($_POST['giftid']);
	$membername = stripinput($_POST['membername']);
	$result = dbquery("SELECT user_id, user_name FROM ".DB_USERS." WHERE user_name='".$membername."' LIMIT 1");
	$exist = dbrows($result);
	table_top(sprintf($locale['urg_donate_104'],UGLD_GOLDTEXT));
	echo "<div>\n";
	if ($exist != 0) {
		$result = dbquery("SELECT inv.ownerid, inv.itemid, it.name FROM ".DB_UG3_INVENTORY." AS inv, ".DB_UG3_USAGE." AS it WHERE inv.id = '".$giftid."' AND it.id = inv.itemid");
		$rowItem = dbarray($result);
		if ($rowItem['ownerid'] !== $userdata['user_id']) {
			die($locale['urg_donate_123']);
		}
		$result = dbquery(
			"SELECT g.owner_id
			FROM ".DB_UG3." g
			LEFT JOIN ".DB_USERS." u ON g.owner_id = u.user_id
			WHERE u.user_name='".$membername."'
			LIMIT 1"
		);
		//$result = dbquery("SELECT owner_id FROM ".DB_UG3." WHERE owner_name='".$membername."' LIMIT 1");
		$rowNewOwner = dbarray($result);
		$result = dbquery(
			"SELECT g.owner_id, u.user_name as owner_name
			FROM ".DB_UG3." g
			LEFT JOIN ".DB_USERS." u ON g.owner_id = u.user_id
			WHERE g.owner_id = '".$userdata['user_id']."'
			LIMIT 1"
		);
		//$result = dbquery("SELECT owner_name, owner_id FROM ".DB_UG3." WHERE owner_id='".$userdata['user_id']."' LIMIT 1");
		$rowCurrOwner = dbarray($result);
		if ($rowNewOwner['owner_id'] == $rowCurrOwner['owner_id']) {
			echo $locale['urg_donate_124'];
		} else {
			$result = dbquery("UPDATE ".DB_UG3_INVENTORY." SET ownerid = '".$rowNewOwner['owner_id']."' WHERE id = '".$giftid."' LIMIT 1");
			$subject = sprintf($locale['urg_donate_125'], $rowCurrOwner['owner_name']);
			$message = sprintf($locale['urg_donate_126'], $rowCurrOwner['owner_name'], $rowItem['name'], stripinput($_POST['message']), $settings['siteusername']);

			payuser($golddata['owner_id'], '5', 'karma');
			sendpm($rowNewOwner['owner_id'], $subject, $message, $rowCurrOwner['owner_id'], $rowCurrOwner['owner_name']);
			echo $locale['urg_donate_127'];
		}
	} else {
		echo $locale['urg_donate_132'];
	}
	echo "</div>\n";
	pagerefresh('meta',3,FUSION_SELF.'?op=donate_item_start');
	closetable();
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function donate_self_donate() {
	global $userdata, $locale, $golddata;
	table_top($locale['urg_donate_128']);
	echo "<table width='100%' cellpadding='5' cellspacing='0' border='0'>\n<tr valign='top'>\n";
	echo "<td style='width: 100%'>";
	$allgold = $golddata['cash'] + $golddata['bank'];
	if ($allgold <= UGLD_SELFDONATE_ALLOW) {
		$autodonate = rand(UGLD_SELFDONATE_MIN, UGLD_SELFDONATE_MAX);
		payuser($userdata['user_id'], $autodonate, 'cash');
		echo sprintf($locale['urg_donate_129'], formatMoney($autodonate));
		pagerefresh('meta','2',FUSION_SELF.'?op=start');
	} else {
		echo sprintf($locale['urg_donate_130'], formatMoney(UGLD_SELFDONATE_ALLOW), formatMoney($allgold));
		pagerefresh('meta','2',FUSION_SELF.'?op=start');
	}
	echo "</td>\n";
	echo "</tr>\n</table>\n";
	closetable();
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function donate_to_ribbon($userid) {
	global $HTTP_POST_VARS, $userdata, $locale, $settings, $golddata;
	$userid = stripinput($userid); 

	//donations once they reach 99,999,999.000.00 also get removed and rewarded with a medal
	$sql = dbquery("SELECT * FROM ".DB_UG3." WHERE owner_id = '".$userid."' LIMIT 1");
	$data = dbarray($sql);
	if ($data['donated'] >= UGLD_DONATE_RIBBON) {
		$donatetimes = floor($data['donated'] / UGLD_DONATE_RIBBON);
		$newdonate = $data['donated']-(UGLD_DONATE_RIBBON * $donatetimes);
		$newribbon = $data['ribbon'] + $donatetimes;
		dbquery("UPDATE ".DB_UG3." SET ribbon = '".$newribbon."', donated = '".$newdonate."' WHERE owner_id = '".$userid."' LIMIT 1");
	} else {
		//didnt donate enough yet
	}
}

function DonationToMedal($userid) {
	global $HTTP_POST_VARS, $userdata, $locale, $settings, $golddata;
	$userid = stripinput($userid);

	//donations once they reach 99,999,999.000.00 also get removed and rewarded with a medal
	$sql = dbquery("SELECT * FROM ".DB_UG3." WHERE owner_id = '".$userid."' LIMIT 1");
	$data = dbarray($sql);
	if($data['donated'] >= UGLD_DONATE_RIBBON) {
		$donatetimes = floor($data['donated'] / UGLD_DONATE_RIBBON);
		$newdonate = $data['donated'] - (UGLD_DONATE_RIBBON * $donatetimes);
		$newribbon = $data['ribbon'] + $donatetimes;
		dbquery("UPDATE ".DB_UG3." SET ribbon = '".$newribbon."', donated = '".$newdonate."' WHERE owner_id = '".$userid."' LIMIT 1");
	} else {
		//didnt donate enough yet
	}
}

?>