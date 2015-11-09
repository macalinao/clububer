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


if(!isset($_GET['id']) || !isNum($_GET['id'])) {
	fallback('index.php');
}

if(iGUEST) {
	$userdata['user_id']='0';
}



/****************************************************************************
 * GET
 */
if(iAWEC_ADMIN) {
	$user_access = '';
} else {
	$user_access = " AND ((ev_status='".AWEC_PUBLISHED."'
		AND ev_private='0')
		OR ev.user_id='".$userdata['user_id']."')";
}
$res = dbquery("SELECT ev.*, user_name,
	DATE_FORMAT(ev_start, '".$awec_settings['date_fmt']."') AS date,
	DATE_FORMAT(ev_end, '".$awec_settings['date_fmt']."') AS end_date,
	DATE_FORMAT(ev_end_time, '".$awec_settings['time_fmt']."') AS end_time,
	DATE_FORMAT(ev_start_time, '".$awec_settings['time_fmt']."') AS start_time
	FROM ".AWEC_DB_EVENTS." AS ev
	LEFT JOIN ".DB_USERS." AS fu USING(user_id)
	WHERE ev_id='".$_GET['id']."' $user_access");
if(dbrows($res)==0) {
	fallback('index.php');
}
$event = dbarray($res);
if(!empty($user_access) && !checkgroup($event['ev_access'])) {
	fallback('index.php');
}



$event['date'] = '<a href="day.php?date='.$event['ev_start'].'">'
	.$event['date'].'</a>';
$event['hide_logins'] = true;



/****************************************************************************
 * GUI
 */
//opentable($locale['EC300']);
opentable($event['ev_title']);
awec_menu();

if($event['ev_status']) {
	show_info($locale['awec_status_longdesc'][$event['ev_status']]);
}

awec_render_event($event, '&amp;time='.$event['ctime']);
closetable();


/*
require_once INCLUDES."comments_include.php";
showcomments("E","aw_ec_events","ev_id",$event['ev_id'],FUSION_SELF.'?id='.$event['ev_id']);
*/


$can_login = checkgroup($event['ev_login_access']);
if($event['ev_allow_logins'] && ($can_login || !$event['hide_logins'])) {
	require_once('include/event_logins.php');
}


require_once('include/die.php');
?>
