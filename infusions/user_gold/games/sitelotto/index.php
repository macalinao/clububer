<?php 
require_once "../../../maincore.php";
require_once BASEDIR."subheader.php";
require_once BASEDIR."side_left.php";
if (file_exists(INFUSIONS."user_gold/locale/".$settings['locale'].".php")) {
	include INFUSIONS."user_gold/locale/".$settings['locale'].".php";
} else {
	include INFUSIONS."user_gold/locale/English.php";
}
if (!iMEMBER) { header("Location:../../index.php"); exit; }
if(!isset($_REQUEST['op'])){ $op='start'; } else {$op=$_REQUEST['op']; }
include_once INFUSIONS."user_gold/inc/functions.php";//will include new version of same file
include_once (INFUSIONS."user_gold/inc/template.class.php");
define("GOLDOK" , TRUE);//safty
if (file_exists($_REQUEST['FILE'])) {
	include($_REQUEST['FILE']);
} else {
	echo 'Game File Not Found';
}
include "../footer.php";
?>