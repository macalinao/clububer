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
 *   Danish translation by Helmuth Mikkelsen   revised July 29 2008        *
 *   helmuthm@gmail.com                                                    *
 *   And by Yxos                                                           *
 *   geismar@gmail.com                                                     *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU General Public License as published by  *
 *   the Free Software Foundation; either version 2 of the License, or     *
 *   (at your option) any later version.                                   *
 ***************************************************************************/
$locale['PDP900'] = array(
	0		=> "OK",
	PDP_EIMG	=> "Billed-fejl: RET MIG",
	PDP_EACCESS	=> "Adgang nægtet!",
	PDP_EURL	=> "Ugyldig URL-format. ".$locale['PDP220'],
	PDP_EFILE	=> "Filen kunne ikke findes.",
	PDP_EUPDIR	=> "Du kan ikke uploade filer, fordi folderen %s ikke er skrivbar. Undersøg venligst dine indstillinger.",
	PDP_ECATS	=> "Du kan ikke tilføje downloads, fordi der ingen kategorier er at tilføje til.",
	PDP_EEXT	=> "Filendelse ikke tilladt.",
	PDP_ESIZE	=> "Filen er for stor.",
	PDP_EIMGVERIFY	=> "Ugyldigt billedindhold (verify_image())!",
	PDP_EUPDATED	=> "Kunne ikke ændre status, fordi downloaden er blevet ændret i mellemtiden",
	//
	PDP_EUPLOAD	=> "Fejl under upload.",
	PDP_EUPLOAD1	=> "Filen er for stor (> upload_max_filesize i php.ini)",
	PDP_EUPLOAD2	=> "Filen er for stor (> MAX_FILE_SIZE)",
	PDP_EUPLOAD3	=> "Kunne ikke uploade filen i en omgang.",
	PDP_EUPLOAD4	=> "Ingen fil uploadet.",
	PDP_EUPLOAD5	=> "",
	PDP_EUPLOAD6	=> "TEMP folder ikke tilgængelig.",
	PDP_EUPLOAD7	=> "Kunne ikke gemme.",
);



// edit_files.php
$locale['PDP120'] = "Ingen filer tilgængelige.";
//
$locale['PDP123'] = "Dette område er kun til baglæns kompabilitet. Benyt informationen fra dette område og tilføj en download ovenfor. Efterfølgende, slet denne tekst.";
//
$locale['PDP125'] = "Download";
$locale['PDP126'] = "Tomme felter";
$locale['PDP127'] = "Ekstern download";
$locale['PDP128'] = "Rediger filer";
$locale['PDP129'] = "Kilde";
$locale['PDP130'] = "Vil du slette filen på harddisken også?";
$locale['PDP131'] = "Ja";
$locale['PDP132'] = "Nej";
$locale['PDP133'] = "eller";
$locale['PDP134'] = "Fortryd";
$locale['pdp_new_files']	= 'Nye filer';


// edit_pics.php
$locale['PDP150'] = "For store billeder vil blive skaleret til denne størrelse.";
$locale['PDP151'] = "Du kan uploade %s screenshots i alt.";
$locale['PDP152'] = "Du kan ikke uploade mere end %s screenshots.";


// edit_comments.php
$locale['PDP380'] = "IP";


// edit_desc.php
$locale['PDP101'] = "Egen / Anden licens";
$locale['PDP102'] = "Rediger download";
$locale['PDP103'] = "Ny download";
$locale['PDP104'] = "Copyright:";
$locale['PDP105'] = "Licens";
$locale['PDP106'] = "Bekræft licens";//file.php
$locale['PDP107'] = "Licens-URL";
$locale['PDP108'] = "Sammenfatning";
$locale['PDP109'] = "Maksimum 255 karakterer";



// edit_misc.php
$locale['PDP501'] = "Skjul brugernavn";
$locale['PDP502'] = "Undersøg download";
$locale['PDP503'] = "Rettelser vil blive efterset af en administrator. Herefter vil denne download måske frigives.";
$locale['PDP504'] = "Udfør!";
$locale['PDP505'] = "Frigiv download";


// edit_admin.php
$locale['PDP450'] = "Admin/Log";
$locale['PDP451'] = "Ingen optegnelser";
$locale['PDP452'] = "Status";
$locale['PDP453'] = "Sæt";
$locale['PDP454'] = "Log optegnelser";
$locale['PDP455'] = "Rapporter om download-fejl.";
$locale['PDP456'] = "Sæt om";
$locale['PDP457'] = "Downloadtæller";
$locale['PDP458'] = "Screenshots pr. download";
$locale['pdp_reset_visitors']	= 'Gæstetæller';
$locale['pdp_dir_files']	= 'Sti til upload-folder';


?>
