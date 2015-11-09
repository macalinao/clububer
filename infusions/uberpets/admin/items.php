<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--- ----------------------------------------------------+
| UBERPETS V 0.0.0.5
+--------------------------------------------------------+
| Uberpets Copyright 2008 Grr@µsoft inc.
| http://www.clububer.com/
+--------------------------------------------------------+
| Admin system based off of Varcade http://www.venue.nu/
\*---------------------------------------------------*/
if (!defined("IN_UBP")) { die("Access Denied"); }

$ipage = stripinput($_GET['ipage']);

if ($ipage == "items"){
$tblx = "tbl1";
}else{
$tblx = "tbl2";
}
if ($ipage == "item_cats"){
$tbly = "tbl1";
}else{
$tbly = "tbl2";
}

echo "
<table align='center' cellspacing='1' cellpadding='0' width='100%' border='0' class='tbl-border'>
<tr>
<td align='center' class='".$tblx."' width='50%'><a href='admin.php?a_page=items&ipage=items'>Items</a></td>
<td align='center' class='".$tbly."' width='50%'><a href='admin.php?a_page=items&ipage=item_cats'>Categories</a></td>
</tr>
</table>
";

if (!$_GET['ipage']){
redirect(FUSION_SELF."?a_page=items&ipage=items");
}
elseif ($ipage == "items"){
require_once UBP_BASE."admin/items/items.php";
}
elseif ($ipage == "item_cats"){
require_once UBP_BASE."admin/items/item_cats.php";
}
?>
