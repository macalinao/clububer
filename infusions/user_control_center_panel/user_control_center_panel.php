<?php
/*---------------------------------------------------+
| PHP-Fusion 6 Content Management System
+----------------------------------------------------+
| Copyright © 2002 - 2005 Nick Jones
| http://www.php-fusion.co.uk/
+----------------------------------------------------+
| Released under the terms & conditions of v2 of the
| GNU General Public License. For details refer to
| the included gpl.txt file or visit http://gnu.org
+----------------------------------------------------+
| User Control Center made by:
| Sebastian "slaughter" Schüssler
| http://basti2web.de
| Version 2.40a
+----------------------------------------------------*/
if (!defined("IN_FUSION")) { header("Location:index.php"); exit; }

if (iADMIN && (iUSER_RIGHTS != "" || iUSER_RIGHTS != "C"))
{

// load language files
if (file_exists(INFUSIONS."user_control_center/locale/".$settings['locale']."/ucc_global.php")) {
	include INFUSIONS."user_control_center/locale/".$settings['locale']."/ucc_global.php";
} else {
	@include INFUSIONS."user_control_center/locale/English/ucc_global.php";
}

// Includes
@include_once INFUSIONS . "user_control_center/infusion_db.php";

// load required functions
if (file_exists(INFUSIONS . "user_control_center/version.php")) {
	require_once INFUSIONS . "user_control_center/version.php";
	$check_file = true;
} else {
	$check_file = false;
}

opensidex("User Control Center");

// check, if infusion is installed
$check_db = dbrows(dbquery("SELECT inf_folder FROM ".DB_PREFIX."infusions WHERE inf_folder='user_control_center'"));

if (($check_db == 0) OR ($check_file == false)) {
	if(isset($locale['ucc_186'])) { echo "<div class='side-label'><b>".$locale['ucc_186']."</b></div>"; } else { echo "<div class='side-label'><b>Error: Infusion 'User Control Center' must be installed!</b></div>"; };
} else {


// load ucc functions
require_once INFUSIONS."user_control_center/includes/functions.php";


// load panel functions
require_once INFUSIONS . "user_control_center_panel/functions_include.php";


// check, if database settings are available
if(ucc_db_version == 0) {
echo "<div class='side-label'><b>".$locale['ucc_180']."</b></div>";
}
elseif(ucc_db_version != ucc_version) {
echo "<a href='".INFUSIONS."user_control_center/ucc_admin.php".$aidlink."'><b>".$locale['ucc_187']."</b></a>";
} else {


//--

// Einsendungen
$count_n = dbcount("(submit_id)", DB_SUBMISSIONS, "submit_type='n'");
$count_a = dbcount("(submit_id)", DB_SUBMISSIONS, "submit_type='a'");
$count_l = dbcount("(submit_id)", DB_SUBMISSIONS, "submit_type='l'");
$count_p = dbcount("(submit_id)", DB_SUBMISSIONS, "submit_type='p'");

// PDP
if($show_pds == 1) {
$url_pds = INFUSIONS."pro_download_panel/mod.php";
$count_pds_C = dbcount("(download_id)", DB_PDP_DOWNLOADS, "dl_status='".PDP_PRO_CHECK."'");
$count_pds_S = dbcount("(download_id)", DB_PDP_DOWNLOADS, "dl_status='".PDP_PRO_NEW."'");
$count_pds = $count_pds_C + $count_pds_S; }
else { $count_pds = 0; }

//Event
if($show_cal == 1)
{ $count_cal = dbcount("(ev_id)", "aw_ec_events", "ev_status='1'"); } else { $count_cal = 0; }

//Witz
if($show_witz == 1) {
$count_witz = dbcount("(id)", DB_WITZ, "status='D'"); }
else { $count_witz = 0; }

//Rezept
if($show_rezept == 1) {
$count_rezept = dbcount("(id)", "recept", "status='D'"); }
else { $count_rezept = 0; }


// Zähler
$count_all = $count_n + $count_a + $count_l + $count_p + $count_pds + $count_cal + $count_witz + $count_rezept;


if ($show_all == 0) {
if ($count_n == 0) { $show_n = 0; } else { $show_n = 1; };
if ($count_a == 0) { $show_a = 0; } else { $show_a = 1; };
if ($count_l == 0) { $show_l = 0; } else { $show_l = 1; };
if ($count_p == 0) { $show_p = 0; } else { $show_p = 1; };
//PDP:
if ($count_pds == 0) { $show_pds = 0; } else { $show_pds = 1; };
//Event
if ($count_cal == 0) { $show_cal = 0; } else { $show_cal = 1; };
//Witz
if ($count_witz == 0) { $show_witz = 0; } else { $show_witz = 1; };
//Rezept
if ($count_rezept == 0) { $show_rezept = 0; } else { $show_rezept = 1; };


} else {
$show_n = 1;
$show_a = 1;
$show_l = 1;
$show_p = 1;
}


if($show_all == 0 AND $count_all == 0)
{
echo "<br>".$locale['ucc_p08'];
} else {
echo "<div class='side-label'>".$locale['ucc_p01']."</div><br>";
}

echo "<table align='center' cellpadding='0' cellspacing='0' width='90%'>";



if ($show_n == 1){
if(checkrights("SU")) {
echo "<tr><td class='side-small' align='left'><a href='".ADMIN."submissions.php".$aidlink."#news_submissions' class='side'>".$locale['ucc_p02']."</a>: </td>";
} else {
echo "<tr><td class='side-small' align='left'>".$locale['ucc_p02'].": </td>";
}
echo "<td class='side-small' align='right'>\n";

if ($count_n != 0) { echo "<font color='red'><b>".$count_n."</b></font>"; } else { echo $count_n; }

echo "</td></tr>";
}

if ($show_a == 1){
if(checkrights("SU")) {
echo "<tr><td class='side-small' align='left'><a href='".ADMIN."submissions.php".$aidlink."#article_submissions' class='side'>".$locale['ucc_p03']."</a>: </td>";
} else {
echo "<tr><td class='side-small' align='left'>".$locale['ucc_p03'].": </td>";
}
echo "<td class='side-small' align='right'>\n";

if ($count_a != 0) { echo "<font color='red'><b>".$count_a."</b></font>"; } else { echo $count_a; }

echo "</td></tr>";
}

if ($show_l == 1){
if(checkrights("SU")) {
echo "<tr><td class='side-small' align='left'><a href='".ADMIN."submissions.php".$aidlink."#link_submissions' class='side'>".$locale['ucc_p04']."</a>: </td>";
} else {
echo "<tr><td class='side-small' align='left'>".$locale['ucc_p04'].": </td>";
}
echo "<td class='side-small' align='right'>\n";

if ($count_l != 0) { echo "<font color='red'><b>".$count_l."</b></font>"; } else { echo $count_l; }

echo "</td></tr>";
}

if ($show_p == 1){
if(checkrights("SU")) {
echo "<tr><td class='side-small' align='left'><a href='".ADMIN."submissions.php".$aidlink."#photo_submissions' class='side'>".$locale['ucc_p05']."</a>: </td>";
} else {
echo "<tr><td class='side-small' align='left'>".$locale['ucc_p05'].": </td>";
}
echo "<td class='side-small' align='right'>\n";

if ($count_p != 0) { echo "<font color='red'><b>".$count_p."</b></font>"; } else { echo $count_p; }

echo "</td></tr>";
}

if($show_pds == 1){
echo "<tr><td class='side-small' align='left'><a href='".$url_pds."'>".$locale['ucc_p06']."</a>: </td>
<td class='side-small' align='right'>\n";

if ($count_pds != 0) { echo "<font color='red'><b>".$count_pds."</b></font>"; } else { echo $count_pds; } 

echo "</td></tr>";
}

if($show_cal == 1){
echo "<tr><td class='side-small' align='left'><a href='".INFUSIONS."aw_ecal_panel/new_events.php".$aidlink."'>".$locale['ucc_p07']."</a>: </td>
<td class='side-small' align='right'>\n";

if ($count_cal != 0) { echo "<font color='red'><b>".$count_cal."</b></font>"; } else { echo $count_cal; } 

echo "</td></tr>";
}

if($show_witz == 1){
echo "<tr><td class='side-small' align='left'><a href='".INFUSIONS."witze/witz.php?admin'>".$locale['ucc_p09']."</a>: </td>
<td class='side-small' align='right'>\n";

if ($count_witz != 0) { echo "<font color='red'><b>".$count_witz."</b></font>"; } else { echo $count_witz; } 

echo "</td></tr>";
}

if($show_rezept == 1){
echo "<tr><td class='side-small' align='left'><a href='".INFUSIONS."rezepte/rezept.php?admin'>".$locale['ucc_p10']."</a>: </td>
<td class='side-small' align='right'>\n";

if ($count_rezept != 0) { echo "<font color='red'><b>".$count_rezept."</b></font>"; } else { echo $count_rezept; } 

echo "</td></tr>";
}

echo "</table><br />";

if (checkrights("IP")){
echo "<a href='".INFUSIONS."user_control_center/ucc_admin.php".$aidlink."&section=unactiveusers' class='side'>".$locale['ucc_901']."</a>";
} else {
echo "<div class='side-label'>".$locale['ucc_901']."</div>";
}

echo "<table align='center' cellpadding='0' cellspacing='0' width='90%'>";

echo "<tr><td class='side-small' >".$locale['ucc_954'].":</td><td>";

$result_a = dbcount("(user_id)", DB_USERS, "user_status='2'");

echo $result_a;

echo "</td></tr>
<tr><td class='side-small' >".$locale['ucc_953'].":</td><td>";

$result_n = dbcount("(user_code)", DB_NEW_USERS);

echo $result_n;

echo "</td></tr></table><br />";

echo "<table align='center' cellpadding='0' cellspacing='0' width='90%'><tr><td>";

if (checkrights("IP")){
echo "<a href='".INFUSIONS."user_control_center/ucc_admin.php".$aidlink."' class='side'>".$locale['ucc_100']."</a>";
} else {
echo "<div class='side-label'>".$locale['ucc_100']."</div>";
}

echo "<br>";




echo "
<br>
<form action='index.php'>
<select onchange='window.location.href=this.value' style='width:100%;' class='textbox'>
<option><i>SELECT</i></option>
<option value='".INFUSIONS."user_control_center/ucc_admin.php".$aidlink."'>User Control Center</option>
<option value='".INFUSIONS."user_control_center/redirects/a_imagecheck.php".$aidlink."'>UCC - Attachment checker</option>
<option value='".INFUSIONS."user_control_center/redirects/delete.php".$aidlink."'>UCC - Delete Members</option>
<option value='".INFUSIONS."user_control_center/redirects/imagecheck.php".$aidlink."'>UCC - Image Checker</option>
<option value='".INFUSIONS."user_control_center/redirects/lastlogin.php".$aidlink."'>UCC - Last Logins</option>
<option value='".INFUSIONS."user_control_center/redirects/pmcount.php".$aidlink."'>UCC - Pm Counter</option>
<option value='".INFUSIONS."user_control_center/redirects/postcount.php".$aidlink."'>UCC - Post Counter</option>
<option value='".INFUSIONS."user_control_center/redirects/postrecount.php".$aidlink."'>UCC - Postrecounter</option>
<option value='".INFUSIONS."user_control_center/redirects/remember.php".$aidlink."'>UCC - Remember Mail</option>
<option value='".INFUSIONS."user_control_center/redirects/_config_.php".$aidlink."'>UCC - Settings</option>
<option value='".INFUSIONS."user_control_center/redirects/unactiveusers.php".$aidlink."'>UCC - Unactivated User</option>
<option value='".INFUSIONS."user_control_center/redirects/usergroups.php".$aidlink."'>UCC - Usergroups</option>
<option value='".INFUSIONS."user_control_center/redirects/usersearch.php".$aidlink."'>UCC - Usersearch</option>
</select>
</form>
<br>
";


 if(function_exists('fsockopen'))
    {
      $version_new = version_check_ucc();
      if($version_new == ucc_db_version)
      {
	  echo "v".$version_new. " <font color='green'>-up-to-date-</font>";

      } else {
        if (!empty($version_new)) 
        {
	  echo "v".ucc_db_version." <font color='red'>-old-</font>";

       }
      }
    } 
	if (empty($version_new)) {

	echo "latest version unknown";
    }

echo "</td></tr></table>";

}

}
closesidex();
}
?>
