<?php
require_once __DIR__ . '/includes/functions.php';

$pageTitle = "Online Teacher Feedback on Curriculum | RKDF IST | SRKU";
$pageDesc = "Submit online curriculum feedback by teachers for RKDF Institute of Science & Technology, Sarvepalli Radhakrishnan University Bhopal.";
$activeNav = "departments";

$submitted = false;
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_teacher_feedback'])) {
    $submitted = true;
    $msg = "Thank you Professor! Your curriculum feedback has been successfully submitted to the Academic Council & Registrar office.";
}

require_once __DIR__ . '/includes/header.php';
?>

<div class="py-5 bg-navy text-white text-center">
    <div class="container-xl py-2">
        <span class="badge bg-warning text-dark px-3 py-1 mb-2">Faculty &bull; Academic Review</span>
        <h1 class="fw-bold display-6 mb-2">Teacher Feedback on Curriculum</h1>
        <p class="text-warning mb-0">RKDF Institute of Science &amp; Technology &bull; Sarvepalli Radhakrishnan University</p>
    </div>
</div>

<div class="container-xl py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
            <div class="card p-4 p-md-5 border-0 shadow-sm rounded-4 bg-white">
                
                <?php if ($submitted): ?>
                    <div class="alert alert-success d-flex align-items-center gap-3 p-4 rounded-4 mb-4">
                        <i class="fas fa-check-circle fa-2x text-success"></i>
                        <div>
                            <h5 class="fw-bold mb-1">Feedback Submitted Successfully</h5>
                            <p class="mb-0 small"><?php echo sanitize($msg); ?></p>
                        </div>
                    </div>
                    <div class="text-center">
                        <a href="<?php echo BASE_URL; ?>department-detail.php?slug=rkdf-institute-of-science-and-technology" class="btn btn-srku px-4 py-2">Back to RKDF IST</a>
                    </div>
                <?php else: ?>
                    
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4 flex-wrap gap-2">
                        <div>
                            <h4 class="fw-bold text-navy mb-1">Faculty Curriculum Evaluation</h4>
                            <p class="text-muted small mb-0">Feedback on course structure, syllabus rigor, and industry orientation.</p>
                        </div>
                        <a href="<?php echo BASE_URL; ?>assets/pdf/rkdf-ist/feedback/teacher-curriculum-feedback.pdf" target="_blank" class="btn btn-outline-danger btn-sm">
                            <i class="fas fa-file-pdf me-1"></i> Download PDF Form
                        </a>
                    </div>

                    <form method="POST" action="">
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Faculty / Teacher Name *</label>
                                <input type="text" name="teacher_name" class="form-control" placeholder="Dr. / Prof. Full Name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Designation / Post Held *</label>
                                <input type="text" name="post_held" class="form-control" placeholder="e.g. Professor / Associate Professor" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-semibold">Course / Subject Name *</label>
                                <input type="text" name="course_name" class="form-control" placeholder="e.g. Data Structures / Thermodynamics" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-semibold">Department / College</label>
                                <input type="text" name="college" class="form-control" value="RKDF IST, SRKU Bhopal" readonly>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-semibold">Academic Year</label>
                                <input type="text" name="year" class="form-control" placeholder="e.g. 2026-27">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Official Email ID *</label>
                                <input type="email" name="teacher_email" class="form-control" placeholder="professor@srku.edu.in" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Contact Number</label>
                                <input type="text" name="contact_number" class="form-control" placeholder="10-digit Mobile Number">
                            </div>
                        </div>

                        <h6 class="fw-bold text-navy mb-3">Curriculum Evaluation Questions:</h6>
                        
                        <div class="p-3 bg-light rounded-3 mb-3 border">
                            <label class="form-label small fw-semibold mb-2">1. How did you find the curriculum standard &amp; rigor?</label>
                            <div class="d-flex gap-4">
                                <label class="form-check-label"><input type="radio" name="q1" value="Appropriate / Balanced" checked> Appropriate &amp; Balanced</label>
                                <label class="form-check-label"><input type="radio" name="q1" value="Challenging"> Challenging</label>
                                <label class="form-check-label"><input type="radio" name="q1" value="Needs Revision"> Needs Revision</label>
                            </div>
                        </div>

                        <div class="p-3 bg-light rounded-3 mb-3 border">
                            <label class="form-label small fw-semibold mb-2">2. Are the learning objectives and course outcomes well defined?</label>
                            <div class="d-flex gap-4">
                                <label class="form-check-label"><input type="radio" name="q2" value="Yes" checked> Yes</label>
                                <label class="form-check-label"><input type="radio" name="q2" value="Partially"> Partially</label>
                                <label class="form-check-label"><input type="radio" name="q2" value="No"> No</label>
                            </div>
                        </div>

                        <div class="p-3 bg-light rounded-3 mb-3 border">
                            <label class="form-label small fw-semibold mb-2">3. Does the syllabus offer adequate balance between theory and practical application?</label>
                            <div class="d-flex gap-4">
                                <label class="form-check-label"><input type="radio" name="q3" value="Yes" checked> Yes</label>
                                <label class="form-check-label"><input type="radio" name="q3" value="Needs More Lab Hours"> Needs More Lab Hours</label>
                            </div>
                        </div>

                        <div class="p-3 bg-light rounded-3 mb-4 border">
                            <label class="form-label small fw-semibold mb-2">4. Specific suggestions for updating syllabus or adding emerging technology topics:</label>
                            <textarea name="suggestions" class="form-control" rows="3" placeholder="Suggest new electives, lab tools, or syllabus modifications..."></textarea>
                        </div>

                        <div class="text-end">
                            <button type="submit" name="submit_teacher_feedback" class="btn btn-srku btn-lg px-5">
                                <i class="fas fa-paper-plane me-2"></i> Submit Curriculum Review
                            </button>
                        </div>
                    </form>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
