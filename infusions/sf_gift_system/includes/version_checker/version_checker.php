<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: version_checker.php
| CVS Version: 1.1.1
| Author: Starefossen
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
if (!defined("IN_FUSION") || !checkrights("I")) { die("Access Denied"); }

include ("vc_config.php");

//The server where the version updater is located. DO NOT ALTER!
define("CHECK_SERVER", "http://version.starefossen.com");

//Checkmethod is prefered method when checking for version updates. DO NOT ALTER!
define("CHECK_METHOD", "rss"); 

define("CHECKER_IMAGES", CHECKER_PATH."version_checker/images/"); 

// URL Chercker by ktcb123@hotmail.com
function url_exists($url) {
	$url = str_replace("http://", "", $url);
    if (strstr($url, "/")) {
        $url = explode("/", $url, 2);
        $url[1] = "/".$url[1];
    } else {
        $url = array($url, "/");
    }

    $fh = fsockopen($url[0], 80, $errno, $errstr, 10);
    if ($fh) {
        fputs($fh,"GET ".$url[1]." HTTP/1.1\nHost:".$url[0]."\n\n");
        if (fread($fh, 22) == "HTTP/1.1 404 Not Found") { 
			return FALSE; 
		} else { 
			return TRUE;    
		}

    } else { 
		return FALSE;
	}
}

//Untag function, used for prsing xml feeds
function untag($string, $tag) {
	$tmpval = array();
	$preg = "|<$tag>(.*?)</$tag>|s";

	preg_match_all($preg, $string, $tags);
	foreach ($tags[1] as $tmpcont){
		$tmpval[] = $tmpcont;
	}
	return $tmpval;
}
//Functions END

// Version Checker Function
function checkversion($checkversion, $width='200', $border="dashed", $method=CHECK_METHOD, $dev = false, $version_server=CHECK_SERVER, $project_shortcut=CHECK_PROJECT_SC) {
	global $locale;
	
	//Set allow_urlfopen to true
	ini_set('allow_url_fopen', true);

	//URL Prefix
	$urlprefix = !strstr($version_server, "http://") ? "http://" : "";
	
	//Compelte URL to the rss feed
	$vf_url = "$urlprefix$version_server/infusions/version_updater/feed.php?project_sc=$project_shortcut&old_v=$checkversion".($dev == true ? "&dev" : ""); 

	//Download URL for new versions
	$vs_down = "$urlprefix$version_server/infusions/version_updater/download_updater.php?ps=$project_shortcut&amp;version=$checkversion".($dev == true ? "&amp;dev" : "");

	if (url_exists($vf_url)) {			
		if (ini_get('allow_url_fopen') == '1') {
			$feed = $vf_url;
			//Open conection to the feed
				$fp = fopen($feed, 'r');
				$xml = '';
				while (!feof($fp)) {
					$xml .= fread($fp, 128);
				}
				fclose($fp);
			//Connection closed and content stored
			//Render and display feed
				$items = untag($xml, 'item');
				$limit = 1; $count = 0;
				foreach ($items as $item) {
					if ($count == $limit) {
						break;
					} else {
						$count++;
					}
					$version = untag($item, 'title');
					$description = untag($item, 'description');
				}
			//Render og display done				
			if (!empty($version)) {
				//If a newer version is available 
				$return = "<table width='$width'>\n<tr>";
				$return .= "<td align='left' valign='top' style='border: $border'>\n";
				$return .= "<a href='$vs_down' target='_blank'>";
				$return .= "<img src='".CHECKER_IMAGES."download_update.png' align='right' title='".$locale['vup102']."' alt='".$locale['vup102']."' border='0' />\n";
				$return .= "</a>\n";
				$return .= "<img src='".CHECKER_IMAGES."version_old.gif' title='".$locale['vup101']."' alt='".$locale['vup101']."' border='0px' /><br />\n";
				$return .= "<strong>".$locale['vup104']."</strong> - v".$version[0]."\n";
				if ($method == "rss") {
					$return .= "<br />".$description[0]."\n";
				}
				$return .= "</td>\n";
				$return .= "</tr>\n</table>\n";
				return $return;
			} else {
				//Else if you have the lates version
				return "<img src='".CHECKER_IMAGES."version.gif' title='".$locale['vup100']."' alt='' />";
			}
		} else {
			//allow_url_fopen failture
			return $locale['vup105']."<br />".$locale['vup106']." <a href='".SUPPORT_SITE_URL."' target='_blank'>".SUPPORT_SITE_NAME."</a>.";
		}
	} else {
		//Else if the url to the version file dos not exist
		return $locale['vup103']."<a href='".SUPPORT_SITE_URL."' target='_BLANK'>".SUPPORT_SITE_NAME."</a>.";
	}
}

?>