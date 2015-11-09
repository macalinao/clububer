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
$rows = dbcount("(spam_id)", DB_PREFIX."secsys_spamfilter", "");
$result=dbquery("SELECT * from ".DB_PREFIX."secsys_spamfilter order by spam_word ASC LIMIT $rowstart,$limits");
opentable($locale['SYS160']);
$list.="<center><b>$sys_error</b></center><fieldset><legend>".$locale['SYS161']."</legend>
<form action='".FUSION_SELF."?pagefile=spamlist&amp;action=update_system' method='post'><center>
".$locale['SYS161']." <input type='text' name='new_spam' style='width:150px;' maxlength='255' class='textbox'>
<input type='submit' name='insert_spam' class='button' value='".$locale['SYS165']."'><br>
<font class='small'>".$locale['SYS161_1']."</font></center>
</form>
</fieldset>";
$list.="<form name='spam_form' action='".FUSION_SELF."?pagefile=spamlist&amp;action=update_system' method=post>";
$list.="<fieldset><legend>".$locale['SYS166']."</legend>
<table width=100% border='0' cellspacing='2' cellpadding='3'>
<tr>";
$count=0;
$spalte=4;
$listnum=0;
$list.="<td colspan='".($spalte*2)."'>
<table border='0' class='textbox' cellspacing='0' cellpadding='0' width='100%'>
<tr>
<td>".$locale['SYS114']." ".($rowstart+1)." - ".($rowstart+dbrows($result))." ".$locale['SYS117']." <b>$rows</b> ".$locale['SYS115']."</td>
<td align='right'>".$locale['SYS113'].": <a href='".FUSION_SELF."?pagefile=spamlist&amp;rowstart=0&amp;limits=10'>10</a> <a href='".FUSION_SELF."?pagefile=spamlist&amp;rowstart=0&amp;limits=25'>25</a> <a href='".FUSION_SELF."?pagefile=spamlist&amp;rowstart=0&amp;limits=50'>50</a> <a href='".FUSION_SELF."?pagefile=spamlist&amp;rowstart=0&amp;limits=$rows'>".$locale['SYS116']."</a></td>
</tr></table><br>
</td>
</tr><tr>\n";
  while($row=dbarray($result)) {
   if ($count==$spalte) {
   $list.="</tr><tr>\n";
   $count=0;
   }
   if ($count<$spalte) {
   $list.="<td valign='top' width=1%><input class='textbox' type='checkbox' id='delete_spam' name='delete_spamword[]' value='".$row['spam_id']."'></td><td valign='middle'>".$row['spam_word']."</td>\n";
   $count++;
   }
   $listnum++;
  }
  $list.="</tr><tr>\n<td colspan='".($spalte*2)."' valign='top'><center>\n";
if ($rows>0) {
  $list.="<table border='0' cellspacing='0' cellpading='3'>
  <tr>
  <td valign='top'>
  <input class='textbox' type='checkbox' onClick='this.value=AllActivate(this.form.delete_spam);'></td>
  <td> ".$locale['SYS123']."</td>
  </tr></table>\n ";
  $list.="<input class='button' type='submit' value='".$locale['SYS110']."' name='del_spam' onClick='return DeleteSpam();'>
  </center>";
}
else {
  $list.=$locale['SYS167']."</center>\n";
}
  if ($rows > $limits) $list.="<br><div align='center' style='margin-top:5px;'>\n".makePageNav($rowstart,$limits,$rows,3,"?pagefile=spamlist&amp;limits=$limits&amp;")."\n</div>\n";
  $list.="</td></tr>\n</table>\n</fieldset></form>";

echo $list;
echo "<script type='text/javascript'>
function DeleteSpam() {
	return confirm('".$locale['SYS164']."');
}
</script>\n";	
closetable();
?>
