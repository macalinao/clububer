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
$result = dbquery("UPDATE ".$db_prefix."kroax SET kroax_approval = '' WHERE kroax_id='$accept'");
redirect("".INFUSIONS."the_kroax/admin/admin.php?a_page=parked");
}
$resultparked = dbquery("SELECT * FROM ".$db_prefix."kroax WHERE kroax_approval='deny'");

echo"<table width='100%' align='center' cellspacing='0' cellpadding='0'border='0'>";

if (dbrows($resultparked) != 0) {
echo "
<tr>
<td align='left' class='tbl2' width='20%'><b>".$locale['APKROAX325']."</b></td>
<td align='center' class='tbl2' width='20%'><b>".$locale['APKROAX326']."</b></td>
<td align='center' class='tbl2' width='20%'><b>".$locale['APKROAX327']."</b></td>
<td align='center' class='tbl2' width='20%'><b>".$locale['APKROAX328']."</b></td>
<td align='right' class='tbl2' width='20%'><b>".$locale['APKROAX329']."</b></td>
</tr>\n";


while ($data = dbarray($resultparked)) 
{
echo "<tr>
<td align='left' width='20%'>".$data['kroax_titel']." </td>
<td align='center' width='20%'><a href='".INFUSIONS."the_kroax/embed.php?p=1&url=".$data['kroax_id']."' target=\"_blank\"><b><u>".$locale['APKROAX326']."</b></u></a></td>
<td align='center' width='20%'><a href='".INFUSIONS."the_kroax/admin/admin.php?a_page=main&step=edit&id=".$data['kroax_id']."'><b><u>".$locale['APKROAX327']."</b></u></a></td>
<td align='center' width='20%'><a href='".INFUSIONS."the_kroax/admin/admin.php?a_page=parked&accept=".$data['kroax_id']."'><b><u>".$locale['APKROAX330']."</b></u></a></td>
<td align='right' width='20%'><a href='".INFUSIONS."the_kroax/admin/admin.php?a_page=main&step=delete&id=".$data['kroax_id']."'><b><u>".$locale['APKROAX329']."</b></u></a></td>

</tr>";
}
}
else
{
echo "<td><center>".$locale['APKROAX324']."</center></td>";
}

echo "</table>";


?>