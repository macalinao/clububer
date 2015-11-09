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
require_once THEMES."templates/admin_header.php";

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."sf_gift_system/locale/".LOCALESET."/give_gift.php")) {
	// Load the locale file matching the current site locale setting.
	include INFUSIONS."sf_gift_system/locale/".LOCALESET."/give_gift.php";
} else {
	// Load the infusion's default locale file.
	include INFUSIONS."sf_gift_system/locale/English/give_gift.php";
}

require_once INFUSIONS."sf_gift_system/includes/functions.php";
require_once INFUSIONS."sf_gift_system/includes/infusion_db.php";

if (!isset($_GET['error'])) { $_GET['error'] = ""; }
if (!isset($_GET['user_id'])) { $_GET['user_id'] = ""; }

//Insert the gift when it is submitted
if((!empty($_POST['give_gift'])) && (!empty($_POST['gift_user_name'])) && (!empty($_POST['gift_id']))) {
	$gift_id = stripinput($_POST['gift_id']);
	$gift_price = stripinput($_POST['gift_price']);	
	$gift_user_name = stripinput($_POST['gift_user_name']);		
	$gift_message = stripinput($_POST['gift_message']);		
	$gift_privacy_type = stripinput($_POST['gift_privacy_type']);
	$mygold = getusergold($userdata['user_id'], "cash");
	if ($mygold >= $gift_price) {	
		//Open the users table and find the users to give gift to
		$result = dbquery("SELECT * FROM ".DB_USERS." WHERE user_name='$gift_user_name' LIMIT 1");
		//We check if the user exist before we send the gift
		if(dbrows($result)){
			$user = dbarray($result);
			if ($userdata['user_id'] != $user['user_id']) {
				takegold2($userdata['user_id'],$gift_price);
				$result = dbquery("UPDATE ".DB_GIFT." SET gift_bought=gift_bought+1 WHERE gift_id='".$gift_id."'");
				$result = dbquery("INSERT INTO ".DB_GIFT_GIVEN." (
					gift_given_gift_id, 
					gift_given_from, 
					gift_given_to, 
					gift_given_visibillity, 
					gift_given_message
				) VALUES(
					'$gift_id', 
					'".$userdata['user_id']."', 
					'".$user['user_id']."', 
					'$gift_privacy_type', 
					'$gift_message')
				");
				$sendt_gift_id = mysql_insert_id();
				$result = dbquery("INSERT INTO ".DB_MESSGES." (
					message_to,
					message_from,
					message_subject,
					message_message,
					message_smileys,
					message_read,
					message_datestamp,
					message_folder
				) VALUES(
					'".$user['user_id']."',
					'".$userdata['user_id']."',
					'".$locale['sfgift950']."',
					'".$locale['sfgift951']." <a href=\'".GIFT_SYSTEM."show_gift.php?lookup=".$user['user_id']."&gift_id=".$sendt_gift_id."\' target=\'_self\'>".$locale['sfgift952']."</a>.<br />".$locale['sfgift953']." ".$userdata['user_name'].".<br /><br /><br />[u][b]".$locale['sfgift954']." ".$userdata['user_name'].":[/b][/u]<br />".$gift_message."',
					'y',
					'0',
					'".time()."',
					'0'
				)");
				redirect(FUSION_SELF."?status=ok&user_id=".$user['user_id']."&gift=".$gift_id."");
			} else {
				redirect(FUSION_SELF."?gift_id=".$gift_id."&error=3");
			}
		//If the user dos not exist we send you back to the give gift page with an error
		} else {
			redirect(FUSION_SELF."?gift_id=".$gift_id."&error=2");
		}
	} else {
		redirect(FUSION_SELF."?gift_id=".$gift_id."&error=4");
	}
//If you didn't write a username at all, you'll gett this error
} else if ((!empty($_POST['give_gift'])) && (empty($_POST['gift_user_name']))){
	$gift_id = stripinput($_POST['gift_id']);
	redirect(FUSION_SELF."?gift_id=".$gift_id."&error=1");
}

//Here is the Buy Gift content
if ((iMEMBER) && (isset($_GET['gift_id'])) && (isNum($_GET['gift_id']))) {
	opentable($locale['sfgift900']);
	$result = dbquery("SELECT * FROM ".DB_GIFT." WHERE gift_id='".$_GET['gift_id']."'");
	$mygold = getusergold($userdata['user_id'], "cash");
	if(dbrows($result)){
		$data = dbarray($result);
		if ($mygold < $data['gift_price']) {
			$disabled = "disabled";
			echo "<table width='100%' align='center'>\n<tr>\n<td align='center'><b>".$locale['sfgift920']."</b><br /><br /></td>\n</tr>\n</table>\n";
		} else if ($data['gift_stock'] == $data['gift_bought']) {
			$disabled = "disabled";
			echo "<table width='100%' align='center'>\n<tr>\n<td align='center'><b>".$locale['sfgift921']."</b><br /><br /></td>\n</tr>\n</table>\n";
		} else {
			$disabled = "";
		}
		//Error messages
		if(isset($_GET['error']) && $_GET['error'] == "1") echo "<table width='100%' align='center'>\n<tr>\n<td align='center'><b>".$locale['sfgift922']."</b><br /><br /></td>\n</tr>\n</table>\n";
		if(isset($_GET['error']) && $_GET['error'] == "2") echo "<table width='100%' align='center'>\n<tr>\n<td align='center'><b>".$locale['sfgift923']."</b><br /><br /></td>\n</tr>\n</table>\n";
		if(isset($_GET['error']) && $_GET['error'] == "3") echo "<table width='100%' align='center'>\n<tr>\n<td align='center'><b>".$locale['sfgift924']."</b><br /><br /></td>\n</tr>\n</table>\n";
		
		//The actually give gift form
		$user = dbarray(dbquery("SELECT * FROM ".DB_USERS." WHERE user_id='".$_GET['user_id']."'"));
		echo "<form action='".FUSION_SELF."?gift_id=".$_GET['gift_id']."' method='post'>\n";
		echo "<table width='450'>\n<tr>\n";
		echo "<td><b>".$locale['sfgift901']."</b></td>\n";
		echo "<td rowspan='6' valign='top'><img src='".GIFT_IMAGES.$data['gift_image']."'align='left' border='0' alt='' /></td>\n";
		echo "</tr>\n<tr>\n";
		echo "<td>\n";
		echo "<input type='hidden' name='gift_id' value='".$_GET['gift_id']."' />\n";
		echo "<input type='hidden' name='gift_price' value='".$data['gift_price']."'>\n";
		echo "<input type='text' name='gift_user_name' class='textbox' style='width:200px;' value='".$user['user_name']."' /> (".$locale['sfgift902'].")\n";
		echo "</td>\n";
		echo "</tr>\n<tr>\n";
		echo "<td><b>".$locale['sfgift905']."</b></td>\n";
		echo "</tr>\n<tr>\n";
		echo "<td><textarea class='textarea' name='gift_message' cols='38' rows='4'></textarea></td>\n";
		echo "</tr>\n<tr>\n";
		echo "<td><b>".$locale['sfgift906']."</b></td>\n";
		echo "</tr>\n<tr>\n";
		echo "<td><label><input type='radio' name='gift_privacy_type' value='0' checked='checked' />".$locale['sfgift930']."<br />".$locale['sfgift931']."</label>\n";
		echo "</tr>\n<tr>\n";
		echo "<td><label><input type='radio' name='gift_privacy_type' value='1' checked='checked' />".$locale['sfgift932']."<br />".$locale['sfgift933']."</label>\n";
		echo "</tr>\n<tr>\n";
		echo "<td><label><input type='radio' name='gift_privacy_type' value='2' checked='checked' />".$locale['sfgift934']."<br />".$locale['sfgift935']."</label>\n";
		echo "</tr>\n<tr>\n";
		echo "<td><input type='submit' class='button' name='give_gift' value='".$locale['sfgift903']."' $disabled /></td>\n";
		echo "</tr>\n</table>\n</form>\n";
	//If the gift is not found in the database we display an error message
	} else {
		echo $locale['sfgift904'];
	}
	
	closetable();
	
	tablebreak();
	
	opentable($locale['sfgift910']);
	echo "<table width='450'>\n<tr>\n";
	echo "<td align='left'><a href='".GIFT_SYSTEM."brows_gifts.php'>".$locale['sfgift911']."</a> | <a href='".BASEDIR."index.php'>".$locale['sfgift912']."</a></td>\n";
	echo "</tr>\n</table>\n";
	closetable();
//If you have returned from buying a gift, you'll gett this
} else if ((iMEMBER) && (isset($_GET['status'])) && ($_GET['status']=="ok") && (isset($_GET['user_id'])) && (isNum($_GET['user_id'])) && (isset($_GET['gift'])) && (isNum($_GET['gift']))) {
	$user = dbarray(dbquery("SELECT * FROM ".DB_USERS." WHERE user_id='".$_GET['user_id']."'"));
	opentable("Gift Bought");
	echo "<table width='450'>\n<tr>\n";
	echo "<td align='center'><b>".$locale['sfgift925']." <a href='".BASEDIR."profile.php?lookup=".$user['user_id']."'>".$user['user_name']."</a></b></td>\n";
	echo "</tr>\n</table>\n";
	closetable();
	opentable($locale['sfgift910']);
	echo "<table width='450'>\n<tr>\n";
	echo "<td align='left'><a href='".GIFT_SYSTEM."brows_gifts.php'>".$locale['sfgift911']."</a> | <a href='".FUSION_SELF."?gift_id=".$_GET['gift']."'>".$locale['sfgift913']."</a></td>\n";
	echo "</tr>\n</table>\n";
	closetable();
//Or if nothing is selected we send you back
} else {
	redirect(GIFT_SYSTEM."brows_gifts.php");
}

require_once(GIFT_SYSTEM."footer.php");

require_once THEMES."templates/footer.php";
?>