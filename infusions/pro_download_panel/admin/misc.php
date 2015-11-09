<?php
/***************************************************************************
 *   Professional Download System                                          *
 *                                                                         *
 *   Copyright (C) pirdani                                                 *
 *   pirdani@hotmail.de                                                    *
 *   http://pirdani.de/                                                    *
 *                                                                         *
 *   Copyright (C) 2005 EdEdster (Stefan Noss)                             *
 *   http://edsterathome.de/                                               *
 *                                                                         *
 *   Copyright (C) 2006-2008 Artur Wiebe                                   *
 *   wibix@gmx.de                                                          *
 *   http://wibix.de/                                                      *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU General Public License as published by  *
 *   the Free Software Foundation; either version 2 of the License, or     *
 *   (at your option) any later version.                                   *
 ***************************************************************************/
require_once('../include/admin.php');
if(!iPDP_ADMIN) {
	fallback('../index.php');
}


/****************************************************************************
 * ACTION
 */
if(isset($_GET['reset_visitors'])) {
	$ok = dbquery("UPDATE ".DB_PDP_DOWNLOADS."
		SET
		count_visitors='0'");
	if($ok) {
		fallback(FUSION_SELF.'?done');
	}
}



/****************************************************************************
 * GUI
 */
require_once('../include/db_update.php');


opentable($locale['PDP016']);
pdp_admin_menu();


if(isset($_GET['done'])) {
	show_info($locale['pdp_done']);
}


/*
 * IMPORT
 */
echo '<p>
<a href="import.php">'.$locale['PDP860'].'</a>
</p>';



echo '<p>
<a href="'.FUSION_SELF.'?reset_visitors">'.$locale['pdp_reset_all_visitors'].'</a>
</p>';


closetable();


require_once('../include/die.php');
?>
