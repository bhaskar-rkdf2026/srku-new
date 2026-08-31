<?php
require_once __DIR__ . '/includes/functions.php';

// Detect if request wants pure XML (via URL, query param, or sitemap.xml rewrite)
$isXml = false;
if (isset($_GET['xml']) || (isset($_GET['format']) && $_GET['format'] === 'xml')) {
    $isXml = true;
} elseif (strpos($_SERVER['REQUEST_URI'] ?? '', 'sitemap.xml') !== false) {
    $isXml = true;
}

$baseUrl = rtrim(BASE_URL, '/') . '/';
$today = date('Y-m-d');

// Static Pages List
$staticPages = [
    ['title' => 'Home Page', 'url' => $baseUrl, 'priority' => '1.0', 'freq' => 'daily'],
    ['title' => 'About SRKU', 'url' => $baseUrl . 'about.php', 'priority' => '0.9', 'freq' => 'weekly'],
    ['title' => 'Why Choose SRKU', 'url' => $baseUrl . 'why-srk.php', 'priority' => '0.8', 'freq' => 'monthly'],
    ['title' => 'Vision & Mission', 'url' => $baseUrl . 'vision-mission.php', 'priority' => '0.8', 'freq' => 'monthly'],
    ['title' => 'Accreditations & Approvals', 'url' => $baseUrl . 'accreditation.php', 'priority' => '0.85', 'freq' => 'monthly'],
    ['title' => 'Board of Management', 'url' => $baseUrl . 'board-of-management.php', 'priority' => '0.75', 'freq' => 'monthly'],
    ['title' => 'Constituent Units & Colleges', 'url' => $baseUrl . 'constituent-unit.php', 'priority' => '0.85', 'freq' => 'weekly'],
    ['title' => 'Departments Directory', 'url' => $baseUrl . 'departments.php', 'priority' => '0.95', 'freq' => 'weekly'],
    ['title' => 'Academic Courses Catalog', 'url' => $baseUrl . 'courses.php', 'priority' => '0.95', 'freq' => 'daily'],
    ['title' => 'Admissions 2026-27', 'url' => $baseUrl . 'admissions.php', 'priority' => '0.95', 'freq' => 'daily'],
    ['title' => 'Ph.D. Doctoral Admissions', 'url' => $baseUrl . 'phd-admission.php', 'priority' => '0.90', 'freq' => 'weekly'],
    ['title' => 'Ph.D. Application Form', 'url' => $baseUrl . 'phd-application-form.php', 'priority' => '0.90', 'freq' => 'weekly'],
    ['title' => 'Curriculum Schemes & Syllabus', 'url' => $baseUrl . 'syllabus.php', 'priority' => '0.80', 'freq' => 'monthly'],
    ['title' => 'Training & Placements', 'url' => $baseUrl . 'placements.php', 'priority' => '0.85', 'freq' => 'weekly'],
    ['title' => 'Campus Facilities & Labs', 'url' => $baseUrl . 'facilities.php', 'priority' => '0.80', 'freq' => 'monthly'],
    ['title' => 'Research & Innovation', 'url' => $baseUrl . 'research-innovation.php', 'priority' => '0.80', 'freq' => 'monthly'],
    ['title' => 'Incubation & Startups', 'url' => $baseUrl . 'incubation-center.php', 'priority' => '0.75', 'freq' => 'monthly'],
    ['title' => 'Student Life & Campus Hub', 'url' => $baseUrl . 'student-life.php', 'priority' => '0.75', 'freq' => 'monthly'],
    ['title' => 'Photo & Event Gallery', 'url' => $baseUrl . 'gallery.php', 'priority' => '0.80', 'freq' => 'weekly'],
    ['title' => 'Alumni Network', 'url' => $baseUrl . 'alumni.php', 'priority' => '0.70', 'freq' => 'monthly'],
    ['title' => 'Career Opportunities', 'url' => $baseUrl . 'career.php', 'priority' => '0.75', 'freq' => 'weekly'],
    ['title' => 'University News & Blogs', 'url' => $baseUrl . 'blogs.php', 'priority' => '0.85', 'freq' => 'daily'],
    ['title' => 'Contact & Campus Helplines', 'url' => $baseUrl . 'contact.php', 'priority' => '0.80', 'freq' => 'monthly'],
    ['title' => 'Online Admission Enquiry', 'url' => $baseUrl . 'admission-enquiry.php', 'priority' => '0.85', 'freq' => 'weekly'],
    ['title' => 'Grievance Redressal Portal', 'url' => $baseUrl . 'grievance.php', 'priority' => '0.70', 'freq' => 'monthly'],
    ['title' => 'RKDF IST - Student Feedback', 'url' => $baseUrl . 'rkdf-ist-student-feedback.php', 'priority' => '0.70', 'freq' => 'monthly'],
    ['title' => 'RKDF IST - Teacher Feedback', 'url' => $baseUrl . 'rkdf-ist-teacher-feedback.php', 'priority' => '0.70', 'freq' => 'monthly'],
    ['title' => 'RKDF IST - Parent Feedback', 'url' => $baseUrl . 'rkdf-ist-parent-feedback.php', 'priority' => '0.70', 'freq' => 'monthly'],
    ['title' => 'RKDF IST - Grievance Portal', 'url' => $baseUrl . 'rkdf-ist-grievance.php', 'priority' => '0.70', 'freq' => 'monthly']
];

// Fetch Data
$departments = getDepartments(true);
$courses = getCourses();
$blogs = getBlogs('all', 150);

$cmsPages = [];
try {
    $pdo = getDBConnection();
    $stmtPages = $pdo->query("SELECT title, slug, updated_at, created_at FROM pages WHERE status = 'published'");
    $cmsPages = $stmtPages->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {}

// Group Courses by Level
$ugCourses = [];
$pgCourses = [];
$diplomaCourses = [];
$phdCourses = [];

foreach ($courses as $c) {
    $lvl = strtoupper(trim($c['level'] ?? ''));
    if (strpos($lvl, 'DIPLOMA') !== false || strpos($lvl, 'POLY') !== false) {
        $diplomaCourses[] = $c;
    } elseif (strpos($lvl, 'PH.D') !== false || strpos($lvl, 'DOCTOR') !== false || strpos($lvl, 'PHD') !== false) {
        $phdCourses[] = $c;
    } elseif (strpos($lvl, 'PG') !== false || strpos($lvl, 'POST') !== false || strpos($lvl, 'MASTER') !== false) {
        $pgCourses[] = $c;
    } else {
        $ugCourses[] = $c;
    }
}

// Total Count
$totalUrls = count($staticPages) + (count($departments) * 2) + count($courses) + count($blogs) + count($cmsPages);

// =========================================================================
// 1. PURE XML OUTPUT (For Search Engines & sitemap.xml)
// =========================================================================
if ($isXml) {
    header('Content-Type: application/xml; charset=utf-8');
    echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <?php foreach ($staticPages as $sp): ?>
    <url>
        <loc><?php echo htmlspecialchars($sp['url']); ?></loc>
        <lastmod><?php echo $today; ?></lastmod>
        <changefreq><?php echo $sp['freq']; ?></changefreq>
        <priority><?php echo $sp['priority']; ?></priority>
    </url>
    <?php endforeach; ?>

    <?php foreach ($departments as $dept): if (empty($dept['slug'])) continue; ?>
    <url>
        <loc><?php echo $baseUrl; ?>department-detail.php?slug=<?php echo urlencode($dept['slug']); ?></loc>
        <lastmod><?php echo $today; ?></lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.90</priority>
    </url>
    <url>
        <loc><?php echo $baseUrl; ?><?php echo htmlspecialchars($dept['slug']); ?></loc>
        <lastmod><?php echo $today; ?></lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.90</priority>
    </url>
    <?php endforeach; ?>

    <?php foreach ($courses as $c): 
        $cSlug = !empty($c['slug']) ? $c['slug'] : $c['id'];
    ?>
    <url>
        <loc><?php echo $baseUrl; ?>course/<?php echo htmlspecialchars($cSlug); ?></loc>
        <lastmod><?php echo $today; ?></lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.85</priority>
    </url>
    <?php endforeach; ?>

    <?php foreach ($blogs as $b): 
        $bSlug = !empty($b['slug']) ? $b['slug'] : $b['id'];
        $bDate = !empty($b['publish_date']) ? date('Y-m-d', strtotime($b['publish_date'])) : $today;
    ?>
    <url>
        <loc><?php echo $baseUrl; ?>blog-detail.php?slug=<?php echo htmlspecialchars($bSlug); ?></loc>
        <lastmod><?php echo $bDate; ?></lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.75</priority>
    </url>
    <?php endforeach; ?>

    <?php foreach ($cmsPages as $p):
        if (empty($p['slug'])) continue;
        $pDate = !empty($p['updated_at']) ? date('Y-m-d', strtotime($p['updated_at'])) : (!empty($p['created_at']) ? date('Y-m-d', strtotime($p['created_at'])) : $today);
    ?>
    <url>
        <loc><?php echo $baseUrl; ?>page.php?slug=<?php echo htmlspecialchars($p['slug']); ?></loc>
        <lastmod><?php echo $pDate; ?></lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.70</priority>
    </url>
    <?php endforeach; ?>
</urlset>
<?php
    exit;
}

// =========================================================================
// 2. CLEAN & SIMPLE HTML SITEMAP (For Browser Visitors)
// =========================================================================
$pageTitle = "Website Sitemap | SRKU Bhopal";
$pageDesc = "Complete directory of Sarvepalli Radhakrishnan University (SRKU) Bhopal pages, colleges, and courses.";
$activeNav = "";
require_once __DIR__ . '/includes/header.php';
?>

<!-- Simple Header Banner -->
<section class="py-4 bg-light border-bottom">
    <div class="container-xl">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1 small">
                        <li class="breadcrumb-item"><a href="<?php echo $baseUrl; ?>" class="text-decoration-none text-muted">Home</a></li>
                        <li class="breadcrumb-item active text-danger" aria-current="page">Sitemap</li>
                    </ol>
                </nav>
                <h1 class="h3 fw-bold text-navy mb-0">Website Sitemap</h1>
            </div>
            <div class="d-flex gap-2 align-items-center">
                <span class="badge bg-secondary-subtle text-dark border px-3 py-2 rounded-pill small">
                    <i class="fas fa-link text-danger me-1"></i> <?php echo $totalUrls; ?> Total Links
                </span>
                <a href="<?php echo $baseUrl; ?>sitemap.php?xml=1" target="_blank" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                    <i class="fas fa-file-code me-1"></i> XML Version
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Simple Structured Sitemap Content -->
<section class="py-5">
    <div class="container-xl">

        <div class="row g-4">

            <!-- Section 1: Main University Pages -->
            <div class="col-12 col-lg-6">
                <div class="card p-4 border rounded-3 shadow-none bg-white h-100">
                    <h2 class="h5 fw-bold text-navy border-bottom pb-2 mb-3">
                        <i class="fas fa-university text-danger me-2"></i> Main Pages
                    </h2>
                    <ul class="list-unstyled mb-0 row row-cols-1 row-cols-sm-2 g-2" style="font-size: 0.92rem;">
                        <?php foreach ($staticPages as $sp): ?>
                            <li class="col">
                                <a href="<?php echo $sp['url']; ?>" class="text-decoration-none text-dark d-flex align-items-center py-1 hover-link">
                                    <i class="fas fa-angle-right text-muted me-2 small"></i>
                                    <span><?php echo $sp['title']; ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

            <!-- Section 2: Constituent Colleges & Departments -->
            <div class="col-12 col-lg-6">
                <div class="card p-4 border rounded-3 shadow-none bg-white h-100">
                    <h2 class="h5 fw-bold text-navy border-bottom pb-2 mb-3">
                        <i class="fas fa-building text-danger me-2"></i> Constituent Units (<?php echo count($departments); ?>)
                    </h2>
                    <ul class="list-unstyled mb-0 row row-cols-1 row-cols-sm-2 g-2" style="font-size: 0.92rem;">
                        <?php foreach ($departments as $dept): ?>
                            <li class="col">
                                <a href="<?php echo $baseUrl . 'department-detail.php?slug=' . urlencode($dept['slug']); ?>" class="text-decoration-none text-dark d-flex align-items-center py-1 hover-link">
                                    <i class="fas fa-angle-right text-muted me-2 small"></i>
                                    <span class="text-truncate"><?php echo sanitize($dept['name']); ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

            <!-- Section 3: Undergraduate (UG) Programmes -->
            <?php if (!empty($ugCourses)): ?>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card p-4 border rounded-3 shadow-none bg-white h-100">
                    <h2 class="h5 fw-bold text-navy border-bottom pb-2 mb-3">
                        <i class="fas fa-user-graduate text-danger me-2"></i> UG Programmes (<?php echo count($ugCourses); ?>)
                    </h2>
                    <ul class="list-unstyled mb-0 d-flex flex-column gap-1" style="font-size: 0.9rem; max-height: 380px; overflow-y: auto;">
                        <?php foreach ($ugCourses as $c): 
                            $cSlug = !empty($c['slug']) ? $c['slug'] : $c['id'];
                        ?>
                            <li>
                                <a href="<?php echo $baseUrl . 'course/' . urlencode($cSlug); ?>" class="text-decoration-none text-dark d-flex align-items-center py-1 hover-link">
                                    <i class="fas fa-chevron-right text-muted me-2" style="font-size:0.7rem;"></i>
                                    <span class="text-truncate"><?php echo sanitize($c['course_name']); ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <?php endif; ?>

            <!-- Section 4: Postgraduate (PG) Programmes -->
            <?php if (!empty($pgCourses)): ?>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card p-4 border rounded-3 shadow-none bg-white h-100">
                    <h2 class="h5 fw-bold text-navy border-bottom pb-2 mb-3">
                        <i class="fas fa-graduation-cap text-danger me-2"></i> PG Programmes (<?php echo count($pgCourses); ?>)
                    </h2>
                    <ul class="list-unstyled mb-0 d-flex flex-column gap-1" style="font-size: 0.9rem; max-height: 380px; overflow-y: auto;">
                        <?php foreach ($pgCourses as $c): 
                            $cSlug = !empty($c['slug']) ? $c['slug'] : $c['id'];
                        ?>
                            <li>
                                <a href="<?php echo $baseUrl . 'course/' . urlencode($cSlug); ?>" class="text-decoration-none text-dark d-flex align-items-center py-1 hover-link">
                                    <i class="fas fa-chevron-right text-muted me-2" style="font-size:0.7rem;"></i>
                                    <span class="text-truncate"><?php echo sanitize($c['course_name']); ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <?php endif; ?>

            <!-- Section 5: Diploma, Polytechnic & Ph.D. -->
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card p-4 border rounded-3 shadow-none bg-white h-100">
                    <h2 class="h5 fw-bold text-navy border-bottom pb-2 mb-3">
                        <i class="fas fa-award text-danger me-2"></i> Diploma &amp; Doctoral
                    </h2>
                    <ul class="list-unstyled mb-0 d-flex flex-column gap-1" style="font-size: 0.9rem; max-height: 380px; overflow-y: auto;">
                        <?php 
                        $otherCourses = array_merge($diplomaCourses, $phdCourses);
                        foreach ($otherCourses as $c): 
                            $cSlug = !empty($c['slug']) ? $c['slug'] : $c['id'];
                        ?>
                            <li>
                                <a href="<?php echo $baseUrl . 'course/' . urlencode($cSlug); ?>" class="text-decoration-none text-dark d-flex align-items-center py-1 hover-link">
                                    <i class="fas fa-chevron-right text-muted me-2" style="font-size:0.7rem;"></i>
                                    <span class="text-truncate"><?php echo sanitize($c['course_name']); ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

            <!-- Section 6: University News & Blogs -->
            <?php if (!empty($blogs)): ?>
            <div class="col-12">
                <div class="card p-4 border rounded-3 shadow-none bg-white">
                    <h2 class="h5 fw-bold text-navy border-bottom pb-2 mb-3">
                        <i class="fas fa-newspaper text-danger me-2"></i> University News &amp; Articles
                    </h2>
                    <ul class="list-unstyled mb-0 row row-cols-1 row-cols-md-2 row-cols-lg-3 g-2" style="font-size: 0.9rem;">
                        <?php foreach ($blogs as $b): 
                            $bSlug = !empty($b['slug']) ? $b['slug'] : $b['id'];
                        ?>
                            <li class="col">
                                <a href="<?php echo $baseUrl . 'blog-detail.php?slug=' . urlencode($bSlug); ?>" class="text-decoration-none text-dark d-flex align-items-center py-1 hover-link">
                                    <i class="fas fa-angle-right text-muted me-2 small"></i>
                                    <span class="text-truncate"><?php echo sanitize($b['title']); ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <?php endif; ?>

        </div>

    </div>
</section>

<style>
.hover-link {
    transition: all 0.2s ease;
    border-radius: 4px;
    padding-left: 4px;
}
.hover-link:hover {
    color: #a91d27 !important;
    background-color: #f8fafc;
    transform: translateX(3px);
}
.hover-link:hover i {
    color: #a91d27 !important;
}
</style>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
