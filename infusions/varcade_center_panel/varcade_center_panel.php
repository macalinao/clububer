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
if (!defined("IN_FUSION")) { header("Location: ../../index.php"); exit; }

echo "<script type='text/javascript' language='JavaScript' src='".INFUSIONS."varcade_center_panel/ft_boxover.js'></script>";
include INFUSIONS."varcade/functions.php";
opentable("".$settings['sitename']."´s ".$locale['VARC105']."");
makeheader();

$antal = 6; // how many to show
$gameH = 55; // image height size
$gameW = 85; // image width size
echo '
<style>

.gameIconWrapperInner {
	overflow: hidden;
	width: 87px;
	height: 56px;
	border: 1px solid #fff;
}
.gameIconWrapperInner img {
	margin-top: -1px;
}
.gameIconWrapperOuter {
	width: 89px;
	border: 1px solid #999;
}

.gline { margin-bottom: 1px; }

.gameentry {
	float: left;
	width: 23%;
	text-align: center;
	padding: 0px 3px;
	}

.margb0 { margin-bottom: 0px; }

</style>';

echo "<div id='lajv' align='center'>";

$count = dbcount("(game_id)", "".$db_prefix."varcade_active");
if ($count > 1) {

if ($varcsettings['playingnow'] == "1")
{
echo "<br><div class='forum-caption' align='left'>".$locale['VARC716']."</div>";
echo "<table align='center' style='margin: 0 auto;'><tr>";
echo '<script type="text/javascript" src="'.INFUSIONS.'varcade_center_panel/swfobject.js"></script>';
echo '<td>
<div id="recent">
You need flashplayer <br>
<a href="http://www.adobe.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash">Download Flash Player</a><br>
</div>
	<script type="text/javascript">
		var so = new SWFObject("'.BASEDIR.'switcher.swf", "'.$locale['VARC716'].'","550", "110", "7");
		so.useExpressInstall("'.INFUSIONS.'varcade/expressinstall.swf");
		var showstr = "";
		so.addVariable("t", showstr);
		so.addVariable("x","activegames.php");
		so.addVariable("repeat","true");
		so.write("recent");
	</script>
</td>';
echo "</tr></table>";
}
}

if ($varcsettings['tournaments'] == "1")
{
echo "<br><div class='forum-caption' align='left'>".$locale['TOUR001']."</div>";
include "".INFUSIONS."varcade/arcade_tournament.php";
}

echo "<div class='forum-caption' align='left'>".$locale['VARC701']."</div>";
$result =dbquery("select lid,icon,title,hi_player FROM ".$db_prefix."varcade_games WHERE ".groupaccess('access')." AND status='2' ORDER BY played DESC limit $antal");
echo "<table align='center' style='margin: 0 auto;'><tr>";
while($data = dbarray($result)) {
if ($data['hi_player'] == "0")
{
$hi_player = "".$locale['VARC160']."";
}
else
{
$hi_player = $data['hi_player'];
}
if (file_exists(INFUSIONS."varcade/uploads/thumb/".$data['icon'].""))
{
$showimg = '<IMG SRC=" '.INFUSIONS.'varcade/uploads/thumb/'.$data['icon'].'" width="'.$gameW.'" height="'.$gameH.'" border="0">';
}
else {
$showimg = '<img src=" '.INFUSIONS.'varcade/img/arcade.gif" width="'.$gameW.'" height="'.$gameH.'" border="0">';
}

if ($varcsettings['popup']=="1")
{
$gamelink = '<a href="#" onclick=window.open("'.INFUSIONS.'varcade/arcade.php?p=1&game='.$data['lid'].'","VArcpopup","scrollbars=yes,resizable=yes,width=800,height=700") title=\'header=[ '.trimlink($data['title'], 30).'] body=[ <br><center>'.$showimg.'<br>'.$locale['VARC151'].' <br> '.$hi_player.'  </center>] delay=[0] fade=[on]\'>';
}
else
{
$gamelink = '<a href="'.INFUSIONS.'varcade/arcade.php?game='.$data['lid'].'"  title=\'header=[ '.trimlink($data['title'], 30).'] body=[ <br><center>'.$showimg.'<br>'.$locale['VARC151'].' <br> '.$hi_player.'  </center>] delay=[0] fade=[on]\'>';
}
echo '<td><br><div class="gameentry margb0">';
echo '<div class="gameIconWrapperOuter"><div class="gameIconWrapperInner">';
echo "".$gamelink.""; echo  '<div class="gline">'.$showimg.'</a></div></div></div></div></td>';
}
echo "</tr></table>";
echo '
<script type="text/javascript"><!--
google_ad_client = "pub-9893909274632313";
//468x15, skapad 2007-12-12
google_ad_slot = "2422497819";
google_ad_width = 468;
google_ad_height = 15;
//--></script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>';

echo "<br><div class='forum-caption' align='left'>".$locale['VARC715']."</div><br>";
$result5 = dbquery("SELECT id,   SUM(total_value) / COUNT(total_votes) as rating_rating ,  lid, title,icon,hi_player FROM ".$db_prefix."varcade_rating,
".$db_prefix."varcade_games WHERE status = '2'  AND id = lid GROUP BY id  ORDER BY  rating_rating DESC LIMIT $antal");

echo "<table align='center' style='margin: 0 auto;'><tr>";
while($data = dbarray($result5)) {
if ($data['hi_player'] == "0")
{
$hi_player = "".$locale['VARC160']."";
}
else
{
$hi_player = $data['hi_player'];
}
if (file_exists(INFUSIONS."varcade/uploads/thumb/".$data['icon'].""))
{
$showimg = '<IMG SRC=" '.INFUSIONS.'varcade/uploads/thumb/'.$data['icon'].'" width="'.$gameW.'" height="'.$gameH.'" border="0">';
}
else {
$showimg = '<img src=" '.INFUSIONS.'varcade/img/arcade.gif" width="'.$gameW.'" height="'.$gameH.'" border="0">';
}

if ($varcsettings['popup']=="1")
{
$gamelink = '<a href="#" onclick=window.open("'.INFUSIONS.'varcade/arcade.php?p=1&game='.$data['lid'].'","VArcpopup","scrollbars=yes,resizable=yes,width=800,height=700") title=\'header=[ '.trimlink($data['title'], 30).'] body=[ <br><center>'.$showimg.'<br>'.$locale['VARC151'].' <br> '.$hi_player.'  </center>] delay=[0] fade=[on]\'>';
}
else
{
$gamelink = '<a href="'.INFUSIONS.'varcade/arcade.php?game='.$data['lid'].'" title=\'header=[ '.trimlink($data['title'], 30).'] body=[ <br><center>'.$showimg.'<br>'.$locale['VARC151'].' <br> '.$hi_player.'  </center>] delay=[0] fade=[on]\'>';
}
echo '<td><div class="gameentry margb0">';
echo '<div class="gameIconWrapperOuter"><div class="gameIconWrapperInner">';
echo "".$gamelink.""; echo  '<div class="gline">'.$showimg.'</a></div></div></div></div></td>';
}
echo "</tr></table>";
echo "<br><div class='forum-caption' align='left'>".$locale['VARC702']."</div><br>";
$result3 =dbquery("select lid,title,icon,hi_player FROM ".$db_prefix."varcade_games WHERE ".groupaccess('access')." AND status='2' ORDER BY lastplayed DESC limit $antal");
echo "<table align='center' style='margin: 0 auto;'><tr>";
while($data = dbarray($result3)) {
if ($data['hi_player'] == "0")
{
$hi_player = "".$locale['VARC160']."";
}
else
{
$hi_player = $data['hi_player'];
}
if (file_exists(INFUSIONS."varcade/uploads/thumb/".$data['icon'].""))
{
$showimg = '<IMG SRC=" '.INFUSIONS.'varcade/uploads/thumb/'.$data['icon'].'" width="'.$gameW.'" height="'.$gameH.'" border="0">';
}
else {
$showimg = '<img src=" '.INFUSIONS.'varcade/img/arcade.gif" width="'.$gameW.'" height="'.$gameH.'" border="0">';
}

if ($varcsettings['popup']=="1")
{
$gamelink = '<a href="#" onclick=window.open("'.INFUSIONS.'varcade/arcade.php?p=1&game='.$data['lid'].'","VArcpopup","scrollbars=yes,resizable=yes,width=800,height=700") title=\'header=[ '.trimlink($data['title'], 30).'] body=[ <br><center>'.$showimg.'<br>'.$locale['VARC151'].' <br> '.$hi_player.'  </center>] delay=[0] fade=[on]\'>';
}
else
{
$gamelink = '<a href="'.INFUSIONS.'varcade/arcade.php?game='.$data['lid'].'" title=\'header=[ '.trimlink($data['title'], 30).'] body=[ <br><center>'.$showimg.'<br>'.$locale['VARC151'].' <br> '.$hi_player.'  </center>] delay=[0] fade=[on]\'>';
}
echo '<td><div class="gameentry margb0">';
echo '<div class="gameIconWrapperOuter"><div class="gameIconWrapperInner">';
echo "".$gamelink.""; echo  '<div class="gline">'.$showimg.'</a></div></div></div></div></td>';
}
echo "</tr></table>";
echo '
<script type="text/javascript"><!--
google_ad_client = "pub-9893909274632313";
//468x15, skapad 2007-12-12
google_ad_slot = "2422497819";
google_ad_width = 468;
google_ad_height = 15;
//--></script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>';
echo "<br><div class='forum-caption' align='left'>".$locale['VARC703']."</div><br>";
$result1 =dbquery("select lid,title,icon,hi_player FROM ".$db_prefix."varcade_games WHERE ".groupaccess('access')." AND status='2' ORDER BY lid DESC limit $antal");
echo "<table align='center' style='margin: 0 auto;'><tr>";
while($data = dbarray($result1)) {
if ($data['hi_player'] == "0")
{
$hi_player = "".$locale['VARC160']."";
}
else
{
$hi_player = $data['hi_player'];
}
if (file_exists(INFUSIONS."varcade/uploads/thumb/".$data['icon'].""))
{
$showimg = '<IMG SRC=" '.INFUSIONS.'varcade/uploads/thumb/'.$data['icon'].'" width="'.$gameW.'" height="'.$gameH.'" border="0">';
}
else {
$showimg = '<img src=" '.INFUSIONS.'varcade/img/arcade.gif" width="'.$gameW.'" height="'.$gameH.'" border="0">';
}

if ($varcsettings['popup']=="1")
{
$gamelink = '<a href="#" onclick=window.open("'.INFUSIONS.'varcade/arcade.php?p=1&game='.$data['lid'].'","VArcpopup","scrollbars=yes,resizable=yes,width=800,height=700") title=\'header=[ '.trimlink($data['title'], 30).'] body=[ <br><center>'.$showimg.'<br>'.$locale['VARC151'].' <br> '.$hi_player.'  </center>] delay=[0] fade=[on]\'>';
}
else
{
$gamelink = '<a href="'.INFUSIONS.'varcade/arcade.php?game='.$data['lid'].'" title=\'header=[ '.trimlink($data['title'], 30).'] body=[ <br><center>'.$showimg.'<br>'.$locale['VARC151'].' <br> '.$hi_player.'  </center>] delay=[0] fade=[on]\'>';
}
echo '<td><div class="gameentry margb0">';
echo '<div class="gameIconWrapperOuter"><div class="gameIconWrapperInner">';
echo "".$gamelink.""; echo  '<div class="gline">'.$showimg.'</a></div></div></div></div></td>';
}
echo "</tr></table>";
echo "<br><div class='forum-caption' align='left'>".$locale['VARC704']."</div><br>";
$result2 =dbquery("select lid,title,icon,hi_player FROM ".$db_prefix."varcade_games WHERE ".groupaccess('access')." AND status='2' ORDER BY played ASC limit $antal");
echo "<table align='center' style='margin: 0 auto;'><tr>";
while($data = dbarray($result2)) {
if ($data['hi_player'] == "0")
{
$hi_player = "".$locale['VARC160']."";
}
else
{
$hi_player = $data['hi_player'];
}
if (file_exists(INFUSIONS."varcade/uploads/thumb/".$data['icon'].""))
{
$showimg = '<IMG SRC=" '.INFUSIONS.'varcade/uploads/thumb/'.$data['icon'].'" width="'.$gameW.'" height="'.$gameH.'" border="0">';
}
else {
$showimg = '<img src=" '.INFUSIONS.'varcade/img/arcade.gif" width="'.$gameW.'" height="'.$gameH.'" border="0">';
}

if ($varcsettings['popup']=="1")
{
$gamelink = '<a href="#" onclick=window.open("'.INFUSIONS.'varcade/arcade.php?p=1&game='.$data['lid'].'","VArcpopup","scrollbars=yes,resizable=yes,width=800,height=700") title=\'header=[ '.trimlink($data['title'], 30).'] body=[ <br><center>'.$showimg.'<br>'.$locale['VARC151'].' <br> '.$hi_player.'  </center>] delay=[0] fade=[on]\'>';
}
else
{
$gamelink = '<a href="'.INFUSIONS.'varcade/arcade.php?game='.$data['lid'].'" title=\'header=[ '.trimlink($data['title'], 30).'] body=[ <br><center>'.$showimg.'<br>'.$locale['VARC151'].' <br> '.$hi_player.'  </center>] delay=[0] fade=[on]\'>';
}
echo '<td><div class="gameentry margb0">';
echo '<div class="gameIconWrapperOuter"><div class="gameIconWrapperInner">';
echo "".$gamelink.""; echo  '<div class="gline">'.$showimg.'</a></div></div></div></div></td>';
}
echo "</tr></table>";
echo "<br><div class='forum-caption' align='left'>".$locale['VARC705']."</div><br>";
$result4 = dbquery ("SELECT lid,icon,title,hi_player FROM ".$db_prefix."varcade_games WHERE ".groupaccess('access')." AND status='2' ORDER BY RAND() LIMIT $antal");
echo "<table align='center' style='margin: 0 auto;'><tr>";
while($data = dbarray($result4)) {
if ($data['hi_player'] == "0")
{
$hi_player = "".$locale['VARC160']."";
}
else
{
$hi_player = $data['hi_player'];
}
if (file_exists(INFUSIONS."varcade/uploads/thumb/".$data['icon'].""))
{
$showimg = '<IMG SRC=" '.INFUSIONS.'varcade/uploads/thumb/'.$data['icon'].'" width="'.$gameW.'" height="'.$gameH.'" border="0">';
}
else {
$showimg = '<img src=" '.INFUSIONS.'varcade/img/arcade.gif" width="'.$gameW.'" height="'.$gameH.'" border="0">';
}

if ($varcsettings['popup']=="1")
{
$gamelink = '<a href="#" onclick=window.open("'.INFUSIONS.'varcade/arcade.php?p=1&game='.$data['lid'].'","VArcpopup","scrollbars=yes,resizable=yes,width=800,height=700") title=\'header=[ '.trimlink($data['title'], 30).'] body=[ <br><center>'.$showimg.'<br>'.$locale['VARC151'].' <br> '.$hi_player.'  </center>] delay=[0] fade=[on]\'>';
}
else
{
$gamelink = '<a href="'.INFUSIONS.'varcade/arcade.php?game='.$data['lid'].'" title=\'header=[ '.trimlink($data['title'], 30).'] body=[ <br><center>'.$showimg.'<br>'.$locale['VARC151'].' <br> '.$hi_player.'  </center>] delay=[0] fade=[on]\'>';
}
echo '<td><div class="gameentry margb0">';
echo '<div class="gameIconWrapperOuter"><div class="gameIconWrapperInner">';
echo "".$gamelink.""; echo  '<div class="gline">'.$showimg.'</a></div></div></div></div></td>';
}
echo "</tr></table>";

echo '
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
</center>';

echo "</div>";
echo "<center>".$locale['VARC220']." ".dbcount("(lid)", "".$db_prefix."varcade_games where status='2'")." ".$locale['VARC221']." ".$locale['VARC222']." ".dbcount("(cid)", "".$db_prefix."varcade_cats")." ".$locale['VARC223']." ".dbcount("(id)", "".$db_prefix."varcade_rating")." ".$locale['VARC224']." ".dbcount("(comment_id)", "".$db_prefix."comments where comment_type='G'")." ".$locale['VARC225']."</center>";

closetable();
require_once INFUSIONS."varcade/footer.php";



?>