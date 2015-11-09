<?php
$item_action = stripinput($_GET['action']);
require_once "../../maincore.php";
if (!defined("IN_UBP")) { include "includes/core.php"; }
require UBP_BASE."includes/core.php";
include THEME."theme.php";
require SEOFUSION."subheader_include.php";
include UBP_BASE."includes/pagelinks.php";
echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">
<html>
<head><title>".$title."</title>
<link rel='stylesheet' href='".THEME."styles.css' type='text/css'>
</head>
<body bgcolor='$body_bg' text='$body_text'>\n";
###############################################
if (!isset($_GET['action'])){
	echo "In progress. Please be patient.";
} elseif ($action = "feed"){
	opentable("");
	closetable();
} elseif ($action = "use"){
	opentable("Using ".$item_data['name']);
	eval($item_data['action']);
	echo "<br /><br /><center>[<a href='javascript:window.close()'>Back to your inventory</a>]</center><br />";
	closetable();
}
###############################################
echo "</body>\n</html>\n";
?>
