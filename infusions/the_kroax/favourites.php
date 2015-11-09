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
require_once "../../maincore.php";

if (!iMEMBER) { header("Location:../../index.php"); exit; }

if (!isset($p))
{
require_once THEMES."templates/header.php";
}
else
{
require_once THEME."theme.php";
echo "<link rel='stylesheet' href='".THEME."styles.css' type='text/css'>";
}

include INFUSIONS."the_kroax/functions.php";

if (!$kroaxsettings['kroax_set_favorites'] == "1") { header("Location:../../index.php"); exit; }

if (!isset($rowstart) || !isNum($rowstart)) $rowstart = 0;

opentable($locale['FKROAX103']);
makeheader();
echo "<div id='lajv'>";
echo "</div>";
if(iMEMBER)
{
if(iMEMBER && isset($fav_id) && isset($removefav)){
dbquery("DELETE FROM ".$db_prefix."kroax_favourites WHERE fav_user='".$userdata[user_id]."' AND fav_id='".$fav_id."'");
}

$result= dbquery("SELECT ter.*,kroax_id,kroax_url,kroax_tumb,kroax_titel,kroax_description FROM ".$db_prefix."kroax_favourites ter
		LEFT JOIN ".$db_prefix."kroax tusr ON ter.fav_id=tusr.kroax_id
		WHERE fav_user='".$userdata['user_id']."'");
if (($kroaxsettings['kroax_set_allowplaylist'] == "1") && (iMEMBER))
{
echo "<center><a href='#' onclick=window.open('".INFUSIONS."the_kroax/playlist.php','playlist','scrollbars=yes,resizable=yes,width=770,height=350')><b>".$locale['FKROAX111']."</b></a></center>";
}
if (dbrows($result) != 0) {
$numRecords = dbrows($result);
echo "<div align='center' style='margin-top:5px;'>".makePageNav($rowstart,5,$numRecords,3,FUSION_SELF."?")."\n</div>\n"; 
$fav20= dbquery("SELECT ter.*,kroax_id,kroax_url,kroax_tumb,kroax_titel,kroax_description  FROM ".$db_prefix."kroax_favourites ter
		LEFT JOIN ".$db_prefix."kroax tusr ON ter.fav_id=tusr.kroax_id
		WHERE fav_user='".$userdata['user_id']."' LIMIT ".$rowstart.", 5");
while($data = dbarray($fav20)) {
echo "<table width='100%' cellpadding='0' cellspacing='1' class='tbl-border'>";
$type = substr($data['kroax_url'], -3, 3);
if($type == "mp3")
{
$showimg = "<img src='".INFUSIONS."the_kroax/img/musicstream.jpg' width='130' height='80' alt='".$data['kroax_titel']."'>";
}
elseif ($data['kroax_tumb']) {
$showimg =  "<IMG SRC='".$data['kroax_tumb']."' width='130' height='80' alt='".$data['kroax_titel']."'>";
}
else {
$showimg = "<img src='".INFUSIONS."the_kroax/img/nopic.gif' width='130' height='80' alt='".$data['kroax_titel']."'>";
}
echo "<tr>  <td colspan='5' class='forum-caption'><b>".$data['kroax_titel']."</b></td> </tr>
<tr> <td align='center' width='20%' class='tbl2'><span class='small'> ".$showimg." ";
echo "<td align='center' width='60%' class='tbl2'><span class='small'>".nl2br(parseubb($data['kroax_description']))."</span><br><br></td>
<td align='center' width='20%' class='tbl2'>";
if ($kroaxsettings['kroax_set_show'] == "1")
{
echo "<input style='cursor:pointer;' style='width: 80px;' type=\"button\" class=\"button\" onClick=\"self.location='embed.php?url=".$data['kroax_id']."'\" value=\"".$locale['FKROAX108']."\">";
}
else
{
echo "<input style='cursor:pointer;' style='width: 80px;' type=\"button\" class=\"button\" onclick=window.open('".INFUSIONS."the_kroax/embed.php?p=1&url=".$data['kroax_id']."','Click','scrollbars=yes,resizable=yes,width=800,height=700') value=\"".$locale['FKROAX108']."\">";
}
echo "<br><input style='cursor:pointer;' style='width: 80px;' type=\"button\" class=\"button\" onclick=window.open('".INFUSIONS."the_kroax/embed.php?p=1&url=".$data['kroax_id']."','Click','scrollbars=yes,resizable=yes,width=800,height=700') value=\"".$locale['FKROAX112']."\">";
echo "<br><input style='cursor:pointer;' style='width: 80px;' type=\"button\" class=\"button\" onClick=\"self.location='favourites.php?fav_id=".$data['fav_id']."&removefav'\" value=\"".$locale['FKROAX110']."\"></td>
</tr><br>"; 
}
echo "</table>";

if (($kroaxsettings['kroax_set_allowplaylist'] == "1") && (iMEMBER))
{
echo "<center><a href='#' onclick=window.open('".INFUSIONS."the_kroax/playlist.php','playlist','scrollbars=yes,resizable=yes,width=770,height=350')><b>Launch this in my playlist</b></a></center>";
}

} else {

echo "<br><center><b>".$locale['FKROAX104']."</b></center><br>";
}
echo "<div align='center' style='margin-top:5px;'>".makePageNav($rowstart,5,@$numRecords,3,FUSION_SELF."?")."\n</div>\n"; 
closetable();
}
else
{
redirect("".BASEDIR."index.php");	
closetable();
}
require_once "footer.php";
if (!isset($p))
{
require_once THEMES."templates/footer.php";
}
?>

