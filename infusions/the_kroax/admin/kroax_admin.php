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
if (!checkRights("I")) { ("Location:../../index.php"); exit; }
echo '<script type="text/javascript" src="'.INFUSIONS.'the_kroax/admin/js.js"></script>';

if (isset($id) && !isNum($id)) fallback("index.php");

echo'
<SCRIPT LANGUAGE=JAVASCRIPT TYPE="TEXT/JAVASCRIPT">
<!--Hide script from old browsers
function confirmdelete() {
return confirm("'.$locale['KROAX224'].'")
}
//Stop hiding script from old browsers -->
</SCRIPT>';

function getparent($parentid,$title) 
{
global $db_prefix;
	$result=dbquery("select * from ".$db_prefix."kroax_kategori where cid=$parentid");
	$data = dbarray($result);
	if ($data['title']!="") $title=$data['title']." &raquo; ".$title;
	if ($data['parentid']!=0) 
	{
		$title=getparent($data['parentid'],$title);
	}
    return $title;
}


if (isset($step) && $step == "delete") {
$result1 = dbquery("SELECT kroax_url,kroax_tumb FROM ".$db_prefix."kroax WHERE kroax_id='$id'");
$remove = dbarray($result1);
$kroaxurl="".$remove['kroax_url']."";
$kroaxtumb="".$remove['kroax_tumb']."";
@unlink($kroaxurl);
@unlink($kroaxtumb);
$resulta = dbquery("DELETE FROM ".$db_prefix."kroax WHERE kroax_id='$id'");
$resultb = dbquery("DELETE FROM ".$db_prefix."kroax_favourites WHERE fav_id='$id'");
$resultc = dbquery("DELETE FROM ".$db_prefix."comments WHERE comment_item_id='$id'");
$resultd = dbquery("DELETE FROM ".$db_prefix."kroax_ratings  WHERE rating_item_id ='$id'");
redirect("".INFUSIONS."the_kroax/admin/admin.php?a_page=main");

}

if (isset($_POST['save_cat'])) {
$titel = stripinput($_POST['titel']);
$category = stripinput($_POST['cat']);
$visibility_opts = stripinput($_POST['visibility_opts']);
$date = stripinput($_POST['date']);
$embed_code = ($_POST['embed_code']);
$uploader = stripinput($_POST['uploader']);
$lastplayed = stripinput($_POST['lastplayed']);
$approval = stripinput($_POST['approval']);
$url = stripinput($_POST['url']);
$downloads = stripinput($_POST['downloads']);
$hits = stripinput($_POST['hits']);
$description = stripslashes($_POST['description']);
$tumb = stripinput($_POST['tumb']);
$errorreport = stripinput($_POST['errorreport']);
$from = stripinput($_POST['from']);


if (isset($step) && $step == "edit") {
if($visibility_opts == "") $visibility_opts="0";
if($url == "") $url=".emb";
if($embed_code != "") $url=".emb";
$cat_changer = dbquery("SELECT kroax_id,kroax_cat,kroax_access,kroax_access_cat FROM ".$db_prefix."kroax WHERE kroax_id='$id'");
$cat = dbarray($cat_changer);
$a_cat= $cat['kroax_cat'];
$access_cat= $cat['kroax_access_cat'];
$cat_cat = dbquery("SELECT access,title FROM ".$db_prefix."kroax_kategori WHERE title='$cat'");
$test_cat = dbarray($cat_cat);
$a_cat1= $test_cat['access'];
$a_cat2= $test_cat['title'];
if($a_cat1 == "") $a_cat1="0";
$result = dbquery("UPDATE ".$db_prefix."kroax SET kroax_access_cat='$a_cat1', kroax_titel='$titel', kroax_cat='$category', kroax_access='$visibility_opts', kroax_date='$date', kroax_embed='$embed_code', kroax_uploader='$uploader', kroax_lastplayed='$lastplayed', kroax_approval='$approval', kroax_url='$url$from', kroax_downloads='$downloads', kroax_hits='$hits', kroax_description='$description', kroax_tumb='$tumb', kroax_errorreport='$errorreport' WHERE kroax_id='$id'");
} else {
if($url == "") $url=".emb";
if($embed_code != "") $url=".emb";
$cat = stripinput($_POST['cat']);
$cat_cat = dbquery("SELECT access,title FROM ".$db_prefix."kroax_kategori WHERE title='$cat'");
$test_cat = dbarray($cat_cat);
$a_cat1=$test_cat['access'];
if($a_cat1 == "") $a_cat1="0";
if($cat =="") $a_cat1="0";
$result = dbquery("INSERT INTO ".$db_prefix."kroax VALUES('', '$titel', '$cat', '$visibility_opts', '$a_cat1', '$date', '$embed_code', '$uploader', '$lastplayed', '$approval', '$url$from', '$downloads', '$hits', '$description', '$tumb', '$errorreport')");
}
redirect("".INFUSIONS."the_kroax/admin/admin.php?a_page=main");
}

if (isset($step) && $step == "edit") {
$result = dbquery("SELECT * FROM ".$db_prefix."kroax WHERE kroax_id='$id'");
$data = dbarray($result);
$titel = $data['kroax_titel'];
$cat = $data['kroax_cat'];
$visibility_opts = $data['kroax_access'];
$date = $data['kroax_date'];
$embed_code = $data['kroax_embed'];
$uploader = $data['kroax_uploader'];
$lastplayed = $data['kroax_lastplayed'];
$approval = $data['kroax_approval'];
$url = $data['kroax_url'];
$downloads = $data['kroax_downloads'];
$hits = $data['kroax_hits'];
$description = $data['kroax_description'];
$tumb = $data['kroax_tumb'];
$errorreport = $data['kroax_errorreport'];

$formaction = "".INFUSIONS."the_kroax/admin/admin.php?a_page=main&step=edit&id=".$data['kroax_id']."";
} else {
$now = time();
$titel = ""; $cat = ""; $visibility_opts = ""; $date= "".$now.""; $embed_code= ""; $uploader= "".$userdata['user_name'].""; $lastplayed= ""; $approval= ""; $url= ""; $downloads= ""; $hits= ""; $description= ""; $tumb= ""; $errorreport= "";
$formaction = "".INFUSIONS."the_kroax/admin/admin.php?a_page=main";
}
echo"<input type='text' id='query' class='textbox' style=' height: 17px; width: 100px; border: 1px solid #000; background-color: #636363; color: #000; font-size: 12px;' value='".$locale['KROAX109']."' onBlur=\"if(this.value=='') this.value='".$locale['KROAX109']."';\" onFocus=\"if(this.value=='".$locale['KROAX109']."') this.value='';\" onKeyDown=\"if(event.keyCode==13) Search();\"><a onClick=\"javascript:Search();\" class='button'>".$locale['KROAX109']."</a>";

echo "<form name='addcat' method='post' action='$formaction'>
<table align='center' width='100%' cellspacing='0' cellpadding='0' class='tbl'>
<tr>
<td width='40%' align='right' valign='top'>
<table align='center' cellspacing='0' cellpadding='0' class='tbl'>
</tr>
<td width='49%' align='right'>".$locale['KROAX204']."</td>
<td><input type='text' name='titel' value='$titel' class='textbox' style='width:120px;'></td>
<tr>
<td align='right'>".$locale['KROAX208']."</td>
<td><input type='text' name='url' value='$url' class='textbox' style='width:250px;'><select name='from' class='small'>
          <option value=''>General url</option>
	<option value='.999'>Youtube</option>
	<option value='.998'>Google</option>
	<option value='.stm'>Stream</option>
       </select></td>
</tr>
<tr>
<td align='right'>".$locale['KROAX316']."</td>
<td><input type='text' name='uploader' value='$uploader' class='textbox' style='width:120px;'></td>
</tr>
<tr>
<td align='right'>".$locale['KROAX317']."</td>
<td><input type='text' name='date' value='$date' class='textbox' style='width:120px;'></td>
</tr>
<tr>
<td align='right'>".$locale['MKROAX101']."</td>
<td><input type='text' name='lastplayed' value='$lastplayed' class='textbox' style='width:120px;'></td>
</tr>
<tr>
<td align='right'>".$locale['KROAX318']."</td>
<td><input type='text' name='hits' value='$hits' class='textbox' style='width:50px;'></td>
</tr>";
$visibility_opts = ""; $sel = "";
	$user_groups = getusergroups();
	while(list($key, $user_group) = each($user_groups)){
$sel = ($news_visibility == $user_group['0'] ? " selected" : "");
	$visibility_opts .= "<option value='".$user_group['0']."'$sel>".$user_group['1']." </option>\n";
}
$check = $data['kroax_access'];
$get_group = dbquery("SELECT group_name FROM ".$db_prefix."user_groups WHERE group_id='$check'");
while ($datagroup = dbarray($get_group))
$group = $datagroup['group_name'];
if($check == 101) $group="Member";
if($check == 102) $group="Admin";
if($check == 103) $group="SuperAdmin";
if($check == "0") $group="Public";
if($check == "") $check="0";
echo"
<td align='right'>".$locale['422']."</td>
<td><select name='visibility_opts' class='textbox'>
<option selected value='".$check."'>$group
$visibility_opts</select></td>
<tr>
<td align='right' valign='top'>".$locale['MKROAX102']."</td>
<td><textarea name='embed_code' cols='25' rows='5' class='textbox'>$embed_code</textarea>
</td></tr>
</table></td>
<td width='40%' align='right' valign='top'>
<table align='center' cellspacing='0' cellpadding='0' class='tbl'>
<tr>
<td align='right' valign='top'>".$locale['KROAX112']."</td>
<td><textarea name='description' cols='45' rows='10' class='textbox'>$description</textarea>
</td></tr>
<tr>
<td align='right'>".$locale['KROAX205']." </td>
<td><input type='text' name='tumb' value='$tumb' class='textbox' style='width:200px;'></td>
</tr>
<input type='hidden' name='approval' value='$approval' readonly>";

echo"</table>";
$resultcat=dbquery("select title,cid from ".$db_prefix."kroax_kategori WHERE cid='$cat'");
$datacat = dbarray($resultcat);

echo "<tr><td align='center' colspan='2'>".$locale['KROAX210']." :";
echo '<select class="textbox" name="cat"> <option value="'.$datacat['cid'].'">'.$datacat['title'].'</option>';
$result=dbquery("select cid, title, parentid from ".$db_prefix."kroax_kategori order by parentid,title");
while(list($cid, $title, $parentid) = dbarraynum($result)) 
{
if ($parentid!=0) $title=getparent($parentid,$title);
echo '<option value="'.$cid.'">'.$title.'</option>';
}
echo '</select></td></tr>';

echo"<td align='center' colspan='2'>


<input type='submit' name='save_cat' value='".$locale['KROAX106']."' class='button'></td><td align='right'>
</tr>
</div>
</table>
</form>\n";
tablebreak();
echo "<div id='lajv'>";
$orderby = ($sortby == "all" ? "" : " WHERE kroax_titel LIKE '$sortby%'");
$result = dbquery("SELECT * FROM ".$db_prefix."kroax".$orderby."");
$rows = dbrows($result);
if (!isset($rowstart) || !isNum($rowstart)) $rowstart = 0;

if ($rows != 0) {
echo "<table align='center' width='100%' cellspacing='0'>
<tr>
<td align='left' class='tbl2' width='30%'><b>".$locale['KROAX212']."</b></td>
<td align='center' class='tbl2' width='35%'><b>".$locale['KROAX213']."</b></td>

<td align='center' class='tbl2' width='30%'><b>".$locale['KROAX210']."</b></td>
<td align='right' class='tbl2' width='5%'><b>".$locale['KROAX207']."</b></td>
</tr>\n";
$result = dbquery("SELECT * FROM ".$db_prefix."kroax".$orderby." ORDER BY kroax_id DESC, kroax_cat LIMIT $rowstart,10");
while ($data = dbarray($result)) {
$cdata = dbarray(dbquery("SELECT * FROM ".$db_prefix."kroax_kategori WHERE cid='".$data['kroax_cat']."' "));
echo "<tr>\n<td class='small' width='22%'><img src='".THEME."images/bullet.gif' alt=''> <a href='".INFUSIONS."the_kroax/admin/admin.php?a_page=main&step=edit&id=".$data['kroax_id']."'><b>".$data['kroax_titel']."</b></a></td>\n";
echo "<td class='small' align='center' width='12%'>".$data['kroax_url']."</td>";
echo "<td class='small' align='center' width='5%'>".$cdata['title']."</td>";
echo "</td>";
echo "<td class='small' align='right' width='7%'><a href='".INFUSIONS."the_kroax/admin/admin.php?a_page=main&step=delete&id=".$data['kroax_id']."' onClick='return confirmdelete();'>".$locale['KROAX207']."</a></td></tr>";
}
echo "</table>\n";
echo "<hr>";
echo "<div align='center' style='margin-top:5px;'>".makePageNav($rowstart,10,$rows,3,FUSION_SELF."?sortby=$sortby&")."\n</div>\n";
} else {
echo "<center><br>\n".$locale['KROAX208']." <b>$sortby<b><br><br>\n</center>\n";
}
echo "</div>";

$search = array(
"A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R",
"S","T","U","V","W","X","Y","Z","0","1","2","3","4","5","6","7","8","9"
);
echo "<hr><table align='center' cellpadding='0' cellspacing='1' class='tbl-border'>\n<tr>\n";
echo "<td rowspan='2' class='tbl2'><a href='".INFUSIONS."the_kroax/admin/admin.php?a_page=main&sortby=all'>".$locale['KROAX202']."</a></td>";
for ($i=0;$i < 36!="";$i++) {
echo "<td align='center' class='tbl1'><div class='small'><a href='".INFUSIONS."the_kroax/admin/admin.php?a_page=main&sortby=".$search[$i]."'>".$search[$i]."</a></div></td>";
echo ($i==17 ? "<td rowspan='2' class='tbl2'><a href='".INFUSIONS."the_kroax/admin/admin.php?a_page=main&sortby=all'>".$locale['KROAX202']."</a></td>\n</tr>\n<tr>\n" : "\n");
}
echo "</table>\n";
?>