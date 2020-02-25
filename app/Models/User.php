<?php

namespace App\Models;

use App\core\Model;
use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;
class User extends Model
{
    public function login(array $request) :array
    {
        $validator = v::key('username', v::stringType()->length(3,10))
            ->key('password', v::min(3));

        $errors = [];
        try {
            $validator->assert($request);
        } catch(NestedValidationException $e) {
            $errors = $e->findMessages([
                'username' => '{{name}} length must be between 3 and 10 chars ',
                'password' => '{{name}} must have at least 3 characters',
            ]);
        }

        if (!empty($errors)) {
            return $errors;
        }

        $sql = "SELECT * FROM `users` WHERE `username`= :username";
        
        $user = $this->dbh->row($sql, [
            'username' => $request['username']
        ]);

        if (empty($user)) {
            return ['username' => 'Wrong username'];
        }

        if (hash('whirlpool', $request['password']) == $user['password']) {
            $_SESSION['signed'] = true;
        } else {
            return ['password' => 'Wrong password'];
        }

        return [];
    }

    public function isAuthorized() :bool
    {
        return isset($_SESSION['signed']);
    }
}