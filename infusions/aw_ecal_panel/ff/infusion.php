<?php
/***************************************************************************
 *   awEventCalendar                                                       *
 *                                                                         *
 *   Copyright (C) 2006-2008 Artur Wiebe                                   *
 *   wibix@gmx.de                                                          *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU General Public License as published by  *
 *   the Free Software Foundation; either version 2 of the License, or     *
 *   (at your option) any later version.                                   *
 ***************************************************************************/
if(!defined('IN_FUSION') || !checkrights('I')) {
	die;
}


$infusion = array(
	'title'		=> 'Event Calendar',
	'description'	=> 'Event Calendar',
	'version'	=> '0.8.1',
	'developer'	=> 'Artur Wiebe',
	'email'		=> 'wibix@gmx.de',
	'weburl'	=> 'http://wibix.de',
	'requires'	=> 'FF',
);

$admin_links = array();
$admin_links[] = array(
	'title'		=> $infusion['title'],
	'image'		=> '',
	'url'		=> 'admin.php',
	'rights'	=> 'AWEC',
);

$site_links = array();
$site_links[] = array(
	'title'		=> $infusion['title'],
	'image'		=> '',
	'url'		=> 'index.php',
	'visibility'	=> '0',
);


/* TABLE STUFF */
$new_tables = array();
$alter_tables = array();
$new_rows = array();
$del_rows = array();

$new_tables['aw_ec_events'] = "(
	ev_id int(10) unsigned NOT NULL auto_increment,
	user_id smallint(5) unsigned NOT NULL default '0',

	ev_title varchar(200) NOT NULL default '',
	ev_body text NOT NULL,
	ev_location varchar(100) NOT NULL default '',

ev_no_smileys tinyint(1) unsigned NOT NULL default '0',

	ctime int(11) NOT NULL default '0',
	mtime int(11) NOT NULL default '0',

	ev_start date NOT NULL default '0000-00-00',
	ev_end date NOT NULL default '0000-00-00',

	ev_start_time time default NULL,
	ev_end_time time default NULL,

	ev_repeat tinyint(1) unsigned NOT NULL default '0',
	ev_private tinyint(1) unsigned NOT NULL default '0',
	ev_status tinyint(1) unsigned NOT NULL default '0',

	ev_allow_logins tinyint(1) NOT NULL default '0',
	ev_max_logins smallint(5) unsigned NOT NULL default '0',
	ev_login_access tinyint(3) unsigned NOT NULL default '101',
	ev_login_limit tinyint(1) unsigned NOT NULL default '0',
	ev_login_start int(10) unsigned NOT NULL default '0',
	ev_login_end int(10) unsigned NOT NULL default '0',

	ev_access tinyint(3) unsigned NOT NULL default '0',

	admin_user_id smallint(5) unsigned NOT NULL default '1',

	PRIMARY KEY (ev_id),
	KEY (ev_start),
	KEY (ev_end)
) TYPE=MyISAM;";

$new_tables['awec_attachments'] = "(
	attach_id int(10) unsigned NOT NULL auto_increment,
	event_id int(10) unsigned NOT NULL default '0',

	filename varchar(100) NOT NULL default '',
	comment varchar(200) NOT NULL default '',

	PRIMARY KEY (attach_id)
) TYPE=MyISAM;";

$new_tables['aw_ec_cats'] = "(
	cat_id smallint(5) unsigned NOT NULL auto_increment,
	cat_name varchar(100) NOT NULL default '0',

	PRIMARY KEY (cat_id)
) TYPE=MyISAM;";

$new_tables['aw_ec_events_in_cats'] = "(
	cat_id smallint(5) unsigned NOT NULL default '0',
	event_id int(10) unsigned NOT NULL default '0',
	PRIMARY KEY (cat_id, event_id)
) TYPE=MyISAM;";

$new_tables['aw_ec_logins'] = "(
	ev_id int(10) unsigned NOT NULL default '0',
	user_id smallint(5) unsigned NOT NULL default '0',
	login_comment varchar(50) NOT NULL default '',
	login_status tinyint(1) unsigned NOT NULL default '0',
	login_timestamp int(10) unsigned NOT NULL default '0',
	PRIMARY KEY (ev_id, user_id)
) TYPE=MyISAM;";

$new_tables['aw_ec_settings'] = "(
	need_admin_ok tinyint(1) NOT NULL default '1',
	edit_group tinyint(3) unsigned NOT NULL default '103',
	post_group tinyint(3) unsigned NOT NULL default '101',
	user_can_edit tinyint(1) NOT NULL default '1',

	show_today_in_panel tinyint(1) unsigned NOT NULL default '0',
	show_birthday_to_group tinyint(3) unsigned NOT NULL default '0',
	birthdays_are_events tinyint(1) unsigned NOT NULL default '0',

	birthdate_fmt varchar(50) NOT NULL default '%d.%m.%Y',
	date_fmt varchar(50) NOT NULL default '%d.%m.%Y',
	sidedate_fmt varchar(50) NOT NULL default '%d.%m. ',
	time_fmt varchar(50) NOT NULL default '%H:%i',

	invite_pm tinyint(1) unsigned NOT NULL default '0',

	default_month_view enum('calendar','list') NOT NULL default 'calendar',
	default_calendar_view enum('week','month','year') NOT NULL default 'month',
	show_week tinyint(1) unsigned NOT NULL default '0',

	use_custom_css tinyint(1) unsigned NOT NULL default '0',
	use_alt_side_calendar tinyint(1) unsigned NOT NULL default '0',

	next_days_in_panel tinyint(1) NOT NULL default '0',
	sun_first_dow enum('yes', 'no') NOT NULL default 'no',

	version varchar(10) NOT NULL default '".$infusion['version']."'
) TYPE=MyISAM;";


$new_rows[] = "aw_ec_settings () VALUES ()";


?>
