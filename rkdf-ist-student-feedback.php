<?php
require_once __DIR__ . '/includes/functions.php';

$pageTitle = "Online Student Feedback | RKDF IST | SRKU";
$pageDesc = "Submit online student feedback for RKDF Institute of Science & Technology, Sarvepalli Radhakrishnan University Bhopal.";
$activeNav = "departments";

$submitted = false;
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_feedback'])) {
    $submitted = true;
    $msg = "Thank you! Your feedback has been successfully submitted to the Academic Dean & Registrar office.";
}

require_once __DIR__ . '/includes/header.php';
?>

<div class="py-5 bg-navy text-white text-center">
    <div class="container-xl py-2">
        <span class="badge bg-danger px-3 py-1 mb-2">RKDF IST &bull; Quality Assurance</span>
        <h1 class="fw-bold display-6 mb-2">Online Student Feedback Form</h1>
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
                            <h4 class="fw-bold text-navy mb-1">Students Evaluation &amp; Feedback</h4>
                            <p class="text-muted small mb-0">Please evaluate your courses, facilities, and teaching quality.</p>
                        </div>
                        <a href="<?php echo BASE_URL; ?>assets/pdf/rkdf-ist/feedback/student-feedback.pdf" target="_blank" class="btn btn-outline-danger btn-sm">
                            <i class="fas fa-file-pdf me-1"></i> Download PDF Form
                        </a>
                    </div>

                    <form method="POST" action="">
                        <div class="row g-3 mb-4">
                            <div class="col-md-3">
                                <label class="form-label small fw-semibold">Academic Year *</label>
                                <input type="text" name="academic_year" class="form-control" placeholder="e.g. 2026-27" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small fw-semibold">Branch *</label>
                                <input type="text" name="branch" class="form-control" placeholder="e.g. CSE / ME / Civil" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small fw-semibold">Date *</label>
                                <input type="date" name="feedback_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small fw-semibold">Section</label>
                                <input type="text" name="section" class="form-control" placeholder="e.g. A / B">
                            </div>
                        </div>

                        <h6 class="fw-bold text-navy mb-3">Rate the Following Parameters:</h6>
                        <div class="table-responsive mb-4">
                            <table class="table table-bordered align-middle small">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 50px;">#</th>
                                        <th>Description</th>
                                        <th class="text-center" style="width: 80px;">Excellent</th>
                                        <th class="text-center" style="width: 80px;">Very Good</th>
                                        <th class="text-center" style="width: 80px;">Good</th>
                                        <th class="text-center" style="width: 80px;">Average</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $questions = [
                                        "Has the Teacher covered entire Syllabus?",
                                        "Has the Teacher covered relevant topics beyond Syllabus?",
                                        "Technical content and delivery style",
                                        "Communication skills & clarity in concepts",
                                        "Practical laboratory demonstrations & experiments",
                                        "Overall learning experience & effectiveness"
                                    ];
                                    foreach ($questions as $i => $q): ?>
                                        <tr>
                                            <td><?php echo $i + 1; ?></td>
                                            <td><?php echo $q; ?></td>
                                            <td class="text-center"><input type="radio" name="rating_<?php echo $i; ?>" value="EX" required></td>
                                            <td class="text-center"><input type="radio" name="rating_<?php echo $i; ?>" value="VG"></td>
                                            <td class="text-center"><input type="radio" name="rating_<?php echo $i; ?>" value="G"></td>
                                            <td class="text-center"><input type="radio" name="rating_<?php echo $i; ?>" value="A"></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <h6 class="fw-bold text-navy mb-3">Facility Feedback &amp; Suggestions</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Library Facility:</label>
                                <textarea name="suggest_library" class="form-control" rows="2" placeholder="Your feedback on library resources..."></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Internet &amp; Computing Facility:</label>
                                <textarea name="suggest_internet" class="form-control" rows="2" placeholder="Wi-Fi, computing lab access..."></textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-semibold">General Feedback / Recommendations:</label>
                                <textarea name="suggest_other" class="form-control" rows="2" placeholder="Any additional suggestions..."></textarea>
                            </div>
                        </div>

                        <div class="p-3 bg-light rounded-3 mb-4 border">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label small fw-semibold">Student Name (Optional):</label>
                                    <input type="text" name="student_name" class="form-control form-control-sm" placeholder="Your Name">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-semibold">Attendance %:</label>
                                    <input type="number" name="attendance" class="form-control form-control-sm" placeholder="e.g. 85">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-semibold">Current CGPA / %:</label>
                                    <input type="text" name="cgpa" class="form-control form-control-sm" placeholder="e.g. 8.2">
                                </div>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" name="submit_feedback" class="btn btn-srku btn-lg px-5">
                                <i class="fas fa-paper-plane me-2"></i> Submit Feedback
                            </button>
                        </div>
                    </form>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
