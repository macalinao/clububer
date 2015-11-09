<?php
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Content-type: text/html; charset=ISO-8859-9");
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
|the original author(s).		                  |
+--------------------------------------------------+
|The Kroax is written by Domi & fetloser  |
|http://www.venue.nu			      |
+-------------------------------------------------*/
if (!defined("IN_FUSION")) { die("Access Denied"); }

include INFUSIONS."the_kroax/functions.php";
echo "<script type='text/javascript' language='JavaScript' src=' ".INFUSIONS."the_kroax_center_panel/ft_boxover.js'></script>";

opentable("".$settings['sitename']." ".$locale['KROAX203'] ."");
makeheader();
$antal = "0,4"; // how many to show
$movieH = 100; // image height size
$movieW = 150; // image width size

echo "<div id='lajv' align='center'>";

if ($kroaxsettings['kroax_set_playingnow'] == "1")
{
$count = dbcount("(movie_id)", "".$db_prefix."kroax_active");
if ($count > 2) {
echo "<br><div class='forum-caption' align='left'>".$locale['KROAXC716']."</div>";

echo "<table align='center' style='margin: 0 auto;'><tr>";
echo '<script type="text/javascript" src="'.INFUSIONS.'the_kroax/swfobject.js"></script>';
echo '<td>
<div id="recent">
You need flashplayer <br>
<a href="http://www.adobe.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash">Download Flash Player</a><br>
</div>
	<script type="text/javascript">
		var so = new SWFObject("switcher.swf", "'.$locale['KROAXC716'].'","550", "150", "7");
		so.useExpressInstall("'.INFUSIONS.'the_kroax/expressinstall.swf");
		var showstr = "";
		so.addVariable("t", showstr);
		so.addVariable("x","playingnow.php");
		so.addVariable("repeat","true");
		so.write("recent");
	</script>
</td>';
echo "</tr></table>";

}

}

echo "<div class='forum-caption' align='left'>".$locale['KROAXC001']."</div>";

$result =dbquery("select * FROM ".$db_prefix."kroax WHERE ".groupaccess('kroax_access')." AND  ".groupaccess('kroax_access_cat')." AND kroax_approval='' ORDER BY kroax_hits DESC limit $antal");
echo "<table align='center' style='margin: 0 auto;'><tr>";
while($data = dbarray($result)) {
$checkurl = url_exists($data['kroax_tumb']);
$type = substr($data['kroax_url'], -3, 3);
if($type == "mp3")
{
$showimg = '<img src="'.INFUSIONS.'the_kroax/img/musicstream.jpg"  width="'.$movieW.'" height="'.$movieH.'">';
}
elseif ($checkurl == "1") {
$showimg = '<IMG SRC="'.$data['kroax_tumb'].'"  width="'.$movieW.'" height="'.$movieH.'">';
}
else {
$showimg = '<img src="'.INFUSIONS.'the_kroax/img/nopic.gif"  width="'.$movieW.'" height="'.$movieH.'">';
}

if ($kroaxsettings['kroax_set_show'] == "1")
{
$videolink = '<a href="'.INFUSIONS.'the_kroax/embed.php?url='.$data['kroax_id'].'" title=\'header=[ '.trimlink($data['kroax_titel'], 30).'] body=[ <br><center>'.$showimg.'<br></center>] delay=[0] fade=[on]\'>';
}
else
{
$videolink = '<a href="#" onclick=window.open("'.INFUSIONS.'the_kroax/embed.php?p=1&url='.$data['kroax_id'].'","Click","scrollbars=yes,resizable=yes,width=800,height=700") title=\'header=[ '.trimlink($data['kroax_titel'], 30).'] body=[ <br><center>'.$showimg.'<br>'.$locale['KROAXC151'].' <br> '.$hi_player.'  </center>] delay=[0] fade=[on]\'>';
}
echo "<td>";
echo "".$videolink.""; echo  ''.$showimg.'</a></td>';
}
echo "</tr></table>";

echo "<div class='forum-caption' align='left'>".$locale['KROAXC002']."</div>";
$result5 = dbquery("SELECT id,   SUM(total_value) / COUNT(total_votes) as rating_rating , kroax_url,kroax_id, kroax_titel,kroax_tumb,kroax_uploader FROM ".$db_prefix."kroax_rating, 
".$db_prefix."kroax WHERE ".groupaccess('kroax_access')." AND  ".groupaccess('kroax_access_cat')." AND kroax_approval=''  AND id =kroax_id GROUP BY id  ORDER BY  rating_rating DESC LIMIT $antal");
echo "<table align='center' style='margin: 0 auto;'><tr>";
while($data = dbarray($result5)) {
$checkurl = url_exists($data['kroax_tumb']);
$type = substr($data['kroax_url'], -3, 3);
if($type == "mp3")
{
$showimg = '<img src="'.INFUSIONS.'the_kroax/img/musicstream.jpg"  width="'.$movieW.'" height="'.$movieH.'">';
}
elseif ($checkurl == "1") {
$showimg = '<IMG SRC="'.$data['kroax_tumb'].'" width="'.$movieW.'" height="'.$movieH.'">';
}
else {
$showimg = '<img src="'.INFUSIONS.'the_kroax/img/nopic.gif"  width="'.$movieW.'" height="'.$movieH.'">';
}

if ($kroaxsettings['kroax_set_show'] == "1")
{
$videolink = '<a href="'.INFUSIONS.'the_kroax/embed.php?url='.$data['kroax_id'].'" title=\'header=[ '.trimlink($data['kroax_titel'], 30).'] body=[ <br><center>'.$showimg.' <br> </center>] delay=[0] fade=[on]\'>';
}
else
{
$videolink = '<a href="#" onclick=window.open("'.INFUSIONS.'the_kroax/embed.php?p=1&url='.$data['kroax_id'].'","Click","scrollbars=yes,resizable=yes,width=800,height=700") title=\'header=[ '.trimlink($data['kroax_titel'], 30).'] body=[ <br><center>'.$showimg.'<br> </center>] delay=[0] fade=[on]\'>';
}
echo "<td>";
echo "".$videolink.""; echo  ''.$showimg.'</a></td>';
}
echo "</tr></table>";
echo "<div class='forum-caption' align='left'>".$locale['KROAXC723']."</div>";

$result3 =dbquery("select * FROM ".$db_prefix."kroax WHERE ".groupaccess('kroax_access')." AND  ".groupaccess('kroax_access_cat')." AND kroax_approval='' ORDER BY kroax_lastplayed DESC limit $antal");
echo "<table align='center' style='margin: 0 auto;'><tr>";
while($data = dbarray($result3)) {
$checkurl = url_exists($data['kroax_tumb']);
$type = substr($data['kroax_url'], -3, 3);
if($type == "mp3")
{
$showimg = '<img src="'.INFUSIONS.'the_kroax/img/musicstream.jpg"  width="'.$movieW.'" height="'.$movieH.'">';
}
elseif ($checkurl == "1") {
$showimg = '<IMG SRC="'.$data['kroax_tumb'].'" width="'.$movieW.'" height="'.$movieH.'">';
}
else {
$showimg = '<img src="'.INFUSIONS.'the_kroax/img/nopic.gif"  width="'.$movieW.'" height="'.$movieH.'">';
}

if ($kroaxsettings['kroax_set_show'] == "1")
{
$videolink = '<a href="'.INFUSIONS.'the_kroax/embed.php?url='.$data['kroax_id'].'" title=\'header=[ '.trimlink($data['kroax_titel'], 30).'] body=[ <br><center>'.$showimg.'<br> </center>] delay=[0] fade=[on]\'>';
}
else
{
$videolink = '<a href="#" onclick=window.open("'.INFUSIONS.'the_kroax/embed.php?p=1&url='.$data['kroax_id'].'","Click","scrollbars=yes,resizable=yes,width=800,height=700") title=\'header=[ '.trimlink($data['kroax_titel'], 30).'] body=[ <br><center>'.$showimg.'<br> </center>] delay=[0] fade=[on]\'>';
}
echo "<td>";
echo "".$videolink.""; echo  ''.$showimg.'</a></td>';
}
echo "</tr></table>";

echo "<div class='forum-caption' align='left'>".$locale['KROAXC004']."</div>";
$result1 =dbquery("select * FROM ".$db_prefix."kroax WHERE ".groupaccess('kroax_access')."  AND kroax_approval='' ORDER BY kroax_id DESC limit $antal");
echo "<table align='center' style='margin: 0 auto;'><tr>";
while($data = dbarray($result1)) {
$checkurl = url_exists($data['kroax_tumb']);
$type = substr($data['kroax_url'], -3, 3);
if($type == "mp3")
{
$showimg = '<img src="'.INFUSIONS.'the_kroax/img/musicstream.jpg"  width="'.$movieW.'" height="'.$movieH.'">';
}
elseif ($checkurl == "1") {
$showimg = '<IMG SRC="'.$data['kroax_tumb'].'" width="'.$movieW.'" height="'.$movieH.'">';
}
else {
$showimg = '<img src="'.INFUSIONS.'the_kroax/img/nopic.gif"  width="'.$movieW.'" height="'.$movieH.'">';
}

if ($kroaxsettings['kroax_set_show'] == "1")
{
$videolink = '<a href="'.INFUSIONS.'the_kroax/embed.php?url='.$data['kroax_id'].'" title=\'header=[ '.trimlink($data['kroax_titel'], 30).'] body=[ <br><center>'.$showimg.'<br>  </center>] delay=[0] fade=[on]\'>';
}
else
{
$videolink = '<a href="#" onclick=window.open("'.INFUSIONS.'the_kroax/embed.php?p=1&url='.$data['kroax_id'].'","Click","scrollbars=yes,resizable=yes,width=800,height=700") title=\'header=[ '.trimlink($data['kroax_titel'], 30).'] body=[ <br><center>'.$showimg.'<br> </center>] delay=[0] fade=[on]\'>';
}
echo "<td>";
echo "".$videolink.""; echo  ''.$showimg.'</a></td>';
}
echo "</tr></table>";

echo "<div class='forum-caption' align='left'>".$locale['KROAXC003']."</div>";

$result4 = dbquery ("SELECT * FROM ".$db_prefix."kroax WHERE ".groupaccess('kroax_access')." AND  ".groupaccess('kroax_access_cat')." AND kroax_approval='' ORDER BY RAND() LIMIT $antal");
echo "<table align='center' style='margin: 0 auto;'><tr>";
while($data = dbarray($result4)) {
$checkurl = url_exists($data['kroax_tumb']);
$type = substr($data['kroax_url'], -3, 3);
if($type == "mp3")
{
$showimg = '<img src="'.INFUSIONS.'the_kroax/img/musicstream.jpg"  width="'.$movieW.'" height="'.$movieH.'">';
}
elseif ($checkurl == "1") {
$showimg = '<IMG SRC="'.$data['kroax_tumb'].'" width="'.$movieW.'" height="'.$movieH.'">';
}
else {
$showimg = '<img src="'.INFUSIONS.'the_kroax/img/nopic.gif"  width="'.$movieW.'" height="'.$movieH.'">';
}

if ($kroaxsettings['kroax_set_show'] == "1")
{
$videolink = '<a href="'.INFUSIONS.'the_kroax/embed.php?url='.$data['kroax_id'].'" title=\'header=[ '.trimlink($data['kroax_titel'], 30).'] body=[ <br><center>'.$showimg.'<br>  </center>] delay=[0] fade=[on]\'>';
}
else
{
$videolink = '<a href="#" onclick=window.open("'.INFUSIONS.'the_kroax/embed.php?p=1&url='.$data['kroax_id'].'","Click","scrollbars=yes,resizable=yes,width=800,height=700") title=\'header=[ '.trimlink($data['kroax_titel'], 30).'] body=[ <br><center>'.$showimg.'<br>  </center>] delay=[0] fade=[on]\'>';
}
echo "<td>";
echo "".$videolink.""; echo  ''.$showimg.'</a></td>';
}
echo "</tr></table>";
echo "</div>";
echo "<center>".$locale['KROAX102']." ".dbcount("(kroax_id)", "".$db_prefix."kroax")."".$locale['KROAX103']." ".dbcount("(cid)", "".$db_prefix."kroax_kategori")." ".$locale['KROAX104']." ".dbcount("(id)", "".$db_prefix."kroax_rating")." ".$locale['KROAX105']." ".dbcount("(comment_id)", "".$db_prefix."comments where comment_type='K'")." ".$locale['KROAX107']."</center>";

$result = dbquery("DELETE FROM ".$db_prefix."kroax_active WHERE lastactive  <".(time()-60)."");
$result = dbquery("DELETE FROM ".$db_prefix."kroax_activeusr WHERE lastactive  <".(time()-60)."");

closetable();

?>