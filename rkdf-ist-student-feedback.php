<?php
require_once __DIR__ . '/includes/functions.php';

$pageTitle = "Student Feedback Form | RKDF IST | SRKU Bhopal";
$pageDesc = "Download official Student Feedback Form for RKDF Institute of Science & Technology (RKDF IST), Sarvepalli Radhakrishnan University Bhopal.";
$pageKeywords = "Student Feedback Form RKDF IST, SRKU Feedback PDF, Engineering Feedback Form Bhopal";
$activeNav = "departments";
require_once __DIR__ . '/includes/header.php';

$pdfUrl = BASE_URL . 'assets/pdf/rkdf-ist/feedback/student-feedback.pdf';
?>

<!-- Banner Header -->
<div class="py-5 text-center text-white position-relative" style="background: linear-gradient(135deg, var(--srku-navy), var(--srku-maroon));">
    <div class="container-xl py-3">
        <span class="badge bg-warning text-dark fw-bold px-3 py-1 mb-2">RKDF IST &bull; Quality Assurance</span>
        <h1 class="fw-bold display-6 mb-2">Student Feedback Form</h1>
        <p class="text-warning fw-semibold lead mb-0">RKDF Institute of Science &amp; Technology, Sarvepalli Radhakrishnan University Bhopal</p>
    </div>
</div>

<section class="py-5 bg-light">
    <div class="container-xl py-2">
        
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb bg-white p-3 rounded-4 shadow-sm border mb-0 small">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>" class="text-navy text-decoration-none"><i class="fas fa-home me-1"></i> Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>departments.php" class="text-navy text-decoration-none">Departments</a></li>
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>department-detail.php?slug=rkdf-institute-of-science-and-technology" class="text-navy text-decoration-none">RKDF IST</a></li>
                <li class="breadcrumb-item active text-danger fw-bold" aria-current="page">Student Feedback Form</li>
            </ol>
        </nav>

        <!-- Top Action Callout Banner -->
        <div class="card p-4 p-lg-5 border-0 shadow rounded-4 text-white mb-5 position-relative overflow-hidden" style="background: linear-gradient(135deg, #7A0B0D 0%, #16233f 100%);">
            <div class="row align-items-center g-4 position-relative z-2">
                <div class="col-12 col-lg-8">
                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold mb-3">
                        <i class="fas fa-file-pdf me-1"></i> Prescribed Institutional Feedback Format
                    </span>
                    <h2 class="h2 fw-bold text-white mb-3">Student Feedback Form &mdash; RKDF IST</h2>
                    <p class="text-white-50 mb-4" style="line-height: 1.7; font-size: 0.98rem;">
                        Official curriculum and institutional evaluation document for students of RKDF Institute of Science &amp; Technology. Students can preview the full form below and download the official print-ready PDF copy.
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="<?php echo $pdfUrl; ?>" download="Student-Feedback-Form-RKDF-IST.pdf" class="btn btn-warning text-dark fw-bold px-4 py-3 rounded-pill shadow">
                            <i class="fas fa-download me-2"></i> Download Official PDF Form
                        </a>
                        <a href="<?php echo $pdfUrl; ?>" target="_blank" class="btn btn-outline-light fw-bold px-4 py-3 rounded-pill">
                            <i class="fas fa-external-link-alt me-2"></i> View PDF in Full Screen
                        </a>
                        <a href="#pdf-viewer" class="btn btn-light text-navy fw-bold px-4 py-3 rounded-pill">
                            <i class="fas fa-eye me-2"></i> Quick PDF Preview
                        </a>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="p-4 rounded-4 bg-white text-navy shadow-sm">
                        <h6 class="fw-bold text-navy mb-3"><i class="fas fa-info-circle text-danger me-2"></i> Document Overview</h6>
                        <ul class="list-unstyled d-flex flex-column gap-2 mb-0 small">
                            <li class="d-flex justify-content-between pb-2 border-bottom">
                                <span class="text-muted">Document Type:</span>
                                <strong class="text-navy">Official Feedback PDF</strong>
                            </li>
                            <li class="d-flex justify-content-between pb-2 border-bottom">
                                <span class="text-muted">Constituent Unit:</span>
                                <strong class="text-navy">RKDF IST</strong>
                            </li>
                            <li class="d-flex justify-content-between pb-2 border-bottom">
                                <span class="text-muted">Compliance:</span>
                                <strong class="text-success">IQAC &amp; AICTE Norms</strong>
                            </li>
                            <li class="d-flex justify-content-between">
                                <span class="text-muted">Target Audience:</span>
                                <strong class="text-navy">Enrolled Students</strong>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 g-lg-4 mb-5">
            
            <!-- Left Column: Interactive PDF Document Viewer -->
            <div class="col-12 col-lg-8 col-xl-9">
                
                <!-- PDF Preview Card -->
                <div class="card p-4 p-md-5 border-0 shadow-sm rounded-4 bg-white mb-4" id="pdf-viewer">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                        <div>
                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-1 rounded-pill small fw-bold mb-1">
                                <i class="fas fa-file-pdf me-1"></i> OFFICIAL DOCUMENT VIEWER
                            </span>
                            <h3 class="h4 fw-bold text-navy mb-0">Student Feedback Form Preview</h3>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="<?php echo $pdfUrl; ?>" download="Student-Feedback-Form-RKDF-IST.pdf" class="btn btn-sm btn-danger rounded-pill px-3 fw-bold">
                                <i class="fas fa-download me-1"></i> Download PDF
                            </a>
                            <a href="<?php echo $pdfUrl; ?>" target="_blank" class="btn btn-sm btn-outline-secondary rounded-pill px-3 fw-bold">
                                <i class="fas fa-external-link-alt me-1"></i> Fullscreen
                            </a>
                        </div>
                    </div>

                    <div class="border rounded-4 overflow-hidden shadow-sm bg-light" style="min-height: 650px; height: 800px;">
                        <iframe src="<?php echo $pdfUrl; ?>#toolbar=1" class="w-100 h-100" style="border:none;" title="Student Feedback Form PDF">
                            <p class="p-4 text-center text-muted">
                                Your browser does not support embedded PDF viewing. 
                                <a href="<?php echo $pdfUrl; ?>" target="_blank" class="btn btn-danger btn-sm ms-2">Click here to download and view the PDF.</a>
                            </p>
                        </iframe>
                    </div>
                </div>

            </div>

            <!-- Right Column: Quick Links & Helpdesk -->
            <div class="col-12 col-lg-4 col-xl-3">
                
                <!-- Other Feedback Forms -->
                <div class="card p-4 border-0 shadow-sm rounded-4 mb-4 bg-white border">
                    <h5 class="fw-bold text-navy mb-3 pb-2 border-bottom"><i class="fas fa-poll text-danger me-2"></i> Other Feedback Forms</h5>
                    <div class="d-flex flex-column gap-2">
                        <a href="<?php echo BASE_URL; ?>rkdf-ist-teacher-feedback.php" class="p-2 px-3 rounded-3 text-decoration-none text-dark bg-light hover-danger small d-flex justify-content-between align-items-center">
                            <span class="fw-semibold">Teacher Feedback</span>
                            <i class="fas fa-chevron-right text-muted small"></i>
                        </a>
                        <a href="<?php echo BASE_URL; ?>rkdf-ist-parent-feedback.php" class="p-2 px-3 rounded-3 text-decoration-none text-dark bg-light hover-danger small d-flex justify-content-between align-items-center">
                            <span class="fw-semibold">Parent Feedback</span>
                            <i class="fas fa-chevron-right text-muted small"></i>
                        </a>
                        <a href="<?php echo BASE_URL; ?>department-detail.php?slug=rkdf-institute-of-science-and-technology" class="p-2 px-3 rounded-3 text-decoration-none text-dark bg-light hover-danger small d-flex justify-content-between align-items-center">
                            <span class="fw-semibold">Back to RKDF IST</span>
                            <i class="fas fa-chevron-right text-muted small"></i>
                        </a>
                    </div>
                </div>

                <!-- Assistance / Helpdesk Box -->
                <div class="card p-4 border-0 shadow-sm rounded-4 bg-light border">
                    <h5 class="fw-bold text-navy mb-2"><i class="fas fa-headset text-danger me-2"></i> Need Help?</h5>
                    <p class="text-muted small mb-3">For any academic assistance or guidance regarding feedback submission:</p>
                    <div class="p-3 bg-white rounded-3 border mb-2 small">
                        <div class="fw-bold text-navy mb-1"><i class="fas fa-envelope text-danger me-2"></i> Email Contact:</div>
                        <a href="mailto:deanengg@srku.edu.in" class="text-decoration-none text-muted">deanengg@srku.edu.in</a>
                    </div>
                    <div class="p-3 bg-white rounded-3 border small">
                        <div class="fw-bold text-navy mb-1"><i class="fas fa-phone text-danger me-2"></i> Helpline:</div>
                        <span class="text-muted">0755 &ndash; 4911204</span>
                    </div>
                </div>

            </div>

        </div>

    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
