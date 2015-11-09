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
require_once "../../../maincore.php";
require_once THEMES."templates/admin_header.php";
include LOCALE.LOCALESET."admin/admins.php";
if (!checkRights("I")) { header("Location:../../../index.php"); exit; }

if (!defined("LANGUAGE")) {
// PHPFusion environment
$this_lang =  str_replace("/", "", LOCALESET);
	if (file_exists(INFUSIONS."varcade/locale/".$this_lang.".php")) {
	   include INFUSIONS."varcade/locale/".$this_lang.".php";
	} else {
	   include INFUSIONS."varcade/locale/English.php";
	}
        } else {
// mFusion environment
$this_lang =  LANGUAGE;
	if (file_exists(INFUSIONS."varcade/locale/".$this_lang.".php")) {
	   include INFUSIONS."varcade/locale/".$this_lang.".php";
	} else {
	   include INFUSIONS."varcade/locale/English.php";
	}
}

// If register_globals is turned off, extract super globals (php 4.2.0+)
if (ini_get('register_globals') != 1) {
	if ((isset($_POST) == true) && (is_array($_POST) == true)) extract($_POST, EXTR_OVERWRITE);
	if ((isset($_GET) == true) && (is_array($_GET) == true)) extract($_GET, EXTR_OVERWRITE);
}


$resultvset = dbquery("SELECT * FROM ".$db_prefix."varcade_settings");
$varcsettings = dbarray($resultvset);

$file = "".INFUSIONS."varcade/randomc.php"; 
$show = file($file); 
$lines = sizeof($show) - 1; 
$rdm = rand(0, $lines); 


 if (!isset($a_page)){
                $a_page = "main";
                }
opentable($locale['VARC712']);

if ($a_page == "main"){
$tbl0 = "tbl1";
}else{
$tbl0 = "tbl2";
}
if ($a_page == "parked"){
$tbl1 = "tbl1";
}else{
$tbl1 = "tbl2";
}
if ($a_page == "errors"){
$tbl2 = "tbl1";
}else{
$tbl2 = "tbl2";
}
if ($a_page == "loader"){
$tbl3 = "tbl1";
}else{
$tbl3 = "tbl2";
}
if ($a_page == "categories"){
$tbl4 = "tbl1";
}else{
$tbl4 = "tbl2";
}
if ($a_page == "tournaments"){
$tbl5 = "tbl1";
}else{
$tbl5 = "tbl2";
}

if ($a_page == "settings"){
$tbl6 = "tbl1";
}else{
$tbl6 = "tbl2";
}


$countreports = "".dbcount("(lid)", "".$db_prefix."varcade_games", "errorreport ='1'")."";
$countparked = "".dbcount("(lid)", "".$db_prefix."varcade_games", "status ='1'")."";


echo "<table align='center' cellspacing='0' cellpadding='0' class='tbl-border' width='98%' border='0'>
<tr><td>
<table align='center' cellspacing='1' cellpadding='0' width='100%' border='0'>
<tr>
<td align='center' class='".$tbl0."' width='8%'><a href='".FUSION_SELF."?a_page=main'>".$locale['VARC380']."</a></td>
<td align='center' class='".$tbl1."' width='8%'><a href='".FUSION_SELF."?a_page=parked'>".$locale['VARC381']." (".$countparked.")</a></td>
<td align='center' class='".$tbl2."' width='8%'><a href='".FUSION_SELF."?a_page=errors'>".$locale['VARC382']." (".$countreports.")</a></td>
<td align='center' class='".$tbl3."' width='8%'><a href='".FUSION_SELF."?a_page=loader'>".$locale['VARC383']."</a></td>
<td align='center' class='".$tbl4."' width='8%'><a href='".FUSION_SELF."?a_page=categories'>".$locale['VARC384']."</a></td>
<td align='center' class='".$tbl5."' width='8%'><a href='".FUSION_SELF."?a_page=tournaments'>".$locale['TOUR001']."</a></td>
<td align='center' class='".$tbl6."' width='8%'><a href='".FUSION_SELF."?a_page=settings'>".$locale['VARC398']."</a></td>
</tr>
<tr>
<td align='left' class='tbl1' colspan='7'>";

if ($a_page == "main"){
include INFUSIONS."varcade/admin/arcade_admin.php";
}
elseif ($a_page == "parked"){
include INFUSIONS."varcade/admin/parked.php";
}
elseif ($a_page == "errors"){
include INFUSIONS."varcade/admin/errors.php";
}
elseif ($a_page == "loader"){
include INFUSIONS."varcade/admin/loader.php";
}
elseif ($a_page == "categories"){
include INFUSIONS."varcade/admin/categories.php";
}
elseif ($a_page == "tournaments"){
include INFUSIONS."varcade/admin/tournaments.php";
}
elseif ($a_page == "settings"){
include INFUSIONS."varcade/admin/settings.php";
}

echo "</td></tr></table></table>";

closetable();
echo " <table cellpadding='0' cellspacing='0' align='center' width='100%'> ";
echo $show[$rdm]; 
echo "</table>";
echo "</td>\n";
require_once THEMES."templates/footer.php";
?>