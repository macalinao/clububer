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
$thumbs_per_row = stripinput($_POST['thumbs_per_row']);
$thumbs_per_page = stripinput($_POST['thumbs_per_page']);
$allow_guest_play = stripinput($_POST['allow_guest_play']);
$showsize = stripinput($_POST['showsize']);
$favorites = stripinput($_POST['favorites']);
$recommend = stripinput($_POST['recommend']);
$ratings = stripinput($_POST['ratings']);
$sound = stripinput($_POST['sound']);
$comments = stripinput($_POST['comments']);
$hiscorepm = stripinput($_POST['hiscorepm']);
$popup = stripinput($_POST['popup']);
$flashdetection = stripinput($_POST['flashdetection']);
$tournaments = stripinput($_POST['tournaments']);
$touringp = stripinput($_POST['touringp']);
$reports = stripinput($_POST['reports']);
$usergold = stripinput($_POST['usergold']);
$keepalive = stripinput($_POST['keepalive']);
$playingnow = stripinput($_POST['playingnow']);
$ingameopts = stripinput($_POST['ingameopts']);
$related = stripinput($_POST['related']);
$bannerimg = stripinput($_POST['bannerimg']);


dbquery("UPDATE ".$db_prefix."varcade_settings SET
thumbs_per_row = '".$thumbs_per_row."',
thumbs_per_page = '".$thumbs_per_page."',
allow_guest_play = '".$allow_guest_play."',
showsize = '".$showsize."',
favorites = '".$favorites."',
recommend = '".$recommend."',
ratings = '".$ratings."',
sound = '".$sound."',
comments = '".$comments."',
hiscorepm = '".$hiscorepm."',
popup = '".$popup."',
flashdetection  = '".$flashdetection."',
tournaments = '".$tournaments."',
touringp = '".$touringp."',
usergold = '".$usergold."',
keepalive = '".$keepalive."',
playingnow = '".$playingnow."',
bannerimg = '".$bannerimg."',
ingameopts = '".$ingameopts."',
related = '".$related."',
reports = '".$reports."' 
WHERE id ='1'");
}

$read_options = dbquery("SELECT * FROM ".$db_prefix."varcade_settings");
if (dbrows($read_options) != 0) {
$options = dbarray($read_options);

echo "
<form name='optionsform' method='post' action='".FUSION_SELF."?a_page=settings'>
<center><table border='0' cellpadding='0' cellspacing='0' width='100%' class='tbl-border'>";


if ($options['usergold'] == "1")
{
if(!(dbquery("SELECT * FROM  ".$db_prefix."users_points")))
{
echo "<tr><b><td class='tbl1' colspan='3' align='center'><font color='red'>".$locale['VARC2391']." | <a href='admin.php?a_page=settings&goldtable'>".$locale['VARC2392']."</a> |</b></font></td></tr>";
}
}

echo "
	<tr>
            <td class='tbl1' width='30%' align='left'>".$locale['VARC356']."</td>
            <td class='tbl1' width='20%'  align='left'>
	   <input type='text' name='thumbs_per_row' value='".$options['thumbs_per_row']."' class='textbox' style='width:40px;'></td>
            <td class='tbl1' width='50%' align='left'><span style='small'>".$locale['VARC357']."</span></td>
	</tr>

	<tr>
            <td class='tbl1' width='30%' align='left'>".$locale['VARC358']."</td>
            <td class='tbl1' width='20%'  align='left'>
	   <input type='text' name='thumbs_per_page' value='".$options['thumbs_per_page']."' class='textbox' style='width:40px;'></td>
            <td class='tbl1' width='50%' align='left'><span style='small'>".$locale['VARC359']."</span></td>
	</tr>

	<tr>
            <td class='tbl1' width='30%' align='left'>".$locale['VARC2397']."</td>
            <td class='tbl1' width='20%'  align='left'>
	   <input type='text' name='bannerimg' value='".$options['bannerimg']."' class='textbox' style='width:200px;'></td>
            <td class='tbl1' width='50%' align='left'><span style='small'>".$locale['VARC2398']."</span></td>
	</tr>

	<tr>
            <td class='tbl1' width='30%' align='left'>".$locale['VARC2393']."</td>
            <td class='tbl1' width='20%'  align='left'>
            <select name='ingameopts' class='textbox'>
                <option value='1'".($options['ingameopts'] == "1" ? " selected" : "").">".$locale['VARC2389']."</option>
                <option value='0'".($options['ingameopts'] == "0" ? " selected" : "").">".$locale['VARC2390']."</option>
            </select></td>
            <td class='tbl1' width='50%' align='left'><span style='small'>".$locale['VARC2394']."</span></td>
	</tr>

	<tr>
            <td class='tbl1' width='30%' align='left'>".$locale['VARC2395']."</td>
            <td class='tbl1' width='20%'  align='left'>
            <select name='related' class='textbox'>
                <option value='1'".($options['related'] == "1" ? " selected" : "").">".$locale['VARC2389']."</option>
                <option value='0'".($options['related'] == "0" ? " selected" : "").">".$locale['VARC2390']."</option>
            </select></td>
            <td class='tbl1' width='50%' align='left'><span style='small'>".$locale['VARC2396']."</span></td>
	</tr>

	<tr>
            <td class='tbl1' width='30%' align='left'>".$locale['VARC360']."</td>
            <td class='tbl1' width='20%'  align='left'>
            <select name='allow_guest_play' class='textbox'>
                <option value='1'".($options['allow_guest_play'] == "1" ? " selected" : "").">".$locale['VARC2389']."</option>
                <option value='0'".($options['allow_guest_play'] == "0" ? " selected" : "").">".$locale['VARC2390']."</option>
            </select></td>
            <td class='tbl1' width='50%' align='left'><span style='small'>".$locale['VARC361']."</span></td>
	</tr>

	<tr>
            <td class='tbl1' width='30%' align='left'>".$locale['VARC362']."</td>
            <td class='tbl1' width='20%'  align='left'>
            <select name='hiscorepm' class='textbox'>
                <option value='1'".($options['hiscorepm'] == "1" ? " selected" : "").">".$locale['VARC2389']."</option>
                <option value='0'".($options['hiscorepm'] == "0" ? " selected" : "").">".$locale['VARC2390']."</option>
            </select></td>
            <td class='tbl1' width='50%' align='left'><span style='small'>".$locale['VARC363']."</span></td>
	</tr>

	<tr>
            <td class='tbl1' width='30%' align='left'>".$locale['VARC364']."</td>
            <td class='tbl1' width='20%'  align='left'>
            <select name='showsize' class='textbox'>
                <option value='1'".($options['showsize'] == "1" ? " selected" : "").">".$locale['VARC2389']."</option>
                <option value='0'".($options['showsize'] == "0" ? " selected" : "").">".$locale['VARC2390']."</option>
            </select></td>
            <td class='tbl1' width='50%' align='left'><span style='small'>".$locale['VARC365']."</span></td>
	</tr>

	<tr>
            <td class='tbl1' width='30%' align='left'>".$locale['VARC366']."</td>
            <td class='tbl1' width='20%'  align='left'>
            <select name='favorites' class='textbox'>
                <option value='1'".($options['favorites'] == "1" ? " selected" : "").">".$locale['VARC2389']."</option>
                <option value='0'".($options['favorites'] == "0" ? " selected" : "").">".$locale['VARC2390']."</option>
            </select></td>
            <td class='tbl1' width='50%' align='left'><span style='small'>".$locale['VARC367']."</span></td>
	</tr>

	<tr>
            <td class='tbl1' width='30%' align='left'>".$locale['VARC368']."</td>
            <td class='tbl1' width='20%'  align='left'>
            <select name='recommend' class='textbox'>
                <option value='1'".($options['recommend'] == "1" ? " selected" : "").">".$locale['VARC2389']."</option>
                <option value='0'".($options['recommend'] == "0" ? " selected" : "").">".$locale['VARC2390']."</option>
            </select></td>
            <td class='tbl1' width='50%' align='left'><span style='small'>".$locale['VARC369']."</span></td>
	</tr>

	<tr>
            <td class='tbl1' width='30%' align='left'>".$locale['VARC370']."</td>
            <td class='tbl1' width='20%'  align='left'>
            <select name='ratings' class='textbox'>
                <option value='1'".($options['ratings'] == "1" ? " selected" : "").">".$locale['VARC2389']."</option>
                <option value='0'".($options['ratings'] == "0" ? " selected" : "").">".$locale['VARC2390']."</option>
            </select></td>
            <td class='tbl1' width='50%' align='left'><span style='small'>".$locale['VARC371']."</span></td>
	</tr>

	<tr>
            <td class='tbl1' width='30%' align='left'>".$locale['VARC372']."</td>
            <td class='tbl1' width='20%'  align='left'>
            <select name='comments' class='textbox'>
                <option value='1'".($options['comments'] == "1" ? " selected" : "").">".$locale['VARC2389']."</option>
                <option value='0'".($options['comments'] == "0" ? " selected" : "").">".$locale['VARC2390']."</option>
            </select></td>
            <td class='tbl1' width='50%' align='left'><span style='small'>".$locale['VARC373']."</span></td>
	</tr>

	<tr>
            <td class='tbl1' width='30%' align='left'>".$locale['VARC374']."</td>
            <td class='tbl1' width='20%'  align='left'>
            <select name='sound' class='textbox'>
                <option value='1'".($options['sound'] == "1" ? " selected" : "").">".$locale['VARC2389']."</option>
                <option value='0'".($options['sound'] == "0" ? " selected" : "").">".$locale['VARC2390']."</option>
            </select></td>
            <td class='tbl1' width='50%' align='left'><span style='small'>".$locale['VARC375']."</span></td>
	</tr>

	<tr>
            <td class='tbl1' width='30%' align='left'>".$locale['VARC376']."</td>
            <td class='tbl1' width='20%'  align='left'>
            <select name='reports' class='textbox'>
                <option value='1'".($options['reports'] == "1" ? " selected" : "").">".$locale['VARC2389']."</option>
                <option value='0'".($options['reports'] == "0" ? " selected" : "").">".$locale['VARC2390']."</option>
            </select></td>
            <td class='tbl1' width='50%' align='left'><span style='small'>".$locale['VARC377']."</span></td>
	</tr>

	<tr>
            <td class='tbl1' width='30%' align='left'>".$locale['VARC378']."</td>
            <td class='tbl1' width='20%'  align='left'>
            <select name='popup' class='textbox'>
                <option value='1'".($options['popup'] == "1" ? " selected" : "").">".$locale['VARC2389']."</option>
                <option value='0'".($options['popup'] == "0" ? " selected" : "").">".$locale['VARC2390']."</option>
            </select></td>
            <td class='tbl1' width='50%' align='left'><span style='small'>".$locale['VARC379']."</span></td>
	</tr>

	<tr>
            <td class='tbl1' width='30%' align='left'>".$locale['VARC2380']."</td>
            <td class='tbl1' width='20%'  align='left'>
            <select name='flashdetection' class='textbox'>
                <option value='1'".($options['flashdetection'] == "1" ? " selected" : "").">".$locale['VARC2389']."</option>
                <option value='0'".($options['flashdetection'] == "0" ? " selected" : "").">".$locale['VARC2390']."</option>
            </select></td>
            <td class='tbl1' width='50%' align='left'><span style='small'>".$locale['VARC2381']."</span></td>
	</tr>

	<tr>
            <td class='tbl1' width='30%' align='left'>".$locale['VARC2382']."</td>
            <td class='tbl1' width='20%'  align='left'>
            <select name='tournaments' class='textbox'>
                <option value='1'".($options['tournaments'] == "1" ? " selected" : "").">".$locale['VARC2389']."</option>
                <option value='0'".($options['tournaments'] == "0" ? " selected" : "").">".$locale['VARC2390']."</option>
            </select></td>
            <td class='tbl1' width='50%' align='left'><span style='small'>".$locale['VARC2383']."</span></td>
	</tr>

	<tr>
            <td class='tbl1' width='30%' align='left'>".$locale['VARC2384']."</td>
            <td class='tbl1' width='20%'  align='left'>
            <select name='touringp' class='textbox'>
                <option value='1'".($options['touringp'] == "1" ? " selected" : "").">".$locale['VARC2389']."</option>
                <option value='0'".($options['touringp'] == "0" ? " selected" : "").">".$locale['VARC2390']."</option>
            </select></td>
            <td class='tbl1' width='50%' align='left'><span style='small'>".$locale['VARC2385']."</span></td>
	</tr>

	<tr>
            <td class='tbl1' width='30%' align='left'>".$locale['GARC100']."</td>
            <td class='tbl1' width='20%'  align='left'>
            <select name='usergold' class='textbox'>
                <option value='1'".($options['usergold'] == "1" ? " selected" : "").">".$locale['VARC2389']."</option>
                <option value='0'".($options['usergold'] == "0" ? " selected" : "").">".$locale['VARC2390']."</option>
            </select></td>
            <td class='tbl1' width='50%' align='left'><span style='small'>".$locale['GARC101']."</span></td>
	</tr>

	<tr>
            <td class='tbl1' width='30%' align='left'>".$locale['GARC102']."</td>
            <td class='tbl1' width='20%'  align='left'>
            <select name='keepalive' class='textbox'>
                <option value='1'".($options['keepalive'] == "1" ? " selected" : "").">".$locale['VARC2389']."</option>
                <option value='0'".($options['keepalive'] == "0" ? " selected" : "").">".$locale['VARC2390']."</option>
            </select></td>
            <td class='tbl1' width='50%' align='left'><span style='small'>".$locale['GARC103']."</span></td>
	</tr>

	<tr>
            <td class='tbl1' width='30%' align='left'>".$locale['VARC2399']."</td>
            <td class='tbl1' width='20%'  align='left'>
            <select name='playingnow' class='textbox'>
                <option value='1'".($options['playingnow'] == "1" ? " selected" : "").">".$locale['VARC2389']."</option>
                <option value='0'".($options['playingnow'] == "0" ? " selected" : "").">".$locale['VARC2390']."</option>
            </select></td>
            <td class='tbl1' width='50%' align='left'><span style='small'>".$locale['VARC2400']."</span></td>
	</tr>


           <td class='tbl1' colspan='3' align='center'><br><input type='submit' name='update_settings' value='".$locale['VARC2386']."' class='button'></td>";

if ($options['version'] < "1.7") {
echo "<tr><b><td class='tbl1' colspan='3' align='center'><font color='red'>".$locale['VARC2387']." | <a href='admin.php?a_page=settings&upgrade'>".$locale['VARC2389']."</a> |</b></font><font color='red'>".$locale['VARC2387']." | <a href='admin.php?a_page=settings&V7upgrade'>Upgrade to PHP-Fusion 7 !</a> |</b></font></td></tr>";
} else {
//Do nothing
}
}
if (isset($upgrade)) {
$upgrade = dbquery("ALTER TABLE ".$db_prefix."varcade_games ADD cost int(10) NOT NULL default '0' AFTER hiscoredate");
$upgrade= dbquery("ALTER TABLE ".$db_prefix."varcade_games ADD reward int(10) NOT NULL default '0' AFTER cost");
$upgrade = dbquery("ALTER TABLE ".$db_prefix."varcade_games ADD bonus int(10) NOT NULL default '0' AFTER reward");
$upgrade = dbquery("ALTER TABLE ".$db_prefix."varcade_settings ADD usergold CHAR(1) NOT NULL default '0' AFTER touringp");
$upgrade = dbquery("ALTER TABLE ".$db_prefix."varcade_settings ADD bannerimg VARCHAR(50) NOT NULL default '0' AFTER related");
$upgrade = dbquery("ALTER TABLE ".$db_prefix."varcade_settings ADD playingnow CHAR(1) NOT NULL default '0' AFTER bannerimg");
$upgrade = dbquery("ALTER TABLE ".$db_prefix."varcade_settings ADD keepalive CHAR(1) NOT NULL default '0' AFTER usergold");
$upgrade = dbquery("ALTER TABLE ".$db_prefix."varcade_settings ADD ingameopts CHAR(1) NOT NULL default '0' AFTER keepalive");
$upgrade = dbquery("ALTER TABLE ".$db_prefix."varcade_settings ADD related CHAR(1) NOT NULL default '0' AFTER ingameopts");
$resulta = dbquery("CREATE TABLE ".DB_PREFIX."varcade_active (
 `game_id` int(10) NOT NULL default '0',
  `title` varchar(50) NOT NULL default '',
  `icon` varchar(50) NOT NULL default '',
  `lastactive` int(10) unsigned NOT NULL default '0'
) TYPE=MyISAM; ");
$resultb = dbquery("CREATE TABLE ".DB_PREFIX."varcade_activeusr (
 `game_id` int(10) NOT NULL default '0',
  `player` int(10) NOT NULL default '0',
  `user_ip` varchar(20) NOT NULL default '0',
  `lastactive` int(10) unsigned NOT NULL default '0'
) TYPE=MyISAM; ");
$resultc = dbquery("UPDATE ".$db_prefix."varcade_games SET hi_player='0' WHERE reverse='1'");
$resultd = dbquery("UPDATE ".$db_prefix."varcade_games SET hiscore='0' WHERE reverse='1'"); //dosent really do any differance but for the sake of it we reset this one!
$upgrade = dbquery("UPDATE ".$db_prefix."admin SET admin_image='arcade.gif' WHERE admin_title ='VArcade'");
$upgrade = dbquery("UPDATE ".$db_prefix."varcade_settings SET version='1.6'");
$upgrade = dbquery("UPDATE ".$db_prefix."infusions SET inf_version='1.6' WHERE inf_title='VArcade'");
redirect(INFUSIONS."varcade/admin/admin.php?a_page=settings");
}

if (isset($V7upgrade)) {
//Old ratings need to go.
$result = dbquery("DROP TABLE ".$db_prefix."varcade_ratings");
//Here we go with a new system
$result = dbquery("CREATE TABLE ".DB_PREFIX."varcade_rating (
`id` varchar(11) NOT NULL default '',
`total_votes` int(11) NOT NULL default '0',
`total_value` int(11) NOT NULL default '0',
`which_id` int(11) NOT NULL default '0',
`used_ips` longtext,
 PRIMARY KEY  (`id`)
) TYPE=MyISAM;");

$result = dbquery("UPDATE ".$db_prefix."varcade_settings SET version='1.7'");
$upgrade = dbquery("UPDATE ".$db_prefix."infusions SET inf_version='1.7' WHERE inf_title='VArcade'");
redirect(INFUSIONS."varcade/admin/admin.php?a_page=settings");

}

if (isset($goldtable)) {
$result = dbquery("CREATE TABLE IF NOT EXISTS ".$db_prefix."users_points (  owner_id int(5) NOT NULL default '0',  owner_name varchar(100) NOT NULL default '',  points_total int(20) NOT NULL default '0',  PRIMARY KEY  (owner_id))");
redirect(INFUSIONS."varcade/admin/admin.php?a_page=settings");
}
echo "</table></center></form>";

?>