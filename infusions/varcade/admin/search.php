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
require_once "../../../maincore.php";
if (!checkRights("I")) { header("Location:../../../index.php"); exit; }

if (!defined("LANGUAGE")) {
// PHPFusion environment
$this_lang =  str_replace("/", "", LOCALESET);
	if (file_exists(INFUSIONS."varcade/locale/".$this_lang.".php")) {
	   include INFUSIONS."varcade/locale/".$this_lang.".php";
	} else {
	   include INFUSIONS."varcade/locale/English.php";
	}
        } else {
// mFusion environment
$this_lang =  LANGUAGE;
	if (file_exists(INFUSIONS."varcade/locale/".$this_lang.".php")) {
	   include INFUSIONS."varcade/locale/".$this_lang.".php";
	} else {
	   include INFUSIONS."varcade/locale/English.php";
	}
}

header("Content-type: text/html; charset=ISO-8859-9");
header("Cache-Control: no-cache");
header("Pragma: nocache");

require_once THEME."theme.php";
echo "<link rel='stylesheet' href='".THEME."styles.css' type='text/css'>";
$search = stripinput(trim($_GET['q']));

if($search != "" && strlen($search) <= 2)

   {
echo "<center><b>".$locale['sok156']."</b><br>".$locale['sok151']."</center>";

} else {

$result = dbquery("SELECT * FROM ".$db_prefix."varcade_games WHERE ".groupaccess('access')." AND status='2' AND title LIKE '%$search%'  ORDER BY title ASC LIMIT 100");

}

if (dbrows($result) != 0) {
$numRecords = dbrows($result);
echo "<center>".$locale['sok152']." <b><font color='red'>".$numRecords."</b></font> ".$locale['sok153']."</center>";

echo "<table align='center' width='100%' cellspacing='0'>
<tr>
<td align='left' class='tbl2' width='30%'><b>".$locale['VARC393']."</b></td>
<td align='center' class='tbl2' width='35%'><b>".$locale['VARC387']."</b></td>
<td align='center' class='tbl2' width='30%'><b>".$locale['VARC390']."</b></td>
<td align='right' class='tbl2' width='5%'><b>".$locale['VARC391']."</b></td>
</tr>\n";

		while ($data = dbarray($result)) {
echo "<tr>\n<td class='small' width='22%'><img src='".THEME."images/bullet.gif' alt=''> <a href='".INFUSIONS."varcade/admin/admin.php?a_page=main&step=edit&stats_id=".$data['lid']."'><b>".$data['title']."</b></a></td>\n";
echo "<td class='small' align='center' width='12%'>".$data['flash']."</td>";
echo "<td class='small' align='center' width='5%'>".$data['cid']."</td>";
echo "</td>";
echo "<td class='small' align='right' width='7%'><a href='".INFUSIONS."varcade/admin/admin.php?a_page=main&step=delete&stats_id=".$data['lid']."' onClick='return confirmdelete();'>".$locale['VARC391']."</a></td></tr>";
	}
echo "</table>\n";
}

else {
Echo "<center>".$locale['sok155']."</center>";
}
?>