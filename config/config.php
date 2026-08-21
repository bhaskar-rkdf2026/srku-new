<?php
// Site Configuration & Auto URL Resolution for Local and GoDaddy Live Server
if (!defined('SITE_NAME')) {
    define('SITE_NAME', 'Sarvepalli Radhakrishnan University (SRKU)');
}

if (!defined('BASE_URL')) {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443)) ? "https://" : "http://";
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    
    // Determine the base path relative to the document root
    $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
    // If inside admin/ or other subfolder, trim back to root
    if (substr($scriptDir, -6) === '/admin') {
        $scriptDir = substr($scriptDir, 0, -6);
    } elseif (substr($scriptDir, -9) === '/includes') {
        $scriptDir = substr($scriptDir, 0, -9);
    } elseif (substr($scriptDir, -7) === '/config') {
        $scriptDir = substr($scriptDir, 0, -7);
    }
    
    $basePath = rtrim($scriptDir, '/') . '/';
    if ($basePath === '//') $basePath = '/';
    
    define('BASE_URL', $protocol . $host . $basePath);
}

// Database Credentials (Easily editable for GoDaddy cPanel MySQL)
if (!defined('DB_HOST')) define('DB_HOST', 'localhost');
if (!defined('DB_USER')) define('DB_USER', 'root');
if (!defined('DB_PASS')) define('DB_PASS', '');
if (!defined('DB_NAME')) define('DB_NAME', 'srku_db');

// Session Initialization
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
