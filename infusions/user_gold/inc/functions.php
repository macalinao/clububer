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
| Filename: functions.php
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

include_once INFUSIONS."user_gold/infusion_db.php";
include_once INFUSIONS."user_gold/inc/dbcalls.inc.php";
require_once INCLUDES."output_handling_include.php";
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
/*							General	Definitions							*/
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
/* We need to check that the gold table is actually there before allowing the gold system to be active */
function gold_table_exists($table_name) {
	$Table = mysql_query("show tables like '".$table_name."'");

	if (mysql_fetch_row($Table) === false) {
		return(false);
		exit;
	} else {
		return(true);
		exit;
	}
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
/*					Get Global settings for gold system.				*/
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
if (gold_table_exists(DB_UG3)) {
	//ok table is there so we get the data from all areas
	//colect definitions that are allways available (Non Purchase items)
	//main settings
	$sql1 = dbquery("SELECT name, value FROM ".DB_UG3_SETTINGS);
	while($row1 = dbarray($sql1)) {
		$defchecked1 = eregi_replace(' ', '_', strtoupper($row1['name']));
		define($defchecked1 , $row1['value']);//turn the result into an available definition
	}
	//free or admin settings items
	//With these we still need to have them defined so they are allways called
	//if the value is zero they are turned off so everything should be fine
	$sql2 = dbquery("SELECT name, cost FROM ".DB_UG3_USAGE." WHERE active = '1'");
	while($row2 = dbarray($sql2)) {
		$defchecked2 = eregi_replace(' ', '_', strtoupper($row2['name']));
		define($defchecked2 , $row2['cost']);//turn the result into an available definition
	}
} else {
	define("USERGOLD", FALSE); //Table is not there above is cancelled!!
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
/*					Constants definitions for directories				*/
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
define("GOLD_DIR", BASEDIR."infusions/user_gold/");
define("GOLD_ADMIN", GOLD_DIR."admin/");
define("GOLD_LANG", GOLD_DIR."locale/");
define("GOLD_INC", GOLD_DIR."inc/");
define("GOLD_CHARTS", GOLD_DIR."inc/charts/");
define("GOLD_GAMES", GOLD_DIR."games/");
define("GOLD_IMAGE", GOLD_DIR."images/");
define("GOLD_IMAGE_ITEM", GOLD_DIR."images/item_images/");
define("GOLD_IMAGE_CAT", GOLD_DIR."images/categories/");
define("GOLD_TEMPLATE", GOLD_DIR."templates/");
define("GOLD_VERSION", '3.0.1');
define("DEBUG", '0');

define("UGLD_BANKLINK", '<a href="'.GOLD_DIR.'index.php?op=bank_start">'.(defined("UGLD_BANK_NAME") ? UGLD_BANK_NAME : "UG3 Bank").'</a>');
/*if (USERGOLD) {
define("UGLD_BANKLINK", "<a href='".GOLD_DIR."index.php?op=bank_start'>".UGLD_BANK_NAME."</a>");
}*/
if(DEBUG && iSUPERADMIN) {
	error_reporting(E_ALL); //all errors for super
} else {
	error_reporting(7); //minimal for admins or lower
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
/*					JavaScript used by the UserGold 3					*/
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
add_to_head('<script type="text/javascript">
	<!--
	var spe = 1000;
	var na = document.getElementsByTagName("blink");
	var swi = 1;
	bringBackBlinky();
	
	function bringBackBlinky() {
		if (swi == 1) {
			sho = "visible";
			swi = 0;
		} else {
			sho = "hidden";
			swi = 1;
		}
	
		for(i = 0; i < na.length; i++) {
			na[i].style.visibility = sho;
		}
	
		setTimeout("bringBackBlinky()", spe);
	}
	-->
</script>');

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
/*							Load Language								*/
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
if (file_exists(GOLD_LANG.LOCALESET."functions.php")) {
	include_once GOLD_LANG.LOCALESET."functions.php";
} else {
	include_once GOLD_LANG."English/functions.php";
}

if (file_exists(GOLD_LANG.LOCALESET."global.php")) {
	include GOLD_LANG.LOCALESET."global.php";
} else {
	include GOLD_LANG."English/global.php";
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
/*							Load Template								*/
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
if (file_exists(GOLD_TEMPLATE.UGLD_TEMPLATE."/template.php")) {
	include GOLD_TEMPLATE.UGLD_TEMPLATE."/template.php";
} else {
	include GOLD_TEMPLATE."default/template.php";
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
/*	Trim Sting Function - Cuts the given string to a certain length 	*/
/*	without breaking a word												*/
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function trimString($string, $length, $more='', $morewhere='') {
	if (isset($string)) {
		$trimmed = str_replace('<br />', '... ', ereg_replace('(<br />)+', '<br />', $string));
		$trimmed = strip_tags($trimmed);
		if (strlen($trimmed) > $length) {
			$trimmed = substr($trimmed, 0, strrpos(substr($trimmed, 0, $length), ' '));
			if ($more != '') {
				$trimmed .= '<a href="'.$morewhere.'">'.$more.'</a>';
			}
		}
		return $trimmed;
	}
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
/* last minute inclusion to get panels available anywhere 				*/
/* DO NOT ALTER!														*/
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
include_once (GOLD_INC."panels.inc.php");


/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
/*						Get the current users info						*/
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
if (iMEMBER && USERGOLD) {
	//Check if current user is in the DB_UG3 table
	$check = dbquery("SELECT owner_id FROM ".DB_UG3." WHERE owner_id = '".$userdata['user_id']."' LIMIT 1");
	if (!dbrows($check) && (!FUSION_SELF == "install.php")) {
		//If not, we create the user
		create_user($userdata['user_id'], UGLD_REGISTER, 'cash');
	}
	//Lest get the data for the current user
	$result = dbquery("SELECT * FROM ".DB_UG3." WHERE owner_id = '".$userdata['user_id']."' LIMIT 1");
	$golddata = dbarray($result);
	
	//Backwords compabillity
	$golddata['owner_name'] = $userdata['user_name'];
	
	if (!empty($golddata['items'])) {
		$item = explode(":", $golddata['items']);
		for($i=0; $i < count($item); $i++) {
			$golddata[$item[$i]] = $item[$i];
		}
	}
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
/*						Backwards compatibility							*/
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function getallgold($user_id) { //Get the users gold total
	getusergold($user_id, 'cash');
}

function paygold($user_name, $user_id, $points) { //Pay user gold
	payuser($user_id, $points, 'cash');
}

function takegold($user_name,$user_id,$points) { //Take gold from user
	takegold2($user_id, $points, 'cash');
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
/*						Used for page redirection						*/
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function pagerefresh($method,$time,$location) {
	if ($method == 'meta') {
		echo "<br /><br /><div align='center'><img src='".GOLD_IMAGE."pagerefresh.gif' alt='*' title='*' /></div>";
		header('refresh: '.$time.'; url='.$location.''); 
	} elseif ($method == 'java') {
		echo "<br /><br /><div align='center'><img src='".GOLD_IMAGE."pagerefresh.gif' alt='*' title='*' /></div>";
		echo "<script>window.location = '".$location."';</script>";
	} else {
		//Do nothing
	}
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
/*				Used for creation of the navigation table top			*/
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function table_top($name) { 	
	global $locale;
	$top = '<form action="'.GOLD_DIR.'index.php" method="post" target="_self">';
	$top .= '<table width="100%" cellpadding="0" cellspacing="0" border="0">';
	$top .= '<tr>';
	$top .= '<td width="75%"><strong>'.$name.'</strong></td>';
	$top .= '<td width="20%"><select name="op" class="textbox" onchange="submit()">';
	$top .= '<option>'.$locale['urg_functions_101'].'</option>';
	$top .= '<option value="">'.$locale['urg_functions_102'].'</option>';
	if (UGLD_BANK_ENABLED) {
		$top .= '<option value="bank_menu">'.$locale['urg_functions_119'].'</option>';
	}
	$top .= '<option value="shop_menu">'.$locale['urg_functions_103'].'</option>';
	$top .= '<option value="trade_start">'.$locale['urg_functions_104'].'</option>';
	$top .= '<option value="donate_centre_start">'.$locale['urg_functions_105'].'</option>';
	$top .= '<option value="gamble_menu">'.$locale['urg_functions_106'].'</option>';
	$top .= '<option value="member_menu">'.$locale['urg_functions_107'].'</option>';
	$top .= '<option value="user_menu">'.$locale['urg_functions_108'].'</option>';
	$top .= '</select></td>';
	$top .= '<td style="width: 5%; text-align: right;"><input class="button" type="button" value="'.$locale['urg_functions_100'].'" onclick="history.back()" /></td>';
	$top .= '</tr>';
	$top .= '</table>';
	$top .= '</form>';
	opentable($top);
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
/*					Used for sending private messages					*/
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function sendpm($pmtoid, $subject, $message, $pmfromid, $pmfromname) { 
	$pmtoid = stripinput($pmtoid);
	$subject = stripinput($subject);
	$pmfromid = stripinput($pmfromid);
	$pmfromname = stripinput($pmfromname);
	$message = descript($message);
	
	dbquery("INSERT INTO ".DB_MESSAGES." (message_id, message_to, message_from, message_subject, message_message, message_smileys, message_read, message_datestamp, message_folder) VALUES ('', '".$pmtoid."', '".$pmfromid."', '".$subject."', '".$message."', '0', '0', '".time()."', '0')");
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
/*					Used for sending welcome message					*/
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function sendwelcomepm($id) {
	global $settings;
	
	$wpmq = dbquery("SELECT * FROM ".DB_USERS." WHERE user_id = '".$id."'");
	$wpmd = dbarray($wpmq);
	if (UGLD_WELCOME_PM == '1') {
		$subject = UGLD_WELCOME_PM_SUBJECT;
		$message = sprintf(UGLD_WELCOME_PM_MESSAGE,$wpmd['user_name']);
		sendpm($wpmd['user_id'], $subject, $message, '0', $settings['siteusername']);
	}	
	if (USERGOLD && UGLD_REGISTER) {
		payuser($wpmd['user_id'], UGLD_REGISTER, 'cash');
	}
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
/*					Write information to the transaction db				*/
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function transaction($user_id, $status, $type, $value) {
	
	//Status: 1 = Take
	//Status: 2 = Give
	
	$user_id = stripinput($user_id);
	$status = stripinput($status);
	$type = stripinput($type);
	$value = stripinput($value);	
	
	$sqlo = dbquery("INSERT INTO ".DB_UG3_TRANSACTIONS." (transaction_user_id, transaction_status, transaction_type, transaction_value) VALUES ('".$user_id."', '".$status."', '".$type."', '".$value."')");	
	//Make timestamp 30 days ago
	$timestamp = time()-2592000;

	//Make correct date format for the timestamp
	$format = "Y-m-d H:i ";
	$date = date($format, $timestamp);
	//dbq - Check number of transactions older than old date and delete them
	$result = dbquery("DELETE FROM ".DB_UG3_TRANSACTIONS." WHERE transaction_timestamp < $date");
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
/*					Used for taking from the listed user				*/
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function takegold2($user_id, $points, $type="cash", $force="0") {
	global $locale;

	$user_id = stripinput($user_id);
	$type = stripinput($type);
	$points = stripinput($points);
	
	//Allow admins to take gold even when they are broke
	if (iADMIN && $force == "1") { $forceit = "1"; } else {	$forceit = "0";	}
	
	if ((getusergold($user_id, $type) < $points) && $forceit == "0") {
		opentable($locale['urg_functions_109']);
		echo $locale['urg_functions_110'];
		closetable();
		exit;
	} else {
		$resultf = dbquery("SELECT owner_id FROM ".DB_UG3." WHERE owner_id = '".$user_id."' LIMIT 1");
		if (dbrows($resultf)) {
			
			// Removed for now
			//transaction($user_id, 1, $type, $points);
			
			$sqlo = dbquery("UPDATE ".DB_UG3." SET ".$type."=".$type."-".$points." WHERE owner_id = '".$user_id."' LIMIT 1");
		}
	}
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
/*						Used for paying the listed user					*/
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function payuser($user_id, $points, $type="cash") {
	$user_id = stripinput($user_id);
	$type = stripinput($type);
	$points = stripinput($points);
	
	if (isnum($user_id)) {
		$result = dbquery("SELECT owner_id FROM ".DB_UG3." WHERE owner_id = '".$user_id."' LIMIT 1");
		if (dbrows($result)) {
			// Removed for now
			//transaction($user_id, 2, $type, $points);
			
			$sqld = dbquery("UPDATE ".DB_UG3." SET ".$type."=".$type."+".$points." WHERE owner_id = '".$user_id."' LIMIT 1");
		} else {
			//$cash = UGLD_REGISTER + $points;
			//create_user($user_id, $cash);
			create_user($user_id, UGLD_REGISTER);
			payuser($user_id, $points, $type);
		}
	}
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
/*			Format the currency result (Use only for display)			*/
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function formatMoney($money) {
	$money = stripinput($money);
	
	if ($money < '0') {
		$formatted = UGLD_CURRENCY_PREFIX.'<font style="text-decoration: line-through; color: red;">'.number_format($money, UGLD_DECIMAL, UGLD_DECPOINT, UGLD_THOUSANDS).'</font>'.UGLD_CURRENCY_SUFFIX;
	} else {
		$formatted = UGLD_CURRENCY_PREFIX.number_format($money, UGLD_DECIMAL, UGLD_DECPOINT, UGLD_THOUSANDS).UGLD_CURRENCY_SUFFIX;
	}
	return $formatted;
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
/*					Check actual ownership of an item					*/
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function ItemOwned($item,$userid) { 
	$item = stripinput($item);
	$userid = stripinput($userid);	
	$res5 = dbquery("SELECT id FROM ".DB_UG3_INVENTORY." WHERE ownerid = '".$userid."' AND itemname = '".$item."' AND trading = '0' LIMIT 1");
	if (dbrows($res5)) {
		return true;
	} else {
		return false;
	}
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
/*					Create a buy link for an listed item				*/
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function buylink($item, $link='', $text='', $return='') {
	$item = stripinput($item);
	$sql3 = dbquery("SELECT id, cost FROM ".DB_UG3_USAGE." WHERE name = '".$item."' LIMIT 1");
	if (dbrows($sql3)) {
		$result = dbarray($sql3);
		$link = '<a href="'.GOLD_DIR.'index.php?op=shop_finalise&amp;id='.$result['id'].($return != '' ? '&amp;return='.$return : '').'">'.$link.' ['.UGLD_CURRENCY_PREFIX.''.$result['cost'].' '.UGLD_GOLDTEXT.']</a>';
		echo sprintf('%s %s',$text,$link);
	}
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
/*					Check to see that an item is active					*/
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function ActiveItemCheck($item) { 
	$item = stripinput($item);
	$sql = dbquery("SELECT id FROM ".DB_UG3_USAGE." WHERE name = '".$item."' AND active = '1' LIMIT 1");
	if ($sql && USERGOLD) {
		return true;
	} else {
		return false;
	}
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
/*								Activity Check							*/
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function activity_check($gold,$userid) { 
// NOTES
// This should not be used unless required to get a check on someone who is not the current user!!
// Information for the current user is available from
// $golddata[cash],$golddata[bank],$golddata[chips],$golddata[karma] etc.

	global $locale;
	$mygold = getusergold($userid, 'all');
	if ($mygold < $gold) {
		opentable($locale['urg_functions_111']);
		echo $locale['urg_functions_112'];
		closetable();
		include "footer.php";
		die();
	}//$mygold < $gold
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
/*				Get the amount of anything a listed user has.			*/
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function getusergold($user, $type="all") { 
	global $locale;
	$user = stripinput($user);
	$type = stripinput($type);
		
	//safty for incomplete details of user
	if (empty($user)) {
		echo $locale['urg_functions_113'];
	} elseif (!isnum($user)) {
		$id_query = dbquery("SELECT user_id FROM ".DB_USERS." WHERE user_name = '".$user."' LIMIT 1");
		if (dbrows($id_query)) {
			$id_result = dbarray($id_query);
			$user = $id_result['user_id'];
		} else {
			$user = "";
		}
	}
		
	if ($type == "all") { $type="cash , bank"; }

	$sql = "SELECT ".$type." FROM ".DB_UG3." WHERE owner_id = '".$user."' LIMIT 1";
	$query = dbquery($sql);
	$usergold = dbarray($query);
	
	//Figure out what to return
	if ($type == "cash , bank") { 
		$current = $usergold['bank'] + $usergold['cash'];
	} elseif ($type == 'bank') { 
		$current = $usergold['bank'];
	} elseif ($type == 'cash') { 
		$current = $usergold['cash'];
	} elseif ($type == 'karma') { 
		$current = $usergold['karma'];
	} elseif ($type == 'chips') { 
		$current = $usergold['chips'];
	} elseif ($type == 'donated') { 
		$current = $usergold['donated'];
	} elseif ($type == 'ribbon') { 
		$current = $usergold['ribbon'];
	} else {
		$current = "";
	}

	if ($current <= '0' || $current == '0' || !$current) {
		$gold = 0; //do not format here may be used in queries
	} else {
		$gold = $current; //do not format here may be used in queries
	}
	return $gold;
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
/*						Shows usernames in color etc.					*/
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function goldmod_user($userid,$username) { 
	global $userdata;
	$userid = stripinput($userid);
	$username = stripinput($username);
	
	$item = dbquery("SELECT itemname FROM ".DB_UG3_INVENTORY." WHERE ownerid = '".$userid."' AND trading = '0' GROUP BY itemname");

	$link = $username;
	if (USERGOLD) {
		while ($check = dbarray($item))	{
			if ($check['itemname'] == "GLD_USERNAME_ITALIC")	{
				$link = "<i>$link</i>";
			}
			
			if ($check['itemname'] == "GLD_USERNAME_COLOR") {
				$result = dbquery("SELECT * FROM ".DB_UG3." WHERE owner_id = '$userid'");
				$goldlinkdata = dbarray($result);
				$link = "<span style='color: ".$goldlinkdata['username_color'].";'>$link</span>";
			}
			
			if (!ItemOwned("GLD_USERNAME_BLINK_BLOCK", $userdata['user_id'])) {
				if ($check['itemname'] == "GLD_USERNAME_BLINK") {
					$link = "<blink>$link</blink>";
				}
			}
			
			if ($check['itemname'] == "GLD_USERNAME_BOLD") {
				$link = "<strong>$link</strong>";
			}
			
			if ($check['itemname'] == "GLD_USERNAMESRIKE") {
				$link = "<strike>$link</strike>";
			}
		}
		return $link;
	}
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
/*	Use to count the words or characters when paying for writing text	*/
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function textPayout($text, $base, $type='word') { 
	if ($type == 'char') {
		$count_message = strlen($text);
	} else {
		$count_message = str_word_count($text);
	}

	if ($count_message <= '5') { 
		$payout = $base / $base;
	} elseif ($count_message >= '5' && $count_message <= '20' ) { 
		$payout = $base / 2;
	} elseif ($count_message <= '49' && $count_message >= '21') { 
		$payout = $base;
	} elseif ($count_message >= '50') { 
		$payout = $base * 2;
	} else { 
		$payout = $base; 
	}

	payuser($userdata['user_id'], $payout, 'cash');
	return $payout;
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
/*	Use to count the words or characters when taking for deleting text	*/
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function textcharge($userid, $text, $base, $type='word') { 
	if ($type == 'char') {
		$count_message = strlen($text);
	} else {
		$count_message = str_word_count($text);
	}

	if ($count_message <= '5') { 
		$charge = $base / $base;
	} elseif ($count_message >= '5' && $count_message <= '20' ) { 
		$charge = $base / 2;
	} elseif ($count_message <= '49' && $count_message >= '21') { 
		$charge = $base;
	} elseif ($count_message >= '50') { 
		$charge = $base * 2;
	} else { 
		$charge = $base; 
	}

	takegold2($userid, $charge, 'cash');
	return $charge;
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
/*							Shows a users ribbons.						*/
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function showribbons($userid, $text=false) {
	global $userdata, $locale, $settings, $golddata;
	$userid = stripinput($userid);
	$sql = dbquery("SELECT ribbon,donated FROM ".DB_UG3." WHERE owner_id = '".$userid."' LIMIT 1");
	$data = dbarray($sql);

	$num_gif = preg_split('//', $data['ribbon'], -1, PREG_SPLIT_NO_EMPTY);
	if ($data['ribbon'] <= 0) {
		$ribbon = "<img src='".GOLD_DIR."images/ribbons/blank.gif' alt='".sprintf($locale['urg_functions_114'], $data['ribbon'])."' title='".sprintf($locale['urg_functions_114'], $data['ribbon'])."' />";
		if (iMEMBER && ($userdata['user_id'] == $userid) && ($text == true)) {
			$need = UGLD_DONATE_RIBBON - $data['donated'];
			$ribbon = "<a href='".INFUSIONS."user_gold/index.php?op=donate_gold_start'>".sprintf($locale['urg_functions_115'], UGLD_GOLDTEXT, formatMoney($need))."</a>";
		}
	} else {
		$i = 0;
		$ribbon = "";
		while($i < count($num_gif)) {
			$need = UGLD_DONATE_RIBBON - $data['donated'];
			$ribbon .= "<img src='".GOLD_DIR."images/ribbons/".$num_gif[$i].".gif' alt='".sprintf($locale['urg_functions_114'], $data['ribbon'])."' title='".sprintf($locale['urg_functions_114'], $data['ribbon'])."' />";
			$i++;
		}
		
		if (iMEMBER && ($userdata['user_id'] == $userid) && ($text == true)) {
			$ribbon .= "<a href='".INFUSIONS."user_gold/index.php?op=donate_gold_start'>".sprintf($locale['urg_functions_116'], formatMoney($need))."</a>";
		}
	}
	return $ribbon;
}


/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
/*		Creates a user in user_gold table if user do not exist			*/
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function create_user($new_id, $cash, $type="cash") {
	$sqld = dbquery("SELECT * FROM ".DB_UG3." LIMIT 1");
	$sqlx = "INSERT INTO ".DB_UG3." (";
	for ($i = 0; $i < @mysql_num_fields($sqld); $i++) {
		$sqlx .= @mysql_field_name($sqld, $i);
		if ($i != @mysql_num_fields($sqld)-1) {
			$sqlx .= ", ";
		}
	}
	$sqlx .= ") VALUES (";
	for ($z = 0; $z < @mysql_num_fields($sqld); $z++) {
		$field_name = mysql_field_name($sqld, $z);
		if ($field_name == 'owner_id')	{
			$sqlx .= " '".$new_id."'";
		} elseif($field_name == $type) {
			$sqlx .= " '".$cash."'";
		} else {
			$sqlx .= " ''";
		}
		
		if ($z != @mysql_num_fields($sqld)-1) {
			$sqlx .= ",";
		}
	}
	$sqlx .= ");";
	dbquery($sqlx);
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
/*						Shows the userlevel for a user.					*/
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function ug_userlevel($userid) {
	$result = dbquery("SELECT userlevel FROM ".DB_UG3." WHERE owner_id = '$userid' LIMIT 1");
	$goldleveldata = dbarray($result);
	$level = $goldleveldata['userlevel'];
	return $level;
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
/*						List categories as an array						*/
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function getcats() {
	$categories_array = array();
	$csql = dbquery("SELECT cat_id,cat_name FROM ".DB_UG3_CATEGORIES." WHERE ".groupaccess("cat_access")." ORDER BY cat_name ASC");
	while ($cdata = dbarray($csql)) {
		array_push($categories_array, array($cdata['cat_id'], $cdata['cat_name']));
	}
	return $categories_array;
}

?>