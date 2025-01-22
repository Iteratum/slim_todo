<?php

declare(strict_types=1);

namespace App\Controller;

use App\Storage\Database;
use PDO;
use PDOException;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;


class TodoController {
    private static $instance = null;
    private $conn = null;

    public function __construct() {
        self::$instance =  new Database();
        $this->conn = self::$instance->connect();
    }

    /**
     * Creates and adds task to the database.
     */
    public function createTask(Request $request, Response $response): Response {
        $request_body = $request->getParsedBody();
    
        // Assuming $request_body is an associative array with keys 'id', 'task', and 'complete'
        $id = $request_body['id'];
        $task = $request_body['task'];
        $complete = $request_body['complete'];
    
        $sql = "INSERT INTO `todo` (`id`, `task`, `complete`) VALUES (:id, :task, :complete)";
    
        try {
            $statement = $this->conn->prepare($sql);
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
            $statement->bindParam(':task', $task, PDO::PARAM_STR);
            $statement->bindParam(':complete', $complete, PDO::PARAM_BOOL);
            $statement->execute();
        
            $response->getBody()->write(json_encode(['message' => 'Task created successfully']));
            return $response
                ->withHeader("content-type", "application/json")
                ->withStatus(201);
        } catch (PDOException $e) {
            $error = array(
                "message" => $e->getMessage()
            );
            $response->getBody()->write(json_encode($error));
            return $response
                ->withHeader("content-type", "application/json")
                ->withStatus(500);
        }
    }
    
    /**
     * Retrieves a single task from the database using the provided integer argument.
     */
    public function getTask(Request $request, Response $response, array $args): Response {
        $id = (int)$args["id"];
        $sql = "SELECT `id`, `task`, `complete` FROM `todo` WHERE `id` = :id";

        try {
            $statement = $this->conn->prepare($sql);
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
            $statement->execute();
            $task = $statement->fetch(PDO::FETCH_OBJ);
            if ($task) {
                $response->getBody()->write(json_encode($task));
                return $response
                    ->withHeader("content-type", "application/json")
                    ->withStatus(200);
            } else {
                $response->getBody()->write(string: json_encode(['error' => 'Task not found']));
                return $response
                    ->withHeader("content-type", "application/json")
                    ->withStatus(404);
            }
        } catch (PDOException $e) {
            $error = array(
                "message" => $e->getMessage()
            );
            $response->getBody()->write(json_encode($error));
            return $response
                ->withHeader("content-type", "application/json")
                ->withStatus(500);
        }
    }

    /**
     * Retrieves all tasks from the database.
     */
    public function getTasks(Request $request, Response $response): Response {
        $sql = "SELECT * FROM `todo` ORDER BY `complete` ASC";

        try {
            $statement = $this->conn->query($sql); 
            $tasks = $statement->fetchAll(PDO::FETCH_OBJ)   ;
            $response->getBody()->write(json_encode($tasks));
            return $response
            ->withHeader("content-type", "application/json")
            ->withStatus(200);
        } catch (PDOException $e) {
            $error = array(
                "message" => $e->getMessage()
            );
            $response->getBody()->write(json_encode($error));
            return $response
            ->withHeader("content-type", "application/json")
            ->withStatus(500);
        }
    }

    /**
     * Updates a particular task in the database with the content of the request body.
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function updateTask(Request $request, Response $response): Response {
        $request_body = $request->getParsedBody();

        if (is_null($request_body) || empty($request_body)) {
            $response->getBody()->write(json_encode(array("error"=> "Request body is empty")));
            return $response
                ->withHeader("content-type", "application/json")
                ->withStatus(400);
        }
    
        // Assuming $request_body is an associative array with keys 'id', 'task', and 'complete'
        $id = $request_body['id'];
        $task = $request_body['task'];
        $complete = $request_body['complete'];
    
        $sql = "UPDATE `todo` SET `task` = :task, `complete` = :complete WHERE `id` = :id";
    
        try {
            $statement = $this->conn->prepare($sql);
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
            $statement->bindParam(':task', $task, PDO::PARAM_STR);
            $statement->bindParam(':complete', $complete, PDO::PARAM_BOOL);
            $statement->execute();
        
            $response->getBody()->write(json_encode(['message' => 'Task updated successfully']));
            return $response
                ->withHeader("content-type", "application/json")
                ->withStatus(201);
        } catch (PDOException $e) {
            $error = array(
                "message" => $e->getMessage()
            );
            $response->getBody()->write(json_encode($error));
            return $response
                ->withHeader("content-type", "application/json")
                ->withStatus(500);
        }
    }

    /**
     * Deletes the task which the id is provided as a query param from the database.
     */
    public function deleteTask(Request $request, Response $response, array $args): Response {
        $id = (int)$args['id'];

        if (is_null($id) || empty($id)) {
            $response->getBody()->write(json_encode(array("error"=> "Request body is empty")));
        }
    
        // Assuming $request_body is an associative array with keys 'id', 'task', and 'complete'
    
        $sql = "DELETE FROM `todo` WHERE `id` = :id";
    
        try {
            $statement = $this->conn->prepare($sql);
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
            $statement->execute();
        
            $response->getBody()->write(json_encode(['message' => 'Task deleted successfully']));
            return $response
                ->withHeader("content-type", "application/json")
                ->withStatus(201);
        } catch (PDOException $e) {
            $error = array(
                "message" => $e->getMessage()
            );
            $response->getBody()->write(json_encode($error));
            return $response
                ->withHeader("content-type", "application/json")
                ->withStatus(500);
        }
    }
}