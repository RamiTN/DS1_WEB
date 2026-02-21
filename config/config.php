<?php
// config.php - global configuration for ChallengeHub

// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'challengehub');
define('DB_USER', 'root');
define('DB_PASS', '');

// Site configuration
define('BASE_URL', 'http://localhost/ds1_web'); // change if your folder is different
define('SITE_NAME', 'ChallengeHub');

// Other options
define('DEFAULT_ROLE', 'user');  // default role for new users
define('ADMIN_ROLE', 'admin');   // admin role name

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}