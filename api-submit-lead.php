<?php
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
    exit;
}

$action = sanitize($_POST['action'] ?? '');

if ($action === 'submit_admission') {
    $res = saveEnquiryLead(
        $_POST['name'] ?? '',
        $_POST['email'] ?? '',
        $_POST['phone'] ?? '',
        $_POST['course'] ?? '',
        $_POST['message'] ?? '',
        'Quick Sticky Admission Popup',
        $_POST['father_name'] ?? '',
        $_POST['city'] ?? '',
        $_POST['state'] ?? ''
    );
    echo json_encode($res);
    exit;
}

if ($action === 'submit_grievance') {
    $res = saveComplaint(
        $_POST['name'] ?? '',
        $_POST['father_name'] ?? '',
        $_POST['enrollment_number'] ?? '',
        $_POST['email'] ?? '',
        $_POST['phone'] ?? '',
        $_POST['institute_name'] ?? '',
        $_POST['course_name'] ?? '',
        $_POST['year_semester'] ?? '',
        $_POST['complaint_type'] ?? '',
        $_POST['complaint_details'] ?? ''
    );
    echo json_encode($res);
    exit;
}

echo json_encode(['success' => false, 'error' => 'Unknown action.']);
