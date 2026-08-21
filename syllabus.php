<?php
$pageTitle = "Scheme & Syllabus - Sarvepalli Radhakrishnan University, Bhopal";
$activeNav = "courses";
require_once __DIR__ . '/includes/header.php';

$departments = getDepartments(true);
?>

<!-- Dynamic Banner Header -->
<?php renderPageBanner('syllabus', 'Academic Curriculum & Syllabus', 'Semester-Wise Scheme of Examination, Course Structures & Learning Outcomes'); ?>

<section class="py-5">
    <div class="container-xl py-3">
        
        <div class="text-center mb-5" style="max-width:750px; margin:auto;">
            <span class="section-subtitle">CURRICULUM ARCHITECTURE</span>
            <h2 class="fw-bold text-navy">Download Course Scheme &amp; Syllabus</h2>
            <p class="text-muted">Designed in alignment with UGC, AICTE, PCI, and National Education Policy (NEP) guidelines with focus on practical competency and industry skills.</p>
        </div>

        <div class="row g-4">
            <?php foreach ($departments as $dept): 
                $courses = getCourses($dept['slug']);
                if (empty($courses)) continue;
            ?>
                <div class="col-12">
                    <div class="card p-4 p-md-5 border-0 shadow-sm rounded-4">
                        <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom">
                            <div class="bg-danger-subtle text-danger rounded-circle d-flex align-items-center justify-content-center" style="width:50px; height:50px; font-size:1.4rem;">
                                <i class="<?php echo sanitize($dept['icon'] ?: 'fas fa-book'); ?>"></i>
                            </div>
                            <div>
                                <h3 class="h4 fw-bold text-navy mb-0"><?php echo sanitize($dept['name']); ?></h3>
                                <small class="text-muted">Scheme &amp; Syllabus Documents</small>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover table-striped align-middle mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th style="width:40%;">Course / Programme</th>
                                        <th style="width:15%;">Level</th>
                                        <th style="width:15%;">Duration</th>
                                        <th style="width:30%;" class="text-end">Download Document</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($courses as $c): ?>
                                        <tr>
                                            <td>
                                                <strong><?php echo sanitize($c['course_name']); ?></strong>
                                            </td>
                                            <td><span class="badge bg-primary-subtle text-primary border"><?php echo sanitize($c['level']); ?></span></td>
                                            <td><span class="text-muted small"><?php echo sanitize($c['duration']); ?></span></td>
                                            <td class="text-end">
                                                <a href="<?php echo BASE_URL; ?>course-detail.php?slug=<?php echo urlencode($c['slug'] ?: $c['id']); ?>" class="btn btn-sm btn-outline-danger me-1">
                                                    <i class="fas fa-eye me-1"></i> View Details
                                                </a>
                                                <a href="<?php echo BASE_URL; ?>contact.php?course=<?php echo urlencode($c['course_name']); ?>" class="btn btn-sm btn-srku">
                                                    <i class="fas fa-file-pdf me-1"></i> Request Syllabus
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
