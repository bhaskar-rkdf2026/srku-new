<?php
$dir = __DIR__ . '/../';
$files = glob($dir . '*.php');

$target1 = '?' . ' loading="lazy" decoding="async">';
$target2 = '?' . ' loading="lazy">';
$replacement = '?' . '>';

foreach ($files as $file) {
    $content = file_get_contents($file);
    $content = str_replace($target1, $replacement, $content);
    $content = str_replace($target2, $replacement, $content);
    file_put_contents($file, $content);
}

echo "Fixed all tags cleanly.\n";
