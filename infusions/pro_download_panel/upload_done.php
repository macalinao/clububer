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
if(!$download->can_edit) {
	fallback('download.php');
}
if($download->status!=PDP_PRO_NEW) {
	$download->fallback_download();
}
require_once("include/edit.php");


/*
 * ACTION
 */
if(isset($_GET['confirm'])) {
	$new_status = (($pdp->settings['need_verify']=="yes" && !iPDP_MOD)
		? PDP_PRO_CHECK : PDP_PRO_ON);
	$ok = $download->set_status($new_status);
	$download->log_event(PDP_EV_NEWDOWNLOAD, 0);
	if($ok) {
		if($new_status==PDP_PRO_ON) {
			$download->fallback_download();
		} else {
			fallback("profile.php?id=".$userdata['user_id']);
		}
	}
}


/*
 * GUI
 */
pdp_upload_step(5);

opentable($locale['PDP045']);
echo '
<p>
	'.$locale['PDP320'].'
</p>
<p>
	'.$locale['PDP321'].'
</p>
<p>
	[ <a href="'.FUSION_SELF.'?did='.$download->id.'&amp;confirm=1">'
		.'<strong>'.$locale['PDP322'].'</b></a> ]
</p>';

closetable();


require_once('include/die.php');
?>
