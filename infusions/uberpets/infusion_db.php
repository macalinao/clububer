<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: infusion_db.php
| Author: INSERT NAME HERE
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
if (!defined("DB_UBERPETS_ITEMS")) {
	define("DB_UBERPETS_ITEMS", DB_PREFIX."uberpets_items");
}
if (!defined("DB_UBERPETS_ITEMS_CATS")) {
	define("DB_UBERPETS_ITEMS_CATS", DB_PREFIX."uberpets_items_cats");
}
if (!defined("DB_UBERPETS_PETS")) {
	define("DB_UBERPETS_PETS", DB_PREFIX."uberpets_pets");
}
if (!defined("DB_UBERPETS_PET_SPECIES")) {
	define("DB_UBERPETS_PET_SPECIES", DB_PREFIX."uberpets_pet_species");
}
if (!defined("DB_UBERPETS_POUND")) {
	define("DB_UBERPETS_POUND", DB_PREFIX."uberpets_pound");
}
if (!defined("DB_UBERPETS_SETTINGS")) {
	define("DB_UBERPETS_SETTINGS", DB_PREFIX."uberpets_settings");
}
if (!defined("DB_UBERPETS_USER")) {
	define("DB_UBERPETS_USER", DB_PREFIX."uberpets_user");
}
if (!defined("DB_UBERPETS_USER_ITEMS")) {
	define("DB_UBERPETS_USER_ITEMS", DB_PREFIX."uberpets_user_items");
}
?>