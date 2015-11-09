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
if(!defined('IN_FUSION')) {
	die;
}



if(!defined('FUSION_VERSION')) {
	if(defined('IN_FF')) {
		define('FUSION_VERSION', 'FF');
	} else {
		$ver_numbers = explode('.', $settings['version']);
		$main_ver = intval(array_shift($ver_numbers));
		define('FUSION_VERSION', $main_ver);
	}
}
define('DB_PRP_DOWNLOADS',	DB_PREFIX.'prp_reviews');
define('DB_PRP_CATS',		DB_PREFIX.'prp_cats');
define('DB_PRP_LICENSES',	DB_PREFIX.'prp_licenses');
define('DB_PRP_FILES',		DB_PREFIX.'prp_files');
define('DB_PRP_LOG',		DB_PREFIX.'prp_log');
define('DB_PRP_NOTIFY',		DB_PREFIX.'prp_notify');
define('DB_PRP_IMAGES',		DB_PREFIX.'prp_images');
define('DB_PRP_VOTES',		DB_PREFIX.'prp_votes');
define('DB_PRP_COMMENTS',	DB_PREFIX.'prp_comments');
define('DB_PRP_SETTINGS',	DB_PREFIX.'prp_settings');
if(!defined('DB_USERS')) {
	define('DB_USERS',		DB_PREFIX.'users');
}
if(!defined('DB_MESSAGES')) {
	define('DB_MESSAGES',		DB_PREFIX.'messages');
}



define('PRP_PRO_ON',	'Y');	// Y(es)	= online
define('PRP_PRO_OFF',	'N');	// N(o)		= offline
define('PRP_PRO_NEW',	'S');	// S(tep)	= in new-review-wizzard
define('PRP_PRO_DEL',	'D');	// D(elete)	= to delete
define('PRP_PRO_CHECK',	'C');	// C(heck)	= needs to be checked by admin.


define('PRP_PM_COMMENT',	1);
define('PRP_PM_NEW',		2);
define('PRP_PM_BROKEN',		3);
define('PRP_PM_CHANGES',	4);
define('PRP_PM_CHECK',		5);
define('PRP_PM_ACCEPTED',	6);
define('PRP_PM_SUBSCRIBERS',	7);


define('PRP_EV_INVALID',	0);
define('PRP_EV_NEW',		1);
define('PRP_EV_DESC',		2);
define('PRP_EV_FILEFTP',	3);
define('PRP_EV_FILEURL',	4);
define('PRP_EV_FILEUPLOAD',	5);
define('PRP_EV_DELFILE',	6);
define('PRP_EV_DELPIC',		7);
define('PRP_EV_PICUPLOAD',	8);
define('PRP_EV_PICFTP',		9);
define('PRP_EV_STATUS',		10);
define('PRP_EV_CHEAT',		11);
define('PRP_EV_CLEARLOG',	12);
define('PRP_EV_RESETBROKEN',	13);
define('PRP_EV_PICDESC',	14);
define('PRP_EV_PICURL',		15);
define('PRP_EV_PICSIZE',	16);
define('PRP_EV_SUBSCRIBE',	17);
define('PRP_EV_NEWCOMMENT',	18);
define('PRP_EV_BROKEN',		19);
define('PRP_EV_NEWDOWNLOAD',	20);
define('PRP_EV_CHECK',		21);
define('PRP_EV_PUBLISHED',	22);
define('PRP_EV_RESETVISITORS',	23);





class prpCore {
	var $settings = array();

	function prpCore() {
		$res = @mysql_query("SELECT *"
			." FROM ".DB_PRP_SETTINGS.""
			." WHERE id='1'");
		if($res && dbrows($res)) {
			$this->settings = dbarray($res);
		} else {
			$this->settings = array(
				'version'	=> '--update--',//FIXME
				'uploadbereich'	=> '103',
				'user_edit'	=> '0',
				'mod_grp'	=> '103',
				'need_verify'	=> 'yes',
				'downbereich'	=> '103',
				'defektpm'	=> '103',
				'broken_access'	=> '103',
			);
		}

		if(!isset($this->settings['upload_file'])
			|| empty($this->settings['upload_file'])) {
			$this->settings['upload_file'] = "infusions/reviews_panel/reviews/";
		}
		if(!isset($this->settings['upload_image'])
			|| empty($this->settings['upload_image'])) {
			$this->settings['upload_image'] = "infusions/reviews_panel/images/";
		}

		$this->settings['upload_file'] = BASEDIR.$this->settings['upload_file'];
		$this->settings['upload_image']= BASEDIR.$this->settings['upload_image'];
	}


	/*
	 * $get = array(
	 *   'type' => 'none' or 'cat' or 'desc' or 'user',
	 *   'data' => $cat_id or $stext,
	 * );
	 * return value: number of reviews matching criteria
	 */
	function get_reviews($get, $sorting, $rowstart, $limit,
		$simple_results, &$ret_downs, $need_all_count=true)
	{
		global $userdata, $prp;

		$ret_downs = array();
		$where = array();

		/* see original code below */
		$where[] = "dl_status='".PRP_PRO_ON."'";
		if(empty($catid)) {
			$where[] = groupaccess('cat_access');
		}
	/*FIXME
		if(iPRP_ADMIN) {
			;
		} elseif(iMEMBER) {
			$where[] = "dl_status='".PRP_PRO_ON."'";
	//		$where[] = "dl_status!='".PRP_PRO_DEL."'";
	//		$where[] = "dl_status!='".PRP_PRO_CHECK."'";
			$where[] = "(dl_status!='".PRP_PRO_OFF."'"
				." OR dl.user_id='".$userdata['user_id']."')";
			if(empty($catid)) {
				$where[] = groupaccess("cat_access");
			}
		} else {
			$where[] = "dl_status='".PRP_PRO_ON."'";
			if(empty($catid)) {
				$where[] = groupaccess("cat_access");
			}
		}
	*/

		switch($get['type']) {
		case 'cat':
			$where[] = "dl.cat_id='".$get['data']."'";
			break;
		case 'desc':
			$stext = mysql_real_escape_string($get['data']);
			$where[] = "(dl_name LIKE '%".$stext."%' OR dl_desc LIKE '%".$stext."%' OR dl_abstract LIKE '%".$stext."%')";
			break;
		case 'user':
			$stext = mysql_real_escape_string($get['data']);
			$where[] = "user_name LIKE '%".mysql_real_escape_string($get['data'])."%'";
			break;
		default:
			break;
		}

		if(count($where)) {
			$where = "WHERE ".implode(' AND ', $where);
		} else {
			$where = "";
		}

		$query = "SELECT";
		if($need_all_count) {
			$query .= " SQL_CALC_FOUND_ROWS";
		}
		$query .= " dl.review_id AS id,
			dl_name AS name,
			dl_count AS reviews,
			dl.user_id,"
			." hide_user, fu.user_name,
			count_votes AS votes,
			count_comments AS comments, count_visitors, avg_vote";
		if(!$simple_results) {
			$query .= ",
			version,
			dl.cat_id,
			dl_status AS status,
			dl_ctime, dl_pic, dl_mtime AS mtime,
			dl_desc AS `desc`,
			dl_abstract,
			IF(LENGTH(dl_abstract), dl_abstract, dl_desc) AS tmp_desc";
		}
		$query .= " FROM ".DB_PRP_DOWNLOADS." AS dl"
			." LEFT JOIN ".DB_USERS." AS fu"
				." ON fu.user_id=dl.user_id"
			." LEFT JOIN ".DB_PRP_CATS." AS c"
				." ON dl.cat_id=c.cat_id"
			." ".$where
			." ORDER BY dl.".$sorting;
		if($limit) {
			$query .= " LIMIT $rowstart, $limit";
		}
		$res = dbquery($query);
		if($need_all_count) {
//FIXME			$all_rows = array_shift(dbarray(dbquery("SELECT FOUND_ROWS() AS cnt")));
			$cnt_res = dbquery("SELECT FOUND_ROWS() AS cnt");
			$row = dbarray($cnt_res);
			$all_rows = $row['cnt'];
		} else {
			$all_rows = 0;
		}

		// show
		while($row = dbarray($res)) {
/*
			$down = array(
				'id'		=> $data['review_id'],
				'name'		=> $data['dl_name'],
				'count'		=> $data['dl_count'],
			);
*/
			if(!$simple_results) {
				$row['href']	= 'review.php?did='.$row['id'];
				$row['desc']	= parseubb($row['tmp_desc']);
/*
				$down['pic']	= $data['dl_pic'];
				$down['long_desc']	= parseubb($data['dl_desc']);
				$down['short_desc']	= parseubb($data['dl_abstract']);
				$down['mtime']	= $data['dl_mtime'];//rename->mdate?
				$down['ctime']	= $data['dl_ctime'];
				$down['reviews']= $data['dl_count'];
				$down['cat_id']	= $data['cat_id'];
				$down['comments'] = $data['count_comments'];
				$down['votes'] = $data['count_votes'];
				$down['visitors'] = $data['count_visitors'];
				$down['avg_vote'] = $data['avg_vote'];
*/
				$row['is_new']	= ($row['mtime']
					> (time()-$prp->settings['new_days_long']*3600*24));
			}
			if($prp->settings['hide_user_allow']=='yes'
				&& $row['hide_user']=='yes' && !iPRP_ADMIN
				&& (!iMEMBER || $userdata['user_id']!=$row['user_id'])) {
				$row['user_id'] = 0;
			} else {
				$row['user_id'] = $row['user_id'];
				$row['user_name'] = $row['user_name'];
			}
			$ret_downs[] = $row;
		}

		return $all_rows;
	}


	function format_number($number) {
		static $fmt = false;
		if($fmt===false) {
			$fmt = localeconv();
		}
		return number_format($number, 0, $fmt['decimal_point'],
			$fmt['thousands_sep']);
	}



};
global $prp;
$prp = new prpCore();


$prp_sorting = 'dl_name ASC';//FIXME
$prp_sorting = 'dl_ctime DESC';
$prp_sorting = 'dl_mtime DESC';

define('iPRP_ADMIN',	checkrights("IP"));
define('iPRP_MOD',	iPRP_ADMIN || checkgroup($prp->settings['mod_grp']));
define('iPRP_CAN_VIEW', checkgroup($prp->settings['downbereich']));
define('iPRP_BROKEN',	$prp->settings['defektpm']
	&& checkgroup($prp->settings['broken_access']));



/****************************************************************************
 * LOAD LOCALES
 */
if(file_exists(INFUSIONS.'reviews_panel/locale/'.$settings['locale'].'.php')) {
	include(INFUSIONS.'reviews_panel/locale/'.$settings['locale'].'.php');
} else {
	include(INFUSIONS.'reviews_panel/locale/English.php');
}


if(!function_exists('fallback')) {
function fallback($href)
{
	redirect($href);
}
}


// php-fusion 6.1.15
if(!function_exists('ff_db_count')) {
function ff_db_count($field, $table, $cond='') {
	if($cond) {
		$cond = " WHERE ".$cond;
	}

	$res = @mysql_query("SELECT COUNT".$field."
		FROM ".$table.$cond);
	if(!$res) {
		return false;
	} else {
		$rows = mysql_result($res, 0);
		return $rows;
	}
}
}

?>
