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

$inf_newtable[1] = DB_UCC_SETTINGS." (
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

$inf_insertdbrow[1] = DB_UCC_SETTINGS." (ucc_version, ucc_logins_perpage, ucc_pm_post_perpage, ucc_panel_showall, ucc_panel_d_show_auto, ucc_panel_d_show_manu, ucc_panel_c_show_auto, ucc_panel_c_show_manu, ucc_ghost) VALUES ('".$inf_version."', '20', '20', '1', '1', '1', '1', '1', '0')";

$inf_droptable[1] = DB_UCC_SETTINGS;

$inf_adminpanel[1] = array(
	"title" => $locale['ucc_100'],
	"image" => "infusions.gif",
	"panel" => "ucc_admin.php",
	"rights" => "UCC"
);

$inf_adminpanel[2] = array(
	"title" => "UCC - Last Logins",
	"image" => "infusions.gif",
	"panel" => "redirects/lastlogin.php",
	"rights" => "UCCa"
);

$inf_adminpanel[3] = array(
	"title" => "UCC - Pm Counter",
	"image" => "infusions.gif",
	"panel" => "redirects/pmcount.php",
	"rights" => "UCCb"
);

$inf_adminpanel[4] = array(
	"title" => "UCC - Post Counter",
	"image" => "infusions.gif",
	"panel" => "redirects/postcount.php",
	"rights" => "UCCc"
);

$inf_adminpanel[5] = array(
	"title" => "UCC - Image Checker",
	"image" => "infusions.gif",
	"panel" => "redirects/imagecheck.php",
	"rights" => "UCCd"
);

$inf_adminpanel[6] = array(
	"title" => "UCC - Attachment checker",
	"image" => "infusions.gif",
	"panel" => "redirects/a_imagecheck.php",
	"rights" => "UCCe"
);

$inf_adminpanel[7] = array(
	"title" => "UCC - Usersearch",
	"image" => "infusions.gif",
	"panel" => "redirects/usersearch.php",
	"rights" => "UCCf"
);

$inf_adminpanel[8] = array(
	"title" => "UCC - Delete Members",
	"image" => "infusions.gif",
	"panel" => "redirects/delete.php",
	"rights" => "UCCg"
);

$inf_adminpanel[9] = array(
	"title" => "UCC - Unactivated User",
	"image" => "infusions.gif",
	"panel" => "redirects/unactiveusers.php",
	"rights" => "UCCh"
);

$inf_adminpanel[10] = array(
	"title" => "UCC - Settings",
	"image" => "infusions.gif",
	"panel" => "redirects/_config_.php",
	"rights" => "UCCi"
);


$inf_adminpanel[11] = array(
	"title" => "UCC - Usergroups",
	"image" => "infusions.gif",
	"panel" => "redirects/usergroups.php",
	"rights" => "UCCj"
);

$inf_adminpanel[12] = array(
	"title" => "UCC - Remember Mail",
	"image" => "infusions.gif",
	"panel" => "redirects/remember.php",
	"rights" => "UCCk"
);

$inf_adminpanel[13] = array(
	"title" => "UCC - Postrecounter",
	"image" => "infusions.gif",
	"panel" => "redirects/postrecount.php",
	"rights" => "UCCl"
);

?>