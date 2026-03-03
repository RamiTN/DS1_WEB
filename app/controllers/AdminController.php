<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Challenge.php';
require_once __DIR__ . '/../models/Submission.php';
require_once __DIR__ . '/../models/Comment.php';
require_once __DIR__ . '/../models/Vote.php';

class AdminController {
    private $userModel;
    private $challengeModel;
    private $submissionModel;
    private $commentModel;
    private $voteModel;

    public function __construct() {
        $this->userModel = new User();
        $this->challengeModel = new Challenge();
        $this->submissionModel = new Submission();
        $this->commentModel = new Comment();
        $this->voteModel = new Vote();

        if(session_status() === PHP_SESSION_NONE) session_start();

        // Only admins can access
        if(!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: index.php');
            exit;
        }
    }

    // ================= DASHBOARD =================
    public function adminDashboard() {

        $users = $this->userModel->getAll();
        $challenges = $this->challengeModel->getAll();
        $submissions = $this->submissionModel->getAll();
        $comments = $this->commentModel->getAll();

        // Add vote count to each submission
        foreach ($submissions as &$s) {
            $s['votes_count'] = $this->voteModel->countBySubmission($s['id']);
        }

        // Statistics
        $totalUsers = count($users);
        $totalChallenges = count($challenges);
        $totalSubmissions = count($submissions);
        $totalComments = count($comments);
        $totalVotes = $this->voteModel->countAllVotes();

        require __DIR__ . '/../views/admin/adminDashboard.php';
    }

    // ================= USER =================
    public function deleteUser() {
        if(isset($_GET['id'])) {
            $this->userModel->delete(intval($_GET['id']));
        }
        header('Location: index.php?controller=Admin&action=adminDashboard');
        exit;
    }

    // ================= CHALLENGE =================
    public function deleteChallenge() {
        if(isset($_GET['id'])) {
            $this->challengeModel->delete(intval($_GET['id']));
        }
        header('Location: index.php?controller=Admin&action=adminDashboard');
        exit;
    }

    // ================= SUBMISSION =================
    public function deleteSubmission() {
        if(isset($_GET['id'])) {
            $this->submissionModel->delete(intval($_GET['id']));
        }
        header('Location: index.php?controller=Admin&action=adminDashboard');
        exit;
    }

    // ================= COMMENT =================
    public function deleteComment() {
        if(isset($_GET['id'])) {
            $this->commentModel->delete(intval($_GET['id']));
        }
        header('Location: index.php?controller=Admin&action=adminDashboard');
        exit;
    }
}