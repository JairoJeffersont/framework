<?php

namespace Framework\Controllers;

use Framework\Models\UserModel;
use function Framework\Utils\responseJson;

class UserController {
    public function listAll(): string {
        $users = UserModel::all();
        return responseJson(200, $users);
    }


    public function store(): string {
        $payload = json_decode(file_get_contents('php://input'), true);
            
        $user = UserModel::store($payload);
    
        return responseJson(201, [
            'id' => $user->id,
            'name' => $user->name
        ]);
    }
}
