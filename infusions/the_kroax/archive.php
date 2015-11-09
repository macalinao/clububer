<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Author: Domi & fetloser
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
require_once THEMES."templates/header.php";



include INFUSIONS."the_kroax/functions.php";

if (!isset($rowstart) || !isNum($rowstart)) $rowstart = 0;
if (!isset($sortby) || !preg_match("/^[0-9A-Z]$/", $sortby)) $sortby = "all";

if(isset($setthumbview))
{
if (iMEMBER)
{
$viewname = $userdata['user_id'];
}
else
{
$viewname = $_SERVER['REMOTE_ADDR'];
}
setcookie("kroaxthumbs", $viewname, time()+31536000); //year
redirect("".FUSION_SELF."?sortby=$sortby&rowstart=$rowstart");
}

if(isset($setdetiledview))
{
if (iMEMBER)
{
$viewname = $userdata['user_id'];
}
else
{
$viewname = $_SERVER['REMOTE_ADDR'];
}
setcookie("kroaxthumbs", "$viewname", mktime(12,0,0,1, 1, 1990)); //kill cookie
redirect("".FUSION_SELF."?sortby=$sortby&rowstart=$rowstart");
}
error_reporting(E_ALL -E_NOTICE);
opentable($locale['KROAX201']);

makeheader();

echo "<div id = 'lajv'>";
echo '<table><tr><td align="left">[ <a href="'.FUSION_SELF.'?sortby='.$sortby.'&rowstart='.$rowstart.'&setdetiledview"><img src="img/view_detailed.png" alt="'.$locale['MKROAX108'].'"></a>  <a href="'.FUSION_SELF.'?sortby='.$sortby.'&rowstart='.$rowstart.'&setthumbview"><img src="img/view_thumbs.png" alt="'.$locale['MKROAX107'].'"></a> ]</td></tr></table>';

$orderby = ($sortby == "all" ? "" : " AND kroax_titel LIKE '$sortby%'");
$result = dbquery("SELECT * FROM ".$db_prefix."kroax WHERE ".groupaccess('kroax_access')." AND ".groupaccess('kroax_access_cat')." ".$orderby."");
$rows = dbrows($result);
	if (!isset($rowstart) || !isNum($rowstart)) $rowstart = 0;
if ($rows != 0) {
 }

 echo'
<SCRIPT LANGUAGE=JAVASCRIPT TYPE="TEXT/JAVASCRIPT">
<!--Hide script from old browsers
function confirmreport() {
return confirm("'.$locale['KROAX108'].'")
}
//Stop hiding script from old browsers -->
</SCRIPT>';

if(isset($_COOKIE['kroaxthumbs']))
{
//thumb view start
$result = dbquery("Select * from ".$db_prefix."kroax WHERE ".groupaccess('kroax_access')."  AND kroax_approval='' ".$orderby." ORDER by kroax_id DESC  LIMIT $rowstart,".$kroaxsettings['kroax_set_thumbs_per_page']."");

		$counter = 0; $r = 0; $k = 1;
		echo "<table cellpadding='0' cellspacing='1' width='100%'>\n<tr>\n";
		while ($data = dbarray($result)) {
			if ($counter != 0 && ($counter % $kroaxsettings['kroax_set_thumbs_per_row'] == 0)) echo "</tr>\n<tr>\n";
	          		echo "<td align='center' valign='top' class='tbl'>\n";
makelist();
			echo "</td>\n";
			$counter++; $k++;
		}
		echo "</tr>\n</table>\n";
		if ($rows > $kroaxsettings['kroax_set_thumbs_per_page']) echo "<div align='center' style='margin-top:5px;'>\n".makePageNav($rowstart,$kroaxsettings['kroax_set_thumbs_per_page'],$rows,3,FUSION_SELF."?sortby=$sortby&amp;")."\n</div>\n";
										
//Album view end

}
else
{
$result = dbquery("SELECT * FROM ".$db_prefix."kroax WHERE ".groupaccess('kroax_access')." AND ".groupaccess('kroax_access_cat')." AND kroax_approval='' ".$orderby." ORDER BY kroax_titel ASC LIMIT $rowstart,".$kroaxsettings['kroax_set_pre']."");
while ($data = dbarray($result)) {
makelist();

}
if ($rows > $kroaxsettings['kroax_set_pre']) echo "<div align='center' style='margin-top:5px;'>".makepagenav($rowstart,$kroaxsettings['kroax_set_pre'],$rows,3,FUSION_SELF."?sortby=$sortby&amp;")."\n</div>\n";
}
echo "<center><br>\n <b>$sortby<b><br><br>\n</center>\n";

$search = array(
"A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R",
"S","T","U","V","W","X","Y","Z","0","1","2","3","4","5","6","7","8","9"
);
echo "<center><table align='center' cellpadding='0' cellspacing='1' class='tbl-border'>\n<tr>\n";
echo "<td rowspan='2' class='tbl2'><a href='".FUSION_SELF."?sortby=all'>".$locale['KROAX202']."</a></td>";
for ($i=0;$i < 39!="";$i++) {
echo "<td align='center' class='tbl1'><div class='small'><a href='".FUSION_SELF."?sortby=".$search[$i]."'>".$search[$i]."</a></div></td>";
echo ($i==19 ? "<td rowspan='2' class='tbl2'><a href='".FUSION_SELF."?sortby=all'>".$locale['KROAX202']."</a></td>\n</tr>\n<tr>\n" : "\n");
}
echo "</table></center>\n";
echo "</div>";
closetable();
echo "<br>";
require_once "footer.php";
require_once THEMES."templates/footer.php";
?>