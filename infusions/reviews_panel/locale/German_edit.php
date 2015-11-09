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
	PRP_EIMG	=> "Bild-Fehler: FIXME",
	PRP_EACCESS	=> "Zugriff verweigert!",
	PRP_EURL	=> "Ung&uuml;ltiges URL-Format. ".$locale['PRP220'],
	PRP_EFILE	=> "Datei nicht gefunden.",
	PRP_EUPDIR	=> "Sie k&ouml;nnen keine Dateien hochladen, da das Verzeichnis %s nicht schreibbar ist. Bitte &uuml;berpr&uuml;fen Sie ihre Einstellungen.",
	PRP_ECATS	=> "Sie k&ouml;nnen keine Reviews hinzuf&uuml;gen, da Sie auf keine Kategorie zugreifen k&ouml;nnen.",
	PRP_EEXT	=> "Erweiterung nicht erlaubt.",
	PRP_ESIZE	=> "Datei ist zu gro&szlig;.",
	PRP_EIMGVERIFY	=> "Ung&uuml;ltige Bilddatei (verify_image())!",
	PRP_EUPDATED	=> "Status konnte nicht ge&auml;ndert werden, da der Review in der Zwischenzeit ge&auml;ndert wurde.",
	PRP_EMAXREACHED	=> "Maximale Anzahl erreicht.",
	//
	PRP_EUPLOAD	=> "Fehler w&auml;hrend des Uploads.",
	PRP_EUPLOAD1	=> "Datei ist zu gro&szlig; (> upload_max_filesize in php.ini)",
	PRP_EUPLOAD2	=> "Datei ist zu gro&szlig; (> MAX_FILE_SIZE)",
	PRP_EUPLOAD3	=> "Datei konnte nicht vollst&auml;ndig geladen werden.",
	PRP_EUPLOAD4	=> "Keine Datei hochgeladen.",
	PRP_EUPLOAD5	=> "",
	PRP_EUPLOAD6	=> "TEMP Verzeichnis nicht vorhanden.",
	PRP_EUPLOAD7	=> "Konnte nicht speichern.",
);


// edit_files.php
$locale['PRP120'] = "Keine Dateien vorhanden.";
//
$locale['PRP123'] = "Dieser Bereich dient lediglich der Abw&auml;rtskompatibilit&auml;t. Bitte tragen Sie die Informationen aus diesem Bereich als neue Datei ein und l&ouml;schen Sie anschlie&szlig;end diese Informationen.";
//
$locale['PRP125'] = "Review";
$locale['PRP126'] = "Feld Leeren";
$locale['PRP127'] = "Externer Review";
$locale['PRP128'] = "Dateien bearbeiten";
$locale['PRP129'] = "Quelle";
$locale['PRP130'] = "Wollen Sie diese Datei ebenfalls l&ouml;schen?";
$locale['PRP131'] = "Ja";
$locale['PRP132'] = "Nein";
$locale['PRP133'] = "oder";
$locale['PRP134'] = "Abbrechen";
$locale['prp_new_files']	= 'Neue Dateien';


// edit_pics.php
$locale['PRP150'] = "Zu gro&szlig;e Bilder werden auf diese Gr&ouml;&szlig;e automatisch verkleinert.";
$locale['PRP151'] = "Sie k&ouml;nnen h&ouml;chstens %s Screenshots hochladen.";
$locale['PRP152'] = "Sie k&ouml;nnen nicht mehr als %s Screenshots hochladen.";


// edit_comments.php
$locale['PRP380'] = "IP";


// edit_desc.php
$locale['PRP101'] = "Eigene / Andere Lizenz";
$locale['PRP102'] = "Review bearbeiten";
$locale['PRP103'] = "Neuer Review";
//FIXME $locale['PRP104'] = "Copyright";
//FIXME $locale['PRP105'] = "Lizenz";
$locale['PRP106'] = "Lizenz best&auml;tigen";
$locale['PRP107'] = "Lizenz-URL";
$locale['PRP108'] = "Zusammenfassung";
$locale['PRP109'] = "Maximal 255 Zeichen";



// edit_misc.php
$locale['PRP501'] = "Verstecke Benutzernamen";
$locale['PRP502'] = "Review &uuml;berpr&uuml;fen";
$locale['PRP503'] = "&Auml;nderungen, die an diesem Review gemacht wurden, werden von einem Administrator &uuml;berpr&uuml;ft. Der Review wird anschlie&szlig;end ggf. freigegeben.";
$locale['PRP504'] = "Los!";
$locale['PRP505'] = "Review freigeben";


// edit_admin.php
$locale['PRP450'] = "Moderator/Log";
$locale['PRP451'] = "Keine Eintr&auml;ge";
$locale['PRP453'] = "Setzen";
$locale['PRP454'] = "Log-Eintr&auml;ge";
$locale['PRP455'] = "Meldungen &uuml;ber fehlende Dateien";
$locale['PRP456'] = "Zur&uuml;cksetzen";
$locale['PRP457'] = "Review-Z&auml;hler";
$locale['PRP458'] = "Screenshots";
$locale['prp_reset_visitors']	= 'Besucher-Z&auml;hler';
$locale['prp_dir_files']	= 'Pfad innerhalb des Upload-Verzeichnisses';


?>
