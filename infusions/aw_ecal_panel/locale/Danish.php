<?php // translation revised and updated on July 7. 2008 by Helmuth Mikkelsen  | originally translated by Helmuth Mikkelsen and Yxos
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
$locale['EC001'] = "Begivenheder";
$locale['EC002'] = "Henvisning";
$locale['EC003'] = "Advarsel";
$locale['awec_no_events'] = 'Ingen begivenheder.';
$locale['EC005'] = "Om...";
$locale['EC006'] = "Vil du slette?";
$locale['EC007'] = "Mine";
$locale['awec_logins'] = "Registreringer";
$locale['EC009'] = "Måned";
$locale['EC010'] = "År";
$locale['EC011'] = "Søg";
$locale['awec_week']	= 'Uge';
//
$locale['EC013'] = "Nye begivenheder";
$locale['awec_user_birthday'] = array(
	'title'	=> '%ss fødselsdag',
	'body'	=> '%1 er %2 år gammel.',
);
$locale['awec_user']		= 'Bruger fødselsdag';
$locale['awec_link']		= 'Link til begivenhed';

$locale['awec_add']		= 'Tilføj';
$locale['awec_save_changes']	= 'Gem ændringer';
$locale['awec_edit']		= 'Rediger';
$locale['awec_none']		= '[Ingen]';
$locale['awec_name']		= 'Navn';
$locale['awec_or']		= 'eller';
$locale['awec_export']		= 'Eksporter';
$locale['awec_login_start']	= 'Log ind begynder';
$locale['awec_login_end']	= 'Log ind slutter';
$locale['awec_status']		= 'Status';
$locale['awec_publish']		= 'Offentliggør';

$locale['awec_today']		= 'I dag';

$locale['awec_location']	= 'Sted';

$locale['awec_calendar_view'] = array(
	'week'	=> 'Uge',
	'month'	=> 'Måned',
	'year'	=> 'År',
);


// edit_event.php
$locale['EC100'] = "Ny begivenhed";
$locale['EC101'] = "Rediger begivenhed";
$locale['EC102'] = "Til begivenhed";
$locale['EC103'] = "Titel";
$locale['awec_description'] = 'Beskrivelse';
$locale['awec_date']	= 'Dato';
$locale['awec_beginn']	= 'Fra';
$locale['awec_end']	= 'Til';
$locale['awec_options'] = "Valg";
$locale['awec_repeat'] = "Gentag";
$locale['EC108'] = "Privat begivenhed";
$locale['EC109'] = "Tillad tilmelding til begivenhed";
$locale['EC110'] = "Tilmeldinger maksimalt (0 for uendelig)";
$locale['EC110_1'] = "0 for uendelig";
$locale['EC111'] = "Gem";
$locale['EC112'] = "Deaktiver smileys";
$locale['EC113'] = array(
	0		=> "Begivenhed er opdateret!",
	EC_ELOGIN	=> "Man kan ikke tilmelde sig private begivenheder.",
	EC_EDB		=> "Databasefejl under opdatering.",
	EC_ESTATUS	=> "Denne begivenhed mangler nu kun godkendelse af en administrator.",
	EC_EACCESS	=> "Til private begivenheder er adgangsniveauet irrelevant.",
	EC_EIMG		=> "Ugyldig billed upload.",
	'date'		=> "Ugyldig dato",
	'end_date'	=> 'Gentag indtil: Ugyldig dato',
);
$locale['EC114'] = "Tilmeldelse til denne begivenhed ikke (længere) mulig.";
$locale['EC115'] = array(
	1 => "Maksimalt antal mulige tilmeldinger opnået.",
	2 => "Ugyldig værdi i status tilmelding.",
	3 => "Kunne ikke opdatere tilmeldings status.",
	4 => "Ingen modtager oplyst.",
);
$locale['EC116'] = "Synlighed";
//$locale['EC117'] = "";
$locale['awec_mandatory'] = "* krævede felter<br>";
$locale['awec_break']	= "** Teksten efter %s, bliver ikke vist i sideelementet. På den måde undgår du et overfyldt sideelement.";
$locale['EC119'] = "Udfyld venligst alle krævede felter (*)!";
$locale['awec_date_fmt']	= 'Dag.Måned.År Time:Minutter';
$locale['awec_time_fmt']	= 'Timer:Minutter';
$locale['EC121'] = "Billede";
$locale['EC122'] = "Øvrigt";
$locale['EC123'] = "Slut";
$locale['EC124'] = "Tillad kun registreringer i denne tidsperiode.";
$locale['EC125'] = array(
	0 => "[Ingen]",
	1 => "Årligt",
	2 => "Månedligt",
	4 => "Ugentligt",
	8 => 'Dagligt',
);
$locale['awec_private_saving']		= 'Private begivenheder kan "offentliggøres" straks.';
$locale['awec_endless_repeat']		= 'Uendelig gentagelse';
$locale['awec_end_repeat']		= 'Gentag indtil ';
$locale['awec_save_draft']		= 'Gem som udkast';
$locale['awec_save_release']		= 'Gem og send';
$locale['awec_save_publish']		= 'Gem og offentliggør';
$locale['awec_cycle']			= 'Cyklus';


// aw_ecal_panel.php
$locale['EC200'] = "Opret ny begivenhed";
$locale['EC202'] = "I morgen";
$locale['EC203'] = "Der er nye begivenheder til godkendelse!";
$locale['EC204'] = "Mine begivenheder";
$locale['EC205'] = "Fødselsdage";
$locale['EC206'] = "Mine registreringer";
$locale['EC207'] = "[mere]";
$locale['EC208'] = "Følgende %s dage";
$locale['EC209'] = array(
	'today'		=> 'I dag',
	'tomorrow'	=> 'I morgen',
	'others'	=> 'Flere ...',
);


// view_event.php
$locale['EC300'] = "Begivenhed";
$locale['EC301'] = $locale['EC113'][3];
$locale['EC302'] = "Advarsel! Bruger er ikke i databasen.";
$locale['EC303'] = "Ukendt";
$locale['EC305'] = "Slet";
$locale['EC306'] = "Offentliggør";
$locale['EC307'] = "Deaktiver";
//EC308
$locale['EC309'] = array(
	0 => "Du er ikke tilmeldt til denne begivenhed.",
	1 => "Endegyldigt accepteret",
	2 => "Foreløbig accepteret",
	3 => "Afmeldt",
	4 => "Inviteret",
);
$locale['EC310'] = array(
	1 => "Endegyldig accept",
	2 => "Foreløbig accept",
	3 => "Afmeld",
);
$locale['EC311'] = "Nuværende status:";
$locale['EC312'] = "Kommentar";
$locale['EC313'] = "Send mail";
$locale['EC314'] = "Send mail til hver enkelt bruger";
$locale['EC315'] = "Send én mail til alle";
$locale['EC316'] = "Send";
$locale['EC317'] = "Noget indholdstekst ville være fint. Tak!";
$locale['EC318'] = "Ingen modtagere valgt. Ret det venligst!";
$locale['EC319'] = "Alle";
$locale['EC320'] = "Mail(s) er afsendt!";
$locale['EC321'] = "HTML-format";
$locale['EC322'] = "Inviter";
$locale['EC323'] = "Benyt CTRL-/SHIFT til at vælge flere brugere";
$locale['EC324'] = 'Send PB';
$locale['awec_invite_title']	= 'Invitation';
$locale['awec_invite_body']	= 'Du er blevet inviteret.';


// calendar.php
$locale['awec_calendar'] = "Kalender";
$locale['EC401'] = "Fødselsdage i denne måned";
$locale['EC402'] = "Se";
$locale['awec_month_view'] = array(
	'calendar'	=> 'Kalender',
	'list'		=> 'Liste',
	'clist'		=> 'KListe',
);


// browse.php
$locale['EC450'] = "År";
$locale['awec_show'] = "Vis";


// new_events.php
$locale['EC500'] = "Nye begivenheder";
$locale['EC501'] = "Der skal ikke frigives nogen begivenheder.";
$locale['EC502'] = array(
	1 => "Begivenheden kunne ikke frigives, da den i mellemtiden er blevet ændret. Venligst gennmse den igen!",
);


// search.php
$locale['EC550'] = "Søg efter";
$locale['EC551'] = array(
	"AND"	=> "Alle søgeord",
	"OR"	=> "Mindst et søgeord",
	"-"	=> "Hele udtrykket",
);
$locale['EC552'] = "Begivenheder fundet.";
$locale['EC553'] = "Valg";
$locale['EC554'] = "Søgeteksten skal være på mindst 3 karakterer";


// my_events.php
$locale['EC600'] = "Mine begivenheder";
$locale['EC601'] = "Du har endnu ikke oprettet nogle begivenheder.";
$locale['EC602'] = array(
	0	=> "Andre",
	1	=> "Privat",
);
$locale['awec_status_desc'] = array(
	AWEC_PUBLISHED	=> 'Offentliggjort',
	AWEC_PENDING	=> 'Afventer offentliggørelse',
	AWEC_DRAFT	=> 'Udkast',
);
$locale['awec_status_longdesc'] = array(
	AWEC_PUBLISHED	=> 'Offentliggjort',
	AWEC_PENDING	=> 'Afventer offentliggørelse',
	AWEC_DRAFT	=> 'Begivenhed er i udkast tilstand.',
);


// admin.php
$locale['EC700'] = "Indstillinger";
$locale['EC701'] = "Administratorgruppe";
$locale['EC702'] = "Godkendelse af nye begivenheder af administratorgruppen";
$locale['EC703'] = "Begivenheder kan oprettes af";
$locale['EC704'] = "Vis dagens begivenheder fuldt ud i side-element.";
$locale['awec705'] = "Behandl fødselsdage som begivenheder.";
$locale['EC706'] = "Vis fødselsdage for";
$locale['EC711'] = "Datoformat";
$locale['EC712'] = "Fødselsdage";
$locale['EC713'] = "Standard";
$locale['EC714'] = "Anvendes kun, når det ikke er specificeret i temaet.";
$locale['EC715'] = "Slet begivenheder";
$locale['EC716'] = "Slet alle begivenheder ældre end det specificerede antal dage.";
$locale['EC716_']	= 'Gentagne begivenheder vil ikke blive slettet!';
$locale['EC717'] = array(
	0	=> "Gemt",
	1	=> "Gamle begivenheder slettet!",
);
$locale['awec_confirm_del'] = "Begivenheder vil blive slettet permanent";
$locale['EC719'] = "%d - Dag i måneden, numerisk (00..31)
%m - Måned, numerisk (00..12)
%Y - År, numerisk, fire tegn
%H - Timer
%i - minutter
Få mere information om formatering med funktionen DATE_FORMAT: <a href='http://dev.mysql.com/doc/refman/4.1/en/date-and-time-functions.html#id3022503' target='_blank'>Her</a>";
$locale['EC720'] = "Se";
$locale['EC721'] = "Dage";
$locale['EC722'] = "Antal dage i side-element";
$locale['EC723'] = "Uge begynder med Søndag";
$locale['EC724'] = "Side-element";
$locale['EC725'] = "Bliver understøttet:";
$locale['EC726'] = 'Tid';
$locale['awec_default_month_view']	= 'Standard månedsvisning';
$locale['awec_custom_css']		= 'Brugertilpasset CSS (læs README)';
$locale['awec_alt_side_calendar']	= 'Alternativ Side-kalender';
$locale['awec_user_can_edit']		= 'Nuværende begivenheder kan redigeres';
$locale['awec_show_week']		= 'Vis uge';
$locale['awec_default_calendar_view']	= 'Standard-Kalendervisning';
$locale['awec_mysql_4']			= 'Du skal have MySQL version 4.1.1 eller højere, for at kunne bruge denne funktion.';

// admin_cats.php
$locale['awec_cats']		= 'Kategorier';
$locale['awec_cat']		= 'Kategori';

// admin/misc.php
$locale['EC750'] = "Diverse";
$locale['awec_old_events']	= 'Afsluttede begivenheder'; 

// include/db_update.php
$locale['EC800'] = "Opdatering tilgængelig";
$locale['EC801'] = "Følgende SQL statements vil blive udført";
$locale['EC802'] = "Start opdatering ...";
//
$locale['EC804'] = "Færdig - Fortsæt!";
$locale['EC805'] = "OK";
$locale['EC806'] = "Fejl";
//
$locale['awec_pls_delete']	= 'Venligst slet følgende filer:';


// others
$locale['EC900'] = array(
	0 => "--",
	1 => "Januar",
	2 => "Februar",
	3 => "Marts",
	4 => "April",
	5 => "Maj",
	6 => "Juni",
	7 => "Juli",
	8 => "August",
	9 => "September",
	10 => "Oktober",
	11 => "November",
	12 => "December",
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
