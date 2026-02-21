<?php
class Database {
    private $host = 'localhost';
    private $db_name = 'challengehub';
    private $username = 'root';
    private $password = '';
    private $conn = null;

    public function connect() {
        if ($this->conn === null) {
            try {
                $this->conn = new PDO(
                    "mysql:host={$this->host};dbname={$this->db_name};charset=utf8",
                    $this->username,
                    $this->password
                );
                // Set PDO error mode to exception
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                // Force fetch mode to associative array by default
                $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                die("Database connection error: " . $e->getMessage());
            }
        }
        return $this->conn;
    }

    // Optional: method to close connection
    public function disconnect() {
        $this->conn = null;
    }
}