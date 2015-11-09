<?php
//COPYRIGHT REMOVAL IS NOT ALLOWED
if (UGLD_VISABLECOPY) {
	echo "<div align='center' class='small'>".$locale['urg_title']." ".GOLD_VERSION." &copy; 2007-2008 <a href='http://www.starglowone.com'>".$locale['urg_dev']." @ Stars Heaven</a></div>\n";
} else {
	echo '<a href="http://www.starglowone.com" target="_blank" name="copywrite"><!-- '.$locale['urg_global_100'].' '.$locale['urg_title'].' '.GOLD_VERSION.' --></a>';
}
//COPYRIGHT REMOVAL IS NOT ALLOWED
require_once THEMES."templates/footer.php";
?>