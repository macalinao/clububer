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


if(isset($_GET['id']) && isNum($_GET['id'])) {
	$id = $_GET['id'];
} else {
	unset($id);
}


/*
 * ACTION
 */
if(isset($_POST['save'])) {
	$name = trim(stripinput($_POST['name']));
	if(empty($name)) {
		fallback(FUSION_SELF);
	}
	$text = addslash($_POST['text']);

	if(isset($id)) {
		$ok = dbquery("UPDATE ".DB_PDP_LICENSES.""
			." SET license_name='$name', license_text='$text'"
			." WHERE license_id='$id'");
	} else {
		$ok = dbquery("INSERT INTO ".DB_PDP_LICENSES.""
			." (license_name, license_text)"
			." VALUES ('$name', '$text')");
	}
	fallback(FUSION_SELF);

} elseif(isset($_GET['del']) && isset($id)) {
	if(!ff_db_count("(*)", DB_PDP_DOWNLOADS, "(license_id='$id')") != 0) {
		$ok = dbquery("DELETE FROM ".DB_PDP_LICENSES.""
			." WHERE license_id='$id'");
	}
	fallback(FUSION_SELF);
}

/*
 * GUI
 */
opentable($locale['PDP800']);
pdp_admin_menu();


if(isset($_GET['edit']) || isset($_GET['new'])) {
	if(isset($id)) {
		$query_id = dbquery("SELECT license_id, license_text,"
			." license_name"
			." FROM ".DB_PDP_LICENSES.""
			." WHERE license_id='$id'");
		$data = dbarray($query_id);
		$action = FUSION_SELF."?id=$id";
	} else {
		$data['license_text'] = "";
		$data['license_name'] = "";
		$action = FUSION_SELF;
	}
	echo "<form action='$action' method='POST'>
<div align='center'>
".$locale['PDP002'].": <input type='text' value='".$data['license_name']."'"
	." size='40' maxlength='255' name='name' class='textbox'>
<p>
<textarea cols='70' rows='15' class='textbox' name='text'>"
	.phpentities(stripslash($data['license_text']))."</textarea>
<p>
<input type='submit' value='".$locale['PDP010']."' class='button' name='save'>
</div>
<hr>
</form>\n";
}


/*
 * show all
 */
$query_id = dbquery("SELECT CHAR_LENGTH(license_text) AS length,"
	." license_id, license_name"
	." FROM ".DB_PDP_LICENSES.""
	." ORDER BY license_name ASC");
if(dbrows($query_id)) {
	echo "<table align='center' cellspacing='1' class='tbl-border'>
<thead>
<tr>
	<th class='tbl2' width='16'></th>
	<th class='tbl2' width='150'>".$locale['PDP002']
		." [<a href='".FUSION_SELF."?new=1'>"
			.$locale['pdp_new']."]</a></th>
	<th class='tbl2'>".$locale['PDP801']."</th>
	<th class='tbl2' colspan='2'># ".$locale['pdp_downloads']."</th>
	<th class='tbl2' width='16'></th>
</tr>
</thead>
<tbody>";
} else {
	if(!isset($_GET['new'])) {
		fallback(FUSION_SELF."?new=1");
	}
	echo "<p>".$locale['PDP802'];
}
$lcount = 0;
while($data = dbarray($query_id)) {
	$id = $data['license_id'];
	$count = ff_db_count("(*)", DB_PDP_DOWNLOADS, "(license_id='$id')");
	if($count) {
		$del_icon = '<img src="../icons/nodelete.gif" alt="">';
	} else {
		$del_icon = '<a href="'.FUSION_SELF.'?id='.$id.'&amp;del=1"'
			." title='".$locale['pdp_delete']."'>"
				.'<img src="../icons/editdelete.png" alt="'.$locale['pdp_delete'].'" title="'.$locale['pdp_delete'].'" class="noborder"></a>';
	}

	if($count) {
		$view_icon = '<a href="downloads.php?show=license&amp;id='.$id.'"><img src="../icons/viewmag.png" class="noborder" alt="'.$locale['pdp_view'].'" title="'.$locale['pdp_view'].'"></a>';
	} else {
		$view_icon = '';
	}

	echo '
<tr class="tbl'.(++$lcount%2+1).'">
	<td>
		<a href="'.FUSION_SELF.'?id='.$id.'&amp;edit=1"><img src="../icons/edit.png" alt="'.$locale['pdp_edit'].'" title="'.$locale['pdp_edit'].'" class="noborder"></a>
	</td>
	<td>'.$data['license_name'].'</td>
	<td>'.$data['length'].'</td>
	<td width="16">'.$view_icon.'</td>
	<td>'.$count.'</td>
	<td>'.$del_icon.'</td>
</tr>';
}
if(dbrows($query_id)) {
	echo '
</tbody>
</table>';
}

closetable();


require_once('../include/die.php');
?>
