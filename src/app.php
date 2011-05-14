<?php

require_once('bootstrap.php');

use Symfony\Component\HttpFoundation\Response;

$app = new Silex\Application();

$app->register(new Silex\Extension\TwigExtension(), array(
    'twig.path'       => __DIR__.'/views',
    'twig.class_path' => __DIR__.'/../vendor/twig/lib',
));

//$app->error(function (\Exception $e) {echo $e;
//    return new Response('We are sorry, but something went terribly wrong.', 500);
//});

// Dashboard
$app->get('/', function () use ($app) {
    
    return $app['twig']->render('dashboard.twig', array(
        
    ));
    
});

// Handle content items
$items = new Silex\LazyApplication(__DIR__.'/items.php');
$app->mount('items', $items);


return $app;