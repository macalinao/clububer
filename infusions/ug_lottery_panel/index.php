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
| Filename: index.php
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
require_once "../../maincore.php";
require_once THEMES."templates/header.php";

include INFUSIONS."ug_lottery_panel/infusion_db.php";

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."ug_lottery_panel/locale/".$settings['locale'].".php")) {
	// Load the locale file matching the current site locale setting.
	include INFUSIONS."ug_lottery_panel/locale/".$settings['locale'].".php";
} else {
	// Load the infusion's default locale file.
	include INFUSIONS."ug_lottery_panel/locale/English.php";
}

//definately must be a member to access this area!!
if (!iMEMBER) {	redirect("../../index.php");´exit; }

opentable($locale['ugly_100'].": ".$locale['ugly_200']);
//choose the correct banner depening on language settings
echo "<div align='center'>\n";
if (file_exists("images/banners/".$settings['locale']."_ug_lottery.jpg")) {
	echo "<img src='images/banners/".$settings['locale']."_ug_lottery.jpg' title='".$locale['ugly_100']."' alt='".$locale['ugly_100']."' />\n";
} else {
	echo "<img src='images/banners/English_ug_lottery.jpg' title='".$locale['ugly_100']."' alt='".$locale['ugly_100']."' />\n";
}
echo "</div><br /><br />\n";
echo "<div align='center' class='tbl2'><strong>\n";
echo "<a href='index.php'>".$locale['ugly_200']."</a> | \n";
echo "<a href='prev_drawings.php'>".$locale['ugly_201']."</a>\n";
if(iADMIN){
	echo " | <a href='admin/index.php".$aidlink."'>".$locale['ugly_202']."</a>\n";
}
echo "</strong></div><br />\n";
if (isset($_POST['buylot_final']) && $_POST['buylot_final'] == '0') {
	$draw_id = stripinput($_POST['draw_id']);
	$lotquery = dbquery("INSERT INTO ".DB_UG_LOTTERY_LOTS."	(lot_id, lot_draw, lot_owner, lot_owner_name) VALUES ('', '".$draw_id."', '".$userdata['user_id']."', '".$userdata['user_name']."')");
	$drawresult = dbquery("SELECT * FROM ".DB_UG_LOTTERY_DRAWINGS." ORDER BY draw_id DESC LIMIT 0,1");
	$drawrow = dbarray($drawresult);
	takegold2($userdata['user_id'], $drawrow['lot_price'], 'cash', 0);
	$drawquery = dbquery("UPDATE ".DB_UG_LOTTERY_DRAWINGS." SET lots=lots-1 WHERE draw_id='".$drawrow['draw_id']."'");
	echo "<div align='center'><strong>".$locale['ugly_213']."!</strong></div>\n<br />\n";
	echo "<div align='center'><strong>".$locale['ugly_223']."!</strong></div>\n";
	unset($_REQUEST['draw_id']);
	//pagerefresh('meta','2',FUSION_SELF.'?op=start');
	pagerefresh('meta','2',FUSION_SELF);
} else {
	$drawresult = dbquery("SELECT * FROM ".DB_UG_LOTTERY_DRAWINGS." ORDER BY draw_id DESC LIMIT 0,1");
	$drawdata = dbarray($drawresult);
	echo "<div align='center'><strong>".$locale['ugly_203']."</strong></div><br />";
	if($drawdata['endtime'] > time()) {
	    echo "<div align='center'>".sprintf($locale['ugly_204'], ucwords(showdate("longdate", $drawdata['endtime'])));
	    echo "<br />".sprintf($locale['ugly_205'], $drawdata['lot_price'], UGLD_GOLDTEXT, $drawdata['prize'], $drawdata['jtype'], $drawdata['lots'], $drawdata['lot_amnt'])."</div>";
	    
	    $ticket_count = dbcount("(lot_id)", DB_UG_LOTTERY_LOTS, "lot_owner='".$userdata['user_id']."' AND lot_draw='".$drawdata['draw_id']."'");
	    $ticket_bought_count = dbcount("(lot_id)", DB_UG_LOTTERY_LOTS, "lot_draw='".$drawdata['draw_id']."'");
		if($ticket_count > '0') {
			$winpercent = $ticket_count/$ticket_bought_count*100;
			echo "<div align='center'>".sprintf($locale['ugly_206'], $ticket_count, $ticket_bought_count, round($winpercent, 2), "%")."</div>";
		} else {
			echo "<br /><div align='center'>".$locale['ugly_207']."</div>";
		}
    
		if($golddata['cash'] >= $drawdata['lot_price']) {
			if($drawdata['lots'] <= 0) {
				echo  "<br /><div align='center'><strong>".$locale['ugly_208']."</strong></div>";
			} else {
				//echo "<div align='center'><form action='index.php?buylot_final=0' method='post'>";
				echo "<div align='center'><form action='index.php' method='post'>";
				echo "<input type='hidden' name='buylot_final' value='0' />";
				echo "<input type='hidden' value='".$drawdata['draw_id']."' name='draw_id' />";
				echo "<input type='submit' value='".$locale['ugly_209']."' class='button' />";
				echo "</form></div>";
			}
		} else {
			echo "<br /><div align='center'><strong>".sprintf($locale['ugly_210'], UGLD_GOLDTEXT)."</strong></div>";
		}
	} else {
		echo "<div align='center'><strong>".$locale['ugly_211']." <br />";
		echo sprintf($locale['ugly_212'], ucwords(showdate("longdate", $drawdata['endtime'])));
		echo "</strong></div>";
	}
}
closetable();
//Start Copywrite Link removal is NOT ALLOWED.
	echo "<div align='center' class='small'>".$locale['ugly_title']." ".$locale['ugly_version']." &copy; 2008 <a href='http://www.starglowone.com'>Stars Heaven</a></div>\n";
//END Copywrite Link removal is NOT ALLOWED.
require_once THEMES."templates/footer.php";
?>