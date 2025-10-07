<?php

namespace Src\Database;

class MySQL{
    private static ?PDO $connection = null;

    private function __construct() {}

    public static function connect(): PDO{

        if(self::$connection === null){
            require __DIR__."/../../config/database.php";

            $dsn = 'mysql:host='.HOST.';dbname='.DBNAME.';charset=utf8mb4';

            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            try {
                self::$connection = new PDO($dsn,   USER, PASSWORD, $options);

            } catch (PDOException $e) {
                error_log($e->getPrevious()->getMessage());
                throw new \RuntimeException('Database connection error!', 0, $e);
            }
        }

        return self::$connection;
    }
}


