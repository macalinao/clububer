<?php
if (eregi(basename(__FILE__), $_SERVER['PHP_SELF'])) die();

if(file_exists(INFUSIONS."seofusion/locale/".$settings['locale'].".php")) {
	require_once INFUSIONS."seofusion/locale/".$settings['locale'].".php";
} else {
	require_once INFUSIONS."seofusion/locale/German.php";
}
?>