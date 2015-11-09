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
require_once THEMES."templates/header.php";

if (!defined("LANGUAGE")) {
// PHPFusion environment
$this_lang =  str_replace("/", "", LOCALESET);
	if (file_exists(INFUSIONS."varcade/locale/".$this_lang.".php")) {
	   include INFUSIONS."varcade/locale/".$this_lang.".php";
	} else {
	   include INFUSIONS."varcade/locale/English.php";
	}
        } else {
// mFusion environment
$this_lang =  LANGUAGE;
	if (file_exists(INFUSIONS."varcade/locale/".$this_lang.".php")) {
	   include INFUSIONS."varcade/locale/".$this_lang.".php";
	} else {
	   include INFUSIONS."varcade/locale/English.php";
	}
}

if (isset($broken_id) && !isNum($broken_id)) fallback("index.php");

if (iMEMBER) {

$broken = dbquery("SELECT * FROM ".$db_prefix."varcade_games WHERE lid='$broken_id'");
$broken1 = dbarray($broken);
$result = dbquery("UPDATE ".$db_prefix."varcade_games SET errorreport='1' WHERE lid='$broken_id'");
$pm_subject = "".$locale['VARC501']."";
$pm_message = "<br><b>".$locale['VARC502']." ".$broken1['title']."</b><br><b>".$locale['VARC503']." ".$broken1['title']."</b><br><br>[URL]".$settings['siteurl']."infusions/varcade/admin/admin.php?a_page=errors[/URL] ";
$result1 = dbquery("INSERT INTO ".$db_prefix."messages (message_id, message_to, message_from, message_subject, message_message, message_smileys, message_read, message_datestamp, message_folder) VALUES('', '1', '".$userdata['user_id']."', '$pm_subject', '$pm_message', 'n', '0', '".time()."', '0')");
opentable($locale['VARC504']);
echo "
<table cellpadding='0' cellspacing='1' border='0' width='100%'align='middle' class='tbl-border'>
<tr><td width='1%' class='tbl2' style='white-space:nowrap'><b><center>".$locale['VARC505']." ".$userdata['user_name']." !</center></b></td>
<tr><td class='tbl1' style='white-space:nowrap'>".$locale['VARC506']." : <b>".$broken1['title']."</b></td></tr>
<tr><td width='1%' class='tbl2' style='white-space:nowrap'><b><center>".$locale['VARC508']."</center></b></td></tr>
</a></b></td></tr></table><br><br>";
//echo "<center>".$locale['VARC509']." <a href='javascript:window.close();'><u><b>".$locale['VARC510']."</u></b></a> ".$locale['VARC511']."</center>";
echo '<center><a href="javascript:history.go(-1)"><B class="button">&nbsp;'.$locale['VARC175'].'&nbsp;</B></a></center>';

closetable();
} else { 
opentable($locale['VARC411']);
echo "".$locale['VARC512']."";
echo '<center><a href="javascript:history.go(-1)"><B class="button">&nbsp;'.$locale['VARC175'].'&nbsp;</B></a></center>';
closetable();
}
require_once THEMES."templates/footer.php";
?>