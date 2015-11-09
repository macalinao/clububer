<?php
/*----------------------------------------------+
| SECURITY SYSTEM V1 FÜR PHP-FUSION             |
| copyright (c) 2006 by BS-Fusion Deutschland   |
| Email-Support: webmaster[at]bs-fusion.de      |
| Homepage: http://www.bs-fusion.de             |
| Inhaber: Manuel Kurz                          |
+----------------------------------------------*/
if (eregi("main_control.php", $_SERVER['PHP_SELF'])) die();
error_reporting(0);
if(!defined("COOKIE_PREFIX")) define("COOKIE_PREFIX","fusion_");
if (isset($_COOKIE[COOKIE_PREFIX.'user'])) {
        $sec_cookie_vars = explode(".", secsys_safecookie($_COOKIE[COOKIE_PREFIX.'user']));
        $sec_cookie_1 = isNum($sec_cookie_vars['0']) ? $sec_cookie_vars['0'] : "0";
        $sec_cookie_2 = (preg_match("/^[0-9a-z]{32}$/", $sec_cookie_vars['1']) ? $sec_cookie_vars['1'] : "");
        $sec_cookie_3 = (preg_match("/^[0-9a-z]{32}$/", $sec_cookie_vars['1']) ? md5($sec_cookie_vars['1']) : "");
        $sec_result = dbquery("SELECT * FROM ".DB_PREFIX."users WHERE (user_id='$sec_cookie_1' AND user_password='$sec_cookie_2') OR (user_id='$sec_cookie_1' AND user_password='$sec_cookie_3') ");
        unset($sec_cookie_vars,$sec_cookie_1,$sec_cookie_2,$sec_cookie_3);
        if (dbrows($sec_result) != 0) {
                $sysdata = dbarray($sec_result);
        } else {
		setcookie(COOKIE_PREFIX."user","",time()-7200,"","/","0");	
		setcookie(COOKIE_PREFIX."lastvisit","",time()-7200,"","/","0");
		}
} else {
        $sysdata = "";  $sysdata['user_level'] = 0; $sysdata['user_rights'] = ""; $sysdata['user_groups'] = ""; $sysdata['user_id']="0";
}

function secsys_safecookie($cookie_value="") {
$found = array("&","/","!","$","%","\"","'","(",")","{","}","[","]","$","*",'"','\'',"<",">","\\","^","\$");	
$value=str_replace($found,"",$cookie_value);
return $value;
}

define("TRUE_REFERER",!isset($_SERVER['HTTP_REFERER']) || (isset($_SERVER['HTTP_REFERER']) && (!eregi(",http",$_SERVER['HTTP_REFERER']) || !eregi(",ftp",$_SERVER['HTTP_REFERER']))) ? TRUE : FALSE);
define("iSYS_SUPERADMIN",!empty($sysdata) && $sysdata['user_level'] == 103 ? 1 : 0);
define("SYS_FUSION_QUERY", isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : "");
define("SYS_USER_IP",isset($_SERVER['REMOTE_ADDR']) ? stripinput($_SERVER['REMOTE_ADDR']) : "");
define("SYS_USER_AGENT",isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : "");
define("SYS_USER_REFERER",isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "");
define("SYS_SERVER_NAME",isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : "");
define("SYS_USER_HOST",isset($_SERVER["REMOTE_HOST"]) ? $_SERVER["REMOTE_HOST"] : SYS_USER_IP);
define("SYS_LANG",$settings['locale']);
define("SYS_USER_ID",(isset($sysdata['user_id']) && isNum($sysdata['user_id'])) ? $sysdata['user_id'] : "0");
define("iSYS_GUEST",!empty($sysdata) && $sysdata['user_level'] == 0 ? 1 : 0);
define("iSYS_MEMBER", !empty($sysdata) && $sysdata['user_level'] >= 101 ? 1 : 0);
define("iSYS_ADMIN", !empty($sysdata) && $sysdata['user_level'] >= 102 ? 1 : 0);
define("iSYS_USER", !empty($sysdata) && $sysdata['user_level']);
define("iSYS_USER_RIGHTS", !empty($sysdata) && isset($sysdata['user_rights']) ? $sysdata['user_rights'] : "");
define("iSYS_USER_GROUPS", !empty($sysdata) && isset($sysdata['user_groups']) ? substr($sysdata['user_groups'], 1) : "");

$sys_forum_id=(isset($_GET['forum_id']) && isNum($_GET['forum_id']) ? $_GET['forum_id']: "");
if (!empty($sys_forum_id)) {
          $sys_forum_result = dbquery(
        "SELECT f.*, f2.forum_name AS forum_cat_name
        FROM ".DB_PREFIX."forums f
        LEFT OUTER JOIN ".DB_PREFIX."forums f2 ON f.forum_cat=f2.forum_id
        WHERE f.forum_id='".$sys_forum_id."'"
);

if (dbrows($sys_forum_result)) {
	if (function_exists("view_forum_mods")) {
	define("iSYSMOD",view_forum_mods($sys_forum_id, true));	
	} else {
    $sys_fdata = dbarray($sys_forum_result);
	$sys_forum_mods = explode(".", $sys_fdata['forum_moderators']);
		if (iSYS_ADMIN) {define("iSYSMOD",1);}
		elseif (!iSYS_ADMIN && in_array($sysdata['user_id'], $sys_forum_mods)) { define("iSYSMOD", 1); } 
		else { define("iSYSMOD",0); }
	}
}
else {
if (iSYS_ADMIN) {define("iSYSMOD",1);} else {
define("iSYSMOD",0);} 
}
} else {
if (iSYS_ADMIN) {define("iSYSMOD",1);} else {
define("iSYSMOD",0);} 
}
define("SEC_INFDIR",INFUSIONS."security_system/");

function check_infusion($inf_pan) {
$rsl_inf=dbrows(dbquery("SELECT * FROM ".DB_PREFIX."infusions WHERE inf_folder='$inf_pan'"));
if ($rsl_inf!=0) {
  return true;
} else {return false;}
}

// Check if user is assigned to the specified user group
function checksysgroup($group) {
        if (iSYS_SUPERADMIN) { return true; }
        elseif (iSYS_ADMIN && ($group == "0" || $group == "101" || $group == "102")) { return true; }
        elseif (iSYS_MEMBER && ($group == "0" || $group == "101")) { return true; }
        elseif (iSYS_GUEST && $group == "0") { return true; }
        elseif (iSYS_USER_GROUPS!="" && iSYS_MEMBER && in_array($group, explode(".", iSYS_USER_GROUPS))) {
                return true;
        } else {
                return false;
        }
}

if (!function_exists("fallback")) {
	function fallback($url) {
	header("location:".$url);exit;
	}
}
$sys_setting=array();
if (check_infusion("security_system")) {

if (file_exists(INFUSIONS . "security_system/locale/".$settings['locale'].".php")) {
        include INFUSIONS . "security_system/locale/".$settings['locale'].".php";
}
else {
         include INFUSIONS . "security_system/locale/German.php";
}


$sys_setting = dbarray(dbquery("SELECT * from ".DB_PREFIX."secsys_settings"));
if (!isset($sys_setting['secsys_started'])) {
	$sys_setting['secsys_started']=1;
}
if ($sys_setting['license_accept']>0 && $sys_setting['secsys_started']==1) {

// function fixed in v 1.8.4
function secsys_hacker() {
global $sys_setting,$db_prefix;	
$hack = false;
if (isset($_GET['stext']) && strlen($_GET['stext'])<= 255 || isset($_GET['user']) && strlen($_GET['user'])<= 255) {$hack=false;}
else {
// Prevent any possible XSS attacks via $_GET.
$array=array("\"","'","<",">","*","/","$","\\","(","[","]",")","NULL","%00","?","_SERVER","from%20".$db_prefix,"from ".$db_prefix,"from+".$db_prefix);
foreach ($_GET as $query_checker) {
$hack_string = str_replace(explode(",",$array),"*",$query_checker);
}
if ($query_checker!=$hack_string) $hack=true;
if (isset($_SERVER['QUERY_STRING'])) {
$check_query = str_replace($array,"*",strtolower($_SERVER['QUERY_STRING']));
if ($check_query!=strtolower($_SERVER['QUERY_STRING'])) {$hack=true;}
}
	 if ($hack) {
	      $user_agent= (SYS_USER_AGENT!="" ? stripinput(str_replace('||', ' ', SYS_USER_AGENT)) : "");
          $resu=dbcount("(blacklist_ip)",DB_PREFIX."secsys_blacklist","blacklist_ip='".SYS_USER_IP."'");
          if ($resu=="0") {
          $resu2=dbquery("INSERT INTO ".DB_PREFIX."secsys_blacklist (blacklist_ip,blacklist_datestamp) VALUES('".SYS_USER_IP."','".time()."')");
          } 
          $rsl=dbrows(dbquery("SELECT * FROM ".DB_PREFIX."secsys_logfile WHERE hack_ip='".SYS_USER_IP."' AND hack_type='hacks' AND hack_datestamp>='".(time()-3600)."'"));
        if (!sec_proxyscan()) {
			$resu2=dbcount("(proxy_ip)",DB_PREFIX."secsys_proxy_blacklist","proxy_ip='".SYS_USER_IP."' LIMIT 0,1");
			if (@$resu2=="0") {
         	 $result=dbquery("INSERT INTO ".DB_PREFIX."secsys_proxy_blacklist (proxy_ip,proxy_datestamp) VALUES ('".SYS_USER_IP."','".time()."')");
          }
		  }   
	   if ($rsl==0 && $sys_setting['ctracker_log']=='1') {
          $sys_msg=stripinput(SYS_FUSION_QUERY);
          $sys_msg=$sys_msg;
          $sys_msg_entry=eregi_replace(" ","",$sys_msg);
          $result=dbquery("INSERT INTO ".DB_PREFIX."secsys_logfile (hack_id,hack_type,hack_userid,hack_ip,hack_query,hack_referer,hack_agent,hack_datestamp) VALUES (NULL,'hacks','".SYS_USER_ID."','".SYS_USER_IP."','".$sys_msg_entry."','".stripinput(SYS_USER_REFERER)."','".$user_agent."','".time()."')");
          }

          $result=dbquery("UPDATE ".DB_PREFIX."secsys_statistics SET hacks=hacks+1");
          mysql_close();
          fallback(SEC_INFDIR."attack.html");exit;
}
 } 
}

// Funktion für die IP/Agent-Blockade
function secsys_filter() {
global $sys_setting;
  $b_remotead = SYS_USER_IP;
  $b_agent    = SYS_USER_AGENT;
  $checker_agent = $b_agent;
  $agent="";
  $agent2="";
  $listnum=0;
  $i=0;
  if(!empty($b_remotead) || !empty($b_agent))
  {
  	if ($b_agent!="") {
    $result = dbquery("SELECT list FROM " .DB_PREFIX."secsys_filter WHERE active='1'");
    $listnum=dbrows($result);
  
     if ($listnum>0)  {
     while($row=dbarray($result))  {
     $agent.=strtolower($row['list']).($i<$listnum-1 ? "," : "");
	 $agent2.="<b>".$row['list']."</b>".($i<$listnum-1 ? "," : "");
     $i++;
     }
     $checker_agent=str_replace(explode(",",$agent),"*",strtolower($b_agent));
       
      if (strtolower($b_agent)!=strtolower($checker_agent)) {
    	$user_agent= (SYS_USER_AGENT!="" ? stripinput(str_replace('||', ' ', SYS_USER_AGENT)) : "");
          $rsl=dbrows(dbquery("SELECT * FROM ".DB_PREFIX."secsys_logfile WHERE hack_ip='".SYS_USER_IP."' AND hack_type='blocks' AND hack_datestamp>='".(time()-3600)."'"));
          if ($rsl==0 && $sys_setting['filter_log']=='1') {
          $sys_msg="User-Agent ".str_replace(explode(",",$agent),explode(",",$agent2),$b_agent)." found";
          $result=dbquery("INSERT INTO ".DB_PREFIX."secsys_logfile (hack_id,hack_type,hack_userid,hack_ip,hack_query,hack_referer,hack_agent,hack_datestamp) VALUES (NULL,'blocks','".SYS_USER_ID."','".SYS_USER_IP."','".$sys_msg."','".stripinput(SYS_USER_REFERER)."','".$user_agent."','".time()."')");
          }
          $resu=dbcount("(blacklist_ip)",DB_PREFIX."secsys_blacklist","blacklist_ip='".SYS_USER_IP."'");
          if ($resu==0) {
          $resu2=dbquery("INSERT INTO ".DB_PREFIX."secsys_blacklist (blacklist_ip,blacklist_datestamp) VALUES('".SYS_USER_IP."','".time()."')");
          } 
          $result=dbquery("UPDATE ".DB_PREFIX."secsys_statistics SET blocks=blocks+1");
          mysql_close();
	   fallback(SEC_INFDIR."filterstop.html");	
	   exit;
	    }	
    }
    }
 
	if ($b_remotead!="") {
	$splitt_ip=explode(".",$b_remotead);
	$ip_1 = isset($splitt_ip[0]) ? intval($splitt_ip[0]) : "0";
	$ip_2 = isset($splitt_ip[1]) ? intval($splitt_ip[1]) : "0";
	$ip_3 = isset($splitt_ip[2]) ? intval($splitt_ip[2]) : "0";
	$ip_4 = isset($splitt_ip[3]) ? intval($splitt_ip[3]) : "0";	
    $result = dbquery("SELECT list FROM " .DB_PREFIX."secsys_filter WHERE (list='{$ip_1}' OR list='{$ip_1}.{$ip_2}' OR list='{$ip_1}.{$ip_2}.{$ip_3}' OR list='{$ip_1}.{$ip_2}.{$ip_3}.{$ip_4}' OR list='{$ip_1}.' OR list='{$ip_1}.{$ip_2}.' OR list='{$ip_1}.{$ip_2}.{$ip_3}.' OR list='{$ip_1}.{$ip_2}.{$ip_3}.{$ip_4}') AND active='1'");
    if (dbrows($result)==1) {
    $query=dbarray($result);
   	$user_agent= (SYS_USER_AGENT!="" ? stripinput(str_replace('||', ' ', SYS_USER_AGENT)) : "");
          $rsl=dbrows(dbquery("SELECT * FROM ".DB_PREFIX."secsys_logfile WHERE hack_ip='".SYS_USER_IP."' AND hack_type='blocks' AND hack_datestamp>='".(time()-3600)."'"));
          if ($rsl==0 && $sys_setting['filter_log']=='1') {
          $sys_msg="IP<b> {$query['list']} </b>found";
          $result=dbquery("INSERT INTO ".DB_PREFIX."secsys_logfile (hack_id,hack_type,hack_userid,hack_ip,hack_query,hack_referer,hack_agent,hack_datestamp) VALUES (NULL,'blocks','".SYS_USER_ID."','".SYS_USER_IP."','".$sys_msg."','".stripinput(SYS_USER_REFERER)."','".$user_agent."','".time()."')");
          }
          $resu=dbcount("(blacklist_ip)",DB_PREFIX."secsys_blacklist","blacklist_ip='".SYS_USER_IP."'");
          if ($resu==0) {
          $resu2=dbquery("INSERT INTO ".DB_PREFIX."secsys_blacklist (blacklist_ip,blacklist_datestamp) VALUES('".SYS_USER_IP."','".time()."')");
          } 
          $result=dbquery("UPDATE ".DB_PREFIX."secsys_statistics SET blocks=blocks+1");
          mysql_close();
          fallback(SEC_INFDIR."filterstop.html");	
          exit;
	    }	
    }
     }
}

function secsys_parser($text) {
	$text = preg_replace('#\[url\]([\r\n]*)(http://|ftp://|https://|ftps://)([^\s\'\";\+]*?)([\r\n]*)\[/url\]#si', '<a href=\'\2\3\' target=\'_blank\'>\2\3</a>', $text);
	$text = preg_replace('#\[url\]([\r\n]*)([^\s\'\";\+]*?)([\r\n]*)\[/url\]#si', '<a href=\'http://\2\' target=\'_blank\'>\2</a>', $text);
	$text = preg_replace('#\[url=([\r\n]*)(http://|ftp://|https://|ftps://)([^\s\'\";\+]*?)\](.*?)([\r\n]*)\[/url\]#si', '<a href=\'\2\3\' target=\'_blank\'>\4</a>', $text);
	$text = preg_replace('#\[url=([\r\n]*)([^\s\'\";\+]*?)\](.*?)([\r\n]*)\[/url\]#si', '<a href=\'http://\2\' target=\'_blank\'>\3</a>', $text);
	
	$text = preg_replace('#\[mail\]([\r\n]*)([^\s\'\";:\+]*?)([\r\n]*)\[/mail\]#si', '<a href=\'mailto:\2\'>\2</a>', $text);
	$text = preg_replace('#\[mail=([\r\n]*)([^\s\'\";:\+]*?)\](.*?)([\r\n]*)\[/mail\]#si', '<a href=\'mailto:\2\'>\2</a>', $text);
	$text = descript($text,false);
	return strtolower($text);	
}

function secsys_spamcontrol($msg) {
global $sys_setting;
$found=false;
$i=0;
$spam_msg="";
$spamword="";
$spamword2="";
$found_spam=0;
$spam_text="";
$spam_words=array();
$spam_checker=!empty($msg) && isset($_POST[$msg]) ? $_POST[$msg] : "";
$result=dbquery("SELECT spam_word FROM ".DB_PREFIX."secsys_spamfilter");
$listnum=dbrows($result);
$spamstop=0;
     if ($listnum>0)  {
     while($row=dbarray($result))  {
     $spamword.=strtolower($row['spam_word']).($i<$listnum-1 ? "," : "");
	 $spamword2.="<b>".$row['spam_word']."</b>".($i<$listnum-1 ? "," : "");
     $i++;
     }
     $message=!empty($msg) && isset($_POST[$msg]) && !empty($_POST[$msg])? secsys_parser($_POST[$msg]) : "";
      
     if (empty($message)) {
	 $found_spam=5;	
	 } else {
$spam_words=explode(",",$spamword);	  
 foreach ($spam_words as $check_spam) {
$spam_text.=substr_count($message,$check_spam).".";
}
$spam = explode(".",$spam_text);
	foreach ($spam as $wert) {
	if ($wert>0) {
	$found_spam=$found_spam+$wert;
	}
	}
}	
     if ($found_spam>=3) {
		$user_agent= (SYS_USER_AGENT!="" ? stripinput(str_replace('||', ' ', SYS_USER_AGENT)) : "");
          $rsl=dbrows(dbquery("SELECT * FROM ".DB_PREFIX."secsys_logfile WHERE hack_ip='".SYS_USER_IP."' AND hack_type='spam' AND hack_datestamp>='".(time()-3600)."'"));
          if ($rsl==0 && $sys_setting['spam_log']=='1') {
          $spam_msg=str_replace(explode(",",$spamword),explode(",",$spamword2),stripinput($_POST[$msg]));
          $result=dbquery("INSERT INTO ".DB_PREFIX."secsys_logfile (hack_id,hack_type,hack_userid, hack_ip,hack_query,hack_referer,hack_agent,hack_datestamp) VALUES (NULL,'spam','".SYS_USER_ID."','".SYS_USER_IP."','".mysql_escape_string($spam_msg)."','".stripinput(SYS_USER_REFERER)."','".$user_agent."','".time()."')");
          }
          if ($sys_setting['userlock']>0 && (iSYS_MEMBER && !iSYS_ADMIN)) {
          $control_member=dbcount("(c_user_id)",DB_PREFIX."secsys_membercontrol","c_user_id='".SYS_USER_ID."'");
          if ($control_member==0) {
          $result=dbquery("INSERT INTO ".DB_PREFIX."secsys_membercontrol (c_user_id,c_flood_count,c_userlock,c_userlock_datestamp) VALUES ('".SYS_USER_ID."','0','0','".time()."')");
          }
          elseif ($control_member>0) {
          $rsl=dbarray(dbquery("SELECT * from ".DB_PREFIX."secsys_membercontrol WHERE c_user_id='".SYS_USER_ID."'"));
          $spam_stop=$rsl['c_flood_count'];
          }

          if ($spam_stop<$sys_setting['user_attempts']) {
          $mem_upd=dbquery("UPDATE ".DB_PREFIX."secsys_membercontrol SET c_flood_count=c_flood_count+1 WHERE c_user_id='".SYS_USER_ID."'");
          } else {
		$mem_upd=dbquery("UPDATE ".DB_PREFIX."secsys_membercontrol SET c_userlock='1', c_userlock_datestamp='".time()."' WHERE c_user_id='".SYS_USER_ID."'");
		$mem_upd=dbquery("UPDATE ".DB_PREFIX."users SET user_status='1' WHERE user_id='".SYS_USER_ID."'");
		fallback(BASEDIR."setuser.php?logout=yes");
		exit;
		}
    }
          $result=dbquery("UPDATE ".DB_PREFIX."secsys_statistics SET spams=spams+1");
         mysql_close();
         fallback(SEC_INFDIR."spamstop.html");
         exit;
	  }	  
   
    }
}

function clear_logfiles() {
global $sys_setting;
$logfiles_counter=dbcount("(hack_id)",DB_PREFIX."secsys_logfile","");
$log_expired=time()-3600*24*$sys_setting['log_expired'];
if ($logfiles_counter>=$sys_setting['log_max']) {
$result=dbquery("TRUNCATE ".DB_PREFIX."secsys_logfile");
} else {
$result=dbquery("DELETE FROM ".DB_PREFIX."secsys_logfile WHERE hack_datestamp<='$log_expired'");
}
return $result;
}

function clear_ip_blacklist() {
$blacklist_expired=time()-3600;
$result=dbquery("DELETE FROM ".DB_PREFIX."secsys_blacklist WHERE blacklist_datestamp<='$blacklist_expired'");
return $result;
}

clear_ip_blacklist();
if ($sys_setting['log_autodelete']=='1') {
clear_logfiles();
}

// Funktionen der Spamkontrolle der einzelnen Bereiche
function forum_control($userid,$ipaddress) {
 global $db_prefix, $sys_setting;
 $floodtime=time()-$sys_setting['fctime'];
 if($userid) {
 $result=dbquery("SELECT post_id FROM ".DB_PREFIX."posts WHERE post_author='$userid' AND post_datestamp>='".$floodtime."'");
 }
 else {
 $result=dbquery("SELECT post_id FROM ".DB_PREFIX."posts WHERE post_ip='$ipaddress' AND post_datestamp>='".$floodtime."'");        }
 if(dbrows($result)>0){ return true;}else{ return false;        }
}

function shoutbox_control ($userid,$ipaddress) {
 global $db_prefix, $sys_setting;
  $floodtime=time()-$sys_setting['sctime'];
 if($userid) {
 $result=dbquery("SELECT shout_id FROM ".DB_PREFIX."shoutbox WHERE shout_name='$userid' AND shout_datestamp>='".$floodtime."'");
 }
 else {
 $result=dbquery("SELECT shout_id FROM ".DB_PREFIX."shoutbox WHERE shout_ip='$ipaddress' AND shout_datestamp>='".$floodtime."'");        }
 if(dbrows($result)>0){ return true;}else{ return false;        }
}

function comment_control ($userid,$ipaddress) {
 global $db_prefix, $sys_setting;
  $floodtime=time()-$sys_setting['cctime'];
 if($userid) {
 $result=dbquery("SELECT comment_id FROM ".DB_PREFIX."comments WHERE comment_name='$userid' AND comment_datestamp>='".$floodtime."'");
 }
 else {
 $result=dbquery("SELECT comment_id FROM ".DB_PREFIX."comments WHERE comment_ip='$ipaddress' AND comment_datestamp>='".$floodtime."'");        }
 if(dbrows($result)>0){ return true;}else{ return false;        }
}

function guestbook_control ($ipaddress) {
 global $db_prefix, $sys_setting;
 $floodtime=time()-$sys_setting['gctime'];
 $result=dbquery("SELECT guestbook_id FROM ".DB_PREFIX."guestbook WHERE guestbook_ip='$ipaddress' AND guestbook_datestamp>='".$floodtime."'");
 if(dbrows($result)>0 || dbrows($result2)>0 ){ return true;}else{ return false;        }
}


function pm_control ($userid,$userid2) {
 global $db_prefix, $sys_setting;
  $floodtime=time()-$sys_setting['mctime'];
  $result=dbquery("SELECT message_id FROM ".DB_PREFIX."messages WHERE message_from='$userid' AND message_to='$userid2' AND message_datestamp>='".$floodtime."'");
 if(dbrows($result)>0){ return true;}else{ return false;        }
}

function contact_control ($contact_ip,$contact_time) {
global $db_prefix, $sys_setting;
$floodtime=time()-$sys_setting['coctime'];
       if (!empty($contact_ip)) {
       $result = dbquery("SELECT * from ".DB_PREFIX."secsys_contact WHERE contact_datestamp>='".$floodtime."' AND contact_ip='$contact_ip'");
        if(dbrows($result)>0){
        unset($_POST['sendmessage']);
        return true;}else{
        $result2=dbquery("INSERT INTO ".DB_PREFIX."secsys_contact (contact_datestamp,contact_ip) VALUES('".time()."','$contact_ip')");
        return false;}
       }
}

// Funktion zur Eintragung der Spam/Flood-Einträge
function print_flood() {
global $sysdata, $db_prefix,$sys_setting;
          $user_agent= (SYS_USER_AGENT!="" ? stripinput(str_replace('||', ' ', SYS_USER_AGENT)) : "");
          $rsl=dbrows(dbquery("SELECT * FROM ".DB_PREFIX."secsys_logfile WHERE hack_ip='".SYS_USER_IP."' AND hack_type='floods' AND hack_datestamp>='".(time()-3600)."'"));
          if ($rsl==0 && $sys_setting['flood_log']=='1') {
          $sys_msg=FUSION_QUERY;
          $sys_msg=substr($sys_msg,0,75).(strlen($sys_msg)>75 ? "..." : "");
          $sys_msg_entry=eregi_replace(" ","",$sys_msg);
          $result=dbquery("INSERT INTO ".DB_PREFIX."secsys_logfile (hack_id,hack_type,hack_userid,hack_ip,hack_query,hack_referer,hack_agent,hack_datestamp) VALUES (NULL,'floods','".SYS_USER_ID."','".SYS_USER_IP."','".$sys_msg."','".SYS_USER_REFERER."','".$user_agent."','".time()."')");
          }
          $result=dbquery("UPDATE ".DB_PREFIX."secsys_statistics SET floods=floods+1");

          if ($sys_setting['userlock']>0 && (iSYS_MEMBER && !iSYS_ADMIN)) {
          $control_member=dbcount("(c_user_id)",DB_PREFIX."secsys_membercontrol","c_user_id='".SYS_USER_ID."'");
          if ($control_member==0) {
          $result=dbquery("INSERT INTO ".DB_PREFIX."secsys_membercontrol (c_user_id,c_flood_count,c_userlock,c_userlock_datestamp) VALUES ('".SYS_USER_ID."','0','0','".time()."')");
          }
          elseif ($control_member>0) {
          $rsl=dbarray(dbquery("SELECT * from ".DB_PREFIX."secsys_membercontrol WHERE c_user_id='".SYS_USER_ID."'"));
          $flood_stop=$rsl['c_flood_count'];
          }

          if ($flood_stop<$sys_setting['user_attempts']) {
          $mem_upd=dbquery("UPDATE ".DB_PREFIX."secsys_membercontrol SET c_flood_count=c_flood_count+1 WHERE c_user_id='".SYS_USER_ID."'");
          }
    }
}

function sec_proxyscan() {
global $REMOTE_ADDR, $HTTP_CLIENT_IP;
global $HTTP_X_FORWARDED_FOR, $HTTP_X_FORWARDED, $HTTP_FORWARDED_FOR, $HTTP_FORWARDED;
global $HTTP_VIA, $HTTP_X_COMING_FROM, $HTTP_COMING_FROM;

// Get some server/environment variables values
if (empty($REMOTE_ADDR)) {
if (!empty($_SERVER) && isset($_SERVER['REMOTE_ADDR'])) {
$REMOTE_ADDR = $_SERVER['REMOTE_ADDR'];}
else if (!empty($_ENV) && isset($_ENV['REMOTE_ADDR'])) {
$REMOTE_ADDR = $_ENV['REMOTE_ADDR'];}
else if (@getenv('REMOTE_ADDR')) {
$REMOTE_ADDR = getenv('REMOTE_ADDR');}} // end if

if (empty($HTTP_CLIENT_IP)) {
if (!empty($_SERVER) && isset($_SERVER['HTTP_CLIENT_IP'])) {
$HTTP_CLIENT_IP = $_SERVER['HTTP_CLIENT_IP'];}
else if (!empty($_ENV) && isset($_ENV['HTTP_CLIENT_IP'])) {
$HTTP_CLIENT_IP = $_ENV['HTTP_CLIENT_IP'];}
else if (@getenv('HTTP_CLIENT_IP')) {
$HTTP_CLIENT_IP = getenv('HTTP_CLIENT_IP');}} // end if

if (empty($HTTP_X_FORWARDED_FOR)) {
if (!empty($_SERVER) && isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
$HTTP_X_FORWARDED_FOR = $_SERVER['HTTP_X_FORWARDED_FOR'];}
else if (!empty($_ENV) && isset($_ENV['HTTP_X_FORWARDED_FOR'])) {
$HTTP_X_FORWARDED_FOR = $_ENV['HTTP_X_FORWARDED_FOR'];}
else if (@getenv('HTTP_X_FORWARDED_FOR')) {
$HTTP_X_FORWARDED_FOR = getenv('HTTP_X_FORWARDED_FOR');}} // end if

if (empty($HTTP_X_FORWARDED)) {
if (!empty($_SERVER) && isset($_SERVER['HTTP_X_FORWARDED'])) {
$HTTP_X_FORWARDED = $_SERVER['HTTP_X_FORWARDED'];}
else if (!empty($_ENV) && isset($_ENV['HTTP_X_FORWARDED'])) {
$HTTP_X_FORWARDED = $_ENV['HTTP_X_FORWARDED'];}
else if (@getenv('HTTP_X_FORWARDED')) {
$HTTP_X_FORWARDED = getenv('HTTP_X_FORWARDED');}} // end if

if (empty($HTTP_FORWARDED_FOR)) {
if (!empty($_SERVER) && isset($_SERVER['HTTP_FORWARDED_FOR'])) {
$HTTP_FORWARDED_FOR = $_SERVER['HTTP_FORWARDED_FOR'];}
else if (!empty($_ENV) && isset($_ENV['HTTP_FORWARDED_FOR'])) {
$HTTP_FORWARDED_FOR = $_ENV['HTTP_FORWARDED_FOR'];}
else if (@getenv('HTTP_FORWARDED_FOR')) {
$HTTP_FORWARDED_FOR = getenv('HTTP_FORWARDED_FOR');}} // end if

if (empty($HTTP_FORWARDED)) {
if (!empty($_SERVER) && isset($_SERVER['HTTP_FORWARDED'])) {
$HTTP_FORWARDED = $_SERVER['HTTP_FORWARDED'];}
else if (!empty($_ENV) && isset($_ENV['HTTP_FORWARDED'])) {
$HTTP_FORWARDED = $_ENV['HTTP_FORWARDED'];}
else if (@getenv('HTTP_FORWARDED')) {
$HTTP_FORWARDED = getenv('HTTP_FORWARDED');}} // end if

if (empty($HTTP_VIA)) {
if (!empty($_SERVER) && isset($_SERVER['HTTP_VIA'])) {
$HTTP_VIA = $_SERVER['HTTP_VIA'];}
else if (!empty($_ENV) && isset($_ENV['HTTP_VIA'])) {
$HTTP_VIA = $_ENV['HTTP_VIA'];}
else if (@getenv('HTTP_VIA')) {
$HTTP_VIA = getenv('HTTP_VIA');}} // end if

if (empty($HTTP_X_COMING_FROM)) {
if (!empty($_SERVER) && isset($_SERVER['HTTP_X_COMING_FROM'])) {
$HTTP_X_COMING_FROM = $_SERVER['HTTP_X_COMING_FROM'];}
else if (!empty($_ENV) && isset($_ENV['HTTP_X_COMING_FROM'])) {
$HTTP_X_COMING_FROM = $_ENV['HTTP_X_COMING_FROM'];}
else if (@getenv('HTTP_X_COMING_FROM')) {
$HTTP_X_COMING_FROM = getenv('HTTP_X_COMING_FROM');}} // end if

if (empty($HTTP_COMING_FROM)) {
if (!empty($_SERVER) && isset($_SERVER['HTTP_COMING_FROM'])) {
$HTTP_COMING_FROM = $_SERVER['HTTP_COMING_FROM'];}
else if (!empty($_ENV) && isset($_ENV['HTTP_COMING_FROM'])) {
$HTTP_COMING_FROM = $_ENV['HTTP_COMING_FROM'];}
else if (@getenv('HTTP_COMING_FROM')) {
$HTTP_COMING_FROM = getenv('HTTP_COMING_FROM');}} // end if

// Gets the default ip sent by the user
if (!empty($REMOTE_ADDR)) {
$direct_ip = $REMOTE_ADDR;} 
else {
$direct_ip = "";	
}

// Gets the proxy ip sent by the user
$proxy_ip = '';
if (!empty($HTTP_X_FORWARDED_FOR)) {
$proxy_ip = $HTTP_X_FORWARDED_FOR;
} else if (!empty($HTTP_X_FORWARDED)) {
$proxy_ip = $HTTP_X_FORWARDED;
} else if (!empty($HTTP_FORWARDED_FOR)) {
$proxy_ip = $HTTP_FORWARDED_FOR;
} else if (!empty($HTTP_FORWARDED)) {
$proxy_ip = $HTTP_FORWARDED;
} else if (!empty($HTTP_VIA)) {
$proxy_ip = $HTTP_VIA;
} else if (!empty($HTTP_X_COMING_FROM)) {
$proxy_ip = $HTTP_X_COMING_FROM;
} else if (!empty($HTTP_COMING_FROM)) {
$proxy_ip = $HTTP_COMING_FROM;} // end if... else if...

// Returns the true IP if it has been found, else ...
if (empty($proxy_ip) && !empty($direct_ip)) {
// True IP without proxy
$sec_proxy_in_use="0";
} elseif (empty($proxy_ip) && empty($direct_ip)) {
$sec_proxy_in_use="1";
} elseif(!empty($proxy_ip)) {
$sec_proxy_in_use='1';
}
if ($sec_proxy_in_use==0)  {
return true;	
} else {
return false;	
}
} // end of function



function secsys_proxy_whitelist() {
global $sys_setting,$db_prefix;	
$white_detection=false;
	if ($sys_setting['proxy_visit']==0) {
	$splitt_ip=explode(".",SYS_USER_IP);
	$ip_1 = isset($splitt_ip[0]) ? intval($splitt_ip[0]) : "0";
	$ip_2 = isset($splitt_ip[1]) ? intval($splitt_ip[1]) : "0";
	$ip_3 = isset($splitt_ip[2]) ? intval($splitt_ip[2]) : "0";
	$ip_4 = isset($splitt_ip[3]) ? intval($splitt_ip[3]) : "0";	
    $check_whitelist = dbquery("SELECT proxy_ip FROM {$db_prefix}secsys_proxy_whitelist WHERE (proxy_ip='{$ip_1}' OR proxy_ip='{$ip_1}.{$ip_2}' OR proxy_ip='{$ip_1}.{$ip_2}.{$ip_3}' OR proxy_ip='{$ip_1}.{$ip_2}.{$ip_3}.{$ip_4}' OR proxy_ip='{$ip_1}.' OR proxy_ip='{$ip_1}.{$ip_2}.' OR proxy_ip='{$ip_1}.{$ip_2}.{$ip_3}.' OR proxy_ip='{$ip_1}.{$ip_2}.{$ip_3}.{$ip_4}') AND proxy_status='1'");

	if (dbrows($check_whitelist)>0) {
 		$white_detection=true;
 		} 
} else {
	$white_detection=true;
}
return $white_detection;
}

function secsys_proxy_blacklist() {
global $sys_setting,$db_prefix,$locale;	
	if ($sys_setting['proxy_visit']==0) {
	$splitt_ip=explode(".",SYS_USER_IP);
	$ip_1 = isset($splitt_ip[0]) ? intval($splitt_ip[0]) : "0";
	$ip_2 = isset($splitt_ip[1]) ? intval($splitt_ip[1]) : "0";
	$ip_3 = isset($splitt_ip[2]) ? intval($splitt_ip[2]) : "0";
	$ip_4 = isset($splitt_ip[3]) ? intval($splitt_ip[3]) : "0";	
    $check_blacklist = dbquery("SELECT proxy_ip FROM {$db_prefix}secsys_proxy_blacklist WHERE (proxy_ip='{$ip_1}' OR proxy_ip='{$ip_1}.{$ip_2}' OR proxy_ip='{$ip_1}.{$ip_2}.{$ip_3}' OR proxy_ip='{$ip_1}.{$ip_2}.{$ip_3}.{$ip_4}' OR proxy_ip='{$ip_1}.' OR proxy_ip='{$ip_1}.{$ip_2}.' OR proxy_ip='{$ip_1}.{$ip_2}.{$ip_3}.' OR proxy_ip='{$ip_1}.{$ip_2}.{$ip_3}.{$ip_4}')");
	if (dbrows($check_blacklist)>0) {
		$result=dbquery("UPDATE ".DB_PREFIX."secsys_statistics SET proxy_blacklist=proxy_blacklist+1");
		mysql_close(); 
		fallback(SEC_INFDIR."proxy_visit.html");
		exit;	
		} 

	if (!sec_proxyscan() && secsys_hacker() || !sec_proxyscan() && !TRUE_REFERER)  {
   		 $rsl=dbrows(dbquery("SELECT * FROM {$db_prefix}secsys_logfile WHERE hack_ip='".SYS_USER_IP."' AND hack_type='proxy_visit' AND hack_datestamp>='".(time()-3600)."'"));
   $rsl1=dbquery("INSERT INTO {$db_prefix}secsys_proxy_blacklist (proxy_id, proxy_ip, proxy_datestamp) VALUES (NULL,'".SYS_USER_IP."','".time()."')");
          if ($rsl==0 && $sys_setting['proxy_log']=='1') {
          $sys_msg_entry=sprintf($locale['SYS229'], $locale['SYS228']);
          $user_agent= (SYS_USER_AGENT!="" ? stripinput(str_replace('||', ' ', SYS_USER_AGENT)) : "");
          $result=dbquery("INSERT INTO {$db_prefix}secsys_logfile (hack_id,hack_type,hack_userid,hack_ip,hack_query,hack_referer,hack_agent,hack_datestamp) VALUES (NULL,'proxy_visit','".SYS_USER_ID."','".SYS_USER_IP."','".$sys_msg_entry."','".stripinput(SYS_USER_REFERER)."','".$user_agent."','".time()."')");
          }
          $result=dbquery("UPDATE {$db_prefix}secsys_statistics SET proxy_visit=proxy_visit+1");	
mysql_close(); 
fallback(SEC_INFDIR."proxy_visit.html");
exit;	
 }
}
}

if ($sys_setting['proxy_visit']=="0") {
	if (!iSYS_ADMIN || !iSYSMOD) {	
	secsys_proxy_blacklist();	
	}
define("FREE_PROXY", sec_proxyscan() || !sec_proxyscan() && secsys_proxy_whitelist() > 0 ? TRUE : FALSE);
} else {
define("FREE_PROXY", TRUE);	
}

	

if (!FREE_PROXY) {
if ($sys_setting['proxy_login']=="0") {
// Loginkontrolle
if (isset($_POST['login']) && !sec_proxyscan() || isset($_COOKIE['fusion_user']) && !sec_proxyscan()) {
          $rsl=dbrows(dbquery("SELECT * FROM ".DB_PREFIX."secsys_logfile WHERE hack_ip='".SYS_USER_IP."' AND hack_type='proxy_login' AND hack_datestamp>='".(time()-3600)."'"));
          if ($rsl==0 && $sys_setting['proxy_log']=='1') {
          $sys_msg_entry=sprintf($locale['SYS229'], $locale['SYS226']);
          $user_agent= (SYS_USER_AGENT!="" ? stripinput(str_replace('||', ' ', SYS_USER_AGENT)) : "");
          $result=dbquery("INSERT INTO ".DB_PREFIX."secsys_logfile (hack_id,hack_type,hack_userid,hack_ip,hack_query,hack_referer,hack_agent,hack_datestamp) VALUES (NULL,'proxy_login','".SYS_USER_ID."','".SYS_USER_IP."','".$sys_msg_entry."','".stripinput(SYS_USER_REFERER)."','".$user_agent."','".time()."')");
          }
          $result=dbquery("UPDATE ".DB_PREFIX."secsys_statistics SET proxy_login=proxy_login+1");
header("P3P: CP='NOI ADM DEV PSAi COM NAV OUR OTRo STP IND DEM'");
		setcookie("fusion_user", "", time()-7200, "/", "", "0");	
		setcookie("fusion_lastvisit", "", time()-7200, "/", "", "0");	
mysql_close(); 
fallback(SEC_INFDIR."proxy.php");
exit;
}
}

if ($sys_setting['proxy_register']==0) {
if(eregi("register.php",FUSION_SELF) && !sec_proxyscan()) {
          $rsl=dbrows(dbquery("SELECT * FROM ".DB_PREFIX."secsys_logfile WHERE hack_ip='".SYS_USER_IP."' AND hack_type='proxy_register' AND hack_datestamp>='".(time()-3600)."'"));
          if ($rsl==0 && $sys_setting['proxy_log']=='1') {
          $sys_msg_entry=sprintf($locale['SYS229'], $locale['SYS227']);
          $user_agent= (SYS_USER_AGENT!="" ? stripinput(str_replace('||', ' ', SYS_USER_AGENT)) : "");
          $result=dbquery("INSERT INTO ".DB_PREFIX."secsys_logfile (hack_id,hack_type,hack_userid,hack_ip,hack_query,hack_referer,hack_agent,hack_datestamp) VALUES (NULL,'proxy_register','".SYS_USER_ID."','".SYS_USER_IP."','".$sys_msg_entry."','".stripinput(SYS_USER_REFERER)."','".$user_agent."','".time()."')");
          }
          $result=dbquery("UPDATE ".DB_PREFIX."secsys_statistics SET proxy_register=proxy_register+1");
mysql_close(); 
fallback(SEC_INFDIR."proxy.php");
exit;	
}
}

}

$bl_list=0;
if (!iSYS_ADMIN || !iSYSMOD) {
	$bl_list=dbcount("(blacklist_ip)",DB_PREFIX."secsys_blacklist","blacklist_ip='".SYS_USER_IP."'");
	if ($bl_list>0) {
	fallback(SEC_INFDIR."filterstop.html");
	} else {
    secsys_filter();     // IP/AGENT-Blocker
    }
	secsys_hacker();     // SQL-Injection

    if (!empty($_POST['message']))
    {secsys_spamcontrol('message');}
    if (!empty($_POST['shout_name']))
    {secsys_spamcontrol('shout_name');}
    if (!empty($_POST['shout_message']))
    {secsys_spamcontrol('shout_message');}
    if (!empty($_POST['guest_message']))
    {secsys_spamcontrol('guest_message');}
    if (!empty($_POST['comment_name']))
    {secsys_spamcontrol('comment_name');}
    if (!empty($_POST['comment_message']))
    {secsys_spamcontrol('comment_message');}
    if (!empty($_POST['guest_webtitle'])) 
    {secsys_spamcontrol('guest_webtitle');}
    if (!empty($_POST['guest_name'])) 
    {secsys_spamcontrol('guest_name');}
    if (!empty($_POST['guest_webtitle'])) 
    {secsys_spamcontrol('guest_webtitle');}
    if (!empty($_POST['mailname'])) 
    {secsys_spamcontrol('mailname');}
    if (!empty($_POST['subject'])) 
    {secsys_spamcontrol('subject');}
    if (!empty($_POST['comm_name']))
    {secsys_spamcontrol('comm_name');}
    if (!empty($_POST['comm_text']))
    {secsys_spamcontrol('comm_text');}
}

if ($sys_setting['flood_active']>0)
 {
      // Floodeinträge stoppen
      // Forum, Kontakt und Private Mitteilungen
      if (isset($_POST['message']) && (!isset($_POST['previewpost']) && !isset($_POST['previewreply']) && !isset($_POST['previewchanges']) && !isset($_POST['savechanges'])))
      {

      if (eregi("/forum/",FUSION_REQUEST)) {
        if (!checksysgroup($sys_setting['forum_access']) && !iSYSMOD) {
          if (forum_control(SYS_USER_ID,$_SERVER['REMOTE_ADDR']))
          {
          print_flood();
          fallback(INFUSIONS."security_system/restrict.php?check=forum");
          exit;
          }
        }
      }
      elseif (eregi("messages.php",FUSION_SELF)) {
        if (!checksysgroup($sys_setting['pm_access'])) {
          if (pm_control($sysdata['user_id'],$_POST['msg_send']))
          {
          print_flood();
          fallback(INFUSIONS."security_system/restrict.php?check=pm");
          exit;
          }
        }
        }
      elseif (eregi("contact.php",FUSION_SELF)) {
        if (!checksysgroup($sys_setting['contact_access']))
        {
if (!isset($_POST['sendmessage']) || isset($_POST['sendmessage']) && $error!="") {

          if (contact_control(SYS_USER_IP,time()))
          {
          print_flood();
          fallback(INFUSIONS."security_system/restrict.php?check=contact");
          exit;
          }
}
        }
      }

      }

      // Shoutbox
      if (isset($_POST['shout_message']))
      {

        if (!checksysgroup($sys_setting['shout_access'])) {
          if (shoutbox_control($sysdata['user_id'],$_SERVER['REMOTE_ADDR']))
          {
          print_flood();
          fallback(INFUSIONS."security_system/restrict.php?check=shout");
          exit;
          }
        }
      }

      // Gästebuch
      if (eregi("guestbook.php",FUSION_SELF)) {
      if (isset($_POST['guest_message']))
      {
       if (!checksysgroup($sys_setting['gb_access'])) {
          if (guestbook_control($_SERVER['REMOTE_ADDR']))
          {
          print_flood();
          fallback(INFUSIONS."security_system/restrict.php?check=guestbook");
          exit;
          }
        }
      }
      }
      // Kommententare
      if (isset($_POST['comment_message']))
      {
        if (!checksysgroup($sys_setting['comment_access'])) {
          if (comment_control($sysdata['user_id'],$_SERVER['REMOTE_ADDR'])) {
          print_flood();
          fallback(INFUSIONS."security_system/restrict.php?check=comments");
          exit;
          }
        }
      }
  }
}
}
?>