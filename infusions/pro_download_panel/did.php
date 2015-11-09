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
	die;
}
if(!$download->id) {
	fallback('download.php');
}
if($download->status==PDP_PRO_NEW) {
	fallback('edit_desc.php?did='.$download->id);
}
if($download->status==PDP_PRO_ON) {
	dbquery("UPDATE ".DB_PDP_DOWNLOADS."
		SET
		count_visitors=count_visitors+1
		WHERE download_id='".$download->id."'");
}


// FIXME: THIS IS DONE TOO OFTEN - REDUCE
$is_subscribing = false;
if(iMEMBER && $pdp->settings['allow_notify']=='yes') {
	$is_subscribing = $download->is_subscribing($userdata['user_id']);
}



/****************************************************************************
 * GUI
 */
// license
$license = '';
if($download->data['license_id']) {
	$res = dbquery("SELECT license_id, license_name
		FROM ".DB_PDP_LICENSES."
		WHERE license_id='".$download->data['license_id']."'");
	if(dbrows($res) && $row=dbarray($res)) {
		$license = '<a href="license.php?id='.$row['license_id'].'">'
			.$row['license_name'].'</a>';
		$target = '';
	}
} elseif(!empty($download->data['lizenz_url'])) {
	$license = '<a target="_blank" href="'.$download->data['lizenz_url'].'">'.$locale['PDP203'].'</a>';
} elseif($download->data['lizenz_packet']=="Y") {
//	$license = "<span class='small2'>".$locale['PDP030']."</span>";
	$license = $locale['PDP030'];
} else {
//FIXME	$license = "<span class='small2'>".$locale['PDP204']."</span>";
}


// files
$files = array();
$res = dbquery("SELECT file_id, file_version, file_desc, file_size,
	file_timestamp, file_url, download_count
	FROM ".DB_PDP_FILES."
	WHERE download_id='".$download->id."' AND file_status='0'
	ORDER BY file_timestamp DESC");
while($data = dbarray($res)) {
	$pos = strpos($data['file_url'], '/');
	if($pos!==false) {
		$data['file_url'] = substr($data['file_url'], $pos+1);
	}

	$files[] = array(
		'id'		=> $data['file_id'],
		// obsolete? FIXME
		'is_external'	=> pdp_is_external($data['file_url']),
		'url'		=> $data['file_url'],
		'ver'		=> $data['file_version'],
		'timestamp'	=> $data['file_timestamp'],
		'size'		=> $data['file_size'],
		'desc'		=> $data['file_desc'],
		'download_count'=> $data['download_count'],
	);
}


// images
$images = array();
$res = dbquery("SELECT pic_id, pic_desc, pic_url
	FROM ".DB_PDP_IMAGES."
	WHERE download_id='".$download->id."' AND pic_status='0'");
while($data = dbarray($res)) {
	$images[] = array(
		'desc'	=> $data['pic_desc'],
		'id'	=> $data['pic_id'],
		'url'	=> $data['pic_url'],
	);
}



$desc = parseubb(parsesmileys($download->data['description']));
$old_data = array(	// FIXME: obsolete
	'down'		=> $download->data['down'],
	'link_extern'	=> $download->data['link_extern'],
	'version'	=> $download->data['version'],
	'size'		=> $download->data['dl_size'],
);
$data = array(
	'name'		=> $download->data['dl_name'],
	'can_download'	=> $download->can_download,
	'mtime'		=> $download->data['dl_mtime'],
	'count'		=> $download->data['dl_count'],
	'license'	=> $license,
	'desc'		=> $desc,
	'copyright'	=> $download->data['dl_copyright'],
	'pic'		=> $download->data['dl_pic'],
	'homepage'	=> $download->data['dl_homepage'],
	'is_subscribing'=> $is_subscribing,
	'count_votes'	=> $download->data['count_votes'],
	'count_comments'=> $download->data['count_comments'],
	'count_visitors'=> $download->data['count_visitors'],
	'can_subscribe'	=> iMEMBER,
	'subscibers'	=> $download->data['count_subscribers'],
	'allow_notify'	=> ($pdp->settings['allow_notify']=="yes"),
);
if($pdp->settings['hide_user_allow']=="yes" && $download->data['hide_user']=="yes"
	&& !$download->can_edit) {
	$data['user_id']	= 0;
} else {
	$data['user_id']	= $download->data['user_id'];
	$data['user_name']	= $download->data['user_name'];
}

$links = array();
if($download->can_edit) {
	$links[] = '<a href="edit_desc.php?did='.$download->id.'">'
		.$locale['PDP025'].'</a>';
	$links[] = '<a href="edit_files.php?did='.$download->id.'">'
			.$locale['PDP019'].'</a>';
	$links[] = '<a href="edit_pics.php?did='.$download->id.'">'
			.$locale['PDP015'].'</a>';
	$links[] = '<a href="edit_misc.php?did='.$download->id.'">'
			.$locale['pdp_misc'].'</a>';
	if(iPDP_MOD) {
		$links[] = '<a href="edit_comments.php?did='.$download->id.'">'
			.$locale['PDP021'].'</a>';
		$links[] = '<a href="edit_admin.php?did='.$download->id.'">'
			.$locale['pdp_moderator'].'</a>';
	}
}
pdp_render_download($download->id, $data, $links, $files, $images, $old_data);

closetable();



/****************************************************************************
 * RATINGS
 */
opentable($locale['PDP202']);
$res = dbquery("SELECT vote_opt, COUNT(vote_opt) AS vote_count
	FROM ".DB_PDP_VOTES."
	WHERE download_id='".$download->id."'
	GROUP BY vote_opt");
if(dbrows($res)!=0) {
	$max_val = 0;
	$votes = array(0, 0, 0, 0, 0, 0);	// index 0 is not used.
	$w = array(0, 0, 0, 0, 0, 0);

	while($data = dbarray($res)) {
		$votes[$data['vote_opt']] = $data['vote_count'];
		if($data['vote_count'] > $max_val) {
			$max_val = $data['vote_count'];
		}
	}
	for($i=1; $i<6; $i++) {
		$w[$i] = intval($votes[$i]*100 / $max_val);
		$p[$i] = intval($votes[$i]*100 / $download->data['count_votes']);
	}

	echo '
<table cellpadding="0" cellspacing="4" width="100%" border="0">
<colgroup>
	<col width="100" />
	<col width="*" />
	<col width="1%" />
	<col width="100" />
</colgroup>
<tbody>';
	for($i=1; $i<6; $i++) {
//	<td><img src="'.THEME.'images/pollbar.gif" height="12" width="'.$w[$i].'%" class="poll" alt="'.$w[$i].'%" /></td>
		echo '
<tr>
	<td align="right">'.$locale['PDP205'][$i].'</td>
	<td><img src="'.THEME.'images/pollbar.gif" height="15" width="'.$w[$i].'%" class="poll" alt="'.$w[$i].'%" /></td>
	<td align="right">'.$p[$i].'%</td>
	<td>['.$votes[$i].' '.$locale['PDP213'].']</td>
</tr>';
	}
	echo '
</tbody>
</table>';
}

if(iUSER >= $pdp->settings['bewertungen']) {
	$res = dbquery("SELECT vote_opt
		FROM ".DB_PDP_VOTES."
		WHERE download_id='".$download->id."'
			AND user_id='".$userdata['user_id']."'");
	if(dbrows($res)==0) {
		echo "<p>
<form action='include/do_did.php?did=".$download->id."' method='post'>
<div align='center'>
	<select size='1' class='textbox' name='vote'>
	<option value='1'>".$locale['PDP205']['1']."</option>
	<option value='2'>".$locale['PDP205']['2']."</option>
	<option value='3'>".$locale['PDP205']['3']."</option>
	<option value='4'>".$locale['PDP205']['4']."</option>
	<option value='5'>".$locale['PDP205']['5']."</option>
	</select>
	<input type='submit' value='".$locale['PDP206']
		."' class='button' name='do_vote' />
</div>
</form>";
	} else {
		$data = dbarray($res);
		echo "<p>
<form action='include/do_did.php?did=".$download->id."' method='post'>
<div align='center'>".$locale['PDP210'].": <b>"
		.$locale['PDP205'][$data['vote_opt']]."</b><br />
	<input type='submit' name='del_vote' class='button'"
		." value='".$locale['PDP209']."' />
</div>
</form>\n";
	}

} elseif(dbrows($res)==0) {
	echo "<p>".$locale['PDP208'];
}
closetable();


/****************************************************************************
 * COMMENTS
 */
opentable($locale['PDP021']);

$res = dbquery("SELECT comment_user_name, comment_smileys,
	comment_text, user_id, comment_id, comment_timestamp
	FROM ".DB_PDP_COMMENTS."
	WHERE download_id='".$download->id."'
	ORDER BY comment_timestamp ASC");
$count_comments = $count = dbrows($res);
while($data = dbarray($res)) {
	$name = $data['comment_user_name'];
	if($data['comment_smileys']=="1") {
		$text = parsesmileys($data['comment_text']);
	} else {
		$text = $data['comment_text'];
	}
	$text = parseubb($text);
	if($data['user_id']) {
		$name = '<a href="'.BASEDIR.'profile.php?lookup='
			.$data['user_id'].'">'.$name.'</a>';
	} else {
		$name = '<strong>'.$name.'</strong>';
	}
	echo '
<div class="comment" id="comm'.$data['comment_id'].'">
<span class="comment-name">'.$name.'</a></span>
<span class="small">'.$locale['PDP031']
	.showdate('shortdate', $data['comment_timestamp']).'</span>
<p>
'.$text.'
</p>
</div>';

	if(--$count) {
		echo '<hr />';
	}
}
if($count_comments==0) {
	echo $locale['PDP212'];
} elseif(iPDP_MOD) {
	echo '<hr />
<div align="right">
[<a href="edit_comments.php?did='.$download->id.'">'.$locale['PDP032'].'</a>]
</div>';
}
closetable();



// show comment form.
if(iUSER >= $pdp->settings['kommentare']) {
	if(isset($_GET['comm_user'])) {
		$c_user = urldecode(stripinput($_GET['comm_user']));
		$c_text = urldecode(stripinput($_GET['comm_text']));
		$c_smileys = ($_GET['comm_smileys']=="1" ? "1" : "0");
	} else {
		$c_user = "";
		$c_text = "";
		$c_smileys = "1";
	}

	if(iMEMBER) {
		$name_line = "";
	} else {
		$name_line = $locale['PDP002']
			.": <input type='text' size='32' maxlength='50'"
			." class='textbox' name='comment_name'"
			." value='".$c_user."' /><br />\n";
	}

	opentable($locale['PDP211']);

	if(isset($_GET['wrong_captcha'])) {
		show_info($locale['pdp_wrong_captcha']);
	}

	echo "
<a name='new_comment'></a>
<p></p>
<form action='include/do_did.php?did=".$download->id."' method='post'
	name='inputform'>
<div align='center'>
$name_line

<textarea cols='60' rows='5' class='textbox' name='comm_text'>".$c_text."</textarea><br />"
	.pdp_get_bb_smileys("comm_text", $c_smileys, true).'
<hr />';
	if(!iMEMBER) {
		echo '
	<p></p>
	<label>'.$locale['pdp_captcha'].':</label><br />
	'.make_captcha().'
	<input type="text" class="textbox" name="user_code" size="5" />';
	}
	echo '
<p></p>
<input type="submit" value="'.$locale['PDP211'].'" class="button"
	name="add_comment" />
</div>
</form>';
	closetable();

}

?>
