<?php
/*----------------------------------------------+
| SECURITY SYSTEM V1.0 F�R PHP-FUSION |
| copyright (c) 2006 by BS-Fusion Deutschland |
| Email-Support: webmaster[at]bs-fusion.de |
| Homepage: http://www.bs-fusion.de |
| Inhaber: Manuel Kurz |
| Danish translation by Helmuth Mikkelsen, revised March 21. 2008 |
+----------------------------------------------*/
if (!defined("IN_FUSION")) die();
$locale['SYS100'] = "Sikkerheds System";
$locale['SYS101'] = "Sikkerheds systemet overv�ger denne PHP-Fusion hjemmeside og beskytter mod SQL nnjections og flood-fors�g i databasen. Yderligere tjekkes individuelle indl�g for ord. Der er integreret en proxy control. Du kan aktivere eller deaktivere tilladelserne til proxy log ind eller registrering.";
$locale['SYS102'] = "Hack fors�g";
$locale['SYS103'] = "Blokeret af filterlisten";
$locale['SYS104'] = "Flood fors�g";
$locale['SYS105'] = "Oversigt";
$locale['SYS106'] = "Logfiler";
$locale['SYS107'] = "filter liste";
$locale['SYS108'] = "Indstillinger";
$locale['SYS109'] = "Ny post til filter listen";
$locale['SYS110'] = "slet markerede poster";
$locale['SYS111'] = "tilf�j til filter liste";
$locale['SYS112'] = "Brugeragent eller IP/IP omr�de";
$locale['SYS112_1'] = "Eksempel: 127.0.0.1 eller 127.0.0. osv. ... eller brugeragent navn";
$locale['SYS113'] = "#vis resultater";
$locale['SYS114'] = "Post";
$locale['SYS115'] = "Poster";
$locale['SYS116'] = "Alle";
$locale['SYS117'] = "fra";
$locale['SYS118'] = "I alt";
$locale['SYS119'] = "Vil du slette denne filter post?";
$locale['SYS120'] = "Vil du slette denne log post?";
$locale['SYS121'] = "Der er ikke oprettet logs endnu!";
$locale['SYS122'] = "Du har ikke valgt nogen post til sletning!";
$locale['SYS123'] = "Marker alle poster!";
$locale['SYS124'] = "Dato";
$locale['SYS125'] = "IP-adresse";
$locale['SYS126'] = "Query-streng";
$locale['SYS127'] = "Referer link";
$locale['SYS128'] = "Brugeragent";
$locale['SYS129'] = "Forum floodtime:";
$locale['SYS130'] = "Replikboks floodtime:";
$locale['SYS131'] = "Kommentar floodtime:";
$locale['SYS132'] = "Kontakt floodtime:";
$locale['SYS133'] = "PB floodtime:";
$locale['SYS134'] = "G�stebog floodtime:";
$locale['SYS135'] = "Flood kontrol interval:";
$locale['SYS135_1'] = "Fra version 6.01 findes en flood kontrol; for at deaktivere det, s�t intervallet til <b>0</b>, da der ellers kan opst� problemer!";

$locale['SYS136'] = "Start flood kontrol?:";

$locale['SYS137'] = "Sp�r brugere automatisk?:";
$locale['SYS138'] = "Ja";
$locale['SYS139'] = "Nej";
$locale['SYS140'] = "aktiveret";
$locale['SYS141'] = "aktiver";
$locale['SYS142'] = "deaktiveret";
$locale['SYS143'] = "deaktiver";
$locale['SYS144'] = "Her kan du �ndre i indstillingerne i sikkerheds systemet. Det er muligt at sl� det fra, ligesom der kan tillades enkelt funktioner og at forbyde. Spam kontrollen er aktiv for brugere og g�ster. Hvis en bruger er ordstyrer i forum, er spam kontrol og flood kontrol deaktiveret. Fra bruger adgangs administrationen er alle niveauer tilg�ngelige undtagen proxy kontrol, n�r det er aktiveret.";

$locale['SYS145'] = "Kontrol Panel";
$locale['SYS146'] = "Gem indstillinger";
$locale['SYS147'] = "Flood fors�g til brugere";
$locale['SYS148'] = "Forum kontrol ikke for:";
$locale['SYS149'] = "Replikboks kontrol ikke for:";
$locale['SYS150'] = "Kommentar kontrol ikke for:";
$locale['SYS151'] = "Kontakt kontrol ikke for:";
$locale['SYS152'] = "PB kontrol ikke for:";
$locale['SYS153'] = "G�stebog kontrol ikke for:";
$locale['SYS154'] = "Sp�rrede brugere";
$locale['SYS155'] = "l�s markerede brugere op";
$locale['SYS156'] = "Ingen sp�rrede brugere at l�se op!";
$locale['SYS157'] = "Brugernavn";
$locale['SYS158'] = "Denne post findes allerede!";
$locale['SYS159'] = "Du skal opgive et navn p� brugeragenten eller en IP eller et IP-omr�de!";
$locale['SYS160'] = "Spamord";
$locale['SYS161'] = "Tilf�j spamord";
$locale['SYS161_1'] = "Store eller sm� bogstaver spiller ingen rolle!";
$locale['SYS162'] = "fjern markerede spamord";
$locale['SYS163'] = "Du har ikke oprettet spamord!";
$locale['SYS164'] = "Vil du slette de markerede spamord";
$locale['SYS165'] = "Tilf�j til listen";
$locale['SYS166'] = "Spamord liste";
$locale['SYS167'] = "Der er ikke skrevet spamord endnu!";
$locale['SYS168'] = "Spam fors�g";
$locale['SYS169'] = "Besked indhold";
$locale['SYS170'] = "Tilbage til admin";
$locale['SYS171'] = "Vis i element";
$locale['SYS200'] = "Sekunder";
$locale['SYS201'] = "Minut";
$locale['SYS202'] = "Minutter";
$locale['SYS203'] = "Time";
$locale['SYS204'] = "Timer";
$locale['SYS205'] = "Dag";
$locale['SYS206'] = "Dage";
$locale['SYS207'] = "Du har fors�gt at oprette en flood post i systemet. Den blev blokeret og registreret af vores system.";
$locale['SYS208'] = "For at kunne oprette en ny tr�d eller svar i debatforum, skal du vente i %s.";
$locale['SYS209'] = "For at kunne skrive et nyt indl�g i replikboksen, skal du vente i %s.";
$locale['SYS210'] = "For at kunne skrive en ny kommentar, skal du vente i %s.";
$locale['SYS211'] = "For at kunne oprette en ny post i g�stebogen, skal du vente i %s.";
$locale['SYS212'] = "For at kunne skrive en ny PB til denne bruger, skal du vente i %s.";
$locale['SYS213'] = "For at kunne sende en besked til os, skal du vente i %s.";
$locale['SYS214'] = "Vi takker for din forst�else, dit ".$settings['sitename']."-team";
$locale['SYS215'] = "Din konto er sp�rret!<br>Kontakt venligst en superadmin for at f� kontoen l�st op igen!";
$locale['SYS216'] = "Aktiver alle markerede filtre";
$locale['SYS217'] = "Deaktiver alle markerede filtre";
$locale['SYS218'] = "Filtre markeret med r�d skrift er deaktiverede, markeret med gr�n skrift er aktiverede";
$locale['SYS219'] = "Du har ikke valgt nogle filtre til aktiver/deaktiver!";
$locale['SYS220'] = "Ryd hele logfilen!";
$locale['SYS221'] = "Vil du rydde logfilen fuldst�ndigt?";


// NEW UNTIL 1.8.2
$locale['PROXY000'] = "Proxy whiteliste";
$locale['PROXY001'] = "Inds�t ny proxy";
$locale['PROXY002'] = "Aktiver proxy";
$locale['PROXY003'] = "Deaktiver proxy";
$locale['PROXY004'] = "Slet proxy";
$locale['PROXY005'] = "Vil du slette de markerede proxy?";
$locale['PROXY006'] = "Vil du aktivere de valgte proxy?";
$locale['PROXY007'] = "Vil du deaktivere proxy?";
$locale['PROXY008'] = "Gr�nt markerede ip'er er aktiverede! R�dt markerede ip'er er deaktiverede!";
$locale['PROXY009'] = "Ny proxy ip";
$locale['PROXY010'] = "Du skal indtaste en proxy ip!";
$locale['PROXY011'] = "Proxy er fundet i listen!"; 
$locale['PROXY012'] = "Proxy blackliste";
$locale['PROXY013'] = "Tilf�j proxy p� blacklist";
$locale['PROXY014'] = "Ingen proxy fundet";
$locale['PROXY015'] = "Vil du tilf�je de markerede proxy p� blacklisten?";
$locale['PROXY016'] = "<font style='font-size:10px;'>(Udfyld kun det felt du �nsker)</font>";

$locale [ 'LOG000'] = "Log indstillinger";
$locale [ 'LOG001'] = "Slet log automatisk?";
$locale [ 'LOG002'] = "Log over hack fors�g?";
$locale [ 'LOG003'] = "Log over blokerede poster p� filter listen?";
$locale [ 'LOG004'] = "Log over spam fors�g?";
$locale [ 'LOG005'] = "Log over flood fors�g?";
$locale [ 'LOG006'] = "Log over proxy kontrol?";
$locale [ 'LOG007'] = "maksimum log poster i databasen";
$locale [ 'LOG008'] = "gyldige log poster for";
// End

// NEW LOCALES START
$locale['SYS222'] = "Start Security System?:";
$locale['SYS223'] = "Kontroll�r proxy?:";
$locale['SYS224'] = "Aktiver proxy registrering?:";
$locale['SYS225'] = "Aktiver proxy log ind?:";
$locale['SYS226'] = "Proxy log ind";
$locale['SYS227'] = "Proxy registrering";
$locale['SYS228'] = "Proxy adgang";
$locale['SYS229'] = "%s er nu blokeret.";
$locale['SYS230'] = "Flere indstillinger";
$locale['SYS231'] = "Online dokumentation";
$locale['SYS232'] = "Kodeord";

$locale['SUPD100'] = "Sikkerheds system opdatering";
$locale['SUBD101'] = "Ny opdatering installeret";
$locale['SUBD102'] = "Ny opdatering er nu installeret!";
$locale['SUBD103'] = "Ingen opdatering tilg�ngelig";
$locale['SUBD104'] = "Sikkerheds systemet er up-to-date!";
$locale['SUBD105'] = "Ny opdatering tilg�ngelig";
$locale['SUBD106'] = "En ny opdatering er tilg�ngelig p� opdaterings serveren. For at kunne downloade filen er brugerregistrering p� BS-Fusion p�kr�vet.";
$locale['SUBD107'] = "Fejl under opdatering";
$locale['SUBD108'] = "En fejl opstod under opdatering.<br>\n %s";
$locale['SUBD109'] = "Den nuv�rende version er 'for gammel' til denne opdatering. Den kr�vede version er %s";
$locale['SUBD110'] = "En fejl opstod under opdatering. Kontakt venligst udvikleren af denne infusion.";
$locale['SUBD111'] = "Funktionen \"fsockopen()\" er deaktiveret. Venligst tjek for opdateringer p�";
$locale['SUBD112'] = "Opdater";
// NEW LOCALES END



$locale['SYS300'] = "<a class='small' href='http://www.bs-fusion.de' target='_blank'>Mere sikkerhed</a> med<br>
<a class='small' href='http://www.bs-fusion.de' target='_blank'>BS-Fusion Security System.</a>";
$locale['SYS301'] = "Beskyttet med <a class='small' href='http://www.bs-fusion.de' target='_blank'>BS-Fusion Security System</a><br>%s fors�g blokeret";
$locale['SYS302'] = "%s fors�g, blokeret";
$locale['SYS400'] = "Luk vindue";
$locale['SYS401'] = "Udskriv";
$locale['license_accept'] = "Jeg er indforst�et med og accepterer licensebestemmelserne!";
?>