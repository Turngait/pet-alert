<?php
session_start();
include "modules/main.php";
include "modules/user.class.php";

$user = new User($_SESSION[id], $_SESSION[name]);


//Рендер страниц
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

if(isset($_GET['get_info'])) {
    $html = renderInfo("Hello", 'main_controller.php?desc=1');
    echo $html;
}

//Функционал
if(isset($_GET[reg])) {
    $answer = $user->reg();
    if($answer > 1) {
        echo "<script>alert('Такой логин уже существует!');</script>";
        echo "<script>window.location='main_controller.php?desc=1';</script>";
    }
    if($answer === 'email') {
        echo "<script>alert('Такой email уже существует!');</script>";
        echo "<script>window.location='main_controller.php?desc=1';</script>";
    }
    if($answer) {
        $html = renderInfo("Регистрация прошла успешно!", 'main_controller.php?desc=1');
        echo $html;
    }
    else {
        $html = renderInfo("Ошибка! Обратитесь к администратору!", 'main_controller.php?desc=1');
        echo $html;
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

//Добавление постов
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

if(isset($_GET['addPostFind'])) {
    $answer = $user->addFindPost($_SESSION[id]);
    if($answer) {
        echo "<script>window.location='main_controller.php?desc=1';</script>";

    }
    else if ($answer === 2) {
        echo "<script>alert('Ошибка загрузки изображения!');</script>";
        echo "<script>window.location='main_controller.php?desc=1';</script>";
    }
    else {
        echo "<script>alert('Ошибка добавления записи!');</script>";
        echo "<script>window.location='main_controller.php?desc=1';</script>";
    }
}

//Редактирование постов
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

if(isset($_GET['editFindPost'])) {
    $answer = $user->editFindPost($_SESSION[id]);
    if($answer) {
        echo "<script>window.location='main_controller.php?user_acc=1';</script>";

    }
    else {
        echo "<script>alert('Ошибка редактирования записи!');</script>";
        echo "<script>window.location='main_controller.php?user_acc=1';</script>";
    }
}

//Удаление постов
if(isset($_GET['deletePost'])) {
    $answer = $user->deletePost();
    if($answer) {
        echo "<script>window.location='main_controller.php?user_acc=1';</script>";

    }
    else {
        echo "<script>alert('Ошибка удаления записи!');</script>";
        echo "<script>window.location='main_controller.php?user_acc=1';</script>";
    }
}


if(isset($_GET['deleteFindPost'])) {
    $answer = $user->deleteFindPost();
    if($answer) {
        echo "<script>window.location='main_controller.php?user_acc=1';</script>";

    }
    else {
        echo "<script>alert('Ошибка удаления записи!');</script>";
        echo "<script>window.location='main_controller.php?user_acc=1';</script>";
    }
}

//Смена данных пользователем в ЛК
if(isset($_GET['chandeUserData'])) {
    $answer = $user->changeUserData();

    if($answer) {
        echo "<script>window.location='main_controller.php?user_acc=1';</script>";

    }
    else {
        echo "<script>alert('Ошибка редактирования!');</script>";
        echo "<script>window.location='main_controller.php?user_acc=1';</script>";
    }
}

//Смена пароля в ЛК
if(isset($_GET['chandeUserPass'])){
    $answer = $user->changePassword();

    if($answer) {
        echo "<script>window.location='main_controller.php?user_acc=1';</script>";

    }
    else {
        echo "<script>alert('Пароль указан не верно!');</script>";
        echo "<script>window.location='main_controller.php?user_acc=1';</script>";
    }
}


//Восстановление пароля
if(isset($_GET['retrivePass'])) {
    $html = retrivePass();
    echo $html;
}

if(isset($_GET['getPassbyEmail'])) {
    $answer = $user->retrivePass();
    
    if($answer) {
        echo "<script>alert('Вам отправлено письмо на почту!');</script>";
        echo "<script>window.location='main_controller.php?desc=1';</script>";

    }
    else {
        echo "<script>alert('Email указан не верно!');</script>";
        echo "<script>window.location='main_controller.php?desc=1';</script>";
    }
}

if(isset($_GET['setNewPass'])) {
    $html = setNewPass();
    echo $html;
}

if(isset($_GET['setNewPassEnd'])) {
    $answer = $user->setNewUserPass();

    if($answer) {
        echo "<script>alert('Пароль изменен!');</script>";
        echo "<script>window.location='main_controller.php?desc=1';</script>";

    }
    else if ($answer ==='not equal') {
        echo "<script>alert('Проверочное число указано не верно!');</script>";
        echo "<script>window.location='main_controller.php?desc=1';</script>";
    }
    else {
        echo "<script>alert('Ошибка! Обратитесь к администратору сайта.');</script>";
        echo "<script>window.location='main_controller.php?desc=1';</script>";
    }
}
?>