<?php
require_once __DIR__ . '/../models/Submission.php';

class SubmissionController {
    private $submissionModel;

    public function __construct() {
        $this->submissionModel = new Submission();

        if(session_status() === PHP_SESSION_NONE) session_start();

        if(!isset($_SESSION['user'])) {
            header('Location: index.php?controller=User&action=login');
            exit;
        }
    }

    // Create a submission
public function create() {

    // If form submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if (!isset($_POST['challenge_id'])) {
            header("Location: index.php?controller=Challenge&action=challengeRoom");
            exit;
        }

        $challenge_id = intval($_POST['challenge_id']);
        $description = trim($_POST['description'] ?? '');
        $image_or_link = trim($_POST['image_or_link'] ?? '');

        // Basic validation
        if (empty($description)) {
            header("Location: index.php?controller=Submission&action=create&challenge_id=" . $challenge_id);
            exit;
        }

        $this->submissionModel->create(
            $challenge_id,
            $_SESSION['user']['id'],
            $description,
            $image_or_link
        );

        header("Location: index.php?controller=Challenge&action=challengeRoom");
        exit;
    }

    // If page accessed normally (GET)
    if (!isset($_GET['challenge_id'])) {
        header("Location: index.php?controller=Challenge&action=challengeRoom");
        exit;
    }

    $challenge_id = intval($_GET['challenge_id']);

    require __DIR__ . '/../views/submission/create.php';
}

    // Edit submission
    public function edit() {

        if(!isset($_GET['id'])) {
            header('Location: index.php?controller=Challenge&action=challengeRoom');
            exit;
        }

        $id = intval($_GET['id']);
        $submission = $this->submissionModel->getById($id);

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            $description = $_POST['description'] ?? '';
            $image_or_link = $_POST['image_or_link'] ?? null;

            $this->submissionModel->update(
                $id,
                $description,
                $image_or_link
            );

            header('Location: index.php?controller=Challenge&action=challengeRoom');
            exit;
        }

        require __DIR__ . '/../views/submission/edit.php';
    }

    // Delete submission
    public function delete() {

        if(isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $this->submissionModel->delete($id);
        }

        header('Location: index.php?controller=Challenge&action=challengeRoom');
        exit;
    }
}