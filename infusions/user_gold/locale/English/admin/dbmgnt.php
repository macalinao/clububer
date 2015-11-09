<?PHP
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| User Gold 3
| Copyright © 2007 - 2008 UG3 Developement Team
| http://www.starglowone.com/
+--------------------------------------------------------+
| Filename: English/admin/dbmgnt.php
| Author: UG3 Developement Team
+--------------------------------------------------------+
| This program is released as free software under the
| Stars Heaven Licence. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included licence.html.
| Removal of this copyright header is strictly
| prohibited without written permission
| from the original author(s).
+--------------------------------------------------------*/
$locale['urg_a_dbmgnt_100'] = "Delete user(s)?";
$locale['urg_a_dbmgnt_101'] = "This action will clean up your \"user_gold\", \"user_gold_inventory\" and \"user_gold_transactions\" tables, by deleting all users, their inventory and transactions, that do not exist anymore on you site.<br />You should not do anything until the operation is completed.";
$locale['urg_a_dbmgnt_102'] = "NOTE: This is experimental and you should make an backup of your database before continuing!";
$locale['urg_a_dbmgnt_103'] = "YES, i wan't to clean up my tables.";
$locale['urg_a_dbmgnt_104'] = "Continue";
$locale['urg_a_dbmgnt_105'] = "Cancel";
$locale['urg_a_dbmgnt_106'] = "Delete user(s)";
$locale['urg_a_dbmgnt_107'] = "And their inventory";
$locale['urg_a_dbmgnt_108'] = "And their transactions";

$locale['urg_a_dbmgnt_109'] = "Successfully deleted the user %s with owner_id %s.";
$locale['urg_a_dbmgnt_110'] = "Failed to delete the user %s with owner_id %s.";
$locale['urg_a_dbmgnt_111'] = "Successfully deleted the item %s with ownerid %s.";
$locale['urg_a_dbmgnt_112'] = "Failed to delete the item %s with ownerid %s.";

$locale['urg_a_dbmgnt_113'] = "Successfully deleted the transaction %s with ownerid %s.";
$locale['urg_a_dbmgnt_114'] = "Failed to delete the transaction %s with ownerid %s.";

$locale['urg_a_dbmgnt_115'] = "No users to delete";
$locale['urg_a_dbmgnt_116'] = "Error!!! Didn't check \"YES, i wan't to clean up my tables\".";
?>