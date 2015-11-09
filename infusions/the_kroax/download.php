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
header("Content-Type: application/unknown");
header("Content-Disposition: filename=$title");

if (isset($youtube))
{
$setdownloaded = dbquery("UPDATE ".$db_prefix."kroax SET kroax_downloads=kroax_downloads+1 WHERE kroax_titel = '$title'");
redirect("".$url."");
exit ;
}
else
{
$setdownloaded = dbquery("UPDATE ".$db_prefix."kroax SET kroax_downloads=kroax_downloads+1 WHERE kroax_url = '$url'");

if($fp = fopen($url, "r")) {
			while(!feof($fp)) {
				echo  fgets($fp, 4096);
			}
			// close the file
			fclose($fp);
		}
}
exit;

?>