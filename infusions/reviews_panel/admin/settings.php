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
require_once('../include/admin.php');
if(!iPRP_ADMIN) {
	fallback('../index.php');
}

/*
 * ACTION
 */
if(isset($_POST['save'])) {
	$title = stripinput($_POST['title']);
	$per_page = stripinput($_POST['per_page']);
	$hide_cats = isset($_POST['hide_cats']) ? "1" : "0";

	$theme = trim(stripinput($_POST['theme']));

	$review_grp = intval($_POST['downbereich']);
	$comm_grp = intval($_POST['kommentare']);

	$vote_grp = intval($_POST['bewertungen']);
	if(!$vote_grp) {
		$vote_grp = "101";
	}

	$image_ext = preg_replace("/\s+/", "", stripinput($_POST['image_ext']));
	$image_max = stripinput($_POST['image_max']);

	$file_ext = preg_replace("/\s+/", "", stripinput($_POST['file_ext']));
	$file_max = stripinput($_POST['file_max']);

	$new_days_long = stripinput($_POST['new_days_long']);

	$user_edit = isset($_POST['user_edit']) ? "1" : "0";
	$hide_user_allow = isset($_POST['hide_user_allow']) ? "yes" : "no";
	$upload_file = stripinput($_POST['upload_file']);
	$upload_image= stripinput($_POST['upload_image']);
	$new_comm_pm = isset($_POST['new_comm_pm']) ? "1" : "0";

	$broken_count = stripinput($_POST['broken_count']);
	$broken_text = stripinput($_POST['broken_text']);
	$broken_access = stripinput($_POST['broken_access']);

	$review_restricted = stripinput($_POST['review_restricted']);

	$pm_after_changes = stripinput($_POST['pm_after_changes']);
	$do_log = (isset($_POST['do_log']) ? "1" : "0");

	if(substr($upload_file, -1, 1)!="/") {
		$upload_file .= "/";
	}
	if(substr($upload_image, -1, 1)!="/") {
		$upload_image .= "/";
	}

	$side_latest = intval($_POST['side_latest']);
	$side_top = intval($_POST['side_top']);

	$mod_grp = intval($_POST['mod_grp']);
	if(!$mod_grp) {
		$mod_grp = "103";
	}
	$need_verify = (isset($_POST['need_verify']) ? "yes" : "no");

	$image_max_w = intval($_POST['image_max_w']);
	$image_max_h = intval($_POST['image_max_h']);
	if(!$image_max_w || !$image_max_h) {
		$image_max_w = $image_max_h = 0;
	}
	$image_scale = (isset($_POST['image_scale']) ? "yes" : "no");

	$allow_notify = (isset($_POST['allow_notify']) ? "yes" : "no");

	$default_max_pics = intval($_POST['default_max_pics']);

	$ok = dbquery("UPDATE ".DB_PRP_SETTINGS."
		SET
		title='".$title."',
		theme='".$theme."',
		neupm='".$neupm."',
		defektpm='".$defektpm."',
		file_max='".$file_max."',
		file_ext='".$file_ext."',
		image_max='".$image_max."',
		image_ext='".$image_ext."',
		downbereich='".$review_grp."',
		kommentare='".$comm_grp."',
		bewertungen='".$vote_grp."',
		per_page='".$per_page."',
		hide_cats='".$hide_cats."',
		user_edit='".$user_edit."',
		hide_user_allow='".$hide_user_allow."',
		upload_file='".$upload_file."',
		upload_image='".$upload_image."',
		new_comm_pm='".$new_comm_pm."',
		broken_count='".$broken_count."',
		broken_text='".$broken_text."',
		broken_access='".$broken_access."',

		pm_after_changes='".$pm_after_changes."',
		side_latest='".$side_latest."',
		side_top='".$side_top."',
		do_log='".$do_log."',
		new_days_long='".$new_days_long."',
		image_max_w='".$image_max_w."',
		image_max_h='".$image_max_h."',
		image_scale='".$image_scale."',

		mod_grp='".$mod_grp."',
		need_verify='".$need_verify."',
		allow_notify='".$allow_notify."',
		default_max_pics='".$default_max_pics."',
		review_restricted='".$review_restricted."'

		WHERE id='1'");
	if($ok) {
		fallback(FUSION_SELF.'?errno=0');
	}
}



/*
 *
 */
$query_id = dbquery("SELECT user_id, user_name, user_rights
	FROM ".DB_USERS."
	WHERE user_level>=102
	ORDER BY user_level DESC, user_name");
$all_admins = array('0' => $locale['PRP707']);
while($user = dbarray($query_id)) {
	if(in_array('IP', explode('.', $user['user_rights']))) {
		$all_admins[$user['user_id']] = $user['user_name'];
	}
}

//
$fusion_groups = getusergroups();
$down_groups = "";
$broken_access = "";
$sel_mod_grp = "";
foreach($fusion_groups as $g) {
	list($id, $name) = $g;

	$down_groups .= "<option value='$id'"
		.($id==$prp->settings['downbereich'] ? " selected" :"").">"
		."$name</option>\n";
	$broken_access .= "<option value='$id'"
		.($id==$prp->settings['broken_access'] ? " selected" :"").">"
		."$name</option>\n";

	if(!$id) {
		continue;
	}
	$sel_mod_grp .= "<option value='$id'"
		.($id==$prp->settings['mod_grp'] ? " selected" :"").">"
		."$name</option>\n";
}


$new_days_long = "";
for($i=0; $i<=30; $i++) {
	$new_days_long .= "<option"
		.($i==$prp->settings['new_days_long'] ? " selected" : "")
		.">$i</option>\n";
}




/****************************************************************************
 * GUI
 */
opentable($locale['PRP700']);
prp_admin_menu();


if(isset($_GET['errno'])) {
	show_info($locale['PRP708']);
}

$allow_comments = "";
$allow_votes = "";
foreach($locale['PRP729'] as $val => $text) {
	$allow_comments .= "<option value='$val'"
		.($prp->settings['kommentare']==$val ? "selected" : "")
		.">$text</option>";

	if($val) {
		$allow_votes .= "<option value='$val'"
			.($prp->settings['bewertungen']==$val ? "selected" : "")
			.">$text</option>";
	}
}

$broken_text_legend = "";
foreach($locale['PRP732'] as $code => $text) {
	$broken_text_legend .= "<b>$code</b> - $text<br>\n";
}


$sel_theme = "<option value=''>".$locale['PRP740']."</option>\n";
$handle = opendir("../themes");
while(false !== ($entry=readdir($handle))) {
	if($entry=="." || $entry=="..") {
		continue;
	}
	if(is_dir("../themes/$entry")
		&& is_file("../themes/$entry/theme.php")) {
		$sel_theme .= "<option"
			.($prp->settings['theme']==$entry ? " selected" : "")
			.">$entry</option>\n";
	}
}
closedir($handle);


$sel_new_pm = "";
$sel_broken_pm = "";
foreach($all_admins as $id => $name) {
	$sel_new_pm .= "<option value='$id'"
		.($id==$prp->settings['neupm'] ? " selected" : "")
		.">$name</option>\n";
	$sel_broken_pm .= "<option value='$id'"
		.($id==$prp->settings['defektpm'] ? " selected" : "")
		.">$name</option>\n";
}


if(!is_dir($prp->settings['upload_file'])) {
	$status_upload_file = "<strong>".$locale['PRP844']."</strong>";
} elseif(!is_writeable($prp->settings['upload_file'])) {
	$status_upload_file = "<strong>".$locale['PRP845']."</strong>";
} else {
	$status_upload_file = $locale['PRP043'];
}
if(!is_dir($prp->settings['upload_image'])) {
	$status_upload_image = "<strong>".$locale['PRP844']."</strong>";
} elseif(!is_writeable($prp->settings['upload_image'])) {
	$status_upload_image = "<strong>".$locale['PRP845']."</strong>";
} else {
	$status_upload_image = $locale['PRP043'];
}

//
$upload_max_filesize = prp_get_upload_max_filesize();
$status_file_maxsize = $status_image_maxsize = "";
if(empty($upload_max_filesize)) {
	$upload_max_filesize = $locale['PRP854'].": ".$locale['PRP849'];
} else {
	if($upload_max_filesize >= $prp->settings['file_max']) {
		$status_file_maxsize = $locale['PRP043'];
	} else {
		$status_file_maxsize = "<strong>".$locale['PRP850']."</strong>";
	}
	if($upload_max_filesize >= $prp->settings['image_max']) {
		$status_image_maxsize = $locale['PRP043'];
	} else {
		$status_image_maxsize = "<strong>".$locale['PRP850']."</strong>";
	}
	$upload_max_filesize = $locale['PRP854'].": "
		.parsebytesize($upload_max_filesize);
}


$save_button = "<input type='submit' value='".$locale['PRP010']."'"
	." class='button' name='save'>";


echo '
<form action="'.FUSION_SELF.'" method="POST" name="inputform">

<p>
<fieldset>
<legend>'.$locale['PRP735'].'</legend>
<table width="100%" border="0" cellspacing="1" class="fusion-settings">
<colgroup>
	<col width="33%" />
	<col width="*" />
</colgroup>
<tbody>
<tr>
	<td align="right" for="title">'.$locale['PRP701'].':</td>
	<td><input type="text" value="'.$prp->settings['title'].'"
		id="title"
		size="40" maxlength="100" class="textbox" name="title"></td>
</tr>
<tr>
	<td align="right">'.$locale['PRP702'].':</td>
	<td><input type="text" size="4" maxlength="3"
		class="textbox" value="'.$prp->settings['per_page'].'"
		name="per_page"></td>
</tr>
<tr>
	<td align="right">'.$locale['PRP739'].':</td>
	<td><select class="textbox" name="theme">'.$sel_theme.'</select></td>
</tr>
<tr>
	<td align="right">'.$locale['PRP005'].':</td>
	<td>
		<input type="checkbox" name="hide_cats" id="hc0"'
			.($prp->settings['hide_cats']==1
				? ' checked="checked"'
				: '')
			.'> <label for="hc0">'.$locale['PRP709'].'</label>
	</td>
</tr>
</tbody>
</table>
</fieldset>
</p>


<p>
<fieldset>
<legend>'.$locale['PRP705'].'</legend>
<table width="100%" border="0" cellspacing="1" class="fusion-settings">
<colgroup>
	<col width="33%" />
	<col width="*" />
</colgroup>
<tbody>
<tr>
	<td align="right">'.$locale['PRP710'].':</td>
	<td><select size="1" class="textbox" name="neupm">'
		.$sel_new_pm.'</select>
	</td>
</tr>
<tr>
	<td align="right">'.$locale['PRP711'].':</td>
	<td><select size="1" class="textbox" name="defektpm">'
		.$sel_broken_pm.'</select>
	</td>
</tr>
<tr>
	<td align="right" valign="top">'.$locale['PRP005'].':</td>
	<td>
		<input type="checkbox" name="new_comm_pm" id="ncp0"'
			.($prp->settings['new_comm_pm']==1
				? ' checked="checked"'
				: ''
			).'> <label for="ncp0">'.$locale['PRP706'].'</label>
		<br />
		<input type="checkbox" name="allow_notify" id="an0"'
			.($prp->settings['allow_notify']=='yes'
				? ' checked="checked"'
				: ''
			).'> <label for="an0">'.$locale['PRP750'].'</label>
	</td>
</tr>
</tbody>
</table>
</fieldset>
</p>





'."
<p>
<fieldset>
<legend>".$locale['prp_reviews']."</legend>
<table width='100%' border='0' cellspacing='1' class='fusion-settings'>
<colgroup>
	<col width='33%' />
	<col width='*' />
</colgroup>
<tbody>
<tr>
	<td align='right'>".$locale['PRP703'].":</td>
	<td><input type='text' name='upload_file'"
		." value='".substr($prp->settings['upload_file'], strlen(BASEDIR))."'"
		." size='50' maxlength='200' class='textbox'><br>"
		.$locale['prp_status'].": $status_upload_file</td>
</tr>
<tr>
	<td align='right'>".$locale['PRP722'].":<br><span class='small2'>"	
	  	.$locale['PRP713']."</span></td>
	<td><input type='text' size='50' name='file_ext'"
	  	." value='".$prp->settings['file_ext']."' class='textbox'><br>"
		."<span class='small2'>".$locale['PRP715']."</span></td>
</tr>
<tr>
	<td align='right'>".$locale['PRP716']
		.":<br><span class='small2'>".$locale['PRP717']."</span></td>
	<td>$upload_max_filesize<br>
		<input type='text' value='".$prp->settings['file_max']."'"
		." size='14' maxlength='12' class='textbox'"
		." name='file_max'> =".parsebytesize($prp->settings['file_max'])
			." (".$status_file_maxsize.")<br>"
		."<span class='small2'>".$locale['PRP720']."</span></td>
</tr>
<tr>
	<td align='right'>".$locale['prp_misc'].":</td>
	<td><input type='checkbox' name='user_edit' id='ue0'"
		.($prp->settings['user_edit']==1 ? " checked" : "")."> "
		."<label for='ue0'>".$locale['PRP721']."</label><br>
		<input type='checkbox' name='hide_user_allow' id='hua0'"
			.($prp->settings['hide_user_allow']=="yes"
				? " checked" : "")."> "
			."<label for='hua0'>".$locale['PRP741']."</label>"
	."</td>
</tr>
<tr>
	<td align='right'>".$locale['PRP712']."</td>
	<td><input type='text' size='5' maxlength='3'"
		." value='".$prp->settings['broken_count']."'"
		." class='textbox' name='broken_count'>"
		." <span class='small2'>(".$locale['PRP731'].")</span></td>
</tr>
<tr>
	<td align='right'>".$locale['PRP736']."</td>
	<td><select name='broken_access' class='textbox'>"
		.$broken_access."</select></td>
</tr>
<tr>
	<td align='right'>".$locale['PRP737']."</td>
	<td><select name='new_days_long' class='textbox'>"
		.$new_days_long."</select> ".$locale['PRP738']."</td>
</tr>
<tr>
	<td align='right'>".$locale['PRP725'].":<br>$broken_text_legend</td>
	<td><textarea class='textbox' name='broken_text' cols='50'"
		." rows='6'>".$prp->settings['broken_text']."</textarea><br>"
		.prp_get_bb_smileys("broken_text", "not_used", false, false)."</td>
</tr>
<tr>
	<td align='right'>".$locale['PRP762'].":</td>
	<td><textarea class='textbox' name='review_restricted' cols='50'"
		." rows='6'>".$prp->settings['review_restricted']."</textarea><br>"
		.prp_get_bb_smileys('review_restricted', "not_used", false, false)."</td>
</tr>
</tbody>
</table>
</fieldset>
</p>
".'


<p>
<fieldset>
<legend>'.$locale['PRP015'].'</legend>
<table width="100%" border="0" cellspacing="1" class="fusion-settings">
<colgroup>
	<col width="33%" />
	<col width="*" />
</colgroup>
<tbody>
<tr>
	<td align="right">'.$locale['PRP704'].':</td>
	<td>
		<input type="text" name="upload_image" value="'.substr($prp->settings['upload_image'], strlen(BASEDIR)).'" size="50" maxlength="200" class="textbox"><br />'
		.$locale['prp_status'].': '.$status_upload_image.'</td>
</tr>
<tr>
	<td align="right">'.$locale['PRP722'].':</td>
	<td>
		<input type="text" value="'.$prp->settings['image_ext'].'" size="50" class="textbox" name="image_ext" /><br />
		<span class="small2">'.$locale['PRP713'].' '.$locale['PRP714'].'</span>
	</td>
</tr>
<tr>
	<td align="right">'.$locale['PRP716']
		.':<br><span class="small2">'.$locale['PRP717'].'</span></td>
	<td>'.$upload_max_filesize.'<br />
		<input type="text" value="'.$prp->settings['image_max'].'" size="14" maxlength="12" class="textbox" name="image_max">'
		.' ='.parsebytesize($prp->settings['image_max'])
		.' ('.$status_image_maxsize.')<br><span class="small2">'.$locale['PRP719'].'</span></td>
</tr>
<tr>
	<td align="right">'.$locale['PRP716']
		.':<br><span class="small2">'.$locale['PRP747'].'</span></td>
	<td>
		<input type="text" name="image_max_w" value="'.$prp->settings['image_max_w'].'" size="5" maxlength="5" class="textbox">'
		.' x <input type="text" name="image_max_h" value="'.$prp->settings['image_max_h'].'" size="5" maxlength="5" class="textbox">'
		.' <span class="small2">'.$locale['PRP748'].'</span>'
		.' <br><input type="checkbox" id="is0" name="image_scale"'
			.($prp->settings['image_scale']=="yes"
				? ' checked="checked"'
				: ''
			).'> <label for="is0">'.$locale['PRP749'].'</label>
	</td>
</tr>
<tr>
	<td align="right">'.$locale['PRP760'].':</td>
	<td><input type="text" size="5" maxlength="3"'
		.' value="'.$prp->settings['default_max_pics'].'"'
		.' class="textbox" name="default_max_pics">'
		.' <span class="small2">('.$locale['PRP731'].')</span><br />
		[<span class="small2">'.$locale['PRP761'].'</span>]
	</td>
</tr>
</tbody>
</table>
</fieldset>
</p>


<p>
<fieldset>
<legend>'.$locale['PRP730'].'</legend>
<table width="100%" border="0" cellspacing="1" class="fusion-settings">
<colgroup>
	<col width="33%" />
	<col width="*" />
</colgroup>
<tbody>
<tr>
	<td align="right">'.$locale['PRP735'].':</td>
	<td><input type="checkbox" name="do_log" id="dl0"'
		.($prp->settings['do_log']
			? ' checked="checked"'
			: '')
		.'> <label for="dl0">'.$locale['PRP718'].'</label>
	</td>
</tr>
<tr>
	<td align="right">'.$locale['PRP733'].'</td>
	<td>
		<input type="text" size="5" maxlength="3" value="'.$prp->settings['pm_after_changes'].'" class="textbox" name="pm_after_changes"><br />
		<span class="small2">'.$locale['PRP734'].'</span>
	</td>
</tr>
</tbody>
</table>
</fieldset>
</p>


<p>
<fieldset>
<legend>'.$locale['PRP742'].'</legend>
<table width="100%" border="0" cellspacing="1" class="fusion-settings">
<colgroup>
	<col width="33%" />
	<col width="*" />
</colgroup>
<tbody>
<tr>
	<td align="right">'.$locale['PRP743'].':</td>
	<td><input type="text" size="5" maxlength="3" value="'.$prp->settings['side_latest'].'" class="textbox" name="side_latest"></td>
</tr>
<tr>
	<td align="right">'.$locale['PRP744'].':</td>
	<td><input type="text" size="5" maxlength="3" value="'.$prp->settings['side_top'].'" class="textbox" name="side_top"></td>
</tr>
</tbody>
</table>
</fieldset>
</p>


<p>
<fieldset>
<legend>'.$locale['prp_misc'].'</legend>
<table width="100%" border="0" cellspacing="1" class="fusion-settings">
<colgroup>
	<col width="33%" />
	<col width="*" />
</colgroup>
<tbody>
<tr>
	<td align="right">'.$locale['PRP723'].':</td>
	<td>
		<select name="downbereich" size="1" class="textbox">
		'.$down_groups.'</select>
		<span class="small2">'.$locale['PRP763'].'</span>
	</td>
</tr>
<tr>
	<td align="right">'.$locale['PRP726'].':</td>
	<td>
		<select name="kommentare" size="1" class="textbox">'
			.$allow_comments.'</select>
		<span class="small2">'.$locale['PRP728'].'</span>
	</td>
</tr>
<tr>
	<td align="right">'.$locale['PRP727'].':</td>
	<td>
		<select name="bewertungen" size="1" class="textbox">'
			.$allow_votes.'</select>
		<span class="small2">'.$locale['PRP728'].'</span>
	</td>
</tr>
<tr>
	<td align="right">'.$locale['PRP745'].':</td>
	<td><select name="mod_grp" size="1" class="textbox">'
		.$sel_mod_grp.'</select><br />'
		.'<input type="checkbox" name="need_verify" id="nv0"'
		.($prp->settings['need_verify']=='yes'
			? ' checked="checked"'
			: '')
		.'> <label for="nv0">'.$locale['PRP746'].'</label></td>
</tr>
</tbody>
</table>
</fieldset>
</p>


<p>
<div style="text-align:center;">'.$save_button.'</div>
</p>

</form>';

closetable();


require_once('../include/die.php');
?>
