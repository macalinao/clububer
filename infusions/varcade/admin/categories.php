<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Author: Domi & fetloser
| www.venue.nu			     	      
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
if (!checkRights("I")) { header("Location:../../../index.php"); exit; }

define("CAT_DIR", INFUSIONS."varcade/categoryimg/");
$cat_files = makefilelist(CAT_DIR, ".|..|index.php", true);
$cat_list = makefileopts($cat_files);

if (isset($stats_id_cat) && !isNum($stats_id_cat)) fallback("index.php");

if (isset($step) && $step == "delete") {
$result = dbquery("DELETE FROM ".$db_prefix."varcade_cats WHERE cid='$stats_id_cat'");
} 
if (isset($_POST['save_cat'])) {
$title = stripinput($_POST['title']);
$cid = stripinput($_POST['cid']);
$access = stripinput($_POST['access']);
$cat_image = stripinput($_POST['cat_image']);

if (isset($step) && $step == "edit") {
$result = dbquery("UPDATE ".$db_prefix."varcade_cats SET title='$title', access='$access',image='$cat_image' WHERE cid ='$stats_id_cat'");
} else {
$result = dbquery("INSERT INTO ".$db_prefix."varcade_cats (cid, title,image,access) VALUES('', '$title','$cat_image', '$access')");

}
redirect("".INFUSIONS."varcade/admin/admin.php?a_page=categories");
}
if (isset($step) && $step == "edit") {
	$result = dbquery("SELECT * FROM ".$db_prefix."varcade_cats WHERE cid='$stats_id_cat'");
	$data = dbarray($result);
	$cid = $data['cid'];
	$title = $data['title'];
	$access = $data['access'];
            $cat_image = $data['image'];
	if(@$visibility_opts == "") $visibility_opts="0";
	$formaction = "".INFUSIONS."varcade/admin/admin.php?a_page=categories&step=edit&stats_id_cat=".$data['cid']."";

} else {
	$cid = ""; 
	$title = ""; 
	$access = "0";
            $cat_image = "default.gif";
	$formaction = "".INFUSIONS."varcade/admin/admin.php?a_page=categories";

}

$visibility_opts = ""; $sel = "";
	$user_groups = getusergroups();
	while(list($key, $user_group) = each($user_groups)){
		$sel = (@$news_visibility == $user_group['0'] ? " selected" : "");
		$visibility_opts .= "<option value='".$user_group['0']."'$sel>".$user_group['1']."</option>\n";

}
echo "
<table align='center' width='100%' cellspacing='0' cellpadding='0' class='tbl'>
<form name='addcat' method='post' action='$formaction'>
<td width='20%' align='center' valign='top'>
<table align='center' cellspacing='0' cellpadding='0' class='tbl'>
<td>
<select name='cat_image' class='textbox' style='width:200px;' onChange=\"document.cat_image_preview.src = '".CAT_DIR."' + document.addcat.cat_image.options[document.addcat.cat_image.selectedIndex].value;\">
<option value='".$cat_image."'>".$locale['VARC350']."</option>
$cat_list
</select>
</td>
<td width='10%' align='center'>".$locale['VARC351']."</td>
<td align='center'><input type='text' name='title' value='$title' class='textbox' style='width:120px;'> </td> 
<td>
".$locale['422']."</td><td>";
$get_group = dbquery("SELECT group_name FROM ".$db_prefix."user_groups WHERE group_id='$access'");
while ($datagroup = dbarray($get_group))
$group = $datagroup['group_name'];
if($access == 101) $group="Member";
if($access == 102) $group="Admin";
if($access == 103) $group="SuperAdmin";
if($access == "0") $group="Public";
if($access == "") $group="Public";
echo"
<select name='access' class='textbox'>
<option selected value='".$access."'>$group
$visibility_opts</select><br>
<td align='center' colspan='3'>
<td align='right' colspan='1'>

<input type='submit'name='save_cat' value='".$locale['VARC407'] ."' class='button'></td>
</td>
</table>
</table>
</form>\n";
tablebreak();

echo "<table align='center' width='55%' cellspacing='0'>
<td class='tbl2' width='30%'><b>".$locale['VARC351']."</b></td>
<td class='tbl2' align='right' width='10%'><b>".$locale['VARC352']."</b></td>
</tr>\n";


if (!isset($sortby) || !preg_match("/^[0-9A-Z]$/", $sortby)) $sortby = "all";
$orderby = ($sortby == "all" ? "" : " WHERE title LIKE '$sortby%'");
$result = dbquery("SELECT * FROM ".$db_prefix."varcade_cats".$orderby."");
$rows = dbrows($result);
if (!isset($rowstart) || !isNum($rowstart)) $rowstart = 0;
if ($rows != 0) {

$result = dbquery("SELECT * FROM ".$db_prefix."varcade_cats".$orderby." ORDER BY title ASC, title LIMIT $rowstart,25");
echo "<br><img src='".CAT_DIR.($cat_image!=''?$cat_image:"")."' name='cat_image_preview' alt=''>";

while ($data = dbarray($result)) {

echo "<table align='center' width='55%' cellspacing='0'>";
echo "<tr><td class='small' width='30%'><img src='".THEME."images/bullet.gif' alt=''> <a href='admin.php?a_page=categories&step=edit&stats_id_cat=".$data['cid']."'><b>".$data['title']."</b></a></td>\n";


echo "<td class='small' align='right' width='30%'><a href='admin.php?a_page=categories&step=delete&stats_id_cat=".$data['cid']."'>".$locale['VARC352']."</a></td></tr>";
echo "</table>\n";
} 
echo "<div align='center' style='margin-top:5px;'>".makePageNav($rowstart,25,$rows,3,"FUSION_SELF?a_page=categories&sortby=$sortby&")."\n</div>\n";
} else {
echo "<center><br>".$locale['VARC354']." <b>$sortby<b><br></center>\n";
}
$search = array(
"A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R",
"S","T","U","V","W","X","Y","Z","0","1","2","3","4","5","6","7","8","9"
);
echo "<hr><table align='center' cellpadding='0' cellspacing='1' class='tbl-border'>\n<tr>\n";
echo "<td rowspan='2' class='tbl2'><a href='".INFUSIONS."varcade/admin/admin.php?a_page=categories&sortby=all'>".$locale['VARC353']."</a></td>";
for ($i=0;$i < 36!="";$i++) {
echo "<td align='center' class='tbl1'><div class='small'><a href='".INFUSIONS."varcade/admin/admin.php?a_page=categories&sortby=".$search[$i]."'>".$search[$i]."</a></div></td>";
echo ($i==17 ? "<td rowspan='2' class='tbl2'><a href='".INFUSIONS."varcade/admin/admin.php?a_page=categories&sortby=all'>".$locale['VARC353']."</a></td>\n</tr>\n<tr>\n" : "\n");
}
echo "</table>\n";
?>