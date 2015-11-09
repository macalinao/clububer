<?php
include "header.php";

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
/* 		MindMaster By StarglowOne for user gold v3+						*/
/* 		Make a bet to recieve a loss or winnings 						*/
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

//locales
if (file_exists(GOLD_GAMES."mindmaster/locale/".$settings['locale'].".php")) {
	include_once GOLD_GAMES."mindmaster/locale/".$settings['locale'].".php";
} else {
	include_once GOLD_GAMES."mindmaster/locale/English.php";
}

//definitions
//define("" , "");
$index = "";
//Basic Required Globals
global $HTTP_POST_VARS, $userdata, $locale, $settings, $golddata;

table_top($locale['mdmr_100']);

session_start();
if (!isset($_SESSION['gamerand'])) {
	$_SESSION['gamerand'] = array();
}

if (!isset($_SESSION['guesstable'])) {
	$_SESSION['guesstable'] = array();
}

if (!isset($_SESSION['answertable'])) {
	$_SESSION['answertable'] = array();
}

if (!isset($_SESSION['won'])) {
	$_SESSION['won'] = 0 ;
}

echo "<div>".$locale['mdmr_201']."</div>\n";

$colour_table = array(
        'blue_button.gif',
        'red_button.gif',
        'green_button.gif',
        'yellow_button.gif',
        'white_button.gif',
        'black_button.gif',
        'purple_button.gif',
        'orange_button.gif');
$lost = 0;

// if new, populate gamerand array with 4 random colours in places
if ( count($_SESSION['gamerand']) == 0) {
	for ($i=0; $i<4; $i++) {
		$j = rand(0,7);		// 56/7 choices - more randomised?
		//$j = int($j/7);
		$_SESSION['gamerand'][] = $colour_table[$j];
	}
}

// get results back from last guess
// --------------------------------

if (isset($_POST['colour1'])) {
	$index = count($_SESSION['guesstable']);
	$_SESSION['guesstable'][$index] = array();
	$_SESSION['answertable'][$index] = array();

	$_SESSION['guesstable'][$index][0] = $_POST['colour1'];
	$_SESSION['guesstable'][$index][1] = $_POST['colour2'];
	$_SESSION['guesstable'][$index][2] = $_POST['colour3'];
	$_SESSION['guesstable'][$index][3] = $_POST['colour4'];
}

// assign ticks for correct results
// --------------------------------

$tick_red = 0;
$tick_white = 0;
$tick_ctr = 0;
$guess_mark = array(0,0,0,0); //to not assign ticks twice
$match_mark = array(0,0,0,0);

for ($i=0; $i<4; $i++) { // red ticks first
	if ($_SESSION['guesstable'][$index][$i] == $_SESSION['gamerand'][$i] ) { 
		$tick_red++;
		$guess_mark[$i] = 1; 	  
		$match_mark[$i] = 1;
	}
}

for ($i=0; $i<4; $i++) { // now white ticks  
	for ($j=0; $j<4; $j++) { 
		if ($guess_mark[$i] == 0 && $j != $i) { 
			if ($_SESSION['guesstable'][$index][$i] == $_SESSION['gamerand'][$j] && $match_mark[$j] != 1) {
				$tick_white++;
				$guess_mark[$i] = 1;
				$match_mark[$j] = 1;
			}
		}
	}
}

if ($tick_red > 0) {
	for ($i=0; $i<$tick_red; $i++) {
		$_SESSION['answertable'][$index][$i] = "red";
	}
}
if ($tick_white > 0) {
	for ($i=$tick_red; $i<($tick_red+$tick_white); $i++) {
		$_SESSION['answertable'][$index][$i] = "white";
	}
}

if ($tick_red == 4) {
	$_SESSION['won'] = 1;
}

// start table for game
if ($_SESSION['won'] == 1) {
	global $locale;
	payuser($userdata['user_id'], 50, 'cash');
    echo "<div align='center'><table cellpadding='0' cellspacing='2' border='0' width='500' height='60'>\n";
    echo "<tr><td align='center' width='300'>\n";
    echo "".$locale['mdmr_204']."<br /><br />\n";
	echo "&nbsp;&nbsp;&nbsp;&nbsp;\n";
    echo "<img src=images/".$_SESSION['gamerand'][0]." alt='".$_SESSION['gamerand'][0]."' /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; \n"
      ."<img src=images/".$_SESSION['gamerand'][1]." alt='".$_SESSION['gamerand'][1]."' /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; \n"
      ."<img src=images/".$_SESSION['gamerand'][2]." alt='".$_SESSION['gamerand'][2]."' /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; \n"
      ."<img src=images/".$_SESSION['gamerand'][3]." alt='".$_SESSION['gamerand'][3]."' /> \n" ;
    echo "</td>\n";
    $lost = 1;
    echo "<td align='center' valign='middle'> \n";
    echo "<form action='".$_SERVER['PHP_SELF']."' method='post'>\n";
    echo "<input type='submit' class='button' value='".$locale['mdmr_206']."' name='playagain' />\n";
    echo "</form> \n";
} elseif (count($_SESSION['guesstable']) == 12) {
	takegold2($userdata['user_id'], 20, 'cash', '0');
    echo "<div align='center'><table border='0' width='500' height='60'>\n";
    echo "<tr><td align='center' width='300'>\n";
    echo $locale['mdmr_205']."<br /><br />\n";
	echo "&nbsp;&nbsp;&nbsp;&nbsp;\n";
    echo "<img src=images/".$_SESSION['gamerand'][0]." alt='".$_SESSION['gamerand'][0]."' /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; \n"
      ."<img src=images/".$_SESSION['gamerand'][1]." alt='".$_SESSION['gamerand'][1]."' /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; \n"
      ."<img src=images/".$_SESSION['gamerand'][2]." alt='".$_SESSION['gamerand'][2]."' /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; \n"
      ."<img src=images/".$_SESSION['gamerand'][3]." alt='".$_SESSION['gamerand'][3]."' /> \n" ;
	echo "</td>\n";
    $lost = 1;
    echo "<td align='center' valign='middle'>\n";
    echo "<form action='".$_SERVER['PHP_SELF']."' method='post'>\n";
    echo "<input type='submit' class='button' value='".$locale['mdmr_206']."' name='playagain' />\n";
    echo "</form>\n";
} else {
    echo "<table align='center' cellpadding='0' cellspacing='2' border='0' width='500' height='60'>\n<tr>\n";
	echo "<td align='center' valign='middle' class='tbl'>\n";
    echo $locale['mdmr_202'];
	//echo "<img src=images/".$_SESSION['gamerand'][0]." /> &nbsp;&nbsp; \n"
	//  ."<img src=images/".$_SESSION['gamerand'][1]." /> &nbsp;&nbsp; \n"
	//  ."<img src=images/".$_SESSION['gamerand'][2]." /> &nbsp;&nbsp; \n"
	//  ."<img src=images/".$_SESSION['gamerand'][3]." /> \n" ;
}
echo "</td></tr></table>\n";

// table of choices
//echo "<div align='center'>\n";
echo "<form action=".$_SERVER['PHP_SELF']." method=post>\n";
echo "<table align='center' border='0' width='500'>\n";


// set up form for selecting the colours
// -------------------------------------
if (count($_SESSION['guesstable']) < 12 && $lost == 0) {
	global $locale;
	echo "<tr><td align='center' width='300'>\n";
	echo "<table cellpadding='0' cellspacing='2' align='center' valign='middle'><tr>\n";
	echo "<td valign='middle'>\n";
	for ($i=0; $i<count($colour_table); $i++) {
		$check_value = "";
		if ($_SESSION['guesstable'][$index][0] == $colour_table[$i]) {
			$check_value = "checked=checked";
		}
		echo "<input type='radio' name='colour1' value='".$colour_table[$i]."' $check_value />"."<img src='images/".$colour_table[$i]."' alt='".$colour_table[$i]."' /><br />\n"; 
	}
	echo "</td>\n";
	echo "<td valign='middle'>\n";
	for ($i=0; $i<count($colour_table); $i++) {
		$check_value = "";
		if ($_SESSION['guesstable'][$index][1] == $colour_table[$i]) {
			$check_value = "checked=checked";
		}
		echo "<input type='radio' name='colour2' value='".$colour_table[$i]."' $check_value />"."<img src='images/".$colour_table[$i]."' alt='".$colour_table[$i]."' /><br />\n";
	}
	echo "</td>\n";
	echo "<td valign='middle'>\n";
	for ($i=0; $i<count($colour_table); $i++) {
		$check_value = "";
		if ($_SESSION['guesstable'][$index][2] == $colour_table[$i]) {
			$check_value = "checked=checked";
		}
		echo "<input type='radio' name='colour3' value='".$colour_table[$i]."' $check_value />"."<img src='images/".$colour_table[$i]."' alt='".$colour_table[$i]."' /><br />\n";
	}
	echo "</td>\n";
	echo "<td valign='middle'>\n";
	for ($i=0; $i<count($colour_table); $i++) {
		$check_value = "";
		if ($_SESSION['guesstable'][$index][3] == $colour_table[$i]) {
			$check_value = "checked=checked";
		}
		echo "<input type='radio' name='colour4' value='".$colour_table[$i]."' $check_value />"."<img src='images/".$colour_table[$i]."' alt='".$colour_table[$i]."' /><br />\n";
	}
	echo "</td>\n";
	echo "</tr>\n</table>\n";
	echo "</td>\n";
	echo "<td align='center' valign='middle'>\n";
	echo "<input type='submit' class='button' value='".$locale['mdmr_203']."' name='submit' />\n";
	echo "</td>\n";
	echo "</tr>\n";
}

// display previous results
// ------------------------
if (count($_SESSION['guesstable']) > 0) {
	$ctr = count($_SESSION['guesstable']) - 1;
	for ($i=$ctr; $i>= 0; $i--) {
        echo "\n <tr class='tbl-border'><td align='center' width='300' class='tbl'>\n";
		echo "&nbsp;&nbsp;&nbsp;&nbsp;\n";
        echo "<img src='images/".$_SESSION['guesstable'][$i][0]."' alt='".$_SESSION['guesstable'][$i][0]."' /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; \n"
          ."<img src='images/".$_SESSION['guesstable'][$i][1]."' alt='".$_SESSION['guesstable'][$i][1]."' /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; \n"
          ."<img src='images/".$_SESSION['guesstable'][$i][2]."' alt='".$_SESSION['guesstable'][$i][2]."' /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; \n"
          ."<img src='images/".$_SESSION['guesstable'][$i][3]."' alt='".$_SESSION['guesstable'][$i][3]."' /> \n";
        echo "</td><td class='tbl'>\n";
		$attempt = $i  + 1;
		echo "($attempt) &nbsp;\n";
        for ($j=0;$j<4; $j++) {
			if ($_SESSION['answertable'][$i][$j] == "red") {
				echo "<img src='images/red_tick.gif' alt='".$locale['mdmr_207']."' />\n";
		 	} elseif ($_SESSION['answertable'][$i][$j] == "white") {
				echo "<img src='images/black_tick.gif' alt='".$locale['mdmr_208']."' />\n";
			}
        }
        echo "</td>\n</tr>\n";
	}
}

echo "</table>\n";
echo "</form>\n";
//echo "</div>\n";

if ($_SESSION['won'] == 1 || count($_SESSION['guesstable']) == 12) {
	$_SESSION = array();
	session_destroy();
}
echo "<div align='center'><a href='http://www.starglowone.com' target='game'>".$locale['mdmr_209']."</a></div>\n";

closetable();
include "footer.php";
?>