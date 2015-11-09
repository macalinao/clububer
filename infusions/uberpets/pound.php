<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--- ----------------------------------------------------+
| UBERPETS V 0.0.0.5
+--------------------------------------------------------+
| Uberpets Copyright 2008 Grr@µsoft inc.
| http://www.clububer.com/
\*-------------------------------------------------------*/

##################################
#   THE POUND! OOH SPOOKY!       #
##################################
# (Get it? Pound Signs!)         #
##################################

// PAGE INCLUDES
require_once "../../maincore.php";
if (!defined("IN_UBP")) { include "includes/core.php"; }


if (preg_match("/^[6]./",$settings['version'])) {
	require_once BASEDIR."subheader.php";
	require_once UBP_BASE."includes/side_left.php";
}
elseif (preg_match("/^[7]./", $settings['version'])) {
	require_once THEMES."templates/header.php";
}

if ($pets_of_user == 0) { redirect(UBP_BASE."create_pet.php"); }

include UBP_BASE."includes/pagelinks.php";
//PAGE INCLUDES END

$page = stripinput($_GET['page']);
$step = stripinput($_GET['step']);
$pet_id = stripinput($_GET['pet_id']);

//If the pound page is the main
		if (!isset($page) || $page == "main"){
	//Echo the pound.
			opentable("The Uberian Pound");
				echo "<center>The pound is still under construction.<br /><br />";
				echo "<table width='84%' cellspacing='1' cellpadding='1' border='0' class='tbl-border'>\n";
				echo "<tr>\n";
				echo "<td align='center' class='tbl1'><a href='".$plink['UBP_101']."'>Adopt</a></td>";
				echo "<td align='center' class='tbl1'><a href='".$plink['UBP_102']."'>Abandon</a></td>";
				echo "</tr>\n";
				echo "</table>";
				echo "</center>";
			closetable();
//If the page is adopt
		} elseif ($page == "adopt") {
				opentable("Adopt a Pet");
				//Get the number of rows
					$rows = dbrows(dbquery("SELECT * FROM ".UPREFIX."pound"));
				//If page is not defined, page is 1
					if (!isset($rowstart) || !isNum($rowstart)) $rowstart = 0;
					
					$result = dbquery("SELECT * FROM ".$db_prefix."varcade_games 
					LIMIT $rowstart,".$varcsettings['pound_pets_per_page']."");
							$counter = 0; $r = 0; $k = 1;
							echo "<table cellpadding='0' cellspacing='0' width='100%'>\n<tr>\n";
							while ($data = dbarray($result)) {
								if ($counter != 0 && ($counter % $uberpets_settings['pound_pets_per_row'] == 0)) echo "</tr>\n<tr>\n";
						          		echo "<td align='center' valign='top' class='tbl'>\n";
					makelist();
								echo "</td>\n";
								$counter++; $k++;
							}
							echo "</tr>\n</table>\n";
							if ($rows > $varcsettings['pound_pets_per_page']) echo "<div align='center' style='margin-top:5px;'>\n".makePageNav($rowstart,$uberpets_settings['pound_pets_per_page'],$rows,3,BASEDIR."game/".url31("cat", $category, $category['title'])."&")."\n</div>\n";
				closetable();
//If the page is abandon
		} elseif ($page == "abandon") {
		
			if (!$step || $step == 1){
				opentable("Abandon");
					$petno = $pets_of_user;					
					if ($petno == 1){
						$tdwidth = "84%";
					}
					elseif ($petno == 2 || 4){
						$tdwidth = "42%";
					}
					elseif ($petno == 3) {
						$tdwidth = "42%";
					}
						echo "<br /><center>Which pet will you abandon today?<br /><br />";
						echo "<table width='84%' cellspacing='1' cellpadding='1' border='0' class='tbl-border'>\n";
						echo "<tr>";
							if ($petno >= 1) {
								echo "<td width='".$tdwidth."' class='tbl1'>";
								echo "<center><a href='".$plink['UBP_103']."'><img src=\"".$petimgpath['1']."normal.gif\" height='100' width='100' /></a><br /><strong>".$pet[1]['p']['name']."</center>";
								echo "</td>\n";
								if ($petno == 1) {
									echo "</tr>\n";
								}
							}
							if ($petno >= 2) {
								echo "<td width='".$tdwidth."' class='tbl2'>";
								echo "<center><a href='".$plink['UBP_104']."'><img src=\"".$petimgpath['2']."normal.gif\" height='100' width='100' /></a><br /><strong>".$pet[2]['p']['name']."</center>";
								echo "</td>\n</tr>\n";
							}
							if ($petno >= 3) {
								echo "<tr>";
								if ($petno == 3){
									echo "<td colspan='2' class='tbl2'>";
								} else {
									echo "<td width='".$tdwidth."' class='tbl2'>";
								}
								echo "<center><a href='".$plink['UBP_105']."'><img src=\"".$petimgpath['3']."normal.gif\" height='100' width='100' /></a><br /><strong>".$pet[3]['p']['name']."</center>";
								echo "</td>\n";
								if ($petno == 3) {
									echo "</tr>\n";
								}
							}
							if ($petno == 4) {
								echo "<td width='".$tdwidth."' class='tbl1'>";
								echo "<center><a href='".$plink['UBP_106']."'><img src=\"".$petimgpath['4']."normal.gif\" height='100' width='100' /></a><br /><strong>".$pet[4]['p']['name']."</center>";
								echo "</td>\n";
								echo "</tr>\n";
							}
						echo "</td></tr></table>\n";
						echo "</center>";
				closetable();
			}
			elseif ($step == 2 && isset($pet_id)){
				$abandon_p = dbarray(dbquery("SELECT * FROM ".DB_UBERPETS_PETS." WHERE uid=".$userdata['user_id']." AND usrpet=".$pet_id.""));
				opentable("Abandon");
					echo "<center>\n<br />\n";
					echo "<img src='".$petimgpath[$pet_id]."normal.gif' height='100' width='100' />";
					echo "<br /><br />\n";
					echo "Don't leave meeeeee!!!!! You can't ignore meeeeee!!!!!<br /><br />\n";
					echo "Are you <b>REALLY</b> sure you want to abandon your ".$abandon_p['species'].", ".$abandon_p['name']."?";
					echo "<br />\n<br />\n";
					echo "[<a href='".$plink['UBP_107']."'>Yes</a>]";
					echo "<br />\n";
					echo "[<a href='".$plink['UBP_108']."'>I'd never leave ".$abandon_p['name']."! What was I thinking?</a>]";
					echo "</center>";
				closetable();
			}
			
			elseif ($step == 3 && isset($pet_id)){
	//Remove a character from $pet_id (unnecessary)
				$petid = $pet_id;
	//Define # of pets into a variable
				$petno = $pets_of_user;
	//We'll be using this number quite a bit...
				$petno2 = $petno-1;
	//Define the abandoned pet's image
				$petimg = $petimgpath[$petid];
	//Create the array of the abandoned pet
				$abandon = dbarray(dbquery("SELECT * FROM ".$db_prefix."uberpets_pets WHERE uid=".$userdata['user_id']." AND usrpet=".$petid.""));
	//Transfer pet to the pound
		//Add to the pound
				dbquery("INSERT INTO ".DB_UBERPETS_POUND." (uid, name, color, species, type, usrpet, active, days) VALUES ('".$abandon['uid']."','".$abandon['name']."','".$abandon['color']."','".$abandon['species']."','".$abandon['type']."','0','0',".$abandon['days'].")");
		//And delete the local pet
				dbquery("DELETE FROM ".UPREFIX."pets WHERE pid='".$abandon['pid']."'");
	//Now to change the pet usrpets...
					if ($petid == 1 && $petno >= 2){
							dbquery("UPDATE ".DB_UBERPETS_PETS." SET usrpet='1' WHERE uid='".$userdata['user_id']."' AND usrpet='2'");
					}
					if ($petid <= 2 && $petno >= 3){
							dbquery("UPDATE ".DB_UBERPETS_PETS." SET usrpet='2' WHERE uid='".$userdata['user_id']."' AND usrpet='3'");
					}
					if ($petid <= 3 && $petno >= 4){
							dbquery("UPDATE ".DB_UBERPETS_PETS." SET usrpet='3' WHERE uid='".$userdata['user_id']."' AND usrpet='4'");
					}
					
	//And, of course, make the new usrpet 1 active if the active pet was abandoned
					if ($abandon['active'] == 1){
							dbquery("UPDATE ".$db_prefix."uberpets_pets SET active='1' WHERE uid='".$userdata['user_id']."' AND usrpet='1'");
					}
	//And echo the abandoned pet.
					opentable("Abandon");
						echo "<center>You have abandoned ".$abandon['name'].".<br /><br /><img src='".$petimg."normal.gif' height='100' width='100' /><br />I knew that you hated me all along!!! Waaaahhh!!!<br /><br />[<a href='".$plink['UBP_109']."'>Back to Uberpets Main</a>]</center>";
					closetable();
	//If the step == anything else, redirect to Abandon main.
			} else {
				redirect($plink['UBP_102']);
			}
//If the page == anything else, redirect to Pound Main.
		} else {
			redirect($plink['UBP_108']);
		}
		
//BOTTOM PAGE INCLUDES
if (preg_match("/^[6]./",$settings['version'])) {
	require_once UBP_BASE."includes/side_right.php";
	require_once BASEDIR."footer.php";
}
elseif (preg_match("/^[7]./", $settings['version'])) {
	require_once THEMES."templates/footer.php";
}
//END
?>
