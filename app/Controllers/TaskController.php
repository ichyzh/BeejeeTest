<?php

namespace App\Controllers;
use App\core\Controller;
use App\Models\Task;

class TaskController extends Controller
{
    public function actionCreate()
    {
        return $this->view->render('create.twig');
    }

    public function actionStore()
    {
        if (isset($_POST['submit'])) {
            $task = new Task();
            $task->save($_POST);
            var_dump('ok');
        }
    }
}