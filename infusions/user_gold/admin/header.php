<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| User Gold 3
| Copyright © 2007 - 2008 UG3 Developement Team
| http://www.starglowone.com/
+--------------------------------------------------------+
| Filename: header.php
| Author: UG3 Developement Team
+--------------------------------------------------------+
| This program is released as free software under the
| Stars Heaven Licence. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included licence.html.
| Removal of this copyright header is strictly
| prohibited without written permission
| from the original author(s).
+--------------------------------------------------------*/
require_once "../../../maincore.php";
require_once THEMES."templates/admin_header.php";
if (!checkrights("UG3") || !defined("iAUTH") || $_GET['aid'] != iAUTH) { redirect("../index.php"); }

include_once INFUSIONS."user_gold/infusion_db.php";
include_once INFUSIONS."user_gold/functions.php";

if (file_exists(GOLD_LANG.LOCALESET."admin/global.php")) {
	include GOLD_LANG.LOCALESET."admin/global.php";
} else {
	include GOLD_LANG."English/admin/global.php";
}

include_once INFUSIONS."user_gold/admin/admin_functions.php";
?>