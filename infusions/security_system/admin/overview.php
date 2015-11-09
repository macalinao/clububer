<?php
/*----------------------------------------------+
| SECURITY SYSTEM V1.0 FÜR PHP-FUSION           |
| copyright (c) 2006 by BS-Fusion Deutschland   |
| Email-Support: webmaster[at]bs-fusion.de      |
| Homepage: http://www.bs-fusion.de             |
| Inhaber: Manuel Kurz                          |
+----------------------------------------------*/
if (!defined("IN_FUSION") || !iADMIN && !checkrights("IP")) {die();}
// Dies bitte nicht ändern ////////////////////////////////////////////////////////////////////////////
$locale['SYSLOGO'] = "<center><a href='http://www.bs-fusion.de' target='_blank'>
<img src='".INFUSIONS."security_system/images/security_logo.jpg' border='0' width='280' height='210' alt='Copyright (c)2006 by BS-Fusion Deutschland' title='Copyright (c)2006 by BS-Fusion Deutschland'></a></center>";
//////////////////////////////////////////////////////////////////////////////////////////////////////
opentable($locale['SYS105']);
$all_logcount=dbcount("(hack_type)", DB_PREFIX."secsys_logfile", "");
$stats=dbarray(dbquery("SELECT * from ".DB_PREFIX."secsys_statistics"));
$stat='<center><form action="https://www.paypal.com/cgi-bin/webscr" method="post"><b><span style="color:red;">Eine Spende für dieses Projekt würde uns freuen und wir wären dafür sehr dankbar.<br>
A donation for this project would make us very happy and we would be deeply grateful.</span></b><br><input type="hidden" name="cmd" value="_s-xclick">
<input type="image" src="https://www.paypal.com/de_DE/i/btn/x-click-butcc-donate.gif" border="0" name="submit" alt="Zahlen Sie mit PayPal - schnell, kostenlos und sicher!"><img alt="" border="0" src="https://www.paypal.com/de_DE/i/scr/pixel.gif" width="1" height="1"><input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----"></form></center>';

$stat.=$locale['SYSLOGO']."<br clear='all'>";
$stat.="<table border='0' cellspacing='1' cellpadding='1' align='center' class='tbl-border'>
<tr><td class='tbl2'>".$locale['SYS103'].": </td><td class='tbl2'>".sprintf($locale['SYS302'],$stats['blocks'])."</td></tr>
<tr><td class='tbl1'>".$locale['SYS102'].": </td><td class='tbl1'>".sprintf($locale['SYS302'],$stats['hacks'])."</td></tr>
<tr><td class='tbl2'>".$locale['SYS104'].": </td><td class='tbl2'>".sprintf($locale['SYS302'],$stats['floods'])."</td></tr>
<tr><td class='tbl1'>".$locale['SYS168'].": </td><td class='tbl1'>".sprintf($locale['SYS302'],$stats['spams'])."</td></tr>
<tr><td class='tbl2'>".$locale['SYS226'].": </td><td class='tbl2'>".sprintf($locale['SYS302'],$stats['proxy_login'])."</td></tr>
<tr><td class='tbl1'>".$locale['SYS227'].": </td><td class='tbl1'>".sprintf($locale['SYS302'],$stats['proxy_register'])."</td></tr>
<tr><td class='tbl2'>".$locale['SYS228'].": </td><td class='tbl2'>".sprintf($locale['SYS302'],$stats['proxy_visit'])."</td></tr>
<tr><td class='tbl1'>".$locale['PROXY012'].": </td><td class='tbl1'>".sprintf($locale['SYS302'],$stats['proxy_blacklist'])."</td></tr>
<tr><td class='tbl2'><b>".$locale['SYS118'].":</b> </td><td class='tbl2'><b>".sprintf($locale['SYS302'],($stats['blocks']+$stats['hacks']+$stats['floods']+$stats['spams']+$stats['proxy_login']+$stats['proxy_register']+$stats['proxy_visit']+$stats['proxy_blacklist']))."</b></td></tr></table>
<br><br>
<table border='0' cellspacing='0' cellpadding='1' align='center' class='tbl-border'>
<tr><form action='".FUSION_SELF."?pagefile=logfiles&action=update_system' method='post'><td colspan='2' class='tbl2'>
".$all_logcount." ".$locale['SYS106'];
if (isset($userdata['user_level']) && $userdata['user_level']=='103' && $all_logcount>0) {
$stat.="<br>".$locale['global_102'].": <input type='password' name='clean_logtable' class='textbox'><br><input type='submit' value='".$locale['SYS220']."' onClick='return DeleteLogFile();' class='button'>\n";
}
$stat.="</td></form></tr></table>";

echo "<script type='text/javascript'>
function DeleteLogFile() {
	return confirm('".$locale['SYS221']."');
}
</script>\n";	
// Automatische Löschung der alten Floodkontrolleinträge des Kontaktformulars
$cont_rsl=dbcount("(contact_id)",DB_PREFIX."secsys_contact","contact_datestamp<='".(time()-$sys_setting['coctime'])."'");
if ($cont_rsl>0) {
$clean_contact_tbl=dbquery("DELETE FROM ".$db_prefix."secsys_contact WHERE contact_datestamp<='".(time()-$sys_setting['coctime'])."'");
}
// Automatische Löschung alter Mitgliederkontrolleinträge wenn keine Sperrung erfolgt ist
$member_rsl=dbcount("(c_user_id)",DB_PREFIX."secsys_membercontrol","c_userlock_datestamp<='".(time()-3600)."' AND c_userlock='0'");
if ($member_rsl>0) {
$clean_member_tbl=dbquery("DELETE FROM ".$db_prefix."secsys_membercontrol WHERE c_userlock_datestamp<='".(time()-3600)."'");
}
echo $stat;
closetable();
?>
