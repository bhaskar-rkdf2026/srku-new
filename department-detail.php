<?php
require_once __DIR__ . '/includes/functions.php';

$slug = sanitize($_GET['slug'] ?? 'department-of-engineering');
$dept = getDepartmentBySlug($slug);

if (!$dept) {
    // If not found by exact slug, try matching by name
    $departments = getDepartments(true);
    if (!empty($departments)) {
        $dept = $departments[0];
    } else {
        header("Location: " . BASE_URL . "departments.php");
        exit;
    }
}

$pageTitle = $dept['name'] . " - SRK University Bhopal";
$activeNav = "departments";
require_once __DIR__ . '/includes/header.php';

$courses = getCourses($dept['slug']);
if (empty($courses)) {
    $courses = getCourses($dept['name']);
}
?>

<!-- Banner Header -->
<div class="py-5 text-center text-white" style="background: linear-gradient(135deg, var(--srku-navy), var(--srku-maroon));">
    <div class="container-xl py-3">
        <div class="d-inline-flex align-items-center justify-content-center bg-white bg-opacity-10 rounded-circle p-3 mb-3" style="width:65px; height:65px; font-size:1.8rem;">
            <i class="<?php echo sanitize($dept['icon'] ?: 'fas fa-graduation-cap'); ?> text-warning"></i>
        </div>
        <h1 class="fw-bold display-5 mb-2"><?php echo sanitize($dept['name']); ?></h1>
        <p class="text-warning fw-semibold lead mb-0">Sarvepalli Radhakrishnan University, Bhopal</p>
    </div>
</div>

<!-- Breadcrumb Bar -->
<div class="bg-light py-2 border-bottom">
    <div class="container-xl">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>" class="text-decoration-none text-muted">Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>departments.php" class="text-decoration-none text-muted">Departments</a></li>
                <li class="breadcrumb-item active text-danger fw-semibold" aria-current="page"><?php echo sanitize($dept['name']); ?></li>
            </ol>
        </nav>
    </div>
</div>

<section class="py-5">
    <div class="container-xl py-3">
        <div class="row g-4 g-lg-5">
            
            <!-- Left Main Column -->
            <div class="col-12 col-lg-8">
                
                <!-- Overview Card -->
                <div class="card p-4 p-md-5 border-0 shadow-sm rounded-4 mb-4">
                    <h2 class="text-maroon fw-bold mb-3">About the Faculty &amp; Academic Vision</h2>
                    <p class="text-dark" style="line-height:1.85; font-size:0.98rem;">
                        <?php echo nl2br(sanitize($dept['description'])); ?>
                    </p>
                    <p class="text-muted" style="line-height:1.85; font-size:0.95rem;">
                        Equipped with industry-standard curriculum, advanced research laboratories, experienced doctoral faculty members, and regular corporate internships, the faculty prepares scholars to excel in global careers, scientific research, and entrepreneurship.
                    </p>

                    <div class="row row-cols-1 row-cols-sm-3 g-3 mt-3 pt-3 border-top text-center">
                        <div class="col">
                            <div class="p-3 bg-light rounded-3">
                                <i class="fas fa-calendar-alt text-danger fa-lg mb-2"></i>
                                <div class="small text-muted">Established</div>
                                <div class="fw-bold text-navy"><?php echo sanitize($dept['established_year'] ?: '2015'); ?></div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="p-3 bg-light rounded-3">
                                <i class="fas fa-graduation-cap text-danger fa-lg mb-2"></i>
                                <div class="small text-muted">Programmes Offered</div>
                                <div class="fw-bold text-navy"><?php echo count($courses); ?> Degrees</div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="p-3 bg-light rounded-3">
                                <i class="fas fa-award text-danger fa-lg mb-2"></i>
                                <div class="small text-muted">Placement Support</div>
                                <div class="fw-bold text-navy">94% Record</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Academic Programmes Offered -->
                <div class="card p-4 p-md-5 border-0 shadow-sm rounded-4 mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="text-navy fw-bold mb-0">Courses &amp; Degrees Offered</h3>
                        <span class="badge bg-danger px-3 py-2"><?php echo count($courses); ?> Available</span>
                    </div>

                    <?php if (!empty($courses)): ?>
                        <div class="d-flex flex-column gap-3">
                            <?php foreach ($courses as $c): ?>
                                <div class="p-4 border rounded-4 bg-light d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 hover-shadow">
                                    <div>
                                        <div class="d-flex align-items-center gap-2 mb-1">
                                            <span class="badge bg-primary-subtle text-primary border"><?php echo sanitize($c['level']); ?></span>
                                            <span class="text-muted small"><i class="far fa-clock me-1"></i> <?php echo sanitize($c['duration']); ?></span>
                                        </div>
                                        <h4 class="h5 fw-bold text-navy mb-1"><?php echo sanitize($c['course_name']); ?></h4>
                                        <div class="text-muted small">
                                            <strong>Eligibility:</strong> <?php echo sanitize($c['eligibility']); ?>
                                        </div>
                                        <?php if (!empty($c['fees'])): ?>
                                            <div class="text-danger small fw-bold mt-1">
                                                <i class="fas fa-rupee-sign"></i> <?php echo sanitize($c['fees']); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="d-flex flex-row flex-md-column gap-2 flex-shrink-0">
                                        <a href="<?php echo BASE_URL; ?>course-detail.php?slug=<?php echo urlencode($c['slug'] ?: $c['id']); ?>" class="btn btn-sm btn-outline-danger px-3">
                                            Details
                                        </a>
                                        <a href="<?php echo BASE_URL; ?>contact.php?course=<?php echo urlencode($c['course_name']); ?>" class="btn btn-sm btn-srku px-3">
                                            Apply
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-book-open fa-2x mb-2"></i>
                            <p class="mb-0">Programmes catalog being updated. Please contact admission desk for details.</p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Laboratory & Research Infrastructure -->
                <div class="card p-4 p-md-5 border-0 shadow-sm rounded-4">
                    <h3 class="text-navy fw-bold mb-3">Key Infrastructure &amp; Laboratories</h3>
                    <p class="text-muted mb-4">Hands-on practical exposure in state-of-the-art facilities equipped with modern machinery and computational software.</p>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-3 d-flex align-items-center gap-3">
                                <i class="fas fa-microscope text-danger fa-2x"></i>
                                <div>
                                    <h5 class="h6 fw-bold text-dark mb-1">Advanced Research Suites</h5>
                                    <small class="text-muted">Specialized testing instruments</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-3 d-flex align-items-center gap-3">
                                <i class="fas fa-laptop-code text-danger fa-2x"></i>
                                <div>
                                    <h5 class="h6 fw-bold text-dark mb-1">Digital Computing Center</h5>
                                    <small class="text-muted">High-speed gigabit Wi-Fi</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-3 d-flex align-items-center gap-3">
                                <i class="fas fa-book-reader text-danger fa-2x"></i>
                                <div>
                                    <h5 class="h6 fw-bold text-dark mb-1">Departmental Library</h5>
                                    <small class="text-muted">Journals, manuals &amp; thesis</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-3 d-flex align-items-center gap-3">
                                <i class="fas fa-handshake text-danger fa-2x"></i>
                                <div>
                                    <h5 class="h6 fw-bold text-dark mb-1">Industry CoE</h5>
                                    <small class="text-muted">MOU partnerships &amp; projects</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right Sidebar Column -->
            <div class="col-12 col-lg-4">
                
                <!-- Dean Desk Card -->
                <?php if (!empty($dept['dean_name'])): ?>
                    <div class="card p-4 border-0 shadow-sm rounded-4 mb-4 text-center bg-light">
                        <div class="bg-navy text-gold rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3" style="width:70px; height:70px; font-size:1.8rem;">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <h4 class="h5 fw-bold text-navy mb-1"><?php echo sanitize($dept['dean_name']); ?></h4>
                        <p class="badge bg-danger-subtle text-danger mb-3">Dean / Head of Faculty</p>
                        <p class="text-muted small mb-0 fst-italic">
                            "We welcome ambitious students to join our distinguished faculty and embark on a fulfilling academic voyage."
                        </p>
                    </div>
                <?php endif; ?>

                <!-- Quick Apply Card -->
                <div class="card p-4 border-0 shadow-sm rounded-4 mb-4 bg-maroon text-white">
                    <h4 class="fw-bold text-warning mb-2"><i class="fas fa-paper-plane me-2"></i> Admissions 2026-27</h4>
                    <p class="text-white-50 small mb-4">Admissions open for all degrees in <?php echo sanitize($dept['name']); ?>. Submit enquiry for instant callback.</p>
                    
                    <form action="<?php echo BASE_URL; ?>contact.php#apply" method="POST">
                        <input type="hidden" name="course" value="<?php echo sanitize($dept['name']); ?>">
                        <div class="mb-3">
                            <input type="text" name="name" class="form-control form-control-sm" placeholder="Your Full Name" required>
                        </div>
                        <div class="mb-3">
                            <input type="email" name="email" class="form-control form-control-sm" placeholder="Your Email Address" required>
                        </div>
                        <div class="mb-3">
                            <input type="tel" name="phone" class="form-control form-control-sm" placeholder="10-Digit Mobile" required>
                        </div>
                        <button type="submit" name="submit_contact" class="btn btn-warning w-100 fw-bold text-dark btn-sm">
                            Submit Admission Query
                        </button>
                    </form>
                </div>

                <!-- All Departments List -->
                <div class="card p-4 border-0 shadow-sm rounded-4">
                    <h5 class="fw-bold text-navy mb-3">All Academic Faculties</h5>
                    <div class="list-group list-group-flush">
                        <?php 
                        $allDepts = getDepartments(true);
                        foreach ($allDepts as $d): 
                            $isActive = ($d['slug'] === $dept['slug']);
                        ?>
                            <a href="<?php echo BASE_URL; ?>department-detail.php?slug=<?php echo urlencode($d['slug']); ?>" 
                               class="list-group-item list-group-item-action px-0 d-flex justify-content-between align-items-center small <?php echo $isActive ? 'text-danger fw-bold' : 'text-muted'; ?>">
                                <span><i class="<?php echo sanitize($d['icon'] ?: 'fas fa-graduation-cap'); ?> me-2 text-danger"></i> <?php echo sanitize($d['name']); ?></span>
                                <i class="fas fa-chevron-right fa-xs"></i>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
