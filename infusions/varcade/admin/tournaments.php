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
if (!checkRights("I")) { header("Location:../../../index.php"); exit; }


include "".INFUSIONS."varcade/arcade_tournament.php";

$currenttime = time();
$tourexpire = dbquery("SELECT * FROM ".$db_prefix."varcade_tournaments ORDER BY id DESC LIMIT 1");
$tourdata = dbarray($tourexpire);

// +86400 =  1 day
// +259200 = 3 days
// +432000 = 5 days
// +604800 = 1 week

if (isset($update_tournament)) {
$query = dbquery ("select * from ".$db_prefix."varcade_games WHERE status='2' ORDER BY RAND() limit 0,1") ;
$rows = dbarray($query);
$expiredate = time()+432000; 

dbquery("UPDATE ".$db_prefix."varcade_tournaments SET
tour_game = '".$rows['lid']."',
tour_title = '".$rows['title']."',
tour_icon = '".$rows['icon']."', 
tour_flash = '".$rows['flash']."',
tour_winner = '".$locale['TOUR003']."', 
tour_score =  '0',
tour_players =  '0', 
tour_reverse =  '".$rows['reverse']."',
tour_startdate =  '".$currenttime."', 
tour_enddate =  '".$expiredate."'
WHERE id ='". $tourdata['id']."'");
}
tablebreak();
echo "<center><a href='admin.php?a_page=tournaments&update_tournament'><b>".$locale['TOUR014']."</b></a></center>";
//echo"<table width='100%' align='center' cellspacing='0' cellpadding='0'border='0'>";
//echo "</table>";

?>