<?php
include INFUSIONS."seofusion/language_include.php";


	function check_inf( $infusion )
	{
	
	$title = dbarray(dbquery("SELECT inf_folder FROM ".DB_PREFIX."infusions WHERE inf_folder='".$infusion."'"));
		
		if ( $title )
		{
		return TRUE;
		} else {
		return FALSE;
		}
	
	}
	
	
	
	function seotitle( $title )
	{
		$search = array("ä", "Ä", "ü", "Ü", "ö", "Ö", "ß", "€", "RE:-");
		$replace = array("ae", "Ae", "ue", "Ue", "oe", "Oe", "ss", "euro", "" );
		$title = str_replace($search, $replace, $title);;
		$title = preg_replace("/[^\d\w]+/", "-", $title);
		$title = trim($title, "-");
		$title = strtolower($title);
		
		return $title;
	}
	
	
	
	function seodesc( $title )
    {
         $search = array("<", ">", "/", "'", "%");
         $replace = array("", "", "", "", "");
         $title = str_replace($search, $replace, $title);;

         return $title;
    }
	
	function url($k, $id, $title)			
	{
		$url = BASEDIR.$k.$id."_".seotitle($title).".html";
		return $url;
	} 


	function furl($id, $title)
	{
		$url = FORUM.$id."_".seotitle( $title ).".html";
		return $url;
		}

			function url2($id1, $title, $id2)
			{
				$url = FORUM."t".$id2."_".seotitle( $title )."_f".$id1.".html";
				return $url;
			}


			function url3($id1, $title, $id2, $pid)
			{
				$url = FORUM."t".$id2."_".seotitle( $title )."_f".$id1."_p".$pid.".html#post_".$pid;
				return $url;
			}
			
			function url31($k, $id, $title)			
			{
				$url = $k.$id."_".seotitle($title).".html";
				return $url;
			} 

function seofusion($seo) 
{
	global $db_host, $db_user, $db_pass, $db_name, $locale, $settings;
	
	
	if(!substr_count($_SERVER['REQUEST_URI'],"administration"))
	{
	
	
	dbconnect($db_host, $db_user, $db_pass, $db_name);



	function title($id, $what)
	{
		
		switch ($what) 
		{
			case "a":
			$from = "articles";
			$name = "article_subject";
			$idn  = "article_id";
			break;
			
			case "cp":
			$from = "custom_pages";
			$name = "page_title";
			$idn  = "page_id";
			break;
			
			case "ac":
			$from = "article_cats";
			$name = "article_cat_name";
			$idn  = "article_cat_id";
			break;

			case "g":
			$from = "user_groups";
			$name = "group_name";
			$idn  = "group_id";
			break;

			case "u":
			$from = "users";
			$name = "user_name";
			$idn  = "user_id";
			break;
			
			case "n":
			$from = "news";
			$name = "news_subject";
			$idn  = "news_id";
			break;
			
			case "nc":
			$from = "news_cats";
			$name = "news_cat_name";
			$idn  = "news_cat_id";
			break;
			
			case "dc":
			$from = "download_cats";
			$name = "download_cat_name";
			$idn  = "download_cat_id";
			break;

			case "qc":
			$from = "faq_cats";
			$name = "faq_cat_name";
			$idn  = "faq_cat_id";
			break;

			case "lc":
			$from = "weblink_cats";
			$name = "weblink_cat_name";
			$idn  = "weblink_cat_id";
			break;

			case "pa":
			$from = "photo_albums";
			$name = "album_title";
			$idn  = "album_id";
			break;

			case "p":
			$from = "photos";
			$name = "photo_title";
			$idn  = "photo_id";
			break;		
			
			case "f":
			$from = "forums";
			$name = "forum_name";
			$idn  = "forum_id";
			break;

			case "t":
			$from = "threads";
			$name = "thread_subject";
			$idn  = "thread_id";
			break;
			
			case "pdp_d":
			$from = "pdp_downloads";
			$name = "dl_name";
			$idn  = "download_id";
			break;
			
			case "s":
			$from = "arcade_games";
			$name = "title";
			$idn  = "lid";
			break;
			
		}
	
	$title = dbarray(dbquery("SELECT ".$name." FROM ".DB_PREFIX.$from." WHERE ".$idn."='".$id."'"));
	return (seotitle($title[$name]));
	
	}


		
	if (isset($settings['seofusion']) && $settings['seofusion']==1) 
	{



	$seo = preg_replace('#(\'|")'.BASEDIR.'articles\.php\?cat_id=([0-9]*?)(\'|")#sie',
	"BASEDIR.'ac\\2_'.title('\\2', 'ac').'.html'", $seo);

	$seo = preg_replace('#(\'|")'.BASEDIR.'viewpage\.php\?page_id=([0-9]*?)(\'|")#sie',
	"BASEDIR.'cp\\2_'.title('\\2', 'cp').'.html'", $seo);

	$seo = preg_replace('#(\'|")'.BASEDIR.'readarticle\.php\?article_id=([0-9]*?)(\'|")#sie',
	"BASEDIR.'a\\2_'.title('\\2', 'a').'.html'", $seo);

	$seo = preg_replace('#(\'|")'.BASEDIR.'profile\.php\?group_id=([0-9]*?)(\'|")#sie',
	"BASEDIR.'g\\2_'.title('\\2', 'g').'.html'", $seo);

	$seo = preg_replace('#(\'|")'.BASEDIR.'profile\.php\?lookup=([0-9]*?)(\'|")#sie',	
	"BASEDIR.'u\\2_'.title('\\2', 'u').'.html'", $seo);
	
	$seo = preg_replace('#(\'|")'.BASEDIR.'news\.php\?readmore=([0-9]*?)(\'|")#sie',
	"BASEDIR.'n\\2_'.title('\\2', 'n').'.html'", $seo);

	$seo = preg_replace('#(\'|")'.BASEDIR.'news_cats\.php\?cat_id=([0-9]*?)(\'|")#sie',
	"BASEDIR.'nc\\2_'.title('\\2', 'nc').'.html'", $seo);

	$seo = preg_replace('#(\'|")'.BASEDIR.'downloads\.php\?cat_id=([0-9]*?)(\'|")#sie',
	"BASEDIR.'dc\\2_'.title('\\2', 'dc').'.html'", $seo);
	
	$seo = preg_replace('#downloads\.php\?cat_id=([0-9]*?)(&|&amp;)download_id=([0-9]*?)(\'|")#sie',
	"'dc\\1_'.title('\\1', 'dc').'_d\\3.html\\4'", $seo);

	$seo = preg_replace('#(\'|")'.BASEDIR.'faq\.php\?cat_id=([0-9]*?)(\'|")#sie',
	"BASEDIR.'qc\\2_'.title('\\2', 'qc').'.html'", $seo);
	
	$seo = preg_replace('#(\'|")'.BASEDIR.'weblinks\.php\?cat_id=([0-9]*?)(\'|")#sie',
	"BASEDIR.'lc\\2_'.title('\\2', 'lc').'.html'", $seo);
	
	$seo = preg_replace('#weblinks\.php\?cat_id=([0-9]*?)(&|&amp;)weblink_id=([0-9]*?)(\'|")#sie',
	"'lc\\1_'.title('\\1', 'lc').'_l\\3.html\\4'", $seo);

	$seo = preg_replace('#(\'|")'.BASEDIR.'photogallery\.php\?album_id=([0-9]*?)(\'|")#sie',
	"BASEDIR.'pa\\2_'.title('\\2', 'pa').'.html'", $seo);
	
	$seo = preg_replace('#(\'|")'.BASEDIR.'photogallery\.php\?photo_id=([0-9]*?)(\'|")#sie',
	"BASEDIR.'p\\2_'.title('\\2', 'p').'.html'", $seo);
	
	$seo = preg_replace('#(\'|")'.BASEDIR.'print\.php\?type=N&amp;item_id=([0-9]*?)(\'|")#sie',
	"BASEDIR.'print.php?type=N&item_id=\\2&'.title('\\2', 'n').'\\3'", $seo);

	$seo = preg_replace('#(\'|")'.BASEDIR.'print\.php\?type=A&amp;item_id=([0-9]*?)(\'|")#sie',
	"BASEDIR.'print.php?type=A&item_id=\\2&'.title('\\2', 'a').'\\3'", $seo);

	$seo = preg_replace('#viewforum\.php\?forum_id=([0-9]*?)(\'|")#sie',
	"'\\1_'.title('\\1', 'f').'.html\\2'", $seo);

	$seo = preg_replace('#viewthread\.php\?forum_id=([0-9]*?)(&|&amp;)thread_id=([0-9]*?)(&|&amp;)pid=([0-9]*?)\#post_([0-9]*?)(\'|")#sie',
	"'t\\3_'.title('\\3', 't').'_f\\1_p\\5.html#post_\\6\\7'", $seo);

	$seo = preg_replace('#viewthread\.php\?forum_id=([0-9]*?)(&|&amp;)thread_id=([0-9]*?)(\'|")#sie',
	"'t\\3_'.title('\\3', 't').'_f\\1.html\\4'", $seo);
 
 	$seo = preg_replace('#viewthread\.php\?forum_id=([0-9]*?)(&|&amp;)thread_id=([0-9]*?)(&|&amp;)rowstart=([0-9]*?)(\'|")#sie',
	"'t\\3_'.title('\\3', 't').'_f\\1_r\\5.html\\6'", $seo);
	
	$seo = preg_replace("#(\"|')".BASEDIR."contact\.php(\"|')#si",
 	BASEDIR.$locale['SEO60'].".html", $seo);
	
	$seo = preg_replace("#(\"|')".BASEDIR."register\.php(\"|')#si",
 	BASEDIR.$locale['SEO61'].".html", $seo);
					
	$seo = preg_replace("#(\"|')".BASEDIR."edit_profile\.php(\"|')#si",
 	BASEDIR.$locale['SEO62'].".html", $seo);
	
	$seo = preg_replace("#(\"|')".BASEDIR."articles\.php(\"|')#si",
 	BASEDIR.$locale['SEO63'].".html", $seo);
	
	$seo = preg_replace("#(\"|')".BASEDIR."downloads\.php(\"|')#si",
	BASEDIR.$locale['SEO64'].".html", $seo);
	
	$seo = preg_replace("#(\"|')".BASEDIR."search\.php(\"|')#si",
	BASEDIR.$locale['SEO71'].".html", $seo);
	
	$seo = preg_replace("#(\"|')".BASEDIR."faq\.php(\"|')#si",
 	BASEDIR.$locale['SEO65'].".html", $seo);
					
	$seo = preg_replace("#(\"|')".BASEDIR."weblinks\.php(\"|')#si",
	BASEDIR.$locale['SEO66'].".html", $seo);
	
	$seo = preg_replace("#(\"|')".BASEDIR."photogallery\.php(\"|')#si",
 	BASEDIR.$locale['SEO67'].".html", $seo);
	
	$seo = preg_replace("#(\"|')".BASEDIR."news_cats\.php(\"|')#si",
 	BASEDIR.$locale['SEO68'].".html", $seo);
	
	$seo = preg_replace('#(\'|")'.BASEDIR.'news\.php\?rowstart=([0-9]*?)(\'|")#sie',
	"'\\1'.BASEDIR.$locale[SEO75].'_\\2.html\\3'", $seo);
	
	$seo = preg_replace("#(\"|')".BASEDIR."news\.php(\"|')#si",
 	BASEDIR.$locale['SEO75'].".html", $seo);
	
	$seo = preg_replace("#(\"|')".BASEDIR."lostpassword\.php(\"|')#si",
	BASEDIR.$locale['SEO69'].".html", $seo);
	
	$seo = preg_replace("#(\"|')".BASEDIR."sitemap\.php(\"|')#si",
 	BASEDIR.$locale['SEO70'].".html", $seo);
	
	$seo = preg_replace("#(\"|')".BASEDIR."members\.php(\"|')#si",
 	BASEDIR.$locale['SEO72'].".html", $seo);
	
	$seo = preg_replace("#(\"|')".BASEDIR."messages\.php(\"|')#si",
	BASEDIR.$locale['SEO79'].".html", $seo);
	
	$seo = preg_replace("#submit\.php\?stype=l#si",
 	BASEDIR.$locale['SEO73']."_".$locale['SEO77'].".html", $seo);
	
	$seo = preg_replace("#submit\.php\?stype=n#si",
 	BASEDIR.$locale['SEO73']."_".$locale['SEO75'].".html", $seo);
	
	$seo = preg_replace("#submit\.php\?stype=a#si",
 	BASEDIR.$locale['SEO73']."_".$locale['SEO74'].".html", $seo);
	
	$seo = preg_replace("#submit\.php\?stype=p#si",
	BASEDIR.$locale['SEO73']."_".$locale['SEO76'].".html", $seo);
	

######INFUSIONS######

##pro_download_panel
if ( check_inf ("pro_download_panel"))
{

	function pdp_dc($id) 
	{
		if ( $id != "0" )
		{
			$title = dbarray(dbquery("SELECT cat_name FROM ".DB_PREFIX."pdp_cats WHERE cat_id='$id'"));
			return "dc".$id."_".(seotitle($title['cat_name']));
		} else {
			return "downloads";
		}
		
	}
	
	$seo = preg_replace('#profile\.php\?id=([0-9]*?)(\'|")#sie',
	"'u\\1_'.title('\\1', 'u').'_uploads.html\\2'", $seo);

	$seo = preg_replace('#download\.php\?catid=([0-9]*?)(\'|")#sie',
	"pdp_dc('\\1').'.html\\2'", $seo);
 
	$seo = preg_replace('#download\.php\?did=([0-9]*?)(\'|")#sie',
	"'d\\1_'.title('\\1','pdp_d').'.html\\2'", $seo);

}

##arcade
	if (check_inf("varcade")) {
		$seo = preg_replace('#games\.php\?game_id=([0-9]*?)#sie',
		"'s\\1_'.title('\\1', 's').'.html'", $seo);
	}
}
}
	return $seo;
}
		add_handler("seofusion");
		

?>