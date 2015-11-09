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
 *   Copyright (C) 2006-2007 Artur Wiebe                                   *
 *   wibix@gmx.de                                                          *
 *   http://wibix.de/                                                      *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU General Public License as published by  *
 *   the Free Software Foundation; either version 2 of the License, or     *
 *   (at your option) any later version.                                   *
 ***************************************************************************/
require_once('include/common.php');
if(!$download->can_edit) {
	$download->fallback_download();
}
require_once('include/edit.php');



/*
 * Action
 */
if(isset($_POST['do_hide_user']) && $pdp->settings['hide_user_allow']=="yes") {
	$ok = dbquery("UPDATE ".DB_PDP_DOWNLOADS.""
		." SET"
		." hide_user='".(isset($_POST['hide_user']) ? "yes" : "no")."'"
		." WHERE download_id='".$download->id."'");
	if($ok) {
		fallback(FUSION_SELF."?did=".$download->id."&errno=0");
	}

} elseif(isset($_POST['del_download']) && isset($_POST['oh_yeah'])) {
	if($download->set_status(PDP_PRO_DEL)) {
		fallback(FUSION_SELF."?did=".$download->id);
	}

} elseif(isset($_POST['check_download'])) {
	$status = ($pdp->settings['need_verify']=="yes" && !iPDP_MOD
		? PDP_PRO_CHECK
		: PDP_PRO_ON);
	$ok = $download->set_status($status);
	if($ok) {
		$download->log_event(PDP_EV_PUBLISHED, 0);
		if($status==PDP_PRO_ON) {
			dbquery("UPDATE ".DB_PDP_DOWNLOADS."
				SET
				dl_mtime='".time()."'
				WHERE download_id='".$download->id."'");
			$download->inform_subscribers();
			fallback('download.php?did='.$download->id);
		} else {
			fallback('profile.php?id='.$userdata['user_id']);
		}
	}

// COMPATIBILITY
} elseif(isset($_GET['clear'])) { //FIXME
	$field = "";
	switch($_GET['clear']) {
	case "down":	$field = "down";	break;
	case "extern":	$field = "link_extern";	break;
	case "version":	$field = "version";	break;
	case "size":	$field = "dl_size";	break;
	case "pic":	$field = "dl_pic";	break;
	}
	if(!empty($field)) {
		dbquery("UPDATE ".DB_PDP_DOWNLOADS.""
			." SET $field=''"
			." WHERE download_id='".$download->id."'");
	}
	fallback(FUSION_SELF."?did=".$download->id);
}


/*
 * GUI
 */
if($download->status==PDP_PRO_NEW) {
	pdp_upload_step(4, "upload_done.php", $download->id);
}


opentable($locale['pdp_misc']);
if(isset($_GET['errno'])) {
	pdp_process_errno($_GET['errno']);
}

if($pdp->settings['hide_user_allow']=="yes") {
	echo "<form method='post' action='".FUSION_SELF."?did=".$download->id."'>
<p>
	<input type='checkbox' name='hide_user' id='hu0'"
	.($download->data['hide_user']=="yes" ? " checked" : "")."> "
	."<label for='hu0'>".$locale['PDP501']."</label>
<p><input type='submit' class='button' name='do_hide_user'"
	." value='".$locale['PDP010']."'>
</form>\n";
}


/*
 * GUI
 */
if($download->status==PDP_PRO_OFF) {
	if($pdp->settings['need_verify']=="yes" && !iPDP_MOD) {
		echo "<p><h2>".$locale['PDP502']."</h2>
<form method='post' action='".FUSION_SELF."?did=".$download->id."'>
<p><input type='checkbox' name='oh_yeah' id='oy1'><label for='oy1'>"
	.$locale['PDP503']."</label>
<p><input type='submit' class='button' name='check_download' value='".$locale['PDP504']."'>
</form>\n";
	} else {
		echo "<p><h2>".$locale['PDP505']."</h2>
<form method='post' action='".FUSION_SELF."?did=".$download->id."'>
<input type='hidden' name='oh_yeah' value='jip'>
<p><input type='submit' class='button' name='check_download'"
	." value='".$locale['PDP504']."'>
</form>\n";
	}
}


/*
 * GUI
 */
echo '
<h2>'.$locale['PDP880'].'</h2>
<form method="post" action="'.FUSION_SELF.'?did='.$download->id.'">
<p>
	<label><input type="checkbox" name="oh_yeah" /> '
		.$locale['PDP888'].'</label>
</p>
<p>
	<input type="submit" class="button" name="del_download"
		value="'.$locale['pdp_delete'].'">
</p>
</form>';


/*
 * FIXME: COMPATIBILITY CODE
 */
if(!empty($download->data['down']) || !empty($download->data['link_extern'])
	|| !empty($download->data['version']) || !empty($download->data['dl_size'])
	|| !empty($download->data['dl_pic'])) {
	echo "<p><h2>".$locale['PDP027']."</h2>";
	echo "<p>".$locale['PDP123'];

	echo "<p><b>".$locale['PDP125'].":</b> ".$download->data['down'];
	if(!empty($download->data['down'])) {
		echo " [ <a href='".FUSION_SELF."?did=".$download->id."&clear=down'>"
			.$locale['PDP126']."</a> ]";
	}

	echo "<p><b>".$locale['PDP127'].":</b> ".$download->data['link_extern'];
	if(!empty($download->data['link_extern'])) {
		echo " [ <a href='".FUSION_SELF."?did=".$download->id."&clear=extern'>"
			.$locale['PDP126']."</a> ]";
	}

	echo "<p><b>".$locale['PDP018'].":</b> ".$download->data['version'];
	if(!empty($download->data['version'])) {
		echo " [ <a href='".FUSION_SELF."?did=".$download->id."&clear=version'>"
			.$locale['PDP126']."</a> ]";
	}

	echo "<p><b>".$locale['PDP029'].":</b> ".$download->data['dl_size'];
	if(!empty($download->data['dl_size'])) {
		echo " [ <a href='".FUSION_SELF."?did=".$download->id."&clear=size'>"
			.$locale['PDP126']."</a> ]";
	}

	echo "<p><b>".$locale['PDP028'].":</b> ".$download->data['dl_pic'];
	if(!empty($download->data['dl_pic'])) {
		echo " [ <a href='".FUSION_SELF."?did=".$download->id."&clear=pic'>"
			.$locale['PDP126']."</a> ]";
	}
	
}

closetable();


require_once('include/die.php');
?>
