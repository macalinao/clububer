<?php
/*----------------------------------------------+
| SECURITY SYSTEM V1.0 FÜR PHP-FUSION           |
| copyright (c) 2006 by BS-Fusion Deutschland   |
| Email-Support: webmaster[at]bs-fusion.de      |
| Homepage: http://www.bs-fusion.de             |
| Inhaber: Manuel Kurz                          |
+----------------------------------------------*/
include_once("../../../maincore.php");
if (!defined("IN_FUSION") || !iADMIN && !checkrights("IP")) {fallback(BASEDIR."index.php");}
include_once(THEME."theme.php");
if (file_exists(INFUSIONS . "security_system/locale/".$settings['locale'].".php")) {
	include INFUSIONS . "security_system/locale/".$settings['locale'].".php";
}
else {
 	include INFUSIONS . "security_system/locale/German.php";
}
echo "
<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">
<html></head>
<title>".$settings['sitename']." ".$locale['SYS100']." - ".$locale['SYS106']."</title>
<link rel='stylesheet' href='".THEME."styles.css' type='text/css'>
</head>
<body onload='self.focus();'>\n";
// Filterliste der UserAgenten
global $sys_error, $list;
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
opentable("");
 echo "<h1 align='center'>".$settings['sitename']."
 <h2 align='center'>".$locale['SYS100']." - ".$locale['SYS106']."</h2>
 </h1>
 <table align='center' cellpadding='0' cellspacing='1' width='100%' class='tbl-border'>";
   echo "
    <tr>
        <td width='15%' rowspan='2' class=".($hack_type == "overview" ? "tbl1" : "tbl2")." align='center'><span class='small'>".($hack_type == "overview" ? "<b>".$locale['SYS116']." ".$locale['SYS115']." ($all_count)</b>" : "<a class='small' href='".FUSION_SELF."?hack_type=overview'><b>".$locale['SYS116']." ".$locale['SYS115']."</b></a> ($all_count)")."</span></td>
        <td width='20%' class=".($hack_type == "blocks" ? "tbl1" : "tbl2")." align='center'><span class='small'>".($hack_type == "blocks" ? "<b>".$locale['SYS103']."  ($block_count)</b>" : "<a class='small' href='".FUSION_SELF."?hack_type=blocks'><b>".$locale['SYS103']."</b></a>  ($block_count)")."</span></td>
        <td width='20%' class=".($hack_type == "hacks" ? "tbl1" : "tbl2")." align='center'><span class='small'>".($hack_type == "hacks" ? "<b>".$locale['SYS102']."  ($hack_count)</b>" : "<a class='small' href='".FUSION_SELF."?hack_type=hacks'><b>".$locale['SYS102']."</b></a>  ($hack_count)")."</span></td>
        <td width='20%' class=".($hack_type == "floods" ? "tbl1" : "tbl2")." align='center'><span class='small'>".($hack_type == "floods" ? "<b>".$locale['SYS104']."  ($flood_count)</b>" : "<a class='small' href='".FUSION_SELF."?hack_type=floods'><b>".$locale['SYS104']."</b></a>  ($flood_count)")."</span></td>
        <td width='20%' class=".($hack_type == "spam" ? "tbl1" : "tbl2")." align='center'><span class='small'>".($hack_type == "spam" ? "<b>".$locale['SYS168']."  ($spam_count)</b>" : "<a class='small' href='".FUSION_SELF."?hack_type=spam'><b>".$locale['SYS168']."</b></a>  ($spam_count)")."</span></td>
        
    </tr>
    <tr>
	  <td width='20%' class=".($hack_type == "proxy_visit" ? "tbl1" : "tbl2")." align='center'><span class='small'>".($hack_type == "proxy_visit" ? "<b>".$locale['SYS228']."  ($proxyv_count)</b>" : "<a class='small' href='".FUSION_SELF."?hack_type=proxy_visit'><b>".$locale['SYS228']."</b></a>  ($proxyv_count)")."</span></td>

	  <td width='20%' class=".($hack_type == "proxy_login" ? "tbl1" : "tbl2")." align='center'><span class='small'>".($hack_type == "proxy_login" ? "<b>".$locale['SYS226']."  ($proxyl_count)</b>" : "<a class='small' href='".FUSION_SELF."?hack_type=proxy_login'><b>".$locale['SYS226']."</b></a>  ($proxyl_count)")."</span></td>
	  
     <td width='25%' class=".($hack_type == "proxy_register" ? "tbl1" : "tbl2")." align='center'><span class='small'>".($hack_type == "proxy_register" ? "<b>".$locale['SYS227']."  ($proxyr_count)</b>" : "<a class='small' href='".FUSION_SELF."?hack_type=proxy_register'><b>".$locale['SYS227']."</b></a>  ($proxyr_count)")."</span></td>   
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
}
else if ($hack_type=="proxy_visit") {
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

$list="<fieldset><legend><b>".$locale['SYS106']." - ".$log_entry."</b></legend>
<table width=100% border='0' cellspacing='2' cellpadding='3'>
<tr><td>";
$listnum=0;
if ($rows>0) {
$list.="
<table border='0' class='textbox' cellspacing='0' cellpadding='0' width='100%'>
<tr>
<td>".$locale['SYS114']." ".($rowstart+1)." - ".($rowstart+dbrows($result))." ".$locale['SYS117']." <b>$rows</b> ".$locale['SYS115']."</td>
<td align='right'>".$locale['SYS113'].": <a href='".FUSION_SELF."?hack_type=$hack_type&amp;rowstart=0&amp;limits=10'>10</a> <a href='".FUSION_SELF."?hack_type=$hack_type&amp;rowstart=0&amp;limits=25'>25</a> <a href='".FUSION_SELF."?hack_type=$hack_type&amp;rowstart=0&amp;limits=50'>50</a> <a href='".FUSION_SELF."?hack_type=$hack_type&amp;rowstart=0&amp;limits=$rows'>".$locale['SYS116']."</a></td>
</tr></table><br>";
}
$list.="<center>$sys_error</center><table cellspacing='1' cellpadding='2' width='100%' border='1px'>
<tr class='tbl2'>
<td align='center'><b>".$locale['SYS124']."</b></td>
<td align='center'><b>".$locale['SYS157']."</b></td>
<td align='center'><b>".$locale['SYS125']."</b></td>
<td align='center'><b>".($hack_type!='spam' ? $locale['SYS126'] : $locale['SYS169'])."</b></td>
<td align='center'><b>".$locale['SYS127']."</b></td>
<td align='center'><b>".$locale['SYS128']."</b></td>
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
   $list.="<tr class='".$background."'>
   <td valign='top' align='center'>".strftime("%d.%m.%Y <br> %H:%M", $row['hack_datestamp'])."</td>
   <td valign='top'>".$usrdata['user_name']."&nbsp;</td>
   <td valign='top'>".$row['hack_ip']."</td>
   <td valign='top'>".chunk_split($row['hack_query'],20)."</td>
   <td valign='top'>".chunk_split($row['hack_referer'],20)."&nbsp;</td>
   <td valign='top'>".chunk_split($row['hack_agent'],20)."</td>
   </tr>\n";
   $listnum++;
  }
$list.="</table>";
$list.="</tr>";
if ($rows>0) {
$list.="<tr>\n<td>&nbsp;</center>";
}
else {
$list.="<tr>\n<td><center>".$locale['SYS121']."</center>";
}
  if ($rows > $limits) $list.="<br><div align='center' style='margin-top:5px;'>\n".makePageNav($rowstart,$limits,$rows,3,FUSION_SELF."?hack_type=$hack_type&amp;limits=$limits&amp;")."\n</div>\n";
  $list.="</td></tr>\n</table>\n</fieldset>";

$list.="<div align='right' style='font-weight:800;'><a href='#' onclick='self.close();'>".$locale['SYS400']."</a> | <a href='#' onclick='print();'>".$locale['SYS401']."</a></div>";
echo $list;
closetable();
echo "</body>
</html>";
?>
