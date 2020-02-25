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
        if (!isset($_POST['submit'])) {
            View::errorCode(404);
        }

        $task = new Task();
        $errors = $task->create($_POST);

        if (!empty($errors)) {
            return $this->view->render('create.twig', [
                'errors' => $errors
            ]);
        }

        return $this->view->redirect('/' .ROOT . '/');

        // return $this->view->render('index.twig', [
        //     'task_list' => $task->getAll(),
        //     'message' => 'Task created successfully'
        // ]);
    }

    public function actionEdit()
    {
        $user = new User();
        if (!$user->isAuthorized()) {
            View::errorCode(403);
        }

        $item = new Task();
        $task = $item->getItem($this->route['id']);

        if (empty($task)) {
            View::errorCode(404);
        }

        return $this->view->render('create.twig', [
            'task' => $task
        ]);
    }

    public function actionUpdate()
    {
        $user = new User();
        if (!$user->isAuthorized()) {
            View::errorCode(403);
        }

        if (!isset($_POST['submit'])) {
            View::errorCode(404);
        }

        $item = new Task();
        $task = $item->getItem($this->route['id']);

        $errors = $task->update($_POST);

        if (!empty($errors)) {
            return $this->view->render('create.twig', [
                'task' => $task->getItem($this->route['id']),
                'errors' => $errors
            ]);
        }

        return $this->view->redirect('/' .ROOT . '/');
    }
}