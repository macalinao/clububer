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
if(!defined('IN_FUSION')) {
	die;
}


require_once(INFUSIONS.'aw_ecal_panel/include/core.php');

echo '<script type="text/javascript" src="'.INFUSIONS.'aw_ecal_panel/include/boxover.js"></script>';


/****************************************************************************
 * FUNCS
 */
function awec_post_process_events(&$events, &$out)
{
	global $ec_today, $ec_tomorrow, $locale, $awec_settings;

	$count = 0;

	$current = 'others';
	$path_event = INFUSIONS.'aw_ecal_panel/view_event.php?id=';
	$path_birthday = INFUSIONS.'aw_ecal_panel/birthday.php?id=';
	$show_details = ($awec_settings['show_today_in_panel'] ? true : false);

	foreach($events as $year => $y_data) {
		ksort($y_data, SORT_NUMERIC);
		foreach($y_data as $month => $m_data) {
			ksort($m_data, SORT_NUMERIC);

			$today_month = ($ec_today['mon']==$month && $ec_today['year']==$year);
			$tomorrow_month = ($ec_tomorrow['mon']==$month && $ec_tomorrow['year']==$year);

			foreach($m_data as $mday => $d_data) {
				if($today_month && $ec_today['mday']==$mday) {
					$current = 'today';
				} else if($tomorrow_month && $ec_tomorrow['mday']==$mday) {
					$current = 'tomorrow';
				} else {
					$current = 'others';
				}


				foreach($d_data as $ev) {
					$item = '';
					if($current!='others') {
						if($ev['start_time']) {
							$item .= $ev['start_time'];
							if($ev['end_time']) {
								$item .= '-'.$ev['end_time'];
							}
							$item .= '&nbsp;';
						}
					} else {
						$item .= ec_format_fucking_date($year,
								$month, $mday).'&nbsp;';
					}
					if($ev['is_birthday']) {
						$path = $path_birthday.$ev['user_id'];
					} else {
						$path = $path_event.$ev['ev_id'];
					}

					$item .= '<a href="'.$path.'">'
						.$ev['ev_title'].'</a>';

					if($show_details && $current=='today') {
						$body = parseubb($ev['ev_body']);
						$body = explode(stripinput(AWEC_BREAK), $body);
						if(count($body)>1) {
							$body[0] .= ' <a href="'.$path.'">'.$locale['EC207'].'</a>';
						}
						$item .= '<br /><span class="small2">'.$body[0].'</span>';
					}

					$out[$current][] = $item;
					++$count;
				}
			}
		}
	}

	return $count;
}



/****************************************************************************
 * GUI
 */
openside($locale['EC001']);

$content = array();
$month = ($ec_month<10 ? '0' : '').$ec_month;
for($i=1; $i<=31; ++$i) {
	$content[$i] = array(
		'style'	=> 'empty',
//XXX		'data'	=> '<a href="'.INFUSIONS.'aw_ecal_panel/day.php?date='.$ec_year.'-'.$month.'-'.($i<10 ? '0' : '').$i.'">'.($i<10 ? ' ' : '').$i.'</a>',
		'data'	=> ($i<10 ? ' ' : '').$i,
	);
}

$events = array();
$needle = array(
	'from'	=> $ec_year.'-'.$month.'-01',
	'to'	=> $ec_year.'-'.$month.'-'.$awec_last_day,
);
awec_get_events($needle, $events, false);
if(count($events)) {
	foreach($events[$ec_year][$ec_month] as $day => $more) {
		$btext = '';
		foreach($more as $day_data) {
			$title = $day_data['ev_title'];
			$btext .= '<li>'.$day_data['ev_title'].'</li>';
		}
		if(!empty($btext)) {
			$btext = '&nbsp;<ul>'.$btext.'</ul>';
		}

		$btext = phpentities($btext);
		$btitle = phpentities('<strong>'.$day.'. '.$locale['EC900'][$ec_month].'</strong>');
		$content[$day] = array(
			'style'	=> 'content',
			'data'	=> '<a href="'.INFUSIONS.'aw_ecal_panel/day.php'
				.'?date='.$ec_year.'-'.$month
					.'-'.($day<10 ? '0' : '').$day.'"'
				.' title="cssbody[tbl1] cssheader=[tbl2] header=['.$btitle.'] body=['.$btext.']">%2s</a>',
		);
	}
}
if($ec_is_this_month) {
	$content[$ec_today['mday']]['style'] = 'current';
}


$pyear = $ec_year;
$nyear = $ec_year;
$pmonth = $ec_month-1;
$nmonth = $ec_month+1;
if($pmonth<1) {
	$pmonth = 12;
	$pyear = $ec_year-1;
} elseif($nmonth>12) {
	$nmonth = 1;
	$nyear = $ec_year+1;
}

$path = INFUSIONS.'aw_ecal_panel';

$href = FUSION_SELF;
unset($_GET['y']);
unset($_GET['m']);
$gets = array();
foreach($_GET as $key => $val) {
	$gets[] = "$key=$val";
}

$href = FUSION_SELF.'?'.(count($gets) ? implode('&amp;', $gets).'&amp;' : '');
// pad title!!!
$cur_title = $locale['EC900'][$ec_month].' '.$ec_year;
/*
$title = str_repeat(' ', (20-strlen($cur_title))/2-3)
.'<a href="'.$href.'y='.$pyear.'&amp;m='.$pmonth.'">&lt;&lt;</a> <a href="'.$path.'/index.php?y='.$ec_year.'&amp;m='.$ec_month.'">'.$cur_title.'</a> <a href="'.$href.'y='.$nyear.'&amp;m='.$nmonth.'">&gt;&gt;</a>';
*/
$title = '
<table border="0" width="100%">
<tbody>
<tr>
	<td align="left">
		<a href="'.$href.'y='.$pyear.'&amp;m='.$pmonth.'">&laquo;</a>
	</td>
	<td align="center">
		<a href="'.$path.'/index.php?y='.$ec_year.'&amp;m='.$ec_month.'">'.$cur_title.'</a>
	</td>
	<td align="right">
		<a href="'.$href.'y='.$nyear.'&amp;m='.$nmonth.'">&raquo;</a>
	</td>
</tr>
</thead>
</table>';
if($awec_settings['use_alt_side_calendar']) {
	awec_repeat_alt_cal($ec_month, $ec_year, $title, $content,
		0, false, $awec_settings['sun_first_dow']=='yes');
} else {
	awec_render_cal($ec_month, $ec_year, $title, $content,
		0, false, $awec_settings['sun_first_dow']=='yes');
}


if(iMEMBER && false) {
	echo '
<ul>';
	if(iAWEC_POST) {
		echo '
	<li><a href="'.$path.'/edit_event.php">'.$locale['EC200'].'</a></li>';
	}
	echo '
	<li><a href="'.$path.'/my_events.php">'.$locale['EC204'].'</a></li>
	<li><a href="'.$path.'/my_logins.php">'.$locale['EC206'].'</a></li>';
	if(iSUPERADMIN) {
		echo '
	<li><a href="'.$path.'/admin.php">'.$locale['EC700'].'</a></li>';
	}
	echo '
</ul>';
}


if(iAWEC_ADMIN
	&& ff_db_count("(*)", AWEC_DB_EVENTS, "(ev_status='".AWEC_PENDING."')"))
{
	echo '
<p>
<div style="text-align:center;">
	<strong><a href="'.$path.'/new_events.php">'.$locale['EC203'].'</a></strong>
</div>
</p>';
}



/*
 * show next x days
 */
if($awec_settings['next_days_in_panel']) {
	$from_time = $awec_now;
	$to_time = $from_time+($awec_settings['next_days_in_panel']-1)*86400;

	$events = array();
	$needle = array(
		'from'	=> date('Y-m-d', $from_time),
		'to'	=> date('Y-m-d', $to_time),
	);
	awec_get_events($needle, $events, false);


	$out = array(
		'today'		=> array(),
		'tomorrow'	=> array(),
		'others'	=> array(),
	);
	$count = awec_post_process_events($events, $out);


	if(!$count) {
		echo '
<p>
<span class="small2">'.$locale['awec_no_events'].'</span>
</p>';
	}

	foreach($out as $type => $content) {
		if(!count($content)) {
			continue;
		}
		echo '
<strong>'.$locale['EC209'][$type].':</strong>
<ul>
	<li>'.implode("</li>\n\t<li>", $content).'</li>
</ul>';
	}

}



/*
 * birthdays
 */
if(!$awec_settings['birthdays_are_events']
	&& $awec_settings['show_birthday_to_group']>=0
        && checkgroup($awec_settings['show_birthday_to_group']))
{
        $res = dbquery("SELECT user_name, user_birthdate, user_id,
                user_avatar,
		(YEAR(CURDATE())-YEAR(user_birthdate)) AS years_old
                FROM ".DB_USERS."
                WHERE MONTH(user_birthdate)='".date('n')."'
                        AND DAYOFMONTH(user_birthdate)='".date("j")."'");
        if(dbrows($res)) {
                $path = INFUSIONS.'aw_ecal_panel';
                echo '
<img src="'.$path.'/icons/birthday.gif" alt="'.$locale['EC712'].'"
	style="vertical-align:bottom;">
<strong>'.$locale['EC205'].':</strong>
<ul>';
                while($data = dbarray($res)) {
                        if(empty($data['user_avatar'])) {
                                $img = INFUSIONS.'aw_ecal_panel/icons/noav.gif';
                        } else {
                                $img = BASEDIR.'images/avatars/'
					.$data['user_avatar'];
                        }
			$header = sprintf($locale['awec_user_birthday']['title'], $data['user_name']);
			$body = '<img src="'.$img.'" alt="'.$data['user_name'].'" />';
			$body .= '<br />'.str_replace(
				array('%1', '%2'),
				array($data['user_name'], $data['years_old']),
				$locale['awec_user_birthday']['body']);


                        echo '
	<li><a href="'.BASEDIR.'profile.php?lookup='.$data['user_id'].'" title="cssbody[tbl1] cssheader=[tbl2] header=['.phpentities($header).'] body=['.phpentities($body).']">'.$data['user_name'].'</a> ('.$data['years_old'].')</li>';
                }
		echo '
</li>';
        }
}


closeside();
?>
