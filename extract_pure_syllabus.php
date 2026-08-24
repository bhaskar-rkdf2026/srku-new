<?php
$data = json_decode(file_get_contents(__DIR__ . '/syllabus_analysis.json'), true);

$globalDocStems = [
    'institutional-development-plan', 'accreditation-ranking', 'obc-minority', 
    'equaloppurtunitycell', 'officersofuniversity', 'statutes', 'nirf', 
    'antiragging', 'grievance', 'ordinance', 'eoa_report', 'approval', 
    'sponsoring', 'about-us', 'ugcinfo', 'nep-policy', 'women-grievance'
];

$pureSyllabus = [];

foreach ($data as $courseName => $info) {
    $pureSyllabus[$courseName] = [];
    foreach ($info['items'] as $item) {
        $u = strtolower($item['url']);
        $isGlobal = false;
        foreach ($globalDocStems as $stem) {
            if (strpos($u, $stem) !== false) {
                $isGlobal = true;
                break;
            }
        }
        if (!$isGlobal) {
            $pureSyllabus[$courseName][] = $item;
        }
    }
}

file_put_contents(__DIR__ . '/pure_syllabus_data.json', json_encode($pureSyllabus, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

foreach ($pureSyllabus as $cat => $items) {
    echo "\n=== $cat (" . count($items) . " PDFs) ===\n";
    foreach ($items as $idx => $it) {
        echo "  [" . ($idx + 1) . "] {$it['title']} -> {$it['url']}\n";
    }
}
