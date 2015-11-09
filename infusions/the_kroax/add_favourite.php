<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Author: Domi & fetloser
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

if (isset($fav_id) && !isNum($fav_id)) fallback("index.php");

if (!iMEMBER) { header("Location:../../index.php"); exit; }

if (!isset($p))
{
require_once THEMES."templates/header.php";
}
else
{
require_once THEME."theme.php";
echo "<link rel='stylesheet' href='".THEME."styles.css' type='text/css'>";
}

include INFUSIONS."the_kroax/functions.php";

if (!$kroaxsettings['kroax_set_favorites'] == "1") { header("Location:../../index.php"); exit; }

opentable($locale['FKROAX100']); 

if (!isset($p))
{
makeheader();
echo "<div id='lajv'>";
echo "</div>";
}
$fav_id = stripinput($fav_id);
$fav_user = stripinput($fav_user);
$row2 = dbquery("SELECT * FROM ".$db_prefix."kroax_favourites WHERE fav_id='".$fav_id."' AND fav_user='".$fav_user."'");
$fav_id2=dbarray($row2);
$fav_id2 = $fav_id2['fav_id'];

if( $fav_id != $fav_id2){

dbquery("INSERT INTO ".$db_prefix."kroax_favourites (fav_id, fav_user, fav_date) VALUES ('$fav_id', '$fav_user', '".time()."')"); 

echo "<br><center><b>".$locale['FKROAX101']."</b><br><br><br><input style=\"cursor:pointer;\" type=\"button\" class=\"button\" onclick=\"javascript:history.back(1)\" value=\"".$locale['KROAX007']."\"><center><br><br>";

} else {

echo "<br><center><b>".$locale['FKROAX102']."</b><br><br><br><input style=\"cursor:pointer;\" type=\"button\" class=\"button\" onclick=\"javascript:history.back(1)\" value=\"".$locale['KROAX007']."\"><center><br><br>";
}

closetable(); 
require_once "footer.php";
if (!isset($p))
{
require_once THEMES."templates/footer.php";
}
?>

