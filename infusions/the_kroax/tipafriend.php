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
	if (file_exists(INFUSIONS."the_kroax/locale/".$this_lang.".php")) {
	   include INFUSIONS."the_kroax/locale/".$this_lang.".php";
	} else {
	   include INFUSIONS."the_kroax/locale/English.php";
	}
        } else {
// mFusion environment
$this_lang =  LANGUAGE;
	if (file_exists(INFUSIONS."the_kroax/locale/".$this_lang.".php")) {
	   include INFUSIONS."the_kroax/locale/".$this_lang.".php";
	} else {
	   include INFUSIONS."the_kroax/locale/English.php";
	}
}

$movie = dbquery("SELECT * FROM ".$db_prefix."kroax WHERE kroax_id='$movie_id'");
$movie1 = dbarray($movie);
$hurl="".$settings['siteurl']."infusions/the_kroax/kroax.php";
$url="".$settings['siteurl']."infusions/the_kroax/embed.php";
$sitename="".$settings['sitename']."";
$siteowner="".$settings['siteusername']."";
$banner="".$settings['sitebanner']."";
$movielink = "".$movie1['kroax_id']."";
$moviename = "".$movie1['kroax_titel']."";
@$user = "".$userdata['user_name']."";
$subject = "".$locale['KROAX602']."";
$insertmsg = "<br><center><img src=".$banner."></center><br>".$locale['KROAX608']."<br><a href='$hurl'>".$sitename."´s ".$locale['KROAX609']."</a>.<br>".$locale['KROAX610']." <a href='$url?url=$movielink'>$moviename</a>.<br>".$locale['KROAX611']."<br>".$locale['KROAX620']." $siteowner @ $sitename";
opentable("".$locale['KROAX601']."");

   $error_msg = "<p id='fel_meddelande'><b>".$locale['KROAX612']."</b></p>";
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
 
      if(!$name) { $error_msg .= "<p id='fel_meddelande_error'><i>• ".$locale['KROAX613']."</i><br /></p>"; $error = true;}
      if(!$email) { $error_msg .= "<p id='fel_meddelande_error'><i>• ".$locale['KROAX614']."</i><br /></p>"; $error = true;}
      if(!$subject) { $error_msg .= "<p id='fel_meddelande_error'><i>• ".$locale['KROAX615']."</i><br /></p>"; $error = true;}
      if(!$message) { $error_msg .= "<p id='fel_meddelande_error'><i>• ".$locale['KROAX616']."</i><br /></p>"; $error = true;}
 
      if($email) { if(!eregi('^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.([a-zA-Z]{2,4})$', $email)){ $error_msg .= "<p id=\"pprojin\"><i>• ".$locale['KROAX622']."</i></p>"; $error = true; }}
		    
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
      echo "<p id='about_motion_top'>".$locale['KROAX617']." </b> ".$name.".<br><br>".$locale['KROAX618']." <a href='javascript:window.close();'>".$locale['KROAX619']."</a> ".$locale['KROAX621']."</p>";

   }
   else
   {
      if ($error)
      {   
         echo $error_msg;
      } 
 
      ?>
         <form action="?sida=kontakta&movie_id=$movie_id" method="post" name="contact">
            <p id="kontakt_text"><? echo "".$locale['KROAX603'].""; ?><span style="color: #C53A09;">*</span> <input name="name" type="text" value="<?php echo $user; $name; ?>" style="margin-left: 7px; height: 14px; width: 180px; border: 1px solid #000; background-color: #636363;color: #FFF; font-size: 9px;"></p>
            
            <p id="kontakt_text"><? echo "".$locale['KROAX604'].""; ?><span style="color: #C53A09;">*</span> <input name="email" type="text" value="" style="margin-left: 3px; height: 14px; width: 180px; border: 1px solid #000; background-color: #636363;color: #FFF; font-size: 9px;"></p>
            
            <p id="kontakt_text"><input name="subject" type="hidden" value="<?php echo $subject ?>" style="margin-left: 7px; height: 12px; width: 180px; border: 1px solid #000; background-color: #636363; color: #FFF; font-size: 9px;"></p>
 
            <p id="kontakt_text"><? echo "".$locale['KROAX605'].""; ?><span style="color: #C53A09;">*</span>
            <br />
            <textarea name="message" cols="30" rows="8" style="margin-left: 0px; height: 100px; border: 1px solid #000; background-color: #636363; color: #FFF; font-size: 12px; font-family: verdana; width: 250px;" readonly><?php echo $insertmsg; $message;  ?></textarea></p>
            
            <input name="submit" type="submit" value="<? echo "".$locale['KROAX606'].""; ?>" style="height: 17px; width: 60px; border: 1px solid #000; background-color: #636363; color: #000; font-size: 9px;">
            <input name="submit" type="reset" value="<? echo "".$locale['KROAX607'].""; ?>" style="margin-left: 10px; height: 17px; width: 60px; border: 1px solid #000; background-color: #636363; color: #000; font-size: 9px;">
         </form>
      <?
}
closetable();
?>