<?php
$pageTitle = "Courses & Programmes - SRK University";
$activeNav = "courses";
require_once __DIR__ . '/includes/header.php';

$pdo = getDBConnection();
$selectedDept = sanitize($_GET['dept'] ?? '');

$query = "SELECT * FROM courses WHERE status = 'active'";
$params = [];

if ($selectedDept) {
    $query .= " AND department LIKE :dept";
    $params[':dept'] = '%' . $selectedDept . '%';
}

$query .= " ORDER BY department ASC, course_name ASC";
$stmt = $pdo->prepare($query);
$stmt->execute($params);
$courses = $stmt->fetchAll();
?>

<!-- Banner Header -->
<div class="py-5 text-center text-white" style="background: linear-gradient(135deg, var(--srku-navy), var(--srku-maroon));">
    <div class="container-xl py-3">
        <h1 class="fw-bold display-5 mb-2">Academic Programmes &amp; Courses</h1>
        <p class="text-warning fw-semibold lead mb-0">Diploma, Undergraduate, Postgraduate &amp; Doctoral Degrees</p>
    </div>
</div>

<section class="py-5">
    <div class="container-xl py-3">
        
        <!-- FILTER BAR -->
        <div class="d-flex flex-wrap gap-2 justify-content-center mb-5">
            <a href="courses.php" class="btn <?php echo empty($selectedDept) ? 'btn-danger' : 'btn-light border'; ?>">All Programmes</a>
            <a href="courses.php?dept=Engineering" class="btn <?php echo $selectedDept == 'Engineering' ? 'btn-danger' : 'btn-light border'; ?>">Engineering</a>
            <a href="courses.php?dept=Pharmacy" class="btn <?php echo $selectedDept == 'Pharmacy' ? 'btn-danger' : 'btn-light border'; ?>">Pharmacy</a>
            <a href="courses.php?dept=Computer" class="btn <?php echo $selectedDept == 'Computer' ? 'btn-danger' : 'btn-light border'; ?>">Computer Science</a>
            <a href="courses.php?dept=Management" class="btn <?php echo $selectedDept == 'Management' ? 'btn-danger' : 'btn-light border'; ?>">Management</a>
            <a href="courses.php?dept=Nursing" class="btn <?php echo $selectedDept == 'Nursing' ? 'btn-danger' : 'btn-light border'; ?>">Nursing</a>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php if (!empty($courses)): ?>
                <?php foreach ($courses as $c): ?>
                    <div class="col">
                        <div class="card h-100 p-4 border-0 shadow-sm rounded-4">
                            <div>
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 rounded-pill fw-bold mb-3">
                                    <?php echo sanitize($c['department']); ?>
                                </span>
                            </div>
                            <h3 class="h5 fw-bold text-navy mb-3"><?php echo sanitize($c['course_name']); ?></h3>
                            <div class="text-muted small mb-4" style="line-height:1.7;">
                                <div><strong class="text-dark"><i class="far fa-clock text-danger me-1"></i> Duration:</strong> <?php echo sanitize($c['duration']); ?></div>
                                <div><strong class="text-dark"><i class="fas fa-graduation-cap text-danger me-1"></i> Eligibility:</strong> <?php echo sanitize($c['eligibility']); ?></div>
                                <div><strong class="text-dark"><i class="fas fa-rupee-sign text-danger me-1"></i> Fees:</strong> <?php echo sanitize($c['fees']); ?></div>
                            </div>
                            <a href="contact.php?course=<?php echo urlencode($c['course_name']); ?>" class="btn btn-srku w-100 mt-auto text-center justify-content-center">
                                Apply / Enquiry
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                    <p class="lead text-muted">No courses found matching this category.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
