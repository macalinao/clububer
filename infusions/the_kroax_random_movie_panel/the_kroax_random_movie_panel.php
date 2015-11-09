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
|Kroax is written by Domi & fetloser          |
|http://www.venue.nu			      |
+--------------------------------------------*/

if (!defined("IN_FUSION")) { header("Location: index.php"); exit; }


if (!defined("LANGUAGE")) {
// PHPFusion environment
$this_lang =  str_replace("/", "", LOCALESET);
	if (file_exists(INFUSIONS."the_kroax/locale/".$this_lang.".php")) {
	   include INFUSIONS."the_kroax/locale/".$this_lang.".php";
	} else {
	   include INFUSIONS."the_kroax/locale/English.php";
	}
        } else {
// mFusion environment
$this_lang =  LANGUAGE;
	if (file_exists(INFUSIONS."the_kroax/locale/".$this_lang.".php")) {
	   include INFUSIONS."the_kroax/locale/".$this_lang.".php";
	} else {
	   include INFUSIONS."the_kroax/locale/English.php";
	}
}

$read_settingskroax = dbquery("SELECT * FROM ".$db_prefix."kroax_set");
if (dbrows($read_settingskroax) != 0) {
$settingskroax = dbarray($read_settingskroax);
$skroaxembed = $settingskroax['kroax_set_show'];
}
$tickersetting = 0;

if ($tickersetting == "1")
{
//the higher the value the slower, default is 100
$ticker_speed = "100";
//ticker width? (use either % or px values)
$ticker_width = "100%";
$tickerquery = dbquery("SELECT * FROM ".$db_prefix."kroax WHERE kroax_approval='' AND ".groupaccess('kroax_access')." AND ".groupaccess('kroax_access_cat')." ORDER BY kroax_id DESC LIMIT 0,10");
$ticker_content = "<marquee Behavior='scroll' Direction='left' ScrollDelay='".$ticker_speed."' width='".$ticker_width."' onmouseover='this.stop()' onmouseout='this.start()'>";
while($data = dbarray($tickerquery)) {
$read_settingskroax = dbquery("SELECT * FROM ".$db_prefix."kroax_set");
if (dbrows($read_settingskroax) != 0) {
$settingskroax = dbarray($read_settingskroax);
$skroaxembed = $settingskroax['kroax_set_show'];
}
}
if ($tickersetting == "1")
{
if ($skroaxembed == "1")
{
$ticker_content .= " [ <b> <a href='".INFUSIONS."the_kroax/embed.php?url=".$data['kroax_id']."'>".$data['kroax_titel']."</a></b>";
}
else {
$ticker_content .= " [ <b> <a href='#' onclick=window.open('".INFUSIONS."the_kroax/embed.php?p=1&url=".$data['kroax_id']."','Click','scrollbars=yes,resizable=yes,width=650,height=550')>".$data['kroax_titel']."</a></b>";
}
$ticker_content .= " ] ";
}
$ticker_content .= "</marquee>";
}
$resultset = dbquery("SELECT * FROM ".$db_prefix."kroax_set WHERE kroax_set_id='1'");
while ($dataset = dbarray($resultset)) {
$moviepage ="".$dataset['kroax_set_pic']."";
$height = "".$dataset['kroax_set_hi']."";
$width = "".$dataset['kroax_set_wi']."";

$result=dbquery ("select kroax_titel,kroax_url,kroax_tumb,kroax_id from ".$db_prefix."kroax WHERE kroax_approval='' AND ".groupaccess('kroax_access')." AND ".groupaccess('kroax_access_cat')." ORDER BY RAND() LIMIT 1") ;

openside("".$locale['KROAX801']."");

if (dbrows($result) == 1) {
		$filename= "".$data['kroax_tumb']."";
		if (!file_exists($filename)) $filename="/img/imagenotfound.jpg";
		$data=dbarray($result);
		echo "<div style='text-align:center'>";
if ($skroaxembed == "1")
{
echo "
		<a href='".INFUSIONS."the_kroax/embed.php?url=".$data['kroax_id']."'>
		<img src='".$data['kroax_tumb']."'title='".$data['kroax_titel']."' alt='".$data['kroax_titel']."' width=$width height=$height></a>
                <br />
		<a href='".INFUSIONS."the_kroax/embed.php?url=".$data['kroax_id']."'>".$data['kroax_titel']."</a>
		<br />
		</div>";
}
else {
echo "
		<a href='#' onclick=window.open('".INFUSIONS."the_kroax/embed.php?p=1&url=".$data['kroax_id']."','Click','scrollbars=yes,resizable=yes,width=650,height=550')>
		<img src='".$data['kroax_tumb']."'title='".$data['kroax_titel']."' alt='".$data['kroax_titel']."' width=$width height=$height></a>
                <br />
		<a href='#' onclick=window.open('".INFUSIONS."the_kroax/embed.php?p=1&url=".$data['kroax_id']."','Click','scrollbars=yes,resizable=yes,width=650,height=550')>".$data['kroax_titel']."</a>
		<br />
		</div>";
}

if ($tickersetting == "1")
{
echo $ticker_content;
}
}
else {
echo "".$locale['KROAX801']."";
}
}
closeside();

?>