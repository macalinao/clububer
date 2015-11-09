<?php
/*--------------------------------------------+
| PHP-Fusion 6 - Content Management System    |
|---------------------------------------------|
| author: Nick Jones (Digitanium) © 2002-2005 |
| web: http://www.php-fusion.co.uk            |
| email: nick@php-fusion.co.uk                |
|---------------------------------------------|
|This program is released as free software    |
|under the |Affero GPL license. 	      |
|You can redistribute it and/or		      |
|modify it under the terms of this license    |
|which you |can read by viewing the included  |
|agpl.html or online			      |
|at www.gnu.org/licenses/agpl.html. 	      |
|Removal of this|copyright header is strictly |
|prohibited without |written permission from  |
|the original author(s).		      |
+---------------------------------------------+
|VArcade is written by Domi & fetloser          |
|http://www.venue.nu			      |
+---------------------------------------------+
| Original Comments system was                |
| developed by CrappoMan		      |
| email: simonpatterson@dsl.pipex.com	      |
| Modded and changed for easy integration     |
| By Domi & fetloser @ venue.nu		      |
+--------------------------------------------*/
if (!defined("IN_FUSION")) { header("Location:../../index.php"); exit; }

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

require_once THEME."theme.php";
echo "<link rel='stylesheet' href='".THEME."styles.css' type='text/css'>";
echo "<script type='text/javascript' src='".INCLUDES."jscript.js'></script>";

echo "<script>
function addnewText(elname, wrap1, wrap2) {
	if (document.selection) { // for IE 
		var str = document.selection.createRange().text;
		document.forms['inputform'].elements[elname].focus();
		var sel = document.selection.createRange();
		sel.text = wrap1 + str + wrap2;
		return;
	} else if ((typeof document.forms['inputform'].elements[elname].selectionStart) != 'undefined') { // for Mozilla
		var txtarea = document.forms['inputform'].elements[elname];
		var selLength = txtarea.textLength;
		var selStart = txtarea.selectionStart;
		var selEnd = txtarea.selectionEnd;
		var oldScrollTop = txtarea.scrollTop;
		//if (selEnd == 1 || selEnd == 2)
		//selEnd = selLength;
		var s1 = (txtarea.value).substring(0,selStart);
		var s2 = (txtarea.value).substring(selStart, selEnd)
		var s3 = (txtarea.value).substring(selEnd, selLength);
		txtarea.value = s1 + wrap1 + s2 + wrap2 + s3;
		txtarea.selectionStart = s1.length;
		txtarea.selectionEnd = s1.length + s2.length + wrap1.length + wrap2.length;
		txtarea.scrollTop = oldScrollTop;
		txtarea.focus();
		return;
	} else {
		insertText(elname, wrap1 + wrap2);
	}
}
</script>";

function comments($ctype,$cdb,$ccol,$cid,$clink) {

        global $db_prefix,$userdata,$rowstart,$locale;

		if ((iMEMBER || $settings['guestposts'] == "1") && isset($_POST['post_comment'])) {
		if (dbrows(dbquery("SELECT $ccol FROM ".DB_PREFIX."$cdb WHERE $ccol='$cid'"))==0) {
		header("Location:".BASEDIR."index.php");
		}
		if (iMEMBER) {
			$comment_name = $userdata['user_id'];
		} elseif ($settings['guestposts'] == "1") {
			$comment_name = trim(stripinput($_POST['comment_name']));
			$comment_name = preg_replace("(^[0-9]*)", "", $comment_name);
			if (isNum($comment_name)) $comment_name="";
		}
		$comment_message = trim(stripinput(censorwords($_POST['comment_message'])));
		$comment_smileys = isset($_POST['disable_smileys']) ? "0" : "1";
		if ($comment_name != "" && $comment_message != "") {
			$result = dbquery("INSERT INTO ".DB_PREFIX."comments VALUES('', '$cid', '$ctype', '$comment_name','$comment_message','1', '".time()."', '".USER_IP."')");
		}
		redirect($clink);
	}
opentable($locale['KOM100']);

$result = dbquery("SELECT * FROM ".$db_prefix."comments WHERE comment_type='G' AND comment_item_id='$cid' ORDER BY comment_datestamp DESC");
	if (dbrows($result) != 0) {
		$i = 0;
		echo "<table cellpadding='0' cellspacing='1' width='98%' class='tbl-border'>\n";
		while ($data = dbarray($result)) {

	echo "<tr>\n<td class='".($i% 2==0?"tbl1":"tbl2")."'><span class='comment-name'>\n";
$avatar = dbquery("SELECT * FROM ".$db_prefix."users WHERE user_id='$data[comment_name]'");
	$avatar1 = dbarray($avatar);			

echo '
<script> 
function profile() { 
opener.location.href="'.BASEDIR.'profile.php?lookup='.$data['comment_name'].'"; 
window.close(); 
} 
</script> ';

if ($avatar1['user_avatar'] != "") {
			echo '<a href="#" onClick="profile()"><img height="50" width="50" border ="0" src="'.IMAGES.'avatars/'.$avatar1['user_avatar'].'"></a>';
		} else {
		echo '<a href="#" onClick="profile()"><img height="50" width="50" border="0" src="'.INFUSIONS.'varcade/img/noav.gif"></a>';
			}

                       if ($data['comment_name']) {
	               echo '<a href="#" onClick="profile()">'.$avatar1['user_name'].'</a><br>'; 
			} else {
		       echo '<a href="#" onClick="profile()">'.$data['comment_name'].'</a><br>'; 
                        }
echo "</span><span class='small'>".showdate("longdate", $data['comment_datestamp'])."";
if(iADMIN) 
{
echo"<br><a href='".FUSION_SELF."?deletemsg=".$data['comment_id']."&&hideout=".$data['comment_item_id']."'>".$locale['KOM101']."</a>";
}
echo"</span><br><HR>
".parsesmileys(parseubb($data['comment_message']))." </td>\n";
echo "</tr>\n";
                        $i++;
                }
                echo "</table>\n";
                echo "<div align='center' style='margin-top:5px;'>\n</div>\n";
                } else {
                echo "'".$locale['KOM102']."'\n";
        }

if (iMEMBER || $settings['guestposts'] == "1") {
echo $locale['KOM103'];
echo "<form name='inputform' method='post' action='$clink'>
<table align='center' cellspacing='0' cellpadding='0' width='98%' class='tbl2'>\n";
if (iGUEST) {
echo "<tr><td>".$locale['KOM104']."</td>
</tr>
<tr>
<td><input type='text' name='comment_name' maxlength='30' class='textbox' style='width:100%;'></td>
</tr>\n";
		}
		echo "<tr>
<td align='center'><textarea name='comment_message' rows='6' class='textbox' style='width:400px'></textarea><br>
<input type='button' value='b' class='button' style='font-weight:bold;width:25px;' onClick=\"addText('comment_message', '[b]', '[/b]');\">
<input type='button' value='i' class='button' style='font-style:italic;width:25px;' onClick=\"addText('comment_message', '[i]', '[/i]');\">
<input type='button' value='u' class='button' style='text-decoration:underline;width:25px;' onClick=\"addText('comment_message', '[u]', '[/u]');\">
<input type='button' value='url' class='button' style='width:30px;' onClick=\"addText('comment_message', '[url]', '[/url]');\">
<input type='button' value='mail' class='button' style='width:35px;' onClick=\"addText('comment_message', '[mail]', '[/mail]');\">
<input type='button' value='img' class='button' style='width:30px;' onClick=\"addText('comment_message', '[img]', '[/img]');\">
<input type='button' value='center' class='button' style='width:45px;' onClick=\"addText('comment_message', '[center]', '[/center]');\">
<input type='button' value='small' class='button' style='width:40px;' onClick=\"addText('comment_message', '[small]', '[/small]');\">
<input type='button' value='code' class='button' style='width:40px;' onClick=\"addText('comment_message', '[code]', '[/code]');\">
<input type='button' value='quote' class='button' style='width:45px;' onClick=\"addText('comment_message', '[quote]', '[/quote]');\">
<br><br>
".displaysmileys("comment_message")."
</tr>
<tr>
<td><br><br><center>
<input type='submit' name='post_comment' value='".$locale['KOM105']."' class='button'></td>
</center>
</tr>
</table>
</form>\n";
	} else {
		echo $locale['KOM106']."\n";
	}
closetable();
}

?>