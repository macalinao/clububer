<?php
/*---------------------------------------------------*\
| PHP-Fusion 6 Content Management System
+----------------------------------------------------+
| Copyright � 2002 - 2005 Nick Jones
| http://www.php-fusion.co.uk/
+----------------------------------------------------+
| Released under the terms & conditions of v2 of the
| GNU General Public License. For details refer to
| the included gpl.txt file or visit http://gnu.org
+----------------------------------------------------+
| UBERPETS V 0.0.0.3
+----------------------------------------------------+
| Uberpets Copyright 2008 µsoft inc.
| http://www.clububer.com/
\*---------------------------------------------------*/

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

$title = stripinput($_GET['error_title']);
$desc = stripinput($_GET['error_desc']);
$history = stripinput($_GET['error_history']);
opentable($title);
	echo "<font color='#FF0000'><h1>Oops!</h1></font>";
	echo nl2br("\n\n\n");
	echo $desc;
	echo nl2br("\n\n");
	echo "[";
	echo "<a href='javascript:history.go(".$history.")'>Back</a>";
	echo "</a>]";
	echo nl2br("\n\n");
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
