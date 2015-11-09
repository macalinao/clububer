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
require_once "../../maincore.php";
header("Content-type: text/html; charset=ISO-8859-9");

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

header("Cache-Control: no-cache");
header("Pragma: nocache");

$vote_sent = stripinput($_REQUEST['j']);
$id_sent = stripinput($_REQUEST['q']);
$ip_num = stripinput($_REQUEST['t']);

if (isset($id_sent) && isNum($id_sent)) {

$query=dbquery("SELECT * FROM ".$db_prefix."kroax_rating WHERE id='$id_sent' ");
}
$numbers=mysql_fetch_assoc($query);
$checkIP=unserialize($numbers['used_ips']);
$count=$numbers['total_votes'];
$current_rating=$numbers['total_value'];
$sum=$vote_sent+$current_rating;
$tense=($count==1) ? "".$locale['VOT303']."" : "".$locale['VOT304']."";

$result=dbquery("SELECT count(*) FROM ".$db_prefix."kroax_rating WHERE used_ips LIKE '%".$ip_num."%' AND id='$id_sent' ");
@$voted = mysql_result($result, 0, 0);

if($voted){
$new_back = 
"<ul class=\"unit-rating\">\n".
"<li class=\"current-rating\" style=\"width:". @number_format($current_rating/$count,2)*30 ."px;\"></li>\n".
"<li class=\"r1-unit\">1</li>\n".
"<li class=\"r2-unit\">2</li>\n".
"<li class=\"r3-unit\">3</li>\n".
"<li class=\"r4-unit\">4</li>\n".
"<li class=\"r5-unit\">5</li>\n".
"</ul>".
	"<p> ".$locale['VOT301']." <strong>".@number_format($current_rating/$count,1)."</strong> ".$locale['VOT302']." ".$count." ".$tense."".
	"<br />\n <span style=\"color:red;\"> ".$locale['VOT305']."</span></p>";


}else{


if($sum==0){
$added=0;
}else{
$added=$count+1;
}

if(is_array($checkIP)){
array_push($checkIP,$ip_num);
}else{
$checkIP=array($ip_num);
}

$insert=serialize($checkIP);


$seekresult=dbquery("SELECT id FROM ".$db_prefix."kroax_rating WHERE id=$id_sent "); 
@$idexists = mysql_result($seekresult, 0, 0); 

if($idexists==true) 

{
	dbquery("UPDATE ".$db_prefix."kroax_rating SET total_votes='".$added."', total_value='".$sum."', used_ips='".$insert."' WHERE id='$id_sent'");
} else {
	dbquery("INSERT INTO ".$db_prefix."kroax_rating VALUES ('$id_sent', 0, 0, 0, '')");
	dbquery("UPDATE ".$db_prefix."kroax_rating SET total_votes='".$added."', total_value='".$sum."', used_ips='".$insert."' WHERE id='$id_sent'");
}


$query=dbquery("SELECT total_votes, total_value, used_ips FROM ".$db_prefix."kroax_rating WHERE id='$id_sent' ")or die(" Error: ".mysql_error());
$numbers=mysql_fetch_assoc($query);
$count=$numbers['total_votes'];
$current_rating=$numbers['total_value'];


$new_back = 
"<ul class=\"unit-rating\"> \n".
"<li class=\"current-rating\" style=\"width:". @number_format($current_rating/$count,2)*30 ."px;\"></li>\n".
"<li class=\"r1-unit\">1</li>\n".
"<li class=\"r2-unit\">2</li>\n".
"<li class=\"r3-unit\">3</li>\n".
"<li class=\"r4-unit\">4</li>\n".
"<li class=\"r5-unit\">5</li>\n".
"</ul>".
"".$locale['VOT306']." <strong>".@number_format($sum/$added,1)."</strong> ".$locale['VOT302']." ".$added." ".$tense.". ".
"<br /> ".$locale['VOT307']." </p>";


}


$output = "unit_long$id_sent|$new_back";
echo $output;
?>