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
require_once('include/common.php');
require_once('include/theme_funcs.php');

if(!iMEMBER) {
	fallback('index.php');
}

if(!isset($_GET['id']) || !isNum($_GET['id'])) {
	if(iMEMBER) {
		fallback(FUSION_SELF.'?id='.$userdata['user_id']);
	}
	fallback('index.php');
}



/****************************************************************************
 * GUI
 */
opentable($pdp->settings['title']);
pdp_menu();


$res = dbquery("SELECT user_id, user_name
	FROM ".DB_USERS."
	WHERE user_id='".$_GET['id']."'");
if(!dbrows($res)) {
	fallback('index.php');
}
$user = dbarray($res);


echo '
<p>
	<strong>'.$user['user_name'].':</strong>
	<a href="'.BASEDIR.'profile.php?lookup='.$user['user_id'].'">'
		.$locale['PDP161'].'</a>
</p>

<hr />
';
if(iPDP_MOD) {
	$where = "";
} elseif(iMEMBER) {
	$where = " AND ((dl_status='".PDP_PRO_ON."'"
		.($pdp->settings['hide_user_allow']=="yes"
			? " AND hide_user='no')"
			: ")")
		." OR user_id='".$userdata['user_id']."')";
} else {
	$where = " AND dl_status='".PDP_PRO_ON."'";
	if($pdp->settings['hide_user_allow']=="yes") {
		$where .= "AND hide_user='no'";
	}
}


$res = dbquery("SELECT dl_name, download_id, dl_status, dl_broken_count,
	cat_name, cat_access, dl.cat_id, hide_user
	FROM ".DB_PDP_DOWNLOADS." AS dl
	LEFT JOIN ".DB_PDP_CATS." AS c
		ON dl.cat_id=c.cat_id
	WHERE user_id='".$user['user_id']."' ".$where."
	ORDER BY dl_status, dl_name ASC");

$last_status = "";
$found = 0;
$more = array();
while($data = dbarray($res)) {
	if(!checkgroup($data['cat_access'])) {
		continue;
	}
	if($last_status != $data['dl_status']) {
		if(empty($last_status)) {
			echo '
<ul>';
		} else {
			echo '
		</ul>
	</li>';
		}
		$last_status = $data['dl_status'];
		echo '
	<li><strong>'.$locale['PDP904'][$last_status].':</strong>
		<ul>';
	}

	if(iPDP_MOD || (iMEMBER && $userdata['user_id']==$user['user_id'])) {
		$more = array();
		if($data['dl_broken_count']>0) {
			$more[] = $locale['PDP163'];
		}
		if($pdp->settings['hide_user_allow']=="yes"
			&& $data['hide_user']=="yes") {
			$more[] = $locale['PDP162'];
		}
	}

	echo '
			<li>';
	if(($last_status==PDP_PRO_DEL || $last_status==PDP_PRO_CHECK
		|| ($last_status==PDP_PRO_OFF && !$pdp->settings['user_edit']))
		&& !iPDP_MOD) {
		echo $data['dl_name'];
	} elseif($last_status==PDP_PRO_NEW) {
		echo "<a href='edit_desc.php?did=".$data['download_id']."'>"
			.$data['dl_name']."</a>";
	} else {
		echo "<a href='download.php?did=".$data['download_id']."'>"
			.$data['dl_name']."</a>";
	}
	if(count($more)) {
		echo " <span class='small2'>(".implode(", ", $more).")</span>";
	}
	echo '</li>';

	$found++;
}
if(dbrows($res)) {
	echo '
		</ul>
	</li>
</ul>';
}
if($found==0) {
	echo $locale['PDP022'];
}

closetable();

/*
 * subscriptions
 */
if(iMEMBER && $user['user_id']==$userdata['user_id']) {
	opentable($locale['PDP164']);

	if($pdp->settings['allow_notify']=="no") {
		echo "<p><strong>".$locale['PDP057']."</strong>\n";
	}

	$res = dbquery("SELECT dl_name, n.download_id, visited
		FROM ".DB_PDP_NOTIFY." AS n
		LEFT JOIN ".DB_PDP_DOWNLOADS." AS d
			ON n.download_id=d.download_id
		WHERE n.user_id=".$user['user_id']."
		ORDER BY dl_name ASC");
	if(!dbrows($res)) {
		echo "<p><span class='small2'>".$locale['PDP058']."</span>\n";
	} else {
		echo "<ul>\n";
	}
	while($data = dbarray($res)) {
		echo "<li><a href='download.php?did=".$data['download_id']."'>"
			.$data['dl_name']."</a>";
		if($data['visited']=="no") {
			echo " (<strong>".$locale['pdp_new']."</strong>)";
		}
		echo "</li>\n";
	}
	if(dbrows($res)) {
		echo "</ul>\n";
	}

	closetable();
}


require_once('include/die.php');
?>
