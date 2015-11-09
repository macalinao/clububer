<?php
/***************************************************************************
 *   awEventCalendar                                                       *
 *                                                                         *
 *   Copyright (C) 2006-2008 Artur Wiebe                                   *
 *   wibix@gmx.de                                                          *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU General Public License as published by  *
 *   the Free Software Foundation; either version 2 of the License, or     *
 *   (at your option) any later version.                                   *
 ***************************************************************************/
if(!defined('IN_FUSION')) {
	die;
}



$can_admin = (iAWEC_ADMIN
        || (iMEMBER && $event['user_id']==$userdata['user_id']));
$cur_logins = ff_db_count("(*)", AWEC_DB_LOGINS,
	"(ev_id='".$event['ev_id']."' AND login_status='1')");
$max_logins = $event['ev_max_logins'];


/****************************************************************************
 * FUNCS
 */
function send_pm($to_id, $subject, $body, $smilies)
{
	global $locale, $userdata, $settings;

	if(iMEMBER) {
		$from_id = $userdata['user_id'];
	} else {
		$from_id = 0;
	}
	if(!$to_id || $from_id==$to_id) {
		return true;
	}

	// get user
	$res = dbquery("SELECT user_name, user_email
		FROM ".DB_USERS."
		WHERE user_id='".$to_id."'");
	if(!dbrows($res)) {
		return false;
	}
	$data = dbarray($res);

	// send pm
	$ok = dbquery("INSERT INTO ".DB_MESSAGES."
		SET
		message_to='".$to_id."',
		message_from='".$from_id."',
		message_subject='".stripinput($subject)."',
		message_message='".stripinput($body)."',
		message_smileys='".($smilies ? '1' : '0')."',
		message_read='0',
		message_datestamp='".time()."'");

	// FIXME: inform about NEW PM!


/*FIXME
	// send mail
	require_once(INCLUDES."sendmail_include.php");
	$type = "plain";

	$body = $subject;
	$body .= "\n\n";
	$body .= stripinput($locale['PDP902']['body'][$pm_type]);
	$body .= "\n\n";
	$body .= $locale['PDP026'].": ".$settings['siteurl']
		."infusions/pro_download_panel/download.php"
		."?did=".$this->id;
	$body .= "\n\n";

	sendemail($data['user_name'], $data['user_email'],
		$settings['siteusername'],
		$settings['siteemail'],
		$subject, strip_tags(nl2br(parseubb($body))), $type);
*/
	return true;
}



/****************************************************************************
 * ACTION
 */
if(isset($_POST['status']) && $can_login) {
	$status = stripinput($_POST['status']);
	if($status>=1 && $status<=3) {
		$comm = stripinput($_POST['comment']);
		if($event['ev_max_logins'] && $cur_logins>=$max_logins) {
			$ok = dbquery("UPDATE ".AWEC_DB_LOGINS."
				SET
				login_status='".$status."',
				login_comment='".$comm."',
				login_timestamp='".time()."'
				WHERE user_id='".$userdata['user_id']."'
				AND ev_id='".$event['ev_id']."'");
		} else {
			$ok = dbquery("REPLACE INTO ".AWEC_DB_LOGINS."
				SET
				ev_id='".$event['ev_id']."',
				user_id='".$userdata['user_id']."',
				login_status='".$status."',
				login_comment='".$comm."',
				login_timestamp='".time()."'");
		}
	} elseif($status==4) {
		$ok = dbquery("DELETE FROM ".AWEC_DB_LOGINS."
			WHERE ev_id='".$event['ev_id']."'
				AND user_id='".$userdata['user_id']."'");
	} else {
		fallback(FUSION_SELF.'?id='.$event['ev_id'].'&errno=2');
	}
	fallback(FUSION_SELF.'?id='.$event['ev_id'].($ok ? '' : '&errno=3'));


} elseif(isset($_GET['action']) && $_GET['action']=='delete'
	&& isset($_GET['user_id']) && isNum($_GET['user_id']) && $can_admin) {
	dbquery("DELETE FROM ".AWEC_DB_LOGINS."
		WHERE ev_id='".$event['ev_id']."'
			AND user_id='".$_GET['user_id']."'");
	fallback(FUSION_SELF.'?id='.$event['ev_id']);


} elseif(isset($_POST['invite']) && $can_admin) {
	if($_POST['send_pm']) {
		$title = $locale['awec_invite_title'];
		$body = $locale['awec_invite_body'].'
		
[url]'.$settings['siteurl'].'infusions/aw_ecal_panel/view_event.php?id='.$event['ev_id'].'[/url]';
	}

	foreach($_POST['users'] as $user) {
		$user = intval($user);
		if(!$user) {
			continue;
		}
		dbquery("INSERT INTO ".AWEC_DB_LOGINS."
			SET
			login_status='4',
			login_timestamp='".time()."',
			user_id='".$user."',
			ev_id='".$event['ev_id']."'");

		if($_POST['send_pm']) {
			send_pm($user, $title, $body, true);
		}
	}
	fallback(FUSION_SELF.'?id='.$event['ev_id']);
}



/****************************************************************************
 * GUI: logins
 */
echo '<a name="logins"></a>';
//opentable($locale['awec_logins']);
if(!$can_login || ($cur_logins>=$max_logins && $event['ev_max_logins']!=0)) {
	show_info($locale['EC114']);
}
if(isset($_GET['sent'])) {
	show_info($locale['EC320']);
}



if($can_admin) {
	$tabs = array(
		'logins'	=> $locale['awec_logins'],
		'invite'	=> $locale['EC322'],
		'email'		=> $locale['EC313'],
	);
	awec_tabs($tabs);
}


awec_open_tab('logins', $locale['awec_logins']);


$my_login = false;


// others login
$res = dbquery("SELECT kl.*, fu.user_name
	FROM ".AWEC_DB_LOGINS." AS kl
	LEFT JOIN ".DB_USERS." AS fu ON kl.user_id=fu.user_id
	WHERE ev_id='".$event['ev_id']."'
	ORDER BY kl.login_status ASC");
// count different logins
$count_types = array();
foreach($locale['EC309'] as $sid => $stext) {
	$count_types[$sid] = 0;
}
$the_whole_table = "";
$new_status = "";
$count = 1;
$users_in_list = array();
while($user = dbarray($res)) {
	$count_types[$user['login_status']]++;
	$users_in_list[] = $user['user_id'];

	if(iMEMBER && $user['user_id']==$userdata['user_id']) {
		$my_login = $user;
	}

	if($user['login_status'] != $new_status) {
		$new_status = $user['login_status'];
		$the_whole_table .=  '
<tr>
	<th colspan="4">'.$locale['EC309'][$user['login_status']].'</th>
</tr>';
		$count = 1;
	}

	$the_whole_table .= '
<tr class="tbl'.(++$count%2 + 1).'">
	<td><a href="'.BASEDIR.'profile.php?lookup='.$user['user_id'].'">'
		.$user['user_name'].'</a></td>
	<td>'.$user['login_comment'].'</td>
	<td>'.showdate('shortdate', $user['login_timestamp']).'</td>
	<td>';
	if($can_admin) {
		$the_whole_table .= '
		<a href="'.FUSION_SELF.'?id='.$event['ev_id']
			.'&action=delete&user_id='.$user['user_id'].'"'
				.' onclick="return ec_confirm_delete();">'
				.$locale['EC305'].'</a>';
	}
	$the_whole_table .= '
	</td>
</tr>';
}

// status
$stats = array();
foreach($locale['EC309'] as $sid => $stext) {
	if($sid) {
		$stats[$stext] = $count_types[$sid];
	}
}



echo '
<table border="0" width="100%">
<tbody>
<tr>
	<td valign="top">';


// display!
echo '
<table class="tbl-border" cellspacing="1" border="0">
<tbody>
<tr>
	<th style="text-align:right;">'.$locale['awec_logins'].':</th>
	<th>
		'.$cur_logins.($event['ev_max_logins']
				? '/'.$event['ev_max_logins']
				: '').'
	</th>
</tr>';
foreach($stats as $label => $value) {
	echo '
<tr>
	<td class="tbl2" style="text-align:right;">'.$label.':</td>
	<td class="tbl1">'.$value.'</td>
</tr>';
}
echo '
</tbody>
</table>';


echo '
	</td>
	<td valign="top">';


// my login
if(iMEMBER) {
	if(is_array($my_login)) {
		echo '
<p>
<div style="text-align:center">
	<strong>'.$locale['EC311'].':</strong> '
		.$locale['EC309'][$my_login['login_status']].'
</div>
</p>';
	} else {
		$my_login['login_status'] = 1;
		$my_login['login_comment'] = '';
	}
	if($can_login
		&& (!$event['ev_max_logins']
		|| ($cur_logins<$max_logins || dbrows($res))))
	{
		$radio_status = '';
		foreach($locale['EC310'] as $sid => $stext) {
			$radio_status .= '
<label><input type="radio" value="'.$sid.'" name="status"'
	.($sid==$my_login['login_status']
		? ' checked="checked"'
		: ''
	).' /> '.$stext.'</label>';
		}

		echo '
<hr />

<form method="post" action="'.FUSION_SELF.'?id='.$event['ev_id'].'">
<div style="text-align: center;">
<label>'.$locale['EC312'].':
<input type="text" size="50" class="textbox" name="comment"
	value="'.$my_login['login_comment'].'" maxlength="50">

<input type="submit" class="button" value="'.$locale['EC111'].'">

<p>
'.$radio_status.'
</p>
</div>
</form>';
	}
}


echo '
	</td>
</tr>
</tbody>
</table>';





echo '
<table border="0" cellspacing="1" width="100%" class="tbl-border">
<colgroup>
	<col width="20%" />
	<col width="30%" />
	<col width="10%" />
	<col width="10%" />
</colgroup>
<tbody>'
	.$the_whole_table
	.'
</table>';
//closetable();
awec_close_tab();


if(!$can_admin) {
	return;
}



/****************************************************************************
 * INVITE
 */
awec_open_tab('invite', $locale['EC322']);


$grp = $event['ev_login_access'];
$query = "SELECT user_id, user_name
	FROM ".DB_USERS."
	WHERE user_status='0'";
// aha, group
if($grp) {
	if($grp < 101) {
		$query .= " AND user_groups REGEXP('^\\\.{$grp}$|\\\.{$grp}\\\.|\\\.{$grp}$')";
	// user, level
	} else {
		$query .= " AND user_level>='$grp'";
	}
}
$query .= " ORDER BY user_name ASC";
$res = dbquery($query);
$sel_users = "";
while($data = dbarray($res)) {
	if(!in_array($data['user_id'], $users_in_list)) {
		$sel_users .= "<option value='".$data['user_id']."'>"
			.$data['user_name']."</option>\n";
	}
}

echo '
<form method="post" action="'.FUSION_SELF.'?id='.$event['ev_id'].'">
<div style="text-align: center;">
<span class="small2">'.$locale['EC323'].'</span><br />
<select class="textbox" name="users[]" size="10" multiple="multiple">'
	.$sel_users.'</select>

<p>
<label><input type="checkbox" name="send_pm" id="sp0"'
	.($awec_settings['invite_pm']
		? ' checked="checked"'
		: ''
	).' /> '.$locale['EC324'].'</label>
</p>

<input type="submit" class="button" name="invite" value="'.$locale['EC322'].'">
</div>
</form>';
//closetable();
awec_close_tab();



/****************************************************************************
 * GUI: mail
 */
echo '<a name="mail"></a>';
awec_open_tab('email', $locale['EC313']);

if(isset($_POST['mail'])) {
	$errors = 0;

	$who = array();
	if(isset($_POST['who'])) {
		foreach($_POST['who'] as $val) {
			$who[] = "login_status='".intval($val)."'";
		}
	}
	if(count($who)==0) {
		$errors++;
		$err_str = $locale['EC115'][4];
	}

	if(!$errors) {
		$res = dbquery("SELECT user_name, user_email
			FROM ".AWEC_DB_LOGINS."
			LEFT JOIN ".DB_USERS." USING(user_id)
			WHERE ev_id='".$event['ev_id']."'
				AND (".implode(' OR ', $who).")");
		if(!dbrows($res)) {
			$errors++;
			$err_str = $locale['EC115'][4];
		}
	}

	if($errors) {
		echo '<p>
<div style="text-align:center;"><strong>'.$err_str.'</strong></div></p>';
	} else {
		require_once(INCLUDES.'sendmail_include.php');


		$body = stripinput($_POST['body']).'


<h1>'.$event['ev_title'].'</h1>

<h1>'.$locale['awec_description'].'</h1>
<i>'.$event['date'].'</i>';

		if($event['start_time']) {
			$body .= "\n<i>".$event['start_time'];
			if($event['end_time']) {
				$body .= ' - '.$event['end_time'];
			}
			$time .= "</i>\n";
		}

		$url = $settings['siteurl'].'infusions/aw_ecal_panel/view_event.php?id='.$event['ev_id'];
		$body .= "\n".str_replace(AWEC_BREAK, '', $event['ev_body']).'

'.$locale['awec_link'].': <a href="'.$url.'">'.$url.'</a>';

		$body = parseubb($body);

		if(isset($_POST['html'])) {
			$type = 'html';
			$body = nl2br($body);
		} else {
			$type = 'plain';
			$body = strip_tags($body);
		}

		$one_to_all = (isset($_POST['one_to_all'])
			? $_POST['one_to_all']
			: false);

		$mail_addr = array();
		while($data = dbarray($res)) {
			if(!$one_to_all) {
				sendemail($data['user_name'], $data['user_email'],
					$settings['siteusername'],
					$settings['siteemail'],
					$event['ev_title'], $body, $type);
			} else {
				$mail_addr[$data['user_name']] = $data['user_email'];
			}
		}

		if($one_to_all) {
			sendemail($locale['awec_all'], implode(',', $mail_addr),//FIXME
				$settings['siteusername'], $settings['siteemail'],
				$event['ev_title'], $body, $type);
		}

		fallback(FUSION_SELF.'?id='.$event['ev_id'].'&sent=1#mail');
	}
}

/* GUI */
if(defined('IN_FF')) {
?>
<script type="text/javascript">
FF.behaviors.awec_who_all = function(content){
//	$("#who_all").click
//	$("#who_all").click(function() {
//		$("#who_1")[0].disabled = this.checked;
//		$("#who_2")[0].checked = this.checked;
//		$("#who_3")[0].checked = this.checked;
//		$("#who_4")[0].checked = this.checked;
//		alert(this.checked+" - "+$("#who_1")[0].checked);
//	});

	$("#who_all").click(function() {
		if(this.checked) {
			$("#who_options").fadeOut('slow');
		} else {
			$("#who_options").show('fast');
		}
	});
};
</script>
<?php
}
$who = '<label><input type="checkbox" name="who_all" id="who_all" /> '
	.$locale['awec_all'].'</label>
<span id="who_options">';
foreach($locale['EC309'] as $sid => $stext) {
	if($sid) {
		$who .= '
<label><input type="checkbox" name="who[]" value="'.$sid.'" />
'.$stext.'</label>';
	}
}
$who .= '
</span>';


echo '
<form method="post" action="'.FUSION_SELF.'?id='.$event['ev_id'].'#mail" name="inputform">
<p>
'.$who.'
</p>

<div style="text-align:center;">
'.awec_get_bb_smileys('body', '', '', true).'

<p>
<label><input type="radio" name="one_to_all" value="0" /> '
	.$locale['EC314'].'</label>
<label><input type="radio" name="one_to_all" value="1" checked="checked" /> '
	.$locale['EC315'].'</label>
</p>

<p>
	<label><input type="checkbox" name="html" checked="checked" /> '
		.$locale['EC321'].'</label>
</p>

<p>
	<input type="submit" class="button" name="mail" value="'.$locale['EC316'].'">
</p>
</div>
</form>';

awec_close_tab();

awec_tabs_close();

//closetable();


?>
