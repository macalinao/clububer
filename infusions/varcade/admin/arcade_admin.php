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
if (!checkRights("I")) { ("Location:../../index.php"); exit; }
if (isset($stats_id) && !isNum($stats_id)) fallback("index.php");

echo '<script type="text/javascript" src="'.INFUSIONS.'varcade/admin/js.js"></script>';

echo'
<SCRIPT LANGUAGE=JAVASCRIPT TYPE="TEXT/JAVASCRIPT">
<!--Hide script from old browsers
function confirmdelete() {
return confirm("'.$locale['VARC707'].'")
}
//Stop hiding script from old browsers -->
</SCRIPT>';

if (isset($step) && $step == "delete") {
$result1 = dbquery("SELECT * FROM ".$db_prefix."varcade_games WHERE lid='$stats_id'");
$remove = dbarray($result1);
$gameurl="".INFUSIONS."varcade/uploads/flash/".$remove['flash']."";
$gamethumb="".INFUSIONS."varcade/uploads/thumb/".$remove['icon']."";

@unlink($gameurl);
@unlink($gamethumb);

$resulta = dbquery("DELETE FROM ".$db_prefix."varcade_games WHERE lid='$stats_id'");
$resultb = dbquery("DELETE FROM ".$db_prefix."varcade_score WHERE game_id='$stats_id'");
$resultc = dbquery("DELETE FROM ".$db_prefix."comments WHERE comment_item_id='$stats_id'");
$resultd = dbquery("DELETE FROM ".$db_prefix."varcade_ratings  WHERE rating_item_id ='$stats_id'");
$resulte = dbquery("DELETE FROM ".$db_prefix."varcade_active  WHERE game_id ='$stats_id'");
$resultf = dbquery("DELETE FROM ".$db_prefix."varcade_activeusr WHERE game_id ='$stats_id'");

echo "
".$remove['title']." ".$locale['VARC708']." ".$remove['flash']."<br>
 ".$remove['icon']." ".$locale['VARC709']." <br>
".$locale['VARC710']." <br>";

echo "<div style='text-align:center'><p><br>".$locale['VARC711']." <br><br>
<a href='".INFUSIONS."varcade/admin/admin.php?a_page=main'>".$locale['VARC712']."</a><br>
<a href='".ADMIN."index.php'>".$locale['VARC713']."</a><br><br></p>
</div>";
} else {
if (isset($_POST['save_cat'])) {

$stats_titel = stripinput($_POST['stats_titel']);
$stats_cat = stripinput($_POST['stats_cat']);
$visibility_opts = stripinput($_POST['visibility_opts']);
$stats_url = stripinput($_POST['stats_url']);
$stats_hiscore = stripinput($_POST['stats_hiscore']);
$stats_hi_player = stripinput($_POST['stats_hi_player']);
$stats_lastplayed = stripinput($_POST['stats_lastplayed']);
$stats_width = stripinput($_POST['stats_width']);
$stats_height = stripinput($_POST['stats_height']);
$stats_hidate = stripinput($_POST['stats_hidate']);
$stats_status = stripinput($_POST['stats_status']);
$stats_reverse  = stripinput($_POST['stats_reverse']);
$stats_thumb = stripinput($_POST['stats_thumb']);
$stats_control = stripinput($_POST['stats_control']);
$stats_played = stripinput($_POST['stats_played']);
$stats_description = stripslashes($_POST['stats_description']);
$stats_errorreport = stripinput($_POST['stats_errorreport']);

$stats_bonus = stripinput($_POST['stats_bonus']);
$stats_reward = stripinput($_POST['stats_reward']);
$stats_cost = stripinput($_POST['stats_cost']);

if (isset($step) && $step == "edit") {
if($visibility_opts == "") $visibility_opts="0";
$result = dbquery("UPDATE ".$db_prefix."varcade_games SET  cost='$stats_cost',reward='$stats_reward', bonus='$stats_bonus', title='$stats_titel', cid='$stats_cat', hiscore = '$stats_hiscore',flash='$stats_url', hi_player ='$stats_hi_player', status = '$stats_status',lastplayed='$stats_lastplayed',width='$stats_width',height='$stats_height',control='$stats_control',reverse='$stats_reverse',hiscoredate='$stats_hidate', access='$visibility_opts', played='$stats_played', description='$stats_description', icon='$stats_thumb', errorreport='$stats_errorreport' WHERE lid='$stats_id'");
} else {
$result = dbquery("INSERT INTO ".$db_prefix."varcade_games VALUES ('', '$stats_cat', '$stats_titel', '$stats_description', '$stats_url', '$stats_thumb','$stats_played','$stats_hiscore','$stats_hi_player','$stats_status','$stats_lastplayed','$stats_width','$stats_height','$stats_control','$stats_reverse','$stats_hidate','$stats_cost','$stats_reward','$stats_bonus','$visibility_opts','$stats_errorreport')");
}
redirect("".INFUSIONS."varcade/admin/admin.php?a_page=main");
}

if (isset($step) && $step == "edit") {
$result = dbquery("SELECT * FROM ".$db_prefix."varcade_games WHERE lid='$stats_id'");
$data = dbarray($result);

$stats_titel = $data['title'];
$stats_cat = $data['cid'];
$visibility_opts = $data['access'];
$stats_hidate = $data['hiscoredate'];
$stats_status = $data['status'];
$stats_url = $data['flash'];
$stats_thumb = $data['icon'];
$stats_played = $data['played'];
$stats_description = $data['description'];
$stats_status = $data['status'];
$stats_errorreport = $data['errorreport'];
$stats_hiscore = $data['hiscore'];
$stats_hi_player = $data['hi_player'];
$stats_lastplayed = $data['lastplayed'];
$stats_width = $data['width'];
$stats_height = $data['height'];
$stats_reverse  = $data['reverse'];
$stats_control = $data['control'];
$stats_played = $data['played'];
$stats_cost = $data['cost'];
$stats_reward = $data['reward'];
$stats_bonus = $data['bonus'];
$check = $data['access'];


if ($data['status'] == "1")
{
$current_status = $locale['VARC412'];
}
if ($data['status'] == "2")
{
$current_status = $locale['VARC411'];
}

if ($data['control'] == "1")
{
$current_control = $locale['VARC413'];
}
if ($data['control'] == "0")
{
$current_control = $locale['VARC414'];
}

if ($data['reverse'] == "1")
{
$current_reverse = $locale['VARC416'];
}
if ($data['reverse'] == "0")
{
$current_reverse = $locale['VARC415'];
}

$formaction = "".INFUSIONS."varcade/admin/admin.php?a_page=main&step=edit&stats_id=".$data['lid']."";
} else {
$check = "0";
$stats_hidate= "0"; 
$stats_titel = "";
$stats_cat = "";
$visibility_opts = "";
$stats_url = "";
$stats_thumb = "";
$stats_description = "";
$stats_status = "2";
$stats_errorreport = "0";
$stats_hiscore = "0";
$stats_hi_player = "0";
$stats_lastplayed = "0";
$stats_cost = "0";
$stats_reward = "0";
$stats_bonus = "0";

if ($varcsettings['flashdetection']=="1") 
{
$stats_height ="0";
$stats_width ="0";
}
else
{
$stats_height ="550";
$stats_width ="550";
}
$stats_reverse  = "0";
$stats_control = "1";
$stats_played = "0";

if ($stats_status == "1")
{
$current_status = $locale['VARC412'];
}
if ($stats_status == "2")
{
$current_status = $locale['VARC411'];
}
if ($stats_control == "1")
{
$current_control = $locale['VARC413'];
}
if ($stats_control == "0")
{
$current_control = $locale['VARC414'];
}
if ($stats_reverse == "1")
{
$current_reverse = $locale['VARC416'];
}
if ($stats_reverse == "0")
{
$current_reverse = $locale['VARC415'];
}

$formaction = "".INFUSIONS."varcade/admin/admin.php?a_page=main";
}
echo"<input type='text' id='query' class='textbox' style=' height: 17px; width: 100px; border: 1px solid #000; background-color: #636363; color: #000; font-size: 12px;' value='".$locale['VARC103']."' onBlur=\"if(this.value=='') this.value='".$locale['VARC103']."';\" onFocus=\"if(this.value=='".$locale['VARC103']."') this.value='';\" onKeyDown=\"if(event.keyCode==13) Search();\"><a onClick=\"javascript:Search();\" class='button'>".$locale['VARC103']."</a>";
echo "<form name='addcat' method='post' action='$formaction'>
<table align='center' width='100%' cellspacing='0' cellpadding='0' class='tbl'>";
echo "
<tr>
<td width='50%' align='right' valign='top'>
<table align='center' cellspacing='0' cellpadding='0' class='tbl'>
</tr>
<td width='49%' align='right'>".$locale['VARC393']."</td>
<td><input type='text' name='stats_titel' value='$stats_titel' class='textbox' style='width:120px;'></td>
<tr>
<tr>
<td width='49%' align='right'>".$locale['VARC394']."</td>
<td><input type='text' name='stats_height' value='$stats_height' class='textbox' style='width:120px;'></td>
</tr>
<tr>
<td width='49%' align='right'>".$locale['VARC395']."</td>
<td><input type='text' name='stats_width' value='$stats_width' class='textbox' style='width:120px;'></td>
</tr>
<tr>
<td align='right'>".$locale['VARC396']."</td>
<td><input type='text' name='stats_hidate' value='$stats_hidate' class='textbox' style='width:120px;'></td>
</tr>
<td align='right'>".$locale['VARC397']."</td>
<td><input type='text' name='stats_hi_player' value='$stats_hi_player' class='textbox' style='width:120px;'></td>
</tr>
<tr>
<td align='right'>".$locale['VARC385']."</td>
<td><input type='text' name='stats_played' value='$stats_played' class='textbox' style='width:50px;'></td>
</tr>";
echo "<tr><td  align='center'>".$locale['VARC403']." </td>
<td><select name='stats_status' class='small'>
          <option value='".$stats_status."'>".$current_status."</option>
	<option value='1'>".$locale['VARC412']."</option>
	<option value='2'>".$locale['VARC411']."</option>
       </select></td>
</tr>";

echo "<tr><td  align='center'>".$locale['VARC404']." </td>
<td><select name='stats_control' class='small'>
          <option value='$stats_control'>".$current_control."</option>
	<option value='0'>".$locale['VARC414']."</option>
	<option value='1'>".$locale['VARC413']."</option>
       </select></td>
</tr>";

echo "<tr><td  align='center'>".$locale['VARC405']." </td>
<td><select name='stats_reverse' class='small'>
          <option value='$stats_reverse'>".$current_reverse."</option>
	<option value='0'>".$locale['VARC415']."</option>
	<option value='1'>".$locale['VARC416']."</option>
       </select></td>
</tr>";
echo "</table></td>
<td width='50%' align='right' valign='top'>
<table align='center' cellspacing='0' cellpadding='0' class='tbl'>
<tr>
<td align='right' valign='top'>".$locale['VARC386']."</td>
<td><textarea name='stats_description' cols='45' rows='4' class='textbox'>$stats_description</textarea>
</td>
</tr>
<tr>
<td align='right'>".$locale['VARC387']."</td>
<td><input type='text' name='stats_url' value='$stats_url' class='textbox' style='width:250px;'></td>
</tr>
<tr>
<td align='right'>".$locale['VARC388']."</td>
<td><input type='text' name='stats_thumb' value='$stats_thumb' class='textbox' style='width:200px;'></td>
</tr>";
if ($varcsettings['usergold']=="1") 
{
echo "
<tr>
<td align='right'>".$locale['GARC104']."</td>
<td><input type='text' name='stats_cost' value='$stats_cost' class='textbox' style='width:200px;'></td>
</tr>

<tr>
<td align='right'>".$locale['GARC105']."</td>
<td><input type='text' name='stats_reward' value='$stats_reward' class='textbox' style='width:200px;'></td>
</tr>

<tr>
<td align='right'>".$locale['GARC106']."</td>
<td><input type='text' name='stats_bonus' value='$stats_bonus' class='textbox' style='width:200px;'></td>
</tr>";
}
echo "
<input type='hidden' name='stats_lastplayed' value='$stats_lastplayed' readonly>
<input type='hidden' name='stats_errorreport' value='$stats_errorreport' readonly>
<input type='hidden' name='stats_hiscore' value='$stats_hiscore' readonly>";


$resultc = dbquery("SELECT * FROM ".$db_prefix."varcade_cats WHERE cid='$stats_cat'");
$cdata = dbarray($resultc);

echo"<tr><td align='right'>".$locale['VARC389']." </td><br>";
echo '			<td><select class="textbox" name="stats_cat">
				<option value="'.$cdata['cid'].'">'.$cdata['title'].'</option>';
			$catresult=dbquery("select * from ".$db_prefix."varcade_cats order by cid ASC");
			while($catdata=dbarray($catresult)) 
			{
				echo '<option value="'.$catdata['cid'].'">'.$catdata['title'].'</option>';
			}		
	echo '</select></td></tr>';
$visibility_opts = ""; $sel = "";
	$user_groups = getusergroups();
	while(list($key, $user_group) = each($user_groups)){
@$sel = ($news_visibility == $user_group['0'] ? " selected" : "");
	$visibility_opts .= "<option value='".$user_group['0']."'$sel>".$user_group['1']." </option>\n";
}


$get_group = dbquery("SELECT group_name FROM ".$db_prefix."user_groups WHERE group_id='$check'");
while ($datagroup = dbarray($get_group))
$group = $datagroup['group_name'];
if($check == 101) $group="Member";
if($check == 102) $group="Admin";
if($check == 103) $group="SuperAdmin";
if($check == "0") $group="Public";
if($check == "") $check="0";
echo"
<td align='right'>".$locale['VARC714']."</td>
<td><select name='visibility_opts' class='textbox'>
<option selected value='".$check."'>$group
$visibility_opts</select></td>";

echo"</table></td></tr><td align='center' colspan='2'>
<input type='submit' name='save_cat' value='".$locale['VARC407']."' class='button'></td><td align='right'>
</tr>
</table>
</form>\n";
tablebreak();
echo "<div id='lajv'>";
if (!isset($sortby) || !preg_match("/^[0-9A-Z]$/", $sortby)) $sortby = "all";
$orderby = ($sortby == "all" ? "" : " WHERE title LIKE '$sortby%'");
$result = dbquery("SELECT * FROM ".$db_prefix."varcade_games".$orderby."");
$rows = dbrows($result);
if (!isset($rowstart) || !isNum($rowstart)) $rowstart = 0;
if ($rows != 0) {
echo "<table align='center' width='100%' cellspacing='0'>
<tr>
<td align='left' class='tbl2' width='30%'><b>".$locale['VARC393']."</b></td>
<td align='center' class='tbl2' width='35%'><b>".$locale['VARC387']."</b></td>
<td align='center' class='tbl2' width='30%'><b>".$locale['VARC390']."</b></td>
<td align='right' class='tbl2' width='5%'><b>".$locale['VARC391']."</b></td>
</tr>\n";
$result = dbquery("SELECT * FROM ".$db_prefix."varcade_games".$orderby." ORDER BY lid DESC, title LIMIT $rowstart,10");
while ($data = dbarray($result)) {
echo "<tr>\n<td class='small' width='22%'><img src='".THEME."images/bullet.gif' alt=''> <a href='".INFUSIONS."varcade/admin/admin.php?a_page=main&step=edit&stats_id=".$data['lid']."'><b>".$data['title']."</b></a></td>\n";
echo "<td class='small' align='center' width='12%'>".$data['flash']."</td>";
echo "<td class='small' align='center' width='5%'>".$data['cid']."</td>";
echo "</td>";
echo "<td class='small' align='right' width='7%'><a href='".INFUSIONS."varcade/admin/admin.php?a_page=main&step=delete&stats_id=".$data['lid']."' onClick='return confirmdelete();'>".$locale['VARC391']."</a></td></tr>";
}
echo "</table>\n";
echo "<hr>";
echo "<div align='center' style='margin-top:5px;'>".makePageNav($rowstart,10,$rows,3,FUSION_SELF."?sortby=$sortby&")."\n</div>\n";
} else {
echo "<center><br>\n<b>$sortby<b><br><br>\n</center>\n";
}
echo "</div>";
$search = array(
"A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R",
"S","T","U","V","W","X","Y","Z","0","1","2","3","4","5","6","7","8","9"
);
echo "<hr><table align='center' cellpadding='0' cellspacing='1' class='tbl-border'>\n<tr>\n";
echo "<td rowspan='2' class='tbl2'><a href='".INFUSIONS."varcade/admin/admin.php?a_page=main&sortby=all'>".$locale['VARC392']."</a></td>";
for ($i=0;$i < 36!="";$i++) {
echo "<td align='center' class='tbl1'><div class='small'><a href='".INFUSIONS."varcade/admin/admin.php?a_page=main&sortby=".$search[$i]."'>".$search[$i]."</a></div></td>";
echo ($i==17 ? "<td rowspan='2' class='tbl2'><a href='".INFUSIONS."varcade/admin/admin.php?a_page=main&sortby=all'>".$locale['VARC392']."</a></td>\n</tr>\n<tr>\n" : "\n");
}
echo "</table>\n";
}
?>