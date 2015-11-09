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
$locale['EC000'] = "awEventCal";
$locale['EC001'] = "Ereignisse";
$locale['EC002'] = "Hinweis";
$locale['EC003'] = "Warnung";
$locale['awec_no_events']	= 'Keine Ereignisse.';
$locale['EC005'] = "&Uuml;ber...";
$locale['EC006']	= 'Wird unwiderruflich entfernt!';
$locale['EC007'] = "Meine";
$locale['awec_logins'] = "Anmeldungen";
$locale['EC009'] = "Monat";
$locale['EC010'] = "Jahr";
$locale['EC011'] = "Suchen";
$locale['awec_week']	= 'Woche';
//
$locale['EC013'] = "Neue Ereignisse";
$locale['awec_user_birthday']	= array(
	'title'	=> 'Geburtstag von %s',
	'body'	=> '%1 wird heute %2 Jahre alt.',
);
$locale['awec_user']		= 'Benutzergeburtstag';
$locale['awec_link']		= 'Link zum Ereignis';

$locale['awec_add']		= 'Hinzuf&uuml;gen';
$locale['awec_save_changes']	= '&Auml;nderungen speichern';
$locale['awec_edit']		= 'Bearbeiten';
$locale['awec_none']		= '[Keine]';
$locale['awec_name']		= 'Name';
$locale['awec_or']		= 'oder';
$locale['awec_export']		= 'Exportieren';
$locale['awec_login_start']	= 'Anmeldebeginn';
$locale['awec_login_end']	= 'Anmeldeschluss';
$locale['awec_status']		= 'Status';
$locale['awec_publish']		= 'Ver&ouml;ffentlichen';

$locale['awec_today']		= 'Heute';

$locale['awec_location']	= 'Ort';

$locale['awec_calendar_view'] = array(
	'week'	=> 'Woche',
	'month'	=> 'Monat',
	'year'	=> 'Jahr',
);


// edit_event.php
$locale['EC100'] = "Neues Ereignis";
$locale['EC101'] = "Ereignis bearbeiten";
$locale['EC102'] = "Zum Ereignis";
$locale['EC103'] = "Titel";
$locale['awec_description'] = "Beschreibung";
$locale['awec_date']	= 'Datum';
$locale['awec_beginn']	= 'Beginn';
$locale['awec_end']	= 'Ende';
$locale['awec_options'] = "Optionen";
$locale['awec_repeat'] = "Wiederholen";
$locale['EC108'] = "Privates Ereignis";
$locale['EC109'] = "Anmeldungen zum Ereignis erlauben";
$locale['EC110'] = "Anmeldungen maximal";
$locale['EC110_1'] = "0 f&uuml;r unendlich";
$locale['EC111'] = "Speichern";
$locale['EC112'] = "Deaktiviere Smileys";
$locale['EC113'] = array(
	0		=> '&Auml;nderungen erfolgreich gespeichert!',
	EC_ELOGIN	=> "F&uuml;r private Ereignisse k&ouml;nnen keine Anmeldungen erfolgen.",
	EC_EDB		=> "Fehler beim Aktualisieren der Datenbank.",
	EC_ESTATUS	=> "Dieses Ereignis muss nur noch von einem Administrator freigegeben werden.",
	EC_EACCESS	=> "F&uuml;r private Ereignisse ist die Zugriffsbeschr&auml;nkung irrelevant.",
	EC_EIMG		=> "Bild-Upload fehlerhaft.",
	'date'		=> "Ung&uuml;ltiges Datum",
	'end_date'	=> 'Wiederholen bis zum: Ung&uuml;ltiges Datum',
);
$locale['EC114'] = "Eine Anmeldung zu diesem Ereignis ist nicht (mehr) m&ouml;glich.";
$locale['EC115'] = array(
	1 => "Maximale Anzahl m&ouml;glicher Anmeldungen erreicht.",
	2 => "Ung&uuml;ltiger Wert der Status-Anmeldung.",
	3 => "Konnte Status der Anmeldung nicht aktualisieren.",
	4 => "Kein Adressat angegeben.",
);
$locale['EC116'] = "Zugriff";
//$locale['EC117'] = "";
$locale['awec_mandatory']	= '(erforderlich)';
$locale['awec_break']		= '** Der Text nach %s, wird im Seitenpanel nicht angezeigt. Bitte benutzen Sie dieses Mittel, um lange Ausgabe im Seitenpanel zu vermeiden.';
$locale['EC119'] = "Bitte f&uuml;llen Sie alle Pflichfelder (*) aus!";
$locale['awec_date_fmt']	= 'Format: Tag.Monat.Jahr';
$locale['awec_time_fmt']	= 'Stunde : Minuten';
$locale['EC121'] = "Bild";
$locale['EC122'] = "Sonstiges";
$locale['EC123'] = "Ende";
$locale['EC124'] = "Anmeldungen nur in diesem Zeitraum erlauben";
$locale['EC125'] = array(
	0 => '[Kein]',
	1 => 'J&auml;hrlich',
	2 => 'Monatlich',
	4 => 'W&ouml;chentlich',
	8 => 'T&auml;glich',
);
$locale['awec_private_saving']		= 'Private Ereignisse k&ouml;nnen sofort "ver&ouml;ffentlicht" werden.';
$locale['awec_endless_repeat']		= 'Endlose Wiederholung';
$locale['awec_end_repeat']		= 'Wiederhole bis zum';
$locale['awec_save_draft']		= 'Als Entwurf speichern';
$locale['awec_save_release']		= 'Speichern und Einsenden';
$locale['awec_save_publish']		= 'Speichern und Ver&ouml;ffentlichen';
$locale['awec_cycle']			= 'Zyklus';


// aw_ecal_panel.php
$locale['EC200'] = "Neues Ereignis eintragen";
$locale['EC202'] = 'Morgen';
$locale['EC203'] = "Neue Ereignisse m&uuml;ssen &uuml;berpr&uuml;ft werden.";
$locale['EC204'] = "Meine Ereignisse";
$locale['EC205'] = "Heute haben Geburtstag";
$locale['EC206'] = "Meine Anmeldungen";
$locale['EC207'] = "[mehr]";
$locale['EC208'] = 'Die n&auml;chsten %s Tage';
$locale['EC209'] = array(
	'today'		=> 'Heute',
	'tomorrow'	=> 'Morgen',
	'others'	=> 'Weitere...',
);


// view_event.php
$locale['EC300'] = "Ereignis";
$locale['EC301'] = $locale['EC113'][3];
$locale['EC302'] = "Warnung! User nicht in der Datenbank.";
$locale['EC303'] = "Unbekannt";
$locale['EC305'] = "L&ouml;schen";
$locale['EC306'] = "Freigeben";
$locale['EC307'] = 'Deaktivieren';
//EC308
$locale['EC309'] = array(
	0 => 'Sie sind zu diesem Event nicht angemeldet.',
	1 => 'Endg&uuml;ltig zugesagt',
	2 => 'Vorl&auml;ufig zugesagt',
	3 => 'Abgesagt',
	4 => 'Eingeladen',
);
$locale['EC310'] = array(
	1 => 'Endg&uuml;ltig Zusagen',
	2 => 'Vorl&auml;ufig Zusagen',
	3 => 'Absagen',
);
$locale['EC311'] = "Mein aktueller Status";
$locale['EC312'] = "Kommentar";
$locale['EC313'] = "E-Mail senden";
$locale['EC314'] = "E-Mail jeweils einzeln senden";
$locale['EC315'] = "Eine E-Mail an alle senden";
$locale['EC316'] = "Senden";
$locale['EC317'] = "Etwas Text f&uuml;r die E-Mail w&auml;re nicht schlecht. Danke!";
$locale['EC318'] = "Ohne Empf&auml;nger gibt es keine E-Mail. Bitte &auml;ndern!";
$locale['awec_all'] = "Alle";
$locale['EC320'] = "E-Mail(s) gesendet!";
$locale['EC321'] = "HTML-Format";
$locale['EC322'] = "Einladen";
$locale['EC323'] = "Bitte benutzen Sie STRG-/SHIFT, um mehrere Namen zu markieren";
$locale['EC324'] = 'PN senden';
$locale['awec_invite_title']	= 'Einladung';
$locale['awec_invite_body']	= 'Sie wurden eingeladen.';


// calendar.php
$locale['awec_calendar'] = "Kalender";
$locale['EC401'] = "Geburtstage im %s";
$locale['EC402'] = "Ansicht";
$locale['awec_month_view'] = array(
	'calendar'	=> 'Kalender',
	'list'		=> 'Liste',
	'clist'		=> 'KListe',
);


// browse.php
$locale['EC450'] = "Jahr";
$locale['awec_show'] = "Zeigen";


// new_events.php
$locale['EC500'] = "Neue Ereignisse";
$locale['EC501'] = "Es m&uuml;ssen keine Ereignisse freigegeben werden.";
$locale['EC502'] = array(
	1 => "Das Ereignis konnte nicht freigegeben werden, da es in der Zwischenzeit ge&auml;ndert wurde. Bitte &uuml;berpr&uuml;fen Sie es erneut!",
);


// search.php
$locale['EC550'] = "Suche nach";
$locale['EC551'] = array(
	'AND'	=> 'Alle Stichw&ouml;rter',
	'OR'	=> 'Mindestens ein Stichwort',
	'-'	=> 'Ganzer Ausdruck',
);
$locale['EC552'] = "Ereignisse gefunden.";
$locale['EC554'] = "Ihre Suchbegriffe m&uuml;ssen mindestens 3 Zeichen lang sein.";


// my_events.php
$locale['EC600'] = "Meine Ereignisse";
$locale['EC601'] = "Sie haben noch keine Ereignisse eingetragen.";
$locale['EC602'] = array(
	0	=> 'Andere',
	1	=> 'Private',
);
$locale['awec_status_desc'] = array(
	AWEC_PUBLISHED	=> 'Ver&ouml;ffentlicht',
	AWEC_PENDING	=> 'Warten auf Ver&ouml;ffentlichung',
	AWEC_DRAFT	=> 'Im Entwurf',
);
$locale['awec_status_longdesc'] = array(
	AWEC_PUBLISHED	=> 'Ver&ouml;ffentlicht',
	AWEC_PENDING	=> 'Warten auf Ver&ouml;ffentlichung',
	AWEC_DRAFT	=> 'Ereignis befindet sich im Entwurf.',
);


// admin.php
$locale['EC700'] = "Einstellungen";
$locale['EC701'] = "Admin-Gruppe";
$locale['EC702'] = "Neue Ereignisse durch die Admin-Gruppe &uuml;berpr&uuml;fen";
$locale['EC703'] = "Eintragen darf";
$locale['EC704'] = "Zeige Ereignisse des heutigen Tages vollst&auml;ndig im Seitenpanel.";
$locale['awec705']	= 'Mitglieder-Geburtstage wie Ereignisse behandeln';
$locale['EC706'] = "Geburtstage zeigen";
$locale['EC711'] = 'Zeit/Datum-Format';
$locale['EC712'] = "Geburtstag";
$locale['EC713'] = "Standard";
$locale['EC714'] = "Wird nur verwendet, wenn keine Vorgabe vom Theme";
$locale['EC715'] = "Ereignisse l&ouml;schen";
$locale['EC716'] = 'L&ouml;sche alle Ereignisse, die &auml;lter sind, als die Anzahl der gew&auml;hlten Tage.';
$locale['EC716_']	= 'Eregnisse, die sich wiederholen, werden nicht gel&ouml;scht!';
$locale['EC717'] = array(
	0	=> "Gespeichert!",
	1	=> "Ereignisse wurden gel&ouml;scht!",
);
$locale['awec_confirm_del']	= 'Ereignisse unwiderruflich l&ouml;schen!';
$locale['EC719'] = "%d - Tag im Monat, numerisch (00..31)
%m - Monat, numerisch (00..12)
%Y - Jahr, numerisch, vier Ziffern
%H - Stunden
%i - Minuten
Mehr Informationen zur Formatierung der Funktion DATE_FORMAT in englischer Sprache: <a href='http://dev.mysql.com/doc/refman/5.1/en/date-and-time-functions.html#function_date-format' target='_blank'>Hier</a>.";//FIXME
$locale['EC720'] = "Vorschau";
$locale['EC721'] = "Tage";
$locale['EC722'] = "N&auml;chsten Tage im Seiten-Panel";
$locale['EC723'] = "Woche beginnt am Sonntag";
$locale['EC724'] = "Seitenpanel";
$locale['EC725'] = 'Wird unterst&uuml;tzt';
$locale['EC726'] = 'Zeit';
$locale['awec_default_month_view']	= 'Standard-Monatsansicht';
$locale['awec_custom_css']		= 'Benutze eigenes CSS-Layout (siehe README)';
$locale['awec_alt_side_calendar']	= 'Benutze alternativen Seitenkalender (siehe README)';
$locale['awec_user_can_edit']		= 'Existierende Ereignisse k&ouml;nnen bearbeitet werden';
$locale['awec_show_week']		= 'Zeige Woche';
$locale['awec_default_calendar_view']	= 'Standard-Kalenderansicht';
$locale['awec_mysql_4']			= 'Sie brauchen MySQL 4.1.1 oder h&ouml;her, um diese Funktion nutzen zu k&ouml;nnen.';

// admin_cats.php
$locale['awec_cats']		= 'Kategorien';
$locale['awec_cat']		= 'Kategorie';

// admin/misc.php
$locale['EC750']		= 'Sonstiges';
$locale['awec_old_events']	= 'Vergangene Ereignisse';

// include/db_update.php
$locale['EC800'] = "Update m&ouml;glich";
$locale['EC801'] = "Dabei werden folgende SQL-Anweisungen ausgef&uuml;hrt";
$locale['EC802'] = "Update starten...";
//
$locale['EC804'] = "Fertig - Weiter!";
$locale['EC805'] = "OK";
$locale['EC806'] = "Fehler";
//
$locale['awec_pls_delete']	= 'Bitte l&ouml;schen Sie zu ihrer eigenen Sicherheit folgende Dateien:';


// others
$locale['EC900'] = array(
	0 => '--',
	1 => 'Januar',
	2 => 'Februar',
	3 => 'M&auml;rz',
	4 => 'April',
	5 => 'Mai',
	6 => 'Juni',
	7 => 'Juli',
	8 => 'August',
	9 => 'September',
	10 => 'Oktober',
	11 => 'November',
	12 => 'Dezember',
);
$locale['EC901'] = array(
	0 => 'So',
	1 => 'Mo',
	2 => 'Di',
	3 => 'Mi',
	4 => 'Do',
	5 => 'Fr',
	6 => 'Sa',
	7 => 'So',
);
?>
