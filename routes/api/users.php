<?php

use Framework\App;
use Framework\Controllers\UserController;

/**
 * Register user-related routes.
 *
 * This function defines all the routes related to user operations, such as:
 * - Listing all users
 * - Finding a user by ID
 * - Creating a new user
 * - Updating an existing user
 * - Deleting a user
 *
 * @param App $app The application instance used to register routes.
 *
 * @return void
 */
return function (App $app) {

    $controller = new UserController();

    $app->get('/users', [$controller, 'listAllUsers']);
    $app->get('/users/{id}', [$controller, 'findUser']);
    $app->put('/users/{id}', [$controller, 'updateUser']);
    $app->post('/users', [$controller, 'newUser']);
    $app->delete('/users/{id}', [$controller, 'deleteUser']);
};
