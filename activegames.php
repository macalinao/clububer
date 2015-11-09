<?php
require_once "maincore.php";
header('Content-type: text/html; charset=utf-8');
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");    // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");  // HTTP/1.1
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");        // HTTP/1.0

echo '
<ut_response status="ok">
<video_list>';

$result =dbquery("select * FROM ".$db_prefix."varcade_active ORDER BY lastactive DESC");


while($data = dbarray($result)) {
echo "
      <video>
	<title>".$data['title']."</title>
             <url>infusions/varcade/arcade.php?game=".$data['game_id']."</url>
	<thumbnail_url>infusions/varcade/uploads/thumb/".$data['icon']."</thumbnail_url>

         </video>";
}

echo "
</video_list>
</ut_response>
";
?>