<?php
session_start();
include "modules/page.class.php";
include "modules/user.class.php";
include "modules/guest.class.php";
include "modules/client.class.php";

$page = new Page($_SESSION['id'], $_SESSION['name']);

if(isset($_GET['reg'])) {
  $user = new Guest();

  $answer = $user->reg($_POST);

  if ($answer === 'email') {
    $page->showInfo('Данный e-mail уже существует.', 'page.php?open=postsPage');
  }
  else if ($answer === 1) {
    $page->loginPage('Вы успешно зарегестрировались!');
  }
  else if ($answer > 1) {
    $page->showInfo('Такой логин уже существует.', 'page.php?open=postsPage');    
  }
  else {
    $page->showInfo('Ошибка регистрации! Обратитесь к администратору!', 'page.php?open=postsPage');
  }
}

if(isset($_GET['login'])) {
  $user = new Guest();

  if($user->login($_POST['login'], md5($_POST['pass']))) {
    header('Location: /page.php?open=postsPage');
  }
  else {
    $page->loginPage('Неверный логин или пароль.');
  }
}

if(isset($_GET['exit'])) {
  $user = new User($_SESSION['id'], $_SESSION['name']);
  $user->exitUser();
}

if(isset($_GET['addPost'])) {
  $client = new Client($_SESSION['id'], $_SESSION['name']);
  $answer = $client->addPost($_POST, $_POST['type']);

  if($answer === 2) {
    $page->showInfo("Ошибка загрузки изображения! Обратитесь к администратору!", 'page.php?open=postsPage');
  }
  else if($answer === true) {
    header('Location: /page.php?open=postsPage');
  }
  else {
    $page->showInfo("Ошибка добавления записи! Обратитесь к администратору!", 'page.php?open=postsPage');
  }
}

if(isset($_GET['editPost'])) {
  $client = new Client($_SESSION['id'], $_SESSION['name']);
  if($client->editPost($_POST, $_POST['type'])) {
    header('Location: /page.php?open=userAccaunt');
  }
  else {
    $page->showInfo("Ошибка редактировании записи! Обратитесь к администратору!", 'page.php?open=userAccaunt');
  }
}

if(isset($_GET['deletePost'])) {
  $client = new Client($_SESSION['id'], $_SESSION['name']);
  if($client->deletePost($_POST, $_POST['type'])) {
    header('Location: /page.php?open=userAccaunt');
  }
  else {
    $page->showInfo("Ошибка удалении записи! Обратитесь к администратору!", 'page.php?open=userAccaunt');
  }
}


if (isset($_GET['chandeUserData'])) {
  $client = new Client($_SESSION['id'], $_SESSION['name']);
  if($client->changeUserData($_POST)) {
    header('Location: /page.php?open=userAccaunt');
  }
  else {
    $page->showInfo("Ошибка редактирования! Обратитесь к администратору!", 'page.php?open=userAccaunt');
  }
}


if(isset($_GET['chandeUserPass'])) {
  $client = new Client($_SESSION['id'], $_SESSION['name']);
  if($client->changePassword($_POST)) {
    header('Location: /page.php?open=userAccaunt');
  }
  else {
    $page->showInfo("Неверно ввели старый пароль.", 'page.php?open=userAccaunt');
  }
}