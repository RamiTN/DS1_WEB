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
            if (!csrf_verify()) {
                $error = 'Invalid request. Please try again.';
                require __DIR__ . '/../views/user/Register.php';
                return;
            }
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $errors = [];
            if (strlen($name) < 2) $errors[] = 'Name must be at least 2 characters.';
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Invalid email.';
            if (strlen($password) < 6) $errors[] = 'Password must be at least 6 characters.';
            if (isset($_POST['confirm_password']) && $password !== $_POST['confirm_password']) $errors[] = 'Passwords do not match.';
            if ($this->userModel->getByEmail($email)) $errors[] = 'Email already registered.';
            if (!empty($errors)) {
                $error = implode(' ', $errors);
                require __DIR__ . '/../views/user/Register.php';
                return;
            }
            $this->userModel->create($name, $email, $password);
            header('Location: index.php?controller=User&action=login');
            exit;
        }
        require __DIR__ . '/../views/user/Register.php';
    }

    // Login
    public function login() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            if (!csrf_verify()) {
                $error = 'Invalid request. Please try again.';
                require __DIR__ . '/../views/user/login.php';
                return;
            }
            $user = $this->userModel->getByEmail($email);
            if($user && password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user;
                if($user['role'] === 'admin') {
                    header('Location: index.php?controller=Admin&action=adminDashboard');
                } else {
                    header('Location: index.php?controller=User&action=userDashboard');
                }
                exit;
            }
            $error = "Invalid credentials";
        }
        require __DIR__ . '/../views/user/login.php';
    }

    // Logout
    public function logout() {
        session_destroy();
        header('Location: index.php');
        exit;
    }

    // Profile dashboard
    public function userDashboard() {
        if(!isset($_SESSION['user'])) {
            header('Location: index.php?controller=User&action=login');
            exit;
        }
        $user = $this->userModel->getById($_SESSION['user']['id']);
        if ($user) $_SESSION['user'] = $user;
        require __DIR__ . '/../views/user/userDashboard.php';
    }

    // Edit profile
    public function editProfile() {
        if(!isset($_SESSION['user'])) {
            header('Location: index.php?controller=User&action=login');
            exit;
        }
        $user = $this->userModel->getById($_SESSION['user']['id']);
        if (!$user) {
            header('Location: index.php?controller=User&action=userDashboard');
            exit;
        }
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!csrf_verify()) {
                $error = 'Invalid request. Please try again.';
                require __DIR__ . '/../views/user/editProfile.php';
                return;
            }
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $new_password = $_POST['new_password'] ?? '';
            $errors = [];
            if (strlen($name) < 2) $errors[] = 'Name must be at least 2 characters.';
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Invalid email.';
            $existing = $this->userModel->getByEmail($email);
            if ($existing && (int)$existing['id'] !== (int)$user['id']) $errors[] = 'Email already in use.';
            if ($new_password !== '' && strlen($new_password) < 6) $errors[] = 'New password must be at least 6 characters.';
            if (!empty($errors)) {
                $error = implode(' ', $errors);
                require __DIR__ . '/../views/user/editProfile.php';
                return;
            }
            $this->userModel->update($user['id'], $name, $email);
            if ($new_password !== '') {
                $this->userModel->updatePassword($user['id'], $new_password);
            }
            $_SESSION['user'] = $this->userModel->getById($user['id']);
            header('Location: index.php?controller=User&action=userDashboard');
            exit;
        }
        require __DIR__ . '/../views/user/editProfile.php';
    }

    // Delete own account
    public function deleteAccount() {
        if(!isset($_SESSION['user'])) {
            header('Location: index.php?controller=User&action=login');
            exit;
        }
        if ($_SESSION['user']['role'] === 'admin') {
            header('Location: index.php?controller=User&action=userDashboard');
            exit;
        }
        if($_SERVER['REQUEST_METHOD'] === 'POST' && csrf_verify()) {
            $this->userModel->delete($_SESSION['user']['id']);
            session_destroy();
            header('Location: index.php');
            exit;
        }
        header('Location: index.php?controller=User&action=userDashboard');
        exit;
    }
}