<?php
/*---------------------------------------------------+
| PHP-Fusion 6 Content Management System
+----------------------------------------------------+
| Copyright © 2002 - 2005 Nick Jones
| http://www.php-fusion.co.uk/
+----------------------------------------------------+
| Released under the terms & conditions of v2 of the
| GNU General Public License. For details refer to
| the included gpl.txt file or visit http://gnu.org
+----------------------------------------------------+
| User Control Center made by:
| Sebastian "slaughter" Schüssler
| http://basti2web.de
| Version 2.40
+----------------------------------------------------*/
if (!defined("IN_FUSION")) { header("Location:index.php"); exit; }

///////////////// PDP
// pre
$show_pds_old = 0;
//
if($d_show_auto == 1){

if (file_exists(INFUSIONS."pro_download_panel/infusion.php")) {

require_once(INFUSIONS."pro_download_panel/include/core.php");

$check_v = "SELECT version FROM ".DB_PDP_SETTINGS." WHERE id='1'";

$check_vr = mysql_query($check_v) or ($check_vr = false);

if($check_vr != false ){
while($data = dbarray($check_vr)) {
	$check_version = $data['version'];
}
if($check_version >= "1.8.4") { $show_pds = 1; }
else { $show_pds = 0;}
} else { $show_pds = 0; }
} else { $show_pds = 0; }

} else {
$show_pds = $d_show_manu;
}
// unset
unset($check_version);
unset($check_v);
unset($check_vr);
///////////////// Cal
if($c_show_auto == 1){

if (file_exists(INFUSIONS."aw_ecal_panel/infusion.php")) {

require_once(INFUSIONS."aw_ecal_panel/infusion_db.php");

$check_v = "SELECT version FROM ".DB_PREFIX."aw_ec_settings";

$check_vr = mysql_query($check_v) or ($check_vr = false);

if($check_vr != false ){
while($data = dbarray($check_vr)) {
	$check_version = $data['version'];
}
if($check_version >= "0.7.0") { $show_cal = 1; } else { $show_cal = 0;}
} else { $show_cal = 0; }
} else { $show_cal = 0; }

} else {
$show_cal = $c_show_manu;
}
// unset
unset($check_version);
unset($check_v);
unset($check_vr);
///////////////// Witze
$w_show_auto = 1;
$w_show_manu = 1;

if($w_show_auto == 1){

if (file_exists(INFUSIONS."witze/infusion.php")) {

require_once(INFUSIONS."witze/infusion_db.php");

$check_v = "SELECT id FROM ".DB_WITZ;

$check_vr = @mysql_query($check_v) or ($check_vr = false);

if($check_vr != false ){

$show_witz = 1;

} else { $show_witz = 0; }
} else { $show_witz = 0; }

} else {
$show_witz = $w_show_manu;
}
// unset
unset($check_v);
unset($check_vr);
///////////////// Rezepte
$r_show_auto = 1;
$r_show_manu = 1;

if($r_show_auto == 1){

if (file_exists(INFUSIONS."rezepte/infusion.php")) {

$check_v = "SELECT id FROM ".DB_PREFIX."recept";

$check_vr = mysql_query($check_v) or ($check_vr = false);

if($check_vr != false ){

$show_rezept = 1;

} else { $show_rezept = 0; }
} else { $show_rezept = 0; }

} else {
$show_rezept = $r_show_manu;
}
// unset
unset($check_v);
unset($check_vr);
?>