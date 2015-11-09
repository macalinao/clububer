<?php
/*----------------------------------------------+
| SECURITY SYSTEM V1.0 FÜR PHP-FUSION           |
| copyright (c) 2006 by BS-Fusion Deutschland   |
| Email-Support: webmaster[at]bs-fusion.de      |
| Homepage: http://www.bs-fusion.de             |
| Inhaber: Manuel Kurz                          |
+----------------------------------------------*/
if (!defined("IN_FUSION") || !iADMIN && !checkrights("IP")) {die();}
if (!empty($sys_action) && file_exists(INFUSIONS."security_system/admin/".$sys_action.".php")) {
require_once(INFUSIONS."security_system/admin/".$sys_action.".php");
}
global $sys_error,$list;
if (!isset($rowstart) || !isNum($rowstart)) $rowstart = 0;
if (!isset($limits) || !isNum($limits)) $limits = 20;
$rows = dbcount("(c_user_id)", DB_PREFIX."secsys_membercontrol", "c_userlock='1'");
$result=dbquery("SELECT * from ".DB_PREFIX."secsys_membercontrol order by c_userlock_datestamp ASC LIMIT $rowstart,$limits");
opentable($locale['SYS154']);
$list="<form name='usr_form' action='".FUSION_SELF."?pagefile=userlocked&amp;action=update_system' method=post>";
$list.="<fieldset><legend><b>".$locale['SYS154']."</b></legend>
<table width=100% border='0' cellspacing='2' cellpadding='3'>
<tr><td>";
$listnum=0;
if ($rows>0) {
$list.="
<table border='0' class='textbox' cellspacing='0' cellpadding='0' width='100%'>
<tr>
<td>".$locale['SYS114']." ".($rowstart+1)." - ".($rowstart+dbrows($result))." ".$locale['SYS117']." <b>$rows</b> ".$locale['SYS115']."</td>
<td align='right'>".$locale['SYS113'].": <a href='".FUSION_SELF."?pagefile=userlocked&amp;rowstart=0&amp;limits=10'>10</a> <a href='".FUSION_SELF."?pagefile=userlocked&amp;rowstart=0&amp;limits=25'>25</a> <a href='".FUSION_SELF."?pagefile=userlocked&amp;rowstart=0&amp;limits=50'>50</a> <a href='".FUSION_SELF."?pagefile=userlocked&amp;rowstart=0&amp;limits=$rows'>".$locale['SYS116']."</a></td>
</tr></table><br>";
}
$list.="<center><font color='#FF0000'><b>$sys_error</b></font></center><table cellspacing='1' cellpadding='2' width='60%' class='tbl-border' align='center'>
<tr class='tbl2'><td width='1%'><input class='textbox' type='checkbox' onClick='this.value=AllActivate(this.form.unlock_user);'></td>
<td align='center'><b>".$locale['SYS124']."</b></td>
<td align='center'><b>".$locale['SYS157']."</b></td>
</tr>
";
$background='tbl1';
  while($row=dbarray($result)) {
   if ($background=='tbl1') {
   $background="tbl2";
   }
   else {
   $background="tbl1";
   }
   $usrdata=dbarray(dbquery("SELECT user_name FROM ".$db_prefix."users WHERE user_id='".$row['c_user_id']."'"));
   $list.="<tr class='".$background."'><td valign='top' width=1%>
   <input class='textbox' type='checkbox' id='unlock_user' name='unlock_user[]' value='".$row['c_user_id']."'></td>
   <td valign='top' align='center'>".strftime("%d.%m.%Y <br> %H:%M:%S", $row['c_userlock_datestamp'])."</td>
   <td valign='top'>".$usrdata['user_name']."</td>
   </tr>\n";
   $listnum++;
  }
$list.="</table>";
$list.="</tr>";
if ($rows>0) {
$list.="<tr>\n<td><center><input class='button' type='submit' value='".$locale['SYS155']."' name='unlock_users'></center>";
}
else {
$list.="<tr>\n<td><center>".$locale['SYS156']."</center>";
}
  if ($rows > $limits) $list.="<br><div align='center' style='margin-top:5px;'>\n".makePageNav($rowstart,$limits,$rows,3,"?pagefile=userlocked&amp;limits=$limits&amp;")."\n</div>\n";
  $list.="</td></tr>\n</table>\n</fieldset></form>";

echo $list;
closetable();
?>
