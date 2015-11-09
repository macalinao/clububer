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
| Filename: gamble.inc.php
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

if (file_exists(GOLD_LANG.LOCALESET."gamble.php")) {
	include GOLD_LANG.LOCALESET."gamble.php";
} else {
	include GOLD_LANG."English/gamble.php";
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function gamble_menu() {
	global $locale, $golddata;
	$account_total = $golddata['cash'] + $golddata['bank'];
	table_top($locale['urg_gamble_100']);
	echo "<table width='100%' cellpadding='3' cellspacing='3'class='tbl-border'>\n<tr>\n";
	echo "<td><h3>".$locale['urg_gamble_101a']."</h3></td>\n";
	echo "<td rowspan='3' align='right' valign='bottom'><img src='".GOLD_IMAGE."logo_gamble.png' alt='logo_gamble' /></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td>".sprintf($locale['urg_gamble_101b'],UGLD_GOLDTEXT)."</td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td>".$locale['urg_gamble_101c']."</td>\n";
	echo "</tr>\n</table>\n";
	
	echo "<div style='margin:5px'></div>\n";
	
	echo "<table width='100%' cellpadding='0' cellspacing='0'class='tbl-border'>\n<tr>\n";
	echo "<td class='tbl2'><a href='index.php?op=gamble_games'>".$locale['urg_gamble_103']."</a>\n";
	if(GLD_GAMBLE && $account_total <= UGLD_GAMBLE_ALLOW && $golddata['gamble'] < date('Ymd')) {
		echo " - <a href='index.php?op=gamble_gamble'>".$locale['urg_gamble_102']."</a><br />\n";
	}
	echo "</td>\n";
	echo "</tr>\n</table>\n";
	closetable();
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function gamble_gamble() { //Gamble for gold
	global $locale, $golddata, $userdata;

	if (isset($_POST['agree']) && isset($_POST['op'])) {
		$agree = $_POST['agree'];
		$op = $_POST['op'];
	}
	
	table_top($locale['urg_gamble_113']);
	echo "<table width='100%' cellpadding='5' cellspacing='0' border='0' class='tbl-border'>\n";
	echo "<tr valign='top' width='100%'>\n";
	echo "<td width='100%' align='center'>\n";
	if($golddata['gamble'] < date('Ymd')) {
		if(isset($agree) == '1') {
			if($golddata['cash'] + $golddata['bank'] < UGLD_GAMBLE_ALLOW) {
				//simple randomization of the difference between the two numers
				$amount = mt_rand(UGLD_GAMBLE_LOW, UGLD_GAMBLE_HIGH);
				//is it positive amount?
				if ($amount < 0) {
					$amountLoss = abs($amount);
					if ($golddata['cash'] > $amountLoss) {
						takegold2($userdata['user_id'], $amountLoss, 'cash', 1);
						echo $locale['urg_gamble_114'].formatMoney($amountLoss)."!\n";
						pagerefresh('meta','5',FUSION_SELF.'?op=gamble_menu');//show message
					} else {
						//do we need this? we now have the force and accountant so maybe can remove it?
						$result = db_query("UPDATE ".DB_UG3." SET bank = bank - ".$amountLoss." WHERE owner_id = '".$userdata['user_id']."' LIMIT 1");
						echo $locale['urg_gamble_114'].formatMoney($amountLoss).$locale['urg_gamble_116'];
					}
				} else {
					//$points = $golddata['cash'] + $amount;
					payuser($userdata['user_id'], $amount, 'cash');
					echo $locale['urg_gamble_115'].formatMoney($amount).'!';
					pagerefresh('meta','5',FUSION_SELF.'?op=gamble_menu');//show message
				}
			} else {
				echo $locale['urg_gamble_117'];
			}
			//timer for daily steal only
			dbquery("UPDATE ".DB_UG3." SET gamble = '".date('Ymd')."' WHERE owner_id = '".$golddata['owner_id']."' LIMIT 1");
		} else {

			if($golddata['cash'] + $golddata['bank'] < UGLD_GAMBLE_ALLOW) {
				echo "<form action='index.php' method='post'>\n";
				echo "<input type='hidden' name='op' value='gamble_gamble' />\n";
				echo $locale['urg_gamble_118'].formatMoney(UGLD_GAMBLE_LOW)."<br />\n";
				echo $locale['urg_gamble_119'].formatMoney(UGLD_GAMBLE_HIGH)."<br />\n";
				echo "<strong>".$locale['urg_gamble_120']."</strong>\n";
				echo "<input type='checkbox' name='agree' value='1' />&nbsp;\n";
				echo "&nbsp;<input class='button' type='submit' value='".$locale['urg_gamble_121']."' />\n";
				echo "</form>\n";
			} else {
				echo $locale['urg_gamble_117'];
			}
		}
	} else {
		echo $locale['urg_gamble_122'];
		pagerefresh('meta','5',FUSION_SELF.'?op=gamble_menu');//show message
	}
	
	echo "</td>\n";
	echo "</tr>\n</table>\n";
	closetable();
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function gamble_games() {
	global $locale;
	$temp = opendir(GOLD_GAMES);
	table_top($locale['urg_gamble_103']);

	echo $locale['urg_gamble_123']."<br />".sprintf($locale['urg_gamble_124'], strtolower(UGLD_GOLDTEXT))."<br />".$locale['urg_gamble_125']."<br /><hr /><br />\n";

	while ($folder = readdir($temp)) {
		if (!in_array($folder, array("..","."))) {
			if (is_dir(GOLD_GAMES.$folder) && file_exists(GOLD_GAMES.$folder."/play.php")) {
				include GOLD_GAMES.$folder."/play.php";
				echo "<hr />\n";
			}
		}
	}
	closedir($temp);
	closetable();
}
?>