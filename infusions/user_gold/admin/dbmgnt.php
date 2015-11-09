<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| User Gold 3
| Copyright © 2007 - 2008 UG3 Developement Team
| http://www.starglowone.com/
+--------------------------------------------------------+
| Filename: dbmgnt.php
| Author: UG3 Developement Team
+--------------------------------------------------------+
| This program is released as free software under the
| Stars Heaven Licence. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included licence.html.
| Removal of this copyright header is strictly
| prohibited without written permission
| from the original author(s).
+--------------------------------------------------------*/
if (!defined("IN_FUSION")) { die("Access Denied"); }

if (file_exists(GOLD_LANG.LOCALESET."admin/dbmgnt.php")) {
	include GOLD_LANG.LOCALESET."admin/dbmgnt.php";
} else {
	include GOLD_LANG."English/admin/dbmgnt.php";
}

function deluserquestion() {
	global $locale, $aidlink;
	global $HTTP_POST_VARS, $userdata, $ug3_install,$locale, $settings, $golddata;
	opentable($locale['urg_a_dbmgnt_100']);
	echo "<div>".$locale['urg_a_dbmgnt_101']."<br /><br /><span style='color: red;'>".$locale['urg_a_dbmgnt_102']."</span></div>\n";
	echo "<div align='center'>\n<form action='index.php".$aidlink."' method='post'>\n";
	echo "<input type='hidden' name='op' value='delusersaction' />\n";
	echo $locale['urg_a_dbmgnt_103']." <input type='checkbox' name='delusers' value='1' />\n";
	echo "<hr />\n";
	echo "<input type='submit' value='".$locale['urg_a_dbmgnt_104']."' class='button' />\n";
	echo "<input type='submit' name='cancel' value='".$locale['urg_a_dbmgnt_105']."' class='button' />\n";
	echo "</form>\n</div>\n";
	closetable();
}

function delusersaction() {
	global $locale;
	opentable($locale['urg_a_dbmgnt_106']);
	if(isset($_POST['delusers']) && $_POST['delusers'] =='1') {			
		$sql = dbquery("SELECT * FROM ".DB_UG3." WHERE owner_id NOT IN (SELECT user_id FROM ".DB_USERS.")");
		if (dbrows($sql) != 0) { //If this member doesn't exist
			opentable($locale['urg_a_dbmgnt_106']);
			while ($data = dbarray($sql)) {
				$deluser = dbquery("DELETE FROM ".DB_UG3." WHERE owner_id = '".$data['owner_id']."'");
				if($deluser) {
					echo "<span style='color: green;'>".sprintf($locale['urg_a_dbmgnt_109'],$data['owner_name'],$data['owner_id'])."</span><br />\n";
				} else {
					echo "<span style='color: red;'>".sprintf($locale['urg_a_dbmgnt_110'],$data['owner_name'],$data['owner_id'])."</span><br />\n";
				}
			}//end
			closetable();
			
			opentable($locale['urg_a_dbmgnt_107']);		
			$sql2 = dbquery("SELECT * FROM ".DB_UG3_INVENTORY." WHERE ownerid NOT IN (SELECT user_id FROM ".DB_USERS.")");
			while ($data2 = dbarray($sql2)) {
				$delinv = dbquery("DELETE FROM ".DB_UG3_INVENTORY." WHERE ownerid = '".$data2['ownerid']."'");
				if($delinv) {
					echo "<span style='color: green;'>".sprintf($locale['urg_a_dbmgnt_111'],$data2['itemname'],$data2['ownerid'])."</span><br />\n";
				} else {
					echo "<span style='color: red;'>".sprintf($locale['urg_a_dbmgnt_112'],$data2['itemname'],$data2['ownerid'])."</span><br />\n";
				}
			}//end
			closetable();
			
			opentable($locale['urg_a_dbmgnt_108']);		
			$sql3 = dbquery("SELECT * FROM ".DB_UG3_TRANSACTIONS." WHERE transaction_user_id NOT IN (SELECT user_id FROM ".DB_USERS.")");
			while ($data3 = dbarray($sql3)) {
				$deltrans = dbquery("DELETE FROM ".DB_UG3_TRANSACTIONS." WHERE transaction_user_id = '".$data3['transaction_user_id']."'");
				if($deltrans) {
					echo "<span style='color: green;'>".sprintf($locale['urg_a_dbmgnt_113'],$data3['transaction_id'],$data3['transaction_user_id'])."</span><br />\n";
				} else {
					echo "<span style='color: red;'>".sprintf($locale['urg_a_dbmgnt_114'],$data3['transaction_id'],$data3['transaction_user_id'])."</span><br />\n";
				}
			}//end
			closetable();
		} else {
			opentable($locale['urg_a_dbmgnt_115']);
				echo "<div>".$locale['urg_a_dbmgnt_115']."</div>\n";
			closetable;
		}
	} else {
	echo "<div>".$locale['urg_a_dbmgnt_116']."</div>\n";
	}
	closetable;
}
?>