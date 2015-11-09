<?
/*----------------------------------------------+
| SECURITY SYSTEM V1.0 FÜR PHP-FUSION |
| copyright (c) 2006 by BS-Fusion Deutschland |
| Email-Support: webmaster[at]bs-fusion.de |
| Homepage: http://www.bs-fusion.de |
| Inhaber: Manuel Kurz |
+----------------------------------------------*/
if (!defined("IN_FUSION")) die();
$locale['SYS100'] = "Security System";
$locale['SYS101'] = "The Security System supervises these PHP-Fusion-page and protects them against SQL Injection and flood entries in the database. Furthermore, it checks individual post boxes on spam words. It has an integrated proxy control. You can activate or deactivate the permissions of proxy login or register.";
$locale['SYS102'] = "Hack attempts";
$locale['SYS103'] = "Block by the filter list";
$locale['SYS104'] = "Flood attempts";
$locale['SYS105'] = "Summary";
$locale['SYS106'] = "Log entry";
$locale['SYS107'] = "filter list";
$locale['SYS108'] = "Settings";
$locale['SYS109'] = "New entry for the filter list";
$locale['SYS110'] = "Delete marked entries";
$locale['SYS111'] = "add to the filter list";
$locale['SYS112'] = "User-agent or ip/ip range";
$locale['SYS112_1'] = "Example: 127.0.0.1 or 127.0.0. etc... or user-agent-name";
$locale['SYS113'] = "#show results";
$locale['SYS114'] = "Entry";
$locale['SYS115'] = "Entries";
$locale['SYS116'] = "All";
$locale['SYS117'] = "from";
$locale['SYS118'] = "Entire";
$locale['SYS119'] = "Do you really want to delete this filter-entry?";
$locale['SYS120'] = "Do you really want to delete this log-entry?";
$locale['SYS121'] = "There are no logs created yet!";
$locale['SYS122'] = "You have not selected an entry to delete!";
$locale['SYS123'] = "All entries selected!";
$locale['SYS124'] = "Date";
$locale['SYS125'] = "IP-address";
$locale['SYS126'] = "Query-string";
$locale['SYS127'] = "Referer";
$locale['SYS128'] = "User-agent";
$locale['SYS129'] = "Forum floodtime:";
$locale['SYS130'] = "Shoutbox floodtime:";
$locale['SYS131'] = "Comment floodtime:";
$locale['SYS132'] = "Contact floodtime:";
$locale['SYS133'] = "PM floodtime:";
$locale['SYS134'] = "Guestbook floodtime:";
$locale['SYS135'] = "Flood control interval:";
$locale['SYS135_1'] = "Flood Control has been added to PHP-Fusion in version 6.01. To avoid conflicts with the Flood Control of the Security System, this setting should be set to 0.";

$locale['SYS136'] = "Start flood control?:";

$locale['SYS137'] = "Lock members automaticly?:";
$locale['SYS138'] = "Yes";
$locale['SYS139'] = "No";
$locale['SYS140'] = "activated";
$locale['SYS141'] = "activate";
$locale['SYS142'] = "deactivated";
$locale['SYS143'] = "deactivate";
$locale['SYS144'] = "This panel allows you to change the Security System settings. You can enable or disable, allow or deny single functions. Spam Control is effective for Members and Guests. Spam Control and Flood Control are not effective for Moderators in a Forum. User levels Administrator and above are not effected by these functions, except for the Proxy Control.";

$locale['SYS145'] = "Control Panel";
$locale['SYS146'] = "Save settings";
$locale['SYS147'] = "Flood-Attempts for members";
$locale['SYS148'] = "Forum-control not for:";
$locale['SYS149'] = "Shoutbox-Control not for:";
$locale['SYS150'] = "Comment-control not for:";
$locale['SYS151'] = "Contact-control not for:";
$locale['SYS152'] = "PM-control not for:";
$locale['SYS153'] = "Guestbook-control not for:";
$locale['SYS154'] = "Locked members";
$locale['SYS155'] = "Release selected Members";
$locale['SYS156'] = "There are no Member to release!";
$locale['SYS157'] = "Membername";
$locale['SYS158'] = "This entry already exists!";
$locale['SYS159'] = "You must enter a user-agent or an IP or IP range!";
$locale['SYS160'] = "Spam words";
$locale['SYS161'] = "Add spam word";
$locale['SYS161_1'] = "The capitalization is nonrelevant!";
$locale['SYS162'] = "Remove selected Spam words";
$locale['SYS163'] = "You have no Spam word entered!";
$locale['SYS164'] = "Do you really want to delete the selected Spam words?";
$locale['SYS165'] = "Add to the list";
$locale['SYS166'] = "Spam word list";
$locale['SYS167'] = "No Spam words entered yet!";
$locale['SYS168'] = "Spam attempts";
$locale['SYS169'] = "Message content";
$locale['SYS170'] = "Back to Adminlevel";
$locale['SYS171'] = "Display in Panel";
$locale['SYS200'] = "Seconds";
$locale['SYS201'] = "Minute";
$locale['SYS202'] = "Minutes";
$locale['SYS203'] = "Hour";
$locale['SYS204'] = "Hours";
$locale['SYS205'] = "Day";
$locale['SYS206'] = "Days";
$locale['SYS207'] = "You have tried to insert a flood entry into our system. This was blocked by our system and was recorded.";
$locale['SYS208'] = "In order to be able to submit a new thread or contribution in the forum, you must wait %s.";
$locale['SYS209'] = "In order to be able to submit a new contribution in the shoutbox, you must wait %s.";
$locale['SYS210'] = "In order to be able to submit a new contribution in the comments, you must wait %s.";
$locale['SYS211'] = "In order to be able to submit a new entry into the Guest book, you must wait %s.";
$locale['SYS212'] = "In order to be able to send a new Private Message to this member, you must wait %s.";
$locale['SYS213'] = "In order to be able to send a contact message to us, you must wait %s.";
$locale['SYS214'] = "We thank for your understanding, your ".$settings['sitename']."-Team";
$locale['SYS215'] = "Your Account was locked!<br>Please contact the superadministrator to release your account again!";
$locale['SYS216'] = "Enable all selected filters";
$locale['SYS217'] = "Disable all selected filters";
$locale['SYS218'] = "Filter marked in red font is disabled, marked in green font is enabled";
$locale['SYS219'] = "You have no Filter selected to enable/disable!";
$locale['SYS220'] = "Clear the whole logfile table!";
$locale['SYS221'] = "Do you really want to clear the whole logfile table?";


// NEW UNTIL 1.8.2
$locale['PROXY000'] = "Proxy White list";
$locale['PROXY001'] = "Insert new proxy";
$locale['PROXY002'] = "Activate proxy";
$locale['PROXY003'] = "Deactivate proxy";
$locale['PROXY004'] = "Delete proxy";
$locale['PROXY005'] = "Do you really want to delete all selected proxies?";
$locale['PROXY006'] = "Do you really want to activate proxy?";
$locale['PROXY007'] = "Do you really want to deactivate proxy?";
$locale['PROXY008'] = "All green marked ip's are activated! All red marked ip's are deactivated";
$locale['PROXY009'] = "New proxy ip";
$locale['PROXY010'] = "You must enter a proxy ip!";
$locale['PROXY011'] = "Proxy already in the list!"; 
$locale['PROXY012'] = "Proxy Black list";
$locale['PROXY013'] = "Insert new proxy";
$locale['PROXY014'] = "No proxy found";
$locale['PROXY015'] = "Do you really want to insert all selected Proxies into the Proxy Black list?";
$locale['PROXY016'] = "<font style='font-size:10px;'>(Only fill out the field, which you require)</font>";

$locale ['LOG000'] = "Logs settings";
$locale ['LOG001'] = "Automatically delete log?";
$locale ['LOG002'] = "Logs for hack attempts?";
$locale ['LOG003'] = "Logs for blocking entries of the filter list?";
$locale ['LOG004'] = "Logs for spam attempts?";
$locale ['LOG005'] = "Logs for flood attempts?";
$locale ['LOG006'] = "Logs for proxy control?";
$locale ['LOG007'] = "maximum log entries in the database";
$locale ['LOG008'] = "valid log entries for";
// End

// NEW LOCALES START
$locale['SYS222'] = "Start Security System?:";
$locale['SYS223'] = "Control proxy?:";
$locale['SYS224'] = "Enable proxy registration?:";
$locale['SYS225'] = "Enable proxy login?:";
$locale['SYS226'] = "Proxy login";
$locale['SYS227'] = "Proxy registration";
$locale['SYS228'] = "Proxy access";
$locale['SYS229'] = "%s successfully blocked.";
$locale['SYS230'] = "More settings";
$locale['SYS231'] = "Online documentation";

$locale['SUPD100'] = "Security System update";
$locale['SUBD101'] = "New update installed";
$locale['SUBD102'] = "New update successfully installed!";
$locale['SUBD103'] = "No updates available";
$locale['SUBD104'] = "The Security System is up-to-date!";
$locale['SUBD105'] = "New update available";
$locale['SUBD106'] = "A new version of Security System was found. 	
To download the file, registration on BS-Fusion is required.";
$locale['SUBD107'] = "Error on update";
$locale['SUBD108'] = "An error occured while updating.<br>\n %s";
$locale['SUBD109'] = "The used version is older than required for the update. Required version is %s";
$locale['SUBD110'] = "An error occured while updating. Please contact the developer of this infusion.";
$locale['SUBD111'] = "The function \"fsockopen()\" is deactivated. Please check for updates on";
$locale['SUBD112'] = "Update";
// NEW LOCALES END



$locale['SYS300'] = "<a class='small' href='http://www.bs-fusion.de' target='_blank'>More security</a> with the<br>
<a class='small' href='http://www.bs-fusion.de' target='_blank'>BS-Fusion Security System.</a>";
$locale['SYS301'] = "Protected with the <a class='small' href='http://www.bs-fusion.de' target='_blank'>BS-Fusion Security System</a><br>%s attacks blocked";
$locale['SYS302'] = "%s attempt(s), blocked";
$locale['SYS400'] = "Close Window";
$locale['SYS401'] = "Print";
$locale['license_accept'] = "I agree to the license-contract!";
?>