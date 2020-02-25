<?php

namespace App\core;
use App\core\Db;

abstract class Model
{
    public $dbh;

    public function __construct()
    {
        $this->dbh = new Db();
    }
}