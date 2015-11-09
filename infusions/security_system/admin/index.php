<?php
/*----------------------------------------------+
| SECURITY SYSTEM V1.0 FÜR PHP-FUSION           |
| copyright (c) 2006 by BS-Fusion Deutschland   |
| Email-Support: webmaster[at]bs-fusion.de      |
| Homepage: http://www.bs-fusion.de             |
| Inhaber: Manuel Kurz                          |
+----------------------------------------------*/
require_once("../../../maincore.php");
if (!defined("IN_FUSION") || !iADMIN && !checkrights("IP")) {fallback(BASEDIR."index.php");}
$print_mc_modify="";
if (!function_exists("check_infusion")) {
$print_mc_modify="<div style='color:#c00000;' align='center'><b>Die maincore.php wurde geändert!<br>Bitte füge das Security System lt. Online Dokumentation wieder ein.<hr>The maincore.php was modify.<br>Please read the online documentation and modify your maincore.php again!</b></div>";

require_once("../main_control.php");	
}
require_once THEMES."templates/admin_header.php";

	if ((isset($_POST) == true) && (is_array($_POST) == true)) extract($_POST, EXTR_OVERWRITE);
	if ((isset($_GET) == true) && (is_array($_GET) == true)) extract($_GET, EXTR_OVERWRITE);

echo "<script language='JavaScript'>
<!--
var Marker = 'false';
var i = '0';
function AllActivate(field)
{
    if(Marker == 'false')
    {
        for(i = 0; i < field.length; i++)
        {
            field[i].checked = true;
        }
        Marker = 'true';
    }
    else
    {
        for(i = 0; i < field.length; i++)
        {
            field[i].checked = false;
        }
        Marker = 'false';
    }
}
function openPrint(URL) {
aWindow=window.open(URL,'Large','toolbar=no,width=750,height=630,toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizeable=1');
}
//-->
</script>";
if (file_exists(INFUSIONS . "security_system/locale/".$settings['locale'].".php")) {
	include INFUSIONS . "security_system/locale/".$settings['locale'].".php";
}
else {
 	include INFUSIONS . "security_system/locale/German.php";
}
$license=dbarray(dbquery("SELECT * FROM ".$db_prefix."secsys_settings"));
if ($license['license_accept']>0) {
$sys_page=!empty($_GET) && isset($_GET['pagefile']) ?  htmlentities($_GET['pagefile']) : "overview"; 
if (empty($sys_page))
    {
      $sys_page= "overview";
    }
if (!empty($_GET['action'])) {
$sys_action=htmlentities($_GET['action']);
}
else {
$sys_action= "";
}
if(isset($aidlink)) {
$ins_aidlink=$aidlink;
}else {
$ins_aidlink="";
}

opentable($locale['SYS100']." ".$license['version']);
    echo "<table align='center' cellpadding='0' cellspacing='1' width='100%' class='tbl-border'>";
    echo "
    <tr>
        <td rowspan=4 width='25%' class='tbl2' align='center'><b><a class='small' href='".ADMIN."index.php".$ins_aidlink."'><b>".$locale['SYS170']."</b></a></td>
        <td width='25%' class=".($sys_page == "overview" ? "tbl1" : "tbl2")." align='center'><span class='small'>".($sys_page == "overview" ? "<b>".$locale['SYS105']."</b>" : "<a class='small' href='".FUSION_SELF."?pagefile=overview'><b><b>".$locale['SYS105']."</b></a>")."</span></td>
        <td width='25%' class=".(!iSUPERADMIN || iSUPERADMIN && $sys_page == "settings" ? "tbl1" : "tbl2")." align='center'><span class='small'>".(!iSUPERADMIN || iSUPERADMIN && $sys_page == "settings" ? "<b>".$locale['SYS108']."</b>" : "<a class='small' href='".FUSION_SELF."?pagefile=settings'><b>".$locale['SYS108']."</b></a>")."</span></td>
        <td width='25%' class=".($sys_page == "filterlist" ? "tbl1" : "tbl2")." align='center'><span class='small'>".($sys_page == "filterlist" ? "<b>".$locale['SYS107']."</b>" : "<a class='small' href='".FUSION_SELF."?pagefile=filterlist'><b>".$locale['SYS107']."</b></a>")."</span></td>
    </tr>
    <tr>
        <td width='25%' class=".($sys_page == "spamlist" ? "tbl1" : "tbl2")." align='center'><span class='small'>".($sys_page == "spamlist" ? "<b>".$locale['SYS160']."</b>" : "<a class='small' href='".FUSION_SELF."?pagefile=spamlist'><b>".$locale['SYS160']."</b></a>")."</span></td>
        <td width='25%' class=".($sys_page == "logfiles" ? "tbl1" : "tbl2")." align='center'><span class='small'>".($sys_page == "logfiles" ? "<b>".$locale['SYS106']."</b>" : "<a class='small' href='".FUSION_SELF."?pagefile=logfiles'><b>".$locale['SYS106']."</b></a>")."</span></td>
        <td width='25%' class=".($sys_page == "userlocked" ? "tbl1" : "tbl2")." align='center'><span class='small'>".($sys_page == "userlocked" ? "<b>".$locale['SYS154']."</b>" : "<a class='small' href='".FUSION_SELF."?pagefile=userlocked'><b>".$locale['SYS154']."</b></a>")."</span></td>
    </tr><tr><td width='25%' class=".($sys_page == "proxy_white" ? "tbl1" : "tbl2")." align='center'><span class='small'>".($sys_page == "proxy_white" ? "<b>".$locale['PROXY000']."</b>" : "<a class='small' href='".FUSION_SELF."?pagefile=proxy_white'><b>".$locale['PROXY000']."</b></a>")."</span></td>
   <td width='25%' class=".($sys_page == "proxy_black" ? "tbl1" : "tbl2")." align='center'><span class='small'>".($sys_page == "proxy_black" ? "<b>".$locale['PROXY012']."</b>" : "<a class='small' href='".FUSION_SELF."?pagefile=proxy_black'><b>".$locale['PROXY012']."</b></a>")."</span></td>
<td class=".(!iSUPERADMIN || iSUPERADMIN && $sys_page == "update" ? "tbl1" : "tbl2")." align='center'><span class='small'>".(!iSUPERADMIN || iSUPERADMIN && $sys_page == "update" ? "<b>Update</b>" : "<a class='small' href='".FUSION_SELF."?pagefile=update'><b>".$locale["SUBD112"]."</b></a>")."</span></td>
    <tr><td class='tbl1'>&nbsp;</td><td class='tbl1'>&nbsp;</td><td class='tbl1' align='center'><a href='http://docs.bs-fusion.de' target='docs' class='small'><b>".$locale["SYS231"]."</b></a></td></tr></table>";
    closetable();
    tablebreak();
    echo $print_mc_modify;
if (!empty($sys_page) && file_exists(INFUSIONS."security_system/admin/".$sys_page.".php")) {
require_once(INFUSIONS."security_system/admin/".$sys_page.".php");
}
}
else {
if (!empty($_GET['action'])) {
$sys_action=htmlentities($_GET['action']);
}
else {
$sys_action= "";
}

if (!empty($sys_action) && file_exists(INFUSIONS."security_system/admin/".$sys_action.".php")) {
require_once(INFUSIONS."security_system/admin/".$sys_action.".php");
}
readfile(INFUSIONS."security_system/lizenz/lizenz.html");
echo "<form action='".FUSION_SELF."?action=update_system' method='post'>
<center><input class='button' type='submit' name='accept_license' value='".$locale['license_accept']."'>
</center>
</form>";
}
require_once THEMES."templates/footer.php";
?>
