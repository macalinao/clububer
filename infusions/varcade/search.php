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

require_once "functions.php";
require_once THEME."theme.php";
echo "<link rel='stylesheet' href='".THEME."styles.css' type='text/css'>";
$search = stripinput(trim($_GET['q']));

if($search != "" && strlen($search) <= 2)

   {
echo "<center><b>".$locale['sok156']."</b><br>".$locale['sok151']."</center>";

} else {

$result = dbquery("SELECT * FROM ".$db_prefix."varcade_games WHERE ".groupaccess('access')." AND status='2' AND title LIKE '%$search%'  ORDER BY title ASC LIMIT 20");

}

if (dbrows($result) != 0) {
$numRecords = dbrows($result);
echo "<center>".$locale['sok152']." <b><font color='red'>".$numRecords."</b></font> ".$locale['sok153']."</center>";

		$counter = 0; $r = 0; $k = 1;
		echo "<table cellpadding='0' cellspacing='1' width='100%'>\n<tr>\n";
		while ($data = dbarray($result)) {
			if ($counter != 0 && ($counter % $varcsettings['thumbs_per_row'] == 0)) echo "</tr>\n<tr>\n";
	          		echo "<td align='center' valign='top' class='tbl'>\n";

makelist();
			echo "</td>\n";
			$counter++; $k++;
		}
		echo "</tr>\n</table>\n";

}

else {
Echo "<center>".$locale['sok155']."</center>";
}
?>