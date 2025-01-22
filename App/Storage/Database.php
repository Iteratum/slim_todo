<?php

declare(strict_types=1);

namespace App\Storage;

use PDO;

class Database {

    private $host = '127.0.0.1';
    private $user = 'root';
    private $password = 'new_password';
    private $dbname = 'slim_todo';

    /**
     * This function is used to create a connections to the database
     */
    public function connect(): PDO {
        $conn_str = "mysql:host=$this->host;dbname=$this->dbname";
        $conn = new PDO($conn_str, $this->user, $this->password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    }
}