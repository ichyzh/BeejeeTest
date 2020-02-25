<?php

namespace App\Models;
use App\core\Model;
use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;



class Task extends Model
{
    public function getAll(array $pagination) :array
    {
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'id';
        $order = '';
        if (!empty($_GET['order'])) {
            $order = $_GET['order'] == 'desc' ? 'DESC' : 'ASC';
        }

        $sql = "SELECT * FROM `tasks`
            ORDER BY {$sort} {$order}
            LIMIT {$pagination['this_page_result']}, {$pagination['number_of_posts']}";

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

    public function create(array $request) :array
    {
        $validator = v::key('username', v::stringType()->length(3,10))
            ->key('email', v::email())
            ->key('task', v::stringType()->notEmpty());

        $errors = [];
        try {
            $validator->assert($request);
        } catch(NestedValidationException $e) {
            $errors = $e->findMessages([
                'username' => '{{name}} length must be between 3 and 10 chars ',
                'email' => '{{name}} must be a valid email',
                'task' => '{{name}} is required'
            ]);
        }

        if (!empty($errors)) {
            return $errors;
        }
        $params = [
            'username' => htmlspecialchars($request['username']),
            'email' => $request['email'],
            'text' => htmlspecialchars($request['task'])
        ];

        $sql = "INSERT INTO `tasks`(`username`, `email`, `text`)
            VALUES (:username, :email, :text)";

        $this->dbh->dbQuery($sql, $params);

        return [];
    }

    public function update(array $request) :array
    {
        $validator = v::key('task', v::stringType()->notEmpty());

        $errors = [];
        try {
            $validator->assert($request);
        } catch(NestedValidationException $e) {
            $errors = $e->findMessages([
                'task' => '{{name}} is required',
            ]);
        }

        if (!empty($errors)) {
            return $errors;
        }
      
        $params = [
            'text' => htmlspecialchars($request['task']),
            'id' => $request['id'],
            'status' => isset($request['status']) ? 'Y' : 'N',
            'is_edit' => 'N'
        ];

        $item = $this->getItem($request['id']);
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

        return [];
    }

    public function pagination() :array 
    {
        $pagination = [];
        $number_of_posts = 3;

        $sql = "SELECT * FROM `tasks`";
        $res = $this->dbh->dbQuery($sql);

        $number_of_photos = $res->rowCount();
        $number_of_pages = ceil($number_of_photos/$number_of_posts);

        $page = isset($_GET['page']) ? $_GET['page'] : 1;

        $this_page_result = ($page - 1)*$number_of_posts;
        $pagination = [
            'number_of_pages' => $number_of_pages,
            'number_of_posts' => $number_of_posts,
            'this_page_result' => $this_page_result
        ];

        return $pagination;
    }
}