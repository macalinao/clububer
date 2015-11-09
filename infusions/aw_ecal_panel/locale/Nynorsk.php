<?php
/***************************************************************************
 *   awEventCalendar                                                       *
 *                                                                         *
 *   Copyright (C) 2006-2007 Artur Wiebe                                   *
 *   wibix@gmx.de                                                          *
 *                                                                         *
 *   Norwegian translation by pma@tubaplayer.com                           *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU General Public License as published by  *
 *   the Free Software Foundation; either version 2 of the License, or     *
 *   (at your option) any later version.                                   *
 ***************************************************************************/
$locale['EC000'] = "awEventCal";
$locale['EC001'] = "Kalender";
$locale['EC002'] = "Notice";
$locale['EC003'] = "Advarsel";
$locale['EC004'] = "Ingen";
$locale['EC005'] = "Om...";
$locale['EC006'] = "Er du sikker p� at du vil slette?";
$locale['EC007'] = "Mine";
$locale['EC008'] = "P�meldingar";
$locale['EC009'] = "M�nad";
$locale['EC010'] = "�r";
$locale['EC011'] = "S�k";
//
$locale['EC013'] = "Nye Aktivitetar";


// edit_event.php
$locale['EC100'] = "Ny Aktivitet";
$locale['EC101'] = "Rediger Aktivitet";
$locale['EC102'] = "Til Aktivitet";
$locale['EC103'] = "Tittel";
$locale['EC104'] = "Beskriving";
$locale['EC105'] = "Start";
$locale['EC106'] = "Valg";
$locale['EC107'] = "Gjenta";
$locale['EC108'] = "Privat Aktivitet";
$locale['EC109'] = "Tillat P�meldingar";
$locale['EC110'] = "Maks P�meldingar (0 = ubegrensa)";
$locale['EC110_1'] = "0 = ubegrensa";
$locale['EC111'] = "Lagre";
$locale['EC112'] = "Deaktiver Smilefjes";
$locale['EC113'] = array(
	0		=> "Aktiviteten blei lagra/oppdatert!",
	EC_ELOGIN	=> "P�melding til private aktivitetar er ikkje tillete.",
	EC_EDB		=> "Ein feil oppstod medan databasen vart oppdatert.",
	EC_ESTATUS	=> "Denne aktiviteten m� godkjennast av ein admin.",
	EC_EACCESS	=> "Det er ikkje tillete med begrensa p�meldingar for private aktivitetar.",
	EC_EIMG		=> "Ugyldig opplasting av bilete.",
	EC_EDATE	=> "Ugyldig dato",
);
$locale['EC114'] = "Det er ikkje mogleg � melde seg p� til denne aktiviteten.";
$locale['EC115'] = array(
	1 => "Maksimalt antall p�meldingar er n�dd.",
	2 => "Ugyldig status.",
	3 => "Kunne ikkje oppdatere p�meldingsstatusen.",
	4 => "Det er ikkje spesifisert ein mottakar.",
);
$locale['EC116'] = "Tilgang";
//$locale['EC117'] = "";
$locale['EC118'] = "* obligatoriske felt<br>"
	. "** Tekst etter %s, vil ikkje vise i sidepanelet. Bruk dette for � unng� for mykje innhald i sidepanelet.";
$locale['EC119'] = "Obligatorisk informasjon manglar (*)!";
$locale['EC120'] = "Format: Dag.M�nad.�r Time:Minutt";
$locale['EC121'] = "Bilete";
$locale['EC122'] = "Diverse";
$locale['EC123'] = "Slutt";
$locale['EC124'] = "Berre tillat p�meldingar i dette tidsrommet.";
$locale['EC125'] = array(
	0 => "---",
	1 => "pr �r",
	2 => "pr M�nad",
	4 => "pr Veke",
);


// aw_ecal_panel.php
$locale['EC200'] = "Ny Aktivitet";
$locale['EC201'] = "I Dag";
$locale['EC202'] = "I Morgon";
$locale['EC203'] = "Nye aktivitetar m� kontrollerast!.";
$locale['EC204'] = "Mine Aktivitetar";
$locale['EC205'] = "Bursdag(ar)";
$locale['EC206'] = "Mine P�meldingar";
$locale['EC207'] = "[meir]";
$locale['EC208'] = "Neste %s dagar";


// view_event.php
$locale['EC300'] = "Aktivitet";
$locale['EC301'] = $locale['EC113'][3];
$locale['EC302'] = "Advarsel! Brukaren finst ikkje i databasen.";
$locale['EC303'] = "Ukjend";
$locale['EC304'] = "Rediger";
$locale['EC305'] = "Slett";
$locale['EC306'] = "Publiser";
$locale['EC307'] = "Deaktiver";
//EC308
$locale['EC309'] = array(
	0 => "Ikkje p�meld til denne aktiviteten.",
	1 => "Deltek Garantert.",
	2 => "Deltek Truleg.",
	3 => "Deltek Ikkje",
	4 => "Invitert",
);
$locale['EC310'] = array(
	1 => "Deltek Garantert",
	2 => "Deltek Truleg",
	3 => "Deltek Ikkje",
);
$locale['EC311'] = "Gjeldande Status:";
$locale['EC312'] = "Kommentar";
$locale['EC313'] = "Send E-Post";
$locale['EC314'] = "Send ein e-post til kvar";
$locale['EC315'] = "Send ein e-post til alle";
$locale['EC316'] = "Send";
$locale['EC317'] = "Meir informasjon hadde vore fint. Takk!";
$locale['EC318'] = "Ingen mottakarar definert. Det m� endrast!";
$locale['EC319'] = "Alle";
$locale['EC320'] = "E-post(ar) er sendt!";
$locale['EC321'] = "HTML-Format";
$locale['EC322'] = "Inviter";
$locale['EC323'] = "Bruk CTRL-/SHIFT for � velge fleire brukarar";


// calendar.php
$locale['awec_calendar'] = "Kalender";
$locale['EC401'] = "Bursdagar denne m�naden";
$locale['EC402'] = "Visning";
$locale['EC403'] = "Kalender";
$locale['EC404'] = "Liste";


// browse.php
$locale['EC450'] = "�r";
$locale['EC451'] = "Vis";


// new_events.php
$locale['EC500'] = "Nye Aktivitetar";
$locale['EC501'] = "Nye aktivitetar som m� kontollerast.";
$locale['EC502'] = array(
	1 => "Aktiviteten kunne ikkje publiserast, den har blitt endra i mellomtida. Sjekk aktiviteten igjen!",
);


// search.php
$locale['EC550'] = "S�k etter";
$locale['EC551'] = array(
	"AND"	=> "AND",
	"OR"	=> "OR",
	"-"	=> "No",
);
$locale['EC552'] = "Resultat.";
$locale['EC553'] = "Alternativ";
$locale['EC554'] = "S�ket m� innehalde minst 3 tegn.";


// my_events.php
$locale['EC600'] = "Mine Aktivitetar";
$locale['EC601'] = "Ingen aktivitetar.";
$locale['EC602'] = array(
	0	=> "Andre",
	1	=> "Privat",
);


// admin.php
$locale['EC700'] = "Innstillingar";
$locale['EC701'] = "Admin-gruppa";
$locale['EC702'] = "Admin-gruppa m� godkjenne nye aktivitetar";
$locale['EC703'] = "Brukarniv� for � legge inn aktivitet";
$locale['EC704'] = "Vis beskriving av dagens aktivitetar i sidepanelet.";
$locale['EC705'] = "Vis bursdagar i sidepanelet.";
$locale['EC706'] = "Vis bursdagar til";
$locale['EC707'] = "Ballong";
$locale['EC708'] = "Bredde i Pixlar";
$locale['EC709'] = "Forgrunn";
$locale['EC710'] = "Bakgrunn";
$locale['EC711'] = "Datoformat";
$locale['EC712'] = "Bursdagar";
$locale['EC713'] = "Standard";
$locale['EC714'] = "Brukast berre n�r ikkje spesifisert i theme-pakken.";
$locale['EC715'] = "Slett Aktivitetar";
$locale['EC716'] = "Slett alle aktivitetar eldre enn x dagar (spesifiser under). Gjentatte aktivitetar blir ikkje sletta!";
$locale['EC717'] = array(
	0	=> "Lagra",
	1	=> "Gamle aktivitetar sletta!",
);
$locale['EC718'] = "aktivitetar blir sletta";
$locale['EC719'] = "%d - Dag i m�naden, numerisk (00..31)
%m - M�nad, numerisk (00..12)
%Y - �r, numerisk, fire siffer
Meir informasjon om datoformat i funksjonen DATE_FORMAT: <a href='http://dev.mysql.com/doc/refman/4.1/en/date-and-time-functions.html#id3022503' target='_blank'>Her</a>";
$locale['EC720'] = "F�rehandsvis";
$locale['EC721'] = "Dagar";
$locale['EC722'] = "Neste dagar i sidepanelet";
$locale['EC723'] = "F�rste dag i veka er s�ndag";
$locale['EC724'] = "Sidepanel";

// admin/misc.php
$locale['EC750'] = "Diverse";

// include/db_update.php
$locale['EC800'] = "Oppdatering er tilgjengeleg!";
$locale['EC801'] = "F�lgjande SQL-Sp�rring(ar) blir utf�rt(e)";
$locale['EC802'] = "Start Oppdatering...";
//
$locale['EC804'] = "Ferdig - Fortsett!";
$locale['EC805'] = "OK";
$locale['EC806'] = "Feil";


// others
$locale['EC900'] = array(
	0 => "Desember",
	1 => "Januar",
	2 => "Februar",
	3 => "Mars",
	4 => "April",
	5 => "Mai",
	6 => "Juni",
	7 => "Juli",
	8 => "August",
	9 => "September",
	10 => "Oktober",
	11 => "November",
	12 => "Desember",
);
$locale['EC901'] = array(
	0 => "S�",
	1 => "Ma",
	2 => "Ti",
	3 => "On",
	4 => "To",
	5 => "Fr",
	6 => "L�",
	7 => "S�",
);
?>
