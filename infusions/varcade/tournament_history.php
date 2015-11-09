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

if (isset($current) && !isNum($current)) fallback("index.php");

include INFUSIONS."varcade/functions.php";

opentable($locale['TOUR008']);

makeheader();
echo "<div id='lajv'>";
$gname = dbquery("SELECT DISTINCT game_id FROM ".$db_prefix."varcade_tournament_scores ORDER BY game_id ASC");
echo '<form action="'.FUSION_SELF.'" method="post">
<span class="small"><b>'.$locale['TOUR011'].' </b></span>
<select class="textbox" name="gameid" size=1 onchange="submit()">
<option> '.$locale['TOUR012'].' ';

while(list($name) = dbarraynum($gname))
{
$row=dbarray(dbquery("SELECT * FROM ".$db_prefix."varcade_games WHERE lid='$name'"));
echo '<option value="'.$row['lid'].'">'.$row['title'];
}
echo '</select>
</form>';
if (isset($gameid)) {

$where = "WHERE game_id = '$gameid'";
}
else
{
$where = "WHERE game_id = '$current'";
}

$hiscorex = dbquery("SELECT DISTINCT game_id, player_id, game_score, score_date FROM ".$db_prefix."varcade_tournament_scores ".$where." ORDER BY game_score DESC LIMIT 0,25");

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
$row=dbarray(dbquery("SELECT  lid, title FROM ".$db_prefix."varcade_games WHERE  lid='$hiscore[game_id]'"));
//get results for user_id
$row2=dbarray(dbquery("SELECT * FROM ".$db_prefix."users WHERE user_id='$hiscore[player_id]'"));

$resultvset = dbquery("SELECT * FROM ".$db_prefix."varcade_settings");
$varcsettings = dbarray($resultvset);

if ($varcsettings['popup']=="1")
{
$gamelink = "<a href='#' onclick=window.open('".INFUSIONS."varcade/arcade.php?p=1&game=".$row['lid']."','VArcpopup','scrollbars=yes,resizable=yes,width=650,height=650')>"; 
}
else
{
$gamelink = "<a href='arcade.php?game=".$row['lid']."'>";
}

echo '<tr>
<td  class="'.$rowclass.'"><center><span class="small"><img src="'.INFUSIONS.'varcade/img/kings/king'.$count.'.gif"></center></span></td>
<td  class="'.$rowclass.'"><span class="small">'; echo "".$gamelink.""; echo ''.$row['title'].'</a></span></td>
<td class="'.$rowclass.'"><span class="small"><a href="'.INFUSIONS.'varcade/player_hiscore.php?name='.$row2['user_name'].'&id='.$row2['user_id'].'&rowstart=0">' .$row2['user_name'].'</a></span></td>
<td class="'.$rowclass.'"><span class="small">'.$hiscore['game_score'].'</span></td>
<td class="'.$rowclass.'"><span class="small">'.showdate("forumdate", $hiscore['score_date']).'</span></td>
</tr>';
$i++;
$count++;
}
echo '</table>';
echo "</div>";
closetable();

require_once THEMES."templates/footer.php";
?>
