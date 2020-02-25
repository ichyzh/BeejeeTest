<?php

namespace App\Controllers;
use App\core\Controller;

class TaskController extends Controller
{
    public function actionCreate()
    {
        return $this->view->render('create.twig');
    }

    public function actionStore()
    {
        
    }
}