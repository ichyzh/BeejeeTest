<?php

namespace App\core;

use PDO;

class Db
{
    protected $dbh;
    protected $conf_path = 'app/config/db.php';

    public function __construct()
    {
        $config = require $this->conf_path;
        try {
            $this->dbh = new PDO($config['db_dsn'] . $config['db_name'], $config['db_user'], $config['db_password'], array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function dbQuery($sql, $params = [])
    {
        $stmt = $this->dbh->prepare($sql);
        if (!empty($params)) {
            foreach ($params as $key => $val) {
                $stmt->bindValue(':' . $key, $val);
            }
        }
        $stmt->execute();
        return $stmt;
    }

    public function row($sql, $params = []) 
    {
        $result = $this->dbquery($sql, $params);
        return $result->fetch(PDO::FETCH_ASSOC);
    }

    public function all($sql, $params = []) 
    {
        $result = $this->dbquery($sql, $params);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
}
