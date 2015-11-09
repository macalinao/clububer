<?php
/***************************************************************************
 *   Professional Review System                                          *
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


function prp_render_review($id, $data, $links, $files, $images, $old_data)
{
	global $locale;

	$down_link = '';
	$old_ver = $old_data['version'];

	if(!empty($old_data['down']) || !empty($old_data['link_extern'])) {
		$down_link = 'file.php?did='.$id.'&amp;file_id=0';
	} elseif(count($files)) {
		$latest_review = $files[0];
		$down_link = 'file.php?did='.$id
			.'&amp;file_id='.$latest_review['id'];
		$old_ver = $latest_review['ver'];
		$old_size = $latest_review['size'];
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

	echo "<hr />
<div style='float:right; width:200px; text-align:center;'>
<a href='$down_link' target='_blank' style='text-decoration: none; display: block; font-weight: bold; color: #ffffff; border:1px solid black; padding:5px; background-color:#0a0;'>".$locale['PRP201']."</a>";
	if(!empty($old_size)) {
		echo $locale['PRP029'].': '.$old_size;
	}
	echo "</div>

<span style='font-size:1.5em;'><strong>".$data['name']." $old_ver</strong></span>
<br />
<span class='small2'>".showdate("longdate", $data['mtime']);
	if($data['user_id']) {
		echo " ".$locale['PRP214']." <a href='profile.php?id="
				.$data['user_id']."'>".$data['user_name']
				."</a></span>";
	}
	echo "
<div style='clear:both;'></div>
<hr />
<div style='width:200px; float:right; margin-left:5px; margin-bottom:5px;'>
<!--begin side details-->
<table cellspacing='1' border='0' width='100%' class='tbl-border'>
<tr>
	<th colspan='2' style='text-align:center;'>".$locale['PRP053']."</th>
</tr>
<tr class='tbl1'>
	<td><strong>".$locale['prp_reviews'].":</strong></td>
	<td>".$data['count']."</td>
</tr>";
if(!empty($data['license'])) {
	echo '
<tr class="tbl1">
	<td><strong>'.$locale['prp_license'].':</strong></td>
	<td>'.$data['license'].'</td>
</tr>';
}
if(!empty($data['copyright'])) {
	echo '
<tr class="tbl1">
	<td><strong>'.$locale['prp_copyright'].':</strong></td>
	<td>'.$data['copyright'].'</td>
</tr>';
}
if(!empty($pic)) {
	echo '
<tr class="tbl1">
	<td><strong>'.$locale['PRP028'].':</strong></td>
	<td><a href="image.php?did='.$id.'&amp;pic_id='.$pic_id.'">'
			.$locale['PRP054'].'</a></td>
</tr>';
}
if(!empty($data['homepage'])) {
	echo '
<tr class="tbl1">
	<td><strong>'.$locale['PRP020'].':</strong></td>
	<td><a href="'.$data['homepage'].'" target="_blank">'
		.$locale['PRP054'].'</a></td>
</tr>';
}
if($data['allow_notify']) {
	if($data['can_subscribe']) {
		$subscribe_action = " (<a href='include/do_did.php?did=".$id
			."&amp;subscibe=";
		if($data['is_subscribing']) {
			$subscribe_action .= "0'>".$locale['PRP060'];
		} else
			$subscribe_action .= "1'>".$locale['PRP059'];
		$subscribe_action .= "</a>)";
	} else {
		$subscribe_action = "";
	}
	echo "<tr>
	<td class='tbl1'><b>".$locale['PRP061'].":</b></td>
	<td class='tbl1'>".$data['subscibers'].$subscribe_action."</td>
</tr>\n";
}
echo "
	</table>
<!--end side details-->
</div>
<div>".$data['desc']."</div>

<div style='clear:both;'></div>\n";


	// report broken reviews
	echo '<hr />
<div align="right">';
	if(iPRP_BROKEN) {
		echo "[ <a href='broken.php?did=".$id."'>".$locale['PRP024']
			."</a> ]<br />";
	}
	// edit link
	if(count($links)) {
		echo '<strong>'.$locale['prp_edit'].':</strong> [ '
			.implode(' | ', $links).' ]';
	}
	echo "</div>\n";


	// files
	if(count($files)) {
		echo '<strong>'.$locale['PRP200'].':</strong>
<ul>';
	}
	foreach($files as $data) {
		echo '
	<li>'.showdate("shortdate", $data['timestamp'])
			." - <b>".$data['ver']." - </b>"
			." <a href='file.php?did=".$id
				."&amp;file_id=".$data['id']."'"
					." title='".$data['url']."'>"
				.trimlink($data['url'], 40)."</a>"
			." (<span class='small2'>".$data['size']." - "
				.$data['desc'].")</span>"
//		."<img src='icons/"
//		.($data['is_external'] ? "external" : "review")
//			.".gif' alt='' border='0'></a> "
			."</li>\n";
	}
	if(count($files)) {
		echo "</ul>\n";
	}
}



function prp_render_downs(&$downs, $rowstart, $per_page, $count, $link)
{
	global $locale;

	echo '<hr />';

	if($count > $per_page) {
		$navi =  makepagenav($rowstart, $per_page, $count, 3, $link);
	} else {
		$navi = '';
	}

	echo $navi;

//	<td class='tbl1' valign='top'>".$data['desc']."</td>
	echo '
<table cellspacing="1" class="tbl-border" width="100%">
<colgroup>
	<col width="75%" />
	<col width="25%" />
</colgroup>
<tbody>';
	foreach($downs as $data) {
		if($data['is_new']) {
			$new = ' <img src="icons/new.gif"'
				.' alt="'.$locale['prp_new'].'" />';
		} else {
			$new = '';
		}

		if($data['votes']) {
			$rating = $locale['PRP205'][intval($data['avg_vote'])]
				." (".$data['votes']." ".$locale['PRP213'].")";
		} else {
			$rating = "-";
		}

		$info = '
<table border="0" width="100%">
<colgroup>
	<col width="1%" />
	<col width="99%" />
</colgroup>
<tbody>';
		if($data['user_id']) {
			$info .= '
<tr>
	<td><strong>'.$locale['PRP882'].':</strong></td>
	<td><a href="profile.php?id='.$data['user_id'].'">'
		.$data['user_name'].'</a></td>
</tr>';
		}
		$info .= '
<tr>
	<td><strong>'.$locale['PRP013'].':</strong></td>
	<td>'.showdate('shortdate', $data['mtime']).'</td>
</tr>
<tr>
	<td><strong>'.$locale['prp_reviews'].':</strong></td>
	<td>'.$data['reviews'].'</td>
</tr>
<tr>
	<td><strong>'.$locale['PRP021'].':</strong></td>
	<td>'.$data['comments'].'</td>
</tr>
<tr>
	<td><strong>'.$locale['PRP224'].':</strong></td>
	<td>'.$rating.'</td>
</tr>
</tbody>
</table>';

		echo '
<tr>
	<th colspan="2"><strong><a href="'.$data['href'].'">'
		.$data['name'].'</a></strong>'.$new.'</th>
</tr>
<tr class="tbl1">
	<td valign="top">'.$data['desc'].'</td>
	<td valign="top">'.$info.'</td>
</tr>';
	}
	echo '
</tbody>
</table>';

	echo $navi;
}


?>
