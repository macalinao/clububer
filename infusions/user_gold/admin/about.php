<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| User Gold 3
| Copyright © 2007 - 2008 UG3 Developement Team
| http://www.starglowone.com/
+--------------------------------------------------------+
| Filename: about.php
| Author: UG3 Developement Team
+--------------------------------------------------------+
| This program is released as free software under the
| Stars Heaven Licence. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included licence.html.
| Removal of this copyright header is strictly
| prohibited without written permission
| from the original author(s).
+--------------------------------------------------------*/
require_once "header.php";

if (file_exists(GOLD_LANG.LOCALESET."admin/about.php")) {
	include GOLD_LANG.LOCALESET."admin/about.php";
} else {
	include GOLD_LANG."English/admin/about.php";
}

opentable($locale['urg_about_100']." ".$locale['urg_title']." ".GOLD_VERSION);
echo "<div class='tbl2'>".$locale['urg_about_101']."</div>\n";
echo "<div class='tbl1'>\n";
echo "<p>".$locale['urg_about_101']." (C) UG Development Team<br />";
echo $locale['urg_about_102']." <a href='http://www.starglowone.com/'>Stars Heaven</a><br />";
echo "</div>\n";

echo "<div class='tbl2'>".$locale['urg_about_103']."</div>\n";
echo "<div class='tbl1'>\n";
echo "<p><b>UG Development Team</b><br>\n";
echo "Stephan Hansson {StarglowOne}<br />\n";
echo "Hans Kristian Flaatten {Starefossen}<br />\n";
echo "Thomas Rosenhagen {Thomas}<br />\n";
echo "Tim Cox {Wolfcore}<br />\n";
echo "Lloyd McGennisken {AusiMods}<br />\n";
echo "Antoine Bomon {Puma} - ".$locale['urg_about_104']."<br />\n";

echo "<p><b>".$locale['urg_about_105']."</b><br>\n";
echo "Dik van Zanen {Dikkie}<br />\n";

echo "<p><b>".$locale['urg_about_106']."</b><br>\n";
echo "<a href='http://icon-king.com'>Nuvola Icons</a> - ".$locale['urg_about_107']." David Vignoni.<br />\n";
echo "<a href='http://javascriptkit.com'>JavaScript Kit</a> - ".$locale['urg_about_108'].".<br />\n";
echo "<a href='http://www.free-color-picker.com'>Free-Color-Picker.Com</a> - ".$locale['urg_about_109']."<br />\n";
echo "<a href='http://www.maani.us/'>Maani.Us</a> - ".$locale['urg_about_110']."<br />\n";
echo "</div>\n";
closetable();

require_once "footer.php";
?>