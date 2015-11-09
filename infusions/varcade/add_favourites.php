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
require_once THEMES."templates/header.php";


if (isset($fav_id) && !isNum($fav_id)) fallback("index.php");

include INFUSIONS."varcade/functions.php";


opentable($locale['FARC100']); 

makeheader();

echo "<div id='lajv'>";
echo "</div>";
$fav_id = ($_GET['fav_id']); 
$fav_id = stripinput($fav_id);
$fav_user = ($_GET['fav_user']); 
$fav_user = stripinput($fav_user);
$fav_icon = ($_GET['fav_icon']); 
$fav_icon = stripinput($fav_icon);
$fav_gamename = ($_GET['fav_gamename']); 
$fav_gamename = stripinput($fav_gamename);

$row2 = dbquery("SELECT * FROM ".$db_prefix."varcade_favourites WHERE fav_id='".$fav_id."' AND fav_user='".$fav_user."'");
$fav_id2=dbarray($row2);
$fav_id2 = $fav_id2['fav_id'];

if( $fav_id != $fav_id2){

dbquery("INSERT INTO ".$db_prefix."varcade_favourites (fav_id, fav_user, fav_date, fav_icon, fav_gamename) VALUES ('$fav_id', '$fav_user', NOW( ), '$fav_icon', '$fav_gamename' )"); 

echo "<br><center><b>".$locale['FARC101']."</b><br><br><br><input style=\"cursor:pointer;\" type=\"button\" class=\"button\" onclick=\"javascript:history.back(1)\" value=\"".$locale['VARC175']."\"><center><br><br>";

} else {

echo "<br><center><b>".$locale['FARC102']."</b><br><br><br><input style=\"cursor:pointer;\" type=\"button\" class=\"button\" onclick=\"javascript:history.back(1)\" value=\"".$locale['VARC175']."\"><center><br><br>";
}

closetable(); 
require_once "footer.php";
require_once THEMES."templates/footer.php";
?>

