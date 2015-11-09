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
if(!defined('IN_FUSION')) {
	die();
}


define('PRP_ENOERR',		0);
define('PRP_EIMG',		1);
define('PRP_EACCESS',		2);	//
define('PRP_EURL',		3);
define('PRP_EFILE',		4);
define('PRP_EUPDIR',		5);
define('PRP_ECATS',		6);
define('PRP_EEXT',		7);
define('PRP_ESIZE',		8);
define('PRP_EIMGVERIFY',	9);
define('PRP_EUPDATED',		10);
define('PRP_EMAXREACHED',	11);
define('PRP_EUPLOAD',		100);
define('PRP_EUPLOAD1',		101);
define('PRP_EUPLOAD2',		102);
define('PRP_EUPLOAD3',		103);
define('PRP_EUPLOAD4',		104);
define('PRP_EUPLOAD5',		105);
define('PRP_EUPLOAD6',		106);
define('PRP_EUPLOAD7',		107);


if(file_exists(INFUSIONS.'reviews_panel/locale/'.$settings['locale'].'_edit.php')) {
	include(INFUSIONS.'reviews_panel/locale/'.$settings['locale'].'_edit.php');
} else {
	include(INFUSIONS.'reviews_panel/locale/English_edit.php');
}



/****************************************************************************
 * MENU
 */
if($review->id) {
	$items = array(
		'edit_desc.php'	=> array(
			'title'	=> $locale['PRP025'],
			'img'	=> 'view_text.png',
		),
		'edit_files.php' => array(
			'title'	=> $locale['PRP019'],
			'img'	=> 'tgz.png',
		),
		'edit_pics.php' => array(
			'title'	=> $locale['PRP015'],
			'img'	=> 'thumbnail.png',
		),
		'edit_misc.php' => array(
			'title'	=> $locale['prp_misc'],
			'img'	=> 'misc.png',
		),
	);
	if(iPRP_MOD) {
		$items['edit_comments.php'] = array(
			'title'	=> $locale['PRP021'],
			'img'	=> 'knotes.png',
		);
		$items['edit_admin.php'] = array(
			'title'	=> $locale['PRP450'],
			'img'	=> 'log.png',
		);
	}

	$colspan = (iPRP_MOD ? '2' : '2');

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
		<a href="'.$href.'?did='.$review->id.'"><img src="icons/'.$item['img'].'" alt="'.$item['title'].'" class="noborder"> '.$item['title'].'</a></td>';
	}

	echo '
<table border="0" cellspacing="1" class="tbl-border" width="100%">
<thead>
<tr>
	<th colspan="2">
		<a href="review.php?did='.$review->id.'">
		<img src="icons/gohome.png" alt="'.$locale['PRP026'].'" class="noborder">
		<strong>'.$review->data['dl_name'].'</strong></a>
	</th>
	<th colspan="2">';
//	if(iPRP_MOD) {//FIXME
//		echo "<br><a href='admin/admin.php'>".$locale['PRP016']."</a>\n";
//	}
	echo '
		<strong>'.$locale['prp_status'].':</strong>
			<a href="edit_misc.php?did='.$review->id.'">'
				.strtoupper($locale['PRP904'][$review->status]).'</a>';
	if($review->status==PRP_PRO_OFF) {
		if($prp->settings['need_verify']=='yes' && !iPRP_MOD) {
			echo '
<form method="post" action="edit_misc.php?did='.$review->id.'">
<span class="small2">'.$locale['PRP503'].'</span>
<br />
<input type="submit" class="button" name="check_review" value="'.$locale['PRP502'].'">
</form>';
		} else {
			echo '
<form method="post" action="edit_misc.php?did='.$review->id.'">
<input type="hidden" name="oh_yeah" value="jip">
<input type="submit" class="button" name="check_review" value="'.$locale['PRP505'].'">
</form>';
		}
	}
	echo '
	</th>';
	if(iPRP_ADMIN) {
		echo '
	<th colspan="2" style="text-align:right;">
		<a href="admin/admin.php"><img src="icons/configure.png" alt="'.$locale['PRP016'].'" /> '.$locale['PRP016'].'</a>
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


function prp_process_errno($errno) {
	global $locale;

	if($errno) {
		if(!isset($locale['PRP900'][$errno])) {
			return;
		}

		show_info('<img src="icons/messagebox_warning.png" alt="'.$locale['prp_warning'].'" style="float:left; padding-right:10px;" /> '.$locale['PRP900'][$errno], 'warning', true);

	} else {
		show_info($locale['PRP050'], 'info');
	}
}




function prp_upload_step($step, $next_addr="") {
	global $locale, $review;

	if(!isNum($step) || !isset($locale['PRP042'][$step])) {
		return;
	}

	opentable($locale['PRP047']);
	echo "<p>".$locale['PRP048'];

	$i = 1;
	foreach($locale['PRP042'] as $id => $title) {
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
			.$review->id."'>"
			."<b>".$locale['PRP045']."</b></a> ]</div>\n";
	}

	closetable();
}


function prp_upload_file($upload, $uploaddir, $maxfilesize, $ext,
	&$ret_filename) {

	if($upload['error']) {
		return PRP_EUPLOAD+$upload['error'];
	}

	if(!is_uploaded_file($upload['tmp_name'])) {
		return PRP_EUPLOAD;
	}
	if($upload['size'] > $maxfilesize) {
		return PRP_ESIZE;
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
		return PRP_EEXT;
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
		return PRP_EUPLOAD;
	}

	$ret_filename = $upload_name;
	return 0;	// no errors
}



function prp_ask_del($href, $url, $url_name, $url_id) {
	global $locale;

	opentable($locale['PRP008']);
	echo '
<table border="0" align="center" width="480px" cellspacing="5">
<tbody>
<tr>
	<td colspan="3" align="center">'.$locale['PRP130'].'</td>
</tr>
<tr>
	<td colspan="3" align="center"><strong>'
		.prp_cleanup_filename($url).'</strong></td>
</tr>
<tr>
	<td align="center" width="33%">
		<a href="'.$href.'&amp;'.$url_name.'='.$url_id
			.'&amp;del=1'
			.'&amp;with_file=1">'.$locale['PRP131'].'</a></td>
	<td align="center" width="33%">
		<a href="'.$href.'&amp;'.$url_name.'='.$url_id
			.'&amp;del=1" class="">'.$locale['PRP132'].'</a></td>
	<td align="center" width="33%">
		<a href="'.$href.'">'.$locale['PRP134'].'</a></td>
</tr>
</tbody>
</table>';
	closetable();
}


?>
