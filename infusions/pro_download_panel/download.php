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
require_once('include/common.php');
require_once('include/theme_funcs.php');


if(isset($_GET['catid']) && isNum($_GET['catid'])) {
	$catid = $_GET['catid'];
} else {
	unset($catid);
}
if($download->id) {
	$catid = $download->data['cat_id'];
}


function pdp_count_dl($cats, $cat_id) {
	$count = $cats[$cat_id]['count_downloads'];

	foreach($cats as $new_cat_id => $data) {
		if($data['parentcat']==$cat_id
			&& checkgroup($data['access']))
		{
			$count += pdp_count_dl($cats, $new_cat_id);
		}
	}

	return $count;
}

function pdp_count_cats($cat) {
	global $pdp;

	$count = 0;
	$res = dbquery("SELECT cat_id, cat_access"
		." FROM ".DB_PDP_CATS.""
		." WHERE top_cat='".$cat."'");
	while($data = dbarray($res)) {
		if($pdp->settings['hide_cats']
			&& !checkgroup($data['cat_access'])) {
			continue;
		}
		$count += pdp_count_cats($data['cat_id']) + 1;
	}
	return $count;
}



/****************************************************************************
 * GUI
 */
if($download->id && $download->status==PDP_PRO_OFF) {
	show_info('<img src="icons/messagebox_info.png" alt="'.$locale['pdp_info'].'" style="float:left; padding-right:10px;" /> '.str_replace('%s', $download->id, $locale['PDP023']), 'info', true);
}



opentable($pdp->settings['title']);
pdp_menu();


/***************************************************************************
 *  CATS                                                                   *
 ***************************************************************************/
$access_group = NULL;
if(isset($catid)) {
	$all_cats = array();

	$res = dbquery("SELECT cat_name, top_cat, cat_id, cat_access,
		cat_sorting, cat_desc, count_downloads
		FROM ".DB_PDP_CATS."
		ORDER BY cat_order ASC");
	while($data = dbarray($res)) {
		$all_cats[$data['cat_id']] = array(
			'name'			=> $data['cat_name'],
			'parentcat'		=> $data['top_cat'],
			'access'		=> $data['cat_access'],
			'sorting'		=> $data['cat_sorting'],
			'desc'			=> $data['cat_desc'],
			'count_downloads'	=> $data['count_downloads'],
		);
	}
	if($catid && !isset($all_cats[$catid])) {
		fallback(FUSION_SELF.'?catid=0');
	}


	// get path to the cat
	$localid = $catid;
	$path = array();
	while($localid) {
		$topcat = $all_cats[$localid];
		if($localid==$catid) {
			$access_group = (checkgroup($topcat['access'])
				? NULL : $topcat['access']);
			$pdp_sorting = "dl_".$topcat['sorting'];
		}

		$path[] = array(
			'id'	=> $localid,
			'name'	=> $topcat['name'],
		);

		$localid = $topcat['parentcat'];
	}
	$path[] = array(
		'id'	=> 0,
		'name'	=> $locale['PDP820'],
	);
	$path = array_reverse($path);

	// get child cats in current cat
	$cats = array();

	if(!$download->id) {
		foreach($all_cats as $id => $data) {
			if($data['parentcat']!=$catid) {
				continue;
			}
			if(!checkgroup($data['access'])
				&& $pdp->settings['hide_cats']) {
				continue;
			}
			$cnt_cats = pdp_count_cats($id);
			$cnt_downs = pdp_count_dl($all_cats, $id);

			$cats[$id] = array(
				"name"		=> $data['name'],
				"cnt_downs"	=> $cnt_downs,
				"cnt_cats"	=> $cnt_cats,
				"desc"		=> parseubb($data['desc']),
			);
		}
	}

	pdp_render_cats($catid, $download->id, $path, $cats);
	unset($path, $cats);

	if(!is_null($access_group)) {
		if($pdp->settings['hide_cats']) {
			fallback("error.php?type=access");
		}
		show_info('<img src="icons/lock.png" alt="'.$locale['pdp_locked'].'" /> '.str_replace('%s', getgroupname($access_group),
				$locale['PDP215']));
	}
}

/***************************************************************************
 *  DOWNLOADS                                                              *
 ***************************************************************************/
if(is_null($access_group) && !$download->id && (!isset($catid) || $catid!=0)) {
	$rowstart = 0;
	if(isset($_GET['rowstart']) && isNum($_GET['rowstart'])) {
		$rowstart = $_GET['rowstart'];
	}

	$downs = array();
	if(isset($catid)) {
		$get = array(
			'type'	=> 'cat',
			'data'	=> $catid,
		);
	} else {
		$get = array(
			'type'	=> 'none',
		);
	}
	$count = pdpCore::get_downloads($get,
		$pdp_sorting, $rowstart, $pdp->settings['per_page'],
		false, $downs);

	$link = FUSION_SELF."?".(isset($catid) ? "catid=$catid&amp;" : "");

	pdp_render_downs($downs, $rowstart, $pdp->settings['per_page'],
		$count, $link);
	unset($downs);
}


if(is_null($access_group) && $download->id) {
	include('did.php');
} else {
	closetable();
}


require_once('include/die.php');
?>
