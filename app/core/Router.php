<?php

namespace App\core;

class Router
{
    protected $route_path = 'app/config/routes.php';
    protected $routes = [];
    protected $params = [];
    protected $root;

    public function __construct()
    {
        $site = explode("/", $_SERVER['REQUEST_URI']);
        define('ROOT', $site[1]);
        $routes = require $this->route_path;
        foreach ($routes as $key => $val) {
            $this->add($key, $val);
        }
    }

    public function add($route, $params)
    {
        $route = '#^' . $route . '$#';
        $this->routes[$route] = $params;
    }

    public function match()
    {
        $url = substr($_SERVER['REQUEST_URI'], strlen('/' . ROOT . '/'));

        if (($cutoff = strpos($url, '?')) !== false) {
            $url = substr($url, 0, $cutoff);
        }
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                foreach ($matches as $key => $match) {
                    if ($key === 'id') {
                        $params[$key] = $match;
                    }
                }
                $this->params = $params;
                return true;
            }
        }
        return false;
    }

    public function run()
    {
        if (!$this->match()) {
            View::errorCode(404);
        }

        $classpath = 'App\Controllers\\' . $this->params['controller'] . 'Controller';
        if (class_exists($classpath)) {
            $action = 'action' . $this->params['action'];
            if (!method_exists($classpath, $action)) {
                View::errorCode(404);
            } else {
                $controller = new $classpath($this->params);
                $controller->$action();
            }
        } else {
            View::errorCode(404);
        }

    }
}