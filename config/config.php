<?php
// config.php - global configuration for ChallengeHub

// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'challengehub');
define('DB_USER', 'root');
define('DB_PASS', '');

// Site configuration
define('BASE_URL', 'http://localhost/ds1_web/'); // change if your folder is different
define('SITE_NAME', 'ChallengeHub');

// Other options
define('DEFAULT_ROLE', 'user');  // default role for new users
define('ADMIN_ROLE', 'admin');   // admin role name

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// CSRF token helpers
function csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}
function csrf_field() {
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars(csrf_token()) . '">';
}
function csrf_verify() {
    return isset($_POST['csrf_token'], $_SESSION['csrf_token'])
        && hash_equals($_SESSION['csrf_token'], $_POST['csrf_token']);
}