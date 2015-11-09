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


if(!iAWEC_ADMIN) {
	fallback('index.php');
}


/*
 * GUI
 */
opentable($locale['EC500']);
awec_menu();

$query_id = dbquery("SELECT ev.*, fu.user_name,
	DATE_FORMAT(ev_start, '".$awec_settings['date_fmt']."') AS date,
	DATE_FORMAT(ev_start_time, '".$awec_settings['time_fmt']."') AS start_time,
	DATE_FORMAT(ev_end_time, '".$awec_settings['time_fmt']."') AS end_time
	FROM ".AWEC_DB_EVENTS." AS ev
	LEFT JOIN ".DB_USERS." AS fu ON ev.user_id=fu.user_id
	WHERE ev_status=".AWEC_PENDING);
if(!dbrows($query_id)) {
	echo "<p>".$locale['EC501'];
}

while($data = dbarray($query_id)) {
	awec_render_event($data, "&amp;time=".$data['ctime']."&amp;back_to=new");
}

closetable();


require_once('include/die.php');
?>
