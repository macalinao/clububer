<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright � 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: last_seen_users_panel.php
| CVS Version: 1.00
| Author: Shedrock / Xandra
| Adapted for V7 by HobbyMan
| Web: http://www.hobbysites.net/
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
if (!defined("IN_FUSION")) { die("Access Denied"); }

include INFUSIONS."last_seen_users_panel/infusion_db.php";

if (file_exists(INFUSIONS."last_seen_users_panel/locale/".$settings['locale'].".php")) {
	include INFUSIONS."last_seen_users_panel/locale/".$settings['locale'].".php";
} else { include INFUSIONS."last_seen_users_panel/locale/English.php"; }

/*******************************************************************
* Set minimum and maximum number of users you want displayed on each level
*******************************************************************/


$min = 10;	// minimum visible shouts in first level.
$max = 10;	// maximum number of shouts in second level (hidden).
$colors = array(
	103 => "#FF0000",	// User name color for Super Admins
	102 => "#008000",	// User name color for Admins
	101 => "#003366"	// User name color for members
);

/******************************************************************/

echo "<script type='text/javascript'>
<!--
function toggle_lsup() {
	var smu = document.getElementById('show_more_users');
	var smutxt = document.getElementById('show_more_users_text');
	if (smu.style.display == 'none') {
		smu.style.display = 'block';
		smutxt.innerHTML = '".$locale['LSUP_010']."';
	} else {
		smu.style.display = 'none';
		smutxt.innerHTML = '".$locale['LSUP_009']."';
	}
}
//-->
</script>";

opensidex($locale['LSUP_000']);

echo "<table cellpadding='0' cellspacing='0' width='100%'  class=''>";
$result = dbquery("SELECT * FROM ".DB_USERS." ORDER BY user_lastvisit DESC LIMIT ".($min + $max));
if (dbrows($result) != 0) {
	$user_count = 0;
	while ($data = dbarray($result)) {

/*******************************************************************
* Begin show more feature.
********************************************************************/

		if ($user_count == $min) {
			echo "</table>
<br>
<div align='center'>
<img alt='' border='0' src='".THEME."images/bullet.gif'>&nbsp;
<a href=\"javascript:void(0)\" onClick=\"toggle_lsup();\"><span id='show_more_users_text'>".$locale['LSUP_009']."</span></a>&nbsp;
<img alt='' border='0' src='".THEME."images/bulletb.gif'>
</div>
<div id='show_more_users' style='display: none;'>
<br>
<table cellpadding='0' cellspacing='0' width='100%'  class=''>";
			}

/*******************************************************************
* End show more feature.
********************************************************************/

		// Check if user has ever logged in
		if ($data['user_lastvisit'] != 0) {
			$lastseen = time() - $data['user_lastvisit'];
			$iW=sprintf("%2d",floor($lastseen/604800));
			$iD=sprintf("%2d",floor($lastseen/(60*60*24)));
			$iH=sprintf("%02d",floor((($lastseen%604800)%86400)/3600));
			$iM=sprintf("%02d",floor(((($lastseen%604800)%86400)%3600)/60));
			$iS=sprintf("%02d",floor((((($lastseen%604800)%86400)%3600)%60)));
			if ($lastseen < 60){
				$lastseen="".$locale['LSUP_001']."";
			} elseif ($lastseen < 360){
				$lastseen="".$locale['LSUP_002']."";
			} elseif ($iW > 0){
				if ($iW == 1) {
					$Text = $locale['LSUP_003'];
				} else {
					$Text = $locale['LSUP_004'];
				}
				$lastseen = "".$iW." ".$Text."";
			} elseif ($iD > 0){
				if ($iD == 1) {
					$Text = $locale['LSUP_005'];
				} else {
					$Text = $locale['LSUP_006'];
				}
				$lastseen = "".$iD." ".$Text."";
			} else {
				$lastseen = $iH.":".$iM.":".$iS;
			}
		} else {
			$lastseen = $locale['LSUP_007'];
		}
		echo "<tr>
<td class='small' align='left'>
<a href='".BASEDIR."".url("u", $data['user_id'], $data['user_name'])."'><font color='".$colors[$data['user_level']]."' title='".$data['user_name']." | ".getuserlevel($data['user_level'] ? $data['user_level'] : $locale['LSUP_008'], 20)."'>".trimlink ($data['user_name'], 12)."</font></a>
</td>
<td class='small2' align='right'>".$lastseen."</td>
</tr>";
		$user_count ++;
	}
}
echo "</table>";
if ($user_count > $min) { echo "</div>\n"; }

closesidex();
?>