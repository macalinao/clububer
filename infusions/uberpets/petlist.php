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

include UBP_BASE."includes/pagelinks.php";
//PAGE INCLUDES END
opentable("My Pets");
	echo "<center>";
	echo "<table width='84%' cellspacing='1' cellpadding='1' border='0'>\n";
	echo "<tr>";
		if ($petno >= 1) {
			echo "<td width='".$tdwidth."' class='tbl1'>";
				echo "<center><a href='".$plink['UBP_103']."'><img src=\"".$petimgpath[1]."normal.gif\" height='100' width='100' /></a><br /><strong>".$pet[1]['p']['name']."</strong>
				<a href='javascript:openWin('".UBP_BASE."action.php?action=feed&pid=1', 'Feed ".$pet[1]['p']['name']."')'>Feed</a>
				</center>";
			echo "</td>\n";
			if ($petno == 1) {
				echo "</tr>\n";
			}
		}
		if ($petno >= 2) {
			echo "<td width='".$tdwidth."' class='tbl2'>";
			echo "<center><a href='".$plink['UBP_104']."'><img src=\"".$petimgpath[2]."normal.gif\" height='100' width='100' /></a><br /><strong>".$pet[2]['p']['name']."</strong>
			<a href='javascript:openWin('".UBP_BASE."action.php?action=feed&pid=2', 'Feed ".$pet[2]['p']['name']."')'>Feed</a>
			</center>";
			echo "</td>\n</tr>\n";
		}
		if ($petno >= 3) {
			echo "<tr>";
			if ($petno == 3){
				echo "<td colspan='2' class='tbl2'>";
			} else {
				echo "<td width='".$tdwidth."' class='tbl2'>";
			}
			echo "<center><a href='".$plink['UBP_105']."'><img src=\"".$petimgpath[3]."normal.gif\" height='100' width='100' /></a><br /><strong>".$pet[3]['p']['name']."</strong>
			<a href='javascript:openWin('".UBP_BASE."action.php?action=feed&pid=3', 'Feed ".$pet[3]['p']['name']."')'>Feed</a>
			</center>";
			echo "</td>\n";
			if ($petno == 3) {
				echo "</tr>\n";
			}
		}
		if ($petno == 4) {
			echo "<td width='".$tdwidth."' class='tbl1'>";
			echo "<center><a href='".$plink['UBP_106']."'><img src=\"".$petimgpath[4]."normal.gif\" height='100' width='100' /></a><br /><strong>".$pet[4]['p']['name']."</strong>
			<a href='javascript:openWin('".UBP_BASE."action.php?action=feed&pid=4', 'Feed ".$pet[4]['p']['name']."')'>Feed</a>
			</center>";
			echo "</td>\n";
			echo "</tr>\n";
		}
	echo "</td></tr></table>\n";
	echo "</center>\n";
closetable();
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
