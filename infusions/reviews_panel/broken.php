<?php
/***************************************************************************
 *   Professional Review System                                          *
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
if(!$review->id) {
	fallback('review.php');
}
if(!iPRP_BROKEN) {
	$review->fallback_review();
}


opentable($locale['PRP140']);


if(isset($_GET['wrong_captcha'])) {
	show_info($locale['prp_wrong_captcha']);
}


if(isset($_POST['really_send'])) {
	$do_pm = true;

	if(!check_captcha($_POST['captcha_encode'], $_POST['user_code'])) {
		fallback(FUSION_SELF.'?did='.$review->id.'&wrong_captcha=1');
	}

	if($prp->settings['broken_count']) {
		$ok = dbquery("UPDATE ".DB_PRP_DOWNLOADS.""
			." SET dl_broken_count=dl_broken_count+1"
			." WHERE review_id='".$review->id."'"
				." AND dl_broken_count<".$prp->settings['broken_count']."");
		$do_pm = mysql_affected_rows();
	}
	if($do_pm) {
		$review->log_event(PRP_EV_BROKEN, 0);
	}
	fallback(FUSION_SELF."?did=".$review->id."&ok=yes");
}

echo "<div align='center'>";
if(isset($_GET['ok'])) {
	echo '<p>'.$locale['PRP141'];
} else {

	echo parseubb(str_replace('%ip', USER_IP, $prp->settings['broken_text']))
.'
<p></p>
<form action="'.FUSION_SELF.'?did='.$review->id.'" method="post">

<div>
'.make_captcha().'
<input type="text" class="textbox" name="user_code" size="5" />
</div>

<input type="submit" name="really_send" class="button" value="'.$locale['PRP144'].'" />
</form>';
}
echo '<p>
<a href="review.php?did='.$review->id.'">'.$locale['PRP035']."</a>
</p>
</div>";

closetable();


require_once('include/die.php');
?>
