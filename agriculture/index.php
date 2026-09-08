<?php
/**
 * Faculty of Agriculture Route Handler
 * Directs visitors to the official Faculty of Agriculture department page.
 */
require_once __DIR__ . '/../includes/functions.php';
header("Location: " . BASE_URL . "department-detail.php?slug=faculty-of-agriculture", true, 301);
exit;
