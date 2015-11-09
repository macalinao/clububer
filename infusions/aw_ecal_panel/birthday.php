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

if($awec_settings['show_birthday_to_group']==-1
	|| !checkgroup($awec_settings['show_birthday_to_group']))
{
	fallback('index.php');
}


$res = dbquery("SELECT user_name, user_id,
	user_birthdate AS event_date,
	(YEAR(CURDATE())-YEAR(user_birthdate)) AS years_old,
	DATE_FORMAT(user_birthdate, '".$awec_settings['date_fmt']."') AS date
	FROM ".DB_USERS."
	WHERE user_id='".$_GET['id']."'");
if(dbrows($res)==0) {
	fallback('index.php');
}
$event = dbarray($res);
$event['ev_title'] = sprintf($locale['awec_user_birthday']['title'], $event['user_name']);


/*
 * GUI
 */
opentable($locale['EC300']);
awec_menu();
ec_render_birthday($event);
closetable();


require_once('include/die.php');
?>
