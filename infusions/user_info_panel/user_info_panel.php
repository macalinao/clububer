<?php
/*---------------------------------------------------+
| PHP-Fusion 6 Content Management System
+----------------------------------------------------+
| Copyright ? 2002 - 2007 Nick Jones
| http://www.php-fusion.co.uk/
+----------------------------------------------------+
| Released under the terms & conditions of v2 of the
| GNU General Public License. For details refer to
| the included gpl.txt file or visit http://gnu.org
+----------------------------------------------------+
/*---------------------------------------------------+
| Popup on new PM - v.2.00
+----------------------------------------------------+
| Popup on new PM By Ragsman
| Author: Ragsman
+----------------------------------------------------*/
/*---------------------------------------------------+
| Advanced User Info Panel - v.2.00
+----------------------------------------------------+
| Authors: Shedrock - Fuzed Themes
| Support: http://phpfusion-themes.com
+----------------------------------------------------*/

if (!defined("IN_FUSION")) { header("Location:../../index.php"); exit; }
if (file_exists(INFUSIONS."user_info_panel/locale/".$settings['locale'].".php")) {
	include INFUSIONS."user_info_panel/locale/".$settings['locale'].".php";
} else {
	include INFUSIONS."user_info_panel/locale/English.php";
}

if (iMEMBER) {
	openside($userdata['user_name']);
	$msg_count = dbcount("(message_id)", DB_MESSAGES, "message_to='".$userdata['user_id']."' AND message_read='0'AND message_folder='0'");
	if ($msg_count) echo "<div align='center'><a href='".BASEDIR."messages.html' class='side'><img border='0' alt='".$locale['on108'].$userdata['user_name']."' title='".$locale['on108'].$userdata['user_name']."' src='".INFUSIONS."user_info_panel/images/newpm.gif'></a></div><br>\n";

	echo "<center><a href='".BASEDIR."".url("u", $userdata['user_id'], $userdata['user_name'])."'><b>".$userdata['user_name']."</b></a>, ".$locale['on129']."<br>[<a href='".BASEDIR."messages.html' class='side'><b>".sprintf($locale['on132'], $msg_count).($msg_count == 1 ? $locale['on134'] : $locale['on135'])."</b></a>]<br>".$locale['on130'];

	// Get folder size restrictions (room for future option to restrict number of pm's for a specific user)
	$limit = dbarray(dbquery("SELECT * FROM ".$db_prefix."messages_options WHERE user_id='0'"));
	$limit_inbox = $limit['pm_inbox'];

	// Set display of top bar
//	if ($limit_inbox != "0") { $inbox_display = " <span class='small'>".$locale['on133']." [<b>".$limit_inbox."</b>]</span>"; } else { $inbox_display = " (".$cnt_inbox.")"; }
	echo " <a href='".BASEDIR."messages.html'><b>".$locale['on131']."</b></a>.</center><br>";

	// popup on new PM mod by Ragsman
	if (!isset($_COOKIE['fusion_privmessages'])) {
	$_COOKIE['fusion_privmessages']=0;}
	if ($_COOKIE['fusion_privmessages'] > $msg_count){
	$cookievalue=$msg_count;
	setcookie("fusion_privmessages", "$cookievalue", time() + 3600, "/", "", "0");
}
	if ($_COOKIE['fusion_privmessages'] < $msg_count){
	echo "<script type='text/javascript' language='JavaScript'>window.open('".BASEDIR."privmessages.php','PrivateMessages','toolbar=0,scrollbars=0,menubar=0,resizable=0,width=360,height=230')</script>";
	$cookievalue=$msg_count;
	setcookie("fusion_privmessages", "$cookievalue", time() + 3600, "/", "", "0");
}
	// end popup on new pm

	if ($userdata['user_avatar'] != "") {
	echo "<hr><center><img border='0' alt='".$locale['on106']."' title='".$locale['on106']."' src='".BASEDIR."images/avatars/".$userdata['user_avatar']."'></center><hr>\n";
		} else {
	echo "<br><center><img border='0' alt='".$locale['on107']."' title='".$locale['on107']."' src='".INFUSIONS."user_info_panel/images/noimage.gif'></center><br><hr>\n";
}
	echo "<center>You are carrying <b>".(getusergold($userdata['user_id'], "cash"))."</b> Bux.</center>";
	echo "<span class='small'><b><a href='".BASEDIR."forum/viewforum.php?forum_id=54'>Request a Game</a></b></span><br>";
	echo "<span class='small'><b>".$locale['on103']."</b></span><br>";
	$data = dbarray(dbquery("SELECT user_id,user_name FROM ".$db_prefix."users WHERE user_status='0' ORDER BY user_joined DESC LIMIT 0,1"));
	echo "<span class='small'>- </span> ".$locale['on117']."<a href='".BASEDIR."".url("u", $data['user_id'], $data['user_name'])."' class='side' title='".$data['user_name']."'>".trimlink($data['user_name'],12)."</a><br>
<span class='small'>- </span> ".$locale['on100'].number_format(dbcount("(user_id)", DB_USERS, "user_status<='1'"))."<br><br>
<span class='small'><b>".$locale['on104']."</b></span><br>";
	$cond = ($userdata['user_level'] != 0 ? "'".$userdata['user_id']."'" : "'0' AND online_ip='".USER_IP."'");
	$result = dbquery("SELECT * FROM ".$db_prefix."online WHERE online_user=".$cond."");
	if (dbrows($result) != 0) {
		$result = dbquery("UPDATE ".$db_prefix."online SET online_lastactive='".time()."' WHERE online_user=".$cond."");
	} else {
		$name = ($userdata['user_level'] != 0 ? $userdata['user_id'] : "0");
		$result = dbquery("INSERT INTO ".$db_prefix."online VALUES('$name', '".USER_IP."', '".time()."')");
	}
	$result = dbquery("DELETE FROM ".$db_prefix."online WHERE online_lastactive<".(time()-60)."");
	$result = dbquery("SELECT * FROM ".$db_prefix."online WHERE online_user='0'");
	echo "<span class='small'>- </span> ".$locale['on101'].dbrows($result)."<br>\n";
	$result = dbquery(
		"SELECT ton.*, user_id,user_name FROM ".$db_prefix."online ton
		LEFT JOIN ".$db_prefix."users tu ON ton.online_user=tu.user_id
		WHERE online_user!='0'"
	);

	$members = dbrows($result);
	if ($members != 0) {
		$i = 1;
	echo "<span class='small'>- </span> <b>".$locale['on102']."</b>";
		while($data = dbarray($result)) {
	echo "<a href='".BASEDIR."".url("u", $data['user_id'], $data['user_name'])."' class='side' title='".$data['user_name']."'>".trimlink($data['user_name'],12)."</a>";
	if ($i != $members) echo ", ";
			$i++;
		}
	echo "<br><br>\n";
	} else {
	echo $locale['on118']."<br><br>\n";
}

	echo "<span class='small'><b>".$locale['on105']."</b></span><br>
<span class='small'>- </span> <a href='".BASEDIR."edit_profile.html' class='side'>".$locale['on119']."</a><br>
<span class='small'>- </span> <a href='".BASEDIR."messages.html' class='side'>".$locale['on120']."</a><br>
<span class='small'>- </span> <a href='".BASEDIR."users.html' class='side'>".$locale['on121']."</a><br>
<span class='small'>- </span> <a href='".BASEDIR."logout.html' class='side'>".$locale['on113']."</a><br>\n";

if (iADMIN && (iUSER_RIGHTS != "" || iUSER_RIGHTS != "C")) {
	echo "<br><span class='small'><b>".$locale['on109']."</b></span><br>
<span class='small'>-</span> <a href='".ADMIN."index.php".$aidlink."' class='side'>".$locale['on110']."</a><br>
<span class='small'>-</span> <a href='".BASEDIR."administration/news.php".$aidlink."' class='side'>".$locale['on111']."</a><br>
<span class='small'>-</span> <a href='".BASEDIR."administration/articles.php".$aidlink."' class='side'>".$locale['on112']."</a><br>\n";
	}
} else {
	openside($locale['on122']);
	echo "<div align='center'>".(isset($loginerror) ? $loginerror : "")."<form name='loginform' method='post' action='".FUSION_SELF."'>".$locale['on123']."<br>
<input type='text' name='user_name' class='textbox' style='width:100px'><br>".$locale['on124']."<br>
<input type='password' name='user_pass' class='textbox' style='width:100px'><br>
<input type='checkbox' name='remember_me' value='y' title='".$locale['on125']."' style='vertical-align:middle;'>
<input type='submit' name='login' value='".$locale['on126']."' class='button'><br></form><br>\n";
if ($settings['enable_registration']) {
	echo "".$locale['on127']."<br><br>\n";
	}
	echo $locale['on128']."</div><br><br>\n";
}

$theme_list = makefilelist(THEMES, ".|..|templates", true, "folders");
array_unshift($theme_list, "Default");
natcasesort($theme_list);
$theme_list = array_filter($theme_list, "simple_theme_exists");

if (isset($_POST['ts_theme']) and in_array($_POST['ts_theme'], $theme_list)){
	if(iMEMBER){
		$result = dbquery("UPDATE ".DB_PREFIX."users SET user_theme='".$_POST['ts_theme']."' WHERE user_id='".$userdata['user_id']."'");
	}else{
		var_dump(setcookie("v7_themeswitcher", $_POST['ts_theme'], time() + 3600 * 24 * 30, "/", "", "0"));
	}
	redirect(FUSION_REQUEST);
}
if (USERGOLD && GLD_THEME_SELECT) {
echo "
<form method='post' action='".str_replace("&","&amp;",FUSION_REQUEST)."' style='text-align:center;'>
	Theme:<br />
	 <select id='ts_theme' name='ts_theme' class='textbox'> ";
		$current_theme = empty($userdata['user_theme']) ? $_COOKIE['v7_themeswitcher'] : $userdata['user_theme'];
		foreach ($theme_list as $theme_element)
		{
			echo "
			<option value='".$theme_element."'".($theme_element == $current_theme ? " selected='selected'" : "").">$theme_element</option>\n";
		}
	
	  echo "
	</select>
	<input type='submit' class='button' value='Go!' id='themeswitcher_submit'/>
</form>";
echo '<script type="text/javascript">
	$("#themeswitcher_submit").hide();
	$("#ts_theme").change(function(){
		$(this).parent().submit();
	});
</script>';
}
closeside();
?>