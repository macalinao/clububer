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
| Filename: configurations.php
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

if (file_exists(GOLD_LANG.LOCALESET."admin/images.php")) {
	include GOLD_LANG.LOCALESET."admin/images.php";
} else {
	include GOLD_LANG."English/admin/images.php";
}

if (!isset($_GET['ifolder'])) $_GET['ifolder'] = "images_cat";

if ($_GET['ifolder'] == "images_items")
{
	$afolder = GOLD_IMAGE_ITEM;
} else {
	$afolder = GOLD_IMAGE_CAT;
}

if (isset($_GET['status'])) {
	if ($_GET['status'] == "del") {
		$title = $locale['urg_a_images_001'];
		$message = "<b>".$locale['urg_a_images_002']."</b>";
	} elseif ($_GET['status'] == "upn") {
		$title = $locale['urg_a_images_003'];
		$message = "<b>".$locale['urg_a_images_004']."</b>";
	} elseif ($_GET['status'] == "upy") {
		$title = $locale['urg_a_images_005'];
		$message = "<img src='".$afolder.$img."' alt='$img' /><br /><br />\n<b>".$locale['urg_a_images_006']."</b>";
	}
	opentable($title);
	echo "<div align='center'>".$message."</div>\n";
	closetable();
}

if (isset($_GET['del'])) {
	unlink($afolder.$_GET['del']);
	redirect(FUSION_SELF.$aidlink."&amp;op=images&amp;ifolder=".$_GET['ifolder']."&amp;status=del");
} else if (isset($_POST['uploadimage'])) {
	$error = "";
	$image_types = array(
		".gif",
		".GIF",
		".jpeg",
		".JPEG",
		".jpg",
		".JPG",
		".png",
		".PNG"
	);
	$imgext = strrchr($_FILES['myfile']['name'], ".");
	$imgname = $_FILES['myfile']['name'];
	$imgsize = $_FILES['myfile']['size'];
	$imgtemp = $_FILES['myfile']['tmp_name'];
	if (!in_array($imgext, $image_types)) {
		redirect(FUSION_SELF.$aidlink."&amp;op=images&amp;status=upn&amp;ifolder=".$_GET['ifolder']."");
	} elseif (is_uploaded_file($imgtemp)) {
		move_uploaded_file($imgtemp, $afolder.$imgname);
		chmod($afolder.$imgname,0644);
		redirect(FUSION_SELF.$aidlink."&amp;op=images&amp;status=upy&amp;ifolder=".$_GET['ifolder']."&img=$imgname");
	}
} else {
	opentable($locale['urg_a_images_003']);
	echo "<form name='uploadform' method='post' action='".FUSION_SELF.$aidlink."&amp;op=images&amp;ifolder=".$_GET['ifolder']."' enctype='multipart/form-data'>\n";
    echo "<table align='center' cellpadding='0' cellspacing='0' width='350'>\n<tr>\n";
    echo "<td width='80' class='tbl'>".$locale['urg_a_images_007'].":</td>\n";
    echo "<td class='tbl'><input type='file' name='myfile' class='textbox' style='width:250px;' /></td>\n";
    echo "</tr>\n<tr>\n";
    echo "<td align='center' colspan='2' class='tbl'>\n";
    echo "<input type='submit' name='uploadimage' value='".$locale['urg_a_images_003']."' class='button' style='width:100px;' /></td>\n";
    echo "</tr>\n</table>\n</form>\n";
	closetable();
	
	if (isset($_GET['view'])) {
    $_GET['view'] = stripinput($_GET['view']);
		opentable($locale['urg_a_images_008']);
		echo "<center><br />\n";
		$image_ext = strrchr($afolder.$_GET['view'],".");
		if (in_array($image_ext, array(".gif",".GIF",".jpg",".JPG",".jpeg",".JPEG",".png",".PNG"))) {
			echo "<img src='".$afolder.$_GET['view']."' alt='".$_GET['view']."' /><br /><br />\n";
            echo "<a href='".FUSION_SELF.$aidlink."&amp;op=images&amp;ifolder=".$_GET['ifolder']."'>\n";
            echo "<img src='".GOLD_IMAGE."back.png' title='".$locale['urg_a_images_009']."' alt='".$locale['urg_a_images_009']."' style='border: 0;' /></a>&nbsp;\n";
            echo "<a href='".FUSION_SELF.$aidlink."&amp;op=images&amp;ifolder=".$_GET['ifolder']."&amp;del=".$_GET['view']."'>\n";
            echo "<img src='".GOLD_IMAGE."delete.png' title='".$locale['urg_a_images_010']."' alt='".$locale['urg_a_images_010']."' style='border: 0;' /></a>\n";
		} else {
			echo $locale['urg_a_images_011'];
		}
        echo "</center>\n";
		closetable();
	} else {
		$image_list = makefilelist($afolder, "index.php|Thumbs.db", true);
		if ($image_list) { $image_count = count($image_list); }
		opentable('Images');
		echo "<table align='center' cellpadding='0' cellspacing='1' width='450' class='tbl-border'>\n<tr>\n";
        echo "<td align='center' colspan='2' class='tbl2'>\n";
        echo "<span style='font-weight:".($_GET['ifolder'] == "images_pc" ? "bold" : "normal")."'>\n";
        echo "<a href='".FUSION_SELF.$aidlink."&amp;op=images&amp;ifolder=images_cat'>".$locale['urg_a_images_012']."</a></span> | \n";
        echo "<a href='".FUSION_SELF.$aidlink."&amp;op=images&amp;ifolder=images_items'>".$locale['urg_a_images_016']."</a></span>\n";
		echo "</td>\n</tr>\n";
		if ($image_list) {
			for ($i=0;$i < $image_count;$i++) {
				if ($i % 2 == 0) { $row_color = "tbl1"; } else { $row_color = "tbl2"; }
				echo "<tr>\n";
                echo "<td class='$row_color'>$image_list[$i]</td>\n";
                echo "<td align='right' width='1%' class='$row_color' style='white-space:nowrap'>\n";
                echo "<a href='".FUSION_SELF.$aidlink."&amp;op=images&amp;ifolder=".$_GET['ifolder']."&amp;view=".$image_list[$i]."'>\n";
                echo "<img src='".GOLD_IMAGE."view.png' title='".$locale['urg_a_images_013']."' alt='".$locale['urg_a_images_013']."' style='border: 0;' /></a>&nbsp;\n";
                echo "<a href='".FUSION_SELF.$aidlink."&amp;op=images&amp;ifolder=".$_GET['ifolder']."&amp;del=$image_list[$i]'>\n";
                echo "<img src='".GOLD_IMAGE."delete.png' title='".$locale['urg_a_images_014']."' alt='".$locale['urg_a_images_014']."' style='border: 0;' /></a>&nbsp;</td>\n";
                echo "</tr>\n";
			}
		} else {
			echo "<tr>\n<td align='center' class='tbl1'>".$locale['urg_a_images_015']."</td>\n</tr>\n";
		}
		echo "</table>\n";
		closetable();
	}
}

?>