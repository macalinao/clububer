<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright � 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: new_infusion.php
| Author: INSERT NAME HERE
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
require_once "../../maincore.php";
require_once THEMES."templates/header.php";
if (USERGOLD && GLD_AVATAR) {
	// Check if locale file is available matching the current site locale setting.
	if (file_exists(INFUSIONS."ug_avatarmaker/locale/".$settings['locale'].".php")) {
		// Load the locale file matching the current site locale setting.
		include INFUSIONS."ug_avatarmaker/locale/".$settings['locale'].".php";
	} else {
		// Load the infusion's default locale file.
		include INFUSIONS."ug_avatarmaker/locale/English.php";
	}
	include_once(INFUSIONS."ug_avatarmaker/class/avatarmaker.php");
	if (array_key_exists('preview', $_POST)) {
		$op = "preview";
	} elseif (array_key_exists('store', $_POST)) {
		$op = "store";
	} else {
		$op = "default";
	}
	
	function preview() {
		global $HTTP_POST_VARS, $settings, $userdata, $locale;
		opentable($locale['ugam_150']);
		echo "<form action='".$_SERVER['PHP_SELF']."' method='post'>\n";
		$image_url = "./preview.php?preview=on";
		for ($i = 1; avatarmaker_check_file($i, $_POST); $i++) {
			$image_url .= "&amp;i".$i."=" . urlencode($_POST['i' . $i]);
		}
		echo "<div align='center'>\n";
		echo "<table>\n<tr align='center'>\n";
		echo "<td>".$locale['ugam_151']."</td>\n";
		echo "<td width='50'></td>\n";
		echo "<td>".$locale['ugam_152']."</td>\n";
		echo "</tr>\n<tr align='center'>\n";
		$none = 'no_avatar.gif';
		$avatar = (!empty($userdata['user_avatar'])? $userdata['user_avatar']: $none);
		echo "<td><img src='".IMAGES."avatars/".$avatar."' alt='".$avatar."' /><br /><input class='button' type='button' name='reset' value='".$locale['ugam_153']."' /></td>\n";
		echo "<td></td>\n";
		echo "<td><img src='".$image_url."' alt='*' /><br /><input class='button' type='submit' name='store' value='".$locale['ugam_154']."' /></td>\n";
		echo "</tr>\n</table>\n";
		echo "<br /><br />\n";
		
		echo "<br /><br />\n";
		links();
		echo "</div>\n";
	}
	
	function store() {
		global $HTTP_POST_VARS, $settings, $userdata, $locale;
		if(!iMEMBER){
			header("location: ".$settings['siteurl']);
			exit();
		}
		$avatar = new AvatarMaker();
		for ($i = 1; avatarmaker_check_file($i, $_POST); $i++) {
			$avatar->addImage('images/' . $_POST['i'.$i] . '.' . $avatar->type, $avatar->type);
		}
		$result = $avatar->senddata();
		$avatar->destroy();
		header("location: ".BASEDIR."edit_profile.php");
		exit();
	}
	
	function head_form() {
		global $HTTP_POST_VARS, $settings, $userdata, $locale;
		opentable($locale['ugam_150']);
		echo "<form action='index.php' method='post'>\n";
		$none = 'no_avatar.gif';
		$avatar = (!empty($userdata['user_avatar'])? $userdata['user_avatar']: $none);
		echo "<div align='center'>\n";
		echo "<img src='".$settings['siteurl']."images/avatars/".$avatar."' width='".UGAM_AVATAR_MAKER_WIDTH."' height='".UGAM_AVATAR_MAKER_HEIGHT."' border='1px' alt='".$avatar."' /><br /><br />\n";
		echo "<strong>".$locale['ugam_155']."</strong>\n";
		echo "</div>\n";
		echo "<hr />";
	}
	
	function form() {
		global $HTTP_POST_VARS, $settings, $userdata, $locale;
		$name = array("background", "ear", "face", "fhair", "eyebrow", "eyes", "nose", "mouth", "dress", "others");
		$code = array("bg", "ear", "fc", "fhr", "eb", "eye", "ns", "mo", "cl", "oth");
		$constant = array($locale['ugam_205'], $locale['ugam_207'], $locale['ugam_208'], 
		$locale['ugam_209'], $locale['ugam_210'], $locale['ugam_211'], $locale['ugam_212'], $locale['ugam_213'], 
		$locale['ugam_214'], $locale['ugam_215']);
		for ($i=0; $i<count($name); $i++) {
			make_table($name[$i], $code[$i], $constant[$i], $i+1);
			links();
		}
	}
	
	function close() {
		echo "</form>\n";  
	}
	
	switch($op) {
		case 'preview':
			preview();
			form();
			close();
			break;
	
		case 'store':
			store();
			break;
	
		default:
			head_form();
			form();
			close();
			break;
			
	}
	closetable();
	//Start Copywrite Link removal is NOT ALLOWED.
		echo "<div align='center' class='small'>".$locale['ugam_title']." ".$locale['ugam_version']." &copy; 2007-2008 <a href='http://www.starglowone.com'>Stars Heaven</a></div>\n";
	//END Copywrite Link removal is NOT ALLOWED.
} else {
	opentable("Access Denied");
	echo "<center>Sorry, but you cannot create an avatar as you have not bought the privilege to do so.<br />You may buy this special privilege <a href='".INFUSIONS."user_gold/index.php?op=shop_start'>here</a>.";
	closetable();
}
require_once THEMES."templates/footer.php";
?>
