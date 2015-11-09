<?php
/***************************************************************************
 *   Professional Review System                                          *
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
if(!defined('IN_FUSION') || !iPRP_ADMIN) {
	die();
}


unset($new_ver);
$mysql = array();
$old_ver = "";
$set_tbl = "";

// version <= 1.4.7
if(empty($old_ver)) {
	$query_id = @mysql_query("SELECT version
		FROM ".DB_PREFIX."proreviews_settings
		WHERE id='1'");
	if($query_id && dbrows($query_id)) {
		$data = dbarray($query_id);
		if(isset($data['version']) && !empty($data['version'])) {
			$old_ver = $data['version'];
		}
	}
}
// version => 1.4.9
if(empty($old_ver)) {
	$query_id = @mysql_query("SELECT version"
		." FROM ".DB_PREFIX."prp_settings"
		." WHERE id='1'");
	if($query_id && dbrows($query_id)) {
		$data = dbarray($query_id);
		$old_ver = $data['version'];
	}
}

switch($old_ver) {
case "1.4.6":
	$new_ver = "1.4.7";
	$set_tbl = DB_PREFIX."proreviews_settings";

	$mysql[] = "ALTER TABLE ".DB_PREFIX."proreviews"
		." ADD COLUMN dl_size varchar(20) NOT NULL default ''";

	$mysql[] = "ALTER TABLE ".DB_PREFIX."proreviews_settings"
		." ADD COLUMN new_comm_pm tinyint(1) unsigned NOT NULL default '0'";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."proreviews_settings"
		." ADD COLUMN hide_cats tinyint(1) unsigned NOT NULL default '0'";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."proreviews_settings"
		." ADD COLUMN upload_file varchar(200) NOT NULL default ''";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."proreviews_settings"
		." ADD COLUMN upload_image varchar(200) NOT NULL default ''";
	break;


case "1.4.7":
	$new_ver = "1.4.9";
	$set_tbl = DB_PREFIX."prp_settings";

	// rename tables
	$mysql[] = "RENAME TABLE ".DB_PREFIX."proreviews"
                ." TO ".DB_PREFIX."prp_reviews";
	$mysql[] = "RENAME TABLE ".DB_PREFIX."proreview_cats"
                ." TO ".DB_PREFIX."prp_cats";
	$mysql[] = "RENAME TABLE ".DB_PREFIX."proreviews_bewertungen"
                ." TO ".DB_PREFIX."prp_votes";
	$mysql[] = "RENAME TABLE ".DB_PREFIX."proreviews_kommentare"
                ." TO ".DB_PREFIX."prp_comments";
	$mysql[] = "RENAME TABLE ".DB_PREFIX."proreviews_lizenz"
                ." TO ".DB_PREFIX."prp_licenses";
	$mysql[] = "RENAME TABLE ".DB_PREFIX."proreviews_settings"
                ." TO ".DB_PREFIX."prp_settings";
	$mysql[] = "RENAME TABLE ".DB_PREFIX."proreviews_files"
                ." TO ".DB_PREFIX."prp_files";

	// modify prp_reviews table
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_reviews"
		." CHANGE COLUMN datestamp dl_ctime int(10) unsigned NOT NULL default '0'";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_reviews"
		." CHANGE COLUMN name dl_name varchar(100) NOT NULL default ''";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_reviews"
		." CHANGE COLUMN beschreibung dl_desc text NOT NULL";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_reviews"
		." CHANGE COLUMN copyright dl_copyright varchar(200) NOT NULL default ''";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_reviews"
		." DROP PRIMARY KEY,"
		." CHANGE COLUMN id dl_id smallint(5) unsigned NOT NULL auto_increment,"
		." ADD PRIMARY KEY(dl_id)";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_reviews"
		." CHANGE COLUMN cat cat_id smallint(5) unsigned NOT NULL default '0'";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_reviews"
		." CHANGE COLUMN bild dl_pic varchar(255) NOT NULL default ''";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_reviews"
		." CHANGE COLUMN reviews dl_count int(10) NOT NULL default '0'";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_reviews"
		." CHANGE COLUMN homepage dl_homepage varchar(255) NOT NULL default ''";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_reviews"
		." CHANGE COLUMN status dl_status char(1) NOT NULL default 'N'";
	// add
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_reviews"
		." ADD COLUMN dl_mtime int(10) unsigned NOT NULL default '0'";

	// modify prp_cats
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_cats"
		." DROP PRIMARY KEY,"
		." CHANGE COLUMN cat cat_id smallint(5) unsigned NOT NULL auto_increment,"
		." ADD PRIMARY KEY(cat_id)";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_cats"
		." CHANGE COLUMN top_cat top_cat smallint(5) unsigned NOT NULL default '0'";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_cats"
		." CHANGE COLUMN name cat_name varchar(50) NOT NULL default ''";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_cats"
		." CHANGE COLUMN beschreibung cat_desc varchar(255) NOT NULL default ''";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_cats"
		." CHANGE COLUMN sorting cat_sorting varchar(50) NOT NULL default 'name ASC'";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_cats"
		." CHANGE COLUMN access cat_access tinyint(3) unsigned default '0'";

	// modify prp_votes
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_votes"
		." CHANGE COLUMN did dl_id smallint(5) unsigned NOT NULL default '0'";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_votes"
		." CHANGE COLUMN vote_opt vote_opt tinyint(1) NOT NULL default '0'";

	// modify prp_comments
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_comments"
		." DROP PRIMARY KEY,"
		." CHANGE COLUMN id comment_id int(10) unsigned NOT NULL auto_increment,"
		." ADD PRIMARY KEY(comment_id)";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_comments"
		." CHANGE COLUMN did dl_id smallint(5) unsigned NOT NULL default '0'";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_comments"
		." CHANGE COLUMN comment_name comment_user_name varchar(50) NOT NULL default ''";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_comments"
		." CHANGE COLUMN text comment_text text NOT NULL";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_comments"
		." CHANGE COLUMN datestamp comment_timestamp int(10) unsigned NOT NULL default '0'";

	// modify prp_licenses
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_licenses"
		." DROP PRIMARY KEY,"
		." CHANGE COLUMN id license_id smallint(5) unsigned NOT NULL auto_increment,"
		." ADD PRIMARY KEY(license_id)";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_licenses"
		." CHANGE COLUMN name license_name varchar(100) NOT NULL default ''";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_licenses"
		." CHANGE COLUMN text license_text text NOT NULL";

	// modify prp_settings
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_settings"
		." DROP COLUMN pmsystem";

	// modify prp_files
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_files"
		." CHANGE COLUMN did dl_id smallint(5) unsigned NOT NULL default '0'";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_files"
		." CHANGE COLUMN file_datestamp file_timestamp int(10) unsigned NOT NULL default '0'";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_files"
		." CHANGE COLUMN file_url file_url varchar(255) NOT NULL default ''";

//
	$new_ver = "1.5.1";
	$mysql[] = "UPDATE ".DB_PREFIX."prp_cats"
		." SET cat_sorting=REPLACE(cat_sorting, 'datestamp', 'mtime')";
	$mysql[] = "UPDATE ".DB_PREFIX."prp_cats"
		." SET cat_sorting=REPLACE(cat_sorting, 'reviews', 'count')";
	$mysql[] = "UPDATE ".DB_PREFIX."prp_reviews"
		." SET dl_mtime=dl_ctime";

//
	$new_ver = "1.5.3";
	// reviews table
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_reviews"
		." CHANGE COLUMN lizenz_id license_id smallint(5) unsigned NOT NULL default '0'";

	// settings table
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_settings"
		." DROP COLUMN uploadsaktivieren";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_settings"
		." CHANGE COLUMN bild image_ext varchar(200) NOT NULL default 'jpg,jpeg,gif,png'";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_settings"
		." CHANGE COLUMN down file_ext varchar(200) NOT NULL default 'zip,rar,tar,exe,tar.gz'";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_settings"
		." CHANGE COLUMN maxfilesize image_max int(12) unsigned NOT NULL default '1048576'";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_settings"
		." CHANGE COLUMN maxupfilesize file_max int(12) unsigned NOT NULL default '2097152'";

//
	$new_ver = "1.5.5";
	// reviews table
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_reviews"
		." ADD COLUMN dl_broken_count tinyint(1) unsigned NOT NULL default '0'";

	// settings table
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_settings"
		." CHANGE COLUMN titel title varchar(100) NOT NULL"
		." default '".addslash($locale['PRP000'])."'";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_settings"
		." ADD COLUMN broken_count tinyint(1) unsigned NOT NULL default '0'";

//
	$new_ver = "1.5.7";
	// settings table
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_settings"
		." ADD COLUMN broken_text text NOT NULL";
	$mysql[] = "UPDATE ".DB_PREFIX."prp_settings"
		." SET broken_text='".stripinput($locale['PRP143'])."'"
		." WHERE id='1'";

//
	$new_ver = "1.5.9";
	$mysql[] = "CREATE TABLE ".DB_PREFIX."prp_log ("
		."log_id int(10) unsigned NOT NULL auto_increment,"
		."dl_id smallint(5) unsigned NOT NULL default '0',"
		."user_id smallint(5) unsigned NOT NULL default '0',"
		."log_timestamp int(10) unsigned NOT NULL default '0',"
		."log_type tinyint(1) unsigned NOT NULL default '0',"
		."log_errno tinyint(1) unsigned NOT NULL default '0',"
		."PRIMARY KEY (log_id)"
		.") TYPE=MyISAM;";

//
	$new_ver = "1.6.1";
	$set_tbl = DB_PREFIX."prp_settings";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_settings"
		." ADD COLUMN pm_after_changes tinyint(1) unsigned NOT NULL default '5'";

//
	$new_ver = "1.6.3";
	$set_tbl = DB_PREFIX."prp_settings";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_settings"
		." ADD COLUMN do_log tinyint(1) unsigned NOT NULL default '1'";
	break;


case "1.6.3":
	$new_ver = "1.6.4";
	$set_tbl = DB_PREFIX."prp_settings";

	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_settings"
		." CHANGE COLUMN id id tinyint(1) unsigned NOT NULL auto_increment";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_settings"
		." ADD COLUMN broken_access tinyint(3) unsigned NOT NULL default '0'";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_settings"
		." ADD COLUMN new_days_long tinyint(1) unsigned NOT NULL default '0'";

	//
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_cats"
		." CHANGE COLUMN top_cat top_cat smallint(5) unsigned NOT NULL default '0'";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_cats"
		." CHANGE COLUMN top_cat top_cat smallint(5) unsigned NOT NULL default '0'";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_cats"
		." ADD COLUMN cat_upload_access tinyint(3) unsigned default '103'";

//
	$new_ver = "1.6.5";
	$set_tbl = DB_PREFIX."prp_settings";
	//
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_cats"
		." ADD COLUMN cat_order smallint(5) unsigned NOT NULL default '0'";

//
	$new_ver = "1.6.7";
	$set_tbl = DB_PREFIX."prp_settings";
	//
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_reviews"
		." ADD COLUMN hide_user enum('yes', 'no') NOT NULL default 'no'";

//
	$new_ver = "1.6.8";
	$set_tbl = DB_PREFIX."prp_settings";
	//
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_settings"
		." ADD COLUMN theme varchar(50) NOT NULL default ''";

//
	$new_ver = "1.6.9";
	$set_tbl = DB_PREFIX."prp_settings";
	//
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_settings"
		." ADD COLUMN hide_user_allow enum('yes', 'no') NOT NULL default 'no'";

//
	$new_ver = "1.7.0";
	$set_tbl = DB_PREFIX."prp_settings";
	break;


case "1.7.0":
	$new_ver = "1.7.1";
	$set_tbl = DB_PREFIX."prp_settings";
	//
	$mysql[] = "UPDATE ".DB_PREFIX."prp_reviews"
		." SET dl_desc=REPLACE(dl_desc, '---break---', '')";
	//
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_reviews"
		." ADD COLUMN dl_abstract varchar(255) NOT NULL default ''";

	break;


case "1.7.1":
	$new_ver = "1.7.2";
	$set_tbl = DB_PREFIX."prp_settings";
	//
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_settings"
		." ADD COLUMN side_latest tinyint(1) unsigned NOT NULL default '5'";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_settings"
		." ADD COLUMN side_top tinyint(1) unsigned NOT NULL default '5'";
	break;

case "1.7.2":
	$new_ver = "1.7.3";
	$set_tbl = DB_PREFIX."prp_settings";
	//
	$mysql[] = "CREATE TABLE ".DB_PREFIX."prp_images (
	pic_id int(10) unsigned NOT NULL auto_increment,
	dl_id smallint(5) unsigned NOT NULL default '0',
	pic_desc varchar(100) NOT NULL default '',
	pic_url varchar(255) NOT NULL default '',
	pic_status tinyint(1) unsigned NOT NULL default '0',
	PRIMARY KEY (pic_id)
) TYPE=MyISAM;";
	break;

case "1.7.3":
	$new_ver = "1.7.4";
	$set_tbl = DB_PREFIX."prp_settings";
	//
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_settings"
		." ADD COLUMN mod_grp tinyint(3) unsigned NOT NULL default '103'";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_settings"
		." ADD COLUMN need_verify enum('yes','no') NOT NULL default 'yes'";
	break;


case "1.7.4":
	$new_ver = "1.7.5";
	$set_tbl = DB_PREFIX."prp_settings";
	//
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_settings"
		." ADD COLUMN image_max_w smallint(5) unsigned NOT NULL default '0'";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_settings"
		." ADD COLUMN image_max_h smallint(5) unsigned NOT NULL default '0'";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_settings"
		." ADD COLUMN image_scale enum('yes','no') NOT NULL default 'no'";
	break;

case "1.7.5":
	$new_ver = "1.7.6";
	$set_tbl = DB_PREFIX."prp_settings";
	//
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_settings"
		." ADD COLUMN allow_notify enum('yes','no') NOT NULL default 'no'";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_settings"
		." DROP COLUMN show_down_desc";
	//
	$mysql[] = "CREATE TABLE ".DB_PREFIX."prp_notify (
	user_id smallint(5) unsigned NOT NULL default '0',
	dl_id smallint(5) unsigned NOT NULL default '0',
	visited enum('yes', 'no') NOT NULL default 'yes',
	details tinyint unsigned NOT NULL default '0',
	PRIMARY KEY (user_id, dl_id)
) TYPE=MyISAM;";
	break;


case "1.7.6":
	$new_ver = "1.7.7";
	$set_tbl = DB_PREFIX."prp_settings";
	//
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_reviews"
		." ADD COLUMN count_comments int(10) unsigned NOT NULL default '0'";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_reviews"
		." ADD COLUMN count_votes int(10) unsigned NOT NULL default '0'";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_reviews"
		." ADD COLUMN count_visitors int(10) unsigned NOT NULL default '0'";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_reviews"
		." ADD COLUMN count_subscribers int(10) unsigned NOT NULL default '0'";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_reviews"
		." ADD COLUMN avg_vote float(3,2) unsigned NOT NULL default '0.00'";
	// hui :)
	$query_id = dbquery("SELECT dl_id FROM ".DB_PREFIX."prp_reviews");
	while($data = dbarray($query_id)) {
		$comm_count = ff_db_count("(*)", "prp_comments",
			"(dl_id='".$data['dl_id']."')");
		$vote_count = ff_db_count("(*)", "prp_votes",
			"(dl_id='".$data['dl_id']."')");
		$subscribers = ff_db_count("(*)", "prp_notify",
			"(dl_id='".$data['dl_id']."')");
		if($comm_count || $vote_count || $subscribers) {
			$avg = prp_calc_avg_vote($data['dl_id']);
			$mysql[] = "UPDATE ".DB_PREFIX."prp_reviews"
				." SET"
				." count_comments='".$comm_count."',"
				." count_votes='".$vote_count."',"
				." count_subscribers='".$subscribers."',"
				." avg_vote='$avg'"
				." WHERE dl_id='".$data['dl_id']."'";
		}
	}
	break;


case "1.7.7":
	$new_ver = "1.7.8";
	$set_tbl = DB_PREFIX."prp_settings";
	//
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_cats"
		." ADD COLUMN count_reviews int(10) unsigned NOT NULL default '0'";
	$query_id = dbquery("SELECT cat_id"
		." FROM ".DB_PREFIX."prp_cats");
	while($data = dbarray($query_id)) {
		$count = ff_db_count("(*)", "prp_reviews",
			"(cat_id='".$data['cat_id']."'"
				." AND dl_status='".PRP_PRO_ON."')");
		$mysql[] = "UPDATE ".DB_PREFIX."prp_cats"
			." SET"
			." count_reviews='".$count."'"
			." WHERE cat_id='".$data['cat_id']."'";
	}
	break;


case "1.7.8":
	$new_ver = "1.7.9";
	$set_tbl = DB_PREFIX."prp_settings";
	//
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_settings"
		." ADD COLUMN default_max_pics tinyint(1) NOT NULL default '5'";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_reviews"
		." ADD COLUMN max_pics tinyint(1) NOT NULL default '5'";
	//
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_reviews"
		." DROP PRIMARY KEY,"
		." CHANGE COLUMN dl_id review_id smallint(5) unsigned NOT NULL auto_increment,"
		." ADD PRIMARY KEY(review_id)";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_votes"
		." DROP PRIMARY KEY,"
		." CHANGE COLUMN dl_id review_id smallint(5) unsigned NOT NULL auto_increment,"
		." ADD PRIMARY KEY(review_id, user_id)";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_comments"
		." CHANGE COLUMN dl_id review_id smallint(5) unsigned NOT NULL default '0'";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_files"
		." CHANGE COLUMN dl_id review_id smallint(5) unsigned NOT NULL default '0'";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_log"
		." CHANGE COLUMN dl_id review_id smallint(5) unsigned NOT NULL default '0'";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_images"
		." CHANGE COLUMN dl_id review_id smallint(5) unsigned NOT NULL default '0'";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_notify"
		." DROP PRIMARY KEY,"
		." CHANGE COLUMN dl_id review_id smallint(5) unsigned NOT NULL auto_increment,"
		." ADD PRIMARY KEY(review_id, user_id)";
	break;


case "1.7.9":
	$new_ver = "1.7.10";
	$set_tbl = DB_PREFIX."prp_settings";
	//
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_reviews"
		." ADD KEY (cat_id)";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_reviews"
		." ADD KEY (user_id)";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_reviews"
		." ADD KEY (license_id)";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_comments"
		." ADD KEY (review_id)";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_files"
		." ADD KEY (review_id)";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_log"
		." ADD KEY (review_id)";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_images"
		." ADD KEY (review_id)";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_notify"
		." ADD KEY (user_id, review_id)";
	// count comments
	$query_id = dbquery("SELECT dl_id FROM ".DB_PREFIX."prp_reviews");
	while($data = dbarray($query_id)) {
		$comm_count = ff_db_count("(*)", "prp_comments",
			"(dl_id='".$data['dl_id']."')");
		$avg = prp_calc_avg_vote($data['dl_id']);
		$mysql[] = "UPDATE ".DB_PREFIX."prp_reviews"
			." SET"
			." count_comments='".$comm_count."'"
			." WHERE dl_id='".$data['dl_id']."'";
	}
	break;


case '1.7.10':
	$new_ver = '1.8.0';
	$set_tbl = DB_PREFIX."prp_settings";
	//
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_cats
		ADD COLUMN cat_review_access tinyint(3) unsigned NOT NULL default '0'";
	$mysql[] = "UPDATE ".DB_PREFIX."prp_cats
		SET
		cat_review_access=cat_access";
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_settings
		ADD COLUMN review_restricted text NOT NULL";
	$mysql[] = "UPDATE ".DB_PREFIX."prp_settings
		SET
		review_restricted='".stripinput($locale['PRP407'])."'";
	/*!!!NO BREAK!!!*/

case '1.8.0':
	$new_ver = '1.8.1';
	$set_tbl = DB_PREFIX."prp_settings";
	//
	$mysql[] = "ALTER TABLE ".DB_PREFIX."prp_settings
		ADD COLUMN use_utf8_locales tinyint(1) unsigned NOT NULL default '0'";
	/*!!!MANDATORY BREAK!!!*/
	break;



case '1.8.1':
	$new_ver = '1.8.2';
	$set_tbl = DB_PRP_SETTINGS;
	//
	$mysql[] = "ALTER TABLE ".DB_PRP_FILES."
		ADD COLUMN review_count int(10) unsigned NOT NULL default '0'";
/*!!!NO BREAK!!!*/
case '1.8.2':
	$new_ver = '1.8.3';
	$set_tbl = DB_PRP_SETTINGS;
	//
	$mysql[] = "ALTER TABLE ".DB_PRP_SETTINGS."
		DROP COLUMN use_utf8_locales";
/*!!!NO BREAK!!!*/
case '1.8.3':
	$new_ver = '1.8.4';
	$set_tbl = DB_PRP_SETTINGS;
	//
	$mysql[] = "ALTER TABLE ".DB_PRP_DOWNLOADS."
		ADD COLUMN dir_files varchar(255) NOT NULL default ''";
	break;


case '1.8.4':
	unset($new_ver);
	break;


default:
	opentable($locale['PRP780']);
	echo $locale['PRP789'].': <strong>1.4.6</strong>';
	closetable();
	break;
}

if(!isset($new_ver)) {
	return;
}


/*
 * GUI
 */
opentable($locale['PRP780']);
echo '<p>
<strong>'.$locale['PRP781'].'</strong>: '.$old_ver.' -&gt; '.$new_ver.'
</p>';

echo "<p>".$locale['PRP782'];

echo "<p>".$locale['PRP783'];

$do_update = (isset($_GET['do_update']) && $_GET['do_update']==1);
if($do_update) {
	$errors = 0;
	$val = 0;
	$button = $locale['PRP045'];
	$res = '';
} else {
	$val = 1;
	$button = $locale['PRP784'];
}

echo '<p>'.$locale['PRP785'].':</p>
<hr /> 
<div class="textbox" style="overflow:auto;">
<ul>';
foreach($mysql as $query) {
	if($do_update) {
		if(dbquery($query)) {
			$res = $locale['PRP043'];
		} else {
			++$errors;
			$res = '<strong>'.$locale['PRP787'].'</strong>';
		}
	}
	echo '
	<li>
		<code>'.htmlentities($query).'</code>';
	if($do_update) {
		echo '
		<ul><li>'.$res.'</li></ul>';
	}
	echo '
	</li>';
}
echo '
</ul>
</div>';
if($do_update) {
	if($errors) {
		echo "<p><b>".$locale['PRP786'].":</b> $errors";
	} else {
		$ok = dbquery("UPDATE $set_tbl SET version='$new_ver'");
		echo '<p><strong>'.$locale['PRP790'].'</strong></p>';
	}
}

echo '
<hr />
<form method="get" action="'.FUSION_SELF.'">
<input type="hidden" name="do_update" value="'.$val.'">
<input type="submit" class="button" value="'.$button.'">
</form>';


closetable();

?>
