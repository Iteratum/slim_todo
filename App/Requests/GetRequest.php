<?php

declare(strict_types=1);

namespace App\Requests;

use App\APIResource\APIResource;
use App\Models\TodoModel;
use Slim\Psr7\Response;

class GetRequest {

    private APIResource $resource;
    private TodoModel $create_task;

    public function __construct() {
        $this->resource = new APIResource();
        $this->create_task = new TodoModel();
    }

    public function validate(Response $response, int $args = null): ?Response {
        if (is_null($args) || empty($args)) {
            $fetched_tasks = $this->create_task->findAll();

            // Return a success response
            $success_message = ["message" => "All tasks fetched and returned successfully"];
            $json = $this->resource->jsonResponse($response, $fetched_tasks, 200);
            return $json;
        } elseif (!is_int($args)) {
            $validation_message = ["error" => "$args is not an integer"];
            $json = $this->resource->jsonResponse($response, $validation_message, 400);
            return $json;
        }

        // Call the create method
        $fetched_task = $this->create_task->find($args);

        // Return a success response
        $success_message = ["message" => "Task with id $args fetched and returned successfully"];
        $json = $this->resource->jsonResponse($response, $fetched_task, 200);
        return $json;
    }
}