<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright � 2002 - 2008 Nick Jones
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
require_once "../../../maincore.php";
require_once THEMES."templates/admin_header.php";

if (!checkrights("GIFT")) redirect("../index.php");

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."sf_gift_system/locale/".LOCALESET."/admin.php")) {
	// Load the locale file matching the current site locale setting.
	include INFUSIONS."sf_gift_system/locale/".LOCALESET."/admin.php";
} else {
	// Load the infusion's default locale file.
	include INFUSIONS."sf_gift_system/locale/English/admin.php";
}

require_once INFUSIONS."sf_gift_system/includes/functions.php";
require_once INFUSIONS."sf_gift_system/includes/infusion_db.php";
require_once GIFT_VERSIONCHECKER."version_checker.php";

if (!isset($_GET['status'])) {
	$_GET['status'] = "";
}

opentable("Navigation - SF Gift System v.".$version['gift_version']."");
echo "<table class='tbl-border' width='100%'>\n<tr>\n";
echo "<td class='tbl2' align='center' width='50%'><b>".$locale['sfgift205']."</b></td>\n";
echo "<td class='tbl1' align='center' width='50%'><a href='".GIFT_ADMIN."upgrade.php".$aidlink."'>".$locale['sfgift206']."</a></td>\n";
echo "</tr>\n</table>\n";
closetable();

if (!isset($rowstart) || !isNum($rowstart)) $rowstart = 0;

if (isset($_GET['edit']) && isNum($_GET['edit'])) {
	if (!empty($_POST['update_gift'])) {
		$gift_id = stripinput($_POST['gift_id']);
		$gift_image = stripinput($_POST['gift_image']);
		$gift_price = stripinput($_POST['gift_price']);
		$gift_stock = stripinput($_POST['gift_stock']);
		$gift_image = str_replace("../../../infusions/sf_gift_system/images/", "", $gift_image);
		$result = dbquery("UPDATE ".DB_GIFT." SET gift_image='".$gift_image."', gift_price='".$gift_price."', gift_stock='".$gift_stock."' WHERE gift_id='".$gift_id."' LIMIT 1");
		redirect(FUSION_SELF.$aidlink."&status=um");
	}
	
	opentable($locale['sfgift231']);
	$editgift = dbarray(dbquery("SELECT * FROM ".DB_GIFT." WHERE gift_id='".$_GET['edit']."' LIMIT 1"));
	echo "<form name='giftform' action='".FUSION_SELF.$aidlink."&edit=".$_GET['edit']."' method='post'>\n";
	echo "<table width='450'>\n<tr>\n";
	echo "<td>".$locale['sfgift202']."</td>\n";
	echo "<td><select name='gift_image' class='textbox' onChange='showimage()'>\n";
	$handle=opendir(INFUSIONS."sf_gift_system/images/");
	while (false!==($file = readdir($handle))) {
		$filec = strrchr($file, '.');
		if ($filec == '.png' || $filec == '.jpg' || $filec == '.gif') {
			$result = dbquery("SELECT * FROM ".DB_GIFT." WHERE gift_image=''");
			if (dbrows($result) == 0) {
				if ($editgift['gift_image'] == $file) {
					$selected = "selected";
				} else {
					$selected = "";
				}
				echo "<option value='".GIFT_IMAGES."".$file."' ".$selected.">".$file."</option>";
			}
		}
	}
	closedir($handle);
	echo "</select>\n</td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td>&nbsp;</td>\n";
	echo "<td><img src='".INFUSIONS."sf_gift_system/images/".$editgift['gift_image']."' name='giftimage' width='64' height='64' alt='' /></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td>".$locale['sfgift213'].":</td>";
	echo "<td>\n";
	echo "<input type='hidden' name='gift_id' value='".$editgift['gift_id']."' />\n";
	echo "<input type='text' name='gift_price' class='textbox' style='width:225px;' value='".$editgift['gift_price']."' />\n";
	echo "</td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td>".$locale['sfgift218'].":</td>\n";
	echo "<td><input type='text' name='gift_stock' class='textbox' style='width:225px;' value='".$editgift['gift_stock']."' /></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td>&nbsp;</td>\n";
	echo "<td><input type='submit' class='button' name='update_gift' value='".$locale['sfgift232']."' /></td>\n";
	echo "</tr>\n</table>\n</form>\n";
	closetable();
	
} else {
	if (isset($del) && isNum($del)) {
		$result = dbquery("DELETE FROM ".DB_GIFT." WHERE gift_id='$del'");
	
		redirect(FUSION_SELF.$aidlink."&status=dm");
	}
	if ((!empty($_POST['add_gift'])) && (!empty($_POST['gift_image']))) {
		$gift_image = stripinput($_POST['gift_image']);
		$gift_price = stripinput($_POST['gift_price']);
		$gift_stock = stripinput($_POST['gift_stock']);
		$gift_bought = stripinput($_POST['gift_bought']);
		$gift_image = str_replace("../../../infusions/sf_gift_system/images/", "", $gift_image);
		$result = dbquery("INSERT INTO ".DB_GIFT." (gift_image, gift_price, gift_stock, gift_bought) VALUES('$gift_image', '$gift_price', '$gift_stock', '$gift_bought')");
		redirect(FUSION_SELF.$aidlink."&status=sm");
	} elseif ((!empty($_POST['add_gift'])) && (empty($_POST['gift_image']))) {
		redirect(FUSION_SELF.$aidlink."&status=ni");
	}

	opentable($locale['sfgift200']);
	echo "<table>\n<tr>\n<td valign='top' width='50%'>\n";
	echo "<form name='giftform' action='".FUSION_SELF.$aidlink."' method='post'>\n";
	echo "<table width='450'>\n<tr>\n";
	echo "<td>".$locale['sfgift202']."</td>\n";
	echo "<td>\n";
	echo "<select name='gift_image' class='textbox' onChange='showimage()'>\n";
	echo "<option value='' disabled>Choose an image</option>\n";
	$handle=opendir(INFUSIONS."sf_gift_system/images/");
	while (false!==($file = readdir($handle))) {
		$filec = strrchr($file, '.');
		if ($filec == '.png' || $filec == '.jpg' || $filec == '.gif') {
			$result = dbquery("SELECT * FROM ".DB_GIFT." WHERE gift_image='$file'");
			if (dbrows($result) == 0) {
				echo "<option value='".GIFT_IMAGES."".$file."'>".$file."</option>\n";
			}
		}
	}
	closedir($handle);
	echo "</select>\n";
	echo "</td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td>&nbsp;</td>\n";
	echo "<td><img src='".INFUSIONS."sf_gift_system/choose.gif' name='giftimage' width='64' height='64' alt='' /></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td>".$locale['sfgift213'].":</td>\n";
	echo "<td><input type='text' name='gift_price' class='textbox' style='width:225px;' value='500' /></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td>".$locale['sfgift218'].":</td>\n";
	echo "<td><input type='text' name='gift_stock' class='textbox' style='width:225px;' value='50' /></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td>&nbsp;</td>\n";
	echo "<td><input type='submit' class='button' name='add_gift' value='".$locale['sfgift204']."' /></td>\n";
	echo "</tr>\n</table>\n</form>\n";
	echo "</td>\n<td valign='top' align='left' width='50%'>\n";
	echo checkversion($version['gift_version']);
	echo "</td>\n</tr>\n</table>\n";
	closetable();

}


if($_GET['status'] == "sm") echo "<table width='100%' align='center'><tr><td align='center'><b>".$locale['sfgift221']."</b><br /><br /></td></tr></table>";
if($_GET['status'] == "dm") echo "<table width='100%' align='center'><tr><td align='center'><b>".$locale['sfgift220']."</b><br /><br /></td></tr></table>";
if($_GET['status'] == "um") echo "<table width='100%' align='center'><tr><td align='center'><b>".$locale['sfgift223']."</b><br /><br /></td></tr></table>";
if($_GET['status'] == "ni") echo "<table width='100%' align='center'><tr><td align='center'><b>".$locale['sfgift224']."</b><br /><br /></td></tr></table>";

opentable($locale['sfgift210']);
$result = dbquery("SELECT * FROM ".DB_GIFT." ORDER BY gift_id DESC LIMIT $rowstart,10");
if (dbrows($result)) {
	echo "<center><table class='tbl-border' width='500'>\n<tr>\n";
	echo "<td class='tbl1' align='center'><b>".$locale['sfgift211']."</b></td>\n";
	echo "<td class='tbl1' align='center'><b>".$locale['sfgift212']."</b></td>\n";
	echo "<td class='tbl1' align='center'><b>".$locale['sfgift213']."</b></td>\n";
	echo "<td class='tbl1' align='center'><b>".$locale['sfgift216']."</b></td>\n";
	echo "<td class='tbl1' align='center'><b>".$locale['sfgift214']."</b></td>\n";
	echo "</tr>\n";
	while($data = dbarray($result)){
		echo "<tr>\n";
		echo "<td class='tbl1' align='center'>".$data['gift_id']."</td>\n";
		echo "<td class='tbl1' align='center'>\n";
		echo "<img src='".INFUSIONS."sf_gift_system/images/".$data['gift_image']."' alt='".$data['gift_image']."' alt='' />\n";
		echo "</td>\n";
		echo "<td class='tbl1' align='center'>".$data['gift_price']." ".$locale['sfgift217']."</td>\n";
		echo "<td class='tbl1' align='center'>".$data['gift_bought']."/".$data['gift_stock']."</td>\n";
		echo "<td class='tbl1' align='center'>\n";
		echo "<a href='".FUSION_SELF.$aidlink."&amp;edit=".$data['gift_id']."'>".$locale['sfgift230']."</a><br />\n";
		echo "<a href='".FUSION_SELF.$aidlink."&amp;del=".$data['gift_id']."'>".$locale['sfgift215']."</a>\n";
		echo "</td>\n";
		echo "</tr>\n";
	}
	echo "</table>\n</center>\n";
} else {
	echo "<center><b>".$locale['sfgift222']."</b></center>\n";
}
closetable();

$total_rows = dbcount("(*)", DB_GIFT);

if ($total_rows > 10) echo "<div align='center' style='margin-top:5px;'>\n".makePageNav($rowstart,10,$total_rows,3,FUSION_SELF."?lookup=$lookup&amp;")."\n</div>\n";

require_once(GIFT_SYSTEM."footer.php");

require_once THEMES."templates/footer.php";
?>