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
require_once('../../../maincore.php');
require_once('common.php');


if(!$download->id) {
	fallback("download.php");
}


$href = "../download.php?did=".$download->id;
$errors = 0;

$do_calc_avg = false;
$do_calc_comments = false;
$do_calc_subscribers = false;


if(isset($_POST['do_vote']) && iUSER >= $pdp->settings['bewertungen']) {
	$do_calc_avg = true;
	$ok = dbquery("INSERT INTO ".DB_PDP_VOTES."
		SET
		download_id='".$download->id."',
		user_id='".$userdata['user_id']."',
		vote_opt='".intval($_POST['vote'])."'");

} elseif(isset($_POST['del_vote']) && iUSER >= $pdp->settings['bewertungen']) {
	$do_calc_avg = true;
	$ok = dbquery("DELETE FROM ".DB_PDP_VOTES."
		WHERE download_id='".$download->id."'
			AND user_id='".$userdata['user_id']."'");

} elseif(isset($_POST['add_comment']) && iUSER >= $pdp->settings['kommentare']) {
	$do_calc_comments = true;

	$c_text = trim(stripinput(censorwords($_POST['comm_text'])));
	if(empty($c_text)) {
		$download->fallback_download();
	}

	$c_smileys = (isset($_POST['disable_smileys']) ? "0" : "1");
	if(iMEMBER) {
		$c_user = $userdata['user_id'];
		$c_name = $userdata['user_name'];
	} else {
		$c_user = "0";
		$c_name = trim(stripinput($_POST['comment_name']));
		if(!check_captcha($_POST['captcha_encode'], $_POST['user_code'])) {
			fallback($href."&comm_user=".urlencode($c_name)
				."&comm_text=".urlencode($c_text)
				."&comm_smileys=".$c_smileys
				.'&wrong_captcha=1'
				.'#new_comment');
		}
	}
	$ok = dbquery("INSERT INTO ".DB_PDP_COMMENTS."
		SET
		download_id='".$download->id."',
		user_id='".$c_user."',
		comment_user_name='".$c_name."',
		comment_text='".$c_text."',
		comment_timestamp='".time()."',
		comment_ip='".USER_IP."',
		comment_smileys='".$c_smileys."'");
	$comment_id = mysql_insert_id();

	$download->log_event(PDP_EV_NEWCOMMENT, 0);
	$href .= "#comm".$comment_id;

} elseif(isset($_POST['delete_comments']) && iPDP_MOD) {
	$do_calc_comments = true;

	if(!isset($_POST['comment'])) {
		fallback(FUSION_SELF."?did=".$download->id);
	}
	$errors = 0;
	foreach($_POST['comment'] as $id => $val) {
		if(!dbquery("DELETE FROM ".DB_PDP_COMMENTS
			." WHERE comment_id='".$id."'"
				." AND download_id='".$download->id."'")) {
			++$errors;
		}
	}

} elseif(isset($_GET['subscibe']) && $pdp->settings['allow_notify'] && iMEMBER){
	$do_calc_subscribers = true;

	if($_GET['subscibe']=="1") {
		$ok = dbquery("INSERT INTO ".DB_PDP_NOTIFY.""
			." SET"
			." user_id='".$userdata['user_id']."',"
			." download_id='".$download->id."',"
			." visited='yes',"
			." details='0'");
	} else {
		$ok = dbquery("DELETE FROM ".DB_PDP_NOTIFY.""
			." WHERE user_id='".$userdata['user_id']."'"
				." AND download_id='".$download->id."'");
	}
	$download->log_event(PDP_EV_SUBSCRIBE, 0);
}


if($do_calc_avg) {
	$ok = dbquery("UPDATE ".DB_PDP_DOWNLOADS."
		SET
		avg_vote='".pdp_calc_avg_vote($download->id)."',
		count_votes='".ff_db_count("(*)", DB_PDP_VOTES,
			"(download_id='".$download->id."')")."'
		WHERE download_id='".$download->id."'");
} elseif($do_calc_comments) {
	$ok = dbquery("UPDATE ".DB_PDP_DOWNLOADS."
		SET
		count_comments='".ff_db_count("(*)", DB_PDP_COMMENTS,
			"(download_id='".$download->id."')")."'
		WHERE download_id='".$download->id."'");
} elseif($do_calc_subscribers) {
	$ok = dbquery("UPDATE ".DB_PDP_DOWNLOADS."
		SET
		count_subscribers='".ff_db_count("(*)", DB_PDP_NOTIFY,
			"(download_id='".$download->id."')")."'
		WHERE download_id='".$download->id."'");
}

if($errors==0) {
	fallback($href);
}

?>
