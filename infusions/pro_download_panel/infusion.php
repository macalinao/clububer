<?php
/***************************************************************************
 *   Professional Download System                                          *
 *                                                                         *
 *   Copyright (C) pirdani                                                 *
 *   pirdani@hotmail.de                                                    *
 *   http://pirdani.de/                                                    *
 *                                                                         *
 *   Copyright (C) 2005 EdEdster (Stefan Noss)                             *
 *   http://edsterathome.de/                                               *
 *                                                                         *
 *   Copyright (C) 2006-2008 Artur Wiebe                                   *
 *   wibix@gmx.de                                                          *
 *   http://wibix.de/                                                      *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU General Public License as published by  *
 *   the Free Software Foundation; either version 2 of the License, or     *
 *   (at your option) any later version.                                   *
 ***************************************************************************/
if(!defined('IN_FUSION') || !checkrights('I')) {
	die;
}

require_once(INFUSIONS.'pro_download_panel/include/core.php');

$infusion = array(
	'title'		=> 'Professional Download System',
	'description'	=> 'Professional Download System',
	'version'	=> '1.8.4',
	'developer'	=> 'Artur Wiebe',
	'email'		=> 'wibix@gmx.de',
	'weburl'	=> 'http://wibix.de',
);

$admin_links = array();
$admin_links[] = array(
	'title'		=> $infusion['title'],
	'image'		=> '',
	'url'		=> 'admin/admin.php',
	'rights'	=> 'PDP',
);

$site_links = array();
$site_links[] = array(
	'title'		=> $infusion['title'],
	'image'		=> '',
	'url'		=> 'download.php',
	'visibility'	=> '0',
);


/* TABLE STUFF */
$new_tables = array();
$alter_tables = array();
$new_rows = array();
$del_rows = array();

$new_tables['pdp_downloads'] = "(
	download_id smallint(5) unsigned NOT NULL auto_increment,
	cat_id smallint(5) unsigned NOT NULL default '0',
	license_id smallint(5) unsigned NOT NULL default '0',
	dl_name varchar(100) NOT NULL default '',
	dl_desc text NOT NULL,
	dl_abstract varchar(255) NOT NULL default '',
	dl_copyright varchar(200) NOT NULL default '',
	lizenz_okay char(1) NOT NULL default '',
	lizenz_packet char(1) NOT NULL default '',
	lizenz_url varchar(255) NOT NULL default '',
	dl_count int(10) NOT NULL default '0',
	user_id smallint(5) unsigned NOT NULL default '0',
	hide_user enum('yes', 'no') NOT NULL default 'no',
	dl_ctime int(10) unsigned NOT NULL default '0',
	dl_mtime int(10) unsigned NOT NULL default '0',
	dl_homepage varchar(255) NOT NULL default '',
	dl_status char(1) NOT NULL default 'N',

	down varchar(255) NOT NULL default '',
	link_extern varchar(255) NOT NULL default '',
	version varchar(20) NOT NULL default '',
	dl_size varchar(20) NOT NULL default '',
	dl_pic varchar(255) NOT NULL default '',

	dl_broken_count tinyint(1) unsigned NOT NULL default '0',

	count_comments int(10) unsigned NOT NULL default '0',
	count_votes int(10) unsigned NOT NULL default '0',
	count_visitors int(10) unsigned NOT NULL default '0',
	count_subscribers int(10) unsigned NOT NULL default '0',
	avg_vote float(3,2) unsigned NOT NULL default '0.00',

	max_pics tinyint(1) NOT NULL default '5',

	dir_files varchar(255) NOT NULL default '',

	PRIMARY KEY (download_id),
	KEY (cat_id),
	KEY (user_id),
	KEY (license_id)
) TYPE=MyISAM;";

$new_tables['pdp_cats'] = "(
	cat_id smallint(5) unsigned NOT NULL auto_increment,
	top_cat smallint(5) unsigned NOT NULL default '0',
	cat_name varchar(50) NOT NULL default '',
	cat_desc varchar(255) NOT NULL default '',
	cat_sorting varchar(50) NOT NULL default 'name ASC',
	cat_access tinyint(3) unsigned NOT NULL default '0',
	cat_upload_access tinyint(3) unsigned NOT NULL default '103',
	cat_download_access tinyint(3) unsigned NOT NULL default '0',
	cat_order smallint(5) unsigned NOT NULL default '0',
	count_downloads int(10) unsigned NOT NULL default '0',
	PRIMARY KEY (cat_id)
) TYPE=MyISAM;";

$new_tables['pdp_votes'] = "(
	download_id smallint(5) unsigned NOT NULL default '0',
	user_id smallint(5) unsigned NOT NULL default '0',
	vote_opt tinyint(1) unsigned NOT NULL default '0',
	PRIMARY KEY (download_id, user_id)
) TYPE=MyISAM;";

$new_tables['pdp_comments'] = "(
	comment_id int(10) unsigned NOT NULL auto_increment,
	download_id smallint(5) unsigned NOT NULL default '0',
	user_id smallint(5) unsigned NOT NULL default '0',
	comment_user_name varchar(50) NOT NULL default '',
	comment_text text NOT NULL,
	comment_timestamp int(10) unsigned NOT NULL default '0',
	comment_ip varchar(20) NOT NULL default '0.0.0.0',
	comment_smileys tinyint(1) unsigned NOT NULL default '1',
	PRIMARY KEY (comment_id),
	KEY (download_id)
) TYPE=MyISAM;";

$new_tables['pdp_licenses'] = "(
	license_id smallint(5) unsigned NOT NULL auto_increment,
	license_name varchar(100) NOT NULL default '',
	license_text text NOT NULL,
	PRIMARY KEY (license_id)
) TYPE=MyISAM;";

$new_tables['pdp_settings'] = "(
	id tinyint(1) unsigned NOT NULL auto_increment,
	title varchar(100) NOT NULL default '$inf_title',
	neupm smallint(5) unsigned NOT NULL default '1',
	defektpm smallint(5) unsigned NOT NULL default '1',
	image_ext varchar(200) NOT NULL default 'jpg,jpeg,gif,png',
	upload_image varchar(200) NOT NULL default 'infusions/pro_download_panel/images/',
	image_max int(12) unsigned NOT NULL default '1048576',
	file_ext varchar(200) NOT NULL default 'zip,rar,tar,exe,tar.gz',
	upload_file varchar(200) NOT NULL default 'infusions/pro_download_panel/downloads/',
	file_max int(12) unsigned NOT NULL default '2097152',
	downbereich tinyint(3) unsigned NOT NULL default '101',
	uploadbereich tinyint(3) unsigned NOT NULL default '103',
	kommentare tinyint(3) unsigned NOT NULL default '101',
	bewertungen tinyint(3) unsigned NOT NULL default '101',
	per_page tinyint(3) unsigned NOT NULL default '10',
	user_edit tinyint(1) unsigned NOT NULL default '0',
	hide_user_allow enum('yes', 'no') NOT NULL default 'no',
	version varchar(10) NOT NULL default '".$infusion['version']."',
	new_comm_pm tinyint(1) unsigned NOT NULL default '0',
	hide_cats tinyint(1) unsigned NOT NULL default '0',

	broken_text text NOT NULL,
	broken_count tinyint(1) unsigned NOT NULL default '0',
	broken_access tinyint(3) unsigned NOT NULL default '0',

	download_restricted text NOT NULL,

	new_days_long tinyint(1) unsigned NOT NULL default '0',
	pm_after_changes tinyint(1) unsigned NOT NULL default '5',
	do_log tinyint(1) unsigned NOT NULL default '1',
	theme varchar(50) NOT NULL default '',
	side_latest tinyint(1) unsigned NOT NULL default '5',
	side_top tinyint(1) unsigned NOT NULL default '5',
	mod_grp tinyint(3) unsigned NOT NULL default '103',
	need_verify enum('yes','no') NOT NULL default 'yes',
	image_max_w smallint(5) unsigned NOT NULL default '0',
	image_max_h smallint(5) unsigned NOT NULL default '0',
	image_scale enum('yes','no') NOT NULL default 'no',
	allow_notify enum('yes','no') NOT NULL default 'no',
	default_max_pics tinyint(1) NOT NULL default '5',

	PRIMARY KEY (id)
) TYPE=MyISAM;";

$new_tables['pdp_files'] = "(
	file_id int(10) unsigned NOT NULL auto_increment,
	download_id smallint(5) unsigned NOT NULL default '0',
	file_version varchar(20) NOT NULL default '',
	file_desc varchar(100) NOT NULL default '',
	file_url varchar(255) NOT NULL default '',
	file_size varchar(20) NOT NULL default '',
	file_timestamp int(10) unsigned NOT NULL default '0',
	file_status tinyint(1) unsigned NOT NULL default '0',
	download_count int(10) unsigned NOT NULL default '0',
	PRIMARY KEY (file_id),
	KEY (download_id)
) TYPE=MyISAM;";

$new_tables['pdp_log'] = "(
	log_id int(10) unsigned NOT NULL auto_increment,
	download_id smallint(5) unsigned NOT NULL default '0',
	user_id smallint(5) unsigned NOT NULL default '0',
	log_timestamp int(10) unsigned NOT NULL default '0',
	log_type tinyint(1) unsigned NOT NULL default '0',
	log_errno tinyint(1) unsigned NOT NULL default '0',
	PRIMARY KEY (log_id),
	KEY (download_id)
) TYPE=MyISAM;";

$new_tables['pdp_images'] = "(
	pic_id int(10) unsigned NOT NULL auto_increment,
	download_id smallint(5) unsigned NOT NULL default '0',
	pic_desc varchar(100) NOT NULL default '',
	pic_url varchar(255) NOT NULL default '',
	pic_status tinyint(1) unsigned NOT NULL default '0',
	PRIMARY KEY (pic_id),
	KEY (download_id)
) TYPE=MyISAM;";

$new_tables['pdp_notify'] = "(
	user_id smallint(5) unsigned NOT NULL default '0',
	download_id smallint(5) unsigned NOT NULL default '0',
	visited enum('yes', 'no') NOT NULL default 'yes',
	details tinyint unsigned NOT NULL default '0',
	PRIMARY KEY (user_id, download_id)
) TYPE=MyISAM;";


$new_rows[] = "pdp_settings
SET
id=1,
broken_text='".stripinput($locale['PDP143'])."',
download_restricted='".stripinput($locale['PDP407'])."'";


include('ff/pf_conv.php');


?>
