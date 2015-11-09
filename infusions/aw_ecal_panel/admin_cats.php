<?php
/***************************************************************************
 *   awEventCalendar                                                       *
 *                                                                         *
 *   Copyright (C) 2006-2008 Artur Wiebe                                   *
 *   wibix@gmx.de                                                          *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU General Public License as published by  *
 *   the Free Software Foundation; either version 2 of the License, or     *
 *   (at your option) any later version.                                   *
 ***************************************************************************/
require_once('include/common.php');
if(!iSUPERADMIN) {
	fallback('index.php');
}



$action = FUSION_SELF;
$button = 'awec_add';

if(isset($_GET['id']) && isNum($_GET['id'])) {
	$res = dbquery("SELECT cat_id, cat_name
		FROM ".AWEC_DB_CATS."
		WHERE cat_id='".$_GET['id']."'");
	if(!dbrows($res)) {
		fallback(FUSION_SELF);
	}

	$cat = dbarray($res);
	$button = 'awec_save_changes';
	$action .= '?id='.$cat['cat_id'];

} else {
	$cat = array(
		'cat_id'	=> 0,
		'cat_name'	=> '',
	);
}



/****************************************************************************
 * ACTION
 */
if(isset($_POST['save'])) {
	$cat['cat_name'] = trim(stripinput($_POST['name']));
	if(empty($cat['cat_name'])) {
		fallback(FUSION_SELF);
	}

	if(!$cat['cat_id']) {
		dbquery("INSERT INTO ".AWEC_DB_CATS." () VALUES ()");
		$cat['cat_id'] = mysql_insert_id();
	}

	$ok = dbquery("UPDATE ".AWEC_DB_CATS."
		SET
		cat_name='".$cat['cat_name']."'
		WHERE cat_id='".$cat['cat_id']."'");
	if($ok) {
		fallback(FUSION_SELF.'?errno=0');
	}

} elseif(isset($_GET['delete']) && $cat['cat_id']) {
	dbquery("DELETE FROM ".AWEC_DB_CATS."
		WHERE cat_id=".$cat['cat_id']);
	dbquery("DELETE FROM ".AWEC_DB_EVENTS_IN_CATS."
		WHERE cat_id=".$cat['cat_id']);
	fallback(FUSION_SELF);
}



/****************************************************************************
 * GUI
 */
opentable($locale['awec_cats']);
awec_menu();


if(isset($_GET['errno']) && isset($locale['EC717'][$_GET['errno']])) {
	show_info($locale['EC717'][$_GET['errno']]);
}



echo '
<form method="post" action="'.$action.'">
<div style="text-align:center;">
<input type="text" class="textbox" name="name" value="'.$cat['cat_name'].'"
	size="32" maxlength="100" />
<input type="submit" class="button" name="save" value="'.$locale[$button].'" />
</div>
</form>
<hr />';





$res = dbquery("SELECT cat_id, cat_name
	FROM ".AWEC_DB_CATS."
	ORDER BY cat_name ASC");
if(dbrows($res)) {
	echo '
<table align="center" cellspacing="1" class="tbl-border">
<colgroup>
	<col width="150" />
	<col width="150" />
</colgroup>
<thead>
	<th>'.$locale['awec_name'].'</th>
	<th></th>
</thead>
<tbody>';
} else {
	echo '<p><span class="small2">'.$locale['awec_none'].'</span></p>';
}
$count = 0;
while($row = dbarray($res)) {
	echo '
<tr class="tbl'.(++$count%2 + 1).'">
	<td>'.$row['cat_name'].'</td>
	<td>
		<a href="'.FUSION_SELF.'?id='.$row['cat_id'].'">'
			.$locale['awec_edit'].'</a>
		-
		<a href="'.FUSION_SELF.'?id='.$row['cat_id'].'&amp;delete">'
			.$locale['EC305'].'</a>
	</td>
</tr>';
}
if(dbrows($res)) {
	echo '
</tbody>
</table>';
}


closetable();


require_once('include/die.php');
?>
