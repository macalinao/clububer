<?php
/*----------------------------------------------+
| SECURITY SYSTEM V1.0 FÜR PHP-FUSION           |
| copyright (c) 2006 by BS-Fusion Deutschland   |
| Email-Support: webmaster[at]bs-fusion.de      |
| Homepage: http://www.bs-fusion.de             |
| Inhaber: Manuel Kurz                          |
+----------------------------------------------*/
require_once "../../maincore.php";
require_once THEMES."templates/header.php";

if (file_exists(INFUSIONS . "security_system/locale/".$settings['locale'].".php")) {
        include INFUSIONS . "security_system/locale/".$settings['locale'].".php";
}
else {
         include INFUSIONS . "security_system/locale/German.php";
}

$check="";
if (isset($_GET['check'])) {
$check=stripinput($_GET['check']);
}
$sys_setting = dbarray(dbquery("SELECT * from ".$db_prefix."secsys_settings"));

$fctime=$sys_setting['fctime'];
$sctime=$sys_setting['sctime'];
$gctime=$sys_setting['gctime'];
$cctime=$sys_setting['cctime'];
$mctime=$sys_setting['mctime'];
$coctime=$sys_setting['coctime'];
$user_lock=$sys_setting['userlock'];
$flood_attempts=$sys_setting['user_attempts'];

function flood_time($flooder) {
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

$flood_stop=0;
if ($user_lock>0 && !iGUEST && !iADMIN) {
  $control_member=dbcount("(c_user_id)",DB_PREFIX."secsys_membercontrol","c_user_id='".$userdata['user_id']."'");
  if ($control_member>0) {
  $rsl=dbarray(dbquery("SELECT * from ".$db_prefix."secsys_membercontrol WHERE c_user_id='".$userdata['user_id']."'"));
  $flood_stop=$rsl['c_flood_count'];
  }
if ($flood_stop>=$flood_attempts) {
          $user_lock = dbquery("UPDATE ".$db_prefix."secsys_membercontrol SET c_userlock='1',c_userlock_datestamp='".time()."' WHERE c_user_id='".$sysdata['user_id']."'");
          $user_lock = dbquery("UPDATE ".$db_prefix."users SET user_status='1' WHERE user_id='".$sysdata['user_id']."'");
          $user_lock = dbquery("UPDATE ".$db_prefix."online SET online_user='0' WHERE online_user='".$sysdata['user_id']."'");
          // Benutzer sofort vom System abmelden
          header("P3P: CP='NOI ADM DEV PSAi COM NAV OUR OTRo STP IND DEM'");
          setcookie("fusion_user", "", time() - 7200, "/", "", "0");
       	  setcookie("fusion_lastvisit", "", time() - 7200, "/", "", "0");
          }
}


opentable($locale['SYS100']);
echo $locale['SYS101']."<br>";
echo "<br><center><b><i>";

switch ($check) {
case "forum":
if (iMEMBER && $user_lock>0 && $flood_stop==$flood_attempts) {
echo "<center><b>".$locale['SYS215']."</b></center>";
}else {
echo sprintf($locale['SYS208'], flood_time($fctime));
}
break;
case "shout":
if (iMEMBER && $sys_setting['userlock']>0 && $flood_stop==$flood_attempts) {
echo "<center><b>".$locale['SYS215']."</b></center>";
} else {
echo sprintf($locale['SYS209'], flood_time($sctime));
}
break;
case "guestbook":
if (iMEMBER && $sys_setting['userlock']>0 && $flood_stop==$flood_attempts) {
echo "<center><b>".$locale['SYS215']."</b></center>";
}
else {
echo sprintf($locale['SYS211'], flood_time($gctime));
}
break;
case "comments":
if (iMEMBER && $sys_setting['userlock']>0 && $flood_stop==$flood_attempts) {
echo "<center><b>".$locale['SYS215']."</b></center>";
}
else {
echo sprintf($locale['SYS210'], flood_time($cctime));
}
break;
case "pm":
if (iMEMBER && $sys_setting['userlock']>0 && $flood_stop==$flood_attempts) {
echo "<center><b>".$locale['SYS215']."</b></center>";
}else {
echo sprintf($locale['SYS212'], flood_time($mctime));
}
break;
case "contact":
if (iMEMBER && $sys_setting['userlock']>0 && $flood_stop==$flood_attempts) {
echo "<center><b>".$locale['SYS215']."</b></center>";
}
else {
echo sprintf($locale['SYS213'], flood_time($coctime));
}
break;
default:
fallback(BASEDIR."index.php");
break;
}
echo "</i></b></center><br>".$locale['SYS207']."<br><br>".$locale['SYS214'];
echo "<meta http-equiv='refresh' content='10; URL=".BASEDIR."index.php'>";
closetable();

require_once THEMES."templates/footer.php";
?>
