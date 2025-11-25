<?php
use Slim\Routing\RouteCollectorProxy;
use App\Controllers\UserController;
use App\Middleware\TokenMiddleware;

// Rutas públicas
$app->post('/usuarios/registrar', [UserController::class, 'registrar']);
$app->post('/usuarios/login', [UserController::class, 'login']);

// Rutas protegidas con token
$app->group('/usuarios', function (RouteCollectorProxy $group) {
    $group->get('/listar', [UserController::class, 'listar']);
    $group->post('/logout', [UserController::class, 'logout']);
    $group->post('/cambiar-rol', [UserController::class, 'cambiarRol']); // EXTRA OPCIONAL
})->add(new TokenMiddleware());
