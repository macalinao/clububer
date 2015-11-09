<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--- ----------------------------------------------------+
| UBERPETS V 0.0.0.5
+--------------------------------------------------------+
| Uberpets Copyright 2008 Grr@µsoft inc.
| http://www.clububer.com/
+--------------------------------------------------------+
| Admin system based off of Varcade http://www.venue.nu/
\*---------------------------------------------------*/
// PAGE INCLUDES
require_once "../../../maincore.php";
if (!defined("IN_UBP")) { include "../includes/core.php"; }

if (preg_match("/^[6]./",$settings['version'])) {
	require_once BASEDIR."subheader.php";
	require_once ADMIN."navigation.php";
}
elseif (preg_match("/^[7]./", $settings['version'])) {
	require_once THEMES."templates/admin_header.php";
}

if (!$usr['uid'] || $pets_of_user == 0) { redirect(UBP_BASE."create_pet.php"); }

if (file_exists(UBP_BASE."locale/".$settings['locale'].".php")) {
	include UBP_BASE."locale/".$settings['locale'].".php";
} else {
	include UBP_BASE."locale/English.php";
}
//PAGE INCLUDES END
ubpadmin();
if (!$a_page){ $a_page = "main"; }
opentable("Uberpets Administration - ".$ubpta);

$a_page = stripinput($_GET['a_page']);

if ($a_page == "main"){
$tbl0 = "tbl1";
}else{
$tbl0 = "tbl2";
}
if ($a_page == "pet_species"){
$tbl1 = "tbl1";
}else{
$tbl1 = "tbl2";
}
if ($a_page == "items"){
$tbl2 = "tbl1";
}else{
$tbl2 = "tbl2";
}

echo "<table align='center' cellspacing='0' cellpadding='0' class='tbl-border' width='98%' border='0'>
<tr><td>
<table align='center' cellspacing='1' cellpadding='0' width='100%' class='tbl-border' border='0'>
<tr>
<td align='center' class='".$tbl0."' width='33%'><a href='".FUSION_SELF."?a_page=main'>Main</a></td>
<td align='center' class='".$tbl1."' width='33%'><a href='".FUSION_SELF."?a_page=pet_species'>Pet Species</a></td>
<td align='center' class='".$tbl2."' width='34%'><a href='".FUSION_SELF."?a_page=items'>Items</a></td>
</tr>
<tr>
<td align='left' class='tbl1' colspan='7'>";

if ($a_page == "main"){
include UBP_BASE."admin/uber_admin.php";
}
elseif ($a_page == "pet_species"){
include UBP_BASE."admin/pet_species.php";
}
elseif ($a_page == "items"){
include UBP_BASE."admin/items.php";
}

echo "</td></tr></table></table>";

closetable();
copyright();

//ADMIN FOOTER
if (preg_match("/^[6]./",$settings['version'])) {
	echo "</td>\n";
	require_once BASEDIR."footer.php";
}
elseif (preg_match("/^[7]./", $settings['version'])) {
	require_once THEMES."templates/footer.php";
}
//END
?>