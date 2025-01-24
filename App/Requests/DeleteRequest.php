<?php

declare(strict_types=1);

namespace App\Requests;

use App\APIResource\APIResource;
use App\Models\TodoModel;
use Slim\Psr7\Response;

class DeleteRequest {

    private APIResource $resource;
    private TodoModel $create_task;

    public function __construct() {
        $this->resource = new APIResource();
        $this->create_task = new TodoModel();
    }

    public function validate(Response $response, int $args): ?Response {
        if (is_null($args) || empty($args)) {
            $validation_message = ["error" => "Function parameter is empty"];
            $json = $this->resource->jsonResponse($response, $validation_message, 400);
            return $json;
        } elseif (!is_int( $args )) {
            $validation_message = ["error" => "Function parameter is not an integer"];
            $json = $this->resource->jsonResponse($response, $validation_message, 400);
            return $json;
        }

        // Call the create method
        $this->create_task->delete($args);

        // Return a success response
        $success_message = ["message" => "Task deleted successfully"];
        $json = $this->resource->jsonResponse($response, $success_message, 200);
        return $json;
    }
}