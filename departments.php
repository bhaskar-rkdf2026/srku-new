<?php
$pageTitle = "Academic Departments & Faculties | 14 Schools | SRKU Bhopal";
$pageDesc = "Discover the faculties and academic departments of Sarvepalli Radhakrishnan University (SRKU), Bhopal including Engineering, Medicine, Pharmacy, Nursing, Law, Management and Agriculture.";
$pageKeywords = "SRKU Departments, Academic Faculties, Engineering Department, Medical College, Pharmacy Faculty Bhopal";
$activeNav = "departments";
require_once __DIR__ . '/includes/header.php';

$selectedCategory = sanitize($_GET['category'] ?? '');
$searchQuery = sanitize($_GET['q'] ?? '');

$allDepartments = getDepartments(true);

// Filter by category or search
$filteredDepartments = array_filter($allDepartments, function($dept) use ($selectedCategory, $searchQuery) {
    if (!empty($selectedCategory) && $selectedCategory !== 'all') {
        if (stripos($dept['category'] ?? '', $selectedCategory) === false && stripos($dept['name'], $selectedCategory) === false) {
            return false;
        }
    }
    if (!empty($searchQuery)) {
        $term = strtolower($searchQuery);
        $nameMatch = strpos(strtolower($dept['name']), $term) !== false;
        $descMatch = strpos(strtolower($dept['description']), $term) !== false;
        $catMatch = strpos(strtolower($dept['category'] ?? ''), $term) !== false;
        if (!$nameMatch && !$descMatch && !$catMatch) {
            return false;
        }
    }
    return true;
});
?>

<!-- Dynamic Banner Header -->
<?php renderPageBanner('departments', 'Academic Departments & Constituent Institutes', 'Recognized Constituent Colleges & Faculties Delivering Premier Education in Central India'); ?>

<!-- Quick Stats Bar -->
<section class="py-4 bg-light border-bottom">
    <div class="container-xl">
        <div class="row row-cols-2 row-cols-md-4 g-3 text-center">
            <div class="col">
                <div class="p-3 bg-white rounded-4 shadow-sm h-100 border">
                    <div class="display-6 fw-bold text-danger mb-1">26+</div>
                    <div class="small fw-semibold text-navy">Constituent Units &amp; Faculties</div>
                </div>
            </div>
            <div class="col">
                <div class="p-3 bg-white rounded-4 shadow-sm h-100 border">
                    <div class="display-6 fw-bold text-danger mb-1">90+</div>
                    <div class="small fw-semibold text-navy">Degree &amp; Diploma Programs</div>
                </div>
            </div>
            <div class="col">
                <div class="p-3 bg-white rounded-4 shadow-sm h-100 border">
                    <div class="display-6 fw-bold text-danger mb-1">1995</div>
                    <div class="small fw-semibold text-navy">Legacy of Excellence (30+ Yrs)</div>
                </div>
            </div>
            <div class="col">
                <div class="p-3 bg-white rounded-4 shadow-sm h-100 border">
                    <div class="display-6 fw-bold text-danger mb-1">750+</div>
                    <div class="small fw-semibold text-navy">Bed Multispecialty Teaching Hospital</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main Department Directory Section -->
<section class="py-5">
    <div class="container-xl py-2">
        
        <!-- Filter & Search Bar -->
        <div class="card p-4 border-0 shadow-sm rounded-4 mb-5 bg-white border">
            <div class="row g-3 align-items-center mb-3">
                <div class="col-12 col-md-6">
                    <h2 class="h4 fw-bold text-navy mb-1"><i class="fas fa-university text-danger me-2"></i> Explore All Faculties &amp; Colleges</h2>
                    <p class="text-muted small mb-0">Browse through all constituent units, professional faculties, and academic departments.</p>
                </div>
                <div class="col-12 col-md-6">
                    <form action="<?php echo BASE_URL; ?>departments.php" method="GET" class="d-flex gap-2">
                        <?php if ($selectedCategory): ?>
                            <input type="hidden" name="category" value="<?php echo sanitize($selectedCategory); ?>">
                        <?php endif; ?>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                            <input type="text" name="q" class="form-control border-start-0" placeholder="Search college, stream (e.g. Pharmacy, Medical, B.Tech, Law)..." value="<?php echo sanitize($searchQuery); ?>">
                        </div>
                        <button type="submit" class="btn btn-srku px-4"><i class="fas fa-filter me-1"></i> Search</button>
                        <?php if ($searchQuery || $selectedCategory): ?>
                            <a href="<?php echo BASE_URL; ?>departments.php" class="btn btn-outline-secondary" title="Reset Filters"><i class="fas fa-times"></i></a>
                        <?php endif; ?>
                    </form>
                </div>
            </div>

            <!-- Category Pills -->
            <div class="d-flex flex-wrap gap-2 pt-3 border-top">
                <a href="<?php echo BASE_URL; ?>departments.php" class="badge px-3 py-2 text-decoration-none rounded-pill <?php echo empty($selectedCategory) ? 'bg-danger text-white' : 'bg-light text-dark border'; ?>">
                    All Units
                </a>
                <a href="<?php echo BASE_URL; ?>departments.php?category=Engineering" class="badge px-3 py-2 text-decoration-none rounded-pill <?php echo $selectedCategory == 'Engineering' ? 'bg-danger text-white' : 'bg-light text-dark border'; ?>">
                    <i class="fas fa-cogs me-1"></i> Engineering &amp; Tech
                </a>
                <a href="<?php echo BASE_URL; ?>departments.php?category=Pharmacy" class="badge px-3 py-2 text-decoration-none rounded-pill <?php echo $selectedCategory == 'Pharmacy' ? 'bg-danger text-white' : 'bg-light text-dark border'; ?>">
                    <i class="fas fa-pills me-1"></i> Pharmacy
                </a>
                <a href="<?php echo BASE_URL; ?>departments.php?category=Medical" class="badge px-3 py-2 text-decoration-none rounded-pill <?php echo $selectedCategory == 'Medical' ? 'bg-danger text-white' : 'bg-light text-dark border'; ?>">
                    <i class="fas fa-stethoscope me-1"></i> Medical &amp; Dental
                </a>
                <a href="<?php echo BASE_URL; ?>departments.php?category=Ayush" class="badge px-3 py-2 text-decoration-none rounded-pill <?php echo $selectedCategory == 'Ayush' ? 'bg-danger text-white' : 'bg-light text-dark border'; ?>">
                    <i class="fas fa-leaf me-1"></i> Ayurveda &amp; Homoeopathy
                </a>
                <a href="<?php echo BASE_URL; ?>departments.php?category=Nursing" class="badge px-3 py-2 text-decoration-none rounded-pill <?php echo $selectedCategory == 'Nursing' ? 'bg-danger text-white' : 'bg-light text-dark border'; ?>">
                    <i class="fas fa-user-nurse me-1"></i> Nursing (B.Sc / M.Sc / NPCC)
                </a>
                <a href="<?php echo BASE_URL; ?>departments.php?category=Paramedical" class="badge px-3 py-2 text-decoration-none rounded-pill <?php echo $selectedCategory == 'Paramedical' ? 'bg-danger text-white' : 'bg-light text-dark border'; ?>">
                    <i class="fas fa-heartbeat me-1"></i> Paramedical Sciences
                </a>
                <a href="<?php echo BASE_URL; ?>departments.php?category=Law" class="badge px-3 py-2 text-decoration-none rounded-pill <?php echo $selectedCategory == 'Law' ? 'bg-danger text-white' : 'bg-light text-dark border'; ?>">
                    <i class="fas fa-balance-scale me-1"></i> Law (BA.LL.B / LL.B / LL.M)
                </a>
                <a href="<?php echo BASE_URL; ?>departments.php?category=Agriculture" class="badge px-3 py-2 text-decoration-none rounded-pill <?php echo $selectedCategory == 'Agriculture' ? 'bg-danger text-white' : 'bg-light text-dark border'; ?>">
                    <i class="fas fa-seedling me-1"></i> Agriculture
                </a>
                <a href="<?php echo BASE_URL; ?>departments.php?category=Management" class="badge px-3 py-2 text-decoration-none rounded-pill <?php echo $selectedCategory == 'Management' ? 'bg-danger text-white' : 'bg-light text-dark border'; ?>">
                    <i class="fas fa-chart-line me-1"></i> Management &amp; IT
                </a>
                <a href="<?php echo BASE_URL; ?>departments.php?category=Allied" class="badge px-3 py-2 text-decoration-none rounded-pill <?php echo $selectedCategory == 'Allied' ? 'bg-danger text-white' : 'bg-light text-dark border'; ?>">
                    <i class="fas fa-atom me-1"></i> Allied Sciences &amp; Arts
                </a>
            </div>
        </div>

        <!-- Department Cards Grid -->
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php 
            // Exact 11 Constituent Institutes that possess their own official circular seals
            $exactSeals = [
                'rkdf-medical-college' => 'logo-rkdf-medical.png',
                'sarvepalli-radhakrishnan-college-of-ayurveda' => 'logo-srk-ayurveda.png',
                'rkdf-homoeopathic-medical-college' => 'logo-rkdf-homoeopathy.png',
                'rkdf-dental-college' => 'logo-rkdf-dental.png',
                'rkdf-college-of-pharmacy' => 'logo-rkdf-pharmacy.png',
                'rkdf-college-of-nursing' => 'logo-rkdf-nursing.png',
                'department-of-paramedical-sciences' => 'logo-allied-healthcare.png',
                'rkdf-institute-of-science-and-technology' => 'logo-rkdf-science-tech.png',
                'sarvepalli-radhakrishnan-college-of-law' => 'logo-srk-law.png',
                'rkdf-institute-of-business-management' => 'logo-rkdf-management.png',
                'faculty-of-agriculture' => 'logo-srk-agriculture.png'
            ];

            // Specific icon mapping for all other departments/colleges
            $iconMap = [
                'faculty-of-arts' => 'fas fa-palette',
                'faculty-of-commerce' => 'fas fa-calculator',
                'faculty-of-computer-application' => 'fas fa-laptop-code',
                'rkdf-institute-science-technology-mca' => 'fas fa-code',
                'rkdf-institute-of-management' => 'fas fa-briefcase',
                'department-of-management' => 'fas fa-chart-line',
                'faculty-of-science' => 'fas fa-atom',
                'faculty-of-yoga' => 'fas fa-spa',
                'faculty-of-fashion-technology-design' => 'fas fa-tshirt',
                'faculty-of-library-science' => 'fas fa-book-reader',
                'sarvepalli-radhakrishnan-college-of-pharmacy' => 'fas fa-prescription-bottle-alt',
                'dr-apj-abdul-kalam-college-of-pharmacy-srk-bhopal' => 'fas fa-pills',
                'sri-sai-college-of-pharmacy-srk-bhopal' => 'fas fa-capsules',
                'sarvepalli-radhakrishnan-institute-of-pharmaceutical-science' => 'fas fa-mortar-pestle',
                'r-n-kapoor-memorial-institute-of-pharmaceutical-sciences-srk-university' => 'fas fa-flask'
            ];

            if (!empty($filteredDepartments)): 
                foreach ($filteredDepartments as $dept): 
                    $deptCourses = getCourses($dept['slug']);
                    if (empty($deptCourses)) {
                        $deptCourses = getCourses($dept['name']);
                    }
                    $courseCount = count($deptCourses);

                    // Degree levels summary
                    $levels = [];
                    foreach ($deptCourses as $dc) {
                        $lvl = trim($dc['degree_level'] ?: $dc['level']);
                        if (stripos($lvl, 'diploma') !== false && stripos($lvl, 'cert') !== false) {
                            $lvl = 'Diploma / Cert.';
                        } elseif (stripos($lvl, 'doctorate') !== false || stripos($lvl, 'ph.d') !== false) {
                            $lvl = 'Doctorate (Ph.D.)';
                        }
                        if ($lvl && !in_array($lvl, $levels)) {
                            $levels[] = $lvl;
                        }
                    }

                    // Check if this department has an exact extracted seal
                    $sealFile = $exactSeals[$dept['slug']] ?? null;
                    $deptIcon = $iconMap[$dept['slug']] ?? ($dept['icon'] ?: 'fas fa-university');

                    // Clean full readable summary without text cutting
                    $descText = trim(strip_tags($dept['description'] ?? ''));
                    if (empty($descText)) {
                        $descText = 'Delivering industry-aligned professional academic education, advanced research laboratories, and experiential learning.';
                    }
                    if (mb_strlen($descText) > 135) {
                        $descText = mb_substr($descText, 0, 130) . '...';
                    }
            ?>
                    <div class="col">
                        <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden d-flex flex-column bg-white border-top border-4 border-danger hover-shadow" style="transition: all 0.25s ease; border-color: rgba(122,11,13,0.15);">
                            
                            <!-- Card Header -->
                            <div class="p-4 pb-2">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <?php if ($sealFile && file_exists(__DIR__ . '/assets/images/constituent-logos/' . $sealFile)): ?>
                                        <!-- Official Constituent College Seal -->
                                        <div class="bg-white rounded-circle shadow-xs border d-flex align-items-center justify-content-center flex-shrink-0" style="width: 66px; height: 66px;" title="<?php echo sanitize($dept['name']); ?> Seal">
                                            <img src="<?php echo BASE_URL; ?>assets/images/constituent-logos/<?php echo $sealFile; ?>?v=3" alt="<?php echo sanitize($dept['name']); ?>" class="img-fluid d-block m-auto" style="max-width: 88%; max-height: 88%; object-fit: contain;">
                                        </div>
                                    <?php else: ?>
                                        <!-- Department Emblem Icon -->
                                        <div class="bg-danger-subtle text-danger rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 shadow-xs border border-danger-subtle" style="width: 66px; height: 66px; font-size: 1.6rem;" title="<?php echo sanitize($dept['name']); ?>">
                                            <i class="<?php echo sanitize($deptIcon); ?>"></i>
                                        </div>
                                    <?php endif; ?>

                                    <div class="d-flex align-items-center gap-1">
                                        <?php if (!empty($dept['established_year'])): ?>
                                            <span class="badge bg-navy text-white fw-bold px-2 py-1" style="font-size: 0.72rem;">Est. <?php echo sanitize($dept['established_year']); ?></span>
                                        <?php endif; ?>
                                        <?php if (!empty($dept['approvals'])): ?>
                                            <span class="badge bg-warning-subtle text-dark border border-warning-subtle px-2 py-1 fw-bold" style="font-size: 0.72rem;"><?php echo sanitize($dept['approvals']); ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <h3 class="h5 fw-bold text-navy mb-2" style="min-height: 2.8rem; line-height: 1.35;">
                                    <a href="<?php echo BASE_URL; ?>department-detail.php?slug=<?php echo urlencode($dept['slug']); ?>" class="text-navy text-decoration-none hover-danger">
                                        <?php echo sanitize($dept['name']); ?>
                                    </a>
                                </h3>

                                <div class="d-flex align-items-center gap-2 flex-wrap mb-2">
                                    <span class="badge bg-light text-secondary border small px-2 py-1">
                                        <i class="fas fa-layer-group text-danger me-1"></i> <?php echo sanitize($dept['category'] ?? 'Academic Unit'); ?>
                                    </span>
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle small px-2 py-1 fw-semibold">
                                        <i class="fas fa-book-open me-1"></i> Approved Programmes
                                    </span>
                                </div>
                            </div>

                            <!-- Card Body -->
                            <div class="px-4 pb-4 d-flex flex-column flex-grow-1">
                                <p class="text-muted small mb-3" style="min-height: 3rem; line-height: 1.55; font-size: 0.86rem;">
                                    <?php echo sanitize($descText); ?>
                                </p>

                                <?php if (!empty($levels)): ?>
                                    <div class="p-2 px-3 rounded-3 bg-light border mb-3 small text-secondary d-flex align-items-center gap-1">
                                        <i class="fas fa-graduation-cap text-danger me-1"></i>
                                        <strong class="text-dark">Offerings:</strong> 
                                        <span class="text-truncate"><?php echo implode(' &bull; ', array_slice($levels, 0, 3)); ?></span>
                                    </div>
                                <?php endif; ?>

                                <!-- Action Buttons -->
                                <div class="d-flex gap-2 mt-auto pt-2">
                                    <a href="<?php echo BASE_URL; ?>department/<?php echo urlencode($dept['slug']); ?>" class="btn btn-sm btn-srku flex-grow-1 text-center justify-content-center py-2">
                                        View Department &rarr;
                                    </a>
                                    <a href="<?php echo BASE_URL; ?>faculties.php?dept=<?php echo urlencode($dept['name']); ?>" class="btn btn-sm btn-outline-danger px-3 py-2 d-flex align-items-center" title="View Faculty Members">
                                        <i class="fas fa-user-tie me-1"></i> Faculty
                                    </a>
                                </div>

                            </div>

                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <i class="fas fa-university fa-3x text-muted mb-3"></i>
                    <h4 class="text-navy fw-bold">No constituent units found</h4>
                    <p class="text-muted">No departments matched your current filter criteria. Please reset filters or try another search term.</p>
                    <a href="<?php echo BASE_URL; ?>departments.php" class="btn btn-srku px-4 py-2">View All 26 Units</a>
                </div>
            <?php endif; ?>
        </div>

    </div>
</section>

<!-- Lateral Entry & Special Wings Section -->
<section class="py-5 bg-light border-top">
    <div class="container-xl">
        <div class="row g-4">
            
            <!-- Lateral Entry Box -->
            <div class="col-12 col-md-6">
                <div class="card p-4 p-md-5 border-0 shadow-sm rounded-4 h-100 bg-white border-start border-4 border-danger">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="bg-danger-subtle text-danger rounded-3 p-3"><i class="fas fa-forward fa-2x"></i></div>
                        <div>
                            <h3 class="h5 fw-bold text-navy mb-0">Lateral Entry Admissions</h3>
                            <span class="text-muted small">Direct 2nd Year (3rd Semester) Entry</span>
                        </div>
                    </div>
                    <p class="text-muted small" style="line-height:1.7;">
                        SRK University offers direct lateral entry admissions for eligible diploma holders and vocational graduates across the following professional streams:
                    </p>
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <span class="badge bg-light text-dark border p-2"><i class="fas fa-check text-success me-1"></i> B.Tech Lateral Entry (3 Yrs)</span>
                        <span class="badge bg-light text-dark border p-2"><i class="fas fa-check text-success me-1"></i> B. Pharmacy Lateral Entry (3 Yrs)</span>
                        <span class="badge bg-light text-dark border p-2"><i class="fas fa-check text-success me-1"></i> Polytechnic Diploma Lateral Entry (2 Yrs)</span>
                        <span class="badge bg-light text-dark border p-2"><i class="fas fa-check text-success me-1"></i> Diploma Agriculture Lateral Entry (2 Yrs)</span>
                    </div>
                    <a href="<?php echo BASE_URL; ?>courses.php?search=Lateral" class="btn btn-sm btn-outline-danger align-self-start mt-auto">
                        <i class="fas fa-arrow-right me-1"></i> Explore Lateral Entry Programs
                    </a>
                </div>
            </div>

            <!-- NSS & NCC Wing Box -->
            <div class="col-12 col-md-6">
                <div class="card p-4 p-md-5 border-0 shadow-sm rounded-4 h-100 bg-white border-start border-4 border-primary">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="bg-primary-subtle text-primary rounded-3 p-3"><i class="fas fa-shield-alt fa-2x"></i></div>
                        <div>
                            <h3 class="h5 fw-bold text-navy mb-0">NSS &amp; NCC Cadet Wings</h3>
                            <span class="text-muted small">Discipline, Leadership &amp; National Service</span>
                        </div>
                    </div>
                    <p class="text-muted small" style="line-height:1.7;">
                        Authorized National Cadet Corps (NCC) and National Service Scheme (NSS) units active on campus. Students undergo parade drills, annual camps, disaster relief training, and earn prestigious B &amp; C Certificates for defence opportunities.
                    </p>
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <span class="badge bg-light text-dark border p-2"><i class="fas fa-medal text-warning me-1"></i> NCC Senior Wing &amp; Division</span>
                        <span class="badge bg-light text-dark border p-2"><i class="fas fa-hands-helping text-primary me-1"></i> NSS Community Units</span>
                        <span class="badge bg-light text-dark border p-2"><i class="fas fa-certificate text-danger me-1"></i> B &amp; C Certificate Exams</span>
                    </div>
                    <a href="<?php echo BASE_URL; ?>course-detail.php?slug=nss-ncc-courses" class="btn btn-sm btn-outline-primary align-self-start mt-auto">
                        <i class="fas fa-arrow-right me-1"></i> View NCC &amp; NSS Details
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Official Brochure Admission Desk Banner -->
<section class="py-5 text-white" style="background: linear-gradient(135deg, var(--srku-navy), var(--srku-maroon));">
    <div class="container-xl">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <div class="d-inline-flex align-items-center gap-2 bg-white bg-opacity-10 px-3 py-1 rounded-pill mb-2">
                    <i class="fas fa-phone-volume text-warning"></i>
                    <span class="small fw-bold">Official Central Admission Helpdesk</span>
                </div>
                <h2 class="fw-bold mb-2">Have Questions About Admissions 2026-27?</h2>
                <p class="text-white-50 mb-3" style="line-height: 1.7;">
                    Connect directly with our senior academic counselors across any of the 26 constituent institutes and departments for immediate guidance and seat reservation.
                </p>
                <div class="row g-2 small">
                    <div class="col-sm-6">
                        <div><i class="fas fa-phone-alt text-warning me-2"></i><strong>Landline:</strong> 0755-4700983, 0755-4700980</div>
                    </div>
                    <div class="col-sm-6">
                        <div><i class="fas fa-mobile-alt text-warning me-2"></i><strong>Mobile:</strong> 7024144981, 82, 83, 84, 86</div>
                    </div>
                    <div class="col-sm-6">
                        <div><i class="fas fa-envelope text-warning me-2"></i><strong>Email:</strong> info@srku.edu.in</div>
                    </div>
                    <div class="col-sm-6">
                        <div><i class="fas fa-globe text-warning me-2"></i><strong>Official Portal:</strong> www.srku.edu.in</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 text-lg-end">
                <div class="d-flex flex-column flex-sm-row justify-content-lg-end gap-3">
                    <a href="<?php echo BASE_URL; ?>contact.php#apply" class="btn btn-warning px-4 py-3 fw-bold text-dark shadow">
                        <i class="fas fa-paper-plane me-1"></i> Apply for Admission Online
                    </a>
                    <a href="<?php echo BASE_URL; ?>courses.php" class="btn btn-outline-light px-4 py-3 fw-semibold">
                        <i class="fas fa-list-ul me-1"></i> All 90+ Courses
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
