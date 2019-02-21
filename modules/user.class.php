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
        $check_email = $db -> prepare("SELECT * FROM users WHERE email='$email';");
        $check->execute();
        $user = $check->fetch();
        $check_email->execute();
        $user_email = $check_email->fetch();
        
        //Если что то в user[id] находится, то присваиваем сессии элементы пользователя
        if (isset($user[id])) {
            if(isset($user_email[id])){
                return 'email';
            }
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
            mail("ryzhov.is@mail.ru", "Новый пользователь", "Новая регистрация!");
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
            //print_r($_FILES);
            return 2;
        }
        else {
            $add_to_socio = $_POST[add_socio];
            $desc_name = $_POST[desc_name];
            $desc_city = $_POST[desc_city];
            $desc_text = $_POST[desc_text];
            $desc_mail = $_POST[desc_mail];
            
            $queryLostPost = "INSERT INTO `lost_post` VALUES(NULL, '$user_id', '$desc_name', '$src', '$desc_text', '$desc_city', '$desc_mail', NULL, 0);";
            if ($add_post = $db->exec($queryLostPost)) {
                mail("ryzhov.is@mail.ru", "Новое объявление", "Добавлен новый пост! Добавление в соц сети: $add_to_socio . Наименование: $desc_name");
                return true;
            }
            else {
            return false;
            }
            
        }

    }
    public function addFindPost($user_id) {
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
            //print_r($_FILES);
           
            return 2;
        }
        else {
            $add_to_socio = $_POST[add_socio];
            $desc_name = $_POST[desc_name];
            $desc_city = $_POST[desc_city];
            $desc_text = $_POST[desc_text];
            $desc_mail = $_POST[desc_mail];
            
            $queryFindPost = "INSERT INTO `find_post` VALUES(NULL, '$user_id', '$src', '$desc_text', '$desc_name', 0, '$desc_city', '$desc_mail', NULL);";
            if ($add_post = $db->exec($queryFindPost)) {
                mail("ryzhov.is@mail.ru", "Новое объявление о пристройстве.", "Добавлен новый пост о пристройстве! Добавление в соц сети: $add_to_socio . Наименование: $desc_name");
                return true;
            }
            else {
            return false;
            }
            
        }
    }

    public function editPost($user_id) {
        include "config/pdo.php";
        /*
        echo "<pre>";
        print_r($_POST);
        echo "</pre>";
        */
        $desc_name = $_POST[header];
        $desc_city = $_POST[city];
        $desc_text = $_POST[main_text];
        $desc_mail = $_POST[user_mail];
        $post_id = $_POST[post_id];

        $queryEditPost = "UPDATE `lost_post` SET `header` = '$desc_name', `text` = '$desc_text', `city` = '$desc_city', `contact`='$desc_mail'  WHERE `id` = '$post_id'";

        if ($edit_post = $db->exec($queryEditPost)) {
            return true;
        }
        else {
             return false;
        }
        
    }

    public function editFindPost($user_id) {
        include "config/pdo.php";
        /*
        echo "<pre>";
        print_r($_POST);
        echo "</pre>";
        */
        $desc_name = $_POST[header];
        $desc_city = $_POST[city];
        $desc_text = $_POST[main_text];
        $desc_mail = $_POST[user_mail];
        $post_id = $_POST[post_id];

        $queryEditPost = "UPDATE `find_post` SET `header` = '$desc_name', `text` = '$desc_text', `city` = '$desc_city', `contact`='$desc_mail'  WHERE `id` = '$post_id'";

        if ($edit_post = $db->exec($queryEditPost)) {
            return true;
        }
        else {
             return false;
        }
        
    }

    public function deletePost() {
        include "config/pdo.php";
        $post_id = $_POST[post_id];
        $queryDelPost = "DELETE FROM `lost_post` WHERE `id` = '$post_id'";

        if ($del_post = $db->exec($queryDelPost)) {
            return true;
        }
        else {
             return false;
        }
    }

    public function deleteFindPost() {
        include "config/pdo.php";
        $post_id = $_POST[post_id];
        $queryDelPost = "DELETE FROM `find_post` WHERE `id` = '$post_id'";

        if ($del_post = $db->exec($queryDelPost)) {
            return true;
        }
        else {
             return false;
        }
    }

    public function changeUserData() {
        include "config/pdo.php";
        $new_name=$_POST[name];
        $new_email = $_POST[email];
        $user_id = $_POST[id];

        $queryEditUserInfo = "UPDATE `users` SET `name` = '$new_name', `email` = '$new_email' WHERE `id` = '$user_id'";
        if ($change_info = $db->exec($queryEditUserInfo)) {
            $_SESSION[name] = $new_name;
            return true;
        }
        else {
             return false;
        }
    }

    public function changePassword() {
        include "config/pdo.php";
        $user_id = $_POST[id];
        $old_pass = md5($_POST[old_pass]);
        $check = $db -> prepare("SELECT * FROM users WHERE pass='$old_pass';");
        $check->execute();
        $user = $check->fetch();

        if(isset($user[pass])) {
            $new_pass = md5($_POST[new_pass]);
            $query_new_pass = "UPDATE `users` SET `pass` = '$new_pass' WHERE `id` = '$user_id';";

            if ($change_pass = $db->exec($query_new_pass)) {
                return true;
            }
            else {
                return false;
            }
        }
        else {
            return false;
        }
    }
    


    public function retrivePass() {
        include "config/pdo.php";
     
        $email=$_POST['email'];
        $query_get_user = "SELECT * FROM users WHERE `email` = '$email';";
        $check = $db -> prepare($query_get_user);
        $check->execute();
        $get_user = $check->fetch();
        if($get_user[email]){
            
            $to = $get_user[email];
            $name = $get_user[name];

            $checkNum = rand();
            
            $link = 'pet-alert.ru/main_controller.php?setNewPass='.$checkNum.'&email='.$to;
            
           

            // тема письма
            $subject = 'Восстановление пароля на сайте Pet-Alert.ru';
    
            // текст письма
            $message = '
            <html>
            <head>
            <title>Восстановление пароля на сайте Pet-Alert.ru</title>
            </head>
            <body>
            <p>
            '.$name.',<br>
            Вы только что запросили восстановление пароля на сайте Pet-Alert.ru.<br>
            Что бы восстаоновить пароль пройдите по этой <a href='.$link.'>ссылке</a> и укажите проверочное число '.$checkNum.'.<br><br>
            Если Вы не запрашивали восстановления пароля, то просто игнорируйте данное письмо.
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
          
            return true;
            
        }
        else {
            return false;
        }
        
    }

    public function setNewUserPass() {
        include "config/pdo.php";
        $check1 = $_POST[checkSet];
        $check2 = $_POST[checkNum];
        if ($check1 == $check2) {
            $pass = $_POST[pass];
            $new_pass = md5($_POST[pass]);
            $email = $_POST[email];
            $query_set_pass = "UPDATE `users` SET `pass` = '$new_pass' WHERE `email` = '$email';";

            if ($change_pass = $db->exec($query_set_pass)) {

                // тема письма
                $subject = 'Смена пароля на сайте Pet-Alert.ru';
        
                // текст письма
                $message = '
                <html>
                <head>
                <title>Смена пароля на сайте Pet-Alert.ru</title>
                </head>
                <body>
                <p>
                Вы только что изменили пароля на сайте Pet-Alert.ru.<br>
                Ваш новый пароль '.$pass.' .<br><br>
                Если Вы не запрашивали восстановления пароля, то свяжитесь с администрацией сайта.
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
                mail($email, $subject, $message, $headers);

                return true;
            }
            else {
                return false;
            }

        }
        else {
            return 'not equal';
        }
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