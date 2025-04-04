<?php

namespace Framework\Controllers;

use Framework\Models\UserModel;
use function Framework\Utils\responseJson;

class UserController {
    public function listAll(): string {
        $users = UserModel::all();
        return responseJson(200, $users);
    }
}
