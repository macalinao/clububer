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
| Filename: shop.inc.php
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
if (!defined("IN_FUSION")) { die("Access Denied"); }

if (file_exists(GOLD_LANG.LOCALESET."shop.php")) {
	include_once GOLD_LANG.LOCALESET."shop.php";
} else {
	include_once GOLD_LANG."English/shop.php";
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function shop_menu() { //Shop system start page
	global $locale, $golddata;
	table_top($locale['urg_shop_100']);
	echo "<table width='100%' cellpadding='3' cellspacing='3' class='tbl-border'>\n<tr>\n";
	echo "<td><h3>".$locale['urg_shop_101a']."</h3></td>\n";
	echo "<td rowspan='3' align='right' valign='bottom'><img src='".GOLD_IMAGE."logo_shop.png' alt='logo_shop' /></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td>".$locale['urg_shop_101b']."</td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td>".$locale['urg_shop_101c']."</td>\n";
	echo "</tr>\n</table>\n";
	
	echo "<div style='margin:5px'></div>\n";

	echo "<table width='100%' cellpadding='0' cellspacing='0' class='tbl-border'>\n<tr>\n";
	echo "<td class='tbl2'><a href='index.php?op=shop_intro'>".$locale['urg_shop_102']."</a>\n";
	echo " - <a href='index.php?op=shop_ribbon_start'>".$locale['urg_shop_103']."</a>\n";

	if(GLD_STEAL && $golddata['steal'] = date('Ymd')) {
		echo " - <a href='index.php?op=shop_buysteal'>".$locale['urg_shop_104']."</a>\n";
	}
			
	if(GLD_FORUM_ADD_POSTS) {
		echo " - <a href='index.php?op=shop_addposts'>".$locale['urg_shop_105']."</a>\n";
	}
			
	if(GLD_JOINED) {
		echo " - <a href='index.php?op=shop_signup'>".$locale['urg_shop_106']."</a>\n";
	}
			
	if(GLD_KARMA) {
		echo " - <a href='index.php?op=shop_karma'>".$locale['urg_shop_107']."</a>\n";
	}
			
	echo "</td>\n";
	echo "</tr>\n</table>\n";
	closetable();
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function shop_intro() { //item shop intro page
	global $HTTP_POST_VARS, $userdata, $locale, $settings, $golddata;

	table_top($locale['urg_shop_100']);
		render_shop_intro();
	closetable();
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function shop_start() { //Item shop start page
	global $HTTP_POST_VARS, $userdata, $locale, $settings, $golddata;
	
	if (isset($_REQUEST['rowstart']) && isnum($_REQUEST['rowstart'])) { $rowstart = $_REQUEST['rowstart']; } else { $rowstart = 0; }
	if (!isset($_REQUEST['sort'])) $_REQUEST['sort'] = "1";
	if (!isset($_REQUEST['sortDir'])) $_REQUEST['sortDir'] = "0";
	if (!isset($_REQUEST['category'])) $_REQUEST['category'] = "0";

	switch($_REQUEST['sort']) {
		case 0:
			$sortType = 'Name';
			$sortQuery = "name";
			break;
		case 1:
			$sortType = 'Price';
			$sortQuery = "cost";
			break;
		case 2:
			$sortType = 'Description';
			$sortQuery = "description";
			break;
		case 3:
			$sortType = 'Stock';
			$sortQuery = "stock";
			break;
		default:
			die("Invalid sort method passed");
			break;
	}

	switch($_REQUEST['sortDir']) {
		case 0:
			$sortDirType = 'ASC';
			$sortDirQuery = "ASC";
			break;
		case 1:
			$sortDirType = 'DESC';
			$sortDirQuery = "DESC";
			break;
		default:
			die("Invalid sort method passed");
			break;
	}
	
	$ug_cats = getcats(); $categories_opts = ""; $sel = "";
	while(list($key, $ug_cat) = each($ug_cats)){
		$sel = ($_REQUEST['category'] == $ug_cat['0'] ? " selected='selected'" : "");
		$categories_opts .= "<option value='".$ug_cat['0']."'$sel>".$ug_cat['1']."</option>\n";
	}
	
	table_top($locale['urg_shop_100']);
	echo "<table width='100%' cellpadding='5' cellspacing='0' border='0' class='tbl2'>\n<tr>\n";
	echo "<td align='left'>\n<form action='index.php' method='post'>\n";
	echo "<strong>Category</strong>\n";
	echo "<input type='hidden' name='op' value='shop_start' />\n";
	echo "<input type='hidden' name='sort' value='".$_REQUEST['sort']."' />\n";
	echo "<input type='hidden' name='sortDir' value='".$_REQUEST['sortDir']."' />\n";
	echo "<select name='category' class='textbox'>".$categories_opts."</select>\n";
	echo "<input type='submit' value='Select' class='button' />\n";
	echo "</form>\n</td>\n";
	echo "<td align='right'>\n<form action='index.php' method='post'>\n";
	echo "<strong>".$locale['urg_shop_108']."</strong>\n";
	echo "<input type='hidden' name='op' value='shop_start' />\n";
	echo "<input type='hidden' name='category' value='".$_REQUEST['category']."' />\n";
	echo "<select name='sort' class='textbox'>\n";
	echo "<option value='1'".($_REQUEST['sort'] == 1 ? " selected='selected'" : "").">".$locale['urg_shop_109']."</option>\n";
	echo "<option value='2'".($_REQUEST['sort'] == 2 ? " selected='selected'" : "").">".$locale['urg_shop_110']."</option>\n";
	echo "<option value='3'".($_REQUEST['sort'] == 3 ? " selected='selected'" : "").">".$locale['urg_shop_111']."</option>\n";
	echo "</select>\n";
	echo "<select name='sortDir' class='textbox'>\n";
	echo "<option value='0'".($_REQUEST['sortDir'] == 0 ? " selected='selected'" : "").">".$locale['urg_shop_112']."</option>\n";
	echo "<option value='1'".($_REQUEST['sortDir'] == 1 ? " selected='selected'" : "").">".$locale['urg_shop_113']."</option>\n";
	echo "</select>\n";
	echo "<input type='submit' value='".$locale['urg_shop_114']."' class='button' />\n";
	echo "</form>\n</td>\n";
	echo "</tr>\n</table>\n";
		
	render_shop("*", DB_UG3_USAGE, "purchase='1' AND active='1' AND category = '".$_REQUEST['category']."' ", $sortQuery, $sortDirQuery, $rowstart);
	
	closetable();
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function shop_item() {
	global $userdata, $locale, $golddata, $_GET, $_POST, $_REQUEST;
	if (isset($_REQUEST['id'])) {
		table_top($locale['urg_shop_100']);
		render_item($_REQUEST['id']);
		closetable();
	} else {
		redirect(FUSION_SELF."?op=shop_start");
	}
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function shop_finalize() { //Finalize the buying of an item
	global $userdata, $locale, $golddata, $_GET, $_POST, $_REQUEST;
	if (!isset($_GET['id']) || !isNum($_GET['id'])) redirect("index.php");
	
	//item information
	$result = dbquery("SELECT cost, stock, name, category FROM ".DB_UG3_USAGE." WHERE id = ".$_GET['id']." LIMIT 1");
	if (dbrows($result)) {
		$item = dbarray($result);

		table_top($locale['urg_shop_147']);
		echo "<table width='100%' cellpadding='5' cellspacing='0' border='0' class='tbl'>\n<tr valign='top' class='tbl12'>\n";
		echo "<td width='100%'>\n";
		if ($golddata['cash'] < $item['cost']) {
			echo sprintf($locale['urg_shop_121']." %s", formatMoney($item['cost'] - $golddata['cash']));
		} elseif ($item['stock'] == 0) {
			echo $locale['urg_shop_120'];
		} else {
			//put item in user's inventory
			$sql = "INSERT INTO `".DB_UG3_INVENTORY."` ( 
				`id` , 
				`ownerid` , 
				`itemid` , 
				`itemname` , 
				`amtpaid` , 
				`trading` , 
				`tradecost` 
			) VALUES (
				'', 
				'".$userdata['user_id']."', 
				'".$_GET['id']."', 
				'".$item['name']."', 
				'".$item['cost']."', 
				'0', 
				'0.00'
			)";				
			$result = dbquery($sql);
	
			//decrease user's money
			takegold2($userdata['user_id'], $item['cost'], 'cash');
	
			//decrease stock by 1
			$result = dbquery("UPDATE ".DB_UG3_USAGE." SET stock = stock - 1 WHERE id = ".$_GET['id']." LIMIT 1");
	
			echo sprintf($locale['urg_shop_125'].' %s.<br /><br />'.$locale['urg_shop_126'], $item['name']);
		}
		echo "</td>\n";
		echo "</tr>\n</table>\n";
		if (isset($_GET['return'])) {
			pagerefresh('meta',3,urldecode($_GET['return']));
		} else {
			pagerefresh('meta',3,FUSION_SELF.'?op=shop_start&category='.$item['category']);
		}
		closetable();
	} else {
		table_top($locale['urg_shop_147']);
		echo $locale['urg_shop_154'];
		pagerefresh('meta',3,FUSION_SELF.'?op=shop_start');
		closetable(); 	
	}
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function shop_ribbon_start() { //Ribbon shop start page
	global $locale;
	table_top($locale['urg_shop_127']);
	echo "<table width='100%' cellpadding='3' cellspacing='3' class='tbl-border'>\n<tr>\n";
	echo "<td>".sprintf($locale['urg_shop_129'], "<strong>".formatMoney(UGLD_DONATE_RIBBON)."</strong>")."</td>\n";
	echo "</tr>\n</table>\n";
	
	echo "<div style='margin:5px'></div>\n";

	echo "<table width='100%' cellpadding='0' cellspacing='0' class='tbl-border'>\n<tr>\n";
	echo "<td class='tbl2'>\n<form action='index.php' method='post'>\n";
	echo "<input type='hidden' name='op' value='shop_ribbon_finalize' />\n";
	echo "".$locale['urg_shop_128']."&nbsp;&nbsp;<input type='text' name='amount' class='textbox' size='5' />&nbsp;&nbsp;\n";
	echo "<input class='button' type='submit' value='".$locale['urg_shop_130']."' name='submit' />\n";
	echo "</form>\n</td>\n";
	echo "</tr>\n</table>\n";
	closetable();
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function shop_ribbon_finalize() { //Finalize the buying of a ribbon
	global $userdata, $locale, $golddata;
	table_top($locale['urg_shop_127']);
	$amount = stripinput($_POST['amount']);
	$totalcost = $amount * UGLD_DONATE_RIBBON;
	if($amount == "") {
		echo $locale['urg_shop_131'];
		pagerefresh('meta','2',FUSION_SELF.'?op=shop_ribbon_start');
	} elseif ($amount <= 0) {
		echo $locale['urg_shop_132'];
		pagerefresh('meta','2',FUSION_SELF.'?op=shop_ribbon_start');
	} elseif($totalcost > $golddata['cash']) {
		echo $locale['urg_shop_133'];
		pagerefresh('meta','2',FUSION_SELF.'?op=shop_ribbon_start');
	} else {
		takegold2($userdata['user_id'], $totalcost, 'cash');
		$newribbon = $golddata['ribbon'] + $amount;
		dbquery("UPDATE ".DB_UG3." SET ribbon = '".$newribbon."' WHERE owner_id = '".$userdata['user_id']."' LIMIT 1");
		echo sprintf($locale['urg_shop_134'], $amount, formatMoney($totalcost));
		pagerefresh('meta','2',FUSION_SELF.'?op=shop_ribbon_start');
	}
	closetable();
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function shop_buysteal() { //Buy a new steal
	global $userdata, $locale, $golddata;
	table_top($locale['urg_shop_104']);

	if(isset($_POST['buysteal'])) {
		//check for gold
		if($golddata['cash'] + $golddata['bank'] > GLD_STEAL_BUY) {
			takegold2($userdata['user_id'], GLD_STEAL_BUY, 'cash');
			$result = dbquery("UPDATE ".DB_UG3." SET steal = '0' WHERE owner_id = '".$userdata['user_id']."' LIMIT 1");
			echo $locale['urg_shop_135'];
		} else {
			echo $locale['urg_shop_136'];
		}
	} else {
		$allow_post_max = $userdata['user_posts'] / 10;
		
		echo "<table width='100%' cellpadding='3' cellspacing='3' class='tbl-border'>\n<tr>\n";
		echo "<td>".$locale['urg_shop_137']." <strong>".formatMoney(GLD_STEAL_BUY)."</strong> ".$locale['urg_shop_138']."</td>\n";
		echo "</tr>\n</table>";
		
		echo "<div style='margin:5px'></div>\n";
	
		echo "<table width='100%' cellpadding='0' cellspacing='0' class='tbl-border'>\n<tr>\n";
		echo "<td class='tbl2'>\n<form action='index.php' method='post'>\n";
		echo "<input type='hidden' name='op' value='shop_buysteal' readonly='readonly' />\n";
		echo "<input type='hidden' name='buysteal' value='1' />\n";
		echo "<input class='button' type='submit' value='".$locale['urg_shop_114']."' />\n";
		echo "</form>\n</td>\n";
		echo "</tr>\n</table>\n";
	}
	closetable();
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function shop_addposts() { //Add to Post Count
	global  $userdata, $locale, $golddata;
	table_top($locale['urg_shop_105']);
	//lets collect the money ;)
	if(isset($_POST['post_up'])) {
		$post_up = stripinput($_POST['post_up']);
		//check for gold
		$postcost = $post_up * GLD_FORUM_ADD_POSTS_COST;
		if($golddata['cash'] > $postcost) {
			$result = dbquery("UPDATE ".DB_USERS." SET user_posts = user_posts + ".$post_up." WHERE user_id = '".$userdata['user_id']."' LIMIT 1");
			takegold2($userdata['user_id'], $postcost, 'cash');
			echo $locale['urg_shop_139']." ".$post_up."".$locale['urg_shop_140'];
		} else {
			echo $locale['urg_shop_136'];
		}
	} else {
		$allow_post_max = round($userdata['user_posts'] * (GLD_FORUM_ADD_POSTS_PERCENT / 100));
		$post_cost = $allow_post_max * GLD_FORUM_ADD_POSTS_COST;
		echo "<table width='100%' cellpadding='3' cellspacing='3' class='tbl-border'>\n<tr>\n";
		echo "<td>".sprintf($locale['urg_shop_141'], "<strong>".$allow_post_max."</strong>", "<strong>".GLD_FORUM_ADD_POSTS_PERCENT."</strong>", "<strong>".$userdata['user_posts']."</strong>","<strong>".$post_cost."</strong>", "<strong>".UGLD_GOLDTEXT."</strong>")."</td>\n";
		echo "</tr>\n</table>\n";
		
		echo "<div style='margin:5px'></div>\n";
	
		echo "<table width='100%' cellpadding='0' cellspacing='0' class='tbl-border'>\n<tr>\n";
		echo "<td class='tbl2'>\n<form action='index.php' method='post'>\n";
		echo "<input type='hidden' name='op' value='shop_addposts' readonly='readonly' />\n";
		echo "<input type='hidden' name='post_up' value='".$allow_post_max."' />\n";
		echo "<input class='button' type='submit' value='".$locale['urg_shop_130']."' />\n";
		echo "</form>\n</td>\n";
		echo "</tr>\n</table>\n";
	}
	closetable();
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function shop_signup() { // Buy a new signup date
	global $userdata, $locale, $golddata;
	table_top($locale['urg_shop_106']);
	$join_time = strftime('%d/%m/%Y %H:%M', $userdata['user_joined']);
	if (isset($_POST['agree']) == '1')	{
		if($golddata['cash'] > GLD_JOINED) {
			//retrieve the join date and alter it
			//must be sure not to exceed current date
			$sec = date('s', time());
			$min = date('m', time());
			$hrs = date('h', time());
			$hrs = rand(1, $hrs);
			$year = date('Y'); $newyear = rand(2004, $year);
			$day = date('d'); $newday = rand(1, $day);
			$month = date('m'); $newmonth = rand(1, $month);
			$allow_time = mktime ( $hrs, $min, $sec, $newmonth, $newday, $newyear, 0 );
			$format_time = strftime('%d/%m/%Y %H:%M', $allow_time);

			//change the date
			$result = dbquery("UPDATE ".DB_USERS." SET user_joined = '".$allow_time."' WHERE user_id = '".$userdata['user_id']."' LIMIT 1");
			//take the money
			takegold2($userdata['user_id'], GLD_JOINED, 'cash');

			echo sprintf($locale['urg_shop_142'], $format_time,$join_time, GLD_JOINED);
		} else {
			echo $locale['urg_shop_136'];
		}
	} else {
		echo "<table width='100%' cellpadding='3' cellspacing='3' class='tbl-border'>\n<tr>\n";
		echo "<td>".$locale['urg_shop_143'].$join_time.$locale['urg_shop_144'].$locale['urg_shop_109']." <strong>".formatMoney(GLD_JOINED)."</strong></td>\n";
		echo "</tr>\n</table>\n";
		
		echo "<div style='margin:5px'></div>\n";
	
		echo "<table width='100%' cellpadding='0' cellspacing='0' class='tbl-border'>\n<tr>\n";
		echo "<td class='tbl2'>\n<form action='index.php' method='post'>\n";
		echo "<input type='hidden' name='op' value='shop_signup' />\n";
		echo "<strong>".$locale['urg_shop_145']."</strong>&nbsp;&nbsp;<input type='checkbox' name='agree' value='1' />&nbsp;\n";
		echo "&nbsp;<input class='button' type='submit' value='".$locale['urg_shop_146']."' />\n";
		echo "</form>\n</td>\n";
		echo "</tr>\n</table>\n";
	}
	closetable();
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function shop_karma() { //Karma
	global $HTTP_POST_VARS, $userdata, $locale, $settings, $golddata;
	/*
	Ok I have heard of karma and someone said its good thing so i figured i would add it here.
	The trouble is i dont really know what it can be used for.
	So i was thinking this could be a post reward thing as well as something you buy.
	anyways since i am not sure for now i havent done much but setup ready for queries etc.
	*/
	table_top($locale['urg_shop_155']);
	//<input type='text' name='karmaup' value='5'>
	//$result = dbquery("UPDATE ".DB_PREFIX."user_gold SET karma = karma + ".$_POST['karmaup']." WHERE owner_id = '".$userdata[user_id]."'");
	echo $locale['urg_shop_155'];
	//echo $locale['URG1508'].$_POST['karmaup']."!";
	closetable();
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
?>