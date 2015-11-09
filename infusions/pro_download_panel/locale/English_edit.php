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

$locale['PDP900'] = array(
	0		=> "OK",
	PDP_EIMG	=> "Image-Error: FIXME",
	PDP_EACCESS	=> "Access denied!",
	PDP_EURL	=> "Invalid URL-Format. ".$locale['PDP220'],
	PDP_EFILE	=> "File could not be found.",
	PDP_EUPDIR	=> "You cannot upload files becase the directory %s is not writeable. Please check you settings.",
	PDP_ECATS	=> "You cannot add any downloads because there are not categories that you can write to.",
	PDP_EEXT	=> "Exention not allowed.",
	PDP_ESIZE	=> "File is too big.",
	PDP_EIMGVERIFY	=> "Invalid image-content (verify_image())!",
	PDP_EUPDATED	=> "Could not change status because download has been modified in meanwhile",
	PDP_EMAXREACHED	=> "Maximum count reached.",
	//
	PDP_EUPLOAD	=> "Error during upload.",
	PDP_EUPLOAD1	=> "File is too big (> upload_max_filesize in php.ini)",
	PDP_EUPLOAD2	=> "File is too big (> MAX_FILE_SIZE)",
	PDP_EUPLOAD3	=> "Could not upload file in one piece.",
	PDP_EUPLOAD4	=> "No file uploaded.",
	PDP_EUPLOAD5	=> "",
	PDP_EUPLOAD6	=> "TEMP directory not available.",
	PDP_EUPLOAD7	=> "Could not save.",
);


// edit_files.php
$locale['PDP120'] = "No files available.";
//
$locale['PDP123'] = "This area is just for backwards compatibility. Please use information from this area and add an download above. After that, delete this information.";
//
$locale['PDP125'] = "Download";
$locale['PDP126'] = "Empty fields";
$locale['PDP127'] = "External Download";
$locale['PDP128'] = "Edit files";
$locale['PDP129'] = "Source";
$locale['PDP130'] = "Do you want to delete the file on disk as well?";
$locale['PDP131'] = "Yes";
$locale['PDP132'] = "No";
$locale['PDP133'] = "or";
$locale['PDP134'] = "Cancel";
$locale['pdp_new_files']	= 'New files';


// edit_pics.php
$locale['PDP150'] = "Too big screenshots will be scaled to this size.";
$locale['PDP151'] = "You can upload %s screenshots at all.";
$locale['PDP152'] = "You can not upload more than %s screenshots.";


// edit_comments.php
$locale['PDP380'] = "IP";


// edit_desc.php
$locale['PDP101'] = "Own / Other License";
$locale['PDP102'] = "Edit download";
$locale['PDP103'] = "New download";
$locale['PDP104'] = "Copyright:";
$locale['PDP105'] = "License";
$locale['PDP106'] = "Confirm license";	//FIXME
$locale['PDP107'] = "License-URL";
$locale['PDP108'] = "Abstract";
$locale['PDP109'] = "Maximum 255 chars";



// edit_misc.php
$locale['PDP501'] = "Hide username";
$locale['PDP502'] = "Check Download";
$locale['PDP503'] = "Changes made will be checked by an admin. He then may release this download.";
$locale['PDP504'] = "Go!";
$locale['PDP505'] = "Release Download";


// edit_admin.php
$locale['PDP450'] = "Admin/Log";
$locale['PDP451'] = "No entries";
$locale['PDP453'] = "Set";
$locale['PDP454'] = "Log Entries";
$locale['PDP455'] = "Reports about broken download.";
$locale['PDP456'] = "Reset";
$locale['PDP457'] = "Download Count";
$locale['PDP458'] = "Screenshots per Download";
$locale['pdp_reset_visitors']	= 'Visitors counter';
$locale['pdp_dir_files']	= 'Path within the upload directory';


?>
