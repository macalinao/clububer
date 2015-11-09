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

// Infusion general information
$inf_title = "VArcade";
$inf_description = "VArcade";
$inf_version = "1.7";
$inf_developer = "Domi & fetloser";
$inf_email = "";
$inf_weburl = "http://www.venue.nu";

$inf_folder = "varcade"; 

$inf_adminpanel[1] = array(
	"title" => $inf_title,
	"image" => "pictureflow.gif",
	"panel" => "admin/admin.php",
	"rights" => "VA"
);

$inf_sitelink[1] = array(
	"title" => $inf_title,
	"url" => "index.php",
	"visibility" => "0"
);

$inf_newtables = 10; // Number of new db tables to create or drop.
$inf_insertdbrows = 1; // Numbers rows added into created db tables.
$inf_altertables = 0; // Number of db tables to alter (upgrade).
$inf_deldbrows = 2; // Number of db tables to delete data from.

$inf_newtable[1] = "".$db_prefix."varcade_games (
  `lid` int(4) NOT NULL auto_increment,
  `cid` int(11) NOT NULL default '0',
  `title` varchar(100) NOT NULL default '',
  `description` text NOT NULL,
  `flash` varchar(100) NOT NULL default '',
  `icon` varchar(100) NOT NULL default '',
  `played` int(10) NOT NULL default '0',
  `hiscore` int(20) NOT NULL default '0',
  `hi_player` varchar(50) NOT NULL default '0',
  `status` int(1) NOT NULL default '2',
  `lastplayed` int(10) unsigned NOT NULL default '0',
  `width` varchar(6) NOT NULL default '100%',
  `height` varchar(6) NOT NULL default '100%',
  `control` enum('0','1') NOT NULL default '0',
  `reverse` int(1) NOT NULL default '0',
  `hiscoredate` int(1) NOT NULL default '0',
  `cost` int(10) NOT NULL default '0',
  `reward` int(10) NOT NULL default '0',
  `bonus` int(10) NOT NULL default '0',
  `access` int(1) NOT NULL default '0',
  `errorreport` char(1) NOT NULL default '',
  PRIMARY KEY  (`lid`),
  UNIQUE KEY `title` (`title`),
  UNIQUE KEY `flash` (`flash`)
) TYPE=MyISAM;";

$inf_newtable[2] = "".$db_prefix."varcade_score (
  `score_id` int(10) NOT NULL auto_increment,
  `game_id` int(4) NOT NULL default '0',
  `player_id` int(4) NOT NULL default '0',
  `game_score` int(20) NOT NULL default '0',
  `score_date` int(10) unsigned default NULL,
  PRIMARY KEY  (`score_id`)
) TYPE=MyISAM;";

$inf_newtable[3] = "".$db_prefix."varcade_cats (
  `cid` int(11) NOT NULL auto_increment,
  `title` varchar(50) NOT NULL default '0',
  `description` text NOT NULL,
  `image` varchar(20) NOT NULL default '0',
  `access` int(1) NOT NULL default '0',
  PRIMARY KEY  (`cid`)
) TYPE=MyISAM;";

$inf_newtable[4] = "".$db_prefix."varcade_tournaments (
  `id` mediumint(10) NOT NULL auto_increment,
  `tour_game` int(10) NOT NULL default '0',
  `tour_title` varchar(100) NOT NULL default '0',
  `tour_icon` varchar(100) NOT NULL default '',
  `tour_flash` varchar(100) NOT NULL default '',
  `tour_winner` varchar(100) NOT NULL default '0',
  `tour_score` int(20) NOT NULL default '0',
  `tour_players` smallint(10) NOT NULL default '0',
  `tour_reverse` char(1) NOT NULL default '',
  `tour_startdate` int(10) unsigned default NULL,
  `tour_enddate` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;";

$inf_newtable[5] = "".$db_prefix."varcade_tournament_scores (
  `id` mediumint(10) NOT NULL auto_increment,
  `game_id` mediumint(10) NOT NULL default '0',
  `player_id` mediumint(10) NOT NULL default '0',
  `tour_id` mediumint(10) NOT NULL default '0',
  `game_score` mediumint(20) NOT NULL default '0',
  `score_date` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;";

$inf_newtable[6] = "".$db_prefix."varcade_favourites (
  `fav_id` mediumint(10) NOT NULL default '0',
  `fav_user` mediumint(10) NOT NULL default '0',
  `fav_date` varchar(20) NOT NULL default '0',
  `fav_icon` varchar(30) NOT NULL default '0',
  `fav_gamename` varchar(30) NOT NULL default '0'
) TYPE=MyISAM;";

$inf_newtable[7] = "".$db_prefix."varcade_rating (
`id` varchar(11) NOT NULL default '',
`total_votes` int(11) NOT NULL default '0',
`total_value` int(11) NOT NULL default '0',
`which_id` int(11) NOT NULL default '0',
`used_ips` longtext,
 PRIMARY KEY  (`id`)
) TYPE=MyISAM;";

$inf_newtable[8] = "".$db_prefix."varcade_settings (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `thumbs_per_row` char(1) NOT NULL default '0',
  `thumbs_per_page` char(1) NOT NULL default '0',
  `allow_guest_play` char(1) NOT NULL default '0',
  `showsize` char(1) NOT NULL default '0',
  `favorites` char(1) NOT NULL default '0',
  `recommend` char(1) NOT NULL default '0',
  `ratings` char(1) NOT NULL default '0',
  `sound` char(1) NOT NULL default '0',
  `comments` char(1) NOT NULL default '0',
  `reports` char(1) NOT NULL default '0',
  `hiscorepm` char(1) NOT NULL default '0',
  `flashdetection` char(1) NOT NULL default '0',
  `tournaments` char(1) NOT NULL default '0',
  `touringp` char(1) NOT NULL default '0',
  `ingameopts` char(1) NOT NULL default '0',
  `related` char(1) NOT NULL default '0',
  `bannerimg` varchar(50) NOT NULL default '0',
  `playingnow` char(1) NOT NULL default '0',
  `usergold` char(1) NOT NULL default '0',
  `keepalive` char(1) NOT NULL default '0',
  `popup` char(1) NOT NULL default '0',
  `version` varchar(5) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;";

$inf_insertdbrow[1] = "".$db_prefix."varcade_settings VALUES (1, '2', '6', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1','1', '1', '1', '1','1', '1','0','1','1', '1.6')";

$inf_newtable[9] = "".$db_prefix."varcade_active (
  `game_id` int(10) NOT NULL default '0',
  `title` varchar(50) NOT NULL default '0',
  `icon` varchar(50) NOT NULL default '0',
  `lastactive` int(10) unsigned NOT NULL default '0'
) TYPE=MyISAM;";

$inf_newtable[10] = "".$db_prefix."varcade_activeusr (
  `game_id` int(10) NOT NULL default '0',
  `player` int(10) NOT NULL default '0',
  `user_ip` varchar(20) NOT NULL default '0',
  `lastactive` int(10) unsigned NOT NULL default '0'
) TYPE=MyISAM;";


$inf_droptable[1] = "".$db_prefix."varcade_games";
$inf_droptable[2] = "".$db_prefix."varcade_cats";
$inf_droptable[3] = "".$db_prefix."varcade_score";
$inf_droptable[4] = "".$db_prefix."varcade_tournaments";
$inf_droptable[5] = "".$db_prefix."varcade_tournament_scores";
$inf_droptable[6] = "".$db_prefix."varcade_favourites";
$inf_droptable[7] = "".$db_prefix."varcade_rating";
$inf_droptable[8] = "".$db_prefix."varcade_settings";
$inf_droptable[9] = "".$db_prefix."varcade_active";
$inf_droptable[10] = "".$db_prefix."varcade_activeusr";

$inf_deldbrow_[1] = "".$db_prefix."comments WHERE comment_type = 'G';";
?>