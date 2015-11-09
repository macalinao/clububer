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

error_reporting(E_ALL -E_NOTICE);

function RemoveExtension($strName)
{
$ext = strrchr($strName, '.');
if($ext !== false)
{
$strName = substr($strName, 0, -strlen($ext));
}
return $strName;
}
define("GAME_DIR", INFUSIONS."varcade/uploads/flash");

echo $locale['VARC337'];
	echo '<form name="inputform" method="post" action="admin.php?a_page=loader&autoload">
    	<table width="100%" cellspacing="0" cellpadding="0"><tr>';
echo "<tr><td align='right'>".$locale['VARC338']." </td>";
echo '<td><select class="textbox" name="loadcat">';
			echo '<option value="">-- '.$locale['VARC338'].' --</option>';
			$catresult=dbquery("select * from ".$db_prefix."varcade_cats order by title");
			while($catdata=dbarray($catresult)) 
			{
				echo '<option value="'.$catdata['cid'].'">'.$catdata['title'].'</option>';
			}				
echo '</select></td></tr>';
echo "
<tr>
<td align='right'>".$locale['VARC348']."</td>
<td>";
	 echo '<SELECT size="5" multiple NAME="flash[]" class="textbox">';
	$handle=opendir(GAME_DIR);
	while (false!==($file = readdir($handle)))
	{
$filec = strrchr($file, '.');
if ($filec == '.swf')
{
$result = dbquery("SELECT * FROM ".$db_prefix."varcade_games WHERE flash='$file'");
if (dbrows($result) == 0)
{
echo '<OPTION VALUE="'.$file.'">'.$file.'</OPTION>';
  }
 }
}
closedir($handle);
echo '</select>';

if ($varcsettings['flashdetection']=="1") 
{
$height = "0";
$width = "0";
}
else
{
$height = "550";
$width = "550";
}
$hidate = "0";
$hi_player = "0";
$played = "0";
$lastplayed = "0";
$cost = "0";
$reward= "0";
$bonus = "0";

echo '</td></tr> ';
echo "
<tr>
<td align='right'>".$locale['VARC339']."</td>
<td><input type='text' name='height' value='$height' class='textbox' style='width:120px;'></td>
</tr>
<tr>
<td align='right'>".$locale['VARC340']."</td>
<td><input type='text' name='width' value='$width' class='textbox' style='width:120px;'></td>
</tr>
<tr>
<td align='right'>".$locale['VARC341']."</td>
<td><input type='text' name='hidate' value='$hidate' class='textbox' style='width:120px;'></td>
</tr>
<td align='right'>".$locale['VARC342']."</td>
<td><input type='text' name='hi_player' value='$hi_player' class='textbox' style='width:120px;'></td>
</tr>
<tr>
<td align='right'>".$locale['VARC343']."</td>
<td><input type='text' name='played' value='$played' class='textbox' style='width:50px;'></td>
</tr>
<tr>
<td align='right'>".$locale['VARC344']."</td>
<td><input type='text' name='lastplayed' value='$lastplayed' class='textbox' style='width:50px;'></td>
</tr>
";
if ($varcsettings['usergold']=="1") 
{
$cost = "5";
$reward= "10";
$bonus = "15";

echo "
<tr>
<td align='right'>".$locale['GARC104']."</td>
<td><input type='text' name='cost' value='$cost' class='textbox' style='width:200px;'></td>
</tr>

<tr>
<td align='right'>".$locale['GARC105']."</td>
<td><input type='text' name='reward' value='$reward' class='textbox' style='width:200px;'></td>
</tr>

<tr>
<td align='right'>".$locale['GARC106']."</td>
<td><input type='text' name='bonus' value='$bonus' class='textbox' style='width:200px;'></td>
</tr>";
}

echo "<tr><td  align='right'>".$locale['VARC403']." </td>
<td><select name='status' class='small'>
          <option value='2'>".$locale['VARC411']."</option>
	<option value='1'>".$locale['VARC412']."</option>
	<option value='2'>".$locale['VARC411']."</option>
       </select></td>
</tr>
<tr><td  align='right'>Control </td>
<td><select name='control' class='small'>
          <option value='0'>".$locale['VARC414']."</option>
	<option value='0'>".$locale['VARC414']."</option>
	<option value='1'>".$locale['VARC413']."</option>
       </select></td>
</tr>";
echo "<tr><td  align='right'>".$locale['VARC405']." </td>
<td><select name='reverse' class='small'>
          <option value='0'>".$locale['VARC415']."</option>
	<option value='0'>".$locale['VARC415']."</option>
	<option value='1'>".$locale['VARC416']."</option>
       </select></td>
</tr>";

$visibility_opts = ""; $sel = "";
	$user_groups = getusergroups();
	while(list($key, $user_group) = each($user_groups)){
$sel = (@$news_visibility == $user_group['0'] ? " selected" : "");
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
echo "<tr><td  align='right'>".$locale['VARC406']." </td>
<td><select name='access' class='textbox'>
<option selected value='".$check."'>$group
$visibility_opts</select></td>";

echo '<tr><td colspan="2" align="center">
<input type="hidden" name="action" value="loadgames">
<input class="button" type="submit" value="'.$locale['VARC345'].'">
</td></tr></table></form>';

if (@$action=='loadgames')
{

if ($_POST['loadcat']||$_POST['loadcat']!='')
{
$catid = $_POST['loadcat'];
global $catid;
$getname=dbarray(dbquery("select * from ".$db_prefix."varcade_cats WHERE cid=$catid"));

	$catid = $_POST['loadcat'];
	$flash=$_POST['flash'];
	if ($flash)
	{
		 foreach ($flash as $t)
		 {
		 		
				$gamename = RemoveExtension($t);
				$thumbfile = RemoveExtension($t).'.gif';
				$flashfile = $t;
echo $cat_id;
				
$result = dbquery("INSERT INTO ".$db_prefix."varcade_games VALUES ('', '$catid', '$gamename','".$_POST['description']."', '".$flashfile."', '".$thumbfile."', '".$_POST['played']."','".$_POST['hiscore']."','".$_POST['hi_player']."','".$_POST['status']."','".$_POST['lastplayed']."','".$_POST['width']."','".$_POST['height']."','".$_POST['control']."','".$_POST['reverse']."','".$_POST['hiscoredate']."','".$_POST['cost']."','".$_POST['reward']."','".$_POST['bonus']."','".$_POST['access']."','0')");

echo  "<center>".$locale['VARC346']." <font color = 'red'><b> ".$gamename." </b></font> ".$locale['VARC347']." <font color = 'red'><b>".$getname['title']."</b></font><br></center>";
		
		 }
	}
}
else
{
echo "<font color = 'red'><b>".$locale['VARC349']."</b></font>";
}
}

?>
