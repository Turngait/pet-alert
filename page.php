<?php
session_start();
require 'modules/page.class.php';

$page = new Page($_SESSION['id'], $_SESSION['name']);

$page->{$_GET['open']}();
?>