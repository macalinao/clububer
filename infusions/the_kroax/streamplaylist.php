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


function youtubetransform($url)
{
$videoid = strval($url);
if (preg_match('/http:\/\/www.youtube.com\/watch\?v=(.*)/', $videoid, $match))
{
$videoid = $match[1];
}
$url="http://www.youtube.com/api2_rest?method=youtube.videos.get_video_token&video_id=$videoid";
$t = trim(strip_tags(@file_get_contents($url)));
$url = "http://www.youtube.com/get_video.php?video_id=" . $videoid . "&amp;t=" . $t . "&amp;fmt=18";

return $url;
}



$result = dbquery("SELECT ter.*,kroax_id,kroax_url,kroax_tumb,kroax_titel FROM ".$db_prefix."kroax_favourites ter
		LEFT JOIN ".$db_prefix."kroax tusr ON ter.fav_id=tusr.kroax_id
		WHERE fav_user='".$userdata['user_id']."'");

echo "<playlist version='1' xmlns='http://xspf.org/ns/0/'>\n";
echo "<trackList>\n";

while($playdata = dbarray($result)) {

//trying to make a youtube item playable from playlist here..
$url = $playdata['kroax_url'];
$ext = strrchr($url, '.');
$url = substr($url, 0, -strlen($ext));
$url = youtubetransform("$url");
$type = substr($playdata['kroax_url'], -3, 3);

switch ($type)
{
case 'mp3':
header("Content-Type: audio/mpeg");
break;
case 'flv':
header("Content-Type: video/x-flv");
break;
case '999':
header("Content-Type: video/x-flv");
break;
}

  echo "\t<track>\n";
  echo "\t\t<title>".$playdata['kroax_titel']."</title>\n";
if($type == "999")
{
  echo "\t\t<location>$url</location>\n";
  echo "\t\t<info>".INFUSIONS."the_kroax/embed.php?url=".$playdata['kroax_id']."</info>\n";
  echo "\t\t<image>".$playdata['kroax_tumb']."</image>\n";
  echo "\t\t<meta rel='type'>flv</meta>\n";
}
elseif($type == "flv")
{
  echo "\t\t<location>".$playdata['kroax_url']."</location>\n";
  echo "\t\t<info>".INFUSIONS."the_kroax/embed.php?url=".$playdata['kroax_id']."</info>\n";
  echo "\t\t<image>".$playdata['kroax_tumb']."</image>\n";
  echo "\t\t<meta rel='type'>flv</meta>\n";
}
elseif($type == "mp3")
{ 
  echo "\t\t<location>".$playdata['kroax_url']."</location>\n";
  echo "\t\t<info>".INFUSIONS."the_kroax/embed.php?url=".$playdata['kroax_id']."</info>\n";
  echo "\t\t<image>img/musicstream.jpg</image>\n";
  echo "\t\t<meta rel='type'>mp3</meta>\n";
}
elseif($type == "swf")
{ 
  echo "\t\t<location>".$playdata['kroax_url']."</location>\n";
  echo "\t\t<info>".INFUSIONS."the_kroax/embed.php?url=".$playdata['kroax_id']."</info>\n";
  echo "\t\t<image>".$playdata['kroax_tumb']."</image>\n";
  echo "\t\t<meta rel='type'>swf</meta>\n";
}

  echo "\t</track>\n";
}

echo "</trackList>\n";
echo "</playlist>\n";


?>
