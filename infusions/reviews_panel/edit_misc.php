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
if(!$review->can_edit) {
	$review->fallback_review();
}
require_once('include/edit.php');



/*
 * Action
 */
if(isset($_POST['do_hide_user']) && $prp->settings['hide_user_allow']=="yes") {
	$ok = dbquery("UPDATE ".DB_PRP_DOWNLOADS.""
		." SET"
		." hide_user='".(isset($_POST['hide_user']) ? "yes" : "no")."'"
		." WHERE review_id='".$review->id."'");
	if($ok) {
		fallback(FUSION_SELF."?did=".$review->id."&errno=0");
	}

} elseif(isset($_POST['del_review']) && isset($_POST['oh_yeah'])) {
	if($review->set_status(PRP_PRO_DEL)) {
		fallback(FUSION_SELF."?did=".$review->id);
	}

} elseif(isset($_POST['check_review'])) {
	$status = ($prp->settings['need_verify']=="yes" && !iPRP_MOD
		? PRP_PRO_CHECK
		: PRP_PRO_ON);
	$ok = $review->set_status($status);
	if($ok) {
		$review->log_event(PRP_EV_PUBLISHED, 0);
		if($status==PRP_PRO_ON) {
			dbquery("UPDATE ".DB_PRP_DOWNLOADS."
				SET
				dl_mtime='".time()."'
				WHERE review_id='".$review->id."'");
			$review->inform_subscribers();
			fallback('review.php?did='.$review->id);
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
		dbquery("UPDATE ".DB_PRP_DOWNLOADS.""
			." SET $field=''"
			." WHERE review_id='".$review->id."'");
	}
	fallback(FUSION_SELF."?did=".$review->id);
}


/*
 * GUI
 */
if($review->status==PRP_PRO_NEW) {
	prp_upload_step(4, "upload_done.php", $review->id);
}


opentable($locale['prp_misc']);
if(isset($_GET['errno'])) {
	prp_process_errno($_GET['errno']);
}

if($prp->settings['hide_user_allow']=="yes") {
	echo "<form method='post' action='".FUSION_SELF."?did=".$review->id."'>
<p>
	<input type='checkbox' name='hide_user' id='hu0'"
	.($review->data['hide_user']=="yes" ? " checked" : "")."> "
	."<label for='hu0'>".$locale['PRP501']."</label>
<p><input type='submit' class='button' name='do_hide_user'"
	." value='".$locale['PRP010']."'>
</form>\n";
}


/*
 * GUI
 */
if($review->status==PRP_PRO_OFF) {
	if($prp->settings['need_verify']=="yes" && !iPRP_MOD) {
		echo "<p><h2>".$locale['PRP502']."</h2>
<form method='post' action='".FUSION_SELF."?did=".$review->id."'>
<p><input type='checkbox' name='oh_yeah' id='oy1'><label for='oy1'>"
	.$locale['PRP503']."</label>
<p><input type='submit' class='button' name='check_review' value='".$locale['PRP504']."'>
</form>\n";
	} else {
		echo "<p><h2>".$locale['PRP505']."</h2>
<form method='post' action='".FUSION_SELF."?did=".$review->id."'>
<input type='hidden' name='oh_yeah' value='jip'>
<p><input type='submit' class='button' name='check_review'"
	." value='".$locale['PRP504']."'>
</form>\n";
	}
}


/*
 * GUI
 */
echo '
<h2>'.$locale['PRP880'].'</h2>
<form method="post" action="'.FUSION_SELF.'?did='.$review->id.'">
<p>
	<label><input type="checkbox" name="oh_yeah" /> '
		.$locale['PRP888'].'</label>
</p>
<p>
	<input type="submit" class="button" name="del_review"
		value="'.$locale['prp_delete'].'">
</p>
</form>';


/*
 * FIXME: COMPATIBILITY CODE
 */
if(!empty($review->data['down']) || !empty($review->data['link_extern'])
	|| !empty($review->data['version']) || !empty($review->data['dl_size'])
	|| !empty($review->data['dl_pic'])) {
	echo "<p><h2>".$locale['PRP027']."</h2>";
	echo "<p>".$locale['PRP123'];

	echo "<p><b>".$locale['PRP125'].":</b> ".$review->data['down'];
	if(!empty($review->data['down'])) {
		echo " [ <a href='".FUSION_SELF."?did=".$review->id."&clear=down'>"
			.$locale['PRP126']."</a> ]";
	}

	echo "<p><b>".$locale['PRP127'].":</b> ".$review->data['link_extern'];
	if(!empty($review->data['link_extern'])) {
		echo " [ <a href='".FUSION_SELF."?did=".$review->id."&clear=extern'>"
			.$locale['PRP126']."</a> ]";
	}

	echo "<p><b>".$locale['PRP018'].":</b> ".$review->data['version'];
	if(!empty($review->data['version'])) {
		echo " [ <a href='".FUSION_SELF."?did=".$review->id."&clear=version'>"
			.$locale['PRP126']."</a> ]";
	}

	echo "<p><b>".$locale['PRP029'].":</b> ".$review->data['dl_size'];
	if(!empty($review->data['dl_size'])) {
		echo " [ <a href='".FUSION_SELF."?did=".$review->id."&clear=size'>"
			.$locale['PRP126']."</a> ]";
	}

	echo "<p><b>".$locale['PRP028'].":</b> ".$review->data['dl_pic'];
	if(!empty($review->data['dl_pic'])) {
		echo " [ <a href='".FUSION_SELF."?did=".$review->id."&clear=pic'>"
			.$locale['PRP126']."</a> ]";
	}
	
}

closetable();


require_once('include/die.php');
?>
