<?php

namespace Framework\Models;

use Framework\Config\Connection;
use PDO;

/**
 * Class Model
 *
 * A simple base model class to perform common database operations (CRUD).
 * Designed to be extended or used directly with a specified table name.
 *
 * @package Framework\Models
 */
class Model {
    /**
     * The name of the database table.
     *
     * @var string
     */
    protected string $table;

    /**
     * Model constructor.
     *
     * @param string $table The name of the database table to interact with.
     */
    public function __construct(string $table) {
        $this->table = $table;
    }

    /**
     * Retrieves all records from the table.
     *
     * @param string $orderBy The column to sort by (default: 'id').
     * @param string $order   Sort direction: 'ASC' or 'DESC' (default: 'ASC').
     *
     * @return array An array of records.
     */
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

    /**
     * Finds a single record by a given column and value.
     *
     * @param string $column The column to search by.
     * @param int    $value  The value to match.
     *
     * @return array|false The found record as an associative array, or false if not found.
     */
    public function find(string $column, int $value): array|false {
        $pdo = Connection::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM {$this->table} WHERE {$column} = ?");
        $stmt->bindParam(1, $value, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Inserts a new record into the table.
     *
     * @param array $data An associative array of column => value pairs.
     *
     * @return bool True on success, false on failure.
     */
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

    /**
     * Updates an existing record in the table.
     *
     * @param string $column The column to identify the record (usually 'id').
     * @param int    $id     The value to match for update.
     * @param array  $data   An associative array of column => value pairs to update.
     *
     * @return bool True on success, false on failure.
     */
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

    /**
     * Deletes a record from the table by ID.
     *
     * @param int $id The ID of the record to delete.
     *
     * @return bool True on success, false on failure.
     */
    public function delete(int $id): bool {
        $pdo = Connection::getConnection();
        $stmt = $pdo->prepare("DELETE FROM {$this->table} WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
