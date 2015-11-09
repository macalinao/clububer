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

error_reporting(E_ALL -E_NOTICE); // Just if we missed something stupid, we want it to look good with limited time now !

// If register_globals is turned off, extract super globals (php 4.2.0+) // We know its off in V7 but we keep this one here for you since VArcade is considered safe and we save alot of time doing this!

if (ini_get('register_globals') != 1) {
	if ((isset($_POST) == true) && (is_array($_POST) == true)) extract($_POST, EXTR_OVERWRITE);
	if ((isset($_GET) == true) && (is_array($_GET) == true)) extract($_GET, EXTR_OVERWRITE);
}

//print_r($_POST); //gimme the damn post array..

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
if (!iMEMBER) { header("Location:../../../index.php"); exit; }

include LOCALE.LOCALESET."admin/photos.php";

function createthumbnail($filetype, $origfile, $thumbfile, $new_w, $new_h) {
	
	global $settings;
	
	if ($filetype == 1) { $origimage = imagecreatefromgif($origfile); }
	elseif ($filetype == 2) { $origimage = imagecreatefromjpeg($origfile); }
	elseif ($filetype == 3) { $origimage = imagecreatefrompng($origfile); }
	
	$old_x = imagesx($origimage);
	$old_y = imagesy($origimage);
	
	if ($old_x > $new_w || $old_y > $new_h) {
		if ($old_x < $old_y) {
			$thumb_w = round(($old_x * $new_h) / $old_y);
			$thumb_h = $new_h;
		} elseif ($old_x > $old_y) {
			$thumb_w = $new_w;
			$thumb_h = round(($old_y * $new_w) / $old_x);
		} else {
			$thumb_w = $new_w;
			$thumb_h = $new_h;
		}
	} else {
		$thumb_w = $old_x;
		$thumb_h = $old_y;
	}
	
	if ($settings['thumb_compression'] == "gd1") {
		$thumbimage = imagecreate($thumb_w,$thumb_h);
		$result = imagecopyresized($thumbimage, $origimage, 0, 0, 0, 0, $thumb_w, $thumb_h, $old_x, $old_y);
	} else {
		$thumbimage = imagecreatetruecolor($thumb_w,$thumb_h);
		$result = imagecopyresampled($thumbimage, $origimage, 0, 0, 0, 0, $thumb_w, $thumb_h, $old_x, $old_y);
	}
	
	touch($thumbfile);

	if ($filetype == 1) { imagegif($thumbimage, $thumbfile); }
	elseif ($filetype == 2) { imagejpeg($thumbimage, $thumbfile); }
	elseif ($filetype == 3) { imagepng($thumbimage, $thumbfile); }
}

function image_exists($dir, $image) {
	$i = 1;
	$image_name = substr($image, 0, strrpos($image, "."));
	$image_ext = strrchr($image,".");
	while (file_exists($dir.$image)) {
		$image = $image_name."_".$i.$image_ext;
		$i++;
	}
	return $image;
}


$resultset = dbquery("SELECT * FROM ".$db_prefix."kroax_set WHERE kroax_set_id='1'");
$kroaxsettings=dbarray($resultset);

if (!$kroaxsettings['kroax_set_allowuploads'] == "1") { header("Location:../../../index.php"); exit; }


opentable("Final proccessing......");

if (isset($_POST['save_cat_user_url'])) {

//Lets takecare of user URLS ...

	$titel = stripinput($_POST['titel']);
	$cat = stripinput($_POST['cat']);
	$access = stripinput($_POST['access']);
	$date = time();
	$embed = stripinput($_POST['embed']);
	$uploader = stripinput($_POST['uploader']);
	$lastplayed = stripinput($_POST['lastplayed']);
	$approval = stripinput($_POST['approval']);
	$upload_name = stripinput($_POST['url']);
	$downloads = stripinput($_POST['downloads']);
	$from = stripinput($_POST['from']);
	$hits = stripinput($_POST['hits']);
	$description = stripslashes($_POST['description']);
	$photo_thumb1 = stripinput($_POST['tumb']);
	$errorreport = stripinput($_POST['errorreport']);


$cat = stripinput($_POST['cat']);
$cat_cat = dbquery("SELECT access,title FROM ".$db_prefix."kroax_kategori WHERE title='$cat'");
$test_cat = dbarray($cat_cat);
$a_cat1= $test_cat['access'];
$pm_subject = "".$locale['KROAX401']."";
$pm_message = "".$locale['KROAX402']." [URL]".$settings['siteurl']."infusions/the_kroax/admin/admin.php?a_page=parked[/URL] ".$locale['KROAX403']."";
$result1 = dbquery("INSERT INTO ".$db_prefix."messages (message_id, message_to, message_from, message_subject, message_message, message_smileys, message_read, message_datestamp, message_folder) VALUES('', '1', '".$userdata['user_id']."', '$pm_subject', '$pm_message', 'n', '0', '".time()."', '0')");

if($cat =="") $a_cat1="0";
$result = dbquery("INSERT INTO ".$db_prefix."kroax VALUES('', '$titel', '$cat', '0', '$a_cat1', '$date', '$embed', '$uploader', '$lastplayed', '$approval', '$upload_name$from', '$downloads', '$hits', '$description', '$photo_thumb1', '$errorreport')");

//End user URLs..
}

if ((isset($_POST['save_cat']) || $_POST['hidFileID'])) {

//Server file upload handleing starts here.

if ($kroaxsettings['kroax_set_ffmpeg'] == "1")
{


//Movie upload function
	//$movie_url = stripinput($_POST['movie_url']);
	$upload_maxsize = 2147483647;				// 2GB in bytes
	$upload_extensions = array(".asf",".swf",".wmv",".mov",".rm",".avi",	".MPG",".mpg",".MPEG",".mpeg",".mp3");
	$upload_folder = INFUSIONS."the_kroax/uploads/movies/";
	$upload = $_FILES['movie_url'];
	$MAX_FILENAME_LENGTH = 260;
	$upload_name = "".$upload['name']."";
	$upload_name = str_replace(" ", "_", $upload_name); //lets get rid of spaces so the conversion works!
	$upload_ext = strrchr($upload['name'],".");



// Validate the file size
	$file_size = @filesize($_FILES['movie_url']["tmp_name"]);
	if (!$file_size || $file_size > $upload_maxsize) {
		HandleError("".$locale['KROAX429']."");
echo '<hr width="90%">'.$locale['KROAX430'].'<br>
<a href="index.php">'.$locale['KROAX431'].'</a>';
closetable();
		exit(0);
	}

if (in_array($upload_ext, $upload_extensions)) {
			move_uploaded_file($upload['tmp_name'], $upload_folder.$upload_name);
			chmod($upload_folder.$upload_name,0644);

}
else
{
HandleError($locale['KROAX432']);
echo '<hr width="90%">'.$locale['KROAX433'].'<br>
<a href="index.php">'.$locale['KROAX431'].'</a>';
closetable();
		exit(0);
}

$filename = $upload_name;

$type = substr($filename, -3, 3);

if($type == "mp3")
{
//Do no proccessing, set some basic db values tho..
//$upload_folder = "".$settings['siteurl']."infusions/the_kroax/uploads/movies/";

$filename = $upload_name;
$photo_dest = "";
$photo_thumb1 = "";
}
else
{

function RemoveExtension($strName)
{
$ext = strrchr($strName, '.');

if($ext !== false)
{
$strName = substr($strName, 0, -strlen($ext));
}
return $strName;
}

$out = "$filename"; 
$out = RemoveExtension($out); 

$saveflvpath = INFUSIONS."the_kroax/uploads/movies/";
$saveflv = "$out.flv";

$saveimgpath = INFUSIONS."the_kroax/uploads/thumbs/";
//$saveimgpath = "../uploads/thumbs/";

$saveimg = "$out.jpg";

$ffmpeg = "C:/ffmpeg/ffmpeg";

echo "<br>";
//Lets not proccess flv files..
if($type == "flv")
{
}
else
{
echo "<fieldset><legend>".$locale['KROAX426']."</legend>";
//High quality 18 mb > 16 mb no quality differance $command = $ffmpeg."  -v 0 -i $saveflvpath$filename -s 320x240 -b 500k -ar 44100 $saveflvpath$saveflv";
//not to high quality shrunk 18 mb to 6 mb..$command = $ffmpeg."  -v 0 -i $saveflvpath$filename -s 320x240 -ar 44100 $saveflvpath$saveflv";
$command = "".$ffmpeg."  -v 0 -i ".$saveflvpath."".$filename." -ar 44100 ".$saveflvpath."".$saveflv."";
$output= exec($command." 2>&1");
print "<pre>$output</pre></fieldset>\n";  
echo "<br>";
echo "<br>";
}
echo "<fieldset><legend>".$locale['KROAX427']."</legend>";

$command = $ffmpeg."  -i $saveflvpath$filename -vcodec mjpeg -ss 15  -vframes 1 -an -f rawvideo -s 150x100 $saveimgpath$saveimg";
$output= exec($command." 2>&1");
print "<pre>$output</pre>\n";  
echo "</fieldset>";
tablebreak();
tablebreak();
if($type == "flv")
{
}
else
{
unlink("$saveflvpath$filename");
echo "<fieldset><legend>".$locale['KROAX428']."</legend>";
echo "$filename Deleted";
echo "</fieldset>";
}
//Lets prep it for database & result display.

$upload_folder = "".$settings['siteurl']."infusions/the_kroax/uploads/movies/";
$photo_dest = "".$settings['siteurl']."infusions/the_kroax/uploads/thumbs/";
$upload_name = $saveflv;
$photo_thumb1 = $saveimg;
}
} //< end mp3 check
else
{


function HandleError($message) {
	header("HTTP/1.1 500 Internal Server Error");
	echo $message;
}


//Movie upload function
	$movie_url = stripinput($_POST['movie_url']);
	$upload_maxsize = 2147483647;				// 2GB in bytes
	$upload_extensions = array(".asf",".swf",".wmv",".mov",".rm",".avi",	".MPG",".mpg",".MPEG",".mpeg",".mp3");
	$upload_folder = INFUSIONS."the_kroax/uploads/movies/";
	$upload = $_FILES['movie_url'];
	$MAX_FILENAME_LENGTH = 260;
	$upload_name = "".$upload['name']."";
	$upload_ext = strrchr($upload['name'],".");


// Validate the file size
	$file_size = @filesize($_FILES['movie_url']["tmp_name"]);
	if (!$file_size || $file_size > $upload_maxsize) {
		HandleError("".$locale['KROAX429']."");
echo '<hr width="90%">'.$locale['KROAX430'].'<br>
<a href="index.php">'.$locale['KROAX431'].'</a>';
closetable();
		exit(0);
	}

if (in_array($upload_ext, $upload_extensions)) {
			move_uploaded_file($upload['tmp_name'], $upload_folder.$upload_name);
			chmod($upload_folder.$upload_name,0644);
$upload_folder = "".$settings['siteurl']."infusions/the_kroax/uploads/movies/";
}
else
{
HandleError($locale['KROAX432']);
echo '<hr width="90%">'.$locale['KROAX433'].'<br>
<a href="index.php">'.$locale['KROAX431'].'</a>';
closetable();
		exit(0);
}

//image upload & resize function
$image_url = stripinput($_POST['image_url']);
$imagewidth = "".$kroaxsettings['kroax_set_wi'] ."";   
$imageheight = "".$kroaxsettings['kroax_set_hi'] .""; 
$imagebytes = "150000";

	$error="";
	$photo_file = ""; $photo_thumb1 = ""; $photo_thumb2 = "";
	if (is_uploaded_file($_FILES['imagefile']['tmp_name'])) {
		$photo_types = array(".gif",".jpg",".jpeg",".png");
		$photo_pic = $_FILES['imagefile'];
		$photo_name = strtolower(substr($photo_pic['name'], 0, strrpos($photo_pic['name'], ".")));
		$photo_ext = strtolower(strrchr($photo_pic['name'],"."));
		$photo_dest = INFUSIONS."the_kroax/uploads/thumbs/"; 
		if (!preg_match("/^[-0-9A-Z_\.\[\]]+$/i", $photo_pic['name'])) {
HandleError("".$locale['KROAX434']."");
echo '<hr width="90%">'.$locale['KROAX435'].'<br>
<a href="index.php">'.$locale['KROAX431'].' </a>';
closetable();
		exit(0);
		} elseif ($photo_pic['size'] > $imagebytes){
HandleError("".$locale['KROAX436']."");
echo '<hr width="90%">'.$locale['KROAX437'].'<br>
<a href="index.php">'.$locale['KROAX431'].' </a>';
closetable();
		exit(0);
		} elseif (!in_array($photo_ext, $photo_types)) {
HandleError("".$locale['KROAX438']."");
echo '<hr width="90%">'.$locale['KROAX439'].'<br>
<a href="index.php">'.$locale['KROAX431'].' </a>';
closetable();
		exit(0);
		} else {
			$photo_file = image_exists($photo_dest, $photo_name.$photo_ext);
			move_uploaded_file($photo_pic['tmp_name'], $photo_dest.$photo_file);
			chmod($photo_dest.$photo_file, 0644);
			$imagefile = @getimagesize($photo_dest.$photo_file);
			if ($imagefile[0] > $imagewidth || $imagefile[1] > $imageheight) {
				$error = 4;
				unlink($photo_dest.$photo_file);
			} else {
				$photo_thumb1 = image_exists($photo_dest, $photo_name."_t1".$photo_ext);
				createthumbnail($imagefile[2], $photo_dest.$photo_file, $photo_dest.$photo_thumb1, $settings['thumb_w'], $settings['thumb_h']);
				if ($imagefile[0] > $settings['photo_w'] || $imagefile[1] > $settings['photo_h']) {
					$photo_thumb2 = image_exists($photo_dest, $photo_name."_t2".$photo_ext);
					createthumbnail($imagefile[2], $photo_dest.$photo_file, $photo_dest.$photo_thumb2, $settings['photo_w'], $settings['photo_h']);
				}
			}
		}
	}
//delete the fullsize image we dont want it anymore!
@unlink("".$photo_dest."".$photo_file."");
//end image upload function

//end ffmpeg 0.
}

	$titel = stripinput($_POST['titel']);
	$cat = stripinput($_POST['cat']);
	$access = stripinput($_POST['access']);
	$date = time();
	$embed = stripinput($_POST['embed']);
	$uploader = stripinput($_POST['uploader']);
	$lastplayed = stripinput($_POST['lastplayed']);
	$approval = stripinput($_POST['approval']);
	$downloads = stripinput($_POST['downloads']);
	$hits = stripinput($_POST['hits']);
	$description = stripslashes($_POST['description']);
	$errorreport = stripinput($_POST['errorreport']);


$pm_subject = "".$locale['KROAX401']."";
$pm_message = "".$locale['KROAX402']." [URL]".$settings['siteurl']."infusions/the_kroax/admin/admin.php?a_page=parked[/URL] ".$locale['KROAX403']."";
$result1 = dbquery("INSERT INTO ".$db_prefix."messages (message_id, message_to, message_from, message_subject, message_message, message_smileys, message_read, message_datestamp, message_folder) VALUES('', '1', '".$userdata['user_id']."', '$pm_subject', '$pm_message', 'n', '0', '".time()."', '0')");

$cat = stripinput($_POST['cat']);
$cat_cat = dbquery("SELECT access,title FROM ".$db_prefix."kroax_kategori WHERE title='$cat'");
$test_cat = dbarray($cat_cat);
$a_cat1= $test_cat['access'];
if($cat =="") $a_cat1="0";
$result = dbquery("INSERT INTO ".$db_prefix."kroax VALUES('', '$titel', '$cat', '0', '$a_cat1', '$date', '$embed', '$uploader', '$lastplayed', '$approval', '$upload_folder$upload_name', '$downloads', '$hits', '$description', '$photo_dest$photo_thumb1', '$errorreport')");
}

// Check for a degraded file upload, this means SWFUpload did not load and the user used the standard HTML upload , we dont bother with this atm since its only for ffmpeg.
$used_degraded = false;
if (isset($_FILES["movie_degraded"]) && is_uploaded_file($_FILES["movie_degraded"]["tmp_name"]) && $_FILES["movie_degraded"]["error"] == 0) {
   $upload_name= $_FILES["movie_degraded"]["name"];
    $used_degraded = true;
}

echo "<br>";
echo "<br>";
$catdata = dbarray(dbquery("SELECT * FROM ".$db_prefix."kroax_kategori WHERE cid='".$cat."'"));

echo "<fieldset><legend>".$locale['KROAX440']."</legend>";
echo "
		<table width='98%'>
			<tr><td>".$locale['KROAX441']." ".$titel." </td></tr>
			<tr><td>".$locale['KROAX442']." ".$upload_name." </td></tr>
			<tr><td>".$locale['KROAX443']." ".$photo_thumb1."</td></tr>
			<tr><td>".$locale['KROAX444']." ".$catdata['title']."	</td></tr>
			<tr><td>".$locale['KROAX445']." ".$description." </td></tr>
";

echo "</table></fieldset>";

if ($used_degraded) 
{
echo ' You used the standard HTML form, we have no support for that,please upgrade to atleast flash 9 version.<br>'; //We will leave this message hardcoded since it will probably change with time.
 } 

echo '<hr width="90%">'.$locale['KROAX446'].'<br>
<a href="index.php">'.$locale['KROAX447'].'</a>';
closetable();
