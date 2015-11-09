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
$file = INFUSIONS."varcade/randomc.php"; 
$show = file($file); 
$lines = sizeof($show) - 1; 
$rdm = rand(0, $lines); 
echo " <table cellpadding='0' cellspacing='0' align='center' width='100%'> ";
echo "<br>";
echo $show[$rdm];
echo "</table>";

$result = dbquery("DELETE FROM ".$db_prefix."varcade_active WHERE lastactive  <".(time()-60)."");
$result = dbquery("DELETE FROM ".$db_prefix."varcade_activeusr WHERE lastactive  <".(time()-60)."");

?>
