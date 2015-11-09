<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: user_gift_include.php
| Author: Starefossen
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
if (!defined("IN_FUSION")) { die("Access Denied"); }

if ($profile_method == "input") {
	//Nothing
} elseif ($profile_method == "display") {
	include_once INFUSIONS."sf_gift_system/includes/infusion_db.php";
	include_once INFUSIONS."sf_gift_system/includes/functions.php";
	
	echo "</table>";
	
	echo "<div style='margin:5px'></div>\n";
	
	echo "<table cellpadding='0' cellspacing='1' width='400' class='tbl-border center'>\n<tr>\n";
	echo "<td class='tbl2' colspan='2'>";
	echo "<span style='float:left'><strong>SF Gift System</strong></span>";
	if ($userdata['user_id'] != $_GET['lookup']) {
		echo "<span style='float:right'>[<a href=''>Give Gift</a>]</span>";
	}
	echo "</td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td class='tbl1' colspan='2'>";
	
	include GIFT_INCLUDES."profile_include.php";

	echo "</td>\n";
	echo "</tr>\n";
	$user_fields++;
} elseif ($profile_method == "validate_insert") {
	//Nothing
} elseif ($profile_method == "validate_update") {
	//Nothing
}
?>