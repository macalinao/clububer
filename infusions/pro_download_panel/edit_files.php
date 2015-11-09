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
if(!$download->can_edit) {
	$download->fallback_download();
}
require_once('include/edit.php');


if(isset($_GET['file_id']) && isNum($_GET['file_id'])) {
	$file_id = $_GET['file_id'];
} else {
	unset($file_id);
}

$upload_dir = $pdp->settings['upload_file'].$download->data['dir_files'];


/****************************************************************************
 * FUNCS
 */
function pdp_get_files($path, $prefix, &$files, &$old_files)
{
	$handle = opendir($path);
	while(false !== ($file=readdir($handle))) {
		if(in_array($file, array('.', '..', '/', 'index.php',
			'.htaccess', '.htusers', '.htgroups'))) {
			continue;
		}
		if(!is_dir($path.$file)) {
			$files[$prefix.$file] = in_array($file, $old_files);
		}
	}
	closedir($handle);

	asort($files, SORT_NUMERIC);
}



/****************************************************************************
 * ACTION
 */
$need_redir = false;

$log = false;
$log_event = PDP_EV_INVALID;
$log_errno = 0;

if(isset($_POST['save'])) {	// FIXME
	$size = stripinput($_POST['size']);
	$url = "";

	// try FTP first
	if(isset($_POST['save_ftp']) && !empty($_POST['save_ftp'])) {
		$log_event = PDP_EV_FILEFTP;
		if(!iPDP_MOD) {
			$download->log_event($log_event, PDP_EACCESS);
			fallback(FUSION_SELF."?did=".$download->id
				."&errno=".PDP_EACCESS);
		}
		$url = stripinput($_POST['save_ftp']);
		if(empty($size)) {
			$size = parsebytesize(filesize($upload_dir.$url));
		}

	// try URL second
	} elseif(isset($_POST['url']) && !empty($_POST['url'])) {
		$log_event = PDP_EV_FILEURL;
		$url = stripinput($_POST['url']);
		if(!iPDP_MOD && !pdp_is_external($url)) {
			$download->log_event($log_event, PDP_EURL);
			fallback(FUSION_SELF."?did=".$download->id
				."&errno=".PDP_EURL);
		}

	// try UPLOAD last
	} elseif(isset($_FILES['upload'])
		&& $_FILES['upload']['error']!=UPLOAD_ERR_NO_FILE) {

		if(empty($pdp->settings['file_ext'])) {
			fallback(FUSION_SELF."?did=".$download->id);
		}

		$log_event = PDP_EV_FILEUPLOAD;

		// cannot be updated.
		if(isset($file_id)) {
			$download->log_event($log_event, PDP_EACCESS);
			fallback(FUSION_SELF."?did=".$download->id
				."&errno=".PDP_EACCESS);
		}

		$ext = explode(",", $pdp->settings['file_ext']);
		foreach($ext as $key => $val) {
			$ext[$key] = ".".$val;
		}

		$errno = pdp_upload_file($_FILES['upload'],
			$upload_dir,
			$pdp->settings['file_max'], $ext, $url);
		if($errno) {
			$download->log_event($log_event, $errno);
			fallback(FUSION_SELF."?did=".$download->id
				."&errno=$errno");
		}
		if(empty($size)) {
			$size = parsebytesize(filesize($upload_dir.$url));
		}
	} else {
		fallback(FUSION_SELF."?did=".$download->id);
	}

	$ver = stripinput($_POST['version']);
	$desc = stripinput($_POST['desc']);
	$now = time();
	if(empty($url)) {
		$url = "file_url";
	} else {
		$url = "'$url'";
	}
/*
	echo "<p><b>+ $url</b>\n";
	echo "<p><b>+ $size</b>\n";
*/

	// new
	if(!isset($file_id)) {
		$ok = dbquery("INSERT INTO ".DB_PDP_FILES.""
			." SET download_id='".$download->id."'");
		$file_id = mysql_insert_id();
	} else {
		$file_id = stripinput($_GET['file_id']);
	}

	// XXX - no '', cause can be a column
	$ok = dbquery("UPDATE ".DB_PDP_FILES."
		SET
		file_version='".$ver."',
		file_size='".$size."',
		file_desc='".$desc."',
		file_url=$url,
		file_timestamp='$now'
		WHERE file_id='".$file_id."'
			AND download_id='".$download->id."'");

	$log = true;
	$log_errno = 0;
	$need_redir = true;

} elseif(isset($_GET['askdel']) && isset($file_id)) {
	$res = dbquery("SELECT file_url
		FROM ".DB_PDP_FILES."
		WHERE file_id='".$file_id."'
			AND download_id='".$download->id."'");
	if(!dbrows($res)) {
		$download->log_event(PDP_EV_DELFILE, PDP_EFILE);
		fallback(FUSION_SELF."?did=".$download->id
			."&errno=".PDP_EFILE);
	}
	$url = array_shift(dbarray($res));


	// confirm
	if(pdp_is_external($url)) {
		fallback(FUSION_SELF."?did=".$download->id."&file_id=".$file_id
			."&del=1");
	}

	if(!is_writeable($upload_dir)) {
		$url .= '<br /><span class="small2">'
			.str_replace('%s', '<strong>'.$upload_dir.'</strong>',
				$locale['PDP885'])
			.'</span>';
	}
	pdp_ask_del(FUSION_SELF."?did=".$download->id, $url, "file_id", $file_id);
} elseif(isset($_GET['del']) && isset($file_id)) {
	$log_event = PDP_EV_DELFILE;

	$res = dbquery("SELECT file_url
		FROM ".DB_PDP_FILES."
		WHERE file_id='".$file_id."'
			AND download_id='".$download->id."'");
	if(!dbrows($res)) {
		$download->log_event($log_event, PDP_EFILE);
		fallback(FUSION_SELF."?did=".$download->id
			."&errno=".PDP_EFILE);
	}
	$url = array_shift(dbarray($res));

	if(isset($_GET['with_file'])) {
		@unlink($upload_dir.$url);
	}
	$ok = dbquery("DELETE FROM ".DB_PDP_FILES.""
		." WHERE file_id='".$file_id."'"
			." AND download_id='".$download->id."'");

	$log_errno = 0;
	$log = true;

	if($ok) {
		$need_redir = true;
	}
}


if($log) {
	$download->log_event($log_event, $log_errno);
}


if($need_redir && $download->status!=PDP_PRO_NEW) {
	if($download->set_status(PDP_PRO_OFF)) {
		fallback(FUSION_SELF."?did=".$download->id);
	}
}


/*
 * GUI - errno
 */
if(isset($_GET['errno'])) {
	pdp_process_errno($_GET['errno']);
}


/*
 * GUI
 */
$action = FUSION_SELF.'?did='.$download->id;

if($download->status==PDP_PRO_NEW) {
	pdp_upload_step(2, 'edit_pics.php', $download->id);
}



/*
 * GUI
 */
opentable($locale['PDP019']);


// files table
$files_in_table = array();
$res = dbquery("SELECT file_id, file_url, file_version, file_timestamp,
	file_desc, file_size
	FROM ".DB_PDP_FILES." AS ff
	WHERE download_id='".$download->id."'
	ORDER BY file_timestamp DESC");
if(!dbrows($res)) {
	echo '<p>'.$locale['PDP120'].'</p>';
} else {
	echo '
<table width="100%" cellspacing="1" class="tbl-border">
<colgroup>
	<col width="16" />
	<col width="16" />
	<col width="*" span="5" />
	<col width="16" />
</colgroup>
<thead>
<tr>
	<th></th>
	<th></th>
	<th>'.$locale['PDP018']
		.' [<a href="'.FUSION_SELF.'?did='.$download->id.'">'
			.$locale['pdp_new'].'</a>]</th>
	<th>'.$locale['PDP025'].'</th>
	<th>'.$locale['PDP013'].'</th>
	<th>'.$locale['PDP129'].'</th>
	<th>'.$locale['PDP029'].'</th>
	<th></th>
</tr>
</thead>
<tbody>';
}

$count = 1;
while($file = dbarray($res)) {
	$fid = $file['file_id'];
	$files_in_table[] = $file['file_url'];

	if(pdp_is_external($file['file_url'])) {
		$dl_icon = "external.gif";
		$dl_link = $file['file_url'];
	} else {
		$dl_link = $upload_dir.$file['file_url'];
		if(file_exists($dl_link)) {
			$dl_icon = "download.gif";
			$dl_link = '';//FIXME
		} else {
			$dl_icon = "nofile.gif";
			$dl_link = '';
		}
	}

	echo '
<tr class="tbl'.(++$count%2+1).'">
	<td><a href="'.$dl_link.'" target="_blank"><img src="icons/'.$dl_icon.'" alt="FIXME" class="noborder"></a></td>
	<td><a href="'.FUSION_SELF.'?did='.$download->id.'&amp;file_id='.$fid.'"><img src="icons/edit.png" class="noborder" alt="'.$locale['pdp_edit'].'" title="'.$locale['pdp_edit'].'"></a></td>
	<td>'.$file['file_version'].'</td>
	<td>'.$file['file_desc'].'</td>
	<td>'.showdate('shortdate', $file['file_timestamp']).'</td>
	<td>'.pdp_cleanup_filename($file['file_url']).'</td>
	<td>'.$file['file_size'].'</td>
	<td><a href="'.FUSION_SELF.'?did='.$download->id
		.'&amp;file_id='.$fid
		.'&amp;askdel=1">'
		.'<img src="icons/editdelete.png" alt="'.$locale['pdp_edit'].'" titl="'.$locale['pdp_edit'].'" class="noborder"></a></td>
</tr>';
//	echo "<tr><td class='tbl1'></td><td class='tbl1' colspan='5'>".$file['file_url']."</td></tr>\n";
}
if(dbrows($res)) {
	echo "</tbody>
</table>

<img src='icons/nofile.gif' alt=''>
".$locale['PDP046']."
<img src='icons/download.gif' alt=''>
".$locale['PDP218']."
<img src='icons/external.gif' alt=''>
".$locale['PDP127']."
";
}
closetable();



/****************************************************************************
 * EDIT FORM
 */
opentable(isset($file_id) ? $locale['PDP128'] : $locale['pdp_new']);

// form itself
$ver		= '';
$desc		= '';
$size		= '';
$url		= '';
$action		= FUSION_SELF.'?did='.$download->id;
$do_edit	= false;

if(isset($file_id)) {
	$res = dbquery("SELECT file_id, file_url, file_version, file_desc,
		file_size
		FROM ".DB_PDP_FILES."
		WHERE file_id='".$file_id."'
			AND download_id='".$download->id."'");
	if(!dbrows($res)) {
		fallback($action);
	}
	$data	= dbarray($res);
	$url	= $data['file_url'];
	$ver	= $data['file_version'];
	$desc	= $data['file_desc'];
	$size	= $data['file_size'];

	$action = FUSION_SELF.'?did='.$download->id.'&file_id='.$file_id;
	$do_edit = true;
}

// ftp files
if(iPDP_MOD) {
	$files = array();
	pdp_get_files($upload_dir, '', $files, $files_in_table);

	$sel_ftp = '
	<option value="">'.$locale['PDP033'].'</option>';
	$new = 0;
	foreach($files as $file => $old) {
		if($old===false) {
			if($new==0) {
				$new = 1;
				$sel_ftp .= '
<optgroup label="'.$locale['pdp_new_files'].'">';
			}
		} elseif($new==1) {
			$new = 2;
			$sel_ftp .= '
</optgroup>
<optgroup label="---">';
		}

		$sel_ftp .= '
	<option value="'.$file.'"';
		if($url==$file) {
			$sel_ftp .= ' selected="selected"';
			$url = '';
		}
		$sel_ftp .= '>'.$file.'</option>';
	}
	if($new==2) {
	$sel_ftp .= '
</optgroup>';
	}


	// OTHERS
	$src_url = '
<tr>
	<td><label>'.$locale['PDP217'].':</label></td>
	<td><input type="text" class="textbox" name="url"
		value="'.$url.'" size="40" maxlegth="200"></td>
</tr>
<tr>
	<td></td>
	<td><span class="small2">'.$locale['PDP216'].'</span></td>
</tr>';

	$src_ftp = '
<tr>
	<td><label>'.$locale['PDP218'].':</label></td>
	<td>
		<select size="1" name="save_ftp" class="textbox">'.$sel_ftp.'
		</select>
	</td>
</tr>
<tr>
	<td></td><td><strong>'.$locale['PDP133'].'</strong></td>
</tr>';
} else {
	$src_ftp = "";

	$src_url = '
<tr>
	<td><label>'.$locale['PDP217'].':</label></td>
	<td><input type="text" class="textbox" name="url"
		value="'.$url.'" size="40" maxlegth="200"></td>
</tr>
<tr>
	<td></td>
	<td><span class="small2">'.$locale['PDP220'].'</span></td>
</tr>';
}
if($do_edit || empty($pdp->settings['file_ext'])) {
	$src_upload = '';
} else {
	$src_upload = "
<tr>
	<td></td>
	<td><strong>".$locale['PDP133']."</strong></td>
</tr>
<tr>
	<td valign='top'>".$locale['PDP219'].":</td>\n";
	if(!is_writeable($upload_dir)) {
		$src_upload .= "<td><span class='small2'>".str_replace("%s",
			'<strong>'.$upload_dir.'</b>',
			$locale['PDP900'][PDP_EUPDIR])."</span></td>";
	} else {
		$src_upload .= "<td><input type='file' class='textbox' name='upload' size='50'></td>
</tr>
<tr>
	<td></td>
	<td><span class='small2'>".$locale['PDP034'].": "
		.parsebytesize($pdp->settings['file_max'])
		." (".str_replace(",", ", ", $pdp->settings['file_ext'])
		.")</span></td>\n";
	}
	$src_upload .= "</tr>\n";
}


// determine what to show and why
$src_read_only = "";
if($do_edit) {
	$is_external = pdp_is_external($url);
	if(iPDP_MOD) {
	} else {
		$src_ftp = "";
		if(!$is_external) {
			$src_url = "";
			$src_read_only = "<tr><td><b>"
				.pdp_cleanup_filename($url)."</b></td></tr>\n";
		}
	}
} else {
	if(iPDP_MOD) {
	} else {
	}
}



echo '
<form action="'.$action.'" method="post" name="editform"
	enctype="multipart/form-data">


<!--DOWNLOAD-SOURCE-BEGIN-->
<fieldset>
<legend>'.$locale['PDP129'].' *</legend>
<table border="0" width="100%">
<tbody>
'.$src_read_only.'
'.$src_ftp.'
'.$src_url.'
'.$src_upload.'
</tbody>
</table>
</fieldset>
<!--DOWNLOAD-SOURCE-END-->

<p></p>
<label>'.$locale['PDP018'].':</label><br />
<input type="text" class="textbox" name="version"
	value="'.$ver.'" maxlegth="20" size="20"></td>

<p></p>
<label>'.$locale['PDP029'].':</label><br />
<input type="text" class="textbox" name="size"
	value="'.$size.'" maxlegth="20" size="20"><br />
<span class="small2">'.$locale['PDP221'].'</span>

<p></p>
<label>'.$locale['PDP025'].':</label><br />
<input type="text" class="textbox" name="desc"
	value="'.$desc.'" maxlegth="100" size="60">

<p></p>
<input type="submit" class="button" name="save" value="'.$locale['PDP010'].'">
</form>';

closetable();


require_once('include/die.php');
?>
