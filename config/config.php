<?php
// Site Configuration
if (!defined('SITE_NAME')) {
    define('SITE_NAME', 'Sarvepalli Radhakrishnan University (SRKU)');
}

if (!defined('BASE_URL')) {
    define('BASE_URL', 'http://localhost/srku-new/');
}

// Database Credentials
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'srku_db');

// Session Initialization
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
