<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Author: Domi & fetloser
| www.venue.nu			     	      
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
require_once "../../maincore.php";


if (!isset($p))
{
require_once THEMES."templates/header.php";
}
else
{
require_once THEME."theme.php";
echo "<link rel='stylesheet' href='".THEME."styles.css' type='text/css'>";
}

if (!defined("LANGUAGE")) {
// PHPFusion environment
$this_lang =  str_replace("/", "", LOCALESET);
	if (file_exists(INFUSIONS."varcade/locale/".$this_lang.".php")) {
	   include INFUSIONS."varcade/locale/".$this_lang.".php";
	} else {
	   include INFUSIONS."varcade/locale/English.php";
	}
        } else {
// mFusion environment
$this_lang =  LANGUAGE;
	if (file_exists(INFUSIONS."varcade/locale/".$this_lang.".php")) {
	   include INFUSIONS."varcade/locale/".$this_lang.".php";
	} else {
	   include INFUSIONS."varcade/locale/English.php";
	}
}
if (isset($noguestplay))
{
	opentable($locale['res_01']);
	echo "<br><center><img src='".INFUSIONS."varcade/img//restricted.gif' alt='".$locale['res_01']."'><br><br>".$locale['res_07']."
	<br><br>
<img src='".THEME."images/bullet.gif'><a href='".BASEDIR."register.php'> ".$locale['res_03']." </a><img src='".THEME."images/bulletb.gif'><br>
<img src='".THEME."images/bullet.gif'><a href='".BASEDIR."lostpassword.php'> ".$locale['res_04']." </a><img src='".THEME."images/bulletb.gif'><br>
<img src='".THEME."images/bullet.gif'><a href='".BASEDIR."login.php'> ".$locale['res_05']." </a><img src='".THEME."images/bulletb.gif'><br><br>
<br></center>";
closetable();
}
else
{
	opentable($locale['res_01']);
	echo "<br><center><img src='".INFUSIONS."varcade/img//restricted.gif' alt='".$locale['res_01']."'><br><br>".$locale['res_02']."
	<br><br>
<img src='".THEME."images/bullet.gif'><a href='".BASEDIR."register.php'> ".$locale['res_03']." </a><img src='".THEME."images/bulletb.gif'><br>
<img src='".THEME."images/bullet.gif'><a href='".BASEDIR."lostpassword.php'> ".$locale['res_04']." </a><img src='".THEME."images/bulletb.gif'><br>
<img src='".THEME."images/bullet.gif'><a href='".BASEDIR."login.php'> ".$locale['res_05']." </a><img src='".THEME."images/bulletb.gif'><br><br>";
if (!isset($p))
{
echo "<img src='".THEME."images/bullet.gif'><a href=\"javascript:history.go(-2)\"> ".$locale['res_06']." </a><img src='".THEME."images/bulletb.gif'><br>";
}
echo "<br></center>";
closetable();
}
require_once "footer.php";
if (!isset($p))
{
require_once THEMES."templates/footer.php";
}
?>
