<?php
$pageTitle = "Constituent Colleges & Institutes | SRK University Bhopal";
$pageDesc = "Explore the 14+ constituent colleges and specialized institutes of Sarvepalli Radhakrishnan University (SRKU) Bhopal spanning Engineering, Medicine, Pharmacy, Nursing, Law & Agriculture.";
$pageKeywords = "SRKU Constituent Units, RKDF Medical College, RKDF Institute of Science and Technology, Sri Sai Pharmacy, SRKU Colleges";
$activeNav = "about";
require_once __DIR__ . '/includes/header.php';

$dbDepartments = getDepartments(true);
$units = [];

if (!empty($dbDepartments)) {
    foreach ($dbDepartments as $d) {
        $img = !empty($d['image']) ? $d['image'] : 'assets/uploads/2026/07/001.webp';
        $units[] = [
            'title' => $d['name'],
            'subtitle' => !empty($d['category']) ? $d['category'] : 'Constituent Institute',
            'img_src' => resolveMediaUrl($img, 'assets/uploads/2026/07/001.webp'),
            'href' => BASE_URL . 'department-detail.php?slug=' . urlencode($d['slug']),
            'external' => false
        ];
    }
} else {
    $units = [
        ['title' => 'RKDF Institute of Science & Technology', 'subtitle' => 'Engineering & Technology', 'img_src' => BASE_URL . 'assets/uploads/2026/07/001.webp', 'href' => BASE_URL . 'department-detail.php?slug=rkdf-institute-of-science-technology', 'external' => false],
        ['title' => 'RKDF Medical College, Hospital & Research Center', 'subtitle' => 'Faculty of Medicine', 'img_src' => BASE_URL . 'assets/uploads/2026/07/RKDF-MEDICAL-COLLEGE.webp', 'href' => BASE_URL . 'department-detail.php?slug=rkdf-medical-college', 'external' => false],
        ['title' => 'SRK College of Ayurveda Hospital & Research Center', 'subtitle' => 'Ayurvedic Medicine', 'img_src' => BASE_URL . 'assets/uploads/2026/07/SRK-COLLEGE-OF-AYURVEDA.webp', 'href' => BASE_URL . 'department-detail.php?slug=sarvepalli-radhakrishnan-college-of-ayurveda', 'external' => false],
        ['title' => 'RKDF Homoeopathic Medical College Hospital', 'subtitle' => 'Homoeopathy Medicine', 'img_src' => BASE_URL . 'assets/uploads/2026/07/RKDF-HOMOEOPATHIC.webp', 'href' => BASE_URL . 'department-detail.php?slug=rkdf-homoeopathic-medical-college', 'external' => false],
        ['title' => 'RKDF College of Pharmacy', 'subtitle' => 'Pharmaceutical Sciences', 'img_src' => BASE_URL . 'assets/uploads/2026/07/SRK-COP.webp', 'href' => BASE_URL . 'department-detail.php?slug=rkdf-college-of-pharmacy', 'external' => false],
        ['title' => 'RKDF Dental College & Research Centre', 'subtitle' => 'Dental Sciences', 'img_src' => BASE_URL . 'assets/uploads/2026/07/012-scaled.webp', 'href' => BASE_URL . 'department-detail.php?slug=rkdf-dental-college', 'external' => false]
    ];
}
?>

<!-- ═══════════════════════════════════════════════════════
     HERO BANNER
═══════════════════════════════════════════════════════ -->
<section class="about-hero-v2">
    <div class="about-hero-v2__blob about-hero-v2__blob--1"></div>
    <div class="about-hero-v2__blob about-hero-v2__blob--2"></div>
    <div class="about-hero-v2__blob about-hero-v2__blob--3"></div>
    <div class="about-hero-v2__grid"></div>
    <div class="container-xl about-hero-v2__inner">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>" class="text-decoration-none text-warning"><i class="fas fa-home me-1"></i> Home</a></li>
                <li class="breadcrumb-item active text-white-50" aria-current="page">Constituent Units</li>
            </ol>
        </nav>
        <span class="about-hero-v2__eyebrow"><i class="fas fa-star"></i> Est. 1995 &middot; RKDF Education Society</span>
        <h1 class="about-hero-v2__title" style="max-width:800px;">120+ programs. One ambition: <span>your future.</span></h1>
        <p class="about-hero-v2__desc" style="max-width:760px;">
            From B.Tech and MBBS to MBA, LLM, and doctoral research &mdash; every programme blends theory, industry immersion, and global exposure. Essays, field notes, and long-form research from students, faculty, and alumni &mdash; published weekly.
        </p>
        <div class="d-flex flex-wrap gap-3">
            <a href="<?php echo BASE_URL; ?>departments.php" class="btn-hero-yellow">Explore All Departments</a>
            <a href="<?php echo BASE_URL; ?>admission-enquiry.php" class="btn-hero-outline">Apply For Admission</a>
        </div>
    </div>
</section>

<!-- STATS STRIP -->
<div class="stats-strip py-2">
    <div class="container-xl">
        <div class="row row-cols-2 row-cols-md-5 g-0 text-center">
            <div class="col stat-box">
                <div class="stat-val">18,000+</div>
                <div class="stat-txt">Students</div>
            </div>
            <div class="col stat-box">
                <div class="stat-val">600+</div>
                <div class="stat-txt">Faculty</div>
            </div>
            <div class="col stat-box">
                <div class="stat-val">120+</div>
                <div class="stat-txt">Programs</div>
            </div>
            <div class="col stat-box">
                <div class="stat-val">1,400+</div>
                <div class="stat-txt">Research Papers</div>
            </div>
            <div class="col stat-box">
                <div class="stat-val">42+</div>
                <div class="stat-txt">Global Partners</div>
            </div>
        </div>
    </div>
</div>

<!-- CONSTITUENT UNITS GRID -->
<section class="py-5">
    <div class="container-xl py-3">
        <div class="text-center mb-5">
            <span class="section-subtitle">CONSTITUENT UNITS OF OUR UNIVERSITY</span>
            <h2 class="section-title">A Guide to the <span>University's Constituent</span> Units</h2>
        </div>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-4">
            <?php foreach ($units as $u): ?>
                <div class="col">
                    <a href="<?php echo sanitize($u['href']); ?>"<?php echo $u['external'] ? ' target="_blank" rel="noopener"' : ''; ?> class="unit-card reveal">
                        <img src="<?php echo $u['img_src']; ?>"
                             onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';"
                             class="unit-card__img" alt="<?php echo sanitize($u['title']); ?>">
                        <span class="unit-card__scrim"></span>
                        <span class="unit-card__icon"><i class="fas fa-university"></i></span>
                        <span class="unit-card__body">
                            <span class="unit-card__title"><?php echo sanitize($u['title']); ?></span>
                            <?php if (!empty($u['subtitle'])): ?>
                                <span class="unit-card__subtitle"><?php echo sanitize($u['subtitle']); ?></span>
                            <?php endif; ?>
                            <span class="unit-card__cta">Explore <i class="fas fa-arrow-right ms-1"></i></span>
                        </span>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- FAQ -->
<section class="py-5 text-center text-white" style="background: linear-gradient(135deg, var(--srku-maroon), var(--srku-navy));">
    <div class="container-xl py-2">
        <span class="section-subtitle text-warning">FAQS</span>
        <h2 class="fw-bold mb-4">Answers before you ask.</h2>
        <div class="accordion mx-auto reveal" id="cuFaq" style="max-width:760px;">
            <div class="accordion-item">
                <h3 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#cuFaq1" aria-expanded="true" aria-controls="cuFaq1">
                        What does SRK University stand for?
                    </button>
                </h3>
                <div id="cuFaq1" class="accordion-collapse collapse show" data-bs-parent="#cuFaq">
                    <div class="accordion-body text-start">
                        SRK University is named after Dr. Sarvepalli Radhakrishnan, India's First Vice President, a renowned philosopher and educator. We embody his ideals of intellectual excellence and humanistic education.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h3 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#cuFaq2" aria-expanded="false" aria-controls="cuFaq2">
                        How does SRK University support diversity and inclusion?
                    </button>
                </h3>
                <div id="cuFaq2" class="accordion-collapse collapse" data-bs-parent="#cuFaq">
                    <div class="accordion-body text-start">
                        Our core value of tolerance and inclusivity means we actively recruit and support students from diverse backgrounds. We offer scholarships, mentorship, and campus organisations that celebrate cultural diversity.
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-5 text-center text-white" style="background: linear-gradient(135deg, var(--srku-navy), var(--srku-maroon));">
    <div class="container-xl py-2 reveal">
        <h2 class="fw-bold mb-4">Ready to write your chapter<br>at SRK University?</h2>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="<?php echo BASE_URL; ?>contact.php#apply" class="btn btn-srku-gold px-4 py-2">Apply Now</a>
            <a href="<?php echo BASE_URL; ?>assets/uploads/2026/07/Constituent-units.pdf" target="_blank" class="btn btn-srku-outline px-4 py-2">Download Brochure</a>
            <a href="tel:07554700983" class="btn btn-srku-outline px-4 py-2">Talk to Counsellor</a>
        </div>
    </div>
</section>

<script src="<?php echo BASE_URL; ?>assets/js/reveal.js" defer></script>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
