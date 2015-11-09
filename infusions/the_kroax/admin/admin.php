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
if (!iADMIN) { header("Location:../../../index.php"); exit; }

error_reporting(E_ALL -E_NOTICE);


// If register_globals is turned off, extract super globals (php 4.2.0+) // We know its off in V7 but we keep this one here for you since VArcade is considered safe and we save alot of time doing this!

if (ini_get('register_globals') != 1) {
	if ((isset($_POST) == true) && (is_array($_POST) == true)) extract($_POST, EXTR_OVERWRITE);
	if ((isset($_GET) == true) && (is_array($_GET) == true)) extract($_GET, EXTR_OVERWRITE);
}

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

if (iADMIN) {

                if (!isset($a_page)){
                $a_page = "main";
                }
opentable("Kroax Administration");

if ($a_page == "main"){
$tbl0 = "tbl1";
}else{
$tbl0 = "tbl2";
}
if ($a_page == "categories"){
$tbl1 = "tbl1";
}else{
$tbl1 = "tbl2";
}
if ($a_page == "errors"){
$tbl4 = "tbl1";
}else{
$tbl4 = "tbl2";
}
if ($a_page == "loader"){
$tbl2 = "tbl1";
}else{
$tbl2 = "tbl2";
}
if ($a_page == "settings"){
$tbl3 = "tbl1";
}else{
$tbl3 = "tbl2";
}
if ($a_page == "parked"){
$tbl5 = "tbl1";
}else{
$tbl5 = "tbl2";
}

$countreports = "".dbcount("(kroax_id)", "".$db_prefix."kroax", "kroax_errorreport ='1'")."";
$countparked = "".dbcount("(kroax_id)", "".$db_prefix."kroax", "kroax_approval ='deny'")."";

echo "<table align='center' cellspacing='0' cellpadding='0' class='tbl-border' width='98%' border='0'>
<tr><td>
<table align='center' cellspacing='1' cellpadding='0' width='100%' border='0'>
<tr>
<td align='center' class='".$tbl0."' width='8%'><a href='".FUSION_SELF."?a_page=main'>".$locale['MKROAX110']."</a></td>
<td align='center' class='".$tbl5."' width='8%'><a href='".FUSION_SELF."?a_page=parked'>".$locale['MKROAX112']." (".$countparked.")</a></td>
<td align='center' class='".$tbl4."' width='8%'><a href='".FUSION_SELF."?a_page=errors'>".$locale['MKROAX113']." (".$countreports.")</a></td>
<td align='center' class='".$tbl2."' width='8%'><a href='".FUSION_SELF."?a_page=loader'>".$locale['MKROAX114']."</a></td>
<td align='center' class='".$tbl1."' width='8%'><a href='".FUSION_SELF."?a_page=categories'>".$locale['MKROAX111']."</a></td>
<td align='center' class='".$tbl3."' width='8%'><a href='".FUSION_SELF."?a_page=settings'>".$locale['MKROAX115']."</a></td>
</tr>
<tr>
<td align='left' class='tbl1' colspan='6'>";

if ($a_page == "main"){
include INFUSIONS."the_kroax/admin/kroax_admin.php";
}elseif ($a_page == "categories"){
include INFUSIONS."the_kroax/admin/categories.php";
}
elseif ($a_page == "loader"){
include INFUSIONS."the_kroax/admin/loader.php";
}
elseif ($a_page == "settings"){
include INFUSIONS."the_kroax/admin/settings.php";
}
elseif ($a_page == "errors"){
include INFUSIONS."the_kroax/admin/errors.php";
}

elseif ($a_page == "parked"){
include INFUSIONS."the_kroax/admin/parked.php";
}


echo "</td></tr></table></table>";

closetable();
}

echo "</td>\n";
require_once THEMES."templates/footer.php";
?>