<?php
require_once 'Database.php';

class Submission {
    private $conn;
    private $table = 'submissions';

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function create($challenge_id, $user_id, $description, $image_or_link = null) {
        $stmt = $this->conn->prepare(
            "INSERT INTO {$this->table} (challenge_id,user_id,description,image_or_link)
             VALUES (?,?,?,?)"
        );
        return $stmt->execute([$challenge_id, $user_id, $description, $image_or_link]);
    }

public function getAllByChallenge($challenge_id) {
    $stmt = $this->conn->prepare("
        SELECT s.*, u.name AS user_name
        FROM {$this->table} s
        JOIN users u ON s.user_id = u.id
        WHERE s.challenge_id=?
    ");
    $stmt->execute([$challenge_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $description, $image_or_link = null) {
        $stmt = $this->conn->prepare("UPDATE {$this->table} SET description=?, image_or_link=? WHERE id=?");
        return $stmt->execute([$description, $image_or_link, $id]);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id=?");
        return $stmt->execute([$id]);
    }
}