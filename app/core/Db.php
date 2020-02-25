<?php

namespace App\core;

use PDO;

class Db
{
    protected $dbh;
    protected $conf = 'app/config/db.php';

    public function __construct()
    {
        try {
            $this->dbh = new PDO($this->conf['db_dsn'] . $this->conf['db_name'], $this->conf['db_user'], $this->conf['db_password'], array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
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
