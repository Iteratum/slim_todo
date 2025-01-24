<?php

declare(strict_types=1);

namespace App\Requests;

use App\APIResource\APIResource;
use App\Models\TodoModel;
use Slim\Psr7\Response;

class UpdateRequest {

    private APIResource $resource;
    private TodoModel $create_task;

    public function __construct() {
        $this->resource = new APIResource();
        $this->create_task = new TodoModel();
    }

public function validate(Response $response, array $args): ?Response {
    foreach ($args as $key => $value) {
        if (is_null($value) || empty($value)) {
            $validation_message = ["error" => "$key is empty"];
            $json = $this->resource->jsonResponse($response, $validation_message, 400);
            return $json;
        }
    }

    // Call the create method
    $this->create_task->update($args);

    // Return a success response
    $success_message = ["message" => "Task updated successfully"];
    $json = $this->resource->jsonResponse($response, $success_message, 201);
    return $json;
}
}