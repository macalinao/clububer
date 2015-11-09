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
require_once('include/common.php');
if(!iPRP_MOD) {
	fallback('review.php');
}
if(!$review->id) {
	fallback('review.php');
}
require_once('include/edit.php');


/*
 * GET
 */
// get latest timestamp
$query_id = dbquery("SELECT log_timestamp
	FROM ".DB_PRP_LOG."
	WHERE review_id='".$review->id."'
	ORDER BY log_timestamp DESC LIMIT 1");
if(dbrows($query_id)) {
	$last_updated = dbarray($query_id);
	$last_updated = array_shift($last_updated);
} else {
	$last_updated = 0;
}



// get all sub-dirs in the upload directory
$upload_file_dirs = array();
if(!empty($prp->settings['upload_file'])) {
	$path = $prp->settings['upload_file'];
	$handle = opendir($path);
	while(false !== ($dir=readdir($handle))) {
		if(substr($dir, 0, 1)=='.' || !is_dir($path.$dir)) {
			continue;
		}

		$upload_file_dirs[] = $dir.'/';
	}
	closedir($handle);
}


/****************************************************************************
 * ACTION
 */
if(isset($_POST['set_status'])) {
	if($last_updated > $_POST['last_updated']) {
		fallback(FUSION_SELF.'?did='.$review->id.'&errno='.PRP_EUPDATED);
	}

	$status = stripinput($_POST['value']);
	if(!isset($locale['PRP904'])) {
		fallback(FUSION_SELF."?did=".$review->id);
	}

	$ok = $review->set_status($status);

	if($status==PRP_PRO_ON) {
		$review->inform_subscribers();
	}

	if($ok) {
		$review->log_event(PRP_EV_STATUS, 0);
		fallback(FUSION_SELF."?did=".$review->id);
	}

} elseif(isset($_POST['resetlog'])) {
	if($last_updated > $_POST['last_updated']) {
		fallback(FUSION_SELF."?did=".$review->id."&errno=".PRP_EUPDATED);
	}

	$ok = dbquery("DELETE FROM ".DB_PRP_LOG.""
		." WHERE review_id='".$review->id."'");
	if($ok) {
		$review->log_event(PRP_EV_CLEARLOG, 0);
		fallback(FUSION_SELF."?did=".$review->id);
	}

} elseif(isset($_POST['resetbroken'])) {
	$ok = dbquery("UPDATE ".DB_PRP_DOWNLOADS."
		SET
		dl_broken_count='0'
		WHERE review_id='".$review->id."'");
	if($ok) {
		$review->log_event(PRP_EV_RESETBROKEN, 0);
		fallback(FUSION_SELF."?did=".$review->id);
	}

} elseif(isset($_POST['resetvisitors'])) {
	$ok = dbquery("UPDATE ".DB_PRP_DOWNLOADS."
		SET
		count_visitors='0'
		WHERE review_id='".$review->id."'");
	if($ok) {
		$review->log_event(PRP_EV_RESETVISITORS, 0);
		fallback(FUSION_SELF.'?did='.$review->id);
	}

} elseif(isset($_POST['setcount'])) {
	if(!isNum($_POST['count'])) {
		fallback(FUSION_SELF."?did=".$review->id);
	}

	$ok = dbquery("UPDATE ".DB_PRP_DOWNLOADS.""
		." SET dl_count='".$_POST['count']."'"
		." WHERE review_id='".$review->id."'");

	if($ok) {
		$review->log_event(PRP_EV_CHEAT, 0);
		fallback(FUSION_SELF."?did=".$review->id);
	}

} elseif(isset($_POST['set_max_pics'])) {
	$ok = dbquery("UPDATE ".DB_PRP_DOWNLOADS."
		SET
		max_pics='".intval($_POST['max_pics'])."'
		WHERE review_id='".$review->id."'");
	if($ok) {
		fallback(FUSION_SELF.'?did='.$review->id);
	}

} elseif(isset($_POST['set_dir_files'])) {
	if(!in_array($_POST['dir_files'], $upload_file_dirs)) {
		fallback(FUSION_SELF.'?did='.$review->id);
	}

	$ok = dbquery("UPDATE ".DB_PRP_DOWNLOADS."
		SET
		dir_files='".$_POST['dir_files']."'
		WHERE review_id='".$review->id."'");
	if($ok) {
		fallback(FUSION_SELF.'?did='.$review->id);
	}
}


/****************************************************************************
 * GUI
 */
if(isset($_GET['errno'])) {
	prp_process_errno($_GET['errno']);
}

opentable($locale['PRP450']);



echo '
<a href="admin/del_review.php?did='.$review->id.'">'
	.$locale['PRP880'].'</a>
<hr />';



$sel_status = '';
foreach($locale['PRP904'] as $val => $title) {
	$sel_status .= '<option value="'.$val.'"'
		.($val==$review->status
			? ' selected="selected"'
			: ''
		).'>'.$title.'</option>';
}


$sel_dir_files = '<option value="">'.$locale['prp_none'].'</option>';
foreach($upload_file_dirs as $dir) {
	$sel_dir_files .= '
	<option value="'.$dir.'"'
		.($dir==$review->data['dir_files']
			?  ' selected="selected"'
			: ''
		).'>'.$dir.'</option>';
}


echo '
<form action="'.FUSION_SELF.'?did='.$review->id.'" method="post">
<input type="hidden" name="last_updated" value="'.$last_updated.'">

<table width="100%" border="0" class="fusion-settings">
<colgroup>
	<col width="33%" />
	<col width="*" />
	<col width="*" />
</colgroup>
<tbody>
<tr>
	<td align="right">'.$locale['PRP454'].':</td>
	<td>'.ff_db_count("(*)", DB_PRP_LOG, "(review_id='".$review->id."')").'</td>
	<td><input type="submit" class="button" name="resetlog"
		value="'.$locale['prp_delete'].'"></td>
</tr>
<tr>
	<td align="right">'.$locale['prp_status'].':</td>
	<td><select class="textbox" name="value">'.$sel_status.'</select></td>
	<td><input type="submit" class="button" name="set_status"
		value="'.$locale['PRP453'].'"></td>
</tr>
<tr>
	<td align="right">'.$locale['prp_reset_visitors'].':</td>
	<td>'.$review->data['count_visitors'].'</td>
	<td><input type="submit" class="button" name="resetvisitors"
		value="'.$locale['PRP456'].'"></td>
</tr>
<tr>
	<td align="right">'.$locale['PRP455'].':</td>
	<td>'.$review->data['dl_broken_count'].'</td>
	<td><input type="submit" class="button" name="resetbroken"
		value="'.$locale['PRP456'].'"></td>
</tr>
<tr>
	<td align="right">'.$locale['PRP458'].':</td>
	<td><input type="text" class="textbox" name="max_pics" size="3"
		value="'.$review->data['max_pics'].'"></td>
	<td><input type="submit" class="button" name="set_max_pics"
		value="'.$locale['PRP453'].'"></td>
</tr>
<tr>
	<td align="right">'.$locale['PRP457'].':</td>
	<td><input type="text" class="textbox" name="count" size="7"
		value="'.$review->data['dl_count'].'" /></td>
	<td><input type="submit" class="button" name="setcount"
		value="'.$locale['PRP453'].'" /></td>
</tr>
<tr>
	<td align="right">'.$locale['PRP061'].':</td>
	<td>'.ff_db_count("(*)", DB_PRP_NOTIFY, "(review_id='".$review->id."')").'</td>
	<td></td>
</tr>
</tbody>
</table>

<fieldset>
<legend>'.$locale['prp_dir_files'].':</legend>
'.$prp->settings['upload_file'].'
<select name="dir_files">'.$sel_dir_files.'
</select>
<input type="submit" class="button" name="set_dir_files"
	value="'.$locale['PRP453'].'" />
</fieldset>

</form>

<hr />';




$query_id = dbquery("SELECT log_timestamp, log_type, user_name, log.user_id,
	log_errno
	FROM ".DB_PRP_LOG." AS log
	LEFT JOIN ".DB_USERS." AS fu USING(user_id)
	WHERE review_id='".$review->id."'
	ORDER BY log_timestamp DESC");
if(!dbrows($query_id)) {
	echo '<p>'.$locale['PRP451'].'</p>';
} else {
	echo '
<ul>';
}
while($data = dbarray($query_id)) {
	echo '
	<li>'.showdate('shortdate', $data['log_timestamp'])
		.' <a href="profile.php?id='.$data['user_id'].'">'
			.$data['user_name'].'</a>'
		.' - <strong>'.$locale['PRP903'][$data['log_type']]
		.'</strong> - '.$locale['PRP900'][$data['log_errno']]
		.'</li>';
}
if(dbrows($query_id)) {
	echo '
</ul>';
}


closetable();


require_once('include/die.php');
?>
