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
global $sys_error;
if (empty($rowstart) || !isNum($rowstart)) $rowstart = 0;
if (empty($limits) || !isNum($limits)) $limits = 10;
if (empty($hack_type)) {$hack_type='overview';}else {$hack_type=strtolower(stripinput($_GET['hack_type']));}
if ($hack_type!="overview") {
$countwhere="hack_type='$hack_type'";
$rslwhere="WHERE $countwhere";
}
else {
$countwhere="";
$rslwhere="";
}
$hack_count=dbcount("(hack_type)", DB_PREFIX."secsys_logfile", "hack_type='hacks'");
$block_count=dbcount("(hack_type)", DB_PREFIX."secsys_logfile", "hack_type='blocks'");
$flood_count=dbcount("(hack_type)", DB_PREFIX."secsys_logfile", "hack_type='floods'");
$spam_count=dbcount("(hack_type)", DB_PREFIX."secsys_logfile", "hack_type='spam'");
$proxyl_count=dbcount("(hack_type)", DB_PREFIX."secsys_logfile", "hack_type='proxy_login'");
$proxyr_count=dbcount("(hack_type)", DB_PREFIX."secsys_logfile", "hack_type='proxy_register'");
$proxyv_count=dbcount("(hack_type)", DB_PREFIX."secsys_logfile", "hack_type='proxy_visit'");
$all_count=dbcount("(hack_type)", DB_PREFIX."secsys_logfile", "");
$rows = dbcount("(hack_type)", DB_PREFIX."secsys_logfile", "$countwhere");
$result=dbquery("SELECT * from ".DB_PREFIX."secsys_logfile $rslwhere ORDER BY hack_datestamp DESC LIMIT $rowstart,$limits");
opentable($locale['SYS106']);
 echo "<table align='center' cellpadding='0' cellspacing='1' width='100%' class='tbl-border'>";
    echo "
    <tr>
        <td width='15%' rowspan='2' class=".($hack_type == "overview" ? "tbl1" : "tbl2")." align='center'><span class='small'>".($hack_type == "overview" ? "<b>".$locale['SYS116']." ".$locale['SYS115']." ($all_count)</b>" : "<a class='small' href='".FUSION_SELF."?pagefile=logfiles&amp;hack_type=overview'><b>".$locale['SYS116']." ".$locale['SYS115']."</b></a> ($all_count)")."</span></td>
        <td width='20%' class=".($hack_type == "blocks" ? "tbl1" : "tbl2")." align='center'><span class='small'>".($hack_type == "blocks" ? "<b>".$locale['SYS103']."  ($block_count)</b>" : "<a class='small' href='".FUSION_SELF."?pagefile=logfiles&amp;hack_type=blocks'><b>".$locale['SYS103']."</b></a>  ($block_count)")."</span></td>
        <td width='20%' class=".($hack_type == "hacks" ? "tbl1" : "tbl2")." align='center'><span class='small'>".($hack_type == "hacks" ? "<b>".$locale['SYS102']."  ($hack_count)</b>" : "<a class='small' href='".FUSION_SELF."?pagefile=logfiles&amp;hack_type=hacks'><b>".$locale['SYS102']."</b></a>  ($hack_count)")."</span></td>
        <td width='20%' class=".($hack_type == "floods" ? "tbl1" : "tbl2")." align='center'><span class='small'>".($hack_type == "floods" ? "<b>".$locale['SYS104']."  ($flood_count)</b>" : "<a class='small' href='".FUSION_SELF."?pagefile=logfiles&amp;hack_type=floods'><b>".$locale['SYS104']."</b></a>  ($flood_count)")."</span></td>
        <td width='20%' class=".($hack_type == "spam" ? "tbl1" : "tbl2")." align='center'><span class='small'>".($hack_type == "spam" ? "<b>".$locale['SYS168']."  ($spam_count)</b>" : "<a class='small' href='".FUSION_SELF."?pagefile=logfiles&amp;hack_type=spam'><b>".$locale['SYS168']."</b></a>  ($spam_count)")."</span></td>
        
    </tr>
    <tr>
	  <td width='20%' class=".($hack_type == "proxy_visit" ? "tbl1" : "tbl2")." align='center'><span class='small'>".($hack_type == "proxy_visit" ? "<b>".$locale['SYS228']."  ($proxyv_count)</b>" : "<a class='small' href='".FUSION_SELF."?pagefile=logfiles&amp;hack_type=proxy_visit'><b>".$locale['SYS228']."</b></a>  ($proxyv_count)")."</span></td>

	  <td width='20%' class=".($hack_type == "proxy_login" ? "tbl1" : "tbl2")." align='center'><span class='small'>".($hack_type == "proxy_login" ? "<b>".$locale['SYS226']."  ($proxyl_count)</b>" : "<a class='small' href='".FUSION_SELF."?pagefile=logfiles&amp;hack_type=proxy_login'><b>".$locale['SYS226']."</b></a>  ($proxyl_count)")."</span></td>
	  
     <td width='25%' class=".($hack_type == "proxy_register" ? "tbl1" : "tbl2")." align='center'><span class='small'>".($hack_type == "proxy_register" ? "<b>".$locale['SYS227']."  ($proxyr_count)</b>" : "<a class='small' href='".FUSION_SELF."?pagefile=logfiles&amp;hack_type=proxy_register'><b>".$locale['SYS227']."</b></a>  ($proxyr_count)")."</span></td>   
     <td colspan=3 class=tbl2>&nbsp;</td>
    </tr>
	</table>";
    tablebreak();
if ($hack_type=="hacks") {
$log_entry=$locale['SYS102'];
}
else if ($hack_type=="blocks") {
$log_entry=$locale['SYS103'];
}
else if ($hack_type=="floods"){
$log_entry=$locale['SYS104'];
}
else if ($hack_type=="spam") {
$log_entry=$locale['SYS168'];
}else if ($hack_type=="proxy_visit") {
$log_entry=$locale['SYS228'];
}
else if ($hack_type=="proxy_register") {
$log_entry=$locale['SYS227'];
}
else if ($hack_type=="proxy_login") {
$log_entry=$locale['SYS226'];
}
else {
$log_entry=$locale['SYS116']." ".$locale['SYS115'];
}

$list="<form name='log_form' action='".FUSION_SELF."?pagefile=logfiles&amp;hack_type=$hack_type&amp;action=update_system' method=post>";
$list.="<fieldset><legend><b>".$locale['SYS106']." - ".$log_entry."</b></legend>
<table width=100% border='0' cellspacing='2' cellpadding='3'>
<tr><td>";
$listnum=0;
if ($rows>0) {
$list.="<table border='0' class='textbox' cellspacing='0' cellpadding='0' width='100%'>
<tr>
<td>".$locale['SYS114']." ".($rowstart+1)." - ".($rowstart+dbrows($result))." ".$locale['SYS117']." <b>$rows</b> ".$locale['SYS115']."</td>
<td align='right'>".$locale['SYS113'].": <a href='".FUSION_SELF."?pagefile=logfiles&amp;hack_type=$hack_type&amp;rowstart=0&amp;limits=10'>10</a> <a href='".FUSION_SELF."?pagefile=logfiles&amp;hack_type=$hack_type&amp;rowstart=0&amp;limits=25'>25</a> <a href='".FUSION_SELF."?pagefile=logfiles&amp;hack_type=$hack_type&amp;rowstart=0&amp;limits=50'>50</a> <a href='".FUSION_SELF."?pagefile=logfiles&amp;hack_type=$hack_type&amp;rowstart=0&amp;limits=$rows'>".$locale['SYS116']."</a></td>
</tr></table><br><center>
<table border='0' cellspacing='1' cellpadding='4'><tr>\n";
if (isset($userdata['user_level']) && $userdata['user_level']=='103') {
$list.="<td><input class='button' type='submit' value='".$locale['SYS110']."' name='del_logfile' onClick='return DeleteLogFile();'></td>\n";
}
$list.="<td><a href='#' onClick='openPrint(\"".INFUSIONS."security_system/admin/printlogfiles.php?hack_type=$hack_type\")'><img src='".INFUSIONS."security_system/images/print.gif' border='0' alt=='".$locale['SYS401']."' title='".$locale['SYS401']."'></a></td></tr></table></center>";
}
$list.="<center>$sys_error</center><table cellspacing='1' cellpadding='2' width='100%' class='tbl-border'>
<tr class='tbl2'><td><input class='textbox' type='checkbox' onClick='this.value=AllActivate(this.form.delete_log);'></td>
<td width='8%' align='center' nowrap><b>".$locale['SYS124']."</b></td>
<td width='10%' align='center' nowrap><b>".$locale['SYS157']."</b></td>
<td width='12%' align='center' nowrap><b>".$locale['SYS125']."</b></td>
<td width='20%' align='center' nowrap><b>".$locale['SYS126']."</b></td>
<td width='30%' align='center' nowrap><b>".$locale['SYS127']."</b></td>
<td width='20%' align='center' nowrap><b>".$locale['SYS128']."</b></td>
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
   $usrdata=dbarray(dbquery("SELECT user_name FROM ".$db_prefix."users WHERE user_id='".$row['hack_userid']."'"));
   $list.="<tr class='".$background."'><td valign='top' width=1%><input class='textbox' type='checkbox' id='delete_log' name='delete_logfile[]' value='".$row['hack_id']."'></td>
   
   <td valign='top' align='center'nowrap>".strftime("%d.%m.%Y <br> %H:%M", $row['hack_datestamp'])."</td>
   <td valign='top'nowrap>".$usrdata['user_name']."&nbsp;</td>
   <td valign='top'nowrap><a href='".INFUSIONS."security_system/admin/index.php?pagefile=ipfander&searchip=".$row['hack_ip']."'>".$row['hack_ip']."</a></td>
   <td valign='top'nowrap><div style='width:100%; height:60px; overflow:auto; border:0px;'>".($row['hack_query']!="" ? wordwrap($row['hack_query'],20,"<br>\n",1) : "&nbsp;")."</div></td>
   <td valign='top'nowrap><div style='width:100%; height:60px; overflow:auto; border:0px;'>".($row['hack_referer']!="" ? wordwrap($row['hack_referer'],20,"<br>\n",1) : "&nbsp;")."</div></td>
   <td valign='top'nowrap>".($row['hack_agent']!="" ? wordwrap($row['hack_agent'],20,"<br>\n",1) : "&nbsp;")."</td>
   </tr>\n";
   $listnum++;
  }
$list.="</table>";
$list.="</tr>";
if ($rows>0) {
$list.="<tr>\n<td><center>
<table border='0' cellspacing='1' cellpadding='4'><tr>\n";
if (isset($userdata['user_level']) && $userdata['user_level']=='103') {
$list.="<td><input class='button' type='submit' value='".$locale['SYS110']."' name='del_logfile' onClick='return DeleteLogFile();'></td>\n";
}
$list.="<td><a href='#' onClick='openPrint(\"".INFUSIONS."security_system/admin/printlogfiles.php?hack_type=$hack_type\")'><img src='".INFUSIONS."security_system/images/print.gif' border='0' alt=='".$locale['SYS401']."' title='".$locale['SYS401']."'></a></td></tr></table></center>";
}
else {
$list.="<tr>\n<td><center>".$locale['SYS121']."</center>";
}
  if ($rows > $limits)
  {$list.="<br><div align='center' style='margin-top:5px;'>\n".makePageNav($rowstart,$limits,$rows,3,"?pagefile=logfiles&amp;hack_type=$hack_type&amp;limits=$limits&amp;")."\n</div>\n";}
  $list.="</td></tr>\n</table>\n</fieldset></form>";

echo $list;
echo "<script type='text/javascript'>
function DeleteLogFile() {
	return confirm('".$locale['SYS120']."');
}
</script>\n";	
closetable();
?>
