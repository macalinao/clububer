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
require_once('include/theme_funcs.php');


//
$stext = '';
if(isset($_GET['stext']) && !empty($_GET['stext'])) {
	$stext = stripinput($_GET['stext']);
}

if(isset($_GET['stype']) && isset($locale['prp_search_type'][$_GET['stype']])) {
	$stype = $_GET['stype'];
} else {
	$stype = 'desc';
}

$search_type = '';
foreach($locale['prp_search_type'] as $type => $title) {
	$search_type .= '<input type="radio" name="stype" value="'.$type.'"'
		.($stype==$type
			? " checked='checked'"
			: ''
		).' />'.$title;
}

if(isset($_GET['rowstart']) && isNum($_GET['rowstart'])) {
	$rowstart = $_GET['rowstart'];
} else {
	$rowstart = 0;
}



/*
 * GUI
 */
opentable($prp->settings['title']);
prp_menu();
echo '<hr />';


//$highlight = "<span class='poll'>\\1</span>";


echo '
<form action="search.php" method="get">
<input type="text" size="24" maxlength="24" name="stext" class="textbox" value="'.$stext.'" />
<input type="submit" value="'.$locale['PRP040'].'" class="button" /><br />
'.$locale['prp_search'].': '.$search_type.'
</form>';


//
if(strlen($stext) >= 3) {
	$downs = array();
	$get = array(
		'type'	=> $stype,
		'data'	=> $stext,
	);
	$count = prpCore::get_reviews($get, 'dl_name ASC',
		$rowstart, $prp->settings['per_page'],
		false, $downs);

	echo '
<p>
<strong>'.$locale['PRP182'].': </strong>'.$stext.'
</p>
<p>
'.sprintf($locale['prp_reviews_found'], $count).'
</p>';

	if($count) {
		$link = FUSION_SELF.'?stext='.$stext.'&amp;stype='.$stype.'&amp;';
		prp_render_downs($downs, $rowstart, $prp->settings['per_page'],
			$count, $link);
	}

} else {
	echo '<p>'.$locale['PRP180'].'</p>';
}


closetable();


require_once('include/die.php');
?>
