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

function RemoveExtension($strName)
{
$ext = strrchr($strName, '.');
if($ext !== false)
{
$strName = substr($strName, 0, -strlen($ext));
}
return $strName;
}
define("MOVIE_DIR", INFUSIONS."the_kroax/uploads/movies");

	echo '<form name="inputform" method="post" action="admin.php?a_page=loader&autoload">
    	<table width="100%" cellspacing="0" cellpadding="0"><tr>';
echo "<td align='right'><br>".$locale['KROAX210']."</td>";
echo '			<td><select class="textbox" name="loadcat">
				<option value="">'.$locale['LKROAX100'].'</option>';
			$catresult=dbquery("select * from ".$db_prefix."kroax_kategori order by cid ASC");
			while($catdata=dbarray($catresult)) 
			{
				echo '<option value="'.$catdata['cid'].'">'.$catdata['title'].'</option>';
			}		
	echo '</select></td></tr>';
echo "
<tr>
<td align='right'>".$locale['LKROAX101']."</td>
<td>";
	 echo '<SELECT size="5" multiple NAME="movie[]" class="textbox">';
	$handle=opendir(MOVIE_DIR);
	while (false!==($file = readdir($handle)))
	{
echo '<OPTION VALUE="'.$file.'">'.$file.'</OPTION>';
 }
closedir($handle);
echo '</select>';

echo '</td></tr> ';
echo "
<tr>
<td align='right' valign='top'>".$locale['KROAX112']."</td>
<td><textarea name='description' cols='45' rows='10' class='textbox'></textarea>
</td></tr>";
$news_visibility = "0";
$visibility_opts = ""; $sel = "";
	$user_groups = getusergroups();
	while(list($key, $user_group) = each($user_groups)){
$sel = ($news_visibility == $user_group['0'] ? " selected" : "");
	$visibility_opts .= "<option value='".$user_group['0']."'$sel>".$user_group['1']." </option>\n";
}
$check = 0;
$get_group = dbquery("SELECT group_name FROM ".$db_prefix."user_groups WHERE group_id='$check'");
while ($datagroup = dbarray($get_group))
$group = $datagroup['group_name'];
if($check == 101) $group="Member";
if($check == 102) $group="Admin";
if($check == 103) $group="SuperAdmin";
if($check == "0") $group="Public";
if($check == "") $check="0";
echo "<tr><td  align='right'>".$locale['LKROAX105']."</td>
<td><select name='access' class='textbox'>
<option selected value='".$check."'>$group
$visibility_opts</select></td>";

echo '<tr><td colspan="2" align="center">
<input type="hidden" name="action" value="loaditems">
<input class="button" type="submit" value="'.$locale['LKROAX106'].'">
</td></tr></table></form>';

if (isset($action)=='loaditems')
{

if ($_POST['loadcat']||$_POST['loadcat']!='')
{
$embed = "";
$uploader = $userdata['user_name'];
$lastplayed = "0";
$downloads = "0";
$hits = "0";
$catid = $_POST['loadcat'];
$upload_folder = "".$settings['siteurl']."infusions/the_kroax/uploads/movies/";
$photo_dest = "".$settings['siteurl']."infusions/the_kroax/uploads/thumbs/";


$getname=dbarray(dbquery("select * from ".$db_prefix."kroax_kategori WHERE cid='".$catid."'"));

	$movie=$_POST['movie'];
	if ($movie)
	{
		 foreach ($movie as $t)
		 {
		 		
				$itemname = RemoveExtension($t);
				$thumbfile = RemoveExtension($t).'.gif';
				$moviefile = $t;
				
$result = dbquery("INSERT INTO ".$db_prefix."kroax VALUES('', '$itemname', '$catid', '".$_POST['access']."', '0', '".time()."', '$embed', '$uploader', '$lastplayed','', '".$upload_folder."".$moviefile."', '$downloads', '$hits', '".$_POST['description']."', '".$photo_dest."".$thumbfile."', '')");

echo  "<center>File: <font color = 'red'><b> ".$itemname." </b></font>".$locale['LKROAX102']." <font color = 'red'><b>".$getname['title']."</b></font> ".$locale['LKROAX103']."<br></center>";
		
		 }
	}
}
else
{
echo "<font color = 'red'><b>".$locale['LKROAX104']." </b></font>";
}
}

?>
