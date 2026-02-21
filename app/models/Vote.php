<?php
require_once 'Database.php';

class Vote {
    private $conn;
    private $table = 'votes';

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    // Add vote
    public function vote($submission_id, $user_id) {
        $stmt = $this->conn->prepare(
            "INSERT IGNORE INTO {$this->table} (submission_id,user_id) VALUES (?,?)"
        );
        return $stmt->execute([$submission_id, $user_id]);
    }

    // Count votes per submission
    public function countBySubmission($submission_id) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) as votes FROM {$this->table} WHERE submission_id=?");
        $stmt->execute([$submission_id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['votes'] ?? 0;
    }
}