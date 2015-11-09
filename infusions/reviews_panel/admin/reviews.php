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


/*
 * GUI
 */
opentable($locale['prp_reviews']);
prp_admin_menu();


echo "<p><div align='center'>[ <a href='../edit_desc.php'>"
	.$locale['prp_new']."</a> ]</div></p>\n";

//
$search = array(
	"A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R",
	"S","T","U","V","W","X","Y","Z","0","1","2","3","4","5","6","7","8","9"
);
echo "<p><table align='center' cellpadding='0' cellspacing='1' class='tbl-border'>
<tr>
	<td rowspan='2' class='tbl2' align='center'>".$locale['prp_view']."<br>
		<a href='".FUSION_SELF."'>".$locale['PRP751']."</a>"
	." | <a href='".FUSION_SELF."?show=inactive'>".$locale['PRP017']."</a>"
	." | <a href='".FUSION_SELF."?show=broken'>".$locale['PRP754']."</a>
	</td>";
for($i=0; $i<36!=""; $i++) {
	echo "<td align='center' class='tbl1'><div class='small'>"
		."<a href='".FUSION_SELF."?show=".$search[$i]."'>"
		.$search[$i]."</a></div></td>";
	if($i==17) {
		echo "\n</tr>\n<tr>\n";
//		echo "<td rowspan='2' class='tbl2'>"
//			."<a href='".FUSION_SELF."?sortby=all'>".$locale['prp_view']."</a></td>\n</tr>\n<tr>\n";
	} else {
		echo "\n";
	}
}
echo "</tr>
</table>
</p>\n";


// show all
$rowstart = 0;
if(isset($_GET['rowstart']) && isNum($_GET['rowstart'])) {
	$rowstart = $_GET['rowstart'];
}
$show = "";
$where_show = "";
if(isset($_GET['show'])) {
	$show = $_GET['show'];
	if(strlen($show)==1) {
		$where_show = "pd.dl_name LIKE '$show%'";
		echo "<p><b>".$locale['PRP752'].":</b> $show\n";
	} elseif($show=="inactive") {
		$where_show = "pd.dl_status='N'";
		echo "<p><b>".$locale['PRP753']."</b>\n";
	} elseif($show=="broken") {
		$where_show = "pd.dl_broken_count>0";
		echo "<p><b>".$locale['PRP848']."</b>\n";
	} elseif($show=="cat" && isset($_GET['id']) && isNum($_GET['id'])) {
		$where_show = "pd.cat_id='".$_GET['id']."'";
		echo "<p><b>".$locale['PRP846']."</b>\n";
	} elseif($show=="license" && isset($_GET['id']) && isNum($_GET['id'])) {
		$where_show = "pd.license_id='".$_GET['id']."'";
		echo "<p><b>".$locale['PRP847']."</b>\n";
	} else {
		$where_show = "";
		$show = "";
	}
}


// FIXME
$res = dbquery("SELECT SQL_CALC_FOUND_ROWS"
	." dl_mtime, dl_status, pd.review_id, dl_name,"
	." pd.cat_id, tu.user_name, pd.user_id, pdc.cat_name"
	." FROM ".DB_PRP_DOWNLOADS." AS pd"
	." LEFT JOIN ".DB_USERS." AS tu ON pd.user_id=tu.user_id"
	." LEFT JOIN ".DB_PRP_CATS." AS pdc ON pd.cat_id=pdc.cat_id"
	.(!empty($where_show) ? " WHERE $where_show" : "")
	." ORDER BY dl_name ASC"
	." LIMIT $rowstart,".$prp->settings['per_page']);

$all_reviews = dbarray(dbquery("SELECT FOUND_ROWS()"));
$all_reviews = array_shift($all_reviews);

if(!dbrows($res)) {
	echo "<p><b>".$locale['PRP022']."</b>\n";
} else {
	echo "
<table width='100%' cellspacing='1' class='tbl-border'>
<thead>
<tr>
	<th class='tbl2' width='1%'>".$locale['prp_status']."</th>
	<th class='tbl2' width='16'></th>
	<th class='tbl2'>".$locale['PRP002']."</th>
	<th class='tbl2'>".$locale['PRP012']."</th>
	<th class='tbl2'>".$locale['PRP052']."</th>
	<th class='tbl2' width='16'></th>
</tr>
</thead>
<tbody>\n";
}
$count = 1;
while($data = dbarray($res)) {
	$id = $data['review_id'];
	$tbl = "tbl".(++$count%2 + 1);

	echo "
<tr>
	<td class='".$tbl."'>".$locale['PRP904'][$data['dl_status']]."</td>
	<td class='".$tbl."'><a href='../edit_desc.php?did=$id'><img"
		." src='../icons/edit.png' alt='".$locale['prp_edit']."'"
		." title='".$locale['prp_edit']."' class='noborder'></a></td>
	<td class='".$tbl."'><a href='../review.php?did=$id'>".$data['dl_name']
		."</a></td>
	<td class='".$tbl."'>".$data['cat_name']."</td>
	<td class='".$tbl."' align='center'>"
		."<a href='../profile.php?id=".$data['user_id']."'>"
		.$data['user_name']."</a><br>"
	  	.showdate("shortdate", $data['dl_mtime'])."</td>
	<td class='".$tbl."'><a href='del_review.php?did=$id'><img"
		." src='../icons/editdelete.png' alt='".$locale['prp_delete']."'"
		." title='".$locale['prp_delete']."' class='noborder'></a>"
		."</td>\n</tr>\n";
}
if(dbrows($res)) {
	echo "</tbody>
</table>\n";
}

if($all_reviews > $prp->settings['per_page']) {
	$link = FUSION_SELF."?show=$show&";
	if(($show=="cat" || $show=="license")
		&& isset($_GET['id']) && isNum($_GET['id'])) {
		$link .= "id=".$_GET['id']."&";
	}
	echo "<div align='center'>"
		.makePageNav($rowstart, $prp->settings['per_page'],
		$all_reviews, $all_reviews, $link)."</div>";
}


closetable();


require_once('../include/die.php');
?>
