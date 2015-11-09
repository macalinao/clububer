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
require_once('../../../maincore.php');
require_once('core.php');



if(!iAWEC_POST && !iAWEC_ADMIN) {
	fallback('../index.php');
}
if(!isset($_GET['id']) || !isNum($_GET['id'])) {
	fallback('../index.php');
}



$backto = '';
if(isset($_GET['backto'])) {
	$backto = '../new_events.php';
}



$where = "ev_id=".$_GET['id'];


if(!iAWEC_ADMIN) {
	$where .= " AND user_id=".$userdata['user_id'];
}


$res = dbquery("SELECT ev_id, ev_status, ev_private
	FROM ".AWEC_DB_EVENTS."
	WHERE ".$where);
if(!dbrows($res)) {
	fallback('../index.php');
}
$event = dbarray($res);


/****************************************************************************
 * ACTION
 */
if(isset($_GET['release']) && iAWEC_RELEASE) {
	dbquery("UPDATE ".AWEC_DB_EVENTS."
		SET
		ev_status=".($event['ev_private']
			? AWEC_PUBLISHED
			: AWEC_PENDING)."
		WHERE ".$where);

} elseif(isset($_GET['publish']) && iAWEC_PUBLISH) {
	dbquery("UPDATE ".AWEC_DB_EVENTS."
		SET
		ev_status=".AWEC_PUBLISHED."
		WHERE ".$where);
	if(empty($backto)) {
		$backto = '../view_event.php?id='.$event['ev_id'];
	}

} elseif(isset($_GET['delete']) && iAWEC_ADMIN) {
	$ok = dbquery("DELETE FROM ".AWEC_DB_EVENTS."
		WHERE ev_id=".$_GET['id']);

	if($ok) {
		$ok = dbquery("DELETE FROM ".AWEC_DB_LOGINS."
			WHERE ev_id='".$_GET['id']."'");
	}

	if($ok) {
		$ok = dbquery("DELETE FROM ".AWEC_DB_EVENTS_IN_CATS."
			WHERE event_id='".$_GET['id']."'");
	}

	if($ok) {
		$res = dbquery("SELECT filename FROM ".AWEC_DB_ATTACHMENTS."
			WHERE event_id='".$_GET['id']."'");
		while($row = dbarray($res)) {
			@unlink(AWEC_ATTACHMENTS.$row['filename']);
		}
		$ok = dbquery("DELETE FROM ".AWEC_DB_ATTACHMENTS."
			WHERE event_id='".$_GET['id']."'");
	}

}


if(empty($backto)) {
	fallback('../my_events.php');
} else {
	fallback($backto);
}

?>
