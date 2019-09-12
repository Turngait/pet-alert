<?php
session_start();
include "modules/main.php";
include "modules/user.class.php";
require 'modules/page.class.php';

$user = new User($_SESSION[id], $_SESSION[name]);
$page = new Page($_SESSION[id], $_SESSION[name]);


//Рендер страниц
if(isset($_GET['desc'])) {
    $page->postsPage();
}

if(isset($_GET['new_post'])) {
    $html = newPost();
    echo $html;
}

if(isset($_GET['about'])) {
    $html = showAbout();
    echo $html;
}

if(isset($_GET['user_acc'])) {
    $html = userAcc($_SESSION[id]);
    echo $html;
}

if(isset($_GET['policy'])) {
    $html = showPolicy();
    echo $html;
}

if(isset($_GET['get_info'])) {
    $html = renderInfo("Hello", 'main_controller.php?desc=1');
    echo $html;
}

if(isset($_GET['get_login'])) {
    $html = renderLogin("Login page");
    echo $html;
}

//Функционал
if(isset($_GET['reg'])) {
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
        $html = renderInfo("Вы успешно зарегестрировались!", 'main_controller.php?desc=1');
        echo $html;
    }
    else {
        $html = renderInfo("Ошибка регистрации! Обратитесь к администратору!", 'main_controller.php?desc=1');
        echo $html;
    }
}

if(isset($_GET[auth])) {
    $answer = $user->login($_POST[login], md5($_POST[pass]));

    if($answer) {
        echo "<script>window.location='main_controller.php?desc=1';</script>";
    }
    else {
        $html = renderLogin("Неверный логин или пароль!");
        echo $html;
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
        $html = renderInfo("Ошибка загрузки изображения! Обратитесь к администратору!", 'main_controller.php?desc=1');
        echo $html;
    }
    else {
        $html = renderInfo("Ошибка добавления записи! Обратитесь к администратору!", 'main_controller.php?desc=1');
        echo $html;
    }
}

if(isset($_GET['addPostFind'])) {
    $answer = $user->addFindPost($_SESSION[id]);
    if($answer) {
        echo "<script>window.location='main_controller.php?desc=1';</script>";

    }
    else if ($answer === 2) {
        $html = renderInfo("Ошибка загрузки изображения! Обратитесь к администратору!", 'main_controller.php?desc=1');
        echo $html;
    }
    else {
        $html = renderInfo("Ошибка добавления записи! Обратитесь к администратору!", 'main_controller.php?desc=1');
        echo $html;
    }
}

//Редактирование постов
if(isset($_GET['editPost'])) {
    $answer = $user->editPost($_SESSION[id]);
    if($answer) {
        echo "<script>window.location='main_controller.php?user_acc=1';</script>";

    }
    else {
        $html = renderInfo("Ошибка редактирования записи! Обратитесь к администратору!", 'main_controller.php?user_acc=1');
        echo $html;
    }
}

if(isset($_GET['editFindPost'])) {
    $answer = $user->editFindPost($_SESSION[id]);
    if($answer) {
        echo "<script>window.location='main_controller.php?user_acc=1';</script>";

    }
    else {
        $html = renderInfo("Ошибка редактирования записи! Обратитесь к администратору!", 'main_controller.php?user_acc=1');
        echo $html;
    }
}

//Удаление постов
if(isset($_GET['deletePost'])) {
    $answer = $user->deletePost();
    if($answer) {
        echo "<script>window.location='main_controller.php?user_acc=1';</script>";
    }
    else {
        $html = renderInfo("Ошибка удаления записи! Обратитесь к администратору!", 'main_controller.php?user_acc=1');
        echo $html;
    }
}


if(isset($_GET['deleteFindPost'])) {
    $answer = $user->deleteFindPost();
    if($answer) {
        echo "<script>window.location='main_controller.php?user_acc=1';</script>";

    }
    else {
        $html = renderInfo("Ошибка удаления записи! Обратитесь к администратору!", 'main_controller.php?user_acc=1');
        echo $html;
    }
}

//Смена данных пользователем в ЛК
if(isset($_GET['chandeUserData'])) {
    $answer = $user->changeUserData();

    if($answer) {
        echo "<script>window.location='main_controller.php?user_acc=1';</script>";

    }
    else {
        $html = renderInfo("Ошибка редактирования личных данных! Обратитесь к администратору!", 'main_controller.php?user_acc=1');
        echo $html;
    }
}

//Смена пароля в ЛК
if(isset($_GET['chandeUserPass'])){
    $answer = $user->changePassword();

    if($answer) {
        echo "<script>window.location='main_controller.php?user_acc=1';</script>";

    }
    else {
        $html = renderInfo("Старый пароль указан не верно!", 'main_controller.php?user_acc=1');
        echo $html;
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
        $html = renderInfo("Вам отправлено письмо на почту!", 'main_controller.php?desc=1');
        echo $html;
    }
    else {
        $html = renderInfo("Email указан не верно!", 'main_controller.php?retrivePass=1');
        echo $html;
    }
}

if(isset($_GET['setNewPass'])) {
    $html = setNewPass();
    echo $html;
}

if(isset($_GET['setNewPassEnd'])) {
    $url = $_SERVER['HTTP_REFERER'];
    $answer = $user->setNewUserPass();
    

    if($answer ==='not equal') {
        $html = renderInfo("Проверочное число указано не верно!", $url);
        echo $html;
    }
    else if ($answer) {
        $html = renderInfo("Пароль изменен!", 'main_controller.php?desc=1');
        echo $html;
        
    }
    else {
        $html = renderInfo("Ошибка! Обратитесь к администратору сайта.", 'main_controller.php?desc=1');
        echo $html;
    }
}


if(isset($_GET['admin_intro'])) {
    $html = renderAdmin();
    echo $html;
}
?>