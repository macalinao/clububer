<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--- ----------------------------------------------------+
| UBERPETS V 0.0.0.5
+--------------------------------------------------------+
| Uberpets Copyright 2008 Grr@µsoft inc.
| http://www.clububer.com/
\*-------------------------------------------------------*/
if (!defined("IN_UBP")) { die("Access Denied"); }

if (isset($_POST['save_cat'])) {
$name = stripinput($_POST['name']);

	if (isset($step) && $step == "edit") {
	$result = dbquery("UPDATE ".DB_UBERPETS_PET_SPECIES." SET WHERE sid ='$species_id'");
	} else {
	$result = dbquery("INSERT INTO ".DB_UBERPETS_PET_SPECIES." (sid, name, info, folder, default_color) VALUES('', '$name','$info', '$folder', '$default_color')");
	}
}


?>