<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| User Gold 3
| Copyright © 2007 - 2008 UG3 Developement Team
| http://www.starglowone.com/
+--------------------------------------------------------+
| Filename: makecode.php
| Author: UG3 Developement Team
+--------------------------------------------------------+
| This program is released as free software under the
| Stars Heaven Licence. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included licence.html.
| Removal of this copyright header is strictly
| prohibited without written permission
| from the original author(s).
+--------------------------------------------------------*/
require_once "../../../maincore.php";

require_once THEME."theme.php";

include_once INFUSIONS."user_gold/functions.php";

if (file_exists(GOLD_LANG.LOCALESET."admin/makecode.php")) {
	include GOLD_LANG.LOCALESET."admin/makecode.php";
} else {
	include GOLD_LANG."English/admin/makecode.php";
}

echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>\n";
echo "<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='".$locale['xml_lang']."' lang='".$locale['xml_lang']."'>\n";
echo "<head>\n";
echo "<title>".$locale['urg_title']." ".GOLD_VERSION." ".$locale['urg_a_makecode_100']."</title>\n";
echo "<meta http-equiv='Content-Type' content='text/html; charset=".$locale['charset']."' />\n";
echo "<link rel='stylesheet' href='".THEME."styles.css' type='text/css' />\n";
echo "</head>\n<body>\n";
//check input
if(!$_REQUEST['title'] || empty($_REQUEST['title'])) {
	$title = "undefined";
} else {
	$title = $_REQUEST['title'];
}
function highlight_php($string) {
	$Line = explode("\n",$string);
	$line = "";
	for($i = 1; $i <= count($Line); $i++) {
		$line .= "&nbsp;".$i."&nbsp;<br />";
	}
	ob_start();
	highlight_string($string);
	$Code = ob_get_contents();
	ob_end_clean();
	$header = 	"<table border='1' cellpadding='1' cellspacing='1' width='100%'>\n<tr>
				<td width='3%' valign='top' class='tbl2'><code>".$line."</code></td>
				<td width='97%' valign='top' class='textbox'>
				<div style='white-space: nowrap; overflow: auto;'>\n";
	$footer = 	$Code."</div>
				</td>
				</tr>\n</table>\n";
	return $header.$footer;
}


$core_snippet = "<?php \n";
$core_snippet .= "// - Start Core gold \n";
$core_snippet .= "if (file_exists(INFUSIONS.\"user_gold_panel/functions.php\"))\n";
$core_snippet .= "{\n";
$core_snippet .= "include_once INFUSIONS.\"user_gold_panel/functions.php\";\n";
$core_snippet .= "}\n";
$core_snippet .= "// - end core gold \n";
$core_snippet .= "?>";
$pay_snippet = "<?php \n";
$pay_snippet .= "// - Start $title gold \n";
$pay_snippet .= "if (USERGOLD && $title)\n";
$pay_snippet .= "{\n";
$pay_snippet .= "payuser(\$user_id, $title, 'cash');\n";
$pay_snippet .= "}\n";
$pay_snippet .= "// - end $title gold \n";
$pay_snippet .= "?>";
$take_snippet = "<?php \n";
$take_snippet .= "// - Start $title gold \n";
$take_snippet .= "if (USERGOLD && $title)\n";
$take_snippet .= "{\n";
$take_snippet .= "takegold2(\$user_id, $title, 'cash');\n";
$take_snippet .= "}\n";
$take_snippet .= "// - end $title gold \n";
$getgold_snippet = "<?php \n";
$getgold_snippet .= "// - Start User Gold \n";
$getgold_snippet .= "if (USERGOLD)\n";
$getgold_snippet .= "{\n";
$getgold_snippet .= "getusergold('cash', \$user_id);\n";
$getgold_snippet .= "}\n";
$getgold_snippet .= "// - end User gold \n";
$activity_snippet = "<?php \n";
$activity_snippet .= "// - Start User Gold \n";
$activity_snippet .= "if (USERGOLD)\n";
$activity_snippet .= "{\n";
$activity_snippet .= "activity_check(\$gold,\$userid);\n";
$activity_snippet .= "}\n";
$activity_snippet .= "// - end User gold \n";
opentable($title.' '.$locale['urg_a_makecode_101']);
echo $locale['urg_a_makecode_102'];
if($_REQUEST['title'] == 'getgold') {
	echo "<hr />".$locale['urg_a_makecode_103'];
	echo highlight_php($getgold_snippet);
} elseif($_REQUEST['title'] == 'activity') {
	echo "<hr />".sprintf($locale['urg_a_makecode_104'],$userid, $gold);
	echo highlight_php($activity_snippet);
} else {
	echo "<hr />".$locale['urg_a_makecode_105'];
	echo highlight_php($core_snippet);
	echo "<hr />".$locale['urg_a_makecode_106'];
	echo highlight_php($pay_snippet);
	echo "<hr />".$locale['urg_a_makecode_107'];
	echo highlight_php($take_snippet);
	echo "<hr />\n";
}
echo "<div align='center'><strong>\n";
echo "<a href='javascript:window.close();'><img style='border: 0;' src='../images/close.png' title='".$locale['urg_a_makecode_108']."' alt='".$locale['urg_a_makecode_108']."' /></a>\n";
echo "</strong></div>\n";
closetable();
echo "</body>\n</html>\n";