<?php
require_once __DIR__ . '/../models/User.php';

class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
        if(session_status() === PHP_SESSION_NONE) session_start();
    }

    // Registration form + processing
    public function register() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $this->userModel->create($name, $email, $password);
            header('Location: index.php?controller=User&action=login');
            exit;
        } else {
            require __DIR__ . '/../views/user/register.php';
        }
    }

    // Login
    public function login() {
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $user = $this->userModel->getByEmail($email);

        if($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;

            // Redirect based on role
            if($user['role'] === 'admin') {
                header('Location: index.php?controller=Admin&action=adminDashboard');
            } else {
                header('Location: index.php?controller=User&action=userDashboard');
            }
            exit;
        } else {
            $error = "Invalid credentials";
            require __DIR__ . '/../views/user/login.php';
        }
    } else {
        require __DIR__ . '/../views/user/login.php';
    }
}

    // Logout
    public function logout() {
        session_destroy();
        header('Location: index.php');
        exit;
    }

    // Profile
    public function userDashboard() {
        if(!isset($_SESSION['user'])) {
            header('Location: index.php?controller=User&action=login');
            exit;
        }
        $user = $_SESSION['user'];
        require __DIR__ . '/../views/user/userDashboard.php';
    }
}