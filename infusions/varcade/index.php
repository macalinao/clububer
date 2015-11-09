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
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
/* Start IPBarcade Game adaptor script 					    */
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
//ipb uses the index page with an act request
//first check for act
$ipb_check = (isset($_GET['act'])) ? 'Arcade' : '';
//now check for a score
$ipb_score = (isset($_GET['do'])) ? 'newscore' : '';

//assuming we now have them final check and activate
if ( ($ipb_check) && ($ipb_score) )
{
require_once "../../maincore.php";
$game = trim(addslashes(stripslashes($_POST['gname'])));
$score = intval($_POST['gscore']);
$currentgame=$game.'.swf';
$sql = "SELECT * FROM ".DB_PREFIX."varcade_games WHERE flash = '". $currentgame ."'";
if(!$result=dbquery($sql)) { echo 'failed query'; }
$row = dbrows($result);
echo '<form method="post" name="ipb" action="newscore.php">';
echo '<input type="hidden" name="score" value="'. $score .'">';
echo '<input type="hidden" name="game_name" value="'. $game .'">';
echo '</form>';
echo '<script type="text/javascript">';
echo 'window.onload = function(){document.ipb.submit()}';
echo '</script>';
exit();
}

//  pnFlashGames Support 
$pngame = ($_GET['func']);
if (isset($pngame))
{
echo "Ok PN lir ska nu funka, måste bara decoda skiten & skicka till scoreing filer sen";
}


// IBProArcade v3 Support 
if($HTTP_GET_VARS['autocom'] == 'arcade' || $HTTP_POST_VARS['autocom'] == 'arcade') 
{
require_once "../../maincore.php";
$game = trim(addslashes(stripslashes($_POST['gname'])));
$score = intval($_POST['gscore']);
$currentgame=$game.'.swf';
$sql = "SELECT * FROM ".DB_PREFIX."varcade_games WHERE flash = '". $currentgame ."'";
if(!$result=dbquery($sql)) { echo 'failed query'; }
$row = dbrows($result);
echo '<form method="post" name="ipb" action="newscore.php">';
echo '<input type="hidden" name="score" value="'. $score .'">';
echo '<input type="hidden" name="game_name" value="'. $game .'">';
echo '</form>';
echo '<script type="text/javascript">';
echo 'window.onload = function(){document.ipb.submit()}';
echo '</script>';
exit();
}
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
/* End Game adaptor script 					    */
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
require_once "../../maincore.php";
require_once THEMES."templates/header.php";

if (isset($category) && !isNum($category)) fallback("index.php");

include INFUSIONS."varcade/functions.php";

if ($varcsettings['touringp'] == "1")
{
if (!isset($category))
{
include "arcade_tournament.php";
}
}
opentable($locale['VARC105']);
makeheader();
echo "<div id='lajv'>";

if (isset($noaccess))
{
if (file_exists(INFUSIONS."members_bewerb/bewerb_admin.php"))
{
echo "<center>".$locale['NOARC100']."<br>";
echo "".$locale['NOARC101']."<br>";
echo "<a href='".BASEDIR."members.php?action=rights'>".$locale['NOARC102']."</a></center>";
}
else
{
echo "<center>".$locale['NOARC100']."<br>";
echo "".$locale['NOARC103']."<br>";
echo "<a href='".BASEDIR."contact.php'>".$locale['NOARC104']."</a>";
}
echo "</center>";
}

if (isset($category)) {
//Check user access level & redirect if not granted & trying a direct link
$detect = dbquery("SELECT access FROM ".$db_prefix."varcade_cats WHERE cid='$category'");
while ($detect_access = dbarray($detect)) {
$access = $detect_access['access'];
}
if(checkgroup($access)) {
//PROCEED AS PLANNED
}else{
redirect(INFUSIONS."varcade/index.php");
}

$result = dbquery("SELECT * FROM ".$db_prefix."varcade_games WHERE ".groupaccess('access')." AND cid='$category' AND status='2' ORDER BY played DESC");
$rows = dbrows($result);
if (!isset($rowstart) || !isNum($rowstart)) $rowstart = 0;
$result = dbquery("SELECT * FROM ".$db_prefix."varcade_games WHERE ".groupaccess('access')." AND cid='$category'  AND status='2' ORDER BY played DESC LIMIT $rowstart,".$varcsettings['thumbs_per_page']."");
		$counter = 0; $r = 0; $k = 1;
		echo "<table cellpadding='0' cellspacing='0' width='100%' style='margin: 0 auto;'>\n<tr>\n";
		while ($data = dbarray($result)) {
			if ($counter != 0 && ($counter % $varcsettings['thumbs_per_row'] == 0)) echo "</tr>\n<tr>\n";
	          		echo "<td align='center' valign='top' class='tbl'>\n";
makelist();
			echo "</td>\n";
			$counter++; $k++;
		}
		echo "</tr>\n</table>\n";
		if ($rows > $varcsettings['thumbs_per_page']) echo "<div align='center' style='margin-top:5px;'>\n".makePageNav($rowstart,$varcsettings['thumbs_per_page'],$rows,3,FUSION_SELF."?category=".$category."&")."\n</div>\n";
}
else {

echo "<table width='100%' border='0' cellspacing='2' cellpadding='3' align='left'>";
$result = dbquery("select * from ".$db_prefix."varcade_cats WHERE ".groupaccess('access')."");
$numrows = dbrows($result);
if($numrows > 0)
{
$numrows % 2  ? $numrows += 1 : $numrows;
$rows = $numrows / 2;

//left main cats
echo "<td width=50%>";
$result1=dbquery("select * from ".$db_prefix."varcade_cats WHERE ".groupaccess('access')." ORDER BY title LIMIT $rows");
while($data1 = dbarray($result1))
{
$count1="".dbcount("(lid)", "".$db_prefix."varcade_games", "cid='".$data1['cid']."' AND status='2'")."";
echo '<table cellspacing="2" cellpadding="2" border="0"><tr><td rowspan="2">';
echo  "<a href='".FUSION_SELF."?category=".$data1['cid']."'><img src='".INFUSIONS."varcade/categoryimg/".$data1['image']."' alt='".$data1['title']."' border='0'></a></td>";
echo "<td><a href='".FUSION_SELF."?category=".$data1['cid']."'><b>".$data1['title']."</b></a> (".$count1." ".$locale['VARC105'].")";

//Most popular games
$lsubcats=dbquery("select * from ".$db_prefix."varcade_games WHERE ".groupaccess('access')." AND cid='$data1[cid]' AND status='2' ORDER BY played DESC limit 5");
$counting = 1;
$i=0;
while($data2 = dbarray($lsubcats))
{
if ($varcsettings['popup']=="1")
{
$gamelink = "<a href='#' onclick=window.open('".INFUSIONS."varcade/arcade.php?p=1&game=".$data2['lid']."','VArcpopup','scrollbars=yes,resizable=yes,width=800,height=700')>"; 
}
else
{
$gamelink = "<a href='arcade.php?game=".$data2['lid']."'>";
}
echo "<br><span class='smal'>".$counting." - ".$gamelink."".$data2['title']."</a></span>";
$i++;
$counting++;
}			

echo "</td></tr></table>";
}
echo "</td><td width=50%>";
//right main cats 
$result3=dbquery("select * from ".$db_prefix."varcade_cats WHERE ".groupaccess('access')." ORDER BY title LIMIT $rows, $rows");
while($data3 = dbarray($result3)) 
{
$count2 = "".dbcount("(lid)", " ".$db_prefix."varcade_games", "cid='".$data3['cid']."' AND status='2'")."";
echo "<table cellspacing='2' cellpadding='2' border='0'><tr><td rowspan='2' align='left'>";
echo  "<a href='".FUSION_SELF."?category=".$data3['cid']."'><img src='".INFUSIONS."varcade/categoryimg/".$data3['image']."' alt='".$data3['title']."' border='0'></a></td>";
echo "<td><a href='".FUSION_SELF."?category=".$data3['cid']."'><b>".$data3['title']."</b></a> (".$count2." ".$locale['VARC105'].")";
//Most popular games
$rsubcats=dbquery("select * from ".$db_prefix."varcade_games WHERE ".groupaccess('access')." AND cid='$data3[cid]' AND status='2' ORDER BY played DESC LIMIT 0,5");
$counting = 1;
$i=0;
while($data4 = dbarray($rsubcats))
{
if ($varcsettings['popup']=="1")
{
$gamelink = "<a href='#' onclick=window.open('".INFUSIONS."varcade/arcade.php?p=1&game=".$data4['lid']."','VArcpopup','scrollbars=yes,resizable=yes,width=800,height=700')>"; 
}
else
{
$gamelink = "<a href='arcade.php?game=".$data4['lid']."'>";
}
echo "<br><span class='smal'>".$counting." - ".$gamelink."".$data4['title']."</a></span>";
$i++;
$counting++;	
}					
echo "</td></tr></table>";
}
echo "</td>";
}
echo "</tr></table>";
}

closetable();


echo "
<table cellpadding='0' cellspacing='0' align='center' width='90%' class='tbl-border'>
<tr class='tbl2'><td><center>".$locale['VARC220']." ".dbcount("(lid)", "".$db_prefix."varcade_games where status='2'")." ".$locale['VARC221']." ".$locale['VARC222']." ".dbcount("(cid)", "".$db_prefix."varcade_cats")." ".$locale['VARC223']." ".dbcount("(id)", "".$db_prefix."varcade_rating")." ".$locale['VARC224']." ".dbcount("(comment_id)", "".$db_prefix."comments where comment_type='G'")." ".$locale['VARC225']."</center></td></tr>
</table>";


require_once "footer.php";
require_once THEMES."templates/footer.php";
?>