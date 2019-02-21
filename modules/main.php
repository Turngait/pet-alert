<?php
/*
    Модуль рендеринга
*/
session_start();

//Отрисовывает стартовую страницу
function showMain() {
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
        'user_id' => $_SESSION[id],
        'user_name' =>$_SESSION[name]
    ));
    } catch (Exception $e) {
    die ('ERROR: ' . $e->getMessage());
    }

    //возвращаем все что оказалось в буффере.
    return ob_get_clean();
}

//Отрисовывает страницу с объявлениями
function showDesc() {
        include "config/pdo.php";
        $quary = "SELECT * FROM lost_post ORDER BY id DESC;";
        $posts = $db -> prepare($quary);
        $posts->execute();

        $arr = $posts->fetchAll();

        $quaryFindPosts = "SELECT * FROM find_post ORDER BY id DESC;";
        $postsFind = $db -> prepare($quaryFindPosts);
        $postsFind->execute();

        $arrFind = $postsFind->fetchAll();
        //print_r($arrFind);

        $date = [];
        $dateFind=[];
        foreach ($arr as $post) {
            $date_new = date_parse($post[created_at]);
            array_push($date, $date_new);
        }
        foreach ($arrFind as $post) {
            $date_new = date_parse($post[created_at]);
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
            'user_id' => $_SESSION[id],
            'user_name' =>$_SESSION[name],
            'user_status' => $_SESSION[status],
            'posts' => $arr,
            'date' => $date,
            'postsFind' => $arrFind,
            'dateFind' => $dateFind
        ));
        } catch (Exception $e) {
        die ('ERROR: ' . $e->getMessage());
        }
    
        //возвращаем все что оказалось в буффере.
        return ob_get_clean();
}


//Отрисовывает страницу с добавлением объявления
function newPost() {
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
    $template = $twig->loadTemplate('add_post.tmpl');
    // Передаем в шаблон переменные и значения
    // Выводим сформированное содержание
    echo $template->render(array(
        'user_id' => $_SESSION[id],
        'user_name' =>$_SESSION[name]

    ));
    } catch (Exception $e) {
    die ('ERROR: ' . $e->getMessage());
    }

    //возвращаем все что оказалось в буффере.
    return ob_get_clean();
}

//Личный кабнет юзера
function userAcc($user_id) {
    include "config/pdo.php";
    $quary = "SELECT * FROM lost_post WHERE user_id = $user_id ORDER BY id DESC;";
    $quary_user_data = "SELECT * FROM users WHERE id = $user_id";
    $posts = $db -> prepare($quary);
    $posts->execute();
    $user_data = $db->prepare($quary_user_data);
    $user_data->execute();

    $arr = $posts->fetchAll();
    //print_r($arr);
    $arr_user_data = $user_data->fetchAll();
    //print_r($arr_user_data);

    $date = [];
    foreach ($arr as $post) {
        $date_new = date_parse($post[created_at]);
        array_push($date, $date_new);
    }

    //Получаем посты и дату с объявлений о пристройстве

    $quaryFind = "SELECT * FROM find_post WHERE user_id = $user_id ORDER BY id DESC;";
    $postsFind = $db -> prepare($quaryFind);
    $postsFind->execute();

    $arrFind = $postsFind->fetchAll();

    $dateFind = [];
    foreach ($arrFind as $postFind) {
        $date_newFind = date_parse($postFind[created_at]);
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
        'user_id' => $_SESSION[id],
        'user_name' =>$_SESSION[name],
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
    return ob_get_clean();
}


//Открывает раздел О проекте
function showAbout() {

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
        'user_id' => $_SESSION[id],
        'user_name' =>$_SESSION[name]

    ));
    } catch (Exception $e) {
    die ('ERROR: ' . $e->getMessage());
    }

    //возвращаем все что оказалось в буффере.
    return ob_get_clean();
}


//Открывает раздел с политикой конфиденциальности
function showPolicy() {

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
        'user_id' => $_SESSION[id],
        'user_name' =>$_SESSION[name]

    ));
    } catch (Exception $e) {
    die ('ERROR: ' . $e->getMessage());
    }

    //возвращаем все что оказалось в буффере.
    return ob_get_clean();
}


//Блок восстановления пароля юзера
function retrivePass() {
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
    $template = $twig->loadTemplate('retrivePass.tmpl');
    // Передаем в шаблон переменные и значения
    // Выводим сформированное содержание
    echo $template->render(array(
    ));
    } catch (Exception $e) {
    die ('ERROR: ' . $e->getMessage());
    }

    //возвращаем все что оказалось в буффере.
    return ob_get_clean();
}

function setNewPass() {
    $checkNum = $_GET[setNewPass];
    $email = $_GET[email];
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
    $template = $twig->loadTemplate('setNewPass.tmpl');
    // Передаем в шаблон переменные и значения
    // Выводим сформированное содержание
    echo $template->render(array(
        'checkNum' => $checkNum,
        'email' =>$email
    ));
    } catch (Exception $e) {
    die ('ERROR: ' . $e->getMessage());
    }

    //возвращаем все что оказалось в буффере.
    return ob_get_clean();
}

?>