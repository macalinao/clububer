<?php
/*---------------------------------------------------+
| PHP-Fusion 6 Content Management System
+----------------------------------------------------+
| Copyright � 2002 - 2006 Nick Jones
| http://www.php-fusion.co.uk/
+----------------------------------------------------+
| Released under the terms & conditions of v2 of the
| GNU General Public License. For details refer to
| the included gpl.txt file or visit http://gnu.org
+----------------------------------------------------+
| User Control Center made by:
| Sebastian "slaughter" Sch�ssler
| http://basti2web.de
| Version 2.40
+----------------------------------------------------
| and this file by Christian Zeller
| mail: zeller.chris@gmx.de
| web: yxcvbnm.xail.net
+----------------------------------------------------*/

require_once "../../maincore.php";
//require_once BASEDIR."subheader.php";
//require_once ADMIN."navigation.php";

// Check Rights
if (!defined("IN_FUSION")) { die("Access Denied"); }
if (!defined("IN_UCC")) { redirect("index.php"); }
if (!defined("iAUTH") || $_GET['aid'] != iAUTH) { redirect("index.php"); }
//if (!defined("UCC_ADMIN") || !UCC_ADMIN) { redirect("index.php"); }

if (file_exists(INFUSIONS."user_control_center/locale/".$settings['locale']."/ugm.php")) {
include INFUSIONS."user_control_center/locale/".$settings['locale']."/ugm.php";
} else {
include INFUSIONS."user_control_center/locale/English/ugm.php";
}

// Check Right UG
if (!checkrights("UCCj")) {
	echo "right UCCj needed.<br><br> (for v6 a fix (checkrights) is needed?!?!)";
} else {


// Security
if (isset($_GET['group_id']) && isnum($_GET['group_id'])) { $group_id = $_GET['group_id']; } else { $group_id = ''; }

if (isset($_GET['rowstart']) && isnum($_GET['rowstart'])) { $rowstart = $_GET['rowstart']; } else { $rowstart = 0; }

if (isset($_GET['sortby']) && preg_match("/^[0-9A-Z]$/", $_GET['sortby'])) { $sortby = $_GET['sortby']; } else { $sortby = "all"; }

// Navigation
if (!isset($_GET['page'])) { $page = "ugm"; } else { $page = stripinput($_GET['page']); }

//
// Meldungen & Actions
//

if (isset($_GET['status'])) {
	if ($_GET['status'] == "su") {
		//$title = $locale['ugm420'];
		$message = "<b>".$locale['ugm421']."</b>";
	} elseif ($_GET['status'] == "sn") {
		//$title = $locale['ugm422'];
		$message = "<b>".$locale['ugm423']."</b>";
	} elseif ($_GET['status'] == "addall") {
		//$title = " (".$locale['ugm424'].$group_name_edit.")";
		$message = "<b>".$locale['ugm425']."</b>";
	} elseif ($_GET['status'] == "remall") {
		//$title = " (".$locale['ugm424'].$group_name_edit.")";
		$message = "<b>".$locale['ugm426']."</b>";
	} elseif ($_GET['status'] == "sel") {
		//$title = " (".$locale['ugm424'].$group_name_edit.")";
		$message = "<b>".$locale['ugm427']."</b>";
	} elseif ($_GET['status'] == "deln") {
		//$title = $locale['ugm428'];
		$message = "<b>".$locale['ugm429']."</b><br>\n".$locale['ugm430'];
	} elseif ($_GET['status'] == "dely") {
		//$title = $locale['ugm428'];
		$message = "<b>".$locale['ugm431']."</b>";
	} elseif ($_GET['status'] == "gry") {
		$message = "<b>".$locale['ugm476']."</b>";
    } elseif ($_GET['status'] == "grn") {
		$message = "<b>".$locale['ugm477']."</b>";
    }
}


if (isset($_POST['save_group'])) {
	$group_id_edit = $_POST['group_id'];
	$group_name = stripinput($_POST['group_name']);
	$group_description = stripinput($_POST['group_description']);
	if (isset($_POST['group_id']))  {
		$result = dbquery("UPDATE ".DB_USER_GROUPS." SET group_name='$group_name', group_description='$group_description' WHERE group_id='$group_id_edit'");
		redirect(FUSION_SELF.$aidlink."&section=usergroups&status=su&rowstart=".$rowstart."&sortby=".$sortby."");
	} elseif ($no_group == 0) {
		$result = dbquery("INSERT INTO ".DB_USER_GROUPS." (group_name, group_description) VALUES ('$group_name', '$group_description')");
		redirect(FUSION_SELF.$aidlink."&section=usergroups&status=sn&rowstart=".$rowstart."&sortby=".$sortby."");
	}

} elseif (isset($_POST['add_all'])) {
	$group_id_edit = $_POST['del_id'];
         $group_name_edit = $_POST['group_name_edit'];
	$result = dbquery("SELECT user_id,user_name,user_groups FROM ".DB_USERS);
	while ($data = dbarray($result)) {
  		if (!preg_match("(^\.{$group_id_edit}|\.{$group_id_edit}\.|\.{$group_id_edit}$)", $data['user_groups'])) {
			$user_groups = $data['user_groups'].".".$group_id_edit;
			$result2 = dbquery("UPDATE ".DB_USERS." SET user_groups='$user_groups' WHERE user_id='".$data['user_id']."'");
		}
	}
	redirect(FUSION_SELF.$aidlink."&section=usergroups&status=addall&rowstart=".$rowstart."&sortby=".$sortby."");

} elseif (isset($_POST['remove_all'])) {
	$group_id_edit = $_POST['del_id'];
         $group_name_edit = $_POST['group_name_edit'];
	$result = dbquery("SELECT user_id,user_name,user_groups FROM ".DB_USERS." WHERE user_groups REGEXP('^\\\.{$group_id_edit}$|\\\.{$group_id_edit}\\\.|\\\.{$group_id_edit}$')");
	while ($data = dbarray($result)) {
		$user_groups = $data['user_groups'];
		$user_groups = preg_replace(array("(^\.{$group_id_edit}$)","(\.{$group_id_edit}\.)","(\.{$group_id_edit}$)"), array("",".",""), $user_groups);
		$result2 = dbquery("UPDATE ".DB_USERS." SET user_groups='$user_groups' WHERE user_id='".$data['user_id']."'");
	}
	redirect(FUSION_SELF.$aidlink."&section=usergroups&status=remall&rowstart=".$rowstart."&sortby=".$sortby."");

} elseif (isset($_POST['save_selected'])) {

	$group_id_edit = $_POST['group_id'];	$group_users = $_POST['group_users'];	$group_name_edit = $_POST['group_name_edit'];
	$group_id = $_POST['group_id']; // <= Test fix
	$result = dbquery("SELECT user_id,user_name,user_groups FROM ".DB_USERS);
	while ($data = dbarray($result)) {
		$user_id = $data['user_id'];
 		if (preg_match("(^{$user_id}$|^{$user_id}\.|\.{$user_id}\.|\.{$user_id}$)", $group_users)) {
			if (!preg_match("(^\.{$group_id_edit}$|\.{$group_id_edit}\.|\.{$group_id_edit}$)", $data['user_groups'])) {
				$user_groups = $data['user_groups'].".".$group_id;
				$result2 = dbquery("UPDATE ".DB_USERS." SET user_groups='$user_groups' WHERE user_id='".$data['user_id']."'");
			}
		} elseif (preg_match("(^\.$group_id_edit$|\.$group_id_edit\.|\.$group_id_edit$)", $data['user_groups'])) {
			$user_groups = $data['user_groups'];
			$user_groups = preg_replace(array("(^{$group_id_edit}\.)","(\.{$group_id_edit}\.)","(\.{$group_id_edit}$)"), array("",".",""), $user_groups);
			$result2 = dbquery("UPDATE ".DB_USERS." SET user_groups='$user_groups' WHERE user_id='".$data['user_id']."'");
		}
		unset($user_id);
	}
	redirect(FUSION_SELF.$aidlink."&section=usergroups&status=sel&rowstart=".$rowstart."&sortby=".$sortby."");

} elseif (isset($_POST['delete'])) {

         $group_id_edit = $_POST['del_id'];
	if (dbcount("(*)", DB_USERS, "user_groups REGEXP('^\\\.{$group_id_edit}$|\\\.{$group_id_edit}\\\.|\\\.{$group_id_edit}$')") != 0) {
		redirect(FUSION_SELF.$aidlink."&section=usergroups&status=deln&rowstart=".$rowstart."&sortby=".$sortby."");
	} else {
		$result = dbquery("DELETE FROM ".$db_prefix."user_groups WHERE group_id='$group_id_edit'");
		redirect(FUSION_SELF.$aidlink."&section=usergroups&status=dely&rowstart=".$rowstart."&sortby=".$sortby."");
	}

} elseif (isset($_POST['reset_database_yes'])) {
		//muss no gmacht werda

                 $result = $result = dbquery("SELECT user_id,user_name,user_groups FROM ".DB_USERS);
                 while ($data = dbarray($result)) {
	                 dbquery("UPDATE ".DB_USERS." SET user_groups='' WHERE user_id='".$data['user_id']."'");
                 }
                 dbquery("TRUNCATE TABLE ".DB_USER_GROUPS);

                 redirect(FUSION_SELF.$aidlink."&section=usergroups&status=gry");
} elseif (isset($_POST['reset_database_no'])) {
                 redirect(FUSION_SELF.$aidlink."&section=usergroups&status=grn");
} else {

//
//
//


opentable($locale['ugm400'].$locale['ugm401']);

echo "<br />";

echo "<table align='center' cellpadding='0' cellspacing='1' width='95%' class='tbl-border'>";
echo "<tr>

<td align='center' width='25%' class='tbl2' style='white-space:nowrap'>
	<a href='".FUSION_SELF.$aidlink."&section=usergroups&page=ugm'><font size='2.5'>".$locale['ugm403']."</font></a>
         </td>";
if (iSUPERADMIN) {
	echo "<td align='center' width='25%' class='tbl2' style='white-space:nowrap'>
	<a href='".FUSION_SELF.$aidlink."&section=usergroups&page=reset_database'><font size='2.5'>".$locale['ugm404']."</font></a>
         </td> ";
}
echo"</tr></table>";

echo "<br />";

closetable();

//
//
//

if ($page == "ugm") {

opentable($locale['ugm410']);
$shown_user_groups = 10;



	$orderby = ($sortby == "all" ? "" : " WHERE group_name LIKE '".stripinput($sortby)."%'");
	$result = dbquery("SELECT * FROM ".DB_USER_GROUPS." ".$orderby."");
	$rows = dbrows($result);

	if ($rows != 0) {
		$i = 0;

                 if (isset($message)) { echo "<div align='center'>".$message."</div>\n<br>"; }
		echo "<table align='center' cellpadding='0' cellspacing='1' width='100%' class='tbl-border'>
<tr>
<td align='center' width='1%' class='tbl2'><b>".$locale['ugm411']."</b></td>
<td class='tbl2'><b>".$locale['ugm412']."</b></td>
<td align='center' width='1%' class='tbl2' style='white-space:nowrap'><b>".$locale['ugm413']."</b></td>
<td align='center' width='1%' class='tbl2' style='white-space:nowrap'><b>".$locale['ugm414']."</b></td>

</tr>\n";

		$result = dbquery("SELECT * FROM ".DB_USER_GROUPS." ".$orderby." ORDER BY group_id LIMIT $rowstart,$shown_user_groups");


		while ($data = dbarray($result)) {
			$cell_color = ($i % 2 == 0 ? "tbl1" : "tbl2"); $i++;
                         $group_id_new = $data['group_id'];
                         $result_all = dbquery("SELECT * FROM ".DB_USERS);
                         $result_pre = dbquery("SELECT * FROM ".DB_USER_GROUPS." WHERE group_id='$group_id'");
                 	$result_anz = dbquery("SELECT * FROM ".DB_USERS." WHERE user_groups REGEXP('^\\\.{$group_id_new}$|\\\.{$group_id_new}\\\.|\\\.{$group_id_new}$') ORDER BY user_level DESC, user_name");
                         $anz = dbrows($result_anz);
                         $anz_all = dbrows($result_all);
                         if ($anz != 0) {
                         	$result_fin = sprintf(($anz==1?$locale['ugm415']:$locale['ugm416']), $anz);
                         } else {
                         	$result_fin = "-"; }



                         echo "<tr>";
                         echo "<form name='form".$group_id_new."' method='post' action='".FUSION_SELF.$aidlink."&section=usergroups&rowstart=".$rowstart."&sortby=".$sortby."'>";
                         echo "<td align='center' class='$cell_color'>".$data['group_id']."</td>";

                         echo "<td class='$cell_color'>\n<a href='".FUSION_SELF.$aidlink."&section=usergroups&page=view_group&group_id=".$data['group_id']."'>".$data['group_name']."</a>\n</td>\n";

                         echo "<td align='center' width='1%' class='$cell_color' style='white-space:nowrap'>".$result_fin."</td>\n";
                         echo "<td align='center' width='1%' class='$cell_color' style='white-space:nowrap'>
			     <input type='hidden' name='id".$data['group_id']."' value='".$data['group_id']."'>
                              <input type='hidden' name='del_id' value='".$data['group_id']."'>
                              <input type='hidden' name='group_name_edit' value='".$data['group_name']."'>
                              <input type='submit' name='edit' value='".$locale['ugm441']."' class='button'>
                              <input type='submit' name='add_user' value='".$locale['ugm442']."' class='button'>";
                              if ($anz < $anz_all) {
                              	echo " <input type='submit' name='add_all' value='".$locale['ugm455']."' class='button'> ";
			     } else {
                              	echo " <input type='submit' name='remove_all' value='".$locale['ugm456']."' class='button'> ";
                              }
                              echo "<input type='submit' name='delete' value='".$locale['ugm445']."' onclick='return DeleteGroup();' class='button'>
                              </td></tr></form>";
		}

		echo "</table>\n";
	} else {
         	$result = dbquery("SELECT * FROM ".DB_USER_GROUPS." WHERE group_id");
                 $anz_ug = dbrows($result);
         	if ($anz_ug != 0) {
			echo "<center><br>\n".$locale['ugm417']."$sortby<br><br>\n</center>\n";
                 } else {
                 	echo "<center><br>\n".$locale['ugm419']."<br><br>\n</center>\n"; }
	}
         if ($rows != 0) {
		$search = array(
			"A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R",
			"S","T","U","V","W","X","Y","Z","0","1","2","3","4","5","6","7","8","9"
		);

		echo "<hr>\n<table align='center' cellpadding='0' cellspacing='1' class='tbl-border'>\n<tr>\n";
		echo "<td rowspan='2' class='tbl2'><a href='".FUSION_SELF.$aidlink."&section=usergroups&sortby=all'>".$locale['ugm418']."</a></td>";
		for ($i=0;$i < 36!="";$i++) {
			echo "<td align='center' class='tbl1'><div class='small'><a href='".FUSION_SELF.$aidlink."&section=usergroups&sortby=".$search[$i]."'>".$search[$i]."</a></div></td>";
			echo ($i==17 ? "<td rowspan='2' class='tbl2'><a href='".FUSION_SELF.$aidlink."&section=usergroups&sortby=all'>".$locale['ugm418']."</a></td>\n</tr>\n<tr>\n" : "\n");
		}
		echo "</tr>\n</table>\n";
	}


closetable();
if ($rows > $shown_user_groups) echo "<div align='center' style='margin-top:5px;'>".makePageNav($rowstart,$shown_user_groups,$rows,5,FUSION_SELF.$aidlink."&section=usergroups&sortby=$sortby&amp;")."\n</div>\n";


echo "<br />";

	$opt_pre = dbquery("SELECT * FROM ".DB_USER_GROUPS." ".$orderby." ORDER BY group_id LIMIT $rowstart,$shown_user_groups");


	while ($data = dbarray($opt_pre)) {
               	if (isset($_POST['id'.$data['group_id']])) {
                    $group_id_edit = $data['group_id'];
                 }
         }


	if (isset($_POST['edit'])) {
		$result = dbquery("SELECT * FROM ".DB_USER_GROUPS." WHERE group_id='$group_id_edit'");
		if (dbrows($result) == 0) fallback(FUSION_SELF.$aidlink);
		$data = dbarray($result);
		$group_name = $data['group_name'];
		$group_description = $data['group_description'];
		$form_action = FUSION_SELF.$aidlink."&amp;section=usergroups&amp;group_id=".$group_id_edit."&rowstart=".$rowstart."&sortby=".$sortby;
		opentable($locale['ugm450']);
                 echo "<form name='editform' method='post' action='$form_action'>
		<table align='center' cellpadding='0' cellspacing='0'>
		<tr>";
		echo "<input type='hidden' name='group_id' value='$group_id_edit'>";
		echo "
		<td class='tbl'>".$locale['ugm452']."</td>
		<td class='tbl'><input type='text' name='group_name' value='$group_name' class='textbox' style='width:200px'></td>
		</tr>
		<tr>
		<td class='tbl'>".$locale['ugm453']."</td>
		<td class='tbl'><input type='text' name='group_description' value='$group_description' class='textbox' style='width:200px'></td>
		</tr>
		<tr>
		<td align='center' colspan='2' class='tbl'><br>
		<input type='submit' name='save_group' value='".$locale['ugm454']."' class='button'></td>
		</tr>
		</table>
		</form>";
		closetable();
	} elseif (isset($_POST['add_user'])) {

		if (isset($group_id_edit)) {

			opentable($locale['ugm424'].$_POST['group_name_edit']);
	                $result = dbquery("SELECT user_id,user_name,user_groups FROM ".DB_USERS." ORDER BY user_level DESC, user_name");

         	        while ($data = dbarray($result)) {
  				if (!preg_match("(^\.{$group_id_edit}$|\.{$group_id_edit}\.|\.{$group_id_edit}$)", $data['user_groups'])) {
					$group1_user_id[] = $data['user_id'];
					$group1_user_name[] = $data['user_name'];
				} else {
					$group2_user_id[] = $data['user_id'];
					$group2_user_name[] = $data['user_name'];
				}
			}

			echo "<form name='groupsform' method='post' action='".FUSION_SELF.$aidlink."&section=usergroups&rowstart=".$rowstart."&sortby=".$sortby."'>

			<table align='center' cellpadding='0' cellspacing='0'>
			<tr>
			<td class='tbl'>
			<select multiple size='15' name='grouplist1' id='grouplist1' class='textbox' style='width:150' onChange=\"addUser('grouplist2','grouplist1');\">\n";
					for ($i=0;$i < count($group1_user_id);$i++) echo "<option value='".$group1_user_id[$i]."'>".$group1_user_name[$i]."</option>\n";
			echo "</select>
			</td>
			<td align='center' valign='middle' class='tbl'>
			</td>
			<td class='tbl'>
			<select multiple size='15' name='grouplist2' id='grouplist2' class='textbox' style='width:150' onChange=\"addUser('grouplist1','grouplist2');\">\n";
					for ($i=0;$i < count($group2_user_id);$i++) echo "<option value='".$group2_user_id[$i]."'>".$group2_user_name[$i]."</option>\n";
			echo "</select>
			</td>
			</tr>
			<tr>
			<td align='center' colspan='3' class='tbl'>
			<input type='hidden' name='group_users'>
			<input type='hidden' name='group_id' value='$group_id_edit'>
			<input type='hidden' name='save_selected'>
			<input type='button' name='update' value='".$locale['ugm457']."' class='button' onclick='saveGroup();'></td>
			</tr>
			</table>
			</form>\n";
			closetable();



			// Script Original Author: Kathi O'Shea (Kathi.O'Shea@internet.com)
			// http://www.webdesignhelper.co.uk/sample_code/sample_code/sample_code10/sample_code10.shtml
			echo "<script type='text/javascript'>
			function addUser(toGroup,fromGroup) {
			     var listLength = document.getElementById(toGroup).length;
			     var selItem = document.getElementById(fromGroup).selectedIndex;
			     var selText = document.getElementById(fromGroup).options[selItem].text;
			     var selValue = document.getElementById(fromGroup).options[selItem].value;
			     var i; var newItem = true;
				     for (i = 0; i < listLength; i++) {
				     if (document.getElementById(toGroup).options[i].text == selText) {
				     	newItem = false; break;
				     }
			     }
			     if (newItem) {
			        document.getElementById(toGroup).options[listLength] = new Option(selText, selValue);
			        document.getElementById(fromGroup).options[selItem] = null;
			     }
			}

			function saveGroup() {
				var strValues = \"\";
				var boxLength = document.getElementById('grouplist2').length;
				var elcount = 0;
				if (boxLength != 0) {
					for (i = 0; i < boxLength; i++) {
						if (elcount == 0) {
							strValues = document.getElementById('grouplist2').options[i].value;
						} else {
							strValues = strValues + \".\" + document.getElementById('grouplist2').options[i].value;
						}
						elcount++;
					}
				}
				if (strValues.length == 0) {
					document.forms['groupsform'].submit();
				} else {
					document.forms['groupsform'].group_users.value = strValues;
					document.forms['groupsform'].submit();
				}
			}


			</script>\n";
		}

	} else {
		$group_name = "";
		$group_description = "";
		$form_action = FUSION_SELF.$aidlink."&section=usergroups&rowstart=".$rowstart."&sortby=".$sortby;
		opentable($locale['ugm451']);
		echo "<form name='editform' method='post' action='$form_action'>
		<table align='center' cellpadding='0' cellspacing='0'>
		<tr>";
		if (isset($group_id_edit)) {
		  echo "<input type='hidden' name='group_id' value='$group_id_edit'>";
		} else  {
	  	  $no_group = 0;
	        }
		echo "
		<td class='tbl'>".$locale['ugm452']."</td>
		<td class='tbl'><input type='text' name='group_name' value='$group_name' class='textbox' style='width:200px'></td>
		</tr>
		<tr>
		<td class='tbl'>".$locale['ugm453']."</td>
		<td class='tbl'><input type='text' name='group_description' value='$group_description' class='textbox' style='width:200px'></td>
		</tr>
		<tr>
		<td align='center' colspan='2' class='tbl'><br>
		<input type='submit' name='save_group' value='".$locale['ugm454']."' class='button'></td>
		</tr>
		</table>
		</form>";
		closetable();
         }

} elseif ($page == "reset_database") {
	if (iSUPERADMIN) {
		$result = dbquery("SELECT * FROM ".DB_USER_GROUPS." WHERE group_id");
         	$rows = dbrows($result);
	        opentable($locale['ugm470']);
         	echo "<center><br />";

	        if ($rows == 0) {
         		echo "<font size='2'><b>".$locale['ugm479']."</b></font>";
	        } else {
         		echo $locale['ugm471']."<br />".$locale['ugm472']."<br />";
			echo "<br />";
	         	echo $locale['ugm473']."<br>";
			echo "<form name='form_reset_database' method='post' action='".FUSION_SELF.$aidlink."&section=usergroups'>
         		     <input type='submit' name='reset_database_yes' value='".$locale['ugm474']."' onclick='return ResetDatabase();' class='button' />
			     <input type='submit' name='reset_database_no' value='".$locale['ugm475']."' class='button' />
         		     </form>";
	        }
		echo "</center>";
		closetable();
         } else {
         	redirect(FUSION_SELF.$aidlink."&section=usergroups");
         }

} elseif ($page == "view_group") {
	$message = "";
 
	if (!isset($group_id) || !isNum($group_id)) {
	redirect(FUSION_SELF.$aidlink."&section=usergroups");
	}

	if(isset($_GET['user_id']) AND isnum($_GET['user_id'])) {
		$user_id = $_GET['user_id'];
	 } else {
		$user_id = 0;
	 }

         	if (isset($_POST['ban_on'])) {
			if ($user_id != 1) {
			   $result = dbquery("UPDATE ".DB_USERS." SET user_status='1' WHERE user_id='$user_id'");
			   $message = $locale['ugm465'];
	                 }
		} elseif (isset($_POST['ban_off'])) {
				$result = dbquery("UPDATE ".DB_USERS." SET user_status='0' WHERE user_id='$user_id'");
				$message = $locale['ugm466'];

		} /* elseif (isset($_POST['delete'])) {
			if ($user_id != 1) {
				$result = dbquery("DELETE FROM ".$db_prefix."users WHERE user_id='$user_id'");
				$result = dbquery("DELETE FROM ".$db_prefix."articles WHERE article_name='$user_id'");
				$result = dbquery("DELETE FROM ".$db_prefix."comments WHERE comment_name='$user_id'");
				$result = dbquery("DELETE FROM ".$db_prefix."messages WHERE message_to='$user_id'");
				$result = dbquery("DELETE FROM ".$db_prefix."messages WHERE message_from='$user_id'");
				$result = dbquery("DELETE FROM ".$db_prefix."news WHERE news_name='$user_id'");
				$result = dbquery("DELETE FROM ".$db_prefix."poll_votes WHERE vote_user='$user_id'");
				$result = dbquery("DELETE FROM ".$db_prefix."ratings WHERE rating_user='$user_id'");
				$result = dbquery("DELETE FROM ".$db_prefix."shoutbox WHERE shout_name='$user_id'");
				$result = dbquery("DELETE FROM ".$db_prefix."threads WHERE thread_author='$user_id'");
				$result = dbquery("DELETE FROM ".$db_prefix."posts WHERE post_author='$user_id'");
				$result = dbquery("DELETE FROM ".$db_prefix."thread_notify WHERE notify_user='$user_id'");
				$message = $locale['ugm467'];

			}
		} */

		$result = dbquery("SELECT * FROM ".DB_USER_GROUPS." WHERE group_id='$group_id'");
		if (dbrows($result)) {
			$data = dbarray($result);
			$result = dbquery("SELECT * FROM ".DB_USERS." WHERE user_groups REGEXP('^\\\.{$group_id}$|\\\.{$group_id}\\\.|\\\.{$group_id}$') ORDER BY user_level DESC, user_name");
			opentable($locale['ugm460']);
                         if ($message != "") {echo "<center>".$message."<br><br></center>\n";}
			echo "<table align='center' cellpadding='0' cellspacing='1' width='100%' class='tbl-border'>
			<tr>
			<td align='center' colspan='6' class='tbl1'><font size='2.5'><b>".$data['group_name']."</b> (".sprintf((dbrows($result)==1?$locale['ugm415']:$locale['ugm416']), dbrows($result)).")</font></td>
			</tr>";
			if(!dbrows($result)){
	                 	echo "<tr><td align='center' class='tbl2'><b><br>".$locale['ugm464']."<br><br></b></td></tr>";
         	        } else {
				echo "<tr>
		                <td align='center' width='1%' class='tbl2'><b>".$locale['ugm411']."</b></td>
         		        <td class='tbl2'><b>".$locale['ugm461']."</b></td>
				<td align='center' width='1%' class='tbl2' style='white-space:nowrap'><b>".$locale['ugm462']."</b></td>
				<td align='center' width='1%' colspan='3' class='tbl2' style='white-space:nowrap'><b>".$locale['ugm414']."</b></td>
				</tr>\n";

				while ($data = dbarray($result)) {

					$cell_color = ($i % 2 == 0 ? "tbl1" : "tbl2"); $i++;

                 	                                 echo "<tr>\n<td align='center' class='$cell_color'>".$data['user_id']."</td>";
					echo "<td class='$cell_color'>\n<a href='".BASEDIR."profile.php?lookup=".$data['user_id']."'>".$data['user_name']."</a></td>\n";
					echo "<td align='center' width='1%' class='$cell_color' style='white-space:nowrap'>".getuserlevel($data['user_level'])."</td>\n";

         	        	             if ($data['user_id'] !=1 ){
                 	        	        echo "<td align='center' width='1%' class='$cell_color' style='white-space:nowrap'>";
##Verwendung unbekannt oder nicht mehr n�tig ?!??!?! Hilfe! :P                 	        	        
##					     	<input type='hidden' name='id".$data['group_id']."' value='".$data['group_id']."'>
##		                	        <input type='hidden' name='del_id' value='".$data['group_id']."'></input>";
		                	        echo "
	                              		<form name='edit".$data['user_id']."' method='post' action='".ADMIN."members.php".$aidlink."&amp;step=edit&amp;user_id=".$data['user_id']."'>
		                                <input type='submit' name='edit' value='".$locale['ugm441']."' class='button'></form>   </td>";
		                                if ($data['user_status'] == "1") {
	        	                         	echo "<td align='center' width='1%' class='$cell_color' style='white-space:nowrap'>
         	        	                        <form name='ban_off".$data['user_id']."' method='post' action='".FUSION_SELF.$aidlink."&section=usergroups&amp;page=view_group&amp;user_id=".$data['user_id']."&amp;group_id=".$group_id."'>
                  	        	                <input type='submit' name='ban_off' value='".$locale['ugm444']."' class='button'></form>   </td>";
                          	        	} else {
				     	 		echo "<td align='center' width='1%' class='$cell_color' style='white-space:nowrap'>
                 	                    <form name='ban_on".$data['user_id']."' method='post' action='".FUSION_SELF.$aidlink."&section=usergroups&amp;page=view_group&amp;user_id=".$data['user_id']."&amp;group_id=".$group_id."'>
	                	                        <input type='submit' name='ban_on' value='".$locale['ugm443']."' class='button'></form>   </td>";
         	                	        }
	////////////// START CHANGE /////////////
                 	             		echo "<td align='center' width='1%' class='$cell_color' style='white-space:nowrap'>
	                         	        <form name='delete".$data['user_id']."' method='post' action='".FUSION_SELF.$aidlink."&section=delete&amp;pre_user_id=".$data['user_id']."'>
         	                                <input type='submit' name='delete' value='".$locale['ugm445']."' class='button'></form>";
	////////////// ENDE CHANGE /////////////
	        	                        echo "</td>\n</tr>";
          	        	             } else {
	                        	      	echo "<td align='center' colspan='3' width='1%' class='$cell_color' style='white-space:nowrap'></td>";
	         	                     }


				}
			}
			echo "</form></table>\n";
		} else {
			redirect(FUSION_SELF.$aidlink."&section=usergroups");
		}

	echo "<br />";

	closetable();

	}




}

//Java-Scripte

echo "<script type='text/javascript'>
function DeleteGroup() {
	return confirm('".$locale['ugm446']."');
}
</script>\n";

echo "<script type='text/javascript'>
function DeleteMember(username) {
	return confirm('".$locale['ugm447']."');
}
</script>\n";

echo "<script type='text/javascript'>
function ResetDatabase() {
	return confirm('".$locale['ugm478']."');
}
</script>\n";


//tablebreak();
//opentable("");


//	echo "<br />User Groups Management by <a href='http://yxcvbnm.xail.net' target='_blank'>Christian Zeller</a>";



} // Right UG

?>