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

if (!defined("IN_FUSION")) { die("Access Denied"); }

$resultvset = dbquery("SELECT * FROM ".$db_prefix."varcade_settings");
$varcsettings = dbarray($resultvset);

//opentable($locale['TOUR001']);

$currenttime = time();
$tourexpire = dbquery("SELECT * FROM ".$db_prefix."varcade_tournaments ORDER BY id DESC LIMIT 1");
$tourdata = dbarray($tourexpire);

// +86400 =  1 day
// +259200 = 3 days
// +432000 = 5 days
// +604800 = 1 week

if ($currenttime > $tourdata['tour_enddate']) 
{
$query = dbquery ("select * from ".$db_prefix."varcade_games WHERE status='2' ORDER BY RAND() limit 0,1") ;
$rows = dbarray($query);
$expiredate = time()+432000; 
$tour_game = "".$rows['lid']."";
$tour_title = "".$rows['title']."";
$tour_icon = "".$rows['icon']."";
$tour_flash = "".$rows['flash']."";
$tour_winner = "".$locale['TOUR003']."";
$tour_score =  "0";
$tour_players =  "0";
$tour_reverse =  "".$rows['reverse']."";
$tour_startdate =  "".$currenttime."";
$tour_enddate =  "".$expiredate."";

$result = dbquery("INSERT INTO ".$db_prefix."varcade_tournaments VALUES('', '$tour_game', '$tour_title', '$tour_icon', '$tour_flash', '$tour_winner', '$tour_score', '$tour_players', '$tour_reverse', '$tour_startdate', '$tour_enddate')");
}
if ($varcsettings['popup']=="1")
{
$gamelink = "<a href='#' onclick=window.open('".INFUSIONS."varcade/arcade.php?p=1&game=".$tourdata['tour_game']."','VArcpopup','scrollbars=yes,resizable=yes,width=800,height=700')>"; 
}
else
{
$gamelink = "<a href='".INFUSIONS."varcade/arcade.php?game=".$tourdata['tour_game']."'>";
}


$tourlink = trimlink($tourdata['tour_title'], 20);
echo "
<table cellpadding='0' cellspacing='1' border='0' width='100%'><tr valign='top'><td>
<table cellpadding='4' cellspacing='1' border='0' width='98%'>
	<tr valign='middle' align='center'>
		<td colspan='4' width='50%' class='scapmain'>";
echo "".$gamelink."<b>".$tourlink."</b></a><br>";
echo "</td><td colspan='4' width='50%' class='scapmain'><a href='".INFUSIONS."varcade/tournament_history.php?current=".$tourdata['tour_game']."'>".$locale['TOUR008']."</a></td>
	</tr>
	<tr valign='top'>";

echo "
<td colspan='4' width='50%'>
<div class='small' style='height: 75px;'>";
echo "".$gamelink.""; echo '<img src="'.INFUSIONS.'varcade/uploads/thumb/'.$tourdata['tour_icon'].'" align="right" valign="center" hspace="5" vspace="5" style="border: 0px;" border="0"/></a>';
echo "".$gamelink.""; echo '<img src="'.INFUSIONS.'varcade/uploads/thumb/'.$tourdata['tour_icon'].'" align="left" valign="center" hspace="5" vspace="5" style="border: 0px;" border="0"/></a>';

echo "
<center>";
echo "".$locale['TOUR002']." <br> ".$tourdata['tour_winner']."";
echo "<br>".$locale['TOUR004']." ".$tourdata['tour_score']." ".$locale['TOUR005']."";
echo "<br>".$locale['TOUR006']." ".$tourdata['tour_players']." ".$locale['TOUR007']."";
echo "<br><br><center>".showdate('forumdate', $tourdata['tour_startdate'])." <--> ".showdate('forumdate', $tourdata['tour_enddate'])."</center>";
echo "</div></td>";

echo "
<td colspan='4' width='50%'>
<div class='small' style='height: 75px;'>";
echo "<a href='".INFUSIONS."varcade/tournament_history.php?current=".$tourdata['tour_game']."'><img src='".INFUSIONS."varcade/img/tournament1.gif' align='right' hspace='5' vspace='5' style='border: 0px;' border='0'/></a>";

echo "<table align='left' cellpadding='0' cellspacing='1' width='70%'>";
echo '
<tr>
<td class="tbl2" width="50"><span class="small"><b>'.$locale['TOUR009'].'</b></span></td>
<td class="tbl2" width="50"><span class="small"><b>'.$locale['TOUR010'].'</b></span></td>
</tr>';


$result = dbquery("SELECT * FROM ".$db_prefix."varcade_tournaments WHERE tour_enddate < $currenttime ORDER BY id DESC LIMIT 0,4");
while ($data = dbarray($result)) {
$result2=dbquery("SELECT user_id FROM ".$db_prefix."users WHERE user_name='".$data['tour_winner']."'");
$data2 = dbarray($result2);
$tourname = trimlink($data['tour_title'], 20);
$tourwinner = trimlink($data['tour_winner'], 10);
echo '<tr>
<td  align="left"><a href="'.INFUSIONS.'varcade/tournament_history.php?gameid='.$data['tour_game'].'">'.$tourname.'</a></td>
<td  align="center"><a href="'.INFUSIONS.'varcade/player_hiscore.php?name='.$data['tour_winner'].'&id='.$data2['user_id'].'&rowstart=0">'.$tourwinner.'</a></td>
</tr>';

}
echo "</div></td></table>";
echo "</td></tr></table></table></center>\n";
//closetable();
?>
