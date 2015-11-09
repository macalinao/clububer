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
require_once('../include/common.php');


if(!iPRP_MOD) {
	fallback('../index.php');
}
if(!$review->id) {
	fallback('reviews.php');
}


/*
 * GUI
 */
opentable($locale['PRP880']);


$do_del = isset($_POST['del']);
$deleted_msg = '<dd><strong>'.$locale['PRP883'].'</strong></dd>';


echo '<p>
'.$locale['PRP881'].': <a href="../edit_admin.php?did='.$review->id.'">'
	.$locale['PRP035'].'</a>
</p>';



if($do_del) {
	echo "
<p><b>".$locale['PRP884']."</b>\n";

	if(iPRP_ADMIN) {
		echo "
<p>
<form method='get' action='reviews.php'>
<input type='submit' class='button' value='".$locale['PRP036']."'>
</form>\n";
	} else {
		echo "
<p>
<form method='get' action='../mod.php'>
<input type='submit' class='button' value='".$locale['PRP600']."'>
</form>\n";
	}
}




echo '
<form action="'.FUSION_SELF.'?did='.$review->id.'" method="post">
<dl>';

// review
echo '
	<dt><strong>'.$locale['PRP002'].':</strong></dt>
	<dd><a href="../review.php?did='.$review->id.'" target="_blank">'.$review->data['dl_name'].'</a></dd>';
if($do_del) {
	$ok = dbquery("DELETE FROM ".DB_PRP_DOWNLOADS."
		WHERE review_id='".$review->id."'");

	$nr_reviews = ff_db_count("(*)", DB_PRP_DOWNLOADS,
		"dl_status='".PRP_PRO_ON."'");

	$ok = dbquery("UPDATE ".DB_PRP_CATS."
		SET
		count_reviews='".$nr_reviews."'
		WHERE cat_id='".$cat_id."'");

	if($ok) {
		echo $deleted_msg;
	}
}


// votes
echo '
	<dt><strong>'.$locale['PRP202'].':</strong></dt>
	<dd>'.ff_db_count("(*)", DB_PRP_VOTES, "(review_id='".$review->id."')").'</dd>';
if($do_del) {
	$ok = dbquery("DELETE FROM ".DB_PRP_VOTES.""
		." WHERE review_id='".$review->id."'");
	if($ok) {
		echo $deleted_msg;
	}
}


// comments
echo '
	<dt><strong>'.$locale['PRP021'].':</strong></dt>
	<dd>'.ff_db_count("(*)", DB_PRP_COMMENTS, "(review_id='".$review->id."')").'</dd>';
if($do_del) {
	$ok = dbquery("DELETE FROM ".DB_PRP_COMMENTS.""
		." WHERE review_id='".$review->id."'");
	if($ok) {
		echo $deleted_msg;
	}
}


// subscibers
echo '
	<dt><strong>'.$locale['PRP061'].':</strong></dt>
	<dd>'.ff_db_count("(*)", DB_PRP_NOTIFY, "(review_id='".$review->id."')").'</dd>';
if($do_del) {
	$ok = dbquery("DELETE FROM ".DB_PRP_NOTIFY.""
		." WHERE review_id='".$review->id."'");
	if($ok) {
		echo $deleted_msg;
	}
}


// logs
echo '
	<dt><strong>'.$locale['PRP454'].':</strong></dt>
	<dd>'.ff_db_count("(*)", DB_PRP_LOG, "(review_id='".$review->id."')").'</dd>';
if($do_del) {
	$ok = dbquery("DELETE FROM ".DB_PRP_LOG
		." WHERE review_id='".$review->id."'");
	if($ok) {
		echo $deleted_msg;
	}
}


// files
$res = dbquery("SELECT file_url, file_id
	FROM ".DB_PRP_FILES."
	WHERE review_id='".$review->id."'");

echo '
	<dt><strong>'.$locale['PRP019'].':</strong></dt>
	<dd>'.dbrows($res).'</dd>';
if(dbrows($res) && !is_writeable($prp->settings['upload_file'])) {
	echo "<dd><span class='small2'>"
		.str_replace("%s", "<b>".$prp->settings['upload_file']."</b>",
			$locale['PRP885'])
		."</span></dd>";
}
if(dbrows($res)) {
	echo '
	<dd>'.$locale['PRP886'].'
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
	if($do_del && !prp_is_external($data['file_url'])
		&& in_array($data['file_id'], $del_this)) {
		$ok = unlink($prp->settings['upload_file'].$data['file_url']);
		if($ok) {
			$del = " - ".$locale['PRP883'];
		}
	}
	echo "<input type='checkbox' name='del_file[]'"
		." value='".$data['file_id']."'> "
		.prp_cleanup_filename($data['file_url'])."$del<br>\n";
}
if(dbrows($res)) {
	echo '
	</ul>
	</dd>';
}
if($do_del) {
	$ok = dbquery("DELETE FROM ".DB_PRP_FILES."
		WHERE review_id='".$review->id."'");
	if($ok) {
		echo $deleted_msg;
	}
}


// images
$res = dbquery("SELECT pic_url, pic_id FROM ".DB_PRP_IMAGES."
	WHERE review_id='".$review->id."'");

echo '
	<dt><strong>'.$locale['PRP015'].':</strong></dt>
	<dd>'.dbrows($res).'</dd>';
if(dbrows($res) && !is_writeable($prp->settings['upload_image'])) {
	echo "<dd><span class='small2'>"
		.str_replace("%s", "<b>".$prp->settings['upload_image']."</b>",
			$locale['PRP885'])
		."</span></dd>";
}
if(dbrows($res)) {
	echo '
	<dd>'.$locale['PRP886'].'
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
	if($do_del && !prp_is_external($data['pic_url'])
		&& in_array($data['pic_id'], $del_this)) {
		$ok = unlink($prp->settings['upload_image'].$data['pic_url']);
		if($ok) {
			$del = " - ".$locale['PRP883'];
		}
	}
	echo "<input type='checkbox' name='del_pic[]'"
		." value='".$data['pic_id']."'> "
		.prp_cleanup_filename($data['pic_url'])."$del<br>\n";
}
if(dbrows($res)) {
	echo '
	</ul>
	</dd>';
}
if($do_del) {
	$ok = dbquery("DELETE FROM ".DB_PRP_IMAGES."
		WHERE review_id='".$review->id."'");
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
	<label>'.$locale['PRP887'].'</label>
</p>

<input type="submit" class="button" value="'.$locale['prp_delete'].'" />
</form>';
}
closetable();


require_once('../include/die.php');
?>
