<?php
require_once 'modules/db.trait.php';

class Guest {
  protected $db;
  use t_DB;

  public function __construct($db=null)
  {
    $this->db = $db;
  }

  public function reg($data) 
  {
    $name =  $data['user_name'];
    $login = $data['user_login'];
    $pass = md5($data['user_pass']);
    $email = $data['user_mail'];
    
    //Проверяем занят ли логин и мэил на стороне сервера
    $user = $this->checkLogin($login);
    $user_email = $this->checkEmail($email);
    
    //Если что то в user[id] находится, то такой логин и мэил заняты
    if (isset($user[id])) {
        if(isset($user_email[id])){
            return 'email';
        }
        return $user[id];
    }

    $queryNU = "INSERT INTO `users` VALUES(NULL, :name, :email, :login, :pass, NULL, 0);";
    $add_user = $this->db->prepare($queryNU);
    
    if ($add_user -> execute([':name' => $name, ':email' => $email, ':login' => $login, ':pass' => $pass])) {
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

  public function createUserHash($login) 
  {
      $queryNewUser = "SELECT `id` FROM `users` WHERE `login` = :login;";
      $get_user = $this->db -> prepare($queryNewUser);
      $get_user -> execute([':login' => $login]);
      $user = $get_user->fetch(); 
      $user_id = $user['id'];
      $hash_user = md5($login);

      $queryAddHash = "INSERT INTO `hur` VALUES($user_id, '$hash_user');";
      $add_hash = $this->db ->prepare($queryAddHash);
      $add_hash->execute();
  }

  public function login($login, $pass) 
  {
      $check = $this->db -> prepare("SELECT * FROM users WHERE login=:login and pass=:pass;");
      $check->execute([':login' => $login, ':pass' => $pass]);
      $user = $check->fetch();
      
      //Если что то в user[id] находится, то присваиваем сессии элементы пользователя
      if (isset($user['id'])) {
          $_SESSION['id'] = $user['id'];
          $_SESSION['name'] = $user['name'];
          $_SESSION['status'] = $user['status'];
          return true;
      }
      else {
          return false;
      }
  }

  public function checkLogin($login)
  {
    $check = $this->db -> prepare("SELECT * FROM users WHERE login=:login;");
    $check->execute([':login' => $login]);
    $user = $check->fetch();

    return $user;
  }

  public function checkEmail($email)
  {
    $check_email = $this->db -> prepare("SELECT * FROM users WHERE email=:email;");

    $check_email->execute([':email'=>$email]);
    $user_email = $check_email->fetch();

    return $user_email;
  }


  public function retrivePass($data) 
  {
    $email=$data['email'];
    $query_get_user = "SELECT * FROM users WHERE `email` = :email;";
    $check = $this->db -> prepare($query_get_user);
    $check->execute([':email' => $email]);
    $get_user = $check->fetch();
    
    if($get_user['email']){

        $id = $get_user['id'];

        $query_token = "SELECT * FROM `hur` WHERE id_user=$id";
        $check = $this->db->prepare($query_token);
        $check->execute();
        $token_arr = $check->fetch();
        $token=$token_arr['hash'];
        
        $to = $get_user['email'];
        $name = $get_user['name'];
        
        $link = 'pet-alert.ru/page.php?open=setNewPass&token='.$token;
        
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
        Что бы восстаоновить пароль пройдите по этой <a href='.$link.'>ссылке</a>.<br><br>
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

    public function setNewPass($data)
    {
        $pass = $data['pass'];
        $new_pass = md5($data['pass']);
        $token = $data['token'];

        $query = "SELECT * FROM `hur` WHERE hash=:token";
        $check = $this->db->prepare($query);
        $check->execute([':token' => $token]);
        $is_user = $check->fetch();

        if($is_user['id_user']){
            $id = $is_user['id_user'];
            $query_set_pass = "UPDATE `users` SET `pass` = :new_pass WHERE `id` = :id;";
            $change_pass = $this->db->prepare($query_set_pass);

            if ($change_pass->execute([':new_pass'=> $new_pass, ':id' => $id])) {

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
            return false;
        }
    }
}