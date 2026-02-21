<?php
require_once 'Database.php';

class User {
    private $conn;
    private $table = 'users';

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    // Create user
    public function create($name, $email, $password, $role = 'user') {
        $sql = "INSERT INTO {$this->table} (name,email,password,role) VALUES (?,?,?,?)";
        $stmt = $this->conn->prepare($sql);
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        return $stmt->execute([$name, $email, $hashed, $role]);
    }

    // Get user by email
    public function getByEmail($email) {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE email=?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get all users
    public function getAll() {
        $stmt = $this->conn->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Update user
    public function update($id, $name, $email) {
        $stmt = $this->conn->prepare("UPDATE {$this->table} SET name=?, email=? WHERE id=?");
        return $stmt->execute([$name, $email, $id]);
    }

    // Delete user
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id=?");
        return $stmt->execute([$id]);
    }
}