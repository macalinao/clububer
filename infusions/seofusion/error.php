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
+----------------------------------------------------*/

require_once "../../maincore.php";

$folder_level = "";
while (!file_exists($folder_level."config.php")) { $folder_level .= "../"; }
require_once $folder_level."config.php";
define("BASEDIR", $folder_level);

if ($userdata['user_theme'] != "Default" && file_exists($settings['siteurl']."themes/".$userdata['user_theme']."/theme.php")) {
	define("THEME_ERROR", BASEDIR."themes/".$userdata['user_theme']."/");
} else {
	define("THEME_ERROR", BASEDIR."themes/".$settings['theme']."/");
}

$error_no = stripinput($_GET['error_no']);

switch($error_no) {
   case 401:
	header("HTTP/1.1 401 Unauthorized");
	$title = "401 Unauthorized";
	$text = "Grr says, \"You are unauthorized!\"";
   break;

   case 403:
	header("HTTP/1.1 403 Forbidden");
	$title = "403 Forbidden";
	$text = "Grr says, \"I forbid you to enter this place!\"";
   break;

   case 404:
	header("HTTP/1.1 404 Not Found");
	$title = "404 Not Found";
	$text = "Sorry, but the page you requested was not found.";
   break;

   case 500:
	header("HTTP/1.1 500 Internal Server Error");
	$title = "500 Internal Server Error";
	$text = "There was an error with the server.";
   break;
   
   default:
	$title = "Unknown Error";
	$text = "There is an unknown error!!!! 0_o";
   break;
}

include THEME_ERROR."theme.php";

unset($_SERVER['QUERY_STRING']);
echo "<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN'>
<html>
<head>
<title>".$settings['sitename']." :: ".$title."</title>
<meta http-equiv='Content-Type' content='text/html; charset=".$locale['charset']."'>
<meta name='robots' content='NOINDEX,NOFOLLOW'>
<meta name='description' content='".$settings['description']."'>
<meta name='keywords' content='".$settings['keywords']."'>
<link rel='stylesheet' href='".THEME."styles.css' type='text/css'>
</head>
<body class='tbl2'>

<table width='100%' height='100%'>
<tr>
<td>

<table align='center' cellpadding='0' cellspacing='1' width='80%' class='tbl-border'>
<tr>
<td class='tbl1'>
<center><br>
<a href='".$settings['siteurl']."home.html'><img src='".$settings['siteurl'].$settings['sitebanner']."' alt='".$settings['sitename']."' border='0' title='".$settings['sitename']."'></a><br><br>";
echo "<hr noshade>";
echo "
<b>".$title."</b>
<br />
".$text."";
echo "<br></p>";
echo "<a href='".$settings['siteurl']."home.html'><h3>Home</h3></a><br><br>
Powered by <a href='http://www.php-fusion.co.uk'>PHP-Fusion</a> &copy; 2003-2005<br><br>
</center>
</td>
</tr>
</table>\n";
echo "</td>
</tr>
</table>\n";
echo "</body>
</html>\n";


mysql_close();
ob_end_flush();
?>