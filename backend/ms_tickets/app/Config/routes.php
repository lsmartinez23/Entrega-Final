<?php
use Slim\Routing\RouteCollectorProxy;
use App\Controllers\TicketController;
use App\Controllers\ComentarioController;
use App\Middleware\TokenMiddleware;

$app->group('/tickets', function (RouteCollectorProxy $group) {

    $group->post('/crear', [TicketController::class, 'crear']);


    $group->get('/mis', [TicketController::class, 'misTickets']);


    $group->get('/todos', [TicketController::class, 'listarTodos']);


    $group->post('/estado', [TicketController::class, 'cambiarEstado']);


    $group->post('/asignar', [TicketController::class, 'asignar']);


    $group->post('/comentar', [ComentarioController::class, 'comentar']);
    $group->get('/historial', [ComentarioController::class, 'historial']);

})->add(new TokenMiddleware());
