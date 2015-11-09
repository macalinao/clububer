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
require_once('include/common.php');

if(isset($_GET['stext'])) {
	$swords = preg_split("/\s+/", trim(stripinput($_GET['stext'])));
	$stext = trim(stripinput($_GET['stext']));
	// verify not too short
	$to_short = false;
	foreach($swords as $val) {
		if(strlen($val) < 3) {
			$to_short = true;
			break;
		}
	}
	if($to_short) {
		$swords = array();
//		unset($stext);
	}
} else {
	$swords = array();
	unset($stext);
}

if(isset($_GET['link'])) {
	if($_GET['link']=="AND") {
		$link = 'AND';
	} elseif($_GET['link']=="OR") {
		$link = 'OR';
	} else {
		$link = '';
	}
} else {
	$link = "";
}


/*
 * GUI
 */
opentable($locale['EC011']);
awec_menu();


$st = (isset($stext) ? $stext : "");


echo '
<form method="get" action="'.FUSION_SELF.'">
<label for="stext">'.$locale['EC550'].':</label>
<input type="text" name="stext" id="stext" class="textbox" value="'.$st.'" />
<input type="submit" class="button" value="'.$locale['EC011'].'" />

<div>
<label>'.$locale['awec_options'].':</label>
<label><input type="radio" name="link" value="'
	.($link==''
		? ' checked="checked"'
		: ''
	).' />'.$locale['EC551']['-'].'<label>
<label><input type="radio" name="link" value="AND"'
	.($link=='AND'
		? ' checked="checked"'
		: ''
	).' />'.$locale['EC551']['AND'].'<label>
<label><input type="radio" name="link" value="OR"'
	.($link=='AND'
		? ' checked="checked"'
		: ''
	).' />'.$locale['EC551']['OR'].'<label>
</div>

</form>';


if(count($swords)) {
	echo '<p>
<strong>'.$locale['EC550'].':</strong> '
		.(empty($link)
			? $stext
			: implode(" ".$locale['EC551'][$link]." ", $swords)
		).'
</p>';

	if(empty($link)) {
		$search_string = "ev_title LIKE '%$stext%'"
			." OR ev_body LIKE '%$stext%'";
	} else {
		$search_string = array();
		foreach($swords as $word) {
			$search_string[] = "ev_title LIKE '%$word%'"
				." OR ev_body LIKE '%$word%'";
		}
		$search_string = implode(" $link ", $search_string);
	}

	// access - edit group - no access limit
	if(iAWEC_ADMIN) {
		$access = "";
	} elseif(iMEMBER) {
		$access = " AND (((ev_status='".AWEC_PUBLISHED."' AND ev_private='0')"
			." OR user_id='".$userdata['user_id']."')"
			." AND ".groupaccess("ev_access").")";
	} else {
		$access = " AND ((ev_status='".AWEC_PUBLISHED."' AND ev_private='0')"
			." AND ev_access='0')";
	}

	$res = dbquery("SELECT DAYOFMONTH(ev_start) AS day,
		ev_title, ev_id, ev_access, YEAR(ev_start) AS year,
		MONTH(ev_start) AS month
		FROM ".AWEC_DB_EVENTS."
		WHERE $search_string $access
		ORDER BY DAYOFMONTH(ev_start) ASC");
	echo dbrows($res).' '.$locale['EC552'].'
<ul>';
	while($ev = dbarray($res)) {
		echo '
	<li><a href="view_event.php?id='.$ev['ev_id'].'">'
		.$ev['ev_title'].'</a></li>';
	}
	echo '
</ul>';

} else {
	if(isset($stext)) {
		echo '
<p>
<strong>'.$locale['EC554'].'</strong>
</p>';
	}
}
closetable();


require_once('include/die.php');
?>
