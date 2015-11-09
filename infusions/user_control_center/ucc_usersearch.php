<?php

/*---------------------------------------------------+
| PHP-Fusion 6 Content Management System
+----------------------------------------------------+
| Copyright � 2002 - 2005 Nick Jones
| http://www.php-fusion.co.uk/
+----------------------------------------------------+
| Released under the terms & conditions of v2 of the
| GNU General Public License. For details refer to
| the included gpl.txt file or visit http://gnu.org
+----------------------------------------------------*
| User Control Center made by:
| Sebastian "slaughter" Sch�ssler
| http://basti2web.de
| Version 2.30
+----------------------------------------------------*/

// Check Rights
if (!defined("IN_FUSION")) { die("Access Denied"); }
if (!defined("IN_UCC")) { redirect("index.php"); }
if (!defined("iAUTH") || $_GET['aid'] != iAUTH) { redirect("index.php"); }
//if (!defined("UCC_ADMIN") || !UCC_ADMIN) { redirect("index.php"); }

opentable($locale['ucc_800']);

if (file_exists(INFUSIONS."user_control_center/locale/".$settings['locale']."/user_fields.php")) {
include INFUSIONS."user_control_center/locale/".$settings['locale']."/user_fields.php";
} else {
include INFUSIONS."user_control_center/locale/English/user_fields.php";
}

if (file_exists(INFUSIONS."user_control_center/locale/".$settings['locale']."/members.php")) {
include INFUSIONS."user_control_center/locale/".$settings['locale']."/members.php";
} else {
include INFUSIONS."user_control_center/locale/English/members.php";
}

if (!isset($stext)) $stext = isset($_POST['stext']) ? $_POST['stext'] : "";
if (!isset($stype)) $stype = isset($_POST['stype']) ? $_POST['stype'] : "user_name";
if (!isset($ssort)) $ssort = isset($_POST['ssort']) ? $_POST['ssort'] : "user_name";
if (!isset($sort)) $sort = isset($_POST['sort']) ? $_POST['sort'] : " ";
if (!isset($eus_limit)) $eus_limit = isset($_POST['eus_limit']) ? $_POST['eus_limit'] : "1000";
if (isset($_GET['go_search'])) { $go_search = stripinput($_GET['go_search']); } else { $go_search = "presearch"; }

if ($eus_limit < 1) $eus_limit = "1000";

$ch_email = isset($_POST['td_email']) ? " checked" : "";
$ch_location = isset($_POST['td_location']) ? " checked" : "";
$ch_birthdate = isset($_POST['td_birthdate']) ? " checked" : "";
$ch_aim = isset($_POST['td_aim']) ? " checked" : "";
$ch_icq = isset($_POST['td_icq']) ? " checked" : "";
$ch_msn = isset($_POST['td_msn']) ? " checked" : "";
$ch_yahoo = isset($_POST['td_yahoo']) ? " checked" : "";
$ch_web = isset($_POST['td_web']) ? " checked" : "";
$ch_theme = isset($_POST['td_theme']) ? " checked" : "";
$ch_sig = isset($_POST['td_sig']) ? " checked" : "";
$ch_ip = isset($_POST['td_ip']) ? " checked" : "";
$ch_joined = isset($_POST['td_joined']) ? " checked" : "";
$ch_lastvisit = isset($_POST['td_lastvisit']) ? " checked" : "";
$ch_options = isset($_POST['td_options']) ? " checked" : "";

echo "<form name='usersearch' method='post' action='".FUSION_SELF.$aidlink."&section=usersearch&go_search=run'>
<table align='center' cellpadding='0' cellspacing='1' width='500' class='tbl-border'>
<tr>
<td class='tbl1' align='right'>".$locale['ucc_820'].":</td>
<td class='tbl2'>
<input type='text' name='stext' value='$stext' class='textbox' style='width:150px'>
<select class='textbox' name='stype'>
<option ".($stype == "user_name" ? "selected" : "")." value='user_name'>".str_replace(":","",$locale['u001'])."</option>
<option ".($stype == "user_email" ? "selected" : "")." value='user_email'>".str_replace(":","",$locale['u005'])."</option>
<option ".($stype == "user_location" ? "selected" : "")." value='user_location'>".str_replace(":","",$locale['u009'])."</option>
<option ".($stype == "user_birthdate" ? "selected" : "")." value='user_birthdate'>".str_replace(":","",$locale['u010'])."</option>
<option ".($stype == "user_aim" ? "selected" : "")." value='user_aim'>".str_replace(":","",$locale['u021'])."</option>
<option ".($stype == "user_icq" ? "selected" : "")." value='user_icq'>".str_replace(":","",$locale['u011'])."</option>
<option ".($stype == "user_msn" ? "selected" : "")." value='user_msn'>".str_replace(":","",$locale['u012'])."</option>
<option ".($stype == "user_yahoo" ? "selected" : "")." value='user_yahoo'>".str_replace(":","",$locale['u013'])."</option>
<option ".($stype == "user_web" ? "selected" : "")." value='user_web'>".str_replace(":","",$locale['u014'])."</option>
<option ".($stype == "user_sig" ? "selected" : "")." value='user_sig'>".str_replace(":","",$locale['u020'])."</option>
<option ".($stype == "user_theme" ? "selected" : "")." value='user_theme'>".str_replace(":","",$locale['u015'])."</option>
<option ".($stype == "user_ip" ? "selected" : "")." value='user_ip'>".$locale['ucc_821']."</option>
</select>
</td></tr><tr>
<td class='tbl2' align='right'>".$locale['ucc_822'].":</td>
<td class='tbl1'>
<select class='textbox' name='ssort'>
<option ".($ssort == "user_name" ? "selected" : "")." value='user_name'>".str_replace(":","",$locale['u001'])."</option>
<option ".($ssort == "user_email" ? "selected" : "")." value='user_email'>".str_replace(":","",$locale['u005'])."</option>
<option ".($ssort == "user_location" ? "selected" : "")." value='user_location'>".str_replace(":","",$locale['u009'])."</option>
<option ".($ssort == "user_birthdate" ? "selected" : "")." value='user_birthdate'>".str_replace(":","",$locale['u010'])."</option>
<option ".($ssort == "user_aim" ? "selected" : "")." value='user_aim'>".str_replace(":","",$locale['u021'])."</option>
<option ".($ssort == "user_icq" ? "selected" : "")." value='user_icq'>".str_replace(":","",$locale['u011'])."</option>
<option ".($ssort == "user_msn" ? "selected" : "")." value='user_msn'>".str_replace(":","",$locale['u012'])."</option>
<option ".($ssort == "user_yahoo" ? "selected" : "")." value='user_yahoo'>".str_replace(":","",$locale['u013'])."</option>
<option ".($ssort == "user_web" ? "selected" : "")." value='user_web'>".str_replace(":","",$locale['u014'])."</option>
<option ".($ssort == "user_theme" ? "selected" : "")." value='user_theme'>".str_replace(":","",$locale['u015'])."</option>
<option ".($ssort == "user_ip" ? "selected" : "")." value='user_ip'>".$locale['ucc_821']."</option>
<option ".($ssort == "user_id" ? "selected" : "")." value='user_id'>".$locale['ucc_823']."</option>
<option ".($ssort == "user_joined" ? "selected" : "")." value='user_joined'>".str_replace(":","",$locale['u040'])."</option>
<option ".($ssort == "user_lastvisit" ? "selected" : "")." value='user_lastvisit'>".str_replace(":","",$locale['u044'])."</option>
</select> - <select class='textbox' name='sort'>
<option ".($sort == " " ? " selected" : "")." value=' '>".$locale['ucc_824']."</option>
<option ".($sort == "DESC" ? " selected" : "")." value='DESC'>".$locale['ucc_825']."</option>
</select>
</td></tr><tr>
<td class='tbl1' align='right'>".$locale['ucc_826'].":</td>
<td class='tbl2'><input type='text' name='eus_limit' value='$eus_limit' class='textbox' style='width:50px;'>
</td></tr><tr>
<td class='tbl1' align='left' colspan='2'>
<i>".$locale['ucc_827'].": %<br>
".$locale['ucc_828']."</i>
</td></tr></table>

<br><br>
<table align='center' cellpadding='0' cellspacing='1' width='500' class='tbl-border'>
<tr><td class='tbl2' colspan='3'>".$locale['ucc_829']."</td></tr>
<tr>
<td class='tbl1' width='33%'><input type='checkbox' name='td_id' value='yes' checked disabled> ".str_replace(":","",$locale['ucc_823'])."</td>
<td class='tbl2' width='33%'><input type='checkbox' name='td_user' value='yes' checked disabled> ".str_replace(":","",$locale['u001'])."</td>
<td class='tbl1' width='34%'><input type='checkbox' name='td_email' value='yes'".$ch_email."> ".str_replace(":","",$locale['u005'])."</td>
</tr><tr>
<td class='tbl2'><input type='checkbox' name='td_location' value='yes'".$ch_location."> ".str_replace(":","",$locale['u009'])."</td>
<td class='tbl1'><input type='checkbox' name='td_birthdate' value='yes'".$ch_birthdate."> ".str_replace(":","",$locale['u010'])."</td>
<td class='tbl2'><input type='checkbox' name='td_aim' value='yes'".$ch_aim."> ".str_replace(":","",$locale['u021'])."</td>
</tr><tr>
<td class='tbl1'><input type='checkbox' name='td_icq' value='yes'".$ch_icq."> ".str_replace(":","",$locale['u011'])."</td>
<td class='tbl2'><input type='checkbox' name='td_msn' value='yes'".$ch_msn."> ".str_replace(":","",$locale['u012'])."</td>
<td class='tbl1'><input type='checkbox' name='td_yahoo' value='yes'".$ch_yahoo."> ".str_replace(":","",$locale['u013'])."</td>
</tr><tr>
<td class='tbl2'><input type='checkbox' name='td_web' value='yes'".$ch_web."> ".str_replace(":","",$locale['u014'])."</td>
<td class='tbl1'><input type='checkbox' name='td_theme' value='yes'".$ch_theme."> ".str_replace(":","",$locale['u015'])."</td>
<td class='tbl2'><input type='checkbox' name='td_sig' value='yes'".$ch_sig."> ".str_replace(":","",$locale['u020'])."</td>
</tr><tr>
<td class='tbl1'><input type='checkbox' name='td_ip' value='yes'".$ch_ip."> ".$locale['ucc_821']."</td>
<td class='tbl2'><input type='checkbox' name='td_joined' value='yes'".$ch_joined."> ".str_replace(":","",$locale['u040'])."</td>
<td class='tbl1'><input type='checkbox' name='td_lastvisit' value='yes'".$ch_lastvisit."> ".str_replace(":","",$locale['u044'])."</td>
</tr>";
if (checkrights("M") or defined("iAUTH")) {
	echo "<tr>
	<td class='tbl2' colspan='3'>".$locale['ucc_830']."</td></tr><tr>
	<td class='tbl1' colspan='3'><input type='checkbox' name='td_options' value='yes'".$ch_options."> ".$locale['ucc_831']."</td>
	</tr>";	
}
echo "</table>
<br><br>
<center><input type='submit' class='button' value='".$locale['ucc_832']."'></center>
<br></form>";

if ($stext != "" AND $go_search == "run") {
 closetable();
 tablebreak();
 opentable($locale['ucc_835']);

/* ---
$result = dbquery("SELECT * FROM ".$db_prefix."users WHERE ".$stype." LIKE '%$stext%' ORDER BY ".$ssort." ".$sort);

$allrows = dbrows($result);if ($rows % $eus_limit){$rows = $rows - 1;}




   if ($allrows > $eus_limit) echo "<div align='center' style='margin-top:5px;'>\n".makePageNav($rowstart,$eus_limit,$allrows,3,FUSION_SELF.$aidlink."&section=usersearch&go_search=run&")."\n</div><br />\n";

change end
*/


$rows = dbcount("(user_id)", DB_USERS, "".$stype." LIKE '%$stext%'");
		if ($rows != 0) {
			echo "<div style='overflow:auto'>
			<table cellpadding='0' cellspacing='1' class='tbl-border' align='center' border='0'>
			<tr>";
			if ((checkrights("M") or defined("iAUTH")) && $ch_options == " checked") echo "<td class='tbl2' align='center'>".str_replace(" ","&nbsp;",$locale['ucc_831'])."</td>\n";
			echo "<td class='tbl2' align='center'>ID</td><td class='tbl2' align='center'>".str_replace(":","",$locale['u001'])."</td>\n";
			if ($ch_email == " checked") echo "<td class='tbl2' align='center'>".str_replace(":","",$locale['u005'])."</td>\n";
			if ($ch_location == " checked") echo "<td class='tbl2' align='center'>".str_replace(":","",$locale['u009'])."</td>\n";
			if ($ch_birthdate == " checked") echo "<td class='tbl2' align='center'>".str_replace(":","",$locale['u010'])."</td>\n";
			if ($ch_aim == " checked") echo "<td class='tbl2' align='center'>".str_replace(":","",$locale['u021'])."</td>\n";
			if ($ch_icq == " checked") echo "<td class='tbl2' align='center'>".str_replace(":","",$locale['u011'])."</td>\n";
			if ($ch_msn == " checked") echo "<td class='tbl2' align='center'>".str_replace(":","",$locale['u012'])."</td>\n";
			if ($ch_yahoo == " checked") echo "<td class='tbl2' align='center'>".str_replace(":","",$locale['u013'])."</td>\n";
			if ($ch_web == " checked") echo "<td class='tbl2' align='center'>".str_replace(":","",$locale['u014'])."</td>\n";
			if ($ch_theme == " checked") echo "<td class='tbl2' align='center'>".str_replace(":","",$locale['u015'])."</td>\n";
			if ($ch_sig == " checked") echo "<td class='tbl2' align='center'>".str_replace(":","",$locale['u020'])."</td>\n";
			if ($ch_ip == " checked") echo "<td class='tbl2' align='center'>".$locale['ucc_821']."</td>\n";
			if ($ch_joined == " checked") echo "<td class='tbl2' align='center'>".str_replace(":","",$locale['u040'])."</td>\n";
			if ($ch_lastvisit == " checked") echo "<td class='tbl2' align='center'>".str_replace(":","",$locale['u044'])."</td>\n";
						echo "</tr><tr>";



/*
$result = dbquery("SELECT * FROM ".$db_prefix."users WHERE ".$stype." LIKE '%$stext%' ORDER BY ".$ssort." ".$sort." LIMIT ".$rowstart.",".$eus_limit."");
*/
$result = dbquery("SELECT * FROM ".DB_USERS." WHERE ".$stype." LIKE '%$stext%' ORDER BY ".$ssort." ".$sort." LIMIT 0,".$eus_limit."");
//---


			while ($data = dbarray($result)) {
				$cell_color = ($i % 2 == 0 ? "tbl1" : "tbl2"); $i++;
				if ((checkrights("M") or defined("iAUTH")) && $ch_options == " checked") { 
					echo "<td class='".$cell_color."' align='center'>";
					if (iUSER >= $data['user_level'] && $data['user_id'] != 1) {
					 $sortby = ''; // Notice-Fix... Think about it, if there is a misstake!
						echo "<a href='".ADMIN."members.php".$aidlink."&amp;step=edit&amp;user_id=".$data['user_id']."'>".str_replace(" ","&nbsp;",$locale['406'])."</a>&nbsp;";
						if ($data['user_status'] == "2") {
							echo "-&nbsp;<a href='".ADMIN."members.php".$aidlink."&amp;step=activate&amp;sortby=$sortby&amp;rowstart=$rowstart&amp;user_id=".$data['user_id']."'>".str_replace(" ","&nbsp;",$locale['412'])."</a>&nbsp;";
						} elseif ($data['user_status'] == "1") {
							echo "-&nbsp;<a href='".ADMIN."members.php".$aidlink."&amp;step=ban&amp;act=off&amp;sortby=$sortby&amp;rowstart=$rowstart&amp;user_id=".$data['user_id']."'>".str_replace(" ","&nbsp;",$locale['407'])."</a>&nbsp;";
						} else {
							echo "-&nbsp;<a href='".ADMIN."members.php".$aidlink."&amp;step=ban&amp;act=on&amp;sortby=$sortby&amp;rowstart=$rowstart&amp;user_id=".$data['user_id']."'>".str_replace(" ","&nbsp;",$locale['408'])."</a>\n";
						}
						echo "-&nbsp;<a href='".ADMIN."members.php".$aidlink."&amp;step=delete&amp;sortby=$sortby&amp;rowstart=$rowstart&amp;user_id=".$data['user_id']."' onClick='return DeleteMember();'>".str_replace(" ","&nbsp;",$locale['409'])."</a>";
					}
				}			
				echo "</td>
				<td class='".$cell_color."' align='center'>".$data['user_id']."</td>\n
                                <td class='".$cell_color."'><a href='".BASEDIR."profile.php?lookup=".$data['user_id']."'>".$data['user_name']."</a></td>\n";
				if ($ch_email == " checked") echo "<td class='".$cell_color."' align='center'>".$data['user_email']."</td>\n";
				if ($ch_location == " checked") echo "<td class='".$cell_color."' align='center'>".$data['user_location']."</td>\n";
				if ($ch_birthdate == " checked") { 
					echo "<td class='".$cell_color."' align='center'>";
					if ($data['user_birthdate'] != "0000-00-00") echo $data['user_birthdate'];
					echo "</td>\n";
				}
				if ($ch_aim == " checked") echo "<td class='".$cell_color."' align='center'>".$data['user_aim']."</td>\n";
				if ($ch_icq == " checked") echo "<td class='".$cell_color."' align='center'>".$data['user_icq']."</td>\n";
				if ($ch_msn == " checked") echo "<td class='".$cell_color."' align='center'>".$data['user_msn']."</td>\n";
				if ($ch_yahoo == " checked") echo "<td class='".$cell_color."' align='center'>".$data['user_yahoo']."</td>\n";
				if ($ch_web == " checked") echo "<td class='".$cell_color."' align='center'>".$data['user_web']."</td>\n";
				if ($ch_theme == " checked") echo "<td class='".$cell_color."' align='center'>".$data['user_theme']."</td>\n";
				if ($ch_sig == " checked") echo "<td class='".$cell_color."' align='center'>".nl2br(parseubb($data['user_sig']))."</td>\n";
				if ($ch_ip == " checked") echo "<td class='".$cell_color."' align='center'>".$data['user_ip']."</td>\n";
				if ($ch_joined == " checked") echo "<td class='".$cell_color."' align='center'>".showdate(str_replace(" ","&nbsp;","%Y.%m.%d %H:%M"), $data['user_joined'])."</td>\n";
				if ($ch_lastvisit == " checked") {echo "<td class='".$cell_color."' align='center'>";
					if ($data['user_lastvisit'] != 0)				
					{ echo showdate("shortdate",$data['user_lastvisit']);} 
                                get_lavi($data['user_lastvisit'],$locale);
                                echo "</td>\n";}
				echo "</tr>\n";
			}
			echo "</table></div>";


		} else {
			echo "<center>".$locale['ucc_834'].".</center>\n";
		}

echo "<script type='text/javascript'>
function DeleteMember(username) {
	return confirm('".$locale['423']."');
}
</script>\n";
} else if ($go_search == "run" AND $stext == ""){
  opentable($locale['ucc_835']);
  echo "<center>".$locale['ucc_833']."!!</center>"; }

	
?>