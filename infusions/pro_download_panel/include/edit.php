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
	die();
}


define('PDP_ENOERR',		0);
define('PDP_EIMG',		1);
define('PDP_EACCESS',		2);	//
define('PDP_EURL',		3);
define('PDP_EFILE',		4);
define('PDP_EUPDIR',		5);
define('PDP_ECATS',		6);
define('PDP_EEXT',		7);
define('PDP_ESIZE',		8);
define('PDP_EIMGVERIFY',	9);
define('PDP_EUPDATED',		10);
define('PDP_EMAXREACHED',	11);
define('PDP_EUPLOAD',		100);
define('PDP_EUPLOAD1',		101);
define('PDP_EUPLOAD2',		102);
define('PDP_EUPLOAD3',		103);
define('PDP_EUPLOAD4',		104);
define('PDP_EUPLOAD5',		105);
define('PDP_EUPLOAD6',		106);
define('PDP_EUPLOAD7',		107);


if(file_exists(INFUSIONS.'pro_download_panel/locale/'.$settings['locale'].'_edit.php')) {
	include(INFUSIONS.'pro_download_panel/locale/'.$settings['locale'].'_edit.php');
} else {
	include(INFUSIONS.'pro_download_panel/locale/English_edit.php');
}



/****************************************************************************
 * MENU
 */
if($download->id) {
	$items = array(
		'edit_desc.php'	=> array(
			'title'	=> $locale['PDP025'],
			'img'	=> 'view_text.png',
		),
		'edit_files.php' => array(
			'title'	=> $locale['PDP019'],
			'img'	=> 'tgz.png',
		),
		'edit_pics.php' => array(
			'title'	=> $locale['PDP015'],
			'img'	=> 'thumbnail.png',
		),
		'edit_misc.php' => array(
			'title'	=> $locale['pdp_misc'],
			'img'	=> 'misc.png',
		),
	);
	if(iPDP_MOD) {
		$items['edit_comments.php'] = array(
			'title'	=> $locale['PDP021'],
			'img'	=> 'knotes.png',
		);
		$items['edit_admin.php'] = array(
			'title'	=> $locale['PDP450'],
			'img'	=> 'log.png',
		);
	}

	$colspan = (iPDP_MOD ? '2' : '2');

	$items2 = '';
	$w = intval(100/count($items))."%";
	foreach($items as $href => $item) {
		if($href==FUSION_SELF) {
			$tbl = 'tbl1';
		} else {
			$tbl = 'tbl2';
		}
		$items2 .= '
	<td class="'.$tbl.'" width="'.$w.'" align="center">
		<a href="'.$href.'?did='.$download->id.'"><img src="icons/'.$item['img'].'" alt="'.$item['title'].'" class="noborder"> '.$item['title'].'</a></td>';
	}

	echo '
<table border="0" cellspacing="1" class="tbl-border" width="100%">
<thead>
<tr>
	<th colspan="2">
		<a href="download.php?did='.$download->id.'">
		<img src="icons/gohome.png" alt="'.$locale['PDP026'].'" class="noborder">
		<strong>'.$download->data['dl_name'].'</strong></a>
	</th>
	<th colspan="2">';
//	if(iPDP_MOD) {//FIXME
//		echo "<br><a href='admin/admin.php'>".$locale['PDP016']."</a>\n";
//	}
	echo '
		<strong>'.$locale['pdp_status'].':</strong>
			<a href="edit_misc.php?did='.$download->id.'">'
				.strtoupper($locale['PDP904'][$download->status]).'</a>';
	if($download->status==PDP_PRO_OFF) {
		if($pdp->settings['need_verify']=='yes' && !iPDP_MOD) {
			echo '
<form method="post" action="edit_misc.php?did='.$download->id.'">
<span class="small2">'.$locale['PDP503'].'</span>
<br />
<input type="submit" class="button" name="check_download" value="'.$locale['PDP502'].'">
</form>';
		} else {
			echo '
<form method="post" action="edit_misc.php?did='.$download->id.'">
<input type="hidden" name="oh_yeah" value="jip">
<input type="submit" class="button" name="check_download" value="'.$locale['PDP505'].'">
</form>';
		}
	}
	echo '
	</th>';
	if(iPDP_ADMIN) {
		echo '
	<th colspan="2" style="text-align:right;">
		<a href="admin/admin.php"><img src="icons/configure.png" alt="'.$locale['PDP016'].'" /> '.$locale['PDP016'].'</a>
	</th>';
	}
	echo '
</tr>
</thead>
<tbody>
<tr>
	'.$items2.'
</tr>
</tbody>
</table>';
}


function pdp_process_errno($errno) {
	global $locale;

	if($errno) {
		if(!isset($locale['PDP900'][$errno])) {
			return;
		}

		show_info('<img src="icons/messagebox_warning.png" alt="'.$locale['pdp_warning'].'" style="float:left; padding-right:10px;" /> '.$locale['PDP900'][$errno], 'warning', true);

	} else {
		show_info($locale['PDP050'], 'info');
	}
}




function pdp_upload_step($step, $next_addr="") {
	global $locale, $download;

	if(!isNum($step) || !isset($locale['PDP042'][$step])) {
		return;
	}

	opentable($locale['PDP047']);
	echo "<p>".$locale['PDP048'];

	$i = 1;
	foreach($locale['PDP042'] as $id => $title) {
		if($i==$step) {
			$title = "<b>$title</b>";
			$img = "step_now";
		} elseif($i<$step) {
			$title = "<span class='small2'>$title</span>";
			$img = "files_ok";
		} else {
			$img = "files_no";
		}
		echo "<p><img src='icons/$img.gif' alt='' align='top'> $title<br>\n";
		$i++;
	}

	if(!empty($next_addr)) {
		echo "<p><div align='center'>[ <a href='$next_addr?did="
			.$download->id."'>"
			."<b>".$locale['PDP045']."</b></a> ]</div>\n";
	}

	closetable();
}


function pdp_upload_file($upload, $uploaddir, $maxfilesize, $ext,
	&$ret_filename) {

	if($upload['error']) {
		return PDP_EUPLOAD+$upload['error'];
	}

	if(!is_uploaded_file($upload['tmp_name'])) {
		return PDP_EUPLOAD;
	}
	if($upload['size'] > $maxfilesize) {
		return PDP_ESIZE;
	}

	// check filename for invalid chars.
	$patterns = array('/ü/', '/ö/', '/ä/', '/Ü/', '/Ö/', '/Ä/', '/ß/',
		'/[^\w._-]/');
	$replace = array('ue', 'oe', 'ae', 'Ue', 'Oe', 'Ae', 'ss', '_');
	$filename = preg_replace($patterns, $replace,
		strtolower($upload['name']));

	$posext = 0;
	foreach($ext as $try_this) {
		$upload_ext = substr($filename, -strlen($try_this));
		if($upload_ext==$try_this) {
			$posext = strlen($filename) - strlen($try_this);
			break;
		}
	}
	if(!$posext) {
		return PDP_EEXT;
	}

	$fileoext = substr($filename, 0, $posext);
	$upload_name = $fileoext.$upload_ext;
	// create a filename
	$i = 1;
	while(file_exists($uploaddir.$upload_name)) {
		$upload_name = $fileoext."__$i".$upload_ext;
		++$i;
		// FIXME: need an exit-condition?
	}

	if(!move_uploaded_file($upload['tmp_name'],
			$uploaddir.$upload_name)
		|| !chmod($uploaddir.$upload_name, 0666)) {	// oder 0644
		return PDP_EUPLOAD;
	}

	$ret_filename = $upload_name;
	return 0;	// no errors
}



function pdp_ask_del($href, $url, $url_name, $url_id) {
	global $locale;

	opentable($locale['PDP008']);
	echo '
<table border="0" align="center" width="480px" cellspacing="5">
<tbody>
<tr>
	<td colspan="3" align="center">'.$locale['PDP130'].'</td>
</tr>
<tr>
	<td colspan="3" align="center"><strong>'
		.pdp_cleanup_filename($url).'</strong></td>
</tr>
<tr>
	<td align="center" width="33%">
		<a href="'.$href.'&amp;'.$url_name.'='.$url_id
			.'&amp;del=1'
			.'&amp;with_file=1">'.$locale['PDP131'].'</a></td>
	<td align="center" width="33%">
		<a href="'.$href.'&amp;'.$url_name.'='.$url_id
			.'&amp;del=1" class="">'.$locale['PDP132'].'</a></td>
	<td align="center" width="33%">
		<a href="'.$href.'">'.$locale['PDP134'].'</a></td>
</tr>
</tbody>
</table>';
	closetable();
}


?>
