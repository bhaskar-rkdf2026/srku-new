<?php
require_once __DIR__ . '/includes/functions.php';

$pageTitle = "Online Parent Feedback Form | RKDF IST | SRKU";
$pageDesc = "Submit online parent feedback for RKDF Institute of Science & Technology, Sarvepalli Radhakrishnan University Bhopal.";
$activeNav = "departments";

$submitted = false;
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_parent_feedback'])) {
    $submitted = true;
    $msg = "Thank you! Your feedback as a parent has been received and will help us further strengthen academic support & campus safety.";
}

require_once __DIR__ . '/includes/header.php';
?>

<div class="py-5 bg-navy text-white text-center">
    <div class="container-xl py-2">
        <span class="badge bg-danger px-3 py-1 mb-2">Stakeholder Engagement</span>
        <h1 class="fw-bold display-6 mb-2">Parents Feedback Form</h1>
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
                            <h4 class="fw-bold text-navy mb-1">Parent's Feedback &amp; Institutional Review</h4>
                            <p class="text-muted small mb-0">Your valuable perspective helps us provide better mentorship, safety, and training.</p>
                        </div>
                        <a href="<?php echo BASE_URL; ?>assets/pdf/rkdf-ist/feedback/parent-feedback.pdf" target="_blank" class="btn btn-outline-danger btn-sm">
                            <i class="fas fa-file-pdf me-1"></i> Download PDF Form
                        </a>
                    </div>

                    <form method="POST" action="">
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Parent's Full Name *</label>
                                <input type="text" name="parent_name" class="form-control" placeholder="Mr. / Mrs. Full Name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Ward / Student's Name *</label>
                                <input type="text" name="student_name" class="form-control" placeholder="Son / Daughter Name" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-semibold">Branch &amp; Year *</label>
                                <input type="text" name="branch_year" class="form-control" placeholder="e.g. B.Tech CSE, 2nd Year" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-semibold">Contact Mobile *</label>
                                <input type="tel" name="phone" class="form-control" placeholder="10-digit Mobile" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-semibold">Email Address</label>
                                <input type="email" name="email" class="form-control" placeholder="parent@gmail.com">
                            </div>
                        </div>

                        <h6 class="fw-bold text-navy mb-3">Rate the Following Institutional Parameters:</h6>
                        <div class="table-responsive mb-4">
                            <table class="table table-bordered align-middle small">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 50px;">#</th>
                                        <th>Evaluation Parameter</th>
                                        <th class="text-center" style="width: 90px;">Excellent</th>
                                        <th class="text-center" style="width: 90px;">Good</th>
                                        <th class="text-center" style="width: 90px;">Satisfactory</th>
                                        <th class="text-center" style="width: 90px;">Needs Impr.</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $parentQuestions = [
                                        "Academic atmosphere and discipline in the campus",
                                        "Quality of teaching faculty and practical guidance",
                                        "Campus security, infrastructure, and hygiene standards",
                                        "Mentorship, placement training & career counseling",
                                        "Communication regarding student attendance & performance",
                                        "Overall satisfaction with SRKU RKDF IST"
                                    ];
                                    foreach ($parentQuestions as $i => $pq): ?>
                                        <tr>
                                            <td><?php echo $i + 1; ?></td>
                                            <td><?php echo $pq; ?></td>
                                            <td class="text-center"><input type="radio" name="p_rating_<?php echo $i; ?>" value="Excellent" required></td>
                                            <td class="text-center"><input type="radio" name="p_rating_<?php echo $i; ?>" value="Good"></td>
                                            <td class="text-center"><input type="radio" name="p_rating_<?php echo $i; ?>" value="Satisfactory"></td>
                                            <td class="text-center"><input type="radio" name="p_rating_<?php echo $i; ?>" value="Needs Improvement"></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-semibold">Any Specific Suggestions / Message for Management:</label>
                            <textarea name="parent_suggestions" class="form-control" rows="3" placeholder="Please write your suggestions here..."></textarea>
                        </div>

                        <div class="text-end">
                            <button type="submit" name="submit_parent_feedback" class="btn btn-srku btn-lg px-5">
                                <i class="fas fa-paper-plane me-2"></i> Submit Parent Feedback
                            </button>
                        </div>
                    </form>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
