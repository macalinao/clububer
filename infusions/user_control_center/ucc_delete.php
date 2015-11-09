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
| Version 2.42
+----------------------------------------------------*/

// Check Rights
if (!defined("IN_FUSION")) { die("Access Denied"); }
if (!defined("IN_UCC")) { redirect("index.php"); }
if (!defined("iAUTH") || $_GET['aid'] != iAUTH) { redirect("index.php"); }
//if (!defined("UCC_ADMIN") || !UCC_ADMIN) { redirect("index.php"); }

if (!checkrights("M")) {

echo $locale['ucc_555'];

} else {

if (isset($_POST['del_send'])) {
 

// Ghost
$ucc_ghost_name = "Deleted_User";
if ($_POST['ghost'] == "yes" AND $ucc_ghost == 0) {

$result = dbquery("SELECT user_id FROM ".$db_prefix."users WHERE user_name = '".$ucc_ghost_name."'");
$ucc_ghost = dbresult($result, 0);
if($ucc_ghost == 0) {
$result = dbquery("INSERT INTO ".$db_prefix."users (user_name, user_password, user_email, user_hide_email, user_location, user_birthdate, user_aim, user_icq, user_msn, user_yahoo, user_web, user_theme, user_offset, user_avatar, user_sig, user_posts, user_joined, user_lastvisit, user_ip, user_rights, user_groups, user_level, user_status) VALUES ('".$ucc_ghost_name."', md5(".time()."), 'mail@mail.de', '1', 'nowhere', '0000-00-00', '', '', '', '', 'http://basti2web.de', 'Default', '0', '../edit.gif\' alt=\'\' title=\'\'> <b>User deleted!</b> <span a=\'a', '[b]This user has been deleted![/b]', '0', '0', '0', '127.0.0.1', '', '', '0', '0')");

$result = dbquery("SELECT user_id FROM ".$db_prefix."users WHERE user_name = '".$ucc_ghost_name."'");
$ucc_ghost = dbresult($result, 0);
}
$result = dbquery("UPDATE ".$db_prefix."ucc_settings SET ucc_ghost='".$ucc_ghost."'");
}
//
$del_counter = '';

// TYPE

switch ($_POST['del_type']) {

case "time":

$toshort = time() - 60*60*24*3; // not delete users, which registered 3 days ago, but did not login
$lavi = time() - $_POST['lavi'];
$query_where = "user_lastvisit <= ".$lavi." AND user_joined <= ".$toshort;

break;
case "posts":

$toshort = time() - 60*60*24*3; // not delete users, which registered 3 days ago, but did not login
$lavi = time() - $_POST['del_type_posts_time'];
$query_where = "user_lastvisit <= ".$lavi." AND user_joined <= ".$toshort." AND user_posts = 0";
// todo:
// einbauen: im WHERE dass die user noch keine Artikel und News geschrieben haben?!?!


break;
case "defined":

$def_userid = $_POST['del_type_defined_userid'];
if(isNum($def_userid)){
$query_where = "user_id = ".$def_userid;
} else { die("Error: isNum(def_userid) == false"); }

break;
}

//

$result = dbquery("SELECT * FROM ".$db_prefix."users WHERE ".$query_where." AND user_name != '".$ucc_ghost_name."' AND user_id != '".$ucc_ghost."'");

if (dbrows($result)) {

while ($data = dbarray($result)) {

if (iUSER > $data['user_level'] AND $data['user_id'] != "1") 
 {	$del_u_id = $data['user_id'];
  
		$d_r = dbquery("DELETE FROM ".$db_prefix."users WHERE user_id='$del_u_id'");
		$d_r = dbquery("DELETE FROM ".$db_prefix."messages WHERE message_to='$del_u_id'");
		$d_r = dbquery("DELETE FROM ".$db_prefix."thread_notify WHERE notify_user='$del_u_id'");

	if ($_POST['posts'] == "no" AND $_POST['ghost'] == "yes") {
		$u_1 = dbquery("UPDATE ".$db_prefix."threads SET thread_author = '$ucc_ghost' WHERE thread_author = '$del_u_id'");
		$u_2 = dbquery("UPDATE ".$db_prefix."posts SET post_author = '$ucc_ghost' WHERE post_author = '$del_u_id'");
	} elseif($_POST['posts'] == "yes") {
		$d_r = dbquery("DELETE FROM ".$db_prefix."threads WHERE thread_author='$del_u_id'");
		$d_r = dbquery("DELETE FROM ".$db_prefix."posts WHERE post_author='$del_u_id'");
	}

	if($_POST['art'] == "no" AND $_POST['ghost'] == "yes") {
		$u_3 = dbquery("UPDATE ".$db_prefix."articles SET article_name = '$ucc_ghost' WHERE article_name = '$del_u_id'");
	} elseif($_POST['art'] == "yes") {
		$d_r = dbquery("DELETE FROM ".$db_prefix."articles WHERE article_name='$del_u_id'");
	}

	if($_POST['news'] == "no" AND $_POST['ghost'] == "yes") {
		$u_4 = dbquery("UPDATE ".$db_prefix."news SET news_name = '$ucc_ghost' WHERE news_name = '$del_u_id'");
	} elseif($_POST['news'] == "yes") {
		$d_r = dbquery("DELETE FROM ".$db_prefix."news WHERE news_name='$del_u_id'");
	}

	if($_POST['other'] == "yes") {
		$d_r = dbquery("DELETE FROM ".$db_prefix."comments WHERE comment_name='$del_u_id'");
		$d_r = dbquery("DELETE FROM ".$db_prefix."messages WHERE message_from='$del_u_id'");
		$d_r = dbquery("DELETE FROM ".$db_prefix."poll_votes WHERE vote_user='$del_u_id'");
		$d_r = dbquery("DELETE FROM ".$db_prefix."ratings WHERE rating_user='$del_u_id'");
		$d_r = dbquery("DELETE FROM ".$db_prefix."shoutbox WHERE shout_name='$del_u_id'");
	}
		if($del_counter == '') { $del_counter = $data['user_name']; } else { $del_counter .= ", ".$data['user_name']; }
}

} // while
$ausgabe = $locale['ucc_551'].": ".$del_counter."";
} // rows
else {
$ausgabe = $locale['ucc_552'];
}

			opentable($locale['ucc_100']);
			echo "<center>".$ausgabe."<br /></center>\n";
			closetable();
			tablebreak();
}


// 
if(isset($pre_user_id) && isNum($pre_user_id)) {
  $pre_user_id = $_GET['pre_user_id'];
  $dummy = " checked='checked'";
} else {
  $pre_user_id = false;
  $dummy = '';
}
//

opentable($locale['ucc_550']);

$never  = time();
$day3   = 60*60*24*3;
$week   = 60*60*24*7;
$week2  = 60*60*24*14;
$monat4 = 60*60*24*30*4;
$monat6 = 60*60*24*30*6;
$monat8 = 60*60*24*30*8;
$year1  = 60*60*24*30*12;
$year2  = 60*60*24*30*24;

$action = FUSION_SELF.$aidlink."&section=delete";

	echo "<form name='inputform' method='post' action='$action' onSubmit='return UCC_Delete_Users();'>
        <table cellspacing='1' cellpadding='3' class='tbl-border' align='center'>
          <tr>
            <td width='400' class='tbl1'>
			<input type='radio' name='del_type' value='time' checked='checked'>
			".$locale['ucc_553'].":</td>
            <td class='tbl1'><select name='lavi' class='textbox'>\n
			<option value='".$never ."'>".$locale['ucc_554']."</option>
			<option value='".$year2 ."'>".$locale['ucc_709_2']."</option>
			<option value='".$year1 ."'>".$locale['ucc_709_1']."</option>
			<option value='".$monat8."'>".$locale['ucc_708_8']."</option>
			<option value='".$monat6."'>".$locale['ucc_708_6']."</option>
			<option value='".$monat4."'>".$locale['ucc_708_4']."</option>
			</select></td>
          </tr>
		
		<tr>
		<td width='400' class='tbl1'>
		<input type='radio' name='del_type' value='posts'>".$locale['ucc_556']."
		</td>
		<td class='tbl1'><select name='del_type_posts_time' class='textbox'>\n
			<option value='".$day3 ."'>".$locale['ucc_710_3']."</option>
			<option value='".$week ."'>".$locale['ucc_707_1']."</option>
			<option value='".$week2."'>".$locale['ucc_707_2']."</option>
			</select></td>
		</tr>";


		$result_ddu = dbquery("SELECT * FROM ".$db_prefix."users WHERE user_level < '".iUSER."' AND user_id != '1' AND user_id != ".$ucc_ghost." ORDER BY user_name");
		if (dbrows($result_ddu)) {
		echo " <tr>
		<td width='400' class='tbl1'>
		<input type='radio' name='del_type' value='defined'".$dummy.">".$locale['ucc_557']."
		</td>
		<td class='tbl1'>
		<select name='del_type_defined_userid' class='textbox'>\n";
				while ($data = dbarray($result_ddu)) {
					if($pre_user_id == $data['user_id']) { $dummy = " selected='selected'"; } else { $dummy = ''; }
					
					echo "<option value='".$data['user_id']."'".$dummy.">".$data['user_name']."</option>\n";

				}
		echo "
		</select>
		</td>
		</tr>";
		}

		echo "
		<tr>
		<td width='400' class='tbl1'>".$locale['ucc_558']." *:</td>
		<td class='tbl1'>
		<input type='radio' name='posts' value='no' checked='checked'>".$locale['ucc_174']."
		<input type='radio' name='posts' value='yes'>".$locale['ucc_173']."
		</td>
		</tr>

		<tr>
		<td width='400' class='tbl1'>".$locale['ucc_559']." *:</td>
		<td class='tbl1'>
		<input type='radio' name='art' value='no' checked='checked'>".$locale['ucc_174']."
		<input type='radio' name='art' value='yes'>".$locale['ucc_173']."
		</td>
		</tr>

		<tr>
		<td width='400' class='tbl1'>".$locale['ucc_560']." *:</td>
		<td class='tbl1'>
		<input type='radio' name='news' value='no' checked='checked'>".$locale['ucc_174']."
		<input type='radio' name='news' value='yes'>".$locale['ucc_173']."
		</td>
		</tr>

		<tr>
		<td width='400' class='tbl1'>".$locale['ucc_561'].":</td>
		<td class='tbl1'>
		<input type='radio' name='other' value='no'>".$locale['ucc_174']."
		<input type='radio' name='other' value='yes' checked='checked'>".$locale['ucc_173']."
		</td>
		</tr>
          <tr>
           <td width='400' class='tbl1'>*) ".$locale['ucc_562'].":
            </td>
		<td class='tbl1'>
		<input type='radio' name='ghost' value='no'>".$locale['ucc_174']."
		<input type='radio' name='ghost' value='yes' checked='checked'>".$locale['ucc_173']."
		</td>
          </tr>
          <tr>
            <td colspan='2' align='left' class='tbl1'>**) ".$locale['ucc_563'].".
            </td>
          </tr>
          <tr>
            <td align='center' colspan='2' class='tbl1'>
	<input type='submit' name='del_send' value='".$locale['ucc_564']."' class='button'>
            </td>
          </tr>

        </table>
        </form>\n";

echo "<script language='JavaScript'>
function UCC_Delete_Users() {	
	return confirm('".$locale['ucc_565']."');
}
</script>";


} // checkrights(): M

?>