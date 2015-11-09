<?php
/*---------------------------------------------------+
| PHP-Fusion 6 Content Management System
+----------------------------------------------------+
| Copyright © 2002 - 2006 Nick Jones
| http://www.php-fusion.co.uk/
+----------------------------------------------------+
| Released under the terms & conditions of v2 of the
| GNU General Public License. For details refer to
| the included gpl.txt file or visit http://gnu.org
+----------------------------------------------------*/
require_once "../../../maincore.php";
require_once THEME."theme.php";

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."sf_gift_system/locale/".LOCALESET."/brows_gifts.php")) {
	// Load the locale file matching the current site locale setting.
	include INFUSIONS."sf_gift_system/locale/".LOCALESET."/brows_gifts.php";
} else {
	// Load the infusion's default locale file.
	include INFUSIONS."sf_gift_system/locale/English/brows_gifts.php";
}

if (isset($souldout)) {
	// load the image from the file specified:
	$im = imagecreatefrompng(BASEDIR."infusions/sf_gift_system/images/".$souldout."");
	// if there's an error, stop processing the page:
	if(!$im) {
		die("");
	}
	 
	// define some colours to use with the image
	$yellow = imagecolorallocate($im, 0, 0, 0);
	$black = imagecolorallocate($im, 204, 204, 204);
	 
	// get the width and the height of the image
	$width = imagesx($im);
	$height = imagesy($im);
	imagesavealpha($im, true);
	 
	$trans_colour = imagecolorallocatealpha($im, 255, 255, 255, 127);
	imagefilledrectangle($im,0,0,$width,$height,$trans_colour);
	 
	// draw a black rectangle across the bottom, say, 20 pixels of the image:
	//imagefilledrectangle($im, 0, ($height-12) , $width, $height, $black);
	 
	// now we want to write in the centre of the rectangle:
	$font = 5; // store the int ID of the system font we're using in $font
	$text = "Sould"; // store the text we're going to write in $text
	$text2 = "Out"; // store the text we're going to write in $text
	// calculate the left position of the text:
	$leftTextPos = ( $width - imagefontwidth($font)*strlen($text) )/2;
	$leftTextPos2 = ( $width - imagefontwidth($font)*strlen($text2) )/2;
	// finally, write the string:
	imagestring($im, $font, $leftTextPos, $height-50, $text, $yellow);
	imagestring($im, $font, $leftTextPos2, $height-30, $text2, $yellow);
	 
	// output the image
	// tell the browser what we're sending it
	Header("Content-type: image/png");
	// output the image as a png
	imagepng($im);
	 
	// tidy up
	imagedestroy($im);
	
} else if (isset($buy)) {
	// load the image from the file specified:
	$im = imagecreatefrompng(BASEDIR."infusions/sf_gift_system/buy.png");
	// if there's an error, stop processing the page:
	if(!$im) {
		die("");
	}
	 
	// define some colours to use with the image
	$yellow = imagecolorallocate($im, 255,255, 255);
	$black = imagecolorallocate($im, 204, 204, 204);
	 
	// get the width and the height of the image
	$width = imagesx($im);
	$height = imagesy($im);
	imagesavealpha($im, true);
	 
	$trans_colour = imagecolorallocatealpha($im, 255, 255, 255, 127);
	imagefilledrectangle($im,0,0,$width,$height,$trans_colour);
	 
	// draw a black rectangle across the bottom, say, 20 pixels of the image:
	//imagefilledrectangle($im, 0, ($height-12) , $width, $height, $black);
	 
	// now we want to write in the centre of the rectangle:
	$font = 3; // store the int ID of the system font we're using in $font
	$text = "    Gi Gave"; // store the text we're going to write in $text
	// calculate the left position of the text:
	$leftTextPos = ( $width - imagefontwidth($font)*strlen($text) )/2;
	// finally, write the string:
	imagestring($im, $font, $leftTextPos, $height-17, $text, $yellow);
	 
	// output the image
	// tell the browser what we're sending it
	Header("Content-type: image/png");
	// output the image as a png
	imagepng($im);
	 
	// tidy up
	imagedestroy($im);
}
?>
