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
require_once INFUSIONS."the_kroax/functions.php";
header("Content-type: text/html; charset=ISO-8859-9");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");    // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");  // HTTP/1.1
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");        // HTTP/1.0


if (!defined("LANGUAGE")) {
// PHPFusion environment
$this_lang =  str_replace("/", "", LOCALESET);
	if (file_exists(INFUSIONS."the_kroax/locale/".$this_lang.".php")) {
	   include INFUSIONS."the_kroax/locale/".$this_lang.".php";
	} else {
	   include INFUSIONS."the_kroax/locale/English.php";
	}
        } else {
// mFusion environment
$this_lang =  LANGUAGE;
	if (file_exists(INFUSIONS."the_kroax/locale/".$this_lang.".php")) {
	   include INFUSIONS."the_kroax/locale/".$this_lang.".php";
	} else {
	   include INFUSIONS."the_kroax/locale/English.php";
	}
}
$search = stripinput(trim($_GET['q']));

if($search != "" && strlen($search) <= 2)

   {
echo "<center><b>".$locale['sok156']."</b><br>".$locale['sok151']."</center>";

} else {

$result = dbquery("SELECT ter.*, user_id,user_name FROM ".$db_prefix."kroax ter
		LEFT JOIN ".$db_prefix."users tusr ON ter.kroax_uploader=tusr.user_id
		WHERE kroax_titel LIKE '%$search%' AND kroax_approval='' AND ".groupaccess('kroax_access')." AND ".groupaccess('kroax_access_cat')." ORDER BY kroax_titel ASC LIMIT 20");
}

if (dbrows($result) != 0) {
$numRecords = dbrows($result);
echo "<center>".$locale['sok152']." <b><font color='red'>".$numRecords."</b></font> ".$locale['sok153']."</center>";


if(isset($_COOKIE['kroaxthumbs']))
{
//thumb view start

		$counter = 0; $r = 0; $k = 1;
		echo "<table cellpadding='0' cellspacing='1' width='100%'>\n<tr>\n";
		while ($data = dbarray($result)) {
			if ($counter != 0 && ($counter % $kroaxsettings['kroax_set_thumbs_per_row'] == 0)) echo "</tr>\n<tr>\n";
	          		echo "<td align='center' valign='top' class='tbl'>\n";
makelist();
			echo "</td>\n";
			$counter++; $k++;
		}
		echo "</tr>\n</table>\n";
									

//Album view end

}
else
{

while ($data = dbarray($result)) {

makelist();

 }
}
}
else {
Echo "<center>".$locale['sok155']."</center>";
}
?>