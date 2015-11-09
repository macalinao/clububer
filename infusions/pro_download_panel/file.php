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
if(!$download->can_download) {
	$download->fallback_download();
}

/*
if(function_exists("pdp_start_download")) {
	pdp_start_download($download->id);
}
*/



if(isset($_GET['file_id']) && isNum($_GET['file_id'])) {
	$file_id = $_GET['file_id'];
} else {
	$file_id = 0;
}



/*
 *
 */
if($file_id) {
	$res = dbquery("SELECT file_id, file_url
		FROM ".DB_PDP_FILES."
		WHERE file_id='$file_id' AND download_id='".$download->id."'
			AND file_status='0'");
	if(!dbrows($res)) {
		$download->fallback_download();
	}
	$file = dbarray($res);
} else {
	$res = dbquery("SELECT file_id, file_url
		FROM ".DB_PDP_FILES."
		WHERE download_id='".$download->id."' AND file_status='0'
		ORDER BY file_timestamp DESC
		LIMIT 1");
	if(!dbrows($res)) {
		$download->fallback_download();
	}
	$file = dbarray($res);
}

if($download->data['lizenz_okay']=='N' || isset($_GET['dlok'])) {
	$url = "";
	$filename = "";
	$parse_url = true;

	if($file_id && !empty($file['file_url'])) {
		$url = $file['file_url'];
	} elseif(!empty($download->data['down'])) {
		$url = $download->data['down'];
	} else {
		$url = $download->data['link_extern'];
		$parse_url = false;
	}

	if($parse_url) {
		if(pdp_is_external($url)) {
			$downlink = $url;
		} else {
			$downlink = $pdp->settings['upload_file'].$download->data['dir_files'].$url;
			$filename = pdp_cleanup_filename($url);
		}
	} else {
		$downlink = $url;
	}


	dbquery("UPDATE ".DB_PDP_DOWNLOADS."
		SET
		dl_count=dl_count+1
		WHERE download_id='".$download->id."'");
	dbquery("UPDATE ".DB_PDP_FILES."
		SET
		download_count=download_count+1
		WHERE file_id='".$file['file_id']."'
			AND download_id='".$download->id."'");

	if(empty($filename)) {
		fallback($downlink);
	} else {
		error_reporting(0);
		require_once(INCLUDES.'class.httpdownload.php');

//		@ini_set('zlib.output_compression', 'Off');
		while(@ob_end_clean());

		$object = new httpdownload;
		if(!$object->set_byfile($downlink)) {
			echo '<p>FIXME:FUCK.set_byfile()';
		}
		$object->use_resume = true;
		if(!$object->download()) {
			echo '<p>FIXME:FUCK!';
		}

		exit;
	}

// show license
} else {
	opentable($pdp->settings['title']);
	echo "<div align='text-align:center;'>
<p>
	<a href='download.php?did=".$download->id."'>"
		.$locale['PDP026']."</a>
</p>
</div>\n";;

	// get from database
	if($download->data['license_id']) {
		$res = dbquery("SELECT license_text, license_name"
			." FROM ".DB_PDP_LICENSES.""
			." WHERE license_id='".$download->data['license_id']."'");
		$data = dbarray($res);

		echo "<p><h2>".$data['license_name']."</h2>\n"
			."<div style='max-height:320px; overflow:auto;'"
				." class='textbox'>\n"
			.stripslash($data['license_text'])
			."\n</div>\n";

	//
	} else {
		if($download->data['lizenz_url']) {
			echo "<p><b>".$locale['PDP402']."</b>";
			echo "<p><b>".$locale['PDP404']."</b>";
			echo "<p><a href='http://".$download->data['lizenz_url']."'>"
				.$locale['pdp_license']."</a>";

		} else {
			echo "<b>\n";
			if($download->data['lizenz_packet']=="Y") {
				echo "<p>".$locale['PDP402'];
				echo "<p>".$locale['PDP403'];
			} else {
				echo "<p>".$locale['PDP406'];
			}
			echo "</b>\n";
		}
	}

	// confirm dialog
	echo "
<div align='center'>
<form method='GET' action='".FUSION_SELF."'>
<input type='hidden' name='did' value='".$download->id."'>
<input type='hidden' name='file_id' value='$file_id'>

<p>
	<label><input type='checkbox' name='dlok'> ".$locale['PDP400']."</label>
</p>

<p>
	<input type='submit' class='button' value='".$locale['PDP401']."'"
		." class='button' />
</p>

</form>
</div>\n";
	closetable();
require_once('include/die.php');
}

?>
