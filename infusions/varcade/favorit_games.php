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

if (isset($fav_id) && !isNum($fav_id)) fallback("index.php");

include INFUSIONS."varcade/functions.php";
opentable($locale['FARC103']);
makeheader();
echo "<div id='lajv'>";
echo "</div>";
if(iMEMBER)
{
if(iMEMBER && isset($fav_id) && isset($removefav)){
dbquery("DELETE FROM ".$db_prefix."varcade_favourites WHERE fav_user='".$userdata[user_id]."' AND fav_id='".$fav_id."'");
}
if (!isset($rowstart) || !isNum($rowstart)) $rowstart = 0;

$result = dbquery("SELECT * FROM ".$db_prefix."varcade_favourites, ".$db_prefix."varcade_games WHERE ".$db_prefix."varcade_favourites.fav_user=".$userdata['user_id']." AND ".$db_prefix."varcade_favourites.fav_icon=".$db_prefix."varcade_games.icon ORDER BY ".$db_prefix."varcade_favourites.fav_gamename");
if (dbrows($result) != 0) {
$numRecords = dbrows($result);
echo "<div align='center' style='margin-top:5px;'>".makePageNav($rowstart,5,$numRecords,3,FUSION_SELF."?")."\n</div>\n"; 
$game20 = dbquery("SELECT * FROM ".$db_prefix."varcade_favourites, ".$db_prefix."varcade_games WHERE ".$db_prefix."varcade_favourites.fav_user=".$userdata['user_id']." AND ".$db_prefix."varcade_favourites.fav_icon=".$db_prefix."varcade_games.icon ORDER BY ".$db_prefix."varcade_favourites.fav_gamename LIMIT ".$rowstart.", 5");

while($data = dbarray($game20)) {
echo "<table width='100%' cellpadding='0' cellspacing='1' class='tbl-border'>";

echo "
<tr>
  <td colspan='5' class='forum-caption'><b>".$data['fav_gamename']."</b></td>
  </tr>
<tr> 
<td align='center' width='55' class='tbl2'><span class='small'><img src='".INFUSIONS."varcade/uploads/thumb/$data[fav_icon]' border='0' width='50' height='50' alt='".$data['fav_gamename']."'>";
if ($data['control'] == 0) {
echo '<td align="center" width="35" class="tbl2"><img src="'.INFUSIONS.'varcade/img/mouse.png" alt="'.$locale['VARC414'].'"></td>';
} else {
echo '<td align="center" width="35" class="tbl2"><img src="'.INFUSIONS.'varcade/img/keyboard.png" alt="'.$locale['VARC413'].'"></td>';
}

echo "<td align='center' width='325' class='tbl2'><span class='small'>".nl2br(parseubb($data['description']))."</span><br><br></td>
<td align='center' width='85' class='tbl2'>";
if ($varcsettings['popup']=="1")
{
echo "<input style='cursor:pointer;' style='width: 80px;' type=\"button\" class=\"button\" onclick=window.open('".INFUSIONS."varcade/arcade.php?p=1&game=".$data['lid']."','VArcpopup','scrollbars=yes,resizable=yes,width=800,height=700') value=\"".$locale['FARC108']."\">";
}
else
{
echo "<input style='cursor:pointer;' style='width: 80px;' type=\"button\" class=\"button\" onClick=\"self.location='arcade.php?game=".$data['lid']."'\" value=\"".$locale['FARC108']."\">";
}
echo "<br><input style='cursor:pointer;' style='width: 80px;' type=\"button\" class=\"button\" onClick=\"self.location='hiscore.php?gameid=".$data['lid']."'\" value=\"".$locale['FARC109']."\">";
echo "<br><input style='cursor:pointer;' style='width: 80px;' type=\"button\" class=\"button\" onClick=\"self.location='favorit_games.php?fav_id=".$data['fav_id']."&removefav'\" value=\"".$locale['FARC110']."\"></td>
</tr><br>"; 
}
echo "</table>";
} else {

echo "<br><center><b>".$locale['FARC104']."</b></center><br>";
}
echo "<div align='center' style='margin-top:5px;'>".makePageNav($rowstart,5,@$numRecords,3,FUSION_SELF."?")."\n</div>\n"; 
closetable();
}
else
{
redirect("".INFUSIONS."varcade/guests.php");	
closetable();
}
require_once "footer.php";
require_once THEMES."templates/footer.php";
?>

