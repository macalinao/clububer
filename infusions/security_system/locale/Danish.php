<?php
/*----------------------------------------------+
| SECURITY SYSTEM V1.0 FÜR PHP-FUSION |
| copyright (c) 2006 by BS-Fusion Deutschland |
| Email-Support: webmaster[at]bs-fusion.de |
| Homepage: http://www.bs-fusion.de |
| Inhaber: Manuel Kurz |
| Danish translation by Helmuth Mikkelsen, revised March 21. 2008 |
+----------------------------------------------*/
if (!defined("IN_FUSION")) die();
$locale['SYS100'] = "Sikkerheds System";
$locale['SYS101'] = "Sikkerheds systemet overvåger denne PHP-Fusion hjemmeside og beskytter mod SQL nnjections og flood-forsøg i databasen. Yderligere tjekkes individuelle indlæg for ord. Der er integreret en proxy control. Du kan aktivere eller deaktivere tilladelserne til proxy log ind eller registrering.";
$locale['SYS102'] = "Hack forsøg";
$locale['SYS103'] = "Blokeret af filterlisten";
$locale['SYS104'] = "Flood forsøg";
$locale['SYS105'] = "Oversigt";
$locale['SYS106'] = "Logfiler";
$locale['SYS107'] = "filter liste";
$locale['SYS108'] = "Indstillinger";
$locale['SYS109'] = "Ny post til filter listen";
$locale['SYS110'] = "slet markerede poster";
$locale['SYS111'] = "tilføj til filter liste";
$locale['SYS112'] = "Brugeragent eller IP/IP område";
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
$locale['SYS134'] = "Gæstebog floodtime:";
$locale['SYS135'] = "Flood kontrol interval:";
$locale['SYS135_1'] = "Fra version 6.01 findes en flood kontrol; for at deaktivere det, sæt intervallet til <b>0</b>, da der ellers kan opstå problemer!";

$locale['SYS136'] = "Start flood kontrol?:";

$locale['SYS137'] = "Spær brugere automatisk?:";
$locale['SYS138'] = "Ja";
$locale['SYS139'] = "Nej";
$locale['SYS140'] = "aktiveret";
$locale['SYS141'] = "aktiver";
$locale['SYS142'] = "deaktiveret";
$locale['SYS143'] = "deaktiver";
$locale['SYS144'] = "Her kan du ændre i indstillingerne i sikkerheds systemet. Det er muligt at slå det fra, ligesom der kan tillades enkelt funktioner og at forbyde. Spam kontrollen er aktiv for brugere og gæster. Hvis en bruger er ordstyrer i forum, er spam kontrol og flood kontrol deaktiveret. Fra bruger adgangs administrationen er alle niveauer tilgængelige undtagen proxy kontrol, når det er aktiveret.";

$locale['SYS145'] = "Kontrol Panel";
$locale['SYS146'] = "Gem indstillinger";
$locale['SYS147'] = "Flood forsøg til brugere";
$locale['SYS148'] = "Forum kontrol ikke for:";
$locale['SYS149'] = "Replikboks kontrol ikke for:";
$locale['SYS150'] = "Kommentar kontrol ikke for:";
$locale['SYS151'] = "Kontakt kontrol ikke for:";
$locale['SYS152'] = "PB kontrol ikke for:";
$locale['SYS153'] = "Gæstebog kontrol ikke for:";
$locale['SYS154'] = "Spærrede brugere";
$locale['SYS155'] = "lås markerede brugere op";
$locale['SYS156'] = "Ingen spærrede brugere at låse op!";
$locale['SYS157'] = "Brugernavn";
$locale['SYS158'] = "Denne post findes allerede!";
$locale['SYS159'] = "Du skal opgive et navn på brugeragenten eller en IP eller et IP-område!";
$locale['SYS160'] = "Spamord";
$locale['SYS161'] = "Tilføj spamord";
$locale['SYS161_1'] = "Store eller små bogstaver spiller ingen rolle!";
$locale['SYS162'] = "fjern markerede spamord";
$locale['SYS163'] = "Du har ikke oprettet spamord!";
$locale['SYS164'] = "Vil du slette de markerede spamord";
$locale['SYS165'] = "Tilføj til listen";
$locale['SYS166'] = "Spamord liste";
$locale['SYS167'] = "Der er ikke skrevet spamord endnu!";
$locale['SYS168'] = "Spam forsøg";
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
$locale['SYS207'] = "Du har forsøgt at oprette en flood post i systemet. Den blev blokeret og registreret af vores system.";
$locale['SYS208'] = "For at kunne oprette en ny tråd eller svar i debatforum, skal du vente i %s.";
$locale['SYS209'] = "For at kunne skrive et nyt indlæg i replikboksen, skal du vente i %s.";
$locale['SYS210'] = "For at kunne skrive en ny kommentar, skal du vente i %s.";
$locale['SYS211'] = "For at kunne oprette en ny post i gæstebogen, skal du vente i %s.";
$locale['SYS212'] = "For at kunne skrive en ny PB til denne bruger, skal du vente i %s.";
$locale['SYS213'] = "For at kunne sende en besked til os, skal du vente i %s.";
$locale['SYS214'] = "Vi takker for din forståelse, dit ".$settings['sitename']."-team";
$locale['SYS215'] = "Din konto er spærret!<br>Kontakt venligst en superadmin for at få kontoen låst op igen!";
$locale['SYS216'] = "Aktiver alle markerede filtre";
$locale['SYS217'] = "Deaktiver alle markerede filtre";
$locale['SYS218'] = "Filtre markeret med rød skrift er deaktiverede, markeret med grøn skrift er aktiverede";
$locale['SYS219'] = "Du har ikke valgt nogle filtre til aktiver/deaktiver!";
$locale['SYS220'] = "Ryd hele logfilen!";
$locale['SYS221'] = "Vil du rydde logfilen fuldstændigt?";


// NEW UNTIL 1.8.2
$locale['PROXY000'] = "Proxy whiteliste";
$locale['PROXY001'] = "Indsæt ny proxy";
$locale['PROXY002'] = "Aktiver proxy";
$locale['PROXY003'] = "Deaktiver proxy";
$locale['PROXY004'] = "Slet proxy";
$locale['PROXY005'] = "Vil du slette de markerede proxy?";
$locale['PROXY006'] = "Vil du aktivere de valgte proxy?";
$locale['PROXY007'] = "Vil du deaktivere proxy?";
$locale['PROXY008'] = "Grønt markerede ip'er er aktiverede! Rødt markerede ip'er er deaktiverede!";
$locale['PROXY009'] = "Ny proxy ip";
$locale['PROXY010'] = "Du skal indtaste en proxy ip!";
$locale['PROXY011'] = "Proxy er fundet i listen!"; 
$locale['PROXY012'] = "Proxy blackliste";
$locale['PROXY013'] = "Tilføj proxy på blacklist";
$locale['PROXY014'] = "Ingen proxy fundet";
$locale['PROXY015'] = "Vil du tilføje de markerede proxy på blacklisten?";
$locale['PROXY016'] = "<font style='font-size:10px;'>(Udfyld kun det felt du ønsker)</font>";

$locale [ 'LOG000'] = "Log indstillinger";
$locale [ 'LOG001'] = "Slet log automatisk?";
$locale [ 'LOG002'] = "Log over hack forsøg?";
$locale [ 'LOG003'] = "Log over blokerede poster på filter listen?";
$locale [ 'LOG004'] = "Log over spam forsøg?";
$locale [ 'LOG005'] = "Log over flood forsøg?";
$locale [ 'LOG006'] = "Log over proxy kontrol?";
$locale [ 'LOG007'] = "maksimum log poster i databasen";
$locale [ 'LOG008'] = "gyldige log poster for";
// End

// NEW LOCALES START
$locale['SYS222'] = "Start Security System?:";
$locale['SYS223'] = "Kontrollér proxy?:";
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
$locale['SUBD103'] = "Ingen opdatering tilgængelig";
$locale['SUBD104'] = "Sikkerheds systemet er up-to-date!";
$locale['SUBD105'] = "Ny opdatering tilgængelig";
$locale['SUBD106'] = "En ny opdatering er tilgængelig på opdaterings serveren. For at kunne downloade filen er brugerregistrering på BS-Fusion påkrævet.";
$locale['SUBD107'] = "Fejl under opdatering";
$locale['SUBD108'] = "En fejl opstod under opdatering.<br>\n %s";
$locale['SUBD109'] = "Den nuværende version er 'for gammel' til denne opdatering. Den krævede version er %s";
$locale['SUBD110'] = "En fejl opstod under opdatering. Kontakt venligst udvikleren af denne infusion.";
$locale['SUBD111'] = "Funktionen \"fsockopen()\" er deaktiveret. Venligst tjek for opdateringer på";
$locale['SUBD112'] = "Opdater";
// NEW LOCALES END



$locale['SYS300'] = "<a class='small' href='http://www.bs-fusion.de' target='_blank'>Mere sikkerhed</a> med<br>
<a class='small' href='http://www.bs-fusion.de' target='_blank'>BS-Fusion Security System.</a>";
$locale['SYS301'] = "Beskyttet med <a class='small' href='http://www.bs-fusion.de' target='_blank'>BS-Fusion Security System</a><br>%s forsøg blokeret";
$locale['SYS302'] = "%s forsøg, blokeret";
$locale['SYS400'] = "Luk vindue";
$locale['SYS401'] = "Udskriv";
$locale['license_accept'] = "Jeg er indforstået med og accepterer licensebestemmelserne!";
?>