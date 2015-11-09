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
+--------------------------------------------*/
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

error_reporting(E_ALL -E_NOTICE); // Just if we missed something stupid, we want it to look good with limited time now !

// If register_globals is turned off, extract super globals (php 4.2.0+) // We know its off in V7 but we keep this one here for you since VArcade is considered safe and we save alot of time doing this!

if (ini_get('register_globals') != 1) {
	if ((isset($_POST) == true) && (is_array($_POST) == true)) extract($_POST, EXTR_OVERWRITE);
	if ((isset($_GET) == true) && (is_array($_GET) == true)) extract($_GET, EXTR_OVERWRITE);
}

echo '<script type="text/javascript" src="'.INFUSIONS.'varcade/rating.js"></script>';
echo '<script type="text/javascript" src="'.INFUSIONS.'varcade/search.js"></script>';
$resultvset = dbquery("SELECT * FROM ".$db_prefix."varcade_settings");
$varcsettings = dbarray($resultvset);
if ($varcsettings['ratings'] == "1")
{
echo '<link rel="stylesheet" type="text/css" href="'.INFUSIONS.'varcade/css/rating.css">';

}

function getsize($gamefile)
{
global $data,$gamefile,$size;
$size = filesize("$gamefile");
return $size;
}

function makeheader() {
global $data,$varcsettings,$db_prefix,$locale,$size,$gamefile;
echo "<fieldset><legend>".$locale['VARC206']."</legend>";
echo"<table align='center' valign='middle' width='95%' cellspacing='0' cellpadding='0'>
<td align='left'><b> [ <a href='".INFUSIONS."varcade/index.php'>".$locale['VARC100']."</a>  ]</b>";
if ($varcsettings['popup']=="1")
{
echo "<b> [ <a href='#' onclick=window.open('".INFUSIONS."varcade/random.php?p=1','VArcpopup','scrollbars=yes,resizable=yes,width=800,height=700')>".$locale['VARC101']."</a> ] </b>";
}
else
{
echo "<b> [ <a href='".INFUSIONS."varcade/random.php'>".$locale['VARC101']."</a> ] </b>";
}
if (iMEMBER) {
if ($varcsettings['favorites'] == "1")
{
echo "<b> [ <a href='".INFUSIONS."varcade/favorit_games.php'>".$locale['VARC102']."</a> ] </b>";
}
}
echo" <input type='text' id='query' class='textbox' style=' height: 17px; width: 100px; border: 1px solid #000; background-color: #636363; color: #000; font-size: 12px;' value='".$locale['VARC103']."' onBlur=\"if(this.value=='') this.value='".$locale['VARC103']."';\" onFocus=\"if(this.value=='".$locale['VARC103']."') this.value='';\" onKeyDown=\"if(event.keyCode==13) Search();\">";

echo "</td>";
$result1 = dbquery("SELECT * FROM ".$db_prefix."varcade_cats WHERE ".groupaccess('access')." ORDER BY title ASC");
echo "<td align='right'>";
echo "<form method='post' action='".INFUSIONS."varcade/index.php'>";
echo "<select name='category' class='textbox' onChange=\"this.form.submit()\">";
echo '<option value="">'.$locale['VARC104'].'</option>';
while ($data1 = dbarray($result1)) {
echo"<option value='".$data1['cid']."'>".$data1['title']."</option>";
} 
echo "</select></form></td></table></fieldset>";
}

function makelist() {
global $data,$varcsettings,$db_prefix,$locale,$pres,$gamefile,$size,$userdata,$gamelink;

$gamefile = "".INFUSIONS."varcade/uploads/flash/".$data['flash']."";
getsize($gamefile);
$arcade_comment_count = dbcount("(comment_id)", "".$db_prefix."comments", "comment_type='G' AND comment_item_id='".$data['lid']."'");
$pres = nl2br($data['description']);
$pres = preg_replace("/^(.{255}).*$/", "$1", $pres);
$pres = preg_replace("/([^\s]{25})/", "$1\n", $pres);

if ($varcsettings['popup']=="1")
{
$gamelink = "<a href='#' onclick=window.open('".INFUSIONS."varcade/arcade.php?p=1&game=".$data['lid']."','VArcpopup','scrollbars=yes,resizable=yes,width=800,height=700')>"; 
}
else
{
$gamelink = "<a href='".INFUSIONS."varcade/arcade.php?game=".$data['lid']."'>";
}

echo "
<center>
<table cellpadding='0' cellspacing='1' border='0' width='300' width='100%'><tr valign='top'><td>
<tr valign='top'>";
echo "<table align='center' cellpadding='0' cellspacing='1'  class='tbl-border'>
<tr>
<td colspan='3'>
<table align='center' cellpadding='0' cellspacing='0' width='100%'>
<tr>
<td class='tbl2'><b>".$gamelink."".$data['title']."</a></b></td>";
echo "<td align='right' class='tbl2'>";
if ($varcsettings['showsize'] == "1")
{
echo "".$locale['VARC150']." ".parseByteSize($size)."";
}
echo "</td></tr></table></td><tr><td align='center' width='150' rowspan='5' class='tbl2'>\n";
if (file_exists(INFUSIONS."varcade/uploads/thumb/".$data['icon'].""))
{
$showimg = "<IMG SRC='".INFUSIONS."varcade/uploads/thumb/".$data['icon']."' valign='middle' align='center' width='80' height='80' border='0' alt='".$data['title']."'>";
}
else {
$showimg = "<img src='".INFUSIONS."varcade/img/arcade.gif' valign='middle' align='center' width='80' height='80' border='0' alt='".$data['title']."'>";
}
if ($data['lastplayed'] == "0")
{
$lastplayed = "".$locale['VARC158']."";
}
else
{
$lastplayed = "".showdate('shortdate', $data['lastplayed'])."";
}

if ($data['hiscoredate'] == "0")
{
$hiscoredate = "".$locale['VARC159']."";
}
else
{
$hiscoredate = "".showdate('shortdate', $data['hiscoredate'])."";
}

if ($data['hi_player'] == "0")
{
$hi_player = "".$locale['VARC160']."";
}
else
{
$hi_player = "<a href='".INFUSIONS."varcade/hiscore.php?gameid=".$data['lid']."'>".$data['hi_player']."</a>";
}
echo "".$gamelink."".$showimg."</a></td>";
echo "
<td width='1%' class='tbl1' style='white-space:nowrap'><b>".$locale['VARC151']."</b></td>
<td class='tbl1'><a href='".INFUSIONS."varcade/hiscore.php?gameid=".$data['lid']."'>".$data['hiscore']."</a></td>
</tr>
<tr>
<td width='1%' class='tbl2' style='white-space:nowrap'><b>".$locale['VARC152']."</b></td>
<td class='tbl2'>".$hi_player."</td>
</tr>
<tr>
<td width='1%' class='tbl1' style='white-space:nowrap'><b>".$locale['VARC153']."</b></td>
<td class='tbl1'>".$hiscoredate."</td>
</tr>
<tr>
<td width='1%' class='tbl2' style='white-space:nowrap'><b>".$locale['VARC154']."</b></td>
<td class='tbl2'>".$data['played']." ".$locale['VARC157']."
</td>
</tr>
<tr>
<td width='1%' class='tbl1' style='white-space:nowrap'><b>".$locale['VARC155']."</b></td>
<td class='tbl1'>".$lastplayed."</td>
</tr>
<tr>";
if ($varcsettings['ratings'] == "1")
{
echo "<td align='center' class='tbl1'>\n";
rating_bar($data['lid']);
echo "</td>";
echo "<td width='1%' class='tbl2' style='white-space:nowrap'><b>".$locale['VARC156']."</b></td>";
}
if ($varcsettings['ratings'] == "0")
{
echo "<td width='1%' colspan='2' class='tbl2' style='white-space:nowrap'><b>".$locale['VARC156']."</b></td>";
}
echo "<td class='tbl2'>";
if ($data['control'] == 0) {
echo '<img src="'.INFUSIONS.'varcade/img/mouse.png" border="0" alt="'.$locale['VARC414'].'">';
} 
if ($data['control'] == 1) {
echo '<img src="'.INFUSIONS.'varcade/img/keyboard.png" border="0" alt="'.$locale['VARC413'].'">';
}
if ($data['control'] == 2) {
echo '<img src="'.INFUSIONS.'varcade/img/mouse.png" border="0" alt="'.$locale['VARC414'].'">';
//Gotto fix a new option / image ..
}
echo "
</td>
</tr>";
echo "<tr><td class='tbl1' align='center' colspan='3'>".$pres."</td></tr>";
if ($varcsettings['usergold'] == "1")
{
echo "<tr><td class='tbl1' align='center' colspan='3'>";
echo "<font color ='red'><b>".$locale['GARC104']."</b></font> : ".$data['cost']." <font color ='red'><b>".$locale['GARC105']."</b></font> : ".$data['reward']." <font color ='red'><b>".$locale['GARC106']."</b></font> : ".$data['bonus']."";
echo "</tr></td>";
}
echo "<tr><td class='tbl1' align='center' colspan='3'>";
if ($varcsettings['popup'] == "2")
{
echo " • <a href='#' onclick=window.open('".INFUSIONS."varcade/arcade.php?p=1&game=".$data['lid']."','VArcpopup','scrollbars=yes,resizable=yes,width=800,height=700')><img src='".INFUSIONS."varcade/img/newwindow.gif' border='0' alt='".$locale['VARC161']."'></a>";
}
if ($varcsettings['favorites'] == "1")
{
if (iMEMBER)
{
$row2 = dbquery("SELECT * FROM ".$db_prefix."varcade_favourites WHERE fav_id=$data[lid] AND fav_user='".$userdata['user_id']."'");
$fav_id2=dbarray($row2);
$fav_id2 = $fav_id2['fav_id'];
if( $data['lid'] != $fav_id2){
echo " • <a href='".INFUSIONS."varcade/add_favourites.php?fav_id=".$data['lid']."&fav_user=".$userdata['user_id']."&fav_icon=".$data['icon']."&fav_gamename=".$data['title']."'><img src='".INFUSIONS."varcade/img/bookmark.gif' border='0' alt='".$locale['FARC107']."'></a> •";
}
}
}
if ($varcsettings['recommend'] == "1")
{
echo" <a href='#' onclick=window.open('".INFUSIONS."varcade/tipafriend.php?game_id=".$data['lid']."','Tipafriend','scrollbars=yes,resizable=yes,width=520,height=300')><img src='".INFUSIONS."varcade/img/email.gif' border='0' alt='".$locale['VARC601']." ".$data['title']."'></a> • ";
}
if ($varcsettings['comments'] == "1")
{
echo "<a href='#' onclick=window.open('".INFUSIONS."varcade/callcomments.php?comment_id=".$data['lid']."','Comments','scrollbars=yes,resizable=yes,width=650,height=660')><img src='".INFUSIONS."varcade/img/comment.gif' border='0' alt='".$locale['KOM100']."'>($arcade_comment_count)</a> • "; 
}
if (iMEMBER)
{
if ($varcsettings['reports'] == "1")
{
echo "<a href='".INFUSIONS."varcade/report.php?broken_id=".$data['lid']."' onClick='return confirmreport();''><img src='".INFUSIONS."varcade/img/broken.gif' border='0' alt='".$locale['VARC504']."'></a>";
}
}
if(iADMIN)
{
$game = "".$data['lid']."";
echo " • <a href=\"javascript:show_hide('".$data['lid']."')\"><img src='".INFUSIONS."varcade/img/edit.gif' border='0' alt='".$locale['VARC400']."'></a> •";
echo "<div id='".$data['lid']."' style='display:none'>";
echo '<IFRAME frameborder="0" SRC="'.INFUSIONS.'varcade/admin/edit.php?game='.$game.'" width="100%" HEIGHT="230px"></IFRAME>';
echo "</div>";
}


echo "</td></tr>";
echo "</table>\n";

}

function rating_bar($id) { 
global $data,$db_prefix,$locale;

$query=dbquery("SELECT total_votes, total_value, used_ips FROM ".$db_prefix."varcade_rating WHERE id='$id' ");
$numbers=mysql_fetch_assoc($query);
$count=$numbers['total_votes'];
$current_rating=$numbers['total_value'];
$tense=($count==1) ? "".$locale['VOT303']."" : "".$locale['VOT304']."";
$ip = $_SERVER['REMOTE_ADDR'];
$result=dbquery("SELECT count(*) FROM ".$db_prefix."varcade_rating WHERE used_ips LIKE '%".$ip."%' AND id='$id' ");
$voted = mysql_result($result, 0, 0); 
@$rating = number_format($current_rating/$count,1);
?>
		<div id="unit_long<?php echo $id ?>">
		<ul class="unit-rating">
		<li class='current-rating' style="width:<?php echo @number_format($current_rating/$count,2)*16; ?>px;"></li>
<?php
		for ($ncount = 1; $ncount <= 5; $ncount++) 
{ 
?>
	<li><a href="#" title="<?php echo $ncount ?> <?php echo $locale['VOT308']; ?>" class="r<?php echo $ncount ?>-unit" onclick="javascript:sndReq('<?php echo $ncount ?>','<?php echo $id ?>','<?php echo $ip ?>')"><?php echo $ncount ?></a></li>
<?php
	}
		$ncount=0; 
		?>
		</ul>
		 <p><?php echo $locale['VOT306']; ?> <strong> <?php echo @number_format($current_rating/$count,1) ?></strong><?php echo $locale['VOT302']; ?> <?php echo $count ?> <?php echo $tense ?> 
			&nbsp;
<?php

}
?>
