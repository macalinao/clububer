<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--- ----------------------------------------------------+
| UBERPETS V 0.0.0.5
+--------------------------------------------------------+
| Uberpets Copyright 2008 Grr@µsoft inc.
| http://www.clububer.com/
+--------------------------------------------------------+
| Admin system based off of Varcade http://www.venue.nu/
\*---------------------------------------------------*/
if (!defined("IN_UBP")) { die("Access Denied"); }

$item_id = stripinput($_GET['item_id']);
$step = stripinput($_GET['step']);
$sortby = $_GET['sortby'];

if (isset($_GET['item_id']) && !isNum($_GET['item_id'])) redirect("index.php");

echo "<script type='text/javascript' src='".UBP_BASE."admin/js.js'></script>";

echo "<script language=javascript type=\"text/javascript\">
<!--Hide script from old browsers
function confirmdelete() {
return confirm(\"Delete?\")
}
//Stop hiding script from old browsers -->
</script>";

if (isset($step) && $step == "delete") {
	$removed_item_info = dbarray(dbquery("SELECT * FROM ".UPREFIX."items WHERE iid='$item_id'"));
	
	$deleter = dbquery("DELETE FROM ".UPREFIX."items WHERE iid='".$item_id."'");
	
	echo "
	<br>
	 The item ".$removed_item_info['name']." has been deleted from the database successfully.<br><br />";
	
	echo "<div style='text-align:center'><p><br>Huzzah!<br><br>
	[<a href='".UBP_BASE."admin/admin.php?a_page=items&ipage=items'>Back</a>]<br>
	[<a href='".UBP_BASE."admin/admin.php?a_page=main'>Back to Main Admin Page</a>]<br><br></p>
	</div>";
} else {
	if (isset($_POST['additem'])) {
			$item_name = stripinput($_POST['item_name']);
			$item_descr = stripinput($_POST['item_descr']);
			$item_action = stripinput($_POST['item_action']);
			$item_rarity = stripinput($_POST['item_rarity']);
			$item_value = stripinput($_POST['item_value']);
			$item_folder = stripinput($_POST['item_folder']);
			$item_image = stripinput($_POST['item_image']);
			$item_cat_id = stripinput($_POST['item_cat_id']);
			$item_visibility = stripinput($_POST['item_visibility']);
			$item_include = stripinput($_POST['item_include']);
			$item_option = stripinput($_POST['item_option']);			
			
				if (isset($step) && $step == "edit") {
					$result = dbquery("UPDATE ".UPREFIX."items SET  
					name='".$item_name."',
					description='".$item_descr."', 
					action='".$item_action."', 
					rarity='".$item_rarity."', 
					value = '".$item_value."',
					folder='".$item_folder."', 
					image ='".$item_image."', 
					cat_id='".$item_cat_id."', 
					visibility='', 
					include_file='".$item_include."', 
					option='".$item_option."' 
					WHERE iid='".$item_id."'");
				} else {
					$result = dbquery("INSERT INTO ".UPREFIX."items VALUES (
					'', 
					'".$item_name."', 
					'".$item_descr."', 
					'".$item_action."', 
					'".$item_rarity."', 
					'".$item_value."',
					'".$item_folder."',
					'".$item_image."',
					'".$item_cat_id."',
					'',
					'".$item_include."',
					'".$item_option."')");
				}
			redirect("".UBP_BASE."admin/admin.php?a_page=items&ipage=items");
	}
	
	if (isset($step) && $step == "edit") {
		$data = dbarray(dbquery("SELECT * FROM ".UPREFIX."items WHERE iid='$item_id'"));
		$item_name = $data['name'];
		$item_descr = $data['description'];
		$item_action = $data['action'];
		$item_rarity = $data['rarity'];
		$item_value = $data['value'];
		$item_folder = $data['folder'];
		$item_image = $data['image'];
		$item_cat_id = $data['cat_id'];
		$item_visibility = $data['visibility'];
		$item_include = $data['include_file'];
		$item_option = $data['option'];
		
		$formaction = FUSION_SELF."?a_page=items&ipage=items&step=edit&item_id=".$data['iid']."";
	} else {
		$check = "0";
		$item_name = "";
		$item_descr = "";
		$item_action = "";
		$item_rarity = "";
		$item_value = "";
		$item_folder = "";
		$item_image = "";
		$item_cat_id = "";
		$item_visibility = "";
		$item_include = "";
		$item_option = "";
		
		$formaction = FUSION_SELF."?a_page=items&ipage=items";
	}
	echo "
	<input type='text' 
	id='query' 
	class='textbox' 
	style=' height: 17px; width: 100px; border: 1px solid #000; background-color: #636363; color: #000; font-size: 12px;' 
	value='Search' 
	onBlur=\"if(this.value=='') 
	this.value='Search';\" 
	onFocus=\"if(this.value=='Search') 
	this.value='';\" 
	onKeyDown=\"if(event.keyCode==13) 
	Search();\">
	<a onClick=\"javascript:Search();\" class='button'>Search</a>";
	echo "<form name='additem' method='post' action='".$formaction."'>";
	echo "<br /><br /><center>Please do not leave any fields blank.</center><br /><br />";
	//Here comes the form...
	echo "<table align='center' cellspacing='5' cellpadding='0' class='tbl'>";
		//Item additem
		echo "<input type='hidden' name='additem' value='It is set, young Jedi. Hack me you do not do.'>";
		//Item Name
		echo "<tr>
		<td width='49%' align='right'>Item Name: <br /></td>
		<td><input type='text' name='item_name' value='".$item_name."' class='textbox' style='width:120px;'></td>
		</tr>\n";
		//Item Description
		echo "<tr>
		<td width='49%' align='right'>Item Description: <br /></td>
		<td><textarea name='item_descr' cols='45' rows='4'>".$item_descr."</textarea></td>
		</tr>\n";
		//Item Action
		echo "<tr>
		<td width='49%' align='right'>Item Action: <br /><h7>The PHP actions performed when using the item.</h7><br /><br /></td>
		<td><textarea name='item_action' cols='45' rows='4'>".$item_action."</textarea></td>
		</tr>\n";
		//Item Include File
		echo "<tr>
		<td width='49%' align='right'>Item Include: <br /><h7>The include file.</h7><br /><br /></td>
		<td><input type='text' name='item_include' value='".$item_include."' class='textbox' style='width:120px;'></td>
		</tr>\n";
		//Item Rarity
		echo "<tr>
		<td width='49%' align='right'>Item Rarity: <br /><h7>The rarity of the item. (0-999)</h7><br /><br /></td>
		<td><input type='text' name='item_rarity' value='".$item_rarity."' class='textbox' style='width:120px;'></td>
		</tr>\n";
		//Item Value
		echo "<tr>
		<td align='right'>Item Value: <br /><h7>Estimated value of item in currency. </h7><br /></td>
		<td><input type='text' name='item_value' value='".$item_value."' class='textbox' style='width:120px;'></td>
		</tr>\n";
		//Item Folder
		echo "<tr>
		<td align='right'>Item Folder: <br /></td>
		<td><input type='text' name='item_folder' value='".$item_folder."' class='textbox' style='width:120px;'></td>
		</tr>\n";
		//Item Image
		echo "<tr>
		<td align='right'>Item Image: <br /></td>
		<td><input type='text' name='item_image' value='".$item_image."' class='textbox' style='width:120px;'></td>
		</tr>\n";
		//Item Option
		echo "<tr>
		<td align='right'>Query or Include? <br /></td>
		<td>
		<select class='textbox' name='item_option'>";
		if (isset($step) && $step == "edit") {
			$option = dbarray(dbquery("SELECT option FROM ".UPREFIX."items WHERE iid='".$item_id."'"));
			if ($option == 1) {
				$option_name = "Include";
			} else {
				$option_name = "Query";
			}
		} else {
			$option = 0;
			$option_name = "Please Choose:&nbsp;";
		}
		echo "
		<option selected value='".$option."'>".$option_name."</option>
		<option value='1'>Include</option>
		<option value='2'>Query</option>
		</select>
		</td>
		</tr>\n";
		
		//Item Category
		echo "<tr><td align='right'>Item Category: <br /></td>";
		echo "<td>";
			echo "<select class='textbox' name='item_cat_id'>";
			if (isset($step) && $step == "edit") {
				$current_catdata = dbarray(dbquery("SELECT * FROM ".UPREFIX."items_cats WHERE cid='".$item_cat_id."'"));
			} else {
				$current_catdata = array(cid => 0, name => "Please select a category:");
			}
			echo "<option selected value='".$current_catdata['cid']."'>".$current_catdata['name']."</option>";
			$other_cats_query = dbquery("SELECT * FROM ".UPREFIX."items_cats ORDER BY name ASC");
				while($othercats_data = dbarray($other_cats_query)) {
					echo "<option value='".$othercats_data['cid']."'>".$othercats_data['name']."</option>";
				}
		echo "</select>";
		echo "</td></tr>\n";
		/*
		//Item Visibility Options
		$visibility_opts = "";
		$sel = "";
		$user_groups = getusergroups();
		while(list($key, $user_group) = each($user_groups)) {
			$sel = ($news_visibility == $user_group['0'] ? " selected" : "");
			$visibility_opts .= "<option value='".$user_group['0']."'$sel>".$user_group['1']." </option>\n";
		}
		$get_group = dbquery("SELECT group_name FROM ".$db_prefix."user_groups WHERE group_id='$check'");
		while ($datagroup = dbarray($get_group)) {
			$group = $datagroup['group_name'];
		}
		
		if($check == 101) $group="Member";
		if($check == 102) $group="Admin";
		if($check == 103) $group="SuperAdmin";
		if($check == "0") $group="Public";
		if($check == "") $check="0";
		echo "<tr><td align='right'>Visibility Options: <br /></td>";
		echo "<td><select name='item_visibility' class='textbox'>";
		echo "<option selected value='".$check."'>".$group."";
		echo $visibility_opts;
		echo "</select>";
		echo "</td></tr>\n";
		*/
		//Submit Button
		echo "<tr><td colspan='2' align='center'><input type='submit' value='Submit' class='button'></td></tr>\n";
	//End of story, schmut, schmut.
	echo "</table>\n";
	echo "</form>";
	
	tblbreak();
	
	echo "<div id='lajv'>";
	if (!isset($_GET['sortby']) || !preg_match("/^[0-9A-Z]$/", $sortby)) $sortby = "all";
	$orderby = ($sortby == "all" ? "" : " WHERE name LIKE '$sortby%'");
	$result = dbquery("SELECT * FROM ".UPREFIX."items".$orderby."");
	$rows = dbrows($result);
	if (!isset($rowstart) || !isNum($rowstart)) $rowstart = 0;
	if ($rows != 0) {
		echo "<table align='center' width='100%' cellspacing='0'>
		<tr>
		<td align='left' class='tbl2' width='30%'><b>Item</b></td>
		<td align='center' class='tbl2' width='35%'><b>Path</b></td>
		<td align='center' class='tbl2' width='30%'><b>Category</b></td>
		<td align='right' class='tbl2' width='5%'><b>Delete</b></td>
		</tr>\n";
		$result = dbquery("SELECT * FROM ".UPREFIX."items".$orderby." ORDER BY iid DESC, name LIMIT $rowstart,10");
			while ($data = dbarray($result)) {
				echo "<tr>\n<td class='small' width='22%'><img src='".THEME."images/bullet.gif' alt=''>";
				echo "<a href='".UBP_BASE."admin/admin.php?a_page=items&ipage=items&step=edit&item_id=".$data['iid']."'><b>".$data['name']."</b></a></td>\n";
				echo "<td class='small' align='center' width='12%'>".$data['folder']."/".$data['image']."</td>";
				echo "<td class='small' align='center' width='5%'>".$data['cat_id']."</td>";
				echo "</td>";
				echo "<td class='small' align='right' width='7%'><a href='".UBP_BASE."admin/admin.php?a_page=items&ipage=items&step=delete&item_id=".$data['iid']."' onClick='return confirmdelete();'>Delete</a></td></tr>";
			}
		echo "</table>\n";
		echo "<hr>";
		echo "<div align='center' style='margin-top:5px;'>".makePageNav($rowstart,10,$rows,3,FUSION_SELF."?a_page=items&ipage=items&sortby=".$sortby."&")."\n</div>\n";
	} else {
		echo "<center><br>\n<b>".$sortby."<b><br><br>\n</center>\n";
	}
	echo "</div>";
	$search = array(
	"A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R",
	"S","T","U","V","W","X","Y","Z","0","1","2","3","4","5","6","7","8","9"
	);
	echo "<hr><table align='center' cellpadding='0' cellspacing='1' class='tbl-border'>\n<tr>\n";
	echo "<td rowspan='2' class='tbl2'><a href='".UBP_BASE."admin/admin.php?a_page=items&ipage=items&sortby=all'>Show All</a></td>";
	for ($i=0;$i < 36!="";$i++) {
	echo "<td align='center' class='tbl1'><div class='small'><a href='".UBP_BASE."admin/admin.php?a_page=items&ipage=items&sortby=".$search[$i]."'>".$search[$i]."</a></div></td>";
	echo ($i==17 ? "<td rowspan='2' class='tbl2'><a href='".UBP_BASE."admin/admin.php?a_page=items&ipage=items&sortby=all'>Show All</a></td>\n</tr>\n<tr>\n" : "\n");
	}
	echo "</table>\n";
}
?>