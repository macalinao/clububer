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
if (!iADMIN) { header("Location:../../../index.php"); exit; }


if (isset($step) && $step == "delete") {
$result = dbquery("DELETE FROM ".$db_prefix."kroax_kategori WHERE cid='$cid'");
redirect("admin.php?a_page=categories");
	}


define("CAT_DIR", INFUSIONS."the_kroax/categoryimg/");
$cat_files = makefilelist(CAT_DIR, ".|..|index.php", true);
$cat_list = makefileopts($cat_files,$image);


$visibility_opts = ""; $sel = "";
	$user_groups = getusergroups();
	while(list($key, $user_group) = each($user_groups)){
		$sel = ($news_visibility == $user_group['0'] ? " selected" : "");
		$visibility_opts .= "<option value='".$user_group['0']."'$sel>".$user_group['1']."</option>\n";
	}


function getparent($parentid,$title) 
{
global $db_prefix;
	$result=dbquery("select * from ".$db_prefix."kroax_kategori where cid=$parentid");
	$data = dbarray($result);
	if ($data['title']!="") $title=$data['title']." &raquo; ".$title;
	if ($data['parentid']!=0) 
	{
		$title=getparent($data['parentid'],$title);
	}
    return $title;
}

if (isset($_POST['kroaxSaveCategoryChanges'])) {

	// Check if Title exist
	if ($_POST['title_u']=="")
	{
		
		echo "
		<table width='100%' cellspacing='2' cellpadding='3' border='0'>
		<tr><td colspan='2'><font color='red'><b>".$locale['CKROAX111']."</b></font></td></tr>
		</table>";
		kroaxBackButton(1);
		exit(0);
	} 
	else 
	{
$access= $_post[access];
	if($_post[access] == "") $access="0";
		dbquery("UPDATE ".$db_prefix."kroax_kategori SET title = '$_POST[title_u]', access= '$access',  image = '$_POST[image_u]', parentid = '$_POST[parentid_u]', status = '$_POST[status_u]' WHERE cid ='$_POST[cid_u]' LIMIT 1 ;");
redirect("admin.php?a_page=categories");

	}

}

if (isset($_POST['kroaxEditCurrentCategory'])) {
			
			$result=dbquery("select * from ".$db_prefix."kroax_kategori where cid=$_POST[cat]");
			$cat_data = dbarray($result);
			$stitle=getparent($cat_data['parentid'],$cat_data['title']);
			$title1="$stitle";
			$image=$cat_data['image'];

		echo '<form action="admin.php?a_page=categories&kroaxSaveCategoryChanges" method="post">
<table>
<tr>
<td colspan="2"></td></tr>
<tr>
	<td><b>'.$locale['CKROAX106'].'</b></td>
	<td><input class="textbox" type="text" name="title_u" size="30" value="'.$cat_data['title'].'"/></td>
</tr>
<tr>
<td><b>'.$locale['CKROAX105'].'</b></td>
<td>';
echo "
<select name='image_u' class='textbox' style='width:200px;'>
<option value='default.gif'>-- Default --</option>
$cat_list
</select>
<br><img src='".CAT_DIR.($image!=''?$image:"")."' alt=''>
";
echo '</td>
</tr>
<tr>
	<td><b>'.$locale['CKROAX107'].'</b></td>
	<td><select class="textbox" name="parentid_u">';
if ($cat_data['parentid'])
{
echo '<option value="'.$cat_data['parentid'].'">'.$title1.'</option>	';
}
echo '<option value="0">'.$locale['CKROAX108'].'</option>	';

			$result=dbquery("select cid, title, parentid from ".$db_prefix."kroax_kategori order by parentid,title");
			while(list($cid, $title, $parentid) = dbarraynum($result)) 
			{
			if ($parentid!=0) 
			{
			$title=getparent($parentid,$title);
			}
			echo '<option value="'.$cid.'">'.$title.'</option>';
			}
		echo '
		</select></td>
</tr>
<tr>
	<td><b>'.$locale['CKROAX101'].'</b></td>
	<td>	<select class="textbox" name="status_u" size="1">
			<option value="'.$cat_data['status'].'" SELECTED>'.$locale['CKROAX102'].'</option>
			<option value="1">'.$locale['CKROAX103'].'</option>
			<option value="2">'.$locale['CKROAX104'].'</option>
			</select></td></tr>';

echo '<tr><td><b>'.$locale['CKROAX109'].'</b></td>';
echo "<td>";
$get_group = dbquery("SELECT group_name FROM ".$db_prefix."user_groups WHERE group_id='$access'");
while ($datagroup = dbarray($get_group))
$group = $datagroup['group_name'];
if($access == 101) $group="Member";
if($access == 102) $group="Admin";
if($access == 103) $group="SuperAdmin";
if($access == "0") $group="Public";
if($access == "") $group="Public";
echo "
<select name='access' class='textbox'>
<option selected value='".$access."'>$group
$visibility_opts</select></td></tr>";

	echo '<tr>
		<td align="center" colspan="2">
		<input type="hidden" name="cid_u" value="'.$cat.'">
		<input type="hidden" name="kroaxSaveCategoryChanges" value="kroaxSaveCategoryChanges">
		<input class="button" type="submit" name="submit" value="'.$locale['CKROAX112'].'  &raquo; '.$cat_data['title'].'"><br><br>
	<a href="admin.php?a_page=categories&step=delete&cid='.$cat.'"><b>'.$locale['CKROAX117'].'  &raquo;  '.$stitle.'</b></a>
		</td></tr>
		</table></form>';
echo "<HR>";
}

if (isset($_POST['kroaxAddSubCategory'])) {
	$result = dbquery("select cid from ".$db_prefix."kroax_kategori where title='$_POST[title]' AND parentid='$_POST[cid]'");
	$numrows = dbrows($result);

	if ($numrows>0) {
		echo "
		<table width='100%' cellspacing='1' cellpadding='3' border='0'>
		<tr><td colspan='2'><font color='red'><b>".$_POST['title']."</b> <b>".$locale['CKROAX110']."</b></font></td></tr>
		</table>";
		kroaxBackButton(1);
	} else {
		// Check if Title exist
		if ($_POST['title']=="")
		{
			echo "
			<table width='100%' cellspacing='2' cellpadding='3' border='0'>
			<tr><td colsapn='2'><font color='red'><b>".$locale['CKROAX111']."</b></font></td></tr>
			</table>";
			kroaxBackButton(1);
			echo "</td>\n";
			include BASEDIR."footer.php";
			exit();
		}
	$access = $_post[access];
	if($_post[access] == "") $access="0";
	dbquery("INSERT INTO ".$db_prefix."kroax_kategori ( cid , title ,access, image , parentid , status )VALUES ('', '$_POST[title]','$access',  '$_POST[image_u]', '$_POST[cid]', '$_POST[status]');");

redirect("admin.php?a_page=categories");
		
	}
}


if (isset($_POST['kroaxAddMainCategory'])) {

	$parentid=0;//main cat? ensure it is
	$result = dbquery("select cid from ".$db_prefix."kroax_kategori where title='$_POST[title]'");
	//check for duplicates
	$numrows = dbrows($result);

	if ($numrows>0)
	{
		echo '
		<table width="100%" class="tbl" border="0">
		<tr>
		<td colspan="2"></td>
		</tr>
		<tr>
		<td colspan="2"><font color="red"><b>'.$_POST['title'].'</b> <b>'.$locale['CKROAX110'].'</b></font><br></td>
		</tr>
		</table>';
		
	} 
	else 
	{
		// Check if Title exist
		if ($_POST['title']=="")
		{
			echo '
			<table width="100%" border="0" class="tbl">
			<tr>
			<td colspan="2"><font color="red"><b>'.$locale['CKROAX111'].'</b></font></td>
			</tr>
			</table>';
			kroaxBackButton(1);
			echo "</td>\n";
			include BASEDIR."footer.php";
			exit();
			
		}
$access = $_post[access];
	if($_post[access] == "") $access="0";
		dbquery("INSERT INTO ".$db_prefix."kroax_kategori ( cid , title ,access, image , parentid , status )VALUES ('', '$_POST[title]','$access', '$_POST[image]', '0', '$_POST[status]');");
		
redirect("admin.php?a_page=categories");
		
	}

}



//Add main category
echo '<table>
<form  method="post" action="admin.php?a_page=categories&kroaxAddMainCategory">
<input type="hidden" name="kroaxAddMainCategory" value="kroaxAddMainCategory" />
<tr>
	<td><b>'.$locale['CKROAX100'].'</b></td>
	<td><input class="textbox" type="text" name="title" size="30" maxlength="100"/></td>
</tr>
<tr>
	<td><b>'.$locale['CKROAX105'].'</b></td><td>';
$image="default.gif";
echo "
<select name='image' class='textbox' style='width:200px;'>
<option value='default.gif'>-- Default --</option>
$cat_list
</select>
<br><img src='".CAT_DIR.($image!=''?$image:"")."' alt=''>
";
echo '</td>
</tr>
<tr>
	<td><b>'.$locale['CKROAX101'].'</b></td>
	<td><select class="textbox" name="status" size="1">
			<option value="1" SELECTED>'.$locale['CKROAX102'].'</option>
			<option value="1">'.$locale['CKROAX103'].'</option>
			<option value="2">'.$locale['CKROAX104'].'</option>
		</select></td></tr>
';

echo '<tr><td><b>'.$locale['CKROAX109'].'</b></td>';
echo "<td>";
$get_group = dbquery("SELECT group_name FROM ".$db_prefix."user_groups WHERE group_id='$access'");
while ($datagroup = dbarray($get_group))
$group = $datagroup['group_name'];
if($access == 101) $group="Member";
if($access == 102) $group="Admin";
if($access == 103) $group="SuperAdmin";
if($access == "0") $group="Public";
if($access == "") $group="Public";
echo "
<select name='access' class='textbox'>
<option selected value='".$access."'>$group
$visibility_opts</select></td></tr>";

echo '

<tr align="center">
	<td colspan="2">
	<input type="hidden" name="cid" value="0">
	<input class="button" type="submit" value="'.$locale['CKROAX112'].'" /></td>
</tr>
</table></form>';

//Add Sub-Categories
echo "<HR>";
tablebreak();
$result = dbquery("select * from ".$db_prefix."kroax_kategori");
	$numrows = dbrows($result);
	if ($numrows > 0) 
	{
	
$image = "default.gif";
echo '<table>
<form method="post" action="admin.php?a_page=categories&kroaxAddSubCategory">
<tr>
	<td><b>'.$locale['CKROAX113'].'</b> </td>
	<td><input class="textbox" type="text" name="title" size="30" maxlength="100"/></td>
</tr>
<tr>
	<td><b>'.$locale['CKROAX105'].'</b> </td><td>';
echo "
<select name='image_u' class='textbox' style='width:200px;'>
<option value='default.gif'>-- Default --</option>
$cat_list
</select>
<br><img src='".CAT_DIR.($image!=''?$image:"")."' alt=''>
";

echo '</td>
</tr>
<tr>
	<td><b>'.$locale['CKROAX107'].'</b> </td>
	<td><select class="textbox" name="cid">';
			$result=dbquery("select cid, title, parentid from ".$db_prefix."kroax_kategori order by parentid,title");
			while(list($cid, $title, $parentid) = dbarraynum($result)) 
			{
			if ($parentid!=0) $title=getparent($parentid,$title);
			echo '<option value="'.$cid.'">'.$title.'</option>';
			}
		echo '
		</select></td>
</tr>
<tr>
	<td><b>'.$locale['CKROAX101'].'</b> </td>
	<td>
			<select class="textbox" name="status" size="1">
			<option value="1" SELECTED>'.$locale['CKROAX102'].'</option>
			<option value="1">'.$locale['CKROAX103'].'</option>
			<option value="2">'.$locale['CKROAX104'].'</option>
			</select>
	</td>
</tr>';

echo '<tr><td><b>'.$locale['CKROAX109'].'</b></td>';
echo "<td>";
$get_group = dbquery("SELECT group_name FROM ".$db_prefix."user_groups WHERE group_id='$access'");
while ($datagroup = dbarray($get_group))
$group = $datagroup['group_name'];
if($access == 101) $group="Member";
if($access == 102) $group="Admin";
if($access == 103) $group="SuperAdmin";
if($access == "0") $group="Public";
if($access == "") $group="Public";
echo "
<select name='access' class='textbox'>
<option selected value='".$access."'>$group
$visibility_opts</select></td></tr>";
echo '
<tr align="center">
	<td colspan="2">
<input type="hidden" name="kroaxAddSubCategory" value="kroaxAddSubCategory" />
<input class="button" type="submit" value="'.$locale['CKROAX112'].'" /></td>
</tr>
</table></form>';
echo "<HR>";
tablebreak();


//Modify Category

	echo '
	<table width="100%" border="0" cellspacing="2" cellpadding="3">
	<tr>
	<td>';

		echo '
		<form method="post" action="admin.php?a_page=categories&kroaxEditCurrentCategory">
		'.$locale['CKROAX106'].' <select class="textbox" name="cat">';

		$result2=dbquery("select * from ".$db_prefix."kroax_kategori order by parentid, title");
		while($cat_data = dbarray($result2)) 
		{
			if ($cat_data[parentid]!=0) $cat_data[title]=getparent($cat_data[parentid],$cat_data[title]);
	    		echo '<option value="'.$cat_data[cid].'" selected>'.$cat_data[title].'</option>';
		}

		echo '</select>
	    	<input type="hidden" name="kroaxEditCurrentCategory" value="kroaxEditCurrentCategory">
	    	<input class="button" type="submit" value="'.$locale['CKROAX114'].'">
	    	</td>
			</tr>
			</form>
			</table>';

	}
	else
	{

	echo $locale['CKROAX115'];

	}

 function kroaxBackButton($num)
 {
 global $locale;
 echo '<form name="BackButton"><input class="button" type="Button" value="'.$locale['CKROAX116'].'" onClick="history.back('.$num.')"></form>';
 }
 
?>