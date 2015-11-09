<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| User Control Center 2.40a
| Author: Sebastian Schüssler (slaughter)
| Download:
| http://basti2web.de
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
if (!defined("IN_FUSION")) { header("Location:index.php"); exit; }

// PHP-Fusion version check
require_once INFUSIONS."user_control_center/includes/check_version.php";


// Admin Rights
// Load Database information; v6 and v7 Compatibility
switch(UCC_PHPF_VER) {
case 6:
define("UCC_ADMIN", iADMIN ? 1 : 0);
	break;
case 7:
define("UCC_ADMIN", checkrights("UCC") ? 1 : 0);
	break;
default:
	die("error ucc004: UCC_PHPF_VER does not contain any version number");
}


$ucc_config = dbarray(dbquery("SELECT * FROM ".DB_PREFIX."ucc_settings"));

$pmc_perpage = $ucc_config['ucc_pm_post_perpage'];
$logins_perpage = $ucc_config['ucc_logins_perpage'];
$show_all = $ucc_config['ucc_panel_showall'];
$d_show_auto = $ucc_config['ucc_panel_d_show_auto'];
$d_show_manu = $ucc_config['ucc_panel_d_show_manu'];
$c_show_auto = $ucc_config['ucc_panel_c_show_auto'];
$c_show_manu = $ucc_config['ucc_panel_c_show_manu'];
$ucc_ghost = $ucc_config['ucc_ghost'];

define("ucc_db_version", $ucc_config['ucc_version']);

$ss[0] = "PGEgaHJlZj0iaHR0cDovL2Jhc3RpMndlYi5kZSIgdGFyZ2V0PS";
$ss[1] = "JfYmxhbmsiPk1haW4gQ29kZSBieSBiYXN0aTJ3ZWIuZGU8L2E+";
$y = "<br />";

function version_check_ucc() {
global $ucc_config;

// IF time() - 60*3 > $DB-ZEIT

$a = time() - 60*5;
if($a > $ucc_config['ucc_version_time']) {

$url = "http://basti2web.de/version/phpfusion_ucc.txt";
$url_p = @parse_url($url);
$host = $url_p['host'];
$port = isset($url_p['port']) ? $url_p['port'] : 80;
$fp = @fsockopen($url_p['host'], $port, $errno, $errstr, 5);
if(!$fp) return false;
@fputs($fp, 'GET '.$url_p['path'].' HTTP/1.1'.chr(10));
@fputs($fp, 'HOST: '.$url_p['host'].chr(10));
@fputs($fp, 'Connection: close'.chr(10).chr(10));
$response = @fgets($fp, 1024);
$content = @fread($fp,1024);
$content = preg_replace("#(.*?)text/plain(.*?)$#is","$2",$content);
@fclose ($fp);

if(preg_match("#404#",$response)) {
   $result = dbquery("UPDATE ".DB_PREFIX."ucc_settings SET ucc_version_time='".time()."', ucc_version_temp=''");
  return false;
 } else {
   $content = trim($content);
   $result = dbquery("UPDATE ".DB_PREFIX."ucc_settings SET ucc_version_time='".time()."', ucc_version_temp='".$content."'");
   return $content;
 }

} else {
return $ucc_config['ucc_version_temp'];
}

}

function get_lavi($lastvis,$locale) {
$lastseen = time() - $lastvis;
$iW=sprintf("%2d",floor($lastseen/604800));
$iD=sprintf("%2d",floor($lastseen/(60*60*24)));
$iH=sprintf("%02d",floor((($lastseen%604800)%86400)/3600));
$iM=sprintf("%02d",floor(((($lastseen%604800)%86400)%3600)/60));
$iS=sprintf("%02d",floor((((($lastseen%604800)%86400)%3600)%60)));
if ($lastseen < 60){
	$lastseen= "<br /><font color='green'>(".$locale['ucc_407'].")</font>";
} elseif ($lastseen < 360){
	$lastseen= "<br /><font color='green'>(".$locale['ucc_408'].")</font>";
} elseif ($iW > 0){
	if ($iW == 1) { $text = $locale['ucc_409']; } else { $text = $locale['ucc_410']; }
	$lastseen = "<br /><font color='red'>(".$iW." ".$text.")</font>";
} elseif ($iD > 0){
	if ($iD == 1) { $text = $locale['ucc_411']; } else { $text = $locale['ucc_412']; }
	$lastseen = "<br /><font color='red'>(".$iD." ".$text.")</font>";
} else {
	$lastseen = "<br /><font color='red'>(".$iH.":".$iM.":".$iS.")</font>";
}
if ($lastvis == 0) {$lastseen = "<font color='red'>".$locale['ucc_413']."</font>";}

echo $lastseen;
}

?>