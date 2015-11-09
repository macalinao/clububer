<?php
include "header.php";

//Russian Roulette Game- by javascriptkit.com
//Visit JavaScript Kit (http://javascriptkit.com) for script
//Credit must stay intact for use

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
/* 		Russian roulette By StarglowOne for user gold v3+						*/
/* 		Make a bet to recieve a loss or winnings, get killed or not						*/
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

//locales
if (file_exists(GOLD_GAMES."roulette/locale/".$settings['locale'].".php"))
{
	include GOLD_GAMES."roulette/locale/".$settings['locale'].".php";
}
else
{
	include GOLD_GAMES."roulette/locale/English.php";
}
//definitions
//define("" , "");
$roulette_images = GOLD_GAMES.'roulette/images/';

//Basic Required Globals
global $HTTP_POST_VARS, $userdata, $locale, $settings, $golddata;

table_top($locale['rou_100']);

if(isset($_POST['submit'])) {
	if ($_POST['bet'] > 50 or $_POST['bet'] < 5) {
		echo "<div align='center'>\n";
		echo "<h1>".$locale['rou_209']."</h1><br /><br />\n";
		echo "<form name='goback' method='post' action='roulette.php'>\n";
		echo "<table align='center'>\n<tr>\n";
		echo "<td align='center'><input name='play' class='button' type='submit' value='".$locale['rou_210']."' /></td>\n";
		echo "</tr>\n</table>\n";
		echo "</form>\n";
		echo "</div>\n";
	} else {
		echo "<div align='center'>\n";
		echo "<table width='450'>\n";
		$sleeptime = rand(1, 5);
		sleep($sleeptime);
		$theone = rand(1, 8);
		$bullets = $_POST['bullets'];

		if ($theone <= $bullets-1) {
			echo "<tr>\n";
		    echo "<td><img border='0' src='".$roulette_images."roulette_5seconds_delay_loose.gif' width='152' height='216' alt='|' /></td>\n";
		    echo "<td><h1>".$locale['rou_202']."</h1>\n";
			$lost=$_POST['bet'];
			takegold2($userdata['user_id'], $lost, 'cash', '0');
		} else {
			if ($theone != $bullets-1) {
				echo "<tr>\n";
				echo "<td><img border='0' src='".$roulette_images."roulette_5seconds_delay_win.gif' width='152' height='216' alt='|' /></td>\n";
				echo "<td><h1>".$locale['rou_203']."</h1>\n";
				$won=$_POST['bet']*($_POST['bullets']-1);
				payuser($userdata['user_id'], $won, 'cash');
			}
		}
		echo "</td></tr>\n</table>\n";
		echo "<br /><br />\n";
		echo "<form name='playagain' method='post' action='roulette.php'>\n";
		echo "<table align='center'>\n<tr>\n";
		echo "<td colspan='7' align='center'><input name='play' class='button' type='submit' value='".$locale['rou_207']."' /></td>\n";
		echo "</tr></table>\n";
		echo "</form>\n";
		
		echo "</div>\n";
	}
} else {
	echo "<div align='center'>\n";
	echo "<table width='450'>\n<tr>\n";
    echo "<td><img border='0' src='".$roulette_images."roulette.gif' width='152' height='216' alt='|' /></td>\n";
    echo "<td>\n<br /><br />\n";
	echo "<form name='fire' method='post' action='roulette.php'>\n";
	echo "<table>\n<tr>\n";
	echo "<td colspan='7' align='center'><strong>".$locale['rou_200']."</strong></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td align='center'>2</td>\n";
	echo "<td align='center'>3</td>\n";
	echo "<td align='center'>4</td>\n";
	echo "<td align='center'>5</td>\n";
	echo "<td align='center'>6</td>\n";
	echo "<td align='center'>7</td>\n";
	echo "<td align='center'>8</td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td><input type='radio' name='bullets' value='2' checked /></td>\n";
	echo "<td><input type='radio' name='bullets' value='3' /></td>\n";
	echo "<td><input type='radio' name='bullets' value='4' /></td>\n";
	echo "<td><input type='radio' name='bullets' value='5' /></td>\n";
	echo "<td><input type='radio' name='bullets' value='6' /></td>\n";
	echo "<td><input type='radio' name='bullets' value='7' /></td>\n";
	echo "<td><input type='radio' name='bullets' value='8' /></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td colspan='7' align='center'>&nbsp;</td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td colspan='7' align='center'><strong>".$locale['rou_208']."</strong><input  class='textbox' name='bet' type='text' /> ( 5 to 50 range )</td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td colspan='7' align='center'>&nbsp;</td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td colspan='7' align='center'><input name='submit' class='button' type='submit' value='".$locale['rou_201']."' /></td>\n";
	echo "</tr>\n</table>\n";
	echo "</form>\n";
	echo "</td>\n</tr>\n</table>\n";
	echo "</div>\n";
}
echo "<div align='center'><a href='http://www.starglowone.com' target='game'>".$locale['rou_211']."</a></div>\n";
closetable();

include "footer.php";
?>