<?php
$pageTitle = "Academic Departments & Constituent Institutes - SRK University";
$activeNav = "departments";
require_once __DIR__ . '/includes/header.php';

$departments = getDepartments(true);
?>

<!-- Dynamic Banner Header -->
<?php renderPageBanner('departments', 'Academic Departments & Institutes', 'Specialized Faculties Delivering World-Class Degrees in Central India'); ?>

<section class="py-5">
    <div class="container-xl py-3">
        <div class="text-center mb-5" style="max-width:750px; margin:auto;">
            <span class="section-subtitle">CONSTITUENT FACULTIES</span>
            <h2 class="fw-bold text-navy">Explore Our Academic Spectrum</h2>
            <p class="text-muted">From Engineering and Medicine to Law and Agriculture, discover cutting-edge education backed by state-of-the-art research laboratories and 94% placement record.</p>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php foreach ($departments as $dept): 
                $courseCount = count(getCourses($dept['slug']));
            ?>
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden d-flex flex-column" style="transition: all 0.3s ease;">
                        <div class="p-4 bg-light border-bottom d-flex align-items-center gap-3">
                            <div class="bg-danger-subtle text-danger rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width:55px; height:55px; font-size:1.5rem;">
                                <i class="<?php echo sanitize($dept['icon'] ?: 'fas fa-graduation-cap'); ?>"></i>
                            </div>
                            <div>
                                <h3 class="h5 fw-bold text-navy mb-1"><?php echo sanitize($dept['name']); ?></h3>
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle small"><?php echo $courseCount; ?> Programmes</span>
                            </div>
                        </div>
                        <div class="p-4 d-flex flex-column flex-grow-1">
                            <p class="text-muted small mb-3 flex-grow-1" style="line-height:1.7;">
                                <?php echo sanitize($dept['description']); ?>
                            </p>
                            
                            <?php if (!empty($dept['dean_name'])): ?>
                                <div class="bg-light p-2 px-3 rounded-3 mb-3 small text-muted">
                                    <i class="fas fa-user-tie text-danger me-1"></i> <strong>Dean / Principal:</strong> <?php echo sanitize($dept['dean_name']); ?>
                                </div>
                            <?php endif; ?>

                            <div class="d-flex gap-2 mt-auto">
                                <a href="<?php echo BASE_URL; ?>department-detail.php?slug=<?php echo urlencode($dept['slug']); ?>" class="btn btn-sm btn-srku flex-grow-1 text-center justify-content-center">
                                    View Faculty Details
                                </a>
                                <a href="<?php echo BASE_URL; ?>courses.php?dept=<?php echo urlencode($dept['name']); ?>" class="btn btn-sm btn-outline-secondary">
                                    Courses (<?php echo $courseCount; ?>)
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5 text-center text-white" style="background: linear-gradient(135deg, var(--srku-navy), var(--srku-dark));">
    <div class="container-xl py-2">
        <h2 class="fw-bold mb-2">Ready to Start Your Journey at SRKU?</h2>
        <p class="text-white-50 mb-4">Admissions open for academic session 2026-27 across all 14 departments.</p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="<?php echo BASE_URL; ?>contact.php#apply" class="btn btn-srku-gold px-4 py-2"><i class="fas fa-paper-plane me-1"></i> Apply for Admission</a>
            <a href="<?php echo BASE_URL; ?>courses.php" class="btn btn-srku-outline px-4 py-2"><i class="fas fa-search me-1"></i> Explore All Courses</a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
