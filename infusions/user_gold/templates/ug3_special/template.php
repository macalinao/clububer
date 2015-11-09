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
| Filename: template.php
| Author: UG3 Developement Team
+--------------------------------------------------------+
| This program is released as free software under the
| Stars Heaven Licence. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included licence.html.
| Removal of this copyright header is strictly
| prohibited without written permission
| from the original author(s).
+--------------------------------------------------------*/if (!defined("IN_FUSION")) { die("Access Denied"); }

//Render Shop Intro
function render_shop_intro() {
	global $aidlink, $locale, $settings, $golddata, $_REQUEST, $_POST, $_GET;
	if (!isset($rowstart) || !isnum($rowstart)) { $rowstart = 0; }
	echo "<table width='100%' cellpadding='3' cellspacing='3' class='tbl-border'>\n<tr>\n";
	echo "<td valign='top' align='left'>\n";
	$limit = 6;

	$result = dbquery("SELECT * FROM ".DB_UG3_CATEGORIES." WHERE ".groupaccess("cat_access")." ORDER BY cat_name ASC LIMIT $rowstart,$limit");
	$rows = dbrows($result);
	if ($rows != 0) {
		$counter = 0; $columns = 3; $width=round(100/$columns); $i = 1; $start = 1; $align = "center";
		echo "<table cellpadding='0' cellspacing='0' width='100%' class='tbl-border'>\n<tr>\n";
		while ($data = dbarray($result)) {
			if ($counter != 0 && ($counter % $columns == 0)) {
				if ($start == 1) {
					$i = 2;
					$start = 2;
				} else {
					$i = 1;
					$start = 1;
				}
				echo "</tr>\n<tr>\n";
			}
			echo "<td align='$align' valign='top' width='$width%' height='100%' class='tbl$i'>\n";
			echo "<a href='".FUSION_SELF."?op=shop_start&amp;category=".$data['cat_id']."'>\n";
			echo "<img src='".GOLD_IMAGE_CAT.$data['cat_image']."' alt='".$data['cat_description']."' border='0'/><br />".$data['cat_name']."</a>\n";
			echo "</td>\n";
			if ($i == 1) {
				$i++;
			} else {
				$i = 1;
			}
			$counter++;
		}
		echo "</tr>\n</table>\n";
					
		$rows = dbcount("(*)", DB_UG3_CATEGORIES, groupaccess("cat_access"));
		if ($rows > $limit) echo "<div align='center' style='margin-top:5px;'>\n".makepagenav($rowstart, $limit, $rows, 3, FUSION_SELF."?op=shop_start&sort=".$_REQUEST['sort']."&sortDir=".$_REQUEST['sortDir']."&")."\n</div>\n";
					
	} else {
		echo "<table cellpadding='5' cellspacing='5' width='100%' class='tbl-border'>\n<tr>\n<td align='left'><strong>".$locale['urg_shop_120']."</strong></td>\n</tr>\n</table>\n";
	}
	echo "</td>\n";
	echo "<td valign='top' align='left' width='150px'>\n";
	echo "<table width='100%' cellpadding='3' cellspacing='3' class='tbl-border'>\n<tr>\n";
	echo "<td class='tbl2'><strong>".$locale['urg_shop_148']."</strong></td>\n";
	echo "</tr>\n";
	
	$result = dbquery("SELECT itemname, itemid, count(*) AS count FROM ".DB_UG3_INVENTORY." GROUP BY itemid ORDER BY count DESC LIMIT 5");
	if (dbrows($result)) {
		while ($data = dbarray($result)) {
			$item = dbarray(dbquery("SELECT * FROM ".DB_UG3_USAGE." WHERE id='".$data['itemid']."' LIMIT 1"));
			echo "<tr>\n";
			echo "<td><img src='".GOLD_IMAGE_ITEM.$item['image']."' alt='".$data['itemname']."' width='15px' height='15px' align='left' border='0'/>&nbsp;\n";
			echo "<a href='".FUSION_SELF."?op=shop_item&amp;id=".$item['id']."'>".trimlink($data['itemname'], 15)."</a></td>\n";
			echo "</tr>";
		}
	} else {
		echo "<tr><td>".$locale['urg_shop_149']."</td></tr>\n";
	}
	echo "</table>\n";
	echo "</td>\n</tr>\n</table>\n";
}

//Render the actual shop
function render_shop($field, $table, $conditions, $sortQuery, $sortDirQuery, $rowstart) {
	global $aidlink, $locale, $settings, $golddata, $_REQUEST, $_POST, $_GET;
	if (!isset($rowstart) || !isnum($rowstart)) { $rowstart = 0; }
	$limit = 8;
	
	$result = dbquery("SELECT $field FROM $table WHERE $conditions ORDER BY $sortQuery $sortDirQuery LIMIT $rowstart,$limit");
	$rows = dbrows($result);
	if ($rows != 0) {
		$counter = 0; $columns = 2; $width=round(100 / $columns); $i = 1; $start = 1; $align = "left";
		echo "<table cellpadding='0' cellspacing='0' width='100%' class='tbl-border'>\n<tr>\n";
		while ($data = dbarray($result)) {
			if ($counter != 0 && ($counter % $columns == 0)) {
				if ($start == 1) {
					$i = 2;
					$start = 2;
				} else {
					$i = 1;
					$start = 1;
				}
				echo "</tr>\n<tr>\n";
			}
			echo "<td align='$align' valign='top' width='$width%' height='100%' class='tbl$i'>\n";
			echo "<table>\n<tr>\n";
			echo "<td rowspan='5' valign='top' align='left' width='1%'>\n";
			echo "<img border='0' width='".UGLD_IMAGE_WIDTH."' height='".UGLD_IMAGE_HEIGHT."' src='".GOLD_IMAGE_ITEM.$data['image']."' /></td>\n";
			echo "<td><strong><a href='".FUSION_SELF."?op=shop_item&amp;id=".$data['id']."'>".$data['name']."</a></strong></td>\n";
			echo "</tr>\n<tr>\n";
			echo "<td>".$data['description']."</td>\n";
			echo "</tr>\n<tr>\n";
			echo "<td><u>".$locale['urg_shop_109']."</u> ".formatMoney($data['cost'])."</td>\n";
			echo "</tr>\n<tr>\n";
			echo "<td><u>".$locale['urg_shop_117']."</u> ".$data['stock']."</td>\n";
			echo "</tr>\n<tr>\n";
			echo "<td>\n";
			if ($golddata['cash'] >= $data['cost']) {
				echo "<a href='index.php?op=shop_finalise&amp;id=".$data['id']."&amp;return=".urlencode(FUSION_SELF."?op=shop_start&sort=".$_REQUEST['sort']."&sortDir=".$_REQUEST['sortDir']."&category=".$_REQUEST['category']."&rowstart=$rowstart")."'>".$locale['urg_shop_119']."</a>\n";
			} elseif ($data['stock'] == 0) {
				echo "<strong>".$locale['urg_shop_120']."</strong>\n";
			} else {
				echo "<span style='color:red;'>".sprintf($locale['urg_shop_121']." %s", formatMoney($data['cost'] - $golddata['cash']))."</span>\n";
			}
			echo "</td>\n</tr>\n</table>\n";
			echo "</td>\n";
			if ($i == 1) {
				$i++;
			} else {
				$i = 1;
			}
			$counter++;
		}
		echo "</tr>\n</table>\n";
		
		$rows = dbcount("(*)", $table, $conditions);
		if ($rows > $limit) echo "<div align='center' style='margin-top:5px;'>\n".makepagenav($rowstart, $limit, $rows, 3, FUSION_SELF."?op=shop_start&sort=".$_REQUEST['sort']."&sortDir=".$_REQUEST['sortDir']."&category=".$_REQUEST['category']."&")."\n</div>\n";
	} else {
		echo "<table cellpadding='5' cellspacing='5' width='100%' class='tbl-border'>\n<tr>\n<td align='left'><strong>".$locale['urg_shop_120']."</strong></td>\n</tr>\n</table>\n";
	}
}

//Render Shop Item
function render_item($item_id) {
	global $aidlink, $locale, $settings, $golddata, $_REQUEST, $_POST, $_GET;

	include INCLUDES."comments_include.php";
	include INCLUDES."ratings_include.php";
	
	echo "<table width='100%' cellpadding='0' cellspacing='0' class='tbl-border'>\n<tr>\n";
	echo "<td valign='top' align='left'>\n";			
	$result = dbquery("SELECT * FROM ".DB_UG3_USAGE." LEFT JOIN (".DB_UG3_CATEGORIES.")
				 ON (".DB_UG3_CATEGORIES.".cat_id = ".DB_UG3_USAGE.".category)
				 WHERE ".DB_UG3_USAGE.".id = '".$item_id."'
				 LIMIT 1");
	if (dbrows($result)) {
		$data = dbarray($result);
		if (checkgroup($data['cat_access'])) {
			echo "<table cellpadding='3' cellspacing='0' width='100%' class='tbl-border'>\n<tr>\n";
			echo "<td align='left' valign='top'>&nbsp;</td>\n";
			echo "<td algin='left' valign='top'><h3>".$data['name']."</h3></td>\n";
			echo "</tr><tr>\n";
			echo "<td align='left' valign='top'><img src='".GOLD_IMAGE_ITEM.$data['image']."' /></td>";
			echo "<td algin='left' valign='top'>".$data['description']."<br/><br />\n";
			echo "<u>".$locale['urg_shop_109']."</u> ".formatMoney($data['cost'])."<br /><br />\n";
			echo "<u>".$locale['urg_shop_117']."</u> ".$data['stock']."<br /><br />\n";
			if ($golddata['cash'] >= $data['cost']) {
				echo "<a href='index.php?op=shop_finalise&amp;id=".$data['id']."&amp;return=".urlencode(FUSION_SELF."?op=shop_start&category=".$data['category'])."'>".$locale['urg_shop_119']."</a>\n";
			} elseif ($data['stock'] == 0) {
				echo "<strong>".$locale['urg_shop_120']."</strong>\n";
			} else {
				echo "<span style='color:red;'>".sprintf($locale['urg_shop_121']." %s", formatMoney($data['cost'] - $golddata['cash']))."</span>\n";
			}
			echo "</td>\n";
			echo "</tr>\n</table>\n";
		} else {
			echo $locale['urg_shop_150'];
			pagerefresh('meta',3,FUSION_SELF.'?op=shop_start');
		}				
	} else {
		echo $locale['urg_shop_151'];
		pagerefresh('meta',3,FUSION_SELF.'?op=shop_start');
	}
	echo "</td>\n";
	echo "<td valign='top' align='left' width='150px'>\n";
	echo "<table width='100%' cellpadding='3' cellspacing='3' class='tbl-border'>\n<tr>\n";
	echo "<td class='tbl2'><strong>".$locale['urg_shop_152']."</strong></td>\n";
	echo "</tr>\n";
	$count = 0;
	$result = dbquery("SELECT ownerid FROM ".DB_UG3_INVENTORY." WHERE itemid = '".$item_id."' AND ownerid != '".$userdata['user_id']."' GROUP BY ownerid ORDER BY RAND()");
	if (dbrows($result)) {
		while ($data = dbarray($result)) {
			if ($count < 5) {
				$result2 = dbquery("SELECT itemid FROM ".DB_UG3_INVENTORY." WHERE ownerid = '".$data['ownerid']."' AND itemid != '".$item_id."' GROUP BY itemid ORDER BY RAND() LIMIT 5");
				while ($data2 = dbarray($result2)) {
					if ($count < 5) {
						$item = dbarray(dbquery("SELECT id, name, image FROM ".DB_UG3_USAGE." WHERE id = '".$data2['itemid']."' LIMIT 1"));
						echo "<tr>\n";
						echo "<td><img src='".GOLD_IMAGE_ITEM.$item['image']."' alt='".$data['itemname']."' width='15px' height='15px' align='left' /> \n";
						echo "<a href='".FUSION_SELF."?op=shop_item&amp;id=".$item['id']."'>".trimlink($item['name'], 15)."</a></td>\n";
						echo "</tr>\n";
						$count++;
					} else {
						break;
					}
				}
			} else {
				break;
			}
		}
	} else {
		echo "<tr><td>".$locale['urg_shop_153']."</td></tr>\n";
	}
	echo "</table>\n";
	echo "</td>\n</tr>\n</table>\n";
	echo "<div style='margin:5px'></div>\n";
	
	showcomments("S", DB_UG3_USAGE, "id", $_REQUEST['id'], FUSION_SELF."?op=shop_item&amp;id=".$_REQUEST['id']);
	showratings("S", $_REQUEST['id'], FUSION_SELF."?op=shop_item&amp;id=".$_REQUEST['id']);
}
?>