<?php
// require 'modules/user.class.php';

class Client extends User {
  public function __construct ($id, $name)
  {
    parent::__construct($id, $name);
  }

  public function addPost($data, $type)
  {
    include "config/pdo.php";

    $newFilename = $_SERVER['DOCUMENT_ROOT']. '/public/photo/';
    $uploadInfo = $_FILES['pet_photo'];
    $newFilename.= $_FILES['pet_photo']['name'];
    $src='public/photo/'.$_FILES['pet_photo']['name'];

    //Перемещаем файл из временной папки в указанную
        if (!move_uploaded_file($uploadInfo['tmp_name'], $src)) {
            return 2;
        }
        else {
            $add_to_socio = $data['add_socio'];
            $desc_name = $data['desc_name'];
            $desc_city = $data['desc_city'];
            $desc_text = $data['desc_text'];
            $desc_mail = $data['desc_mail'];

            if($type === 'lost') {
              $queryPost = "INSERT INTO `lost_post` VALUES(NULL, '$this->id', '$desc_name', '$src', '$desc_text', '$desc_city', '$desc_mail', NULL, 0);";
            }
            else if ($type === 'find') {
              $queryPost = "INSERT INTO `find_post` VALUES(NULL, '$this->id', '$src', '$desc_text', '$desc_name', 0, '$desc_city', '$desc_mail', NULL);";
            }
            
            if ($add_post = $db->exec($queryPost)) {
                mail("ryzhov.is@mail.ru", "Новое объявление", "Добавлен новый пост! Добавление в соц сети: $add_to_socio . Наименование: $desc_name");
                return true;
            }
            else {
            return false;
            }
            
        }
  }

  public function editPost($data, $type)
  {
    include "config/pdo.php";

    $desc_name = $data['header'];
    $desc_city = $data['city'];
    $desc_text = $data['main_text'];
    $desc_mail = $data['user_mail'];
    $post_id = $data['post_id'];

    if ($type === 'lost') {
      $queryEditPost = "UPDATE `lost_post` SET `header` = '$desc_name', `text` = '$desc_text', `city` = '$desc_city', `contact`='$desc_mail'  WHERE `id` = '$post_id'";
    }
    else if($type === 'find') {
      $queryEditPost = "UPDATE `find_post` SET `header` = '$desc_name', `text` = '$desc_text', `city` = '$desc_city', `contact`='$desc_mail'  WHERE `id` = '$post_id'";
    }


    if ($edit_post = $db->exec($queryEditPost)) {
      return true;
    }
    else {
      return false;
    }
  }

  public function deletePost($data, $type)
  {
    include "config/pdo.php";
    $post_id = $data['post_id'];
    if ($type === 'lost'){
      $queryDelPost = "DELETE FROM `lost_post` WHERE `id` = '$post_id'";
    }
    else if($type === 'find') {
      $queryDelPost = "DELETE FROM `find_post` WHERE `id` = '$post_id'";
    }

    if ($del_post = $db->exec($queryDelPost)) {
        return true;
    }
    else {
         return false;
    }
  }

  public function changeUserData($data)
  {
    include "config/pdo.php";
    $new_name=$data['name'];
    $new_email = $data['email'];

    $queryEditUserInfo = "UPDATE `users` SET `name` = '$new_name', `email` = '$new_email' WHERE `id` = '$this->id'";
    if ($change_info = $db->exec($queryEditUserInfo)) {
        $_SESSION[name] = $new_name;
        return true;
    }
    else {
         return false;
    }
  }

  public function changePassword($data)
  {
    include "config/pdo.php";
    $old_pass = md5($data['old_pass']);
    $check = $db -> prepare("SELECT * FROM users WHERE pass='$old_pass';");
    $check->execute();
    $user = $check->fetch();

    if(isset($user[pass])) {
        $new_pass = md5($data['new_pass']);
        $query_new_pass = "UPDATE `users` SET `pass` = '$new_pass' WHERE `id` = '$this->id';";

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
}