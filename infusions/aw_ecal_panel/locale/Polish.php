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
$locale['EC001'] = "Kalendarz";
$locale['EC002'] = "Notatka";
$locale['EC003'] = "Ostrze�enie";
$locale['awec_no_events']	= 'Brak wydarze�.';
$locale['EC005'] = "O...";
$locale['EC006'] = "Na pewno skasowa�?";
$locale['EC007'] = "Moje";
$locale['EC008'] = "Rejestracje";
$locale['EC009'] = "Miesi�c";
$locale['EC010'] = "Rok";
$locale['EC011'] = "Szukaj";
//
$locale['EC013'] = "Nowe wydarzenia";
$locale['awec_user_birthday']	= array(
	'title'	=> '%ss birthday',
	'body'	=> '%1 is %2 years old.',
);
$locale['awec_user']		= 'Urodziny u�ytkownika';
$locale['awec_link']		= 'Link do wydarzenia';

$locale['awec_add']		= 'Dodaj';
$locale['awec_save_changes']	= 'Zapisz zmiany';
$locale['awec_edit']		= 'Edytuj';
$locale['awec_none']		= '[---]';
$locale['awec_name']		= 'Nazwa';
$locale['awec_or']		= 'lub';
$locale['awec_export']		= 'Eksport';
$locale['awec_login_start']	= 'Logowanie rozpocz�te';
$locale['awec_login_end']	= 'Logowanie zako�czone';
$locale['awec_status']		= 'Status';
$locale['awec_publish']		= 'Publiczne';

$locale['awec_today']		= 'Dzisiaj';


// edit_event.php
$locale['EC100'] = "Nowe wydarzenie";
$locale['EC101'] = "Edytuj wydarzenie";
$locale['EC102'] = "Do wydarze�";
$locale['EC103'] = "Tytu�";
$locale['EC104'] = "Opis";
$locale['awec_date']	= 'Data';
$locale['awec_beginn']	= 'Od';
$locale['awec_end']	= 'Do';
$locale['EC106'] = "Opcje";
$locale['EC107'] = "Powt�rz";
$locale['EC108'] = "Prywatne wydarzenia";
$locale['EC109'] = "Rejestracje do wydarze� dozwolone";
$locale['EC110'] = "Maksymalnie rejestracji";
$locale['EC110_1'] = "0 dla niesko�czonej";
$locale['EC111'] = "Zapisz";
$locale['EC112'] = "Wy��cz u�mieszki";
$locale['EC113'] = array(
	0                => "Wydarzenie zaktualizowano z sukcesem.<br>Prosz� sprawdzi� dane dla pewno�ci.",
	EC_ELOGIN        => "Dla prywatnych wydarze� nie dopuszczono rejestracji.",
	EC_EDB           => "B��d przy aktualizacji bazy danych.",
	EC_ESTATUS       => "To wydarzenie musi by� upublicznione przez Administracje.",
	EC_EACCESS       => "Dla prywatnych wydarze� uprawnienie dost�pu jest ograniczone.",
	EC_EIMG          => "B��d przy za�adowaniu obrazka.",
	EC_EDATE         => "Niew�a�ciwa data",
);
$locale['EC114'] = "Rejestracja do tego wydarzenie jest niemo�liwa.";
$locale['EC115'] = array(
	1 => "Maksymalna liczba mo�liwych rejestracji osi�gni�ta.",
	2 => "Niew�a�ciwa warto�� statusu.",
	3 => "Nie mog�em zaktualizowa� statusu rejestracji.",
	4 => "Nie wprowadzono adresata.",
);
$locale['EC116'] = "Dost�p";
//$locale['EC117'] = "";
$locale['awec_mandatory']	= '* obowi�zkowe pola';
$locale['awec_break']		= '** Tekst po %s, nie\' uka�e si� wbocznym panelu. Wten spos�b unikniemy jego przepe�nienia.';
$locale['EC119'] = "Wype�nij wszystkie wymagane pola (*)!";
$locale['awec_date_fmt']	= 'Dzie�.Miesi�c.Rok Godzina:Minuty';
$locale['awec_time_fmt']	= 'Godzin:Minut';
$locale['EC121'] = "Obrazek";
$locale['EC122'] = "Dodatki";
$locale['EC123'] = "Koniec";
$locale['EC124'] = "Rejestracje dozwolone tylko w tym czasie";
$locale['EC125'] = array(
	0 => '[---]',
	1 => 'Rocznie',
	2 => 'Miesi�cznie',
	4 => 'Tygodniowo',
	8 => 'Dziennie',
);
$locale['awec_private_saving']		= 'Prywatne wydarzenie mog� by� "upublicznione" natychmiastowo.';
$locale['awec_endless_repeat']		= 'zako�cz powtarzanie';
$locale['awec_save_draft']		= 'Zapisz jako projekt';
$locale['awec_save_release']		= 'Zapisz i potwierd�';
$locale['awec_save_publish']		= 'Zapisz i Publikuj';


// aw_ecal_panel.php
$locale['EC200'] = "Wprowad� nowe wydarzenie";
$locale['EC201'] = "Dzisiaj";
$locale['EC202'] = "Jutro";
$locale['EC203'] = "Nowe wydarzenia musz� by� sprawdzone.";
$locale['EC204'] = "Moje wydarzenia";
$locale['EC205'] = "Urodziny";
$locale['EC206'] = "Moje rejestracje";
$locale['EC207'] = "[wi�cej]";
$locale['EC208'] = "Nastepnych %s dni";
$locale['EC209'] = array(
	'today'		=> 'Dzisiaj',
	'tomorrow'	=> 'Wczoraj',
	'others'	=> 'Wi�cej...',
);


// view_event.php
$locale['EC300'] = "Wydarzenie";
$locale['EC301'] = $locale['EC113'][3];
$locale['EC302'] = "Ostrze�enie. U�ytkownik nie figuruje w bazie danych";
$locale['EC303'] = "Nieznany";
$locale['EC304'] = "Edytuj";
$locale['EC305'] = "Skasuj";
$locale['EC306'] = "Publikuj";
$locale['EC307'] = "Deaktywuj";
//EC308
$locale['EC309'] = array(
	0 => "Nie informuj mnie o tym wydarzeniu.",
	1 => "Zawsze informuj mnie o tym wydarzeniu.",
	2 => "Czasowo informuj mnie o tym wydarzeniu.",
	3 => "Anuluj",
	4 => "Zapro�",
);
$locale['EC310'] = array(
	1 => "Subskypcja",
	2 => "Czasowa subskypcja",
	3 => "Anulowano",
	3 => "Cancel",
);
$locale['EC311'] = "Aktualny status";
$locale['EC312'] = "Komentarz";
$locale['EC313'] = "Wy�lij E-Mail ";
$locale['EC314'] = "Wy�lij email ka�dorazowo";
$locale['EC315'] = "Wy�lij email do wszystkich";
$locale['EC316'] = "Wy�lij";
$locale['EC317'] = "Prze�lij jaki� tekst przez email. Dzi�ki!";
$locale['EC318'] = "Nie wprowadzono Adresata. Wprowad�!";
$locale['EC319'] = "Wszystkie";
$locale['EC320'] = "E-Mail(e) wys�ano!";
$locale['EC321'] = "HTML-Format";
$locale['EC322'] = "Zapros";
$locale['EC323'] = "Uzyj CTRL-/SHIFT by wybrac wielu";
$locale['EC324'] = 'Wy�lij PW';
$locale['awec_invite_title']	= 'Zaproszenie';
$locale['awec_invite_body']	= 'Zosta�e� zaproszony.';


$locale['awec_calendar'] = "Kalendarz";
$locale['EC401'] = "Urodziny w tym miesi�cu";
$locale['EC402'] = "Widok";
$locale['awec_month_view'] = array(
	'calendar'	=> 'Kalendarz',
	'list'		=> 'Lista',
);


// browse.php
$locale['EC450'] = "Rok";
$locale['EC451'] = "Poka�";


// new_events.php
$locale['EC500'] = "Nowe wydarzenia";
$locale['EC501'] = "Brak wydarze� do upublicznienia.";
$locale['EC502'] = array(
	1 => "Wydarzenie nie mo�e by� upublicznione, poniewa� zosta�o w mi�dzyczasie zmienione. Prosz� sprawdzi�!",
);


// search.php
$locale['EC550'] = "Szukaj po";
$locale['EC551'] = array(
	"AND"	=> "I",
	"OR"	=> "LUB",
	"-"	=> "�ADNE",
);
$locale['EC552'] = "Znaleziono wydarzenie.";
$locale['EC553'] = "Opcje";
$locale['EC554'] = "Minimum 3 znaki";


// my_events.php
$locale['EC600'] = "Moje wydarzenia";
$locale['EC601'] = "Nie wprowadzi�e� jeszcze �adnych wydarze�.";
$locale['EC602'] = array(
	0	=> "Inne",
	1	=> "Prywatne",
);
$locale['awec_status_desc'] = array(
	AWEC_PUBLISHED	=> 'Upubliczniono',
	AWEC_PENDING	=> 'Oczekuj�cych na opublikowanie',
	AWEC_DRAFT	=> 'Projekty',
);
$locale['awec_status_longdesc'] = array(
	AWEC_PUBLISHED	=> 'Upubliczniono',
	AWEC_PENDING	=> 'Oczekuj�cych na opublikowanie',
	AWEC_DRAFT	=> 'Zdarze� w trybie projektowania.',
);


// admin.php
$locale['EC700'] = "Ustawienia";
$locale['EC701'] = "Grupa administracyjna";
$locale['EC702'] = "Nowe wydarzenia sprawdzane przez grup� administracyjn�";
$locale['EC703'] = "Wstawione przez";
$locale['EC704'] = "Poka� wydarzenia dzisiejszego dnia w panelu strony.";
$locale['awec705']	= 'Pokazuj urodziny u�ytkownik�w jako wydarzenia.';
$locale['EC706'] = "Poka� urodziny do";
$locale['EC711'] = "Format Daty";
$locale['EC712'] = "Urodziny";
$locale['EC713'] = "Opis funkcji: Format daty";
$locale['EC714'] = "B�dzie u�ywany, kiedy nie wprowadzono go w Themie strony.";
$locale['EC715'] = "Skasuj wydarzenie";
$locale['EC716'] = "Skasuj wydarzenia starsze niz podane dni. Zapisane wydarzenia do powt�rek nie zostan� usuni�te!";
$locale['EC716_']	= 'Powt�rzone ju� wydarzenia nie b�d� usuni�te!';
$locale['EC717'] = array(
	0	=> "Zapisano",
	1	=> "Stare wydarzenia usunieto!",
);
$locale['awec_confirm_del']	= 'Wydarzenia b�d� usuni�te';
$locale['EC719'] = "%d - Dzien miesiaca, numerycznie(00..31)
%m - Miesiac, numerycznie (00..12)
%Y - Rok, numerycznie, cztery cyfry
%H - godziny
%i - minuty
Wi�cej informacji o formacie funkcji DATE_FORMAT: <a href='http://dev.mysql.com/doc/refman/4.1/en/date-and-time-functions.html#id3022503' target='_blank'>Tutaj</a>";
$locale['EC720'] = "Podgl�d";
$locale['EC721'] = "Dni";
$locale['EC722'] = "Nastepnych dni w panelu";
$locale['EC723'] = "Zacznij tydzien od niedzieli";
$locale['EC724'] = "Panel boczny";
$locale['EC725'] = "Suportowane tylko:";
$locale['EC726'] = 'Czas';
$locale['awec_default_month_view']	= 'Domy�lny widok miesi�ca';
$locale['awec_custom_css']		= 'U�ycie wybranego CSS (patrz README)';
$locale['awec_alt_side_calendar']	= 'U�ycie alternatywnego bocznego kalendarza';
$locale['awec_user_can_edit']		= 'Istniej�ce wydarzenia mog� by� edytowane';

// admin_cats.php
$locale['awec_cats']		= 'Kategorie';

// admin/misc.php
$locale['EC750'] = "Inne";
$locale['awec_old_events']	= 'Minione wydarzenia';

// include/db_update.php
$locale['EC800'] = "Mo�liwa aktualizacja";
$locale['EC801'] = "Zostanie wykonane nastepujace zapytanie";
$locale['EC802'] = "Rozpocznij aktualizacj�...";
//
$locale['EC804'] = "Koniec - nastepny krok";
$locale['EC805'] = "OK";
$locale['EC806'] = "B��d";
//
$locale['awec_pls_delete']	= 'Prosz� skasowa� te pliki:';


// others
$locale['EC900'] = array(
	0 => '--',
	1 => 'Stycze�',
	2 => 'Luty',
	3 => 'Marzec',
	4 => 'Kwiecie�',
	5 => 'Maj',
	6 => 'Czerwiec',
	7 => 'Lipiec',
	8 => 'Sierpie�',
	9 => 'Wrzesie�',
	10 => 'Pa�dziernik',
	11 => 'Listopad',
	12 => 'Grudzie�',
);
$locale['EC901'] = array(
	0 => 'Ni',
	1 => 'Po',
	2 => 'Wt',
	3 => '�r',
	4 => 'Cz',
	5 => 'Pi',
	6 => 'So',
	7 => 'Ni',
);
?>
