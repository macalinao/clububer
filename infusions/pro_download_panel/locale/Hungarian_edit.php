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
	PDP_EIMG	=> "K�phiba",
	PDP_EACCESS	=> "Hozz�f�r�s megtagadva!",
	PDP_EURL	=> "Helytelen URL c�m. ".$locale['PDP220'],
	PDP_EFILE	=> "A f�jlt nem lehetett megtal�lni.",
	PDP_EUPDIR	=> "Nem tudsz f�jlokat felt�lteni mert a %s k�nyvt�r nem �rhat�. N�zd meg az attrib�tumok (CHMOD) be�ll�t�sait.",
	PDP_ECATS	=> "Egy let�lt�st sem tudsz hozz�adni, mert m�g egy kateg�ria sincs l�trehozva az adatb�zisban.",
	PDP_EEXT	=> "A kiterjeszt�s nem enged�lyezett.",
	PDP_ESIZE	=> "A f�jl t�l nagy.",
	PDP_EIMGVERIFY	=> "Helytelen k�p tartalom (verify_image())!",
	PDP_EUPDATED	=> "A st�tuszt nem lehetett elmenteni, mert a let�lt�sek id&#337;k�zben m�dosultak.",
	PDP_EMAXREACHED	=> "Maximum �rt�k el�rve.",
	//
	PDP_EUPLOAD	=> "Hiba l�pett fel a felt�lt�s k�zben.",
	PDP_EUPLOAD1	=> "A f�jl t�l nagy (> upload_max_filesize a php.ini f�jlban)",
	PDP_EUPLOAD2	=> "A f�jl t�l nagy (> MAX_FILE_SIZE)",
	PDP_EUPLOAD3	=> "A f�jlt nem lehetett felt�lteni egy darabban.",
	PDP_EUPLOAD4	=> "Nincs f�jl felt�ltve.",
	PDP_EUPLOAD5	=> "",
	PDP_EUPLOAD6	=> "A TEMP k�nyvt�r nem el�rhet&#337;.",
	PDP_EUPLOAD7	=> "Nem lehet elmenteni.",
);


// edit_files.php
$locale['PDP120'] = "Nincs el�rhet� f�jl.";
//
$locale['PDP123'] = "This area is just for backwards compatibility. Please use information from this area and add an download above. After that, delete this information.";
//
$locale['PDP125'] = "Let�lt�s";
$locale['PDP126'] = "�res mez�k";
$locale['PDP127'] = "K�ls� let�lt�s";
$locale['PDP128'] = "F�jlok szerkeszt�se";
$locale['PDP129'] = "Forr�s";
$locale['PDP130'] = "Biztos, hogy t�r�lni akarod ezt a f�jlt a szerverr�l?";
$locale['PDP131'] = "Igen";
$locale['PDP132'] = "Nem";
$locale['PDP133'] = "-";
$locale['PDP134'] = "M�gse";
$locale['pdp_new_files']	= '�j f�jlok';


// edit_pics.php
$locale['PDP150'] = "A nagy k�pek automatikusan erre az ar�nyra ker�lnek �tm�retez�sre.";
$locale['PDP151'] = "�sszesen %s k�pet t�lthetsz fel.";
$locale['PDP152'] = "Csak %s k�pet t�lthetsz fel.";


// edit_comments.php
$locale['PDP380'] = "IP c�m";


// edit_desc.php
$locale['PDP101'] = "Saj�t / Egy�b licensz";
$locale['PDP102'] = "Let�lt�s szerkeszt�se";
$locale['PDP103'] = "�j let�lt�s";
$locale['PDP104'] = "Szerz�i jog:";
$locale['PDP105'] = "Licensz";
$locale['PDP106'] = "Meger�s�t�s";
$locale['PDP107'] = "Licensz-URL";
$locale['PDP108'] = "Bevezet�s";
$locale['PDP109'] = "Maximum 255 karakter";



// edit_misc.php
$locale['PDP501'] = "Felhaszn�l�n�v elrejt�se";
$locale['PDP502'] = "Let�lt�s ellen�rz�se";
$locale['PDP503'] = "A v�ltoz�sokat ism�t le fogja ellen�rizni egy adminisztr�tor. Ha megfelel, j�v�hagy�sra ker�l a friss�t�s.";
$locale['PDP504'] = "Mehet";
$locale['PDP505'] = "J�v�hagy�s";


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