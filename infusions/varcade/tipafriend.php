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
require_once THEME."theme.php";
echo "<link rel='stylesheet' href='".THEME."styles.css' type='text/css'>";

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

$resultvset = dbquery("SELECT bannerimg FROM ".$db_prefix."varcade_settings");
$varcsettings = dbarray($resultvset);

$movie = dbquery("SELECT * FROM ".$db_prefix."varcade_games WHERE lid='$game_id'");
$movie1 = dbarray($movie);
$url="".$settings['siteurl']."infusions/varcade/arcade.php";
$gameindex="".$settings['siteurl']."infusions/varcade/index.php";
$sitename="".$settings['sitename']."";
$siteowner="".$settings['siteusername']."";
$banner="".$varcsettings['bannerimg']."";
$movielink = "".$movie1['lid']."";
$moviename = "".$movie1['title']."";
@$user = "".$userdata['user_name']."";
$subject = "".$locale['VARC602']."";
$insertmsg = "<br><center><img src=".$banner."></center><br>".$locale['VARC608']."<br><a href='$gameindex'>".$sitename."´s ".$locale['VARC609']."</a>.<br>".$locale['VARC610']." <a href='$url?game=$movielink'>$moviename</a>.<br>".$locale['VARC611']."<br>".$locale['VARC620']." $siteowner @ $sitename";
opentable("".$locale['VARC601']."");

   $error_msg = "<p id='fel_meddelande'><b>".$locale['VARC612']."</b></p>";
   $error = false;
   @$submit = $_POST['submit'];
   if(empty($submit))
      $form_sent = false;
   else
      $form_sent = true;
   if ($form_sent)
   {
      $to  = "$email";


      $name = $_POST['name'];
      $email = $_POST['email'];
      $subject = $_POST['subject'];
      $message = $_POST['message'];
 
      if(!$name) { $error_msg .= "<p id='fel_meddelande_error'><i>• ".$locale['VARC613']."</i><br /></p>"; $error = true;}
      if(!$email) { $error_msg .= "<p id='fel_meddelande_error'><i>• ".$locale['VARC614']."</i><br /></p>"; $error = true;}
      if(!$subject) { $error_msg .= "<p id='fel_meddelande_error'><i>• ".$locale['VARC615']."</i><br /></p>"; $error = true;}
      if(!$message) { $error_msg .= "<p id='fel_meddelande_error'><i>• ".$locale['VARC616']."</i><br /></p>"; $error = true;}
 
      if($email) { if(!eregi('^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.([a-zA-Z]{2,4})$', $email)){ $error_msg .= "<p id=\"pprojin\"><i>• ".$locale['VARC622']."</i></p>"; $error = true; }}
		    
      if(!$error)
      {
         @$msg .= "\r\n $message \r\n";
         $mailheaders  = "MIME-Version: 1.0\r\n";
         $mailheaders .= "Content-type: text/html; charset=iso-8859-1\r\n";
         $mailheaders .= "From: $name <$email>\r\n";
         $mailheaders .= "Reply-To: $name <$email>\r\n"; 
         mail($to, $subject ,stripslashes($msg), $mailheaders);
      }
   }
 
   if (($form_sent) && (!$error))
   {
      echo "<p id='about_motion_top'>".$locale['VARC617']." </b> ".$name.".<br><br>".$locale['VARC618']." <a href='javascript:window.close();'>".$locale['VARC619']."</a> ".$locale['VARC621']."</p>";

   }
   else
   {
      if ($error)
      {   
         echo $error_msg;
      } 
 
      ?>
         <form action="?sida=kontakta&game_id=$game_id" method="post" name="contact"><center>
            <p id="kontakt_text"><? echo "".$locale['VARC603'].""; ?><span style="color: #C53A09;">*</span> <input name="name" type="text" value="<?php echo $user; $name; ?>" style="margin-left: 7px; height: 14px; width: 180px; border: 1px solid #000; background-color: #636363;color: #FFF; font-size: 9px;"></p>
            
            <p id="kontakt_text"><? echo "".$locale['VARC604'].""; ?><span style="color: #C53A09;">*</span> <input name="email" type="text" value="" style="margin-left: 3px; height: 14px; width: 180px; border: 1px solid #000; background-color: #636363;color: #FFF; font-size: 9px;"></p>
            
            <p id="kontakt_text"><input name="subject" type="hidden" value="<?php echo $subject ?>" style="margin-left: 7px; height: 12px; width: 180px; border: 1px solid #000; background-color: #636363; color: #FFF; font-size: 9px;"></p>
 
            <br />
            <input name="message" type="hidden" value="<?php echo $insertmsg; $message;  ?>"  style="height: 17px; width: 60px; border: 1px solid #000; background-color: #636363; color: #000; font-size: 9px;">
            <input name="submit" type="submit" value="<? echo "".$locale['VARC606'].""; ?>" style="height: 17px; width: 60px; border: 1px solid #000; background-color: #636363; color: #000; font-size: 9px;">
            <input name="submit" type="reset" value="<? echo "".$locale['VARC607'].""; ?>" style="margin-left: 10px; height: 17px; width: 60px; border: 1px solid #000; background-color: #636363; color: #000; font-size: 9px;">
         </form></center>
      <?
}

echo "<br><b><center>".$locale['VARC623']."";
echo $insertmsg; $message; 
echo "</center>";
closetable();
?>