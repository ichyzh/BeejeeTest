<?php

namespace App\Controllers;

use App\core\Controller;
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
            
        }
        $user = new User();

        $user->login($_POST);

        return $this->view->redirect('/' .ROOT . '/');
    }

    public function actionLogout()
    {
        session_destroy();

        return $this->view->redirect('/' .ROOT . '/');
    }
}