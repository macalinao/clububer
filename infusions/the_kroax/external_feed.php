<?php
$extern = (isset($_GET['ex'])) ? strval($_GET['ex']) : 'www.venue.nu/infusions/the_kroax/streamplaylist.php';
$extern = "http://" . $extern;
header("content-type:text/xml;charset=utf-8");
readfile("$extern");
?>
