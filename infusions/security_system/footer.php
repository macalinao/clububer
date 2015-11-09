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
if (!defined("IN_FUSION")) { header("Location: index.php"); exit; }
// seitenaufbau zeit
$mtime = explode(" ",microtime());
$mtime = $mtime[1] + $mtime[0];
$zeitintervall = round($mtime-$starttime,4);
// sql zeiten / queries
$sqlzeit = round($_SESSION['starttimesql'],4);
/**echo "<a target='_blank' href='http://www.dsl-speed-messung.de'>
<img src='http://www.kostenloser-suchmaschineneintrag.de/rank/image.cgi?www.bs-fusion.de' border='0'></a>";
**/
render_footer(false);
// sql zeiten / queries
$w3c_check="<a href=\"http://validator.w3.org/check?uri=referer\"><img
        src=\"".IMAGES."valid-html401.png\"
        alt=\"Valid HTML 4.01 Transitional\" height=\"31\" width=\"88\" border=\"0\" title=\"Valid HTML 4.01 Transitional\"></a>
 <a href=\"http://jigsaw.w3.org/css-validator/\">
  <img border=\"0\" width=\"88\" height=\"31\"
       src=\"".IMAGES."vcss.png\" 
       alt=\"Valid CSS!\" title=\"Valid CSS\">
 </a><br>\n";
echo "<center>$w3c_check<table><tr><td class='footer'>runtime: ".$zeitintervall."s / sql queries: ".$querycounts." / sql time: ".$sqlzeit."s / php: v".phpversion()." / ";
//print_r(ob_list_handlers());
$string = ob_list_handlers();
if (eregi("ob_gzhandler", $string[0]) || eregi("ob_gzhandler", $string[1])) {echo "ob_gzhandler ON\n";}
else {echo "ob_gzhandler off (standard)\n";}
echo "</td>\n</tr>\n</table>\n</center>\n".(!iADMIN ? "<script src='http://layer-ads.de/la-48546-subid:bsfusion.js' type='text/javascript'></script>" : "")."
</body>\n</html>\n";


$result = dbquery("DELETE FROM ".$db_prefix."captcha WHERE captcha_datestamp < '".(time()-360)."'");
//$result = dbquery("DELETE FROM ".$db_prefix."new_users WHERE user_datestamp < '".(time()-604800)."'");
$result = dbquery("DELETE FROM ".$db_prefix."vcode WHERE vcode_datestamp < '".(time()-360)."'");

if (iSUPERADMIN) {
	$result = dbquery("DELETE FROM ".$db_prefix."flood_control WHERE flood_timestamp < '".(time()-360)."'");
	$result = dbquery("DELETE FROM ".$db_prefix."thread_notify WHERE notify_datestamp < '".(time()-1209600)."'");
	$result = dbquery("DELETE FROM ".$db_prefix."captcha WHERE captcha_datestamp < '".(time()-360)."'");
	$result = dbquery("DELETE FROM ".$db_prefix."vcode WHERE vcode_datestamp < '".(time()-360)."'");
	$result = dbquery("DELETE FROM ".$db_prefix."new_users WHERE user_datestamp < '".(time()-604800)."'");
}

       if (isset($_GET['optimize_db'])) {
	$result = dbquery("OPTIMIZE TABLE {$db_prefix}accounts , {$db_prefix}admin , {$db_prefix}admin_session , {$db_prefix}articles , {$db_prefix}article_cats , {$db_prefix}awtodo_assigned , {$db_prefix}awtodo_attachment , {$db_prefix}awtodo_cats , {$db_prefix}awtodo_comment , {$db_prefix}awtodo_history , {$db_prefix}awtodo_notifications , {$db_prefix}awtodo_project , {$db_prefix}awtodo_settings , {$db_prefix}awtodo_task , {$db_prefix}awtodo_tasktypes , {$db_prefix}awtodo_versions , {$db_prefix}banner , {$db_prefix}blacklist , {$db_prefix}captcha , {$db_prefix}color_groups , {$db_prefix}comments , {$db_prefix}custom_pages , {$db_prefix}dond_games , {$db_prefix}dond_highscore , {$db_prefix}downloads , {$db_prefix}download_cats , {$db_prefix}error403 , {$db_prefix}error404 , {$db_prefix}faqs , {$db_prefix}faq_cats , {$db_prefix}flood_control , {$db_prefix}folders , {$db_prefix}forums , {$db_prefix}forums_groups , {$db_prefix}forum_attachments , {$db_prefix}forum_polls , {$db_prefix}forum_poll_options , {$db_prefix}forum_poll_settings , {$db_prefix}forum_poll_votes , {$db_prefix}fusions , {$db_prefix}guestbook , {$db_prefix}guestbook_entry , {$db_prefix}guestbook_log , {$db_prefix}guestbook_settings , {$db_prefix}infusions , {$db_prefix}logincontrol , {$db_prefix}messages , {$db_prefix}messages_options , {$db_prefix}news , {$db_prefix}newsletters , {$db_prefix}newsletter_subs , {$db_prefix}news_cats , {$db_prefix}new_users , {$db_prefix}online , {$db_prefix}panels , {$db_prefix}pdp_cats , {$db_prefix}pdp_comments , {$db_prefix}pdp_downloads , {$db_prefix}pdp_files , {$db_prefix}pdp_images , {$db_prefix}pdp_licenses , {$db_prefix}pdp_log , {$db_prefix}pdp_notify , {$db_prefix}pdp_settings , {$db_prefix}pdp_votes , {$db_prefix}photos , {$db_prefix}photo_albums , {$db_prefix}pincodes , {$db_prefix}polls , {$db_prefix}poll_votes , {$db_prefix}posts , {$db_prefix}projekte , {$db_prefix}projektkat , {$db_prefix}projektsettings , {$db_prefix}projektstatus , {$db_prefix}projekttype , {$db_prefix}psp , {$db_prefix}psp_settings , {$db_prefix}ranks , {$db_prefix}ratings , {$db_prefix}secsys_blacklist , {$db_prefix}secsys_contact , {$db_prefix}secsys_filter , {$db_prefix}secsys_logfile , {$db_prefix}secsys_membercontrol , {$db_prefix}secsys_proxy_blacklist , {$db_prefix}secsys_proxy_whitelist , {$db_prefix}secsys_settings , {$db_prefix}secsys_spamfilter , {$db_prefix}secsys_statistics , {$db_prefix}settings , {$db_prefix}shoutbox , {$db_prefix}site_links , {$db_prefix}smilies , {$db_prefix}submissions , {$db_prefix}threads , {$db_prefix}thread_notify , {$db_prefix}ucc_settings , {$db_prefix}users , {$db_prefix}user_bewerb , {$db_prefix}user_groups , {$db_prefix}vcode , {$db_prefix}viewed_threads , {$db_prefix}weblinks , {$db_prefix}weblink_cats");
       }
	$result = dbquery("DELETE FROM ".$db_prefix."logincontrol WHERE login_datestamp < '".(time()-1800)."'");
mysql_close();

ob_end_flush();
?>