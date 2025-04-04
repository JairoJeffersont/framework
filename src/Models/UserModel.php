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


    public static function find($id): ?self {
        // Simulation (mock). Here you can later turn it into a query with PDO.
        $users = [
            1 => ['id' => 1, 'name' => 'Jairo'],
            2 => ['id' => 2, 'name' => 'Maria']
        ];

        
        if (!isset($users[$id])) {
            return null;
        }

        return new self($users[$id]);
    }


    public static function store(array $data): self {
        // Simulation: Creates a new object with a fake ID
        $novoId = rand(100, 999); // Fake ID
        return new self([
            'id' => $novoId,
            'name' => $data['name']
        ]);
    }
}
