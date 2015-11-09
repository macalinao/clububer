<?php
if (eregi(basename(__FILE__), $_SERVER['PHP_SELF'])) die();
####basedir####
##articles.php
if (isNum(FUSION_SELF == 'articles.php'))
{
	if (isset($cat_id))
	{
		$result = dbquery("SELECT article_cat_name, article_cat_description FROM ".$db_prefix."article_cats WHERE article_cat_id='$cat_id'");
		$data = dbarray($result);
    	$title = $data['article_cat_name']." - ".$locale['SEO1'];
		$desc = $data['article_cat_name']." - ".substr($data['article_cat_description'], 0, 150);
		$keys = $data['article_cat_name'].", ".$locale['SEO1'];
	} 
	else
	{
    	$title = $locale['SEO1'];
		$desc = $locale['SEO2']." - ".$settings['sitename'];
		$keys = $locale['SEO1'];
	}
}
##contact.php
elseif (isNum(FUSION_SELF == 'contact.php'))
{
		$title = $locale['SEO3'];
		$desc = $locale['SEO4'];
		$keys = $locale['SEO3'];
}
##downloads.php
elseif (isNum(BASEDIR.FUSION_SELF == 'downloads.php'))
{
	if (isset($cat_id))
	{
		$result = dbquery("SELECT download_cat_name, download_cat_description FROM ".$db_prefix."download_cats WHERE download_cat_id='$cat_id'");
		$data = dbarray($result);
    	$title = $data['download_cat_name']." - ".$locale['SEO5'];
		$desc = $data['download_cat_name']." - ".substr($data['download_cat_description'], 0, 150);
		$keys = $data['download_cat_name'].", ".$locale['SEO5'];
	}
	else
	{
 	   $title = $locale['SEO5'];
		$desc = $locale['SEO6'];
		$keys = $locale['SEO5'];
	}	
}
##edit_profile.php
elseif (isNum(FUSION_SELF == 'edit_profile.php'))
{
		$title = $locale['SEO7'];
		$desc = $locale['SEO8'];
		$keys = $locale['SEO7'];
}
##faq.php
elseif (isNum(FUSION_SELF == 'faq.php'))
{
	if (isset($cat_id))
	{
		$result = dbquery("SELECT faq_cat_name, faq_cat_description FROM ".$db_prefix."faq_cats WHERE faq_cat_id='$cat_id'");
		$data = dbarray($result);
    	$title = $data['faq_cat_name']." - ".$locale['SEO9'];
   	 $desc = $data['faq_cat_name']." - ".substr($data['faq_cat_description'], 0, 150);
		$keys = $data['faq_cat_name'].", ".$locale['SEO9'];
	}
	else
	{
   		$title = $locale['SEO9'];
		$desc = $locale['SEO10'];
		$keys = $locale['SEO9'];
	}
}
##login.php
elseif (isNum(FUSION_SELF == 'login.php'))
{
		$title = $locale['SEO11'];
		$desc = $locale['SEO12'];
		$keys = $locale['SEO11'];
	
}
##lostpassword.php
elseif (isNum(FUSION_SELF == 'lostpassword.php'))
{
		$title = $locale['SEO13'];
		$desc = $locale['SEO14'];
		$keys = $locale['SEO13'];
}
##members.php
elseif (isNum(FUSION_SELF == 'members.php'))
{
		$title = $locale['SEO15'];
		$desc = $locale['SEO16'];
		$keys = $locale['SEO15'];
}
##messages.php
elseif (isNum(FUSION_SELF == 'messages.php'))
{
		$title = $locale['SEO17'];
		$desc = $locale['SEO18'];
		$keys = $locale['SEO17'];
}
##news.php
elseif (isNum(FUSION_SELF == 'news.php'))
{
	if (isset($readmore))
	{
		$result = dbquery("SELECT news_subject, news_news FROM ".$db_prefix."news WHERE news_id='$readmore'");
		$data = dbarray($result);
    	$title = $data['news_subject']." - ".$locale['SEO19'];
    	$desc = $data['news_subject']." - ".substr($data['news_news'], 0, 150)." - ".$locale['SEO20'];
		$keys = $data['news_subject'].", ".$locale['SEO19'];
		
	} else {
	
		$title = $locale['SEO19'];
		$desc = $locale['SEO20'];
		$keys = $locale['SEO19'];
	}
	
}
##news_cats.php
elseif (isNum(FUSION_SELF == 'news_cats.php'))
{

	if (isset($cat_id))
	{
		$result = dbquery("SELECT news_cat_name FROM ".$db_prefix."news_cats WHERE news_cat_id='$cat_id'");
		$data = dbarray($result);
    	$title = $data['news_cat_name']." - ".$locale['SEO19'];
    	$desc = $data['news_cat_name']." - ".$locale['SEO20'];
		$keys = $data['news_cat_name'].", ".$locale['SEO19'];
	
	} else {
	
		$title = $locale['SEO19'];
		$desc = $locale['SEO20'];
		$keys = $locale['SEO19'];
	}
}
##photogallery.php
elseif (isNum(FUSION_SELF == 'photogallery.php'))
{
	if (isset($album_id))
	{
		$result = dbquery("SELECT album_description, album_thumb, album_title FROM ".$db_prefix."photo_albums WHERE album_id='$album_id'");
		$data = dbarray($result);
   		$title = $data['album_title']." - ".$locale['SEO21'];
    	$desc = $data['album_title']." - ".substr($data['album_description'], 0, 150);
		$keys = $data['album_title'].", ".$locale['SEO21'].", ".$data['album_thumb'];
	}
	elseif (isset($photo_id))
	{
		$result = dbquery("SELECT photo_title, photo_filename, photo_description FROM ".$db_prefix."photos WHERE photo_id='$photo_id'");
		$data = dbarray($result);
    	$title = $data['photo_title']." - ".$locale['SEO21'];
    	$desc = $data['photo_title']." - ".substr($data['photo_description'], 0, 150);
		$keys = $data['photo_title'].", ".$locale['SEO21'].", ".$data['photo_filename'];
	}
	else
	{
    	$title = $locale['SEO21'];
		$desc = $locale['SEO22'];
		$keys = $locale['SEO21'];
	}
}
##profile.php
elseif (isNum(FUSION_SELF == 'profile.php'))
{
	if (isset($group_id))
	{
   		$result = dbquery("SELECT group_name, group_description FROM ".$db_prefix."user_groups WHERE group_id='$group_id'");
    	$data = dbarray($result);
    	$title = $data['group_name']." - ".$locale['SEO23'];
		$desc = $data['group_name']." - ".substr($data['group_description'], 0, 150);
		$keys = $data['group_name'].", ".$locale['SEO23'];
	} 
	elseif (isset($lookup))
	{
   		$result = dbquery("SELECT * FROM ".$db_prefix."users WHERE user_id='$lookup'");
    	$data = dbarray($result);
    	$title = $data['user_name']." - ".$locale['SEO24'];
		$desc = $data['user_name']." - ".$locale['SEO25'];
    	$keys = $data['user_name'].", ".$locale['SEO24'];
	}
}
##readarticle.php
elseif (isNum(FUSION_SELF == 'readarticle.php'))
{
	if (isset($article_id))
	{
		$result = dbquery("SELECT article_subject, article_snippet FROM ".$db_prefix."articles WHERE article_id='$article_id'");
    	$data = dbarray($result);
    	$title = $data['article_subject']." - ".$locale['SEO1'];
    	$desc = $data['article_subject']." - ".substr($data['article_snippet'], 0, 150);
		$keys = $data['article_subject'].", ".$locale['SEO1'];
	}
}
##register.php
elseif (isNum(FUSION_SELF == 'register.php'))
{
		$title = $locale['SEO26'];
		$desc = $locale['SEO27'];
		$keys = $locale['SEO26'];
}
##search.php
elseif (isNum(FUSION_SELF == 'search.php'))
{
		$title = $locale['SEO28'];
		$desc = $locale['SEO29'];
		$keys = $locale['SEO28'];
}
##subtmit.php
elseif (isNum(FUSION_SELF == 'submit.php'))
{
	if ($stype == "n")
	{
		$title = $locale['SEO30'];
		$desc = $locale['SEO31'];
		$keys = $locale['SEO30'];
	} 
	elseif ($stype == "a")
	{
		$title = $locale['SEO32'];
		$desc = $locale['SEO33'];
		$keys = $locale['SEO32'];
	}	
	elseif ($stype == "l")
	{
		$title = $locale['SEO34'];
		$desc = $locale['SEO35'];
		$keys = $locale['SEO34'];
	}
	elseif ($stype == "p")
	{
		$title = $locale['SEO36'];
		$desc = $locale['SEO37'];
		$keys = $locale['SEO36'];
	}
}
##viewpage.php
elseif (isNum(FUSION_SELF == 'viewpage.php'))
{
	if (isset($page_id))
	{
		$result = dbquery("SELECT page_title, page_content FROM ".$db_prefix."custom_pages WHERE page_id='$page_id'");
    	$data = dbarray($result);
    	$title = $data['page_title'];
    	$desc = $data['page_title']." - ".substr($data['page_content'], 0, 150);
		$keys = $data['page_title'];
	}
}
##weblinks.php
elseif (isNum(FUSION_SELF == 'weblinks.php'))
{
	if (isset($cat_id))
	{
		$result = dbquery("SELECT weblink_cat_name, weblink_cat_description FROM ".$db_prefix."weblink_cats WHERE weblink_cat_id='$cat_id'");
		$data = dbarray($result);
    	$title = $data['weblink_cat_name']." - ".$locale['SEO38'];
   	 	$desc = $data['weblink_cat_name']." - ".substr($data['weblink_cat_description'], 0, 150);
		$keys = $data['weblink_cat_name'].", ".$locale['SEO38'];
	}
	else
	{
   		$title = $locale['SEO38'];
		$desc = $locale['SEO39'];
		$keys = $locale['SEO38'];
	}
}

##forum/index.php
elseif (stristr($_SERVER['REQUEST_URI'],'/forum/index.php'))
{
		$title = $locale['SEO40'];
    	$desc = $locale['SEO40']." - ".$settings['sitename']." - ".$settings['description'];
		$keys = $locale['SEO40'];
}
##viewforum.php
elseif (isNum(FUSION_SELF == 'viewforum.php'))
{
	if (isset($forum_id))
	{
    	$result = dbquery("SELECT forum_name, forum_description FROM ".$db_prefix."forums WHERE forum_id='$forum_id'");
    	$data = dbarray($result);
    	$title = $data['forum_name']." - ".$locale['SEO40'];
		$desc  = $data['forum_name']." - ".substr($data['forum_description'], 0, 150);
		$keys = $data['forum_name'].", ".$locale['SEO40'];
	}
}
##viewthread.php
elseif (isNum(FUSION_SELF == 'viewthread.php'))
{

    	$result1 = dbquery("SELECT thread_subject FROM ".$db_prefix."threads WHERE thread_id='$thread_id'");
    	$data1 = dbarray($result1);

    	$result2 = dbquery("SELECT forum_name FROM ".$db_prefix."forums WHERE forum_id='$forum_id'");
    	$data2 = dbarray($result2);
	 
    	$title = $data1['thread_subject']." - ".$locale['SEO40'];
		$desc = $data1['thread_subject']." - ".$data2['forum_name'];
		$keys = $data1['thread_subject'].", ".$data2['forum_name'].", ".$locale['SEO40'];
}


######INFUSIONS######

##pro_download_panel
if ( check_inf ("pro_download_panel"))
{

	if (isNum(FUSION_SELF == 'download.php'))
	{
		if (isset($did))
		{
			$result = dbquery("SELECT dl_name, dl_abstract, dl_desc FROM ".$db_prefix."pdp_downloads WHERE download_id='$did'");
			$data = dbarray($result);
   			$title = $data['dl_name'];
   			$desc = $data['dl_name']." - ".substr($data['dl_desc'], 0, 150);
			$keys = $data['dl_name'].", ".$locale['SEO5'];
		}
		elseif (isset($catid))
		{
			$result = dbquery("SELECT cat_name, cat_desc FROM ".$db_prefix."pdp_cats WHERE cat_id='$catid'");
			$data = dbarray($result);
				if ($catid == "0" )
				{
			$title = $locale['SEO81'];
				} else {
    		$title = $data['cat_name'];
				}
    		$desc = $data['cat_name']." - ".substr($data['cat_desc'], 0, 150);
			$keys = $data['cat_name'].", ".$locale['SEO5'];
		}
		else
		{
   			$title = $locale['SEO5'];
			$desc = $locale['SEO5'];
			$keys = $locale['SEO5'];
		}
		
	} 
	elseif (isNum(FUSION_SELF == 'profile.php'))
	{
	
		if (isset($id))
		{
	   		$result = dbquery("SELECT * FROM ".$db_prefix."users WHERE user_id='$id'");
    		$data = dbarray($result);
    		$title = $locale['SEO82']." ".$data['user_name'];
			$desc = $locale['SEO82']." ".$data['user_name'];
    		$keys = $locale['SEO82']." ".$data['user_name'];
		}
		
	}
}
?>
