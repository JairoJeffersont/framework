<?php

namespace Framework\Models;

use Framework\Config\Connection;
use PDO;

class UserModel {

    public static function all(): array {
        $pdo = Connection::getConnection();

        $stmt = $pdo->query("SELECT * FROM users");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $results;
    }




    public static function find($id): array {
        $pdo = Connection::getConnection();

        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $results;
    }


    public static function store(array $data): bool|array {
        $pdo = Connection::getConnection();

        $stmt = $pdo->prepare("INSERT INTO users (name) VALUES (:name)");
        $stmt->bindParam(':name', $data['name'], PDO::PARAM_STR);
        return $stmt->execute();
    }
}
