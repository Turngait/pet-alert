<?php
//USER ACTION CONTROLLER
session_start();
include "modules/page.class.php";
include "modules/user.class.php";
include "modules/guest.class.php";
include "modules/client.class.php";
include "lib/array_helpers.php";
include "config/pdo.php";

$page = new Page($_SESSION['id'], $_SESSION['name']);

if(isset($_GET['reg'])) {
  $user = new Guest($db);

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
  $user = new Guest($db);

  if($user->login($_POST['login'], md5($_POST['pass']))) {
    header('Location: /page.php?open=postsPage');
  }
  else {
    $page->loginPage('Неверный логин или пароль.');
  }
}

if(isset($_GET['exit'])) {
  $user = new User($_SESSION['id'], $_SESSION['name'], $db);
  $user->exitUser();
}


if(isset($_GET['addPost'])) {
  $client = new Client($_SESSION['id'], $_SESSION['name'], $db);
  $answer = $client->addPost($_POST, $_POST['type']);

  if($answer === 2) {
    $page->showInfo("Ошибка загрузки изображения! Обратитесь к администратору!", 'page.php?open=postsPage');
  }
  else if ($answer === 3) {
    $page->showInfo('Вы прекрипили фаил не являющийся изображением.', 'page.php?open=postsPage');    
  }
  else if($answer === true) {
    header('Location: /page.php?open=postsPage');
  }
  else {
    $page->showInfo("Ошибка добавления записи! Обратитесь к администратору!", 'page.php?open=postsPage');
  }
}


if(isset($_GET['editPost'])) {
  $client = new Client($_SESSION['id'], $_SESSION['name'], $db);
  if($client->editPost($_POST, $_POST['type'])) {
    header('Location: /page.php?open=userAccaunt');
  }
  else {
    $page->showInfo("Ошибка редактировании записи! Обратитесь к администратору!", 'page.php?open=userAccaunt');
  }
}


if(isset($_GET['addArticle'])) {
  $client = new Client($_SESSION['id'], $_SESSION['name'], $db);
  $files = reArrayFiles($_FILES['img']);

  $answer = $client->addArticle($_POST,$_FILES['photo'], $files);
  
  if($answer === 'db problem') {
    $page->showInfo("Ошибка добавления записи! Обратитесь к администратору!", 'page.php?open=postsPage');
  }
  else if($answer === 'wrong ammount of files') {
    $page->showInfo("Колличество дополнительных фотографий не должно превышать 4.", 'page.php?open=postsPage');
  }
  else if($answer === 'wrong file type') {
    $page->showInfo("Фотографии должны быть в формате jpg/jpeg или png.", 'page.php?open=postsPage');    
  }
  else if($answer == true) {
    header('Location: /page.php?open=articlesPage');
  }
}

if (isset($_GET['editArticle'])){
  $client = new Client($_SESSION['id'], $_SESSION['name'], $db);
  $answer = $client->editArticle($_POST, $_GET['editArticle']);

  if($answer) {
    header('Location: /page.php?open=getArticle&id='.$_GET['editArticle']);
  }
  else {
    $page->showInfo("Ошибка редактирования записи! Обратитесь к администратору!", 'page.php?open=postsPage');
  }
}


if(isset($_GET['deletePost'])) {
  $client = new Client($_SESSION['id'], $_SESSION['name'], $db);
  if($client->deletePost($_POST, $_POST['type'])) {
    header('Location: /page.php?open=userAccaunt');
  }
  else {
    $page->showInfo("Ошибка удалении записи! Обратитесь к администратору!", 'page.php?open=userAccaunt');
  }
}


if (isset($_GET['chandeUserData'])) {
  $client = new Client($_SESSION['id'], $_SESSION['name'], $db);
  if($client->changeUserData($_POST)) {
    header('Location: /page.php?open=userAccaunt');
  }
  else {
    $page->showInfo("Ошибка редактирования! Обратитесь к администратору!", 'page.php?open=userAccaunt');
  }
}


if(isset($_GET['chandeUserPass'])) {
  $client = new Client($_SESSION['id'], $_SESSION['name'], $db);
  if($client->changePassword($_POST)) {
    header('Location: /page.php?open=userAccaunt');
  }
  else {
    $page->showInfo("Неверно ввели старый пароль.", 'page.php?open=userAccaunt');
  }
}

if(isset($_GET['retrivePass'])) {
  $guest = new Guest();

  if($guest->retrivePass($_POST)) {
    $page->showInfo("Вам отправленно письмо с инсnрукцией на Ваш e-mail.", 'page.php?open=postsPage');
  }
  else {
    $page->retrivePass('Вы ввели неверный e-mail');
  }
}

if(isset($_GET['setNewPass'])) {
  $guest = new Guest();

  if($guest->setNewPass($_POST)) {
    $page->showInfo("Пароль успешно изменен.", 'page.php?open=postsPage');
  }
  else {
    $page->showInfo("Ошибка. Обратитесь к администратору сайта", 'page.php?open=postsPage');
  }
}