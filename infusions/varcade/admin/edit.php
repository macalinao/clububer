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
require_once "../../../maincore.php";
require_once THEME."theme.php";
echo "<link rel='stylesheet' href='".THEME."styles.css' type='text/css'>";

if (!checkRights("I")) { header("Location:../../../index.php"); exit; }
if (isset($game) && !isNum($game)) fallback("".BASEDIR."index.php");

if (!defined("LANGUAGE")) {
// PHPFusion environment
$this_lang =  str_replace("/", "", LOCALESET);
	if (file_exists(INFUSIONS."varcade/locale/".$this_lang.".php")) {
	   include INFUSIONS."varcade/locale/".$this_lang.".php";
	} else {
	   include INFUSIONS."varcade/locale/English.php";
	}
        } else {
// mFusion environment
$this_lang =  LANGUAGE;
	if (file_exists(INFUSIONS."varcade/locale/".$this_lang.".php")) {
	   include INFUSIONS."varcade/locale/".$this_lang.".php";
	} else {
	   include INFUSIONS."varcade/locale/English.php";
	}
}


$resultvset = dbquery("SELECT * FROM ".$db_prefix."varcade_settings");
$varcsettings = dbarray($resultvset);

if (isset($_POST['save_cat'])) {
	$stats_title = stripinput($_POST['stats_title']);
	$stats_status = stripinput($_POST['stats_status']);
	$stats_control = stripinput($_POST['stats_control']);
	$stats_reverse = stripinput($_POST['stats_reverse']);
	$stats_description = stripinput($_POST['stats_description']);
	$stats_access = stripinput($_POST['stats_access']);
	$stats_width = stripinput($_POST['stats_width']);
	$stats_height = stripinput($_POST['stats_height']);
	$stats_category = stripinput($_POST['stats_category']);

$result = dbquery("UPDATE ".$db_prefix."varcade_games SET cid='$stats_category', title='$stats_title', status='$stats_status', width='$stats_width',height='$stats_height',control='$stats_control', reverse='$stats_reverse', 
description='$stats_description', access='$stats_access', cid='$stats_category' WHERE lid='$stats_id'");
redirect("".INFUSIONS."varcade/admin/edit.php?game=".$stats_id."");
}

	$result = dbquery("SELECT * FROM ".$db_prefix."varcade_games WHERE lid='$game'");
	$game = dbarray($result);

	$stats_title = $game['title'];
	$stats_status = $game['status'];
	$stats_control = $game['control'];
	$stats_reverse = $game['reverse'];
	$stats_description = $game['description'];
	$stats_category = $game['cid'];
	$stats_access = $game['access'];
	$stats_width = $game['width'];
	$stats_height = $game['height'];


if ($game['status'] == "1")
{
$current_status = $locale['VARC412'];
}
if ($game['status'] == "2")
{
$current_status = $locale['VARC411'];
}

if ($game['control'] == "1")
{
$current_control = $locale['VARC413'];
}
if ($game['control'] == "0")
{
$current_control = $locale['VARC414'];
}

if ($game['reverse'] == "1")
{
$current_reverse = $locale['VARC416'];
}
if ($game['reverse'] == "0")
{
$current_reverse = $locale['VARC415'];
}


echo "<form name='addcat' method='post' action='".INFUSIONS."varcade/admin/edit.php?edit&stats_id=".$game['lid']."'>
<table align='center' width='100%' cellspacing='0' cellpadding='0'>";

echo "<tr><td  align='center'>".$locale['VARC401']." </td>
<td><input type='text' name='stats_title' value='$stats_title' class='textbox' style='width:120px;'></td>
</tr>";

$resultc = dbquery("SELECT * FROM ".$db_prefix."varcade_cats WHERE cid='$stats_category'");
$cdata = dbarray($resultc);
echo "<tr><td  align='center'>".$locale['VARC402']." </td>";
echo '<td><select class="textbox" name="stats_category">
				<option value="'.$cdata['cid'].'">'.$cdata['title'].'</option>';
			$catresult=dbquery("select * from ".$db_prefix."varcade_cats order by title ASC");
			while($catdata=dbarray($catresult)) 
			{
			echo '<option value="'.$catdata['cid'].'">'.$catdata['title'].'</option>';
			}		
		echo '</select></td></tr>';

echo "<tr><td  align='center'>".$locale['VARC403']." </td>
<td><select name='stats_status' class='small'>
          <option value='".$game['status']."'>".$current_status."</option>
	<option value='1'>".$locale['VARC412']."</option>
	<option value='2'>".$locale['VARC411']."</option>
       </select></td>
</tr>";

echo "<tr><td  align='center'>".$locale['VARC404']." </td>
<td><select name='stats_control' class='small'>
          <option value='".$game['control']."'>".$current_control."</option>
	<option value='0'>".$locale['VARC414']."</option>
	<option value='1'>".$locale['VARC413']."</option>
       </select></td>
</tr>";

echo "<tr><td  align='center'>".$locale['VARC405']." </td>
<td><select name='stats_reverse' class='small'>
          <option value='".$game['reverse']."'>".$current_reverse."</option>
	<option value='0'>".$locale['VARC415']."</option>
	<option value='1'>".$locale['VARC416']."</option>
       </select></td>
</tr>";

if ($varcsettings['flashdetection'] == "0")
{
echo "
<tr>
<td align='center'>".$locale['VARC408']."</td>
<td><input type='text' name='stats_height' value='$stats_height' class='textbox' style='width:120px;'></td>
</tr>
<tr>
<td align='center'>".$locale['VARC409']."</td>
<td><input type='text' name='stats_width' value='$stats_width' class='textbox' style='width:120px;'></td>
</tr>";
echo "<center><td class='tbl1' align='center'><a href='#' onclick=window.open('".INFUSIONS."varcade/admin/flashdetect.php?game=".$game['lid']."','VArcflashnumbers','scrollbars=yes,resizable=yes,width=100,height=200')>".$locale['VARC417']."</a></td></center>";
}
else
{
echo "
<input type='hidden' name='stats_height' value='$stats_height' class='textbox' style='width:120px;'>
<input type='hidden' name='stats_width' value='$stats_width' class='textbox' style='width:120px;'>";
}


$visibility_opts = ""; $sel = "";
	$user_groups = getusergroups();
	while(list($key, $user_group) = each($user_groups)){
$sel = (@$news_visibility == $user_group['0'] ? " selected" : "");
	$visibility_opts .= "<option value='".$user_group['0']."'$sel>".$user_group['1']." </option>\n";
}
$check = $stats_access;
$get_group = dbquery("SELECT group_name FROM ".$db_prefix."user_groups WHERE group_id='$check'");
while ($datagroup = dbarray($get_group))
$group = $datagroup['group_name'];
if($check == 101) $group="Member";
if($check == 102) $group="Admin";
if($check == 103) $group="SuperAdmin";
if($check == "0") $group="Public";
if($check == "") $check="0";
echo "<tr><td  align='center'>".$locale['VARC406']." </td>
<td><select name='stats_access' class='textbox'>
<option selected value='".$check."'>$group
$visibility_opts</select></td>";



echo "</table>";
echo "<center><td class='tbl1' align='center'><textarea name='stats_description' cols='50' rows='3' class='textbox'>".$stats_description."</textarea></td></center>";
echo "<td><center><input type='submit' name='save_cat' value='".$locale['VARC407']."' class='button'></td></center></form>\n";
?>