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



if(isset($_GET['view']) && isset($locale['awec_month_view'][$_GET['view']])) {
	$view = $_GET['view'];
} else {
	$view = $awec_settings['default_month_view'];
}
if(isset($_GET['cal']) && isset($locale['awec_calendar'][$_GET['cal']])) {
	$cal = $_GET['cal'];
} else {
	$cal = $awec_settings['default_calendar_view'];
}
$cat = (isset($_GET['cat']) && isNum($_GET['cat']) ? $_GET['cat'] : 0);



/****************************************************************************
 * GUI: birthdays
 */
if(!$awec_settings['birthdays_are_events']
	&& $awec_settings['show_birthday_to_group']>=0
	&& checkgroup($awec_settings['show_birthday_to_group']))
{
        opentable(str_replace('%s', $locale['EC900'][$ec_month],
		$locale['EC401']));

	$from = $ec_year.'-'.$ec_month.'-01';

        $res = dbquery("SELECT user_name,
                DATE_FORMAT(user_birthdate, '".$awec_settings['birthdate_fmt']."') AS birthday,
		(YEAR('$from')-YEAR(user_birthdate)) AS years_old,
                user_id, user_avatar
                FROM ".DB_USERS."
                WHERE MONTH(user_birthdate)='".$ec_month."'
                ORDER BY DAYOFMONTH(user_birthdate) ASC");
        if(!dbrows($res)) {
                echo '<p>'.$locale['awec_none'].'</p>';
        } else {
                echo '
<ul>';
        }
        while($user = dbarray($res)) {
/*              if($user['user_avatar']!="") {
                                echo "<img src='".BASEDIR."images/avatars/"
                                .$user['user_avatar']."'><br/>";
                }
*/
                echo '
	<li>'.$user['birthday']
//                      .showdate("%x", $user['birthday'])
                        ." <a href='".BASEDIR."profile.php?lookup=".$user['user_id']
                        ."'>".$user['user_name'].'</a> ('.$user['years_old'].')</li>';
        }
        if(dbrows($res)) {
                echo '
</ul>';
        }

        closetable();
}



/****************************************************************************
 * GET
 */
$cats = '';
$res = dbquery("SELECT cat_id, cat_name
	FROM ".AWEC_DB_CATS."
	ORDER BY cat_name ASC");
while($row = dbarray($res)) {
	$cats .= '
	<option value="'.$row['cat_id'].'"'
		.($row['cat_id']==$cat
			? ' selected="selected"'
			: ''
		).'>'.$row['cat_name'].'</option>';
}



/****************************************************************************
 * GUI
 */
opentable($locale['awec_calendar']);
awec_menu();


echo '
<div style="float:left;">
<strong>'.$locale['awec_calendar'].':</strong>';
$count = count($locale['awec_calendar_view']);
foreach($locale['awec_calendar_view'] as $key => $val) {
	if($key==$cal) {
		echo '
<span class="small2">'.$val.'</span>';
	} else {
		echo '
<a href="'.FUSION_SELF
	.'?cal='.$key.'&amp;view='.$view.'&amp;cat='.$cat
	.'&amp;y='.$ec_year.'&amp;m='.$ec_month.'">'.$val.'</a>';
	}
	if(--$count) {
		echo ' | ';
	}
}
if($cal=='month') {
echo '

<br />

<strong>'.$locale['EC402'].':</strong>';
$count = count($locale['awec_month_view']);
foreach($locale['awec_month_view'] as $key => $val) {
	if($key==$view) {
		echo '
<span class="small2">'.$val.'</span>';
	} else {
		echo '
<a href="'.FUSION_SELF
	.'?cal='.$cal.'&amp;view='.$key.'&amp;cat='.$cat
	.'&amp;y='.$ec_year.'&amp;m='.$ec_month.'">'.$val.'</a>';
	}
	if(--$count) {
		echo ' | ';
	}
}
}
echo '
</div>
<div style="float:right;">';
if(!empty($cats)) {
	echo '
<form method="get" action="'.FUSION_SELF.'">
<input type="hidden" name="cal" value="'.$cal.'" />
<input type="hidden" name="view" value="'.$view.'" />
<input type="hidden" name="y" value="'.$ec_year.'" />
<input type="hidden" name="m" value="'.$ec_month.'" />
<label for="cat">'.$locale['awec_cat'].':</label>
<select name="cat" id="cat" class="textbox">
<option value="0">['.$locale['awec_all'].']</option>'.$cats.'
</select>
<input type="submit" class="button" value="'.$locale['awec_show'].'" />
</form>';
}
echo '
<a href="'.FUSION_SELF.'?cal='.$cal.'&amp;view='.$view.'&amp;cat='.$cat.'">'
	.$locale['awec_today'].'</a>
</div>
<div style="clear:both;"></div>

<hr />';



$cal_href = FUSION_SELF.'?cal='.$cal.'&amp;view='.$view.'&amp;cat='.$cat;
$events = array();
$needle = array(
	'from'	=> '',
	'to'	=> '',
	'cat'	=> $cat,
);
switch($cal)
{
case 'year':
	require_once('include/cal_year.php');
	break;
case 'week':
	require_once('include/cal_week.php');
	break;
case 'month':
default:
	require_once('include/cal_month.php');
	break;
}

closetable();


require_once('include/die.php');
?>
