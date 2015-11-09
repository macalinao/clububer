<?php
/***************************************************************************
 *   awEventCalendar                                                       *
 *                                                                         *
 *   Copyright (C) 2006-2007 Artur Wiebe                                   *
 *   wibix@gmx.de                                                          *
 *                                                                         *
 *   Dutch translations by martijn78                                       *
 *   martijn@rikkerink.nu                                                  *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU General Public License as published by  *
 *   the Free Software Foundation; either version 2 of the License, or     *
 *   (at your option) any later version.                                   *
 ***************************************************************************/
$locale['EC000'] = "awEventCal";
$locale['EC001'] = "Evenementen";
$locale['EC002'] = "Bericht";
$locale['EC003'] = "Waarschuwing";
$locale['EC004'] = "Geen";
$locale['EC005'] = "Over...";
$locale['EC006'] = "Verwijderen?";
$locale['EC007'] = "Mijn";
$locale['EC008'] = "Registraties";
$locale['EC009'] = "Maand";
$locale['EC010'] = "Jaar";
$locale['EC011'] = "Zoeken";
//
$locale['EC013'] = "Nieuwe Evenementen";
$locale['awec_user_birthday']	= array(
	'title'	=> '%ss verjaardag',
	'body'	=> '%1 is %2 jaar oud.',
);
$locale['awec_user']		= 'verjaardag lid';
$locale['awec_link']		= 'Link naar evenemen';

$locale['awec_add']		= 'Toevoegen';
$locale['awec_save_changes']	= 'Wijzigingen Opslaan';
$locale['awec_edit']		= 'Wijzig';
$locale['awec_none']		= '[Geen]';
$locale['awec_name']		= 'Naam';
$locale['awec_or']		= 'of';
$locale['awec_export']		= 'Exporteer';
$locale['awec_login_start']	= 'Inloggen Begin';
$locale['awec_login_end']	= 'Inloggen Eind';
$locale['awec_status']		= 'Status';
$locale['awec_publish']		= 'Publiceer';

$locale['awec_today']		= 'Vandaag';


// edit_evenement.php
$locale['EC100'] = "Nieuw Evenement";
$locale['EC101'] = "Wijzig Evenement";
$locale['EC102'] = "Naar Evenement";
$locale['EC103'] = "Titel";
$locale['awec_description'] = 'Omschrijving';
$locale['awec_date']	= 'Datum';
$locale['awec_beginn']	= 'Van';
$locale['awec_end']	= 'Tot';
$locale['EC106'] = "Opties";
$locale['EC107'] = "Herhalen";
$locale['EC108'] = "Privé Evenement";
$locale['EC109'] = "Registratie toelaten";
$locale['EC110'] = "Maximum registraties (0 = oneindig)";
$locale['EC110_1'] = "0 voor oneindig";
$locale['EC111'] = "Opslaan";
$locale['EC112'] = "Smileys uitschakelen";
$locale['EC113'] = array(
	0		=> "Evenement succesvol opgeslagen!",
	EC_ELOGIN	=> "Geen registratie toegelaten.",
	EC_EDB		=> "Fout tijdens updaten database.",
	EC_ESTATUS	=> "Dit Evenement moet door een beheerder worden goedgekeurd.",
	EC_EACCESS	=> "Geen restricties toegelaten voor privé Evenementen.",
	EC_EIMG		=> "Ongeldige afbeelding upload.",
	EC_EDATE	=> "Ongeldige datum",
);
$locale['EC114'] = "Registraties niet mogelijk.";
$locale['EC115'] = array(
	1 => "Maximale aantal registraties bereikt.",
	2 => "Ongeldige statuswaarde.",
	3 => "Kon registratiestatus niet opslaan.",
	4 => "Geen ontvanger gekozen.",
);
$locale['EC116'] = "Toegang";
//$locale['EC117'] = "";
$locale['EC118'] = "* verplichte velden<br>"
	. "** De tekst achter %s, wordt niet getoond in het zijde-paneel. Op deze manier voorkom je een overvol paneel.";
$locale['EC119'] = "Vul aub alle verplichte velden in(*)!";
$locale['awec_date_fmt']	= 'Dag.Maand.Jaar Uur:Minuten';
$locale['awec_time_fmt']	= 'Uren:Minuten';
$locale['EC121'] = "Afbeelding";
$locale['EC122'] = "Misc";
$locale['EC123'] = "Eind";
$locale['EC124'] = "Registraties alleen toestaan in deze periode.";
$locale['EC125'] = array(
	0 => "---",
	1 => "Jaarlijks",
	2 => "Maandelijks",
	4 => "Wekelijks",
	8 => 'Daily',
);
$locale['awec_private_saving']		= 'Privé evenementen kunnen direct worden "gepubliceerd".';
$locale['awec_endless_repeat']		= 'Eindeloos herhalen';
$locale['awec_save_draft']		= 'Opslaan als Concept';
$locale['awec_save_release']		= 'Opslaan en Inzenden';
$locale['awec_save_publish']		= 'Opslaan en Publiceren';

// aw_ecal_panel.php
$locale['EC200'] = "Nieuw Evenement";
$locale['EC201'] = "Vandaag";
$locale['EC202'] = "Morgen";
$locale['EC203'] = "Nieuwe Evenementen worden eerst bekeken!.";
$locale['EC204'] = "Mijn Evenementen";
$locale['EC205'] = "Verjaardag(en)";
$locale['EC206'] = "Mijn Registraties";
$locale['EC207'] = "[meer]";
$locale['EC209'] = array(
	'today'		=> 'Vandaag',
	'tomorrow'	=> 'Morgen',
	'others'	=> 'Meer...',
);


// view_evenement.php
$locale['EC300'] = "Evenement";
$locale['EC301'] = $locale['EC113'][3];
$locale['EC302'] = "Waarschuwing! Gebruiker niet in database.";
$locale['EC303'] = "Onbekend";
$locale['EC304'] = "Wijzig";
$locale['EC305'] = "Verwijder";
$locale['EC306'] = "Publiceer";
$locale['EC307'] = "De-aktiveer";
//EC308
$locale['EC309'] = array(
	0 => "Niet ingeschreven voor dit Evenement.",
	1 => "Accoord.",
	2 => "Vooralsnog accoord.",
	3 => "Afgezegd",
	4 => "Uitgenodigd",
);
$locale['EC310'] = array(
	1 => "Accoord gaan",
	2 => "Voorlopig accoord gaan",
	3 => "Afzeggen",
);
$locale['EC311'] = "Huidige status:";
$locale['EC312'] = "Reactie";
$locale['EC313'] = "Stuur email";
$locale['EC314'] = "Zend een email naar elke";
$locale['EC315'] = "Zend email naar iedereen";
$locale['EC316'] = "Zend";
$locale['EC317'] = "Tekst invoeren aub. Bedankt!";
$locale['EC318'] = "Geen ontvangers gekozen. Wijzig dit?!";
$locale['EC319'] = "Alle";
$locale['EC320'] = "Zend email(s)!";
$locale['EC321'] = "HTML-Formaat";
$locale['EC322'] = "Uitnodigen";
$locale['EC323'] = "Gebruik CTRL-/SHIFT om meerdere leden te selecteren";
$locale['EC324'] = 'Zend PB';
$locale['awec_invite_title']	= 'Uitnodiging';
$locale['awec_invite_body']	= 'Je bent uitgenodigd.';

// calendar.php
$locale['awec_calendar'] = "Kalender";
$locale['EC401'] = "Verjaardagen in deze maand";
$locale['EC402'] = "Bekijk";
$locale['awec_month_view'] = array(
	'calendar'	=> 'Kalender',
	'list'		=> 'Lijst',
);


// browse.php
$locale['EC450'] = "Jaar";
$locale['EC451'] = "Toon";


// new_evenements.php
$locale['EC500'] = "Nieuwe Evenementen";
$locale['EC501'] = "Geen nieuwe Evenementen om te bekijken.";
$locale['EC502'] = array(
	1 => "Kon niet publiceren omdat Evenement tussentijds gewijzigd is. Bekijk opnieuw!",
);


// search.php
$locale['EC550'] = "Zoek naar";
$locale['EC551'] = array(
	"AND"	=> "EN",
	"OR"	=> "OF",
	"-"	=> "Geen",
);
$locale['EC552'] = "Evenementen gevonden.";
$locale['EC553'] = "Opties";
$locale['EC554'] = "Zoekterm op zijn minst drie letters";


// my_evenements.php
$locale['EC600'] = "Mijn Evenement(en)";
$locale['EC601'] = "Nog geen Evenementen toegevoegd.";
$locale['EC602'] = array(
	0	=> "Anderen",
	1	=> "Privé",
);
$locale['awec_status_desc'] = array(
	AWEC_PUBLISHED	=> 'Gepubliceerd',
	AWEC_PENDING	=> 'Wacht op publicatie',
	AWEC_DRAFT	=> 'Concept',
);
$locale['awec_status_longdesc'] = array(
	AWEC_PUBLISHED	=> 'Gepubliseerd',
	AWEC_PENDING	=> 'Wacht op publicatie',
	AWEC_DRAFT	=> 'Evenement is in Concept.',
);

// admin.php
$locale['EC700'] = "Instellingen";
$locale['EC701'] = "Admin-Groep";
$locale['EC702'] = "Controlleer nieuwe Evenementen door de Admin-Groep";
$locale['EC703'] = "Voeg Evenementen toe van";
$locale['EC704'] = "Toon omschrijving van Evenementen van vandaag in zijde-paneel.";
$locale['awec705']	= 'Behandel verjaardagen als evenement.';
$locale['EC706'] = "Toon verjaardagen aan";
$locale['EC711'] = "Datum Formaat";
$locale['EC712'] = "Verjaardagen";
$locale['EC713'] = "Standaard";
$locale['EC714'] = "Wordt alleen gebruikt zonder gespecificeerd thema.";
$locale['EC715'] = "Verwijder Evenementen";
$locale['EC716'] = "Verwijder alle Evenementen ouder dan een bepaald aantal dagen. Herhaalde Evenementenworden niet verwijderd!";
$locale['EC717'] = array(
	0	=> "Opgeslagen",
	1	=> "Oude Evenementen verwijderd!",
);
$locale['awec_confirm_del']	= 'Evenementen worden verwijderd';
$locale['EC719'] = "%d - Dag van de maand, numeriek (00..31)
%m - Maand, numeriek (00..12)
%Y - Jaar, numeriek, vier getallen
%H - uren
%i - minuten
Meer informatie over het formaat van de functie DATE_FORMAT: <a href='http://dev.mysql.com/doc/refman/4.1/en/date-and-time-functions.html#id3022503' target='_blank'>Hier</a>";
$locale['EC720'] = "Bekijken";	
$locale['EC721'] = "Dagen";
$locale['EC722'] = "Volgende dagen in zijde-paneel";
$locale['EC723'] = "Week start op zondag";
$locale['EC724'] = "Zijde-Paneel";
$locale['EC725'] = "Alleen ondersteund door:";
$locale['EC726'] = 'Tijd';
$locale['awec_default_month_view']	= 'Standaard maandoverzicht';
$locale['awec_custom_css']		= 'Gebruik eigen CSS (Zie README)';
$locale['awec_alt_side_calendar']	= 'Gebuik alternatieve Zijde-kalendar';
$locale['awec_user_can_edit']		= 'Bestaande evenementen kunnen worden verwijderd';

// admin_cats.php
$locale['awec_cats']		= 'Categoriën';

// admin/misc.php
$locale['EC750'] = "Misc";
$locale['awec_old_events']	= 'Verlopen Evenementen';

// include/db_update.php
$locale['EC800'] = "Update beschikbaar";
$locale['EC801'] = "De volgende SQL-Opdrachten zullen worden uitgevoerd";
$locale['EC802'] = "Update starten...";
//
$locale['EC804'] = "Klaar - Doorgaan!";
$locale['EC805'] = "OK";
$locale['EC806'] = "Fout";
//
$locale['awec_pls_delete']	= 'Verwijder aub deze bestanden:';


// others
$locale['EC900'] = array(
	0 => "December",
	1 => "Januari",
	2 => "Februari",
	3 => "Maart",
	4 => "April",
	5 => "Mei",
	6 => "Juni",
	7 => "Juli",
	8 => "Augustus",
	9 => "September",
	10 => "Oktober",
	11 => "November",
	12 => "December",
);
$locale['EC901'] = array(
	0 => "Zo",
	1 => "Ma",
	2 => "Di",
	3 => "Wo",
	4 => "Do",
	5 => "Vr",
	6 => "Za",
	7 => "Zo",
);
?>
