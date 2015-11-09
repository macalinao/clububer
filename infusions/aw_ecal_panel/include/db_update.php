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
if(!defined('IN_FUSION') || !checkrights('IP')) {
	die;
}



/****************************************************************************
 * CHECK FOR FILE UPDATES
 */
$obsolete_files = array(
	'tooltips.js',
	'cross.js',
	'week.php',
	'browse.php',
);
$files_to_delete = array();
foreach($obsolete_files as $file) {
	if(file_exists($file)) {
		$files_to_delete[] = $file;
	}
}
if(count($files_to_delete)) {
	show_info($files_to_delete, 'warning', $locale['awec_pls_delete']);
}



/****************************************************************************
 * CHECK FOR DB UPDATES
 */
$mysql = array();


switch($awec_settings['version']) {
case "0.2.0":
case "0.3.0":
	$newver = "0.3.5";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."aw_ec_events
		ADD COLUMN ev_login_limit tinyint(1) unsigned NOT NULL default '0'";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."aw_ec_events
		CHANGE COLUMN ev_rep_year ev_repeat tinyint(1) unsigned NOT NULL default '0'";
	break;


case "0.3.5":
case "0.4.1":
	$newver = "0.3.7";
	// events table
	$mysql[] = "ALTER TABLE ".DB_PREFIX."aw_ec_events"
		." ADD COLUMN ev_show_time tinyint(1) unsigned NOT NULL default '0'";
	// settings table
	$mysql[] = "ALTER TABLE ".DB_PREFIX."aw_ec_settings"
		." ADD COLUMN birthday_date_format varchar(50) NOT NULL default '%d.%m.%Y'";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."aw_ec_settings"
		." ADD COLUMN ballon_w smallint(5) unsigned NOT NULL default '200'";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."aw_ec_settings"
		." ADD COLUMN ballon_fg char(7) NOT NULL default '#000000'";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."aw_ec_settings"
		." ADD COLUMN ballon_bg char(7) NOT NULL default '#ffcc00'";
	break;


case "0.3.7":
	$newver = "0.3.9";
	//
	$mysql[] = "ALTER TABLE ".DB_PREFIX."aw_ec_settings"
		." DROP PRIMARY KEY, DROP COLUMN set_id";
	break;


case "0.3.9":
	$newver = "0.5.0";
	break;

case "0.5.0":
case "0.5.1":
case "0.5.2":
	$newver = "0.5.3";
	//
	$mysql[] = "UPDATE ".DB_PREFIX."aw_ec_events SET ev_end=ev_start";
	break;

case "0.5.3":
case "0.5.4":
	$newver = "0.5.5";
	//
	@mysql_query("ALTER TABLE ".DB_PREFIX."aw_ec_events"
		." DROP COLUMN ev_login_access");
	$mysql[] = "ALTER TABLE ".DB_PREFIX."aw_ec_events"
		." ADD COLUMN ev_login_access tinyint(3) unsigned NOT NULL default '101'";
	break;

case "0.5.5":
	$newver = "0.5.6";
	//
	$mysql[] = "ALTER TABLE ".DB_PREFIX."aw_ec_settings"
		." CHANGE COLUMN birthday_date_format birthdate_fmt varchar(50) NOT NULL default '%d.%m.%Y'";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."aw_ec_settings"
		." ADD COLUMN date_fmt varchar(50) NOT NULL default '%d.%m.%Y'";
	break;

case "0.5.6":
	$newver = "0.5.7";
	break;

case "0.5.7":
	$newver = "0.5.8";
	//
	$mysql[] = "ALTER TABLE ".DB_PREFIX."aw_ec_settings"
		." ADD COLUMN next_days_in_panel tinyint(1) NOT NULL default '0'";
	break;

case "0.5.8":
	$newver = "0.5.9";
	//
	$mysql[] = "ALTER TABLE ".DB_PREFIX."aw_ec_settings"
		." ADD COLUMN sun_first_dow enum('yes', 'no') NOT NULL default 'no'";
	break;

case "0.5.9":
	$newver = "0.7.0";
	//
	$mysql[] = "ALTER TABLE ".DB_PREFIX."aw_ec_settings"
		." ADD COLUMN sidedate_fmt varchar(50) NOT NULL default '%d.%m. '";
	break;


case '0.7.0':
case '0.7.1':
case '0.7.2':
case '0.7.3':
case '0.7.4':
	$newver = '0.7.5';
	//
	$mysql[] = "ALTER TABLE ".DB_PREFIX."aw_ec_events
		ADD COLUMN ev_start_time time default NULL";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."aw_ec_events
		ADD COLUMN ev_end_time time default NULL";
	//
	$mysql[] = "UPDATE ".DB_PREFIX."aw_ec_events
		SET
		ev_start_time=TIME(ev_start)
		WHERE TIME(ev_start)<>'00:00:00'";
	$mysql[] = "UPDATE ".DB_PREFIX."aw_ec_events
		SET
		ev_end_time=TIME(ev_end)
		WHERE TIME(ev_end)<>'00:00:00'";
	//
	$mysql[] = "ALTER TABLE ".DB_PREFIX."aw_ec_settings
		ADD COLUMN time_fmt varchar(50) NOT NULL default '%H:%i'";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."aw_ec_settings
		ADD COLUMN invite_pm tinyint(1) unsigned NOT NULL default '0'";
	//
	$mysql[] = "ALTER TABLE ".DB_PREFIX."aw_ec_settings
		DROP COLUMN ballon_w";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."aw_ec_settings
		DROP COLUMN ballon_fg";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."aw_ec_settings
		DROP COLUMN ballon_bg";
	break;


case '0.7.5':
	$newver = '0.7.6';
	//
	$mysql[] = "ALTER TABLE ".DB_PREFIX."aw_ec_events
		CHANGE COLUMN ev_start ev_start date NOT NULL default '0000-00-00'";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."aw_ec_events
		CHANGE COLUMN ev_end ev_end date NOT NULL default '0000-00-00'";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."aw_ec_settings
		ADD COLUMN default_month_view enum('calendar','list') NOT NULL default 'calendar'";
/*!!!NO BREAK!!!*/
case '0.7.6':
	$newver = '0.7.7';
	//
	$mysql[] = "ALTER TABLE ".DB_PREFIX."aw_ec_settings
		ADD COLUMN use_custom_css tinyint(1) unsigned NOT NULL default '0'";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."aw_ec_settings
		ADD COLUMN use_alt_side_calendar tinyint(1) unsigned NOT NULL default '0'";
	//
/*!!!NO BREAK!!!*/
case '0.7.7':
	$newver = '0.7.8';
	//
	$mysql[] = "CREATE TABLE ".DB_PREFIX."aw_ec_cats (
	cat_id smallint(5) unsigned NOT NULL auto_increment,
	cat_name varchar(100) NOT NULL default '0',

	PRIMARY KEY (cat_id)
) TYPE=MyISAM;";
	$mysql[] = "CREATE TABLE ".DB_PREFIX."aw_ec_events_in_cats (
	cat_id smallint(5) unsigned NOT NULL default '0',
	event_id int(10) unsigned NOT NULL default '0',
	PRIMARY KEY (cat_id, event_id)
) TYPE=MyISAM;";
/*!!!NO BREAK!!!*/
case '0.7.8':
	$newver = '0.7.9';
	//
	$mysql[] = "ALTER TABLE ".DB_PREFIX."aw_ec_events
		DROP COLUMN ev_show_time";
	//
	$mysql[] = "CREATE TABLE ".DB_PREFIX."awec_attachments (
	attach_id int(10) unsigned NOT NULL auto_increment,
	event_id int(10) unsigned NOT NULL default '0',

	filename varchar(100) NOT NULL default '',
	comment varchar(200) NOT NULL default '',

	PRIMARY KEY (attach_id)
) TYPE=MyISAM;";
	//
	$mysql[] = "ALTER TABLE ".DB_PREFIX."aw_ec_settings
		DROP COLUMN show_birthday_in_panel";
	//
	$mysql[] = "ALTER TABLE ".DB_PREFIX."aw_ec_settings
		ADD COLUMN birthdays_are_events tinyint(1) unsigned NOT NULL default '0'";
	break;


case '0.7.9';
	$newver = '0.8.0';
	//
	$mysql[] = "ALTER TABLE ".DB_PREFIX."aw_ec_events
		ADD KEY (ev_start)";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."aw_ec_events
		ADD KEY (ev_end)";
	//
	$mysql[] = "UPDATE ".DB_PREFIX."aw_ec_events
		SET
		ev_end='0000-00-00'
		WHERE ev_repeat<>0 AND ev_start=ev_end";
	//
	$mysql[] = "ALTER TABLE ".DB_PREFIX."aw_ec_events
		CHANGE COLUMN ev_timestamp ctime int(11) NOT NULL default '0'";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."aw_ec_events
		CHANGE COLUMN user_id user_id smallint(5) unsigned NOT NULL default '0'";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."aw_ec_events
		ADD COLUMN mtime int(11) NOT NULL default '0'";
	$mysql[] = "UPDATE ".DB_PREFIX."aw_ec_events
		SET
		mtime=ctime";
	//
	$mysql[] = "UPDATE ".DB_PREFIX."aw_ec_events
		SET
		ev_body=REPLACE(ev_body,'---br---','<!--BREAK-->')";
	//
	$mysql[] = "ALTER TABLE ".DB_PREFIX."aw_ec_settings
		ADD COLUMN user_can_edit tinyint(1) NOT NULL default '1'";
	break;


case '0.8.0':
	$newver = '0.8.1';
	//
	$mysql[] = "ALTER TABLE ".AWEC_DB_EVENTS."
		ADD COLUMN ev_location varchar(100) NOT NULL default ''";
	$mysql[] = "ALTER TABLE ".AWEC_DB_SETTINGS."
		CHANGE COLUMN default_month_view default_month_view enum('calendar','list','clist') NOT NULL default 'calendar',
		ADD COLUMN default_calendar_view enum('week','month','year') NOT NULL default 'month',
		ADD COLUMN show_week tinyint(1) unsigned NOT NULL default '0'";
	// cleanup
	$mysql[] = "DELETE FROM ".AWEC_DB_EVENTS_IN_CATS."
		WHERE event_id=0";
	break;


case '0.8.1':
default:
	unset($newver);
	break;
}

if(!isset($newver)) {
	return;
}



/****************************************************************************
 * GUI
 */
$do_update = (isset($_GET['do_update']) && $_GET['do_update']==1);
if($do_update) {
	$errors = 0;
	$val = 0;
	$button = $locale['EC804'];
} else {
	$val = 1;
	$button = $locale['EC802'];
}


echo '
<p>
<strong>'.$locale['EC800'].': </strong>'
	.$awec_settings['version'].' -&gt; '.$newver;
echo '<p>'.$locale['EC801'].':
<div class="textbox" style="overflow:auto;">
<ul>';
foreach($mysql as $query) {
	if($do_update) {
		if(dbquery($query)) {
			$ok = '<span class="small2">'.$locale['EC805'].'</span>';
		} else {
			$ok = '<strong>'.$locale['EC806'].'</strong>';
			$errors++;
		}
	}
	echo '
	<li>
		<code>'.htmlentities($query).'</code>';
	if($do_update) {
		echo '
		<ul><li>'.$ok.'</li></ul>';
	}
	echo '
	</li>';
}
echo '
</ul>
</div>';

if($do_update) {
	if($errors) {
		echo '<p><strong>'.$locale['EC806'].':</strong> '.$errors.'</p>';
	} else {
		dbquery("UPDATE ".DB_PREFIX."aw_ec_settings"
			." SET version='".$newver."'");
	}

}

echo '
<form method="get" action="'.FUSION_SELF.'">
<input type="hidden" name="do_update" value="'.$val.'">
<input type="submit" class="button" value="'.$button.'">
</form>
<hr />';

?>
