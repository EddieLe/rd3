<?php

class MyPDO
{
    private $dbHost = 'localhost';
    private $dbUser = 'root';
    private $dbPass = '';
    private $dbName = 'Api';
    public $pdoConnect = null;

    function __construct()
    {
        try {
            $pdo = new PDO(
                "mysql:host=" . $this->dbHost . ";dbname=" . $this->dbName,
                $this->dbUser,
                $this->dbPass,
                [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"]
            );
        } catch(PDOException $e) {
            echo "Connection Failed ! " . $e->getMessage();
        }
        $this->pdoConnect = $pdo;
        $pdo = null;
    }
}
