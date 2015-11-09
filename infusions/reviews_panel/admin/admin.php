<?php
/***************************************************************************
 *   Professional Review System                                          *
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
if(!iPRP_ADMIN) {
	fallback('../index.php');
}


/*
 * GUI
 */
require_once('../include/db_update.php');


opentable($locale['PRP016']);
prp_admin_menu();


$obsolete = array(
	'locale_utf8',
	'icons/warning.gif',
	'icons/screenshot.gif',
	'icons/comments.gif',
	'icons/delete.gif',
	'include/getvcode.php',
);
foreach($obsolete as $file) {
	if(file_exists(INFUSIONS.'reviews_panel/'.$file)) {
		show_info(sprintf($locale['prp_obsolete'], $file));
	}
}


// some statics
echo '<dl>
	<dt>'.$locale['prp_reviews'].':</dt>
	<dd>'.ff_db_count('(*)', DB_PRP_DOWNLOADS, '').'</dd>
	<dt>'.$locale['PRP820'].':</dt>
	<dd>'.ff_db_count('(*)', DB_PRP_CATS, '').'</dd>
	<dt>'.$locale['PRP800'].':</dt>
	<dd>'.ff_db_count('(*)', DB_PRP_LICENSES, '').'</dd>
	<dt>'.$locale['PRP019'].':</dt>
	<dd>'.ff_db_count('(*)', DB_PRP_FILES, '').'</dd>
</dl>';





closetable();


require_once('../include/die.php');
?>
