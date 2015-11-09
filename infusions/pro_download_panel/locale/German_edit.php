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
	PDP_EIMG	=> "Bild-Fehler: FIXME",
	PDP_EACCESS	=> "Zugriff verweigert!",
	PDP_EURL	=> "Ung&uuml;ltiges URL-Format. ".$locale['PDP220'],
	PDP_EFILE	=> "Datei nicht gefunden.",
	PDP_EUPDIR	=> "Sie k&ouml;nnen keine Dateien hochladen, da das Verzeichnis %s nicht schreibbar ist. Bitte &uuml;berpr&uuml;fen Sie ihre Einstellungen.",
	PDP_ECATS	=> "Sie k&ouml;nnen keine Downloads hinzuf&uuml;gen, da Sie auf keine Kategorie zugreifen k&ouml;nnen.",
	PDP_EEXT	=> "Erweiterung nicht erlaubt.",
	PDP_ESIZE	=> "Datei ist zu gro&szlig;.",
	PDP_EIMGVERIFY	=> "Ung&uuml;ltige Bilddatei (verify_image())!",
	PDP_EUPDATED	=> "Status konnte nicht ge&auml;ndert werden, da der Download in der Zwischenzeit ge&auml;ndert wurde.",
	PDP_EMAXREACHED	=> "Maximale Anzahl erreicht.",
	//
	PDP_EUPLOAD	=> "Fehler w&auml;hrend des Uploads.",
	PDP_EUPLOAD1	=> "Datei ist zu gro&szlig; (> upload_max_filesize in php.ini)",
	PDP_EUPLOAD2	=> "Datei ist zu gro&szlig; (> MAX_FILE_SIZE)",
	PDP_EUPLOAD3	=> "Datei konnte nicht vollst&auml;ndig geladen werden.",
	PDP_EUPLOAD4	=> "Keine Datei hochgeladen.",
	PDP_EUPLOAD5	=> "",
	PDP_EUPLOAD6	=> "TEMP Verzeichnis nicht vorhanden.",
	PDP_EUPLOAD7	=> "Konnte nicht speichern.",
);


// edit_files.php
$locale['PDP120'] = "Keine Dateien vorhanden.";
//
$locale['PDP123'] = "Dieser Bereich dient lediglich der Abw&auml;rtskompatibilit&auml;t. Bitte tragen Sie die Informationen aus diesem Bereich als neue Datei ein und l&ouml;schen Sie anschlie&szlig;end diese Informationen.";
//
$locale['PDP125'] = "Download";
$locale['PDP126'] = "Feld Leeren";
$locale['PDP127'] = "Externer Download";
$locale['PDP128'] = "Dateien bearbeiten";
$locale['PDP129'] = "Quelle";
$locale['PDP130'] = "Wollen Sie diese Datei ebenfalls l&ouml;schen?";
$locale['PDP131'] = "Ja";
$locale['PDP132'] = "Nein";
$locale['PDP133'] = "oder";
$locale['PDP134'] = "Abbrechen";
$locale['pdp_new_files']	= 'Neue Dateien';


// edit_pics.php
$locale['PDP150'] = "Zu gro&szlig;e Bilder werden auf diese Gr&ouml;&szlig;e automatisch verkleinert.";
$locale['PDP151'] = "Sie k&ouml;nnen h&ouml;chstens %s Screenshots hochladen.";
$locale['PDP152'] = "Sie k&ouml;nnen nicht mehr als %s Screenshots hochladen.";


// edit_comments.php
$locale['PDP380'] = "IP";


// edit_desc.php
$locale['PDP101'] = "Eigene / Andere Lizenz";
$locale['PDP102'] = "Download bearbeiten";
$locale['PDP103'] = "Neuer Download";
//FIXME $locale['PDP104'] = "Copyright";
//FIXME $locale['PDP105'] = "Lizenz";
$locale['PDP106'] = "Lizenz best&auml;tigen";
$locale['PDP107'] = "Lizenz-URL";
$locale['PDP108'] = "Zusammenfassung";
$locale['PDP109'] = "Maximal 255 Zeichen";



// edit_misc.php
$locale['PDP501'] = "Verstecke Benutzernamen";
$locale['PDP502'] = "Download &uuml;berpr&uuml;fen";
$locale['PDP503'] = "&Auml;nderungen, die an diesem Download gemacht wurden, werden von einem Administrator &uuml;berpr&uuml;ft. Der Download wird anschlie&szlig;end ggf. freigegeben.";
$locale['PDP504'] = "Los!";
$locale['PDP505'] = "Download freigeben";


// edit_admin.php
$locale['PDP450'] = "Moderator/Log";
$locale['PDP451'] = "Keine Eintr&auml;ge";
$locale['PDP453'] = "Setzen";
$locale['PDP454'] = "Log-Eintr&auml;ge";
$locale['PDP455'] = "Meldungen &uuml;ber fehlende Dateien";
$locale['PDP456'] = "Zur&uuml;cksetzen";
$locale['PDP457'] = "Download-Z&auml;hler";
$locale['PDP458'] = "Screenshots";
$locale['pdp_reset_visitors']	= 'Besucher-Z&auml;hler';
$locale['pdp_dir_files']	= 'Pfad innerhalb des Upload-Verzeichnisses';


?>
