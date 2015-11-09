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
require_once('common.php');


function pdp_admin_menu()
{
	global $locale, $pdp;

	$admin_items = array(
		'../index.php'		=> '&lt;--',
		'admin.php'		=> $locale['PDP037'],
		'settings.php'		=> $locale['PDP700'],
		'cats.php'		=> $locale['PDP820'],
		'licenses.php'		=> $locale['PDP800'],
		'downloads.php'		=> $locale['pdp_downloads'],
		'misc.php'		=> $locale['pdp_misc'],
	);
	$w = intval(100 / count($admin_items));

	echo '
<table class="tbl-border" cellspacing="1" cellpadding="0" width="100%">
<colgroup>
	<col span="'.count($admin_items).'" width="'.$w.'%" />
</colgroup>
<tbody>
<tr>';
	foreach($admin_items as $href => $title) {
		$c = "tbl".($href==FUSION_SELF ? "1" : "2");
		echo '
	<td align="center" class="'.$c.'"><a href="'.$href.'">'.$title.'</a></td>';
	}
	echo '
</tr>
</tbody>
</table>

<div align="right">
	<strong><code>Professional Download System '.$pdp->settings['version'].'</code></strong></div>
<hr>';
}


function pdp_get_upload_max_filesize()
{
	$size = trim(ini_get("upload_max_filesize"));

	if(!empty($size)) {
		$last = strtolower(substr($size, -1));

		switch($last) {
		case 'g': $size *= 1024;
		case 'm': $size *= 1024;
		case 'k': $size *= 1024;
		}
	}

	return $size;
}

?>
