<?php
class Vote {

    private $conn;
    private $table = 'votes';

    public function __construct() {
        $host = 'localhost';
        $db   = 'challengehub';
        $user = 'root';
        $pass = '';
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->conn = new PDO($dsn, $user, $pass, $options);
        } catch (PDOException $e) {
            die("Database Error: " . $e->getMessage());
        }
    }

    public function vote($challenge_id, $user_id) {
        if ($this->hasVotedAny($user_id)) {
            return false; // User already voted, do not allow
        }

        $stmt = $this->conn->prepare(
            "INSERT INTO {$this->table} (challenge_id, user_id)
             VALUES (?, ?)"
        );

        return $stmt->execute([$challenge_id, $user_id]);
    }

    public function hasVotedChallenge($challenge_id, $user_id) {
        $stmt = $this->conn->prepare(
            "SELECT 1 
             FROM {$this->table} 
             WHERE challenge_id = ? AND user_id = ? 
             LIMIT 1"
        );
        $stmt->execute([$challenge_id, $user_id]);
        return $stmt->fetch() !== false;
    }

    public function countByChallenge($challenge_id) {
        $stmt = $this->conn->prepare(
            "SELECT COUNT(*) 
             FROM {$this->table} 
             WHERE challenge_id = ?"
        );
        $stmt->execute([$challenge_id]);
        return (int)$stmt->fetchColumn();
    }

    public function hasVotedAny($user_id) {
        $stmt = $this->conn->prepare(
            "SELECT 1 FROM {$this->table} WHERE user_id = ? LIMIT 1"
        );
        $stmt->execute([$user_id]);
        return $stmt->fetch() !== false;
    }
}