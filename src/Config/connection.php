<?php

namespace Framework\Config;

use PDO;
use PDOException;
use Dotenv\Dotenv;
use function Framework\Utils\responseJson;



class Connection {

    private static ?PDO $connection = null;

    private function __construct() {
    }


    public static function getConnection(): ?PDO {
        if (self::$connection === null) {

            $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
            $dotenv->load();

            $host = $_ENV['DB_HOST'] ?? 'localhost';
            $dbname = $_ENV['DB_NAME'] ?? '';
            $username = $_ENV['DB_USER'] ?? '';
            $password = $_ENV['DB_PASS'] ?? '';

            try {
                $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
                self::$connection = new PDO($dsn, $username, $password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_PERSISTENT => true
                ]);
            } catch (PDOException $e) {
                echo responseJson(500, [], 'Error fetching users: ' . $e->getMessage());
                exit();
                return null;
            }
        }

        return self::$connection;
    }
}
