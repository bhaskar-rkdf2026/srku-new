<?php
/**
 * RKDF Institute of Science & Technology Route Handler
 * Directs visitors to the official RKDF IST department page.
 */
require_once __DIR__ . '/../includes/functions.php';
header("Location: " . BASE_URL . "department-detail.php?slug=rkdf-institute-of-science-and-technology", true, 301);
exit;
