<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Requests\CreateRequest;
use App\Requests\GetRequest;
use App\Requests\UpdateRequest;
use App\Requests\DeleteRequest;

use App\Storage\Database;
use PDO;
use PDOException;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;


class TodoController {
    private CreateRequest $create_request_validation;
    private GetRequest $get_request_validation;
    private UpdateRequest $update_request_validation;
    private DeleteRequest $delete_request_validation;

    public function __construct() {
        $this->create_request_validation = new CreateRequest();
        $this->get_request_validation = new GetRequest();
        $this->update_request_validation = new UpdateRequest();
        $this->delete_request_validation = new DeleteRequest();
    }

    /**
     * Creates and adds task to the database.
     */
    public function createTask(Request $request, Response $response): Response {
        $request_body = $request->getParsedBody();
        return $this->create_request_validation->validate($response, $request_body);
    }
    
    /**
     * Retrieves a single task from the database using the provided integer argument.
     */
    public function getTask(Request $request, Response $response, array $args): Response {
        $id = (int)$args["id"];
        return $this->get_request_validation->validate($response, $id);

    }

    /**
     * Retrieves all tasks from the database.
     */
    public function getTasks(Request $request, Response $response): Response {
        return $this->get_request_validation->validate($response);

    }

    /**
     * Updates a particular task in the database with the content of the request body.
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function updateTask(Request $request, Response $response): Response {
        $request_body = $request->getParsedBody();
        return $this->update_request_validation->validate($response, $request_body);

    }

    /**
     * Deletes the task which the id is provided as a query param from the database.
     */
    public function deleteTask(Request $request, Response $response, array $args): Response {
        $id = (int)$args["id"];
        return $this->delete_request_validation->validate($response, $id);

    }
}