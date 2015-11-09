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

error_reporting(E_ALL -E_NOTICE); // Just if we missed something stupid, we want it to look good with limited time now !

// If register_globals is turned off, extract super globals (php 4.2.0+) // We know its off in V7 but we keep this one here for you since VArcade is considered safe and we save alot of time doing this!

if (ini_get('register_globals') != 1) {
	if ((isset($_POST) == true) && (is_array($_POST) == true)) extract($_POST, EXTR_OVERWRITE);
	if ((isset($_GET) == true) && (is_array($_GET) == true)) extract($_GET, EXTR_OVERWRITE);
}


echo "<link rel='stylesheet' type='text/css' href='".INFUSIONS."the_kroax/css/rating.css' />";
echo "<script type='text/javascript' src='".INFUSIONS."the_kroax/rating.js'></script>";
echo "<script type='text/javascript' src='".INFUSIONS."the_kroax/search.js'></script>";

echo'
<SCRIPT LANGUAGE=JAVASCRIPT TYPE="TEXT/JAVASCRIPT">
<!--Hide script from old browsers
function confirmreport() {
return confirm("'.$locale['KROAX108'].'")
}
//Stop hiding script from old browsers -->
</SCRIPT>';

$kroaxsettings = dbarray(dbquery("SELECT * FROM ".$db_prefix."kroax_set WHERE kroax_set_id='1'"));

function cleanurl_kroax($url) {
	$bad_entities = array("&", "\"", "'", '\"', "\'", "<", ">", "(", ")", "*");
	$safe_entities = array("&amp;", "", "", "", "", "", "", "", "", "");
	$url = str_replace($bad_entities, $safe_entities, $url);
	return $url;
}

function url_exists($url) {
global $data;
return true;
}
function breadcrumb($cid)
{
global $db_prefix,$locale,$data,$cdata;
$bcq=dbquery("select * from ".$db_prefix."kroax_kategori WHERE status='1' AND cid=$cid");
    	while($bcd = dbarray($bcq))
		{
		$title=getparentlink($bcd['parentid'],$bcd['title'],$bcd['cid']);
		$title="<a href=\"".FUSION_SELF."\"><strong>Home</strong></a> &raquo;  $title";
		}
		return $title;
}

function getparent($parentid,$title) 
{
global $db_prefix,$data;
	$result=dbquery("select * from ".$db_prefix."kroax_kategori where cid=$parentid");
	$data = dbarray($result);
	if ($data['title']!="") $title=$data['title']." &raquo; ".$title;
	if ($data['parentid']!=0) 
	{
		$title=getparent($data['parentid'],$title);
	}
    return $title;
}

function getparentlink($parentid,$title,$cid) 
{
global $db_prefix,$locale,$data,$cdata;
		$data=dbarray(dbquery("select cid, title, parentid from ".$db_prefix."kroax_kategori where cid=$parentid"));
			if ($data['title']!="") 
		{
		$title='<a href="'.INFUSIONS.'the_kroax/kroax.php?category='.$data['cid'].'"><b>'.$data['title'].'</b></a> &raquo;  <a href="'.INFUSIONS.'the_kroax/kroax.php?category='.$cid.'"><b>'.$title.'</b></a>';
		}
		if ($data['parentid']!=0) 
		{
			$title=getparentlink($data['parentid'],$title,$cid);
		}
		if ($data['parentid']==0) 
		{
			$title='<a href="'.INFUSIONS.'the_kroax/kroax.php?category='.$cid.'"><b>'.$title.'</b></a>';
		}
	return $title;
}



function makeheader() {
global $data,$userdata,$kroaxsettings,$db_prefix,$locale;
echo"
<fieldset>
<legend>  Menu </legend>
<table align='center' width='95%' cellspacing='0' cellpadding='0'>
<td align='left'>
<b> [ <a href='".INFUSIONS."the_kroax/kroax.php'>".$locale['KROAX006']."</a> ]</b>";
if ($kroaxsettings['kroax_set_show'] == "1")
{
echo "<b> [ <a href='".INFUSIONS."the_kroax/random.php'>".$locale['KROAX110']."</a> ]</b>";
}
else
{
echo "<b> [ <a href='#' onclick=window.open('".INFUSIONS."the_kroax/random.php?p=1','Click','scrollbars=yes,resizable=yes,width=800,height=700')>".$locale['KROAX110']."</a> ] </b>";
}
if (($kroaxsettings['kroax_set_allowuploads'] == "1") && (iMEMBER))
{
echo "<b> [ <a href='#' onclick=window.open('".INFUSIONS."the_kroax/uploader/index.php','Uploader','scrollbars=yes,resizable=yes,width=520,height=520')>".$locale['KROAX111']."</a>  ]</b>";
}
if (($kroaxsettings['kroax_set_favorites'] == "1") && (iMEMBER))
{
echo "<b> [ <a href='".INFUSIONS."the_kroax/favourites.php'>".$locale['FKROAX103']."</a> ]</b>";
}
echo "<b> [ <a href='".INFUSIONS."the_kroax/archive.php'>".$locale['KROAX119']."</a> ]</b>";
echo"<br><input type='text' id='query' class='textbox' style=' height: 17px; width: 100px; border: 1px solid #000; background-color: #636363; color: #000; font-size: 12px;' value='".$locale['KROAX109']."' onBlur=\"if(this.value=='') this.value='".$locale['KROAX109']."';\" onFocus=\"if(this.value=='".$locale['KROAX109']."') this.value='';\" onKeyDown=\"if(event.keyCode==13) Search();\"> <a onClick=\"javascript:Search();\" class='button'>".$locale['KROAX109']."</a>";
echo "</td>";

$result1 = dbquery("SELECT * FROM ".$db_prefix."kroax_kategori WHERE ".groupaccess('access')."");
echo'<td align="right">';
echo "
<form method='post' action='".INFUSIONS."the_kroax/kroax.php'>
<select name='category' class='textbox' onChange=\"this.form.submit()\">";
echo '<option value="">'.$locale['KROAX320'].'</option>';
while ($data1 = dbarray($result1)) {
echo"<option value='".$data1['cid']."'>".$data1['title']."</option>";
} 
echo "</select></form></td></table></fieldset>";
}
function makelist() {
global $data,$userdata,$cdata,$kroaxsettings,$db_prefix,$locale,$browser,$pres;

if (isset($_COOKIE['kroaxthumbs']))
{
//thumb view enabled
$cdata = dbarray(dbquery("SELECT * FROM ".$db_prefix."kroax_kategori WHERE cid='".$data['kroax_cat']."'"));
$udata = dbarray(dbquery("SELECT user_id,user_name FROM ".$db_prefix."users WHERE user_name='".$data['kroax_uploader']."' "));
echo "<td align='left'>";
$checkurl = url_exists($data['kroax_tumb']);
$type = substr($data['kroax_url'], -3, 3);
if($type == "mp3")
{
$showimg = "<img src='".INFUSIONS."the_kroax/img/musicstream.jpg'  width='".$kroaxsettings['kroax_set_wi']."' height='".$kroaxsettings['kroax_set_hi']."'>";
}
elseif ($checkurl == "1") {
$showimg = "<IMG SRC='".$data['kroax_tumb']."'  width='".$kroaxsettings['kroax_set_wi']."' height='".$kroaxsettings['kroax_set_hi']."'>";
}
else {
$showimg = "<img src='".INFUSIONS."the_kroax/img/nopic.gif' width='".$kroaxsettings['kroax_set_wi']."' height='".$kroaxsettings['kroax_set_hi']."'>";
}
if ($kroaxsettings['kroax_set_show'] == "1")
{
echo "
<a href='".INFUSIONS."the_kroax/embed.php?url=".$data['kroax_id']."'>".$showimg."</a>";
}
else 
{
echo "
<a href='#' onclick=window.open('".INFUSIONS."the_kroax/embed.php?p=1&url=".$data['kroax_id']."','Click','scrollbars=yes,resizable=yes,width=650,height=550')>".$showimg."</a>";
}
echo "<br>
<a href='#' onclick=window.open('".INFUSIONS."the_kroax/embed.php?p=1&url=".$data['kroax_id']."','Click','scrollbars=yes,resizable=yes,width=800,height=700')><img src='".INFUSIONS."the_kroax/img/newwindow.gif' title='".$locale['MKROAX106']."' border='0' valign='bottom'></a>";
if ($kroaxsettings['kroax_set_show'] == "1")
{
echo "
<a href='".INFUSIONS."the_kroax/embed.php?url=".$data['kroax_id']."'>".trimlink($data['kroax_titel'], 20)."</a><br>";
}
else 
{
echo "
<a href='#' onclick=window.open('".INFUSIONS."the_kroax/embed.php?p=1&url=".$data['kroax_id']."','Click','scrollbars=yes,resizable=yes,width=650,height=550')>".trimlink($data['kroax_titel'], 20)."</a><br>";
}
echo "
<b>".$locale['KROAX114']."</b> <a href='".BASEDIR."profile.php?lookup=".$udata['user_id']."'>".$data['kroax_uploader']."</a><br>
<b>".$locale['KROAX115']."</b> ".showdate('forumdate', $data['kroax_date'])."<br>
<b>".$locale['KROAX307']."</b> <a href='kroax.php?category=".$cdata['cid']."'>".$cdata['title']."</a><br>
<b>".$locale['KROAX113']."</b> ".$data['kroax_hits']." </td>";

}

else
{

$cdata = dbarray(dbquery("SELECT * FROM ".$db_prefix."kroax_kategori WHERE cid='".$data['kroax_cat']."' "));
$udata = dbarray(dbquery("SELECT user_id,user_name FROM ".$db_prefix."users WHERE user_name='".$data['kroax_uploader']."' "));
$pres = nl2br($data['kroax_description']);
$pres = preg_replace("/^(.{255}).*$/", "$1", $pres);
$pres = preg_replace("/([^\s]{25})/", "$1\n", $pres);
echo" <table cellpadding='0' cellspacing='1' border='0' width='200px' align='right' class='tbl-border' style='margin: 0.5em;'>
<tr>
<td width='26%' class='tbl2'>".$locale['KROAX307']."</td>
<td width='26%' class='tbl2'>".$cdata['title']."</td></tr>
<tr>
<td width='26%' class='tbl2'>".$locale['KROAX113']."</td>
<td width='26%' class='tbl2'>".$data['kroax_hits']."</td>
</tr>
<tr>
<td width='26%' class='tbl2'>".$locale['KROAX114']."</td>
<td width='26%' class='tbl2'><a href='".BASEDIR."profile.php?lookup=".$udata['user_id']."'>".$data['kroax_uploader']."</a></td>
</tr>
<tr>
<td width='26%' class='tbl2'>".$locale['KROAX115']."</td>
<td width='26%' class='tbl2'>".showdate('forumdate', $data['kroax_date'])."</td>
</tr>
<tr>
<td width='26%' class='tbl2'>".$locale['MKROAX101']."</td>
<td width='26%' class='tbl2'>".showdate('forumdate', $data['kroax_lastplayed'])."</td>
</tr>
</table>";

echo "<table width='69%' align='middle' cellspacing='0' style='height: 125px' cellpadding='0' border='0'>";
$checkurl = url_exists($data['kroax_tumb']);
$type = substr($data['kroax_url'], -3, 3);
if($type == "mp3")
{
$showimg = "<img src='".INFUSIONS."the_kroax/img/musicstream.jpg' valign='top' align='left' width='".$kroaxsettings['kroax_set_wi']."' height='".$kroaxsettings['kroax_set_hi']."'>";
}
elseif ($checkurl == "1") {
$showimg = "<IMG SRC='".$data['kroax_tumb']."' valign='top' align='left' width='".$kroaxsettings['kroax_set_wi']."' height='".$kroaxsettings['kroax_set_hi']."'>";
}
else {
$showimg = "<img src='".INFUSIONS."the_kroax/img/nopic.gif' valign='top' align='left' width='".$kroaxsettings['kroax_set_wi']."' height='".$kroaxsettings['kroax_set_hi']."'>";
}
if ($kroaxsettings['kroax_set_show'] == "1")
{
echo "
<td align='left' width='8%'><a href='".INFUSIONS."the_kroax/embed.php?url=".$data['kroax_id']."'>".$showimg."</A>
<td valign='top' width='74%'><center><a href='".INFUSIONS."the_kroax/embed.php?url=".$data['kroax_id']."'><b><u>".$data['kroax_titel']."</b></u></a><br><br>".stripslashes($pres)."</td></td></center>";
}
else 
{
echo "
<td align='left' width='8%'><a href='#' onclick=window.open('".INFUSIONS."the_kroax/embed.php?p=1&url=".$data['kroax_id']."','Click','scrollbars=yes,resizable=yes,width=650,height=550')>".$showimg."</A>
<td valign='top' width='74%'><center><a href='#' onclick=window.open('".INFUSIONS."the_kroax/embed.php?p=1&url=".$data['kroax_id']."','Click','scrollbars=yes,resizable=yes,width=650,height=550')><b><u>".$data['kroax_titel']."</b></u></a><br><br>".stripslashes($pres)."</td></td></center>";
}

echo "</table><br><br>";

$kroax_comment_count = dbcount("(comment_id)", "".$db_prefix."comments", "comment_type='K' AND comment_item_id='".$data['kroax_id']."'");

echo "<table width='95%' align='middle' cellspacing='0' cellpadding='0'border='0'>
<td width='20%' class='tbl1' align='middle'>";
if ($kroaxsettings['kroax_set_ratings'] == "1")
{
rating_bar($data['kroax_id']);
}
echo "<td width='80%' class='tbl1'>";
if (($kroaxsettings['kroax_set_favorites'] == "1") && (iMEMBER))
{
$row2 = dbquery("SELECT * FROM ".$db_prefix."kroax_favourites WHERE fav_id=".$data['kroax_id']." AND fav_user='".$userdata['user_id']."'");
$fav_id2=dbarray($row2);
$fav_id2 = $fav_id2['fav_id'];
if( $data['kroax_id'] != $fav_id2){
echo "<a href='".INFUSIONS."the_kroax/add_favourite.php?fav_id=".$data['kroax_id']."&fav_user=".$userdata['user_id']."'><b>".$locale['FKROAX107']."</b></a>  ]<br>[ ";
}
}
if ($kroaxsettings['kroax_set_comments'] == "1")
{
echo "<a href='#' onclick=window.open('".INFUSIONS."the_kroax/callcomments.php?comment_id=".$data['kroax_id']."','Comments','scrollbars=yes,resizable=yes,width=650,height=650')><b>".$locale['KROAX302']."</b></a>($kroax_comment_count) ][ ";
}
if ($kroaxsettings['kroax_set_recommend'] == "1")
{
echo "<a href='#' onclick=window.open('".INFUSIONS."the_kroax/tipafriend.php?movie_id=".$data['kroax_id']."','Tipafriend','scrollbars=yes,resizable=yes,width=350,height=300')><b>".$locale['KROAX303']."</b></a>  ][ ";
}
if ($kroaxsettings['kroax_set_report'] == "1")
{
if (iMEMBER)
{
echo "<a href='".INFUSIONS."the_kroax/report.php?broken_id=".$data['kroax_id']."' target='_blank' onClick='return confirmreport();''><b>".$locale['KROAX304']."</b></a>  ][ ";
}
}
echo"<a href=\"javascript:history.go(-1)\"><b>".$locale['KROAX007']."</b></a>";
echo '</td>';
echo "</td><tr>";
echo "<td colspan='2' height='1px' valign='top' background='img/line.gif'></tr></td></td></tr></table>";

} //End else from thumb view..

}

function rating_bar($id) { 
global $data,$db_prefix,$locale;

$query=dbquery("SELECT total_votes, total_value, used_ips FROM ".$db_prefix."kroax_rating WHERE id='$id' ");
$numbers=mysql_fetch_assoc($query);
$count=$numbers['total_votes'];
$current_rating=$numbers['total_value'];
$tense=($count==1) ? "".$locale['VOT303']."" : "".$locale['VOT304']."";
$ip = $_SERVER['REMOTE_ADDR'];
$result=dbquery("SELECT count(*) FROM ".$db_prefix."kroax_rating WHERE used_ips LIKE '%".$ip."%' AND id='$id' ");
$voted = mysql_result($result, 0, 0); 
@$rating = number_format($current_rating/$count,1);
?>
		<div id="unit_long<?php echo $id ?>">
		<ul class="unit-rating">
		<li class='current-rating' style="width:<?php echo @number_format($current_rating/$count,2)*30; ?>px;"></li>
<?php
		for ($ncount = 1; $ncount <= 5; $ncount++) 
{ 
?>
	<li><a href="#" title="<?php echo $ncount ?> <?php echo $locale['VOT603']; ?>" class="r<?php echo $ncount ?>-unit" onclick="javascript:sndReq('<?php echo $ncount ?>','<?php echo $id ?>','<?php echo $ip ?>')"><?php echo $ncount ?></a></li>
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