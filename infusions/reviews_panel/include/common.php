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
require_once dirname(dirname(dirname(dirname(__FILE__)))).'/maincore.php';
require_once(INFUSIONS.'reviews_panel/include/core.php');

if(!iPRP_CAN_VIEW
	&& !in_array(FUSION_SELF, array('error.php', 'copyright.php'))) {
	fallback(INFUSIONS.'reviews_panel/error.php?type=access');
}

switch(FUSION_VERSION) {
case 6:
	require_once(BASEDIR.'subheader.php');
	require_once(BASEDIR.'side_left.php');
	break;
case 7:
	require_once(THEMES.'templates/header.php');
	break;
case 'FF':
	break;
default:
	die;
}



/*
 * get review
 */
require_once(INFUSIONS.'reviews_panel/include/class.review.php');
$review = new prpReview(isset($_GET['did']) && isNum($_GET['did'])
	? $_GET['did']
	: 0);


if($review->id && $review->status!=PRP_PRO_ON && !$review->can_edit) {
	fallback('review.php?catid='.$review->data['cat_id']);
}


/*
 * FUNCS
 */
// bb-buttons and smileys
function prp_get_bb_smileys($input, $val, $is_enabled, $show_smileys=true) {
	global $locale;
	return '
<input type="button" value="b" class="button" style="font-weight:bold;"
	onclick="addText(\''.$input.'\', \'[b]\', \'[/b]\');" />
<input type="button" value="i" class="button" style="font-style:italic;"
	onclick="addText(\''.$input.'\', \'[i]\', \'[/i]\');" />
<input type="button" value="u" class="button" style="text-decoration:underline;"
	onclick="addText(\''.$input.'\', \'[u]\', \'[/u]\');" />
<input type="button" value="url" class="button"
	onclick="addText(\''.$input.'\', \'[url]\', \'[/url]\');" />
<input type="button" value="mail" class="button"
	onclick="addText(\''.$input.'\', \'[mail]\', \'[/mail]\');" />
<input type="button" value="img" class="button"
	onclick="addText(\''.$input.'\', \'[img]\', \'[/img]\');" />
<input type="button" value="center" class="button"
	onclick="addText(\''.$input.'\', \'[center]\', \'[/center]\');" />
<input type="button" value="small" class="button"
	onclick="addText(\''.$input.'\', \'[small]\', \'[/small]\');" />
<input type="button" value="code" class="button"
	onclick="addText(\''.$input.'\', \'[code]\', \'[/code]\');" />
<input type="button" value="quote" class="button"
	onclick="addText(\''.$input.'\', \'[quote]\', \'[/quote]\');" />'
.($show_smileys
	? '<div>'.displaysmileys($input).'</div>'
	: '')
.($is_enabled
	? '<div><label><input type="checkbox" name="disable_smileys" value="'.$val.'"'
		.($val=='0'
			? ' checked="checked"'
			: ''
		).' /> '.$locale['PRP041'].'</label></div>'
: '');
}


function prp_cleanup_filename($filename)
{
	$filename = preg_replace('/__\d+\.\S$/', '', $filename);
	$filename = preg_replace('/\[\d+\]\.\S$/', '', $filename);
	return $filename;
}


function prp_is_external($url)
{
	return (substr($url, 0, 7)=='http://'
		|| substr($url, 0, 8)=='https://'
		|| substr($url, 0, 6)=='ftp://');
}


function prp_calc_avg_vote($id)
{
	$avg = 0;

	$res = dbquery("SELECT vote_opt, COUNT(vote_opt) AS vote_count
		FROM ".DB_PRP_VOTES."
		WHERE review_id='".$id."'
		GROUP BY vote_opt");
	if(!dbrows($res)) {
		return $avg;
	}

	$votes = array(0, 0, 0, 0, 0, 0);	// index 0 is not used.
	$nr_votes = 0;
	while($data = dbarray($res)) {
		$votes[$data['vote_opt']] = $data['vote_count'];
		$nr_votes += $data['vote_count'];
	}
	for($i=1; $i<6; ++$i) {
		$avg += $i*$votes[$i]/$nr_votes;
	}
	return $avg;
}


//FIXME
if(!function_exists('show_info')) {
function show_info($info, $class='warning')
{
	if(is_array($info)) {
		$info = '
<ul>
	<li>'.implode("</li>\n\t<li>", $info).'</li>
</ul>';
	}

	echo '
<div class="tbl1 '.$class.'">
	'.$info.'
</div>';
}
}

?>
