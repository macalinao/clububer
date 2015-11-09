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
require_once "../../maincore.php";

require_once THEME."theme.php";
echo "<link rel='stylesheet' href='".THEME."styles.css' type='text/css'>";
if (!defined("LANGUAGE")) {
// PHPFusion environment
$this_lang =  str_replace("/", "", LOCALESET);
	if (file_exists(INFUSIONS."the_kroax/locale/".$this_lang.".php")) {
	   include INFUSIONS."the_kroax/locale/".$this_lang.".php";
	} else {
	   include INFUSIONS."the_kroax/locale/English.php";
	}
        } else {
// mFusion environment
$this_lang =  LANGUAGE;
	if (file_exists(INFUSIONS."the_kroax/locale/".$this_lang.".php")) {
	   include INFUSIONS."the_kroax/locale/".$this_lang.".php";
	} else {
	   include INFUSIONS."the_kroax/locale/English.php";
	}
}
if (isset($broken_id) && !isNum($broken_id)) fallback("index.php");

if (iMEMBER) {

$broken = dbquery("SELECT * FROM ".$db_prefix."kroax WHERE kroax_id='$broken_id'");
$broken1 = dbarray($broken);
$result = dbquery("UPDATE ".$db_prefix."kroax SET kroax_errorreport='1' WHERE kroax_id='$broken_id'");
$pm_subject = "".$locale['KROAX501']."";
$pm_message = "<br><b>".$locale['KROAX502']." ".$broken1['kroax_titel']."</b><br><b>".$locale['KROAX503']." ".$broken1['kroax_url']."</b><br><br>".$locale['KROAX402']." [URL]".$settings['siteurl']."infusions/the_kroax/admin/admin.php?a_page=errors[/URL] ".$locale['KROAX403']."";
$result1 = dbquery("INSERT INTO ".$db_prefix."messages (message_id, message_to, message_from, message_subject, message_message, message_smileys, message_read, message_datestamp, message_folder) VALUES('', '1', '".$userdata['user_id']."', '$pm_subject', '$pm_message', 'n', '0', '".time()."', '0')");
opentable($locale['KROAX504']);
Echo "
<table cellpadding='0' cellspacing='1' border='0' width='100%'align='middle' class='tbl-border'>
<tr><td width='1%' class='tbl2' style='white-space:nowrap'><b><center>".$locale['KROAX505']." ".$userdata['user_name']." !</center></b></td>
<tr><td class='tbl1' style='white-space:nowrap'>".$locale['KROAX506']." : <b>".$broken1['kroax_titel']."</b></td></tr>
<tr><td width='1%' class='tbl1' style='white-space:nowrap'>".$locale['KROAX507']." : <b>".$broken1['kroax_url']."</b></td></tr>
<tr><td width='1%' class='tbl2' style='white-space:nowrap'><b><center>".$locale['KROAX508']."</center></b></td></tr>
</a></b></td></tr></table><br><br>";
echo "<center>".$locale['KROAX509']." <a href='javascript:window.close();'><u><b>".$locale['KROAX510']."</u></b></a> ".$locale['KROAX511']."</center>";
closetable();
} else { 

opentable($locale['KROAX411']);
echo "".$locale['KROAX512']."";
closetable();

}

?>