<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| UG Lottery Panel
| Copyright © 2007 - 2008 Stephan Hansson (StarglowOne)
| http://www.starglowone.com/
+--------------------------------------------------------+
| Filename: ug_lottery_panel.php
| Author: Stephan Hansson (StarglowOne)
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

include INFUSIONS."ug_lottery_panel/infusion_db.php";

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."ug_lottery_panel/locale/".$settings['locale'].".php")) {
	// Load the locale file matching the current site locale setting.
	include INFUSIONS."ug_lottery_panel/locale/".$settings['locale'].".php";
} else {
	// Load the infusion's default locale file.
	include INFUSIONS."ug_lottery_panel/locale/English.php";
}

global $locale;
// Check if lottery time is met
$result = dbquery("SELECT * FROM ".DB_UG_LOTTERY_DRAWINGS." ORDER BY draw_id DESC LIMIT 0,1");
$data = dbarray($result);
$numrows = dbrows($result);
//$timediff = (time()-$data['endtime']);
//if($timediff >= UGLY_DEFAULT_START_NEW_DRAW) {
if (($data['endtime']+UGLY_DEFAULT_START_NEW_DRAW) < time()) { 
$endtime = (time()+UGLY_DEFAULT_ENDTIME);
	$result = dbquery("INSERT INTO ".DB_UG_LOTTERY_DRAWINGS." (draw_id, lots, lot_price, prize, endtime, ended, prize_winner_name, prize_winner_id, lot_amnt, jtype) VALUES ('', '".UGLY_DEFAULT_AMOUNT."', '".UGLY_DEFAULT_PRICE."', '".UGLY_DEFAULT_JACKPOT."', '".$endtime."', '0', '', '', '".UGLY_DEFAULT_AMOUNT."', '".strtolower(UGLY_DEFAULT_TYPE)."')");
}
if($numrows != '0') {
	if($data['endtime'] <= time() && $data['ended'] == 0) { // if so, get how many tickets were bought
		$check = dbquery("SELECT * FROM ".DB_UG_LOTTERY_LOTS." WHERE lot_draw='".$data['draw_id']."'");
		if(dbrows($check) >= 2) { // make sure it's more than 1 ticket
			// get the number to start/end at for the rnd() number
			$start = dbarray(dbquery("SELECT * FROM ".DB_UG_LOTTERY_LOTS." WHERE lot_draw='".$data['draw_id']."' ORDER BY lot_id ASC LIMIT 0,1"));
			$start = $start['lot_id'];
			$end = dbarray(dbquery("SELECT * FROM ".DB_UG_LOTTERY_LOTS." WHERE lot_draw='".$data['draw_id']."' ORDER BY lot_id DESC LIMIT 0,1"));
			$end = $end['lot_id'];
			$pick = rand($start, $end); // alright, pick the number!!
			$check = dbarray(dbquery("SELECT * FROM ".DB_UG_LOTTERY_LOTS." WHERE lot_id='".$pick."' AND lot_draw='".$data['draw_id']."'")); // check who's ticket it is
			$winner_id = $check['lot_owner'];
			$winner_name = $check['lot_owner_name'];
			$prize = $data['prize'];
			$jtype = $data['jtype'];
			
			/*sendpm('1', '2', '3', '4', '5');
			1 = $pmtoid / The user_id of the person the message is sent to
			2 = $subject / The subject to be used in the message
			3 = $message / The message content
			4 = $pmfromid / The user_id of the person sending the message (0 for site)
			5 = $pmfromname / the user_name of the person sending the message.*/
			
			if(UGLY_SEND_ADMIN_PM) { // send a PM to the Site Owner
				sendpm('1', $locale['ugly_300'], sprintf($locale['ugly_301'], $winner_name), '0', sprintf($locale['ugly_307'], $settings['siteusername']));
			}	
			if(UGLY_SEND_WINNER_PM) { // send a PM to the WINNER
				sendpm($winner_id, sprintf($locale['ugly_302'], $winner_name), sprintf($locale['ugly_305'], $winner_name, $prize, $jtype), '0', sprintf($locale['ugly_307'], $settings['siteusername']));
			}
			if($jtype == 'cash' OR $jtype == 'chips' OR $jtype == 'karma') { //update cash or chips or karma amount if type is cash or chips or karma
				payuser($winner_id, $prize, $type=$jtype);
			}
			if($jtype == 'ribbon') { //update ribbon amount if prize is ribbon
				payuser($winner_id, $prize, $type=$jtype);
			}
			// make it so drawing won't be checked again
			$result = dbquery("UPDATE ".DB_UG_LOTTERY_DRAWINGS." SET ended='1', prize_winner_name='".$winner_name."', prize_winner_id='".$winner_id."' WHERE draw_id='".$data['draw_id']."'");
			$dellots = dbquery("DELETE FROM ".DB_UG_LOTTERY_LOTS." WHERE lot_draw='".$data['draw_id']."'");	
		} else {
			if(UGLY_SEND_NOT_ENOUGH_TICKETS_PM) { // PM site owner that there weren't enough tickets to pick a person
				sendpm('1', $locale['ugly_303'], $locale['ugly_304'], '0', sprintf($locale['ugly_307'], $settings['siteusername']));
			}	
			// make it so drawing won't be checked again
			$result = dbquery("UPDATE ".DB_UG_LOTTERY_DRAWINGS." SET ended='1', prize_winner_name='".$locale['ugly_308']."', prize_winner_id='0' WHERE draw_id='".$data['draw_id']."'");
			$dellots = dbquery("DELETE FROM ".DB_UG_LOTTERY_LOTS." WHERE lot_draw='".$data['draw_id']."'");
		}
	}
} else {
	//do nothing
}
?>