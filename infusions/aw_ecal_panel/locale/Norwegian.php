<?php
/***************************************************************************
 *   awEventCalendar                                                       *
 *                                                                         *
 *   Copyright (C) 2006-2008 Artur Wiebe                                   *
 *   wibix@gmx.de                                                          *
 *                                                                         *
 *   Translation by post@lhslbandy.com                                     *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU General Public License as published by  *
 *   the Free Software Foundation; either version 2 of the License, or     *
 *   (at your option) any later version.                                   *
 ***************************************************************************/
$locale['EC000'] = "awEventCal";
$locale['EC001'] = "Hendelser";
$locale['EC002'] = "Notice";
$locale['EC003'] = "Advarsel";
$locale['awec_no_events']	= 'Ingen hendelser oppgitt.';
$locale['EC005'] = "Om...";
$locale['EC006']	= 'Er du sikker på at du vil slette?';
$locale['EC007'] = "Min";
$locale['EC008'] = "Registreringer";
$locale['EC009'] = "Måned";
$locale['EC010'] = "År";
$locale['EC011'] = "Søk";
//
$locale['EC013'] = "Nye hendelser";
$locale['awec_user_birthday']	= array(
	'title'	=> '%ss bursdag',
	'body'	=> '%1 blir %2 år.',
);
$locale['awec_user']		= 'Brukers bursdag';
$locale['awec_link']		= 'Link til hendelsen';

$locale['awec_add']		= 'Legg til';
$locale['awec_save_changes']	= 'Lagre endringer';
$locale['awec_edit']		= 'Forandre';
$locale['awec_none']		= '[Ingen]';
$locale['awec_name']		= 'Navn';
$locale['awec_or']		= 'eller';
$locale['awec_export']		= 'Eksporter';
$locale['awec_login_start']	= 'Login starter';
$locale['awec_login_end']	= 'Login ender';
$locale['awec_status']		= 'Status';
$locale['awec_publish']		= 'Publiser';

$locale['awec_today']		= 'I dag';


// edit_event.php
$locale['EC100'] = "Ny hendelse";
$locale['EC101'] = "Forandre hendelse";
$locale['EC102'] = "Til hendelse";
$locale['EC103'] = "Tittel";
$locale['awec_description'] = 'Beskrivelse';
$locale['awec_date']	= 'Dato';
$locale['awec_beginn']	= 'Fra';
$locale['awec_end']	= 'Til';
$locale['EC106'] = "Innstillinger";
$locale['EC107'] = "Repeter";
$locale['EC108'] = "Privat hendelse";
$locale['EC109'] = "Tillat registrering til hendelsen";
$locale['EC110'] = "Maks antall registreringer (0 for uendelig)";
$locale['EC110_1'] = "0 for uendelig";
$locale['EC111'] = "Lagre";
$locale['EC112'] = "Deaktiver smilyer";
$locale['EC113'] = array(
	0		=> 'Hendelse oppdatert!',
	EC_ELOGIN	=> "Ingen registreringer for private hendelser tillatt.",
	EC_EDB		=> "Feil ved oppdatering av database.",
	EC_ESTATUS	=> "Hendelsen må legges ut av en administrator.",
	EC_EACCESS	=> "Ingen grense for antallet private hendelser satt.",
	EC_EIMG		=> "Ugyldig bildeopplasning.",
	EC_EDATE	=> "Ugyldig dato",
);
$locale['EC114'] = "Registreringer for denne hendelsen er ikke mulig.";
$locale['EC115'] = array(
	1 => "Maks antall registreringer nådd.",
	2 => "Ugyldig statusverdi.",
	3 => "Kunne ikke oppdatere registreringsstatus.",
	4 => "Ingen mottager spesifisert.",
);
$locale['EC116'] = "Adgang";
//$locale['EC117'] = "";
$locale['awec_mandatory']	= '* obligatoriske felter';
$locale['awec_break']		= '** Teksten etter %s, won\'t vil ikke dukke opp i sidepanelet. På denne måten kan du unngå overfylte sidepanel.';
$locale['EC119'] = "Fyll inn i alle obligatoriske felter (*)!";
$locale['awec_date_fmt']	= 'Dag.Måned.År ';
$locale['awec_time_fmt']	= 'Timer:Minutter';
$locale['EC121'] = "Bilde";
$locale['EC122'] = "Misc";
$locale['EC123'] = "Slutt";
$locale['EC124'] = "Tillatt registreringer kun i dette tidsrommet.";
$locale['EC125'] = array(
	0 => '[None]',
	1 => 'Årlig',
	2 => 'Månedlig',
	4 => 'Ukentlig',
	8 => 'Daglig',
);
$locale['awec_private_saving']		= 'Private hendelser kan bli publisert øyeblikkelig.';
$locale['awec_endless_repeat']		= 'Uendelig repetisjon';
$locale['awec_save_draft']		= 'Lagre som kladd';
$locale['awec_save_release']		= 'Lagre og legg til';
$locale['awec_save_publish']		= 'Lagre og publiser';


// aw_ecal_panel.php
$locale['EC200'] = "Legg til ny hendelse";
$locale['EC202'] = "I morgen";
$locale['EC203'] = "Nye hendelser trengs sjekkes!.";
$locale['EC204'] = "Mine hendelser";
$locale['EC205'] = "Bursdag(er)";
$locale['EC206'] = "Mine registreringer";
$locale['EC207'] = "[mer]";
$locale['EC208'] = 'Kommende %s dager';
$locale['EC209'] = array(
	'today'		=> 'I dag',
	'tomorrow'	=> 'I morgen',
	'others'	=> 'Neste hendelse(r)',
);


// view_event.php
$locale['EC300'] = "Hendelse";
$locale['EC301'] = $locale['EC113'][3];
$locale['EC302'] = "Advarsel! Bruker ikke oppgitt i database.";
$locale['EC303'] = "Ukjent";
$locale['EC305'] = "Slett";
$locale['EC306'] = "Publiser";
$locale['EC307'] = 'Deaktiver';
//EC308
$locale['EC309'] = array(
	0 => "Ikke satt opp til denne hendelsen.",
	1 => "Nesten Gotatt.",
	2 => "Helt Godtatt.",
	3 => "Kanselert",
	4 => "Invitert",
);
$locale['EC310'] = array(
	1 => "Helt Godtatt",
	2 => "Nesten Godtatt",
	3 => "Avbryt",
);
$locale['EC311'] = "Gjeldende status:";
$locale['EC312'] = "Kommentèr";
$locale['EC313'] = "Send E-Post";
$locale['EC314'] = "Send en e-post til hver";
$locale['EC315'] = "Send en e-post til alle";
$locale['EC316'] = "Send";
$locale['EC317'] = "En beskrivelse hadde vært fint.";
$locale['EC318'] = "Ingen mottagere valgt. Endre på dette!";
$locale['EC319'] = "Alle";
$locale['EC320'] = "E-post(er) har blitt sendt!";
$locale['EC321'] = "HTML-Format";
$locale['EC322'] = "Invitèr";
$locale['EC323'] = "Bruk CTRL-/SHIFT til å velge flere brukere";
$locale['EC324'] = 'Send PM';
$locale['awec_invite_title']	= 'Invitasjon';
$locale['awec_invite_body']	= 'Du ble invitert.';


// calendar.php
$locale['awec_calendar'] = "Kalender";
$locale['EC401'] = "Bursdager denne måneden";
$locale['EC402'] = "Vis som";
$locale['awec_month_view'] = array(
	'calendar'	=> 'Kalender',
	'list'		=> 'Liste',
);


// browse.php
$locale['EC450'] = "År";
$locale['EC451'] = "Vis";


// new_events.php
$locale['EC500'] = "Nye hendelser";
$locale['EC501'] = "Ingen nye hendelser.";
$locale['EC502'] = array(
	1 => "Kunne ikke publisere hendelsen siden den ble forandret underveis. Sjekk dette igjen!",
);


// search.php
$locale['EC550'] = "Søk etter";
$locale['EC551'] = array(
	'AND'	=> 'Alle ord',
	'OR'	=> 'Minst ett ord',
	'-'	=> 'Denne fremstillingen som ett ord',
);
$locale['EC552'] = "Hendelse funnet.";
$locale['EC553'] = "Alternativer";
$locale['EC554'] = "Søkeordet må minst inneholde 3 ord";


// my_events.php
$locale['EC600'] = "Mine hendelser";
$locale['EC601'] = "Ingen hendelser opprettet enda.";
$locale['EC602'] = array(
	0	=> 'Andre',
	1	=> 'Private',
);
$locale['awec_status_desc'] = array(
	AWEC_PUBLISHED	=> 'Publisert',
	AWEC_PENDING	=> 'Venter på å bli publisert',
	AWEC_DRAFT	=> 'Kladd',
);
$locale['awec_status_longdesc'] = array(
	AWEC_PUBLISHED	=> 'Publisert',
	AWEC_PENDING	=> 'Venter på å bli publisert',
	AWEC_DRAFT	=> 'Hendelsen er bare en kladd enda.',
);


// admin.php
$locale['EC700'] = "Alternativer";
$locale['EC701'] = "Admin-gruppe";
$locale['EC702'] = "Sjekk nye hendelser fra Admin-gruppen";
$locale['EC703'] = "Underkast hendelser fra";
$locale['EC704'] = "Vis beskrivelse av dagens hendelser i sidepanelet.";
$locale['awec705']	= 'Behandle brukerbursdager som hendelser.';
$locale['EC706'] = "Vis bursdager til";
$locale['EC711'] = 'Dato/Tid-Format';
$locale['EC712'] = "Bursdager";
$locale['EC713'] = "Standard";
$locale['EC714'] = "Brukes bare når den ikke er spesifisert av tema.";
$locale['EC715'] = "Slett hendelser";
$locale['EC716'] = 'Slett hvis eldre enn oppsatt dag.';
$locale['EC716_']	= 'Repeterte hendelser vil ikke bli slettet!';
$locale['EC717'] = array(
	0	=> "Lagret",
	1	=> "Gamle hendelser slettet!",
);
$locale['awec_confirm_del']	= 'Fjern hendelsen totalt';
$locale['EC719'] = "%d - dag, (00-31)
%m - måned, (00-12)
%Y - år, fire tall
%H - timer
%i - minutter
Mer informasjon om funksjonen DATE_FORMAT finner du: <a href='http://dev.mysql.com/doc/refman/4.1/en/date-and-time-functions.html#id3022503' target='_blank'>Her</a>";
$locale['EC720'] = "Forhåndsvis";
$locale['EC721'] = "Dager";
$locale['EC722'] = "Neste dager i sidepanelet";
$locale['EC723'] = "Uken starter på søndag";
$locale['EC724'] = "SidePanel";
$locale['EC725'] = "Bruk kun:";
$locale['EC726'] = 'Tid';
$locale['awec_default_month_view']	= 'Standard månedsvisning';
$locale['awec_custom_css']		= 'Bruk vanlig CSS (se README)';
$locale['awec_alt_side_calendar']	= 'Bruk alternativt sidepanel';
$locale['awec_user_can_edit']		= 'Eksisterende hendelser kan forandres';

// admin_cats.php
$locale['awec_cats']		= 'Kategorier';

// admin/misc.php
$locale['EC750']		= 'Misc';
$locale['awec_old_events']	= 'Gamle hendelser';

// include/db_update.php
$locale['EC800'] = "Oppdatering tilgjengelig";
$locale['EC801'] = "Følgende SQL-Endringene vil bli gjort";
$locale['EC802'] = "Start Oppdatering...";
//
$locale['EC804'] = "Ferdig! - Fortsett!";
$locale['EC805'] = "OK";
$locale['EC806'] = "Feil";
//
$locale['awec_pls_delete']	= 'Slett disse filene:';


// others
$locale['EC900'] = array(
	0 => '--',
	1 => 'Januar',
	2 => 'Februar',
	3 => 'Mars',
	4 => 'April',
	5 => 'Mai',
	6 => 'Juni',
	7 => 'Juli',
	8 => 'August',
	9 => 'September',
	10 => 'Oktober',
	11 => 'November',
	12 => 'Desember',
);
$locale['EC901'] = array(
	0 => 'Sø',
	1 => 'Ma',
	2 => 'Ti',
	3 => 'On',
	4 => 'To',
	5 => 'Fr',
	6 => 'Lø',
	7 => 'Sø',
);
?>
