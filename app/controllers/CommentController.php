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
        if(isset($_GET['submission_id'])) {
            $submission_id = intval($_GET['submission_id']); // sanitize input
        } else {
            header('Location: index.php?controller=Challenge&action=index');
            exit;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $content = $_POST['content'] ?? '';
            $this->commentModel->create(
                $submission_id,
                $_SESSION['user']['id'],
                $content
            );

            header("Location: index.php?controller=Challenge&action=index");
            exit;
        }

        // If needed, you could include a small comment form view here
        // require __DIR__ . '/../views/comment/create.php';
    }

    // Delete a comment
    public function delete() {
        if(isset($_GET['id'])) {
            $id = intval($_GET['id']); // sanitize input
            $this->commentModel->delete($id);
        }
        header('Location: index.php?controller=Challenge&action=index');
        exit;
    }
}