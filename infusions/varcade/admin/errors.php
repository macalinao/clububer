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

if (isset($remove) && isNum($remove)) {
$boringresult = dbquery("UPDATE ".$db_prefix."varcade_games SET errorreport='0' WHERE lid='$remove'");
redirect("".INFUSIONS."varcade/admin/admin.php?a_page=errors");
}

$resultbroken = dbquery("SELECT * FROM ".$db_prefix."varcade_games WHERE errorreport='1'");
echo"<table width='100%' align='center' cellspacing='0' cellpadding='0'border='0'>";

if (dbrows($resultbroken) != 0) {
echo "
<tr>
<td align='left' class='tbl2' width='20%'><b>".$locale['VARC331']."</b></td>
<td align='center' class='tbl2' width='20%'><b>".$locale['VARC332']."</b></td>
<td align='center' class='tbl2' width='20%'><b>".$locale['VARC333']."</b></td>
<td align='center' class='tbl2' width='20%'><b>".$locale['VARC334']."</b></td>
<td align='right' class='tbl2' width='20%'><b>".$locale['VARC335']."</b></td>
</tr>\n";

while ($databroken = dbarray($resultbroken)) {
echo "<tr><td align='left' width='20%'><b>".$databroken['title']."</b></td>
<td align='center'  width='20%'><a href='".INFUSIONS."varcade/arcade.php?p=1&game=".$databroken['lid']."' target=\"_blank\"><b><u>".$locale['VARC332']."</b></u></a></td>
<td align='center'  width='20%'><a href='".INFUSIONS."varcade/admin/admin.php?a_page=main&step=edit&stats_id=".$databroken['lid']."'><b><u>".$locale['VARC333']."</b></u></a></td>
<td align='center' width='20%'><a href='".INFUSIONS."varcade/admin/admin.php?a_page=errors&remove=".$databroken['lid']."'><b><u>".$locale['VARC334']."</b></u></a></td>
<td align='right' width='20%'><a href='".INFUSIONS."varcade/admin/admin.php?a_page=main&step=delete&stats_id=".$databroken['lid']."'><b><u>".$locale['VARC335']."</b></u></a></td></tr>";
}
}
else
{
echo "<td><center>".$locale['VARC706']."</center></td>";
}

echo "</table>";

?>