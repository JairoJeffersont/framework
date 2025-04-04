<?php

use Framework\App;
use Framework\Controllers\UserController;

return function(App $app) {
    $controller = new UserController();

    $app->get('/users', [$controller, 'listAll']);
};
