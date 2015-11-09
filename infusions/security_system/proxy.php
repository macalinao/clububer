<?php
/*---------------------------------------------------+
| PHP-Fusion 6 Content Management System
+----------------------------------------------------+
| Copyright © 2002 - 2006 Nick Jones
| http://www.php-fusion.co.uk/
+----------------------------------------------------+
| Released under the terms & conditions of v2 of the
| GNU General Public License. For details refer to
| the included gpl.txt file or visit http://gnu.org
+----------------------------------------------------*/
require_once("../../maincore.php");
require_once THEMES."templates/header.php";

function secsys_change_lng($lang='de') {
if ($lang=="de") {
return "german";

}	
if ($lang=="en"){
return "english";
	
} else {
return "german";		
}
}

$slng=isset($_GET['lng']) ? secsys_change_lng(stripinput($_GET['lng'])) : secsys_change_lng("de");

if (file_exists(INFUSIONS."security_system/locale/proxy_".$slng.".php")) {
require_once(INFUSIONS."security_system/locale/proxy_".$slng.".php");	
} else {
require_once(INFUSIONS."security_system/locale/proxy_german.php");
}

$sys_siteurl=$settings['siteurl'];
$sys_siteurl2 = str_replace("www.","",$settings['siteurl']);
if (!sec_proxyscan() && !FREE_PROXY || iSYS_SUPERADMIN) {
$entry_error="";
$entry_ok="";
if (!empty($_POST) && isset($_POST['pentry']) && TRUE_REFERER) {
if (eregi($sys_siteurl,SYS_USER_REFERER) || eregi($sys_siteurl2,SYS_USER_REFERER)) {
$reaccept= isset($_POST['reaccept']) ? $_POST['reaccept'] : 0;
$newproxy= isset($_POST['newproxy']) ? htmlentities($_POST['newproxy']) : "";
if ($reaccept>0) {
   $entry_count=dbcount("(*)",DB_PREFIX."secsys_proxy_whitelist","proxy_ip='$newproxy'");
   if ($entry_count>0) {
   $entry_error=$locale["PR08"];
   } else {
   $entry_insert=dbquery("INSERT INTO {$db_prefix}secsys_proxy_whitelist (proxy_ip, proxy_datestamp) VALUES('$newproxy','".time()."')");
   if ($entry_insert) {
   $entry_ok=$locale["PR07"];
   } else {
   $entry_error=$locale["PR06"];
   }
   }
}
else {
$entry_error=$locale["PR05"];
}
}
} 

opentable($locale["PR01"]);
echo "<center><a href='".FUSION_SELF."?lng=de'><img src='".SEC_INFDIR."images/flag-deu.png' border='0' alt='Deutsch' title='Deutsch'></a> <a href='".FUSION_SELF."?lng=en'><img src='".SEC_INFDIR."images/flag-eng.png' border='0' alt='English' title='English'></a></center><br>";
if (!empty($_POST) && $entry_error!="") { 
echo "<div class='quote'>".$entry_error."</div><br>";
}
if (!isset($_POST['pentry'])) {
echo $locale["PR02"];
echo "<form action='".FUSION_SELF.(FUSION_QUERY!="" ? "?".rawurldecode((FUSION_QUERY)) : "")."' method='post'>
<input type='hidden' name='newproxy' value='".USER_IP."'>".$locale['PR09'].": ".USER_IP."<br>
<input type='checkbox' name='reaccept' value='1'>".$locale['PR03']."<br>
 <input type='submit' value='".$locale['PR04']."' name='pentry' class='button'></form>";
}
elseif (empty($entry_error)) {
echo $entry_ok;
}

closetable();
}
else {
fallback(BASEDIR."index.php");
}

require_once THEMES."templates/footer.php";
?>