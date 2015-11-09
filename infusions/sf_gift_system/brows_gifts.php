<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: upgrade_functions.php
| Author: Starefossen
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

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."sf_gift_system/locale/".LOCALESET."/brows_gifts.php")) {
	// Load the locale file matching the current site locale setting.
	include INFUSIONS."sf_gift_system/locale/".LOCALESET."/brows_gifts.php";
} else {
	// Load the infusion's default locale file.
	include INFUSIONS."sf_gift_system/locale/English/brows_gifts.php";
}

require_once INFUSIONS."sf_gift_system/includes/functions.php";
require_once INFUSIONS."sf_gift_system/includes/infusion_db.php";

if (!isset($_GET['user_id'])) { $_GET['user_id'] = ""; }

if(!empty($_POST['sort_gifts'])){
		$_GET['rowstart'] = stripinput($_POST['rowstart']);
		$_GET['user_id'] = stripinput($_POST['user_id']);
		$orderby = stripinput($_POST['orderby']);
		$sortby = stripinput($_POST['sortby']);
}

if (!isset($_GET['rowstart']) || !isNum($_GET['rowstart'])) $_GET['rowstart'] = 0;
if (!isset($orderby) || (($orderby!="gift_id") && ($orderby!="gift_price") && ($orderby!="gift_stock") && ($orderby!="gift_bought"))) $orderby = "gift_id";
if (!isset($sortby) || (($sortby!="ASC") && ($sortby!="DESC"))) $sortby = "DESC";

if ((isset($_GET['user_id'])) && (isNum($_GET['user_id']))) {
	$nav_user = "user_id=".$_GET['user_id']."&";
} else {
	$nav_user = "";
}	


if ((iMEMBER) && ($userdata['user_id'] != $_GET['user_id'])) {
	$gift_images = true;
	opentable($locale['sfgift800']);
	
	opentable("Info");
	echo "<table align='center' cellpadding='0' cellspacing='1' width='100%' class='tbl-border'>\n<tr>\n";
	if ((isset($_GET['user_id'])) && (isNum($_GET['user_id']))) {
		$user = dbarray(dbquery("SELECT * FROM ".$db_prefix."users WHERE user_id='".$_GET['user_id']."'"));
		echo "<td class='tbl1'>".$locale['sfgift803']." <a href='".BASEDIR."profile.php?lookup=".$user['user_id']."'><b>".$user['user_name'].".</b></a></td>\n";
	} else {
		echo "<td class='tbl1'>".$locale['sfgift804']."</td>\n";
	}
	echo "<td class='tbl1'>\n";
	echo "<form action='brows_gifts.php' method='post'>\n";
	echo "<b>".$locale['sfgift805']."</b>\n";
	echo "<input type='hidden' name='rowstart' value='".$_GET['rowstart']."'>\n";
	echo "<input type='hidden' name='user_id' value='".$_GET['user_id']."'>\n";
	echo "<select name='orderby' class='textbox'>\n";
	echo "<option value='gift_id' ".(($orderby == "gift_id") ? "selected" : "").">".$locale['sfgift810']."</option>\n";
	echo "<option value='gift_price' ".(($orderby == "gift_price") ? "selected" : "").">".$locale['sfgift811']."</option>\n";
	echo "<option value='gift_stock' ".(($orderby == "gift_stock") ? "selected" : "").">".$locale['sfgift812']."</option>\n";
	echo "<option value='gift_bought' ".(($orderby == "gift_bought") ? "selected" : "").">".$locale['sfgift813']."</option>\n";
	echo "</select>\n";
	echo "<select name='sortby' class='textbox'>\n";
	echo "<option value='DESC' ".(($sortby == "DESC") ? "selected" : "").">".$locale['sfgift814']."</option>\n";
	echo "<option value='ASC' ".(($sortby == "ASC") ? "selected" : "").">".$locale['sfgift815']."</option>\n";
	echo "</select>\n";
	echo "<input type='submit' name='sort_gifts' value='".$locale['sfgift820']."' class='button'>\n";
	echo "</form>\n";
	echo "</td>\n</tr>\n</table>\n";
	closetable();

	echo "<table align='center' cellpadding='0' cellspacing='1' width='100%' class='tbl-border'>\n<tr>\n";
	echo "<td colspan='4' class='tbl1'>\n";
	$result = dbquery("SELECT * FROM ".DB_GIFT." ORDER BY ".$orderby." ".$sortby." LIMIT ".$_GET['rowstart'].",16");
	$rows = dbrows($result);
	if ($rows != 0) {
		$counter = 0; $columns = 4;
		$align = $gift_images ? "center" : "left";
		echo "<table cellpadding='0' cellspacing='0' width='100%'>\n<tr>\n";
		while ($data = dbarray($result)) {		
			if ($counter != 0 && ($counter % $columns == 0)) echo "</tr>\n<tr>\n";
			echo "<td align='$align' height='64' width='25%' class='tbl'>";
			if ($data['gift_stock'] == $data['gift_bought']) {
				echo "<img src='".GIFT_INCLUDES."gfx.php?souldout=".$data['gift_image']."' alt='".$locale['sfgift821']."' style='border:0px;' border='0' alt='' />";
			} elseif ((isset($_GET['user_id'])) && (isNum($_GET['user_id']))) {
				echo "<a href='".GIFT_SYSTEM."give_gift.php?gift_id=".$data['gift_id']."&amp;user_id=".$_GET['user_id']."'>\n";
				echo "<img src='".GIFT_IMAGES.$data['gift_image']."' alt='".$data['gift_image']."' style='border:0px;' border='0' alt='' />\n";
				echo "</a>\n";
			} else {
				echo "<a href='".GIFT_SYSTEM."give_gift.php?gift_id=".$data['gift_id']."'>";
				echo "<img src='".GIFT_IMAGES.$data['gift_image']."' alt='".$data['gift_image']."' style='border:0px;' border='0' alt='' />\n";
				echo "</a>\n";
			}
			echo "<br />".$locale['sfgift822']." ".$data['gift_price']." ".$locale['sfgift823']."<br />".$locale['sfgift824']." ".($data['gift_stock']-$data['gift_bought'])."\n";
			echo "</td>\n";
			$counter++;
		}
		echo "</tr>\n</table>\n";
	} else {
		echo "<center><br />\n".$locale['sfgift802']."<br /><br />\n</center>\n";
	}
	echo "</td>\n</tr>\n</table>\n";
	
	closetable();
	
	$total_rows = dbcount("(*)", DB_GIFT);
	
	if ($total_rows > 10) echo "<div align='center' style='margin-top:5px;'>\n".makePageNav($_GET['rowstart'],16,$total_rows,3,FUSION_SELF."?".$nav_user."orderby=".$orderby."&sortby=".$sortby."&")."\n</div>\n";
} else if ($userdata['user_id'] == $_GET['user_id']) {
	opentable($locale['sfgift830']);
	echo $locale['sfgift831'];
	closetable();
} else {
	opentable($locale['sfgift830']);
	echo $locale['sfgift832'];
	closetable();
}

require_once(GIFT_SYSTEM."footer.php");

require_once THEMES."templates/footer.php";
?>