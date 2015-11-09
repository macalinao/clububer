<?php
/*---------------------------------------------------+
| PHP-Fusion 6 Content Management System
+----------------------------------------------------+
| Copyright � 2002 - 2007 Nick Jones
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


@include "config.php";
include "maincore.php";
include THEME."theme.php";
echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">
<html>
<head><title>".$settings['sitename']."</title>
<link rel='stylesheet' href='".THEME."styles.css' type='text/css'>
</head>
<body bgcolor='$body_bg' text='$body_text'>\n";
$msg_count = dbcount("(message_id)", "messages", "message_to='".$userdata['user_id']."' AND message_read='0'");
opentable(Messages);
echo"<center> Hello ".$userdata[user_name]."!<p>
You have received a new private message!<p>";
if ($msg_count==1) {
echo "There is ".$msg_count." message in your inbox!<br>";
}
else {
echo "There are ".$_COOKIE["fusion_privmessages"]." messages in your inbox!<br>";
}
echo "<br><a href=\"javascript:;\" onclick=\"opener.location='".BASEDIR."messages.html';self.close()\">
Go to Private Messages Folder</a><p>
<a href='javascript:self.close()'>Close this Window</a></center>";
closetable();
?>