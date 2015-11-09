<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Author: Domi & fetloser
| www.venue.nu			     	      
| Embed player functions by:Wain Glaister     
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/

if (!defined("IN_FUSION")) { header("Location: index.php"); exit; }

//Quicktime
$quicktime_extensions = 
array(
".mov",
".qt",
".amc",
".3g2",
".amr",
".sdv",
".caf",
".m4p",
".m4b",
".m4a",
".m4v",
".3gp",
".atr",
".dvd",
".jp2",
".mj2",
".qtl",
".mp4",
".mpg4",
".cdda",
".fpx",
".fpix",
".fpx",
".tiff",
".tif",
".targa",
".tga",
".sgi",
".rgb",
".png",
".pct",
".pic",
".pict",
".psd",
".dif",
".dv",
".pntg",
".pnt",
".mac",
".jpeg",
".jpg",
".jpe",
".bmp",
".kar",
".mid",
".smf",
".midi",
".qtif",
".qti",
".sml",
".pls",
".m3u",
".m3url",
".swa",
".sdp",
".rtsp",
".rts",
".gif",
".fli",
".flc",
".dv",
".vfw",
".au",
".ulw",
".snd",
".mp2",
".m1s",
".m1a",
".m75",
".m15",
".m2p",
".m2s",
".mqv",
".wav",
".gsm",
".m2v",
".m1v",
".mpa",
".mpm",
".aifc",
".aiff",
".aif",
".txt",
".text",
".pdf",
".sd2",
".qtz");


//Windows media
$windowsmedia_extensions = 
array(
".wma",
".wmv",
".wm",
".wmp",
".asf",
".asx",
".wmx",
".wax",
".mpg",
".mpeg",
".wvx");


//Flash
$flash_extensions = 
array(
".fla");

//Flash FLV
$flash_flv_extensions = 
array(
".flv",
".mp3",
".swf",
".SWF",
".FLV");


//Real player
$realplayer_extensions = 
array(
".ram",
".rm",
".ra",
".rv",
".rmj",
".rpm",
".rp",
".rt",
".rmvb",
".rmd",
".rms",
".rmx",
".rax",
".rvx",
".aac");


//Not in config
$not_config = 
array(
".pps");

//Youtube
$weird_extensions = 
array(
".999");

//google video
$googlevideo = 
array(
".998");

//my space video
$myspace = 
array(
".997");

//embed code
$embed_code = 
array(
".emb");

//Avi/DIVX
$divx_code = 
array(
".avi",
".divx");

//Streaming media playbacks
$streammedia = 
array(
".stm");

?>