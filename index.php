<?php
session_start();
include "modules/main.php";
$html = showMain();
echo $html;
//header("Location: index.html");
?>