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

    public function getItem(int $id) :array
    {
        $sql = "SELECT * FROM `tasks` WHERE `id` = :id";

        $task = $this->dbh->row($sql, [
            'id' => $id
        ]);

        return empty($task) ? [] : $task;
    }

    public function create(array $request) :bool
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

    public function update(array $request) :bool
    {
        $item = $this->getItem($request['id']);

        if (empty($item)) {
            return false;
        }

        $params = [
            'text' => $request['task'],
            'id' => $request['id'],
            'status' => isset($request['status']) ? 'Y' : 'N',
            'is_edit' => 'N'
        ];

        if ($item['text'] != $request['task']) {
            $params['is_edit'] = 'Y';
        }

        $sql = "UPDATE `tasks` 
            SET 
                `text` = :text, 
                `status` = :status,
                `is_edit` = :is_edit
            WHERE `id` = :id";

        $this->dbh->dbQuery($sql, $params);

        return true;
    }
}