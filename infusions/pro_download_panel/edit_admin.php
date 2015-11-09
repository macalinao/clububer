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
if(!iPDP_MOD) {
	fallback('download.php');
}
if(!$download->id) {
	fallback('download.php');
}
require_once('include/edit.php');


/*
 * GET
 */
// get latest timestamp
$query_id = dbquery("SELECT log_timestamp
	FROM ".DB_PDP_LOG."
	WHERE download_id='".$download->id."'
	ORDER BY log_timestamp DESC LIMIT 1");
if(dbrows($query_id)) {
	$last_updated = dbarray($query_id);
	$last_updated = array_shift($last_updated);
} else {
	$last_updated = 0;
}



// get all sub-dirs in the upload directory
$upload_file_dirs = array();
if(!empty($pdp->settings['upload_file'])) {
	$path = $pdp->settings['upload_file'];
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
		fallback(FUSION_SELF.'?did='.$download->id.'&errno='.PDP_EUPDATED);
	}

	$status = stripinput($_POST['value']);
	if(!isset($locale['PDP904'])) {
		fallback(FUSION_SELF."?did=".$download->id);
	}

	$ok = $download->set_status($status);

	if($status==PDP_PRO_ON) {
		$download->inform_subscribers();
	}

	if($ok) {
		$download->log_event(PDP_EV_STATUS, 0);
		fallback(FUSION_SELF."?did=".$download->id);
	}

} elseif(isset($_POST['resetlog'])) {
	if($last_updated > $_POST['last_updated']) {
		fallback(FUSION_SELF."?did=".$download->id."&errno=".PDP_EUPDATED);
	}

	$ok = dbquery("DELETE FROM ".DB_PDP_LOG.""
		." WHERE download_id='".$download->id."'");
	if($ok) {
		$download->log_event(PDP_EV_CLEARLOG, 0);
		fallback(FUSION_SELF."?did=".$download->id);
	}

} elseif(isset($_POST['resetbroken'])) {
	$ok = dbquery("UPDATE ".DB_PDP_DOWNLOADS."
		SET
		dl_broken_count='0'
		WHERE download_id='".$download->id."'");
	if($ok) {
		$download->log_event(PDP_EV_RESETBROKEN, 0);
		fallback(FUSION_SELF."?did=".$download->id);
	}

} elseif(isset($_POST['resetvisitors'])) {
	$ok = dbquery("UPDATE ".DB_PDP_DOWNLOADS."
		SET
		count_visitors='0'
		WHERE download_id='".$download->id."'");
	if($ok) {
		$download->log_event(PDP_EV_RESETVISITORS, 0);
		fallback(FUSION_SELF.'?did='.$download->id);
	}

} elseif(isset($_POST['setcount'])) {
	if(!isNum($_POST['count'])) {
		fallback(FUSION_SELF."?did=".$download->id);
	}

	$ok = dbquery("UPDATE ".DB_PDP_DOWNLOADS.""
		." SET dl_count='".$_POST['count']."'"
		." WHERE download_id='".$download->id."'");

	if($ok) {
		$download->log_event(PDP_EV_CHEAT, 0);
		fallback(FUSION_SELF."?did=".$download->id);
	}

} elseif(isset($_POST['set_max_pics'])) {
	$ok = dbquery("UPDATE ".DB_PDP_DOWNLOADS."
		SET
		max_pics='".intval($_POST['max_pics'])."'
		WHERE download_id='".$download->id."'");
	if($ok) {
		fallback(FUSION_SELF.'?did='.$download->id);
	}

} elseif(isset($_POST['set_dir_files'])) {
	if(!in_array($_POST['dir_files'], $upload_file_dirs)) {
		fallback(FUSION_SELF.'?did='.$download->id);
	}

	$ok = dbquery("UPDATE ".DB_PDP_DOWNLOADS."
		SET
		dir_files='".$_POST['dir_files']."'
		WHERE download_id='".$download->id."'");
	if($ok) {
		fallback(FUSION_SELF.'?did='.$download->id);
	}
}


/****************************************************************************
 * GUI
 */
if(isset($_GET['errno'])) {
	pdp_process_errno($_GET['errno']);
}

opentable($locale['PDP450']);



echo '
<a href="admin/del_download.php?did='.$download->id.'">'
	.$locale['PDP880'].'</a>
<hr />';



$sel_status = '';
foreach($locale['PDP904'] as $val => $title) {
	$sel_status .= '<option value="'.$val.'"'
		.($val==$download->status
			? ' selected="selected"'
			: ''
		).'>'.$title.'</option>';
}


$sel_dir_files = '<option value="">'.$locale['pdp_none'].'</option>';
foreach($upload_file_dirs as $dir) {
	$sel_dir_files .= '
	<option value="'.$dir.'"'
		.($dir==$download->data['dir_files']
			?  ' selected="selected"'
			: ''
		).'>'.$dir.'</option>';
}


echo '
<form action="'.FUSION_SELF.'?did='.$download->id.'" method="post">
<input type="hidden" name="last_updated" value="'.$last_updated.'">

<table width="100%" border="0" class="fusion-settings">
<colgroup>
	<col width="33%" />
	<col width="*" />
	<col width="*" />
</colgroup>
<tbody>
<tr>
	<td align="right">'.$locale['PDP454'].':</td>
	<td>'.ff_db_count("(*)", DB_PDP_LOG, "(download_id='".$download->id."')").'</td>
	<td><input type="submit" class="button" name="resetlog"
		value="'.$locale['pdp_delete'].'"></td>
</tr>
<tr>
	<td align="right">'.$locale['pdp_status'].':</td>
	<td><select class="textbox" name="value">'.$sel_status.'</select></td>
	<td><input type="submit" class="button" name="set_status"
		value="'.$locale['PDP453'].'"></td>
</tr>
<tr>
	<td align="right">'.$locale['pdp_reset_visitors'].':</td>
	<td>'.$download->data['count_visitors'].'</td>
	<td><input type="submit" class="button" name="resetvisitors"
		value="'.$locale['PDP456'].'"></td>
</tr>
<tr>
	<td align="right">'.$locale['PDP455'].':</td>
	<td>'.$download->data['dl_broken_count'].'</td>
	<td><input type="submit" class="button" name="resetbroken"
		value="'.$locale['PDP456'].'"></td>
</tr>
<tr>
	<td align="right">'.$locale['PDP458'].':</td>
	<td><input type="text" class="textbox" name="max_pics" size="3"
		value="'.$download->data['max_pics'].'"></td>
	<td><input type="submit" class="button" name="set_max_pics"
		value="'.$locale['PDP453'].'"></td>
</tr>
<tr>
	<td align="right">'.$locale['PDP457'].':</td>
	<td><input type="text" class="textbox" name="count" size="7"
		value="'.$download->data['dl_count'].'" /></td>
	<td><input type="submit" class="button" name="setcount"
		value="'.$locale['PDP453'].'" /></td>
</tr>
<tr>
	<td align="right">'.$locale['PDP061'].':</td>
	<td>'.ff_db_count("(*)", DB_PDP_NOTIFY, "(download_id='".$download->id."')").'</td>
	<td></td>
</tr>
</tbody>
</table>

<fieldset>
<legend>'.$locale['pdp_dir_files'].':</legend>
'.$pdp->settings['upload_file'].'
<select name="dir_files">'.$sel_dir_files.'
</select>
<input type="submit" class="button" name="set_dir_files"
	value="'.$locale['PDP453'].'" />
</fieldset>

</form>

<hr />';




$query_id = dbquery("SELECT log_timestamp, log_type, user_name, log.user_id,
	log_errno
	FROM ".DB_PDP_LOG." AS log
	LEFT JOIN ".DB_USERS." AS fu USING(user_id)
	WHERE download_id='".$download->id."'
	ORDER BY log_timestamp DESC");
if(!dbrows($query_id)) {
	echo '<p>'.$locale['PDP451'].'</p>';
} else {
	echo '
<ul>';
}
while($data = dbarray($query_id)) {
	echo '
	<li>'.showdate('shortdate', $data['log_timestamp'])
		.' <a href="profile.php?id='.$data['user_id'].'">'
			.$data['user_name'].'</a>'
		.' - <strong>'.$locale['PDP903'][$data['log_type']]
		.'</strong> - '.$locale['PDP900'][$data['log_errno']]
		.'</li>';
}
if(dbrows($query_id)) {
	echo '
</ul>';
}


closetable();


require_once('include/die.php');
?>
