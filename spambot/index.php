<?php
if (isset($_POST['spam'])) {
	$to = $_POST['to'];
	$limit = intval($_POST['limit']);
	$i = 1;
	while($i <= $limit) {
		sendemail($to,$to,"SpamBot v1.0 rand=".$i,$i."techsupport@jeff".$i."isanoob.com","This is not spam. Muhaha. My lucky nmber is ".$i,"spam lol rofl btw ".$i);
		$i++;
	}
	echo "<center>Spam successful.</center>";
}
	echo "<center>\n";
	echo "<form name='spam' action='".$_SERVER['PHP_SELF']."' method='post' />\n";
	echo "<input type='text' value='Spam who?' name='to' /><br />\n";
	echo "<input type='text' value='How many times?' name='limit' /><br />\n";
	echo "<input type='submit' name='spam' value='Spam!' /><br />\n";
	echo "</form>\n";
	echo "</center>\n";

function sendemail($toname,$toemail,$fromname,$fromemail,$subject,$message,$type="plain",$cc="",$bcc="") {

	global $settings, $locale;
	
	require_once "phpmailer_include.php";
	
	$mail = new PHPMailer();
	$mail->SetLanguage("en", "");

	if ($settings['smtp_host']=="") {
		$mail->IsMAIL();
	} else {
		$mail->IsSMTP();
		$mail->Host = $settings['smtp_host'];
		$mail->SMTPAuth = true;
		$mail->Username = $settings['smtp_username'];
		$mail->Password = $settings['smtp_password'];
	}
	
	$mail->CharSet = $locale['charset'];
	$mail->From = $fromemail;
	$mail->FromName = $fromname;
	$mail->AddAddress($toemail, $toname);
	$mail->AddReplyTo($fromemail, $fromname);
	if ($cc) { 
		$cc = explode(", ", $cc);
		foreach ($cc as $ccaddress) {
			$mail->AddCC($ccaddress);
		}
	}
	if ($bcc) {
		$bcc = explode(", ", $bcc);
		foreach ($bcc as $bccaddress) {
			$mail->AddBCC($bccaddress);
		}
	}
	if ($type == "plain") {
		$mail->IsHTML(false);
	} else {
		$mail->IsHTML(true);
	}
	
	$mail->Subject = $subject;
	$mail->Body = $message;
	
	if(!$mail->Send()) {
		$mail->ErrorInfo;
		$mail->ClearAllRecipients();
		$mail->ClearReplyTos();
		return false;
	} else {
		$mail->ClearAllRecipients(); 
		$mail->ClearReplyTos();
		return true;
	}

}
?>