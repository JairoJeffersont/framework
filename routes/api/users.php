<?php

use Framework\App;
use Framework\Controllers\UserController;

return function (App $app) {

    $controller = new UserController();

    $app->get('/users', [$controller, 'listAllUsers']);
    $app->get('/users/{id}', [$controller, 'findUser']);
    $app->put('/users/{id}', [$controller, 'updateUser']);
    $app->post('/users', [$controller, 'newUser']);
    $app->delete('/users/{id}', [$controller, 'deleteUser']);
};
