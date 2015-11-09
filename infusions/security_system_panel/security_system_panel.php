<?php
#################################################
# SECURITY SYSTEM V1.2 FÜR PHP-FUSION           #
# copyright (c) 2006 by BS-Fusion Deutschland   #
# Email-Support: webmaster[at]bs-fusion.de      #
# Homepage: http://www.bs-fusion.de             #
# Inhaber: Manuel Kurz                          #
#################################################
if (!defined("IN_FUSION")) { header("Location: ../../index.php"); exit; }
if (!function_exists('check_infusion')) {
echo "<div style='color:#c00000;' align='center'><b>Die maincore.php wurde geändert!<br>Bitte füge das Security System lt. Online Dokumentation wieder ein.<hr>The maincore.php was modify.<br>Please read the online documentation and modify your maincore.php again!</b></div>";
}
else {
if (check_infusion("security_system")) {
if (file_exists(INFUSIONS . "security_system/locale/".$settings['locale'].".php")) {
	include INFUSIONS . "security_system/locale/".$settings['locale'].".php";
}
else {
 	include INFUSIONS . "security_system/locale/German.php";
}
$result=dbarray(dbquery("SELECT * FROM ".DB_PREFIX."secsys_settings"));
$view_art=$result['panel_set'];
$sys_version=$result['version'];
$counts=dbarray(dbquery("SELECT * FROM ".DB_PREFIX."secsys_statistics"));
$count_hacks=$counts['hacks'];
$count_floods=$counts['floods'];
$count_blocks=$counts['blocks'];
$count_spams=$counts['spams'];
$proxy_visit=$counts['proxy_visit'];
$proxy_register=$counts['proxy_register'];
$proxy_login=$counts['proxy_login'];
  if($view_art > 3 && $view_art < 8)
    {
    // Counterfiles
    $count_value = $count_hacks+$count_floods+$count_blocks+$count_spams+$proxy_visit+$proxy_register+$proxy_login;
    }

  $secsys_panel = "<span class='small'>";
  $secsys_minipic = "<a class='small' href='http://www.bs-fusion.de' target='_blank'>
  <img src='".INFUSIONS."security_system/images/bs_mini.jpg' border='0' alt='Security System ".$sys_version." © 2006 by BS-Fusion Deutschland' title='Security System ".$sys_version." © 2006 by BS-Fusion Deutschland'></a>";
  $secsys_miniimg = "<a class='small' href='http://www.bs-fusion.de' target='_blank'>
  <img src='" . INFUSIONS."security_system/images/small_security_logo.jpg' border='0' alt='Security System ".$sys_version." © 2006 by BS-Fusion Deutschland' title='Security System ".$sys_version." © 2006 by BS-Fusion Deutschland'></a>";
  $secsys_minipic2 = "<a class='small' href='http://www.bs-fusion.de' target='_blank'>
  <img src='".INFUSIONS."security_system/images/secure_mini.gif' border='0' alt='Security System ".$sys_version." © 2006 by BS-Fusion Deutschland' title='Security System ".$sys_version." © 2006 by BS-Fusion Deutschland'></a>";

  // Generate Footer
  switch($view_art)
  {
    case 1:
      $secsys_panel .= $secsys_minipic;
      break;
    case 2:
      $secsys_panel .= $secsys_minipic2;
      break;
    case 3:
    $secsys_panel .= $secsys_miniimg;
    break;
    case 4:
      $secsys_panel .= $secsys_minipic . "<br clear='all'>" . sprintf($locale['SYS302'], $count_value);
      break;
    case 5:
      $secsys_panel .= $secsys_minipic2 . "<br clear='all'>" . sprintf($locale['SYS302'], $count_value);
      break;
     case 6:
      $secsys_panel .= $secsys_miniimg . "<br clear='all'>" . sprintf($locale['SYS302'], $count_value);
      break;
    case 7:
      $secsys_panel .= sprintf($locale['SYS301'], $count_value);
      break;
    case 8:
      $secsys_panel .= $locale['SYS300'];
    break;
    case 9:
      $secsys_panel .= $secsys_minipic."<br clear='all'>".$locale['SYS300'];
    break;
    case 10:
      $secsys_panel .= $secsys_minipic2."<br clear='all'>".$locale['SYS300'];
    break;
    case 11:
    $secsys_panel .= $secsys_miniimg."<br clear='all'>".$locale['SYS300'];
    break;

    default:
    $secsys_panel .= $secsys_minipic;
    break;
  }
if ($result['license_accept']>0) {
echo "<center>$secsys_panel</center>\n";
}
}
}
?>
