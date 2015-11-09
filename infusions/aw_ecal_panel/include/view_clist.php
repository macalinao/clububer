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



if(!count($events)) {
	echo '
<p>
	'.$locale['awec_no_events'].'
</p>';
	return;
}


$content = array_fill(1, 31, array());


foreach($events[$ec_year][$ec_month] as $day => $more) {
	foreach($more as $event) {
		$content[$day][] = $event;
	}
}

$events = array();
for($i=1; $i<=31; ++$i) {
	foreach($content[$i] as $event) {
		$events[] = $event;
	}
}
awec_clist($events);


?>
