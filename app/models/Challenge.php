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
        $stmt = $this->conn->query("SELECT * FROM {$this->table} ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get challenges with optional search, category filter, and sort.
     * @param string $keyword Search in title and description
     * @param string $category Filter by category
     * @param string $sort 'popularity' | 'date' | 'newest'
     */
    public function getFiltered($keyword = '', $category = '', $sort = 'newest') {
        $sql = "SELECT c.*,
            (SELECT COUNT(*) FROM votes v
             INNER JOIN submissions s ON v.submission_id = s.id
             WHERE s.challenge_id = c.id) AS total_votes
            FROM {$this->table} c WHERE 1=1";
        $params = [];
        if ($keyword !== '') {
            $sql .= " AND (c.title LIKE ? OR c.description LIKE ?)";
            $p = '%' . $keyword . '%';
            $params[] = $p;
            $params[] = $p;
        }
        if ($category !== '') {
            $sql .= " AND c.category = ?";
            $params[] = $category;
        }
        switch ($sort) {
            case 'popularity':
                $sql .= " ORDER BY total_votes DESC, c.id DESC";
                break;
            case 'date':
                $sql .= " ORDER BY c.deadline ASC, c.id DESC";
                break;
            default:
                $sql .= " ORDER BY c.id DESC";
        }
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCategories() {
        $stmt = $this->conn->query("SELECT DISTINCT category FROM {$this->table} ORDER BY category");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
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