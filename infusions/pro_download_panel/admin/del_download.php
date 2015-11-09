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
require_once('../include/common.php');


if(!iPDP_MOD) {
	fallback('../index.php');
}
if(!$download->id) {
	fallback('downloads.php');
}


/*
 * GUI
 */
opentable($locale['PDP880']);


$do_del = isset($_POST['del']);
$deleted_msg = '<dd><strong>'.$locale['PDP883'].'</strong></dd>';


echo '<p>
'.$locale['PDP881'].': <a href="../edit_admin.php?did='.$download->id.'">'
	.$locale['PDP035'].'</a>
</p>';



if($do_del) {
	echo "
<p><b>".$locale['PDP884']."</b>\n";

	if(iPDP_ADMIN) {
		echo "
<p>
<form method='get' action='downloads.php'>
<input type='submit' class='button' value='".$locale['PDP036']."'>
</form>\n";
	} else {
		echo "
<p>
<form method='get' action='../mod.php'>
<input type='submit' class='button' value='".$locale['PDP600']."'>
</form>\n";
	}
}




echo '
<form action="'.FUSION_SELF.'?did='.$download->id.'" method="post">
<dl>';

// download
echo '
	<dt><strong>'.$locale['PDP002'].':</strong></dt>
	<dd><a href="../download.php?did='.$download->id.'" target="_blank">'.$download->data['dl_name'].'</a></dd>';
if($do_del) {
	$ok = dbquery("DELETE FROM ".DB_PDP_DOWNLOADS."
		WHERE download_id='".$download->id."'");

	$nr_downloads = ff_db_count("(*)", DB_PDP_DOWNLOADS,
		"dl_status='".PDP_PRO_ON."'");

	$ok = dbquery("UPDATE ".DB_PDP_CATS."
		SET
		count_downloads='".$nr_downloads."'
		WHERE cat_id='".$cat_id."'");

	if($ok) {
		echo $deleted_msg;
	}
}


// votes
echo '
	<dt><strong>'.$locale['PDP202'].':</strong></dt>
	<dd>'.ff_db_count("(*)", DB_PDP_VOTES, "(download_id='".$download->id."')").'</dd>';
if($do_del) {
	$ok = dbquery("DELETE FROM ".DB_PDP_VOTES.""
		." WHERE download_id='".$download->id."'");
	if($ok) {
		echo $deleted_msg;
	}
}


// comments
echo '
	<dt><strong>'.$locale['PDP021'].':</strong></dt>
	<dd>'.ff_db_count("(*)", DB_PDP_COMMENTS, "(download_id='".$download->id."')").'</dd>';
if($do_del) {
	$ok = dbquery("DELETE FROM ".DB_PDP_COMMENTS.""
		." WHERE download_id='".$download->id."'");
	if($ok) {
		echo $deleted_msg;
	}
}


// subscibers
echo '
	<dt><strong>'.$locale['PDP061'].':</strong></dt>
	<dd>'.ff_db_count("(*)", DB_PDP_NOTIFY, "(download_id='".$download->id."')").'</dd>';
if($do_del) {
	$ok = dbquery("DELETE FROM ".DB_PDP_NOTIFY.""
		." WHERE download_id='".$download->id."'");
	if($ok) {
		echo $deleted_msg;
	}
}


// logs
echo '
	<dt><strong>'.$locale['PDP454'].':</strong></dt>
	<dd>'.ff_db_count("(*)", DB_PDP_LOG, "(download_id='".$download->id."')").'</dd>';
if($do_del) {
	$ok = dbquery("DELETE FROM ".DB_PDP_LOG
		." WHERE download_id='".$download->id."'");
	if($ok) {
		echo $deleted_msg;
	}
}


// files
$res = dbquery("SELECT file_url, file_id
	FROM ".DB_PDP_FILES."
	WHERE download_id='".$download->id."'");

echo '
	<dt><strong>'.$locale['PDP019'].':</strong></dt>
	<dd>'.dbrows($res).'</dd>';
if(dbrows($res) && !is_writeable($pdp->settings['upload_file'])) {
	echo "<dd><span class='small2'>"
		.str_replace("%s", "<b>".$pdp->settings['upload_file']."</b>",
			$locale['PDP885'])
		."</span></dd>";
}
if(dbrows($res)) {
	echo '
	<dd>'.$locale['PDP886'].'
	<ul>';
}
if($do_del) {
	if(isset($_POST['del_file'])) {
		$del_this = $_POST['del_file'];
	} else {
		$del_this = array();
	}
}
while($data = dbarray($res)) {
	$del = '';
	if($do_del && !pdp_is_external($data['file_url'])
		&& in_array($data['file_id'], $del_this)) {
		$ok = unlink($pdp->settings['upload_file'].$data['file_url']);
		if($ok) {
			$del = " - ".$locale['PDP883'];
		}
	}
	echo "<input type='checkbox' name='del_file[]'"
		." value='".$data['file_id']."'> "
		.pdp_cleanup_filename($data['file_url'])."$del<br>\n";
}
if(dbrows($res)) {
	echo '
	</ul>
	</dd>';
}
if($do_del) {
	$ok = dbquery("DELETE FROM ".DB_PDP_FILES."
		WHERE download_id='".$download->id."'");
	if($ok) {
		echo $deleted_msg;
	}
}


// images
$res = dbquery("SELECT pic_url, pic_id FROM ".DB_PDP_IMAGES."
	WHERE download_id='".$download->id."'");

echo '
	<dt><strong>'.$locale['PDP015'].':</strong></dt>
	<dd>'.dbrows($res).'</dd>';
if(dbrows($res) && !is_writeable($pdp->settings['upload_image'])) {
	echo "<dd><span class='small2'>"
		.str_replace("%s", "<b>".$pdp->settings['upload_image']."</b>",
			$locale['PDP885'])
		."</span></dd>";
}
if(dbrows($res)) {
	echo '
	<dd>'.$locale['PDP886'].'
	<ul>';
}
if($do_del) {
	if(isset($_POST['del_pic'])) {
		$del_this = $_POST['del_pic'];
	} else {
		$del_this = array();
	}
}
while($data = dbarray($res)) {
	$del = "";
	if($do_del && !pdp_is_external($data['pic_url'])
		&& in_array($data['pic_id'], $del_this)) {
		$ok = unlink($pdp->settings['upload_image'].$data['pic_url']);
		if($ok) {
			$del = " - ".$locale['PDP883'];
		}
	}
	echo "<input type='checkbox' name='del_pic[]'"
		." value='".$data['pic_id']."'> "
		.pdp_cleanup_filename($data['pic_url'])."$del<br>\n";
}
if(dbrows($res)) {
	echo '
	</ul>
	</dd>';
}
if($do_del) {
	$ok = dbquery("DELETE FROM ".DB_PDP_IMAGES."
		WHERE download_id='".$download->id."'");
	if($ok) {
		echo $deleted_msg;
	}
}


// GO!
if(!$do_del) {
	echo '
</dl>

<p>
	<input type="checkbox" name="del" />
	<label>'.$locale['PDP887'].'</label>
</p>

<input type="submit" class="button" value="'.$locale['pdp_delete'].'" />
</form>';
}
closetable();


require_once('../include/die.php');
?>
