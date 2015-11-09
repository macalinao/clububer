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
if(!iSUPERADMIN) {
	fallback('index.php');
}


if(isset($_GET['days']) && isNum($_GET['days'])) {
	$days = $_GET['days'];
} else {
	unset($days);
}


/*
 * ACTION
 */
if(isset($_GET['del_events']) && isset($days)) {
	$where = "ev_repeat='0'"
		." AND DATE_SUB(CURDATE(), INTERVAL ".$days." DAY) >= ev_start";

	// delete logins
	$res = dbquery("SELECT ev_id
		FROM ".AWEC_DB_EVENTS."
		WHERE ".$where);
	while($data = dbarray($res)) {
		$ok = dbquery("DELETE FROM ".AWEC_DB_LOGINS."
			WHERE ev_id='".array_shift($data)."'");
	}

	// delete events
	$ok = dbquery("DELETE FROM ".AWEC_DB_EVENTS."
		WHERE ".$where);
	if($ok) {
		fallback(FUSION_SELF.'?errno=1');
	}
}




/*
 * GUI
 */
opentable($locale['EC715']);
awec_menu();


if(isset($_GET['errno']) && isset($locale['EC717'][$_GET['errno']])) {
	show_info($locale['EC717'][$_GET['errno']]);
}


echo '
<p>'.$locale['EC716'].'</p>
<p>'.$locale['EC716_'].'</p>
<form method="get" action="'.FUSION_SELF.'">
<input type="text" class="textbox" name="days" value="180" size="3">
<label>'.$locale['EC721'].'</label>

<p>
<label><input type="checkbox" name="del_events" />
'.$locale['awec_confirm_del'].'</label>
</p>

<input type="submit" class="button" value="'.$locale['EC305'].'">
</form>';
closetable();


/****************************************************************************
 * GUI
 */
opentable($locale['awec_old_events']);

$count = ff_db_count("(*)", AWEC_DB_EVENTS,
	"ev_repeat='0' AND CURDATE()>=ev_start");

echo '<p>
'.$locale['EC716_'].'
</p>

'.$count.' '.$locale['EC001'].'
<form method="get" action="'.FUSION_SELF.'">
<input type="hidden" name="days" value="0" />

<p>
<label><input type="checkbox" name="del_events" />
'.$locale['awec_confirm_del'].'</label>
</p>

<input type="submit" class="button" value="'.$locale['EC305'].'">
</form>';
closetable();


require_once('../include/die.php');
?>
