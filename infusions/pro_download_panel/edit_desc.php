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
if(!iMEMBER) {
	fallback('download.php');
}
if($download->id && !$download->can_edit) {
	$download->fallback_download();
}
require_once('include/edit.php');


$name		= '';
$homepage	= '';
$desc		= '';
$abstract	= '';
$copy		= 'Copyright (C) '.$userdata['user_name'].' '.date('Y');
$li_url		= '';
$li_ok		= '';
$li_pa		= '';
$li_id		= 0;
$cat		= 0;

$errors = 0;



/*
 * ACTION!
 */
if(isset($_POST['save'])) {
	$href = FUSION_SELF;
	if($download->id) {
		$href .= "?did=".$download->id;
	}

	$cat = intval($_POST['cat']);
	if(!$cat) {
		$errors++;
	} else {
		$query_id = dbquery("SELECT cat_upload_access"
			." FROM ".DB_PDP_CATS.""
			." WHERE cat_id='$cat'");
		if(!dbrows($query_id)
			|| !checkgroup(array_shift(dbarray($query_id)))) {
			$errors++;
		}
	}

	$name = trim(stripinput($_POST['name']));
	if(empty($name)) {
		$errors++;
	}
	$homepage = stripinput($_POST['homepage']);
	$desc = stripinput($_POST['desc']);
	$abstract = stripinput($_POST['abstract']);
	$copyright = stripinput($_POST['copyright']);
	$license_id = stripinput($_POST['license_id']);
	$lizenz_okay = isset($_POST['lizenz_okay']) ? "Y" : "N";
	$lizenz_packet = isset($_POST['lizenz_packet']) ? "Y" : "N";
	$lizenz_url = stripinput($_POST['lizenz_url']);

	$now = time();

	if(!$errors) {
		if(!$download->id) {
			$ok = dbquery("INSERT INTO ".DB_PDP_DOWNLOADS."
				SET
				dl_count='0',
				user_id='".$userdata['user_id']."',
				dl_ctime='".$now."',
				dl_mtime='".$now."',
				dl_desc='',
				max_pics='".$pdp->settings['default_max_pics']."'");
			$download->id = mysql_insert_id();

			$download->set_status(PDP_PRO_NEW);
		} else {
			$download->set_status(PDP_PRO_OFF);
		}

		$ok = dbquery("UPDATE ".DB_PDP_DOWNLOADS."
			SET
			cat_id='".$cat."',
			dl_name='".$name."',
			dl_desc='".$desc."',
			dl_abstract='".$abstract."',
			dl_copyright='".$copyright."',
			license_id='".$license_id."',
			lizenz_okay='".$lizenz_okay."',
			lizenz_packet='".$lizenz_packet."',
			lizenz_url='".$lizenz_url."',
			dl_homepage='".$homepage."'
			WHERE download_id='".$download->id."'");

		$download->log_event($download->status==PDP_PRO_NEW
			? PDP_EV_NEW : PDP_EV_DESC, 0);

		if($ok) {
			if($download->status==PDP_PRO_NEW) {
				fallback('edit_files.php?did='.$download->id);
			}
			fallback(FUSION_SELF.'?did='.$download->id.'&errno=0');
		}
	}
}



/****************************************************************************
 * CREATE
 */
$all_cats = array();

$query_id = dbquery("SELECT  cat_name, top_cat, cat_id, cat_upload_access"
	." FROM ".DB_PDP_CATS.""
	.(iPDP_MOD ? "" : " WHERE ".groupaccess("cat_upload_access"))
	." ORDER BY cat_order ASC");
while($data = dbarray($query_id)) {
	$all_cats[$data['cat_id']] = array(
		"name"		=> $data['cat_name'],
		"parentcat"	=> $data['top_cat'],
		"access"	=> $data['cat_upload_access'],
	);
}

function pdp_tmp_show_cat($parentid, $cat_array, $level, $sel_this) {
	$retval = "";
	foreach($cat_array as $myid => $thiscat) {
		if($thiscat['parentcat']==$parentid
			&& checkgroup($thiscat['access'])) {

			$retval .= "<option value='$myid'"
				.($sel_this==$myid ?
					' selected="selected"'
					: ''
				).'>'.str_repeat("&nbsp;", $level*4)
					.$thiscat['name'].'</option>';

			$retval .= pdp_tmp_show_cat($myid, $cat_array,
				$level+1, $sel_this);
		}
	}
	return $retval;
}

$sel_cats = pdp_tmp_show_cat(0, $all_cats, 0,
	$download->id ? $download->data['cat_id'] : $cat);
if(empty($sel_cats)) {
	fallback("error.php?type=cats");
}



/*
 * GUI
 */
if(!$download->id || $download->status==PDP_PRO_NEW) {
	pdp_upload_step(1, $download->id ? "edit_files.php" : "");
	$button = $locale['PDP044']." 2";
	$caption = $locale['PDP103'];
} else {
	$button = $locale['PDP010'];
	$caption = $locale['PDP025'];
}

opentable($caption);
if(isset($_GET['errno'])) {
	pdp_process_errno($_GET['errno']);
}


if($errors) {
	echo "<p><div style='text-align:center;'><strong>".$locale['PDP011']
		."</strong></div></p>\n";
}


if($download->id) {
	$name = $download->data['dl_name'];
	$homepage = $download->data['dl_homepage'];
	$desc = $download->data['dl_desc'];
	$abstract = $download->data['dl_abstract'];
	$copy = $download->data['dl_copyright'];
//	$cat_id = $download->data['cat_id'];
	$li_id = $download->data['license_id'];
	$li_ok = ($download->data['lizenz_okay']=="Y" ? "checked" : "" );
	$li_pa = ($download->data['lizenz_packet']=="Y" ? "checked" : "");
	$li_url = $download->data['lizenz_url'];
}


$query_id = dbquery("SELECT license_id, license_name"
	." FROM ".DB_PDP_LICENSES);
$sel_licenses = "<option value='0'>".$locale['PDP101']."</option>\n";
while($data = dbarray($query_id)) {
	$sel_licenses .= "<option value='".$data['license_id']."'"
		.($li_id==$data['license_id'] ? " selected" : "")
		.">".$data['license_name']
		."</option>\n";
}



$action = FUSION_SELF;
if($download->id) {
	$action .= '?did='.$download->id;
}


echo '
<form action="'.$action.'" method="post" name="inputform">

<p>
<label for="name">'.$locale['PDP002'].': *</label><br />
<input type="text" value="'.$name.'" size="50" maxlength="200"
	class="textbox" name="name" id="name">
</p>

<p>
<label for="cat">'.$locale['PDP012'].' *</label><br />
<select size="1" name="cat" id="cat" class="textbox">
	<option value="0">'.$locale['PDP033'].'</option>
	'.$sel_cats.'
</select>
</p>

<p>
<label for="homepage">'.$locale['PDP020'].':</label><br />
<input type="text" value="'.$homepage.'" size="50" maxlength="200" size="60"
	class="textbox" name="homepage" id="homepage"><br />
<span class="small2">'.$locale['PDP216'].'</span>
</p>

<p>
<label for="copyright">'.$locale['pdp_copyright'].':</label><br />
<input type="text" value="'.$copy.'" size="50" maxlength="255" class="textbox"
	name="copyright" id="copyright">
</p>

<p>
<fieldset>
<legend>'.$locale['PDP108'].':</legend>
<span class="small2">'.$locale['PDP109'].'</span><br />
<textarea rows="5" cols="75" class="textbox" name="abstract">'.$abstract.'</textarea><br />
'.pdp_get_bb_smileys('abstract', 0, false).'
</fieldset>
</p>

<p>
<fieldset>
<legend>'.$locale['PDP025'].':</legend>
<textarea rows="10" cols="75" class="textbox" name="desc">'.$desc.'</textarea><br />
'.pdp_get_bb_smileys('desc', 0, false).'
</fieldset>
</p>


<p>
<fieldset>
<legend>'.$locale['pdp_license'].':</legend>
<select size="1" name="license_id" class="textbox">'.$sel_licenses.'
</select><br />

<label><input type="checkbox" name="lizenz_okay" id="lo0" '.$li_ok.'>
'.$locale['PDP106'].'</label><br />

<label>'.$locale['PDP107'].':</label>
<input type="text" value="'.$li_url.'" maxlength="255" size="60"
	class="textbox" name="lizenz_url"><br />

<label><input type="checkbox" name="lizenz_packet" id="lp0" '.$li_pa.'>
'.$locale['PDP030'].'</label>

</fieldset>
</p>


<p>
	<input type="submit" class="button" value="'.$button.'" name="save">
</p>

</form>';

closetable();


require_once('include/die.php');
?>
