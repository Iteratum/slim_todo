<?php

declare(strict_types=1);

namespace App\Route;

use App\Controller\TodoController;
use Slim\Factory\AppFactory;


$app = AppFactory::create();

$app->get('/todo/api/task/{id:[0-9]+}', [TodoController::class, 'getTask']);

$app->get('/todo/api/tasks', [TodoController::class, 'getTasks']);

$app->post('/todo/api/tasks', [TodoController::class, 'createTask']);

$app->post('/todo/api/task', [TodoController::class,'updateTask']);

$app->delete('/todo/api/task/{id:[0-9]+}', [TodoController::class,'deleteTask']);