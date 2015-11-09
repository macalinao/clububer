<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: news.php
| Author: Nick Jones (Digitanium)
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
require_once "../maincore.php";
require_once THEMES."templates/admin_header_mce.php";
include LOCALE.LOCALESET."admin/news.php";

if (!checkrights("N") || !defined("iAUTH") || $_GET['aid'] != iAUTH) { redirect("../index.php"); }

if ($settings['tinymce_enabled']) {
	echo "<script language='javascript' type='text/javascript'>advanced();</script>\n";
} else {
	require_once INCLUDES."html_buttons_include.php";
}

if (isset($_GET['status'])) {
	if ($_GET['status'] == "sn") {
		$message = $locale['410'];
	} elseif ($_GET['status'] == "su") {
		$message = $locale['411'];
	} elseif ($_GET['status'] == "del") {
		$message = $locale['412'];
	}
	if ($message) {	echo "<div class='admin-message'>".$message."</div>\n"; }
}

if (isset($_POST['save'])) {
	$news_subject = stripinput($_POST['news_subject']);
	$news_cat = isnum($_POST['news_cat']) ? $_POST['news_cat'] : "0";
	$body = addslash($_POST['body']);
	if ($_POST['body2']) {
		$body2 = addslash(preg_replace("(^<p>\s</p>$)", "", $_POST['body2']));
	} else {
		$body2 = "";
	}
	$news_start_date = 0; $news_end_date = 0;
	if ($_POST['news_start']['mday']!="--" && $_POST['news_start']['mon']!="--" && $_POST['news_start']['year']!="----") {
		$news_start_date = mktime($_POST['news_start']['hours'],$_POST['news_start']['minutes'],0,$_POST['news_start']['mon'],$_POST['news_start']['mday'],$_POST['news_start']['year']);
	}
	if ($_POST['news_end']['mday']!="--" && $_POST['news_end']['mon']!="--" && $_POST['news_end']['year']!="----") {
		$news_end_date = mktime($_POST['news_end']['hours'],$_POST['news_end']['minutes'],0,$_POST['news_end']['mon'],$_POST['news_end']['mday'],$_POST['news_end']['year']);
	}
	$news_visibility = isnum($_POST['news_visibility']) ? $_POST['news_visibility'] : "0";
	$news_draft = isset($_POST['news_draft']) ? "1" : "0";
	$news_sticky = isset($_POST['news_sticky']) ? "1" : "0";
	if ($settings['tinymce_enabled'] != 1) { $news_breaks = isset($_POST['line_breaks']) ? "y" : "n"; } else { $news_breaks = "n"; }
	$news_comments = isset($_POST['news_comments']) ? "1" : "0";
	$news_ratings = isset($_POST['news_ratings']) ? "1" : "0";
	if (isset($_POST['news_id']) && isnum($_POST['news_id'])) {
		if ($news_sticky == "1") { $result = dbquery("UPDATE ".DB_NEWS." SET news_sticky='0' WHERE news_sticky='1'"); }
		$result = dbquery("UPDATE ".DB_NEWS." SET news_subject='$news_subject', news_cat='$news_cat', news_news='$body', news_extended='$body2', news_breaks='$news_breaks',".($news_start_date != 0 ? " news_datestamp='$news_start_date'," : "")." news_start='$news_start_date', news_end='$news_end_date', news_visibility='$news_visibility', news_draft='$news_draft', news_sticky='$news_sticky', news_allow_comments='$news_comments', news_allow_ratings='$news_ratings' WHERE news_id='".$_POST['news_id']."'");
		redirect(FUSION_SELF.$aidlink."&status=su");
	} else {
		if ($news_sticky == "1") { $result = dbquery("UPDATE ".DB_NEWS." SET news_sticky='0' WHERE news_sticky='1'"); }
		$result = dbquery("INSERT INTO ".DB_NEWS." (news_subject, news_cat, news_news, news_extended, news_breaks, news_name, news_datestamp, news_start, news_end, news_visibility, news_draft, news_sticky, news_reads, news_allow_comments, news_allow_ratings) VALUES ('$news_subject', '$news_cat', '$body', '$body2', '$news_breaks', '".$userdata['user_id']."', '".($news_start_date != 0 ? $news_start_date : time())."', '$news_start_date', '$news_end_date', '$news_visibility', '$news_draft', '$news_sticky', '0', '$news_comments', '$news_ratings')");
		redirect(FUSION_SELF.$aidlink."&status=sn");
	}
} else if (isset($_POST['delete']) && (isset($_POST['news_id']) && isnum($_POST['news_id']))) {
	$result = dbquery("DELETE FROM ".DB_NEWS." WHERE news_id='".$_POST['news_id']."'");
	$result = dbquery("DELETE FROM ".DB_COMMENTS."  WHERE comment_item_id='".$_POST['news_id']."' and comment_type='N'");
	$result = dbquery("DELETE FROM ".DB_RATINGS." WHERE rating_item_id='".$_POST['news_id']."' and rating_type='N'");
	redirect(FUSION_SELF.$aidlink."&status=del");
} else {
	if (isset($_POST['preview'])) {
		$news_subject = stripinput($_POST['news_subject']);
		$news_cat = isnum($_POST['news_cat']) ? $_POST['news_cat'] : "0";
		$body = phpentities(stripslash($_POST['body']));
		$bodypreview = str_replace("src='".str_replace("../", "", IMAGES_N), "src='".IMAGES_N, stripslash($_POST['body']));
		if ($_POST['body2']) {
			$body2 = phpentities(stripslash($_POST['body2']));
			$body2preview = str_replace("src='".str_replace("../", "", IMAGES_N), "src='".IMAGES_N, stripslash($_POST['body2']));
		} else {
			$body2 = "";
		}
		if (isset($_POST['line_breaks'])) {
			$news_breaks = " checked='checked'";
			$bodypreview = nl2br($bodypreview);
			if ($body2) { $body2preview = nl2br($body2preview); }
		} else {
			$news_breaks = "";
		}
		$news_start = array(
			"mday" => isnum($_POST['news_start']['mday']) ? $_POST['news_start']['mday'] : "--",
			"mon" => isnum($_POST['news_start']['mon']) ? $_POST['news_start']['mon'] : "--",
			"year" => isnum($_POST['news_start']['year']) ? $_POST['news_start']['year'] : "----",
			"hours" => isnum($_POST['news_start']['hours']) ? $_POST['news_start']['hours'] : "0",
			"minutes" => isnum($_POST['news_start']['minutes']) ? $_POST['news_start']['minutes'] : "0",
		);
		$news_end = array(
			"mday" => isnum($_POST['news_end']['mday']) ? $_POST['news_end']['mday'] : "--",
			"mon" => isnum($_POST['news_end']['mon']) ? $_POST['news_end']['mon'] : "--",
			"year" => isnum($_POST['news_end']['year']) ? $_POST['news_end']['year'] : "----",
			"hours" => isnum($_POST['news_end']['hours']) ? $_POST['news_end']['hours'] : "0",
			"minutes" => isnum($_POST['news_end']['minutes']) ? $_POST['news_end']['minutes'] : "0",
		);
		$news_visibility = isnum($_POST['news_visibility']) ? $_POST['news_visibility'] : "0";
		$news_draft = isset($_POST['news_draft']) ? " checked='checked'" : "";
		$news_sticky = isset($_POST['news_sticky']) ? " checked='checked'" : "";
		$news_comments = isset($_POST['news_comments']) ? " checked='checked'" : "";
		$news_ratings = isset($_POST['news_ratings']) ? " checked='checked'" : "";
		opentable($news_subject);
		echo "$bodypreview\n";
		closetable();
		if (isset($body2preview)) {
			opentable($news_subject);
			echo "$body2preview\n";
			closetable();
		}
	}
	$result = dbquery("SELECT * FROM ".DB_NEWS." ORDER BY news_draft DESC, news_datestamp DESC");
	if (dbrows($result) != 0) {
		$editlist = ""; $sel = "";
		while ($data = dbarray($result)) {
			if ((isset($_POST['news_id']) && isnum($_POST['news_id'])) || (isset($_GET['news_id']) && isnum($_GET['news_id']))) {
				$news_id = isset($_POST['news_id']) ? $_POST['news_id'] : $_GET['news_id'];
				$sel = ($news_id == $data['news_id'] ? " selected='selected'" : "");
			}
			$editlist .= "<option value='".$data['news_id']."'$sel>".($data['news_draft'] ? $locale['438']." " : "").$data['news_subject']."</option>\n";
		}
		opentable($locale['400']);
		echo "<div style='text-align:center'>\n<form name='selectform' method='post' action='".FUSION_SELF.$aidlink."&amp;action=edit'>\n";
		echo "<select name='news_id' class='textbox' style='width:250px'>\n".$editlist."</select>\n";
		echo "<input type='submit' name='edit' value='".$locale['420']."' class='button' />\n";
		echo "<input type='submit' name='delete' value='".$locale['421']."' onclick='return DeleteNews();' class='button' />\n";
		echo "</form>\n</div>\n";
		closetable();
	}

	if ((isset($_GET['action']) && $_GET['action'] == "edit") && (isset($_POST['news_id']) && isnum($_POST['news_id'])) || (isset($_GET['news_id']) && isnum($_GET['news_id']))) {
		$result = dbquery("SELECT * FROM ".DB_NEWS." WHERE news_id='".(isset($_POST['news_id']) ? $_POST['news_id'] : $_GET['news_id'])."'");
		if (dbrows($result)) {
			$data = dbarray($result);
			$news_subject = $data['news_subject'];
			$news_cat = $data['news_cat'];
			$body = phpentities(stripslashes($data['news_news']));
			$body2 = phpentities(stripslashes($data['news_extended']));
			if ($data['news_start'] > 0) $news_start = getdate($data['news_start']);
			if ($data['news_end'] > 0) $news_end = getdate($data['news_end']);
			$news_visibility = $data['news_visibility'];
			$news_draft = $data['news_draft'] == "1" ? " checked='checked'" : "";
			$news_sticky = $data['news_sticky'] == "1" ? " checked='checked'" : "";
			$news_breaks = $data['news_breaks'] == "y" ? " checked='checked'" : "";
			$news_comments = $data['news_allow_comments'] == "1" ? " checked='checked'" : "";
			$news_ratings = $data['news_allow_ratings'] == "1" ? " checked='checked'" : "";
		} else {
			redirect(FUSION_SELF.$aidlink);
		}
	}
	if ((isset($_POST['news_id']) && isnum($_POST['news_id'])) || (isset($_GET['news_id']) && isnum($_GET['news_id']))) {
		opentable($locale['402']);
	} else {
		if (!isset($_POST['preview'])) {
			$news_subject = "";
			$news_cat = "0";
			$body = "";
			$body2 = "";
			$news_visibility = 0;
			$news_draft = "";
			$news_sticky = "";
			$news_breaks = " checked='checked'";
			$news_comments = " checked='checked'";
			$news_ratings = " checked='checked'";
		}
		opentable($locale['401']);
	}
	$result = dbquery("SELECT * FROM ".DB_NEWS_CATS." ORDER BY news_cat_name");
	$news_cat_opts = ""; $sel = "";
	if (dbrows($result)) {
		while ($data = dbarray($result)) {
			if (isset($news_cat)) $sel = ($news_cat == $data['news_cat_id'] ? " selected='selected'" : "");
			$news_cat_opts .= "<option value='".$data['news_cat_id']."'$sel>".$data['news_cat_name']."</option>\n";
		}
	}	
	$visibility_opts = ""; $sel = "";
	$user_groups = getusergroups();
	while(list($key, $user_group) = each($user_groups)){
		$sel = ($news_visibility == $user_group['0'] ? " selected='selected'" : "");
		$visibility_opts .= "<option value='".$user_group['0']."'$sel>".$user_group['1']."</option>\n";
	}
	echo "<form name='inputform' method='post' action='".FUSION_SELF.$aidlink."' onsubmit='return ValidateForm(this);'>\n";
	echo "<table cellpadding='0' cellspacing='0' class='center'>\n<tr>\n";
	echo "<td width='100' class='tbl'>".$locale['422']."</td>\n";
	echo "<td width='80%' class='tbl'><input type='text' name='news_subject' value='".$news_subject."' class='textbox' style='width: 250px' /></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td width='100' class='tbl'>".$locale['423']."</td>\n";
	echo "<td width='80%' class='tbl'><select name='news_cat' class='textbox'>\n";
	echo "<option value='0'>".$locale['424']."</option>\n".$news_cat_opts."</select></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td valign='top' width='100' class='tbl'>".$locale['425']."</td>\n";
	echo "<td width='80%' class='tbl'><textarea name='body' cols='95' rows='10' class='textbox' style='width:98%'>".$body."</textarea></td>\n";
	echo "</tr>\n";
	if (!$settings['tinymce_enabled']) {
		echo "<tr>\n<td class='tbl'></td>\n<td class='tbl'>\n";
		echo display_html("inputform", "body", true, true, true, IMAGES_N);
		echo "</td>\n</tr>\n";
	}
	echo "<tr>\n<td valign='top' width='100' class='tbl'>".$locale['426']."</td>\n";
	echo "<td class='tbl'><textarea name='body2' cols='95' rows='10' class='textbox' style='width:98%'>".$body2."</textarea></td>\n";
	echo "</tr>\n";
	if ($settings['tinymce_enabled'] != 1) {
		echo "<tr>\n<td class='tbl'></td>\n<td class='tbl'>\n";
		echo display_html("inputform", "body2", true, true, true, IMAGES_N);
		echo "</td>\n</tr>\n";
	}
	echo "<tr>\n";
	echo "<td class='tbl'>".$locale['427']."</td>\n";
	echo "<td class='tbl'><select name='news_start[mday]' class='textbox'>\n<option>--</option>\n";
	for ($i=1;$i<=31;$i++) echo "<option".(isset($news_start['mday']) && $news_start['mday'] == $i ? " selected='selected'" : "").">$i</option>\n";
	echo "</select> <select name='news_start[mon]' class='textbox'>\n<option>--</option>\n";
	for ($i=1;$i<=12;$i++) echo "<option".(isset($news_start['mon']) && $news_start['mon'] == $i ? " selected='selected'" : "").">$i</option>\n";
	echo "</select> <select name='news_start[year]' class='textbox'>\n<option>----</option>\n";
	for ($i=2004;$i<=2010;$i++) echo "<option".(isset($news_start['year']) && $news_start['year'] == $i ? " selected='selected'" : "").">$i</option>\n";
	echo "</select> / <select name='news_start[hours]' class='textbox'>\n";
	for ($i=0;$i<=24;$i++) echo "<option".(isset($news_start['hours']) && $news_start['hours'] == $i ? " selected='selected'" : "").">$i</option>\n";
	echo "</select> : <select name='news_start[minutes]' class='textbox'>\n";
	for ($i=0;$i<=60;$i++) echo "<option".(isset($news_start['minutes']) && $news_start['minutes'] == $i ? " selected='selected'" : "").">$i</option>\n";
	echo "</select> : 00 ".$locale['429']."</td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td class='tbl'>".$locale['428']."</td>\n";
	echo "<td class='tbl'><select name='news_end[mday]' class='textbox'>\n<option>--</option>\n";
	for ($i=1;$i<=31;$i++) echo "<option".(isset($news_end['mday']) && $news_end['mday'] == $i ? " selected='selected'" : "").">$i</option>\n";
	echo "</select> <select name='news_end[mon]' class='textbox'>\n<option>--</option>\n";
	for ($i=1;$i<=12;$i++) echo "<option".(isset($news_end['mon']) && $news_end['mon'] == $i ? " selected='selected'" : "").">$i</option>\n";
	echo "</select> <select name='news_end[year]' class='textbox'>\n<option>----</option>\n";
	for ($i=2004;$i<=2010;$i++) echo "<option".(isset($news_end['year']) && $news_end['year'] == $i ? " selected='selected'" : "").">$i</option>\n";
	echo "</select> / <select name='news_end[hours]' class='textbox'>\n";
	for ($i=0;$i<=24;$i++) echo "<option".(isset($news_end['hours']) && $news_end['hours'] == $i ? " selected='selected'" : "").">$i</option>\n";
	echo "</select> : <select name='news_end[minutes]' class='textbox'>\n";
	for ($i=0;$i<=60;$i++) echo "<option".(isset($news_end['minutes']) && $news_end['minutes'] == $i ? " selected='selected'" : "").">$i</option>\n";
	echo "</select> : 00 ".$locale['429']."</td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td class='tbl'>".$locale['430']."</td>\n";
	echo "<td class='tbl'><select name='news_visibility' class='textbox'>\n".$visibility_opts."</select></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td class='tbl'></td><td class='tbl'>\n";
	echo "<label><input type='checkbox' name='news_draft' value='yes'".$news_draft." /> ".$locale['431']."</label><br />\n";
	echo "<label><input type='checkbox' name='news_sticky' value='yes'".$news_sticky." /> ".$locale['432']."</label><br />\n";
	if ($settings['tinymce_enabled'] != 1) {
		echo "<label><input type='checkbox' name='line_breaks' value='yes'".$news_breaks." /> ".$locale['433']."</label><br />\n";
	}
	echo "<label><input type='checkbox' name='news_comments' value='yes' onclick='SetRatings();'".$news_comments." /> ".$locale['434']."</label><br />\n";
	echo "<label><input type='checkbox' name='news_ratings' value='yes'".$news_ratings." /> ".$locale['435']."</label></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td align='center' colspan='2' class='tbl'><br />\n";
	if ((isset($_POST['edit']) && (isset($_POST['news_id']) && isnum($_POST['news_id']))) || (isset($_POST['preview']) && (isset($_POST['news_id']) && isnum($_POST['news_id']))) || (isset($_GET['news_id']) && isnum($_GET['news_id']))) {
		echo "<input type='hidden' name='news_id' value='".(isset($_POST['news_id']) ? $_POST['news_id'] : $_GET['news_id'])."' />\n";
	}
	echo "<input type='submit' name='preview' value='".$locale['436']."' class='button' />\n";
	echo "<input type='submit' name='save' value='".$locale['437']."' class='button' /></td>\n";
	echo "</tr>\n</table>\n</form>\n";
	closetable();
	echo "<script type='text/javascript'>\n"."function DeleteNews() {\n";
	echo "return confirm('".$locale['451']."');\n}\n";
	echo "function ValidateForm(frm) {\n"."if(frm.news_subject.value=='') {\n";
	echo "alert('".$locale['450']."');\n"."return false;\n}\n}\n";
	echo "function SetRatings() {\n"."if (inputform.news_comments.checked == false) {\n";
	echo "inputform.news_ratings.checked = false;\n"."inputform.news_ratings.disabled = true;\n";
	echo "} else {\n"."inputform.news_ratings.disabled = false;\n}\n}\n</script>\n";
}

require_once THEMES."templates/footer.php";
?>
