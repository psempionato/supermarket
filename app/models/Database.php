<?php

namespace app\models;

use PDO;
use PDOException;

class Database {
    private static $instace = null;
    private $conn;

    private $host = 'postgres';
    private $db = 'supermarket';
    private $user = 'postgres';
    private $password = 'password';
    private $pdo;

    public function __construct()
    {
        $this->connect();
    }

    private function connect() {
        try {
            $dsn = "pgsql:host={$this->host};dbname={$this->db}";
            $this->pdo = new PDO($dsn, $this->user, $this->password);

            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed " . $e->getMessage();
            exit;
        }
    }

    public function query($sql) {
        return $this->pdo->query($sql);
    }

    public function prepare($sql) {
        return $this->pdo->prepare($sql);
    }

    public function execute($statement, $parameters = []) {
        return $statement->execute($parameters);
    }

    public function fetch($statement) {
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function fetchAll($statement) {
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

}