<?php

namespace App\core;

use App\Models\User;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class View
{
    public $path;
    public $route;
    public $layout = 'default';

    public function __construct($route)
    {
        $this->route = $route;
        $this->path = $route['controller'] . '/' . $route['action'];
    }

    public function render(string $title, array $vars = [], $pag = [])
    {
        $loader = new FilesystemLoader('../resources/views');
        $twig = new Environment($loader);

        $vars['ROOT'] = ROOT;
        $vars['user'] = new User();
        $vars['request'] = $_GET ?? [];

        echo $twig->render($title, $vars);
    }

    public static function errorCode($code)
    {
        http_response_code($code);
        echo "<div><p>Error {$code}</p></div>";
        exit;
    }

    public function redirect($url)
    {
        header("Location: " . $url);
    }
}