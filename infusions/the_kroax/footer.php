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

$file = "randomc.php"; 
$show = file($file); 
$lines = sizeof($show) - 1; 
$rdm = rand(0, $lines); 

echo "<br>
<table cellpadding='0' cellspacing='0' align='center' width='90%' class='tbl-border'>
<tr class='tbl2'><td><center>".$locale['KROAX102']." ".dbcount("(kroax_id)", "".$db_prefix."kroax")."".$locale['KROAX103']." ".dbcount("(cid)", "".$db_prefix."kroax_kategori")." ".$locale['KROAX104']." ".dbcount("(id)", "".$db_prefix."kroax_rating")." ".$locale['KROAX105']." ".dbcount("(comment_id)", "".$db_prefix."comments where comment_type='K'")." ".$locale['KROAX107']."</center></td></tr>
</table>";
echo " <table cellpadding='0' cellspacing='0' align='center' width='45%'> ";
echo $show[$rdm]; 
echo "</table>";

?>
