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
| Filename: infusion_db.php
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
if (!defined("IN_FUSION")) { die("Access Denied"); }

if (!defined("DB_UG3")) {
	define("DB_UG3", DB_PREFIX."user_gold");
}
if (!defined("DB_UG3_INVENTORY")) {
	define("DB_UG3_INVENTORY", DB_PREFIX."user_gold_inventory");
}
if (!defined("DB_UG3_SETTINGS")) {
	define("DB_UG3_SETTINGS", DB_PREFIX."user_gold_settings");
}
if (!defined("DB_UG3_USAGE")) {
	define("DB_UG3_USAGE", DB_PREFIX."user_gold_usage");
}
if (!defined("DB_UG3_CATEGORIES")) {
	define("DB_UG3_CATEGORIES", DB_PREFIX."user_gold_categories");
}
if (!defined("DB_UG3_TRANSACTIONS")) {
	define("DB_UG3_TRANSACTIONS", DB_PREFIX."user_gold_transactions");
}

?>