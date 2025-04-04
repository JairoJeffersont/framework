<?php

namespace Framework\Models;

class UserModel {
    public int $id;
    public string $name;

    public function __construct(array $data) {
        $this->id = $data['id'];
        $this->name = $data['name'];
    }

    public static function all(): array {
        // Simulation (mock). Here you can later turn it into a query with PDO.
        return [
            new self(['id' => 1, 'name' => 'Jairo']),
            new self(['id' => 2, 'name' => 'Maria']),
        ];
    }
}
