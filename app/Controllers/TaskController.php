<?php

namespace App\Controllers;
use App\core\Controller;
use App\core\View;
use App\Models\Task;
use App\Models\User;

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
            $task->create($_POST);
            var_dump('ok');
        }
    }

    public function actionEdit()
    {
        $user = new User();
        if (!$user->isAuthorized()) {
            View::errorCode(403);
        }

        $item = new Task();
        $task = $item->getItem($this->route['id']);

        if (empty($item)) {
            View::errorCode(404);
        }

        return $this->view->render('create.twig', [
            'task' => $task
        ]);
    }

    public function actionUpdate()
    {
        if (!isset($_POST['submit'])) {
            View::errorCode(404);
        }

        $item = new Task();

        $item->update($_POST);

        return $this->view->redirect('/' .ROOT . '/');
    }
}