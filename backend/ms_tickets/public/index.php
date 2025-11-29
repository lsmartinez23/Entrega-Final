<?php
use Slim\Factory\AppFactory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

// Mostrar errores
$app->addErrorMiddleware(true, true, true);

// Leer JSON del body
$app->addBodyParsingMiddleware();

// BD y rutas
require __DIR__ . '/../app/Config/database.php';
require __DIR__ . '/../app/Config/routes.php';

// CORS
$app->options('/{routes:.+}', function (ServerRequestInterface $request, ResponseInterface $response) {
    return $response;
});

$app->add(function (ServerRequestInterface $request, $handler): ResponseInterface {
    $response = $handler->handle($request);

    return $response
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization, token')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
});

$app->run();

