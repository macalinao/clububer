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
if(!iAWEC_POST) {
	fallback('index.php');
}


if(FUSION_VERSION=='FF' || FUSION_VERSION=='7') {
	$js = <<<JS
<script type="text/javascript">
function awec_show_repeat(enabled)
{
	if(enabled) {
		$("#repeat_options").show();
	} else {
		$("#repeat_options").hide();
	}
}
function awec_enable_end_date(enabled)
{
	if(enabled) {
		$("#end_date input").removeAttr('disabled');
		$("#end_date select").removeAttr('disabled');
	} else {
		$("#end_date input").attr('disabled', 'disabled');
		$("#end_date select").attr('disabled', 'disabled');
	}
}

function awec_show_logins(enabled)
{
	if(enabled) {
		$("#logins_options").show();
	} else {
		$("#logins_options").hide();
	}
}

%BEGIN%
	awec_show_logins($("#allow_logins")[0].checked);
	$("#allow_logins").change(function(){
		awec_show_logins(this.checked);
	});

	awec_show_repeat($("#repeat_cycle").val()!=0);
	$("#repeat_cycle").change(function(){
		awec_show_repeat($(this).val()!=0);
	});

	awec_enable_end_date($("input[@name=repeat_duration]").val()!='endless');
	$("input[@name=repeat_duration]").change(function(){
		awec_enable_end_date($(this).val()!='endless');
	});
%END%
</script>
JS;
if(FUSION_VERSION=='7') {
	add_to_head(str_replace(
		array('%BEGIN%', '%END%'),
		array('$(document).ready(function(){', '});'),
		$js));
} else {
	echo str_replace(
		array('%BEGIN%', '%END%'),
		array('FF.behaviors.awec_edit_event=function(content){', '};' ),
		$js);
}
}



/****************************************************************************
 * GET
 */
$action = FUSION_SELF;
$event = array(
	'ev_id'			=> 0,
	//
	'ev_title'		=> '',
	'ev_body'		=> '',
	'ev_location'		=> '',
	'ev_status'		=> AWEC_DRAFT,
	'ctime'			=> 0,
	'ev_repeat'		=> 0,
	'ev_private'		=> 0,
	'ev_allow_logins'	=> 0,
	'ev_max_logins'		=> 0,
	'ev_login_access'	=> 0,
	'ev_no_smileys'		=> 0,
	'ev_access'		=> 0,
	'ev_start'		=> date('Y-m-d'),
	'ev_end'		=> date('Y-m-d'),
	'ev_start_time'		=> '',
	'ev_end_time'		=> '',
	//
	'ev_login_start'	=> 0,
	'ev_login_end'		=> 0,
);
if(isset($_GET['id'])) {
	if(!isNum($_GET['id'])) {
		fallback('index.php');
	}

	$where = array(
		"ev_id='".$_GET['id']."'"
	);
	if(!iAWEC_ADMIN) {
		$where[] = "user_id='".$userdata['user_id']."'";
	}
	if($awec_settings['user_can_edit']) {
		$where[] = "ev_status<>".AWEC_PENDING;
	} else {
		$where[] = "ev_status=".AWEC_DRAFT;
	}


	$res = dbquery("SELECT ".implode(', ', array_keys($event))."
		FROM ".AWEC_DB_EVENTS."
		WHERE ".implode(' AND ', $where));
	if(!dbrows($res)) {
		fallback('index.php');
	}
	$event = dbarray($res);
	$action .= '?id='.$event['ev_id'];

} else {
	if(isset($_GET['date']) && preg_match(AWEC_DATE_FORMAT, $_GET['date'])){
		$event['ev_end'] = $event['ev_start'] = $_GET['date'];
	}
}


$errors = array();



/****************************************************************************
 * ACTION
 */
if(isset($_POST['save'])) {
	$event['ev_title'] = trim(stripinput($_POST['title']));
	$event['ev_body'] = trim(stripinput($_POST['desc']));
	if(empty($event['ev_title']) || empty($event['ev_body'])) {
		$errors[] = $locale['EC119'];
	}
	$event['ev_access'] = intval($_POST['access']);
	$event['ev_no_smileys'] = (isset($_POST['disable_smileys']) ? '1' : '0');

	$event['ev_location'] = trim(stripinput($_POST['location']));

	$event['ev_start'] = awec_get_date($_POST, 'start');
	if(!$event['ev_start']) {
		$errors[] = $locale['EC113']['date'];
	}

	$event['ev_start_time'] = awec_get_time($_POST, 'start_time');
	$event['ev_end_time'] = awec_get_time($_POST, 'end_time');

	$event['ev_allow_logins'] = (isset($_POST['allow_logins']) ? '1' : '0');
	$event['ev_max_logins'] = intval($_POST['max_logins']);
	$event['ev_login_access'] = intval($_POST['login_access']);
	if(!$event['ev_login_access']
		|| !checkgroup($event['ev_login_access']))
	{
		$event['ev_login_access'] = 101;
	}

	$event['ev_login_start'] = 0;
	$event['ev_login_end'] = 0;
/*
	$date = awec_get_date($_POST, 'login_start');
	$time = substr(awec_get_time($_POST, 'login_start'), 1, 8);
	$event['ev_login_start'] = intval(strtotime($date.' '.$time));

	$date = awec_get_date($_POST, 'login_end');
	$time = substr(awec_get_time($_POST, 'login_end'), 1, 8);
	$event['ev_login_end'] = intval(strtotime($date.' '.$time));
*/

	$event['ev_repeat'] = intval($_POST['repeat_cycle']);
	$event['ev_end'] = '0000-00-00';
	if($event['ev_repeat']) {
		if($_POST['repeat_duration']=='date') {
			$end_date = awec_get_date($_POST, 'end');
			$event['ev_end'] = $end_date;

			if($end_date
				&& (strtotime($end_date)<strtotime($event['ev_start']))) {
					$end_date = false;
			}
			if(!$end_date) {
				$errors[] = $locale['EC113']['end_date'];
			}
		}
	}


	$event['ev_private'] = (isset($_POST['is_private']) ? '1' : '0');


	if($event['ev_private']) {
		if($event['ev_allow_logins']) {
			$event['ev_allow_logins'] = '0';
			$event['ev_max_logins'] = '0';
			$event['ev_login_access'] = '101';
			$errors[] = $locale['EC113'][EC_ELOGIN];
		}
		if($event['ev_access']) {
			$event['ev_access'] = '0';
			$errors[] = $locale['EC113'][EC_EACCESS];
		}
	}

	if(count($errors)==0) {
		if(!$event['ev_id']) {
			dbquery("INSERT INTO ".AWEC_DB_EVENTS."
				SET
				user_id='".$userdata['user_id']."',
				ctime='".time()."',
				ev_body=''");
			$event['ev_id'] = mysql_insert_id();
		}

		// categories
		dbquery("DELETE FROM ".AWEC_DB_EVENTS_IN_CATS."
			WHERE event_id='".$event['ev_id']."'");
		if(isset($_POST['cat']) && is_array($_POST['cat'])) {
			foreach($_POST['cat'] as $catid => $checked) {
				if(!isNum($catid)) {
					continue;
				}
				dbquery("INSERT INTO ".AWEC_DB_EVENTS_IN_CATS."
					SET
					cat_id='".$catid."',
					event_id='".$event['ev_id']."'");
			}
		}

		$ok = dbquery("UPDATE ".AWEC_DB_EVENTS."
			SET
			ev_title='".$event['ev_title']."',
			ev_body='".$event['ev_body']."',
			ev_location='".$event['ev_location']."',
			ev_start='".$event['ev_start']."',
			ev_end='".$event['ev_end']."',
			ev_start_time=".$event['ev_start_time'].",
			ev_end_time=".$event['ev_end_time'].",
			ev_repeat='".$event['ev_repeat']."',
			ev_private='".$event['ev_private']."',
			ev_status='".AWEC_DRAFT."',
			ev_no_smileys='".$event['ev_no_smileys']."',
			ev_allow_logins='".$event['ev_allow_logins']."',
			ev_max_logins='".$event['ev_max_logins']."',
			ev_access='".$event['ev_access']."',
			ev_login_access='".$event['ev_login_access']."',
			ev_login_start='".$event['ev_login_start']."',
			ev_login_end='".$event['ev_login_end']."'
			WHERE ev_id='".$event['ev_id']."'");
		if($ok) {
			if(isset($_POST['save_release']) && iAWEC_RELEASE)
			{
				fallback('include/event_ops.php?id='.$event['ev_id']
					.'&release');
			} elseif(isset($_POST['save_publish'])
				&& iAWEC_PUBLISH)
			{
				fallback('include/event_ops.php?id='.$event['ev_id']
					.'&publish');
			}
			fallback('edit_event.php?id='.$event['ev_id']
				.'&errno=0');
		}
	}

}



/****************************************************************************
 * FUNCS
 */
function awec_make_date($date, $fname, $can_be_null=false)
{
	global $locale;

	$year = substr($date, 0, 4);
	$mon = substr($date, 5, 2);
	$mday = substr($date, 8, 2);

	$sel_day = '';
	$sel_month = '';

	$start_from = ($can_be_null ? 0 : 1);

	// day
	for($i=$start_from; $i<=31; ++$i) {
		$sel_day .= '
			<option value="'.$i.'"'
				.($i==$mday
					? ' selected="selected"'
					: '')
			.'>'.$i.'</option>';
	}
	// month
	for($i=$start_from; $i<=12; ++$i) {
		$sel_month .= '
			<option value="'.$i.'"'
				.($i==$mon
					? ' selected="selected"'
					: '')
			.'>'.$locale['EC900'][$i].'</option>';
	}

	return '
<select class="textbox" name="'.$fname.'[mday]" id="'.$fname.'_mday">'.$sel_day.'
</select>
.
<select class="textbox" name="'.$fname.'[month]" id="'.$fname.'_month">'.$sel_month.'
</select>
.
<input type="text" class="textbox" name="'.$fname.'[year]" id="'.$fname.'_year"
	value="'.$year.'" size="5" maxlength="4" />';
}


function awec_make_time($time, $fname) {
	global $locale;

	if(preg_match('/^\d\d:\d\d:\d\d$/', $time)) {
		$hours = substr($time, 0, 2);
		$mins = substr($time, 3, 2);
	} else {
		$hours = $mins = -1;
	}

	$sel_mins = $sel_hours = '<option value="-1">--</option>';

	// hours
	for($i=0; $i<=23; ++$i) {
		$sel_hours .= '
			<option value="'.$i.'"'
				.($i==$hours
					? ' selected="selected"'
					: '')
				.'>'.($i<10 ? '0' : '').$i.'</option>';
	}
	// mins
	for($i=0; $i<=59; ++$i) {
		$sel_mins .= '
			<option value="'.$i.'"'
				.($i==$mins
					? ' selected="selected"'
					: '')
				.'>'.($i<10 ? '0' : '').$i.'</option>';
	}

	return '
<select class="textbox" name="'.$fname.'[hours]">'.$sel_hours.'
</select>
:
<select class="textbox" name="'.$fname.'[mins]">'.$sel_mins.'
</select>';
}

function awec_make_datetime($datetime, $fname)
{
	global $locale;

	$date = date('Y-m-d H:i', $datetime);

	return awec_make_date(substr($date, 0, 10), $fname, true)
		.'&nbsp;'.awec_make_time(substr($date, 11, 8), $fname)
		.'<br />'
		.'<span class="small2">'.$locale['awec_date_fmt'].'</span>';
}

// returns 'NULL' or 'time in quotes'
function awec_get_time($data, $fname) {
	if(!isset($data[$fname]) || !isset($data[$fname]['hours'])
		|| !isset($data[$fname]['mins']))
	{
		return 'NULL';
	}
	if($data[$fname]['hours']<0 || $data[$fname]['mins']<0) {
		return 'NULL';
	}

	return sprintf("'%02d:%02d:00'",
		intval($data[$fname]['hours']),
		intval($data[$fname]['mins']));
}
// returns false on failure 'date in quotes'
function awec_get_date($data, $fname) {
	if(!isset($data[$fname]) || !isset($data[$fname]['year'])
		|| !isset($data[$fname]['month'])
		|| !isset($data[$fname]['mday'])
		|| !checkdate($data[$fname]['month'], $data[$fname]['mday'],
			$data[$fname]['year']))
	{
		return false;
	}

	return sprintf("%04d-%02d-%02d",
		intval($data[$fname]['year']),
		intval($data[$fname]['month']),
		intval($data[$fname]['mday']));
}


/*
function ec_get_timestamp($fname) {
	return mktime($_POST[$fname."_hours"], $_POST[$fname."_mins"], 0,
		$_POST[$fname."_month"], $_POST[$fname."_mday"],
		$_POST[$fname."_year"]);
}
*/



/****************************************************************************
 * GUI
 */
$sel_access = '';
$sel_login_access = '';
$fusion_groups = getusergroups();
foreach($fusion_groups as $group) {
	list($gid, $gname) = $group;
	if(!checkgroup($gid)) {
		continue;
	}

	$sel_access .= '
		<option value="'.$gid.'"'
			.($gid==$event['ev_access']
				? ' selected="selected"'
				: ''
		).'>'.$gname.'</option>';

	if(!$gid) {
		continue;
	}
	$sel_login_access .= '
		<option value="'.$gid.'"'
			.($gid==$event['ev_login_access']
				? ' selected="selected"'
				: ''
		).'>'.$gname.'</option>';
}

$sel_repeat = '';
foreach($locale['EC125'] as $rep => $text) {
	$sel_repeat .= '
		<option value="'.$rep.'"'
			.($rep==$event['ev_repeat']
				? ' selected="selected"'
				: '')
		.'>'.$text.'</option>';
}


$cats = '';
$res = dbquery("SELECT c.cat_id, cat_name, event_id
	FROM ".AWEC_DB_CATS." AS c
	LEFT JOIN ".AWEC_DB_EVENTS_IN_CATS." AS eic
		ON c.cat_id=eic.cat_id AND event_id=".$event['ev_id']."
	ORDER BY cat_name ASC");
while($row = dbarray($res)) {
	$cats .= '
<label><input type="checkbox" name="cat['.$row['cat_id'].']"'
	.($row['event_id']
		? ' checked="checked"'
		: ''
	).' /> '.$row['cat_name'].'</label>
<br />';
}



/****************************************************************************
 * GUI
- <input type='button' value='".AWEC_BREAK."' class='button' onClick=\"insertText('comment_message', '".AWEC_BREAK."');\">\n";
 */
opentable($event['ev_id'] ? $locale['EC101'] : $locale['EC100']);
awec_menu();


if($event['ev_id']) {
	echo '
<div style="text-align:right">
<strong>'.$locale['awec_status'].':</strong> '
	.$locale['awec_status_desc'][$event['ev_status']].'
| <a href="view_event.php?id='.$event['ev_id'].'">'.$locale['EC102'].'</a>
</div>';
}

if(count($errors)) {
	show_info($errors, 'warning');
}
if(isset($_GET['errno']) && isset($locale['EC113'][$_GET['errno']])) {
	show_info($locale['EC113'][$_GET['errno']], 'info');
}


$tabs = array(
	'desc'		=> $locale['awec_description'],
	'repeat'	=> $locale['awec_repeat'],
	'logins'	=> $locale['awec_logins'],
);
if(!empty($cats)) {
	$tabs['cats'] = $locale['awec_cats'];
}
awec_tabs($tabs);


awec_open_tab('desc', $locale['awec_description']);
echo '
<form action="'.$action.'" method="post" name="inputform">

<p>
<label for="title">'.$locale['EC103'].':</label>
<span class="small">'.$locale['awec_mandatory'].'</span><br />
<input type="text" name="title" id="title" class="textbox" size="40"
	maxlength="200" value="'.$event['ev_title'].'" />
</p>

<p>
<label for="desc">'.$locale['awec_description'].':</label>
<span class="small">'.$locale['awec_mandatory'].'</span><br />
<span class="small2">'.str_replace('%s', htmlentities(AWEC_BREAK),
	$locale['awec_break']).'</span>
'.awec_get_bb_smileys('desc', $event['ev_body'], $event['ev_no_smileys']).'
</p>

<p>
<label for="location">'.$locale['awec_location'].':</label><br />
<input type="text" name="location" id="location" class="textbox" size="40"
	maxlength="100" value="'.$event['ev_location'].'" />
</p>

<p>
<fieldset>
<legend>'.$locale['awec_options'].':</legend>

<p>
<label>'.$locale['awec_date'].': *</label><br />
'.awec_make_date($event['ev_start'], 'start').'
<br />
<span class="small2">'.$locale['awec_date_fmt'].'</span>
</p>

<p>
<label>'.$locale['awec_beginn'].':</label><br />
'.awec_make_time($event['ev_start_time'], 'start_time').'<br />
<span class="small2">'.$locale['awec_time_fmt'].'</span>
</p>

<p>
<label>'.$locale['awec_end'].':</label><br />
'.awec_make_time($event['ev_end_time'], 'end_time').'<br />
<span class="small2">'.$locale['awec_time_fmt'].'</span>
</p>

<p>
<label>'.$locale['EC116'].':</label><br />
<select class="textbox" name="access">'.$sel_access.'
</select>
<label><input type="checkbox" name="is_private"'
	.($event['ev_private']
		? ' checked="checked"'
		: '')
	.' /> '.$locale['EC108'].'</label>
</p>

</fieldset>
</p>
';
awec_close_tab();


awec_open_tab('repeat', $locale['awec_repeat']);
echo '
<p>
<label for="repeat_cycle">'.$locale['awec_cycle'].':</label><br />
<select class="textbox" name="repeat_cycle" id="repeat_cycle">'.$sel_repeat.'
</select>
</p>

<div id="repeat_options">
	<p>
	<label><input type="radio" name="repeat_duration" value="endless"'
		.(!$event['ev_repeat'] || substr($event['ev_end'], 0, 4)=='0000'
			? ' checked="checked"'
			: ''
		).' /> '.$locale['awec_endless_repeat'].'</label>
	</p>
	<p>
	<label><input type="radio" name="repeat_duration" value="date"'
		.($event['ev_repeat'] && substr($event['ev_end'], 0, 4)!='0000'
			? ' checked="checked"'
			: ''
		).' /> '.$locale['awec_end_repeat'].':</label>
	<div id="end_date">
		'.awec_make_date($event['ev_end'], 'end', true).'<br />
		<span class="small2">'.$locale['awec_date_fmt'].'</span>
	</div>
	</p>
</div>';
awec_close_tab();


awec_open_tab('logins', $locale['awec_logins']);
echo '
<label><input type="checkbox" name="allow_logins" id="allow_logins"'
	.($event['ev_allow_logins']
		? ' checked="checked"'
		: '')
	.' /> '.$locale['EC109'].'</label>

<div id="logins_options">
	<p>
	<label for="max_logins">'.$locale['EC110'].':</label><br />
	<input type="text" class="textbox" name="max_logins" id="max_logins"
		value="'.$event['ev_max_logins'].'" size="5" maxlength="5" />
	<span class="small2">'.$locale['EC110_1'].'</span>
	</p>

	<p>
		<label for="login_access">'.$locale['EC116'].':</label><br />
		<select name="login_access" id="login_access" class="textbox">'.$sel_login_access.'
		</select>
</p>
</div>';

/*
echo '
<p>
	<label>'.$locale['awec_login_start'].':</label><br />
	'.awec_make_datetime($event['ev_login_start'], 'login_start').'
</p>

<p>
	<label>'.$locale['awec_login_end'].':</label><br />
	'.awec_make_datetime($event['ev_login_end'], 'login_end').'
</p>';
*/
awec_close_tab();


if(!empty($cats)) {
	awec_open_tab('cats', $locale['awec_cats']);
	echo $cats;
	awec_close_tab();
}


awec_tabs_close();


echo '
<p>
<span class="small2">'.$locale['awec_private_saving'].'</span>
</p>

<p>
<input type="hidden" name="save" value="just_do_it" />
<input type="submit" name="save_draft" class="button" value="'.$locale['awec_save_draft'].'" />';
if(iAWEC_RELEASE) {
	echo '
<input type="submit" name="save_release" class="button" value="'.$locale['awec_save_release'].'" />';
}
if(iAWEC_PUBLISH) {
	echo '
<input type="submit" name="save_publish" class="button" value="'.$locale['awec_save_publish'].'" />';
}




echo '
</p>
</form>';


closetable();


require_once('include/die.php');
?>
