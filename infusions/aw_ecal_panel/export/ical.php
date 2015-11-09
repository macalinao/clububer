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
require_once('../include/common.php');


if(!isset($_GET['id']) || !isNum($_GET['id'])) {
	fallback('index.php');
}


/****************************************************************************
 * FUNCS
 */
function awec_make_vevent($event)
{
	global $settings;

	static $utc_fmt = 'Ymd\THis\Z';
	static $freq_conv = array(
		AWEC_REP_YEAR	=> 'YEARLY',
		AWEC_REP_MONTH	=> 'MONTHLY',
		AWEC_REP_WEEK	=> 'WEEKLY',
		AWEC_REP_DAY	=> 'DAILY',
	);


	$event_start = $event['ev_start'];
	if($event['ev_start_time']) {
		$event_start .= ' '.$event['ev_start_time'];
	}

	$ical = array();

	$ical[] = 'DTSTART:'.gmdate($utc_fmt, strtotime($event_start));
	if($event['ev_end_time']) {
		$event_end = $event['ev_start'].' '.$event['ev_end_time'];
		$ical[] = 'DTEND:'.gmdate($utc_fmt, strtotime($event_end));
	}

	$ical[] = 'UID:'.$event['ev_id'].'@'.$settings['siteurl'];
	$ical[] = 'DTSTAMP:'.gmdate($utc_fmt, $event['ctime']);
	$ical[] = 'DESCRIPTION:'.str_replace("\r\n", '\n', $event['ev_body']);
	$ical[] = 'SUMMARY:'.$event['ev_title'];
	if(!empty($event['ev_location'])) {
		$ical[] = 'LOCATION:'.$event['ev_location'];
	}

	$ical[] = 'CLASS:'.($event['ev_private'] ? 'PRIVATE' : 'PUBLIC');


	// recurrence
	if($event['ev_repeat']) {
		$rrule = 'RRULE:FREQ='.$freq_conv[$event['ev_repeat']].';INTERVAL=1';
		if($event['ev_end']!='0000-00-00') {
			$rrule .= ';UNTIL='.gmdate($utc_fmt, strtotime($event['ev_end']));
		}
		$ical[] = $rrule;
	}


	return "BEGIN:VEVENT\r
".implode("\r\n", $ical)."\r
END:VEVENT\r";
//$ical[] = 'ORGANIZER;CN="'.$event['user_name'].'"';
}



/****************************************************************************
 * GET
 */
if(iAWEC_ADMIN) {
	$user_access = '';
} else {
	$user_access = " AND ((ev_status='".AWEC_PUBLISHED."'
		AND ev_private='0')"
		." OR ev.user_id='".$userdata['user_id']."')";
}
$res = dbquery("SELECT ev.*, user_name,
	DATE_FORMAT(ev_start, '".$awec_settings['date_fmt']."') AS date,
	DATE_FORMAT(ev_end_time, '".$awec_settings['time_fmt']."') AS end_time,
	DATE_FORMAT(ev_start_time, '".$awec_settings['time_fmt']."') AS start_time
	FROM ".AWEC_DB_EVENTS." AS ev
	LEFT JOIN ".DB_USERS." AS fu USING(user_id)
	WHERE ev_id='".$_GET['id']."' $user_access");
if(dbrows($res)==0) {
	fallback('../index.php');
}
$event = dbarray($res);
if(!empty($user_access) && !checkgroup($event['ev_access'])) {
	fallback('../index.php');
}



/****************************************************************************
 * OUTPUT
 */
while(@ob_end_clean());
header('Content-Type: text/calendar');
header('Content-Disposition: attachment; filename="event.ics"');
header('Content-Type: text/calendar; charset=UTF-8');
//echo "<pre>";
echo "BEGIN:VCALENDAR\r
PRODID:http://wibix.de/infusions/pro_download_panel/download.php?did=27\r
VERSION:2.0\r
METHOD:PUBLISH\r
".awec_make_vevent($event)."
END:VCALENDAR\r
";

//echo "</pre>";
?>
