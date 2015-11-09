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
require_once('../include/admin.php');
if(!iPDP_ADMIN) {
	fallback('../index.php');
}


if(isset($_GET['id']) && isNum($_GET['id']) && $_GET['id']!=0) {
	$id = $_GET['id'];
} else {
	unset($id);
}


$errors = 0;


function pdp_cat_has_child($cat, $child)
{
	if($cat==$child) {
		return true;
	}

	$query_id = dbquery("SELECT cat_id"
		." FROM ".DB_PDP_CATS.""
		." WHERE top_cat='$cat'");
	while($data = dbarray($query_id)) {
		if($data['cat_id']==$child) {
			return true;
		}
		if(pdp_cat_has_child($data['cat_id'], $child)) {
			return true;
		}
	}

	return false;
}


/*
 * ACTION!
 */
// insert new or update existing.
if(isset($_POST['save'])) {
	$name = trim(stripinput($_POST['cat_name']));
	if(empty($name)) {
		$errors++;
	}

	$desc = stripinput($_POST['desc']);
	$sorting = stripinput($_POST['sort_field'])." "
		.stripinput($_POST['sort_dir']);
	$top_cat = intval($_POST['top_cat']);
	$access = intval($_POST['access']);
	$order = intval($_POST['order']);

	$upload_access = intval($_POST['upload_access']);
	if(!$upload_access) {
		$errors++;
//FIXME		$upload_access = 103;
	}

	$download_access = intval($_POST['download_access']);

	if(isset($id) && pdp_cat_has_child($id, $top_cat)) {
		fallback(FUSION_SELF."?id=$id&edit=1");
	}


	if(!$errors) {
		if(!isset($id)) {
			$ok = dbquery("INSERT INTO ".DB_PDP_CATS.""
				." () VALUES ()");
			$id = mysql_insert_id();
		}

		// update cat_order
		if(ff_db_count("(*)", DB_PDP_CATS,
			"top_cat='$top_cat' AND cat_order='$order' AND cat_id!='$id'")){
			$ok = dbquery("UPDATE ".DB_PDP_CATS.""
				." SET cat_order=cat_order+1"
				." WHERE top_cat='$top_cat' AND cat_order>='$order'");
		}


		$ok = dbquery("UPDATE ".DB_PDP_CATS.""
			." SET top_cat='$top_cat',"
			." cat_name='$name',"
			." cat_desc='$desc',"
			." cat_sorting='$sorting',"
			." cat_access='$access',"
			." cat_upload_access='".$upload_access."',"
			." cat_download_access='".$download_access."',"
			." cat_order='$order'"
			." WHERE cat_id='$id'");
		if($ok) {
			fallback(FUSION_SELF);
		}
	}

} elseif(isset($_GET['del']) && isset($id)) {
	if(ff_db_count("(*)", DB_PDP_DOWNLOADS, "cat_id='$id'")==0
		&& ff_db_count("(*)", DB_PDP_CATS, "top_cat='$id'")==0) {
		$ok = dbquery("DELETE FROM ".DB_PDP_CATS.""
			." WHERE cat_id='$id'");
	}
	fallback(FUSION_SELF);
}


// edit form
$top_cat = 0;
if(isset($_GET['new']) || isset($_GET['edit'])) {
	if(isset($id)) {
		$query_id = dbquery("SELECT cat_name, cat_desc, cat_sorting,"
			." cat_access, cat_upload_access, top_cat, cat_order,"
			." cat_download_access"
			." FROM ".DB_PDP_CATS.""
			." WHERE cat_id='$id'");
		if(!dbrows($query_id)) {
			fallback(FUSION_SELF);
		}
		$data = dbarray($query_id);
		$name = $data['cat_name'];
		$desc = $data['cat_desc'];
		$sorting = explode(" ", $data['cat_sorting']);
		$access = $data['cat_access'];
		$upload_access = $data['cat_upload_access'];
		$download_access = $data['cat_download_access'];
		$top_cat = $data['top_cat'];
		$order = $data['cat_order'];

		$action = FUSION_SELF."?id=$id";

	} else {
		$name = "";
		$desc = "";
		$sorting[0] = $locale['PDP823']['name'];
		$sorting[1] = $locale['PDP824']['ASC'];
		$access = 0;
		$upload_access = 103;
		$download_access = 0;
		$top_cat = 0;
		$order = 0;

		$action = FUSION_SELF;
	}

	$access_ops = "";
	$sel_upload_access = "";
	$sel_download_access = '';
        $user_groups = getusergroups();
        foreach($user_groups as $user_grp){
		list($gid, $gname) = $user_grp;

                $access_ops .= "<option value='$gid'"
			.($access==$gid ? " selected" : "")
			.">$gname</option>\n";

                $sel_download_access .= "<option value='".$gid."'"
			.($download_access==$gid ? ' selected="selected"' : '')
			.'>'.$gname.'</option>';

		if(!$gid) {
			continue;
		}
                $sel_upload_access .= "<option value='$gid'"
			.($upload_access==$gid ? " selected" : "")
			.">$gname</option>\n";
        }

	$sel_sort_by = "";
	foreach($locale['PDP823'] as $col => $text) {
		$sel_sort_by .= "<option value='$col'"
			.($sorting[0]==$col ? " selected" : "")
			.">$text</option>\n";
	}

	$sel_sort_dir = "";
	foreach($locale['PDP824'] as $col => $text) {
		$sel_sort_dir .= "<option value='$col'"
			.($sorting[1]==$col ? " selected" : "")
			.">$text</option>\n";
	}
}


/*
 * GET
 */
$all_cats = array();

$query_id = dbquery("SELECT  cat_name, top_cat, cat_id, cat_access,"
	." cat_sorting, cat_upload_access, cat_order, cat_download_access"
	." FROM ".DB_PDP_CATS.""
	." ORDER BY cat_order ASC");
while($data = dbarray($query_id)) {
	$all_cats[$data['cat_id']] = array(
		'name'		=> $data['cat_name'],
		'parentcat'	=> $data['top_cat'],
		'access'	=> $data['cat_access'],
		'upload_access'	=> $data['cat_upload_access'],
		'download_access'	=> $data['cat_download_access'],
		'sorting'	=> $data['cat_sorting'],
		'order'		=> $data['cat_order'],
	);
}
function pdp_tmp_show_cat($parentid, $cat_array, $level, $sel_this,
	&$ret_array, &$maxlevel, $dont_follow_this_cat) {
	$retval = "";
	foreach($cat_array as $myid => $thiscat) {
		if($thiscat['parentcat']==$parentid) {
			$ret_array[$myid] = array(
				'name'		=> $thiscat['name'],
				'access'	=> $thiscat['access'],
				'upload_access'	=> $thiscat['upload_access'],
				'download_access'	=> $thiscat['download_access'],
				'sorting'	=> $thiscat['sorting'],
				'level'		=> $level,
				'order'		=> $thiscat['order'],
			);
			if($level > $maxlevel) {
				$maxlevel = $level;
			}

//FIXME			if($myid!=$dont_follow_this_cat) {
				$retval .= "<option value='$myid'"
					.($sel_this==$myid ? " selected" : "")
					.">".str_repeat("&nbsp;", $level*4)
					.$thiscat['name']."</option>";

				$retval .= pdp_tmp_show_cat($myid, $cat_array,
					$level+1, $sel_this, $ret_array,
					$maxlevel, $dont_follow_this_cat);
//FIXME			}
		}
	}
	return $retval;
}
$cats_for_table = array();
$maxlevel = 0;
$sel_cats = "<option value='0'>".$locale['PDP821']."</option>\n"
	.pdp_tmp_show_cat(0, $all_cats, 0, $top_cat, $cats_for_table,
		$maxlevel, isset($id) ? $id : 0);
$maxlevel++;


/*
 * GUI
 */
opentable($locale['PDP820']);
pdp_admin_menu();



if(isset($_GET['new']) || isset($_GET['edit'])) {
	echo "<p>
<form action='$action' method='POST' name='inputform'>
<table align='center' cellspacing='1' class='tbl-border'>
<tr>
	<td class='tbl2'>".$locale['PDP002'].": *</td>
	<td class='tbl1'><input type='text' size='50' maxlength='50'"
		." class='textbox' name='cat_name' value='$name'></td>
</tr>
<tr>
	<td class='tbl2'>".$locale['PDP012'].":</td>
	<td class='tbl1'><select name='top_cat' size='1' class='textbox'>"
		."$sel_cats</select></td>
</tr>
<tr>
	<td class='tbl2'>".$locale['PDP822'].":</td>
	<td class='tbl1'><select name='sort_field' class='textbox'>"
		.$sel_sort_by."</select> <select name='sort_dir'"
			." class='textbox'>$sel_sort_dir</select>
	</td>
</tr>
<tr>
	<td class='tbl2'>".$locale['PDP829'].":</td>
	<td class='tbl1'><select name='access' class='textbox'>"
		.$access_ops."</select></td>
</tr>
<tr>
	<td class='tbl2'>".$locale['PDP827'].":</td>
	<td class='tbl1'><select name='upload_access' class='textbox'>"
		.$sel_upload_access."</select></td>
</tr>
<tr>
	<td class='tbl2'>".$locale['PDP826'].":</td>
	<td class='tbl1'><select name='download_access' class='textbox'>"
		.$sel_download_access."</select></td>
</tr>
<tr>
	<td class='tbl2'>".$locale['PDP828'].":</td>
	<td class='tbl1'><input type='text' name='order' class='textbox'"
		." size='5' value='$order'></td>
</tr>
<tr>
	<td class='tbl2'></td>
	<td class='tbl1'>
		<textarea cols='70' rows='5' maxlength='255' class='textbox'"
		." name='desc'>$desc</textarea><br>"
		.pdp_get_bb_smileys("desc", "0", false)."</td>
</tr>
<tr>
	<td class='tbl2' colspan='2' align='center'><input type='submit'"
		." value='".$locale['PDP010']."' class='button' name='save'>
	</td>
</tr>
</table>
</form>
</p>";
}


// show all cats
if(count($cats_for_table)) {
	echo '
<table align="center" class="tbl-border" cellspacing="1">
<thead>
<tr>
	<th width="16"></th>
	<th>'.$locale['PDP002']
		.' [<a href="'.FUSION_SELF.'?new=1">'.$locale['pdp_new']
		.'</a>]</th>
	<th colspan="'.$maxlevel.'">'.$locale['PDP828'].'</th>
	<th align="center">'.$locale['PDP829'].'</th>
	<th>'.$locale['PDP827'].'</th>
	<th>'.$locale['PDP826'].'</th>
	<th>'.$locale['PDP822'].'</th>
	<th  width="1" colspan="2">'.$locale['pdp_downloads'].'</th>
	<th  width="16"></th>
</tr>
</thead>
<tbody>';
$count = 1;
} else {
	if(!isset($_GET['new'])) {
		fallback(FUSION_SELF."?new=1");
	}
	echo "<p>".$locale['PDP825'];
}
foreach($cats_for_table as $cid => $data) {
	$edit_icon = '<a href="'.FUSION_SELF.'?id='.$cid.'&amp;edit=1">'
		.'<img src="../icons/edit.png" alt="'.$locale['pdp_edit'].'" title="'.$locale['pdp_edit'].'" class="noborder"></a>';

	$sorting = explode(' ', $data['sorting']);

	$dl_count = ff_db_count('(*)', DB_PDP_DOWNLOADS, "(cat_id='$cid')");
	$child_cats = ff_db_count('(*)', DB_PDP_CATS, "(top_cat='$cid')");

	if($dl_count || $child_cats) {
		$del_icon = "<img src='../icons/nodelete.gif'"
			." alt='' class='noborder'>";
	} else {
		$del_icon = "<a href='".FUSION_SELF."?id=$cid&amp;del=1'"
			." title='".$locale['pdp_delete']."'>"
				."<img src='../icons/editdelete.png'"
				." alt='".$locale['pdp_delete']."' title='".$locale['pdp_delete']."' class='noborder'></a>";
	}
	if($dl_count) {
		$view_icon = '<a href="downloads.php?show=cat&amp;id='.$cid.'"><img src="../icons/viewmag.png" class="noborder" alt="'.$locale['pdp_view'].'" title="'.$locale['pdp_view'].'"></a>';
	} else {
		$view_icon = '';
	}

//	$order_cols = "<td class='$tbl'>".str_repeat("&nbsp;", $data['level']*5)
//		.$data['order'].":".$data['level']."</td>";
	$order_cols = "";
	for($i=0; $i<$data['level']; ++$i) {
		$order_cols .= "<td></td>";
	}
	$order_cols .= "<td>".$data['order']."</td>";
	for($i=$data['level']+1; $i<$maxlevel; ++$i) {
		$order_cols .= "<td></td>";
	}

	echo '
<tr class="tbl'.(1 + (++$count%2)).'">
	<td>'.$edit_icon.'</td>
	<td>'.str_repeat('&nbsp;', $data['level']*5)
		.$data['name'].'</td>
	'.$order_cols.'
	<td style="white-space:nowrap;">'
		.getgroupname($data['access']).'</td>
	<td style="white-space:nowrap;">'
		.getgroupname($data['upload_access']).'</td>
	<td style="white-space:nowrap;">'
		.getgroupname($data['download_access']).'</td>
	<td align="center">'.$locale['PDP823'][$sorting[0]].'<br />'
		.'<span class="small2">'.$locale['PDP824'][$sorting[1]]
		.'</span></td>
	<td width="16">'.$view_icon.'</td>
	<td align="center">'.$dl_count.'</td>
	<td>'.$del_icon.'</td>
</tr>';
}
if(count($cats_for_table)) {
	echo '
</tbody>
</table>';
}

closetable();


require_once('../include/die.php');
?>
