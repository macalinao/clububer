<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| User Control Center 2.41
| Author: Sebastian Schüssler (slaughter)
| Download:
| http://basti2web.de
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

// PHP-Fusion Version Checker for switch();
if(!defined('UCC_PHPF_VER')) {
		$numbers = explode('.', $settings['version']);
		$version = intval(array_shift($numbers));
		define('UCC_PHPF_VER', $version);
}


?>