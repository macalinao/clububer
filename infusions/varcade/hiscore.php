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

if (isset($current) && !isNum($current)) fallback("index.php");
if (isset($gameid) && !isNum($gameid)) fallback("index.php");

include INFUSIONS."varcade/functions.php";

//No need to try scoreing for guests
if (!iMEMBER) 
{
redirect("".INFUSIONS."varcade/guests.php"); 
exit; 
}

$current = dbarray(dbquery("SELECT reverse,lid,title FROM ".$db_prefix."varcade_games WHERE lid='".$gameid."'"));

if($current['reverse'] == "1")
	{
		$sort = "ASC";
	}
	else
	{
		$sort = "DESC";
	}

$hiscorex= dbquery("SELECT ter.*, user_id,user_name FROM ".$db_prefix."varcade_score ter
		LEFT JOIN ".$db_prefix."users tusr ON ter.player_id=tusr.user_id
		WHERE game_id='".$gameid."' ORDER BY game_score ".$sort." LIMIT 25");


$resultvset = dbquery("SELECT * FROM ".$db_prefix."varcade_settings");
$varcsettings = dbarray($resultvset);

if ($varcsettings['popup']=="1")
{
$gamelink = "<a href='#' onclick=window.open('".INFUSIONS."varcade/arcade.php?p=1&game=".$current['lid']."','VArcpopup','scrollbars=yes,resizable=yes,width=650,height=650')>"; 
}
else
{
$gamelink = "<a href='arcade.php?game=".$current['lid']."'>";
}

opentable($locale['TOUR013']);

if (!isset($p))
{
makeheader();
}

echo "<div id='lajv'>";

echo '<br><table width="98%" cellpadding="0" cellspacing="1" class="tbl-border">
<tr align="center">
<td width="10%"  class="tbl2"><span class="small"><b>'.$locale['VARC182'].'</b></span></td>
<td width="22%"  class="tbl2"><span class="small"><b>'.$locale['VARC170'].'</b></span></td>
<td width="22%"  class="tbl2"><span class="small"><b>'.$locale['VARC183'].'</b></span></td>
<td width="22%"  class="tbl2"><span class="small"><b>'.$locale['VARC184'].'</b></span></td>
<td width="24%"  class="tbl2"><span class="small"><b>'.$locale['VARC185'].'</b></span></td>
</tr>';
$count = 1;
$i = 0;
while($hiscore = dbarray($hiscorex))
{
//color code the rows
$i % 2 == 0 ? $rowclass="tbl1" : $rowclass="tbl2";

echo '<tr>
<td  class="'.$rowclass.'"><center><span class="small"><img src="'.INFUSIONS.'varcade/img/kings/king'.$count.'.gif"></center></span></td>
<td  class="'.$rowclass.'"><span class="small">'; echo "".$gamelink.""; echo ''.$current['title'].'</a></span></td>';
if (!isset($p))
{
echo '<td class="'.$rowclass.'"><span class="small"><a href="'.INFUSIONS.'varcade/player_hiscore.php?name='.$hiscore['user_name'].'&id='.$hiscore['user_id'].'&rowstart=0">' .$hiscore['user_name'].'</a></span></td>';
}
else
{
echo '<td class="'.$rowclass.'"><span class="small"><a href="'.INFUSIONS.'varcade/player_hiscore.php?p=1&name='.$hiscore['user_name'].'&id='.$hiscore['user_id'].'&rowstart=0">' .$hiscore['user_name'].'</a></span></td>';
}
echo '<td class="'.$rowclass.'"><span class="small">'.$hiscore['game_score'].'</span></td>
<td class="'.$rowclass.'"><span class="small">'.showdate("forumdate", $hiscore['score_date']).'</span></td>
</tr>';
$i++;
$count++;
}
echo '</table>';
echo "</div>";
closetable();
require_once INFUSIONS."varcade/footer.php";
if (!isset($p))
{
require_once THEMES."templates/footer.php";
}
?>
