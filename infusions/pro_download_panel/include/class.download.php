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
if(!defined('IN_FUSION')) {
	die();
}


class pdpDownload {
	var $id = 0;
	var $data = array();
	var $status = '';
	var $can_edit = false;
	var $can_download = false;

	function pdpDownload($id) {
		global $pdp, $userdata;

		if(!$id) {
			return;
		}

		// get download
		$res = dbquery("SELECT d.*, c.cat_access, fu.user_name,"
			." c.cat_download_access,"
			." IF(LENGTH(dl_desc), dl_desc, dl_abstract) AS description"
			." FROM ".DB_PDP_DOWNLOADS." AS d"
			." LEFT JOIN ".DB_PDP_CATS." AS c"
				." ON c.cat_id=d.cat_id"
			." LEFT JOIN ".DB_USERS." AS fu ON"
				." d.user_id=fu.user_id"
			." WHERE d.download_id='".$id."'"
			." LIMIT 1");
		if(dbrows($res)!=1) {
			fallback("index.php");
		}
		$data = dbarray($res);

		if(!checkgroup($data['cat_access'])) {
			return;
		}

		$this->id = $id;
		$this->data = $data;
		$this->status = $data['dl_status'];

		unset($this->data['dl_status']);

		// check what we can do
		$this->can_edit = (iPDP_ADMIN || iPDP_MOD
			|| (iMEMBER && $userdata['user_id']==$this->data['user_id']
			&& ($pdp->settings['user_edit']
				|| $this->status==PDP_PRO_NEW))
			&& $this->status!=PDP_PRO_DEL
			&& $this->status!=PDP_PRO_CHECK
		);

		$this->can_download = iPDP_ADMIN || iPDP_MOD
			|| checkgroup($data['cat_download_access']);
	}

	function log_event($event, $errno)
	{
		global $userdata, $pdp;

		if(!$this->id || !$pdp->settings['do_log']) {
			return false;
		}

		$ok = dbquery("INSERT INTO ".DB_PDP_LOG.""
			." SET"
			." download_id='".$this->id."',"
			." user_id='".$userdata['user_id']."',"
			." log_timestamp='".time()."',"
			." log_type='".$event."',"
			." log_errno='".$errno."'");

		if($pdp->settings['pm_after_changes']
			&& ((ff_db_count("(*)", DB_PDP_LOG,
				"(download_id='".$this->id."')")
			% $pdp->settings['pm_after_changes'])===0)) {
			$this->send_pm_mail($pdp->settings['neupm'], PDP_PM_CHANGES);
		}

		if($event==PDP_EV_NEWCOMMENT && $pdp->settings['new_comm_pm']) {
			$this->send_pm_mail($this->data['user_id'], PDP_PM_COMMENT);
		} elseif($event==PDP_EV_BROKEN && $pdp->settings['defektpm']) {
			$this->send_pm_mail($pdp->settings['defektpm'], PDP_PM_BROKEN);
		} elseif($event==PDP_EV_CHECK) {
			$this->send_pm_mail($pdp->settings['neupm'],
				PDP_PM_CHECK);
		} elseif($event==PDP_EV_PUBLISHED) {
			$this->send_pm_mail($this->data['user_id'],
				PDP_PM_ACCEPTED);
		} elseif($event==PDP_EV_NEWDOWNLOAD) {
			$this->send_pm_mail($pdp->settings['neupm'], PDP_PM_NEW);
		}

		return true;
	}


	function is_subscribing($user_id) {
		$res = dbquery("SELECT visited"
			." FROM ".DB_PDP_NOTIFY.""
			." WHERE user_id='".$user_id."'"
				." AND download_id='".$this->id."'"
			." LIMIT 1");
		if(!dbrows($res)) {
			return false;
		}
		$row = dbarray($res);
		if($row['visited']=='no') {
			$ok = dbquery("UPDATE ".DB_PDP_NOTIFY.""
				." SET visited='yes'"
				." WHERE download_id='".$this->id."'"
					." AND user_id='".$user_id."'");
		}
		return true;
	}


	function inform_subscribers() {
		global $pdp;

		if($pdp->settings['allow_notify']=="no" || !$this->id) {
			return false;
		}

		$res = dbquery("SELECT user_id"
			." FROM ".DB_PDP_NOTIFY.""
			." WHERE download_id='".$this->id."'"
				." AND visited!='no'"
				.($pdp->settings['new_comm_pm']
					? " AND user_id<>'".$this->data['user_id']."'"
					: ''
				));
		while($data = dbarray($res)) {
			$this->send_pm_mail($data['user_id'], PDP_PM_SUBSCRIBERS);
		}
		$ok = dbquery("UPDATE ".DB_PDP_NOTIFY."
			SET visited='no'
			WHERE download_id='".$this->id."' AND visited!='no'");

		return true;
	}

	function fallback_download() {
		fallback(INFUSIONS.'pro_download_panel/download.php?did='.$this->id);
	}


	function send_pm_mail($to_id, $pm_type) {
		global $locale, $userdata, $settings;

		if(!isset($locale['PDP902']['subject'][$pm_type])) {
			return false;
		}

		if(iMEMBER) {
			$from_id = $userdata['user_id'];
			/*
			$res = dbquery("SELECT user_name"
				." WHERE user_id='$from_id'");
			$from_name = array_shift(dbarray($res));
			*/
		} else {
			$from_id = 0;
		}
		if(!$to_id || $from_id==$to_id) {
			return true;
		}

		// get user
		$res = dbquery("SELECT user_name, user_email"
			." FROM ".DB_USERS.""
			." WHERE user_id='$to_id'");
		if(!dbrows($res)) {
			return false;
		}
		$data = dbarray($res);


		// collect
		$subject = stripinput($locale['PDP902']['subject'][$pm_type]);

		$body = stripinput($locale['PDP902']['body'][$pm_type]);
		$body .= "<br><br>";
		$body .= "[url=".$settings['siteurl']
			."infusions/pro_download_panel/download.php"
			."?did=".$this->id."]".$locale['PDP026']."[/url]";
		$body .= "<br><br>";
		$body .= "[b]".$locale['PDP051'].":[/b] ".USER_IP;

		// send pm
		$ok = dbquery("INSERT INTO ".DB_MESSAGES
			." SET message_to='$to_id',"
			." message_from='$from_id',"
			." message_subject='$subject',"
			." message_message='$body',"
			." message_smileys='Y',"
			." message_read='0',"
			." message_datestamp='".time()."'");


		// send mail
		require_once(INCLUDES."sendmail_include.php");
		$type = "plain";

		$body = $subject;
		$body .= "\n\n";
		$body .= stripinput($locale['PDP902']['body'][$pm_type]);
		$body .= "\n\n";
		$body .= $locale['PDP026'].": ".$settings['siteurl']
			."infusions/pro_download_panel/download.php"
			."?did=".$this->id;
		$body .= "\n\n";

		sendemail($data['user_name'], $data['user_email'],
			$settings['siteusername'],
			$settings['siteemail'],
			$subject, strip_tags(parseubb($body)), $type);

		return true;
	}

	function set_status($status) {
		if($status == $this->status) {
			return true;
		}

		$ok = dbquery("UPDATE ".DB_PDP_DOWNLOADS.""
			." SET dl_status='".$status."'"
			." WHERE download_id='".$this->id."'");

		if($this->status==PDP_PRO_ON || $status==PDP_PRO_ON) {
			$count = ff_db_count("(*)", DB_PDP_DOWNLOADS,
				"(cat_id='".$this->data['cat_id']."'"
					." AND dl_status='".PDP_PRO_ON."')");
			dbquery("UPDATE ".DB_PDP_CATS
				." SET"
				." count_downloads='".$count."'"
				." WHERE cat_id='".$this->data['cat_id']."'");
		}

		$this->status = $status;

		return $ok;
	}

}

?>
