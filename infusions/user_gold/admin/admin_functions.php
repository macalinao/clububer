<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| User Gold 3
| Copyright © 2007 - 2008 UG3 Developement Team
| http://www.starglowone.com/
+--------------------------------------------------------+
| Filename: admin_functions.php
| Author: UG3 Developement Team
+--------------------------------------------------------+
| This program is released as free software under the
| Stars Heaven Licence. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included licence.html.
| Removal of this copyright header is strictly
| prohibited without written permission
| from the original author(s).
+--------------------------------------------------------*/
if (!defined("IN_FUSION")) { die("Access Denied"); }

/*	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~	*/
function admin_menu(){
global $locale, $aidlink;
opentable($locale['urg_a_global_100']); //Gold administration menu
echo "<div align='center' class='caps-main'>\n"; //Gold administration menu
echo "<a href='".FUSION_SELF.$aidlink."&amp;op=main'><strong>".$locale['urg_a_global_113']."</strong></a>  |  \n";
echo "<a href='".FUSION_SELF.$aidlink."&amp;op=useage'><strong>".$locale['urg_a_global_102']."</strong></a>  |  \n";
echo "<a href='".FUSION_SELF.$aidlink."&amp;op=config'><strong>".$locale['urg_a_global_103']."</strong></a>  |  \n";
echo "<a href='".FUSION_SELF.$aidlink."&amp;op=inventory'><strong>".$locale['urg_a_global_104']."</strong></a>  |  \n";
echo "<a href='".FUSION_SELF.$aidlink."&amp;op=images'><strong>".$locale['urg_a_global_109']."</strong></a>  |  \n";
echo "<a href='".FUSION_SELF.$aidlink."&amp;op=deluserquestion'><strong>".$locale['urg_a_global_107']."</strong></a>\n";
echo "<a href='".FUSION_SELF.$aidlink."&amp;op=about'><strong>".$locale['urg_a_global_108']."</strong></a>\n";
echo "</div>\n";
closetable();

}

/*	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~	*/
function gold_admin_main(){ //Gold administration entry view
	global $locale, $aidlink;
	
	include GOLD_INC."version_checker/version_checker.php";
	
	opentable($locale['urg_a_global_100'],'');
	echo "<div align='left' style='float: left; width: 50%;'>\n";
	echo $locale['urg_a_global_105'];
	/*if (gold_table_exists(DB_PREFIX."users_points")) {//Check if usergold 2 is installed or not
		$rows = dbcount("(*)", DB_UG3);
		if ($rows < 2) { 
			echo "<br /><br />".$locale['urg_a_global_110']."<a href='install.php".$aidlink."'><strong>".$locale['urg_a_global_111']."</strong></a>".$locale['urg_a_global_112'];
		}
	}*/
	echo "</div><div align='right' style='float: right; width: 50%;'>\n";
	echo checkversion(GOLD_VERSION);
	echo "</div><div style='clear:both;'></div>\n";
	closetable();
}

/*	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~	*/
function MakeCode($title, $page, $width='200', $height='200'){ //make code popup
global $locale;
	echo '<a style="cursor:help;" href="javascript:void window.open(\'makecode.php?title='.$title.'&op='.$page.'\',\'\',\'width='.$width.',height='.$height.'\');"><img alt="'.$locale['urg_a_global_106'].'" src="../images/help.png" style="border: 0;" /></a>';
}

/*	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~	*/
function ug_adminhelp($title, $page, $width, $height){ //Help popup in admin
global $locale;
$title = str_replace(" ", "%20", $title);
		echo '<a href="javascript:void(window.open(\''.INFUSIONS.'user_gold/admin/help.php?title='.$title.'&amp;op='.$page.'\',\'\',\'width='.$width.'\',\'height='.$height.'\'));" style="cursor:help;"><img src="'.INFUSIONS.'user_gold/images/help.png"  style="border: 0;" title="'.$locale['urg_a_global_106'].'" alt="'.$locale['urg_a_global_106'].'" /></a>';
}

/*	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~	*/
?>