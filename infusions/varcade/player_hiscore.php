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

if (!isset($p))
{
require_once THEMES."templates/header.php";
}
else
{
require_once THEME."theme.php";
echo "<link rel='stylesheet' href='".THEME."styles.css' type='text/css'>";
}

include "functions.php";


$game_query = dbquery("SELECT * FROM ".$db_prefix."varcade_games, ".$db_prefix."users WHERE
".$db_prefix."varcade_games.hi_player = ".$db_prefix."users.user_name AND ".$db_prefix."varcade_games.status='2' AND ".$db_prefix."varcade_games.played >='1' AND ".$db_prefix."varcade_games.hi_player = '".$name."' ORDER BY ".$db_prefix."users.user_id;");
$numRecords = dbrows($game_query);

opentable("".$name." ".$locale['PARC104']." ".$numRecords." ".$locale['PARC105']."");
if (!isset($p))
{
makeheader();
}

echo "<div id ='lajv'>";
echo "<table border='0' cellspacing='1' cellpadding='0' width='98%' class='tbl-border'>\n";
echo '<tr>';
if (dbrows($game_query) != 0) {
echo '
  <td width="4%" class="tbl2"><div align="center"><b>#</b></div></td>
  <td width="4%" class="tbl2"><div align="center"><b>'.$locale['PARC100'].'</b></div></td>
  <td width="30%" class="tbl2"><div align="center"><b>'.$locale['PARC101'].'</b></div></td>
  <td width="14%" class="tbl2"><div align="center"><b>'.$locale['PARC102'].'</b></div></td>
  <td width="25%" class="tbl2"><div align="center"><b>'.$locale['PARC103'].' </b></div></td>
</tr>';

$count = 1;
$i=0;
$limit = 10;

$game_query2 = dbquery("SELECT * FROM ".$db_prefix."varcade_games, ".$db_prefix."users WHERE
".$db_prefix."varcade_games.hi_player = ".$db_prefix."users.user_name AND ".$db_prefix."varcade_games.status='2' AND ".$db_prefix."varcade_games.played >='1' AND ".$db_prefix."varcade_games.hi_player = '".$name."' ORDER BY ".$db_prefix."users.user_id LIMIT ".$rowstart.", ".$limit."");
while($hilist=dbarray($game_query2))
{
if ($varcsettings['popup']=="1")
{
$gamelink = "<a href='#' onclick=window.open('".INFUSIONS."varcade/arcade.php?p=1&game=".$hilist['lid']."','VArcpopup','scrollbars=yes,resizable=yes,width=800,height=700')>"; 
}
else
{
$gamelink = "<a href='".INFUSIONS."varcade/arcade.php?game=".$hilist['lid']."'>";
}

if ($i % 2 == 0) { $row_color = "tbl1"; } else { $row_color = "tbl2"; }
echo '<tr>
<td class="'.$row_color.'"><div align="center"><img src="'.INFUSIONS.'varcade/img/trophy.gif"></div></td>
<td class="'.$row_color.'"><div align="center">';
echo "".$gamelink."";
echo '<img width="26" height="26" hspace="1" vspace="1" src="'.INFUSIONS.'varcade/uploads/thumb/'.$hilist['icon'].'" border="0"></a>';
echo '</div></td><td class="'.$row_color.'">&nbsp;&nbsp;&nbsp;';
echo "".$gamelink."";
echo ''.$hilist['title'].'</a>';
echo '</td><td valign="bottom"  class="'.$row_color.'"><div align="center"><img src="'.INFUSIONS.'varcade/img/trophy.gif" width="25" height="20"><br> ';
if (!isset($p))
{
echo  '<a href="'.INFUSIONS.'varcade/hiscore.php?gameid='.$hilist['lid'].'">'.$hilist['hiscore'].'</a>';
}
else
{
echo  '<a href="'.INFUSIONS.'varcade/hiscore.php?p=1&gameid='.$hilist['lid'].'">'.$hilist['hiscore'].'</a>';
}
echo  '</div></td><td class="'.$row_color.'"><div align="center">'.showdate("forumdate", $hilist['lastplayed']).'</div></td>';
$i++;
$count++;
}	
} else {
}
	echo '</tr></table>';
if (!isset($p))
{
echo "<div align='center' style='margin-top:5px;'>".makePageNav($rowstart,10,$numRecords,3,FUSION_SELF."?name=".$name."&id=".$id."&")."\n</div>\n";
}
else
{
echo "<div align='center' style='margin-top:5px;'>".makePageNav($rowstart,10,$numRecords,3,FUSION_SELF."?p=1&name=".$name."&id=".$id."&")."\n</div>\n";
}
echo "</div>";
closetable();
require_once "footer.php";
if (!isset($p))
{
require_once THEMES."templates/footer.php";
}
?>