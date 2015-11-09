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

$game_name = stripinput($_REQUEST['game_name']);
$score = stripinput($_REQUEST['score']);

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


if (!$_POST['game_name'] || !$_POST['score'] || !$userdata['user_id'])
{
require_once "../../maincore.php";
require_once THEMES."templates/header.php";

opentable($locale['VARC801']);
echo '<div align="center"><b>'.$locale['VARC802'].' <br> '.$locale['VARC803'].'</b><br>';
if($_POST['game_name']=='')
{
echo "".$locale['VARC804']."<br>";
}
if($_POST['score']=='')
{
echo "".$locale['VARC805']."<br>";
}
echo '<a href="'.INFUSIONS.'varcade/index.php">'.$locale['VARC806'].'</a>
<br></div>';
closetable();

require_once "footer.php";
require_once THEMES."templates/footer.php";
exit;
}

$game_name = htmlspecialchars($_POST['game_name']);
$score1 = doubleval(htmlspecialchars($_POST['score']));
//lets try to kill all decimals in the recieved score
$pieces = explode(".", $score1);//break it at the decimal
$score=$pieces[0];//use only the predecimal info

$currentgame=$game_name.'.swf';
$result = dbquery("SELECT DISTINCT * FROM ".$db_prefix."varcade_games WHERE flash = '".$currentgame."'"); 
$current = dbarray($result);
$user_id = $userdata['user_id'];

//check comp  expiry
$curtime = time();
if ($varcsettings['tournaments'] == "1")
{
$tourexpire = dbquery("SELECT DISTINCT * FROM ".$db_prefix."varcade_tournaments WHERE tour_game = '".$current['lid']."' ORDER BY id DESC");
$tourdata = dbarray($tourexpire);

if ($tourdata['tour_game'] == $current['lid'] AND $tourdata['tour_enddate'] >= $curtime)
{
redirect("".INFUSIONS."varcade/tournament.php?score=$score");
exit;
}
//Continue with normal score no tournament here.
}

$countplay = dbquery("UPDATE ".$db_prefix."varcade_games SET played= played+1,lastplayed = '".time()."' WHERE lid ='".$current['lid']."' LIMIT 1 ;");

//if we have reversed scoreing & the score is 0, we need to set a temp value to a rediculous high number.
if (($current['reverse']=="1") && ($current['hiscore'] == "0"))
{
$current['hiscore'] ="99999999999";
}
$thisbonus = 0;

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
$result = dbquery("SELECT * FROM ".$db_prefix."varcade_score WHERE game_id = '".$current['lid']."' AND player_id = '".$user_id."' ORDER BY game_score"); 
$myscore = dbarray($result);
$rows = dbrows($result);

if (($current['reverse']=="1") && ($rows == "0"))
{
$addnewscore = dbquery("INSERT INTO ".$db_prefix."varcade_score ( score_id , game_id , player_id , game_score , score_date )  VALUES ('', '$current[lid]', '$user_id', '$score', ".time().")");
}
//check the current score against the stored scores
if (($current['reverse']=="1") && ($score < $myscore['game_score']))
{
$addnewscore = dbquery("INSERT INTO ".$db_prefix."varcade_score ( score_id , game_id , player_id , game_score , score_date )  VALUES ('', '$current[lid]', '$user_id', '$score', ".time().")");
$scorefix = dbquery("DELETE FROM ".$db_prefix."varcade_score WHERE game_id = '".$current['lid']."' AND player_id = '".$user_id."' AND game_score > '".$score."'");
}

if (($current['reverse']=="0") && ($score > $myscore['game_score']))
  {
$addnewscore = dbquery("INSERT INTO ".$db_prefix."varcade_score ( score_id , game_id , player_id , game_score , score_date )  VALUES ('', '$current[lid]', '$user_id', '$score', ".time().")");
$scorefix = dbquery("DELETE FROM ".$db_prefix."varcade_score WHERE game_id = '".$current['lid']."' AND player_id = '".$user_id."' AND game_score < '".$score."'");
}


if ($varcsettings['usergold']=="1") {
//edited to work with UG3 and UG2 - Start
	if(USERGOLD){
		$gold = $current['reward']+$thisbonus;
		payuser($userdata['user_id'],$gold,'cash');
	} else {
		if (dbcount("(*)", "users_points", "owner_id= '$user_id'")) {
			$userpoints=dbarray(dbquery("SELECT * FROM ".$db_prefix."users_points WHERE owner_id='".$userdata['user_id']."'"));
			$thisreward = $userpoints['points_total'] + $current['reward'] + $thisbonus;
			$result = dbquery("UPDATE ".$db_prefix."users_points SET points_total = '$thisreward' WHERE owner_id = " . $userdata['user_id']."");
		} else {
			$newreward = $current['reward'] + $thisbonus;
			$result = dbquery("INSERT INTO ".$db_prefix."users_points ( owner_id , owner_name , points_total )VALUES ('".$userdata['user_id']."', '".$userdata['user_name']."', '".$newreward."');");
		}
	}
//edited to work with UG3 and UG2 - End	
	$gold = $current['reward']+$thisbonus;

if ($varcsettings['popup']=="1")
{
redirect("".INFUSIONS."varcade/gameover.php?p=1&s=$score&g=$current[lid]&gold=$gold"); 
}
else
{
redirect("".INFUSIONS."varcade/gameover.php?s=$score&g=$current[lid]&gold=$gold"); 
}
exit;
}

if ($varcsettings['popup']=="1")
{
redirect("".INFUSIONS."varcade/gameover.php?p=1&s=$score&g=$current[lid]"); 
}
else
{
redirect("".INFUSIONS."varcade/gameover.php?s=$score&g=$current[lid]"); 
}

exit;
?>
