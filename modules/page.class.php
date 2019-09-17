<?php

class Page {

  private $user_id;
  private $user_name;

  public function __construct($id = '', $name = '')
  {
    $this->user_id = $id;
    $this->user_name = $name;
  }

  public function startPage() 
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
    $template = $twig->loadTemplate('start.tmpl');
    // Передаем в шаблон переменные и значения
    // Выводим сформированное содержание
    echo $template->render(array(
        'user_id' => $this->user_id,
        'user_name' =>$this->user_name
    ));
    } catch (Exception $e) {
    die ('ERROR: ' . $e->getMessage());
    }

    //возвращаем все что оказалось в буффере.
    echo ob_get_clean();
  }

  public function postsPage()
  {
    include "config/pdo.php";

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
    $posts = $db -> prepare($quary);
    $posts->execute();

    $arr = $posts->fetchAll();

    $quaryFindPosts = "SELECT * FROM find_post ORDER BY id DESC;";
    $postsFind = $db -> prepare($quaryFindPosts);
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
    $template = $twig->loadTemplate('desc.tmpl');
    // Передаем в шаблон переменные и значения
    // Выводим сформированное содержание
    echo $template->render(array(
        'user_id' => $_SESSION['id'],
        'user_name' =>$_SESSION['name'],
        'user_status' => $_SESSION['status'],
        'posts' => $arr,
        'date' => $date,
        'postsFind' => $arrFind,
        'dateFind' => $dateFind,
        'policy_check' => $policy_check
    ));
    } catch (Exception $e) {
    die ('ERROR: ' . $e->getMessage());
    }

    //возвращаем все что оказалось в буффере.
    echo ob_get_clean();
  }

  public function userAccaunt()
  {
    include "config/pdo.php";

    //Получаем посты и дату с объявлений о поиске

    $quary = "SELECT * FROM lost_post WHERE user_id = $this->user_id ORDER BY id DESC;";
    $quary_user_data = "SELECT * FROM users WHERE id = $this->user_id";
    $posts = $db -> prepare($quary);
    $posts->execute();
    $user_data = $db->prepare($quary_user_data);
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
    $postsFind = $db -> prepare($quaryFind);
    $postsFind->execute();

    $arrFind = $postsFind->fetchAll();

    $dateFind = [];
    foreach ($arrFind as $postFind) {
        $date_newFind = date_parse($postFind['created_at']);
        array_push($dateFind, $date_newFind);
    }

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
    $template = $twig->loadTemplate('user_acc.tmpl');
    // Передаем в шаблон переменные и значения
    // Выводим сформированное содержание
    echo $template->render(array(
        'user_id' => $this->user_id,
        'user_name' =>$this->user_name,
        'posts' => $arr,
        'date' => $date,
        'dateFind' => $dateFind,
        'postsFind' => $arrFind,
        'user_data' => $arr_user_data
    ));
    } catch (Exception $e) {
    die ('ERROR: ' . $e->getMessage());
    }

    //возвращаем все что оказалось в буффере.
    echo ob_get_clean();
  }

  public function loginPage($info)
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
    $template = $twig->loadTemplate('login.tmpl');
    // Передаем в шаблон переменные и значения
    // Выводим сформированное содержание
    echo $template->render(array(
        'user_id' => $this->user_id,
        'user_name' =>$this->user_name,
        'info' => $info
    ));
    } catch (Exception $e) {
    die ('ERROR: ' . $e->getMessage());
    }

    //возвращаем все что оказалось в буффере.
    echo ob_get_clean();
  }

  public function showInfo($info, $link)
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
    $template = $twig->loadTemplate('get_info.tmpl');
    // Передаем в шаблон переменные и значения
    // Выводим сформированное содержание
    echo $template->render(array(
        'user_id' => $this->user_id,
        'user_name' =>$this->user_name,
        'info' => $info,
        'link' => $link

    ));
    } catch (Exception $e) {
    die ('ERROR: ' . $e->getMessage());
    }

    //возвращаем все что оказалось в буффере.
    echo ob_get_clean();
  }

  public function aboutPage()
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
    $template = $twig->loadTemplate('about.tmpl');
    // Передаем в шаблон переменные и значения
    // Выводим сформированное содержание
    echo $template->render(array(
        'user_id' => $this->user_id,
        'user_name' =>$this->user_name

    ));
    } catch (Exception $e) {
    die ('ERROR: ' . $e->getMessage());
    }

    //возвращаем все что оказалось в буффере.
    echo ob_get_clean();
  }

  public function privacyPage()
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
    $template = $twig->loadTemplate('policy.tmpl');
    // Передаем в шаблон переменные и значения
    // Выводим сформированное содержание
    echo $template->render(array(
        'user_id' => $this->user_id,
        'user_name' =>$this->user_name

    ));
    } catch (Exception $e) {
    die ('ERROR: ' . $e->getMessage());
    }

    //возвращаем все что оказалось в буффере.
    echo ob_get_clean();
  }
}