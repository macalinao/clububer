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
global $sys_error,$list;
if (!isset($rowstart) || !isNum($rowstart)) $rowstart = 0;
if (!isset($limits) || !isNum($limits)) $limits = 50;
$rows = dbcount("(proxy_id)", DB_PREFIX."secsys_proxy_whitelist", "");
$result=dbquery("SELECT * from ".DB_PREFIX."secsys_proxy_whitelist order by proxy_datestamp DESC LIMIT $rowstart,$limits");

opentable($locale['PROXY000']);
$list.="<center><b>$sys_error</b></center><fieldset><legend>".$locale['PROXY001']."</legend>
<form action='".FUSION_SELF."?pagefile=proxy_white&amp;action=update_system' method='post'><center>
".$locale['PROXY009']." <input type='text' name='new_proxy_white1' style='width:30px;' maxlength='3' class='textbox'>.<input type='text' name='new_proxy_white2' style='width:30px;' maxlength='3' class='textbox'>.<input type='text' name='new_proxy_white3' style='width:30px;' maxlength='3' class='textbox'>.<input type='text' name='new_proxy_white4' style='width:30px;' maxlength='3' class='textbox'>
<input type='submit' name='insert_proxy' class='button' value='".$locale['SYS165']."'><br>".$locale['PROXY016']."</center>
</form>
</fieldset>";

$list.="<form name='fi_form' action='".FUSION_SELF."?pagefile=proxy_white&amp;action=update_system' method=post>";
$list.="<fieldset><legend>".$locale['PROXY000']."</legend>
<table width=100% border='0' cellspacing='2' cellpadding='3'>
<tr>";
$count=0;
$spalte=4;
$listnum=0;
if ($rows>0) {
$list.="<td colspan='".($spalte*2)."'>
<table border='0' class='textbox' cellspacing='0' cellpadding='0' width='100%'>
<tr>
<td>".$locale['SYS114']." ".($rowstart+1)." - ".($rowstart+dbrows($result))." ".$locale['SYS117']." <b>$rows</b> ".$locale['SYS115']."</td>
<td align='right'>".$locale['SYS113'].": <a href='".FUSION_SELF."?pagefile=proxy_white&amp;rowstart=0&amp;limits=10'>10</a> <a href='".FUSION_SELF."?pagefile=proxy_white&amp;rowstart=0&amp;limits=25'>25</a> <a href='".FUSION_SELF."?pagefile=proxy_white&amp;rowstart=0&amp;limits=50'>50</a> <a href='".FUSION_SELF."?pagefile=proxy_white&amp;rowstart=0&amp;limits=$rows'>".$locale['SYS116']."</a></td>
</tr></table><br>".$locale['PROXY008']."
</td>
</tr><tr>\n";
  while($row=dbarray($result)) {
   if ($count==$spalte) {
   $list.="</tr><tr>\n";
   $count=0;
   }
   if ($count<$spalte) {
   $list.="<td valign='top' width=1%><input class='textbox' type='checkbox' id='delete_proxy' name='delete_proxy[]' value='".$row['proxy_id']."'></td><td valign='middle'><a href='".FUSION_SELF."?pagefile=ipfander&amp;searchip=".$row['proxy_ip']."'><font color='".($row['proxy_status']==1 ? "#009900" : "#C00000")."'>".$row['proxy_ip']."</font></a></td>\n";
   $count++;
   }
   $listnum++;
  }
  $list.="</tr><tr>\n<td colspan='".($spalte*2)."' valign='top'><center>
  <table border='0' cellspacing='0' cellpading='3'>
  <tr>
  <td valign='top'><input class='textbox' type='checkbox' onClick='this.value=AllActivate(this.form.delete_proxy);'></td>
  <td> ".$locale['SYS123']."</td>
  </tr></table>
  <input class='button' type='submit' value='".$locale['PROXY004']."' name='del_proxy' onClick='return DeleteProxy();'>
  <input class='button' type='submit' value='".$locale['PROXY013']."' name='black_proxy' onClick='return BlackProxy();'>
  <input class='button' type='submit' value='".$locale['PROXY002']."' name='active_proxy' onClick='return ActivateProxy();'>
  <input class='button' type='submit' value='".$locale['PROXY003']."' name='deactive_proxy' onClick='return DeactivateProxy();'>
  </center>";
  if ($rows > $limits) $list.="<br><div align='center' style='margin-top:5px;'>\n".makePageNav($rowstart,$limits,$rows,3,"?pagefile=proxy_white&amp;limits=$limits&amp;")."\n</div>\n";
  $list.="</td></tr>\n</table>\n</fieldset></form>";
echo "<script type='text/javascript'>
function DeleteProxy() {
	return confirm('".$locale['PROXY005']."');
}
function BlackProxy() {
	return confirm('".$locale['PROXY005']."');
}
function ActivateProxy() {
	return confirm('".$locale['PROXY006']."');
}
function DeactivateProxy() {
	return confirm('".$locale['PROXY007']."');
}
</script>\n";	
} else {
	$list.="<td>".$locale['PROXY014']."</td></tr></table>\n";
}
echo $list;

closetable();
?>