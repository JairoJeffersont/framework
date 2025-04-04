<?php

namespace Framework\Config;

use PDO;
use PDOException;
use Dotenv\Dotenv;
use function Framework\Utils\responseJson;

/**
 * Class Connection
 *
 * Manages a singleton database connection using PDO.
 * Loads environment variables from a .env file using PHP Dotenv.
 *
 * @package Framework\Config
 */
class Connection {

    /**
     * The PDO connection instance.
     *
     * @var PDO|null
     */
    private static ?PDO $connection = null;

    /**
     * Private constructor to prevent instantiation.
     */
    private function __construct() {
    }

    /**
     * Returns a singleton PDO connection.
     *
     * Loads database credentials from environment variables:
     * - DB_HOST
     * - DB_NAME
     * - DB_USER
     * - DB_PASS
     *
     * On failure, returns a JSON error response and stops execution.
     *
     * @return PDO|null The PDO instance or null on failure.
     */
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
