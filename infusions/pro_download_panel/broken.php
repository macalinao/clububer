<?php
/***************************************************************************
 *   Professional Download System                                          *
 *                                                                         *
 *   Copyright (C) pirdani                                                 *
 *   pirdani@hotmail.de                                                    *
 *   http://pirdani.de/                                                    *
 *                                                                         *
 *   Copyright (C) 2005 EdEdster (Stefan Noss)                             *
 *   http://edsterathome.de/                                               *
 *                                                                         *
 *   Copyright (C) 2006-2008 Artur Wiebe                                   *
 *   wibix@gmx.de                                                          *
 *   http://wibix.de/                                                      *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU General Public License as published by  *
 *   the Free Software Foundation; either version 2 of the License, or     *
 *   (at your option) any later version.                                   *
 ***************************************************************************/
require_once('include/common.php');
if(!$download->id) {
	fallback('download.php');
}
if(!iPDP_BROKEN) {
	$download->fallback_download();
}


opentable($locale['PDP140']);


if(isset($_GET['wrong_captcha'])) {
	show_info($locale['pdp_wrong_captcha']);
}


if(isset($_POST['really_send'])) {
	$do_pm = true;

	if(!check_captcha($_POST['captcha_encode'], $_POST['user_code'])) {
		fallback(FUSION_SELF.'?did='.$download->id.'&wrong_captcha=1');
	}

	if($pdp->settings['broken_count']) {
		$ok = dbquery("UPDATE ".DB_PDP_DOWNLOADS.""
			." SET dl_broken_count=dl_broken_count+1"
			." WHERE download_id='".$download->id."'"
				." AND dl_broken_count<".$pdp->settings['broken_count']."");
		$do_pm = mysql_affected_rows();
	}
	if($do_pm) {
		$download->log_event(PDP_EV_BROKEN, 0);
	}
	fallback(FUSION_SELF."?did=".$download->id."&ok=yes");
}

echo "<div align='center'>";
if(isset($_GET['ok'])) {
	echo '<p>'.$locale['PDP141'];
} else {

	echo parseubb(str_replace('%ip', USER_IP, $pdp->settings['broken_text']))
.'
<p></p>
<form action="'.FUSION_SELF.'?did='.$download->id.'" method="post">

<div>
'.make_captcha().'
<input type="text" class="textbox" name="user_code" size="5" />
</div>

<input type="submit" name="really_send" class="button" value="'.$locale['PDP144'].'" />
</form>';
}
echo '<p>
<a href="download.php?did='.$download->id.'">'.$locale['PDP035']."</a>
</p>
</div>";

closetable();


require_once('include/die.php');
?>
