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
	if (file_exists(INFUSIONS."uberpets/locale/".$settings['locale'].".php")) {
		include INFUSIONS."uberpets/locale/".$settings['locale'].".php";
	} else {
		include INFUSIONS."uberpets/locale/English.php";
	}
	require_once INFUSIONS."uberpets/infusion_db.php";


// Infusion general information
$inf_title = $locale['UBP_title'];
$inf_description = $locale['UBP_desc'];
$inf_version = "0.0.0.5";
$inf_developer = "Grr/Qenzaf";
$inf_email = "grr@clububer.com";
$inf_weburl = "http://www.clububer.com/";

$inf_folder = "uberpets"; // The folder in which the infusion resides.

	

#####################################################
#                         V6                        #
#####################################################
if (preg_match("/^[6]./",$settings['version'])) {

	$inf_admin_image = ""; // Leave blank to use the default image.
	$inf_admin_panel = "admin/admin.php"; // The admin panel filename if required.
	
	$inf_link_name = "UberPets"; // if not required replace $locale['xxx102']; with "";
	$inf_link_url = "index.php"; // The filename you wish to link to.
	$inf_link_visibility = "101"; // 0 - Guest / 101 - Member / 102 - Admin / 103 - Super Admin.

	$inf_newtables = 7; // Number of new db tables to create or drop.
	$inf_insertdbrows = 0; // Numbers rows added into created db tables.
	$inf_altertables = 0; // Number of db tables to alter (upgrade).
	$inf_deldbrows = 7; // Number of db tables to delete data from.

	$inf_newtable_[1] = "uberpets_pets (
		`pid` int(100) NOT NULL auto_increment,
		`uid` int(100) NOT NULL default '0',
		`name` text NOT NULL,
		`color` text NOT NULL,
		`species` text NOT NULL,
		`type` text NOT NULL,
		`usrpet` int(1) NOT NULL default '0',
		`active` tinyint(1) NOT NULL default '0',
		`days` int(255) NOT NULL default '0',
		PRIMARY KEY (`pid`)
	) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
	
	$inf_newtable_[2] = "uberpets_pet_species (
		`sid` int(100) NOT NULL auto_increment,
		`name` text NOT NULL,
		`info` text NOT NULL,
		`folder` text NOT NULL,
		`default_color` text NOT NULL,
		PRIMARY KEY (`sid`)
	) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";

	$inf_newtable_[3] = "uberpets_items (
		`iid` int(7) NOT NULL auto_increment,
		`name` text NOT NULL,
		`description` text NOT NULL,
		`action` text NOT NULL,
		`rarity` tinyint(3) NOT NULL default '0',
		`value` int(20) NOT NULL default '0',
		`folder` text NOT NULL,
		`image` text NOT NULL,
		`cat_id` text NOT NULL,
		`visibility` int(11) NOT NULL default '0',
		`include_file` text NOT NULL,
		`option` tinyint(1) NOT NULL default '0',
		PRIMARY KEY (`iid`)
	) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";

	$inf_newtable_[4] = "uberpets_items_cats (
		`cid` int(10) NOT NULL auto_increment,
		`name` text NOT NULL,
		PRIMARY KEY (`cid`)
	) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";

	$inf_newtable_[5] = "uberpets_pound (
		`pid` int(100) NOT NULL auto_increment,
		`uid` int(100) NOT NULL default '0',
		`name` text NOT NULL,
		`color` text NOT NULL,
		`species` text NOT NULL,
		`type` text NOT NULL,
		`usrpet` int(1) NOT NULL default '0',
		`active` int(1) NOT NULL default '0',
		`days` int(255) NOT NULL default '0',
		PRIMARY KEY (`pid`)
	) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
	
	$inf_newtable_[6] = "uberpets_user (
	  `uid` int(11) NOT NULL default '0',
	  `pets` int(2) NOT NULL default '0',
	  PRIMARY KEY  (`uid`)
	) ENGINE=MyISAM DEFAULT CHARSET=latin1;";

	$inf_newtable_[7] = "uberpets_settings (
		`pound_pets_per_page` tinyint(5) NOT NULL default '0',
		`pound_pets_per_row` tinyint(5) NOT NULL default '0',
		`scriptseofusion` tinyint(1) NOT NULL default '0'
	) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
	
	$inf_droptable_[1] = 'uberpets_pets';
	$inf_droptable_[2] = 'uberpets_pet_species';
	$inf_droptable_[3] = 'uberpets_items';
	$inf_droptable_[4] = 'uberpets_pound';
	$inf_droptable_[5] = 'uberpets_user';
	$inf_droptable_[6] = 'uberpets_settings';
	$inf_droptable_[7] = 'uberpets_items_cats';
#####################################################
#                         V7                        #
#####################################################
} elseif (preg_match("/^[7]/",$settings['version'])) {
	
	$inf_adminpanel[1] = array(
		"title" => $locale['UBP_admin'],
		"image" => "infusion.gif",
		"panel" => "admin/admin.php",
		"rights" => "UBP"
	);
	
	$inf_sitelink[1] = array(
		"title" => $locale['UBP_link'],
		"url" => "index.php",
		"visibility" => "0"
	);
	
	$inf_newtable[1] = DB_UBERPETS_PETS." (
		`pid` int(100) NOT NULL auto_increment,
		`uid` int(100) NOT NULL default '0',
		`name` text NOT NULL,
		`color` text NOT NULL,
		`species` text NOT NULL,
		`type` text NOT NULL,
		`usrpet` int(1) NOT NULL default '0',
		`active` tinyint(1) NOT NULL default '0',
		`days` int(255) NOT NULL default '0',
		PRIMARY KEY (`pid`)
	) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
	
	$inf_newtable[2] = DB_UBERPETS_PET_SPECIES." (
		`sid` int(100) NOT NULL auto_increment,
		`name` text NOT NULL,
		`info` text NOT NULL,
		`folder` text NOT NULL,
		`default_color` text NOT NULL,
		PRIMARY KEY (`sid`)
	) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";

	$inf_newtable[3] = DB_UBERPETS_ITEMS." (
		`iid` int(7) NOT NULL auto_increment,
		`name` text NOT NULL,
		`description` text NOT NULL,
		`action` text NOT NULL,
		`rarity` tinyint(3) NOT NULL default '0',
		`value` int(20) NOT NULL default '0',
		`folder` text NOT NULL,
		`image` text NOT NULL,
		`cat_id` text NOT NULL,
		`visibility` int(11) NOT NULL default '0',
		`include_file` text NOT NULL,
		`option` tinyint(1) NOT NULL default '0',
		PRIMARY KEY (`iid`)
	) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";

	$inf_newtable[4] = DB_UBERPETS_ITEMS_CATS." (
		`cid` int(10) NOT NULL auto_increment,
		`name` text NOT NULL,
		PRIMARY KEY (`cid`)
	) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";

	$inf_newtable[5] = DB_UBERPETS_POUND." (
		`pid` int(100) NOT NULL auto_increment,
		`uid` int(100) NOT NULL default '0',
		`name` text NOT NULL,
		`color` text NOT NULL,
		`species` text NOT NULL,
		`type` text NOT NULL,
		`usrpet` int(1) NOT NULL default '0',
		`active` int(1) NOT NULL default '0',
		`days` int(255) NOT NULL default '0',
		PRIMARY KEY (`pid`)
	) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
	
	$inf_newtable[6] = DB_UBERPETS_USER." (
	  `uid` int(11) NOT NULL default '0',
	  `pets` int(2) NOT NULL default '0',
	  PRIMARY KEY  (`uid`)
	) ENGINE=MyISAM DEFAULT CHARSET=latin1;";

	$inf_newtable[7] = DB_UBERPETS_SETTINGS." (
		`pound_pets_per_page` tinyint(5) NOT NULL default '0',
		`pound_pets_per_row` tinyint(5) NOT NULL default '0',
		`scriptseofusion` tinyint(1) NOT NULL default '0'
	) ENGINE=MyISAM DEFAULT CHARSET=latin1;";

	$inf_droptable[1] = DB_UBERPETS_PETS;
	$inf_droptable[2] = DB_UBERPETS_PET_SPECIES;
	$inf_droptable[3] = DB_UBERPETS_ITEMS;
	$inf_droptable[4] = DB_UBERPETS_ITEMS_CATS;
	$inf_droptable[5] = DB_UBERPETS_POUND;
	$inf_droptable[6] = DB_UBERPETS_USER;
	$inf_droptable[7] = DB_UBERPETS_SETTINGS;
}


?>