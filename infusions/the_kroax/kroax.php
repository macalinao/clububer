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
require_once THEMES."templates/header.php";


if (isset($category) && !isNum($category)) redirect("index.php");
include INFUSIONS."the_kroax/functions.php";

if (isset($category)) $category=cleanurl_kroax($category);


$kroaxsettings = dbarray(dbquery("SELECT * FROM ".$db_prefix."kroax_set WHERE kroax_set_id='1'"));

if (!isset($rowstart) || !isNum($rowstart)) $rowstart = 0;

if(!isset($_COOKIE['kroaxdetailed']) && ($kroaxsettings['kroax_set_defaultview'] == "1"))
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
}

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
setcookie("kroaxdetailed", "$viewname", mktime(12,0,0,1, 1, 1990)); //kill cookie
redirect("".FUSION_SELF."?category=$category&rowstart=$rowstart");
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
setcookie("kroaxdetailed", $viewname, time()+31536000); //year
setcookie("kroaxthumbs", "$viewname", mktime(12,0,0,1, 1, 1990)); //kill cookie
redirect("".FUSION_SELF."?category=$category&rowstart=$rowstart");
}

opentable($locale['KROAX201']);

makeheader();

echo "<div id='lajv'>";

if (isset($noaccess))
{
if (file_exists(INFUSIONS."members_bewerb/bewerb_admin.php"))
{
echo "<center>".$locale['NOAKX100']."<br>";
echo "".$locale['NOAKX101']."<br>";
echo "<a href='".BASEDIR."members.php?action=rights'>".$locale['NOAKX102']."</a>";
}
else
{
echo "<center>".$locale['NOAKX100']."<br>";
echo "".$locale['NOAKX103']."<br>";
echo "<a href='".BASEDIR."contact.php'>".$locale['NOAKX104']."</a>";
}
echo "</center>";
echo "<br>";
require_once "footer.php";
require_once BASEDIR."side_right.php";
require_once BASEDIR."footer.php";
exit;
}

if (isset($category) && isNum($category)) {

echo '<table><tr><td align="left">[ <a href="'.FUSION_SELF.'?category='.$category.'&rowstart='.$rowstart.'&setdetiledview"><img src="img/view_detailed.png" alt="'.$locale['MKROAX108'].'"></a>  <a href="'.FUSION_SELF.'?category='.$category.'&rowstart='.$rowstart.'&setthumbview"><img src="img/view_thumbs.png" alt="'.$locale['MKROAX107'].'"></a> ]  [ '.breadcrumb($category,'1').' ]</td></tr></table>';

$result = dbquery("select * from ".$db_prefix."kroax_kategori  WHERE status='1' AND  parentid='".$category."' ORDER BY title ASC");
$numrows = dbrows($result);
if($numrows > 0)
{

//Sub album view start
$result = dbquery("SELECT * FROM ".$db_prefix."kroax_kategori WHERE ".groupaccess('access')." AND  status='1' AND parentid='".$category."' ORDER BY title ASC");
		$counter = 0; $r = 0; $k = 1;
		echo "<table cellpadding='0' cellspacing='1' width='100%'>\n<tr>\n";
		while ($data = dbarray($result)) {
			if ($counter != 0 && ($counter % $kroaxsettings['kroax_set_thumbs_per_row'] == 0)) echo "</tr>\n<tr>\n";
	          		echo "<td align='center' valign='top' class='tbl'>\n";
                                    echo "<a href='".FUSION_SELF."?category=".$data['cid']."'><b>".$data['title']."</b></a><br>\n";
			if ($data['image']){
                                    echo "<a href='".FUSION_SELF."?category=".$data['cid']."'><img src='".INFUSIONS."the_kroax/categoryimg/".$data['image']."' alt='".$data['title']."' title='".$data['title']."' border='0'></a>";
			} else {
                                    echo "<a href='".FUSION_SELF."?category=".$data['cid']."'><img src='".INFUSIONS."the_kroax/categoryimg/default.gif' alt='".$data['title']."' title='".$data['title']."' border='0'></a>";
			}
			echo "</a><br>\n<span class='small'>\n";
			echo "".$locale['KROAX201'].":".dbcount("(kroax_id)", "".$db_prefix."kroax", "kroax_cat ='".$data['cid']."'")."
			</span>\n";
			echo "</td>\n";
			$counter++; $k++;
		}
		echo "</tr>\n</table>\n";
//Sub album view end

}
else
{
$result = dbquery("select * from ".$db_prefix."kroax WHERE ".groupaccess('kroax_access')." AND kroax_cat='$category' AND kroax_approval=''");
$rows = dbrows($result);
if ($rows != 0) {

if (isset($_COOKIE['kroaxthumbs']))
{
//thumb view start
$result = dbquery("Select * from ".$db_prefix."kroax WHERE ".groupaccess('kroax_access')."  AND kroax_cat='$category' AND kroax_approval='' ORDER by kroax_id DESC  LIMIT $rowstart,".$kroaxsettings['kroax_set_thumbs_per_page']."");

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
		if ($rows > $kroaxsettings['kroax_set_thumbs_per_page']) echo "<div align='center' style='margin-top:5px;'>\n".makePageNav($rowstart,$kroaxsettings['kroax_set_thumbs_per_page'],$rows,3,FUSION_SELF."?category=".$category."&")."\n</div>\n";
//thumb view end

}
else
{
$result = dbquery("Select * from ".$db_prefix."kroax WHERE ".groupaccess('kroax_access')."  AND kroax_cat='$category' AND kroax_approval=''  ORDER by kroax_id DESC LIMIT $rowstart,".$kroaxsettings['kroax_set_pre']." ");

while ($data = dbarray($result)) {

makelist();

}

echo "<div align='center' style='margin-top:5px;'>\n".makePageNav($rowstart,$kroaxsettings['kroax_set_pre'],$rows,3,FUSION_SELF."?category=".$category."&")."\n</div>\n";

}
}
}
}
if ($kroaxsettings['kroax_set_thumb'] == '1') {
if (isset($category) && isNum($category)) {
$category=cleanurl_kroax($category);
}
else
{

//Album view start
$result = dbquery("SELECT * FROM ".$db_prefix."kroax_kategori WHERE ".groupaccess('access')." AND status='1' AND parentid='0' ORDER BY title ASC");
$rows = dbrows($result);

		$counter = 0; $r = 0; $k = 1;
		echo "<table cellpadding='0' cellspacing='1' width='100%'>\n<tr>\n";
		while ($data = dbarray($result)) {
			if ($counter != 0 && ($counter % $kroaxsettings['kroax_set_thumbs_per_row'] == 0)) echo "</tr>\n<tr>\n";
	          		echo "<td align='center' valign='top' class='tbl'>\n";
                                    echo "<a href='".FUSION_SELF."?category=".$data['cid']."'><b>".$data['title']."</b></a><br>\n";
			if ($data['image']){
                                    echo "<a href='".FUSION_SELF."?category=".$data['cid']."'><img src='".INFUSIONS."the_kroax/categoryimg/".$data['image']."' alt='".$data['title']."' title='".$data['title']."' border='0'></a>";
			} else {
                                    echo "<a href='".FUSION_SELF."?category=".$data['cid']."'><img src='".INFUSIONS."the_kroax/categoryimg/default.gif' alt='".$data['title']."' title='".$data['title']."' border='0'></a>";
			}
			echo "</a><br>\n<span class='small'>\n";
			echo "".$locale['KROAX201'].":".dbcount("(kroax_id)", "".$db_prefix."kroax", "kroax_cat ='".$data['cid']."'")."
			<br>".$locale['MKROAX109']."".dbcount("(parentid)", "".$db_prefix."kroax_kategori", "parentid ='".$data['cid']."'")."
			</span>\n";
			echo "</td>\n";
			$counter++; $k++;
		}
		echo "</tr>\n</table>\n";
//Album view end
}
}
else
{
if (!isset($category)) {
//echo '<table><tr><td align="left">[ <a href="'.FUSION_SELF.'?category='.$category.'&rowstart='.$rowstart.'&setdetiledview"><img src="img/view_detailed.png" alt="'.$locale['MKROAX108'].'"></a>  <a href="'.FUSION_SELF.'?category='.$category.'&rowstart='.$rowstart.'&setthumbview"><img src="img/view_thumbs.png" alt="'.$locale['MKROAX107'].'"></a> ] </td></tr></table>';
echo "
<table width='95%' align='center' cellpadding='0' cellspacing='0' border='0'>
<td><center>".$locale['KROAX117']." ".$kroaxsettings['kroax_set_pic']." ".$locale['KROAX118']." </center></td>
<tr><td colspan='2' height='1px' background='img/line.gif'></tr></td>
</table>";

if(isset($_COOKIE['kroaxthumbs']))
{
//thumb view start
$result = dbquery("Select * from ".$db_prefix."kroax WHERE kroax_approval='' AND ".groupaccess('kroax_access')."  ORDER by kroax_id DESC LIMIT ".$kroaxsettings['kroax_set_pic']."");

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
//thumb view end

}
else
{
$result = dbquery("SELECT * FROM ".$db_prefix."kroax WHERE kroax_approval='' AND ".groupaccess('kroax_access')." ORDER BY kroax_id DESC LIMIT ".$kroaxsettings['kroax_set_pic']."");
while ($data = dbarray($result)) {
makelist();
}
}
}
}
echo "</div>";

closetable();
echo "<br>";
require_once "footer.php";
require_once THEMES."templates/footer.php";
?>