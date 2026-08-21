<?php
$dir = __DIR__ . '/../';
$files = glob($dir . '*.php');

foreach ($files as $file) {
    $content = file_get_contents($file);
    
    // First remove any broken <?php ... ? loading="lazy" decoding="async">
    $content = preg_replace('/<\?php\s+echo\s+BASE_URL;\s*\?\s*loading="lazy"\s*decoding="async">/i', '<?php echo BASE_URL; ?>', $content);
    $content = preg_replace('/<\?php\s+echo\s+BASE_URL;\s*\?\s*loading="lazy">/i', '<?php echo BASE_URL; ?>', $content);
    
    // Cleanly ensure loading="lazy" decoding="async" is placed before closing > of <img>
    // Only on html <img> tags
    $content = preg_replace_callback('/<img\s+([^>]+?)(\/?)>/i', function($m) {
        $attrs = $m[1];
        $slash = $m[2];
        
        // Remove duplicated loading/decoding
        $attrs = preg_replace('/\s*loading=["\'][^"\']*["\']/i', '', $attrs);
        $attrs = preg_replace('/\s*decoding=["\'][^"\']*["\']/i', '', $attrs);
        
        $attrs = trim($attrs) . ' loading="lazy" decoding="async"';
        return '<img ' . $attrs . ($slash ? ' /' : '') . '>';
    }, $content);

    // Also clean iframes
    $content = preg_replace_callback('/<iframe\s+([^>]+?)(\/?)>/i', function($m) {
        $attrs = $m[1];
        $slash = $m[2];
        $attrs = preg_replace('/\s*loading=["\'][^"\']*["\']/i', '', $attrs);
        $attrs = trim($attrs) . ' loading="lazy"';
        return '<iframe ' . $attrs . ($slash ? ' /' : '') . '>';
    }, $content);

    file_put_contents($file, $content);
}

echo "Cleaned and properly structured lazy loading on all templates.\n";
