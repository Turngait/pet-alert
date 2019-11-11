<?php
require_once 'modules/db.trait.php';

class Page {
  private $user_id;
  private $user_name;
  private $db;

  public function __construct($id = '', $name = '', $db = null)
  {
    $this->user_id = $id;
    $this->user_name = $name;
    $this->db = $db; 
  }

  use t_DB;

  protected function render($filename = 'start.tmpl', $data = [])
  {
    //открываем буфферизацию
    ob_start();
    // Подгружаем и активируем автозагрузчик Twig-а
    require_once 'Twig/Autoloader.php';
    Twig_Autoloader::register();
    try {
    // папка шаблонов
    $loader = new Twig_Loader_Filesystem('templates');
    // Инициализируем Twig
    $twig = new Twig_Environment($loader);
    // Подгружаем шаблон
    $template = $twig->loadTemplate($filename);
    // Передаем в шаблон переменные и значения
    // Выводим сформированное содержание
    echo $template->render($data);
    } catch (Exception $e) {
    die ('ERROR: ' . $e->getMessage());
    }

    //возвращаем все что оказалось в буффере.
    echo ob_get_clean();
  }

  public function startPage() 
  {
    $data = [
      'user_id' => $this->user_id,
      'user_name' =>$this->user_name
    ];

    $this->render('start.tmpl', $data);
  }

  public function articlesPage()
  {
    if(isset($_COOKIE['policy_check'])) {
      $policy_check = 1;
    }
    else {
      setcookie('policy_check', 'checked', time()+3600*24);
      $policy_check = 0;
    }

    $articles = $this->getSimpleInfoOrderByInt($this->db, 'blog_posts', 'id');
    $tags = $this->getSimpleInfo($this->db, 'tags');
    $blog_tags = $this->getSimpleInfo($this->db, 'blog_tags');
    $categories = $this->getSimpleInfo($this->db, 'category');

    $date = [];
    foreach ($articles as $post) {
        $date_new = date_parse($post['created_at']);
        array_push($date, $date_new);
    }

    $data_arr = [
      'user_id' => $_SESSION['id'],
      'user_name' =>$_SESSION['name'],
      'user_status' => $_SESSION['status'],
      'articles' => $articles,
      'date' => $date,
      'tags'=>$tags,
      'blog_tags' => $blog_tags,
      'categories' => $categories,
      'policy_check' => $policy_check
    ];

    $this->render('articles.tmpl', $data_arr);
  }

  public function getArticle()
  {
    if(!isset($_GET['id'])){
      header('Location: /page.php?open=articlesPage');
    }

    if(isset($_COOKIE['policy_check'])) {
      $policy_check = 1;
    }
    else {
      setcookie('policy_check', 'checked', time()+3600*24);
      $policy_check = 0;
    }

    $article_id = (int)$_GET['id'];

    $article = $this->getWhereIntInfo($this->db, 'blog_posts', 'id', $article_id);
    $tags = $this->getSimpleInfo($this->db, 'tags');
    $blog_tags = $this->getSimpleInfo($this->db, 'blog_tags');
    $categories = $this->getSimpleInfo($this->db, 'category');
    $photos = $this->getWhereIntInfo($this->db, 'blog_photos', 'id_article', $article_id, true);
    $data = date_parse($article['created_at']);

    //Increase view count
    $article_views = $article['views'] + 1;
    $add_views = $this->db->prepare("UPDATE `blog_posts` SET `views`=$article_views WHERE `id` = $article_id;");
    if ($add_views->execute()) {
      $article['views'] = $article_views;
    }

    $data_arr = [
      'user_id' => $_SESSION['id'],
      'user_name' =>$_SESSION['name'],
      'user_status' => $_SESSION['status'],
      'article' => $article,
      'date' => $data,
      'tags'=>$tags,
      'blog_tags' => $blog_tags,
      'categories' => $categories,
      'photos' => $photos,
      'policy_check' => $policy_check
    ];

    $this->render('article_page.tmpl', $data_arr);
  }

  public function addArticle()
  {
    $query_get_category = "SELECT * FROM `category`;";
    $get = $this->db->prepare($query_get_category);
    $get->execute();
    $categories = $get->fetchAll();

    $data_arr = [
      'user_id' => $_SESSION['id'],
      'user_name' =>$_SESSION['name'],
      'user_status' => $_SESSION['status'],
      'categories' => $categories,
      'policy_check' => $policy_check
    ];

    $this->render('add_article.tmpl', $data_arr);
  }

  public function editArticle()
  {
    if(!isset($_GET['id'])){
      header('Location: /page.php?open=articlesPage');
    }

    $article_id = (int)$_GET['id'];

    $article = $this->getWhereIntInfo($this->db, 'blog_posts', 'id', $article_id);
    $tags = $this->getSimpleInfo($this->db, 'tags');
    $blog_tags = $this->getSimpleInfo($this->db, 'blog_tags');
    $categories = $this->getSimpleInfo($this->db, 'category');
    $photos = $this->getWhereIntInfo($this->db, 'blog_photos', 'id_article', $article_id, true);
    $date = date_parse($article['created_at']);

    $data_arr = [
      'user_id' => $_SESSION['id'],
      'user_name' =>$_SESSION['name'],
      'user_status' => $_SESSION['status'],
      'article' => $article,
      'date' => $date,
      'tags'=>$tags,
      'blog_tags' => $blog_tags,
      'categories' => $categories,
      'photos' => $photos,
      'policy_check' => $policy_check
    ];

    $this->render('edit_article.tmpl', $data_arr);
  }

  public function getByTags()
  {
    if(!isset($_GET['tag'])){
      header('Location: /page.php?open=articlesPage');
    }
    $id_tag = $_GET['tag'];
    $articles_id = $this->getWhereIntInfo($this->db, 'blog_tags', 'id_tag', $id_tag, true);
    $articles = [];

    foreach ($articles_id as $key => $value) {
      $get_article = $this->getWhereIntInfo($this->db, 'blog_posts', 'id', $value['article_id']);
      if(!$get_article) {
        continue;
      }
      $articles[] = $get_article;
    }

    $articles = array_reverse($articles);

    $tags = $this->getSimpleInfo($this->db, 'tags');
    $blog_tags = $this->getSimpleInfo($this->db, 'blog_tags');
    $categories = $this->getSimpleInfo($this->db, 'category');

    $date = [];
    foreach ($articles as $post) {
        $date_new = date_parse($post['created_at']);
        array_push($date, $date_new);
    }

    $dates = [
      'user_id' => $_SESSION['id'],
      'user_name' =>$_SESSION['name'],
      'user_status' => $_SESSION['status'],
      'articles' => $articles,
      'date' => $date,
      'tags'=>$tags,
      'blog_tags' => $blog_tags,
      'categories' => $categories

    ];
    $this->render('articles.tmpl', $dates);
  }

  public function postsPage()
  {
    //$_COOKIE['policy_check'] - кукисы для проверки, видел ли пользователь
    //предупреждение про исп кукисов на сайте. хранятся - 1 день
    if(isset($_COOKIE['policy_check'])) {
        $policy_check = 1;
    }
    else {
        setcookie('policy_check', 'checked', time()+3600*24);
        $policy_check = 0;
    }

    $quary = "SELECT * FROM lost_post ORDER BY id DESC;";
    $posts = $this->db->prepare($quary);
    $posts->execute();

    $arr = $posts->fetchAll();

    $quaryFindPosts = "SELECT * FROM find_post ORDER BY id DESC;";
    $postsFind = $this->db-> prepare($quaryFindPosts);
    $postsFind->execute();

    $arrFind = $postsFind->fetchAll();

    $date = [];
    $dateFind=[];
    foreach ($arr as $post) {
        $date_new = date_parse($post['created_at']);
        array_push($date, $date_new);
    }
    foreach ($arrFind as $post) {
        $date_new = date_parse($post['created_at']);
        array_push($dateFind, $date_new);
    }

    $data_arr = [
      'user_id' => $_SESSION['id'],
      'user_name' =>$_SESSION['name'],
      'user_status' => $_SESSION['status'],
      'posts' => $arr,
      'date' => $date,
      'postsFind' => $arrFind,
      'dateFind' => $dateFind,
      'policy_check' => $policy_check
    ];

    $this->render('desc.tmpl', $data_arr);
  }

  public function userAccaunt()
  {
    if(!isset($this->user_id)) {
      header('Location: /');
    }
    //Получаем посты и дату с объявлений о поиске

    $quary = "SELECT * FROM lost_post WHERE user_id = $this->user_id ORDER BY id DESC;";
    $quary_user_data = "SELECT * FROM users WHERE id = $this->user_id";
    $posts = $this->db -> prepare($quary);
    $posts->execute();
    $user_data = $this->db->prepare($quary_user_data);
    $user_data->execute();

    $arr = $posts->fetchAll();
    $arr_user_data = $user_data->fetchAll();

    $date = [];
    foreach ($arr as $post) {
        $date_new = date_parse($post['created_at']);
        array_push($date, $date_new);
    }

    //Получаем посты и дату с объявлений о пристройстве

    $quaryFind = "SELECT * FROM find_post WHERE user_id = $this->user_id ORDER BY id DESC;";
    $postsFind = $this->db -> prepare($quaryFind);
    $postsFind->execute();

    $arrFind = $postsFind->fetchAll();

    $dateFind = [];
    foreach ($arrFind as $postFind) {
        $date_newFind = date_parse($postFind['created_at']);
        array_push($dateFind, $date_newFind);
    }

    $data_arr = [
      'user_id' => $this->user_id,
      'user_name' =>$this->user_name,
      'posts' => $arr,
      'date' => $date,
      'dateFind' => $dateFind,
      'postsFind' => $arrFind,
      'user_data' => $arr_user_data
    ];

    $this->render('user_acc.tmpl', $data_arr);
  }

  public function loginPage($info)
  {
    $data_arr= [
      'user_id' => $this->user_id,
      'user_name' =>$this->user_name,
      'info' => $info
    ];

    $this->render('login.tmpl', $data_arr);
  }

  public function showInfo($info, $link)
  {
    $data_arr = [
      'user_id' => $this->user_id,
      'user_name' =>$this->user_name,
      'info' => $info,
      'link' => $link
    ];

    $this->render('get_info.tmpl', $data_arr);
  }

  public function aboutPage()
  {
    $data_arr = [
      'user_id' => $this->user_id,
      'user_name' =>$this->user_name
    ];

    $this->render('about.tmpl', $data_arr);
  }

  public function privacyPage()
  {
    $data_arr = [
      'user_id' => $this->user_id,
      'user_name' =>$this->user_name
    ];

    $this->render('policy.tmpl', $data_arr);
  }

  public function retrivePass($info = '')
  {
    $data_arr = [
      'info' => $info
    ];

    $this->render('retrivePass.tmpl', $data_arr);
  }

  public function setNewPass() 
  {
    $token = $_GET['token'];
    $email = $_GET['email'];

    $data_arr = [
      'token' => $token
    ];
    $this->render('setNewPass.tmpl', $data_arr);
  }
}