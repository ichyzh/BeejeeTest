<?php

namespace App\Controllers;

use App\core\Controller;
use App\core\View;
use App\Models\User;

class UserController extends Controller
{
    public function actionSingIn()
    {
        return $this->view->render('login.twig');
    }

    public function actionLogin()
    {
        if (!isset($_POST['submit'])) {
            View::errorCode(404);
        }
        $user = new User();

        $errors = $user->login($_POST);
        if (!empty($errors)) {
            return $this->view->render('login.twig', [
                'errors' => $errors
            ]);
        }

        return $this->view->redirect('/' .ROOT . '/');
    }

    public function actionLogout()
    {
        session_destroy();

        return $this->view->redirect('/' .ROOT . '/');
    }
}