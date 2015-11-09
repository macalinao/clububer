<?php
/*--------------------------------------------+
| PHP-Fusion 6 - Content Management System    |
|---------------------------------------------|
| author: Nick Jones (Digitanium) � 2002-2005 |
| web: http://www.php-fusion.co.uk            |
| email: nick@php-fusion.co.uk                |
|---------------------------------------------|
|This program is released as free software    |
|under the |Affero GPL license. 	      |
|You can redistribute it and/or		      |
|modify it under the terms of this license    |
|which you |can read by viewing the included  |
|agpl.html or online			      |
|at www.gnu.org/licenses/agpl.html. 	      |
|Removal of this|copyright header is strictly |
|prohibited without |written permission from  |
|the original author(s).		      |
+---------------------------------------------+
|VArcade is written by Domi & fetloser          |
|http://www.venue.nu			      |
+--------------------------------------------*/
require_once "../../../maincore.php";
if (!defined("IN_UBP")) { include "../../includes/core.php"; }
require_once UBP_BASE."includes/core.php";
ubpadmin();

if (file_exists(UBP_BASE."locale/".$settings['locale'].".php")) {
	include UBP_BASE."locale/".$settings['locale'].".php";
} else {
	include UBP_BASE."locale/English.php";
}

header("Content-type: text/html; charset=ISO-8859-9");
header("Cache-Control: no-cache");
header("Pragma: nocache");

require_once THEME."theme.php";
echo "<link rel='stylesheet' href='".THEME."styles.css' type='text/css'>";
$search = stripinput(trim($_GET['q']));

if ($search != "" && strlen($search) <= 2) {
	echo "<center><b>Your search was too short!</b><br>3 characters or more!</center>";
} else {
	$stext = stripinput($_GET['stext']);
	$result = dbquery("SELECT * FROM ".UPREFIX."items name LIKE '%$search%' ORDER BY name ASC LIMIT 100");
}

if (dbrows($result) != 0) {
	$numRecords = dbrows($result);
	echo "<center>Your search returned <b><font color='red'>".$numRecords."</b></font> results.</center>";
	
	echo "<table align='center' width='100%' cellspacing='0'>
	<tr>
	<td align='left' class='tbl2' width='30%'><b>Name</b></td>
	<td align='center' class='tbl2' width='35%'><b>Folder</b></td>
	<td align='center' class='tbl2' width='30%'><b>Image</b></td>
	<td align='right' class='tbl2' width='5%'><b>Delete</b></td>
	</tr>\n";
	
	while ($data = dbarray($result)) {
		echo "<tr>\n<td class='small' width='22%'><img src='".THEME."images/bullet.gif' alt=''>";
		echo "<a href='".UBP_BASE."admin/admin.php?a_page=items&ipage=items&step=edit&item_id=".$data['iid']."'><b>".$data['name']."</b></a></td>\n";
		echo "<td class='small' align='center' width='12%'>".$data['folder']."</td>";
		echo "<td class='small' align='center' width='5%'>".$data['image']."</td>";
		echo "</td>";
		echo "<td class='small' align='right' width='7%'><a href='".UBP_BASE."admin/admin.php?a_page=items&ipage=items&step=delete&item_id=".$data['iid']."' onClick='return confirmdelete();'>Delete</a></td></tr>";
	}
	echo "</table>\n";
}

else {
	echo "<center>No items found... sorry...</center>";
}
?>