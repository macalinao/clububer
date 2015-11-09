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
 *   Copyright (C) 2006-2007 Artur Wiebe                                   *
 *   wibix@gmx.de                                                          *
 *   http://wibix.de/                                                      *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU General Public License as published by  *
 *   the Free Software Foundation; either version 2 of the License, or     *
 *   (at your option) any later version.                                   *
 ***************************************************************************/

$locale['PRP900'] = array(
	0		=> "Rendben",
	PRP_EIMG	=> "K�phiba",
	PRP_EACCESS	=> "Hozz�f�r�s megtagadva!",
	PRP_EURL	=> "Helytelen URL c�m. ".$locale['PRP220'],
	PRP_EFILE	=> "A f�jlt nem lehetett megtal�lni.",
	PRP_EUPDIR	=> "Nem tudsz f�jlokat felt�lteni mert a %s k�nyvt�r nem �rhat�. N�zd meg az attrib�tumok (CHMOD) be�ll�t�sait.",
	PRP_ECATS	=> "Egy let�lt�st sem tudsz hozz�adni, mert m�g egy kateg�ria sincs l�trehozva az adatb�zisban.",
	PRP_EEXT	=> "A kiterjeszt�s nem enged�lyezett.",
	PRP_ESIZE	=> "A f�jl t�l nagy.",
	PRP_EIMGVERIFY	=> "Helytelen k�p tartalom (verify_image())!",
	PRP_EUPDATED	=> "A st�tuszt nem lehetett elmenteni, mert a let�lt�sek id&#337;k�zben m�dosultak.",
	PRP_EMAXREACHED	=> "Maximum �rt�k el�rve.",
	//
	PRP_EUPLOAD	=> "Hiba l�pett fel a felt�lt�s k�zben.",
	PRP_EUPLOAD1	=> "A f�jl t�l nagy (> upload_max_filesize a php.ini f�jlban)",
	PRP_EUPLOAD2	=> "A f�jl t�l nagy (> MAX_FILE_SIZE)",
	PRP_EUPLOAD3	=> "A f�jlt nem lehetett felt�lteni egy darabban.",
	PRP_EUPLOAD4	=> "Nincs f�jl felt�ltve.",
	PRP_EUPLOAD5	=> "",
	PRP_EUPLOAD6	=> "A TEMP k�nyvt�r nem el�rhet&#337;.",
	PRP_EUPLOAD7	=> "Nem lehet elmenteni.",
);


// edit_files.php
$locale['PRP120'] = "Nincs el�rhet� f�jl.";
//
$locale['PRP123'] = "This area is just for backwards compatibility. Please use information from this area and add an review above. After that, delete this information.";
//
$locale['PRP125'] = "Let�lt�s";
$locale['PRP126'] = "�res mez�k";
$locale['PRP127'] = "K�ls� let�lt�s";
$locale['PRP128'] = "F�jlok szerkeszt�se";
$locale['PRP129'] = "Forr�s";
$locale['PRP130'] = "Biztos, hogy t�r�lni akarod ezt a f�jlt a szerverr�l?";
$locale['PRP131'] = "Igen";
$locale['PRP132'] = "Nem";
$locale['PRP133'] = "-";
$locale['PRP134'] = "M�gse";
$locale['prp_new_files']	= '�j f�jlok';


// edit_pics.php
$locale['PRP150'] = "A nagy k�pek automatikusan erre az ar�nyra ker�lnek �tm�retez�sre.";
$locale['PRP151'] = "�sszesen %s k�pet t�lthetsz fel.";
$locale['PRP152'] = "Csak %s k�pet t�lthetsz fel.";


// edit_comments.php
$locale['PRP380'] = "IP c�m";


// edit_desc.php
$locale['PRP101'] = "Saj�t / Egy�b licensz";
$locale['PRP102'] = "Let�lt�s szerkeszt�se";
$locale['PRP103'] = "�j let�lt�s";
$locale['PRP104'] = "Szerz�i jog:";
$locale['PRP105'] = "Licensz";
$locale['PRP106'] = "Meger�s�t�s";
$locale['PRP107'] = "Licensz-URL";
$locale['PRP108'] = "Bevezet�s";
$locale['PRP109'] = "Maximum 255 karakter";



// edit_misc.php
$locale['PRP501'] = "Felhaszn�l�n�v elrejt�se";
$locale['PRP502'] = "Let�lt�s ellen�rz�se";
$locale['PRP503'] = "A v�ltoz�sokat ism�t le fogja ellen�rizni egy adminisztr�tor. Ha megfelel, j�v�hagy�sra ker�l a friss�t�s.";
$locale['PRP504'] = "Mehet";
$locale['PRP505'] = "J�v�hagy�s";


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