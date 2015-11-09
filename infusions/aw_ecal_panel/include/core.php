<?php
/**
*
* @package awEventCalendar
* @version $Id: $
* @copyright (c) 2006-2008 Artur Wiebe <wibix@gmx.de>
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
if(!defined('IN_FUSION')) {
	die;
}


if(!defined('FUSION_VERSION')) {
	if(defined('IN_FF')) {
		define('FUSION_VERSION', 'FF');
	} else {
		$ver_numbers = explode('.', $settings['version']);
		$main_ver = intval(array_shift($ver_numbers));
		define('FUSION_VERSION', $main_ver);
	}
}



if(!defined('DB_USERS')) {
	define('DB_USERS',	DB_PREFIX.'users');
}
if(!defined('DB_MESSAGES')) {
	define('DB_MESSAGES',	DB_PREFIX.'messages');
}
define('AWEC_DB_EVENTS',	DB_PREFIX.'aw_ec_events');
define('AWEC_DB_EVENTS_IN_CATS',DB_PREFIX.'aw_ec_events_in_cats');
define('AWEC_DB_CATS',		DB_PREFIX.'aw_ec_cats');
define('AWEC_DB_LOGINS',	DB_PREFIX.'aw_ec_logins');
define('AWEC_DB_SETTINGS',	DB_PREFIX.'aw_ec_settings');
define('AWEC_DB_ATTACHMENTS',	DB_PREFIX.'awec_attachments');


define('AWEC_BREAK',		'<!--BREAK-->');
define('AWEC_DATE_FORMAT',	'/^\d\d\d\d-\d\d-\d\d$/');

define('AWEC_REP_YEAR',		1);// repeat on that day and month every year
define('AWEC_REP_MONTH',	2);// repeat on that day every month
define('AWEC_REP_WEEK',		4);// repeat on that day of week
define('AWEC_REP_DAY',		8);// repeat on every day

define('AWEC_ATTACHMENTS',	INFUSIONS.'aw_ecal_panel/attachments/');


define('AWEC_PUBLISHED',	0);
define('AWEC_PENDING',		1);
define('AWEC_DRAFT',		2);


//0: no error
define('EC_ELOGIN',	1);
define('EC_EDB',	2);
define('EC_ESTATUS',	3);
define('EC_EACCESS',	4);
define('EC_EIMG',	5);


if(file_exists(INFUSIONS.'aw_ecal_panel/locale/'.$settings['locale'].'.php')) {
	include(INFUSIONS.'aw_ecal_panel/locale/'.$settings['locale'].'.php');
} else {
	include(INFUSIONS.'aw_ecal_panel/locale/German.php');
}


// settings
$res = dbquery("SELECT * FROM ".AWEC_DB_SETTINGS);
$awec_settings = dbarray($res);
$ec_supported = array('%d', '%e', '%m', '%c', '%Y', '%y');
if(empty($awec_settings['version'])) {
	$awec_settings['version'] = '0.8.0';	/*FIXME*/
}
// MySQL 4
$res = dbquery("SELECT VERSION()");
if(dbrows($res)) {
	$row = dbarray($res);
	$ver_numbers = explode('.', array_shift($row));
	if(array_shift($ver_numbers)<5) {
		$awec_settings['birthdays_are_events'] = -1;
	}
}


// check if users.user_birthdate exists
if(FUSION_VERSION==7) {
	if(!dbcount("(*)", DB_USER_FIELDS, "field_name='user_birthdate'")) {
		$awec_settings['show_birthday_to_group'] = -1;
	}
}



//css
if($awec_settings['use_custom_css']) {
		// calendar view
	$awec_styles = array(
		'calendar'		=> 'awec_calendar',
		'dayofweek'		=> 'dayofweek',
		'weekend'		=> 'weekend',
		'content'		=> 'content',
		'current'		=> 'current',
		'current weekend'	=> 'current weekend',
		'empty'			=> 'empty',
		'content weekend'	=> 'content weekend',
		'empty weekend'		=> 'empty weekend',
		'invalid'		=> 'invalid',
		// list view
		'list'			=> 'awec_list',
		'even'			=> 'even',
		'odd'			=> 'odd',
	);
} else {
	$awec_styles = array(
		// calendar view
		'calendar'		=> 'tbl-border',
		'dayofweek'		=> 'forum-caption',
		'weekend'		=> 'tbl1',
		'content'		=> 'tbl1',
		'current'		=> 'tbl2',
		'current weekend'	=> 'tbl2',
		'empty'			=> 'tbl1',
		'content weekend'	=> 'tbl1',
		'empty weekend'		=> 'tbl1',
		'invalid'		=> 'tbl1',
		// list view
		'list'			=> 'tbl-border',
		'even'			=> 'tbl1',
		'odd'			=> 'tbl2',
	);
}




define('iAWEC_ADMIN',	iSUPERADMIN || checkgroup($awec_settings['edit_group']));
define('iAWEC_POST',	iMEMBER  && (iAWEC_ADMIN || checkgroup($awec_settings['post_group'])));
define('iAWEC_RELEASE', (!iAWEC_ADMIN && $awec_settings['need_admin_ok']));
define('iAWEC_PUBLISH', (!$awec_settings['need_admin_ok'] || iAWEC_ADMIN));



$awec_now = time()+$settings['timeoffset']*3600;


if(isset($_GET['y']) && isNum($_GET['y'])) {
	$ec_year = intval($_GET['y']);
} else {
	$ec_year = date('Y', $awec_now);
}
if(isset($_GET['m']) && isNum($_GET['m'])) {
	$ec_month = intval($_GET['m']);
} else {
	$ec_month = date('n', $awec_now);
}
if(isset($_GET['d']) && isNum($_GET['d'])) {
	$ec_mday = intval($_GET['d']);
} else {
	$ec_mday = date('j', $awec_now);
}
$awec_last_day = date('t', strtotime($ec_year.'-'.$ec_month.'-'.$ec_mday));


// today - not the same that is shown in the calendar.
$ec_today = getdate($awec_now);
$ec_is_this_month = ($ec_today['mon']==$ec_month && $ec_today['year']==$ec_year);
$ec_tomorrow = getdate($awec_now+86400);	// +1 day



/****************************************************************************
 * FUNCS
 */
function awec_render_cal($month, $year, $title, $content,
	$height, $show_others, $sun_first_day, $show_cw=false)
{
	global $locale, $awec_styles;

	$dow_from = 1;
	$dow_to = 7;
	$dow_offset = -1;
	if($sun_first_day) {
		$dow_from = 0;
		$dow_to = 6;
		$dow_offset = 0;
	}

	if($height>0) {
		$height = ' style="height:'.$height.'px;"';
	} else {
		$height = '';
	}

	//
	$thismonth = mktime(12, 0, 0, $month, 1, $year);
	$date = getdate($thismonth);

	if(!$sun_first_day && $date['wday']==0) {
		$date['wday'] = 7;
	}
	$offset = $date['wday'] + $dow_offset;

	$daysinmonth = date('t', $thismonth);

	if($show_cw) {
		$cw = date('W', $thismonth);
	}

	/*
	 * line by line
	 */
	echo '
<div style="text-align:center;">'.$title.'</div>';

	echo '
<table class="'.$awec_styles['calendar'].'" cellspacing="0" width="100%">
<colgroup>
	'.($show_cw ? '<col width="1%" />' : '').'
	<col width="14%" span="6" />
</colgroup>
<thead>';
//	echo "<caption>".$locale['awec_calendar']."</caption>\n";

	// days of week
	echo '
<tr>';
	if($show_cw) {
		echo '
	<th class="'.$awec_styles['dayofweek'].'"></th>';
	}
	for($i=$dow_from; $i<=$dow_to; ++$i) {
		echo '
	<th class="'.$awec_styles['dayofweek'].'">'.$locale['EC901'][$i].'</th>';
	}
	echo '
</tr>
</thead>
<tbody>';

	// start with offset
	echo '
<tr'.$height.'>';
	if($show_cw) {
		echo '
	<td><a href="week.php?date='.date('Y-m-d', $thismonth).'">'.$cw.'</a></td>';
	}
	for($i=0; $i<$offset; ++$i) {
		echo '
	<td class="'.$awec_styles['invalid'].'">&nbsp;</td>';
	}
	// start month
	$col = $offset;
	for($i=1; $i<=$daysinmonth; ++$i) {
		if($sun_first_day) {
			if($col==0 || $col==6) {
				$content[$i]['style'] .= ' weekend';
			}
		} else {
			if($col==5 || $col==6) {
				$content[$i]['style'] .= ' weekend';
			}
		}
		echo '
	<td class="'.$awec_styles[$content[$i]['style']].'" valign="top">';
		if($content[$i]['data']!==false) {
			echo sprintf($content[$i]['data'], $i);
		} else {
			echo $i;
		}
		echo '</td>';

		// new line
		if((++$col%7)==0) {
			echo '
</tr>
<tr'.$height.'>';
			if($show_cw) {
				$thismonth += 604800;// 1 week
				echo '
	<td><a href="week.php?date='.date('Y-m-d', $thismonth).'">'.++$cw.'</a></td>';
			}
			$col = 0;
		}
	}
	for($i=0; $i<(7-$col); $i++) {
		echo '
	<td class="'.$awec_styles['invalid'].'">&nbsp;</td>';
	}
	echo '
</tr>
</tbody>
</table>';
}


function ec_format_fucking_date($year, $month, $mday)
{
	global $ec_supported, $awec_settings;

	$ret = $awec_settings['sidedate_fmt'];

	$conv = array(
		'%d'	=> sprintf('%02d', $mday),
		'%e'	=> sprintf('%d', $mday),
		'%m'	=> sprintf('%02d', $month),
		'%c'	=> sprintf('%d', $month),
		'%Y'	=> sprintf('%04d', $year),
		'%y'	=> sprintf('%02d', $year),
	);

	foreach($conv as $field => $fmt) {
		$ret = str_replace($field, $fmt, $ret);
	}

	return $ret;
}



function awec_repeat_alt_cal($month, $year, $title, $content,
	$height, $show_others, $sun_first_day)
{
	global $locale;

	$dow_from = 1;
	$dow_to = 7;
	$dow_offset = -1;
	if($sun_first_day) {
		$dow_from = 0;
		$dow_to = 6;
		$dow_offset = 0;
	}

	//
	$thismonth = mktime(12, 0, 0, $month, 1, $year);
	$date = getdate($thismonth);

	if(!$sun_first_day && $date['wday']==0) {
		$date['wday'] = 7;
	}
	$offset = $date['wday'] + $dow_offset;

	$daysinmonth = date('t', $thismonth);

	/*
	 * line by line
	 */
	echo $title;
//'.str_pad($title, 20, ' ', STR_PAD_LEFT).'
	echo '
<pre class="awec_alt_cal">
';

	echo '<span class="dayofweek_header">';
	for($i=$dow_from; $i<=$dow_to; ++$i) {
		echo '<span class="dayofweek">'.$locale['EC901'][$i].'</span>';
		if($i!=$dow_to) {
			echo ' ';
		}
	}
	echo "</span>\n";

	// start with offset
	for($i=0; $i<$offset; ++$i) {
		echo '<span class="empty">  </span> ';
	}
	// start month
	$col = $offset;
	for($i=1; $i<=$daysinmonth; ++$i) {
		if($sun_first_day) {
			if($col==0 || $col==6) {
				$content[$i]['style'] .= ' weekend';
			}
		} else {
			if($col==5 || $col==6) {
				$content[$i]['style'] .= ' weekend';
			}
		}
		if($content[$i]['data']!==false) {
			$d = sprintf($content[$i]['data'], $i);
		} else {
			$d = ($i<10 ? ' ': '').$i;
		}
		echo '<span class="'.$content[$i]['style'].'">'.$d.'</span> ';
		// new line
		if((++$col%7)==0) {
			echo "\n";
			$col = 0;
		}
	}
	for($i=0; $i<(7-$col); $i++) {
		echo '<span class="empty">  </span> ';
	}
	echo '
</pre>';
}


/**
* Returnes an array of events in the specified time period.
*
* @param $needle
*	Array that determines what events are to be retrieved.
*	'from'	- MANDATORY
*		See AWEC_DATE_FORMAT format above.
*	'to'	- MANDATORY
*		See AWEC_DATE_FORMAT format above. Including the last day!
*	'cat'	- OPTIONAL
*		Retrieve only events in this cat. 0 stands for "dont care".
* @param $events
*	An array like this $events[year][month][day][event_id]. Array will be
*	emptied before first use.
* @param $extended
*	TRUE if need a join with PHP-Fusion user's table.
* @param $get_birthdays
*	TRUE if birtdays are should be retrieved just like events.
* @return
*	FALSE if invalid date format. Else TRUE.
*/
// FIXME: need to make sure $from,$to are valid events. otherwise mysql fails.
function awec_get_events($needle, &$events, $extended=true)
{
	global $userdata, $awec_settings, $locale;

	if(!isset($needle['from']) || !isset($needle['to'])) {
		return false;
	}
	$from = $needle['from'];
	$to = $needle['to'];
	if(!isset($needle['cat'])) {
		$needle['cat'] = 0;
	}

	if(!preg_match(AWEC_DATE_FORMAT, $from)) {
		return false;
	}
	if(!preg_match(AWEC_DATE_FORMAT, $to)) {
		return false;
	}

	$and_where = array();

	$where = array();

	$and_where[] = "
			((ev_start>='".$from."' AND ev_start<='".$to."' )
			OR
			(ev_end>='".$from."' AND ev_end<='".$to."' AND ev_start!=ev_end)
			OR
			(ev_start<'".$from."' AND (ev_end>'".$to."' OR (ev_repeat<>0 AND ev_end='0000-00-00'))))";


	// access - edit group - no access limit
	if(iAWEC_ADMIN) {
		//
	} elseif(iMEMBER) {
		$and_where[] = "((ev_private='0'"
			." OR ec.user_id='".$userdata['user_id']."')"
			." AND ".groupaccess("ev_access").")";
	} else {
		$and_where[] = "(ev_private='0' AND ev_access='0')";
	}

	$query = "SELECT
IF(ev_end='0000-00-00','$to',IF(ev_end<'$to',ev_end,'$to')) AS end_here,
ev_start, ev_end,

		0 AS is_birthday,
		DAYOFMONTH(ev_start) AS day, ev_repeat,
		ev_title, ev_location, ev_id, ev_access, YEAR(ev_start) AS year,
		MONTH(ev_start) AS month, DAYOFWEEK(ev_start) AS wday,
		ev_private, ec.user_id, ctime,";
	if($extended) {
		$query .= " user_name, ev_allow_logins, ev_status,";
	}
	$query .= "ev_body,
		DATE_FORMAT(ev_start_time, '".$awec_settings['time_fmt']."') AS start_time,
		DATE_FORMAT(ev_end_time, '".$awec_settings['time_fmt']."') AS end_time,
		DATE_FORMAT(ev_start,
			'".$awec_settings['date_fmt']."') AS date,
		DATE_FORMAT(ev_end,
			'".$awec_settings['date_fmt']."') AS end_date,
		ev_no_smileys
		FROM ".AWEC_DB_EVENTS." AS ec";
	if($extended) {
		$query .= "
		LEFT JOIN ".DB_USERS." AS fu
			ON fu.user_id=ec.user_id";
	}
	if($needle['cat']) {
		$query .= "
		LEFT JOIN ".AWEC_DB_EVENTS_IN_CATS." AS cat
			ON cat.event_id=ec.ev_id AND cat_id=".$needle['cat'];
	}
	$query .= "
		WHERE ev_status=".AWEC_PUBLISHED." ";
	if(count($and_where)) {
		$query .= " AND (".implode(' AND ', $and_where).")";
	}
	if($needle['cat']) {
		$query .= " AND cat_id=".$needle['cat'];
	}
	$query .= "
		ORDER BY DAYOFMONTH(ev_start) ASC, ev_start_time ASC";


	// have a look at the cache!
	static $cache = array();
	$md5 = md5($query);
	if(isset($cache[$md5])) {
// echo '<p>cache hit: '.$from.' - '.$to;
		$events = $cache[$md5];
		return;
	}



	$from_unix = strtotime($from);


	// retrieve events
	$res = dbquery($query);
	while($ev = dbarray($res)) {
		$ev_id = $ev['ev_id'];


		if($ev['ev_repeat']) {
			awec_repeat_event($ev, $events, $from_unix);
		} else {
			$events[$ev['year']][$ev['month']][$ev['day']][$ev_id] = $ev;
		}
	}


	// looks like birthdays are event, too.
	if($awec_settings['birthdays_are_events']==1
		&& checkgroup($awec_settings['show_birthday_to_group'])
		&& $needle['cat']==0)
	{
		$where = array();

		$where[] = "user_status='0'";

		//FIXME years old may be incorrect if looking for more that one year.
		$days_needed = (1+(strtotime($to)-$from_unix)/86400);

		$res = dbquery("SELECT
			1 AS is_birthday,
			user_id,

			'$to' AS end_here,
			user_birthdate AS ev_start, user_birthdate AS ev_end,
			user_id AS ev_id,

			NULL AS start_time,


			(YEAR('$from')-YEAR(user_birthdate)) AS years_old,


			user_name,
			user_id AS date_id,
			user_birthdate AS event_date,
			DAYOFMONTH(user_birthdate) AS day,
			MONTH(user_birthdate) AS month,

			'".AWEC_REP_YEAR."' AS ev_repeat,

			DATE_FORMAT(user_birthdate, '".$awec_settings['date_fmt']."')
				AS date,

			DATEDIFF(CONCAT(YEAR('$from'),'-',MONTH(user_birthdate),'-',DAY(user_birthdate)),'$from') AS distance

			FROM ".DB_USERS."
			HAVING distance>=0 AND distance<".$days_needed."
			ORDER BY distance ASC");
//			WHERE user_birthdate>='$from'
//XXX: echo '<p>#'.dbrows($res);

		while($row = dbarray($res)) {
			$row['ev_title'] = sprintf($locale['awec_user_birthday']['title'], $row['user_name']);
			$row['ev_body'] = str_replace(
				array('%1', '%2'),
				array($row['user_name'], $row['years_old']),
				$locale['awec_user_birthday']['body']);

			awec_repeat_event($row, $events, $from_unix);
		}
	}

	// add to cache
	$cache[$md5] = $events;
// echo '<p>adding to cache: '.$year.$month.' (#cached: '.count($cache).')';
}
/*
* Repeats an event.
*
* @param $event
* @param $events
* @param $from
*/
function awec_repeat_event(&$event, &$events, $from)
{
	$s = strtotime($event['ev_start']);
//	$s = strtotime($event['start_here']);
	$to = strtotime($event['end_here']);

	static $rep_map = array(
		AWEC_REP_YEAR	=> array(
			'year',
			31536000,	// secs in 365 days = 1 year
		),
		AWEC_REP_MONTH	=> array(
			'month',
			2419200,	// secs in 28 days = 1 month
		),
		AWEC_REP_WEEK	=> array(
			'week',
			604800,		// secs in 7 days
		),
		AWEC_REP_DAY	=> array(
			'day',
			86400,		// secs in 1 day
		),
	);
	$rep = $rep_map[$event['ev_repeat']][0];

	// skip old dates
	$diff = $from - $s;
	if($diff > 0) {
		$period =  $rep_map[$event['ev_repeat']][1];
		$diff_periods = floor($diff/$period);
		$s = strtotime('+'.$diff_periods.' '.$rep, $s);
	}


	do {
		if($s>=$from) {
			list($y, $m, $d) = explode('-', date('Y-n-j', $s));
			$events[$y][$m][$d][] = $event;
		} else {
		}
		$s = strtotime('+1 '.$rep, $s);
	} while($s <= $to);
}



if(!function_exists('fallback')) {
function fallback($href)
{
	redirect($href);
}
}


// php-fusion 6.1.15
if(!function_exists('ff_db_count')) {
function ff_db_count($field, $table, $cond='') {
	if($cond) {
		$cond = " WHERE ".$cond;
	}

	$res = @mysql_query("SELECT COUNT".$field."
		FROM ".$table.$cond);
	if(!$res) {
		return false;
	} else {
		$rows = mysql_result($res, 0);
		return $rows;
	}
}
}

?>
