<?php

###pro_download_panel
//if (isset($settings['seofusion']) && $settings['seofusion']==1) {

	function pdpdcn($id) 
	{
		if ( $id != "0" )
		{
			$title = dbarray(dbquery("SELECT cat_name FROM ".DB_PREFIX."pdp_cats WHERE cat_id='$id'"));
			return "dc".$id."_".(seotitle($title['cat_name']));
		} else {
			return "downloads";
		}
	}

	function pdpdln($id) 
	{
	$title = dbarray(dbquery("SELECT dl_name FROM ".DB_PREFIX."pdp_downloads WHERE download_id='$id'"));
	return (seotitle($title['dl_name']));
	}

	$seo = preg_replace('#profile\.php\?id=([0-9]*?)(\'|")#sie',
	"'u\\1_'.un('\\1').'_uploads.html\\2'", $seo);

	$seo = preg_replace('#download\.php\?catid=([0-9]*?)(\'|")#sie',
	"pdpdcn('\\1').'.html\\2'", $seo);
 
	$seo = preg_replace('#download\.php\?did=([0-9]*?)(\'|")#sie',
	"'d\\1_'.pdpdln('\\1').'.html\\2'", $seo);
	
//} 


?>