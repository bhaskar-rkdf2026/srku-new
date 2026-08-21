<?php
require_once __DIR__ . '/../includes/functions.php';

$res1 = saveEnquiryLead('Amit Verma', 'amit.test@example.com', '9893012345', 'B.Tech AI & Data Science', 'Interested in admissions and hostel facilities.', 'Admissions 2026 Portal');
echo "Test 1 Valid Lead: " . json_encode($res1) . "\n";

$res2 = saveEnquiryLead('A', 'invalid-email', '123', '', '', 'Test Invalid');
echo "Test 2 Invalid Lead: " . json_encode($res2) . "\n";

$pdo = getDBConnection();
$leads = $pdo->query("SELECT id, name, email, phone, course, status, created_at FROM enquiries ORDER BY id DESC LIMIT 5")->fetchAll();
echo "Latest Leads in DB:\n";
print_r($leads);
