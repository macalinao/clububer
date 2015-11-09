<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD>
<META http-equiv=Content-Type content="text/html; charset=windows-1252"></HEAD>
<BODY><PRE>
<?php
require_once "../../maincore.php";
Header("content-type: application/x-javascript");
$pathstring=pathinfo($_SERVER['PHP_SELF']);
$locationstring="http://" . $_SERVER['HTTP_HOST'].$pathstring['dirname'] . "/";

function returnimages($dirname=".") {
	 $pattern="(\.jpg$)|(\.png$)|(\.jpeg$)|(\.gif$)";
   $files = array();
	 $curimage=0;
   if($handle = opendir($dirname)) {
       while(false !== ($file = readdir($handle))){
               if(eregi($pattern, $file)){
			   $result = dbquery("SELECT * FROM ".$db_prefix."sf_gift WHERE gift_image=''");
			   if (dbrows($result) == 0)

				{
                     echo 'picsarray[' . $curimage .']="' . $file . '";';
                     $curimage++;
				}
               }
       }

       closedir($handle);
   }
   return($files);
}

echo 'var locationstring="' . $locationstring . '";';
echo 'var picsarray=new Array();';
returnimages()
?>
 </PRE></BODY></HTML>
