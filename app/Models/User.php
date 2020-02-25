<?php

namespace App\Models;

use App\core\Model;

class User extends Model
{
    public function login(array $request) :array
    {
        $params = [
            'username' => $request['username'],
            'password' => $request['password']
        ];

        $sql = "SELECT * FROM `users` WHERE `username`= :username'";
        $user = $this->dbh->row($sql, $params);

        if (empty($user)) {
            echo 'Wrong Login';
            exit();
        }

        if (hash('whirlpool', $request['password']) == $user['password']) {
            $_SESSION['signed'] = true;
        } else {
            var_dump('wrong pwd');
            exit();
        }

        return [];
    }

    public function isAuthorized() :bool
    {
        return isset($_SESSION['signed']);
    }
}