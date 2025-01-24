<?php

declare(strict_types=1);

namespace App\APIResource;

use Slim\Psr7\Response;

class APIResource {

    public function jsonResponse(Response $response, array $message, int $status = 200): Response {
        $response->getBody()->write(json_encode($message));
        return $response->withHeader('Content-Type', 'application/json')->withStatus($status);
    }
}