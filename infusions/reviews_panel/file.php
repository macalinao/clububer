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
if(!$review->can_review) {
	$review->fallback_review();
}

/*
if(function_exists("prp_start_review")) {
	prp_start_review($review->id);
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
		FROM ".DB_PRP_FILES."
		WHERE file_id='$file_id' AND review_id='".$review->id."'
			AND file_status='0'");
	if(!dbrows($res)) {
		$review->fallback_review();
	}
	$file = dbarray($res);
} else {
	$res = dbquery("SELECT file_id, file_url
		FROM ".DB_PRP_FILES."
		WHERE review_id='".$review->id."' AND file_status='0'
		ORDER BY file_timestamp DESC
		LIMIT 1");
	if(!dbrows($res)) {
		$review->fallback_review();
	}
	$file = dbarray($res);
}

if($review->data['lizenz_okay']=='N' || isset($_GET['dlok'])) {
	$url = "";
	$filename = "";
	$parse_url = true;

	if($file_id && !empty($file['file_url'])) {
		$url = $file['file_url'];
	} elseif(!empty($review->data['down'])) {
		$url = $review->data['down'];
	} else {
		$url = $review->data['link_extern'];
		$parse_url = false;
	}

	if($parse_url) {
		if(prp_is_external($url)) {
			$downlink = $url;
		} else {
			$downlink = $prp->settings['upload_file'].$review->data['dir_files'].$url;
			$filename = prp_cleanup_filename($url);
		}
	} else {
		$downlink = $url;
	}


	dbquery("UPDATE ".DB_PRP_DOWNLOADS."
		SET
		dl_count=dl_count+1
		WHERE review_id='".$review->id."'");
	dbquery("UPDATE ".DB_PRP_FILES."
		SET
		review_count=review_count+1
		WHERE file_id='".$file['file_id']."'
			AND review_id='".$review->id."'");

	if(empty($filename)) {
		fallback($downlink);
	} else {
		error_reporting(0);
		require_once(INCLUDES.'class.httpreview.php');

//		@ini_set('zlib.output_compression', 'Off');
		while(@ob_end_clean());

		$object = new httpreview;
		if(!$object->set_byfile($downlink)) {
			echo '<p>FIXME:FUCK.set_byfile()';
		}
		$object->use_resume = true;
		if(!$object->review()) {
			echo '<p>FIXME:FUCK!';
		}

		exit;
	}

// show license
} else {
	opentable($prp->settings['title']);
	echo "<div align='text-align:center;'>
<p>
	<a href='review.php?did=".$review->id."'>"
		.$locale['PRP026']."</a>
</p>
</div>\n";;

	// get from database
	if($review->data['license_id']) {
		$res = dbquery("SELECT license_text, license_name"
			." FROM ".DB_PRP_LICENSES.""
			." WHERE license_id='".$review->data['license_id']."'");
		$data = dbarray($res);

		echo "<p><h2>".$data['license_name']."</h2>\n"
			."<div style='max-height:320px; overflow:auto;'"
				." class='textbox'>\n"
			.stripslash($data['license_text'])
			."\n</div>\n";

	//
	} else {
		if($review->data['lizenz_url']) {
			echo "<p><b>".$locale['PRP402']."</b>";
			echo "<p><b>".$locale['PRP404']."</b>";
			echo "<p><a href='http://".$review->data['lizenz_url']."'>"
				.$locale['prp_license']."</a>";

		} else {
			echo "<b>\n";
			if($review->data['lizenz_packet']=="Y") {
				echo "<p>".$locale['PRP402'];
				echo "<p>".$locale['PRP403'];
			} else {
				echo "<p>".$locale['PRP406'];
			}
			echo "</b>\n";
		}
	}

	// confirm dialog
	echo "
<div align='center'>
<form method='GET' action='".FUSION_SELF."'>
<input type='hidden' name='did' value='".$review->id."'>
<input type='hidden' name='file_id' value='$file_id'>

<p>
	<label><input type='checkbox' name='dlok'> ".$locale['PRP400']."</label>
</p>

<p>
	<input type='submit' class='button' value='".$locale['PRP401']."'"
		." class='button' />
</p>

</form>
</div>\n";
	closetable();
require_once('include/die.php');
}

?>
