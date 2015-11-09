<?php
include "header.php";

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
/* 		Site Lotto By AusiMods for user gold v3+						*/
/* 		Pick 6 numbers to recieve a loss or winnings						*/
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

//locales
if (file_exists(GOLD_GAMES."sitelotto/locale/".$settings['locale'].".php")) {
	include GOLD_GAMES."sitelotto/locale/".$settings['locale'].".php";
} else {
	include GOLD_GAMES."sitelotto/locale/English.php";
}

//Basic Required Globals
global $HTTP_POST_VARS, $userdata, $locale, $settings, $golddata;
table_top($locale['selo_100']);


$winning_numbers = array (
"0" => "",
"1" => "",
"2" => "",
"3" => "",
"4" => "",
"5" => "",
"6" => "");


$player_numbers = array (
"0" => (isset($_POST['n1']) ? $_POST['n1'] : ""),
"1" => (isset($_POST['n2']) ? $_POST['n2'] : ""),
"2" => (isset($_POST['n3']) ? $_POST['n3'] : ""),
"3" => (isset($_POST['n4']) ? $_POST['n4'] : ""),
"4" => (isset($_POST['n5']) ? $_POST['n5'] : ""),
"5" => (isset($_POST['n6']) ? $_POST['n6'] : ""),
"6" => (isset($_POST['n1']) ? $_POST['n1'] : "")
);

if (isset($_REQUEST['action']) == "play") {
	if($golddata['cash'] >= '20') {
		takegold2($userdata['user_id'], '20', 'cash', '0');
	} else {
		echo $locale['selo_200'];
		closetable();
		include_once GOLD_GAMES.'sitelotto/footer.php';
		exit;
	}
	$i = 0;
	while ($i < 6) {
		$temp = rand(1,45);
		if (!in_array($temp,$winning_numbers)) {
			$winning_numbers[$i] = $temp;
			$i++;
		}
	}
	sort($winning_numbers);
	sort($player_numbers);
}

$i = 0;
$points = 0;
while ($i < 6) {
	if (in_array($winning_numbers[$i],$player_numbers))
	$points++;
	$i++;
}

echo "<script type='text/javascript'>\n";
echo "<!--\n";
echo "function selectsitelotto(v)\n";
echo "{\n";
echo "	document.sitelottoform.n6.value = document.sitelottoform.n6.value\n";
echo "	document.sitelottoform.n6.value = document.sitelottoform.n5.value\n";
echo "	document.sitelottoform.n5.value = document.sitelottoform.n4.value\n";
echo "	document.sitelottoform.n4.value = document.sitelottoform.n3.value\n";
echo "	document.sitelottoform.n3.value = document.sitelottoform.n2.value\n";
echo "	document.sitelottoform.n2.value = document.sitelottoform.n1.value\n";
echo "	document.sitelottoform.n1.value = v\n";
echo "}\n";
echo "//-->\n";
echo "</script>\n";
echo "<table align='center' rules='none' frame='box' cellpadding='0' cellspacing='0' border='1'>";

$i = 0;
$n = 1;
while ($i < 5) {
	if ($i % 2 == 1) {
		echo "  <tr class='tbl1'>\n";
	} else {
		echo "  <tr>\n";
	}
	$j = 0;
	while ($j < 9) {

		if (in_array($n, $winning_numbers)) {
			echo "<td class='border' align='center'>\n";
		} else {
			echo "<td align='center'>";
			echo "<font face='verdana, arial, helvetica' size='2'>\n";
		}
		
		if (in_array ($n, $player_numbers)) {
			echo "<strong> <a style='cursor:pointer;' onclick='selectsitelotto($n)'>&nbsp; <font color='green'>$n</font> &nbsp;</a> </strong>\n";
		} else {
			echo "<a style='cursor:pointer;' onclick='selectsitelotto($n)'> &nbsp; $n &nbsp; </a></font>\n";
		}	
		echo "</td>\n";
		$j++;
		$n++;
	}
	$i++;
	echo "</tr>\n";
}
echo "</table><div align='center'>\n";

if (isset($_REQUEST['action']) == "play") {
	$again = $locale['selo_201'];
	echo "<strong>".$locale['selo_202']."</strong><br />\n";
	$w = 0;
	while ($w < 7) {
		echo " &nbsp; $winning_numbers[$w]\n";
		$w++;
	}
	echo "<br /><strong>".$locale['selo_203']."</strong><br />\n";
	$w = 0;
	while ($w < 6) {
		echo " &nbsp; $player_numbers[$w]\n";
		$w++;

	}

	if($points > 3 && $points < 5) {
		payuser($userdata['user_id'], '2000', 'cash');
		echo "<p>".$locale['selo_204']."</p>\n";
	} elseif($points > 4 && $points < 6) {
		payuser($userdata['user_id'], '10000', 'cash');
		echo "<p>".$locale['selo_205']."</p>\n";
	} elseif($points == 6) {
		payuser($userdata['user_id'], '20000', 'cash');
		echo "<p>".$locale['selo_206']."</p>\n";
	} elseif($points > 0 && $points < 4) {
		echo "<p>".$locale['selo_207']." ".$points." ".$locale['selo_208']."</p>\n";
	} else {
		echo "<p>".$locale['selo_209']."</p>\n";
	}

	echo "<form method='post' action='sitelotto.php'>\n";
	echo "<input class='button' type='submit' value='".$locale['selo_210']."$again' /></form>\n";
} else {
	echo "<form method='post' action='sitelotto.php' name='sitelottoform'>\n";
	echo "Select 6 numbers between 1 and 45:<br /><br />\n";
	echo "<input class='textbox' type='hidden' name='action' value='play' />\n";
	echo "<input class='textbox' type='text' size='2' maxlength='2' name='n1' value='$player_numbers[0]' /> \n";
	echo "<input class='textbox' type='text' size='2' maxlength='2' name='n2' value='$player_numbers[1]' /> \n";
	echo "<input class='textbox' type='text' size='2' maxlength='2' name='n3' value='$player_numbers[2]' /> \n";
	echo "<input class='textbox' type='text' size='2' maxlength='2' name='n4' value='$player_numbers[3]' /> \n";
	echo "<input class='textbox' type='text' size='2' maxlength='2' name='n5' value='$player_numbers[4]' /> \n";
	echo "<input class='textbox' type='text' size='2' maxlength='2' name='n6' value='$player_numbers[5]' /> \n";
	echo "<br /><br />\n";
	echo "<input class='button' type='submit' value='".$locale['selo_210']."' />\n";
	echo "</form>\n";
}
echo "</div>\n";
echo "<div align='center'><a href='http://www.starglowone.com' target='game'>".$locale['selo_212']."</a></div>\n";

closetable();

include "footer.php";
?>