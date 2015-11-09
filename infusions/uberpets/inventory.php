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
require_once "../../maincore.php";
if (!defined("IN_UBP")) { include "includes/core.php"; }


if (preg_match("/^[6]./",$settings['version'])) {
	require_once BASEDIR."subheader.php";
	require_once UBP_BASE."includes/side_left.php";
}
elseif (preg_match("/^[7]./", $settings['version'])) {
	require_once THEMES."templates/header.php";
}

if (!$usr['uid'] || $pets_of_user == 0) { redirect(UBP_BASE."create_pet.php"); }

include UBP_BASE."includes/pagelinks.php";
//END
#####
opentable("My Items");
	echo "Not yet! :)<br /><hr /><br />";
	echo "<center>";
	######ITEMS
				//Get the number of rows
					$rows = dbrows(dbquery("SELECT * FROM ".DB_UBERPETS_USER_ITEMS." WHERE uid='".$userdata['user_id']."' AND loc='1'"));
				//If page is not defined, page is 1
					if (!isset($rowstart) || !isNum($rowstart)) $rowstart = 0;
					$result = dbquery("SELECT * FROM ".DB_UBERPETS_USER_ITEMS." WHERE uid='".$userdata['user_id']."' AND loc='1' LIMIT $rowstart,".$uberpets_settings['inventory_items_per_page']."");
							$counter = 0; $r = 0; $k = 1;
							echo "<table cellpadding='0' cellspacing='0' width='100%'>\n<tr>\n";
							while ($data = dbarray($result)) {
								if ($counter != 0 && ($counter % $uberpets_settings['inventory_items_per_row'] == 0)) echo "</tr>\n<tr>\n";
						          		echo "<td align='center' valign='top' class='tbl'>\n";
						show_item($data['iid'],"inventory");
								echo "</td>\n";
								$counter++; $k++;
							}
							echo "</tr>\n</table>\n";
							if ($rows > $uberpets_settings['inventory_items_per_page']) {
								echo "<div align='center' style='margin-top:5px;'>\n";
								makePageNav($rowstart,$uberpets_settings['pound_pets_per_page'],$rows,3,BASEDIR."uberpets/inventory");
								echo "\n</div>\n";
							}
	######ITEMS END
	echo "</center>";
closetable();

#####
//BOTTOM PAGE INCLUDES
if (preg_match("/^[6]./",$settings['version'])) {
	require_once UBP_BASE."includes/side_right.php";
	require_once BASEDIR."footer.php";
}
elseif (preg_match("/^[7]./", $settings['version'])) {
	require_once THEMES."templates/footer.php";
}
//END
?>
