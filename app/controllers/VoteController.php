<?php
require_once __DIR__ . '/../models/Vote.php';

class VoteController {

    private $voteModel;

    public function __construct() {

        $this->voteModel = new Vote();

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Redirect if user not logged in
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?controller=User&action=login');
            exit;
        }
    }

    // ✅ Vote on a challenge
public function vote() {

    if (isset($_POST['challenge_id'])) {

        $challenge_id = intval($_POST['challenge_id']);
        $user_id = $_SESSION['user']['id'];
        $this->voteModel->vote($challenge_id, $user_id);
    }

    header('Location: index.php?controller=Challenge&action=challengeRoom');
    exit;
}

    
}