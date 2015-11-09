<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| User Gold 3
| Copyright © 2007 - 2008 UG3 Developement Team
| http://www.starglowone.com/
+--------------------------------------------------------+
| Filename: extras.inc.php
| Author: UG3 Developement Team
+--------------------------------------------------------+
| This program is released as free software under the
| Stars Heaven Licence. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included licence.html.
| Removal of this copyright header is strictly
| prohibited without written permission
| from the original author(s).
+--------------------------------------------------------*/
if (!defined("IN_FUSION")) { die("Access Denied"); }

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function extras_start() { //Extras start page
global $userdata, $locale, $settings, $golddata;
table_top($locale['URG1561']);
	echo $locale['URG1500']."
	<div align='center'>";
	//if they are turned on allow visable links
	if(GLD_CRIME && $golddata['karma'] > '100') {
		echo "<a href='index.php?op=extras_crime'>".$locale['URG1507']."</a><br />";
	}
	echo "</div>";
closetable();
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function extras_crime() { //Crime, not finished
global $HTTP_POST_VARS, $userdata, $locale, $settings, $golddata;
table_top($locale['URG1554']);
	echo $locale['URG1552'] ;
	echo $locale['URG1553'];
closetable();
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
?>