<?php
require_once __DIR__ . '/../models/Submission.php';

class SubmissionController {
    private $submissionModel;

    public function __construct() {
        $this->submissionModel = new Submission();
        if(session_status() === PHP_SESSION_NONE) session_start();

        // Redirect if user is not logged in
        if(!isset($_SESSION['user'])) {
            header('Location: index.php?controller=User&action=login');
            exit;
        }
    }

    // Create a submission for a challenge
    public function create() {
        if(isset($_GET['challenge_id'])) {
            $challenge_id = intval($_GET['challenge_id']); // sanitize input
        } else {
            // No challenge ID provided, redirect
            header('Location: index.php?controller=Challenge&action=index');
            exit;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $description = $_POST['description'] ?? '';
            $image_or_link = $_POST['image_or_link'] ?? null;

            $this->submissionModel->create(
                $challenge_id,
                $_SESSION['user']['id'],
                $description,
                $image_or_link
            );

            header("Location: index.php?controller=Challenge&action=index");
            exit;
        } else {
            require __DIR__ . '/../views/submission/create.php';
        }
    }

    // Edit a submission
    public function edit() {
        if(!isset($_GET['id'])) {
            header('Location: index.php?controller=Challenge&action=index');
            exit;
        }

        $id = intval($_GET['id']); // sanitize input
        $submission = $this->submissionModel->getById($id);

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $description = $_POST['description'] ?? '';
            $image_or_link = $_POST['image_or_link'] ?? null;
            $this->submissionModel->update($id, $description, $image_or_link);

            header('Location: index.php?controller=Challenge&action=index');
            exit;
        }

        require __DIR__ . '/../views/submission/edit.php';
    }

    // Delete a submission
    public function delete() {
        if(isset($_GET['id'])) {
            $id = intval($_GET['id']); // sanitize input
            $this->submissionModel->delete($id);
        }
        header('Location: index.php?controller=Challenge&action=index');
        exit;
    }
}