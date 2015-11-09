<?php
/**
*
* @package awEventCalendar
* @version $Id: $
* @copyright (c) 2006-2008 Artur Wiebe <wibix@gmx.de>
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
require_once('include/common.php');


if(!isset($_GET['date']) || !preg_match(AWEC_DATE_FORMAT, $_GET['date'])) {
	fallback('index.php');
}
$date = $_GET['date'];
list($year, $month, $mday) = explode('-', $date);
$year = intval($year);
$month = intval($month);
$mday = intval($mday);



/****************************************************************************
 * GET
 */
$events = array();
$needle = array(
	'from'	=> $date,
	'to'	=> $date,
);
if(awec_get_events($needle, $events, true)===false) {
	fallback('index.php');
}



$res = dbquery("SELECT
	DATE_FORMAT('".$date."', '".$awec_settings['date_fmt']."') AS date");
$row = dbarray($res);
$date = array_shift($row);



/****************************************************************************
 * GUI
 */
opentable($date);
awec_menu();
awec_set_title($date);


if(iAWEC_POST) {
	echo '<a href="edit_event.php?date='.$_GET['date'].'">'
		.$locale['EC100'].'</a>';
}


if(count($events)) {
	foreach($events[$year][$month][$mday] as $event) {
		if($event['is_birthday']) {
			ec_render_birthday($event);
		} else {
			$event['ev_title'] = '<a href="view_event.php?id='.$event['ev_id'].'">'.$event['ev_title'].'</a>';
			awec_render_event($event);
		}
	}
} else {
	echo '<p>'.$locale['awec_no_events'].'</p>';
}

closetable();


require_once('include/die.php');
?>
