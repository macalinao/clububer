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
// PAGE INCLUDES
require_once "../../maincore.php";
if (!defined("IN_UBP")) { include "includes/core.php"; }


if (preg_match("/^[6]./",$settings['version'])) {
	require_once BASEDIR."subheader.php";
	require_once UBP_BASE."includes/side_left.php";
}
elseif (preg_match("/^[7]./", $settings['version'])) {
	require_once THEMES."templates/header.php";
}

if (!$usr['uid'] || $pets_of_user == 0) { redirect(UBP_BASE."create_pet.php"); }

include UBP_BASE."includes/pagelinks.php";
//PAGE INCLUDES END

	opentable($locale['UBP_title']);
		echo $locale['UBP_001'];
	closetable();


//BOTTOM PAGE INCLUDES
if (preg_match("/^[6]./",$settings['version'])) {
	require_once UBP_BASE."includes/side_right.php";
	require_once BASEDIR."footer.php";
}
elseif (preg_match("/^[7]./", $settings['version'])) {
	require_once THEMES."templates/footer.php";
}
//END
?>
