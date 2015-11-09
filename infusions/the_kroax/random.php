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

$query = dbquery("select * from ".$db_prefix."kroax WHERE ".groupaccess('kroax_access')." AND ".groupaccess('kroax_access_cat')." order by RAND() limit 0,1");
$rows = dbarray($query);


$read_settingskroax = dbquery("SELECT * FROM ".$db_prefix."kroax_set");
if (dbrows($read_settingskroax) != 0) {
$settingskroax = dbarray($read_settingskroax);
$skroaxembed = $settingskroax['kroax_set_show'];
}

if ($skroaxembed == "1")
{
redirect("embed.php?url=".$rows[kroax_id]."");
exit;
}
else {
redirect("embed.php?p=1&url=".$rows[kroax_id]."");
exit;
}
?>