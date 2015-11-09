<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--- ----------------------------------------------------+
| UBERPETS V 0.0.0.5
+--------------------------------------------------------+
| Uberpets Copyright 2008 Grr@µsoft inc.
| http://www.clububer.com/
\*-------------------------------------------------------*/

// LOAD STANDARD MODULES

//Defining the core definition
if (defined("IN_FUSION")) { define("IN_UBP",TRUE); }

//BASE

define("UBP_BASE", INFUSIONS."uberpets/");


//Ignoring Guests...
if (iMEMBER) {
//Initialize Database
require INFUSIONS."uberpets/infusion_db.php";

//Loading settings...
$uberpets_settings = dbarray(dbquery("SELECT * FROM ".DB_UBERPETS_SETTINGS.""));

//Adding title (V7)...
if (preg_match("/^[7]./", $settings['version'])) {
	if (!function_exists("ubpt")) {
		add_to_title(" - Uberpets");	
	} else {
		ubpt();
		add_to_title(" - Uberpets - ".$ubpt);
	}
}

#################################
#       COMMON CONSTANTS        #
#################################

#################################

	
#################################
#         PAGE INCLUDES         #
#################################

$pets_of_user = dbrows(dbquery("SELECT * FROM ".DB_UBERPETS_PETS." WHERE uid=".$userdata['user_id'].""));

#################################
#           ARRAYS              #
#################################

/*----------------------------*\
| ARRAY $usr
\*----------------------------*/
$usr = dbarray(dbquery("SELECT * FROM ".DB_UBERPETS_USER." WHERE uid=".$userdata['user_id']));

/*----------------------------*\
| ARRAY $pet
\*----------------------------*/

# 1

$userpet_0_o_1 = dbarray(dbquery("SELECT * FROM ".DB_UBERPETS_PETS." WHERE uid='".$userdata['user_id']."' AND usrpet=1"));
$userpet_species_0_o_1 = dbarray(dbquery("SELECT * FROM ".DB_UBERPETS_PET_SPECIES." WHERE name='".$userpet_0_o_1['species']."'"));
$pet1 = array(
	"p" => $userpet_0_o_1,
	"s" => $userpet_species_0_o_1
);

# 2

$userpet_0_o_2 = dbarray(dbquery("SELECT * FROM ".DB_UBERPETS_PETS." WHERE uid=".$userdata['user_id']." AND usrpet=2"));
$userpet_species_0_o_2 = dbarray(dbquery("SELECT * FROM ".DB_UBERPETS_PET_SPECIES." WHERE name='".$userpet_0_o_2['species']."'"));
$pet2 = array(
	"p" => $userpet_0_o_2,
	"s" => $userpet_species_0_o_2
);

# 3

$userpet_0_o_3 = dbarray(dbquery("SELECT * FROM ".DB_UBERPETS_PETS." WHERE uid=".$userdata['user_id']." AND usrpet=3"));
$userpet_species_0_o_3 = dbarray(dbquery("SELECT * FROM ".DB_UBERPETS_PET_SPECIES." WHERE name='".$userpet_0_o_3['species']."'"));
$pet3 = array(
	"p" => $userpet_0_o_3,
	"s" => $userpet_species_0_o_3
);

# 4

$userpet_0_o_4 = dbarray(dbquery("SELECT * FROM ".DB_UBERPETS_PETS." WHERE uid=".$userdata['user_id']." AND usrpet=4"));
$userpet_species_0_o_4 = dbarray(dbquery("SELECT * FROM ".DB_UBERPETS_PET_SPECIES." WHERE name='".$userpet_0_o_4['species']."'"));
$pet4 = array(
	"p" => $userpet_0_o_4,
	"s" => $userpet_species_0_o_4
);

$pet = array(
1 => $pet1,
2 => $pet2,
3 => $pet3,
4 => $pet4
);

/*----------------------------*\
| ARRAY $petdata
\*----------------------------*/

$userpet_0_o = dbarray(dbquery("SELECT * FROM ".DB_UBERPETS_PETS." WHERE uid=".$userdata['user_id']." AND active=1"));
$userpet_species_0_o = dbarray(dbquery("SELECT * FROM ".DB_UBERPETS_PET_SPECIES." WHERE name='".$userpet_0_o['species']."'"));
$petdata = array(
	"p" => $userpet_0_o,
	"s" => $userpet_species_0_o
);

/*----------------------------*\
| ARRAY $petimgpath
\*----------------------------*/

$petimgpath = array(
1 => UBP_BASE."pets/".$pet1['p']['type']."/".$pet1['s']['folder']."/".$pet1['p']['color']."/",
2 => UBP_BASE."pets/".$pet2['p']['type']."/".$pet2['s']['folder']."/".$pet2['p']['color']."/",
3 => UBP_BASE."pets/".$pet3['p']['type']."/".$pet3['s']['folder']."/".$pet3['p']['color']."/",
4 => UBP_BASE."pets/".$pet4['p']['type']."/".$pet4['s']['folder']."/".$pet4['p']['color']."/",
"active" => UBP_BASE."pets/".$petdata['p']['type']."/".$petdata['s']['folder']."/".$petdata['p']['color']."/"
);





#################################
#          FUNCTIONS            #
#################################

/*------------------------------+
 | FUNCTION copyright();
 +------------------------------+
 | Usage: copyright();
 +------------------------------+
 | Displays a copyright footer.
 +------------------------------+
 | Example: copyright();
 +- - - - - - - - - - - - - - - +
 | Displays the copyright.      
 \*----------------------------*/
 
function copyright() {
	echo "<!--Go to www.clububer.com ! //-->
	<table cellpadding='0' cellspacing='0' align='center' width='100%'>
	<tr><td><div class='small'><center>UberPets Virtual Pet System Copyright 
	&copy; 2008-Forever Grr @ <a href='http://www.clububer.com/' target='_blank'>
	&mu;soft</a></center></div></td></tr></table>";
}
/*------------------------------+
 | FUNCTION keepin();
 +------------------------------+
 | Usage: keepin($level);
 +------------------------------+
 | Keeps a type of user into the
 | page while blocking all other
 | types out.
 +------------------------------+
 | Example: keepin(iSUPERADMIN);
 +- - - - - - - - - - - - - - - +
 | Keeps Super Admins in.
 \*----------------------------*/
function keepin($level){
	if (!$level) { header("Location:../../../index.php"); exit; }
}

function ubpadmin(){
	if (preg_match("/^[6]./",$settings['version'])) {
		if (!checkrights("I")) { header("Location:../../../index.php"); exit; }
	}
	elseif (preg_match("/^[7]./", $settings['version'])) {
		if (!checkrights("UBP")) { header("Location:../../../index.php"); exit; }
	}	
}

function tblbreak(){
	if (preg_match("/^[6]./",$settings['version'])) {
		tablebreak();
	}	
}
/*------------------------------+
 | FUNCTION render_error();
 +------------------------------+
 | Usage: render_error($title, 
 | $error, $history);
 +------------------------------+
 | Displays an error page.
 +------------------------------+
 | Example: render_error("Restricted",
 | "You may not enter.", "-1");
 +- - - - - - - - - - - - - - - +
 | Displays a page with the title
 | "Restricted". The content is
 | a centered "Oops!" and under
 | it "You may not enter.".
 | A back button is displayed
 | going back one page. 
 \*----------------------------*/
function render_error($error_title, $error_desc, $error_history){
	redirect(UBP_BASE."error.php?error_title=".$error_title."&error_desc=".$error_desc."&error_history=".$error_history."");
}

function shop_item($price){
	takegold($userdata['user_name'], $userdata['user_id'], $price);
}
/*
function show_item($iid, $type = "image"){
	$cur_item_result = dbquery("SELECT * FROM ".DB_UBERPETS_ITEMS." WHERE iid='$iid'");
	$cur_item = dbarray($cur_item_result);
	var_dump($cur_item);
	echo "<br />";
	echo $cur_item['name'];
	if ($type = "inventory") { // The inventory display
		echo "<center>";
		echo "<img src='".UBP_BASE."images/items/".$cur_item['image']."' border='0' alt='".$cur_item['name']."' /><br />\n";
		echo "<b>".$cur_item['name']."</b>Hi<br />";	
		echo "</center>";
	} elseif ($type = "shop") { // With the shop
		echo "<center>";
		echo "<img src='".UBP_BASE."images/items/".$cur_item['image']."' border='0' alt='".$cur_item['name']."' /><br />\n";
		echo "</center>";
	} elseif ($type = "image") { // With image only
		echo "<center>";
		echo "<img src='".UBP_BASE."images/items/".$cur_item['image']."' border='0' alt='".$cur_item['name']."' /><br />\n";
		echo "</center>";
	}
}
*/
function show_item($iid, $type){
	$type = "image";
	$cur_item_query = "SELECT * FROM ".DB_UBERPETS_ITEMS." WHERE iid='$iid'";
	$cur_item_result = mysql_query($cur_item_query) or die(mysql_error);
	echo "<br />";
	while($row = mysql_fetch_assoc($cur_item_result)) {
		$name = "{$row['name']}";
	echo $name;
		$image = "{$row['image']}";
	}
	if ($type = "inventory") {
		echo "<center>";
		echo "<img src='".UBP_BASE."images/items/".$image."' border='0' alt='".$name."' /><br />";
		echo "</center>";
	} else if ($type = "shop") { // With the shop
		echo "<center>";
		echo "<img src='".UBP_BASE."images/items/".$image."' border='0' alt='".$name."' /><br />";
		echo "</center>";
	} else if ($type = "image") { // With image only
		echo "<center>";
		echo "<img src='".UBP_BASE."images/items/".$image."' border='0' alt='".$name."' /><br />";
		echo "</center>";
	}
}
//To ignore guests
}

#################################

//Load locale
if (file_exists(UBP_BASE."locale/".$settings['locale'].".php")) {
	include UBP_BASE."locale/".$settings['locale'].".php";
} else {
	include UBP_BASE."locale/English.php";
}
?>
