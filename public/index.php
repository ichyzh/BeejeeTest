<?php
    require "../vendor/autoload.php";

    session_start();

    use App\core\Router;

    $router = new Router();
    $router->run();