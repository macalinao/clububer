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

//Start Copywrite Link removal is NOT ALLOWED.
echo "<div align='center' class='small'>".$locale['urg_title']." ".GOLD_VERSION." &copy; 2007-2008 <a href='http://www.starglowone.com'>".$locale['urg_dev']." @ Stars Heaven</a></div>\n";
//END Copywrite Link removal is NOT ALLOWED.

require_once THEMES."templates/footer.php";
?>