<?php
require_once __DIR__ . '/../models/Comment.php';

class CommentController {
    private $commentModel;

    public function __construct() {
        $this->commentModel = new Comment();
        if(session_status() === PHP_SESSION_NONE) session_start();

        // Redirect if user is not logged in
        if(!isset($_SESSION['user'])) {
            header('Location: index.php?controller=User&action=login');
            exit;
        }
    }

    // Create a comment
    public function create() {
        $submission_id = isset($_GET['submission_id']) ? intval($_GET['submission_id']) : (isset($_POST['submission_id']) ? intval($_POST['submission_id']) : 0);
        if (!$submission_id) {
            header('Location: index.php?controller=Challenge&action=challengeRoom');
            exit;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $content = trim($_POST['content'] ?? '');
            if ($content !== '') {
                $this->commentModel->create($submission_id, $_SESSION['user']['id'], $content);
            }
            header('Location: index.php?controller=Challenge&action=challengeRoom');
            exit;
        }
        header('Location: index.php?controller=Challenge&action=challengeRoom');
        exit;
    }

    // Delete a comment (author or admin only)
    public function delete() {
        if(isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $comment = $this->commentModel->getById($id);
            if ($comment) {
                $isAuthor = (int)$comment['user_id'] === (int)($_SESSION['user']['id'] ?? 0);
                $isAdmin = ($_SESSION['user']['role'] ?? '') === 'admin';
                if ($isAuthor || $isAdmin) {
                    $this->commentModel->delete($id);
                }
            }
        }
        header('Location: index.php?controller=Challenge&action=challengeRoom');
        exit;
    }
}