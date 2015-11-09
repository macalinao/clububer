<?
/*----------------------------------------------+
| SECURITY SYSTEM V1.0 FÜR PHP-FUSION |
| copyright (c) 2006 by BS-Fusion Deutschland |
| Email-Support: webmaster[at]bs-fusion.de |
| Homepage: http://www.bs-fusion.de |
| Inhaber: Manuel Kurz |
+----------------------------------------------*/
if (!defined("IN_FUSION")) die();
$locale['SYS100'] = "Security Systeem";
$locale['SYS101'] = "Het Security Systeem monitoort deze PHP-Fusion-pagina en beschermt het tegen SQL Injectie, flood invoer in de database. Daarnaast controleert het de individuele postvakken op spam woorden. Het heeft een geïntegreerde proxy controle. U kunt de rechten om via proxy in te loggen of te registreren inschakelen of uitschakelen.";
$locale['SYS102'] = "Hack pogingen";
$locale['SYS103'] = "Geblokkeerd door filterlijst";
$locale['SYS104'] = "Flood pogingen";
$locale['SYS105'] = "Overzicht";
$locale['SYS106'] = "Log regel";
$locale['SYS107'] = "filter lijst";
$locale['SYS108'] = "Instellingen";
$locale['SYS109'] = "Nieuwe waarde voor filterlijst";
$locale['SYS110'] = "gemarkeerde waarde verwijderen";
$locale['SYS111'] = "toevoegen aan filterlijst";
$locale['SYS112'] = "User-agent of ip/ip reeks";
$locale['SYS112_1'] = "Voorbeeld: 127.0.0.1 or 127.0.0. etc... of user-agent-name";
$locale['SYS113'] = "#resultaten weergave";
$locale['SYS114'] = "Waarde";
$locale['SYS115'] = "Waarden";
$locale['SYS116'] = "Alle";
$locale['SYS117'] = "van";
$locale['SYS118'] = "Geheel";
$locale['SYS119'] = "Wilt u deze filter waarde echt verwijderen?";
$locale['SYS120'] = "Wilt u deze log regel echt verwijderen?";
$locale['SYS121'] = "Er is nog geen log regel gemaakt!";
$locale['SYS122'] = "U heeft geen regel geselecteerd om te wissen!";
$locale['SYS123'] = "Alle waarden markeren!";
$locale['SYS124'] = "Datum";
$locale['SYS125'] = "IP-adres";
$locale['SYS126'] = "Query-string";
$locale['SYS127'] = "Referer";
$locale['SYS128'] = "User-agent";
$locale['SYS129'] = "Forum floodtijd:";
$locale['SYS130'] = "Shoutbox floodtijd:";
$locale['SYS131'] = "Commentaar floodtijd:";
$locale['SYS132'] = "Contact floodtijd:";
$locale['SYS133'] = "PM floodtijd:";
$locale['SYS134'] = "Gastenboek floodtijd:";
$locale['SYS135'] = "Flood controle interval:";
$locale['SYS135_1'] = "Vanaf versie 6.01 heeft PHP-Fusion er een flood control. Stel deze in op 0 om conflicten met deze infusie te voorkomen!";

$locale['SYS136'] = "Start flood controle?:";

$locale['SYS137'] = "Leden automatisch blokkeren?:";
$locale['SYS138'] = "Ja";
$locale['SYS139'] = "Nee";
$locale['SYS140'] = "ingeschakeld";
$locale['SYS141'] = "inschakelen";
$locale['SYS142'] = "uitgeschakeld";
$locale['SYS143'] = "uitschakelen";
$locale['SYS144'] = "U kunt hier de instellingen van het Security Systeem aanpassen. U kunt het uitschakelen, maar ook enkele functies toestaan of verbieden. Spam controle is ingeschakeld voor leden en bezoekers. Wanneer een gebruiker tevens moderator van een forum is, is de spam controle en flood controle uitgeschakeld. Beheerders zijn uitgesloten van de controles, met uitzondering van de proxy controle indien deze is ingeschakeld";

$locale['SYS145'] = "Beheer paneel";
$locale['SYS146'] = "Instellingen opslaan";
$locale['SYS147'] = "Flood-pogingen voor gebruikers";
$locale['SYS148'] = "Forum-controle niet voor:";
$locale['SYS149'] = "Shoutbox-controle niet voor:";
$locale['SYS150'] = "Commentaar-controle niet voor:";
$locale['SYS151'] = "Contact-controle niet voor:";
$locale['SYS152'] = "PM-controle niet voor:";
$locale['SYS153'] = "Gastenboek-controle niet voor:";
$locale['SYS154'] = "Afgesloten gebruikers";
$locale['SYS155'] = "gemarkeerde gebruikers vrijgeven";
$locale['SYS156'] = "Er zijn geen afgesloten gebruikers!";
$locale['SYS157'] = "Gebruikersnaam";
$locale['SYS158'] = "Deze waarde bestaat al!";
$locale['SYS159'] = "Invoer van user-agent of an IP of IP reeks is verplicht!";
$locale['SYS160'] = "Spamwoorden";
$locale['SYS161'] = "Spamwoord toevoegen";
$locale['SYS161_1'] = "Niet hoofdletter gevoelig!";
$locale['SYS162'] = "gemarkeerde spamwoorden verwijderen";
$locale['SYS163'] = "U heeft geen spamwoord ingevoerd!";
$locale['SYS164'] = "Wilt u de gemarkeerde spamwoorden echt verwijderen";
$locale['SYS165'] = "Toevoegen aan de lijst";
$locale['SYS166'] = "Spamwoorden lijst";
$locale['SYS167'] = "Er zijn nog geen spamwoorden geschreven!";
$locale['SYS168'] = "Spam pogingen";
$locale['SYS169'] = "Bericht inhoud";
$locale['SYS170'] = "Terug naar beheerder paneel";
$locale['SYS171'] = "Weergave in paneel";
$locale['SYS200'] = "Seconden";
$locale['SYS201'] = "Minuut";
$locale['SYS202'] = "Minuten";
$locale['SYS203'] = "Uur";
$locale['SYS204'] = "Uren";
$locale['SYS205'] = "Dag";
$locale['SYS206'] = "Dagen";
$locale['SYS207'] = "U heeft een flood poging gedaan op ons systeem. Deze poging is geblokkeerd en geregistreerd.";
$locale['SYS208'] = "Om een nieuwe thread of reactie in het forum te kunnen plaatsen, moet u %s wachten.";
$locale['SYS209'] = "Om een nieuw bericht in de shoutbox te kunnen plaatsen, moet u %s wachten.";
$locale['SYS210'] = "Om een nieuw commentaar te kunnen plaatsen, moet u %s wachten.";
$locale['SYS211'] = "Om een nieuw bericht in het gastenboek te kunnen plaatsen, moet u %s wachten.";
$locale['SYS212'] = "Om een nieuw bericht te kunnen sturen naar deze gebruiker, moet u %s wachten.";
$locale['SYS213'] = "Om een bericht middels het contactformulier naar ons te kunnen sturen, moet u %s wachten.";
$locale['SYS214'] = "Bedankt voor uw begrip, het ".$settings['sitename']."-Team";
$locale['SYS215'] = "Uw gebruikersnaam is afgesloten!<br>Neem contact op met de beheerder om uw gebruikersnaam vrij te geven!";
$locale['SYS216'] = "Alle gemarkeerde filters inschakelen";
$locale['SYS217'] = "Alle gemarkeerde filters uitschakelen";
$locale['SYS218'] = "Filter gemarkeerdmarked in rood is uitgeschakeld, gemarkeerd in groen is ingeschakeld";
$locale['SYS219'] = "U heeft geen filter gemarkeerd om in of uit te schakelen!";
$locale['SYS220'] = "Gehele logfile opschonen!";
$locale['SYS221'] = "weet u zeker dat u de gehele logfile wilt opschonen?";


// NEW UNTIL 1.8.2
$locale['PROXY000'] = "Proxy whitelist";
$locale['PROXY001'] = "Proxy toevoegen";
$locale['PROXY002'] = "Proxy inschakelen";
$locale['PROXY003'] = "Proxy uitschakelen";
$locale['PROXY004'] = "Proxy verwijderen";
$locale['PROXY005'] = "Wilt u echt alle gemarkeerde proxies verwijderen?";
$locale['PROXY006'] = "Wilt u echt proxy inschakelen?";
$locale['PROXY007'] = "Wilt u echt proxy uitschakelen?";
$locale['PROXY008'] = "Alle groen gemarkeerde ip's zijn ingeschakeld! Alle rood gemarkeerde ip's zijn uitgeschakeld";
$locale['PROXY009'] = "Nieuw proxy ip";
$locale['PROXY010'] = "U moet een proxy ip invoeren!";
$locale['PROXY011'] = "Proxy staat al in de lijst!"; 
$locale['PROXY012'] = "Proxy blacklist";
$locale['PROXY013'] = "Proxy toevoegen aan de blacklist";
$locale['PROXY014'] = "Geen proxy gevonden";
$locale['PROXY015'] = "Wilt u echt alle gemarkeerde proxies aan de proxy blacklijst toevoegen?";
$locale['PROXY016'] = "<font style='font-size:10px;'>(Alleen het gewenste veld invullen)</font>";

$locale [ 'LOG000'] = "Logs instellingen";
$locale [ 'LOG001'] = "Automatisch log wissen?";
$locale [ 'LOG002'] = "Logs voor hack pogingen?";
$locale [ 'LOG003'] = "Logs voor blokkering door de filterlijst?";
$locale [ 'LOG004'] = "Logs voor spam pogingen?";
$locale [ 'LOG005'] = "Logs voor flood pogingen?";
$locale [ 'LOG006'] = "Logs voor proxy controle?";
$locale [ 'LOG007'] = "maximum aantal log regels in de database";
$locale [ 'LOG008'] = "Geldige log regels voor";
// End

// NEW LOCALES START
$locale['SYS222'] = "Start Security Systeem?:";
$locale['SYS223'] = "Controleer proxy?:";
$locale['SYS224'] = "Proxy registratie toestaan?:";
$locale['SYS225'] = "Proxy login toestaan?:";
$locale['SYS226'] = "Proxy login";
$locale['SYS227'] = "Proxy registratie";
$locale['SYS228'] = "Proxy toegang";
$locale['SYS229'] = "%s succesvol geblokkeerd.";
$locale['SYS230'] = "Meer instellingen";
$locale['SYS231'] = "Online documentatie";

$locale['SUPD100'] = "Security Systeem bijwerken";
$locale['SUBD101'] = "Nieuwe versie geïnstalleerd";
$locale['SUBD102'] = "Nieuwe versie succesvol geïnstalleerd!";
$locale['SUBD103'] = "Geen update beschikbaar";
$locale['SUBD104'] = "Het Security Systeem is up-to-date!";
$locale['SUBD105'] = "Nieuwe update beschikbaar";
$locale['SUBD106'] = "Er is een nieuwe versie van Security Systeem gevonden. 	
Voor download van dit bestand is registratie op BS-Fusion vereist.";
$locale['SUBD107'] = "Fout tijdens update";
$locale['SUBD108'] = "Er is een fout opgetreden tijdens het bijwerken.<br>\n %s";
$locale['SUBD109'] = "De gebruikte versie is ouder dan de voor de update vereiste versie. Vereiste versie is %s";
$locale['SUBD110'] = "Er is een fout opgetreden tijdens het bijwerken. Gaarne contact opnemen met de maker van deze infusie.";
$locale['SUBD111'] = "de functie \"fsockopen()\" is uitgeschakeld. Controleer voor update op";
$locale['SUBD112'] = "Update";
// NEW LOCALES END



$locale['SYS300'] = "<a class='small' href='http://www.bs-fusion.de' target='_blank'>Beter beveiligd</a> met het<br>
<a class='small' href='http://www.bs-fusion.de' target='_blank'>BS-Fusion Security Systeem.</a>";
$locale['SYS301'] = "Beveiligd met het <a class='small' href='http://www.bs-fusion.de' target='_blank'>BS-Fusion Security Systeem</a><br>%s aanvallen geblokkeerd";
$locale['SYS302'] = "%s poging(en) geblokkeerd";
$locale['SYS400'] = "Sluit venster";
$locale['SYS401'] = "Print";
$locale['license_accept'] = "Ik ga accoord met het licentie-contract!";
?>