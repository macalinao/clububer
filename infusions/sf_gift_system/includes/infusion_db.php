<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: upgrade_functions.php
| Author: Starefossen
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

if (!defined("DB_GIFT")) {
	define("DB_GIFT", DB_PREFIX."sf_gift");
}
if (!defined("DB_GIFT_VERSION")) {
	define("DB_GIFT_VERSION", DB_PREFIX."sf_gift_version");
}
if (!defined("DB_GIFT_GIVEN")) {
	define("DB_GIFT_GIVEN", DB_PREFIX."sf_gift_given");
}

?>