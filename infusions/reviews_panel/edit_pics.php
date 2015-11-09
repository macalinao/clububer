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
require_once(INCLUDES.'photo_functions_include.php');
if(!$review->can_edit) {
	$review->fallback_review();
}
require_once('include/edit.php');


$action = FUSION_SELF.'?did='.$review->id;
$pic = array(
	'pic_id'	=> 0,
	'pic_desc'	=> '',
	'pic_url'	=> '',
);
if(isset($_GET['pic_id']) && isNum($_GET['pic_id'])) {
	$res = dbquery("SELECT pic_id, pic_desc, pic_url
		FROM ".DB_PRP_IMAGES."
		WHERE review_id='".$review->id."'
			AND pic_id='".$_GET['pic_id']."'");
	if(!dbrows($res)) {
		fallback(FUSION_SELF.'?did='.$review->id);
	}
	$pic = dbarray($res);
	$action .= '&pic_id='.$pic['pic_id'];
}







$more_pics = ($review->data['max_pics']==0
	|| ff_db_count("(*)", DB_PRP_IMAGES,
		"review_id='".$review->id."'")<$review->data['max_pics']);



/****************************************************************************
 * ACTION
 */
$do_pm = false;
$log = false;
$log_errno = 0;
$log_event = PRP_EV_INVALID;

if(isset($_POST['save'])) {
	$pic['pic_desc'] = trim(stripinput($_POST['desc']));

	// UPLOAD
	if(isset($_FILES['upload']) && $_FILES['upload']['error']!=PRP_EFILE) {
		$log_event = PRP_EV_PICUPLOAD;

		if(!$more_pics) {
			$review->log_event($log_event, PRP_EMAXREACHED);
			fallback(FUSION_SELF.'?did='.$review->id.'&errno='.PRP_EMAXREACHED);
		}


		if(empty($prp->settings['image_ext'])) {
			fallback(FUSION_SELF.'?did='.$review->id);
		}
		if(!empty($review->data['dl_pic'])) {
			$review->log_event($log_event, PRP_EIMG);
			fallback(FUSION_SELF.'?did='.$review->id.'&errno='.PRP_EIMG);
		}
		if(!isset($_FILES['upload'])) {
			$review->log_event($log_event, PRP_EUPLOAD);
			fallback(FUSION_SELF."?did=".$review->id.'&errno='.PRP_EUPLOAD);
		}

		$ext = explode(',', $prp->settings['image_ext']);
		foreach($ext as $key => $val) {
			$ext[$key] = '.'.$val;
		}

		$errno = prp_upload_file($_FILES['upload'],
			$prp->settings['upload_image'],
			$prp->settings['image_max'], $ext, $screen_fn);
		if($errno) {
			$review->log_event($log_event, $errno);
			fallback(FUSION_SELF.'?did='.$review->id.'&errno='.$errno);
		}

		$file = $prp->settings['upload_image'].$screen_fn;
		if(!verify_image($file)) {
			$review->log_event($log_event, PRP_EIMGVERIFY);
			unlink($file);
			fallback(FUSION_SELF."?did=".$review->id
				."&errno=".PRP_EIMGVERIFY);
		}

		// check size
		if($prp->settings['image_max_w']) {
			$size = getimagesize($file);
			if($size===false) {
				$log_event = PRP_EV_PICUPLOAD;
				$errno = PRP_EFILE;
				$review->log_event($log_event, $errno);
				fallback(FUSION_SELF."?did=".$review->id."&errno=$errno");
			}

			if($size[0]>$prp->settings['image_max_w']
				|| $size[1]>$prp->settings['image_max_h']) {
					// scale
				if($prp->settings['image_scale']=="yes") {
					$imagefile = @getimagesize($file);
					createthumbnail($imagefile[2],
						$file, $file,
						$prp->settings['image_max_w'],
						$prp->settings['image_max_h']);
					// do not scale
				} else {
					@unlink($file);
					$log_event = PRP_EV_PICSIZE;
					$errno = PRP_ESIZE;
					$review->log_event($log_event, $errno);
					fallback(FUSION_SELF.'?did='.$review->id.'&errno='.$errno);
				}
			}
		}

		$screen_fn = "'$screen_fn'";

	// FTP
	} elseif(isset($_POST['select_ftp']) && !empty($_POST['select_ftp'])) {
		$log_event = PRP_EV_PICFTP;

		if(!iPRP_MOD) {
			$review->log_event($log_event, PRP_EACCESS);
			fallback(FUSION_SELF.'?did='.$review->id
				.'&errno='.PRP_EACCESS);
		}

		$screen_fn = stripinput($_POST['select_ftp']);
		$file = $prp->settings['upload_image'].$screen_fn;

		if(!file_exists($file) || !is_readable($file)) {
			$review->log_event($log_event, PRP_EFILE);
			fallback(FUSION_SELF.'?did='.$review->id
				.'&errno='.PRP_EFILE);
		}
		$screen_fn = "'$screen_fn'";
		echo '<p>['.$screen_fn.']';

	// URL
	} elseif(isset($_POST['url'])) {
		$log_event = PRP_EV_PICURL;
		$screen_fn = "'".trim(stripinput($_POST['url']))."'";

		if(!iPRP_MOD && !prp_is_external($pic['pic_url'])) {
			$review->log_event($log_event, PRP_EURL);
			fallback(FUSION_SELF."?did=".$review->id
				."&errno=".PRP_EURL);
		}

	// change DESC only
	} elseif($pic['pic_id']) {
		$log_event = PRP_EV_PICDESC;
		$screen_fn = "pic_url";

	} else {
		fallback(FUSION_SELF."?did=".$review->id);
	}

	if(empty($pic['pic_desc'])) {
		$pic['pic_desc'] = str_replace("'", "", $screen_fn);
	}

	if(!$pic['pic_id']) {
		$ok = dbquery("INSERT INTO ".DB_PRP_IMAGES.""
			." SET review_id='".$review->id."'");
		if($ok) {
			$pic['pic_id'] = mysql_insert_id();
		}
	}
	if($pic['pic_id']) {
		// XXX - $screen_fn can be col
		$ok = dbquery("UPDATE ".DB_PRP_IMAGES."
			SET
			pic_desc='".$pic['pic_desc']."',
			pic_url=".$screen_fn."
			WHERE pic_id='".$pic['pic_id']."'
				AND review_id='".$review->id."'");
	}

	$do_pm = true;
	$log_errno = 0;
	$log = true;


} elseif(isset($_GET['ask_del']) && $pic['pic_id']) {
	$text = $pic['pic_url'];
	if(!is_writeable($prp->settings['upload_image'])) {
		$text .= '<p><span class="small2">'
			.str_replace('%s',
			'<strong>'.$prp->settings['upload_image'].'</strong>',
			$locale['PRP885']).'</span></p>';
	}
	prp_ask_del(FUSION_SELF.'?did='.$review->id, $text,
		'pic_id', $pic['pic_id']);


} elseif(isset($_GET['del']) && $pic['pic_id']) {
	$log_event = PRP_EV_DELPIC;
	$log = true;
	$do_pm = true;

	if(!iPRP_MOD || isset($_GET['with_file'])) {
		if(is_writeable($prp->settings['upload_image'])) {
			@unlink($prp->settings['upload_image'].$pic['pic_url']);
		}
	}
	dbquery("DELETE FROM ".DB_PRP_IMAGES."
		WHERE review_id='".$review->id."'
			AND pic_id='".$pic['pic_id']."'");

} elseif(isset($_POST['desc']) && $pic['pic_id']) {
	$log_event = PRP_EV_PICDESC;
	$log = true;
	$do_pm = true;
	$log_errno = 0;
	$ok = dbquery("UPDATE ".DB_PRP_IMAGES."
		SET
		pic_desc='".stripinput($_POST['desc'])."'
		WHERE review_id='".$review->id."' AND pic_id='".$pic['pic_id']."'");
}


if($log) {
	$review->log_event($log_event, $log_errno);
}
if($do_pm) {
	if($review->status!=PRP_PRO_NEW) {
		$review->set_status(PRP_PRO_OFF);
	}
	fallback(FUSION_SELF.'?did='.$review->id);
}


/*
 * GUI
 */
if(isset($_GET['errno'])) {
	prp_process_errno($_GET['errno']);
}

if($review->status==PRP_PRO_NEW) {
	prp_upload_step(3, "edit_misc.php", $review->id);
}


/*
 * GUI
 */
opentable($locale['PRP015']);


if($review->data['max_pics']) {
	echo "<p><strong>".str_replace("%s", $review->data['max_pics'],
		$locale['PRP151'])."</strong>\n";
}


$res = dbquery("SELECT pic_id, pic_desc, pic_url"
	." FROM ".DB_PRP_IMAGES.""
	." WHERE review_id='".$review->id."'");
echo '<p></p>
<table border="0" cellspacing="1" width="100%" class="tbl-border">
<thead>
<tr>
	<th width="16"></th>
	<th>'.$locale['PRP025'].' [<a href="'.FUSION_SELF.'?did='.$review->id.'">'.$locale['prp_new'].'</a>]</th>
	<th>'.$locale['PRP217'].'</th>
	<th width="16"></th>
</tr>
</thead>
<tbody>';
$count = 1;
while($data = dbarray($res)) {
	$id = $data['pic_id'];

	echo '
<tr class="tbl'.(++$count%2+1).'">
	<td><a href="'.FUSION_SELF.'?did='.$review->id.'&amp;pic_id='.$id.'">'
		.'<img src="icons/edit.png" alt="'.$locale['prp_edit'].'" border="0" title="'.$locale['prp_edit'].'"></a></td>
	<td>'.$data['pic_desc'].'</td>
	<td><a href="'.$prp->settings['upload_image']
		.$data['pic_url'].'">'.$data['pic_url'].'</a></td>
	<td><a href="'.FUSION_SELF.'?did='.$review->id.'&amp;pic_id='.$id
		.'&amp;ask_del=1"><img src="icons/editdelete.png" alt="'.$locale['prp_delete'].'" title="'.$locale['prp_delete'].'" class="noborder"></a></td>
</tr>';
}
echo '
</tbody>
</table>';


// ftp files
if(iPRP_MOD) {
	$files = array();
	$handle = opendir($prp->settings['upload_image']);
	while(false !== ($file=readdir($handle))) {
		if(in_array($file, array(".", "..", "/", "index.php"))) {
			continue;
		}
		if(!is_dir($prp->settings['upload_file'].$file)) {
			$files[] = $file;
		}
	}
	closedir($handle);
	ksort($files);

	$sel_ftp = "<select class='textbox' name='select_ftp'>\n";
	$sel_ftp .= "<option value=''>".$locale['PRP033']."</option>\n";
	$last_group = "";
	foreach($files as $file) {
		if($last_group != strtoupper(substr($file, 0, 1))) {
			if(!empty($last_group)) {
				$sel_ftp .= "</optgroup>\n";
			}
			$last_group = strtoupper(substr($file, 0, 1));
			$sel_ftp .= "<optgroup label='$last_group'>\n";
		}
		$sel_ftp .= "<option";
		if($pic['pic_id'] && $pic['pic_url']==$file) {
			$sel_ftp .= " selected";
			$pic['pic_url'] = "";
		}
		$sel_ftp .= " value='$file'>$file</option>\n";
	}
	$sel_ftp .= "</optgroup>\n";

	$sel_ftp .= "</select>\n";
} else {
	$sel_ftp = "<span class='small2'>".$locale['PRP017']."</span>";
}


if(!is_writeable($prp->settings['upload_image'])) {
	$upload = "<span class='small2'>".str_replace("%s",
		"<b>".$prp->settings['upload_image']."</b>",
			$locale['PRP900'][PRP_EUPDIR])."</span>";
} elseif(!$more_pics) {
	$upload = "<span class='small2'>".str_replace("%s",
		$review->data['max_pics'], $locale['PRP152'])."</span>\n";
} else {
	if(empty($prp->settings['image_ext'])) {
		$upload = "<span class='small2'>".$locale['PRP055']."</span>";
	} else {
		if($pic['pic_id']) {
			$upload = '<strong>'.$pic['pic_url'].'</strong>';
		} else {
			$upload = "<input type='file' name='upload'"
				." class='textbox' size='50'><br />"
				."<span class='small2'>"
				.parsebytesize($prp->settings['image_max'])." / "
				.str_replace(",", ", ",
					$prp->settings['image_ext']);
			if($prp->settings['image_max_w']) {
				$upload .= "<br>".$prp->settings['image_max_w']
					."x".$prp->settings['image_max_h'];
				if($prp->settings['image_scale']=="yes") {
					$upload .= " (".$locale['PRP150'].")";
				}
			}
			$upload .= "</span>";
		}
	}
}


$src_url = '-';
if(!$pic['pic_id'] || prp_is_external($pic['pic_url'])) {
	$src_url = '<input type="text" class="textbox" name="url" maxlegth="255" size="60" value="'.$pic['pic_url'].'">';
}

closetable();



/****************************************************************************
 * GUI
 */
opentable($pic['pic_id'] ? $locale['prp_edit_entry'] : $locale['prp_new']);


echo '
<form method="post" action="'.$action.'" enctype="multipart/form-data">

<label>'.$locale['PRP025'].':</label><br />
<input type="textbox" name="desc" maxlegth="255" value="'.$pic['pic_desc'].'"
	size="50" /><br />
<span class="small2">'.$locale['PRP056'].'</span>

<p></p>
<fieldset>
<legend>'.$locale['PRP129'].'</legend>
<table border="0" width="100%">
<colgroup>
	<col width="100" />
	<col width="*" />
</colgroup>
<tbody>
<tr>
	<td valign="top">'.$locale['PRP219'].':</td>
	<td>'.$upload.'</td>
</tr>
<tr>
	<td></td>
	<td><strong>'.$locale['PRP133'].'</strong></td>
</tr>
<tr>
	<td>'.$locale['PRP218'].':</td>
	<td>'.$sel_ftp.'</td>
</tr>
<tr>
	<td></td>
	<td><strong>'.$locale['PRP133'].'</strong></td>
</tr>
<tr>
	<td>'.$locale['PRP217'].':</td>
	<td>'.$src_url.'</td>
</tr>
</tbody>
</table>
</fieldset>

<p></p>
<div style="text-align:center;">
	<input type="submit" class="button" name="save" value="'.$locale['PRP010'].'" />
</div>

</form>';

closetable();


require_once('include/die.php');
?>
