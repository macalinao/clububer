<?php
if (!defined("IN_FUSION")) { header("Location: ../../index.php"); exit; }


if (!defined("LANGUAGE")) {
// PHPFusion environment
$this_lang =  str_replace("/", "", LOCALESET);
	if (file_exists(INFUSIONS."varcade_best_panel/locale/".$this_lang.".php")) {
	   include INFUSIONS."varcade_best_panel/locale/".$this_lang.".php";
	} else {
	   include INFUSIONS."varcade_best_panel/locale/English.php";
	}
        } else {
// mFusion environment
$this_lang =  LANGUAGE;
	if (file_exists(INFUSIONS."varcade_best_panel/locale/".$this_lang.".php")) {
	   include INFUSIONS."varcade_best_panel/locale/".$this_lang.".php";
	} else {
	   include INFUSIONS."varcade_best_panel/locale/English.php";
	}
}

$gname = dbquery("SELECT hi_player, count(*) FROM ".$db_prefix."varcade_games WHERE ".groupaccess('access')." AND status='2' GROUP BY hi_player ORDER BY `count(*)` DESC LIMIT 0,11");
openside($locale['ABP000']);

echo "<table align='center' cellpadding='0' cellspacing='1' width='85%'>";
echo '
<tr>
<td class="tbl2" width="10"><span class="small"><b>'.$locale['ABP002'].'</b></span></td>
<td class="tbl2" width="45"><span class="small"><b>'.$locale['ABP003'].'</b></span></td>
<td class="tbl2" width="45"><span class="small"><b>'.$locale['ABP004'].'</b></span></td>
</tr>';

$count = 1;
$i = 0;
while($tulem = dbarray($gname))
{
if ($tulem['hi_player']=='0')
{
/*Do Nothing*/
}
else
{
$userquery=dbquery("SELECT * FROM ".$db_prefix."users WHERE user_name='".$tulem['hi_player']."'");
while ($user=dbarray($userquery))
{
$i % 2 == 0 ? $rowclass="tbl1" : $rowclass="tbl2";

echo '<tr  width="85%">
<td  class="'.$rowclass.'"><center><span class="small"><img src="'.INFUSIONS.'varcade/img/kings/king'.$count.'.gif" width="26" height="26" hspace="1" vspace="1" border="0"></center></span></td>
<td class="'.$rowclass.'">&nbsp;<span class="small"><a href="'.INFUSIONS.'varcade/player_hiscore.php?name='.$user['user_name'].'&id='.$user['user_id'].'&rowstart=0" onmouseover="ajaxshout_showTooltip(\''.BASEDIR.'tooltip/scripts/members.php?parser='.$user['user_id'].'\',this);return false" onmouseout="ajaxshout_hideTooltip()">'.trimlink($user['user_name'], 12).'</a></span></td>
<td class="'.$rowclass.'" align="center"><span class="small">'.$tulem['count(*)'].'</span></td>
</tr>';
$i++;
$count++;
}//while ($user=db
}//else
}
echo '</table>';
closeside();

?>
