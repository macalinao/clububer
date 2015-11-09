<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Author: Domi & fetloser
| www.venue.nu			     	      
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
if (!checkRights("I")) { header("Location:../../../index.php"); exit; }


if (isset($update_settings)) {

$hi = stripinput($_POST['hi']);
$wi = stripinput($_POST['wi']);
$pre = stripinput($_POST['pre']);
$pic = stripinput($_POST['pic']);
$show = stripinput($_POST['show']);
$thumb = stripinput($_POST['thumb']);
$ffmpeg = stripinput($_POST['ffmpeg']);
$thumbs_per_row = stripinput($_POST['thumbs_per_row']);
$thumbs_per_page = stripinput($_POST['thumbs_per_page']);
$favorites = stripinput($_POST['favorites']);
$recommend = stripinput($_POST['recommend']);
$ratings = stripinput($_POST['ratings']);
$comments = stripinput($_POST['comments']);
$keepalive = stripinput($_POST['keepalive']);
$playingnow = stripinput($_POST['playingnow']);
$related = stripinput($_POST['related']);
$bannerimg = stripinput($_POST['bannerimg']); 
$reports = stripinput($_POST['reports']); 
$allowembed = stripinput($_POST['allowembed']); 
$allowdownloads = stripinput($_POST['allowdownloads']); 
$allowuploads = stripinput($_POST['allowuploads']); 
$allowplaylist = stripinput($_POST['allowplaylist']); 
$defaultview = stripinput($_POST['defaultview']); 

dbquery("UPDATE ".$db_prefix."kroax_set SET
kroax_set_hi = '".$hi."',
kroax_set_wi = '".$wi."',
kroax_set_pre = '".$pre."',
kroax_set_pic = '".$pic."',
kroax_set_show = '".$show."',
kroax_set_thumb= '".$thumb."',
kroax_set_ffmpeg= '".$ffmpeg."', 
kroax_set_thumbs_per_row = '".$thumbs_per_row."',
kroax_set_thumbs_per_page = '".$thumbs_per_page."',
kroax_set_favorites = '".$favorites."',
kroax_set_recommend = '".$recommend."',
kroax_set_ratings = '".$ratings."',
kroax_set_comments = '".$comments."',
kroax_set_keepalive = '".$keepalive."',
kroax_set_playingnow = '".$playingnow."',
kroax_set_bannerimg = '".$bannerimg."',
kroax_set_related = '".$related."',
kroax_set_allowembed = '".$allowembed."',
kroax_set_allowdownloads = '".$allowdownloads."',
kroax_set_allowuploads = '".$allowuploads."',
kroax_set_allowplaylist = '".$allowplaylist."',
kroax_set_defaultview = '".$defaultview."',
kroax_set_report = '".$reports."' 
WHERE kroax_set_id ='1'");
}

$read_options = dbquery("SELECT * FROM ".$db_prefix."kroax_set");
if (dbrows($read_options) != 0) {
$options = dbarray($read_options);

echo "
<form name='optionsform' method='post' action='".FUSION_SELF."?a_page=settings'>
<center><table border='0' cellpadding='0' cellspacing='0' width='100%' class='tbl-border'>";


echo "
	<tr>
            <td class='tbl1' width='30%' align='left'>".$locale['KROAX716']."</td>
            <td class='tbl1' width='20%'  align='left'>
            <select name='thumb' class='textbox'>
                <option value='1'".($options['kroax_set_thumb'] == "1" ? " selected" : "").">".$locale['KROAX705']."</option>
                <option value='0'".($options['kroax_set_thumb'] == "0" ? " selected" : "").">".$locale['KROAX707']."</option>
            </select></td>
            <td class='tbl1' width='50%' align='left'><span style='small'>".$locale['KROAX718']."</span></td>
	</tr>

	<tr>
            <td class='tbl1' width='30%' align='left'>".$locale['KROAX753']."</td>
            <td class='tbl1' width='20%'  align='left'>
            <select name='defaultview' class='textbox'>
                <option value='1'".($options['kroax_set_defaultview'] == "1" ? " selected" : "").">".$locale['KROAX754']."</option>
                <option value='0'".($options['kroax_set_defaultview'] == "0" ? " selected" : "").">".$locale['KROAX755']."</option>
            </select></td>
            <td class='tbl1' width='50%' align='left'><span style='small'>".$locale['KROAX756']."</span></td>
	</tr>


	<tr>
            <td class='tbl1' width='30%' align='left'>".$locale['KROAX719']."</td>
            <td class='tbl1' width='20%'  align='left'>
	   <input type='text' name='thumbs_per_row' value='".$options['kroax_set_thumbs_per_row']."' class='textbox' style='width:40px;'></td>
            <td class='tbl1' width='50%' align='left'><span style='small'>".$locale['KROAX709']."</span></td>
	</tr>

	<tr>
            <td class='tbl1' width='30%' align='left'>".$locale['KROAX720']."</td>
            <td class='tbl1' width='20%'  align='left'>
	   <input type='text' name='thumbs_per_page' value='".$options['kroax_set_thumbs_per_page']."' class='textbox' style='width:40px;'></td>
            <td class='tbl1' width='50%' align='left'><span style='small'>".$locale['KROAX709']."</span></td>
	</tr>

	<tr>
            <td class='tbl1' width='30%' align='left'>".$locale['KROAX721']."</td>
            <td class='tbl1' width='20%'  align='left'>
	   <input type='text' name='pic' value='".$options['kroax_set_pic']."' class='textbox' style='width:40px;'></td>
            <td class='tbl1' width='50%' align='left'><span style='small'>".$locale['KROAX709']."</span></td>
	</tr>

	<tr>
            <td class='tbl1' width='30%' align='left'>".$locale['KROAX710']."</td>
            <td class='tbl1' width='20%'  align='left'>
	   <input type='text' name='pre' value='".$options['kroax_set_pre']."' class='textbox' style='width:40px;'></td>
            <td class='tbl1' width='50%' align='left'><span style='small'>".$locale['KROAX709']."</span></td>
	</tr>

	<tr>
            <td class='tbl1' width='30%' align='left'>".$locale['KROAX713']."</td>
            <td class='tbl1' width='20%'  align='left'>
	   <input type='text' name='wi' value='".$options['kroax_set_wi']."' class='textbox' style='width:40px;'></td>
            <td class='tbl1' width='50%' align='left'><span style='small'>".$locale['KROAX709']."</span></td>
	</tr>

	<tr>
            <td class='tbl1' width='30%' align='left'>".$locale['KROAX714']."</td>
            <td class='tbl1' width='20%'  align='left'>
	   <input type='text' name='hi' value='".$options['kroax_set_hi']."' class='textbox' style='width:40px;'></td>
            <td class='tbl1' width='50%' align='left'><span style='small'>".$locale['KROAX709']."</span></td>
	</tr>


	<tr>
            <td class='tbl1' width='30%' align='left'>".$locale['KROAX722']."</td>
            <td class='tbl1' width='20%'  align='left'>
	   <input type='text' name='bannerimg' value='".$options['kroax_set_bannerimg']."' class='textbox' style='width:200px;'></td>
            <td class='tbl1' width='50%' align='left'><span style='small'>".$locale['KROAX723']."</span></td>
	</tr>

	<tr>
            <td class='tbl1' width='30%' align='left'>".$locale['KROAX724']."</td>
            <td class='tbl1' width='20%'  align='left'>
            <select name='show' class='textbox'>
                <option value='1'".($options['kroax_set_show'] == "1" ? " selected" : "").">".$locale['KROAX705']."</option>
                <option value='0'".($options['kroax_set_show'] == "0" ? " selected" : "").">".$locale['KROAX707']."</option>
            </select></td>
            <td class='tbl1' width='50%' align='left'><span style='small'>".$locale['KROAX725']."</span></td>
	</tr>

	<tr>
            <td class='tbl1' width='30%' align='left'>".$locale['KROAX726']."</td>
            <td class='tbl1' width='20%'  align='left'>
            <select name='ffmpeg' class='textbox'>
                <option value='1'".($options['kroax_set_ffmpeg'] == "1" ? " selected" : "").">".$locale['KROAX705']."</option>
                <option value='0'".($options['kroax_set_ffmpeg'] == "0" ? " selected" : "").">".$locale['KROAX707']."</option>
            </select></td>
            <td class='tbl1' width='50%' align='left'><span style='small'>".$locale['KROAX727']."</span></td>
	</tr>

	<tr>
            <td class='tbl1' width='30%' align='left'>".$locale['KROAX728']."</td>
            <td class='tbl1' width='20%'  align='left'>
            <select name='allowembed' class='textbox'>
                <option value='1'".($options['kroax_set_allowembed'] == "1" ? " selected" : "").">".$locale['KROAX705']."</option>
                <option value='0'".($options['kroax_set_allowembed'] == "0" ? " selected" : "").">".$locale['KROAX707']."</option>
            </select></td>
            <td class='tbl1' width='50%' align='left'><span style='small'>".$locale['KROAX729']."</span></td>
	</tr>

<tr>
            <td class='tbl1' width='30%' align='left'>".$locale['KROAX730']."</td>
            <td class='tbl1' width='20%'  align='left'>
            <select name='allowdownloads' class='textbox'>
                <option value='1'".($options['kroax_set_allowdownloads'] == "1" ? " selected" : "").">".$locale['KROAX705']."</option>
                <option value='0'".($options['kroax_set_allowdownloads'] == "0" ? " selected" : "").">".$locale['KROAX707']."</option>
            </select></td>
            <td class='tbl1' width='50%' align='left'><span style='small'>".$locale['KROAX731']."</span></td>
	</tr>

<tr>
            <td class='tbl1' width='30%' align='left'>".$locale['KROAX732']."</td>
            <td class='tbl1' width='20%'  align='left'>
            <select name='allowuploads' class='textbox'>
                <option value='1'".($options['kroax_set_allowuploads'] == "1" ? " selected" : "").">".$locale['KROAX705']."</option>
                <option value='0'".($options['kroax_set_allowuploads'] == "0" ? " selected" : "").">".$locale['KROAX707']."</option>
            </select></td>
            <td class='tbl1' width='50%' align='left'><span style='small'>".$locale['KROAX733']."</span></td>
	</tr>

	<tr>
            <td class='tbl1' width='30%' align='left'>".$locale['KROAX734']."</td>
            <td class='tbl1' width='20%'  align='left'>
            <select name='related' class='textbox'>
                <option value='1'".($options['kroax_set_related'] == "1" ? " selected" : "").">".$locale['KROAX705']."</option>
                <option value='0'".($options['kroax_set_related'] == "0" ? " selected" : "").">".$locale['KROAX707']."</option>
            </select></td>
            <td class='tbl1' width='50%' align='left'><span style='small'>".$locale['KROAX735']."</span></td>
	</tr>

	<tr>
            <td class='tbl1' width='30%' align='left'>".$locale['KROAX736']."</td>
            <td class='tbl1' width='20%'  align='left'>
            <select name='favorites' class='textbox'>
                <option value='1'".($options['kroax_set_favorites'] == "1" ? " selected" : "").">".$locale['KROAX705']."</option>
                <option value='0'".($options['kroax_set_favorites'] == "0" ? " selected" : "").">".$locale['KROAX707']."</option>
            </select></td>
            <td class='tbl1' width='50%' align='left'>".$locale['KROAX737']."<span style='small'></span></td>
	</tr>

	<tr>
            <td class='tbl1' width='30%' align='left'>".$locale['KROAX738']."</td>
            <td class='tbl1' width='20%'  align='left'>
            <select name='allowplaylist' class='textbox'>
                <option value='1'".($options['kroax_set_allowplaylist'] == "1" ? " selected" : "").">".$locale['KROAX705']."</option>
                <option value='0'".($options['kroax_set_allowplaylist'] == "0" ? " selected" : "").">".$locale['KROAX707']."</option>
            </select></td>
            <td class='tbl1' width='50%' align='left'><span style='small'>".$locale['KROAX739']."</span></td>
	</tr>


	<tr>
            <td class='tbl1' width='30%' align='left'>".$locale['KROAX740']."</td>
            <td class='tbl1' width='20%'  align='left'>
            <select name='recommend' class='textbox'>
                <option value='1'".($options['kroax_set_recommend'] == "1" ? " selected" : "").">".$locale['KROAX705']."</option>
                <option value='0'".($options['kroax_set_recommend'] == "0" ? " selected" : "").">".$locale['KROAX707']."</option>
            </select></td>
            <td class='tbl1' width='50%' align='left'><span style='small'>".$locale['KROAX741']."</span></td>
	</tr>

	<tr>
            <td class='tbl1' width='30%' align='left'>".$locale['KROAX742']."</td>
            <td class='tbl1' width='20%'  align='left'>
            <select name='ratings' class='textbox'>
                <option value='1'".($options['kroax_set_ratings'] == "1" ? " selected" : "").">".$locale['KROAX705']."</option>
                <option value='0'".($options['kroax_set_ratings'] == "0" ? " selected" : "").">".$locale['KROAX707']."</option>
            </select></td>
            <td class='tbl1' width='50%' align='left'><span style='small'>".$locale['KROAX743']."</span></td>
	</tr>

	<tr>
            <td class='tbl1' width='30%' align='left'>".$locale['KROAX744']."</td>
            <td class='tbl1' width='20%'  align='left'>
            <select name='comments' class='textbox'>
                <option value='1'".($options['kroax_set_comments'] == "1" ? " selected" : "").">".$locale['KROAX705']."</option>
                <option value='0'".($options['kroax_set_comments'] == "0" ? " selected" : "").">".$locale['KROAX707']."</option>
            </select></td>
            <td class='tbl1' width='50%' align='left'><span style='small'>".$locale['KROAX745']."</span></td>
	</tr>

	<tr>
            <td class='tbl1' width='30%' align='left'>".$locale['KROAX757']."</td>
            <td class='tbl1' width='20%'  align='left'>
            <select name='reports' class='textbox'>
                <option value='1'".($options['kroax_set_report'] == "1" ? " selected" : "").">".$locale['KROAX705']."</option>
                <option value='0'".($options['kroax_set_report'] == "0" ? " selected" : "").">".$locale['KROAX707']."</option>
            </select></td>
            <td class='tbl1' width='50%' align='left'><span style='small'>".$locale['KROAX746']."</span></td>
	</tr>

	<tr>
            <td class='tbl1' width='30%' align='left'>".$locale['KROAX747']."</td>
            <td class='tbl1' width='20%'  align='left'>
            <select name='keepalive' class='textbox'>
                <option value='1'".($options['kroax_set_keepalive'] == "1" ? " selected" : "").">".$locale['KROAX705']."</option>
                <option value='0'".($options['kroax_set_keepalive'] == "0" ? " selected" : "").">".$locale['KROAX707']."</option>
            </select></td>
            <td class='tbl1' width='50%' align='left'><span style='small'>".$locale['KROAX748']."</span></td>
	</tr>

	<tr>
            <td class='tbl1' width='30%' align='left'>".$locale['KROAX749']."</td>
            <td class='tbl1' width='20%'  align='left'>
            <select name='playingnow' class='textbox'>
                <option value='1'".($options['kroax_set_playingnow'] == "1" ? " selected" : "").">".$locale['KROAX705']."</option>
                <option value='0'".($options['kroax_set_playingnow'] == "0" ? " selected" : "").">".$locale['KROAX707']."</option>
            </select></td>
            <td class='tbl1' width='50%' align='left'><span style='small'>".$locale['KROAX750']."</span></td>
	</tr>

           <td class='tbl1' colspan='3' align='center'><br><input type='submit' name='update_settings' value='".$locale['KROAX711']."' class='button'></td>";

if ($options['kroax_set_version'] < "7.1") {
echo "<tr><b><td class='tbl1' colspan='3' align='center'><font color='red'>".$locale['KROAX751']." !<br>| <a href='admin.php?a_page=settings&upgrade'>Upgrade from any prev version (warning all media dates will be set to current date & time)</a> |<br> | <a href='admin.php?a_page=settings&upgrade52'>Upgrade 5.1 > 5.2</a> |</b> | <a href='admin.php?a_page=settings&upgrade53'>Upgrade 5.2 > 5.3</a> |</b></font>| <a href='admin.php?a_page=settings&upgrade54'>Upgrade 5.3 > 5.4</a> |</b></font>| <a href='admin.php?a_page=settings&V7upgrade'>Upgrade to PHP-Fusion 7 !</a> |</td></tr>";
} else {
//Do nothing
}
}
if (isset($upgrade)) {
//Upgradeing from any version with this..

$result = dbquery("ALTER TABLE ".$db_prefix."kroax_set ADD roax_set_show VARCHAR( 20 ) NOT NULL AFTER  kroax_set_copy");
$result = dbquery("ALTER TABLE ".$db_prefix."kroax CHANGE kroax_spare1 kroax_access VARCHAR(10)");
$result = dbquery("ALTER TABLE ".$db_prefix."kroax_kategori ADD kroax_namn_access VARCHAR(10) NOT NULL AFTER kroax_namn_cat1");
$result = dbquery("UPDATE ".$db_prefix."kroax_kategori SET kroax_namn_access='0' WHERE kroax_namn_access=''");
$result = dbquery("UPDATE ".$db_prefix."kroax SET kroax_access='0' WHERE kroax_access=''");
$result = dbquery("ALTER TABLE ".$db_prefix."kroax ADD kroax_access_cat VARCHAR(10) NOT NULL AFTER kroax_access");
$result = dbquery("UPDATE ".$db_prefix."kroax SET kroax_access_cat='0' WHERE kroax_access_cat=''");
$result = dbquery("SELECT * FROM ".$db_prefix."kroax");
while ($data = dbarray($result)) {
$kroax_cat=$data['kroax_cat'];
$k_access =$data['kroax_access'];
$id=$data['kroax_id'];
$detect = dbquery("SELECT * FROM ".$db_prefix."kroax_kategori WHERE kroax_namn_cat1='$kroax_cat'");
echo $kroax_cat;
while ($detect_access = dbarray($detect)) {
$access = $detect_access['kroax_namn_access'];
echo"[".$id."] New access: ".$access." Old access: ".$k_access."<br>";
$result4 = dbquery("UPDATE ".$db_prefix."kroax SET kroax_access_cat='$access' WHERE kroax_id='$id'");
}
}
$result = dbquery("ALTER TABLE ".$db_prefix."kroax CHANGE kroax_spare2 kroax_spare2 text not null");
$result = dbquery("UPDATE ".$db_prefix."admin SET admin_link='../infusions/the_kroax/admin/admin.php' WHERE admin_image='the_kroax.jpg'");
$result = dbquery("ALTER TABLE ".$db_prefix."kroax_kategori ADD kroax_cat_img VARCHAR(20) NOT NULL AFTER kroax_namn_access");
$result = dbquery("UPDATE ".$db_prefix."kroax_kategori SET kroax_cat_img='0' WHERE kroax_cat_img=''");
$result = dbquery("ALTER TABLE ".$db_prefix."kroax_set ADD kroax_set_thumb VARCHAR(10) NOT NULL AFTER kroax_set_show");
$result = dbquery("UPDATE ".$db_prefix."kroax_set SET kroax_set_thumb='1'");

//Here starts 5.1 changes..
//some propper nameing
$result = dbquery("ALTER TABLE ".$db_prefix."kroax_kategori CHANGE kroax_id_cat cid smallint(5)");
$result = dbquery("ALTER TABLE ".$db_prefix."kroax_kategori CHANGE kroax_namn_cat1 title varchar(40)");
$result = dbquery("ALTER TABLE ".$db_prefix."kroax_kategori CHANGE kroax_namn_access access varchar(10)");
$result = dbquery("ALTER TABLE ".$db_prefix."kroax_kategori CHANGE kroaX_cat_img image varchar(30)");

//So we need to set it right in kroax table too..
$result = dbquery("SELECT * FROM ".$db_prefix."kroax_kategori");
while ($data = dbarray($result)) {
$update = dbquery("UPDATE ".$db_prefix."kroax SET kroax_cat='".$data['cid']."' WHERE kroax_cat='".$data['title']."'");
}
//While we are at it, lets add the support for subcats & a status support on that..
$update2 = dbquery("ALTER TABLE ".$db_prefix."kroax_kategori ADD parentid int(10) NOT NULL AFTER image");
$update3 = dbquery("ALTER TABLE ".$db_prefix."kroax_kategori ADD status int(10) NOT NULL AFTER parentid");
//Lets make all categories available..
$update4 = dbquery("UPDATE ".$db_prefix."kroax_kategori SET status='1'");
//Some propper nameing of kroax tables
$result = dbquery("ALTER TABLE ".$db_prefix."kroax CHANGE kroax_spare3 kroax_lastplayed int(10)");
$result = dbquery("ALTER TABLE ".$db_prefix."kroax CHANGE kroax_date kroax_date int(10)");
$result = dbquery("ALTER TABLE ".$db_prefix."kroax CHANGE kroax_spare2 kroax_embed text");
$result = dbquery("ALTER TABLE ".$db_prefix."kroax CHANGE kroax_spare4 kroax_downloads int(10)");
//We need to fix the dates, sorry this will blow all dates out and put it to current.
$result = dbquery("UPDATE ".$db_prefix."kroax set kroax_date ='".time()."'");
$upgrade = dbquery("ALTER TABLE ".$db_prefix."kroax_set ADD kroax_set_thumbs_per_row  int(10) NOT NULL default '0' AFTER kroax_set_thumb");
$upgrade = dbquery("UPDATE ".$db_prefix."kroax_set SET kroax_set_thumbs_per_row='4'");
$upgrade = dbquery("ALTER TABLE ".$db_prefix."kroax_set ADD kroax_set_thumbs_per_page  int(10) NOT NULL default '0' AFTER kroax_set_thumbs_per_row");
$upgrade = dbquery("UPDATE ".$db_prefix."kroax_set SET kroax_set_thumbs_per_page='16'");
$upgrade = dbquery("ALTER TABLE ".$db_prefix."kroax_set ADD kroax_set_ffmpeg  int(10) NOT NULL default '0' AFTER kroax_set_thumbs_per_page");
$upgrade = dbquery("UPDATE ".$db_prefix."kroax_set SET kroax_set_ffmpeg='0'");
$upgrade = dbquery("ALTER TABLE ".$db_prefix."kroax_set ADD kroax_set_favorites  int(10) NOT NULL default '0' AFTER kroax_set_ffmpeg");
$upgrade = dbquery("UPDATE ".$db_prefix."kroax_set SET kroax_set_favorites ='1'");
$upgrade = dbquery("ALTER TABLE ".$db_prefix."kroax_set ADD kroax_set_recommend int(10) NOT NULL default '0' AFTER kroax_set_favorites");
$upgrade = dbquery("UPDATE ".$db_prefix."kroax_set SET kroax_set_recommend ='1'");
$upgrade = dbquery("ALTER TABLE ".$db_prefix."kroax_set ADD kroax_set_ratings int(10) NOT NULL default '0' AFTER kroax_set_recommend");
$upgrade = dbquery("UPDATE ".$db_prefix."kroax_set SET kroax_set_ratings ='1'");
$upgrade = dbquery("ALTER TABLE ".$db_prefix."kroax_set ADD kroax_set_comments int(10) NOT NULL default '0' AFTER kroax_set_ratings");
$upgrade = dbquery("UPDATE ".$db_prefix."kroax_set SET kroax_set_comments ='1'");
$upgrade = dbquery("ALTER TABLE ".$db_prefix."kroax_set ADD kroax_set_keepalive int(10) NOT NULL default '0' AFTER kroax_set_comments");
$upgrade = dbquery("UPDATE ".$db_prefix."kroax_set SET kroax_set_keepalive ='1'");
$upgrade = dbquery("ALTER TABLE ".$db_prefix."kroax_set ADD kroax_set_playingnow int(10) NOT NULL default '0' AFTER kroax_set_keepalive");
$upgrade = dbquery("UPDATE ".$db_prefix."kroax_set SET kroax_set_playingnow ='1'");
$upgrade = dbquery("ALTER TABLE ".$db_prefix."kroax_set ADD kroax_set_bannerimg VARCHAR(100) NOT NULL default '0' AFTER kroax_set_playingnow");
$upgrade = dbquery("UPDATE ".$db_prefix."kroax_set SET kroax_set_bannerimg ='img/logo.gif'");
$upgrade = dbquery("ALTER TABLE ".$db_prefix."kroax_set ADD kroax_set_related int(10) NOT NULL default '0' AFTER kroax_set_bannerimg");
$upgrade = dbquery("UPDATE ".$db_prefix."kroax_set SET kroax_set_related ='1'");
$upgrade = dbquery("ALTER TABLE ".$db_prefix."kroax_set ADD kroax_set_report int(10) NOT NULL default '0' AFTER kroax_set_related");
$upgrade = dbquery("UPDATE ".$db_prefix."kroax_set SET kroax_set_report ='1'");
$upgrade = dbquery("ALTER TABLE ".$db_prefix."kroax_set ADD kroax_set_allowembed int(10) NOT NULL default '0' AFTER kroax_set_report");
$upgrade = dbquery("UPDATE ".$db_prefix."kroax_set SET kroax_set_allowembed ='1'");
$upgrade = dbquery("ALTER TABLE ".$db_prefix."kroax_set ADD kroax_set_allowdownloads int(10) NOT NULL default '0' AFTER kroax_set_allowembed");
$upgrade = dbquery("UPDATE ".$db_prefix."kroax_set SET kroax_set_allowdownloads ='1'");
$upgrade = dbquery("ALTER TABLE ".$db_prefix."kroax_set ADD kroax_set_allowplaylist int(10) NOT NULL default '0' AFTER kroax_set_allowdownloads");
$upgrade = dbquery("UPDATE ".$db_prefix."kroax_set SET kroax_set_allowplaylist ='1'");
$upgrade = dbquery("ALTER TABLE ".$db_prefix."kroax_set ADD kroax_set_allowuploads int(10) NOT NULL default '0' AFTER kroax_set_allowplaylist");
$upgrade = dbquery("UPDATE ".$db_prefix."kroax_set SET kroax_set_allowuploads ='1'");
//5.2
$upgrade = dbquery("ALTER TABLE ".$db_prefix."kroax_set ADD kroax_set_defaultview int(10) NOT NULL default '0' AFTER kroax_set_allowuploads");
$upgrade = dbquery("UPDATE ".$db_prefix."kroax_set SET kroax_set_defaultview ='1'");
//end 5.2
$upgrade = dbquery("ALTER TABLE ".$db_prefix."kroax_set ADD kroax_set_version varchar(10) NOT NULL default '0' AFTER kroax_set_defaultview");

$result = dbquery("CREATE TABLE ".DB_PREFIX."kroax_favourites (
  `fav_id` int(30) NOT NULL default '0',
  `fav_user` int(30) NOT NULL default '0',
  `fav_date` int(10) NOT NULL default '0'
) TYPE=MyISAM; ");
$result = dbquery("CREATE TABLE ".DB_PREFIX."kroax_active (
 `movie_id` int(10) NOT NULL default '0',
  `title` varchar(50) NOT NULL default '0',
  `icon` varchar(50) NOT NULL default '0',
  `lastactive` int(10) unsigned NOT NULL default '0'
) TYPE=MyISAM; ");
$result = dbquery("CREATE TABLE ".DB_PREFIX."kroax_activeusr (
 `movie_id` int(10) NOT NULL default '0',
  `member` int(10) NOT NULL default '0',
  `user_ip` varchar(20) NOT NULL default '0',
  `lastactive` int(10) unsigned NOT NULL default '0'
) TYPE=MyISAM; ");
$upgrade = dbquery("UPDATE ".$db_prefix."kroax_set SET kroax_set_version='5.4'");
$upgrade = dbquery("UPDATE ".$db_prefix."infusions SET inf_version='5.4' WHERE inf_title='Kroax'");
//Trying Some ninja hack to fix the admin link issue atleast one person seem to have...
$result = dbquery("UPDATE ".$db_prefix."admin SET admin_link='../infusions/the_kroax/admin/admin.php' WHERE admin_image='../../infusions/the_kroax/img/the_kroax.jpg'");
$result = dbquery("UPDATE ".$db_prefix."admin SET admin_link='../infusions/the_kroax/admin/admin.php' WHERE admin_image='the_kroax.jpg'");
redirect(INFUSIONS."the_kroax/admin/admin.php?a_page=settings");
}

if (isset($upgrade52)) {
$upgrade = dbquery("ALTER TABLE ".$db_prefix."kroax_set ADD kroax_set_defaultview int(10) NOT NULL default '0' AFTER kroax_set_allowuploads");
$upgrade = dbquery("UPDATE ".$db_prefix."kroax_set SET kroax_set_defaultview ='1'");
$upgrade = dbquery("UPDATE ".$db_prefix."kroax_set SET kroax_set_version='5.4'");
$upgrade = dbquery("UPDATE ".$db_prefix."infusions SET inf_version='5.4' WHERE inf_title='Kroax'");
redirect(INFUSIONS."the_kroax/admin/admin.php?a_page=settings");
}

if (isset($upgrade53)) {
$upgrade = dbquery("UPDATE ".$db_prefix."kroax_set SET kroax_set_version='5.4'");
$upgrade = dbquery("UPDATE ".$db_prefix."infusions SET inf_version='5.4' WHERE inf_title='Kroax'");
redirect(INFUSIONS."the_kroax/admin/admin.php?a_page=settings");
}

if (isset($upgrade54)) {
$upgrade = dbquery("UPDATE ".$db_prefix."kroax_set SET kroax_set_version='5.4'");
$upgrade = dbquery("UPDATE ".$db_prefix."infusions SET inf_version='5.4' WHERE inf_title='Kroax'");
redirect(INFUSIONS."the_kroax/admin/admin.php?a_page=settings");
}

if (isset($V7upgrade)) {
//Old ratings need to go.
$result = dbquery("DROP TABLE ".$db_prefix."kroax_ratings");
//Here we go with a new system
$result = dbquery("CREATE TABLE ".DB_PREFIX."kroax_rating (
`id` varchar(11) NOT NULL default '',
`total_votes` int(11) NOT NULL default '0',
`total_value` int(11) NOT NULL default '0',
`which_id` int(11) NOT NULL default '0',
`used_ips` longtext,
 PRIMARY KEY  (`id`)
) TYPE=MyISAM;");

$result = dbquery("UPDATE ".$db_prefix."kroax_set SET kroax_set_version='7.1'");
$upgrade = dbquery("UPDATE ".$db_prefix."infusions SET inf_version='7.1' WHERE inf_title='The kroax'");
redirect(INFUSIONS."the_kroax/admin/admin.php?a_page=settings");

}


echo "</table></center></form>";

?>