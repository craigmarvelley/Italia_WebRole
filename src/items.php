<?php

require_once __DIR__.'/bootstrap.php';

$app = new Silex\Application();

$app->register(new Silex\Extension\TwigExtension(), array(
    'twig.path'       => __DIR__.'/views',
    'twig.class_path' => __DIR__.'/../vendor/twig/lib',
));

// List items of content
$app->get('/', function () use ($app) {
    
    return $app['twig']->render('items/index.twig', array(
        
    ));
    
});

// Create
$app->get('/new', function () use ($app) {
    
    return $app['twig']->render('items/add.twig', array(
        
    ));
    
});

return $app;