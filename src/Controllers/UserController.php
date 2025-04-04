<?php

namespace Framework\Controllers;

use function Framework\Utils\validateJsonBody;
use function Framework\Utils\responseJson;
use Framework\Models\UserModel;
use PDOException;
use Exception;

class UserController {

    private UserModel $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function listAll(): string {
        try {
            $users = $this->userModel->all();

            if (empty($users)) {
                return responseJson(404, [], 'No users found.');
            }

            return responseJson(200, $users);
        } catch (PDOException $e) {
            return responseJson(500, [], 'Error fetching users: ' . $e->getMessage());
        } catch (Exception $e) {
            return responseJson(500, [], 'Error fetching users: ' . $e->getMessage());
        }
    }

    public function find(array $params): string {
        $id = $params['id'] ?? null;

        try {
            $user = $this->userModel->find('id', (int)$id);

            if (!$user) {
                return responseJson(404, [], 'User not found.');
            }

            return responseJson(200, $user);
        } catch (PDOException $e) {
            return responseJson(500, [], 'Error fetching user: ' . $e->getMessage());
        } catch (Exception $e) {
            return responseJson(500, [], 'Error fetching user: ' . $e->getMessage());
        }
    }

    public function store(): string {
        try {
            validateJsonBody(['name']);
            $data = $GLOBALS['__json'];

            $this->userModel->store($data);

            return responseJson(201, [], 'User successfully created.');
        } catch (PDOException $e) {
            if (str_contains($e->getMessage(), 'Duplicate entry')) {
                return responseJson(409, [], 'User already registered');
            }
            return responseJson(500, [], 'Database error: ' . $e->getMessage());
        } catch (Exception $e) {
            return responseJson(400, [], 'Error creating user: ' . $e->getMessage());
        }
    }

    public function update(array $params): string {
        $id = $params['id'] ?? null;

        try {
            validateJsonBody(['name']);
            $data = $GLOBALS['__json'];

            $updated = $this->userModel->update('id', (int)$id, $data);

            if (!$updated) {
                return responseJson(404, [], 'User not found or not updated.');
            }

            return responseJson(200, [], 'User successfully updated.');
        } catch (PDOException $e) {
            return responseJson(500, [], 'Database error: ' . $e->getMessage());
        } catch (Exception $e) {
            return responseJson(400, [], 'Error updating user: ' . $e->getMessage());
        }
    }

    public function delete(array $params): string {
        $id = $params['id'] ?? null;

        try {
            $deleted = $this->userModel->delete((int)$id);

            if (!$deleted) {
                return responseJson(404, [], 'User not found or could not be deleted.');
            }

            return responseJson(200, [], 'User successfully deleted.');
        } catch (PDOException $e) {
            return responseJson(500, [], 'Database error: ' . $e->getMessage());
        } catch (Exception $e) {
            return responseJson(500, [], 'Error deleting user: ' . $e->getMessage());
        }
    }
}
