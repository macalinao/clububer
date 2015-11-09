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

if (isset($game) && !isNum($game)) fallback("index.php");

include INFUSIONS."varcade/functions.php";
if ($varcsettings['keepalive'] == "1")
{
echo "<script type='text/javascript' src='".INFUSIONS."/varcade/onlinestatus.js'></script>";
echo "<body onload=\"update(page,'onlinestatus','".$game."')\"></body>";
}

echo '<script type="text/javascript" src="'.INFUSIONS.'varcade/swfobject.js"></script>';

if (!isset($p))
{
require_once THEMES."templates/header.php";

}
else
{
require_once THEME."theme.php";
echo "<link rel='stylesheet' href='".THEME."styles.css' type='text/css'>";
}

//Check user access level & redirect if not granted & trying a direct link
$detect = dbquery("SELECT access,cid FROM ".$db_prefix."varcade_games WHERE lid='$game'");
while ($detect_access = dbarray($detect)) {
$access = $detect_access['access'];
$cid = $detect_access['cid'];
}
if(checkgroup($access)) {
//PROCEED AS PLANNED
}
else
{
redirect(INFUSIONS."varcade/index.php?noaccess");
}
//Check user access level for the games category.
$detect = dbquery("SELECT access FROM ".$db_prefix."varcade_cats WHERE cid='$cid' ");
while ($detect_access = dbarray($detect)) {
$access = $detect_access['access'];
}
if(checkgroup($access)) {
//PROCEED AS PLANNED
}
else
{
redirect(INFUSIONS."varcade/index.php?noaccess");
}

if (iGUEST) {
if ($varcsettings['allow_guest_play'] == "0")
{
if (isset($p))
{
redirect("guests.php?p&noguestplay");
exit;
}
else
{
redirect("guests.php?noguestplay");
exit;
}
}
}

$result = dbquery("SELECT ter.*, user_id,user_name FROM ".$db_prefix."varcade_games ter
		LEFT JOIN ".$db_prefix."users tusr ON ter.hi_player=tusr.user_name
		WHERE lid='$game'");
$game = dbarray($result);

if (!isset($p))
{
add_to_title(" - ".$game['title']."");
}

if (dbrows($result) != 0) {
opentable($game['title']);

if (!isset($p))
{
makeheader();
}
if (isset($lackofgold))
{
//edited to work with UG3 and UG2 - Start
if(USERGOLD){
$gold = getusergold($userdata['user_id'], 'cash');
} else {
$gold = dbarray(dbquery("SELECT * FROM ".$db_prefix."users_points WHERE owner_id=$userdata[user_id]"));
$gold = $gold['points_total'];
}
//edited to work with UG3 and UG2 - End
echo "<br><center><b>".$locale['GARC110']."<br>";
echo "".$locale['GARC111']." ".$game['cost']." ".$locale['GARC112']."<br>";
echo "".$locale['GARC113']." ".$gold." ".$locale['GARC114']."</b></center><br>";
exit;
}

echo "<div id='lajv'>";
echo "</div>";
echo '<table align="center" width="98%" cellpadding="0" cellspacing="1" class="tbl-border">';

if ($game['lastplayed'] == "0")
{
$lastplayed = $locale['VARC158'];
}
else
{
$lastplayed = "".showdate('forumdate', $game['lastplayed'])."";
}

if ($game['hi_player'] == "0")
{
$hi_player = $locale['VARC160'];
}
else
{
$hi_player = $game['hi_player'];
}

//Check tournaments
$currenttime = time();
$tourexpire = dbquery("SELECT * FROM ".$db_prefix."varcade_tournaments ORDER BY id DESC LIMIT 1");
$tourdata = dbarray($tourexpire);

if (($tourdata['tour_game'] == "".$game['lid']."" AND $tourdata['tour_enddate'] > $currenttime) && ($varcsettings['tournaments'] == "1"))
{
echo '<tr><td colspan="4" class="tbl1" align="center"><B>'.$locale['VARC176'].'</B></td></tr>';
echo '<tr>
	<td class="tbl2"><span class="small"><B>'.$locale['VARC171'].' :</B> '.$tourdata['tour_score'].'</span></td>
	<td class="tbl2"><span class="small"><B>'.$locale['VARC172'].' :</B> '.$tourdata['tour_winner'].'</span></td>
	<td class="tbl2"><span class="small"><B>'.$locale['VARC173'].' :</B> '.$tourdata['tour_players'].' '.$locale['VARC157'].'</span></td>
	<td class="tbl2"><span class="small"><B>'.$locale['VARC177'].' :</B> '.showdate("forumdate", $tourdata['tour_enddate']).'
</span></td></tr>';
}

else 
{
echo '<tr><td class="tbl2"><span class="small"><B>'.$locale['VARC170'].' : </B> '.$game['title'].'</span></td>';
if (!isset($p))
{
echo '<td class="tbl2"><span class="small"><B>'.$locale['VARC171'].' : </B><a href="hiscore.php?gameid='.$game['lid'].'">'.$game['hiscore'].'</a></span></td>
<td class="tbl2"><span class="small"><B>'.$locale['VARC172'].' : </B><a href="'.INFUSIONS.'varcade/player_hiscore.php?name='.$game['user_name'].'&id='.$game['user_id'].'&rowstart=0">'.$hi_player.'</a></span></td>';
}
else
{
echo '<td class="tbl2"><span class="small"><B>'.$locale['VARC171'].' : </B><a href="hiscore.php?p=1&gameid='.$game['lid'].'">'.$game['hiscore'].'</a></span></td>
<td class="tbl2"><span class="small"><B>'.$locale['VARC172'].' : </B><a href="'.INFUSIONS.'varcade/player_hiscore.php?p=1&name='.$game['user_name'].'&id='.$game['user_id'].'&rowstart=0">'.$hi_player.'</a></span></td>';
}
echo '<td class="tbl2"><span class="small"><B>'.$locale['VARC173'].' : </B> '.$game['played'].' '.$locale['VARC157'].'</span></td>
<td class="tbl2"><span class="small"><B>'.$locale['VARC174'].' : </B> '.$lastplayed.'</span></td>';

}
echo "</tr></table>";
if (($varcsettings['flashdetection']=="1") && ($game['width'] =="0" || $game['height'] =="0"))
{
list($width, $height) = getimagesize("".INFUSIONS."varcade/uploads/flash/".$game['flash']."");
$gamewidth=$width;
$gameheight=$height;
}
else
{
$gamewidth=$game['width'];
$gameheight=$game['height'];
}
if ($varcsettings['ingameopts'] == "1")
{
echo" <table width='120px;' align='left'>";

if ($varcsettings['comments']=="1") 
{
echo "<tr><td align='left' class='tbl2'>";
$arcade_comment_count = dbcount("(comment_id)", "".$db_prefix."comments", "comment_type='G' AND comment_item_id='".$game['lid']."'");
echo "<a href='#' onclick=window.open('".INFUSIONS."varcade/callcomments.php?comment_id=".$game['lid']."','Comments','scrollbars=yes,resizable=yes,width=650,height=660')><img src='".INFUSIONS."varcade/img/comment.gif' border='0' alt='".$locale['KOM100']."'>".$locale['KOM100']." ($arcade_comment_count)</a><br>"; 
echo "</td></tr>";
}
if ($varcsettings['recommend']=="1") 
{
echo "<tr><td align='left' class='tbl2'>";
echo" <a href='#' onclick=window.open('".INFUSIONS."varcade/tipafriend.php?game_id=".$game['lid']."','Tipafriend','scrollbars=yes,resizable=yes,width=520,height=300')><img src='".INFUSIONS."varcade/img/email.gif' border='0' alt='".$locale['VARC601']." ".$game['title']."'>".$locale['VARC601']."</a>";
echo "</td></tr>";
}
if ($varcsettings['related']=="1") 
{
echo "<tr><td class='tbl2' align='center'><b>".$locale['VARC162']."</b></td></tr>";
$result =dbquery("select lid,icon,title FROM ".$db_prefix."varcade_games WHERE ".groupaccess('access')." AND status='2' AND cid = '".$game['cid']."' ORDER BY RAND() LIMIT 0,5");
while($data = dbarray($result)) {
if ($varcsettings['popup']=="1")
{
$gamelink = '<a href="'.INFUSIONS.'varcade/arcade.php?p=1&game='.$data['lid'].'">';
}
else
{
$gamelink = '<a href="'.INFUSIONS.'varcade/arcade.php?game='.$data['lid'].'">';
}
if (file_exists(INFUSIONS."varcade/uploads/thumb/".$data['icon'].""))
{
$showimg = '<IMG SRC=" '.INFUSIONS.'varcade/uploads/thumb/'.$data['icon'].'" border="0" height="50" width="50">';
}
else {
$showimg = '<img src=" '.INFUSIONS.'varcade/img/arcade.gif" border="0" height="50" width="50">';
}
echo "<tr><td align='center' class='tbl2'>";
echo "".$gamelink.""; echo  ''.$showimg.'<br>'.trimlink($data['title'], 20).'</a></td></tr>';
}
}
if ($varcsettings['keepalive'] == "1")
{
echo "<div id ='onlinestatus'>";
echo '</div>';
$result_guest = dbrows(dbquery("SELECT * FROM ".$db_prefix."varcade_activeusr WHERE game_id='".$game['lid']."' AND player='0'"));
$result_total = dbrows(dbquery("SELECT * FROM ".$db_prefix."varcade_activeusr WHERE game_id='".$game['lid']."' AND  player>='0'"));
$result_members = dbrows(dbquery("SELECT * FROM ".$db_prefix."varcade_activeusr WHERE game_id='".$game['lid']."' AND  player>0"));
echo "<tr><td class='tbl2' align='center'><b>".$locale['VARC723']."</b></td></tr>";
echo "<tr><td align='center' class='tbl2'>";
echo ''.$locale['VARC720'].''.$result_members.' 
</td></tr>';
echo "<tr><td align='center' class='tbl2'>";
echo ''.$locale['VARC721'].''.$result_guest.'
</td></tr>';
echo "<tr><td align='center' class='tbl2'>";
echo ' '.$locale['VARC722'].''.$result_total.' 
</td></tr>';


//echo "</table>";
}
}
echo '<table width="83%" border="0" align="center"><tr><td align="center">
<div id="gamebox">
'.$locale['VARC178']. ' <br>
<a href="http://www.adobe.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash">Download Flash Player</a><br>

</div>
	<script type="text/javascript">
		var so = new SWFObject("'.INFUSIONS.'varcade/uploads/flash/'.$game['flash'].'", "'.$game['title'].'","'.$gamewidth.'", "'.$gameheight.'", "8");
		so.useExpressInstall("'.INFUSIONS.'varcade/expressinstall.swf");
		so.write("gamebox");
	</script>
<center>
<script type="text/javascript"><!--
google_ad_client = "pub-9893909274632313";
//Spel 468x60, skapad 2007-12-06
google_ad_slot = "9569192416";
google_ad_width = 468;
google_ad_height = 60;
//--></script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</center>
</td> 
<td>
<script type="text/javascript"><!--
google_ad_client = "pub-9893909274632313";
/* Spel skrapa 120x600, skapad 2008-02-09 */
google_ad_slot = "9691958768";
google_ad_width = 120;
google_ad_height = 600;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</td>

</tr>';

if ($varcsettings['usergold']=="1")
{
if (!iMEMBER)
{
}
else
{
//edited to work with UG3 and UG2 - Start
if(USERGOLD){
$available = getusergold($userdata['user_id'], 'cash');
} else {
$gold = dbarray(dbquery("SELECT * FROM ".$db_prefix."users_points WHERE owner_id=$userdata[user_id]"));
$available = $gold['points_total']+1;
}
//edited to work with UG3 and UG2 - End
if ($available <= $game['cost'] && $game['cost'] > 1)
{
if (!isset($p))
{
redirect("".INFUSIONS."varcade/arcade.php?lackofgold&game=".$game['lid']."");
}
else
{
redirect("".INFUSIONS."varcade/arcade.php?p=1&lackofgold&game=".$game['lid']."");
}
exit;
}
else
{
//edited to work with UG3 and UG2 - Start
if(USERGOLD){
takegold2($userdata['user_id'],$game['cost'],'cash',0);
} else {
$payment = $gold['points_total']-$game['cost'];
$result = dbquery("UPDATE ".$db_prefix."users_points SET points_total = '$payment' WHERE owner_id =$userdata[user_id] LIMIT 1");
}
//edited to work with UG3 and UG2 - End
echo '<tr><td colspan="4" class="tbl1" align="center"><B>'.$locale['GARC115'].' '.$game['cost'].' '.$locale['GARC116'].'</B></td></tr><br>';
}
}
}
if ($varcsettings['ratings']=="1") 
{
echo "<tr><td align='center'>";
rating_bar($game['lid']);
echo "</td></tr>";
}
echo '</table>';
closetable();
}
else
{
opentable($locale['VARC801']);
echo $locale['VARC179'];
closetable();
}
require_once "footer.php";
if (!isset($p))
{
require_once THEMES."templates/footer.php";
}
?>