<?php

declare(strict_types=1);

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Factory\AppFactory;
use App\Controller\TodoController;

$dirname = __DIR__;

require $dirname . '/../vendor/autoload.php';
require $dirname . '/../App/Storage/Database.php';

$app = AppFactory::create();

require $dirname . '/../App/Route/Todo.php';


$app->run();