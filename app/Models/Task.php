<?php

namespace App\Models;
use App\core\Model;

class Task extends Model
{
    public function getAll() :array
    {
        $sql = 'SELECT * FROM `tasks`';

        $task_list = $this->dbh->all($sql);

        return $task_list;
    }

    public function save(array $request) :bool
    {
        $params = [
            'username' => $request['username'],
            'email' => $request['email'],
            'text' => $request['task']
        ];

        $sql = "INSERT INTO `tasks`(`username`, `email`, `text`)
        VALUES (:username, :email, :text)";

        $this->dbh->dbQuery($sql, $params);

        return true;
    }
}