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
switch(FUSION_VERSION) {
case 6:
	require_once(BASEDIR.'side_right.php');
	require_once(BASEDIR.'footer.php');
	break;
case 7:
	require_once(THEMES.'templates/footer.php');
	break;
case 'FF':
	require_once(BASEDIR.'page_foot.php');
	break;
default:
	die;
}
?>
