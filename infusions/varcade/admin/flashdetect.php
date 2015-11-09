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
require_once "../../../maincore.php";
require_once THEME."theme.php";
echo "<link rel='stylesheet' href='".THEME."styles.css' type='text/css'>";
if (!checkRights("I")) { header("Location:../../../index.php"); exit; }

if (isset($game) && !isNum($game)) fallback("index.php");

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


$result = dbquery("SELECT lid,flash FROM ".$db_prefix."varcade_games WHERE lid=$game");
$game = dbarray($result);

opentable($locale['VARC417']);

list($width, $height) = getimagesize("".INFUSIONS."varcade/uploads/flash/".$game['flash']."");
echo "<center>";
echo "".$locale['VARC395']." = $width";
echo "<br>";
echo "".$locale['VARC394']." = $height";
echo "<br>";
echo $locale['VARC410'];
echo "</center>";
closetable();

?>
