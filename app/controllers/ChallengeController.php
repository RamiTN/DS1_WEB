<?php
require_once __DIR__ . '/../models/Challenge.php';
require_once __DIR__ . '/../models/Submission.php';
require_once __DIR__ . '/../models/Vote.php';
require_once __DIR__ . '/../models/Comment.php';

class ChallengeController {
    private $challengeModel;
    private $submissionModel;
    private $voteModel;
    private $commentModel;

    public function __construct() {
        $this->challengeModel = new Challenge();
        $this->submissionModel = new Submission();
        $this->voteModel = new Vote();
        $this->commentModel = new Comment();

        if(session_status() === PHP_SESSION_NONE) session_start();

        // Redirect if user is not logged in
        if(!isset($_SESSION['user'])) {
            header('Location: index.php?controller=User&action=login');
            exit;
        }
    }

    // Show all challenges with search, filter, sort; submissions with vote count and ranking
    public function challengeRoom() {
        $keyword = trim($_GET['search'] ?? '');
        $category = trim($_GET['category'] ?? '');
        $sort = $_GET['sort'] ?? 'newest';
        if (!in_array($sort, ['newest', 'popularity', 'date'], true)) $sort = 'newest';

        $challenges = $this->challengeModel->getFiltered($keyword, $category, $sort);
        $categories = $this->challengeModel->getCategories();
        $currentUserId = (int) $_SESSION['user']['id'];
        $search = $keyword;
        foreach ($challenges as $key => $challenge) {
            $submissions = $this->submissionModel->getAllByChallenge($challenge['id']);
            foreach ($submissions as $i => $sub) {
                $submissions[$i]['has_voted'] = $this->voteModel->hasVotedSubmission($sub['id'], $currentUserId);
                $submissions[$i]['comments'] = $this->commentModel->getAllBySubmission($sub['id']);
            }
            $challenges[$key]['submissions'] = $submissions;
        }

        require __DIR__ . '/../views/challenge/challengeRoom.php';
    }

    // Create a new challenge
    public function create() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!csrf_verify()) {
                require __DIR__ . '/../views/challenge/create.php';
                return;
            }
            $title = trim($_POST['title'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $category = trim($_POST['category'] ?? '');
            $deadline = $_POST['deadline'] ?: null;
            $image = trim($_POST['image'] ?? '') ?: null;
            if ($title !== '' && $description !== '' && $category !== '') {
                $this->challengeModel->create(
                    $_SESSION['user']['id'],
                    $title,
                    $description,
                    $category,
                    $deadline,
                    $image
                );
            }
            header('Location: index.php?controller=Challenge&action=challengeRoom');
            exit;
        }
        require __DIR__ . '/../views/challenge/create.php';
    }

    // Edit a challenge (owner only)
    public function edit() {
        if(!isset($_GET['id'])) {
            header('Location: index.php?controller=Challenge&action=challengeRoom');
            exit;
        }
        $id = intval($_GET['id']);
        $challenge = $this->challengeModel->getById($id);
        if (!$challenge || (int)$challenge['user_id'] !== (int)$_SESSION['user']['id']) {
            header('Location: index.php?controller=Challenge&action=challengeRoom');
            exit;
        }
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!csrf_verify()) {
                require __DIR__ . '/../views/challenge/edit.php';
                return;
            }
            $title = trim($_POST['title'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $category = trim($_POST['category'] ?? '');
            $deadline = $_POST['deadline'] ?: null;
            $image = trim($_POST['image'] ?? '') ?: null;
            if ($title !== '' && $description !== '' && $category !== '') {
                $this->challengeModel->update($id, $title, $description, $category, $deadline, $image);
            }
            header('Location: index.php?controller=Challenge&action=challengeRoom');
            exit;
        }
        require __DIR__ . '/../views/challenge/edit.php';
    }

    // Delete a challenge (owner only)
    public function delete() {
        if(isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $challenge = $this->challengeModel->getById($id);
            if ($challenge && (int)$challenge['user_id'] === (int)$_SESSION['user']['id']) {
                $this->challengeModel->delete($id);
            }
        }
        header('Location: index.php?controller=Challenge&action=challengeRoom');
        exit;
    }
}