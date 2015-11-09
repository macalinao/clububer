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
require_once "../../..maincore.php";
require_once THEMES."templates/admin_header.php";

$result = dbquery("SELECT * FROM ".$db_prefix."kroax");
while ($data = dbarray($result)) {
$kroax_cat=$data['kroax_cat'];
$k_access =$data['kroax_access'];
$id=$data['kroax_id'];
$detect = dbquery("SELECT * FROM ".$db_prefix."kroax_kategori WHERE cid='$kroax_cat'");
echo $kroax_cat;
while ($detect_access = dbarray($detect)) {
$access = $detect_access['access'];

echo"[".$id."] New access: ".$access." Old access: ".$k_access."<br>";
$update = dbquery("UPDATE ".$db_prefix."kroax SET kroax_access_cat='$access' WHERE kroax_id='$id'");
}
}

?>