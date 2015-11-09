<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--- ----------------------------------------------------+
| UBERPETS V 0.0.0.5
+--------------------------------------------------------+
| Uberpets Copyright 2008 Grr@µsoft inc.
| http://www.clububer.com/
\*-------------------------------------------------------*/
if ($uberpets_settings['scriptseofusion'] == 1){
	$plink = array(
	
	//uberpets_pet_panel.php
	"UBP_001" => "".BASEDIR."uberpets/pound?page=abandon",
	"UBP_002" => "".BASEDIR."uberpets/create-pet",
	
	"UBP_101" => "".BASEDIR."uberpets/pound?page=adopt",
	"UBP_102" => "".BASEDIR."uberpets/pound?page=abandon",
	"UBP_103" => "".BASEDIR."uberpets/pound?page=abandon&step=2&pet_id=1",
	"UBP_104" => "".BASEDIR."uberpets/pound?page=abandon&step=2&pet_id=2",
	"UBP_105" => "".BASEDIR."uberpets/pound?page=abandon&step=2&pet_id=3",
	"UBP_106" => "".BASEDIR."uberpets/pound?page=abandon&step=2&pet_id=4",
	"UBP_107" => "".BASEDIR."uberpets/pound?page=abandon&step=3&pet_id=".$pet_id."",
	"UBP_108" => "".BASEDIR."uberpets/pound",
	"UBP_109" => "".BASEDIR."uberpets/index",

	"UBP_201" => "".BASEDIR."uberpets/create-pet-step-1",
	"UBP_202" => "".BASEDIR."uberpets/create-pet-step-2-species-",
	"UBP_203" => "".BASEDIR."uberpets/forms/cancer_create_pet",
	"UBP_204" => "".BASEDIR."uberpets/create-pet-step-3"
	);
} else {
	$plink = array(
	
	//uberpets_pet_panel.php
	"UBP_001" => "".UBP_BASE."pound.php?page=abandon",
	"UBP_002" => "".UBP_BASE."create_pet.php",

	//pound.php
	"UBP_101" => "".FUSION_SELF."?page=adopt",
	"UBP_102" => "".FUSION_SELF."?page=abandon",
	"UBP_103" => "".FUSION_SELF."?page=abandon&step=2&pet_id=1",
	"UBP_104" => "".FUSION_SELF."?page=abandon&step=2&pet_id=2",
	"UBP_105" => "".FUSION_SELF."?page=abandon&step=2&pet_id=3",
	"UBP_106" => "".FUSION_SELF."?page=abandon&step=2&pet_id=4",
	"UBP_107" => "".FUSION_SELF."?page=abandon&step=3&pet_id=".$pet_id."",
	"UBP_108" => "".FUSION_SELF."",
	"UBP_109" => "".UBP_BASE."index.php",
	
	"UBP_201" => "".UBP_BASE."create_pet.php?step=1",
	"UBP_202" => FUSION_SELF."?step=2&species=",
	"UBP_203" => "".UBP_BASE."forms/cancer_create_pet.php",
	"UBP_204" => UBP_BASE."create_pet.php?step=3"
	);
}
?>
