<?php

namespace Framework\Controllers;

use function Framework\Utils\validateJsonBody;


use Framework\Models\UserModel;
use function Framework\Utils\responseJson;

class UserController {
    public function listAll(): string {
        $users = UserModel::all();
        return responseJson(200, $users);
    }


    public function store(): string {
        
        validateJsonBody(['name']);

        $data = $GLOBALS['__json'];

        $user = UserModel::store($data);

        return responseJson(201, [
            'id' => $user->id,
            'name' => $user->name
        ]);
    }
}
