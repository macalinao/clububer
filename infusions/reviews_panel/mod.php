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
require_once('include/common.php');
require_once('include/theme_funcs.php');

if(!iPRP_MOD) {
	fallback('index.php');
}


/*
 * GUI
 */
opentable($locale['prp_moderator']);
prp_menu();
echo '<hr />';


$res = dbquery("SELECT review_id, dl_name,
	IF(dl_status='".PRP_PRO_ON."', 'broken', dl_status) as dl_status
	FROM ".DB_PRP_DOWNLOADS."
	WHERE dl_status!='".PRP_PRO_ON."' OR dl_broken_count>0
	ORDER BY dl_status ASC, dl_name ASC");
if(!dbrows($res)) {
	echo $locale['PRP602'];
}
$status = '';
while($data = dbarray($res)) {
	if($status != $data['dl_status']) {
		if(empty($status)) {
			echo '
<ul>';
		} else {
			echo '
		</ul>
	</li>';
		}
		$status = $data['dl_status'];
		echo '
	<li><strong>'.$locale['PRP601'][$status].':</strong>
		<ul>';
	}
	echo '
			<li><a href="edit_admin.php?did='.$data['review_id'].'">'.$data['dl_name'].'</a></li>';
}
if(dbrows($res)) {
	echo '
		</ul>
	</li>
</ul>';
}



/* CHECK FOR ILL FILES */
echo '<hr />
<p>
<a href="'.FUSION_SELF.'?check_all_files">'.$locale['prp_check_files'].'</a>
</p>';

if(isset($_GET['check_all_files'])) {
	$res = dbquery("SELECT d.review_id, dl_name, dir_files, file_url
		FROM ".DB_PRP_DOWNLOADS." AS d
		LEFT JOIN ".DB_PRP_FILES." USING(review_id)
		ORDER BY review_id ASC");
	if(dbrows($res)) {
		echo '
'.$locale['prp_ill_files'].':
<ul>';
	}
	$ill_files = 0;
	while($row = dbarray($res)) {
		if(prp_is_external($row['file_url'])) {
			continue;
		}
		if(!file_exists($prp->settings['upload_file'].$row['dir_files']
			.$row['file_url']))
		{
			++$ill_files;
			echo '
	<li><a href="review.php?did='.$row['review_id'].'">'.$row['dl_name'].'</a>: '.$row['file_url'].'</li>';
		}
	}
	if(!$ill_files) {
		echo '<li>'.$locale['prp_none'].'</li>';
	}
	if(dbrows($res)) {
		echo '
</ul>';
	}
}


closetable();


require_once('include/die.php');
?>
