<?php
require_once 'Database.php';

class Vote {
    private $conn;
    private $table = 'votes';

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function vote($submission_id, $user_id) {
        if ($this->hasVotedSubmission($submission_id, $user_id)) {
            return false;
        }
        $stmt = $this->conn->prepare(
            "INSERT INTO {$this->table} (submission_id, user_id) VALUES (?, ?)"
        );
        return $stmt->execute([$submission_id, $user_id]);
    }

    public function hasVotedSubmission($submission_id, $user_id) {
        $stmt = $this->conn->prepare(
            "SELECT 1 FROM {$this->table} WHERE submission_id = ? AND user_id = ? LIMIT 1"
        );
        $stmt->execute([$submission_id, $user_id]);
        return $stmt->fetch() !== false;
    }

    public function countBySubmission($submission_id) {
        $stmt = $this->conn->prepare(
            "SELECT COUNT(*) FROM {$this->table} WHERE submission_id = ?"
        );
        $stmt->execute([$submission_id]);
        return (int) $stmt->fetchColumn();
    }

    public function getAll() {
        $stmt = $this->conn->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countAllVotes() {
        $stmt = $this->conn->query("SELECT COUNT(*) FROM {$this->table}");
        return (int) $stmt->fetchColumn();
    }
}
