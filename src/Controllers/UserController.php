<?php

namespace Framework\Controllers;

use function Framework\Utils\validateJsonBody;
use function Framework\Utils\responseJson;
use Framework\Models\UserModel;
use PDOException;
use Exception;


class UserController {

    public function listAll(): string {
        try {
            $users = UserModel::all();

            if (!is_array($users) || count($users) === 0) {
                return responseJson(404, [], 'No users found.');
            }

            return responseJson(200, $users);
        } catch (\PDOException $e) {
            return responseJson(500, [], 'Error fetching users: ' . $e->getMessage());
        } catch (\Exception $e) {
            return responseJson(500, [], 'Error fetching users: ' . $e->getMessage());
        }
    }


    public function find(array $params): string {
        $id = $params['id'] ?? null;

        try {
            $users = UserModel::find($id);
            if (!is_array($users) || count($users) === 0) {
                return responseJson(404, [], 'User not found.');
            }
            return responseJson(200, $users);
        } catch (\PDOException $e) {
            return responseJson(500, [], 'Error fetching users: ' . $e->getMessage());
        } catch (\Exception $e) {
            return responseJson(500, [], 'Error fetching users: ' . $e->getMessage());
        }
    }


    public function store(): string {
        try {
            validateJsonBody(['name']);

            $data = $GLOBALS['__json'];

            $user = UserModel::store($data);

            return responseJson(201, [], 'User successfully created.');
        } catch (\PDOException $e) {
            if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                return responseJson(409, [], 'User already registered');
            }
            return responseJson(500, [], 'Database error: ' . $e->getMessage());
        } catch (\Exception $e) {
            return responseJson(400, [], 'Error creating user: ' . $e->getMessage());
        }
    }
}
