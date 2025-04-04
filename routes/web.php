<?php

use Framework\App;
use function Framework\Utils\responseJson;


return function (App $app) {


    $app->get('/', function () {
        return responseJson(200, ['status' => '200', 'message' => 'Hello, the API is working, check the documentation']);
    }); 
    
    foreach (glob(__DIR__ . '/api/*.php') as $arquivoRota) {
        $registrarRotas = require $arquivoRota;
        $registrarRotas($app);
    }
};
