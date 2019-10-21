<?php

class User {
    protected $id;
    protected $name;

    public function __construct ($id, $name) {
        $this->id = $id;
        $this->name = $name;
    }
    
    public function reg() {
        include "config/pdo.php";
        $name =  $_POST['user_name'];
        $login = $_POST['user_login'];
        $pass = md5($_POST['user_pass']);
        $email = $_POST['user_mail'];

        $queryNU = "INSERT INTO `users` VALUES(NULL, '$name', '$email', '$login', '$pass', NULL, 0);";
        
        //Проверяем занят ли логин и мэил на стороне сервера
        $check = $db -> prepare("SELECT * FROM users WHERE login='$login';");
        $check_email = $db -> prepare("SELECT * FROM users WHERE email='$email';");
        $check->execute();
        $user = $check->fetch();
        $check_email->execute();
        $user_email = $check_email->fetch();
        
        //Если что то в user[id] находится, то такой логин и мэил заняты
        if (isset($user[id])) {
            if(isset($user_email[id])){
                return 'email';
            }
            return $user[id];
        }
        if ($add_user = $db->exec($queryNU)) {
            $this->createUserHash($login);

            $to = $email; 

            // тема письма
            $subject = 'Регистрация на сайте Pet-Alert.ru';
    
            // текст письма
            $message = '
            <html>
            <head>
            <title>Регистрация на сайте Pet-Alert.ru</title>
            </head>
            <body>
            <p>
            '.$name.',<br>
            Вы только что зарегестрировались на сайте Pet-Alert.ru.<br>
            Ваш логин:'.$login.'<br><br>
            Ваш пороль:'.$_POST[user_pass].'<br><br>
            Теперь Вы можете оставлять объявления о пропаже домашних животных.
            </p>
            </body>
            </html>
            ';
    
            // Для отправки HTML-письма должен быть установлен заголовок Content-type
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    
            // Дополнительные заголовки
            $headers .= 'From: Pet Alert <info@pet-alert.ru>';
    
            // Отправляем
            mail($to, $subject, $message, $headers);
            mail("ryzhov.is@mail.ru", "Новый пользователь", "Новая регистрация!");
            return 1;
        }
        else {
            return 0;
        }
    }

    public function createUserHash($login) {
        include "config/pdo.php";
        $queryNewUser = "SELECT `id` FROM `users` WHERE `login` = '$login';";
        $get_user = $db -> prepare($queryNewUser);
        $get_user -> execute();
        $user = $get_user->fetch(); 
        $user_id = $user['id'];
        $hash_user = md5($login);

        $queryAddHash = "INSERT INTO `hur` VALUES($user_id, '$hash_user');";
        $add_hash = $db ->prepare($queryAddHash);
        $add_hash->execute();
    }

    public function login($login, $pass) {
        include "config/pdo.php";
                
        $check = $db -> prepare("SELECT * FROM users WHERE login='$login' and pass='$pass';");
        $check->execute();
        $user = $check->fetch();
        
        //Если что то в user[id] находится, то присваиваем сессии элементы пользователя
        if (isset($user[id])) {
            $_SESSION[id] = $user[id];
            $_SESSION[name] = $user[name];
            $_SESSION[status] = $user[status];
            return true;
        }
        else {
            return false;
        }
    }

    public function exitUser() {
        session_start();
        $_SESSION = array();
        session_destroy();
        header("Location: index.php");
    }


    //Ajax functions

    public function checkLogin($login) {
        include "../config/pdo.php";
        $queryCheckLogin = "SELECT * FROM `users` WHERE `login` = '$login';";

        $check = $db -> prepare($queryCheckLogin);
        $check->execute();
        $user = $check->fetch();
        if(isset($user[id])) {
            return true;
        }
        else {
            return false;
        };
    }

    public function checkEmail($email) {
        include "../config/pdo.php";
        $queryCheckEmail = "SELECT * FROM `users` WHERE `email` = '$email';";

        $check = $db -> prepare($queryCheckEmail);
        $check->execute();
        $user = $check->fetch();
        if(isset($user[id])) {
            return true;
        }
        else {
            return false;
        };
    }
}

?>