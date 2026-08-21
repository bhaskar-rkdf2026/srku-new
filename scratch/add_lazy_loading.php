<?php
$dir = __DIR__ . '/../';
$files = glob($dir . '*.php');

$totalModified = 0;
foreach ($files as $file) {
    $content = file_get_contents($file);
    $orig = $content;
    
    // Add loading="lazy" decoding="async" to <img> tags if missing
    $content = preg_replace_callback('/<img\b([^>]*?)>/i', function($matches) {
        $attrs = $matches[1];
        if (stripos($attrs, 'loading=') === false) {
            $attrs .= ' loading="lazy"';
        }
        if (stripos($attrs, 'decoding=') === false) {
            $attrs .= ' decoding="async"';
        }
        return '<img' . $attrs . '>';
    }, $content);

    // Add loading="lazy" to <iframe> tags if missing
    $content = preg_replace_callback('/<iframe\b([^>]*?)>/i', function($matches) {
        $attrs = $matches[1];
        if (stripos($attrs, 'loading=') === false) {
            $attrs .= ' loading="lazy"';
        }
        return '<iframe' . $attrs . '>';
    }, $content);

    if ($content !== $orig) {
        file_put_contents($file, $content);
        echo "Updated: " . basename($file) . "\n";
        $totalModified++;
    }
}
echo "Total files updated with lazy loading: $totalModified\n";
