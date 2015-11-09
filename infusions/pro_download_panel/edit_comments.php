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


unset($id);
if(isset($_GET['id']) && isNum($_GET['id'])) {
	$id = $_GET['id'];
}


/*
 * ACTION
 */
if(isset($_POST['save']) && isset($id)) {
	$text = stripinput($_POST['comm_text']);
	$comment_smileys = (isset($_POST['disable_smileys']) ? "0" : "1");
	$ok = dbquery("UPDATE ".DB_PDP_COMMENTS."
		SET
		comment_text='".$text."',
		comment_smileys='".$comment_smileys."'
		WHERE comment_id='".$id."' AND download_id='".$download->id."'");
	if($ok) {
		fallback(FUSION_SELF.'?did='.$download->id);
	}

}


/*
 * GUI
 */
opentable($locale['PDP021']);


if(isset($id)) {
	$res = dbquery("SELECT comment_id, comment_timestamp,
		comment_text, comment_smileys
		FROM ".DB_PDP_COMMENTS."
		WHERE comment_id='".$id."'
			AND download_id='".$download->id."'");
	if(!dbrows($res)) {
		fallback(FUSION_SELF.'?did='.$download->id);
	}
	$comm = dbarray($res);

	echo '
<form action="'.FUSION_SELF.'?did='.$download->id.'&id='.$id.'" method="post"
	name="inputform">
<table align="center" cellspacing="1">
<tr>
	<td align="center">
	<textarea cols="70" rows="8" class="textbox" name="comm_text">'
		.$comm['comment_text'].'</textarea><br />'
		.pdp_get_bb_smileys('comm_text', $comm['comment_smileys'], true).'</td>
</tr>
<tr>
	<td align="center"><input type="submit"
		value="'.$locale['PDP010'].'" class="button" name="save">
	</td>
</tr>
</table>';
}


// show all
$res = dbquery("SELECT comment_id, comment_text, comment_smileys, user_id,
	comment_user_name, comment_ip, comment_timestamp
	FROM ".DB_PDP_COMMENTS."
	WHERE download_id='".$download->id."'
	ORDER BY comment_timestamp ASC");
if(!dbrows($res)) {
	echo "<p>".$locale['PDP212'];
} else {
	echo '
<form method="post" action="include/do_did.php?did='.$download->id.'">
<table width="100%" cellspacing="1" class="tbl-border">
<colgroup>
	<col width="16" />
	<col width="*" />
	<col width="16" />
</colgroup>
<thead>
<tr>
	<th colspan="3">'.$locale['pdp_delete'].'</th>
</tr>
</thead>
<tbody>';
}
$count = 0;
while($cdata = dbarray($res)) {
	$id = $cdata['comment_id'];
	if($cdata['comment_smileys']=="1") {
		$text = parsesmileys($cdata['comment_text']);
	} else {
		$text = $cdata['comment_text'];
	}
	$name = $cdata['comment_user_name'];
	if($cdata['user_id']) {
		$name = "<a href='profile.php?id=".$cdata['user_id']
			."'>".$name."</a>";
	}
	echo '
<tr>
	<td class="tbl1" align="center" valign="top" rowspan="2">
		<input type="checkbox" name="comment['.$id.']">
	</td>
	<td class="tbl2">
		'.$name.' - '.showdate('longdate', $cdata['comment_timestamp'])
		.' - '.$locale['PDP380'].': '.$cdata['comment_ip'].'
	</td>
	<td width="16" class="tbl2">
		<a href="'.FUSION_SELF.'?did='.$download->id.'&amp;id='.$id.'"><img src="icons/edit.png" border="0" title="'.$locale['pdp_edit'].'" alt="'.$locale['pdp_edit'].'"></a>
	</td>
</tr>
	<td class="tbl1" colspan="2">'.parseubb($text).'</td>
</tr>';
}
if(dbrows($res)) {
	echo '
</tbody>
</table>

<p>
<input type="checkbox" name="delete_comments">
<label>'.$locale['PDP008'].'</label>

<p>
<input type="submit" class="button" value="'.$locale['pdp_delete'].'">
</form>';
}
closetable();


require_once('include/die.php');
?>
