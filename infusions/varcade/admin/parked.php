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

if (isset($accept) && isNum($accept)) {
$result = dbquery("UPDATE ".$db_prefix."varcade_games SET status = '2' WHERE lid='$accept'");
redirect("".INFUSIONS."varcade/admin/admin.php?a_page=parked");
}

$resultparked = dbquery("SELECT * FROM ".$db_prefix."varcade_games WHERE status='1'");

echo"<table width='100%' align='center' cellspacing='0' cellpadding='0'border='0'>";

if (dbrows($resultparked) != 0) {
echo "
<tr>
<td align='left' class='tbl2' width='20%'><b>".$locale['VARC325']."</b></td>
<td align='center' class='tbl2' width='20%'><b>".$locale['VARC326']."</b></td>
<td align='center' class='tbl2' width='20%'><b>".$locale['VARC327']."</b></td>
<td align='center' class='tbl2' width='20%'><b>".$locale['VARC328']."</b></td>
<td align='right' class='tbl2' width='20%'><b>".$locale['VARC329']."</b></td>
</tr>\n";


while ($data = dbarray($resultparked)) 
{
echo "<tr>
<td align='left' width='20%'>".$data['title']." </td>
<td align='center' width='20%'><a href='".INFUSIONS."varcade/arcade.php?p=1&game=".$data['lid']."' target=\"_blank\"><b><u>".$locale['VARC326']."</b></u></a></td>
<td align='center' width='20%'><a href='".INFUSIONS."varcade/admin/admin.php?a_page=main&step=edit&stats_id=".$data['lid']."'><b><u>".$locale['VARC327']."</b></u></a></td>
<td align='center' width='20%'><a href='".INFUSIONS."varcade/admin/admin.php?a_page=parked&accept=".$data['lid']."'><b><u>".$locale['VARC330']."</b></u></a></td>
<td align='right' width='20%'><a href='".INFUSIONS."varcade/admin/admin.php?a_page=main&step=delete&stats_id=".$data['lid']."'><b><u>".$locale['VARC329']."</b></u></a></td>

</tr>";
}
}
else
{
echo "<td><center>".$locale['VARC324']."</center></td>";
}

echo "</table>";


?>