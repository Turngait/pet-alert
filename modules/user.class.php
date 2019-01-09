<?php

class User {
    private $id;
    public $name;

    public function __construct ($id, $name) {
        $this->id = $id;
        $this->name = $name;
    }
    
    public function reg() {
        include "config/pdo.php";
        $name =  $_POST['user_name'];
        $login = $_POST[user_login];
        $pass = md5($_POST[user_pass]);
        $email = $_POST[user_mail];

        $queryNU = "INSERT INTO `users` VALUES(NULL, '$name', '$email', '$login', '$pass', NULL, 0);";
        
        $check = $db -> prepare("SELECT * FROM users WHERE login='$login';");
        $check->execute();
        $user = $check->fetch();
        
        //Если что то в user[id] находится, то присваиваем сессии элементы пользователя
        if (isset($user[id])) {
            return $user[id];
        }
        if ($add_user = $db->exec($queryNU)) {
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
            mail("wulzin.t@gmail.com", "Новый пользователь", "Новая регистрация!");
            return 1;
        }
        else {
            return 0;
        }
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

    public function addPost($user_id) {
        include "config/pdo.php";
        /*echo "<pre>";
        print_r($_POST);
        echo "</pre>";
        $text = htmlentities(nl2br($_POST[desc_text]));
        echo $text;
        */
        $newFilename = $_SERVER['DOCUMENT_ROOT']. '/public/photo/';
        $uploadInfo = $_FILES['pet_photo'];
        $newFilename.= $_FILES['pet_photo']['name'];
        $src='public/photo/'.$_FILES['pet_photo']['name'];

        //Перемещаем файл из временной папки в указанную
        if (!move_uploaded_file($uploadInfo['tmp_name'], $src)) {
            print_r($_FILES);
            echo 'Не удалось осуществить сохранение файла';
        }
        else {

            $desc_name = $_POST[desc_name];
            $desc_city = $_POST[desc_city];
            $desc_text = $_POST[desc_text];
            $desc_mail = $_POST[desc_mail];
            
            $queryLostPost = "INSERT INTO `lost_post` VALUES(NULL, '$user_id', '$desc_name', '$src', '$desc_text', '$desc_city', '$desc_mail', NULL, 0);";
            if ($add_post = $db->exec($queryLostPost)) {
                mail("wulzin.t@gmail.com", "Новое объявление", "Добавлен новый пост!");
                return true;
            }
            else {
            return false;
            }
        }

    }
}

?>