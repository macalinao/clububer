<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| User Control Center 2.40a
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

if (!defined("IN_FUSION") || !checkrights("I")) { die("Access Denied"); }

$inf_admin_image = "infusions.gif"; // Leave blank to use the default image.
$inf_admin_panel = "ucc_admin.php";

$inf_link_name = "";
$inf_link_url = ""; // The filename you wish to link to.
$inf_link_visibility = "101"; // 0 - Guest / 101 - Member / 102 - Admin / 103 - Super Admin.

$inf_newtables = 1; // Number of new db tables to create or drop.
$inf_insertdbrows = 1; // Numbers rows added into created db tables.
$inf_altertables = 0; // Number of db tables to alter (upgrade).
$inf_deldbrows = 0; // Number of db tables to delete data from.

$inf_newtable_[1] = "ucc_settings (
ucc_id SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
ucc_version VARCHAR(100) NOT NULL DEFAULT '',
ucc_version_temp VARCHAR(100) NOT NULL DEFAULT '',
ucc_version_time INT(10) UNSIGNED DEFAULT '0' NOT NULL,
ucc_logins_perpage INT(5) UNSIGNED DEFAULT '0' NOT NULL,
ucc_pm_post_perpage INT(5) UNSIGNED DEFAULT '0' NOT NULL,
ucc_panel_showall INT(5) UNSIGNED DEFAULT '0' NOT NULL,
ucc_panel_d_show_auto INT(5) UNSIGNED DEFAULT '0' NOT NULL,
ucc_panel_d_show_manu INT(5) UNSIGNED DEFAULT '0' NOT NULL,
ucc_panel_c_show_auto INT(5) UNSIGNED DEFAULT '0' NOT NULL,
ucc_panel_c_show_manu INT(5) UNSIGNED DEFAULT '0' NOT NULL,
ucc_ghost INT(5) UNSIGNED DEFAULT '0' NOT NULL,
PRIMARY KEY (ucc_id)
) TYPE=MyISAM;";

$inf_insertdbrow_[1] = "ucc_settings (ucc_version, ucc_logins_perpage, ucc_pm_post_perpage, ucc_panel_showall, ucc_panel_d_show_auto, ucc_panel_d_show_manu, ucc_panel_c_show_auto, ucc_panel_c_show_manu, ucc_ghost) VALUES ('".$inf_version."', '20', '20', '1', '1', '1', '1', '1', '0')";

$inf_droptable_[1] = "ucc_settings";

?>