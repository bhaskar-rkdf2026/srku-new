<?php
$pageTitle = "Constituent Units - Sarvepalli Radhakrishnan University, Bhopal";
$activeNav = "about";
require_once __DIR__ . '/includes/header.php';

$units = [
    ['title' => 'RKDF IST', 'subtitle' => 'RKDF INSTITUTE OF SCIENCE & TECHNOLOGY', 'img' => 'RKDF-IST.webp', 'href' => BASE_URL . 'department-detail.php?slug=rkdf-institute-of-science-technology', 'external' => false],
    ['title' => 'RKDF MEDICAL COLLEGE', 'subtitle' => 'RKDF MEDICAL COLLEGE, HOSPITAL & RESEARCH CENTER', 'img' => 'RKDF-MEDICAL-COLLEGE.webp', 'href' => 'https://rkdfmedicalcollege.org/', 'external' => true],
    ['title' => 'SRK COLLEGE OF AYURVEDA', 'subtitle' => 'SARVEPALLI RADHAKRISHNAN COLLEGE OF AYURVEDA HOSPITAL & RESEARCH CENTER', 'img' => 'SRK-COLLEGE-OF-AYURVEDA.webp', 'href' => 'http://www.srkcahrc.in/', 'external' => true],
    ['title' => 'RKDF HOMEOPATHIC', 'subtitle' => 'RKDF HOMEOPATHIC MEDICAL COLLEGE HOSPITAL & RESEARCH CENTER', 'img' => 'RKDF-HOMOEOPATHIC.webp', 'href' => 'http://www.rkdfhmc.in/', 'external' => true],
    ['title' => 'RKDF COP', 'subtitle' => 'RKDF COLLEGE OF PHARMACY', 'img' => 'RKDF-COP.webp', 'href' => BASE_URL . 'department-detail.php?slug=rkdf-college-of-pharmacy', 'external' => false],
    ['title' => 'RKDF POLYTECHNIC PHARMACY', 'subtitle' => 'RKDF POLYTECHNIC PHARMACY', 'img' => 'RKDF-POLYTECHNIC-PHARMACY.webp', 'href' => BASE_URL . 'department-detail.php?slug=rkdf-polytechnic-pharmacy', 'external' => false],
    ['title' => 'DR. APJ. COP', 'subtitle' => 'DR. APJ. ABDUL KALAM COLLEGE OF PHARMACY', 'img' => 'DR.-APJ.-COP.webp', 'href' => BASE_URL . 'department-detail.php?slug=dr-apj-abdul-kalam-college-of-pharmacy', 'external' => false],
    ['title' => 'SRK COP', 'subtitle' => 'SARVEPALLI RADHAKRISHNAN COLLEGE OF PHARMACY', 'img' => 'SRK-COP.webp', 'href' => BASE_URL . 'department-detail.php?slug=sarvepalli-radhakrishnan-college-of-pharmacy', 'external' => false],
    ['title' => 'SS COP', 'subtitle' => 'SRI SAI COLLEGE OF PHARMACY', 'img' => 'SS-COP.webp', 'href' => BASE_URL . 'department-detail.php?slug=sri-sai-college-of-pharmacy', 'external' => false],
    ['title' => 'SRK IPS', 'subtitle' => 'SARVEPALLI RADHAKRISHNAN INSTITUTE OF PHARMACEUTICAL SCIENCES', 'img' => 'SRK-IPS.webp', 'href' => BASE_URL . 'department-detail.php?slug=sarvepalli-radhakrishnan-institute-of-pharmaceutical-science', 'external' => false],
    ['title' => 'R.N. KAPOOR MEMORIAL PHARMACY', 'subtitle' => 'R. N. KAPOOR MEMORIAL INSTITUTE OF PHARMACEUTICAL SCIENCES', 'img' => 'R.N.-KAPOOR-MEMORIAL-PHARMACY.webp', 'href' => BASE_URL . 'department-detail.php?slug=r-n-kapoor-memorial-institute-of-pharmaceutical-science', 'external' => false],
    ['title' => 'SARVEPALLI RADHAKRISHNAN COLLEGE OF ALLIED & HEALTHCARE SCIENCES', 'subtitle' => 'SARVEPALLI RADHAKRISHNAN COLLEGE OF ALLIED & HEALTHCARE SCIENCES', 'img' => 'SARVEPALLI-RADHAKRISHANAN-COLLEGE-OF-ALLIED-HEALTHCARE-SCIENCES.webp', 'href' => BASE_URL . 'department-detail.php?slug=department-of-allied-health-care-sciences', 'external' => false],
    ['title' => 'RKDF DENTAL COLLEGE', 'subtitle' => 'RKDF DENTAL COLLEGE & RESEARCH CENTRE', 'img' => '012-scaled.webp', 'href' => 'http://rkdfdentalcollege.in/', 'external' => true],
    ['title' => 'Faculty of Agriculture', 'subtitle' => 'Faculty of Agriculture', 'img' => '011-scaled.webp', 'href' => BASE_URL . 'department-detail.php?slug=faculty-of-agriculture', 'external' => false],
    ['title' => 'NURSING COLLEGE', 'subtitle' => 'RKDF COLLEGE OF NURSING', 'img' => '010-scaled.webp', 'href' => BASE_URL . 'department-detail.php?slug=rkdf-college-of-nursing', 'external' => false],
    ['title' => 'RKDF IBM', 'subtitle' => 'RKDF INSTITUTE OF BUSINESS MANAGEMENT', 'img' => '003-scaled.webp', 'href' => BASE_URL . 'department-detail.php?slug=rkdf-institute-of-business-management', 'external' => false],
    ['title' => 'RKDF IM', 'subtitle' => 'RKDF INSTITUTE OF MANAGEMENT', 'img' => '009-scaled.webp', 'href' => BASE_URL . 'department-detail.php?slug=rkdf-institute-of-management', 'external' => false],
    ['title' => 'RKDF IST MCA', 'subtitle' => 'RKDF INSTITUTE OF SCIENCE & TECHNOLOGY MCA', 'img' => 'ChatGPTImageAug5202611_07_54A-1.webp', 'href' => BASE_URL . 'department-detail.php?slug=rkdf-institute-science-technology-mca', 'external' => false, 'dir' => '2026/08'],
    ['title' => 'SRK LAW COLLEGE', 'subtitle' => 'SARVEPALLI RADHAKRISHNAN COLLEGE OF LAW', 'img' => '006-scaled.webp', 'href' => BASE_URL . 'department-detail.php?slug=sarvepalli-radhakrishnan-college-of-law', 'external' => false],
    ['title' => 'Faculty of Allied Sciences', 'subtitle' => '', 'img' => '005-scaled.webp', 'href' => BASE_URL . 'departments.php', 'external' => false],
    ['title' => 'Faculty of Commerce', 'subtitle' => '', 'img' => 'ChatGPTImageAug5202610_50_16A.jpg', 'href' => BASE_URL . 'departments.php', 'external' => false, 'dir' => '2026/08'],
    ['title' => 'Faculty of Allied Arts', 'subtitle' => '', 'img' => '002-scaled.webp', 'href' => BASE_URL . 'departments.php', 'external' => false],
    ['title' => 'Faculty of Computer Application', 'subtitle' => '', 'img' => '008-scaled.webp', 'href' => BASE_URL . 'department-detail.php?slug=faculty-of-computer-application', 'external' => false],
    ['title' => 'Faculty of Library & Information Science', 'subtitle' => '', 'img' => '001-scaled.webp', 'href' => BASE_URL . 'departments.php', 'external' => false],
];
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
<<<<<<< HEAD
        <span class="about-hero-v2__eyebrow"><i class="fas fa-star"></i> Est. 1995 &middot; RKDF Education Society</span>
        <h1 class="about-hero-v2__title" style="max-width:800px;">120+ programs. One ambition: <span>your future.</span></h1>
        <p class="about-hero-v2__desc" style="max-width:760px;">
            From B.Tech and MBBS to MBA, LLM, and doctoral research &mdash; every programme blends theory, industry immersion, and global exposure. Essays, field notes, and long-form research from students, faculty, and alumni &mdash; published weekly.
=======
        <span class="about-hero-tag" style="display: inline-flex; align-items: center; gap: 6px; background: rgba(229, 169, 59, 0.16) !important; color: #ffcc00 !important; border: 1px solid rgba(229, 169, 59, 0.38) !important; font-size: 0.76rem; font-weight: 700; padding: 5px 14px; border-radius: 30px; letter-spacing: 0.6px; text-transform: uppercase; margin-bottom: 1rem;"><i class="fas fa-building me-1"></i> INSTITUTES &amp; COLLEGES</span>
        <h1 class="fw-bold display-6 mb-3 text-white" style="max-width:860px; line-height: 1.3;">Constituent Colleges &amp; Faculties of SRK University</h1>
        <p class="mb-4 text-white-50" style="max-width:780px; line-height:1.8; font-size: 1.02rem;">
            26 apex constituent institutes deliver benchmarked education across Medical, Ayurveda, Homoeopathy, Dental, Pharmacy, Nursing, Engineering, Law, Management, and Agriculture disciplines.
>>>>>>> 9886b3062a50f4a31440069af5d456b70d8e3aad
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
                        <img src="<?php echo BASE_URL . 'assets/uploads/' . ($u['dir'] ?? '2026/07') . '/' . rawurlencode($u['img']); ?>"
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
