<?php
$pageTitle = "Ph.D. Application Form 2026 | Guidelines, Checklist & PDF Download | SRKU Bhopal";
$pageDesc = "Download official Ph.D. Application Form for Sarvepalli Radhakrishnan University (SRKU) Bhopal. Check submission instructions, enclosure checklist, research proposal guidelines, and entrance exemption rules.";
$pageKeywords = "PhD Application Form SRKU, PhD Form Bhopal, Doctoral Application PDF, UGC PhD Admission Form SRKU, PhD Research Synopsis";
$activeNav = "admission";
require_once __DIR__ . '/includes/header.php';
?>

<!-- Banner Header -->
<?php renderPageBanner('phd-application', 'Ph.D. Application Form & Guidelines 2026', 'Official Doctoral Research Admission Application Form, Submission Guidelines & Document Checklist'); ?>

<section class="py-5 bg-light">
    <div class="container-xl py-2">
        
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb bg-white p-3 rounded-4 shadow-sm border mb-0">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>" class="text-navy text-decoration-none"><i class="fas fa-home me-1"></i> Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>phd-admission.php" class="text-navy text-decoration-none">Ph.D. Admission</a></li>
                <li class="breadcrumb-item active text-danger fw-bold" aria-current="page">Ph.D. Application Form</li>
            </ol>
        </nav>

        <!-- Top Action Callout Banner -->
        <div class="card p-4 p-lg-5 border-0 shadow rounded-4 text-white mb-5 position-relative overflow-hidden" style="background: linear-gradient(135deg, #7A0B0D 0%, #16233f 100%);">
            <div class="row align-items-center g-4 position-relative z-2">
                <div class="col-12 col-lg-8">
                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold mb-3">
                        <i class="fas fa-file-alt me-1"></i> Prescribed Form for Doctoral Admission
                    </span>
                    <h2 class="h2 fw-bold text-white mb-3">Ph.D. Application Form (Academic Session 2026-27)</h2>
                    <p class="text-white-50 mb-4" style="line-height: 1.7; font-size: 0.98rem;">
                        This official application form is to be submitted by all candidates seeking admission to the Doctor of Philosophy (Ph.D.) programme at Sarvepalli Radhakrishnan University (SRKU), either for appearing in the Doctoral Entrance Test (DET) or claiming entrance exemption (UGC-NET / GATE / SLET / GPAT / JRF / M.Phil).
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="<?php echo BASE_URL; ?>assets/uploads/pdf/phd-application-form.pdf" download class="btn btn-warning text-dark fw-bold px-4 py-3 rounded-pill shadow">
                            <i class="fas fa-download me-2"></i> Download Official PDF Form
                        </a>
                        <a href="<?php echo BASE_URL; ?>assets/uploads/pdf/phd-application-form.pdf" target="_blank" class="btn btn-outline-light fw-bold px-4 py-3 rounded-pill">
                            <i class="fas fa-external-link-alt me-2"></i> View PDF in Full Screen
                        </a>
                        <a href="#pdf-viewer" class="btn btn-light text-navy fw-bold px-4 py-3 rounded-pill">
                            <i class="fas fa-eye me-2"></i> Quick PDF Preview
                        </a>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="p-4 rounded-4 bg-white text-navy shadow-sm">
                        <h6 class="fw-bold text-navy mb-3"><i class="fas fa-info-circle text-danger me-2"></i> Form Quick Facts</h6>
                        <ul class="list-unstyled d-flex flex-column gap-2 mb-0 small">
                            <li class="d-flex justify-content-between pb-2 border-bottom">
                                <span class="text-muted">Document Type:</span>
                                <strong class="text-navy">Official Application PDF</strong>
                            </li>
                            <li class="d-flex justify-content-between pb-2 border-bottom">
                                <span class="text-muted">Total Pages:</span>
                                <strong class="text-navy">4 Pages</strong>
                            </li>
                            <li class="d-flex justify-content-between pb-2 border-bottom">
                                <span class="text-muted">Regulation Norms:</span>
                                <strong class="text-success">UGC / AICTE Compliant</strong>
                            </li>
                            <li class="d-flex justify-content-between">
                                <span class="text-muted">Enclosures:</span>
                                <strong class="text-navy">Documents &amp; Synopsis</strong>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 g-lg-5 mb-5">
            
            <!-- Left Column: Interactive Form Document Viewer -->
            <div class="col-12 col-lg-8">
                
                <!-- PDF Preview Card -->
                <div class="card p-4 p-md-5 border-0 shadow-sm rounded-4 bg-white mb-4" id="pdf-viewer">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                        <div>
                            <span class="section-subtitle"><i class="fas fa-file-pdf text-danger me-1"></i> OFFICIAL PDF PREVIEW</span>
                            <h3 class="h4 fw-bold text-navy mb-0">Interactive Form Document</h3>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="<?php echo BASE_URL; ?>assets/uploads/pdf/phd-application-form.pdf" download class="btn btn-sm btn-danger rounded-pill px-3 fw-bold">
                                <i class="fas fa-download me-1"></i> Download PDF
                            </a>
                            <a href="<?php echo BASE_URL; ?>assets/uploads/pdf/phd-application-form.pdf" target="_blank" class="btn btn-sm btn-outline-navy rounded-pill px-3 fw-bold">
                                <i class="fas fa-external-link-alt me-1"></i> Open Fullscreen
                            </a>
                        </div>
                    </div>

                    <div class="ratio ratio-4x3 border rounded-4 overflow-hidden shadow-sm bg-light" style="min-height: 550px;">
                        <iframe src="<?php echo BASE_URL; ?>assets/uploads/pdf/phd-application-form.pdf#toolbar=1" class="w-100 h-100" style="border:none;" title="Ph.D. Application Form PDF">
                            <p class="p-4 text-center text-muted">
                                Your browser does not support embedded PDF viewing. 
                                <a href="<?php echo BASE_URL; ?>assets/uploads/pdf/phd-application-form.pdf" target="_blank" class="btn btn-danger btn-sm ms-2">Click here to download and view the PDF.</a>
                            </p>
                        </iframe>
                    </div>
                </div>

            </div>

            <!-- Right Sidebar: Submission Address & Related Forms -->
            <div class="col-12 col-lg-4">
                
                <!-- Submission Details Card -->
                <div class="card p-4 border-0 shadow-sm rounded-4 bg-white mb-4">
                    <h5 class="fw-bold text-navy mb-3"><i class="fas fa-paper-plane text-danger me-2"></i> Form Submission Desk</h5>
                    <p class="text-muted small mb-3">
                        Submit the completed application form along with self-attested photocopies of all required certificates in person or via registered post/courier to:
                    </p>
                    <div class="p-3 rounded-3 bg-light border small text-muted mb-3">
                        <strong class="text-navy d-block mb-1"><i class="fas fa-university text-danger me-1"></i> The Office of Dean Research / Ph.D. Cell</strong>
                        Sarvepalli Radhakrishnan University (SRKU)<br>
                        NH-12, Hoshangabad Road, Misrod,<br>
                        Bhopal, Madhya Pradesh - 462026
                    </div>
                    <div class="d-flex flex-column gap-2 small">
                        <a href="tel:7024144981" class="text-decoration-none text-navy fw-semibold p-2 rounded-3 bg-light border d-flex align-items-center">
                            <i class="fas fa-phone-alt text-danger me-2"></i> Ph.D. Helpline: 7024144981
                        </a>
                        <a href="mailto:info@srku.edu.in" class="text-decoration-none text-navy fw-semibold p-2 rounded-3 bg-light border d-flex align-items-center">
                            <i class="fas fa-envelope text-primary me-2"></i> info@srku.edu.in
                        </a>
                    </div>
                </div>

                <!-- Related Doctoral Links -->
                <div class="card p-4 border-0 shadow-sm rounded-4 bg-white mb-4">
                    <h5 class="fw-bold text-navy mb-3"><i class="fas fa-link text-warning me-2"></i> Related Ph.D. Portals</h5>
                    <ul class="list-unstyled d-flex flex-column gap-2 mb-0 small">
                        <li>
                            <a href="<?php echo BASE_URL; ?>phd-entrance-form.php" class="text-navy text-decoration-none p-2 rounded-3 bg-light border d-flex align-items-center justify-content-between hover-text-danger">
                                <span class="fw-semibold"><i class="fas fa-file-signature text-danger me-2"></i> Ph.D. Entrance Exam Form</span>
                                <i class="fas fa-chevron-right text-muted"></i>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo BASE_URL; ?>phd-admission.php" class="text-navy text-decoration-none p-2 rounded-3 bg-light border d-flex align-items-center justify-content-between hover-text-danger">
                                <span class="fw-semibold"><i class="fas fa-graduation-cap text-primary me-2"></i> Ph.D. Admission Main Portal</span>
                                <i class="fas fa-chevron-right text-muted"></i>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo BASE_URL; ?>assets/uploads/pdf/phd-admission-policy.pdf" target="_blank" class="text-navy text-decoration-none p-2 rounded-3 bg-light border d-flex align-items-center justify-content-between hover-text-danger">
                                <span class="fw-semibold"><i class="fas fa-gavel text-warning me-2"></i> Ph.D. Admission Policy</span>
                                <i class="fas fa-download text-muted"></i>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo BASE_URL; ?>research-innovation.php" class="text-navy text-decoration-none p-2 rounded-3 bg-light border d-flex align-items-center justify-content-between hover-text-danger">
                                <span class="fw-semibold"><i class="fas fa-flask text-success me-2"></i> Research &amp; Innovation</span>
                                <i class="fas fa-chevron-right text-muted"></i>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Online Quick Pre-Registration Link -->
                <div class="card p-4 border-0 shadow rounded-4 text-white text-center" style="background: linear-gradient(135deg, var(--srku-maroon), var(--srku-navy));">
                    <i class="fas fa-laptop-code fa-3x text-warning mb-3"></i>
                    <h5 class="fw-bold text-white mb-2">Apply Online First</h5>
                    <p class="text-white-50 small mb-3">Submit your research interest online for rapid doctoral counseling &amp; test slot allotment.</p>
                    <a href="<?php echo BASE_URL; ?>phd-admission.php#apply" class="btn btn-warning text-dark fw-bold rounded-pill w-100 py-2">
                        <i class="fas fa-paper-plane me-1"></i> Pre-Register Online
                    </a>
                </div>

            </div>

        </div>

    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
