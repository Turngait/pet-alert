<?php
// require 'modules/user.class.php';
require_once 'modules/db.trait.php';

class Client extends User {
  use t_DB;
  
  public function __construct ($id, $name, $db=null)
  {
    parent::__construct($id, $name, $db);
  }

  public function addPost($data, $type)
  {
    include "config/pdo.php";

    $newFilename = $_SERVER['DOCUMENT_ROOT']. '/public/photo/';
    $uploadInfo = $_FILES['pet_photo'];
    $newFilename.= $_FILES['pet_photo']['name'];
    $src='public/photo/'.$_FILES['pet_photo']['name'];
    
    if ($uploadInfo['type'] != 'image/png' && $uploadInfo['type'] != 'image/jpeg') {
      return 3;
    }

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
              $queryPost = "INSERT INTO `lost_post` VALUES(NULL, :id, :desc_name, :src, :desc_text, :desc_city, :desc_mail, NULL, 0);";
            }
            else if ($type === 'find') {
              $queryPost = "INSERT INTO `find_post` VALUES(NULL, :id, :src, :desc_text, :desc_name, 0, :desc_city, :desc_mail, NULL);";
            }
            
            $add_post = $db -> prepare($queryPost);
            

            if ($add_post->execute([':id'=>$this->id, ':desc_name'=>$desc_name, ':src'=>$src, ':desc_text'=>$desc_text, ':desc_city' => $desc_city, ':desc_mail' =>$desc_mail])) {
                mail("ryzhov.is@mail.ru", "Новое объявление", "Добавлен новый пост! Добавление в соц сети: $add_to_socio . Наименование: $desc_name");
                return true;
            }
            else {
            return false;
            }
        }
  }

  public function addArticle($data, $main_photo, $files)
  {
    $src='public/articles_photo/'.$main_photo['name'];
    
    if(count($files) > 4) {
      return 'wrong ammount of files';
    }

    if ($main_photo['type'] != 'image/png' && $main_photo['type'] != 'image/jpeg') {
      return 'wrong file type';
    }

    if(!move_uploaded_file($main_photo['tmp_name'], $src)){
      return 'db problem';
    }

    $query = "INSERT INTO `blog_posts` VALUES(NULL, :heading, :txt, '$src', :id_user, :id_category, 0, 0, NULL);";
    $add = $this->db->prepare($query);
    $add->execute([':heading'=>$data['name'], ':txt'=>$data['text'], ':id_user'=>$this->id, ':id_category'=>$data['category']]);

    $id_article = $this->db->lastInsertId();

    foreach ($files as $file) {
      if(!$file['name']) {
        break;
      }
      $src = 'public/articles_photo/'.$file['name'];

      if ($file['type'] != 'image/png' && $file['type'] != 'image/jpeg') {
        return 'wrong file type';
      }
      
      if(!move_uploaded_file($file['tmp_name'], $src)){
        return 'db problem';
      }

      $query_add_photos = "INSERT INTO `blog_photos` VALUES(NULL, $id_article, '$src');";
      $add_photos = $this->db->prepare($query_add_photos);
      $add_photos->execute();
    }

    $tags = explode(',', $data['tags']);

    foreach ($tags as $tag) {

      $query_get_tag = "SELECT * FROM `tags` WHERE tag = :tag;";
      $check_tag = $this->db->prepare($query_get_tag);
      $check_tag->execute([':tag' => $tag]);
      $get_tag = $check_tag->fetch();

      if(isset($get_tag['id'])) {
        $id_tag = $get_tag['id'];
        $query_add_tags_blog = "INSERT INTO `blog_tags` VALUES($id_article, $id_tag);";
  
        $add_blog_tags = $this->db->prepare($query_add_tags_blog);

        if(!$add_blog_tags->execute()) {
          return 'db problem';
        }
      }
      else {
        $query_add_tags = "INSERT INTO `tags` VALUES(NULL, :tag);";

        $add_tags = $this->db->prepare($query_add_tags);
  
        if($add_tags->execute([':tag' => $tag])) {
          $id_tag = $this->db->lastInsertId();
          
          $query_add_tags_blog = "INSERT INTO `blog_tags` VALUES($id_article, $id_tag);";
  
          $add_blog_tags = $this->db->prepare($query_add_tags_blog);
  
          if(!$add_blog_tags->execute()) {
            return 'db problem';
          }
        }
      }

    }

    return true;
  }

  public function editArticle($data, $id)
  {
    $id = (int)$id;
    newDump($data);

    $query = "UPDATE `blog_posts` SET `heading` = :heading, `text` = :txt WHERE `id` = $id;";
    $edit_post = $this->db->prepare($query);
    if ($edit_post->execute([':heading' => $data["name"], ':txt' => $data["text"]])) {
      return true;
    }
    else {
      return false;
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
      $queryEditPost = "UPDATE `lost_post` SET `header` = :desc_name, `text` = :desc_text, `city` = :desc_city, `contact`=:desc_mail WHERE `id` = :id";
    }
    else if($type === 'find') {
      $queryEditPost = "UPDATE `find_post` SET `header` = :desc_name, `text` = :desc_text, `city` = :desc_city, `contact`=:desc_mail WHERE `id` = :id";
    }

    $edit_post = $db->prepare($queryEditPost);

    if ($edit_post->execute([':desc_name' => $desc_name, ':desc_text'=>$desc_text, ':desc_city'=>$desc_city, ':desc_mail'=>$desc_mail, ':id'=>$post_id])) {
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

    $queryEditUserInfo = "UPDATE `users` SET `name` = :new_name, `email` = :new_email WHERE `id` = :id";
    
    $change_info = $db->prepare($queryEditUserInfo);

    if ($change_info->execute([':new_name'=>$new_name, ':new_email' => $new_email, ':id'=>$this->id])) {
        $_SESSION['name'] = $new_name;
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
    $check = $db -> prepare("SELECT * FROM users WHERE pass=:old_pass;");
    $check->execute([':old_pass' => $old_pass]);
    $user = $check->fetch();

    if(isset($user[pass])) {
        $new_pass = md5($data['new_pass']);
        $query_new_pass = "UPDATE `users` SET `pass` = :new_pass WHERE `id` = :id;";
        $change_pass = $db -> prepare($query_new_pass);
        if ($change_pass->execute([':new_pass'=>$new_pass, ':id'=>$this->id])) {
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