<?php 
/*
Ok This is a basic start button file.
It needs to be formatted nicely with some detail of the game etc.
So lay it out in a table.
*/
if (file_exists(GOLD_GAMES."sitelotto/locale/".$settings['locale'].".php")) {
	include_once GOLD_GAMES."sitelotto/locale/".$settings['locale'].".php";
} else {
	include_once GOLD_GAMES."sitelotto/locale/English.php";
}

echo "<table width='100%' align='center' cellpadding='5' cellspacing='2' border='0'>\n<tr>\n";
echo "<td><a href='".GOLD_GAMES."sitelotto/sitelotto.php'>\n";
if(file_exists(GOLD_GAMES."sitelotto/images/sitelotto.png")) {
	echo "<img alt='".$locale['selo_100']."' src='".GOLD_GAMES."sitelotto/images/sitelotto.png' border='0' width='32' />\n";
} else {
     echo "<img alt='".$locale['selo_100']."' src='".GOLD_DIR."images/blank.gif' border='0' width='32' />\n";
}
echo "</a></td>\n";
echo "<td> <a href='".GOLD_GAMES."sitelotto/sitelotto.php'>".$locale['selo_100']."</a></td>\n";
echo "<td>".$locale['selo_101']."</td>\n";
echo "<td>".$locale['selo_103']."</td>\n";
echo "</tr>\n<tr>\n";
echo "<td colspan='4' align='center'>".$locale['selo_104']."</td>\n";
echo "</tr>\n</table>\n<br />\n";
?>