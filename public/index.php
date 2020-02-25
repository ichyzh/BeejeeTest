<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    require "../vendor/autoload.php";

    session_start();

    use App\core\Router;

    define('ROOT_FOLD', dirname(__FILE__));

    $router = new Router();
    $router->run();