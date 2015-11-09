<?php
include "header.php";

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
/* 		Coin Game By StarglowOne for user gold v3+						*/
/* 		Make a bet to recieve a loss or winnings 						*/
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

//locales
if (file_exists(GOLD_GAMES."coingame/locale/".$settings['locale'].".php")) {
	include_once GOLD_GAMES."coingame/locale/".$settings['locale'].".php";
} else {
	include_once GOLD_GAMES."coingame/locale/English.php";
}
//definitions
//define("" , "");

//Basic Required Globals
global $HTTP_POST_VARS, $userdata, $locale, $settings, $golddata;

table_top($locale['cnge_100']);


if(isset($_POST['submit'])) {
	$answer = rand(1,100);
	if($_POST['submit']) {
		$bet = stripinput($_POST['bet']);
		if($bet == "") {
			echo "<div align='center'>".$locale['cnge_200']."</div>\n";
			pagerefresh('meta','3','coingame.php');
			closetable();
			include "footer.php";
			exit;
		}
			
		if (is_float($bet)) {
			echo "<div align='center'>".$locale['cnge_201']."</div>\n";
			pagerefresh('meta','3','coingame.php');
			closetable();
			include "footer.php";
			exit;
		}

		if($bet > 100 or $bet < 5) {
			echo "<div align='center'>".$locale['cnge_202']."</div>\n";
			pagerefresh('meta','3','coingame.php');
			closetable();
			include "footer.php";
			exit;
		}

		if($golddata['cash'] < $bet) {
			echo "<div align='center'>".$locale['cnge_211']."</div>\n";
			pagerefresh('meta','3','coingame.php');
			closetable();
			include "footer.php";
			exit;
		}

	}
	
	if($answer > 50) {
		echo "<div align='center'>".$locale['cnge_203']." ".$bet."!</div>\n";
		takegold2($userdata['user_id'], $bet, 'cash', '0');
		pagerefresh('meta','3','coingame.php');
	} else if ($answer < 50) {
		$won=$bet*1.5;
		echo "<div align='center'>".$locale['cnge_204']." ".$won."!</div>\n";
		payuser($userdata['user_id'], $won, 'cash');
		pagerefresh('meta','3','coingame.php');
	}
} else {
	echo "<form name='form1' method='post' action='coingame.php'>\n";
	echo "<div align='center'>\n";
	echo $locale['cnge_205'];
	echo " <input name='bet' type='text' class='textbox' id='bet' size='20' maxlength='10' />\n";
	echo "<br />\n";
	echo "<input type='submit' class='button' name='submit' value='".$locale['cnge_206']."' />\n";
	echo "</div>\n";
	echo "</form>\n";
}

echo "<br /><br /><div align='center'><a href='http://www.starglowone.com' target='game'>".$locale['cnge_207']."</a></div>\n";
closetable();

include "footer.php";
?>