<?php
require_once "../../maincore.php";
//include_once(INFUSIONS."avatarmaker/class/avatarmaker.php");
include INFUSIONS."ug_avatarmaker/class/avatarmaker.php";

$avatar = new AvatarMaker();
global $HTTP_POST_VARS;
for ($i = 1; avatarmaker_check_file($i, $_GET); $i++){
	$avatar->addImage('images/' . $_GET['i' . $i] . '.' . $avatar->type, $avatar->type);
}

if (array_key_exists('preview', $_GET))
{
	$avatar->show();
}

$avatar->destroy();
?>
