<?php

namespace Core;


use PDO;

class Database
{

    private ?\PDO $PDO = NULL;

    private static ?Database $_instance = NULL;

    const SQL_SERVER = 'mysql';
    const SQL_USER = 'root';
    const SQL_PASSWORD = 'root';

    const DATABASE = 'ebanx';

    private function __construct()
    {
        try{
            $this->PDO = new \PDO('mysql:dbname='.self::DATABASE.';host='.self::SQL_SERVER,self::SQL_USER ,self::SQL_PASSWORD);
            $this->PDO->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        }
        catch(\PDOException $e){
            echo 'Erro :'.$e->getMessage();
            die();
        }
    }

    public static function getInstance() : Database
    {
        if(is_null(self::$_instance))
        {
            self::$_instance = new Database();
        }
        return self::$_instance;
    }

    public function prepare($sql) : \PDOStatement
    {
        return $this->PDO->prepare($sql);
    }

    public function query($sql) : \PDOStatement
    {
        return $this->PDO->query($sql);
    }

    public function lastInsertId($sql) : string
    {
        return $this->PDO->lastInsertId();
    }
}