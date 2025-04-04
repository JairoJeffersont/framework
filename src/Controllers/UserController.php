<?php

namespace Framework\Controllers;

use function Framework\Utils\validateJsonBody;
use function Framework\Utils\responseJson;
use Framework\Models\UserModel;
use PDOException;
use Exception;

/**
 * Class UserController
 *
 * Handles HTTP requests related to user operations,
 * such as listing, creating, updating, and deleting users.
 *
 * @package Framework\Controllers
 */
class UserController {

    /**
     * Instance of the user model.
     *
     * @var UserModel
     */
    private UserModel $userModel;

    /**
     * UserController constructor.
     *
     * Initializes the UserModel.
     */
    public function __construct() {
        $this->userModel = new UserModel();
    }

    /**
     * Returns a list of all users.
     *
     * @return string A JSON response with the user list or error message.
     */
    public function listAllUsers(): string {
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

    /**
     * Finds a user by ID.
     *
     * @param array $params Associative array containing 'id'.
     *
     * @return string A JSON response with the user data or error message.
     */
    public function findUser(array $params): string {
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

    /**
     * Creates a new user.
     *
     * Expects a JSON body with at least the 'name' field.
     *
     * @return string A JSON response indicating success or failure.
     */
    public function newUser(): string {
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

    /**
     * Updates an existing user.
     *
     * @param array $params Associative array containing 'id'.
     *
     * @return string A JSON response indicating success or failure.
     */
    public function updateUser(array $params): string {
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

    /**
     * Deletes a user by ID.
     *
     * @param array $params Associative array containing 'id'.
     *
     * @return string A JSON response indicating success or failure.
     */
    public function deleteUser(array $params): string {
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
