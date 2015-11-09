<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: embed.php
| Author: Domi & fetloser 
| www.venue.nu		
| Embed player functions by Wain Glaister    
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

if (isset($url) && !isNum($url)) redirect("index.php");


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

if ($kroaxsettings['kroax_set_keepalive'] == "1")
{
//add_to_head("<script type='text/javascript' src=".INFUSIONS."the_kroax/onlinestatus.js'></script>");

echo "<script type='text/javascript' src='".INFUSIONS."the_kroax/onlinestatus.js'></script>";
echo "<body onload=\"ajax(page,'onlinestatus','".$url."')\"></body>";

}


function RemoveExtension($strName)
{
$ext = strrchr($strName, '.');

if($ext !== false)
{
$strName = substr($strName, 0, -strlen($ext));
}
return $strName;
}

echo '<script type="text/javascript" src="'.INFUSIONS.'the_kroax/swfobject.js"></script>';

//GET ACCESS LEVEL AND REDIRECT IF CHEAT LOOP IS DETECTED

$detect = dbquery("SELECT kroax_access,kroax_cat FROM ".$db_prefix."kroax WHERE kroax_id='$url'");
while ($detect_access = dbarray($detect)) {
$access = $detect_access['kroax_access'];
$kroax_cat = $detect_access['kroax_cat'];
}
if(checkgroup($access)) {
//PROCEED AS PLANNED
}else{
redirect(INFUSIONS."the_kroax/kroax.php?noaccess");
}

$detect = dbquery("SELECT access FROM ".$db_prefix."kroax_kategori WHERE cid='$kroax_cat'");
while ($detect_access = dbarray($detect)) {
$access = $detect_access['access'];
}
if(checkgroup($access)) {
//PROCEED AS PLANNED
}else{
redirect(INFUSIONS."the_kroax/kroax.php?noaccess");

}
//END DETECTION

$counthits = dbquery("UPDATE ".$db_prefix."kroax SET kroax_hits=kroax_hits+1 WHERE kroax_id='$url'");
$setplayed = dbquery("UPDATE ".$db_prefix."kroax SET kroax_lastplayed='".time()."' WHERE kroax_id='$url'");

$result = dbquery("SELECT * FROM ".$db_prefix."kroax WHERE kroax_id='$url'");
$data = dbarray($result);
$uresult = dbquery("SELECT user_id,user_name FROM ".$db_prefix."users WHERE user_name='".$data['kroax_uploader']."'");
$udata = dbarray($uresult);

$url = $data['kroax_url'];
$embed = $data['kroax_embed'];
$thumb = $data['kroax_tumb'];
$title = $data['kroax_titel'];
$lurl="".$settings['siteurl']."infusions/the_kroax";
if (!isset($p))
{
add_to_title(" - ".$data['kroax_titel']."");
}

if ($kroaxsettings['kroax_set_allowembed'] == '1')
{
$embedcode ='
<textarea cols="49" rows="2">
<object width="400" height="373">
<param name="movie" value="'.$url.'">
</param><param name="wmode" value="transparent"></param>
<embed src="'.$url.'" type="application/x-shockwave-flash" wmode="transparent" width="425" height="373">
</embed></object>
</textarea>';
$youtubeembedcode ='
<textarea cols="49" rows="2">
<script type="text/javascript" src="'.$lurl.'/swfobject.js"></script>
<div id="videoebox">
<a href="http://www.adobe.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash">Download Flash Player</a><br>
</div>
<script type="text/javascript">
var s4 = new SWFObject("'.$lurl.'/flash_flv_player/flvplayer.swf","single","280","280","7");
s4.useExpressInstall("expressinstall.swf"); 
s4.addParam("allowfullscreen","true");
s4.addVariable("autostart","false");
s4.addVariable("type","flv");
s4.addVariable("file","'.$url.'");
s4.addVariable("logo","'.$videoimg.'");
s4.addVariable("image","'.$thumb.'");
s4.addVariable("displayheight","320");
s4.addVariable("width","320");
s4.addVariable("height","320");
s4.write("videoebox");
</script>
</textarea>';
}
else
{
$embedcode ="";
$youtubeembedcode ="";
}
if ($kroaxsettings['kroax_set_allowdownloads'] == '1') 
{
$downloadcode = '<br><a href="download.php?url='.$url.'&title='.$title.'" target="_blank">'.$locale['MKROAX104'].'</a><br>';
$youtubedownloadcode = '<a href="download.php?url='.$file.'&title='.$title.'&youtube" target="_blank">'.$locale['MKROAX104'].'</a><br>';

}
else
{
$downloadcode ="";
$youtubedownloadcode ="";
}

if ($kroaxsettings['kroax_set_bannerimg']) 
{
$videoimg = $kroaxsettings['kroax_set_bannerimg'];
}
else
{
$videoimg = "";
}

opentable("---> ".$title."");
if ($kroaxsettings['kroax_set_keepalive'] == "1")
{
echo "<div id ='onlinestatus'>";
echo '<div style="height: 30px;"><em><IMG SRC="/infusions/the_kroax/img/loading.gif">'.$locale['MKROAX116'].'</em></div>';
echo '</div>';
}

if (!isset($p))
{
makeheader();
echo "<div id='lajv'>";
echo "</div>";
}
if ($kroaxsettings['kroax_set_related'] == "1")
{
echo" <table width='120px;' align='left'>";
echo "<tr width='15%'><td class ='tbl2' width='15%' align='center'>".$locale['MKROAX105']."</td></tr>";
$relresult = dbquery("select * from ".$db_prefix."kroax WHERE ".groupaccess('kroax_access')." AND ".groupaccess('kroax_access_cat')." AND kroax_cat='".$data['kroax_cat']."' AND kroax_approval='' ORDER BY RAND() DESC LIMIT 0,5");
while($reldata = dbarray($relresult)) {
echo "<tr><td align='center' class='tbl2'>";
$rtype = substr($reldata['kroax_url'], -3, 3);
if($rtype == "mp3")
{
$showimg = "<img src='".INFUSIONS."the_kroax/img/musicstream.jpg' width='50' height='30'>";
}
elseif ($reldata['kroax_tumb']) {
$showimg = "<IMG SRC='".$reldata['kroax_tumb']."' width='70' height='50'>";
}
else {
$showimg = "<img src='".INFUSIONS."the_kroax/img/nopic.gif' width='70' height='50'>";
}
if (!isset($p))
{
$videolink = '<a href="'.INFUSIONS.'the_kroax/embed.php?url='.$reldata['kroax_id'].'">';
}
else
{
$videolink = '<a href="#" onclick=window.open("'.INFUSIONS.'the_kroax/embed.php?p=1&url='.$reldata['kroax_id'].'","Click","scrollbars=yes,resizable=yes,width=800,height=600")>';
}
echo "".$videolink.""; echo  ''.$showimg.'<br>'.trimlink($reldata['kroax_titel'], 15).'</a></td></tr>';
}
if ($kroaxsettings['kroax_set_keepalive'] == "1")
{
$result_guest = dbrows(dbquery("SELECT * FROM ".$db_prefix."kroax_activeusr WHERE movie_id='".$data['kroax_id']."' AND member='0'"));
$result_total = dbrows(dbquery("SELECT * FROM ".$db_prefix."kroax_activeusr WHERE movie_id='".$data['kroax_id']."' AND  member>='0'"));
$result_members = dbrows(dbquery("SELECT * FROM ".$db_prefix."kroax_activeusr WHERE movie_id='".$data['kroax_id']."' AND  member>0"));
echo "<tr><td class='tbl2' align='center'><b>".$locale['KROAXC724']."</b></td></tr>";
echo "<tr><td align='center' class='tbl2'>";
echo ''.$locale['KROAXC720'].''.$result_members.' 
</td></tr>';
echo "<tr><td align='center' class='tbl2'>";
echo ''.$locale['KROAXC721'].''.$result_guest.'
</td></tr>';
echo "<tr><td align='center' class='tbl2'>";
echo ' '.$locale['KROAXC722'].''.$result_total.' ';
}

echo '</table>';

}
$cdata = dbarray(dbquery("SELECT * FROM ".$db_prefix."kroax_kategori WHERE cid='".$data['kroax_cat']."'"));
echo '<table width="85%" border="0" align="center"><tr><td align="center">';
echo '<table align="center" width="90%" cellpadding="0" cellspacing="1" class="tbl-border" style="margin: 0 auto;">';
echo '<tr>';
if (!isset($p))
{
echo '	<td class="tbl2"><span class="small"><B>'.$locale['KROAX210'].' </B><a href="'.INFUSIONS.'the_kroax/kroax.php?category='.$cdata['cid'].'">'.$cdata['title'].'</a></span></td>';
}
else
{
echo '<td class="tbl2"><span class="small"><B>'.$locale['KROAX210'].' </B>'.$cdata['title'].'</span></td>';
}
if (!isset($p))
{
echo '<td class="tbl2"><span class="small"><B>'.$locale['KROAX114'].' </B><a href="'.BASEDIR.'profile.php?lookup='.$udata['user_id'].'">'.$data['kroax_uploader'].'</a></span></td>';
}
else
echo '<td class="tbl2"><span class="small"><B>'.$locale['KROAX114'].' </B>'.$data['kroax_uploader'].'</span></td>';
{
echo '	<td class="tbl2"><span class="small"><B>'.$locale['KROAX317'].' </B> '.showdate('forumdate', $data['kroax_date']).'</span></td>';
}
if ($kroaxsettings['kroax_set_allowdownloads'] == '1') 
{
echo '<td class="tbl2"><span class="small"><B>'.$locale['MKROAX103'].' </B> '.$data['kroax_downloads'].'</span></td>';
}
echo '<td class="tbl2"><span class="small"><B>'.$locale['KROAX318'].' </B> '.$data['kroax_hits'].'</span></td></tr>';
echo '</table>';


// WG - mod to select a suitable embedded player
// include the file containing the arrays of accepted file extensions
include INFUSIONS."the_kroax/embeddedextensions.php";

// create a regex to get the file extension
// file extension is allowed to contain 2 to 5 charachers
// both upper and lower case and any digit
$pattern = "/\.[a-zA-Z-0-9]{2,5}$/";
preg_match($pattern, $url, $match);

// test the file extension against the allowed arrays
// and add code for the appropriate media

if (array_search($match[0], $quicktime_extensions) !== FALSE)
{
	quicktime_player($url);
}
elseif (array_search($match[0], $windowsmedia_extensions) !== FALSE)
{
	windowsmedia_player($url);
}
elseif (array_search($match[0], $flash_extensions) !== FALSE)
{
	flash_player($url);
}
elseif (array_search($match[0], $realplayer_extensions) !== FALSE)
{
	real_player($url);

}
elseif (array_search($match[0], $not_config) !== FALSE)
{
	misc($url);
}
elseif (array_search($match[0], $weird_extensions) !== FALSE)
{
	weird_player($url);

}

elseif (array_search($match[0], $flash_flv_extensions) !== FALSE)
{
	flvplayer($url);
}

elseif (array_search($match[0], $myspace) !== FALSE)
{
	space_player($url);

}

elseif (array_search($match[0], $embed_code) !== FALSE)
{
	embed_player($embed);

}

elseif (array_search($match[0], $divx_code) !== FALSE)
{
	divx_player($url);

}

elseif (array_search($match[0], $googlevideo) !== FALSE)
{
	googleplayer($url);

}
elseif (array_search($match[0], $streammedia) !== FALSE)
{
	streammedia($url);

}
elseif (array_search($match[0], $mp3media) !== FALSE)
{
	mp3media($url);

}

else
{
	// a player could not be found
	echo $locale['WGKROAX001'] . $url . $locale['WGKROAX002'] . $match[0] . $locale['WGKROAX003'];
}
echo '
<center>
<script type="text/javascript"><!--
google_ad_client = "pub-9893909274632313";
/* Humor , 468x60, skapad 2008-08-18 */
google_ad_slot = "1645736433";
google_ad_width = 468;
google_ad_height = 60;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script></center>
';


$kroax_comment_count = dbcount("(comment_id)", "".$db_prefix."comments", "comment_type='K' AND comment_item_id='".$data['kroax_id']."'");
echo '<table align="center" width="98%" style="margin: 0 auto;">';
echo '<tr><td align="center">';
if (($kroaxsettings['kroax_set_favorites'] == "1") && (iMEMBER))
{
$row2 = dbquery("SELECT * FROM ".$db_prefix."kroax_favourites WHERE fav_id=".$data['kroax_id']." AND fav_user='".$userdata['user_id']."'");
$fav_id2=dbarray($row2);
$fav_id2 = $fav_id2['fav_id'];
if( $data['kroax_id'] != $fav_id2){

if (!isset($p))
{
echo "<a href='".INFUSIONS."the_kroax/add_favourite.php?fav_id=".$data['kroax_id']."&fav_user=".$userdata['user_id']."'><b>".$locale['FKROAX107']."</b></a>  ][ ";
}
else
{
echo "<a href='".INFUSIONS."the_kroax/add_favourite.php?fav_id=".$data['kroax_id']."&fav_user=".$userdata['user_id']."&p=1'><b>".$locale['FKROAX107']."</b></a>  ][ ";
}

}
}
if ($kroaxsettings['kroax_set_comments'] == "1")
{
echo "<a href='#' onclick=window.open('".INFUSIONS."the_kroax/callcomments.php?comment_id=".$data['kroax_id']."','Comments','scrollbars=yes,resizable=yes,width=650,height=650')><b>".$locale['KROAX302']."</b></a>($kroax_comment_count) ][ ";
}
if ($kroaxsettings['kroax_set_recommend'] == "1")
{
echo "<a href='#' onclick=window.open('".INFUSIONS."the_kroax/tipafriend.php?movie_id=".$data['kroax_id']."','Tipafriend','scrollbars=yes,resizable=yes,width=350,height=300')><b>".$locale['KROAX303']."</b></a>  ][ ";
}
if ($kroaxsettings['kroax_set_report'] == "1")
{
if (iMEMBER)
{
echo "<a href='".INFUSIONS."the_kroax/report.php?broken_id=".$data['kroax_id']."' target='_blank' onClick='return confirmreport();''><b>".$locale['KROAX304']."</b></a>  ][ ";
}
}
echo"<a href=\"javascript:history.go(-1)\"><b>".$locale['KROAX007']."</b></a>";
echo '</td></tr>';
if ($kroaxsettings['kroax_set_ratings'] == "1")
{
echo '<tr><td align="center">';
rating_bar($data['kroax_id']);
echo "</td></tr>";
}

echo "</table>";

// quicktime
function quicktime_player($file_url)
{
global $title,$thumb,$embedcode,$downloadcode,$url;
$theplayer = <<<EOD
<table border='0' cellpadding='0' align="center" style='margin: 0 auto;'> 
	<tr>
		<td>
			<OBJECT classid='clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B' width="425"
			height="373" codebase='http://www.apple.com/qtactivex/qtplugin.cab'>
			<param name='src' value="$file_url">
			<param name='autoplay' value="true">
			<param name='controller' value="true">
			<param name='loop' value="false">
			<EMBED src="$file_url" width="420" height="360" autoplay="true" 
			controller="true" loop="false" pluginspage='http://www.apple.com/quicktime/download/'>
			</EMBED>
			</OBJECT>
$downloadcode
$embedcode
		</td>
	</tr>
	<!-- ...end embedded QuickTime file -->
</table>
EOD;

echo ($theplayer);
}

function flvplayer($file_url) {
global $title,$thumb,$embedcode,$downloadcode,$url,$videoimg;

echo "<br>";

//Gotto work on this one..
//s2.addVariable("streamscript","http://www.venue.nu/infusions/the_kroax/stream.php"); 

$type = substr($url, -3, 3);
if($type == "mp3")
{
$flashvar1 ='';
$flashvar2 ='s1.addVariable("width","420"); ';
$flashvar3 ='s1.addVariable("height","120"); ';
$flashvar4= 's1.addVariable("showeq", "true");';
$height = '120';
$width = '420';
$multibr= "<br><br><br><br><br><br><br><br><br><br><br><br>";
}
else {
$flashvar1 ='s1.addVariable("displayheight","340"); ';
$flashvar2 ='s1.addVariable("width","420"); ';
$flashvar3 ='s1.addVariable("height","360"); ';
$height = '360';
$width = '420';
$multibr = "";
}

$theplayer = <<<EOD
<table border='0' cellpadding='0' align="center" style='margin: 0 auto;'>
	<tr>
		<td>
<div id="videobox2">
<a href="http://www.adobe.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash">Download Flash Player</a><br>
</div>
<script type="text/javascript">
var s1 = new SWFObject("flash_flv_player/flvplayer.swf","single","$width","$height","7");
s1.useExpressInstall("expressinstall.swf"); 
s1.addParam("allowfullscreen","true");
s1.addVariable("autostart","false");
s1.addVariable("file","$file_url");
s1.addVariable("logo","$videoimg");
s1.addVariable("image","$thumb");
$flashvar1
$flashvar2
$flashvar3
$flashvar4
s1.write("videobox2");
</script>
$downloadcode
$embedcode

		</td>
	</tr>
</table>
EOD;

echo ($theplayer);
echo $multibr;
//echo "<br><br><br><br><br><br>";

}

// flash
function flash_player($file_url)
{
global $title,$thumb,$embedcode,$downloadcode,$url;
$theplayer = <<<EOD
<table border='0' cellpadding='0' align="center" style='margin: 0 auto;'>
	<tr>
		<td>
<div id="flashbox">
<a href="http://www.adobe.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash">Download Flash Player</a><br>
</div>
	<script type="text/javascript">
		var so = new SWFObject("$file_url", "$title","400", "400", "7");
		so.useExpressInstall("'.INFUSIONS.'the_kroax/expressinstall.swf");
		so.write("flashbox");
	</script>
$downloadcode
$embedcode
		</td>
	</tr>
</table>
EOD;

echo ($theplayer);
}

// windows media
function windowsmedia_player($file_url)
{
global $title,$thumb,$embedcode,$downloadcode,$url;
$theplayer = <<<EOD
<table border='0' cellpadding='0' align='center' style='margin: 0 auto;'>
	<tr>
		<td>
			<OBJECT id='mediaPlayer' width="420" height="360" 
			classid='CLSID:22d6f312-b0f6-11d0-94ab-0080c74c7e95' 
			codebase='http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=5,1,52,701'
			standby='Loading Microsoft Windows Media Player components...' type='application/x-oleobject'>
			<param name='fileName' value="$file_url">
			<param name='animationatStart' value='true'>
			<param name='transparentatStart' value='true'>
			<param name='autoStart' value="true">
			<param name='showControls' value="true">
			<param name='loop' value="false">
			<EMBED type='application/x-mplayer2'
			pluginspage='http://microsoft.com/windows/mediaplayer/en/download/'
			id='mediaPlayer' name='mediaPlayer' displaysize='4' autosize='-1' 
			bgcolor='darkblue' showcontrols="true" showtracker='-1' 
			showdisplay='0' showstatusbar='-1' videoborder3d='-1' width="420" height="360"
			src="$file_url" autostart="true" designtimesp='5311' loop="false">
			</EMBED>
			</OBJECT>
$downloadcode
$embedcode
		</td>
	</tr>
	<!-- ...end embedded WindowsMedia file -->
	<!-- begin link to launch external media player... -->
	<tr>
		<td align='center'>
			<a href="$file_url" style='font-size: 85%;' target='_blank'>Launch in external player</a> |
			<a href="http://www.iol.ie/~locka/mozilla/plugin.htm#download" style='font-size: 85%;' target='_blank'>Got firefox problems?</a>
		</td>
	</tr>
	<!-- ...end link to launch external media player... -->
</table>
EOD;

echo ($theplayer);
}

// real player
function real_player($file_url)
{
global $title,$thumb,$embedcode,$downloadcode,$url;
$theplayer = <<<EOD
<table border='0' cellpadding='0' align="center" style='margin: 0 auto;'>
	<tr>
		<td>
			<OBJECT id='rvocx' classid='clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA'
			width="420" height="360">
			<param name='src' value="$file_url">
			<param name='autostart' value="true">
			<param name='controls' value='imagewindow'>
			<param name='console' value='video'>
			<param name='loop' value="false">
			<EMBED src="$file_url" width="420" height="360" 
			loop="false" type='audio/x-pn-realaudio-plugin' controls='imagewindow' console='video' autostart="true">
			</EMBED>
			</OBJECT>

		</td>
	</tr>
	<!-- begin control panel... -->
	<tr>
		<td>
			<OBJECT id='rvocx' classid='clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA'
			width="420" height='30'>
			<param name='src' value="$file_url">
			<param name='autostart' value="true">
			<param name='controls' value='ControlPanel'>
			<param name='console' value='video'>
			<EMBED src="$file_url" width="420" height='360' 
			controls='ControlPanel' type='audio/x-pn-realaudio-plugin' console='video' autostart="true">
			</EMBED>
			</OBJECT>
$downloadcode
$embedcode
		</td>
	</tr>
	<!-- ...end control panel -->
	<!-- begin link to launch external media player... -->
	<tr>
		<td align='center'>
			<a href="$file_url" style='font-size: 85%;' target='_blank'>Launch in external player</a>
		</td>
	</tr>
	<!-- ...end link to launch external media player... -->
</table>
EOD;

echo ($theplayer);
}

//Misc player
function misc($file_url)
{
global $title,$thumb,$embedcode,$downloadcode,$url;
$theplayer = <<<EOD
<table border='0' cellpadding='0' align="center" style='margin: 0 auto;'>
	<tr>
		<td>
			
			<a href="$file_url" style='font-size: 140%;' target='_blank'><br>Filen kommer att öppnas i ett nytt fönster, klicka på textraden</a><br>
$downloadcode
$embedcode
		</td>
	</tr>
	<!-- ...end link to launch external media player... -->
</table>
EOD;

echo ($theplayer);
}

// flash with weird extensions
@$file_url = substr($file_url, 0, -4);
function weird_player($file_url)
{
global $title,$thumb,$videoimg,$file,$url,$lurl,$youtubeembedcode,$youtubedownloadcode,$locale;

$file_url = RemoveExtension($file_url);

$videoid = strval($file_url);

if (preg_match('/http:\/\/www.youtube.com\/watch\?v=(.*)/', $videoid, $match))
{
$videoid = $match[1];
}
$url="http://www.youtube.com/api2_rest?method=youtube.videos.get_video_token&video_id=$videoid";
$t = trim(strip_tags(@file_get_contents($url)));
$url = "http://www.youtube.com/get_video.php?video_id=" . $videoid . "&amp;t=" . $t . "&amp;fmt=18";
$file = urlencode(trim($url,"Location: "));

$theplayer = <<<EOD
<table border='0' cellpadding='0' align="center" style='margin: 0 auto;'>
	<tr>
		<td>
<div id="videobox3">
<a href="http://www.adobe.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash">Download Flash Player</a><br>
</div>
<script type="text/javascript">
var s3 = new SWFObject("flash_flv_player/flvplayer.swf","single","420","360","7");
s3.useExpressInstall("expressinstall.swf"); 
s3.addParam("allowfullscreen","true");
s3.addVariable("autostart","false");
s3.addVariable("type","flv");
s3.addVariable("file","$file");
s3.addVariable("logo","$videoimg");
s3.addVariable("image","$thumb");
s3.addVariable("displayheight","340");
s3.addVariable("width","420");
s3.addVariable("height","360");
s3.write("videobox3");
</script>
<a href="download.php?url=$file&title=$title&youtube" target="_blank">Download</a>
$youtubeembedcode
		</td>
	</tr>
</table>
EOD;

echo ($theplayer);
}

// flash with google
$file_url = substr($file_url, 0, -4);
function googleplayer($file_url)
{
$theplayer = <<<EOD
<table border='0' cellpadding='0' align="center" style='margin: 0 auto;'>
	<tr>
		<td>
		<embed style="width:420px; height:360px;" id="VideoPlayback" type="application/x-shockwave-flash" src="$file_url"> </embed>
        	</td>
	</tr>
</table>
EOD;

echo ($theplayer);
}
$file_url = ($file_url);

// flash with myspace
$file_url = substr($file_url, 0, -4);
function space_player($file_url)
 {
$theplayer = <<<EOD
<table border='0' cellpadding='0' align="center" style='margin: 0 auto;'>
	<tr>
		<td>
 <embed src="http://lads.myspace.com/videos/vplayer.swf" flashvars="$file_url" type="application/x-shockwave-flash" width="420" height="360"></embed>
</td>
	</tr>
</table>
EOD;

echo ($theplayer);
}


// Embed test area
$file_url = ($file_url);
function embed_player($file_url)
 {
global $title,$thumb,$embedcode,$downloadcode,$url;
$theplayer = <<<EOD
<table border='0' cellpadding='0' align="center" style='margin: 0 auto;'>
	<tr>
		<td>
	
$file_url
$downloadcode
$embedcode
	</tr>
		</td>

</table>
EOD;

echo ($theplayer);
}
// DivX/AVI tester
$file_url = ($file_url);
function divx_player($file_url)
 {
global $title,$thumb,$embedcode,$downloadcode,$url;
$theplayer = <<<EOD
<table border='0' cellpadding='0' align="center" style='margin: 0 auto;'>
	<tr>
		<td>
<object classid='clsid:67DABFBF-D0AB-41fa-9C46-CC0F21721616' width='420' height='360' codebase='http://go.divx.com/plugin/DivXBrowserPlugin.cab'>
 <param name='src' value='$file_url' />
<embed type='video/divx' src='$file_url' pluginspage='http://go.divx.com/plugin/download/'>
</embed>
</object>

$downloadcode
$embedcode
	</tr>
		</td>
</table>
EOD;

echo ($theplayer);
}

// streaming media
function streammedia($file_url)
{
global $title,$thumb,$embedcode,$downloadcode,$url;
$file_url = substr($file_url, 0, -4);
$theplayer = <<<EOD
<table border='0' cellpadding='0' align="center" style='margin: 0 auto;'>
	<tr>
		<td>
</center><p align='right'><b>Full screen</b> [<a href="#" title="Double click on the video to watch full screen." 
onclick="alert('Double click on the video to watch full screen.'); return false;">?</a>]</p>
<center><object classid='CLSID:22D6F312-B0F6-11D0-94AB-0080C74C7E95' type='application/x-oleobject' id='thePlayerObj' width='420' height='360'>
<param name='filename' value='$file_url' />
<param name='showstatusbar' value='1' />
<param name='enablecontextmenu' value='0' />
<param name='showpositioncontrols' value='0' />
<param name='showtracker' value='0' />
<embed type='application/x-mplayer2' id='thePlayerEmb' width='400' height='400' src='$file_url' showstatusbar='1' enablecontextmenu='0' 
showpositioncontrols='0' showtracker='0' /></object><br>
</center>
		</td>
	</tr>
	<!-- ...end embedded WindowsMedia file -->
	<!-- begin link to launch external media player... -->
	<tr>
		<td align='center'>
			<a href="$file_url" style='font-size: 85%;' target='_blank'>Launch in external player</a> |
			<a href="http://www.iol.ie/~locka/mozilla/plugin.htm#download" style='font-size: 85%;' target='_blank'>Got firefox problems?</a>
$embedcode
		</td>
	</tr>
	<!-- ...end link to launch external media player... -->
</table>
EOD;

echo ($theplayer);
}

echo "</table>";
closetable();
require_once "footer.php";

if (!isset($p))
{
require_once THEMES."templates/footer.php";
}
?>
