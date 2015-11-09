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
| Filename: accountant.inc.php
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

function BuyMedal() {
	global $HTTP_POST_VARS, $userdata, $locale, $settings, $golddata;
	//let the user purchase a site medal.
	//if they have one then they can upgrade instead.
}

function DonateToThePoor() {
	global $HTTP_POST_VARS, $userdata, $locale, $settings, $golddata;
	//Let the user donate current moneys to the poorest people on the site.
	//karma reward
}

function DonateToCurrent() {
	global $HTTP_POST_VARS, $userdata, $locale, $settings, $golddata;
	//donate all money to a current online person
	//karma reward
}

?>