<?php

use Framework\App;
use function Framework\Utils\responseJson;

/**
 * Register application routes.
 *
 * This function sets up the main application routes, including:
 * - A base route ('/') for API health check.
 * - Automatically loading and registering routes from the 'api/' directory.
 *
 * @param App $app The application instance used to define routes.
 *
 * @return void
 */
return function (App $app) {

    // Root route to confirm the API is running
    $app->get('/', function () {
        return responseJson(200, [], 'Hello, the API is working');
    }); 
    
    // Dynamically load all route definitions from the 'api' directory
    foreach (glob(__DIR__ . '/api/*.php') as $arquivoRota) {
        $registrarRotas = require $arquivoRota;
        $registrarRotas($app);
    }
};
