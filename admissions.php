<?php
/**
 * Admissions Route Handler
 * Redirects visitors seamlessly to the primary Online Admission Enquiry portal.
 */
require_once __DIR__ . '/includes/functions.php';
header("Location: " . BASE_URL . "admission-enquiry.php", true, 301);
exit;
