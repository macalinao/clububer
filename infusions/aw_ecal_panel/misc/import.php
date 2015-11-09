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
	fallback('../index.php');
}


$do_import = (isset($_GET['action']) && $_GET['action']=='import');


/*
 * GUI
 */
opentable('Import');

echo '<p>
<strong>Not localized. English only!</strong>
</p>';

// check if table exists
$res = dbquery("SHOW TABLES LIKE '".DB_PREFIX."kalender'");
if(dbrows($res)==0) {
	echo '<p>
NO kalender-tables found!
</p>';
} else {
	$res = dbquery("SELECT * FROM ".DB_PREFIX."kalender");
	echo "<p><a href='".FUSION_SELF."?action=import'>import</a>";
	echo "<p>old records: ".dbrows($res)."<br>";
	$errors = 0;
	while($old = dbarray($res)) {

		$start = stripinput($old['jahr'].'-'.$old['monat'].'-'.$old['tag']);
		$query = "INSERT INTO ".DB_PREFIX."aw_ec_events
			SET
			ev_id='".$old['id']."',
			user_id='".$old['user_id']."',
			ev_title='".stripinput($old['title'])."',
			ev_body='".stripinput($old['text'])."',
			ev_no_smileys ='".$old['']."',
			ctime='".$old['datestamp']."',
			mtime='".$old['datestamp']."',
			ev_start='".$start."',
			ev_end='".$start."',
			ev_repeat='".($old['rep_year']=="Y" ? "1" : "0")."',
			ev_private='".($old['privat']=="Y" ? "1" : "0")."',
			ev_status='".($old['is_published']=="1" ? "0" : "1")."',
			ev_allow_logins='0',
			ev_max_logins='0',
			ev_login_start='0',
			ev_login_end='0'";
		if($do_import) {
			$ok = dbquery($query);
		}
		if($do_import && !$ok) {
			echo "+".$old['title']."<br />"
				."<span class='small2'>$query</span><br>";
			$errors++;
		}
	}
	if($do_import) {
		echo "Update done.";
		echo "<p>Error: $errors";
	}
}
closetable();


require_once('../include/die.php');
?>
