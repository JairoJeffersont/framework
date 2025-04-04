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


    public function find(array $params): string {
        $id = $params['id'] ?? null;

        if (!$id) {
            return responseJson(400, ['message' => 'Invalid ID']);
        }

        $user = UserModel::find($id);

        if (!$user) {
            return responseJson(404, ['message' => 'User not found']);
        }

        return responseJson(200, [
            'id' => $user->id,
            'name' => $user->name
        ]);
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
