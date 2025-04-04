<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/Utils/helpers.php'; //


use Framework\App;

$app = new App();

$rotas = require __DIR__ . '/../routes/web.php';
$rotas($app);

$app->run();
