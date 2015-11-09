<?php
/**
*
* @package FFusion
* @version $Id: $
* @copyright (c) 2006-2008 Artur Wiebe <wibix@gmx.de>
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
if(!defined('IN_FUSION')) {
	die;
}


/****************************************************************************
 * PHP-FUSION-CONVERTER
 */
//if(defined('IN_FF')) {
//	return;
//}

$ver_numbers = explode('.', $settings['version']);
$main_ver = intval(array_shift($ver_numbers));
//echo 'VERSION='.$main_ver;



$inf_title		= $infusion['title'];
$inf_description	= $infusion['description'];
$inf_version		= $infusion['version'];
$inf_developer		= $infusion['developer'];
$inf_email		= $infusion['email'];
$inf_weburl		= $infusion['weburl'];

$inf_folder		= basename(dirname(dirname(__FILE__)));


if($main_ver==6) {
	$inf_newtables		= count($new_tables);
	$inf_insertdbrows	= count($new_rows);
	$inf_altertables	= count($alter_tables); 
	$inf_deldbrows		= count($del_rows); 

	$inf_newtable_ = array();
	$inf_droptable_ = array();
	$inf_insertdbrow_ = array();

	if(count($admin_links)) {
		$link = array_shift($admin_links);
		$inf_admin_image = $link['image'];
		$inf_admin_panel = $link['url'];
	} else {
		$inf_admin_image	= '';
		$inf_admin_panel	= '';
	}

	if(count($site_links)) {
		$link = array_shift($site_links);
		$inf_link_name = $link['title'];
		$inf_link_url = $link['url'];
		$inf_link_visibility = $link['visibility'];
	} else {
		$inf_link_name		= '';
		$inf_link_url		= '';
		$inf_link_visibility	= '';
	}

	$i = 0;
	foreach($new_tables as $tname => $tsql) {
		++$i;
		$inf_newtable_[$i] = $tname.$tsql;
		$inf_droptable_[$i] = $tname;
	}

	$i = 0;
	foreach($new_rows as $row) {
		$inf_insertdbrow_[++$i] = $row;
	}


} elseif($main_ver==7) {
	$inf_newtable = '';
	$inf_droptable = '';
	$inf_insertdbrow = '';

	if(count($admin_links)) {
		$i = 0;
		foreach($admin_links as $link) {
			$link['panel'] = $link['url'];
			$inf_adminpanel[++$i] = $link;
		}
	} else {
		$inf_adminpanel = '';
	}

	if(count($site_links)) {
		$i = 0;
		foreach($site_links as $link) {
			$inf_sitelink[++$i] = $link;
		}
	} else {
		$inf_sitelink = '';
	}

	$i = 0;
	foreach($new_tables as $tname => $tsql) {
		++$i;
		$inf_newtable[$i] = DB_PREFIX.$tname.$tsql;
		$inf_droptable[$i] = DB_PREFIX.$tname;
	}

	$i = 0;
	foreach($new_rows as $row) {
		$inf_insertdbrow[++$i] = DB_PREFIX.$row;
	}
}
?>

