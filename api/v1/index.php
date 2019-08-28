<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

require '../../vendor/autoload.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$settings = require '../../app/settings.php';
$app = new \Slim\App($settings);

$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
        // ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Origin', 'http://localhost:8080')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST');
});

$container = $app->getContainer();
//Se guardan las credenciales de acceso a la BD
require '../../app/dependencies.php';
// Importamos nuestras rutas
require '../../app/routes.php';
// Importamos el middleware
require '../../app/middleware.php';

$app->run();
