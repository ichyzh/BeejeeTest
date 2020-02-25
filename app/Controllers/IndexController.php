<?php

namespace App\Controllers;

use App\core\Controller;
use App\Models\Task;

class IndexController extends Controller
{
    public function actionIndex()
    {
        $task = new Task();
        $pagination = $task->pagination();

        return $this->view->render('index.twig', [
            'task_list' => $task->getAll($pagination),
            'pagination' => $pagination
        ]);
    }
}