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


require_once(INFUSIONS.'pro_download_panel/include/core.php');
if(!iPDP_CAN_VIEW) {
	return;
}


/*
 * GUI
 */
openside($locale['pdp_downloads']);


$get = array(
	'type'	=> 'none',
);


$downs = array();
pdpCore::get_downloads($get, 'dl_mtime DESC', 0,
	$pdp->settings['side_latest'], true, $downs, false);

echo '
<p>
	'.$locale['PDP300'].'
</p>
<ul>';
//<table width='100%' cellspacing='0' cellpadding='0'>\n";
foreach($downs as $data) {
	echo '
	<li><a href="'.INFUSIONS.'pro_download_panel/download.php'
		.'?did='.$data['id'].'" title="'.$data['name'].'">'
		.trimlink($data['name'], 18).'</a></li>';
}
echo '
</ul>';



$downs = array();
pdpCore::get_downloads($get, 'dl_count DESC', 0,
	$pdp->settings['side_top'], true, $downs, false);

echo '
<p>
'.str_replace('%s', $pdp->settings['side_top'],
	$locale['PDP301']).'
</p>

<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tbody>';
foreach($downs as $data) {
	echo '
<tr>
	<td><a href="'.INFUSIONS.'pro_download_panel/download.php?did='.$data['id'].'" title="'.$data['name'].'">'
		.trimlink($data['name'], 18).'</a></td>
	<td align="right">'.pdpCore::format_number($data['downloads']).'</td>
</tr>';
}
echo '
</tbody>
</table>';


closeside();
?>
