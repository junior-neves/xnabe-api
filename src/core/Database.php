<?php

namespace Core;

use PDO;

class Database
{

    private ?PDO $PDO = null;

    private static ?Database $instance = null;

    private const SQL_SERVER = 'mysql';
    private const SQL_USER = 'root';
    private const SQL_PASSWORD = 'root';

    private const DATABASE = 'ebanx';

    private function __construct()
    {
        try {
            $this->PDO = new PDO(
                'mysql:dbname=' . self::DATABASE . ';host=' . self::SQL_SERVER,
                self::SQL_USER,
                self::SQL_PASSWORD
            );
            $this->PDO->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo 'Erro :' . $e->getMessage();
        }
    }

    public static function getInstance(): Database
    {
        if (is_null(self::$instance)) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function prepare($sql): \PDOStatement
    {
        return $this->PDO->prepare($sql);
    }

    public function query($sql): \PDOStatement
    {
        return $this->PDO->query($sql);
    }
}
