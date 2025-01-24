<?php

declare(strict_types=1);

namespace App\Route;

use App\Controllers\TodoController;
use Slim\Factory\AppFactory;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app = AppFactory::create();

// Handle preflight requests
$app->options('/{routes:.+}', function (Request $request, Response $response, array $args) {
    return $response;
});

$app->get('/todo/api/tasks/{id:[0-9]+}', [TodoController::class, 'getTask']);
$app->get('/todo/api/tasks', [TodoController::class, 'getTasks']);
$app->post('/todo/api/tasks', [TodoController::class, 'createTask']);
$app->post('/todo/api/task', [TodoController::class, 'updateTask']);
$app->delete('/todo/api/task/{id:[0-9]+}', [TodoController::class, 'deleteTask']);