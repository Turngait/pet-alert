<?php
session_start();
include "../modules/main.php";
include "../modules/user.class.php";

$user = new User($_SESSION[id], $_SESSION[name]);

if(isset($_GET['check_login'])) {
    $login = $_GET['check_login'];
    $answer = $user->checkLogin($login);
    if($answer) {
        echo 1;
    }
    else {
        echo 0; 
    }
};



if(isset($_GET['check_email'])) {
    $email = $_GET['check_email'];
    $answer = $user->checkEmail($email);
    if($answer) {
        echo 1;
    }
    else {
        echo 0; 
    }
};