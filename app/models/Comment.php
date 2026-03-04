<?php
require_once 'Database.php';

class Comment {
    private $conn;
    private $table = 'comments';

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function create($submission_id, $user_id, $content) {
        $stmt = $this->conn->prepare(
            "INSERT INTO {$this->table} (submission_id,user_id,content) VALUES (?,?,?)"
        );
        return $stmt->execute([$submission_id, $user_id, $content]);
    }

    public function getAllBySubmission($submission_id) {
        $stmt = $this->conn->prepare("
            SELECT c.*, u.name AS author_name
            FROM {$this->table} c
            JOIN users u ON c.user_id = u.id
            WHERE c.submission_id = ?
            ORDER BY c.created_at ASC
        ");
        $stmt->execute([$submission_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id=?");
        return $stmt->execute([$id]);
    }
public function getAll() {
    $stmt = $this->conn->prepare("SELECT * FROM comments");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

}