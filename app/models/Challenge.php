<?php
require_once 'Database.php';

class Challenge {
    private $conn;
    private $table = 'challenges';

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

 public function create($user_id, $title, $description, $category, $deadline, $image = null) {
    $stmt = $this->conn->prepare(
        "INSERT INTO {$this->table} 
        (user_id, title, description, category, deadline, image) 
        VALUES (?, ?, ?, ?, ?, ?)"
    );

    return $stmt->execute([
        $user_id,
        $title,
        $description,
        $category,
        $deadline,
        $image
    ]);
}

    public function getAll() {
        $stmt = $this->conn->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $title, $description, $category, $deadline, $image = null) {
        $stmt = $this->conn->prepare(
            "UPDATE {$this->table} SET title=?, description=?, category=?, deadline=?, image=? WHERE id=?"
        );
        return $stmt->execute([$title, $description, $category, $deadline, $image, $id]);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id=?");
        return $stmt->execute([$id]);
    }
}