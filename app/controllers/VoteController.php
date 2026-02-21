<?php
require_once __DIR__ . '/../models/Vote.php';

class VoteController {
    private $voteModel;

    public function __construct() {
        $this->voteModel = new Vote();
        if(session_status() === PHP_SESSION_NONE) session_start();

        // Redirect if user is not logged in
        if(!isset($_SESSION['user'])) {
            header('Location: index.php?controller=User&action=login');
            exit;
        }
    }

    // Vote on a submission
    public function vote() {
        if(isset($_GET['submission_id'])) {
            $submission_id = intval($_GET['submission_id']); // sanitize input
            $this->voteModel->vote($submission_id, $_SESSION['user']['id']);
        }
        // Redirect back to challenges page
        header('Location: index.php?controller=Challenge&action=index');
        exit;
    }
}