<?php
require_once __DIR__ . '/../models/User.php';

class AdminController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
        if(session_status() === PHP_SESSION_NONE) session_start();

        // Only admins can access
        if(!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: index.php');
            exit;
        }
    }

    // Admin dashboard
    public function adminDashboard() {
        $users = $this->userModel->getAll();
        require __DIR__ . '/../views/admin/adminDashboard.php';
    }

    // Delete user
    public function deleteUser() {
        if(isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $this->userModel->delete($id);
        }
        header('Location: index.php?controller=Admin&action=adminDashboard');
        exit;
    }
}