<?php
/*
    Модуль рендеринга
*/
session_start();

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

function showDesc() {
        include "config/pdo.php";
        $quary = "SELECT * FROM lost_post ORDER BY id DESC;";
        $posts = $db -> prepare($quary);
        $posts->execute();

        $arr = $posts->fetchAll();
        //print_r($arr);
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
            'posts' => $arr
        ));
        } catch (Exception $e) {
        die ('ERROR: ' . $e->getMessage());
        }
    
        //возвращаем все что оказалось в буффере.
        return ob_get_clean();
}

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

?>