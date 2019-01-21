<?php
session_start();
include "modules/main.php";
include "modules/user.class.php";

$user = new User($_SESSION[id], $_SESSION[name]);

if(isset($_GET[desc])) {
    $html = showDesc();
    echo $html;
}

if(isset($_GET[new_post])) {
    $html = newPost();
    echo $html;
}

if(isset($_GET[about])) {
    $html = showAbout();
    echo $html;
}

if(isset($_GET[user_acc])) {
    $html = userAcc($_SESSION[id]);
    echo $html;
}

if(isset($_GET[policy])) {
    $html = showPolicy();
    echo $html;
}

if(isset($_GET[reg])) {
    $answer = $user->reg();
    if($answer > 1) {
        echo "<script>alert('Такой логин уже существует!');</script>";
        echo "<script>window.location='main_controller.php?desc=1';</script>";
    }
    if($answer) {
        echo "<script>alert('Вы зарегестрировались!');</script>";
        echo "<script>window.location='main_controller.php?desc=1';</script>";
    }
    else {
        echo "<script>alert('Ошибка! Обратитесь к администратору!');</script>";
        echo "<script>window.location='main_controller.php?desc=1';</script>";
    }
}

if(isset($_GET[auth])) {
    $answer = $user->login($_POST[login], md5($_POST[pass]));

    if($answer) {
        echo "<script>window.location='main_controller.php?desc=1';</script>";
    }
    else {
        echo "<script>alert('Неверный логин или пароль!');</script>";
        echo "<script>window.location='main_controller.php?desc=1';</script>";
    }
}

if(isset($_GET['exit'])) {
    $user->exitUser();
}

//CRUD по постам обычных юзеров
if(isset($_GET['addPost'])) {
    $answer = $user->addPost($_SESSION[id]);
    if($answer) {
        echo "<script>window.location='main_controller.php?desc=1';</script>";

    }
    else if ($answer == 2) {
        echo "<script>alert('Ошибка загрузки изображения!');</script>";
        echo "<script>window.location='main_controller.php?desc=1';</script>";
    }
    else {
        echo "<script>alert('Ошибка добавления записи!');</script>";
        echo "<script>window.location='main_controller.php?desc=1';</script>";
    }
}

if(isset($_GET['editPost'])) {
    $answer = $user->editPost($_SESSION[id]);
    if($answer) {
        echo "<script>window.location='main_controller.php?user_acc=1';</script>";

    }
    else {
        echo "<script>alert('Ошибка редактирования записи!');</script>";
        echo "<script>window.location='main_controller.php?user_acc=1';</script>";
    }
}

if(isset($_GET['deletePost'])) {
    $answer = $user->deletePost();
    if($answer) {
        echo "<script>window.location='main_controller.php?user_acc=1';</script>";

    }
    else {
        echo "<script>alert('Ошибка редактирования записи!');</script>";
        echo "<script>window.location='main_controller.php?user_acc=1';</script>";
    }
}
?>