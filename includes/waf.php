<?php
/**
 * ==============================================================================
 * SRKU UNIVERSITY — HIGH-PERFORMANCE WEB APPLICATION FIREWALL (WAF)
 * Real-Time Protection against SQL Injection, XSS, RFI, LFI, and Path Traversal
 * ==============================================================================
 */

if (!defined('PATH_ROOT')) {
    define('PATH_ROOT', dirname(__DIR__));
}

class SRKU_Security_WAF {

    private static $blacklisted_patterns = [
        // 1. SQL Injection (SQLi) Signatures
        'sqli_union'      => '/(\bunion\b\s+(all\s+)?\bselect\b)/i',
        'sqli_schema'     => '/\b(information_schema|performance_schema|mysql\.(user|db|tables))\b/i',
        'sqli_sleep'      => '/\b(sleep\s*\(\s*\d+\s*\)|benchmark\s*\(\s*\d+\s*,\s*|pg_sleep\s*\()/i',
        'sqli_outfile'    => '/(\binto\s+(outfile|dumpfile)\b|\bload_file\s*\()/i',
        'sqli_concat'     => '/(\bgroup_concat\s*\(|\bchar\s*\(\s*\d+(\s*,\s*\d+)*\s*\)|\b0x[0-9a-f]{4,}\b)/i',
        'sqli_tautology'  => '/(\'\s*or\s*\'1\'\s*=\s*\'1|\'\s*or\s*1\s*=\s*1|"\s*or\s*"1"\s*=\s*"1|"\s*or\s*1\s*=\s*1|\b1\s*=\s*1\s*--|\b1\s*=\s*1\s*#)/i',
        'sqli_comments'   => '/(--[^\r\n]*$|\/\*!|\*\/[ \t]*\/\*)/i',

        // 2. Cross-Site Scripting (XSS) Signatures
        'xss_tags'        => '/<\s*(script|object|embed|applet|meta|link|style)\b[^>]*>/i',
        'xss_events'      => '/\b(onload|onerror|onclick|onmouseover|onfocus|onblur|onmouseenter|onmouseleave|onkeydown|onkeyup|onkeypress|onsubmit|onchange)\s*=/i',
        'xss_protocols'   => '/(javascript|vbscript|data|livescript)\s*:\s*[^\s]/i',
        'xss_eval'        => '/\b(eval|alert|prompt|confirm|document\.cookie|document\.domain|window\.location)\s*\(/i',
        'xss_base64'      => '/data\s*:\s*text\/html\s*;\s*base64/i',

        // 3. Local & Remote File Inclusion (LFI / RFI) & Path Traversal
        'traversal'       => '/(\.\.\/|\.\.\\|\.\.%2f|\.\.%5c|%2e%2e%2f|%2e%2e\/)/i',
        'rfi_wrappers'    => '/\b(php:\/\/|data:\/\/|expect:\/\/|input:\/\/|phar:\/\/|zip:\/\/|glob:\/\/)/i',
        'null_byte'       => '/(\x00|%00|\0)/',
        'proc_environ'    => '/(\/etc\/passwd|\/etc\/shadow|\/proc\/self\/environ|\/proc\/self\/cmdline)/i',

        // 4. Remote Code Execution (RCE) & PHP2Shell / WebShell Signatures
        'rce_system'      => '/\b(system|shell_exec|exec|passthru|proc_open|popen|pcntl_exec)\s*\(/i',
        'rce_php2shell'   => '/(-d\s+allow_url_include|-d\s+auto_prepend_file|-d\s+auto_append_file|-d\s+cgi\.force_redirect|php:\/\/input)/i',
        'rce_shell_cmds'  => '/\b(cmd\.exe|powershell(\.exe)?|\/bin\/(ba)?sh|wget\s+|curl\s+[^\s]+(\s*\|\s*(ba)?sh)|\bncat?\b)/i',

        // 5. WebShell, CGI Backdoors & Malware Probes
        'webshell_probes' => '/\b(alfasc|lord\.php|rimuru|deploy-all|c99|r57|wso|b374k|alfa\.php|alfa_team|shell\.php|cmd\.php|up\.php|uploader\.php|defunct|gs-dbus|udevd-sync)\b/i',
        'cgi_probes'      => '/\.(rimuru|cgi|pl|py|sh|bash)\b/i'
    ];

    /**
     * Run full security inspection on all incoming user inputs
     */
    public static function inspect() {
        // Enforce Secure Session Cookie settings before session starts
        self::hardenSessionSettings();

        // Check Request URI & Query String
        $uri = $_SERVER['REQUEST_URI'] ?? '';
        $qs  = $_SERVER['QUERY_STRING'] ?? '';
        self::checkPayload($uri, 'REQUEST_URI');
        self::checkPayload($qs, 'QUERY_STRING');

        // Check GET parameters
        if (!empty($_GET)) {
            self::scanArray($_GET, 'GET');
        }

        // Check POST parameters (allowing rich text in admin if authenticated)
        if (!empty($_POST)) {
            $isAdmin = (isset($_SESSION['admin_id']) || isset($_SESSION['user_id']) || strpos($_SERVER['REQUEST_URI'] ?? '', '/admin/') !== false);
            self::scanArray($_POST, 'POST', $isAdmin);
        }

        // Check COOKIE parameters
        if (!empty($_COOKIE)) {
            self::scanArray($_COOKIE, 'COOKIE');
        }

        // Check uploaded files for hidden PHP scripts or polyglots
        if (!empty($_FILES)) {
            self::scanFiles($_FILES);
        }

        // Sanitize Common ID parameters
        self::sanitizeKeyParams();
    }

    /**
     * Recursive Scanner for Array Inputs
     */
    private static function scanArray(&$array, $source, $allowRichText = false) {
        foreach ($array as $key => &$value) {
            // Check key name for injection attempts
            self::checkPayload($key, $source . '_KEY');

            if (is_array($value)) {
                self::scanArray($value, $source, $allowRichText);
            } else {
                // In admin rich text editors (like CKEditor content fields), skip strict XSS check on content
                $isRichTextField = $allowRichText && (
                    stripos($key, 'content') !== false || 
                    stripos($key, 'description') !== false || 
                    stripos($key, 'about') !== false ||
                    stripos($key, 'testimonial') !== false ||
                    stripos($key, 'message') !== false ||
                    stripos($key, 'body') !== false
                );

                self::checkPayload($value, $source . '[' . $key . ']', $isRichTextField);
            }
        }
    }

    /**
     * Check payload against blacklisted malicious patterns
     */
    private static function checkPayload($data, $source, $skipXss = false) {
        if (!is_string($data) || strlen($data) === 0) {
            return;
        }

        foreach (self::$blacklisted_patterns as $type => $pattern) {
            if ($skipXss && strpos($type, 'xss_') === 0) {
                continue;
            }

            if (preg_match($pattern, $data)) {
                self::blockAttack($type, $source, $data);
            }
        }
    }

    /**
     * Inspect uploaded files for embedded executable code, polyglots and dangerous extensions
     */
    private static function scanFiles($files) {
        foreach ($files as $fileKey => $fileData) {
            if (is_array($fileData['name'] ?? null)) {
                // Multi-file upload
                $count = count($fileData['name']);
                for ($i = 0; $i < $count; $i++) {
                    $name = $fileData['name'][$i] ?? '';
                    $tmp  = $fileData['tmp_name'][$i] ?? '';
                    self::inspectSingleUpload($name, $tmp, $fileKey . '[' . $i . ']');
                }
            } else {
                $name = $fileData['name'] ?? '';
                $tmp  = $fileData['tmp_name'] ?? '';
                self::inspectSingleUpload($name, $tmp, $fileKey);
            }
        }
    }

    private static function inspectSingleUpload($name, $tmp, $key) {
        if (empty($name) || empty($tmp) || !is_uploaded_file($tmp)) return;

        $dangerous_exts = ['php', 'php3', 'php4', 'php5', 'php7', 'php8', 'phtml', 'phar', 'inc', 'cgi', 'pl', 'py', 'sh', 'bash', 'exe', 'bat', 'cmd', 'vbs', 'rimuru', 'dat'];

        // 1. Check extension and double extensions
        $parts = explode('.', strtolower($name));
        $ext = end($parts);
        if (in_array($ext, $dangerous_exts, true)) {
            self::blockAttack('blocked_file_upload_ext', 'FILES[' . $key . ']', $name);
        }
        if (count($parts) > 2) {
            foreach ($parts as $p) {
                if (in_array($p, $dangerous_exts, true)) {
                    self::blockAttack('blocked_double_extension', 'FILES[' . $key . ']', $name);
                }
            }
        }

        // 2. Scan file content header for PHP open tags (polyglot detector like fb6.png)
        $chunk = @file_get_contents($tmp, false, null, 0, 4096);
        if ($chunk !== false && preg_match('/<\?(php|=|%)/i', $chunk)) {
            self::blockAttack('embedded_php_in_upload', 'FILES[' . $key . ']', $name);
        }
    }

    /**
     * Block Attack and Send Clean 403 Response
     */
    private static function blockAttack($type, $source, $data) {
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';
        $logEntry = sprintf(
            "[%s] BLOCKED ATTACK: Type=%s | Source=%s | IP=%s | URI=%s | Payload=%s\n",
            date('Y-m-d H:i:s'),
            $type,
            $source,
            $ip,
            substr($_SERVER['REQUEST_URI'] ?? '', 0, 150),
            substr(addslashes($data), 0, 200)
        );

        // Silent Security Logging in protected directory
        $logDir = PATH_ROOT . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'logs';
        if (!is_dir($logDir)) {
            @mkdir($logDir, 0755, true);
        }
        @file_put_contents($logDir . DIRECTORY_SEPARATOR . 'security.log', $logEntry, FILE_APPEND | LOCK_EX);

        // Return 403 Forbidden with security header
        if (!headers_sent()) {
            http_response_code(403);
            header('Content-Type: text/html; charset=utf-8');
            header('X-Security-Protection: Active-WAF');
        }

        echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>403 Forbidden - Request Blocked</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; background: #0A1B54; color: #fff; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; padding: 20px; box-sizing: border-box; }
        .box { background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.12); border-radius: 12px; padding: 40px; max-width: 500px; text-align: center; box-shadow: 0 20px 50px rgba(0,0,0,0.4); }
        h1 { color: #FFC107; font-size: 26px; margin: 0 0 12px 0; }
        p { color: rgba(255,255,255,0.8); font-size: 14px; line-height: 1.6; margin: 0 0 24px 0; }
        a { display: inline-block; background: #FFC107; color: #0A1B54; font-weight: bold; text-decoration: none; padding: 10px 24px; border-radius: 6px; text-transform: uppercase; font-size: 12px; letter-spacing: 0.8px; }
        a:hover { background: #e0a800; }
    </style>
</head>
<body>
    <div class="box">
        <h1>403 Forbidden</h1>
        <p>Your request was flagged and blocked by the Bhabha University Web Application Firewall for containing potentially unsafe parameters.</p>
        <a href="/">Return to Home</a>
    </div>
</body>
</html>';
        exit;
    }

    /**
     * Sanitize common identifier parameters
     */
    private static function sanitizeKeyParams() {
        if (isset($_GET['id'])) {
            if (is_numeric($_GET['id'])) {
                $_GET['id'] = (int)$_GET['id'];
            } else {
                $_GET['id'] = preg_replace('/[^a-zA-Z0-9_-]/', '', (string)$_GET['id']);
            }
        }
        if (isset($_GET['page'])) {
            if (is_numeric($_GET['page'])) {
                $_GET['page'] = (int)$_GET['page'];
            } else {
                $_GET['page'] = preg_replace('/[^a-zA-Z0-9_-]/', '', (string)$_GET['page']);
            }
        }
    }

    /**
     * Configure Secure Session Cookies
     */
    private static function hardenSessionSettings() {
        if (session_status() === PHP_SESSION_NONE) {
            $isHttps = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') || 
                       (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');

            @ini_set('session.cookie_httponly', '1');
            @ini_set('session.use_only_cookies', '1');
            @ini_set('session.cookie_samesite', 'Lax');
            if ($isHttps) {
                @ini_set('session.cookie_secure', '1');
            }
        }
    }
}

// Automatically initiate inspection on every request
SRKU_Security_WAF::inspect();
