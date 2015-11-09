<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: user_ug3-information_include.php
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
	include_once INFUSIONS."user_gold/infusion_db.php";
	include_once INFUSIONS."user_gold/functions.php";
	$user_id = isnum($_GET['lookup']) ? $_GET['lookup'] : 0;
	if($user_id) {	
		list($name) = dbarraynum(dbquery("SELECT user_name FROM ".DB_USERS." WHERE user_id=".$user_id));
		list($cash, $bank, $karma, $chips) = dbarraynum(dbquery("SELECT cash, bank, karma, chips FROM ".DB_UG3." WHERE owner_id=".$user_id));
		echo "</table>";
		
		echo "<div style='margin:5px'></div>\n";
		
		echo "<table cellpadding='0' cellspacing='1' width='400' class='tbl-border center'>\n<tr>\n";
		echo "<td class='tbl2' colspan='2'><strong>".$locale['uf_user_ug3-information']."</strong></td>\n";
		echo "</tr>\n<tr>\n";
		echo "<td class='tbl1' colspan='2'>";
		
		echo "<table width='100%'>\n<tr>\n";
		echo "<td class='tbl1' width='50%'><img src='".GOLD_IMAGE."cash.png' title='".UGLD_GOLDTEXT."' alt='".UGLD_GOLDTEXT."' />&nbsp;".formatMoney($cash)."</td>";
		echo "<td class='tbl1' width='50%'><img src='".GOLD_IMAGE."bank.png' title='".UGLD_GOLDTEXT.$locale['uf_user_ug3-information_001']."' alt='".UGLD_GOLDTEXT.$locale['uf_user_ug3-information_001']."' />&nbsp;".formatMoney($bank)."</td>";
		echo "</tr><tr>";
		echo "<td class='tbl1' width='50%'><img src='".GOLD_IMAGE."karma.png' title='".$locale['uf_user_ug3-information_003']."' alt='".$locale['uf_user_ug3-information_003']."' />&nbsp;".formatMoney($karma)."</td>";
		echo "<td class='tbl1' width='50%'><img src='".GOLD_IMAGE."chips.png' title='".$locale['uf_user_ug3-information_002']."' alt='".$locale['uf_user_ug3-information_002']."' />&nbsp;".formatMoney($chips)."</td>";
		echo "</tr><tr>";
		echo "<td class='tbl1' colspan='2' width='100%'><hr /><div style='text-align: center;'>".$locale['uf_user_ug3-information_004']."<br />".showribbons($user_id, false)."</div></td>";
		echo "</tr>\n</table>\n";	

		echo "</td>\n";
		echo "</tr>\n";
		$user_fields++;
	}
} elseif ($profile_method == "validate_insert") {
	//Nothing
} elseif ($profile_method == "validate_update") {
	//Nothing
}
?>