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
if(!iSUPERADMIN) {
	fallback('index.php');
}


/****************************************************************************
 * ACTION
 */
if(isset($_POST['save'])) {
	$need_admin_ok = (isset($_POST['need_admin_ok']) ? "1" : "0");
	$s_today_in_panel = (isset($_POST['show_today_in_panel']) ? "1" : "0");
	$s_birthdays_are_events = (isset($_POST['birthdays_are_events']) ? "1" : "0");
	$edit_group = intval($_POST['edit_group']);
	if(!$edit_group) {
		$edit_group = "103";
	}
	$post_group = intval($_POST['post_group']);
	if(!$post_group) {
		$edit_group = "101";
	}
	$b_group = intval($_POST['b_group']);

	$next_days = intval($_POST['next_days']);

	$b_date_fmt = stripinput($_POST['b_date_fmt']);
	$date_fmt = stripinput($_POST['date_fmt']);
	$s_date_fmt = stripinput($_POST['sidedate_fmt']);
	$time_fmt = stripinput($_POST['time_fmt']);

	$sun_first_dow = (isset($_POST['sun_first_dow']) ? "yes" : "no");

	$default_month_view = $_POST['default_month_view'];
	if(!isset($locale['awec_month_view'][$default_month_view])) {
		$default_month_view = 'calendar';
	}
	$default_calendar_view = $_POST['default_calendar_view'];
	if(!isset($locale['awec_calendar_view'][$default_calendar_view])) {
		$default_calendar_view = 'month';
	}
	$show_week = (isset($_POST['show_week']) ? 1 : 0);

	$use_custom_css = (isset($_POST['use_custom_css']) ? '1' : '0');
	$use_alt_side_calendar = (isset($_POST['use_alt_side_calendar']) ? '1' : '0');

	$user_can_edit = (isset($_POST['user_can_edit']) ? 1 : 0);

	$ok = dbquery("UPDATE ".AWEC_DB_SETTINGS."
		SET
		need_admin_ok='".$need_admin_ok."',
		edit_group='".$edit_group."',
		post_group='".$post_group."',
		user_can_edit=".$user_can_edit.",

		show_today_in_panel='".$s_today_in_panel."',
		birthdays_are_events='".$s_birthdays_are_events."',
		show_birthday_to_group='".$b_group."',
		birthdate_fmt='".$b_date_fmt."',
		next_days_in_panel='".$next_days."',
		sun_first_dow='".$sun_first_dow."',

		default_month_view='".$default_month_view."',
		default_calendar_view='".$default_calendar_view."',
		show_week='".$show_week."',

		use_custom_css='".$use_custom_css."',
		use_alt_side_calendar='".$use_alt_side_calendar."',

		sidedate_fmt='".$s_date_fmt."',
		date_fmt='".$date_fmt."',
		time_fmt='".$time_fmt."'");
	if($ok) {
		fallback(FUSION_SELF.'?errno=0');
	}
}


/****************************************************************************
 * GUI
 */
opentable($locale['EC700']);
awec_menu();
echo '
<div style="text-align:right;">
	<strong><code>awEventCalendar '.$awec_settings['version'].'</code></strong>
</div>';

require_once('include/db_update.php');


if(isset($_GET['errno']) && isset($locale['EC717'][$_GET['errno']])) {
	show_info($locale['EC717'][$_GET['errno']], 'info');
}



// all groups
$usergroups = getusergroups();
$sel_edit_group = '';
$sel_post_group = '';
$sel_b_group = '';
foreach($usergroups as $group) {
	list($gid, $gname) = $group;

	$sel_b_group .= '
	<option value="'.$gid.'"'
		.($gid==$awec_settings['show_birthday_to_group']
			? ' selected="selected"'
			: '')
		.'>'.$gname.'</option>';

	if(!$gid) {
		continue;
	}
	$sel_edit_group .= '
		<option value="'.$gid.'"'
			.($gid==$awec_settings['edit_group']
				? ' selected="selected"'
				: '')
			.'>'.$gname.'</option>';
	$sel_post_group .= '
		<option value="'.$gid.'"'
			.($gid==$awec_settings['post_group']
				? ' selected="selected"'
				: '')
			.'>'.$gname.'</option>';
}


$sel_default_month_view = '';
foreach($locale['awec_month_view'] as $key => $title) {
	$sel_default_month_view .= '
		<option value="'.$key.'"'
			.($key==$awec_settings['default_month_view']
				? ' selected="selected"'
				: '')
			.'>'.$title.'</option>';
}
$sel_default_calendar_view = '';
foreach($locale['awec_calendar_view'] as $key => $title) {
	$sel_default_calendar_view .= '
		<option value="'.$key.'"'
			.($key==$awec_settings['default_calendar_view']
				? ' selected="selected"'
				: '')
			.'>'.$title.'</option>';
}


$res = dbquery("SELECT
	DATE_FORMAT(NOW(), '".$awec_settings['birthdate_fmt']."') AS b_date,
	DATE_FORMAT(NOW(), '".$awec_settings['date_fmt']."') AS s_date,
	TIME_FORMAT(NOW(), '".$awec_settings['time_fmt']."') AS s_time
	"
	);
$fmt_sample = dbarray($res);
$fmt_sample['sidedate_fmt'] = ec_format_fucking_date(date('Y'), date('m'), date('d'));


echo '
<form method="post" action="'.FUSION_SELF.'">
<table width="100%" cellspacing="1" border="0">
<colgroup>
	<col width="150" />
	<col width="*" />
</colgroup>
<tbody>
<tr>
	<td>'.$locale['EC701'].':</td>
	<td>
		<select name="edit_group" class="textbox">'.$sel_edit_group.'
		</select>
	</td>
</tr>
<tr>
	<td valign="top">'.$locale['EC703'].':</td>
	<td>
		<select name="post_group" class="textbox">'.$sel_post_group.'
		</select>
		<br />
		<label><input type="checkbox" name="need_admin_ok"'
			.($awec_settings['need_admin_ok']
				? ' checked="checked"'
				: ''
			).' /> '.$locale['EC702'].'</label>
		<br />
		<label><input type="checkbox" name="user_can_edit"'
			.($awec_settings['user_can_edit']
				? ' checked="checked"'
				: ''
			).' /> '.$locale['awec_user_can_edit'].'</label>
	</td>
</tr>
<tr>
	<td>'.$locale['EC722'].':</td>
	<td>
		<input type="text" name="next_days" class="textbox" size="4"
			value="'.$awec_settings['next_days_in_panel'].'"
			maxlength="3" />
	</td>
</tr>
<tr>
	<td valign="top">'.$locale['EC706'].':</td>
	<td>
		<select name="b_group" class="textbox"'
		.($awec_settings['show_birthday_to_group']==-1
			? ' disabled="disabled"'
			: ''
			).'>'.$sel_b_group.'
			</select>
		<br />
		<label><input type="checkbox" name="birthdays_are_events"'
			.($awec_settings['show_birthday_to_group']==-1
				|| $awec_settings['birthdays_are_events']==-1
				? ' disabled="disabled"'
				: ''
			).($awec_settings['birthdays_are_events']
				? ' checked="checked"'
				: ''
			).' /> '.$locale['awec705'].'</label>'
			.($awec_settings['birthdays_are_events']==-1
				? '<br /><strong>'.$locale['awec_mysql_4']
					.'</strong>'
				: ''
			).'
	</td>
</tr>

<tr>
	<td><label>'.$locale['awec_default_month_view'].'</label>:</td>
	<td>
		<select name="default_month_view" class="textbox">'
			.$sel_default_month_view.'
		</select>
	</td>
</tr>
<tr>
	<td><label>'.$locale['awec_default_calendar_view'].'</label>:</td>
	<td>
		<select name="default_calendar_view" class="textbox">'
			.$sel_default_calendar_view.'
		</select>
	</td>
</tr>

<tr>
	<td valign="top">'.$locale['awec_options'].':</td>
	<td>
		<label><input type="checkbox" name="show_today_in_panel"'
			.($awec_settings['show_today_in_panel']
				? ' checked="checked"'
				: ''
			).' /> '.$locale['EC704'].'</label>
		<br />
		<label><input type="checkbox" name="sun_first_dow"'
			.($awec_settings['sun_first_dow']=='yes'
				? ' checked="checked"'
				: ''
			).' /> '.$locale['EC723'].'</label>
		<br />
		<label><input type="checkbox" name="use_custom_css"'
			.($awec_settings['use_custom_css']
				? ' checked="checked"'
				: ''
			).' /> '.$locale['awec_custom_css'].'</label>
		<br />
		<label><input type="checkbox" name="use_alt_side_calendar"'
			.($awec_settings['use_alt_side_calendar']
				? ' checked="checked"'
				: ''
			).' /> '.$locale['awec_alt_side_calendar'].'</label>
		<br />
		<label><input type="checkbox" name="show_week"'
			.($awec_settings['show_week']
				? ' checked="checked"'
				: ''
			).' /> '.$locale['awec_show_week'].'</label>
	</td>
</tr>
</tbody>
</table>

<fieldset>
<legend>'.$locale['EC711'].'</legend>
<table width="100%">
<colgroup>
	<col width="150" />
	<col width="*" />
</colgroup>
<tbody>
<tr>
	<td>'.$locale['EC712'].':</td>
	<td><input type="text" class="textbox" name="b_date_fmt"
		size="20" maxlength="50"
		value="'.$awec_settings['birthdate_fmt'].'"> '
		.$locale['EC720'].": ".$fmt_sample['b_date'].'</td>
</tr>
<tr>
	<td>'.$locale['EC713'].':</td>
	<td><input type="text" class="textbox" name="date_fmt"
		size="20" maxlength="50"
		value="'.$awec_settings['date_fmt'].'"> '
		.$locale['EC720'].": ".$fmt_sample['s_date'].'</td>
</tr>
<tr>
	<td>'.$locale['EC726'].':</td>
	<td><input type="text" class="textbox" name="time_fmt"
		size="20" maxlength="50"
		value="'.$awec_settings['time_fmt'].'"> '
		.$locale['EC720'].': '.$fmt_sample['s_time'].'</td>
</tr>
<tr>
	<td></td>
	<td><span class="small2">'.nl2br($locale['EC719']).'</span></td>
</tr>
<tr>
	<td>'.$locale['EC724'].':</td>
	<td><input type="text" class="textbox" name="sidedate_fmt"
		size="20" maxlength="50"
		value="'.$awec_settings['sidedate_fmt'].'" /> '
		.$locale['EC720'].': '.$fmt_sample['sidedate_fmt'].'</td>
</tr>
<tr>
	<td></td>
	<td><span class="small2">'.$locale['EC725'].': '
		.implode(', ', $ec_supported).'</span></td>
</tr>
</tbody>
</table>
</fieldset>

<p>
<input type="submit" value="'.$locale['EC111'].'" name="save" class="button" />
</p>

</form>';
closetable();


require_once('include/die.php');
?>
