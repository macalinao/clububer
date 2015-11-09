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
| Filename: index.php
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
require_once "header.php";
include_once GOLD_ADMIN.'inventry.php';
include_once GOLD_ADMIN.'dbmgnt.php';

admin_menu();

/*	Switchboard	*/
if(!isset($_GET['op'])){ $op = "main"; } else {$op = $_GET['op']; }
switch($op) {
	case "main":
		gold_admin_main();
		break;
	case "useage":
		include GOLD_ADMIN.'usage.php';
		break;
	case "config":
		include GOLD_ADMIN.'configuration.php';
		break;
	case "about":
		include GOLD_ADMIN.'about.php';
		break;
	case "images":
		include GOLD_ADMIN.'images.php';
		break;
	case "inventory":
		start_inventory();
		break;
	case "start_inventory":
		start_inventory();
		break;
	case "viewmember":
		viewmember();
		break;
	case "delete":
		delete();
		break;
	case "admineditmoney":
		admineditmoney();
		break;
	case "admin_sell":
		admin_sell();
		break;
	case "deluserquestion":
		deluserquestion();
		break;
	case "delusersaction":
		delusersaction();
		break;
	default:
		if(!$op) {
			opentable($locale['urg_a_global_100'],'');
			gold_admin_main();
		}
		break;
}

require_once "footer.php";
?>