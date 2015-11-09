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
require_once "../../maincore.php";

header("Content-type: text/html; charset=ISO-8859-9");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");    // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");  // HTTP/1.1
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");        // HTTP/1.0

$id_sent = stripinput($_GET['id']);

if ($id_sent == "0")
{
$playlistactivated = "1";
}
else
{
$playlistactivated = "0";
}

$resultset = dbquery("SELECT * FROM ".$db_prefix."kroax_set WHERE kroax_set_id='1'");
$kroaxsettings=dbarray($resultset);

if (!$kroaxsettings['kroax_set_keepalive'] == "1") { header("Location:../../index.php"); exit; }


$result = dbquery("SELECT * FROM ".DB_ONLINE." WHERE online_user=".($userdata['user_level'] != 0 ? "'".$userdata['user_id']."'" : "'0' AND online_ip='".USER_IP."'"));
if (dbrows($result)) {
	$result = dbquery("UPDATE ".DB_ONLINE." SET online_lastactive='".time()."' WHERE online_user=".($userdata['user_level'] != 0 ? "'".$userdata['user_id']."'" : "'0' AND online_ip='".USER_IP."'")."");
} else {
	$result = dbquery("INSERT INTO ".DB_ONLINE." (online_user, online_ip, online_lastactive) VALUES ('".($userdata['user_level'] != 0 ? $userdata['user_id'] : "0")."', '".USER_IP."', '".time()."')");
}

if (iMEMBER) $result = dbquery("UPDATE ".$db_prefix."users SET user_lastvisit='".time()."', user_ip='".USER_IP."' WHERE user_id='".$userdata['user_id']."'");


if ($playlistactivated == "1")
{
//Do nothing for now, well we will keep user online anyway ..
}
else
{
if ($kroaxsettings['kroax_set_playingnow'] == "1")
{

$result = dbquery("SELECT kroax_id,kroax_tumb,kroax_titel FROM ".$db_prefix."kroax WHERE kroax_id='".$id_sent."' ");
$data=dbarray($result);
$result = dbquery("SELECT * FROM ".$db_prefix."kroax_activeusr WHERE movie_id='".$id_sent."' AND user_ip='".USER_IP."'");
if (dbrows($result) != 0) {
$result = dbquery("UPDATE ".$db_prefix."kroax_activeusr SET lastactive='".time()."'  WHERE movie_id='".$id_sent."'");
} else {
$name = ($userdata['user_level'] != 0 ? $userdata['user_id'] : "0");
$result = dbquery("INSERT INTO ".$db_prefix."kroax_activeusr VALUES('".$id_sent."', '$name','".USER_IP."', '".time()."')");
}
$resulta = dbquery("SELECT * FROM ".$db_prefix."kroax_active WHERE movie_id='".$id_sent."'");
if (dbrows($resulta) != 0) {
$resultu = dbquery("UPDATE ".$db_prefix."kroax_active SET lastactive='".time()."'  WHERE movie_id='".$id_sent."'");
} else {
$result = dbquery("INSERT INTO ".$db_prefix."kroax_active VALUES('".$id_sent."', '".$data['kroax_titel']."', '".$data['kroax_tumb']."', '".time()."')");
}
}
}
$result = dbquery("DELETE FROM ".$db_prefix."kroax_active WHERE lastactive  <".(time()-60)."");
$result = dbquery("DELETE FROM ".$db_prefix."kroax_activeusr WHERE lastactive  <".(time()-60)."");


?>