<?php
//require_once "../../../../maincore.php";
require_once "charts.php";
//require_once INFUSIONS."user_gold/infusion_db.php";
//require_once INFUSIONS."user_gold/functions.php";

// Render the chart
echo InsertChart ( "inc/charts/charts.swf", "inc/charts/charts_library", "inc/charts/outcome_data.php", 600, 150, "e5f2fa", true );

?>