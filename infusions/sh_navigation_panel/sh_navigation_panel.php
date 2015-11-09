<?php	
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| SH Navigation Panel v1.0beta
| Copyright © 2008 Stephan Hansson (StarglowOne)
| http://www.starglowone.com/
+--------------------------------------------------------+
| Filename: sh_navigation_panel.php
| Author: Stephan Hansson (StarglowOne)
| Original Author: Nick Jones (Digitanium)
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
if (!defined("IN_FUSION")) { die("Access Denied"); }
add_to_head('<link rel="stylesheet" href="'.INFUSIONS.'sh_navigation_panel/inc/sh_navigation.css" type="text/css" media="screen" />');
add_to_head('<script type="text/javascript" src="'.INFUSIONS.'sh_navigation_panel/inc/jquery.cookie.js"></script>');
add_to_head('<script type="text/javascript" src="'.INFUSIONS.'sh_navigation_panel/inc/sh_navigation.js"></script>');
$list_open = false;

openside($locale['global_001']);
$result = dbquery(
	"SELECT tl.link_name, tl.link_url, tl.link_window, tl.link_order FROM ".DB_SITE_LINKS." tl
	WHERE ".groupaccess('tl.link_visibility')." AND link_position<='2'
	ORDER BY link_order"
);
if (dbrows($result)) {
	echo "<div id='navigation'>\n"; // start sidebar
	while($data = dbarray($result)) {
		if ($data['link_name'] != "---" && $data['link_url'] == "---") {
			if ($list_open) { echo "</ul></div>\n"; $list_open = false; }
			$linkname = preg_replace('/[. -]+/', '_', $data['link_name']);
			if (file_exists(INFUSIONS."sh_navigation_panel/images/".strtolower($linkname).".png")) {
				$nav_img = "<img src='".INFUSIONS."sh_navigation_panel/images/".strtolower($linkname).".png' border='0' alt='".$linkname."' />&nbsp;\n";
			} else {
				$nav_img = "";
			}			
			echo "<h2 id='".$linkname."Link'>".$nav_img.$data['link_name']."</h2>\n";
			echo "<div id='".$linkname."Content'>\n";
		} else if ($data['link_name'] == "---" && $data['link_url'] == "---") {
			if ($list_open) { echo "</ul></div>\n"; $list_open = false; }
		} else {
			if (!$list_open) { echo "<ul>\n"; $list_open = true; }
			$link_target = ($data['link_window'] == "1" ? " target='_blank'" : "");
			if (strstr($data['link_url'], "http://") || strstr($data['link_url'], "https://")) {
				echo "<li><a href='".$data['link_url']."'".$link_target." class='side'>".THEME_BULLET." <span>".$data['link_name']."</span></a></li>\n";
			} else {
				echo "<li><a href='".BASEDIR.$data['link_url']."'".$link_target." class='side'>".THEME_BULLET." <span>".$data['link_name']."</span></a></li>\n";
			}
		}
	}
	if ($list_open) { echo "</ul></div>\n"; }
	echo "</div>\n"; // end sidebar
	
} else {
	echo $locale['global_002'];
}
closeside();
?>