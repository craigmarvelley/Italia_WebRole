<?php

require_once __DIR__.'/bootstrap.php';

$app = new Silex\Application();

$app->get('/', function () {
    return "Hello world";
});

return $app;