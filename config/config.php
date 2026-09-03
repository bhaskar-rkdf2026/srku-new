<?php
// Site Configuration & Auto URL Resolution for Local and GoDaddy Live Server
if (!defined('SITE_NAME')) {
    define('SITE_NAME', 'Sarvepalli Radhakrishnan University (SRKU)');
}

if (!defined('BASE_URL')) {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443)) ? "https://" : "http://";
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    
    // Determine base path relative to web root
    $docRoot = isset($_SERVER['DOCUMENT_ROOT']) ? str_replace('\\', '/', realpath($_SERVER['DOCUMENT_ROOT']) ?: '') : '';
    $projRoot = str_replace('\\', '/', realpath(__DIR__ . '/..') ?: '');
    
    if ($docRoot && $projRoot && strpos($projRoot, $docRoot) === 0) {
        $sub = trim(substr($projRoot, strlen($docRoot)), '/');
        $basePath = $sub ? '/' . $sub . '/' : '/';
    } else {
        $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
        $scriptDir = preg_replace('/(\/admin|\/includes|\/config|\/scratch|\/api)$/i', '', $scriptDir);
        $basePath = rtrim($scriptDir, '/') . '/';
        if ($basePath === '//' || empty($basePath)) $basePath = '/';
    }
    
    define('BASE_URL', $protocol . $host . $basePath);
}

// Database Credentials (Auto-resolves with fallback for Localhost & GoDaddy cPanel MySQL)
if (!defined('DB_HOST')) define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
if (!defined('DB_USER')) define('DB_USER', getenv('DB_USER') ?: 'root');
if (!defined('DB_PASS')) define('DB_PASS', getenv('DB_PASS') !== false ? getenv('DB_PASS') : '');
if (!defined('DB_NAME')) define('DB_NAME', getenv('DB_NAME') ?: 'srku_db');

// Session Initialization
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
