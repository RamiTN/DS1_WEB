<?php
require_once __DIR__ . '/../models/Challenge.php';

class ChallengeController {
    private $challengeModel;

    public function __construct() {
        $this->challengeModel = new Challenge();
        if(session_status() === PHP_SESSION_NONE) session_start();

        // Redirect if user is not logged in
        if(!isset($_SESSION['user'])) {
            header('Location: index.php?controller=User&action=login');
            exit;
        }
    }

    // List all challenges
    public function challengeRoom() {
        $challenges = $this->challengeModel->getAll();
        require __DIR__ . '/../views/challenge/challengeRoom.php';
    }

    // Create a new challenge
    public function create() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $description = $_POST['description'] ?? '';
            $category = $_POST['category'] ?? '';
            $deadline = $_POST['deadline'] ?? null;
            $image = $_POST['image'] ?? null;

            $this->challengeModel->create(
                $_SESSION['user']['id'],
                $title,
                $description,
                $category,
                $deadline,
                $image
            );

            header('Location: index.php?controller=Challenge&action=challengeRoom');
            exit;
        } else {
            require __DIR__ . '/../views/challenge/create.php';
        }
    }

    // Edit a challenge
    public function edit() {
        if(!isset($_GET['id'])) {
            header('Location: index.php?controller=Challenge&action=challengeRoom');
            exit;
        }

        $id = intval($_GET['id']); // sanitize input
        $challenge = $this->challengeModel->getById($id);

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $description = $_POST['description'] ?? '';
            $category = $_POST['category'] ?? '';
            $deadline = $_POST['deadline'] ?? null;
            $image = $_POST['image'] ?? null;

            $this->challengeModel->update($id, $title, $description, $category, $deadline, $image);

            header('Location: index.php?controller=Challenge&action=challengeRoom');
            exit;
        }

        require __DIR__ . '/../views/challenge/edit.php';
    }

    // Delete a challenge
    public function delete() {
        if(isset($_GET['id'])) {
            $id = intval($_GET['id']); // sanitize input
            $this->challengeModel->delete($id);
        }
        header('Location: index.php?controller=Challenge&action=challengeRoom');
        exit;
    }
}