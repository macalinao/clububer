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
 *   Copyright (C) 2006-2007 Artur Wiebe                                   *
 *   wibix@gmx.de                                                          *
 *   http://wibix.de/                                                      *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU General Public License as published by  *
 *   the Free Software Foundation; either version 2 of the License, or     *
 *   (at your option) any later version.                                   *
 ***************************************************************************/
require_once('include/common.php');



if(!isset($_GET['id']) || !isNum($_GET['id'])) {
	fallback("index.php");
}

$res = dbquery("SELECT license_text, license_name
	FROM ".DB_PRP_LICENSES."
	WHERE license_id='".$_GET['id']."'");
if(!dbrows($res)) {
	fallback("index.php");
}

$license=dbarray($res);


opentable($license['license_name']);

echo stripslash($license['license_text']);

closetable();


require_once('include/die.php');
?>
