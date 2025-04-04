<?php

use Framework\App;
use function Framework\Utils\responseJson;


return function (App $app) {

    $app->get('/', function () {
        return responseJson(200, [], 'Hello, the API is working');
    }); 
    
    foreach (glob(__DIR__ . '/api/*.php') as $arquivoRota) {
        $registrarRotas = require $arquivoRota;
        $registrarRotas($app);
    }
};
