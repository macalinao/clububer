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

$locale['PDP900'] = array(
	0		=> "Rendben",
	PDP_EIMG	=> "Képhiba",
	PDP_EACCESS	=> "Hozzáférés megtagadva!",
	PDP_EURL	=> "Helytelen URL cím. ".$locale['PDP220'],
	PDP_EFILE	=> "A fájlt nem lehetett megtalálni.",
	PDP_EUPDIR	=> "Nem tudsz fájlokat feltölteni mert a %s könyvtár nem írható. Nézd meg az attribútumok (CHMOD) beállításait.",
	PDP_ECATS	=> "Egy letöltést sem tudsz hozzáadni, mert még egy kategória sincs létrehozva az adatbázisban.",
	PDP_EEXT	=> "A kiterjesztés nem engedélyezett.",
	PDP_ESIZE	=> "A fájl túl nagy.",
	PDP_EIMGVERIFY	=> "Helytelen kép tartalom (verify_image())!",
	PDP_EUPDATED	=> "A státuszt nem lehetett elmenteni, mert a letöltések id&#337;közben módosultak.",
	PDP_EMAXREACHED	=> "Maximum érték elérve.",
	//
	PDP_EUPLOAD	=> "Hiba lépett fel a feltöltés közben.",
	PDP_EUPLOAD1	=> "A fájl túl nagy (> upload_max_filesize a php.ini fájlban)",
	PDP_EUPLOAD2	=> "A fájl túl nagy (> MAX_FILE_SIZE)",
	PDP_EUPLOAD3	=> "A fájlt nem lehetett feltölteni egy darabban.",
	PDP_EUPLOAD4	=> "Nincs fájl feltöltve.",
	PDP_EUPLOAD5	=> "",
	PDP_EUPLOAD6	=> "A TEMP könyvtár nem elérhet&#337;.",
	PDP_EUPLOAD7	=> "Nem lehet elmenteni.",
);


// edit_files.php
$locale['PDP120'] = "Nincs elérhetõ fájl.";
//
$locale['PDP123'] = "This area is just for backwards compatibility. Please use information from this area and add an download above. After that, delete this information.";
//
$locale['PDP125'] = "Letöltés";
$locale['PDP126'] = "Üres mezõk";
$locale['PDP127'] = "Külsõ letöltés";
$locale['PDP128'] = "Fájlok szerkesztése";
$locale['PDP129'] = "Forrás";
$locale['PDP130'] = "Biztos, hogy törölni akarod ezt a fájlt a szerverrõl?";
$locale['PDP131'] = "Igen";
$locale['PDP132'] = "Nem";
$locale['PDP133'] = "-";
$locale['PDP134'] = "Mégse";
$locale['pdp_new_files']	= 'Új fájlok';


// edit_pics.php
$locale['PDP150'] = "A nagy képek automatikusan erre az arányra kerülnek átméretezésre.";
$locale['PDP151'] = "Összesen %s képet tölthetsz fel.";
$locale['PDP152'] = "Csak %s képet tölthetsz fel.";


// edit_comments.php
$locale['PDP380'] = "IP cím";


// edit_desc.php
$locale['PDP101'] = "Saját / Egyéb licensz";
$locale['PDP102'] = "Letöltés szerkesztése";
$locale['PDP103'] = "Új letöltés";
$locale['PDP104'] = "Szerzõi jog:";
$locale['PDP105'] = "Licensz";
$locale['PDP106'] = "Megerõsítés";
$locale['PDP107'] = "Licensz-URL";
$locale['PDP108'] = "Bevezetés";
$locale['PDP109'] = "Maximum 255 karakter";



// edit_misc.php
$locale['PDP501'] = "Felhasználónév elrejtése";
$locale['PDP502'] = "Letöltés ellenõrzése";
$locale['PDP503'] = "A változásokat ismét le fogja ellenõrizni egy adminisztrátor. Ha megfelel, jóváhagyásra kerül a frissítés.";
$locale['PDP504'] = "Mehet";
$locale['PDP505'] = "Jóváhagyás";


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