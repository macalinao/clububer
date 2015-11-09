<?php
if (!defined("IN_FUSION")) die();

include INFUSIONS."seofusion/language_include.php";
include INFUSIONS."seofusion/seotags_include.php";

if (!isset($title)) $title = $settings['sitename'];
else $title = $title." - ".$settings['sitename'];
$title = substr($title, 0, 70);
$title = seodesc( $title );

if (!isset($desc)) $desc = $settings['description'];
else $desc = $desc." - ".$settings['description'];
$desc = substr($desc, 0, 200);
$desc = seodesc( $desc );

if (!isset($keys)) $keys = $settings['keywords'];
else $keys = $keys.", ".$settings['keywords'];
$keys = substr($keys, 0, 1000);
$keys = seodesc( $keys );
?>