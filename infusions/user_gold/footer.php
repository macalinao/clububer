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
| Filename: footer.php
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

//COPYRIGHT REMOVAL IS NOT ALLOWED
if (UGLD_VISABLE_COPY) {
	echo "<div align='center' class='small'>".$locale['urg_title']." ".GOLD_VERSION." &copy; 2007-2008 <a href='http://www.starglowone.com'>".$locale['urg_dev']." @ Stars Heaven</a></div>\n";
} else {
	echo '<a href="http://www.starglowone.com" target="_blank" name="copywrite"><!-- '.$locale['urg_global_100'].' '.$locale['urg_title'].' '.GOLD_VERSION.' --></a>';
}
//COPYRIGHT REMOVAL IS NOT ALLOWED

require_once THEMES."templates/footer.php";
?>