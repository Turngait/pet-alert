<?php
session_start();

if(isset($_GET['pass'])){
    $login = $_GET['login'];
    $pass = md5($_GET['pass']);
    $server = $_SERVER['DOCUMENT_ROOT'];
    $db_acces = "$server/config/pdo.php";

    include $db_acces;
                
    $check = $db -> prepare("SELECT * FROM `users` WHERE `login`='$login' and `pass`='$pass';");
    $check->execute();
    $user = $check->fetch();
    
    //Если что то в user[id] находится, то присваиваем сессии элементы пользователя
    if (isset($user['id'])) {
        setcookie('user_id', $user['id'], time()+900);
        echo 1;
    }
    else {
        echo $server;
    }
    
}

if(isset($_GET['checkLogin'])) {
    if(isset($_COOKIE['user_id'])) {
        echo $_COOKIE['user_id'];
    }
    else {
        echo 0;
    }
}

?>