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


if(!count($events)) {
	echo '
<p>
	'.$locale['awec_no_events'].'
</p>';
	return;
}


echo '
<table width="100%" class="'.$awec_styles['list'].'" cellspacing="0" cellpadding="0">
<colgroup>
	<col width="24" />
	<col width="16" />
	<col width="*" />
</colgroup>
<tbody>';
for($i=1; $i<=$daysinmonth; ++$i) {
	if($ec_is_this_month && $ec_today['mday']==$i) {
		$tbl = 'current';
	} else {
		$tbl = ($i%2==0 ? 'even' : 'odd');
	}
	echo '
<tr style="height:30px;" class="'.$awec_styles[$tbl].'">
	<td align="right" valign="top">
		<a href="day.php?date='.$ec_year.'-'.$month.'-'.($i<10 ? '0' : '').$i.'">'.$i.'.</a></td>
	<td></td>
	<td valign="top">'.$content[$i].'</td>
</tr>';
}
echo '
</tbody>
</table>';


?>
