<?php
session_start();
require 'modules/page.class.php';
include "config/pdo.php";

$page = new Page($_SESSION['id'], $_SESSION['name'], $db);

$page->{$_GET['open']}();
?>