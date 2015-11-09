<?php
require_once "../../../../maincore.php";
require_once THEMES."templates/header.php";

if (!iMEMBER) { header("Location:../../index.php"); exit; }


include_once INFUSIONS."user_gold/inc/functions.php";//will include new version of same file

?>