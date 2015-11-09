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
\*-------------------------------------------------------*/
// PAGE INCLUDES
if (!defined("IN_FUSION")) { die("Acqcess Denied"); }
include UBP_BASE."includes/pagelinks.php";
//PAGE INCLUDES END



if (isset($petdata['p']['uid']) && iMEMBER){
	openside($petdata['p']['name']);
	echo "<center>\n";
	echo "<br /><br />\n";
	echo "<img src='".$petimgpath['active']."normal.gif' height='100' width='100' />\n";
	echo "<br />\n";
	echo "<br />\n";
	$sayings = array('I\'m bored...', 'What\'s up?', 'Grr is great!', 'I wish there were more stuff for me to do. Hopefully Grr is doing well!');
	echo $sayings[rand(0,3)];
	echo "<br />[<a href='".$plink['UBP_001']."'>Abandon Pet</a>]<br />
	<br />[<a href='".UBP_BASE."inventory.php'>Your Items</a>]<br /></center>\n";
	closeside();
} elseif (iMEMBER) {
	openside($locale['UBP_title']);
	echo "<center>You have not created a pet yet. You may do so <a href='".$plink['UBP_002']."'>here</a>.</center>";
	closeside();
} else {
	openside($locale['UBP_title']);
		echo $locale['UBP_902'];
	closeside();
}
?>
