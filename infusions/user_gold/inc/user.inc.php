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
| Filename: usage.inc.php
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

if (file_exists(GOLD_LANG.LOCALESET."user.php")) {
    include_once GOLD_LANG.LOCALESET."user.php";
} else {
    include_once GOLD_LANG."English/user.php";
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function user_menu() { //User menu
    global $locale;
	table_top($locale['urg_user_100']);
	echo "<table width='100%' cellpadding='3' cellspacing='3'class='tbl-border'>\n<tr>\n";
	echo "<td><h3>".$locale['urg_user_101a']."</h3></td>\n";
	echo "<td rowspan='3' align='right' valign='bottom'><img src='".GOLD_IMAGE."logo_user.png' alt='logo_user' /></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td>".sprintf($locale['urg_user_101b'], UGLD_GOLDTEXT)."</td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td>".$locale['urg_user_101c']."</td>\n";
	echo "</tr>\n</table>\n";
	
	echo "<div style='margin:5px'></div>\n";
	
	echo "<table width='100%' cellpadding='0' cellspacing='0'class='tbl-border'>\n<tr>\n";
	echo "<td class='tbl2'><a href='index.php?op=user_inventory_start'>".$locale['urg_user_102']."</a>\n";
	echo " - <a href='index.php?op=user_settings_start'>".$locale['urg_user_103']."</a></td>\n";
	echo "</tr>\n</table>\n";
	closetable();
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function user_inventory_start() { //Entry Screen Includes list of current items
    global $userdata, $locale, $settings, $golddata;
    table_top($locale['urg_user_100']);
    echo "<table width='100%' cellpadding='5' cellspacing='0' border='0'>\n<tr valign='top' class='tbl1'>\n";
    echo "<td width='32px'><strong>".$locale['urg_user_104']."</strong></td>\n";
    echo "<td><strong>".$locale['urg_user_105']."</strong></td>\n";
    echo "<td><strong>".$locale['urg_user_106']."</strong></td>\n";
    echo "<td width='18%'><strong>".$locale['urg_user_107']."</strong></td>\n";
    echo "</tr>\n";

    $i = 0;//color

    $result = dbquery("SELECT it.name, it.description, it.purchase, it.cost, it.image, it.active, inv.amtpaid, inv.id, inv.trading, inv.tradecost 
	FROM ".DB_UG3_INVENTORY." AS inv, ".DB_UG3_USAGE." AS it WHERE inv.ownerid = ".$userdata['user_id']." 
	AND inv.itemid = it.id ORDER BY it.name ASC");
    while ($row = dbarray($result)) {
		if ($i % 2 == 0) { $alternating = "tbl2"; } else { $alternating = "tbl1"; }
        echo "<tr valign='top' class='".$alternating."'>\n";
        echo "<td><img style='border: 0; width: ".UGLD_IMAGE_WIDTH."; height: ".UGLD_IMAGE_HEIGHT.";' src='images/item_images/".$row['image']."' title='".$row['name']."' alt='".$row['name']."' /></td>\n";
        echo "<td style='padding-bottom: 2px; width: 20%;'>".$row['name']."</td>\n";
        echo "<td>".$row['description']."</td>\n";
        echo "<td width='18%'>".$locale['urg_user_107'].": ".formatMoney($row['amtpaid'])."<br />\n";
        echo "<form action='index.php' method='post'>\n";

        $startTrade = "<br />
		<input type='hidden' name='op' value='trade_sell' />
		<input type='hidden' name='id' value='".$row['id']."' />
		<input type='submit' value='".$locale['urg_user_108']."' class='button' />";

        $endTrade = "<i>".sprintf("Trading for %s", formatMoney($row['tradecost']))."</i><br />
		<input type='hidden' name='op' value='trade_stop' />
		<input type='hidden' name='id' value='".$row['id']."' />
		<input type='submit' value='".$locale['urg_user_109']."' class='button' />";
        if ('UGLD_ALLOWTRADE') {
            echo "".($row['trading'] == 1 ? $endTrade:$startTrade)."";
        }
        echo "</form>\n</td>\n</tr>\n";
	$i++;
    }
    echo "</table>\n";
    closetable();
}//inv()

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function user_settings_start() { //User Settings start page
    global $userdata, $locale, $golddata;
    table_top($locale['urg_user_103']);

	add_to_head("<script type='text/javascript' src='".GOLD_INC."colorpicker/301a.js'></script>");

    echo "<form name='ug3_usersettings' method='post' action='".FUSION_SELF."' enctype='multipart/form-data'>\n";
    echo "<table align='center' cellpadding='3' cellspacing='0' width='100%'><tr>\n";
    echo "<td class='tbl1' width='145px'>".$locale['urg_user_110']."</td>\n";
    echo "<td style='color: ".$golddata['username_color'].";'><input type='hidden' name='user_name' value='".$userdata['user_name']."' maxlength='30' class='textbox' style='width: 200px;' />".$userdata['user_name']."</td>\n";
    echo "</tr>\n<tr valign='top'>\n";
    echo "<td class='tbl1'>".$locale['urg_user_111']."</td>\n";
    echo "<td>\n";
	echo "<div id='colorpicker301' class='colorpicker301'></div>\n";
	echo "<input class='textbox' type='text' size='9' name='color_value' id='color_value' value='".$golddata['username_color']."' />&nbsp;\n";
	echo "<img src='".GOLD_INC."colorpicker/colorpicker.png' onclick='showColorGrid3(\"color_value\",\"none\");' border='0' style='cursor:pointer' alt='".$locale['urg_user_117']."' title='".$locale['urg_user_117']."' />\n";
	echo "</td>\n";
    echo "</tr>\n<tr>\n";
	if (ItemOwned("GLD_USERLEVEL", $userdata['user_id'])) {
		echo "<td class='tbl1'>".$locale['urg_user_113']."</td>\n";
		echo "<td><input type='text' name='userlevel' value='".$golddata['userlevel']."' maxlength='30' class='textbox' style='width: 200px;' /></td>\n";
		echo "</tr>\n<tr>\n";
	} else {
		echo "<input type='hidden' name='userlevel' value='".$locale['urg_user_118']."' class='textbox' />\n";
	}
    echo "<td colspan='2'><input type='hidden' name='op' value='user_settings_save' /></td>\n";
    echo "</tr>\n<tr>\n";
    echo "<td align='center' colspan='2'>\n";
	echo "<input type='submit' name='submit' value='".$locale['urg_user_112']."' class='button' /></td>\n";
    echo "</tr>\n</table>\n";
	echo "</form>\n";
    closetable();
}

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function user_settings_save() { //Save the users settings
    global $userdata, $locale;
    $color_value = stripinput($_POST['color_value']);
    $userlevel = stripinput($_POST['userlevel']);

    $error = "";

    if (!preg_match("/^[a-z0-9]+([\\s]{1}[a-z0-9]|[a-z0-9])+$/i", $userlevel)) {
        $error = $locale['urg_user_114'];
    } else {
        if (UGLD_USERLEVEL_DISALLOW != "") {
            $disallow_levellist = explode(":", UGLD_USERLEVEL_DISALLOW);
            for ($i = 0; $i < count($disallow_levellist); $i++) {
                if ($disallow_levellist[$i] != "") {
                    if (eregi($disallow_levellist[$i], $userlevel)) {
                        $error = $locale['urg_user_115'];
                    }
                }
            }
        }
    }

    if ($error != "") {
        table_top($locale['urg_user_116']);
        echo $error;
        closetable();
		include "footer.php";
        exit;
    }
    dbquery("UPDATE ".DB_UG3." SET username_color = '".$color_value."', userlevel = '".$userlevel."' WHERE owner_id = '".$userdata['user_id']."' LIMIT 1");
    redirect(FUSION_SELF."?op=user_settings_start");
}
?>