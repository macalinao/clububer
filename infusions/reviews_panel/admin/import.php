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
require_once('../include/admin.php');
if(!iPRP_ADMIN) {
	fallback('../index.php');
}


if(!defined('DB_DOWNLOADS')) {
	define('DB_DOWNLOADS',		DB_PREFIX.'reviews');
	define('DB_DOWNLOAD_CATS',	DB_PREFIX.'review_cats');
}


$imported = array();
$do_import = (isset($_GET['do_import']) && $_GET['do_import']=="yes");


/*
 * ACTION
 */
if($do_import) {
	foreach($_POST['take'] as $id => $val) {
		$query_id = dbquery("SELECT * FROM ".DB_DOWNLOADS
			." WHERE review_id='$id'");
		if(!dbrows($query_id)) {
			$imported[$id] = $locale['PRP866'];
			continue;
		}

		$imported[$id] = $locale['PRP043'];
		$data = dbarray($query_id);

		$name = $data['review_title'];
		$ver = $data['review_version'];
		$url = $_POST['down'][$id];
		$size= $data['review_filesize'];
		$datestamp = $data['review_datestamp'];
		$cat_id = $_POST['cat'][$id];
		$lid = $_POST['license'][$id];
		$desc = addslash($data['review_description']);

		$ok = dbquery("INSERT INTO ".DB_PRP_DOWNLOADS.""
			." SET"
			." cat_id='$cat_id', dl_name='$name',"
			." dl_desc='$desc',"
			." user_id='".$userdata['user_id']."',"
			." license_id='$lid', lizenz_okay='N',"
			." lizenz_packet='N',"
			." dl_count='".$data['review_count']."',"
			." dl_mtime='$datestamp', dl_ctime='$datestamp',"
			." dl_status='".PRP_PRO_ON."'");
		$id = mysql_insert_id();
		$ok = dbquery("INSERT INTO ".DB_PRP_FILES.""
			." SET"
			." review_id='$id',"
			." file_version='$ver',"
			." file_desc='',"
			." file_url='$url',"
			." file_size='$size',"
			." file_timestamp='$datestamp'");
	}

	// count cat reviews
	$query_id = dbquery("SELECT cat_id"
		." FROM ".DB_PRP_CATS."");
	while($data = dbarray($query_id)) {
		$count = ff_db_count("(*)", DB_PRP_DOWNLOADS,
			"(cat_id='".$data['cat_id']."'"
				." AND dl_status='".PRP_PRO_ON."')");
		$mysql[] = "UPDATE ".DB_PRP_CATS.""
			." SET"
			." count_reviews='".$count."'"
			." WHERE cat_id='".$data['cat_id']."'";
	}

	fallback(FUSION_SELF."?do_import=no");
}


/*
 * CREATE CAT SEL
 */
$all_cats = array();

$query_id = dbquery("SELECT  cat_name, top_cat, cat_id, cat_upload_access"
	." FROM ".DB_PRP_CATS.""
	." ORDER BY cat_order ASC");
while($data = dbarray($query_id)) {
	$all_cats[$data['cat_id']] = array(
		"name"		=> $data['cat_name'],
		"parentcat"	=> $data['top_cat'],
		"access"	=> $data['cat_upload_access'],
	);
}

function prp_tmp_show_cat($parentid, $cat_array, $level, $sel_this) {
	$retval = "";
	foreach($cat_array as $myid => $thiscat) {
		if($thiscat['parentcat']==$parentid
			&& checkgroup($thiscat['access'])) {

			$retval .= "<option value='$myid'"
				.($sel_this==$myid ? " selected" : "")
				.">".str_repeat("&nbsp;", $level*4)
				.$thiscat['name']."</option>";

			$retval .= prp_tmp_show_cat($myid, $cat_array,
				$level+1, $sel_this);
		}
	}
	return $retval;
}

$sel_cat = prp_tmp_show_cat(0, $all_cats, 0, 0);
if(empty($sel_cat)) {
	fallback("../error.php?type=cats");
}
$sel_cat = "<option value='0'>".$locale['PRP033']."</option>\n$sel_cat";


/*
 * CREATE LICENSE SEL
 */

$query_id = dbquery("SELECT license_id, license_name"
	." FROM ".DB_PRP_LICENSES);
$sel_license = "<option value='0'>".$locale['PRP033']."</option>\n";
while($data = dbarray($query_id)) {
	$sel_license .= "<option value='".$data['license_id']."'>"
		.$data['license_name']."</option>\n";
}



/*
 * GUI
 */
opentable($locale['PRP860']);
prp_admin_menu();


if(count($all_cats)==0) {
	show_info($locale['PRP825']);
}


// php fusion reviews -> pro/review reviews
$query_id = dbquery("SELECT review_title, review_cat_name, review_url,
	review_id, review_license
	FROM ".DB_DOWNLOADS."
	LEFT JOIN ".DB_DOWNLOAD_CATS."
		ON review_cat=review_cat_id");
echo "<p>".$locale['PRP863']."
<p><form method='post' action='".FUSION_SELF."?do_import=yes'>
<table class='tbl-border' width='100%' cellspacing='1'>
<tr>
	<th colspan='3'>".$locale['PRP864']."</th>
	<th width='1%'><img src='".THEME."images/right.gif' alt='--&gt;'></th>
	<th colspan='2'>".$locale['PRP865']."</th>
</tr>
<tr>
	<td class='tbl2' width='1%'></td>
	<td class='tbl2'><b>".$locale['PRP002']."</b></td>
	<td class='tbl2'><b>".$locale['PRP217']." / ".$locale['PRP012']." / ".$locale['prp_license']."</b></td>
	<td class='tbl2'><img src='".THEME."images/right.gif' alt='--&gt;'></td>
	<td class='tbl2'></td>
</tr>\n";
while($data = dbarray($query_id)) {
	$id = $data['review_id'];
	if(!isset($imported[$id])) {
		$imported[$id] = "";
	}

	echo "<tr>
	<td class='tbl1' style='white-space:nowrap;'>".$imported[$id]."<input type='checkbox' name='take[$id]' checked></td>
	<td class='tbl1'>".$data['review_title']."</td>
	<td class='tbl1' colspan='3'><input type='text' class='textbox' size='60'"
		." value='".$data['review_url']."' name='down[$id]'></td>
</tr>
<tr>
	<td class='tbl1'></td>
	<td class='tbl1'></td>
	<td class='tbl1'>".$data['review_cat_name']."</td>
	<td class='tbl2'><img src='".THEME."images/right.gif' alt='--&gt;'></td>
	<td class='tbl1'><select name='cat[$id]' class='textbox'>$sel_cat</select></td>
</tr>
<tr>
	<td class='tbl1'></td>
	<td class='tbl1'></td>
	<td class='tbl1'>".$data['review_license']."</td>
	<td class='tbl2'><img src='".THEME."images/right.gif' alt='--&gt;'></td>
	<td class='tbl1'><select name='license[$id]' class='textbox'>$sel_license</select></td>
</tr>
<tr>
	<td class='forum-caption' colspan='5'></td>
</tr>\n";
}
echo "</table>\n";
if($do_import) {
	echo "
<p>
	<strong>".$locale['PRP861']."</strong>
</p>\n";
} else {
	echo "
<p>
	<input type='submit' value='".$locale['PRP862']."' />
</p>\n";
}

echo "</form>\n";


closetable();


require_once('../include/die.php');
?>
