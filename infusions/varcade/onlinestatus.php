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
header("Cache-Control: no-cache");
header("Pragma: nocache");

$id_sent = stripinput($_REQUEST['id']);
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


$resultvset = dbquery("SELECT playingnow FROM ".$db_prefix."varcade_settings");
$varcsettings = dbarray($resultvset);

$result = dbquery("SELECT * FROM ".DB_ONLINE." WHERE online_user=".($userdata['user_level'] != 0 ? "'".$userdata['user_id']."'" : "'0' AND online_ip='".USER_IP."'"));
if (dbrows($result)) {
	$result = dbquery("UPDATE ".DB_ONLINE." SET online_lastactive='".time()."' WHERE online_user=".($userdata['user_level'] != 0 ? "'".$userdata['user_id']."'" : "'0' AND online_ip='".USER_IP."'")."");
} else {
	$result = dbquery("INSERT INTO ".DB_ONLINE." (online_user, online_ip, online_lastactive) VALUES ('".($userdata['user_level'] != 0 ? $userdata['user_id'] : "0")."', '".USER_IP."', '".time()."')");
}

if (iMEMBER) $result = dbquery("UPDATE ".$db_prefix."users SET user_lastvisit='".time()."', user_ip='".USER_IP."' WHERE user_id='".$userdata['user_id']."'");

if ($varcsettings['playingnow'] == "1")
{

$result = dbquery("SELECT lid,icon,title,hi_player FROM ".$db_prefix."varcade_games WHERE lid='".$id_sent."' ");
$data=dbarray($result);
$result = dbquery("SELECT * FROM ".$db_prefix."varcade_activeusr WHERE game_id='".$id_sent."' AND user_ip='".USER_IP."'");
if (dbrows($result) != 0) {
$result = dbquery("UPDATE ".$db_prefix."varcade_activeusr SET lastactive='".time()."'  WHERE game_id='".$id_sent."'");
} else {
$name = ($userdata['user_level'] != 0 ? $userdata['user_id'] : "0");
$result = dbquery("INSERT INTO ".$db_prefix."varcade_activeusr VALUES('".$id_sent."', '$name','".USER_IP."', '".time()."')");
}
$resulta = dbquery("SELECT * FROM ".$db_prefix."varcade_active WHERE game_id='".$id_sent."'");
if (dbrows($resulta) != 0) {
$resultu = dbquery("UPDATE ".$db_prefix."varcade_active SET lastactive='".time()."'  WHERE game_id='".$id_sent."'");
} else {
$result = dbquery("INSERT INTO ".$db_prefix."varcade_active VALUES('".$id_sent."', '".$data['title']."', '".$data['icon']."', '".time()."')");
}
$result = dbquery("DELETE FROM ".$db_prefix."varcade_active WHERE lastactive  <".(time()-60)."");
$result = dbquery("DELETE FROM ".$db_prefix."varcade_activeusr WHERE lastactive  <".(time()-60)."");

}
?>