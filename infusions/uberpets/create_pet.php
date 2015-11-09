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

include UBP_BASE."includes/pagelinks.php";

//PAGE INCLUDES END
if (isset($_POST['petcreate'])){
		//Let's define some variables and create the check if the created pet has the posted name
	$pet_owned = stripinput($_POST['petname_cancer']);
	$check = dbrows(dbquery("SELECT name FROM ".DB_UBERPETS_PETS." WHERE name='".$pet_owned."'"));
	//Now let's see if a name was entered
		if (empty($pet_owned)) { 
			echo render_error("No pet name", "You didn't enter a pet name!", "-1");
		}
	
	//Check if a color was chosen
		elseif (empty($_POST[petcolor_cancer])) { 
			echo render_error("No pet color", "You didn't choose a pet color!", "-1");
		}
	//Check if the name is valid (Letters, Numbers, Spaces, Underscores, and Hyphens)
		elseif(!preg_match("/^[\w\s\-]+$/", $pet_owned)){
			echo render_error("A-Z, 0-9, Underscores, and Spaces only!", "Sorry, but you must only use letters, numbers, underscores, and spaces in your pet's name!", "-1");
		}
	//Check if the user already has 4 pets
		elseif ($pets_of_user == 4) {
			echo render_error("Maximum number of pets", "Sorry, but you already have 4 pets...", "-1");
		}
	//Check the database if the name is already in use
		elseif ($check != 0) {
			echo render_error("Name already taken", "Sorry, but the name ".$pet_owned." is already taken.", "-1");
		} else {
	//If the checks are bypassed, then create a pet and redirect to step 3
	
			if (!isset($pets_of_user) || $pets_of_user <= 0){
				$active_pet_if_no_pets_defined = 1;
			} else {
				$active_pet_if_no_pets_defined = 0;
			}
	
			if (!isset($pets_of_user)){
				$create_entry == 1;
			} else {
				$create_enrty == 0;
			}
	
			if ($active_pet_if_no_pets_defined == 1){
				$usrpet = 1;
			}
			elseif ($pets_of_user == 1){
				$usrpet = 2;
			}
			elseif ($pets_of_user == 2){
				$usrpet = 3;
			}
			elseif ($pets_of_user == 3){
				$usrpet = 4;
			} else {
				redirect(UBP_BASE."index.php");
			}
	
			
				$name = stripinput($_POST[petname_cancer]);
				$color = stripinput($_POST[petcolor_cancer]);
				$species = stripinput($_POST[petspecies_cancer]);
				
			dbquery("INSERT INTO ".DB_UBERPETS_PETS." (uid, name, color, species, type, active, usrpet)
			VALUES ('".$userdata['user_id']."','".$name."','".$color."','".$species."','regular','".$active_pet_if_no_pets_defined."','".$usrpet."')");
			
			if ($create_entry == 1){
				dbquery("INSERT INTO ".DB_UBERPETS_USER." (uid,pets) 
				VALUES (".$userdata['user_id'].",".$usrpet.")");
			} else {
				dbquery("UPDATE ".DB_UBERPETS_USER." SET pets=".$usrpet." WHERE uid=".$usr['uid']."");
			}
			redirect($plink['UBP_204']);
		}
} else {
	$step = stripinput($_GET['step']);
	
		if (isset($usr) && $pets_of_user == "4" && $step != "3"){
			opentable("Create a Pet");
			echo "<center>Sorry, but at the moment you may only create 4 pets.</center>";
			closetable();
		} else {
				if (!isset($_GET['step'])){
					redirect($plink['UBP_201']);
				}
				
				if ($step == 1){
					opentable("Create a Pet");
					$query = dbquery("SELECT sid FROM ".DB_UBERPETS_PET_SPECIES."");
					$pet_species = dbarray($query);
						
						echo "<center>Here you can create your first pet! Please choose. You will be able to change the color.</center><br /><br />";		
								
								$count = dbrows($query);
								$display_columns = 4;
								$padding = ($display_columns-1)-(($count-1)%$display_columns);
								echo '<table width="100%">';
								// Let's begin our loop.
									for($i=0; $i<$count; $i++)
									{
									    if($i%$display_columns == 0)
									        echo "<tr>";
										
										$current_pet_species_info = dbarray(dbquery("SELECT * FROM ".DB_UBERPETS_PET_SPECIES." WHERE sid='".dbresult($query, $i)."'"));
									    echo "<td width='25%'>";
									    echo "<center><a href='".$plink['UBP_202'].$current_pet_species_info['name']."'>";
										echo "<img src='".UBP_BASE."pets/regular/".$current_pet_species_info['folder']."/".$current_pet_species_info['default_color']."/Normal.gif' height='100' width='100' /></a><br />";
										echo "<b>".$current_pet_species_info['name']."</b>&nbsp;";
										echo "</center><br /><br /><br />";
									    echo "</td>";
										
										
									    if($i%$display_columns == $display_columns-1)
									        echo "</tr>";
										
									}
								if($padding!=0){
									for($i=0;$i<$padding;$i++)
								        echo "<td></td>";
								    echo "</tr>";
								}
								echo "</table>";
						
	
					closetable();
				}
				
				if ($step == 2 && isset($_GET['species'])){
					opentable("Create a Pet");
						$species = stripinput($_GET['species']);
						$species_data = dbarray(dbquery("SELECT * FROM ".DB_UBERPETS_PET_SPECIES." WHERE name='".$species."'"));
						$species_path = PETS."regular/".$species_data['folder']."/";
						echo "<center>You chose a ".$species.".<br /><br />";
						echo $species_data['info'];
						echo "<br /><br />Please choose a name and color for your soon-to-be-created ".$species.".</center><br /><br />";
							$pet_color_list = makefilelist($species_path, ".|..", true, "folders");
								$display_columns = 4;
								$count = count($pet_color_list, COUNT_RECURSIVE);
								$padding = ($display_columns-1)-(($count-1)%$display_columns);
								echo "<form action='".UBERPETS.FUSION_SELF."' method='post'>";
								echo '<table width="100%">';
								// Let's begin our loop.
								for($i=0; $i<$count; $i++)
								{
								    if($i%$display_columns == 0)
								        echo '<tr>';
								    echo '<td width="25%">';
								    echo '<center><img src="'.$species_path.''.$pet_color_list[$i].'/normal.gif" height="100" width="100" /><br /><b>'.$pet_color_list[$i].'</b>&nbsp;<input type="radio" name="petcolor_cancer" value="'.$pet_color_list[$i].'"/><br /><br />';
								    echo '</td>';
								    if($i%$display_columns == $display_columns-1)
								        echo '</tr>';
								}
								if($padding!=0)
								{    for($i=0;$i<$padding;$i++)
								        echo '<td></td>';
								    echo '</tr>';
								}
								echo "<tr><td colspan='1' align='right'><b>Name of your ".$species.":&nbsp;<br /><font size='2'>Maximum letters: 20</font></b></td><td colspan='3' align='left'><input type='text' name='petname_cancer' length='20' maxlength='20' /></td></tr><tr><td colspan='4'><input type='hidden' name='petspecies_cancer' value='".$species."'><input type='hidden' name='petcreate' value='Created'><center><br /><input type='submit' value='Create your pet!'></center></td></tr>";
								echo "</table></form>";
					closetable();
				}
		}
		if ($step == 3){
			opentable("Create a Pet");
			echo "<center>Your pet has been created!<br />Remember, you can only own 4 pets.</center>";
			closetable();
		}
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
