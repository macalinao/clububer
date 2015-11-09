<?php
/*--------------------------------------------+
| PHP-Fusion 6 - Content Management System    |
|---------------------------------------------|
| author: Nick Jones (Digitanium) © 2002-2005 |
| web: http://www.php-fusion.co.uk            |
| email: nick@php-fusion.co.uk                |
|---------------------------------------------|
|This program is released as free software    |
|under the |Affero GPL license. 	      |
|You can redistribute it and/or		      |
|modify it under the terms of this license    |
|which you |can read by viewing the included  |
|agpl.html or online			      |
|at www.gnu.org/licenses/agpl.html. 	      |
|Removal of this|copyright header is strictly |
|prohibited without |written permission from  |
|the original author(s).		      |
+---------------------------------------------+
|VArcade is written by Domi & fetloser          |
|http://www.venue.nu			      |
+--------------------------------------------*/
if (!defined("LANGUAGE")) {
// PHPFusion environment
$this_lang =  str_replace("/", "", LOCALESET);
	if (file_exists(INFUSIONS."varcade_events_panel/locale/".$this_lang.".php")) {
	   include INFUSIONS."varcade_events_panel/locale/".$this_lang.".php";
	} else {
	   include INFUSIONS."varcade_events_panel/locale/English.php";
	}
        } else {
// mFusion environment
$this_lang =  LANGUAGE;
	if (file_exists(INFUSIONS."varcade_events_panel/locale/".$this_lang.".php")) {
	   include INFUSIONS."varcade_events_panel/locale/".$this_lang.".php";
	} else {
	   include INFUSIONS."varcade_events_panel/locale/English.php";
	}
}

$resultvset = dbquery("SELECT * FROM ".$db_prefix."varcade_settings");
$varcsettings = dbarray($resultvset);

openside($locale['AEP001']);

echo "<table align='center' cellpadding='0' cellspacing='0' width='90%'>";
echo "<div class='scapmain'>".$locale['AEP008']."</div>";
$result1=dbquery("SELECT * FROM ".$db_prefix."varcade_score ORDER BY score_date DESC LIMIT 0,5");
while ($data1=dbarray($result1))
{
$result2 = dbquery("SELECT hiscore,hi_player,lid,title,lastplayed,access FROM ".$db_prefix."varcade_games WHERE ".groupaccess('access')." AND status='2' AND lid='".$data1['game_id']."'");
$data2 = dbarray($result2);
$result3=dbquery("SELECT user_name,user_id FROM ".$db_prefix."users WHERE user_id='".$data1['player_id']."'");
$data3 = dbarray($result3);
if ($varcsettings['popup']=="1")
{
$gamelink = "<a href='#' onclick=window.open('".INFUSIONS."varcade/arcade.php?p=1&game=".$data2['lid']."','VArcpopup','scrollbars=yes,resizable=yes,width=800,height=700')>"; 
}
else
{
$gamelink = '<a href="'.INFUSIONS.'varcade/arcade.php?game='.$data2['lid'].'">';
}
echo '<tr align="center">
<td ><span class="small"><a href="'.INFUSIONS.'varcade/player_hiscore.php?name='.$data3['user_name'].'&id='.$data3['user_id'].'&rowstart=0">'.$data3['user_name'].'</a> <br>'.$locale['AEP002'].' '.$data1['game_score'].' '.$locale['AEP004'].'<br>
'.$locale['AEP003'].' '.$gamelink.' '.$data2['title'].'</a></span></td>
</tr>';
}
echo '</table>';

echo "<table align='center' cellpadding='0' cellspacing='0' width='90%'>";
echo "<div class='scapmain'>".$locale['AEP009']."</div>";
$result1=dbquery("SELECT DISTINCT hiscoredate,hiscore,hi_player,lid,title,access FROM ".$db_prefix."varcade_games WHERE ".groupaccess('access')." AND status='2' ORDER BY hiscoredate DESC LIMIT 0,5");
while ($data1=dbarray($result1))
{
if ($varcsettings['popup']=="1")
{
$gamelink = "<a href='#' onclick=window.open('".INFUSIONS."varcade/arcade.php?p=1&game=".$data1['lid']."','VArcpopup','scrollbars=yes,resizable=yes,width=800,height=700')>"; 
}
else
{
$gamelink = '<a href="'.INFUSIONS.'varcade/arcade.php?game='.$data1['lid'].'">';
}
$result3=dbquery("SELECT user_name,user_id FROM ".$db_prefix."users WHERE user_name='".$data1['hi_player']."'");
$data3 = dbarray($result3);
echo '<tr align="center">
<td ><span class="small">
<a href="'.INFUSIONS.'varcade/player_hiscore.php?name='.$data3['user_name'].'&id='.$data3['user_id'].'&rowstart=0">'.$data3['user_name'].'</a> <br>'.$locale['AEP005'].' <br>
'.$locale['AEP006'].'  '.$gamelink.' '.$data1['title'].'</a> <br> '.$locale['AEP007'].' '.$data1['hiscore'].' '.$locale['AEP004'].'.
</span></td>
</tr>';
}
echo '</table>';
closeside();
?>