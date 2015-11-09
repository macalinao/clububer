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
$boringresult = dbquery("UPDATE ".$db_prefix."kroax SET kroax_errorreport='' WHERE kroax_id='$remove'");
redirect("".INFUSIONS."the_kroax/admin/admin.php?a_page=errors");
}

$resultbroken = dbquery("SELECT * FROM ".$db_prefix."kroax WHERE kroax_errorreport='1'");
echo"<table width='100%' align='center' cellspacing='0' cellpadding='0'border='0'>";

if (dbrows($resultbroken) != 0) {
echo "
<tr>
<td align='left' class='tbl2' width='20%'><b>".$locale['AEKROAX331']."</b></td>
<td align='center' class='tbl2' width='20%'><b>".$locale['AEKROAX332']."</b></td>
<td align='center' class='tbl2' width='20%'><b>".$locale['AEKROAX333']."</b></td>
<td align='center' class='tbl2' width='20%'><b>".$locale['AEKROAX334']."</b></td>
<td align='right' class='tbl2' width='20%'><b>".$locale['AEKROAX335']."</b></td>
</tr>\n";

while ($databroken = dbarray($resultbroken)) {
echo "<tr><td align='left' width='20%'><b>".$databroken['kroax_titel']."</b></td>
<td align='center'  width='20%'><a href='".INFUSIONS."the_kroax/embed.php?p=1&url=".$databroken['kroax_id']."' target=\"_blank\"><b><u>".$locale['AEKROAX332']."</b></u></a></td>
<td align='center'  width='20%'><a href='".INFUSIONS."the_kroax/admin/admin.php?a_page=main&step=edit&id=".$databroken['kroax_id']."'><b><u>".$locale['AEKROAX333']."</b></u></a></td>
<td align='center' width='20%'><a href='".INFUSIONS."the_kroax/admin/admin.php?a_page=errors&remove=".$databroken['kroax_id']."'><b><u>".$locale['AEKROAX334']."</b></u></a></td>
<td align='right' width='20%'><a href='".INFUSIONS."the_kroax/admin/admin.php?a_page=main&step=delete&id=".$databroken['kroax_id']."'><b><u>".$locale['AEKROAX335']."</b></u></a></td></tr>";
}
}
else
{
echo "<td><center>".$locale['AEKROAX337']."</center></td>";
}

echo "</table>";

?>