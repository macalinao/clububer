<?php
require_once "maincore.php";
header("Content-type: text/html; charset=ISO-8859-9");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");    // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");  // HTTP/1.1
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");        // HTTP/1.0

echo '
<ut_response status="ok">
<video_list>';

//$result = dbquery("SELECT * FROM ".$db_prefix."kroax order by kroax_lastplayed DESC limit 15");

		$result= dbquery("SELECT ter.*,kroax_id,kroax_url,kroax_tumb,kroax_titel,kroax_description FROM ".$db_prefix."kroax_active ter
		LEFT JOIN ".$db_prefix."kroax tusr ON ter.movie_id=tusr.kroax_id
		WHERE ".groupaccess('kroax_access')." AND  ".groupaccess('kroax_access_cat')." AND kroax_approval='' ORDER BY lastactive DESC");

while($playdata = dbarray($result)) {
echo "
      <video>
	<title>".$playdata['kroax_titel']."</title>
	<run_time>1337</run_time>
             <url>infusions/the_kroax/embed.php?url=".$playdata['kroax_id']."</url>
	<thumbnail_url>".$playdata['kroax_tumb']."</thumbnail_url>

         </video>";
}

echo "
</video_list>
</ut_response>
";
?>