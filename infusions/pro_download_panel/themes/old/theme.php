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
if(!defined("IN_FUSION")) {
	die("");
}


function pdp_render_cats($catid, $in_down, &$path, &$cats)
{
	global $locale;

	// path
	$level = 0;
	$bullet = "<img src='".THEME."images/bullet.gif' alt=''>";
	$path_str = "";
	foreach($path as $data) {
		if($data['id']==$catid && !$in_down) {
			$path_str .= str_repeat("&nbsp;", $level*4).$bullet
				." <b>".$data['name']."</b><br>\n";
		} else {
			$path_str .= str_repeat("&nbsp;", $level*4).$bullet
				." <a href='?catid=".$data['id']."'>"
					.$data['name']."</a><br>\n";
		}
		++$level;
	}

	// wibix do not show sub cats on a specific download
	echo "<p><table border='0' width='100%' cellspacing='1'"
		." cellpadding='2' class='tbl-border'>\n"
		."<tr><td class='tbl2'>$path_str</td>";
	if(count($cats)) {
		echo "<td width='1%' valign='bottom' class='tbl2'>"
			."<b>".$locale['PDP222']."</b></td>"
			."<td width='1%' valign='bottom' class='tbl2'>"
			."<b>".$locale['pdp_downloads']."</b></td>";
	}
	echo "</tr>\n";
	
	// child cats
	$level = ($level*15)."px";
	foreach($cats as $id => $data) {
		echo "<tr>\n"
			."<td class='tbl1'><div style='margin-left:$level'>"
				."<img src='".THEME."images/bullet.gif'>"
				." <b><a href='".FUSION_SELF."?catid=$id'>"
				.$data['name']."</a></b>";
		if(!empty($data['desc'])) {
			echo "<br><span class='small2'>".$data['desc']
				."</span>";
		}
		echo "</div></td>\n"
			."<td align='center' class='tbl2' valign='top'>"
				.($data['cnt_cats']
					? $data['cnt_cats'] : "")."</td>\n"
			."<td align='center' class='tbl2' valign='top'>"
				.($data['cnt_downs']
					? $data['cnt_downs'] : "")."</td>\n"
			."</tr>\n";

	}

	echo "</table></p>\n";
}

?>
