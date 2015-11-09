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
| Filename: help.php
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
/* Changelog  071207
Rewrote the helpfile due to incompatibility issues with extra installed infusions using UG3
Now fetching the help text from database table user_gold_settings, field description
instead of from a locale file
*/
require_once "../../../maincore.php";
require_once THEME."/theme.php";
include_once INFUSIONS."user_gold/infusion_db.php";
include_once INFUSIONS."user_gold/functions.php";

//get locals
if (file_exists(GOLD_LANG.LOCALESET."admin/help.php")) {
	include GOLD_LANG.LOCALESET."admin/help.php";
} else {
	include GOLD_LANG."English/admin/help.php";
}
include_once INFUSIONS."user_gold/functions.php";
//check input
if(!$_REQUEST['title'] || empty($_REQUEST['title'])){ $title = "Help"; }
//create the case call from the title
$op = eregi_replace(' ', '_', strtoupper($title));
echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>\n";
echo "<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='".$locale['xml_lang']."' lang='".$locale['xml_lang']."'>\n";
echo "<head>\n";
echo "<title>".$ug_help_locale['usergold']." ".GOLD_VERSION." ".$ug_help_locale['help']."</title>\n";
echo "<meta http-equiv='Content-Type' content='text/html; charset=".$locale['charset']."' />\n";
echo "<link rel='stylesheet' href='".THEME."styles.css' type='text/css' />\n";
echo "</head>\n<body>\n";

opentable($ug_help_locale['help'].' - '.$title);

//ok now to sort it all out as it comes in
$helpquery = dbquery("SELECT description FROM ".DB_UG3_SETTINGS." WHERE name = '".$title."' LIMIT 0,1");

if(dbrows($helpquery) != 0 ) {
	$help = dbarray($helpquery);
	if($help['description'] != "" ) {
		echo $help['description'];
	} else {
		echo $ug_help_locale['no_help'];
	}
} else {
	echo $ug_help_locale['no_help'];
}

echo "<p style='text-align: center;'>\n";
echo "<a href='javascript:window.close();'><img border='0' src='".GOLD_IMAGE."close.png' title='".$ug_help_locale['close']."' alt='".$ug_help_locale['close']."' /></a>\n";
echo "</p>\n";
closetable();
echo "</body>\n</html>\n";