<?php

namespace Framework\Models;

use Framework\Config\Connection;
use PDO;

class Model {
    protected string $table;

    public function __construct(string $table) {
        $this->table = $table;
    }

    public function all(string $orderBy = 'id', string $order = 'ASC'): array {
        $pdo = Connection::getConnection();

        $allowedOrders = ['ASC', 'DESC'];
        $order = strtoupper($order);
        if (!in_array($order, $allowedOrders)) {
            $order = 'ASC';
        }

        $orderBy = preg_replace('/[^a-zA-Z0-9_]/', '', $orderBy);

        $sql = "SELECT * FROM {$this->table} ORDER BY {$orderBy} {$order}";
        $stmt = $pdo->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function find(string $column, int $value): array|false {
        $pdo = Connection::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM {$this->table} WHERE {$column} = ?");
        $stmt->bindParam(1, $value, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function store(array $data): bool {
        $pdo = Connection::getConnection();
        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));

        $stmt = $pdo->prepare("INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})");

        foreach ($data as $key => $value) {
            $stmt->bindValue(":{$key}", $value);
        }

        return $stmt->execute();
    }

    public function update(string $column, int $id, array $data): bool {
        $pdo = Connection::getConnection();
        $set = implode(", ", array_map(fn($key) => "$key = :$key", array_keys($data)));

        $stmt = $pdo->prepare("UPDATE {$this->table} SET {$set} WHERE {$column} = :id");
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":{$key}", $value);
        }

        return $stmt->execute();
    }

    public function delete(int $id): bool {
        $pdo = Connection::getConnection();
        $stmt = $pdo->prepare("DELETE FROM {$this->table} WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
