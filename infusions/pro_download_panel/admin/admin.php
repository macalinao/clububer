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


/*
 * GUI
 */
require_once('../include/db_update.php');


opentable($locale['PDP016']);
pdp_admin_menu();


$obsolete = array(
	'locale_utf8',
	'icons/warning.gif',
	'icons/screenshot.gif',
	'icons/comments.gif',
	'icons/delete.gif',
	'include/getvcode.php',
);
foreach($obsolete as $file) {
	if(file_exists(INFUSIONS.'pro_download_panel/'.$file)) {
		show_info(sprintf($locale['pdp_obsolete'], $file));
	}
}


// some statics
echo '<dl>
	<dt>'.$locale['pdp_downloads'].':</dt>
	<dd>'.ff_db_count('(*)', DB_PDP_DOWNLOADS, '').'</dd>
	<dt>'.$locale['PDP820'].':</dt>
	<dd>'.ff_db_count('(*)', DB_PDP_CATS, '').'</dd>
	<dt>'.$locale['PDP800'].':</dt>
	<dd>'.ff_db_count('(*)', DB_PDP_LICENSES, '').'</dd>
	<dt>'.$locale['PDP019'].':</dt>
	<dd>'.ff_db_count('(*)', DB_PDP_FILES, '').'</dd>
</dl>';





closetable();


require_once('../include/die.php');
?>
