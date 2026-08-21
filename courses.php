<?php
$pageTitle = "Academic Programmes & Courses - SRK University Bhopal";
$activeNav = "courses";
require_once __DIR__ . '/includes/header.php';

$selectedDept = sanitize($_GET['dept'] ?? '');
$selectedLevel = sanitize($_GET['level'] ?? '');
$searchKeyword = sanitize($_GET['search'] ?? '');

$courses = getCourses($selectedDept, $selectedLevel, $searchKeyword);
$departments = getDepartments(true);
?>

<!-- Dynamic Banner Header -->
<?php renderPageBanner('courses', 'Academic Programmes & Degrees', 'Undergraduate (UG), Postgraduate (PG), Diploma & Doctoral Research Programs'); ?>

<section class="py-5">
    <div class="container-xl py-3">
        
        <!-- SEARCH & FILTER BAR -->
        <div class="card p-4 border-0 shadow-sm rounded-4 mb-5 bg-light">
            <form action="<?php echo BASE_URL; ?>courses.php" method="GET" class="row g-3 align-items-center">
                
                <div class="col-12 col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" name="search" class="form-control border-start-0" placeholder="Search by degree name or keywords (e.g. B.Tech, MBA, Pharmacy)..." value="<?php echo sanitize($searchKeyword); ?>">
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <select name="dept" class="form-select">
                        <option value="">-- All Departments --</option>
                        <?php foreach ($departments as $d): ?>
                            <option value="<?php echo sanitize($d['slug']); ?>" <?php echo ($selectedDept == $d['slug'] || $selectedDept == $d['name']) ? 'selected' : ''; ?>>
                                <?php echo sanitize($d['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-12 col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-srku flex-grow-1"><i class="fas fa-filter me-1"></i> Filter</button>
                    <?php if ($selectedDept || $selectedLevel || $searchKeyword): ?>
                        <a href="<?php echo BASE_URL; ?>courses.php" class="btn btn-outline-secondary"><i class="fas fa-times"></i></a>
                    <?php endif; ?>
                </div>

            </form>

            <!-- Degree Level Pills -->
            <div class="d-flex flex-wrap gap-2 mt-3 pt-3 border-top justify-content-center">
                <a href="<?php echo BASE_URL; ?>courses.php<?php echo $selectedDept ? '?dept=' . urlencode($selectedDept) : ''; ?>" 
                   class="badge px-3 py-2 text-decoration-none rounded-pill <?php echo empty($selectedLevel) ? 'bg-danger text-white' : 'bg-white text-dark border'; ?>">
                    All Degrees (<?php echo count(getCourses($selectedDept, null, $searchKeyword)); ?>)
                </a>
                <a href="<?php echo BASE_URL; ?>courses.php?level=UG<?php echo $selectedDept ? '&dept=' . urlencode($selectedDept) : ''; ?>" 
                   class="badge px-3 py-2 text-decoration-none rounded-pill <?php echo $selectedLevel == 'UG' ? 'bg-danger text-white' : 'bg-white text-dark border'; ?>">
                    Undergraduate (UG)
                </a>
                <a href="<?php echo BASE_URL; ?>courses.php?level=PG<?php echo $selectedDept ? '&dept=' . urlencode($selectedDept) : ''; ?>" 
                   class="badge px-3 py-2 text-decoration-none rounded-pill <?php echo $selectedLevel == 'PG' ? 'bg-danger text-white' : 'bg-white text-dark border'; ?>">
                    Postgraduate (PG)
                </a>
                <a href="<?php echo BASE_URL; ?>courses.php?level=Diploma<?php echo $selectedDept ? '&dept=' . urlencode($selectedDept) : ''; ?>" 
                   class="badge px-3 py-2 text-decoration-none rounded-pill <?php echo $selectedLevel == 'Diploma' ? 'bg-danger text-white' : 'bg-white text-dark border'; ?>">
                    Diploma &amp; Polytechnic
                </a>
            </div>

        </div>

        <!-- COURSE CARDS GRID -->
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php if (!empty($courses)): ?>
                <?php foreach ($courses as $c): ?>
                    <div class="col">
                        <div class="card h-100 p-4 border-0 shadow-sm rounded-4 d-flex flex-column hover-shadow">
                            
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-1 rounded-pill small fw-bold">
                                    <?php echo sanitize($c['department']); ?>
                                </span>
                                <span class="badge bg-primary-subtle text-primary border small">
                                    <?php echo sanitize($c['level']); ?>
                                </span>
                            </div>

                            <h3 class="h5 fw-bold text-navy mb-3"><?php echo sanitize($c['course_name']); ?></h3>

                            <div class="text-muted small mb-4 flex-grow-1" style="line-height:1.7;">
                                <div class="mb-1"><strong class="text-dark"><i class="far fa-clock text-danger me-1"></i> Duration:</strong> <?php echo sanitize($c['duration']); ?></div>
                                <div class="mb-1"><strong class="text-dark"><i class="fas fa-graduation-cap text-danger me-1"></i> Eligibility:</strong> <?php echo sanitize($c['eligibility']); ?></div>
                                <?php if (!empty($c['fees'])): ?>
                                    <div><strong class="text-dark"><i class="fas fa-rupee-sign text-danger me-1"></i> Academic Fee:</strong> <span class="text-danger fw-bold"><?php echo sanitize($c['fees']); ?></span></div>
                                <?php endif; ?>
                            </div>

                            <div class="d-flex gap-2 mt-auto pt-2 border-top">
                                <a href="<?php echo BASE_URL; ?>course-detail.php?slug=<?php echo urlencode($c['slug'] ?: $c['id']); ?>" class="btn btn-sm btn-outline-danger flex-grow-1 text-center justify-content-center">
                                    View Syllabus
                                </a>
                                <a href="<?php echo BASE_URL; ?>contact.php?course=<?php echo urlencode($c['course_name']); ?>" class="btn btn-sm btn-srku flex-grow-1 text-center justify-content-center">
                                    Apply Now
                                </a>
                            </div>

                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                    <h4 class="text-navy fw-bold">No programmes found</h4>
                    <p class="text-muted">No courses match your filter criteria. Try resetting filters or search terms.</p>
                    <a href="<?php echo BASE_URL; ?>courses.php" class="btn btn-srku px-4 py-2">Reset All Filters</a>
                </div>
            <?php endif; ?>
        </div>

    </div>
</section>

<!-- CTA Bar -->
<section class="py-5 text-center text-white" style="background: linear-gradient(135deg, var(--srku-navy), var(--srku-dark));">
    <div class="container-xl py-2">
        <h2 class="fw-bold mb-2">Need Guidance Choosing the Right Career Stream?</h2>
        <p class="text-white-50 mb-4">Our senior academic counselors are available for personalized one-on-one admission counseling.</p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="<?php echo BASE_URL; ?>contact.php#apply" class="btn btn-srku-gold px-4 py-2"><i class="fas fa-phone-alt me-1"></i> Request Free Callback</a>
            <a href="<?php echo BASE_URL; ?>syllabus.php" class="btn btn-srku-outline px-4 py-2"><i class="fas fa-book me-1"></i> Download Scheme &amp; Syllabus</a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
