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

$step = stripinput($_GET['step']);
$cid = stripinput($_GET['cid']);

if (isset($_GET['cid']) && !isNum($_GET['cid'])) redirect("index.php");

if (isset($step) && $step == "delete") {
$result = dbquery("DELETE FROM ".UPREFIX."items_cats WHERE cid='".$cid."'");
}
if (isset($_POST['save_cat'])) {
	$name = stripinput($_POST['name']);
	$default_color = stripinput($_POST['default_color']);
	
	if (isset($step) && $step == "edit") {
		$result = dbquery("UPDATE ".UPREFIX."items_cats SET name='$name' WHERE cid ='$cid'");
	} else {
		$result = dbquery("INSERT INTO ".UPREFIX."items_cats (cid, name) VALUES('', '$name')");
	}
	redirect(UBP_BASE."admin/admin.php?a_page=items&ipage=item_cats");
}
if (isset($step) && $step == "edit") {
	$data = dbarray(dbquery("SELECT * FROM ".UPREFIX."items_cats WHERE cid='$cid'"));
	$name = $data['name'];
	$formaction = UBP_BASE."admin/admin.php?a_page=items&ipage=item_cats&step=edit&cid=".$data['cid'];

} else {
	$name = ""; 
	$formaction = UBP_BASE."admin/admin.php?a_page=items&ipage=item_cats";

}

echo "
<center>
<form name='create_species' method='post' action='$formaction'>
<table width='100%' border='0'>

<tr>

<td width='50%' align='right'><b>Category Name:</b></td>

<td width='50%' align='left'>
<input type='text' name='name' value='".$name."' class='textbox' style='width:120px;'>
</td>

</tr>
<tr>
<td>
<input type='submit' name='save_cat' value='Save Pet' class='button'>
</td>
</tr>
</table>
</form>\n
</center>";
tblbreak();
echo "<table align='center' width='55%' cellspacing='0'>
<td class='tbl2' width='30%'><b>".$locale['VARC351']."</b></td>
<td class='tbl2' align='right' width='10%'><b>".$locale['VARC352']."</b></td>
</tr>\n";


if (!isset($sortby) || !preg_match("/^[0-9A-Z]$/", $sortby)) $sortby = "all";
$orderby = ($sortby == "all" ? "" : " WHERE name LIKE '$sortby%'");
$result = dbquery("SELECT * FROM ".UPREFIX."items_cats".$orderby."");
$rows = dbrows($result);
if (!isset($rowstart) || !isNum($rowstart)) $rowstart = 0;
if ($rows != 0) {

$result = dbquery("SELECT * FROM ".UPREFIX."items_cats".$orderby." ORDER BY name ASC, name LIMIT $rowstart,25");
echo "<br><img src='".PETS.($folder!=''?$folder:"")."/Normal.gif' name='folder_preview' alt=''>";

while ($data = dbarray($result)) {

echo "<table align='center' width='55%' cellspacing='0'>";
echo "<tr><td class='small' width='30%'><img src='".THEME."images/bullet.gif' alt=''> <a href='admin.php?a_page=items&ipage=item_cats&step=edit&cid=".$data['cid']."'><b>".$data['name']."</b></a></td>\n";


echo "<td class='small' align='right' width='30%'><a href='admin.php?a_page=items&ipage=item_cats&step=delete&cid=".$data['cid']."'>Delete</a></td></tr>";
echo "</table>\n";
} 
echo "<div align='center' style='margin-top:5px;'>".makePageNav($rowstart,25,$rows,3,"$FUSION_SELF?a_page=items&ipage=item_cats&sortby=$sortby&")."\n</div>\n";
} else {
echo "<center><br>".$locale['VARC354']." <b>$sortby<b><br></center>\n";
}
$search = array(
"A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R",
"S","T","U","V","W","X","Y","Z","0","1","2","3","4","5","6","7","8","9"
);
echo "<hr><table align='center' cellpadding='0' cellspacing='1' class='tbl-border'>\n<tr>\n";
echo "<td rowspan='2' class='tbl2'><a href='".UBP_BASE."admin/admin.php?a_page=items&ipage=item_cats&sortby=all'>".$locale['VARC353']."</a></td>";
for ($i=0;$i < 36!="";$i++) {
echo "<td align='center' class='tbl1'><div class='small'><a href='".UBP_BASE."admin/admin.php?a_page=items&ipage=item_cats&sortby=".$search[$i]."'>".$search[$i]."</a></div></td>";
echo ($i==17 ? "<td rowspan='2' class='tbl2'><a href='".UBP_BASE."admin/admin.php?a_page=items&ipage=item_cats&sortby=all'>".$locale['VARC353']."</a></td>\n</tr>\n<tr>\n" : "\n");
}
echo "</table>\n";
?>