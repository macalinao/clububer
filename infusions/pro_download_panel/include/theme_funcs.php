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
if(!defined('IN_FUSION')) {
	die;
}
if(!empty($pdp->settings['theme'])) {
	include_once(INFUSIONS.'pro_download_panel/themes/'
		.$pdp->settings['theme'].'/theme.php');
}


if(!function_exists('pdp_render_cats')) {
function pdp_render_cats($catid, $in_down, &$path, &$cats)
{
	global $locale;

	echo '<hr />';

	// path
	$level = 0;
	$bullet = "&raquo";
	foreach($path as $data) {
		if($data['id']==$catid && !$in_down) {
			echo str_repeat("&nbsp;", $level*4).$bullet
				." <b>".$data['name']."</b><br />\n";
		} else {
			echo str_repeat("&nbsp;", $level*4).$bullet
				." <a href='download.php?catid=".$data['id']."'>"
					.$data['name']."</a><br />\n";
		}
		++$level;
	}

	// child cats
	foreach($cats as $id => $data) {
		$more = array();
		if($data['cnt_downs']) {
			$more[] = $data['cnt_downs']." ".$locale['pdp_downloads'];
		}
		if($data['cnt_cats']) {
			$more[] = $data['cnt_cats']." ".$locale['PDP222'];
		}

		echo str_repeat("&nbsp;", $level*4).$bullet
			." <a href='download.php?catid=$id'>".$data['name']."</a>";
		if(count($more)) {
			echo " (".implode(" - ", $more).")";
		}
		echo "<br />\n";
	}
}
}

if(!function_exists('pdp_render_downs')) {
function pdp_render_downs(&$downs, $rowstart, $per_page, $count, $link)
{
	global $locale;

	foreach($downs as $data) {
		if($data['is_new']) {
			$new = " <img src='icons/new.gif'"
				." alt='".$locale['pdp_new']."' />";
		} else {
			$new = "";
		}
		echo "<hr>
<table border='0' width='100%'>
<tr>
	<td width='1%'><img src='icons/project.gif' alt='' /></td>
	<td><b><a href='".$data['href']."'>".$data['name']."</a></b>$new<br />"
		."<span class='small2'>"
			.($data['user_id']
				? $locale['PDP214']." <a href='profile.php?id="
					.$data['user_id']."'>"
					.$data['user_name']."</a> "
				: "")
			.showdate("shortdate", $data['mtime'])."</span>"
	."</td>
	<td align='right' style='white-space:nowrap;'>"
		.$locale['pdp_downloads'].": ".$data['downloads']."<br />"
			.$locale['PDP021'].": ".$data['comments']."</td>
</tr>
<tr>
	<td colspan='3'>".$data['desc']."</td>
</tr>
</table>";
	}

	if($count > $per_page) {
		echo '
<p>
<div style="text-align:center;">'
	.makePageNav($rowstart, $per_page, $count, 3, $link).'
</div>';
	}
}
}

if(!function_exists('pdp_render_download')) {
function pdp_render_download($id, $data, $links, $files, $images, $old_data)
{
	global $locale, $pdp;

	$down_link = '';
	if(!$data['can_download']) {
		;
	} elseif(!empty($old_data['down']) || !empty($old_data['link_extern'])){
		$down_link = "file.php?did=".$id."&file_id=0";
	} elseif(count($files)) {
		$latest_download = array_shift($files);
		$down_link = "file.php?did=".$id
			."&file_id=".$latest_download['id'];
		$old_ver = $latest_download['ver'];
		$old_size = $latest_download['size'];
		array_unshift($files, $latest_download);
	}

	if(!empty($data['pic'])) {
		$pic = $data['pic'];
		$pic_id = 0;
	} elseif(count($images)) {
		$first_pic = $images[0];
		$pic = $first_pic['url'];
		$pic_id = $first_pic['id'];
	} else {
		$pic = "";
	}

	echo "<p><font size='+1'><b>".$data['name']."</b></font>\n";
	echo "<hr>\n";

echo "
<table border='0' cellspacing='2' width='100%' cellpadding='0'>
<tr>
	<td valign='top' colspan='2'>".$data['desc']."</td>
	<td width='150' valign='top' rowspan='2'>
	<table class='tbl-border' cellspacing='1' width='100%'>";
// version
if(!empty($old_data['version'])) {
	echo "<tr><td class='tbl2' align='center'>".$locale['PDP018']
		.":<br />".$old_data['version']."</td>";
}
// homepage
if(!empty($data['homepage'])) {
	echo "<tr><td class='tbl2' align='center'><a href='".$data['homepage']."'"
		." target='_blank'>".$locale['PDP020']."</a></td>";
}
// screenshot
if(!empty($pic)) {
	echo "<tr>
	<td align='center' class='tbl2'>"
		."<a href='image.php?did=".$id."&amp;pic_id=$pic_id'>"
			.$locale['PDP028']."</a></td>
</tr>";
}
// download count
echo "<tr>
	<td align='center' class='tbl2'>".$locale['pdp_downloads'].":<br />"
		.pdpCore::format_number($data['count'])."</td>
</tr>";
// FIXME TODO
if(!empty($old_data['size'])) {
	echo "<tr><td align='center' class='tbl2'>"
		.$locale['PDP029'].":<br />".$old_data['size']."</td></tr>";
}
if(!empty($data['license'])) {
	echo "<tr>
	<td align='center' class='tbl2'>".$data['license']."</td>
</tr>";
}
// who posted and when.
echo "<tr><td align='center' class='tbl2'>"
	.($data['user_id']
		?  "<a href='profile.php?id=".$data['user_id']."'>"
			.$data['user_name']."</a><br />"
		: "")
	.showdate("shortdate", $data['mtime'])."</td>
</tr>\n";
if(!empty($data['copyright'])) {
	echo "<tr>
	<td class='tbl2' align='center'>".$data['copyright']."</td>
</tr>\n";
}
if($data['allow_notify']) {
if($data['can_subscribe']) {
	echo "<tr>
	<td class='tbl2' align='center'>".($data['is_subscribing']
		? "<a href='include/do_did.php?did=".$id."&amp;subscibe=0'>".$locale['PDP060']."</a>"
		: "<a href='include/do_did.php?did=".$id."&amp;subscibe=1'>".$locale['PDP059']."</a>")
		."</td>
</tr>\n";
}
}
echo "</table></td>
</tr>
<tr>
	<td align='center' valign='bottom'>"
		.(empty($down_link)
			? $pdp->settings['download_restricted']
			: '<strong><a href="'.$down_link.'" target="_blank">'
				.$locale['PDP201'].'</a></strong>'
		)."</td>
</tr>
</table>
<hr>\n";


	// report broken downloads
	echo "<div align='right'>";
	if(iPDP_BROKEN) {
		echo "[ <a href='broken.php?did=".$id."'>".$locale['PDP024']
			."</a> ]<br />";
	}
	// edit link
	if(count($links)) {
		echo "<b>".$locale['pdp_edit'].":</b> [ "
			.implode(" | ", $links)." ]";
	}

	echo "</div>\n";


	// files
	if(count($files)) {
		echo '<strong>'.$locale['PDP200'].":</strong><ul>\n";
	}
	foreach($files as $data) {
		echo "<li>"
			.showdate("shortdate", $data['timestamp'])
			." - <b>".$data['ver']." - </b>"
			." <a href='file.php?did=".$id
				."&amp;file_id=".$data['id']."'"
				." title='".$data['url']."'>"
				.trimlink($data['url'], 40)."</a>"
			." (<span class='small2'>".$data['size']." - "
				.$data['desc'].")</span>"
			."</li>\n";
	}
	if(count($files)) {
		echo "</ul>\n";
	}
}
}


function pdp_menu()
{
	global $locale, $pdp, $userdata;

	$user_links = array();
	$admin_links = array();

	$user_links[] = "<a href='download.php'>".$locale['PDP037']."</a>";
	$user_links[] = "<a href='download.php?catid=0'>"
		.$locale['PDP820']."</a>";
	$user_links[] = "<a href='search.php'>".$locale['PDP040']."</a>";
	if(iMEMBER || iPDP_ADMIN || iPDP_MOD)
	{
		if(ff_db_count('(*)', DB_PDP_CATS,
			groupaccess('cat_upload_access')))
		{
				$user_links[] = "<a href='edit_desc.php'>"
					.$locale['PDP038']."</a>";
		}
		if(ff_db_count('(*)', DB_PDP_DOWNLOADS,
			"user_id='".$userdata['user_id']."'")
			|| ff_db_count('(*)', DB_PDP_NOTIFY,
				"user_id='".$userdata['user_id']."'"))
		{
			$user_links[] = "<a href='profile.php"
				."?id=".$userdata['user_id']."'>"
				.$locale['PDP160']."</a>";
		}
	}

	if(iPDP_MOD) {
		$admin_links[] = "<a href='mod.php'>".$locale['pdp_moderator']."</a>";
	}
	if(iPDP_ADMIN) {
		$admin_links[] = "<a href='admin/admin.php'>".$locale['PDP016']."</a>";
	}
	$admin_links[] = "<a href='copyright.php'>".$locale['PDP039']."</a>";

	pdp_render_menu($user_links, $admin_links);
}



if(!function_exists('pdp_render_menu')) {
function pdp_render_menu($user_links, $admin_links)
{
	global $locale, $stext;

	if(isset($_GET['stext'])) {
		$stext = stripinput($_GET['stext']);
	} else {
		$stext = '';
	}

	echo '
<div style="float:right;">'.implode(' | ', $admin_links).'</div>
<div>'.implode(' | ', $user_links).'</div>
<div style="clear:both;"></div>

<form action="search.php" method="get">
<input type="text" size="24" maxlength="24" name="stext" class="textbox" value="'.$stext.'" />
<input type="submit" value="'.$locale['PDP040'].'" class="button" />
</form>
';
}
}



?>
