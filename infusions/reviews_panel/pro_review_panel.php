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


require_once(INFUSIONS.'reviews_panel/include/core.php');
if(!iPRP_CAN_VIEW) {
	return;
}


/*
 * GUI
 */
openside($locale['prp_reviews']);


$get = array(
	'type'	=> 'none',
);


$downs = array();
prpCore::get_reviews($get, 'dl_mtime DESC', 0,
	$prp->settings['side_latest'], true, $downs, false);

echo '
<p>
	'.$locale['PRP300'].'
</p>
<ul>';
//<table width='100%' cellspacing='0' cellpadding='0'>\n";
foreach($downs as $data) {
	echo '
	<li><a href="'.INFUSIONS.'reviews_panel/review.php'
		.'?did='.$data['id'].'" title="'.$data['name'].'">'
		.trimlink($data['name'], 18).'</a></li>';
}
echo '
</ul>';



$downs = array();
prpCore::get_reviews($get, 'dl_count DESC', 0,
	$prp->settings['side_top'], true, $downs, false);

echo '
<p>
'.str_replace('%s', $prp->settings['side_top'],
	$locale['PRP301']).'
</p>

<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tbody>';
foreach($downs as $data) {
	echo '
<tr>
	<td><a href="'.INFUSIONS.'reviews_panel/review.php?did='.$data['id'].'" title="'.$data['name'].'">'
		.trimlink($data['name'], 18).'</a></td>
	<td align="right">'.prpCore::format_number($data['reviews']).'</td>
</tr>';
}
echo '
</tbody>
</table>';


closeside();
?>
