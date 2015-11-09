<?php
/*----------------------------------------------+
| SECURITY SYSTEM V1.0 FÜR PHP-FUSION           |
| copyright (c) 2006 by BS-Fusion Deutschland   |
| Email-Support: webmaster[at]bs-fusion.de      |
| Homepage: http://www.bs-fusion.de             |
| Inhaber: Manuel Kurz                          |
+----------------------------------------------*/
if (!defined("IN_FUSION") || !iADMIN && !checkrights("IP")) {die();}
// Filterliste der UserAgenten
if (!empty($sys_action) && file_exists(INFUSIONS."security_system/admin/".$sys_action.".php")) {
require_once(INFUSIONS."security_system/admin/".$sys_action.".php");
}
function timechange($flooder) {
global $locale;
if ($flooder<60) {
$ftime=$flooder." ".$locale['SYS200'];
}
if ($flooder==60) {
$ftime="1 ".$locale['SYS201'];
}
if ($flooder>60 && $flooder<3600) {
$ftime=round($flooder/60)." ".$locale['SYS202'];
}
if ($flooder==3600) {
$ftime=round($flooder/3600)." ".$locale['SYS203'];
}
if ($flooder>3600 && $flooder<86400) {
$ftime=round($flooder/3600)." ".$locale['SYS204'];
}
if ($flooder==86400) {
$ftime=round($flooder/86400)." ".$locale['SYS205'];
}
if ($flooder>86400) {
$ftime=round($flooder/86400)." ".$locale['SYS206'];
}
return $ftime;
}
$result=dbquery("SELECT * from ".DB_PREFIX."secsys_settings");
opentable($locale['SYS108']);
$row=dbarray($result);
$secsys_started=$row['secsys_started'];
$proxy_visit=$row['proxy_visit'];
$proxy_login=$row['proxy_login'];
$proxy_register=$row['proxy_register'];
$forumtime=$row['fctime'];
$shouttime=$row['sctime'];
$commenttime=$row['cctime'];
$contacttime=$row['coctime'];
$pmtime=$row['mctime'];
$gbtime=$row['gctime'];
$userlock=$row['userlock'];
$userattempts=$row['user_attempts'];
$flood_active=$row['flood_active'];
$forum_access=$row['forum_access'];
$shout_access=$row['shout_access'];
$contact_access=$row['contact_access'];
$pm_access=$row['pm_access'];
$gb_access=$row['gb_access'];
$comment_access=$row['comment_access'];
$panel_set=$row['panel_set'];
function flood_uncontrol($group="") {
	$user_groups = getusergroups();
  $access_opts = "";
		while(list($key, $user_group) = each($user_groups)){
			$sel = ($group == $user_group['0'] ? " selected" : "");
			$access_opts .= "<option value='".$user_group['0']."'$sel>".$user_group['1']."</option>\n";
		}

return $access_opts;
}		
define("YES_NO",$row['userlock']==0 ? $locale['SYS139']:$locale['SYS138']);
echo wordwrap($locale['SYS144'],100,"<br>\n");
echo "<p><form name='setting_form' action='".FUSION_SELF."?pagefile=settings&amp;action=update_system' method='post'>";
 
opentable($locale['SYS145']);
echo "<table border='0' cellspacing='1' cellpadding='2' width='80%' align='center'>
<tr><td width='50%'><b>".$locale['SYS222']."</b> (".($secsys_started==1 ? $locale['SYS138']:$locale['SYS139']).")</td>
<td><select class='textbox' name='new_secsys_started'>
<option value='1'".($secsys_started==1 ? ' selected' : '').">".$locale['SYS138']."</option>
<option value='0'".($secsys_started==0? ' selected' : '').">".$locale['SYS139']."</option>
</select>
</td>
</tr>
<tr><td><b>".$locale['SYS223']."</b> (".($proxy_visit==1 ? $locale['SYS139']:$locale['SYS138']).")</td>
<td><select class='textbox' name='new_proxy_visit'>
<option value='1'".($proxy_visit==1 ? ' selected' : '').">".$locale['SYS139']."</option>
<option value='0'".($proxy_visit==0 ? ' selected' : '').">".$locale['SYS138']."</option>
</select>
</td>
</tr>
<tr><td><b>".$locale['SYS224']."</b> (".($proxy_register==1 ? $locale['SYS138']:$locale['SYS139']).")</td>
<td><select class='textbox' name='new_proxy_register'>
<option value='1'".($proxy_register==1 ? ' selected' : '').">".$locale['SYS138']."</option>
<option value='0'".($proxy_register==0 ? ' selected' : '').">".$locale['SYS139']."</option>
</select>
</td>
</tr>
<tr><td><b>".$locale['SYS225']."</b> (".($proxy_login==1 ? $locale['SYS138']:$locale['SYS139']).")</td>
<td><select class='textbox' name='new_proxy_login'>
<option value='1'".($proxy_login==1 ? ' selected' : '').">".$locale['SYS138']."</option>
<option value='0'".($proxy_login==0 ? ' selected' : '').">".$locale['SYS139']."</option>
</select>
</td>
</tr>
<tr><td><b>".$locale['SYS136']."</b> (".($flood_active==1 ? $locale['SYS138']:$locale['SYS139']).")</td>
<td><select class='textbox' name='new_flood_active'>
<option value='1'".($flood_active==1 ? ' selected' : '').">".$locale['SYS138']."</option>
<option value='0'".($flood_active==0 ? ' selected' : '').">".$locale['SYS139']."</option>
</select>
</td>
</tr></table>\n";
closetable();

opentable($locale['SYS230']);
echo "<table border='0' cellspacing='1' cellpadding='2' width='80%' align='center'>
<tr><td width='50%'><b>".$locale['SYS129']."</b> (".timechange($forumtime).")</td>
<td><input type='text' class='textbox' name='new_fctime' style='width:50px;' value='".$forumtime."'> ".$locale['SYS200']."</td>
</tr>
<tr><td><b>".$locale['SYS130']."</b> (".timechange($shouttime).")</td>
<td><input type='text' class='textbox' name='new_sctime' style='width:50px;' value='".$shouttime."'> ".$locale['SYS200']."</td>
</tr>
<tr><td><b>".$locale['SYS131']."</b> (".timechange($commenttime).")</td>
<td><input type='text' class='textbox' name='new_cctime' style='width:50px;' value='".$commenttime."'> ".$locale['SYS200']."</td>
</tr>
<tr><td><b>".$locale['SYS132']."</b> (".timechange($contacttime).")</td>
<td><input type='text' class='textbox' name='new_coctime' style='width:50px;' value='".$contacttime."'> ".$locale['SYS200']."</td>
</tr>
<tr><td><b>".$locale['SYS133']."</b> (".timechange($pmtime).")</td>
<td><input type='text' class='textbox' name='new_mctime' style='width:50px;' value='".$pmtime."'> ".$locale['SYS200']."</td>
</tr>
<tr><td><b>".$locale['SYS134']."</b> (".timechange($gbtime).")</td>
<td><input type='text' class='textbox' name='new_gctime' style='width:50px;' value='".$gbtime."'> ".$locale['SYS200']."</td>
</tr>
<tr><td><b>".$locale['SYS137']."</b> (".YES_NO.")</td>
<td><select class='textbox' name='new_userlock'>
<option value='1' ".($userlock==1?'selected':'').">".$locale['SYS138']."</option>
<option value='0' ".($userlock==0?'selected':'').">".$locale['SYS139']."</option>
</select>
</td>
</tr>
<tr><td><b>".$locale['SYS147']."</b> (".$userattempts.")</td>
<td><input type='text' class='textbox' name='new_userattempts' style='width:50px;' value='".$userattempts."'></td>
</tr>
<tr><td><b>".$locale['SYS148']."</b> (".getgroupname($forum_access).")</td>
<td><select class='textbox' name='new_forum_access'>";
echo flood_uncontrol($forum_access)."
</select>
</td>
</tr>
<tr><td><b>".$locale['SYS149']."</b> (".getgroupname($shout_access).")</td>
<td><select class='textbox' name='new_shout_access'>";
echo flood_uncontrol($shout_access)."
</select>
</td>
</tr>
<tr><td><b>".$locale['SYS150']."</b> (".getgroupname($comment_access).")</td>
<td><select class='textbox' name='new_comment_access'>";
echo flood_uncontrol($comment_access)."
</select>
</td>
</tr>
<tr><td><b>".$locale['SYS152']."</b> (".getgroupname($pm_access).")</td>
<td><select class='textbox' name='new_pm_access'>";
echo flood_uncontrol($pm_access)."
</select>
</td>
</tr>
<tr><td><b>".$locale['SYS151']."</b> (".getgroupname($contact_access).")</td>
<td><select class='textbox' name='new_contact_access'>";
echo flood_uncontrol($contact_access)."
</select>
</td>
</tr>
<tr><td><b>".$locale['SYS153']."</b> (".getgroupname($gb_access).")</td>
<td><select class='textbox' name='new_gb_access'>";
echo flood_uncontrol($gb_access)."
</select>
</td>
</tr>
<tr><td><b>".$locale['SYS171']."</b> (".$panel_set.")<br>
<table class='tbl2' border='0' width='70%' cellspacing='0' cellpadding='3'><tr><td>";
include_once INFUSIONS."security_system_panel/security_system_panel.php";
echo "</td></tr></table></td>
<td valign='top'><select class='textbox' name='new_panel_set'>";
for ($i=1;$i<=11;$i++) {
echo "<option value='$i'".($panel_set==$i ? ' selected':'').">$i</option>\n";
}
echo "</select>
</td>
</tr></table>
";
closetable();

opentable($locale['LOG000']);
echo "<table border='0' cellspacing='1' cellpadding='2' width='80%' align='center'>
<tr><td width='50%'><b>".$locale['LOG002']."</b></td>
<td><select name='newctrackerlog' class='textbox'>
<option value='1'".($sys_setting['ctracker_log']=='1' ? ' selected' : '').">".$locale['SYS138']."</option>
<option value='0'".($sys_setting['ctracker_log']=='0' ? ' selected' : '').">".$locale['SYS139']."</option>
</select></td>
</tr>
<tr><td width='50%'><b>".$locale['LOG003']."</b></td>
<td><select name='newfilterlog' class='textbox'>
<option value='1'".($sys_setting['filter_log']=='1' ? ' selected' : '').">".$locale['SYS138']."</option>
<option value='0'".($sys_setting['filter_log']=='0' ? ' selected' : '').">".$locale['SYS139']."</option>
</select></td>
</tr>
<tr><td width='50%'><b>".$locale['LOG004']."</b></td>
<td><select name='newspamlog' class='textbox'>
<option value='1'".($sys_setting['spam_log']=='1' ? ' selected' : '').">".$locale['SYS138']."</option>
<option value='0'".($sys_setting['spam_log']=='0' ? ' selected' : '').">".$locale['SYS139']."</option>
</select></td>
</tr>
<tr><td width='50%'><b>".$locale['LOG005']."</b></td>
<td><select name='newfloodlog' class='textbox'>
<option value='1'".($sys_setting['flood_log']=='1' ? ' selected' : '').">".$locale['SYS138']."</option>
<option value='0'".($sys_setting['flood_log']=='0' ? ' selected' : '').">".$locale['SYS139']."</option>
</select></td>
</tr>
<tr><td width='50%'><b>".$locale['LOG006']."</b></td>
<td><select name='newproxylog' class='textbox'>
<option value='1'".($sys_setting['proxy_log']=='1' ? ' selected' : '').">".$locale['SYS138']."</option>
<option value='0'".($sys_setting['proxy_log']=='0' ? ' selected' : '').">".$locale['SYS139']."</option>
</select></td>
</tr>
<tr><td width='50%'><b>".$locale['LOG001']."</b></td>
<td><select name='newautodeletelog' class='textbox'>
<option value='1'".($sys_setting['log_autodelete']=='1' ? ' selected' : '').">".$locale['SYS138']."</option>
<option value='0'".($sys_setting['log_autodelete']=='0' ? ' selected' : '').">".$locale['SYS139']."</option>
</select></td>
</tr>
<tr><td width='50%'><b>".$locale['LOG007']."</b></td>
<td><input name='newmaxlog' class='textbox' style='width:50px;' value='".$sys_setting['log_max']."'>
</td>
</tr>
<tr><td width='50%'><b>".$locale['LOG008']."</b></td>
<td><input name='newlogexpired' class='textbox' style='width:50px;' value='".$sys_setting['log_expired']."'> ".$locale['SYS206']."
</td>
</tr>
</table>";
closetable();

opentable("PHP-Fusion 7");
echo "<table border='0' cellspacing='1' cellpadding='2' width='80%' align='center'>
<tr><td>".$locale['SYS135']." (".timechange($settings['flood_interval']).")</td>
<td><input type='text' class='textbox' name='new_floodinterval' style='width:50px;' value='".$settings['flood_interval']."'> ".$locale['SYS200']."</td>
</tr><tr><td colspan='2'><span class='small'>".wordwrap($locale['SYS135_1'],100,"<br>\n")."</span></td>
</tr></table>";
closetable();

echo "<center>
<input type='submit' class='button' name='sys_settings' value='".$locale['SYS146']."'>
</center></form>";
closetable();
?>
