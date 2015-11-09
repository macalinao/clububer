<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright � 2002 - 2008 Nick Jones
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
require_once "../../maincore.php";

$gold = stripinput($_GET['gold']);
if (!isset($p))
{
require_once THEMES."templates/header.php";

}
else
{
require_once THEME."theme.php";
echo "<link rel='stylesheet' href='".THEME."styles.css' type='text/css'>";
}

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

$g = $_GET['g'];

$result = dbquery("SELECT * FROM ".$db_prefix."varcade_games WHERE lid = '".$g."' LIMIT 0,1"); 
$current = dbarray($result);

$resultvset = dbquery("SELECT * FROM ".$db_prefix."varcade_settings");
$varcsettings = dbarray($resultvset);

if($current['reverse'] == "1")
	{
		$sort = "ASC";
		$cleansort = "DESC";

	}
	else
	{
		$sort = "DESC";
		$cleansort = "ASC";
	}


//score cleaning
$result = dbquery("SELECT * FROM ".$db_prefix."varcade_score WHERE game_id =".$g."");
$scorecount = dbrows($result);
if ($scorecount > 25) {
$result = dbquery("DELETE FROM ".$db_prefix."varcade_score WHERE game_id =".$g." AND $scorecount > 25 ORDER BY game_score ".$cleansort." LIMIT 1");
}
$result = dbquery ("DELETE FROM ".$db_prefix."varcade_score WHERE player_id = '0' OR game_score = '0' OR player_id = '';");

if (isset($c))
{
opentable("".$locale['VARC180']." ".$current['title']."");
echo "<div id='lajv'>";
echo "</div>";

//Start Tournament LADDER
$hiscorex= dbquery("SELECT ter.*, user_id,user_name FROM ".$db_prefix."varcade_tournament_scores ter
		LEFT JOIN ".$db_prefix."users tusr ON ter.player_id=tusr.user_id
		WHERE game_id='".$g."' ORDER BY game_score ".$sort." LIMIT 25");


echo ' <table width="98%" cellpadding="0" cellspacing="1" class="tbl-border">
<div class="scapmain"><center><b> '.$locale['VARC202'].' </b></center></div>
<tr align="center">
<td class="tbl2" width="10%"><span class="small"><B>'.$locale['VARC182'].'</B></span></td>
<td class="tbl2" width="22%"><span class="small"><B>'.$locale['VARC183'].'</B></span></td>
<td class="tbl2" width="22%"><span class="small"><B>'.$locale['VARC184'].'</B></span></td>
<td class="tbl2" width="22%"><span class="small"><B>'.$locale['VARC185'].'</B></span></td>
</tr>';
$count = 1;
$i = 0;
while($hiscore = dbarray($hiscorex))
{
//color code the rows
$i % 2 == 0 ? $rowclass="tbl1" : $rowclass="tbl2";
//get results for user_id
if ($varcsettings['popup']=="1")
{
$gamelink1 = '<a href="'.INFUSIONS.'varcade/player_hiscore.php?p=1&name='.$hiscore['user_name'].'&id='.$hiscore['user_id'].'&rowstart=0">'; 
$gamelink2 = '<a href="hiscore.php?p=1&id='.$hiscore['game_id'].'">'; 
}
else
{
$gamelink1 = '<a href="'.INFUSIONS.'varcade/player_hiscore.php?name='.$hiscore['user_name'].'&id='.$hiscore['user_id'].'&rowstart=0">';
$gamelink2 = '<a href="hiscore.php?gameid='.$hiscore['game_id'].'">'; 
}

echo '<tr align="center">
<td class="'.$rowclass.'"><center><span class="small"><img src="'.INFUSIONS.'varcade/img/kings/king'.$count.'.gif"></center></span></td>
<td class="'.$rowclass.'"><span class="small">'.$gamelink1.''.$hiscore['user_name'].'</a></span></td>
<td class="'.$rowclass.'"><span class="small">'.$gamelink1.''.$hiscore['game_score'].'</a></span></td>
<td class="'.$rowclass.'"><span class="small">'.showdate("forumdate", $hiscore['score_date']).'</span></td>
</tr>';
$i++;
$count++;
}
echo '</table>';

$compleader = dbarray(dbquery("SELECT * FROM ".$db_prefix."varcade_tournaments WHERE tour_game = '".$g."' LIMIT 0,1")); 
if ($compleader['tour_winner']==$userdata['user_name'])
	{
if ($varcsettings['sound'] == "1")
{
echo '<SCRIPT LANGUAGE="JavaScript">
<!--  Begin
var MSIE=navigator.userAgent.indexOf("MSIE");
var NETS=navigator.userAgent.indexOf("Netscape");
var OPER=navigator.userAgent.indexOf("Opera");
if((MSIE>-1) || (OPER>-1)) {
document.write("<BGSOUND SRC=img/hi.wav LOOP=NO>");
} else {
document.write("<EMBED SRC=img/hi.wav AUTOSTART=TRUE ");
document.write("HIDDEN=true VOLUME=100 LOOP=FALSE>");
}
// End -->
</SCRIPT>';
}
echo '<div align="center"><B> '.$locale['VARC200'].'  '.$userdata['user_name'].' '.$locale['VARC199'].' </B></div>';
	}
	else
	{
if ($varcsettings['sound'] == "1")
{
echo '<SCRIPT LANGUAGE="JavaScript">
<!--  Begin
var MSIE=navigator.userAgent.indexOf("MSIE");
var NETS=navigator.userAgent.indexOf("Netscape");
var OPER=navigator.userAgent.indexOf("Opera");
if((MSIE>-1) || (OPER>-1)) {
document.write("<BGSOUND SRC=img/no_hi.wav LOOP=NO>");
} else {
document.write("<EMBED SRC=img/no_hi.wav AUTOSTART=TRUE ");
document.write("HIDDEN=true VOLUME=100 LOOP=FALSE>");
}
// End -->
</SCRIPT>';
}
echo '<div align="center">'.$locale['VARC203'].' '.$score.' '.$locale['VARC204'].' ('.$compleader['tour_score'].') '.$locale['VARC205'].'</div>';
	}		

//END Tournament LADDER

}
else
{

opentable($locale['VARC207'].' '.$current['title']);
if ($current['hi_player']==$userdata['user_name'])
{
if ($varcsettings['sound'] == "1")
{
echo '<SCRIPT LANGUAGE="JavaScript">
<!--  Begin
var MSIE=navigator.userAgent.indexOf("MSIE");
var NETS=navigator.userAgent.indexOf("Netscape");
var OPER=navigator.userAgent.indexOf("Opera");
if((MSIE>-1) || (OPER>-1)) {
document.write("<BGSOUND SRC=img/hi.wav LOOP=NO>");
} else {
document.write("<EMBED SRC=img/hi.wav AUTOSTART=TRUE ");
document.write("HIDDEN=true VOLUME=100 LOOP=FALSE>");
}
// End -->
</SCRIPT>';
}
echo '<div align="center"><B>'.$locale['VARC190'].' '.$userdata['user_name'].' '.$locale['VARC193'].'</B></div>';
	}
	else
	{
if ($varcsettings['sound'] == "1")
{

echo '<SCRIPT LANGUAGE="JavaScript">
<!--  Begin
var MSIE=navigator.userAgent.indexOf("MSIE");
var NETS=navigator.userAgent.indexOf("Netscape");
var OPER=navigator.userAgent.indexOf("Opera");
if((MSIE>-1) || (OPER>-1)) {
document.write("<BGSOUND SRC=img/no_hi.wav LOOP=NO>");
} else {
document.write("<EMBED SRC=img/no_hi.wav AUTOSTART=TRUE ");
document.write("HIDDEN=true VOLUME=100 LOOP=FALSE>");
}
// End -->
</SCRIPT>';
}
echo '<div align="center">'.$locale['VARC191'].' '.$s.' '.$locale['VARC192'].' ('.$current['hiscore'].') '.$locale['VARC194'].'</div>';
	}
	
}
closetable();
echo "<br>";
opentable($locale['VARC181'].' '.$current['title']);
$hiscorex= dbquery("SELECT ter.*, user_id,user_name FROM ".$db_prefix."varcade_score ter
		LEFT JOIN ".$db_prefix."users tusr ON ter.player_id=tusr.user_id
		WHERE game_id='".$g."' ORDER BY game_score ".$sort." LIMIT 25");

echo ' <br><table width="98%" cellpadding="0" cellspacing="1" class="tbl-border">
<tr align="center">
<td class="tbl2" width="10%"><span class="small"><B>'.$locale['VARC182'].'</B></span></td>
<td class="tbl2" width="22%"><span class="small"><B>'.$locale['VARC183'].'</B></span></td>
<td class="tbl2" width="22%"><span class="small"><B>'.$locale['VARC184'].'</B></span></td>
<td class="tbl2" width="24%"><span class="small"><B>'.$locale['VARC185'].'</B></span></td>
</tr>';
$count = 1;
$i = 0;
while($hiscore = dbarray($hiscorex))
{
//color code the rows
$i % 2 == 0 ? $rowclass="tbl1" : $rowclass="tbl2";
if ($varcsettings['popup']=="1")
{
$gamelink1 = '<a href="'.INFUSIONS.'varcade/player_hiscore.php?p=1&name='.$hiscore['user_name'].'&id='.$hiscore['user_id'].'&rowstart=0">'; 
$gamelink2 = '<a href="hiscore.php?p=1&id='.$hiscore['game_id'].'">'; 
}
else
{
$gamelink1 = '<a href="'.INFUSIONS.'varcade/player_hiscore.php?name='.$hiscore['user_name'].'&id='.$hiscore['user_id'].'&rowstart=0">';
$gamelink2 = '<a href="hiscore.php?gameid='.$hiscore['game_id'].'">'; 
}

echo '<tr align="center">
<td  class="'.$rowclass.'"><center><span class="small"><img src="'.INFUSIONS.'varcade/img/kings/king'.$count.'.gif"></center></span></td>
<td class="'.$rowclass.'"><span class="small">'.$gamelink1.''.$hiscore['user_name'].'</a></span></td>
<td class="'.$rowclass.'"><span class="small">'.$gamelink2.''.$hiscore['game_score'].'</a></span></td>
<td class="'.$rowclass.'"><span class="small">'.showdate("forumdate", $hiscore['score_date']).'</span></td>
</tr>';
$i++;
$count++;
}
if ($varcsettings['usergold']=="1")
{
echo '<tr><td colspan="4" class="tbl1" align="center"><B>'.$locale['GARC117'].'  '.$gold.' '.$locale['GARC112'].' </B></td></tr>';
}
echo '</table>';
closetable();

if (!isset($p))
{
opentable($locale['VARC206']);
echo '<table align="center" width="98%"><tr align="center">
<td><a href="'.INFUSIONS.'varcade/arcade.php?game='.$current['lid'].'">'.$locale['VARC186'].'</B></a></td> ';

if ($varcsettings['favorites'] == "1")
{
if (iMEMBER)
{
$row2 = dbquery("SELECT * FROM ".$db_prefix."varcade_favourites WHERE fav_id='".$current['lid']."' AND fav_user='".$userdata['user_id']."'");
$fav_id2=dbarray($row2);
$fav_id2 = $fav_id2['fav_id'];
if( $current['lid'] != $fav_id2){
echo "<td> <a href='".INFUSIONS."varcade/add_favourites.php?fav_id=".$current['lid']."&fav_user=".$userdata['user_id']."&fav_icon=".$current['icon']."&fav_gamename=".$current['title']."'>".$locale['FARC107']."</a></td>";
}
}
}

if (!isset($c))
{
echo '<td><a href="javascript:history.go(-2)">'.$locale['VARC187'].'</B></a></td>';
}
if ($varcsettings['comments'] == "1")
{
echo "<td><a href='#' onclick=window.open('".INFUSIONS."varcade/callcomments.php?comment_id=".$current['lid']."','Comments','scrollbars=yes,resizable=yes,width=650,height=650')>".$locale['VARC188']."</B></a></td>";
}
echo '<td><a href="index.php">'.$locale['VARC189'].'</B></a></td>
</tr></table>';
closetable();
}

require_once "footer.php";
if (!isset($p))
{
require_once THEMES."templates/footer.php";
}
?>