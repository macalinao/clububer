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
if(!iMEMBER) {
	fallback('index.php');
}



/*
 * GUI
 */
opentable($locale['EC600']);
awec_menu();

$res = dbquery("SELECT ev_title, ev_id, ev_allow_logins,
	DATE_FORMAT(ev_start, '".$awec_settings['date_fmt']."') AS start,
	ev_private, ev_status
	FROM ".AWEC_DB_EVENTS."
	WHERE user_id='".$userdata['user_id']."'
	ORDER BY ev_status DESC, ev_private DESC, ev_start DESC");
if(!dbrows($res)) {
	echo '<p>'.$locale['EC601'].'</p>';
} else {
	echo '
<ul>';
}
$is_private = '';
$last_status = -1;
while($ev = dbarray($res)) {
	if($last_status != $ev['ev_status']) {
		if($last_status >= 0) {
			echo '
	</ul>
	</li>';
		}
		$last_status = $ev['ev_status'];
		echo '
	<li>'.$locale['awec_status_desc'][$last_status].'
	<ul>';
	}

	echo '
		<li>'.$ev['start'];
	if(iAWEC_ADMIN || $ev['ev_status']==AWEC_DRAFT
		|| ($awec_settings['user_can_edit']
			&& $ev['ev_status']!=AWEC_PENDING))
	{
		echo ' [<a href="edit_event.php?id='.$ev['ev_id'].'">'
			.$locale['awec_edit'].'</a>]';
	}
	echo ' <a href="view_event.php?id='.$ev['ev_id'].'">'.$ev['ev_title'].'</a>';
	if($ev['ev_allow_logins']) {
		$logins = ff_db_count("(*)", AWEC_DB_LOGINS,
			"(ev_id='".$ev['ev_id']."')");
		echo ' ('.$logins.' '.$locale['awec_logins'].')';
	}
	echo '</li>';
}
if(dbrows($res)) {
	echo '
	</ul>
	</li>
</ul>';
}
closetable();


require_once('include/die.php');
?>
