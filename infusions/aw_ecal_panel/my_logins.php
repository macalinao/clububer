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
$res = dbquery("SELECT ev.ev_title, ev.ev_id, logins.login_status,
	DATE_FORMAT(ev_start, '".$awec_settings['date_fmt']."') AS start
	FROM ".AWEC_DB_LOGINS." AS logins
	LEFT JOIN ".AWEC_DB_EVENTS." AS ev USING(ev_id)
	WHERE logins.user_id='".$userdata['user_id']."'
	ORDER BY ev_start ASC");
opentable($locale['EC206']);
awec_menu();
if(dbrows($res)) {
	echo '
<ul>';
	while($ev = dbarray($res)) {
		echo '
<li>'.$ev['start'].' <a href="view_event.php?id='.$ev['ev_id'].'">'
	.$ev['ev_title'].'</a> ('.$locale['EC309'][$ev['login_status']].')</li>';
	}
	echo '
</ul>';
} else {
	echo '<p>'.$locale['EC601'].'</p>';
}
closetable();


require_once('include/die.php');
?>
