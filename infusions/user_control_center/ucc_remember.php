<?php

/*---------------------------------------------------+
| PHP-Fusion 6 Content Management System
+----------------------------------------------------+
| Copyright � 2002 - 2005 Nick Jones
| http://www.php-fusion.co.uk/
+----------------------------------------------------+
| Released under the terms & conditions of v2 of the
| GNU General Public License. For details refer to
| the included gpl.txt file or visit http://gnu.org
+----------------------------------------------------*
| User Control Center made by:
| Sebastian "slaughter" Sch�ssler
| http://basti2web.de
| Version 2.40
+----------------------------------------------------*/

// Check Rights
if (!defined("IN_FUSION")) { die("Access Denied"); }
if (!defined("IN_UCC")) { redirect("index.php"); }
if (!defined("iAUTH") || $_GET['aid'] != iAUTH) { redirect("index.php"); }
//if (!defined("UCC_ADMIN") || !UCC_ADMIN) { redirect("index.php"); }

require_once INCLUDES."sendmail_include.php";


if (isset($_POST['send']))
{
$mit_sub = "";

 opentable($locale['ucc_702']);
 
	$lavi = time() - $_POST['msg_lavi'];
	$subject = stripslash($_POST['subject']);
	
	if ($_POST['format'] == "plain") {
		$content = stripslash($_POST['content']);
	} else if ($_POST['format'] == "html") {
		$content = "<html>
								<head>
								<style type=\"text/css\">
								<!--
								a { color: #0000ff; text-decoration:none; }
								a:hover { color: #0000ff; text-decoration: underline; }
								body { font-family:Verdana,Tahoma,Arial,Sans-Serif; font-size:10px; }
								p { font-family:Verdana,Tahoma,Arial,Sans-Serif; font-size:10px; }
								.td { font-family:Verdana,Tahoma,Arial,Sans-Serif; font-size:10px; }
								-->
								</style>
								</head>
								<body>
								".stripslashes($_POST['content'])."
								</body>
								</html>";
	}

// not send e-mail to users, which registered 24 hours ago, but did not login
$toshort = time() - 60*60*24;

$result = dbquery("SELECT user_name, user_email FROM ".$db_prefix."users WHERE user_lastvisit <= '".$lavi."' AND user_joined <= ".$toshort." AND user_id != '".$ucc_ghost."' AND user_status = '0'");
while ($data = dbarray($result))
	{
	$sendtest = sendemail($data['user_name'], 
						$data['user_email'],
						$settings['siteusername'],
						$settings['siteemail'],
						$subject,
						$content,
						$_POST['format'],
						$cc="",
						$bcc="");
	$mit_sub .= $data['user_name'].", ";
	}

echo "<br />";

//	if (!$error) {
		if ($mit_sub == "" || $mit_sub == ", ")
		{
			echo $locale['ucc_703'];
		} else {
			echo $locale['ucc_704']."<br />".$mit_sub;
		}
//	} else {
//		echo $locale['ucc_705']."<br /><br />\n".$error;
//	}


if($sendtest) { echo "<br><br>sendtest: true"; } else { echo "<br><br>sendtest: false"; }

echo "<br /><br />\n";

closetable();

}

// Wenn kein SEND

$week1  = 60*60*24*7;
$week2  = 60*60*24*14;
$week3  = 60*60*24*21;
$monat1 = 60*60*24*30;
$monat2 = 60*60*24*30*2;
$monat3 = 60*60*24*30*3;
$monat4 = 60*60*24*30*4;
$monat6 = 60*60*24*30*6;
$monat8 = 60*60*24*30*8;
$year1  = 60*60*24*30*12;
$year2  = 60*60*24*30*24;


	if (isset($_POST['preview'])) {

	 	$sel_w1 = ($_POST['msg_lavi'] == $week1 ? " selected" : "");
	 	$sel_w2 = ($_POST['msg_lavi'] == $week2 ? " selected" : "");
	 	$sel_w3 = ($_POST['msg_lavi'] == $week3 ? " selected" : "");	 
	 	$sel_m1 = ($_POST['msg_lavi'] == $monat1 ? " selected" : "");
	 	$sel_m2 = ($_POST['msg_lavi'] == $monat2 ? " selected" : "");
	 	$sel_m3 = ($_POST['msg_lavi'] == $monat3 ? " selected" : "");
	 	$sel_m4 = ($_POST['msg_lavi'] == $monat4 ? " selected" : "");
	 	$sel_m6 = ($_POST['msg_lavi'] == $monat6 ? " selected" : "");
	 	$sel_m8 = ($_POST['msg_lavi'] == $monat8 ? " selected" : "");
	 	$sel_y1 = ($_POST['msg_lavi'] == $year1 ? " selected" : "");
	 	$sel_y2 = ($_POST['msg_lavi'] == $year2 ? " selected" : "");
	 	
		$subject = phpentities(stripslash($_POST['subject']));
		$content = phpentities(stripslash($_POST['content']));

		$plain = ($_POST['format'] == "plain" ? " checked" : "");
		$html = ($_POST['format'] == "html" ? " checked" : "");

		if ($_POST['format'] == "plain") {
			$contentpreview = nl2br(stripslash($_POST['content']));
		} else {
			$contentpreview = stripslash($_POST['content']);
		}

		opentable($subject);
		echo "$contentpreview\n";
		closetable();
		tablebreak();
		
	} else {
		 	$sel_w1 = "";
		 	$sel_w2 = "";
		 	$sel_w3 = "";
		 	$sel_m1 = "";
			$sel_m2 = "";
		 	$sel_m3 = " selected ";
			$sel_m4 = "";
		 	$sel_m6 = "";
			$sel_m8 = "";
		 	$sel_y1 = "";
		 	$sel_y2 = "";
			$subject = $locale['ucc_700']." ".$settings['sitename'];

			$content = $locale['ucc_720_plain'];
			$html = "";
			$plain = " checked";
	}


$action = FUSION_SELF.$aidlink."&section=remember";


opentable($locale['ucc_700']);

	echo $locale['ucc_701']."<br /><br /><form name='inputform' method='post' action='$action' onSubmit='return ValidateForm(this)'>
        <table align='center' cellspacing='0' cellpadding='0' class='tbl'>
          <tr>
            <td width='160'>".$locale['ucc_706'].":</td>
            <td><select name='msg_lavi' class='textbox'>\n
			<option value='".$week1."' ". $sel_w1.">".$locale['ucc_707_1']."</option>
			<option value='".$week2."' ". $sel_w2.">".$locale['ucc_707_2']."</option>
			<option value='".$week3."' ". $sel_w3.">".$locale['ucc_707_3']."</option>
			<option value='".$monat1."' ".$sel_m1.">".$locale['ucc_708_1']."</option>
			<option value='".$monat2."' ".$sel_m2.">".$locale['ucc_708_2']."</option>
			<option value='".$monat3."' ".$sel_m3.">".$locale['ucc_708_3']."</option>
			<option value='".$monat4."' ".$sel_m4.">".$locale['ucc_708_4']."</option>
			<option value='".$monat6."' ".$sel_m6.">".$locale['ucc_708_6']."</option>
			<option value='".$monat8."' ".$sel_m8.">".$locale['ucc_708_8']."</option>
			<option value='".$year1."' ". $sel_y1.">".$locale['ucc_709_1']."</option>
			<option value='".$year2."' ". $sel_y2.">".$locale['ucc_709_2']."</option>
			</select></td>
          </tr>
          <tr>
            <td width='160'>".$locale['ucc_711'].":</td>
            <td><input type='text' name='subject' value='$subject' class='textbox' style='width:250px;'></td>
          </tr>
          <tr>
            <td valign='top' width='160'>".$locale['ucc_712'].":</td>
            <td><textarea name='content' cols='95' rows='15' class='textbox'>$content</textarea></td>
          </tr>
          <tr>
            <td>".$locale['ucc_713'].":</td>
            <td>
              <input type='button' value='p' class='button' style='font-weight:bold;width:25px;' onClick=\"addText('content', '<p>', '</p>');\">
              <input type='button' value='br' class='button' style='font-weight:bold;width:25px;' onClick=\"insertText('content', '<br>');\">
              <input type='button' value='b' class='button' style='font-weight:bold;width:25px;' onClick=\"addText('content', '<b>', '</b>');\">
              <input type='button' value='i' class='button' style='font-style:italic;width:25px;' onClick=\"addText('content', '<i>', '</i>');\">
              <input type='button' value='u' class='button' style='text-decoration:underline;width:25px;' onClick=\"addText('content', '<u>', '</u>');\">
              <input type='button' value='link' class='button' style='width:35px;' onClick=\"addText('content', '<a href=\'http://\' target=\'_blank\'>', '</a>');\">
              <input type='button' value='img' class='button' style='width:35px;' onClick=\"insertText('content', '<img src=\'".$settings['siteurl']."fusion_images/\' style=\'margin:5px;\' align=\'left\'>');\">
              <input type='button' value='center' class='button' style='width:45px;' onClick=\"addText('content', '<center>', '</center>');\">
              <input type='button' value='small' class='button' style='width:40px;' onClick=\"addText('content', '<span class=\'small\'>', '</span>');\">
              <input type='button' value='small2' class='button' style='width:45px;' onClick=\"addText('content', '<span class=\'small2\'>', '</span>');\">
              <input type='button' value='alt' class='button' style='width:25px;' onClick=\"addText('content', '<span class=\'alt\'>', '</span>');\">
            </td>
          </tr>
          <tr>
            <td><br>Format:</td>
            <td><br><input type='radio' name='format' value='plain'$plain>".$locale['ucc_714']." <input type='radio' name='format' value='html'$html>".$locale['ucc_715']."</td>
          </tr>
          <tr>
            <td align='center' colspan='2'><br>
              <input type='submit' name='preview' value='".$locale['ucc_716']."' class='button'>
              <input type='submit' name='send' value='".$locale['ucc_717']."' class='button'>
            </td>
          </tr>
        </table>
        </form>\n";

	echo "<script language=\"JavaScript\">
function ValidateForm(frm) {
	if(frm.subject.value=='') {
		alert('".$locale['ucc_718']."!');
		return false;
	}
	if(frm.content.value=='') {
		alert('".$locale['ucc_719']."!');
		return false;
	}
}
</script>\n";

?>