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
            "INSERT INTO {$this->table} (submission_id,user_id,content) VALUES (?,?,?,NOW())"
        );
        return $stmt->execute([$submission_id, $user_id, $content]);
    }

    public function getAllBySubmission($submission_id) {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE submission_id=?");
        $stmt->execute([$submission_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id=?");
        return $stmt->execute([$id]);
    }
}