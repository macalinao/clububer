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
require_once('include/common.php');
require_once('include/theme_funcs.php');


if(isset($_GET['type']) && isset($locale['PDP341'][$_GET['type']])) {
	$err = $_GET['type'];
} else {
	$err = '-';
}


opentable($pdp->settings['title']);
pdp_menu();
closetable();


opentable($locale['PDP049']);
echo '<p>'.$locale['PDP340'].'</p>';

show_info('<img src="icons/messagebox_warning.png" alt="'.$locale['pdp_warning'].'" style="float:left; padding-right:10px;" /> <strong>'.$locale['PDP341'][$err].'</strong>',
	'warning', true);

closetable();


require_once('include/die.php');
?>
