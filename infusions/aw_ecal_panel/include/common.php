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
require_once dirname(dirname(dirname(dirname(__FILE__)))).'/maincore.php';
require_once(INFUSIONS.'aw_ecal_panel/include/core.php');


switch(FUSION_VERSION) {
case 6:
	require_once(BASEDIR.'subheader.php');
	require_once(BASEDIR.'side_left.php');
	break;
case 7:
	require_once(THEMES.'templates/header.php');
	break;
case 'FF':
	break;
default:
	die;
}





?>
<script type='text/javascript'>
function ec_confirm_delete() {
	return confirm("<?php echo $locale['EC006']; ?>");
}
</script>
<?php



/****************************************************************************
 * FUNCS
 */
function awec_menu()
{
	global $locale, $awec_settings;

	$menu = '';
	$path = INFUSIONS.'aw_ecal_panel';

	$menu = '
<table border="0" cellspacing="0" cellpadding="0" width="100%">
<colgroup>
	<col width="48%" />
	<col width="4%" />
	<col width="48%" />
</colgroup>
<tbody>
<tr>
	<td valign="top">
		<strong>'.$locale['awec_calendar'].':</strong>
		<a href="'.$path.'/calendar.php?cal=week">'
			.$locale['awec_week'].'</a>
		| <a href="'.$path.'/calendar.php">'.$locale['EC009'].'</a>
		| <a href="'.$path.'/calendar.php?cal=year">'.$locale['EC010'].'</a>
		| <a href="'.$path.'/search.php">'.$locale['EC011'].'</a>';
	if(iAWEC_POST) {
		$menu .= '
		| <a href="'.$path.'/edit_event.php">'.$locale['EC100'].'</a>';
	}
	if(iMEMBER) {
		$menu .= '
		<br />
		<strong>'.$locale['EC007'].':</strong>
		<a href="'.$path.'/my_events.php">'.$locale['EC001'].'</a>
		| <a href="'.$path.'/my_logins.php">'.$locale['awec_logins'].'</a>';
	}
	$menu .= '
	</td>
	<td>&nbsp;</td>
	<td align="right" valign="bottom">';
	if(iAWEC_ADMIN) {
		if(iSUPERADMIN) {
			$menu .= '
		<a href="'.$path.'/admin.php">'.$locale['EC700'].'</a>
		| <a href="'.$path.'/admin_cats.php">'.$locale['awec_cats'].'</a>
		| <a href="'.$path.'/admin/misc.php">'.$locale['EC750'].'</a>
		| ';
		}
		$menu .= '<a href="'.$path.'/new_events.php">'
			.$locale['EC013'].'</a><br />';
	}
	$menu .= '<a href="'.$path.'/about.php">'.$locale['EC005'].'</a>
	</td>
</tr>
</tbody>
</table>
<hr />';

	echo $menu;
}


if(!function_exists('awec_render_event')) {
function awec_render_event($event, $target='')
{
	global $locale, $userdata, $awec_settings;


	$body = str_replace(stripinput(AWEC_BREAK), '', $event['ev_body']);
	if(!$event['ev_no_smileys']) {
		$body = parsesmileys($body);
	}
	$body = nl2br(parseubb($body));


	$admin_stuff = array();
	//
	if(iAWEC_ADMIN) {
		$can_edit = true;
		$can_publish = true;
	} else {
		$can_edit = (iMEMBER
			&& $event['user_id']==$userdata['user_id']
			&& ($event['ev_status']==AWEC_DRAFT
				|| ($awec_settings['user_can_edit']
					&& $event['ev_status']==AWEC_PUBLISHED)));
		$can_publish = false;
	}

	if($event['ev_allow_logins']) {
		$admin_stuff[] = "<a href='view_event.php?id="
			.$event['ev_id']."#logins'>".$locale['awec_logins']."</a>";
	}
	if($can_edit) {
		$admin_stuff[] = "<a href='edit_event.php?id="
			.$event['ev_id']."'>".$locale['awec_edit']."</a>";
	}
	if($can_publish && $event['ev_status']==AWEC_PENDING) {
		$admin_stuff[] = '<a href="include/event_ops.php?id='
			.$event['ev_id'].'&amp;publish&amp;backto=new">'
				.$locale['awec_publish'].'</a>';
	}
	if(iAWEC_ADMIN) {
		$admin_stuff[] = "<a href='include/event_ops.php?id="
				.$event['ev_id']."&amp;delete&amp;backto=new'"
			." onclick='return ec_confirm_delete();'>"
			.$locale['EC305']."</a>";
	}
	if(count($admin_stuff)) {
		$admin_stuff = implode(' | ', $admin_stuff);
	} else {
		$admin_stuff = '';
	}


	$more = array();
	if($event['ev_private']) {
		$more[] = '<img src="icons/locked.gif" alt="'.$locale['EC108'].'"'
				.' title="'.$locale['EC108'].'">';
	} elseif($event['ev_access']) {
		$more[] = '<strong>'.$locale['EC116'].':</strong> '
				.getgroupname($event['ev_access']);
	}
	if($event['ev_repeat']) {
		$more[] = '<strong>'.$locale['awec_repeat'].':</strong> '
				.$locale['EC125'][$event['ev_repeat']];
	}
	$more[] = '<a href="export/ical.php?id='.$event['ev_id'].'"><img src="icons/export.png" alt="'.$locale['awec_export'].'" title="'.$locale['awec_export'].'" class="noborder" /></a>';


	$time = '';
	if($event['start_time']) {
		$time = $event['start_time'];
		if($event['end_time']) {
			$time .= ' - '.$event['end_time'];
		}
		$time .= '<br />';
	}
	if(!empty($event['ev_location'])) {
		$time .= $event['ev_location'].'<br />';
	}

/*
	echo '
<div class="awec_event">
	<img src="icons/event.gif" alt="'.$locale['EC300'].'" class="icon">
	<div class="head">
		<div class="left">
			'.$event['date'].'<br />
			'.$time.'
			<span class="title">'.$event['ev_title'].'</span>
		</div>
		<div class="right">
			'.implode('<br />', $more).'
		</div>
	</div>
	<div class="body">
		'.$body.'
	</div>
	<div class="status">
		<div class="left">
		<a href="'.BASEDIR.'profile.php'
			.'?lookup='.$event['user_id'].'">'.$event['user_name']
				.'</a> - '.showdate('shortdate',
			$event['ctime']).'
		</div>
		<div class="right">
			'.$admin_stuff.'
		</div>
	</div>
	<div style="clear:both;"></div>
</div>';
*/


	$date = $event['date'];
	if($event['ev_repeat'] && $event['ev_end']!='0000-00-00') {
		$date .= ' - '.$event['end_date'];
	}

	// categories
	$cats = array();
	$res = dbquery("SELECT cat_name
		FROM ".AWEC_DB_CATS."
		LEFT JOIN ".AWEC_DB_EVENTS_IN_CATS." USING(cat_id)
		WHERE event_id=".$event['ev_id']);
	while($row = dbarray($res)) {
		$cats[] = $row['cat_name'];
	}
	if(count($cats)) {
		$cats = ' - '.implode(', ', $cats);
	} else {
		$cats = '';
	}


	echo '
<p></p>
<table border="0" width="100%" cellspacing="1" cellpadding="0" class="tbl-border">
<tbody>
<tr class="tbl2">
	<td>
	<table width="100%">
	<tr>
		<td width="38"><img src="icons/event.gif" alt="'.$locale['EC300'].'"></td>
		<td>
			'.$date.'<br />
			'.$time.'
			<strong>'.$event['ev_title'].'</strong>
		</td>
		<td valign="top" align="right">'.implode('<br />', $more).'</td>
	</tr>
	</table>
	</td>
</tr>
<tr class="tbl1">
	<td>'.$body.'</td>
</tr>
<tr class="tbl2">
	<td>
	<table width="100%" cellspacing="0" cellpadding="0">
	<tr>
		<td>
			<span class="small2">
				<a href="'.BASEDIR.'profile.php'
					.'?lookup='.$event['user_id'].'">'
						.$event['user_name'].'</a>
				- '.showdate('shortdate', $event['ctime']).'
				'.$cats.'
			</span>
		</td>
		<td align="right">'.$admin_stuff.'</td>
	</tr>
	</table>
	</td>
</tr>
</tbody>
</table>';
}
}



if(!function_exists('ec_render_birthday')) {
function ec_render_birthday($event)
{
	global $locale;

	$body = str_replace(
		array('%1', '%2'),
		array('<a href="'.BASEDIR.'profile.php?lookup='.$event['user_id'].'">'.$event['user_name'].'</a>', $event['years_old']),
		$locale['awec_user_birthday']['body']);

/*
	echo '
<div class="awec_event">
	<img src="icons/birthday.png" alt="'.$locale['EC712'].'" class="icon" />
	<div class="head">
		'.$event['date'].'<br />
		<span class="title">'.$event['ev_title'].'</span>
	</div>
	<div class="body">
		'.$body.'
	</div>
</div>';
*/

	echo '
<p></p>
<table border="0" width="100%" cellspacing="1" cellpadding="0" class="tbl-border">
<tbody>
<tr class="tbl2">
	<td>
	<table width="100%">
	<tr>
		<td width="38"><img src="icons/birthday.png" alt="'.$locale['EC712'].'"></td>
		<td>
			'.$event['date'].'<br />
			<span class="awec_title">'.$event['ev_title'].'</span>
		</td>
	</tr>
	</table>
	</td>
</tr>
<tr class="tbl1">
	<td>'.$body.'</td>
</tr>
</tbody>
</table>';
}
}
if(!function_exists('awec_clist')) {
function awec_clist($events)
{
	foreach($events as $event) {
		$time = '';
		if($event['start_time']) {
			$time = ' | '.$event['start_time'];
			if($event['end_time']) {
				$time .= ' - '.$event['end_time'];
			}
		}

		if(!$event['is_birthday'] && $event['ev_no_smileys']) {
			$body = parsesmileys($event['ev_body']);
		} else {
			$body = $event['ev_body'];
		}
		$body = str_replace(stripinput(AWEC_BREAK), '', $body);
		$body = parseubb($body);

		echo '
<p>
<div class="small">'.$event['date'].$time.'</div>
<a href="view_event.php?id='.$event['ev_id'].'"><strong>'.$event['ev_title'].'</strong></a>
<p>
	'.$body.'
</p>
</p>';
	}
}
}





function awec_get_bb_smileys($name, $msg, $no_smileys, $hide_smileys=false)
{
	global $locale;

	if(defined('IN_FF')) {
		return ff_form_bb($name, $msg, '').'
<input type="hidden" name="disable_smileys" />';
	}

	$retval = '
<textarea name="'.$name.'" id="'.$name.'" rows="8" class="textbox" cols="60">'
	.$msg.'</textarea>
<div>
'."
<input type='button' value='b' class='button' style='font-weight:bold;' onclick=\"addText('$name', '[b]', '[/b]');\">
<input type='button' value='i' class='button' style='font-style:italic;' onclick=\"addText('$name', '[i]', '[/i]');\">
<input type='button' value='u' class='button' style='text-decoration:underline;' onclick=\"addText('$name', '[u]', '[/u]');\">
<input type='button' value='url' class='button' onclick=\"addText('$name', '[url]', '[/url]');\">
<input type='button' value='mail' class='button' onclick=\"addText('$name', '[mail]', '[/mail]');\">
<input type='button' value='img' class='button' onclick=\"addText('$name', '[img]', '[/img]');\">
<input type='button' value='center' class='button' onclick=\"addText('$name', '[center]', '[/center]');\">
<input type='button' value='small' class='button' onclick=\"addText('$name', '[small]', '[/small]');\">
<input type='button' value='code' class='button' onclick=\"addText('$name', '[code]', '[/code]');\">
<input type='button' value='quote' class='button' onclick=\"addText('$name', '[quote]', '[/quote]');\">
</div>";

	if(!$hide_smileys) {
		$retval .= '
<p>
<label><input type="checkbox" name="disable_smileys"'
	.($no_smileys
		? ' checked="checked"'
		: '')
.' /> '.$locale['EC112'].'</label>
</p>';

		$retval .= '
<p>
<fieldset>
'.displaysmileys($name).'
</fieldset>
</p>';
	}

	return $retval;
}


if(!function_exists('show_info')) {
function show_info($info, $class='warning', $caption='')
{
	if(is_array($info)) {
		$info = '
<ul>
	<li>'.implode("</li>\n\t<li>", $info).'</li>
</ul>';
	}

	echo '
<div class="tbl1" style="font-weight:bold; padding:10px 50px;">
'.$caption.'
'.$info.'
</div>
';
}
}


function awec_set_title($title)
{
	global $locale;

	if(defined('IN_FF')) {
		if($title) {
			ff_add_to_title($locale['awec_calendar'].'::'.$title);
		} else {
			ff_add_to_title($locale['awec_calendar']);
		}
	} else {
	}
}


function awec_open_tab($name, $caption)
{
	if(defined('IN_FF')) {
		echo '<div id="'.$name.'">';
	} else {
		opentable($caption);
	}
}
function awec_close_tab()
{
	if(defined('IN_FF')) {
		echo '</div>';
	} else {
		closetable();
	}
}
function awec_tabs($tabs)
{
	if(!defined('IN_FF')) {
		return;
	}

	define('FF_TABS',	true);
?>
<script type="text/javascript">
FF.behaviors.awec_tabs = function(content){
	$("#tabs > ul").tabs();
};
</script>
<?php

	echo '
<!--TABS.open-->
<div id="tabs">
	<ul>';
	foreach($tabs as $tab_id => $tab_title) {
		echo '
		<li><a href="#'.$tab_id.'"><span>'.$tab_title.'</span></a></li>';
	}
	echo '
	</ul>';

}
function awec_tabs_close()
{
	echo '
</div>
<!--TABS.close-->';
}


?>
