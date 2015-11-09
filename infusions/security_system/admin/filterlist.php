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
$rows = dbcount("(id)", DB_PREFIX."secsys_filter", "");

$result=dbquery("SELECT * from ".DB_PREFIX."secsys_filter order by list ASC LIMIT $rowstart,$limits");
opentable($locale['SYS107']);
$list.="<center><b>$sys_error</b></center><fieldset><legend>".$locale['SYS109']."</legend>
<form action='".FUSION_SELF."?pagefile=filterlist&amp;action=update_system' method='post'><center>
".$locale['SYS112']." <input type='text' name='new_filter' style='width:150px;' maxlength='255' class='textbox'>
<input type='submit' name='insert_filter' class='button' value='".$locale['SYS165']."'><br>
<font class='small'>".$locale['SYS112_1']."</font></center>
</form>
</fieldset>";
$list.="<form name='fi_form' action='".FUSION_SELF."?pagefile=filterlist&amp;action=update_system' method=post>";
$list.="<fieldset><legend>".$locale['SYS107']."</legend>
<table width=100% border='0' cellspacing='2' cellpadding='3'>
<tr>";
$count=0;
$spalte=4;
$listnum=0;
$list.="<td colspan='".($spalte*2)."'>
<table border='0' class='textbox' cellspacing='0' cellpadding='0' width='100%'>
<tr>
<td>".$locale['SYS114']." ".($rowstart+1)." - ".($rowstart+dbrows($result))." ".$locale['SYS117']." <b>$rows</b> ".$locale['SYS115']."</td>
<td align='right'>".$locale['SYS113'].": <a href='".FUSION_SELF."?pagefile=filterlist&amp;rowstart=0&amp;limits=10'>10</a> <a href='".FUSION_SELF."?pagefile=filterlist&amp;rowstart=0&amp;limits=25'>25</a> <a href='".FUSION_SELF."?pagefile=filterlist&amp;rowstart=0&amp;limits=50'>50</a> <a href='".FUSION_SELF."?pagefile=filterlist&amp;rowstart=0&amp;limits=$rows'>".$locale['SYS116']."</a></td>
</tr></table><br>".$locale['SYS218']."
</td>
</tr><tr>\n";
  while($row=dbarray($result)) {
   if ($count==$spalte) {
   $list.="</tr><tr>\n";
   $count=0;
   }
   if ($count<$spalte) {
   $list.="<td valign='top' width=1%><input class='textbox' type='checkbox' id='delete_list' name='delete_filter[]' value='".$row['id']."'></td><td valign='middle'><font color='".($row['active']==1 ? "#009900" : "#C00000")."'>".$row['list']."</font></td>\n";
   $count++;
   }
   $listnum++;
  }
  $list.="</tr><tr>\n<td colspan='".($spalte*2)."' valign='top'><center>
  <table border='0' cellspacing='0' cellpading='3'>
  <tr>
  <td valign='top'><input class='textbox' type='checkbox' onClick='this.value=AllActivate(this.form.delete_list);'></td>
  <td> ".$locale['SYS123']."</td>
  </tr></table>
  <input class='button' type='submit' value='".$locale['SYS110']."' name='del_filter' onClick='return DeleteFilter();'>
  <input class='button' type='submit' value='".$locale['SYS216']."' name='active_filter'>
  <input class='button' type='submit' value='".$locale['SYS217']."' name='deactive_filter'>
  </center>";
  if ($rows > $limits) $list.="<br><div align='center' style='margin-top:5px;'>\n".makePageNav($rowstart,$limits,$rows,3,"?pagefile=filterlist&amp;limits=$limits&amp;")."\n</div>\n";
  $list.="</td></tr>\n</table>\n</fieldset></form>";

echo $list;
echo "<script type='text/javascript'>
function DeleteFilter() {
	return confirm('".$locale['SYS119']."');
}
</script>\n";	
closetable();
?>
