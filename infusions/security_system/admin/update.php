<?php
if (!defined("IN_FUSION") || !iSUPERADMIN) {die();}
$secsys_version = "1.8.5";
$secsys_current_version=$sys_setting['version'];

$op = isset($_REQUEST['op']) && is_string($_REQUEST['op']) ? $_REQUEST['op'] : "start";
if (str_replace(".","",$secsys_current_version)<str_replace(".","",$secsys_version)) {

$mysql[] = "UPDATE ".DB_PREFIX."secsys_settings SET version='".$secsys_version."'";
// Update der Infusions und Amdin-Tabelle
$mysql[] = "UPDATE ".DB_PREFIX."infusions SET inf_version='".$secsys_version."' WHERE inf_folder='security_system'";

switch($op) {
case "start":
opentable("<font color='red'>".$locale['SUPD100']."</font>");
if (!empty($mysql)) {
echo "<div style='font-size:13px;'><ol>";
$nextlink="";
echo "<ol>";
foreach($mysql as $query) {
	echo "<li><code>".$query."</code></li>\n";
}
echo "</ol></div>\n";
echo "<form method='get' action='".FUSION_SELF."'>\n";
echo "<input type='hidden' name='pagefile' value='update'><input type='hidden' name='op' value='step1'>
<input type='hidden' name='do_update' value='1'><input type='submit' class='button' value='Schritt 1 / Step 1'>\n";
echo "</form>\n";	
} else {
echo "<form method='get' action='".FUSION_SELF."'>\n";	
echo "<input type='hidden' name='op' value='step2'><input type='submit' class='button' value='Schritt 2 / Step 2'>
</form>\n";	
}
closetable();
break;
case "step1":
opentable("<font color='red'>".$locale['SUPD100']."</font>");
echo "<div style='font-size:13px;'><ol>\n";
$res = "";
$errors = 0;
$nextlink="";
echo "<ol>";
$res = "";
$errors = 0;
foreach($mysql as $query) {
	if($do_update) {
		if(dbquery($query)) {
			$res = "<span class='small2'>OK</span>";
		} else {
			++$errors;
			$res = "<b>FEHLER/ERROR!</b>";
		}
		$res .= " - ";
	}
	echo "<li><code>".$res.$query."</code></li>\n";
}
echo "</ol></div>\n";

if($do_update) {
	if($errors) {
		echo "ERRORS: $errors <br>";
		echo "Check your database!<br>";
		die("<b>Fehler!</b>");
	} else {
		echo "<p><b>".$locale['SUBD102']."</b></p>";
	}
} 
closetable();
break;
}
} else {
function secsys_new_version()
{
	$url = "http://update.bs-fusion.de/security_system/version.txt";
	$url_p = @parse_url($url);
	$host = $url_p['host'];
	$port = isset($url_p['port']) ? $url_p['port'] : 80;
	$fp = @fsockopen($url_p['host'], $port, $errno, $errstr, 5);
	if(!$fp) return false;
	@fputs($fp, 'GET '.$url_p['path'].' HTTP/1.1'.chr(10));
	@fputs($fp, 'HOST: '.$url_p['host'].chr(10));
	@fputs($fp, 'Connection: close'.chr(10).chr(10));
	$response = @fgets($fp, 1024);
	$content = @fread($fp,1024);
	$content = preg_replace("#(.*?)text/plain(.*?)$#is","$2",$content);
	@fclose ($fp);
	if(preg_match("#404#",$response)) return "Timeout";
	else return trim(str_replace("X-Pad: avoid browser bug","",$content));
}	
$newversion=str_replace("X-Pad: avoid browser bug","",secsys_new_version());
$new_version=$newversion!="Timeout" && intval(str_replace(".","",$newversion)) > intval(str_replace(".","",$secsys_version)) ? true : false; 
if ($new_version) {
	opentable($locale['SUBD105']);
	echo $locale['SUBD106']." <a href='http://www.bs-fusion.de/infusions/pro_download_panel/download.php?catid=4' target='_blank'>BS-Fusion Security System</a> <font style='font-size:11px;'><i><b>v".str_replace("X-Pad: avoid browser bug","",$newversion)."</b></i></font>";
       closetable(); 
} elseif ($newversion=="Timeout") {
	opentable($locale['SUBD105']);
	echo $locale['SUBD111']." <a href='http://www.bs-fusion.de/infusions/pro_download_panel/download.php?catid=4' target='_blank'>BS-Fusion Security System</a>";
	closetable();
} else {
	opentable($locale['SUBD103']);
	echo $locale['SUBD104'];
	closetable();
}
	
}	 
?>
