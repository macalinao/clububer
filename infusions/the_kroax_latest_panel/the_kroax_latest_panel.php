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


openside("".$locale['KROAX803']."");
$result = dbquery("SELECT kroax_id,kroax_titel,kroax_url,kroax_date FROM ".$db_prefix."kroax WHERE ".groupaccess('kroax_access')." AND  kroax_approval=''  ORDER BY kroax_id DESC LIMIT 0,10");
if (dbrows($result) != 0) {
	echo "<table width='100%' cellpadding='0' cellspacing='0'>";
	while($data = dbarray($result)) {
		$itemsubject = trimlink($data['kroax_titel'], 22);
if ($skroaxembed == "1")
{
		echo "<tr>\n<td class='small'><img src='".THEME."images/bullet.gif'> <a href='".INFUSIONS."the_kroax/embed.php?url=".$data['kroax_id']."'>$itemsubject</a><br> [".showdate('forumdate', $data['kroax_date'])."]</td>\n";
}
else 
{
		echo "<tr>\n<td class='small'><img src='".THEME."images/bullet.gif'> <a href='#' onclick=window.open('".INFUSIONS."the_kroax/embed.php?p=1&url=".$data['kroax_id']."','Click','scrollbars=yes,resizable=yes,width=650,height=550')>$itemsubject</a><br> [".showdate('forumdate', $data['kroax_date'])."]</td>\n";
}

echo "</tr>\n";
	}
echo "</table>";
} 
else {
echo "".$locale['KROAX802']."";
}
closeside();
?>