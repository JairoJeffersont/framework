<?php

use Framework\App;
use Framework\Controllers\UserController;

return function (App $app) {
    $controller = new UserController();

    $app->get('/users', [$controller, 'listAll']);
    $app->get('/users/{id}', [$controller, 'find']);
    $app->post('/users', [$controller, 'store']);
    $app->delete('/users/{id}', [$controller, 'delete']);

};
