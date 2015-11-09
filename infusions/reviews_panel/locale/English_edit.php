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

$locale['PRP900'] = array(
	0		=> "OK",
	PRP_EIMG	=> "Image-Error: FIXME",
	PRP_EACCESS	=> "Access denied!",
	PRP_EURL	=> "Invalid URL-Format. ".$locale['PRP220'],
	PRP_EFILE	=> "File could not be found.",
	PRP_EUPDIR	=> "You cannot upload files becase the directory %s is not writeable. Please check you settings.",
	PRP_ECATS	=> "You cannot add any reviews because there are not categories that you can write to.",
	PRP_EEXT	=> "Exention not allowed.",
	PRP_ESIZE	=> "File is too big.",
	PRP_EIMGVERIFY	=> "Invalid image-content (verify_image())!",
	PRP_EUPDATED	=> "Could not change status because review has been modified in meanwhile",
	PRP_EMAXREACHED	=> "Maximum count reached.",
	//
	PRP_EUPLOAD	=> "Error during upload.",
	PRP_EUPLOAD1	=> "File is too big (> upload_max_filesize in php.ini)",
	PRP_EUPLOAD2	=> "File is too big (> MAX_FILE_SIZE)",
	PRP_EUPLOAD3	=> "Could not upload file in one piece.",
	PRP_EUPLOAD4	=> "No file uploaded.",
	PRP_EUPLOAD5	=> "",
	PRP_EUPLOAD6	=> "TEMP directory not available.",
	PRP_EUPLOAD7	=> "Could not save.",
);


// edit_files.php
$locale['PRP120'] = "No files available.";
//
$locale['PRP123'] = "This area is just for backwards compatibility. Please use information from this area and add an review above. After that, delete this information.";
//
$locale['PRP125'] = "Review";
$locale['PRP126'] = "Empty fields";
$locale['PRP127'] = "External Review";
$locale['PRP128'] = "Edit files";
$locale['PRP129'] = "Source";
$locale['PRP130'] = "Do you want to delete the file on disk as well?";
$locale['PRP131'] = "Yes";
$locale['PRP132'] = "No";
$locale['PRP133'] = "or";
$locale['PRP134'] = "Cancel";
$locale['prp_new_files']	= 'New files';


// edit_pics.php
$locale['PRP150'] = "Too big screenshots will be scaled to this size.";
$locale['PRP151'] = "You can upload %s screenshots at all.";
$locale['PRP152'] = "You can not upload more than %s screenshots.";


// edit_comments.php
$locale['PRP380'] = "IP";


// edit_desc.php
$locale['PRP101'] = "Own / Other License";
$locale['PRP102'] = "Edit review";
$locale['PRP103'] = "New review";
$locale['PRP104'] = "Copyright:";
$locale['PRP105'] = "License";
$locale['PRP106'] = "Confirm license";	//FIXME
$locale['PRP107'] = "License-URL";
$locale['PRP108'] = "Abstract";
$locale['PRP109'] = "Maximum 255 chars";



// edit_misc.php
$locale['PRP501'] = "Hide username";
$locale['PRP502'] = "Check Review";
$locale['PRP503'] = "Changes made will be checked by an admin. He then may release this review.";
$locale['PRP504'] = "Go!";
$locale['PRP505'] = "Release Review";


// edit_admin.php
$locale['PRP450'] = "Admin/Log";
$locale['PRP451'] = "No entries";
$locale['PRP453'] = "Set";
$locale['PRP454'] = "Log Entries";
$locale['PRP455'] = "Reports about broken review.";
$locale['PRP456'] = "Reset";
$locale['PRP457'] = "Review Count";
$locale['PRP458'] = "Screenshots per Review";
$locale['prp_reset_visitors']	= 'Visitors counter';
$locale['prp_dir_files']	= 'Path within the upload directory';


?>
