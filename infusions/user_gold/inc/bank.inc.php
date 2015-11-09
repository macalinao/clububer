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
| Filename: bank.inc.php
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

if (file_exists(GOLD_LANG.LOCALESET."bank.php")) {
	include GOLD_LANG.LOCALESET."bank.php";
} else {
	include GOLD_LANG."English/bank.php";
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function bank_menu() { //Bank menu
	global $locale, $golddata, $userdata;
	table_top($locale['urg_bank_100']);
	echo "<table width='100%' cellpadding='3' cellspacing='3' class='tbl-border'>\n<tr>\n";
	echo "<td><h3>".$locale['urg_bank_101a']."</h3></td>\n";
	echo "<td rowspan='3' align='right' valign='bottom'><img src='".GOLD_IMAGE."logo_bank.png' alt='logo_bank' /></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td>".$locale['urg_bank_101b']."</td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td>".$locale['urg_bank_101c']."</td>\n";
	echo "</tr>\n</table>\n";
	
	echo "<div style='margin:5px'></div>\n";
	
	echo "<table width='100%' cellpadding='0' cellspacing='0' class='tbl-border'>\n<tr>\n";
	echo "<td class='tbl2'>\n";
	if (UGLD_BANK_ENABLED) {
		if (ItemOwned("GLD_BANK_ACCOUNT", $golddata['owner_id'])) {
			echo "<a href='index.php?op=bank_start'>".$locale['urg_bank_102']."</a>\n";
			$today = date('Ymd');
			if ($golddata['interest'] != $today) {
				echo " - <a href='index.php?op=bank_interest'>".$locale['urg_bank_103']."</a>\n";
			}
			// Removed for now
			//echo " - <a href='index.php?op=bank_transactions'>".$locale['urg_bank_124']."</a>\n";
		} else {
			echo buylink("GLD_BANK_ACCOUNT", $locale['urg_bank_125'], $locale['urg_bank_126'], urlencode(FUSION_SELF."?op=bank_menu"))."";
		}
	} else {
		echo $locale['urg_bank_127'];
	} 
	echo "</td>\n</tr>\n</table>\n";
	closetable();
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function bank_start() { //Bank start page
	global $locale, $golddata;
	if (!ItemOwned("GLD_BANK_ACCOUNT", $golddata['owner_id']) || !UGLD_BANK_ENABLED) { redirect(FUSION_SELF."?op=bank_menu"); }
	table_top(UGLD_BANK_NAME);
	echo "<table width='100%' cellpadding='3' cellspacing='3' class='tbl-border'>\n<tr>\n";
	echo "<td colspan='2'><h3>".sprintf($locale['urg_bank_105a'],UGLD_BANK_NAME)."</h3></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td colspan='2'>".sprintf($locale['urg_bank_105b'],UGLD_GOLDTEXT, "<strong>".UGLD_BANK_INTEREST."%</strong>")."</td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td width='130px'><u>".$locale['urg_bank_106']."</u></td>\n";
	echo "<td><strong>".formatMoney(UGLD_BANK_DEPOSIT_MIN)."</strong></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td width='130px'><u>".$locale['urg_bank_107']."</u></td>\n";
	echo "<td><strong>".formatMoney(UGLD_BANK_WITHDRAW_MIN)."</strong></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td colspan='2'>".sprintf($locale['urg_bank_104a'], "<strong>".formatMoney($golddata['bank'])."</strong>", "<strong>".formatMoney($golddata['cash'])."</strong>")."</td>\n";
	echo "</tr>\n</table>\n";
	
	echo "<div style='margin:5px'></div>\n";

	echo "<table width='100%' cellpadding='0' cellspacing='0' class='tbl-border'>\n<tr>\n";
	echo "<td class='tbl2'>".sprintf($locale['urg_bank_104b'],UGLD_GOLDTEXT)."</td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td class='tbl2'>\n";
	echo "<form action='index.php' method='post'>\n";
	echo "<input type='hidden' name='op' value='bank_complete' />\n";
	echo "<select name='type' class='textbox'>\n";
	echo "<option value='' selected='selected'>".$locale['urg_bank_108']."</option>\n";
	echo "<option value='deposit'>".$locale['urg_bank_109']."</option>\n";
	echo "<option value='withdraw'>".$locale['urg_bank_110']."</option>\n";
	echo "</select>\n";
	echo "&nbsp;&nbsp;".$locale['urg_bank_112']."&nbsp;".UGLD_CURRENCY_PREFIX." <input type='text' name='amount' size='5' class='textbox' />".UGLD_CURRENCY_SUFFIX."\n";
	echo "&nbsp;<input class='button' type='submit' value='".$locale['urg_bank_111']."' />\n";
	echo "</form>\n";
	echo "</td>\n";
	echo "</tr>\n</table>\n";
	closetable();
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function bank_complete() { //Finalize transactions at the bank
	global $userdata, $locale, $golddata;
	if (!ItemOwned("GLD_BANK_ACCOUNT", $golddata['owner_id']) || !UGLD_BANK_ENABLED) { redirect(FUSION_SELF."?op=bank_menu"); }
	$erro = '';
	table_top($locale['urg_bank_121']);
	echo "<div>\n";
	if($_POST['type'] == "" ||$_POST['amount'] == "") {
		echo $locale['urg_bank_113'];
		$erro = '1';
	} elseif ($_POST['type'] == "deposit") {
		$_POST['amount'] = (int) $_POST['amount'];
		if ($_POST['amount'] > $golddata['cash']) {
			echo $locale['urg_bank_114'];
			$erro = '1';
		} elseif ($_POST['amount'] <= 0) {
			echo $locale['urg_bank_115'];
			$erro = '1';
		} elseif ($_POST['amount'] < UGLD_BANK_DEPOSIT_MIN) {
			echo sprintf($locale['urg_bank_116'], formatMoney(UGLD_BANK_DEPOSIT_MIN));
			$erro = '1';
		} elseif ($_POST['amount']+$golddata['bank'] > 9999999.99 ) {
			echo sprintf($locale['urg_bank_131'], UGLD_GOLDTEXT);
			$erro = '1';
		} else {
			takegold2($userdata['user_id'], $_POST['amount'], 'cash');
			payuser($userdata['user_id'], $_POST['amount'], 'bank');
			echo sprintf($locale['urg_bank_117'], formatMoney($golddata['bank']+$_POST['amount']), formatMoney($golddata['cash']-$_POST['amount']))."<br />";
		}
	} elseif ($_POST['type'] == "withdraw") {
		$_POST['amount'] = (int) $_POST['amount'];
		if ($_POST['amount'] > $golddata['bank']) {
			echo sprintf($locale['urg_bank_118'], UGLD_BANK_NAME);
			$erro = '1';
		} elseif ($_POST['amount'] <= 0) {
			echo $locale['urg_bank_115'];
			$erro = '1';
		} elseif ($_POST['amount'] < UGLD_BANK_WITHDRAW_MIN) {
			echo sprintf($locale['urg_bank_116'], formatMoney(UGLD_BANK_WITHDRAW_MIN));
			$erro = '1';
		} else {
			takegold2($userdata['user_id'], $_POST['amount'], 'bank');
			payuser($userdata['user_id'], $_POST['amount'], 'cash');
			echo sprintf($locale['urg_bank_119'], formatMoney($golddata['cash']+$_POST['amount']), formatMoney($golddata['bank']-$_POST['amount']))."<br />";
		}
	} else {
		echo $locale['urg_bank_120'];
	}

	unset($_REQUEST['amount'], $_REQUEST['type'], $_REQUEST['op']);
	if ($erro == '1') {
		pagerefresh('meta','2',FUSION_SELF.'?op=bank_start');//show message
	} else {
		pagerefresh('java','0',FUSION_SELF.'?op=bank_start');//just go
	}
	echo "</div>\n";
	closetable();
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function bank_interest() { //Collect the interest
	global $locale, $golddata;
	if (!ItemOwned("GLD_BANK_ACCOUNT", $golddata['owner_id']) || !UGLD_BANK_ENABLED) { redirect(FUSION_SELF."?op=bank_menu"); }
	$today = date('Ymd');
	table_top($locale['urg_bank_128']);
	echo "<div>\n";	
	if ($golddata['interest'] != $today) {
		$interest_rate = UGLD_BANK_INTEREST / 100;
		$newtotal = $golddata['bank'] * $interest_rate;
		payuser($golddata['owner_id'], $newtotal, 'bank');
		dbquery("UPDATE ".DB_UG3." SET interest = '".$today."' WHERE owner_id = '".$golddata['owner_id']."' LIMIT 1");
		echo sprintf($locale['urg_bank_122'], formatMoney($newtotal), date("d/m/Y h:i:s A"));
	} else {
		echo $locale['urg_bank_123'];
	}
	echo "</div>\n";
	pagerefresh('meta','2',FUSION_SELF.'?op=bank_menu');
	closetable();
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function bank_transactions() { //View all the transactions for the user
	global $locale, $golddata, $userdata;
	table_top($locale['urg_bank_124']);
	echo "<table width='100%' cellpadding='3' cellspacing='3' class='tbl-border'>\n<tr>\n";
	echo "<td><strong>".$locale['urg_bank_129']."</strong></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td>\n";
	include GOLD_CHARTS."income_chart.php";
	echo "</td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td><strong>".$locale['urg_bank_130']."</strong></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td>\n";
	include GOLD_CHARTS."outcome_chart.php";
	echo "</td>\n";
	echo "</tr>\n</table>\n";
	closetable();
}
?>