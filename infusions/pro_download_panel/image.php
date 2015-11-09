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
require_once('include/common.php');


if(!$download->id) {
	fallback('index.php');
}


if(isset($_GET['pic_id']) && isNum($_GET['pic_id'])) {
	$pic_id = $_GET['pic_id'];
} else {
	$pic_id = 0;
}



/****************************************************************************
 * GUI
 */
opentable($download->data['dl_name']);
echo '
<p>
	<a href="download.php?did='.$download->id.'">'.$locale['PDP026'].'</a>
<p>';


$links = array();
$cur_pic = '';

if(!empty($download->data['dl_pic'])) {
	$links[] = '<a href="'.FUSION_SELF.'?did='.$download->id.'">'
		.$download->data['dl_name'].'</a>';
	$cur_pic = array(
		'pic_id'	=> 0,
		'pic_url'	=> $download->data['dl_pic'],
		'pic_desc'	=> $download->data['dl_name'],
	);
}


$res = dbquery("SELECT pic_id, pic_url, pic_desc
	FROM ".DB_PDP_IMAGES."
	WHERE download_id='".$download->id."' AND pic_status='0'");
while($data = dbarray($res)) {
	if($data['pic_id']==$pic_id) {
		$pic_id = $data['pic_id'];
		$cur_pic = $data;
		$data['pic_desc'] = "<strong>".$data['pic_desc'].'</strong>';
	}

	$links[] = '<a href="'.FUSION_SELF."?did=".$download->id
		.'&amp;pic_id='.$data['pic_id'].'">'
		.$data['pic_desc'].'</a>';
}


if(!is_array($cur_pic)) {
	$download->fallback_download();
}


echo '
<div style="text-align: center;">
'.implode(' | ', $links).'
<p>
<img src="'
	.(!pdp_is_external($cur_pic['pic_url'])
		? $pdp->settings['upload_image']
		: ''
	).$cur_pic['pic_url'].'" alt="'.$cur_pic['pic_desc'].'" />

<p>'
	.$cur_pic['pic_desc'].'
</p>
</div>';


closetable();


require_once('include/die.php');
?>
