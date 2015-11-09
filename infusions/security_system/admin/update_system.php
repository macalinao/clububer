<?php
/*----------------------------------------------+
| SECURITY SYSTEM V1.0 FÜR PHP-FUSION           |
| copyright (c) 2006 by BS-Fusion Deutschland   |
| Email-Support: webmaster[at]bs-fusion.de      |
| Homepage: http://www.bs-fusion.de             |
| Inhaber: Manuel Kurz                          |
+----------------------------------------------*/
if (!defined("IN_FUSION") || !iADMIN && !checkrights("IP")) {die();}
$sys_error="";
if (!empty($_POST['del_filter'])) {
 if (!empty($_POST['delete_filter']))
 {
  foreach($_POST['delete_filter'] as $nofilter) {
    $result=dbquery("DELETE FROM ".$db_prefix."secsys_filter WHERE id='".$nofilter."'");
  }
     if ($result) {
   redirect(FUSION_SELF."?pagefile=filterlist");
   }
 }
 else {
 $sys_error="<b>".$locale['SYS122']."</b>";
 }
}


if (!empty($_POST['del_proxy'])) {
 if (!empty($_POST['delete_proxy']))
 {
 	if (is_array($_POST['delete_proxy']) && count($_POST['delete_proxy'])) {
	  foreach($_POST['delete_proxy'] as $nofilter) {
	    $result=dbquery("DELETE FROM ".$db_prefix."secsys_proxy_whitelist WHERE proxy_id='".$nofilter."'");
	  }
	  if ($result) {
	    redirect(FUSION_SELF."?pagefile=proxy_white");
    	}
	}  
 }
 else {
 $sys_error="<b>".$locale['SYS122']."</b>";
 }
}

if (!empty($_POST['del_proxy_black'])) {
 if (!empty($_POST['delete_proxy_black']))
 {
	  foreach($_POST['delete_proxy_black'] as $nofilter) {
	    $result=dbquery("DELETE FROM ".$db_prefix."secsys_proxy_blacklist WHERE proxy_id='".$nofilter."'");
	  }
	  if ($result) {
	    redirect(FUSION_SELF."?pagefile=proxy_black");
      }
 }
 else {
 $sys_error="<b>".$locale['SYS122']."</b>";
 }
}

if (!empty($_POST['active_proxy'])) {
 if (!empty($_POST['delete_proxy']))
 {
  foreach($_POST['delete_proxy'] as $nofilter) {
    $result=dbquery("UPDATE ".$db_prefix."secsys_proxy_whitelist SET proxy_status='1' WHERE proxy_id='".$nofilter."'");
  }
   if ($result) {
   redirect(FUSION_SELF."?pagefile=proxy_white");
   }
 }
 else {
 $sys_error="<b>".$locale['SYS219']."</b>";
 }
}

if (!empty($_POST['black_proxy'])) {
 if (!empty($_POST['delete_proxy']))
 {
  foreach($_POST['delete_proxy'] as $nofilter) {
    $res=dbarray(dbquery("SELECT proxy_ip FROM {$db_prefix}secsys_proxy_whitelist WHERE proxy_id='$nofilter'"));
    $newfilter=$res['proxy_ip'];
    $plcounter=dbrows(dbquery("SELECT proxy_id FROM ".$db_prefix."secsys_proxy_blacklist WHERE proxy_ip='".$newfilter."'"));
    if ($plcounter==0) {
    $result=dbquery("INSERT INTO ".$db_prefix."secsys_proxy_blacklist (proxy_ip,proxy_datestamp) VALUES ('".$newfilter."','".time()."')");
    } else {
		$result=true;
	}	
    if ($result) {
    $result2=dbquery("DELETE FROM ".$db_prefix."secsys_proxy_whitelist WHERE proxy_id='".$nofilter."'");
    } else {
    if ($result2) {
	redirect(FUSION_SELF."?pagefile=proxy_white");
   }}
  }
 }
 else {
 $sys_error="<b>".$locale['SYS219']."</b>";
 }
}
if (!empty($_POST['deactive_proxy'])) {
 if (!empty($_POST['delete_proxy']))
 {
  foreach($_POST['delete_proxy'] as $nofilter) {
    $result=dbquery("UPDATE ".$db_prefix."secsys_proxy_whitelist SET proxy_status='0' WHERE proxy_id='".$nofilter."'");
    
  }
  if ($result) {
   redirect(FUSION_SELF."?pagefile=proxy_white");
   }
 }
 else {
 $sys_error="<b>".$locale['SYS219']."</b>";
 }
}

if (!empty($_POST['active_filter'])) {
 if (!empty($_POST['delete_filter']))
 {
  foreach($_POST['delete_filter'] as $nofilter) {
    $result=dbquery("UPDATE ".$db_prefix."secsys_filter SET active='1' WHERE id='".$nofilter."'");
    
  }
  if ($result) {
   redirect(FUSION_SELF."?pagefile=filterlist");
   }
 }
 else {
 $sys_error="<b>".$locale['SYS219']."</b>";
 }
}

if (!empty($_POST['deactive_filter'])) {
 if (!empty($_POST['delete_filter']))
 {
  foreach($_POST['delete_filter'] as $nofilter) {
    $result=dbquery("UPDATE ".$db_prefix."secsys_filter SET active='0' WHERE id='".$nofilter."'");
    
  }
  if ($result) {
   redirect(FUSION_SELF."?pagefile=filterlist");
   }
 }
 else {
 $sys_error="<b>".$locale['SYS219']."</b>";
 }
}

if (!empty($_POST['insert_proxy'])) {
   if (!empty($_POST['new_proxy_white1'])) {
   $newproxyname1=isset($_POST['new_proxy_white1']) ? stripinput($_POST['new_proxy_white1']) : "";
   $newproxyname2=isset($_POST['new_proxy_white2']) ? stripinput($_POST['new_proxy_white2']) : "";
   $newproxyname3=isset($_POST['new_proxy_white3']) ? stripinput($_POST['new_proxy_white3']) : "";
   $newproxyname4=isset($_POST['new_proxy_white4']) ? stripinput($_POST['new_proxy_white4']) : "";
   $newproxyname=$newproxyname1!="" ? $newproxyname1.".".($newproxyname2!="" ? $newproxyname2."." : "").($newproxyname3!="" ? $newproxyname3."." : "").($newproxyname4!="" ? $newproxyname4 : "") : "";
      
   $newproxy_check=dbrows(dbquery("SELECT proxy_ip from ".$db_prefix."secsys_proxy_whitelist WHERE proxy_ip='".$newproxyname."'"));
    if ($newproxy_check==0) {
    $result=dbquery("INSERT INTO ".$db_prefix."secsys_proxy_whitelist (proxy_ip,proxy_datestamp) VALUES ('".$newproxyname."','".time()."')");
     if ($result) {
     redirect(FUSION_SELF."?pagefile=proxy_white");
     }
    }
    else {
    $sys_error=$locale['PROXY011'];
    }
   }
   else {
    $sys_error=$locale['PROXY010'];
   }
}

if (!empty($_POST['insert_proxy_black'])) {
   if (!empty($_POST['new_proxy_black1'])) {
   $newproxyname1=isset($_POST['new_proxy_black1']) ? stripinput($_POST['new_proxy_black1']) : "";
   $newproxyname2=isset($_POST['new_proxy_black2']) ? stripinput($_POST['new_proxy_black2']) : "";
   $newproxyname3=isset($_POST['new_proxy_black3']) ? stripinput($_POST['new_proxy_black3']) : "";
   $newproxyname4=isset($_POST['new_proxy_black4']) ? stripinput($_POST['new_proxy_black4']) : "";
   $newproxyname=$newproxyname1!="" ? $newproxyname1.".".($newproxyname2!="" ? $newproxyname2."." : "").($newproxyname3!="" ? $newproxyname3."." : "").($newproxyname4!="" ? $newproxyname4 : "") : "";

   $newproxy_check=dbrows(dbquery("SELECT proxy_ip from ".$db_prefix."secsys_proxy_blacklist WHERE proxy_ip='".$newproxyname."'"));
    if ($newproxy_check==0) {
    $result=dbquery("INSERT INTO ".$db_prefix."secsys_proxy_blacklist (proxy_ip,proxy_datestamp) VALUES ('".$newproxyname."','".time()."')");
     if ($result) {
     redirect(FUSION_SELF."?pagefile=proxy_black");
     }
    }
    else {
    $sys_error=$locale['PROXY011'];
    }
   }
   else {
    $sys_error=$locale['PROXY010'];
   }
}

if (!empty($_POST['insert_filter'])) {
   if (!empty($_POST['new_filter'])) {
   $filtername=strtolower($_POST['new_filter']);
   $filter_check=dbrows(dbquery("SELECT list from ".$db_prefix."secsys_filter WHERE list='".$filtername."'"));
    if ($filter_check==0) {
    $result=dbquery("INSERT INTO ".$db_prefix."secsys_filter (id,list) VALUES (NULL,'".$new_filter."')");
     if ($result) {
     redirect(FUSION_SELF."?pagefile=filterlist");
     }
    }
    else {
    $sys_error=$locale['SYS158'];
    }
   }
   else {
    $sys_error=$locale['SYS159'];
   }
}

if (!empty($_POST['del_spam'])) {
 if (!empty($_POST['delete_spamword']))
 {
  foreach($_POST['delete_spamword'] as $nospam) {
    $result=dbquery("DELETE FROM ".$db_prefix."secsys_spamfilter WHERE spam_id='".$nospam."'");
  }
  if ($result) {
   redirect(FUSION_SELF."?pagefile=spamlist");
   }
 }
 else {
 $sys_error="<b>".$locale['SYS122']."</b>";
 }
}

if (!empty($_POST['insert_spam'])) {
   if (!empty($_POST['new_spam'])) {
   $filtername=strtolower($_POST['new_spam']);
   $filter_check=dbrows(dbquery("SELECT list from ".$db_prefix."secsys_spamfilter WHERE spam_word='".$filtername."'"));
    if ($filter_check==0) {
    $result=dbquery("INSERT INTO ".$db_prefix."secsys_spamfilter (spam_id,spam_word) VALUES (NULL,'".stripinput($new_spam)."')");
     if ($result) {
     redirect(FUSION_SELF."?pagefile=spamlist");
     }
    }
    else {
    $sys_error=$locale['SYS158'];
    }
   }
   else {
    $sys_error=$locale['SYS163'];
   }
}
if (!empty($_POST['del_logfile'])) {
 if (!empty($_POST['delete_logfile']))
 {

  foreach($_POST['delete_logfile'] as $nolog) {
    $result=dbquery("DELETE FROM ".$db_prefix."secsys_logfile WHERE hack_id='".$nolog."'");
  }
  if ($result) {
   redirect(FUSION_SELF."?pagefile=logfiles");
   }
}
 else {
 $sys_error="<b>".$locale['SYS122']."</b>";
 }
}

if (!empty($_POST['sys_settings'])) {
  $new_secsys_started=(isNum($_POST['new_secsys_started'])? $_POST['new_secsys_started'] : "1");  
  $new_forumtime=(isNum($_POST['new_fctime'])? $_POST['new_fctime'] : "120");
  $new_shouttime=(isNum($_POST['new_sctime'])? $_POST['new_sctime'] : "60");
  $new_commenttime=(isNum($_POST['new_cctime'])? $_POST['new_cctime'] : "60");
  $new_pmtime=(isNum($_POST['new_mctime'])? $_POST['new_mctime'] : "240");
  $new_contacttime=(isNum($_POST['new_coctime'])? $_POST['new_coctime'] : "240");
  $new_gbtime=(isNum($_POST['new_gctime'])? $_POST['new_gctime'] : "86400");
  $new_userlock=(isNum($_POST['new_userlock'])? $_POST['new_userlock'] : "0");
  $new_userattempts=(isNum($_POST['new_userattempts'])? $_POST['new_userattempts'] : "3");
  $new_flood_active=(isNum($_POST['new_flood_active'])? $_POST['new_flood_active'] : "1");
  $new_forum_access=(isNum($_POST['new_forum_access'])? $_POST['new_forum_access'] : "102");
  $new_shout_access=(isNum($_POST['new_shout_access'])? $_POST['new_shout_access'] : "102");
  $new_comment_access=(isNum($_POST['new_comment_access'])? $_POST['new_comment_access'] : "102");
  $new_contact_access=(isNum($_POST['new_contact_access'])? $_POST['new_contact_access'] : "101");
  $new_pm_access=(isNum($_POST['new_pm_access'])? $_POST['new_pm_access'] : "102");
  $new_gb_access=(isNum($_POST['new_gb_access'])? $_POST['new_gb_access'] : "102");
  $new_panel_set=(isNum($_POST['new_panel_set'])? $_POST['new_panel_set'] : "1");
  $new_proxy_visit=(isNum($_POST['new_proxy_visit'])? $_POST['new_proxy_visit'] : "1");
  $new_proxy_register=(isNum($_POST['new_proxy_register'])? $_POST['new_proxy_register'] : "1");
  $new_proxy_login=(isNum($_POST['new_proxy_login'])? $_POST['new_proxy_login'] : "1");
  $new_ctracker_log=(isNum($_POST['newctrackerlog'])? $_POST['newctrackerlog'] : "1");
  $new_filter_log=(isNum($_POST['newfilterlog'])? $_POST['newfilterlog'] : "1");
  $new_spam_log=(isNum($_POST['newspamlog'])? $_POST['newspamlog'] : "1");
  $new_flood_log=(isNum($_POST['newfloodlog'])? $_POST['newfloodlog'] : "1");
  $new_proxy_log=(isNum($_POST['newproxylog'])? $_POST['newproxylog'] : "1");
  $new_log_autodelete=(isNum($_POST['newautodeletelog'])? $_POST['newautodeletelog'] : "1");
  $new_log_max=(isNum($_POST['newmaxlog'])? $_POST['newmaxlog'] : "500");
  $new_log_expired=(isNum($_POST['newlogexpired'])? $_POST['newlogexpired'] : "30");

  $result=dbquery("UPDATE ".$db_prefix."secsys_settings SET
  secsys_started='$new_secsys_started',
  proxy_visit='$new_proxy_visit',
  proxy_register='$new_proxy_register',
  proxy_login='$new_proxy_login',
  fctime='$new_forumtime',
  sctime='$new_shouttime',
  cctime='$new_commenttime',
  mctime='$new_pmtime',
  gctime='$new_gbtime',
  coctime='$new_contacttime',
  userlock='$new_userlock',
  user_attempts='$new_userattempts',
  flood_active='$new_flood_active',
  forum_access='$new_forum_access',
  shout_access='$new_shout_access',
  comment_access='$new_comment_access',
  pm_access='$new_pm_access',
  contact_access='$new_contact_access',
  gb_access='$new_gb_access',
  ctracker_log='$new_ctracker_log',
  filter_log='$new_filter_log',
  spam_log='$new_spam_log',
  flood_log='$new_flood_log',
  proxy_log='$new_proxy_log',
  log_autodelete='$new_log_autodelete',
  log_max='$new_log_max',
  log_expired='$new_log_expired',
  panel_set='$new_panel_set'
  ");
  if (isset($_POST['new_floodinterval']) && isNum($_POST['new_floodinterval'])) {
  $result=dbquery("UPDATE ".$db_prefix."settings SET flood_interval='".$_POST['new_floodinterval']."'");
   if ($result) {
   redirect(FUSION_SELF."?pagefile=settings");
   }
  }
}
if (!empty($_POST['unlock_users'])) {
 if (!empty($_POST['unlock_user']))
 {
  foreach($_POST['unlock_user'] as $free_user) {
    $result=dbquery("UPDATE ".$db_prefix."users SET user_status='0' WHERE user_id='".$free_user."'");
    $result=dbquery("DELETE FROM ".$db_prefix."secsys_membercontrol WHERE c_user_id='".$free_user."'");
  }
  if ($result) {
    redirect(FUSION_SELF."?pagefile=userlocked");
   }
 }
 else {
 $sys_error="<b>".$locale['SYS122']."</b>";
 }
}

if (!empty($_POST['accept_license'])) {
  $result=dbquery("UPDATE ".$db_prefix."secsys_settings SET
  license_accept='1'
  ");
  redirect(FUSION_SELF);
}
if (isset($_POST['clean_logtable']) && (md5($_POST['clean_logtable'])==$userdata['user_password'] || md5(md5($_POST['clean_logtable']))==$userdata['user_password'])) {
$result=dbquery("TRUNCATE TABLE ".DB_PREFIX."secsys_logfile");
  if ($result) {
   redirect(FUSION_SELF."?pagefile=overview");
   }
}
?>
