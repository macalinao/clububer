<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Author: Domi & fetloser
| www.venue.nu			     	      
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
require_once "../../maincore.php";

if (isset($score) && !isNum($score)) fallback("index.php");
if (empty($_SERVER['HTTP_REFERER']) || eregi('newscore.php',$_SERVER['HTTP_REFERER']) || eregi('proarcade.php',$_SERVER['HTTP_REFERER'])) fallback("index.php");
$score = stripinput($_REQUEST['score']);

if (!defined("LANGUAGE")) {
// PHPFusion environment
$this_lang =  str_replace("/", "", LOCALESET);
	if (file_exists(INFUSIONS."varcade/locale/".$this_lang.".php")) {
	   include INFUSIONS."varcade/locale/".$this_lang.".php";
	} else {
	   include INFUSIONS."varcade/locale/English.php";
	}
        } else {
// mFusion environment
$this_lang =  LANGUAGE;
	if (file_exists(INFUSIONS."varcade/locale/".$this_lang.".php")) {
	   include INFUSIONS."varcade/locale/".$this_lang.".php";
	} else {
	   include INFUSIONS."varcade/locale/English.php";
	}
}
$resultvset = dbquery("SELECT * FROM ".$db_prefix."varcade_settings");
$varcsettings = dbarray($resultvset);

//No need to try scoreing for guests
if (!iMEMBER) 
{ 
if ($varcsettings['popup']=="1")
{
redirect("".INFUSIONS."varcade/guests.php?p=1"); 
}
else
{
redirect("".INFUSIONS."varcade/guests.php"); 
}
exit; 
}

//Get tournament info
$curtime = time();
$tourinfo = dbquery("SELECT * FROM ".$db_prefix."varcade_tournaments ORDER BY id DESC LIMIT 1");
$tourdata = dbarray($tourinfo);


$tour_id = "".$tourdata['id']."";
$tour_game = "".$tourdata['tour_game']."";
$tour_title = "".$tourdata['tour_title']."";
$tour_icon = "".$tourdata['tour_icon']."";
$tour_flash = "".$tourdata['tour_flash']."";
$tour_winner = "".$userdata['user_name']."";
$tour_score = "".$score."";
$tour_players = "".$tourdata['tour_players']."";
$tour_startdate = "".$tourdata['tour_startdate']."";
$tour_enddate = "".$tourdata['tour_enddate']."";
$player_id = "".$userdata['user_id'].""; 


if (($tourdata['tour_reverse']=="1") && ($tourdata['tour_score'] == "0"))
{
$tourdata['tour_score'] ="99999999999";
}

if (($tourdata['tour_reverse']=="1") && ($score < $tourdata['tour_score']))
   {
$updatetournament = dbquery("UPDATE ".$db_prefix."varcade_tournaments SET tour_game='$tour_game', tour_title='$tour_title', tour_icon='$tour_icon', tour_flash='$tour_flash', tour_winner='$tour_winner', tour_score='$tour_score', tour_players='$tour_players', tour_startdate='$tour_startdate', tour_enddate='$tour_enddate' WHERE id = '$tour_id'");
  }
if (($tourdata['tour_reverse']=="0") && ($score > $tourdata['tour_score']))
   {
$updatetournament = dbquery("UPDATE ".$db_prefix."varcade_tournaments SET tour_game='$tour_game', tour_title='$tour_title', tour_icon='$tour_icon', tour_flash='$tour_flash', tour_winner='$tour_winner', tour_score='$tour_score', tour_players='$tour_players', tour_startdate='$tour_startdate', tour_enddate='$tour_enddate' WHERE id = '$tour_id'");
  }

$result = dbquery("SELECT * FROM ".$db_prefix."varcade_tournament_scores WHERE tour_id = '".$tour_id."' AND player_id = '".$player_id."' ORDER BY game_score"); 
$mytscore = dbarray($result);
$rows = dbrows($result);

if (($tourdata['tour_reverse']=="1") && ($rows == "0"))
{
$addnewscore = dbquery("INSERT INTO ".$db_prefix."varcade_tournament_scores ( id , game_id ,tour_id, player_id , game_score , score_date )  VALUES ('', '$tour_game', '".$tour_id."', '$player_id', '$score', ".time().")");
}

if (($tourdata['tour_reverse']=="1") && ($score < $mytscore['game_score']))
     {
$addnewscore = dbquery("INSERT INTO ".$db_prefix."varcade_tournament_scores ( id , game_id ,tour_id, player_id , game_score , score_date )  VALUES ('', '$tour_game', '".$tour_id."', '$player_id', '$score', ".time().")");
$scorefix = dbquery("DELETE FROM ".$db_prefix."varcade_tournament_scores WHERE tour_id = '".$tour_id."' AND player_id = '".$player_id."' AND game_score > '".$score."'");
  }

if (($tourdata['tour_reverse']=="0") && ($score > $mytscore['game_score']))
     {
$addnewscore = dbquery("INSERT INTO ".$db_prefix."varcade_tournament_scores ( id , game_id ,tour_id, player_id , game_score , score_date )  VALUES ('', '$tour_game', '".$tour_id."', '$player_id', '$score', ".time().")");
$scorefix = dbquery("DELETE FROM ".$db_prefix."varcade_tournament_scores WHERE tour_id = '".$tour_id."' AND player_id = '".$player_id."' AND game_score < '".$score."'");
  }

//pumpup the played status..

$counttourplays = dbquery("UPDATE ".$db_prefix."varcade_tournaments SET tour_players = tour_players+1 WHERE id = '$tour_id'");

// ********************** Tournament End ************************
$current = dbarray(dbquery("SELECT * FROM ".$db_prefix."varcade_games WHERE lid = '".$tour_game."' LIMIT 0,1")); 

$countplay = dbquery("UPDATE ".$db_prefix."varcade_games SET played= played+1,lastplayed = '".time()."' WHERE lid ='".$current['lid']."' LIMIT 1 ;");

//if we have reversed scoreing & the score is 0, we need to set a temp value to a rediculous high number.
if (($current['reverse']=="1") && ($current['hiscore'] == "0"))
{
$current['hiscore'] ="99999999999";
}
$thisbonus = 0;
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
/*						Games Table Entries				 	 */
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

//do the games table entry if valid
if (($current['reverse']=="1") && ($score < $current['hiscore']))
{
$oldhigh = dbarray(dbquery("SELECT ter.*, user_id,user_name FROM ".$db_prefix."varcade_games ter
		LEFT JOIN ".$db_prefix."users tusr ON ter.hi_player=tusr.user_name
		WHERE lid='".$current['lid']."' AND user_name ='".$current['hi_player']."'"));


//Send A message to player for hiscore defeat
if (($varcsettings['hiscorepm']=="1") && ($oldhigh['user_id'] != $userdata['user_id']) && ($oldhigh['user_id']) != 0)
	{
$pmtitle=$current['title'];
$asubject = $locale['VARC317'].' '.$pmtitle;
if ($varcsettings['popup']=="1")
{
$amessage = "$asubject \n\n ".$locale['VARC311']." ".$userdata['user_name']." ".$locale['VARC312']." $score".$locale['VARC313']." ".$oldhigh['hiscore'].".\n<a href=\'".INFUSIONS."varcade/arcade.php?p=1&game=".$current['lid']."\' target=\'_blank\'>\<b>".$locale['VARC314']."</b></a>\n\n".$locale['VARC315']." ".$userdata['user_name'];
}
else
{
$amessage = "$asubject \n\n ".$locale['VARC311']." ".$userdata['user_name']." ".$locale['VARC312']." $score".$locale['VARC313']." ".$oldhigh['hiscore'].".\n<a href=\'".INFUSIONS."varcade/arcade.php?game=".$current['lid']."\' target=\'_self\'>\<b>".$locale['VARC314']."</b></a>\n\n".$locale['VARC315']." ".$userdata['user_name'];
}
dbquery("INSERT INTO `".$db_prefix."messages` ( `message_id` , `message_to` , `message_from` , `message_subject` , `message_message` , `message_smileys` , `message_read` , `message_datestamp` , `message_folder` )VALUES ('', '".$oldhigh['user_id']."', '".$userdata['user_id']."', '".$asubject."', '".$amessage."', '0', '0', '".time()."' , '0');");
	}

	//ok everyone knows about it now so we will add the new score to the system
	$newhi= dbquery("UPDATE ".$db_prefix."varcade_games SET hiscore = '".$score."',hi_player = '".$userdata['user_name']."', hiscoredate = '".$curtime."' WHERE lid ='".$current['lid']."' LIMIT 1 ;");
	$thisbonus = "".$current['bonus']."";
	}

//end highest score

//do the games table entry if valid non reversed
if (($current['reverse']=="0") && ($score > $current['hiscore']))
{
$oldhigh = dbarray(dbquery("SELECT ter.*, user_id,user_name FROM ".$db_prefix."varcade_games ter
		LEFT JOIN ".$db_prefix."users tusr ON ter.hi_player=tusr.user_name
		WHERE lid='".$current['lid']."' AND user_name ='".$current['hi_player']."'"));


//Send A message to player for hiscore defeat
if (($varcsettings['hiscorepm']=="1") && ($oldhigh['user_id'] != $userdata['user_id']) && ($oldhigh['user_id']) != 0)
	{
$pmtitle=$current['title'];
$asubject = $locale['VARC317'].' '.$pmtitle;
if ($varcsettings['popup']=="1")
{
$amessage = "$asubject \n\n ".$locale['VARC311']." ".$userdata['user_name']." ".$locale['VARC312']." $score".$locale['VARC313']." ".$oldhigh['hiscore'].".\n<a href=\'".INFUSIONS."varcade/arcade.php?p=1&game=".$current['lid']."\' target=\'_blank\'>\<b>".$locale['VARC314']."</b></a>\n\n".$locale['VARC315']." ".$userdata['user_name'];
}
else
{
$amessage = "$asubject \n\n ".$locale['VARC311']." ".$userdata['user_name']." ".$locale['VARC312']." $score".$locale['VARC313']." ".$oldhigh['hiscore'].".\n<a href=\'".INFUSIONS."varcade/arcade.php?game=".$current['lid']."\' target=\'_self\'>\<b>".$locale['VARC314']."</b></a>\n\n".$locale['VARC315']." ".$userdata['user_name'];
}
dbquery("INSERT INTO `".$db_prefix."messages` ( `message_id` , `message_to` , `message_from` , `message_subject` , `message_message` , `message_smileys` , `message_read` , `message_datestamp` , `message_folder` )VALUES ('', '".$oldhigh['user_id']."', '".$userdata['user_id']."', '".$asubject."', '".$amessage."', '0', '0', '".time()."' , '0');");
	}

	//ok everyone knows about it now so we will add the new score to the system
	$newhi= dbquery("UPDATE ".$db_prefix."varcade_games SET hiscore = '".$score."',hi_player = '".$userdata['user_name']."', hiscoredate = '".$curtime."' WHERE lid ='".$current['lid']."' LIMIT 1 ;");
	$thisbonus = "".$current['bonus']."";
	}

//end highest score


//get the scores for this game and this player
$result = dbquery("SELECT * FROM ".$db_prefix."varcade_score WHERE game_id = '".$current['lid']."' AND player_id = '".$player_id."' ORDER BY game_score"); 
$myscore = dbarray($result);
$rows = dbrows($result);

if (($current['reverse']=="1") && ($rows == "0"))
{
$addnewscore = dbquery("INSERT INTO ".$db_prefix."varcade_score ( score_id , game_id , player_id , game_score , score_date )  VALUES ('', '$current[lid]', '$player_id', '$score', ".time().")");
}

//check the current score against the stored scores
if (($current['reverse']=="1") && ($score < $myscore['game_score']))
{
$addnewscore = dbquery("INSERT INTO ".$db_prefix."varcade_score ( score_id , game_id , player_id , game_score , score_date )  VALUES ('', '$current[lid]', '$player_id', '$score', ".time().")");
$scorefix = dbquery("DELETE FROM ".$db_prefix."varcade_score WHERE game_id = '".$current['lid']."' AND player_id = '".$player_id."' AND game_score > '".$score."'");
}

if (($current['reverse']=="0") && ($score > $myscore['game_score']))
  {
$addnewscore = dbquery("INSERT INTO ".$db_prefix."varcade_score ( score_id , game_id , player_id , game_score , score_date )  VALUES ('', '$current[lid]', '$player_id', '$score', ".time().")");
//remove all other scores for this player
$scorefix = dbquery("DELETE FROM ".$db_prefix."varcade_score WHERE game_id = '".$current['lid']."' AND player_id = '".$player_id."' AND game_score < '".$score."'");
}


if ($varcsettings['usergold']=="1")
	{
if(USERGOLD){
		$gold = $current['reward']+$thisbonus;
		payuser($userdata['user_id'],$gold,'cash');
	} else {

	if (dbcount("(*)", "users_points", "owner_id= '$player_id'"))
		{
			$userpoints=dbarray(dbquery("SELECT * FROM ".$db_prefix."users_points WHERE owner_id='".$userdata['user_id']."'"));
			$thisreward = $userpoints['points_total'] + $current['reward'] + $thisbonus;
			$result = dbquery("UPDATE ".$db_prefix."users_points SET points_total = '$thisreward' WHERE owner_id = " . $userdata['user_id']."");
		}
		else
		{
			$newreward = $current['reward'] + $thisbonus;
			$result = dbquery("INSERT INTO ".$db_prefix."users_points ( owner_id , owner_name , points_total )VALUES ('".$userdata['user_id']."', '".$userdata['user_name']."', '".$newreward."');");
		}
	$gold = $current['reward']+$thisbonus;

}
}
//***************** END ordinary score handling **********************

if ($varcsettings['popup']=="1")
{
redirect("".INFUSIONS."varcade/gameover.php?p=1&c=1&g=$tour_game&score=$score");
}
else
{
redirect("".INFUSIONS."varcade/gameover.php?c=1&g=$tour_game&score=$score");
}

exit;
?>
