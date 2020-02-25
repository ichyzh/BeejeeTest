<?php

namespace App\Controllers;

use App\core\Controller;

class IndexController extends Controller
{
    public function actionIndex()
    {
        return $this->view->render('index.twig');
    }
}