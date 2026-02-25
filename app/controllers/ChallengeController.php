<?php
require_once __DIR__ . '/../models/Challenge.php';
require_once __DIR__ . '/../models/Submission.php';
require_once __DIR__ . '/../models/Vote.php';

class ChallengeController {
    private $challengeModel;
    private $submissionModel;
    private $voteModel;

    public function __construct() {
        $this->challengeModel = new Challenge();
        $this->submissionModel = new Submission();
        $this->voteModel = new Vote();

        if(session_status() === PHP_SESSION_NONE) session_start();

        // Redirect if user is not logged in
        if(!isset($_SESSION['user'])) {
            header('Location: index.php?controller=User&action=login');
            exit;
        }
    }

    // Show all challenges with submissions and votes
    public function challengeRoom() {
        $challenges = $this->challengeModel->getAll();

        foreach ($challenges as $key => $challenge) {

            // Fetch only submissions for THIS challenge
            $submissions = $this->submissionModel->getAllByChallenge($challenge['id']);

            // Attach submissions to the challenge
            $challenges[$key]['submissions'] = $submissions;

            // Count votes for this challenge
            $challenges[$key]['votes_count'] = $this->voteModel->countByChallenge($challenge['id']);

            // Check if current user has voted → cast to boolean
            $challenges[$key]['has_voted'] = (bool) $this->voteModel->hasVotedChallenge(
                $challenge['id'],
                $_SESSION['user']['id']
            );
        }

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
        }

        require __DIR__ . '/../views/challenge/create.php';
    }

    // Edit a challenge
    public function edit() {
        if(!isset($_GET['id'])) {
            header('Location: index.php?controller=Challenge&action=challengeRoom');
            exit;
        }

        $id = intval($_GET['id']);
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
            $id = intval($_GET['id']);
            $this->challengeModel->delete($id);
        }

        header('Location: index.php?controller=Challenge&action=challengeRoom');
        exit;
    }
}