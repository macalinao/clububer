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
| Filename: usage.php
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

if (file_exists(GOLD_LANG.LOCALESET."admin/usage.php")) {
	include GOLD_LANG.LOCALESET."admin/usage.php";
} else {
	include GOLD_LANG."English/admin/usage.php";
}

if (!isset($_GET['rowstart']) || !isNum($_GET['rowstart'])) { $rowstart = 0; } else { $rowstart = $_GET['rowstart']; }
if (!isset($_GET['c_rowstart']) || !isNum($_GET['c_rowstart'])) { $c_rowstart = 0; } else { $c_rowstart = $_GET['c_rowstart']; }

$query1 = dbquery("SELECT * FROM ".DB_UG3_USAGE." ORDER BY id DESC");
//Delete Item
if (isset($_GET['step']) && $_GET['step'] == "delete") {
	if (isset($_GET['id']) && !isNum($_GET['id'])) redirect("index.php".$aidlink."&amp;op=useage&error=1");
	$result = dbquery("DELETE FROM ".DB_UG3_USAGE." WHERE id='".$_GET['id']."' LIMIT 1");
	redirect(FUSION_SELF.$aidlink."&amp;op=useage&amp;delete=ok");
//Delete Category
} elseif (isset($_GET['step']) && $_GET['step'] == "c_delete") {
	if (isset($_GET['id']) && !isNum($_GET['id'])) redirect("index.php".$aidlink."&amp;op=useage&error=2");
	$result = dbquery("DELETE FROM ".DB_UG3_CATEGORIES." WHERE cat_id='".$_GET['id']."' LIMIT 1");
	redirect(FUSION_SELF.$aidlink."&amp;op=useage&amp;c_delete=ok");
} else {	
	//Save Item
	if (isset($_POST['save_item'])) {
		if (isset($_GET['id']) && !isNum($_GET['id'])) redirect("index.php".$aidlink."&amp;op=useage");
		if ((strpos(strtoupper($_POST['name']),"GLD_")) === 0) {
			$namechecked = stripinput($_POST['name']);
		} else {
			$namechecked = "GLD_".eregi_replace(' ', '_', stripinput(strtoupper($_POST['name'])));
		}
		$descchecked = stripinput($_POST['description']);
		$costchecked = stripinput($_POST['cost']);
		$stockchecked = stripinput($_POST['stock']);
		$purchasechecked = stripinput($_POST['purchase']);
		$imagechecked = stripinput($_POST['image']);
		$category = stripinput($_POST['category']);
		$active = stripinput($_POST['active']);
		if (isset($_GET['step']) && $_GET['step'] == "edit") {
			$result = dbquery("UPDATE ".DB_UG3_USAGE." SET 
			  name = '".$namechecked."', 
			  description = '".$descchecked."', 
			  purchase = '".$purchasechecked."', 
			  cost = '".$costchecked."', 
			  stock = '".$stockchecked."', 
			  image = '".$imagechecked."',
			  category = '".$category."',
			  active = '".$active."'
			WHERE 
			  id = ".$_GET['id']." 
			LIMIT 1");
		} else {
			//add a new entry
			$result = dbquery("INSERT INTO ".DB_UG3_USAGE." (
			  name,
			  description,
			  purchase,
			  cost,
			  stock,
			  image,
			  category,
			  active 
			) VALUES (
			  '".$namechecked."', 
			  '".$descchecked."', 
			  '".$purchasechecked."', 
			  '".$costchecked."', 
			  '".$stockchecked."', 
			  '".$imagechecked."', 
			  '".$category."',
			  '".$active."'
			);");
		}
		redirect(FUSION_SELF.$aidlink."&amp;op=useage");
	} elseif (isset($_POST['save_cat'])) {
		if (isset($_GET['cat_id']) && !isNum($_GET['cat_id'])) redirect("index.php".$aidlink."&amp;op=useage");
		$cat_name = stripinput($_POST['cat_name']);
		$cat_description = stripinput($_POST['cat_description']);
		$cat_image = stripinput($_POST['cat_image']);
		$cat_sorting = stripinput($_POST['cat_sorting']);
		$cat_access = stripinput($_POST['cat_access']);
		if (isset($_GET['step']) && $_GET['step'] == "c_edit") {
			$result = dbquery("UPDATE ".DB_UG3_CATEGORIES." SET 
			  cat_name = '".$cat_name."', 
			  cat_description = '".$cat_description."', 
			  cat_image = '".$cat_image."', 
			  cat_sorting = '".$cat_sorting."', 
			  cat_access = '".$cat_access."' 
			WHERE 
			  cat_id = ".$_GET['id']." 
			LIMIT 1");
		} else {
			//add a new entry
			$result = dbquery("INSERT INTO ".DB_UG3_CATEGORIES." (
			  cat_name,
			  cat_description,
			  cat_image,
			  cat_sorting,
			  cat_access 
			) VALUES (
			  '".$cat_name."', 
			  '".$cat_description."', 
			  '".$cat_image."', 
			  '".$cat_sorting."', 
			  '".$cat_access."'
			);");
		}
		redirect(FUSION_SELF.$aidlink."&amp;op=useage");
	}
	
	if (isset($_GET['step']) && $_GET['step'] == "edit") {
		if (isset($_GET['id']) && !isNum($_GET['id'])) redirect("index.php".$aidlink."&amp;op=useage");
		$result = dbquery("SELECT * FROM ".DB_UG3_USAGE." WHERE id = '".$_GET['id']."'");
		$data = dbarray($result);
		$formaction = FUSION_SELF.$aidlink."&amp;op=useage&amp;step=edit&amp;id=".$data['id'];
	} else {
		$formaction = FUSION_SELF.$aidlink."&amp;op=useage";
		$data['name'] = '';
		$data['description'] = '';
		$data['purchase'] = '';
		$data['cost'] = '';
		$data['stock'] = '';
		$data['active'] = '';
		$data['image'] = '';
	}
	if (isset($_GET['step']) && $_GET['step'] == "c_edit") {
		if (isset($_GET['id']) && !isNum($_GET['id'])) redirect("index.php".$aidlink."&amp;op=useage");
		$c_result = dbquery("SELECT * FROM ".DB_UG3_CATEGORIES." WHERE cat_id = '".$_GET['id']."'");
		$c_data = dbarray($c_result);
		$c_formaction = FUSION_SELF.$aidlink."&amp;op=useage&amp;step=c_edit&amp;id=".$c_data['cat_id'];
	} else {
		$c_formaction = FUSION_SELF.$aidlink."&amp;op=useage";
		$c_data['cat_id'] = '';
		$c_data['cat_name'] = '';
		$c_data['cat_description'] = '';
		$c_data['cat_sorting'] = '';
		$c_data['cat_access'] = '';
	}
	opentable($locale['urg_a_usage_100'],'');
	echo "<table width='100%'>\n<tr>\n";
	echo "<td class='tbl-border' width='50%'>\n";
 	$ug_cats = getcats(); $categories_opts = ""; $sel = "";
	while(list($key, $ug_cat) = each($ug_cats)){
		$sel = ($data['category'] == $ug_cat['0'] ? " selected='selected'" : "");
		$categories_opts .= "<option value='".$ug_cat['0']."'$sel>".$ug_cat['1']."</option>\n";
	}
	//Create / Edit Items
	echo "<form name='item_form' method='post' action='".$formaction."'>\n";
	echo "<table align='center' width='100%' cellspacing='2' cellpadding='2'>\n<tr>\n";
	echo "<td colspan='2'><h3>".$locale["urg_a_usage_107"]."</h3></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td width='100px'><strong>".$locale["urg_a_usage_108"]."</strong></td>\n";
	echo "<td><input type='text' name='name' value='".$data["name"]."' class='textbox' style='width:200px;' />\n";
	echo "<input type='hidden' name='originalname' value='".$data["name"]."' /></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td width='100px'><strong>".$locale["urg_a_usage_109"]."</strong></td>\n";
	echo "<td><input type='text' name='description' value='".$data["description"]."' class='textbox' style='width:200px;' /></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td width='100px'><strong>".$locale["urg_a_usage_110"]."</strong></td>\n";
	echo "<td><select name='purchase' class='textbox'>\n";
	echo "<option value='0'".($data["purchase"] == 0 ? " selected='selected'" : "").">".$locale["urg_a_usage_111"]."</option>\n";
	echo "<option value='1'".($data["purchase"] == 1 ? " selected='selected'" : "").">".$locale["urg_a_usage_112"]."</option>\n";
	echo "</select></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td width='100px'><strong>".$locale["urg_a_usage_113"]."</strong></td>\n";
	echo "<td><input type='text' name='cost' value='".$data["cost"]."' class='textbox' style='width:200px;' /></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td width='100px'><strong>".$locale["urg_a_usage_114"]."</strong></td>\n";
	echo "<td><input type='text' name='stock' value='".$data["stock"]."' class='textbox' style='width:200px;' /></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td width='100px'><strong>".$locale["urg_a_usage_115"]."</strong></td>\n";
	echo "<td><input type='text' name='image' value='".$data["image"]."' class='textbox' style='width:200px;' /></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td width='100px'><strong>".$locale["urg_a_usage_116"]."</strong></td>\n";
	echo "<td><select name='active' class='textbox'>\n";
	echo "<option value='0'".($data["active"] == 0 ? " selected='selected'" : "").">".$locale["urg_a_usage_111"]."</option>\n";
	echo "<option value='1'".($data["active"] == 1 ? " selected='selected'" : "").">".$locale["urg_a_usage_112"]."</option>\n";
	echo "</select></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td width='100px'><strong>Category:</strong></td>\n";
	echo "<td><select name='category' class='textbox'>".$categories_opts."</select></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td>&nbsp;</td>\n";
	echo "<td><input type='submit' name='save_item' value='".$locale["urg_a_usage_117"]."' class='button' /></td>\n";
	echo "</tr>\n</table>\n";
	echo "</form>\n";
	echo "</td>\n";
	echo "<td class='tbl-border' width='50%' valign='top'>\n";
	$user_groups = getusergroups(); $access_opts = ""; $sel = "";
	while(list($key, $user_group) = each($user_groups)){
		if ($user_group['0'] != 0) {
			$sel = ($c_data['cat_access'] == $user_group['0'] ? " selected='selected'" : "");
			$access_opts .= "<option value='".$user_group['0']."'$sel>".$user_group['1']."</option>\n";
		}
	}
	//Create / Edit Categories
	echo "<form name='cat_form' method='post' action='".$c_formaction."'>\n";
	echo "<table align='center' width='100%' cellspacing='2' cellpadding='2'>\n<tr>\n";
	echo "<td colspan='2'><h3>".$locale['urg_a_usage_135']."</h3></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td width='100px'><strong>".$locale['urg_a_usage_108']."</strong></td>\n";
	echo "<td><input type='hidden' name='cat_id' value='".$c_data["cat_name"]."' />\n";
	echo "<input type='text' name='cat_name' value='".$c_data["cat_name"]."' class='textbox' style='width:200px;' /></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td width='100px'><strong>".$locale['urg_a_usage_109']."</strong></td>\n";
	echo "<td><input type='text' name='cat_description' value='".$c_data["cat_description"]."' class='textbox' style='width:200px;' /></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td width='100px'><strong>".$locale['urg_a_usage_136']."</strong></td>\n";
	echo "<td><input type='text' name='cat_image' value='".($c_data["cat_image"] ? $c_data["cat_image"] : "blank.gif" )."' class='textbox' style='width:200px;' /></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td width='100px'><strong>".$locale['urg_a_usage_137']."</strong></td>\n";
	echo "<td><select name='cat_sorting' class='textbox'>\n";
	echo "<option value='price'".($c_data["cat_sorting"] == "price" ? " selected='selected'" : "").">".$locale['urg_a_usage_138']."</option>\n";
	echo "<option value='description'".($data["purchase"] == "description" ? " selected='selected'" : "").">".$locale['urg_a_usage_139']."</option>\n";
	echo "<option value='stock'".($data["purchase"] == "stock" ? " selected='selected'" : "").">".$locale['urg_a_usage_140']."</option>\n";
	echo "</select></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td width='100px'><strong>".$locale['urg_a_usage_141']."</strong></td>\n";
	echo "<td><select name='cat_access' class='textbox'>".$access_opts."</select></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td>&nbsp;</td>\n";
	echo "<td><input type='submit' name='save_cat' value='".$locale["urg_a_usage_117"]."' class='button' /></td>\n";
	echo "</tr>\n</table>\n";
	echo "</form>\n";
	echo "</td>\n</tr>\n</table>\n";
	closetable();
	
	//Current Items
	opentable($locale['urg_a_usage_118']);
	$result = dbquery("SELECT * FROM ".DB_UG3_USAGE." ORDER BY purchase ASC, name ASC LIMIT $rowstart,10");
	if (dbrows($result) != 0) {
		echo "<table align='center' width='100%' cellspacing='0' cellpadding='0' class='tbl-border'>\n<tr>\n";
		echo "<td class='tbl2'><strong>".$locale['urg_a_usage_134']."</strong></td>\n";
		echo "<td class='tbl2'><strong>".$locale['urg_a_usage_119']."</strong></td>\n";
		echo "<td class='tbl2'><strong>".$locale['urg_a_usage_120']."</strong></td>\n";
		echo "<td class='tbl2'><strong>".$locale['urg_a_usage_121']."</strong></td>\n";
		echo "<td class='tbl2'><strong>".$locale['urg_a_usage_122']."</strong></td>\n";
		echo "<td align='right' class='tbl2'><strong>".$locale['urg_a_usage_123']."</strong></td>\n";
		echo "</tr>\n";
		$i = 0;//color
		$activeY = '<img src="'.INFUSIONS.'user_gold/images/activey.png" style="border: 0;" title="'.$locale['urg_a_usage_122'].'" alt="'.$locale['urg_a_usage_122'].' '.$locale['urg_a_usage_112'].'" />';
		$activeN = '<img src="'.INFUSIONS.'user_gold/images/activen.png" style="border: 0;" title="'.$locale['urg_a_usage_122'].'" alt="'.$locale['urg_a_usage_122'].' '.$locale['urg_a_usage_111'].'" />';
		while ($data = dbarray($result)) {
			if ($i % 2 == 0) { $row_color = "tbl1"; } else { $row_color = "tbl2"; }
			echo "<tr class='".$row_color."'>\n";
			echo "<td>".$data["name"]."</td>\n";
			echo "<td>".$data["cost"]."</td>\n";
			echo "<td>".$data["stock"]."</td>\n";
			echo "<td align='center'>".($data["purchase"] == 1 ? $activeY : $activeN)."</td>\n";
			echo "<td align='center'>".($data["active"] == 1 ? $activeY : $activeN)."</td>\n";
			echo "<td align='right' valign='top'>\n";
			echo "<a style='cursor:help;' href='javascript:void(window.open(\"makecode.php?title=".$data["name"]."\",\"\",\"width=500,height=600\"));'>\n";
			echo "<img src='../images/makecode.png' title='".$locale["urg_a_usage_130"]."' alt='".$locale["urg_a_usage_130"]."' style='border: 0;' /></a>\n";
			echo "&nbsp;&nbsp;<a href='".FUSION_SELF.$aidlink."&amp;op=useage&amp;step=delete&amp;id=".$data["id"]."'>\n";
			echo "<img src='../images/delete.png' title='".$locale["urg_a_usage_124"]."' alt='".$locale["urg_a_usage_124"]."' style='border: 0;' /></a>\n";
			echo "&nbsp;&nbsp;<a href='".FUSION_SELF.$aidlink."&amp;op=useage&amp;step=edit&amp;id=".$data["id"]."'>\n";
			echo "<img src='../images/edit.png' title='".$locale["urg_a_usage_125"]."' alt='".$locale["urg_a_usage_125"]."' style='border: 0;' /></a></td>\n";
			echo "</tr>\n<tr class='".$row_color."'>\n";
			echo "<td colspan='6'><i>".$data["description"]."</i></td>\n";
			echo "</tr>\n<tr>\n";
			echo "<td colspan='6'><hr /></td>\n";
			echo "</tr>\n";
			$i++;
		}
		
		echo "</table>\n";
		$total_rows = dbcount("(*)", DB_UG3_USAGE);

		if ($total_rows > 10) echo "<div align='center' style='margin-top:5px;'>\n".makepagenav($rowstart,10,$total_rows,3,FUSION_SELF.$aidlink."&amp;op=useage&amp;")."\n</div>\n";
	
	} else {
		echo "<table align='center' width='100%' cellspacing='3' cellpadding='3' class='center'><tr><td align='center'>".$locale['urg_a_usage_132']."</td></tr></table>\n";
	}
	closetable();	
	
	//Current Categories
	opentable("Current Categories");
	$result = dbquery("SELECT * FROM ".DB_UG3_CATEGORIES." ORDER BY cat_name ASC LIMIT $c_rowstart,10");
	if (dbrows($result) != 0) {
		echo "<table align='center' width='100%' cellspacing='0' cellpadding='0' class='tbl-border'>\n<tr>\n";
		echo "<td class='tbl2'><strong>".$locale['urg_a_usage_134']."</strong></td>\n";
		echo "<td class='tbl2'><strong>".$locale['urg_a_usage_137']."</strong></td>\n";
		echo "<td class='tbl2'><strong>".$locale['urg_a_usage_141']."</strong></td>\n";
		echo "<td align='right' class='tbl2'><strong>".$locale['urg_a_usage_123']."</strong></td>\n";
		echo "</tr>\n";
		$i = 0;//color
		while ($data = dbarray($result)) {
			if ($i % 2 == 0) { $row_color = "tbl1"; } else { $row_color = "tbl2"; }
			echo "<tr class='".$row_color."'>\n";
			echo "<td>".$data["cat_name"]."</td>\n";
			echo "<td>".$data["cat_sorting"]."</td>\n";
			echo "<td>".$data["cat_access"]."</td>\n";
			echo "<td align='right' valign='top'>\n";
			echo "<a href='".FUSION_SELF.$aidlink."&amp;op=useage&amp;step=c_delete&amp;id=".$data["cat_id"]."'>\n";
			echo "<img src='../images/delete.png' title='".$locale['urg_a_usage_142']."' alt='".$locale['urg_a_usage_142']."' style='border: 0;' /></a>\n";
			echo "&nbsp;&nbsp;<a href='".FUSION_SELF.$aidlink."&amp;op=useage&amp;step=c_edit&amp;id=".$data["cat_id"]."'>\n";
			echo "<img src='../images/edit.png' title='".$locale['urg_a_usage_143']."' alt='".$locale['urg_a_usage_143']."' style='border: 0;' /></a></td>\n";
			echo "</tr>\n<tr class='".$row_color."'>\n";
			echo "<td colspan='6'><i>".$data["cat_description"]."</i></td>\n";
			echo "</tr>\n<tr>\n";
			echo "<td colspan='6'><hr /></td>\n";
			echo "</tr>\n";
			$i++;
		}
		
		echo "</table>\n";
		$total_rows = dbcount("(*)", DB_UG3_CATEGORIES);
		
		if ($total_rows > 10) echo "<div align='center' style='margin-top:5px;'>\n".makepagenav(c_rowstart,10,$total_rows,3,FUSION_SELF.$aidlink."&amp;op=useage&amp;")."\n</div>\n";
		
	} else {
		echo "<table align='center' width='100%' cellspacing='3' cellpadding='3' class='center'><tr><td align='center'>".$locale['urg_a_usage_144']."</td></tr></table>\n";
	}
	closetable();	
	
	//Permanent Items
	opentable($locale['urg_a_usage_126']);
	echo "<table align='center' width='100%' cellspacing='0' cellpadding='0' class='tbl'>\n<tr>\n";
	echo "<td class='tbl2'><strong>".$locale["urg_a_usage_134"]."</strong></td>\n";
	echo "<td class='tbl2'><strong>".$locale["urg_a_usage_119"]."</strong></td>\n";
	echo "<td class='tbl2'><strong>".$locale["urg_a_usage_121"]."</strong></td>\n";
	echo "<td class='tbl2'><strong>".$locale["urg_a_usage_122"]."</strong></td>\n";
	echo "<td align='right' class='tbl2'><strong>".$locale["urg_a_usage_123"]."</strong></td>\n";
	echo "</tr>\n<tr class='tbl1'>\n";
	echo "<td>".$locale["urg_a_usage_127"]."</td>\n";
	echo "<td>0</td>\n";
	echo "<td align='center'>".$activeN."</td>\n";
	echo "<td align='center'>".$activeY."</td>\n";
	echo "<td align='right' valign='top'>\n";
	echo "<a style='cursor:help;' href='javascript:void(window.open(\"makecode.php?title=activity\",\"\",\"width=500,height=600\"));'>\n";
	echo "<img src='../images/makecode.png' alt='".$locale["urg_a_usage_130"]."' style='border: 0;' /></a></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td colspan='5'><i>".$locale["urg_a_usage_128"]."</i></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td colspan='5'><hr /></td>\n";
	echo "</tr>\n<tr class='tbl2'>\n";
	echo "<td>".$locale["urg_a_usage_129"]."</td>\n";
	echo "<td>0</td>\n";
	echo "<td align='center'>".$activeN."</td>\n";
	echo "<td align='center'>".$activeY."</td>\n";
	echo "<td align='right' valign='top'>\n";
	echo "<a style='cursor:help;' href='javascript:void(window.open(\"makecode.php?title=getgold\",\"\",\"width=500,height=600\"));'>\n";
	echo "<img src='../images/makecode.png' title='".$locale["urg_a_usage_130"]."' alt='".$locale["urg_a_usage_130"]."' style='border: 0;' /></a></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td colspan='5'><i>".$locale["urg_a_usage_131"]."</i></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td colspan='5'><hr /></td>\n";
	echo "</tr>\n</table>\n";
	closetable();
}
?>