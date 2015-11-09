<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Author: Domi & fetloser
| www.venue.nu			     	      
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
if (!defined("IN_FUSION") || !checkrights("I")) { header("Location: ../../index.php"); exit; }

if (!defined("LANGUAGE")) {
// PHPFusion environment
$this_lang = str_replace("/", "", LOCALESET);
if (file_exists(INFUSIONS."the_kroax/locale/".$this_lang.".php")) {
include INFUSIONS."the_kroax/locale/".$this_lang.".php";
} else {
include INFUSIONS."the_kroax/locale/English.php";
}
}

// Infusion general information
$inf_title = "The Kroax";
$inf_description = "The Kroax";
$inf_version = "7.1";
$inf_developer = "Domi & fetloser";
$inf_email = "";
$inf_weburl = "http://www.venue.nu";

$inf_folder = "the_kroax"; 

$inf_adminpanel[1] = array(
	"title" => $inf_title,
	"image" => "../../infusions/the_kroax/img/the_kroax.jpg",
	"panel" => "admin/admin.php",
	"rights" => "KR"
);

$inf_sitelink[1] = array(
	"title" => $inf_title,
	"url" => "kroax.php",
	"visibility" => "0"
);

$inf_newtables = 7; // Number of new db tables to create or drop.
$inf_insertdbrows = 1; // Numbers rows added into created db tables.
$inf_altertables = 0; // Number of db tables to alter (upgrade).
$inf_deldbrows = 0; // Number of db tables to delete data from.

// Delete any items not required here.

$inf_newtable[1] = "".$db_prefix."kroax (
`kroax_id` smallint(5) unsigned NOT NULL auto_increment,
`kroax_titel` varchar(90),
`kroax_cat` varchar(30),
`kroax_access` varchar(10),
`kroax_access_cat` varchar(10),
`kroax_date` int(10),
`kroax_embed` text,
`kroax_uploader` varchar(50),
`kroax_lastplayed` int(10),
`kroax_approval` varchar(30),
`kroax_url` varchar(200),
`kroax_downloads` int(10),
`kroax_hits` varchar(50),
`kroax_description` text,
`kroax_tumb` varchar(150),
`kroax_errorreport` varchar(100),
PRIMARY KEY (`kroax_id`)
) TYPE=MyISAM;";

$inf_newtable[2] = "".$db_prefix."kroax_kategori (
`cid` smallint(5) unsigned NOT NULL auto_increment,
`title` varchar(40),
`access` varchar(10),
`image` varchar(30),
`parentid` int(10),
`status` int(10),
PRIMARY KEY (`cid`)
) TYPE=MyISAM;";

$inf_newtable[3] = "".$db_prefix."kroax_set (
`kroax_set_id` smallint(2),
`kroax_set_hi` varchar(3),
`kroax_set_wi` varchar(3),
`kroax_set_pre` varchar(50),
`kroax_set_pic` varchar(100),
`kroax_set_show` varchar(20),
`kroax_set_thumb` varchar(10),
`kroax_set_thumbs_per_row` int(10),
`kroax_set_thumbs_per_page` int(10),
`kroax_set_ffmpeg` int(10),
`kroax_set_favorites` int(10),
`kroax_set_recommend` int(10),
`kroax_set_ratings` int(10),
`kroax_set_comments` int(10),
`kroax_set_keepalive` int(10),
`kroax_set_playingnow` int(10),
`kroax_set_bannerimg` varchar(100),
`kroax_set_related` int(10),
`kroax_set_report` int(10),
`kroax_set_allowembed` int(10),
`kroax_set_allowdownloads` int(10),
`kroax_set_allowplaylist` int(10),
`kroax_set_allowuploads` int(10),
`kroax_set_defaultview` int(10),
`kroax_set_version` varchar(10),
PRIMARY KEY (`kroax_set_id`)
) TYPE=MyISAM;";

$inf_newtable[4] = "".$db_prefix."kroax_rating (
`id` varchar(11) NOT NULL default '',
`total_votes` int(11) NOT NULL default '0',
`total_value` int(11) NOT NULL default '0',
`which_id` int(11) NOT NULL default '0',
`used_ips` longtext,
PRIMARY KEY  (`id`)
) TYPE=MyISAM;";

$inf_newtable[5] = "".$db_prefix."kroax_active (
`movie_id` int(10) NOT NULL default '0',
`title` varchar(50) NOT NULL default '0',
`icon` varchar(50) NOT NULL default '0',
`lastactive` int(10) unsigned NOT NULL default '0'
) TYPE=MyISAM;";

$inf_newtable[6] = "".$db_prefix."kroax_activeusr (
`movie_id` int(10) NOT NULL default '0',
`member` int(10) NOT NULL default '0',
`user_ip` varchar(20) NOT NULL default '0',
`lastactive` int(10) unsigned NOT NULL default '0'
) TYPE=MyISAM;";


$inf_newtable[7] = "".$db_prefix."kroax_favourites (
`fav_id` int(30),
`fav_user` int(30),
`fav_date` int(10)
) TYPE=MyISAM;";


$inf_insertdbrow[1] = "".$db_prefix."kroax_set VALUES('1', '85', '150', '10', '15', '1','1','4','16','0','1','1','1','1','1','1','img/logo.gif','1','1','0','0','1','1','1','7.1')";

$inf_droptable[1] = "".$db_prefix."kroax";
$inf_droptable[2] = "".$db_prefix."kroax_kategori";
$inf_droptable[3] = "".$db_prefix."kroax_set";
$inf_droptable[4] = "".$db_prefix."kroax_rating";
$inf_droptable[5] = "".$db_prefix."kroax_active";
$inf_droptable[6] = "".$db_prefix."kroax_activeusr";
$inf_droptable[7] = "".$db_prefix."kroax_favourites";
?>

