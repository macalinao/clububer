<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright � 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| User Control Center 2.42a
| Author: Sebastian Sch�ssler (slaughter)
| Download:
| http://basti2web.de
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/

require_once "../../maincore.php";

// Check: iAUTH and $aid
if (!defined("iAUTH") || $_GET['aid'] != iAUTH) redirect("index.php");

// Includes
require_once INFUSIONS."user_control_center/infusion_db.php";
require_once INFUSIONS."user_control_center/includes/functions.php";

require_once INFUSIONS."user_control_center/version.php";

// Check: Admin Rights
//if (!defined("UCC_ADMIN") || !UCC_ADMIN) redirect("index.php");

// Header
switch(UCC_PHPF_VER) {
case 6:
	require_once BASEDIR."subheader.php";
	require_once ADMIN."navigation.php";
	break;
case 7:
	require_once THEMES."templates/admin_header.php";
	break;
default:
	die("error ucc002: UCC_PHPF_VER does not contain any version number");
}


if (file_exists(INFUSIONS."user_control_center/locale/".$settings['locale']."/ucc_global.php")) {
include INFUSIONS."user_control_center/locale/".$settings['locale']."/ucc_global.php";
} else {
include INFUSIONS."user_control_center/locale/English/ucc_global.php";
}


if(isset($_GET['section'])) {
 $section = stripinput($_GET['section']);
} else {
 $section = "main";
}

if (isset($_GET['rowstart']) AND isnum($_GET['rowstart'])) {
 $rowstart = stripinput($_GET['rowstart']);
} else {
 $rowstart = 0;
}

if (isset($_GET['user_id']) && !isnum($_GET['user_id'])) redirect("index.php");
if (isset($_GET['action'])) { $action = stripinput($_GET['action']); } else { $action = ""; }

define("IN_UCC", TRUE);

opentable($locale['ucc_100']." ".ucc_db_version);

// install control
if (ucc_db_version == 0) {
opentable($locale['ucc_751']);
echo "<b>".$locale['ucc_180']."!</b><br /><br />".$locale['ucc_181'];
}
elseif(ucc_db_version == "2.30"){
echo "<br /><b><a href='".INFUSIONS."user_control_center/updates/up_2.31.php".$aidlink."'>".sprintf($locale['ucc_182'], "2.30 => 2.31")."</a></b>";
}
elseif(ucc_db_version == "2.31"){
echo "<br /><b><a href='".INFUSIONS."user_control_center/updates/up_2.32.php".$aidlink."'>".sprintf($locale['ucc_182'], "2.31 => 2.32")."</a></b>";
}
elseif(ucc_db_version == "2.32"){
echo "<br /><b><a href='".INFUSIONS."user_control_center/updates/up_2.40.php".$aidlink."'>".sprintf($locale['ucc_182'], "2.32 => 2.40")."</a></b>";
}
elseif(ucc_db_version == "2.40" OR ucc_db_version == "2.41"){
echo "<br /><b><a href='".INFUSIONS."user_control_center/updates/up_2.42.php".$aidlink."'>".sprintf($locale['ucc_182'], "2.40 and/or 2.41 => 2.42")."</a></b>";
} else {

$ausgabe = '';
	if(function_exists('fsockopen'))
	{
	$version_new = version_check_ucc();
	if($version_new == ucc_db_version)
	{
	$ausgabe .= "<table><tr><td><img src=\"images/version.gif\"></td>";
	$ausgabe .= "<td><span style=\"font-weight: bold; color: #1bdc16;\">".$locale['ucc_303'].": ".ucc_db_version."</span></td></tr></table>";
	$ausgabe .= "";
	} else {
	 if (!empty($version_new)) 
	 {
	$ausgabe .= "<table><tr><td><img src=\"images/version_old.gif\"></td><td>";
	$ausgabe .= "<span style=\"font-weight: bold; color: red;\">".$locale['ucc_301'].": ".ucc_db_version."</span><br />";
	$ausgabe .= "<span style=\"font-weight: bold; color: #1bdc16;\">".$locale['ucc_302'].": ".$version_new."</span><br />";
	$ausgabe .= "<span style=\"font-weight: bold; \">".$locale['ucc_305'].": </span><a href=\"http://basti2web.de\" target=\"_blank\" title=\"www.basti2web.de\"><span style=\"font-weight: bold; \">http://basti2web.de</span></a>";
	$ausgabe .= "</td></tr></table>";
	 }
	}
	} 
	if (empty($version_new)) {
	$ausgabe .= "<br />".$locale['ucc_307']."!<br />";
	$ausgabe .= $locale['ucc_306']." <a href=\"http://basti2web.de\" target=\"_blank\" title=\"www.basti2web.de\"><span style=\"font-weight: bold; \">http://basti2web.de</span></a><br /><br />";
	}

echo "<div align='left' cellpadding='0' cellspacing='1' width='100%'>".$ausgabe."</div>";

closetable();
tablebreak();
opentable($locale['ucc_200']);

echo "<table align='center' cellpadding='0' cellspacing='1' width='100%' class='tbl-border'>";
echo "<tr><td rowspan='2' width='25%' class='tbl2' align='center'><b><a class='small' href='".ADMIN."index.php".$aidlink."'><b>".$locale['ucc_201']."</b></a></td><td width='25%' class=".($section == "lastlogin" ? "tbl1" : "tbl2")." align='center'><span class='small'>".($section == "lastlogin" ? "<b>".$locale['ucc_202']."</b>" : "<a class='small' href='".FUSION_SELF.$aidlink."&section=lastlogin'><b>".$locale['ucc_202']."</b></a>")."</span></td><td width='25%' class=".($section == "pmcount" ? "tbl1" : "tbl2")." align='center'><span class='small'>".($section == "pmcount" ? "<b>".$locale['ucc_203']."</b>" : "<a class='small' href='".FUSION_SELF.$aidlink."&section=pmcount'><b>".$locale['ucc_203']."</b></a>")."</span></td><td width='25%' class=".($section == "postcount" ? "tbl1" : "tbl2")." align='center'><span class='small'>".($section == "postcount" ? "<b>".$locale['ucc_204']."</b>" : "<a class='small' href='".FUSION_SELF.$aidlink."&section=postcount'><b>".$locale['ucc_204']."</b></a>")."</span></td></tr>

<tr><td width='25%' class=".($section == "imagecheck" ? "tbl1" : "tbl2")." align='center'><span class='small'>".($section == "imagecheck" ? "<b>".$locale['ucc_205']."</b>" : "<a class='small' href='".FUSION_SELF.$aidlink."&section=imagecheck'><b>".$locale['ucc_205']."</b></a>")."</span></td><td width='25%' class=".($section == "a_imagecheck" ? "tbl1" : "tbl2")." align='center'><span class='small'>".($section == "a_imagecheck" ? "<b>".$locale['ucc_206']."</b>" : "<a class='small' href='".FUSION_SELF.$aidlink."&section=a_imagecheck'><b>".$locale['ucc_206']."</b></a>")."</span></td><td width='25%' class=".($section == "usersearch" ? "tbl1" : "tbl2")." align='center'><span class='small'>".($section == "usersearch" ? "<b>".$locale['ucc_207']."</b>" : "<a class='small' href='".FUSION_SELF.$aidlink."&section=usersearch'><b>".$locale['ucc_207']."</b></a>")."</span></td></tr>

<tr>
<td width='25%' class=".($section == "main" ? "tbl1" : "tbl2")." align='center'><span class='small'>".($section == "main" ? "<b>".$locale['ucc_212']."</b>" : "<a class='small' href='".FUSION_SELF.$aidlink."&section=main'><b>".$locale['ucc_212']."</b></a>")."</span></td>
<td width='25%' class=".($section == "postrecount" ? "tbl1" : "tbl2")." align='center'><span class='small'>".($section == "postrecount" ? "<b>".$locale['ucc_208']."</b>" : "<a class='small' href='".FUSION_SELF.$aidlink."&section=postrecount'><b>".$locale['ucc_208']."</b></a>")."</span></td><td width='25%' class=".($section == "unactiveusers" ? "tbl1" : "tbl2")." align='center'><span class='small'>".($section == "unactiveusers" ? "<b>".$locale['ucc_209']."</b>" : "<a class='small' href='".FUSION_SELF.$aidlink."&section=unactiveusers'><b>".$locale['ucc_209']."</b></a>")."</span></td><td width='25%' class=".($section == "delete" ? "tbl1" : "tbl2")." align='center'><span class='small'>".($section == "delete" ? "<b>".$locale['ucc_550']."</b>" : "<a class='small' href='".FUSION_SELF.$aidlink."&section=delete'><b>".$locale['ucc_550']."</b></a>")."</span></td></tr>

<tr>
<td width='25%' class=".($section == "author" ? "tbl1" : "tbl2")." align='center'><span class='small'>".($section == "author" ? "<b>".$locale['ucc_210']."</b>" : "<a class='small' href='".FUSION_SELF.$aidlink."&section=author'><b>".$locale['ucc_210']."</b></a>")."</span></td><td width='25%' class=".($section == "remember" ? "tbl1" : "tbl2")." align='center'><span class='small'>".($section == "remember" ? "<b>".$locale['ucc_700']."</b>" : "<a class='small' href='".FUSION_SELF.$aidlink."&section=remember'><b>".$locale['ucc_700']."</b></a>")."</span></td><td width='25%' class=".($section == "config" ? "tbl1" : "tbl2")." align='center'><span class='small'>".($section == "config" ? "<b>".$locale['ucc_750']."</b>" : "<a class='small' href='".FUSION_SELF.$aidlink."&section=config'><b>".$locale['ucc_750']."</b></a>")."</span></td><td width='25%' class=".($section == "usergroups" ? "tbl1" : "tbl2")." align='center'><span class='small'>".($section == "usergroups" ? "<b>".$locale['ucc_211']."</b>" : "<a class='small' href='".FUSION_SELF.$aidlink."&section=usergroups'><b>".$locale['ucc_211']."</b></a>")."</span></td>

</tr>

</table>";

closetable();
tablebreak();


switch($section)
{
case "main":

opentable($locale['ucc_130']);

echo "<br />";
echo "<table align='center' cellpadding='0' cellspacing='1' width='90%' class='tbl-border'>";
echo "<tr><td class='tbl1'>".$locale['ucc_202'].":</td><td class='tbl1'> ".$locale['ucc_401']."</td></tr>";
echo "<tr><td class='tbl1'>".$locale['ucc_203'].":</td><td class='tbl1'> ".$locale['ucc_501']."</td></tr>";
echo "<tr><td class='tbl1'>".$locale['ucc_204'].":</td><td class='tbl1'> ".$locale['ucc_601']."</td></tr>";
echo "<tr><td class='tbl1'>".$locale['ucc_205'].":</td><td class='tbl1'> ".$locale['imc101']."</td></tr>";
echo "<tr><td class='tbl1'>".$locale['ucc_206'].":</td><td class='tbl1'> ".$locale['imc201']."</td></tr>";
echo "<tr><td class='tbl1'>".$locale['ucc_207'].":</td><td class='tbl1'> ".$locale['ucc_801']."</td></tr>";
echo "<tr><td class='tbl1'>".$locale['ucc_208'].":</td><td class='tbl1'> ".$locale['ucc_655']." ".$locale['ucc_656']." ".$locale['ucc_657']."</td></tr>";
echo "<tr><td class='tbl1'>".$locale['ucc_209'].":</td><td class='tbl1'> ".$locale['ucc_902']."</td></tr>";
echo "<tr><td class='tbl1'>".$locale['ucc_550'].":</td><td class='tbl1'> ".$locale['ucc_566']."</td></tr>";
echo "<tr><td class='tbl1'>".$locale['ucc_700'].":</td><td class='tbl1'> ".$locale['ucc_701']."</td></tr>";
echo "</table>";

echo "<br>".$locale['ucc_103']." <a href='http://basti2web.de' target='_blank'>http://basti2web.de</a>";

break;
case "lastlogin":

if (file_exists(INFUSIONS."user_control_center/locale/".$settings['locale']."/members.php")) {
include INFUSIONS."user_control_center/locale/".$settings['locale']."/members.php";
} else {
include INFUSIONS."user_control_center/locale/English/members.php";
}

if ($action == "delete") {

if (!checkrights("M") || !defined("iAUTH") || $aid != iAUTH) redirect("index.php");

$result = dbquery("SELECT * FROM ".DB_USERS." WHERE user_id=".$user_id);

$data = dbarray($result);

if (iUSER > $data['user_level'] && $data['user_id'] != 1) 
 {
			$result = dbquery("DELETE FROM ".DB_USERS." WHERE user_id='$user_id'");
			$result = dbquery("DELETE FROM ".DB_ARTICLES." WHERE article_name='$user_id'");
			$result = dbquery("DELETE FROM ".DB_COMMENTS." WHERE comment_name='$user_id'");
			$result = dbquery("DELETE FROM ".DB_MESSAGES." WHERE message_to='$user_id'");
			$result = dbquery("DELETE FROM ".DB_MESSAGES." WHERE message_from='$user_id'");
			$result = dbquery("DELETE FROM ".DB_NEWS." WHERE news_name='$user_id'");
			$result = dbquery("DELETE FROM ".DB_POLL_VOTES." WHERE vote_user='$user_id'");
			$result = dbquery("DELETE FROM ".DB_RATINGS." WHERE rating_user='$user_id'");
			$result = dbquery("DELETE FROM ".DB_SHOUTBOX." WHERE shout_name='$user_id'");
			$result = dbquery("DELETE FROM ".DB_THREADS." WHERE thread_author='$user_id'");
			$result = dbquery("DELETE FROM ".DB_POSTS." WHERE post_author='$user_id'");
			$result = dbquery("DELETE FROM ".DB_THREAD_NOTIFY." WHERE notify_user='$user_id'");
			opentable($locale['ucc_100']);
			echo "<center>".$locale['422']."<br /></center>\n";
			closetable();
			tablebreak();
		}
	}


opentable($locale['ucc_400']);

$result = dbquery("SELECT user_id FROM ".DB_USERS." WHERE user_status='0' AND user_id != '".$ucc_ghost."'");
$rows = dbrows($result);

if(isset($_GET['sortby'])) {
	$sortby = stripinput($_GET['sortby']);
} else {
	$sortby = "lastvisit";
}
switch ($sortby) {
	case "lastvisit":
	$query_order = "user_lastvisit DESC";
	break;
	case "id":
	$query_order = "user_id ASC";
	break;
	case "name":
	$query_order = "user_name ASC";
	break;
	case "mail":
	$query_order = "user_email ASC";
	break;
	case "ip":
	$query_order = "user_ip ASC";
	break;
	default:
	$query_order = "user_lastvisit DESC";
}

$result = dbquery("SELECT * FROM ".DB_USERS." WHERE user_status='0' AND user_id != '".$ucc_ghost."' ORDER BY ".$query_order." LIMIT ".$rowstart.", ".$logins_perpage);

   if ($rows > $logins_perpage) echo "<div align='center' style='margin-top:5px;'>\n".makePageNav($rowstart,$logins_perpage,$rows,3,FUSION_SELF.$aidlink."&amp;section=lastlogin&amp;sortby=".$sortby."&amp;")."\n</div><br />\n";

if (dbrows($result) != 0) {
echo "<table align='center' cellpadding='0' cellspacing='1' width='96%' class='tbl-border'>";
echo "<tr>";
echo "<td class='tbl2' align='center' style='font-weight:bold'>".$locale['ucc_113']."</td>\n";
echo "<td class='tbl2' align='left' style='font-weight:bold'>".$locale['ucc_115']."</td>\n";
echo "<td class='tbl2' align='center' style='font-weight:bold'>".$locale['ucc_114']."</td>\n";
echo "<td class='tbl2' align='center' style='font-weight:bold'>".$locale['ucc_116']."</td>\n";
echo "<td class='tbl2' align='center' style='font-weight:bold'>".$locale['ucc_118']."</td>\n";
if(checkrights("M")){
echo "<td class='tbl2' align='center' style='font-weight:bold'>".$locale['404']."</td>\n";
}
echo "<td class='tbl2' align='center' style='font-weight:bold'>".$locale['ucc_406']."</td>\n";
echo "</tr>";
	$i = "0";
	while($data = dbarray($result)) {
		$cls = ($i % 2 == 0 ? "tbl1" : "tbl2"); $i++;
		switch($data['user_level']){
		case "103": $temp_user_level = $locale['ucc_110']; break;
		case "102": $temp_user_level = $locale['ucc_111']; break;
		case "101": $temp_user_level = $locale['ucc_112']; break;
		default: $temp_user_level = $locale['ucc_150']; }
		echo "<tr>
		<td class='".$cls."' align='left'>".$data['user_id']."</td>
		<td class='".$cls."' align='left'><a href='".BASEDIR."profile.php?lookup=".$data['user_id']."' class='side'>".$data['user_name']."</a></td>
		<td class='".$cls."' align='center'>".$temp_user_level."</td>
		<td class='".$cls."' align='center'><a href='mailto:".$data['user_email']."'>".$data['user_email']."</a></td>
		<td class='".$cls."' align='center'><a href='http://www.geoiptool.com/en/?IP=".$data['user_ip']."' target='_blank'>".$data['user_ip']."</a></td>";

if(checkrights("M")) {
if( iUSER > $data['user_level'] AND $data['user_id'] != 1 AND checkrights("M")) {
echo "<td class='".$cls."' align='center'><a href='".FUSION_SELF.$aidlink."&amp;section=lastlogin&amp;action=delete&amp;user_id=".$data['user_id']."&amp;rowstart=$rowstart' onClick='return DeleteMember();'>".$locale['409']."</a></td>";
} else {
echo "<td class='".$cls."' align='center'> </td>"; 
}
}
echo "<td class='".$cls."' align='left'>"; if ($data['user_lastvisit'] != 0) {echo showdate("shortdate",$data['user_lastvisit']);} get_lavi($data['user_lastvisit'],$locale);echo "</td>
            </tr>";
	}

echo "</table>";

echo "<br>".$locale['ucc_414']."&nbsp;";
if ($sortby != "lastvisit") {
	echo "<a href='".FUSION_SELF.$aidlink."&amp;section=lastlogin&amp;sortby=lastvisit&amp;rowstart=".$rowstart."'>".$locale['ucc_406']."</a>,&nbsp;";
} else {
	echo "<i>".$locale['ucc_406']."</i>,&nbsp;";
}
if ($sortby != "id") {
	echo "<a href='".FUSION_SELF.$aidlink."&amp;section=lastlogin&amp;sortby=id&amp;rowstart=".$rowstart."'>".$locale['ucc_113']."</a>,&nbsp;";
} else {
	echo "<i>".$locale['ucc_113']."</i>,&nbsp;";
}
if ($sortby != "name") {
	echo "<a href='".FUSION_SELF.$aidlink."&amp;section=lastlogin&amp;sortby=name&amp;rowstart=".$rowstart."'>".$locale['ucc_115']."</a>,&nbsp;";
} else {
	echo "<i>".$locale['ucc_115']."</i>,&nbsp;";
}
if ($sortby != "mail") {
	echo "<a href='".FUSION_SELF.$aidlink."&amp;section=lastlogin&amp;sortby=mail&amp;rowstart=".$rowstart."'>".$locale['ucc_116']."</a>,&nbsp;";
} else {
	echo "<i>".$locale['ucc_116']."</i>,&nbsp;";
}
if ($sortby != "ip") {
	echo "<a href='".FUSION_SELF.$aidlink."&amp;section=lastlogin&amp;sortby=ip&amp;rowstart=".$rowstart."'>".$locale['ucc_121']."</a>&nbsp;";
} else {
	echo "<i>".$locale['ucc_121']."</i>&nbsp;";
}

} else {
	echo "<div align='center'><font color='red'><b>".$locale['ucc_415']."</b></font></div>";
}


if ($rows > $logins_perpage) echo "<div align='center' style='margin-top:5px;'>\n".makePageNav($rowstart,$logins_perpage,$rows,3,FUSION_SELF.$aidlink."&amp;section=lastlogin&amp;sortby=".$sortby."&amp;")."\n</div>\n";


echo "<script type='text/javascript'>
function DeleteMember(username) {
	return confirm('".$locale['423']."');
}
</script>\n";


break;
case "pmcount":

$XYZ = 0;

opentable($locale['ucc_501']);
	$sql = dbquery("SELECT user_email, user_id, user_name, user_level, COUNT(message_to) AS message_count FROM ".DB_USERS." JOIN ".DB_MESSAGES." ON user_id=message_to GROUP BY user_id");
	$rows = dbrows($sql);
	if ($rows!=0) {
	$sql = dbquery("SELECT user_email, user_id, user_name, user_level, COUNT(message_to) AS message_count FROM ".DB_USERS." JOIN ".DB_MESSAGES." ON user_id=message_to GROUP BY user_id ORDER BY message_count DESC LIMIT ".$rowstart.",".$pmc_perpage."");

	if ($rows>$pmc_perpage) echo "<div align='center' style='margin-top:5px;'>".makePageNav($rowstart,$pmc_perpage,$rows,3,FUSION_SELF.$aidlink."&section=pmcount&")."</div><br />\n";

	echo "<table align='center' width='85%' cellspacing='1' cellpadding='0' class='tbl-border'>
	<tr>
	<td class='tbl2' align='center' style='font-weight:bold'>".$locale['ucc_113']."</td>
	<td class='tbl2' align='left' style='font-weight:bold'>".$locale['ucc_115']."</td>
	<td class='tbl2' align='center' style='font-weight:bold'>".$locale['ucc_114']."</td>
	<td class='tbl2' align='center' style='font-weight:bold'>".$locale['ucc_116']."</td>
	<td class='tbl2' align='center' style='font-weight:bold'>".$locale['ucc_117']."</td>
	<td class='tbl2' align='center' style='font-weight:bold'>".$locale['ucc_505']."</td>
	</tr>\n";
	$i = 0;
	while($data = dbarray($sql)) {
	$cls = ($XYZ++%2==0 ? 'tbl1' : 'tbl2');
		switch($data['user_level']){
		case "103": $temp_user_level = $locale['ucc_110']; break;
		case "102": $temp_user_level = $locale['ucc_111']; break;
		case "101": $temp_user_level = $locale['ucc_112']; break;
		default: $temp_user_level = $locale['ucc_150']; }
	echo "<tr>
	<td class='".$cls."' align='left'>".$data['user_id']."</td>
	<td class='".$cls."' align='left'><a href='".BASEDIR."profile.php?lookup=".$data['user_id']."'>".$data['user_name']."</a></td>
	<td class='".$cls."' align='center'>".$temp_user_level."</td>
	<td class='".$cls."' align='center'><a href='mailto:".$data['user_email']."'>".$data['user_email']."</a></td>
	<td class='".$cls."' align='center'><a href='".BASEDIR."messages.php?msg_send=".$data['user_id']."'>
	<img src='".THEME."/forum/pm.gif' alt='PM'></a></td>
	<td class='".$cls."' align='center'>".$data['message_count']."</td>
	</tr>\n";
	}
	echo "</table><br />\n";
	if ($rows>$pmc_perpage) echo "<div align='center' style='margin-top:5px;'>".makePageNav($rowstart,$pmc_perpage,$rows,3,FUSION_SELF.$aidlink."&section=pmcount&")."</div>\n";
} else {
	echo "<div style='text-align:center'><br />".$locale['ucc_506']."<br /><br /></div>\n";
}

break;
case "postcount":

$XYZ = 0;

opentable($locale['ucc_601']);
	$sql = dbquery("SELECT user_id, user_name, user_level, user_posts, COUNT(post_author) AS post_count FROM ".DB_USERS." JOIN ".DB_POSTS." ON user_id=post_author WHERE user_id != '".$ucc_ghost."' GROUP BY user_id");
	$rows = dbrows($sql);
	if ($rows!=0) {
	$sql = dbquery("SELECT user_id, user_name, user_level, user_posts, COUNT(post_author) AS post_count FROM ".DB_USERS." JOIN ".DB_POSTS." ON user_id=post_author WHERE user_id != '".$ucc_ghost."' GROUP BY user_id ORDER BY post_count DESC LIMIT ".$rowstart.",".$pmc_perpage."");

	if ($rows>$pmc_perpage) echo "<div align='center' style='margin-top:5px;'>".makePageNav($rowstart,$pmc_perpage,$rows,3,FUSION_SELF.$aidlink."&section=postcount&")."</div><br />\n";

	echo "<table align='center' width='85%' cellspacing='1' cellpadding='0' class='tbl-border'>
	<tr>
	<td class='tbl2' align='center' style='font-weight:bold'>".$locale['ucc_113']."</td>
	<td class='tbl2' align='left' style='font-weight:bold'>".$locale['ucc_115']."</td>
	<td class='tbl2' align='center' style='font-weight:bold'>".$locale['ucc_114']."</td>
	<td class='tbl2' align='center' style='font-weight:bold'>".$locale['ucc_117']."</td>
	<td class='tbl2' align='center' style='font-weight:bold'>".$locale['ucc_602']."</td>
	<td class='tbl2' align='center' style='font-weight:bold'>".$locale['ucc_602']." *)</td>
	</tr>\n";
	$i = 0;
	while($data = dbarray($sql)) {
	$cls = ($XYZ++%2==0 ? 'tbl1' : 'tbl2');
		switch($data['user_level']){
		case "103": $temp_user_level = $locale['ucc_110']; break;
		case "102": $temp_user_level = $locale['ucc_111']; break;
		case "101": $temp_user_level = $locale['ucc_112']; break;
		default: $temp_user_level = $locale['ucc_150']; }
	echo "<tr>
	<td class='".$cls."' align='left'>".$data['user_id']."</td>
	<td class='".$cls."' align='left'><a href='".BASEDIR."profile.php?lookup=".$data['user_id']."'>".$data['user_name']."</a></td>
	<td class='".$cls."' align='center'>".$temp_user_level."</td>
	<td class='".$cls."' align='center'><a href='".BASEDIR."messages.php?msg_send=".$data['user_id']."'>
	<img src='".THEME."/forum/pm.gif' alt='PM'></a></td>
	<td class='".$cls."' align='center'>".$data['post_count']."</td>";
	if($data['post_count'] != $data['user_posts']) {
	echo "<td class='".$cls."' align='center'><font color='red'>".$data['user_posts']."</font></td>";
	} else {	echo "<td class='".$cls."' align='center'>".$data['user_posts']."</td>";	}
	echo "</tr>\n";
	}
	echo "</table><br />\n";
	if ($rows>$pmc_perpage) echo "<div align='center' style='margin-top:5px;'>".makePageNav($rowstart,$pmc_perpage,$rows,3,FUSION_SELF.$aidlink."&section=postcount&")."</div>\n";

	echo "<br />*) ".$locale['ucc_607']."<br /><br />".$locale['ucc_608'].": <a href='".FUSION_SELF.$aidlink."&section=postrecount'>".$locale['ucc_208']."</a>";


} else {
	echo "<div style='text-align:center'><br />".$locale['ucc_606']."<br /><br /></div>\n";
}

break;
case "imagecheck":

$imgname = isset($_GET['imgname']) ? $_GET['imgname'] : '';
$imgext = isset($_GET['imgext']) ? $_GET['imgext'] : '';

if ($action == "view") {
 
	opentable($locale['imc102']);
	echo "<center><a href='".FUSION_SELF.$aidlink."&section=imagecheck&rowstart=$rowstart'>".$locale['imc104']."</a><br><br>\n";
	echo stripinput(file_get_contents(IMAGES."avatars/".$imgname.$imgext))."</center>";

} elseif ($action == "delete") {
 
	opentable($locale['imc103']);
	unlink(IMAGES."avatars/".$imgname.$imgext);
	$result = dbquery("UPDATE ".DB_USERS." SET user_avatar='' WHERE user_avatar='".$imgname.$imgext."'");
	echo "<center>".$locale['imc108']."<br><br>\n<a href='".FUSION_SELF.$aidlink."&section=imagecheck&rowstart=$rowstart'>".$locale['imc104']."</a></center>";

} else {
	opentable($locale['imc100']);
	$files = makefilelist(IMAGES."avatars/", ".|..|index.php", false);
	$rows = count($files);
	$counter = 0; $columns = 4;
	echo "<table cellpadding='0' cellspacing='0' width='100%'>\n<tr>\n";
	for($i=$rowstart;$i<($rowstart+12);$i++) {
		if (isset($files[$i])) {
			$name = IMAGES."avatars/".$files[$i];
			$imgext = strrchr($files[$i],".");
			$imgname = substr($files[$i], 0, strrpos($files[$i], "."));
			if ($counter != 0 && ($counter % $columns == 0)) echo "</tr>\n<tr>\n";
			echo "<td align='center' class='tbl'>".$files[$i]."<br><br>\n";
			echo "<img src='".$name."'><br><br>";
			//if(!verify_image($name)) echo "<br>".stripinput(file_get_contents($name))."<br>";
			//if (!verify_image($name)) echo $locale['imc105']."<br><br>";
			echo "<a href='".FUSION_SELF.$aidlink."&section=imagecheck&action=view&amp;imgname=$imgname&amp;imgext=$imgext&amp;rowstart=$rowstart'>".$locale['imc106']."</a> |\n";
			echo "<a href='".FUSION_SELF.$aidlink."&section=imagecheck&action=delete&amp;imgname=$imgname&amp;imgext=$imgext&amp;rowstart=$rowstart'>".$locale['imc107']."</a></br>\n";
			echo "</td>\n";
			$counter++;
		}
	}
	if($rows == 0)
	{
	echo "<td align='center' class='tbl'><br />".$locale['imc109']."</td>\n";
	}
	echo "</tr>\n</table>\n";

	if ($rows > 12) echo "<div align='center' style='margin-top:5px;'>\n".makePageNav($rowstart,12,$rows,3,FUSION_SELF.$aidlink."&section=imagecheck&")."\n</div>\n";
}

echo "<br /><a href=\"http://www.php-fusion.co.uk\" target=\"_blank\">Code by Digitanium</a>";

break;
case "a_imagecheck":

$imgname = isset($_GET['imgname']) ? $_GET['imgname'] : '';
$imgext = isset($_GET['imgext']) ? $_GET['imgext'] : '';

switch(UCC_PHPF_VER) {
case 6:
	require_once INCLUDES."forum_functions_include.php";
	break;
case 7:
	require_once INCLUDES."forum_include.php";
	break;
default:
	die();
}

if ($action == "view") {
	opentable($locale['imc202']);
	echo "<center><a href='".FUSION_SELF.$aidlink."&section=a_imagecheck&rowstart=$rowstart'>".$locale['imc204']."</a><br><br>\n";
	echo stripinput(file_get_contents(FORUM."attachments/".$imgname.$imgext))."</center>";

} elseif ($action == "delete") {
	opentable($locale['imc203']);
	unlink(FORUM."attachments/".$imgname.$imgext);
	echo "<center>".$locale['imc208']."<br><br>\n<a href='".FUSION_SELF.$aidlink."&section=a_imagecheck&rowstart=$rowstart'>".$locale['imc204']."</a></center>";

} else {
	opentable($locale['imc200']);
	$files = array();
	$temp = opendir(FORUM."attachments/");
	while ($file = readdir($temp)) {
		$imgext = strrchr($file,".");
		if (in_array($imgext, $imagetypes)) {
			$files[] = $file;
		}
	}
	closedir($temp);
	if (is_array($files)) sort($files);

	$rows = count($files);
	$counter = 0; $columns = 4;
	echo "<table cellpadding='0' cellspacing='0' width='100%'>\n<tr>\n";
	for($i=$rowstart;$i<($rowstart+12);$i++) {
		if (isset($files[$i])) {
			$name = FORUM."attachments/".$files[$i];
			$imgext = strrchr($files[$i],".");
			$imgname = substr($files[$i], 0, strrpos($files[$i], "."));
			if ($counter != 0 && ($counter % $columns == 0)) echo "</tr>\n<tr>\n";
			echo "<td align='center' class='tbl'>".$files[$i]."<br><br>\n";
			echo "<img src='".$name."' width='100' height='100'><br><br>";
			//if(!verify_image($name)) echo "<br>".stripinput(file_get_contents($name))."<br>";
			//if (!verify_image($name)) echo $locale['imc205']."<br><br>";
			echo "<a href='".FUSION_SELF.$aidlink."&section=a_imagecheck&action=view&amp;imgname=$imgname&amp;imgext=$imgext&amp;rowstart=$rowstart'>".$locale['imc206']."</a> |\n";
			echo "<a href='".FUSION_SELF.$aidlink."&section=a_imagecheck&action=delete&amp;imgname=$imgname&amp;imgext=$imgext&amp;rowstart=$rowstart'>".$locale['imc207']."</a></br>\n";
			echo "</td>\n";
			$counter++;
		}
	}
	if($rows == 0)
	{
	echo "<td align='center' class='tbl'><br />".$locale['imc209']."</td>\n";
	}
	echo "</tr>\n</table>\n";

	if ($rows > 12) echo "<div align='center' style='margin-top:5px;'>\n".makePageNav($rowstart,12,$rows,3,FUSION_SELF.$aidlink."&section=a_imagecheck&")."\n</div>\n";
}

echo "<br /><a href=\"http://www.php-fusion.co.uk\" target=\"_blank\">Code by Digitanium</a>";

break;
case "usersearch":

require INFUSIONS."user_control_center/ucc_usersearch.php";


break;
case "postrecount":

opentable($locale['ucc_650']);


if (isset($_GET['step']) AND $_GET['step'] == "recount") {

$type = $_POST['recount_type'];
$type_obj1 = $_POST['recount_name_t'];
$type_obj2 = $_POST['recount_id_t'];

echo $locale['ucc_654']."<br /><br /><hr size='5'>";
//--

if ($type == 1) {
if (preg_match ("/^([0-9.,-]+)$/", $type_obj2)){
$num = dbcount("(user_id)", DB_USERS, "user_id='".$type_obj2."'");
if ($num) {
$result = dbquery("SELECT * FROM ".DB_USERS." WHERE user_id='".$type_obj2."' LIMIT 0,1");
while ($data = dbarray($result)) {
// ------------------Log //

  echo $locale['ucc_651'].": ".$data['user_name']." (id: ".$data['user_id'].")<br>";

// ------------------ //
 $recounter = dbcount("(post_author)", DB_POSTS, "post_author='".$data['user_id']."'");
$result2 = dbquery("UPDATE ".DB_USERS." SET user_posts='".$recounter."' WHERE user_id=".$data['user_id']."");
$recounted = dbquery("SELECT * FROM ".DB_USERS." WHERE user_id=".$data['user_id']."");
$rebuilded = dbarray($recounted);
// ------------------Log //

if($data['user_posts'] !=$rebuilded['user_posts'])
{
  echo $locale['ucc_652'].": <font color='red'>".$data['user_posts']."</font><br>";
  echo $locale['ucc_653'].": <font color='red'>".$rebuilded['user_posts']."</font><br>";
  echo "<hr color='red' size='5'>";

} else {
  echo $locale['ucc_652'].": ".$data['user_posts']."<br>";
  echo $locale['ucc_653'].": ".$rebuilded['user_posts']."<br>";
  echo "<hr size='5'>";
}
// ------------------ //
}
echo "<br><br><center>".$locale['ucc_673'].".<br><br><br><a href='".FUSION_SELF.$aidlink."&section=postrecount'>".$locale['ucc_160']."</a>";
}else {echo "<center>".$locale['ucc_692'].": ".$type_obj2."<br><br><br><a href='".FUSION_SELF.$aidlink."&section=postrecount'>".$locale['ucc_160']."</a></center>";}
} else { echo "<center>".$locale['ucc_693'].".<br><br><br><a href='".FUSION_SELF.$aidlink."&section=postrecount'>".$locale['ucc_160']."</a>"; }}


//++++++++++++++++++++++


if ($type == 2){
$num1 = dbcount("(user_name)", DB_USERS, "user_name='$type_obj1'");
if ($num1) {
$result = dbquery("SELECT * FROM ".DB_USERS." WHERE user_name='$type_obj1' LIMIT 0,1");
while ($data = dbarray($result)) {
// ------------------Log //

  echo $locale['ucc_651'].": ".$data['user_name']." (id: ".$data['user_id'].")<br>";

// ------------------ //
 $recounter = dbcount("(post_author)", DB_POSTS, "post_author='".$data['user_id']."'");
$result2 = dbquery("UPDATE ".DB_USERS." SET user_posts='".$recounter."' WHERE user_id=".$data['user_id']."");
$recounted = dbquery("SELECT * FROM ".DB_USERS." WHERE user_id=".$data['user_id']."");
$rebuilded = dbarray($recounted);
// ------------------Log //

if($data['user_posts'] !=$rebuilded['user_posts'])
{
  echo $locale['ucc_652'].": <font color='red'>".$data['user_posts']."</font><br>";
  echo $locale['ucc_653'].": <font color='red'>".$rebuilded['user_posts']."</font><br>";
  echo "<hr color='red' size='5'>";

} else {
  echo $locale['ucc_652'].": ".$data['user_posts']."<br>";
  echo $locale['ucc_653'].": ".$rebuilded['user_posts']."<br>";
  echo "<hr size='5'>";
}
// ------------------ //
}
echo "<br><br><center>".$locale['ucc_673'].".<br><br><br><a href='".FUSION_SELF.$aidlink."&section=postrecount'>".$locale['ucc_160']."</a>";}
else {echo "<center>".$locale['ucc_691'].": ".$type_obj1."<br><br><br><a href='".FUSION_SELF.$aidlink."&section=postrecount'>".$locale['ucc_160']."</a></center>";}}

//+++++++++++++++++++++++

if ($type == 3){
$result = dbquery("SELECT * FROM ".DB_USERS." WHERE user_id != '".$ucc_ghost."'");
while ($data = dbarray($result)) {
// ------------------Log //

  echo $locale['ucc_651'].": ".$data['user_name']." (id: ".$data['user_id'].")<br>";

// ------------------ //
 $recounter = dbcount("(post_author)", DB_POSTS, "post_author='".$data['user_id']."'");
$result2 = dbquery("UPDATE ".DB_USERS." SET user_posts='".$recounter."' WHERE user_id=".$data['user_id']."");
$recounted = dbquery("SELECT * FROM ".DB_USERS." WHERE user_id=".$data['user_id']."");
$rebuilded = dbarray($recounted);
// ------------------Log //

if($data['user_posts'] !=$rebuilded['user_posts'])
{
  echo $locale['ucc_652'].": <font color='red'>".$data['user_posts']."</font><br>";
  echo $locale['ucc_653'].": <font color='red'>".$rebuilded['user_posts']."</font><br>";
  echo "<hr color='red' size='5'>";

} else {
  echo $locale['ucc_652'].": ".$data['user_posts']."<br>";
  echo $locale['ucc_653'].": ".$rebuilded['user_posts']."<br>";
  echo "<hr size='5'>";

}

// ------------------ //
}
echo "<br><br><center>".$locale['ucc_674'].".<br><br><br><a href='".FUSION_SELF.$aidlink."&section=postrecount'>".$locale['ucc_160']."</a>";}


//+++++++++++++++++++++


} else {
echo "<br />".$locale['ucc_655']."<br />".$locale['ucc_656']."<br />".$locale['ucc_657']."<br /><br />";
echo "<form name='' method='post' action='".FUSION_SELF.$aidlink."&section=postrecount&step=recount'>
<table align='center' cellpadding='0' cellspacing='1' class='tbl-border' width='50%'>
<tr>
<td class='tbl2' colspan='2' align='center'>".$locale['ucc_675']."</td>
</tr>
<tr>
<td class='tbl1'><input type='radio' name='recount_type' value='3' checked='checked'>".$locale['ucc_678']."</td>
<td class='tbl1'></td>
</tr>
<tr>
<td class='tbl1'><input type='radio' name='recount_type' value='1'>".$locale['ucc_676'].": </td>
<td class='tbl1'><input type='text' name='recount_id_t' maxlength='30' class='textbox'></td>
</tr>
<tr>
<td class='tbl1'><input type='radio' name='recount_type' value='2'>".$locale['ucc_677'].":</td>
<td class='tbl1'><input type='text' name='recount_name_t' maxlength='30' class='textbox'></td>
</tr>
<tr>
<td align='center' colspan='2' class='tbl1'><input type='submit' name='add_user' value='".$locale['ucc_680']."' class='button'></td>
</tr>
</table>
</form>\n";
}

break;
case "unactiveusers":


if (isset($_GET['deletecode'])) {
$deletecode = stripinput($_GET['deletecode']);
$result = dbquery("DELETE FROM ".DB_NEW_USERS." WHERE user_code='$deletecode'");
}

if (isset($_GET['deleteuser'])) {
$deleteuser = stripinput($_GET['deleteuser']);
$result = dbquery("DELETE FROM ".DB_NEW_USERS." WHERE user_id='$deleteuser'");
}

if (isset($_GET['admin_activate'])) {
$admin_activate = stripinput($_GET['admin_activate']);

if (file_exists(INFUSIONS."user_control_center/locale/".$settings['locale']."/members.php")) {
include INFUSIONS."user_control_center/locale/".$settings['locale']."/members.php";
} else {
include INFUSIONS."user_control_center/locale/English/members.php";
}

		$result = dbquery("SELECT user_name,user_email FROM ".DB_USERS." WHERE user_id='$admin_activate'");
		if (dbrows($result) != 0) {
			$udata = dbarray($result);
			$result = dbquery("UPDATE ".DB_USERS." SET user_status='0' WHERE user_id='$admin_activate'");
			if ($settings['email_verification'] == "1") {
				require_once INCLUDES."sendmail_include.php";
				sendemail($udata['user_name'],$udata['user_email'],$settings['siteusername'],$settings['siteemail'],$locale['ucc_930'].": ".$settings['sitename'],str_replace("[USER_NAME]", $udata['user_name'], $locale['426']));
			}
		opentable($locale['ucc_920']);
			echo "<center><br />\n".$locale['ucc_922']."<br /><br /></center>\n";
		closetable();
		tablebreak();
		}
	} 


if (isset($_GET['re'])){
$re = stripinput($_GET['re']);

  if (dbcount("(user_code)", DB_NEW_USERS, "user_code='".$re."'")) {
    $rs_e = dbquery("SELECT * FROM ".DB_NEW_USERS." WHERE user_code='".$re."'"); $rs_ed = dbarray($rs_e);
    require_once INCLUDES."sendmail_include.php";
    $rs_ed_n = unserialize($rs_ed['user_info']);
    $sd_1 = $locale['ucc961']." ".$rs_ed_n['user_name'];
    $sd_2 = $locale['ucc961']." ".$rs_ed_n['user_name'].",\n".$locale['ucc962a']." ".$settings['sitename']." ".$locale['ucc962b']."\n".$locale['ucc962c']."\n".$locale['ucc962d']." ".$rs_ed_n['user_name']."\n".$locale['ucc962e']." ".$rs_ed_n['user_password']."\n\n".$locale['ucc962f']."\n";

    $activation_url = $settings['siteurl']."register.php?activate=".$rs_ed['user_code'];
    
    
      if (sendemail($rs_ed_n['user_name'],$rs_ed['user_email'],$settings['siteusername'],$settings['siteemail'],$sd_1, $sd_2.$activation_url)) {

opentable($locale['ucc960']);
        echo "<center>".$locale['ucc963']."</center>";
closetable();
tablebreak();


      } else if (!sendemail($rs_ed_n['user_name'],$rs_ed['user_email'],$settings['siteusername'],$settings['siteemail'],$sd_1, $sd_2.$activation_url)) {

opentable($locale['ucc960']);
        echo "<center>".$locale['ucc965']."</center>";
closetable();
tablebreak();

        }
   }  else if (!dbcount("(user_code)", DB_NEW_USERS, "user_code='".$re."'")) {

opentable($locale['ucc960']);
      echo "<center>".$locale['ucc966']."</center>";
closetable();
tablebreak();


      }
}


if (isset($_GET['activate'])) {
$activate = $_GET['activate'];
	if (!preg_match("/^[0-9a-z]{32}$/", $activate)) redirect("index.php");
	$result = dbquery("SELECT * FROM ".DB_NEW_USERS." WHERE user_code='$activate'");
	if (dbrows($result) != 0) {
		$data = dbarray($result);
		$user_info = unserialize($data['user_info']);

// Falls admin_activation = 1, wird user_status = 2
/*
		$activation = $settings['admin_activation'] == "1" ? "2" : "0";
		$result = dbquery("INSERT INTO ".$db_prefix."users (user_name, user_password, user_email, user_hide_email, user_location, user_birthdate, user_aim, user_icq, user_msn, user_yahoo, user_web, user_theme, user_offset, user_avatar, user_sig, user_posts, user_joined, user_lastvisit, user_ip, user_rights, user_groups, user_level, user_status) VALUES('".$user_info['user_name']."', '".$user_info['user_password']."', '".$user_info['user_email']."', '".$user_info['user_hide_email']."', '', '0000-00-00', '', '', '', '', '', 'Default', '0', '', '', '0', '".time()."', '0', '".USER_IP."', '', '', '101', '$activation')");
*/
// Auch wenn admin_activation = 1, wird user_status = 0


// Insert
switch(UCC_PHPF_VER) {
case 6:
	$result = dbquery("INSERT INTO ".DB_USERS." (user_name, user_password, user_email, user_hide_email, 	user_location, user_birthdate, user_aim, user_icq, user_msn, user_yahoo, user_web, user_theme, user_offset, 	user_avatar, user_sig, user_posts, user_joined, user_lastvisit, user_ip, user_rights, user_groups, user_level, 	user_status) VALUES('".$user_info['user_name']."', '".$user_info['user_password']."', '".$user_info['user_email']."', 	'".$user_info['user_hide_email']."', '', '0000-00-00', '', '', '', '', '', 'Default', '0', '', '', '0', '".time()."', 	'0', '0', '', '', '101', '0')");
	break;
case 7:
// Insert von SoulSmasher f�r v7:
$result = dbquery("INSERT INTO ".DB_USERS." (user_name, user_password, user_admin_password, user_email, user_hide_email, user_theme, user_avatar, user_posts, user_threads, user_joined, user_lastvisit, user_ip, user_rights, user_groups, user_level, user_status) VALUES('".$user_info['user_name']."', '".$user_info['user_password']."', '', '".$user_info['user_email']."',    '".$user_info['user_hide_email']."', 'Default', '', '0', '0', '".time()."', '0', '0', '', '', '101', '0')");
	break;
default:
	die("error ucc00x");
}



//--

		$result = dbquery("DELETE FROM ".DB_NEW_USERS." WHERE user_code='$activate'");	
		opentable($locale['ucc_920']);
		if ($settings['admin_activation'] == "1") {
			echo "<center><br />\n".$locale['ucc_921']."!<br /><br />\n</center>\n";
		} else {
			echo "<center><br />\n".$locale['ucc_922']."!<br /><br />\n</center>\n";
		}
		closetable();
		tablebreak();
	} else {
		redirect("index.php");
	}
}


opentable($locale['ucc_951']);
if($settings['email_verification'] == "1")
{
echo $locale['ucc_953'].": ".$locale['ucc_171'];
}else{
echo $locale['ucc_953'].": ".$locale['ucc_172'];
}
echo "<br /><br />";
	$result = dbquery("SELECT * FROM ".DB_NEW_USERS);
	if (dbrows($result) !=0) {
		echo "<table align='center' cellpadding='0' cellspacing='1' width='90%' class='tbl-border'><tr>
	<td class='tbl2' style='font-weight:bold'>".$locale['ucc_115']."</td>    
	<td class='tbl2' style='text-align:center; font-weight:bold'>".$locale['ucc_119']."</td>    
	<td class='tbl2' style='text-align:center; font-weight:bold'>".$locale['ucc_116']."</td>   	
	<td class='tbl2' style='text-align:center; font-weight:bold'>".$locale['ucc_910']."</td>    
		</tr>";	
		while($data = dbarray($result))	{	    
			$info = unserialize($data['user_info']);	    
			echo "<tr>
				<td class='tbl1'>".$info['user_name']."</td>
				<td class='tbl1' style='text-align:center'>".strftime($settings['forumdate'], $data['user_datestamp']+($settings['timeoffset']*3600))."</td>
				<td class='tbl1' style='text-align:center'><a href='mailto:".$info['user_email']."'>".$info['user_email']."</a></td>
				<td class='tbl1' style='text-align:center'><a href='".FUSION_SELF.$aidlink."&section=unactiveusers&activate=".$data['user_code']."'>".$locale['ucc_911']."</a> | <a href='".FUSION_SELF.$aidlink."&section=unactiveusers&deletecode=".$data['user_code']."' onclick='return RemoveThisNewUser();'>".$locale['ucc_120']."</a> | <a href='".FUSION_SELF.$aidlink."&section=unactiveusers&re=".$data['user_code']."'>Erneut Senden</a>  </td>
			</tr>";	
			}	
		echo "</table>";
	}  else{	
		echo "<div style='text-align:center'>".$locale['ucc_913']."</div>";
	}

echo "<br />".$locale['ucc_903']."<br />".$locale['ucc_904']."
<a href='http://basti2web.de/readarticle.php?article_id=3' target='_blank'>http://basti2web.de</a>";


// Admin-Aktivierung
closetable();
tablebreak();
opentable($locale['ucc_952']);


if($settings['admin_activation'] == "1")
{
echo $locale['ucc_954'].": ".$locale['ucc_171'];
}else{
echo $locale['ucc_954'].": ".$locale['ucc_172'];
}
echo "<br /><br />";
$result = dbquery("SELECT * FROM ".DB_USERS." WHERE user_status='2' ORDER BY user_id DESC");
	if (dbrows($result) !=0) {    
		echo "<table align='center' cellpadding='0' cellspacing='1' width='90%' class='tbl-border'><tr>
	<td class='tbl2' style='font-weight:bold'>".$locale['ucc_115']."</td>    
	<td class='tbl2' style='text-align:center; font-weight:bold'>".$locale['ucc_119']."</td>    
	<td class='tbl2' style='text-align:center; font-weight:bold'>".$locale['ucc_116']."</td>   	
	<td class='tbl2' style='text-align:center; font-weight:bold'>".$locale['ucc_910']."</td>    
		</tr>";	
		while($data = dbarray($result))	{	       
			echo "<tr>
				<td class='tbl1'>".$data['user_name']."</td>
				<td class='tbl1' style='text-align:center'>".strftime($settings['forumdate'], $data['user_joined']+($settings['timeoffset']*3600))."</td>
				<td class='tbl1' style='text-align:center'><a href='mailto:".$data['user_email']."'>".$data['user_email']."</a></td>
				<td class='tbl1' style='text-align:center'><a href='".FUSION_SELF.$aidlink."&section=unactiveusers&admin_activate=".$data['user_id']."'>".$locale['ucc_911']."</a> | <a href='".FUSION_SELF.$aidlink."&section=unactiveusers&deleteuser=".$data['user_id']."' onclick='return RemoveThisNewUser();'>".$locale['ucc_120']."</a></td>
			</tr>";	
			}	
		echo "</table>";
	}  else{	
		echo "<div style='text-align:center'>".$locale['ucc_914']."</div>";
	}



echo "<script language='JavaScript'>
function RemoveThisNewUser() {	
	return confirm('".$locale['ucc_912']."');
}
</script>";

break;
case "delete":

require INFUSIONS."user_control_center/ucc_delete.php";

break;
case "remember":

require INFUSIONS."user_control_center/ucc_remember.php";

break;
case "usergroups":

require INFUSIONS."user_control_center/ucc_ug.php";

break;
case "config":

$ausgabe = "";
if (isset($_POST['ucc_save'])) {
	$error = "";
$save_pmc_perpage = stripinput($_POST['pmc_perpage']);
$save_logins_perpage = stripinput($_POST['logins_perpage']);
$save_show_all = stripinput($_POST['show_all']);
$save_d_show_auto = stripinput($_POST['d_show_auto']);
$save_d_show_manu = stripinput($_POST['d_show_manu']);
$save_c_show_auto = stripinput($_POST['c_show_auto']);
$save_c_show_manu = stripinput($_POST['c_show_manu']);
	
	if (preg_match("/[^0-9]/", $save_pmc_perpage) OR preg_match("/[^0-9]/", $save_logins_perpage))
	{ $error .= $locale['ucc_769']."<br /><br />\n"; }
	
	if ($save_pmc_perpage == 0)	$save_pmc_perpage = 15;
	if ($save_logins_perpage == 0)	$save_logins_perpage = 15;

	if ($error != "") {
	$ausgabe .= "<u>".$locale['ucc_768'].":</u><br /><br />\n$error\n\n";
	} else {
	
	$result = dbquery("UPDATE ".DB_UCC_SETTINGS." SET ucc_pm_post_perpage = '".$save_pmc_perpage."', ucc_logins_perpage = '".$save_logins_perpage."', ucc_panel_showall = '".$save_show_all."', ucc_panel_d_show_auto = '".$save_d_show_auto."', ucc_panel_d_show_manu = '".$save_d_show_manu."', ucc_panel_c_show_auto = '".$save_c_show_auto."', ucc_panel_c_show_manu = '".$save_c_show_manu."'");

	redirect(FUSION_SELF.$aidlink."&section=config");	
	}
}

if($ausgabe != "")
{
opentable($locale['ucc_751']);
echo $ausgabe;
closetable();
tablebreak();
$ausgabe = "";
}

opentable($locale['ucc_750']);


echo "<table width='95%' cellspacing='1' cellpadding='3' class='tbl-border' align='center'>";

echo "<form action='".FUSION_SELF.$aidlink."&section=config' method='POST'>

		<tr><td class='tbl2' colspan='3'>".$locale['ucc_764']."</td></tr>

		<tr>
		<td class='tbl1' width='160'>".$locale['ucc_766'].":</td>
		<td class='tbl1'><input type='text' name='logins_perpage' value='".$logins_perpage."' size='10' maxlength='50' class='textbox'></td>
		<td class='tbl1'>".$locale['ucc_765']."</td>
		</tr>

		<tr>
		<td class='tbl1' width='160'>".$locale['ucc_767'].":</td>
		<td class='tbl1'><input type='text' name='pmc_perpage' value='".$pmc_perpage."' size='10' maxlength='50' class='textbox'></td>
		<td class='tbl1'>".$locale['ucc_765']."</td>
		</tr>

		<tr><td class='tbl2' colspan='3'>".$locale['ucc_762']."</td></tr>

		<tr>	
		<td class='tbl1' width='160'>".$locale['ucc_752'].":</td>
		<td class='tbl1'><select size='1' class='textbox' name='show_all'>
		<option value='0'"; if($show_all == 0) echo " selected='selected' "; echo">".$locale['ucc_172']."</option>
		<option value='1'"; if($show_all == 1) echo " selected='selected' "; echo">".$locale['ucc_171']."</option>
		</select></td>
		<td class='tbl1'>".$locale['ucc_753a']."<br />".$locale['ucc_753b']."</td>
		</tr>

		<tr>	
		<td class='tbl1' width='160'>".$locale['ucc_754'].":<br><span class='small2'>".$locale['ucc_755']."</span></td>
		<td class='tbl1'><select size='1' class='textbox' name='d_show_auto'>
		<option value='0'"; if($d_show_auto == 0) echo " selected='selected' "; echo">".$locale['ucc_172']."</option>
		<option value='1'"; if($d_show_auto == 1) echo " selected='selected' "; echo">".$locale['ucc_171']."</option>
		</select></td>
		<td class='tbl1'>".$locale['ucc_757']."</td>
		</tr>

		<tr>	
		<td class='tbl1' width='160'>".$locale['ucc_758'].":<br><span class='small2'>".$locale['ucc_759']."</span></td>
		<td class='tbl1'><select size='1' class='textbox' name='d_show_manu'>
		<option value='0'"; if($d_show_manu == 0) echo " selected='selected' "; echo">".$locale['ucc_172']."</option>
		<option value='1'"; if($d_show_manu == 1) echo " selected='selected' "; echo">".$locale['ucc_171']."</option>
		</select></td>
		<td class='tbl1'>".$locale['ucc_760']."<br />".$locale['ucc_761']."</td>
		</tr>

		<tr>	
		<td class='tbl1' width='160'>".$locale['ucc_754'].":<br><span class='small2'>".$locale['ucc_756']."</span></td>
		<td class='tbl1'><select size='1' class='textbox' name='c_show_auto'>
		<option value='0'"; if($c_show_auto == 0) echo " selected='selected' "; echo">".$locale['ucc_172']."</option>
		<option value='1'"; if($c_show_auto == 1) echo " selected='selected' "; echo">".$locale['ucc_171']."</option>
		</select></td>
		<td class='tbl1'>".$locale['ucc_757']."</td>
		</tr>

		<tr>	
		<td class='tbl1' width='160'>".$locale['ucc_758'].":<br><span class='small2'>".$locale['ucc_759']."</span></td>
		<td class='tbl1'><select size='1' class='textbox' name='c_show_manu'>
		<option value='0'"; if($c_show_manu == 0) echo " selected='selected' "; echo">".$locale['ucc_172']."</option>
		<option value='1'"; if($c_show_manu == 1) echo " selected='selected' "; echo">".$locale['ucc_171']."</option>
		</select></td>
		<td class='tbl1'>".$locale['ucc_760']."<br />".$locale['ucc_761']."</td>
		</tr>

		<tr>
		<td class='tbl1' colspan='3' align='center'><input type='submit' value='".$locale['ucc_763']."' name='ucc_save' class='button'></td>
		</tr>
	</table>
	</form><br />";



break;
case "author":

opentable($locale['ucc_210']);

echo "<br />
<table align='center' width='80%' cellspacing='1' cellpadding='0' class='tbl-border'>
<tr><td class='tbl1'>Sebastian Sch�ssler (slaughter)</td><td class='tbl1'>Main Code, Last Logins, PM-Counter, Post-Counter, Unactivated User, Remember-Mail, Delete Users</td>
<td class='tbl1'><a href=\"http://basti2web.de\" target=\"_blank\" title=\"www.basti2web.de\"><span style=\"font-weight: bold; \">http://basti2web.de</span></a></td></tr><tr><td class='tbl1'>Nick Jones (Digitanium)</td><td class='tbl1'>Image-Checker, Attachment-Image-Checker</td><td class='tbl1'><a href=\"http://php-fusion.co.uk\" target=\"_blank\" title=\"http://php-fusion.co.uk\"><span style=\"font-weight: bold; \">http://php-fusion.co.uk</span></a></td></tr><tr><td class='tbl1'>Nagy K�rolynak (Korcsii)</td><td class='tbl1'>User Search</td><td class='tbl1'><a href=\"http://php-fusion.co.hu\" target=\"_blank\" title=\"http://php-fusion.co.hu\"><span style=\"font-weight: bold; \">http://php-fusion.co.hu</span></a></td></tr><tr><td class='tbl1'>Christian Zeller (I*need*$)</td><td class='tbl1'>Usergroups Management</td><td class='tbl1'><a href=\"http://yxcvbnm.xail.net\" target=\"_blank\" title=\"http://yxcvbnm.xail.net\"><span style=\"font-weight: bold; \">http://yxcvbnm.xail.net</span></a></td></tr><tr><td class='tbl1'>Koller J�zsef (Orosznyet)</td><td class='tbl1'>A Part of the Post-Recounter</td><td class='tbl1'> </td></tr>
</table>";

} // ende von switch
} // ende der install control
echo $y
// Close
.$y.base64_decode($ss[0].$ss[1]).$y.$y;
closetable();
echo "</td>\n";
// Footer
switch(UCC_PHPF_VER) {
case 6:
	echo "</td>\n";
	require_once BASEDIR."footer.php";
	break;
case 7:
require_once THEMES."templates/footer.php";
	break;
default:
	die("error ucc003: UCC_PHPF_VER does not contain any version number");
}
?>