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

$result = dbquery ("select lid from ".$db_prefix."varcade_games WHERE ".groupaccess('access')." AND status='2' ORDER BY RAND() LIMIT 0,1") ;
$data = dbarray($result);

if (!isset($p))
{
redirect("arcade.php?game=".$data['lid']."");
exit;
}
else
{
redirect("arcade.php?p=1&game=".$data['lid']."");
exit;
}
?>