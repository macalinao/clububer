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
 *   Copyright (C) 2006-2007 Artur Wiebe                                   *
 *   wibix@gmx.de                                                          *
 *   http://wibix.de/                                                      *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU General Public License as published by  *
 *   the Free Software Foundation; either version 2 of the License, or     *
 *   (at your option) any later version.                                   *
 ***************************************************************************/
require_once('include/common.php');
if(!$review->can_edit) {
	fallback('review.php');
}
if($review->status!=PRP_PRO_NEW) {
	$review->fallback_review();
}
require_once("include/edit.php");


/*
 * ACTION
 */
if(isset($_GET['confirm'])) {
	$new_status = (($prp->settings['need_verify']=="yes" && !iPRP_MOD)
		? PRP_PRO_CHECK : PRP_PRO_ON);
	$ok = $review->set_status($new_status);
	$review->log_event(PRP_EV_NEWDOWNLOAD, 0);
	if($ok) {
		if($new_status==PRP_PRO_ON) {
			$review->fallback_review();
		} else {
			fallback("profile.php?id=".$userdata['user_id']);
		}
	}
}


/*
 * GUI
 */
prp_upload_step(5);

opentable($locale['PRP045']);
echo '
<p>
	'.$locale['PRP320'].'
</p>
<p>
	'.$locale['PRP321'].'
</p>
<p>
	[ <a href="'.FUSION_SELF.'?did='.$review->id.'&amp;confirm=1">'
		.'<strong>'.$locale['PRP322'].'</b></a> ]
</p>';

closetable();


require_once('include/die.php');
?>
