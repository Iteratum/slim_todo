<?php

declare(strict_types=1);

namespace App\Models;

use App\Storage\Database;
use PDO;

class TodoModel {
    
    private static $instance = null;
    private $conn = null;

    public function __construct() {
        self::$instance =  new Database();
        $this->conn = self::$instance->connect();
    }
    public function create(array $data): void {
    
        $sql = "INSERT INTO `todo` (`id`, `task`, `complete`) VALUES (:id, :task, :complete)";

        $statement = $this->conn->prepare($sql);
        $statement->execute([
            ':id' => $data['id'],
            ':task' => $data['task'],
            ':complete' => $data['complete'],
        ]);

    }

    public function find(int $data): array {
        $sql = "SELECT `id`, `task`, `complete` FROM `todo` WHERE `id` = :id";
    
        $statement = $this->conn->prepare($sql);
        $statement->execute([
            ':id' => $data,
        ]);
        $task = $statement->fetch(PDO::FETCH_ASSOC);
    
        if ($task === false) {
            return [];
        }
    
        return $task;
    }

    public function findAll(): array {
        $sql = "SELECT `id`, `task`, `complete` FROM `todo`";

        $statement = $this->conn->query($sql);
        $tasks = $statement->fetchAll(PDO::FETCH_OBJ);
        return $tasks;
    }

    public function update(array $data): void {
        $sql = "UPDATE `todo` SET `task` = :task, `complete` = :complete WHERE `id` = :id";

        $statement = $this->conn->prepare($sql);
        $statement->execute([
            ':id' => (int)$data['id'],
            ':task' => $data['task'],
            ':complete' => $data['complete'],
        ]);
    }

    public function delete(int $data): void {
        $sql = "DELETE FROM `todo` WHERE `id` = :id";

        $statement = $this->conn->prepare($sql);
        $statement->execute([
            ':id' => $data,
        ]);
    }
}