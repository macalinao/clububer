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
require_once THEME."theme.php";
echo "<link rel='stylesheet' href='".THEME."styles.css' type='text/css'>";
include INFUSIONS."the_kroax/functions.php";

if (!$kroaxsettings['kroax_set_allowplaylist'] == "1") { header("Location:../../index.php"); exit; }

if ($kroaxsettings['kroax_set_keepalive'] == "1")
{
echo "<script type='text/javascript' src='".INFUSIONS."the_kroax/onlinestatus.js'></script>";
echo "<body onload=\"ajax(page,'onlinestatus','0')\"></body>";
}

opentable($locale['FKROAX103']);

echo '<script type="text/javascript" src="'.INFUSIONS.'the_kroax/swfobject.js"></script>';


echo "<table border='0' cellpadding='0' align='center' style='margin: 0 auto;'>
	<tr>
		<td>";
echo '
<div id="videobox2">
<a href="http://www.adobe.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash">Download Flash Player</a><br>
</div>
<script type="text/javascript">
var s1 = new SWFObject("flash_flv_player/flvplayer.swf","mpl","720","280","7");
s1.useExpressInstall("expressinstall.swf"); 
s1.addParam("allowfullscreen","true");
s1.addVariable("file", "streamplaylist.php");
s1.addVariable("displaywidth","420");
s1.addVariable("width","720");
s1.addVariable("height","280");
s1.addVariable("overstretch", "fit");
s1.addVariable("autostart","true");
s1.addVariable("repeat","true");
s1.addVariable("showicons","true");
s1.addVariable("showdigits", "true");
s1.addVariable("autostart", "true");
s1.addVariable("shuffle", "true");
s1.addVariable("linkfromdisplay","false");
s1.addVariable("thumbsinplaylist","true");
s1.addVariable("autoscroll","false");
s1.addVariable("showstop","false"); 
s1.addVariable("showdownload","false"); 

s1.write("videobox2");
</script></td>	</tr></table>';


if ($kroaxsettings['kroax_set_keepalive'] == "1")
{
echo "<div id ='onlinestatus'>";
echo "Updateing info for site tracking.....";
echo '</div>';
}

closetable();

//s1.addVariable("file", "external_feed.php%3Fex%3Dwww.venue.nu/infusions/the_kroax/streamplaylist.php"); //included just if we wanna stream others playlists..



?>