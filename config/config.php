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

// ============================================================================
// ENVIRONMENT DETECTION & DATABASE CONFIGURATION
// ============================================================================
// Optional custom credentials file override (if present)
if (file_exists(__DIR__ . '/db_local.php')) {
    require_once __DIR__ . '/db_local.php';
}

$isLocalhost = (
    in_array($_SERVER['HTTP_HOST'] ?? '', ['localhost', '127.0.0.1']) ||
    (isset($_SERVER['SERVER_NAME']) && in_array($_SERVER['SERVER_NAME'], ['localhost', '127.0.0.1'])) ||
    (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' && file_exists('C:\\xampp'))
);

if ($isLocalhost) {
    // ----------------------------------------------------
    // LOCALHOST (XAMPP) SETTINGS
    // ----------------------------------------------------
    if (!defined('DB_HOST')) define('DB_HOST', '127.0.0.1');
    if (!defined('DB_USER')) define('DB_USER', 'root');
    if (!defined('DB_PASS')) define('DB_PASS', '');
    if (!defined('DB_NAME')) define('DB_NAME', 'srku_db_new');
} else {
    // ----------------------------------------------------
    // LIVE SERVER (cPanel / GoDaddy / Production) SETTINGS
    // ----------------------------------------------------
    // Enter your live cPanel MySQL credentials below:
    if (!defined('DB_HOST')) define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
    if (!defined('DB_USER')) define('DB_USER', getenv('DB_USER') ?: 'root');
    if (!defined('DB_PASS')) define('DB_PASS', getenv('DB_PASS') !== false ? getenv('DB_PASS') : '');
    if (!defined('DB_NAME')) define('DB_NAME', getenv('DB_NAME') ?: 'srku_db_new');
}

// Secure Session Initialization
if (session_status() === PHP_SESSION_NONE) {
    @ini_set('session.cookie_httponly', '1');
    @ini_set('session.use_only_cookies', '1');
    if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
        @ini_set('session.cookie_secure', '1');
    }
    session_start();
}
