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
|Kroax is written by Domi & fetloser          |
|http://www.venue.nu			      |
+--------------------------------------------*/
require_once "../../../maincore.php";
require_once THEME."theme.php";
echo "<link rel='stylesheet' href='".THEME."styles.css' type='text/css'>";

if (!iMEMBER) { header("Location:../../../index.php"); exit; }

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

$resultset = dbquery("SELECT * FROM ".$db_prefix."kroax_set WHERE kroax_set_id='1'");
$kroaxsettings=dbarray($resultset);

if (!$kroaxsettings['kroax_set_allowuploads'] == "1") { header("Location:../../../index.php"); exit; }

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


echo "<fieldset ><legend>".$locale['KROAX424']."</legend>";

echo"
<form name='contact1' name='inputform' method='post' action='proccess.php?upload' enctype='multipart/form-data' onSubmit='return ValidateForm(this);'>
<table align='center' width='100%' cellspacing='0' cellpadding='0' class='tbl'>
<tr>
<td width='100%' align='center' valign='top'>
<table align='center' cellspacing='0' cellpadding='0' class='tbl'>
</tr>

<tr>
<td  align='right'>".$locale['KROAX212']." </td>
<td><input type='text' name='titel' value='' class='textbox' style='width:120px;'></td>
</tr>
";
echo "
<tr>
<td align='right'>".$locale['KROAX422']."</td>
<td><input type='file' name='movie_url' enctype='multipart/form-data' value='' class='textbox' style='width:200px;'></td>
</tr>";
if ($kroaxsettings['kroax_set_ffmpeg'] == "1")
{
}
else
{
echo "
<tr>
<td align='right'>".$locale['KROAX423']."</td>
<td><input type='file' name='imagefile' enctype='multipart/form-data' value='' class='textbox' style='width:200px;'></td>
</tr>";
}

echo"
<tr>
<td align='right' valign='top'>".$locale['KROAX112']."</td>
<td>
<textarea name='description' id='description' cols='5' rows='4' class='textbox' style='width:100%;'></textarea>
</td></tr>";
echo "<td align='right'><br>".$locale['KROAX210']."</td>";
echo '<td><select class="textbox" name="cat"><option value="">'.$locale['KROAX320'].'</option>';
$result=dbquery("select cid, title, parentid from ".$db_prefix."kroax_kategori order by parentid,title");
while(list($cid, $title, $parentid) = dbarraynum($result)) 
{
if ($parentid!=0) $title=getparent($parentid,$title);
echo '<option value="'.$cid.'">'.$title.'</option>';
}	
echo '</select></td></tr>';
$now = time();

echo "
<input type='hidden' name='uploader' value='".$userdata['user_name']."' readonly>
<input type='hidden' name='date' value='".$now."' readonly>
<input type='hidden' name='lastplayed' value='0' readonly>
<input type='hidden' name='approval' value='deny'>
<td align='center' colspan='2'>";
if ($kroaxsettings['kroax_set_ffmpeg'] == "1")
{
echo "<input type='submit' name='save_cat' value='".$locale['KROAX106']."' class='button'  id='btnSubmit' /></td>";
}
else
{
echo "<input type='submit' name='save_cat' value='".$locale['KROAX106']."' class='button'></td>";
 }
echo "
</table></table>
</form>\n";

echo "<script type='text/javascript'>

function closeWin() {
  window.close();
}

function ValidateForm(frm) {
	if(frm.titel.value=='') {
		alert('".$locale['KROAX407']."');
		return false;
	}
if(frm.movie_url.value=='') {
		alert('".$locale['KROAX408']."');
		return false;
	}
if(frm.imagefile.value=='') {
		alert('".$locale['KROAX410']."');
		return false;
	}
if(frm.description.value=='') {
		alert('".$locale['KROAX409']."');
		return false;

	}
}

</script>\n";

echo "</fieldset>";
echo "<br>";
echo "<br>";
echo "<fieldset><legend>".$locale['KROAX425']."</legend>";

echo"

<form name='contact' name='inputform' method='post' action='proccess.php?url' enctype='multipart/form-data' onSubmit='return ValidateForm(this);'>
<table align='center' width='100%' cellspacing='0' cellpadding='0' class='tbl'>

<td width='100%' align='center' valign='top'>
<table align='center' cellspacing='0' cellpadding='0' class='tbl'>
<tr>
<td  align='right'>".$locale['KROAX212']." </td>
<td><input type='text' name='titel' value='' class='textbox' style='width:120px;'></td>
</tr>
<tr>
<td align='right'>".$locale['KROAX208']."</td>
<td><input type='text' name='url' value='' class='textbox' style='width:200px;'><select name='from' class='small'>
          <option value=''>General URL </option>
	<option value='.999'>Youtube</option>
	<option value='.998'>Google</option>
	<option value='.stm'>Stream</option>
       </select></td>
</tr>

<tr>
<td align='right'>".$locale['KROAX205']." </td>
<td><input type='text' name='tumb' value='' class='textbox' style='width:200px;'></td>
</tr>

";

echo"


<tr>
<td align='right' valign='top'>".$locale['KROAX112']."</td>
<td><textarea name='description' id='description' cols='5' rows='4' class='textbox' style='width:100%;'></textarea>
</td></tr>";

echo "<td align='right'><br>".$locale['KROAX210']."</td>";
echo '<td><select class="textbox" name="cat"><option value="">'.$locale['KROAX320'].'</option>';
$result=dbquery("select cid, title, parentid from ".$db_prefix."kroax_kategori order by parentid,title");
while(list($cid, $title, $parentid) = dbarraynum($result)) 
{
if ($parentid!=0) $title=getparent($parentid,$title);
echo '<option value="'.$cid.'">'.$title.'</option>';
}	
echo '</select></td></tr>';


echo "
<input type='hidden' name='uploader' value='".$userdata['user_name']."' readonly>
<input type='hidden' name='date' value='".$now."' readonly>
<input type='hidden' name='approval' value='deny'>

<td align='center' colspan='2'>
<input type='submit' name='save_cat_user_url' value='".$locale['KROAX106']."' class='button'></td>

</table></table>
</form>\n";

echo "<script type='text/javascript'>

function closeWin() {
  window.close();
}

function ValidateForm(frm) {
	if(frm.titel.value=='') {
		alert('".$locale['KROAX407']."');
		return false;
	}
if(frm.url.value=='') {
		alert('".$locale['KROAX408']."');
		return false;
	}
if(frm.tumb.value=='') {
		alert('".$locale['KROAX410']."');
		return false;
	}
if(frm.description.value=='') {
		alert('".$locale['KROAX409']."');
		return false;

	}
}

</script>\n";
echo "</fieldset>";

?>
