<?php
$pageTitle = "Accreditation & Regulatory Recognition - Sarvepalli Radhakrishnan University, Bhopal";
$activeNav = "about";
require_once __DIR__ . '/includes/header.php';
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
                <li class="breadcrumb-item active text-white-50" aria-current="page">Accreditations &amp; Approvals</li>
            </ol>
        </nav>
        <span class="about-hero-v2__eyebrow"><i class="fas fa-star"></i> Est. 1995 &middot; RKDF Education Society</span>
        <h1 class="about-hero-v2__title" style="max-width:800px;">Our <span>Accreditations &amp; Regulatory Recognition</span> &ndash; Guaranteeing Quality Excellence</h1>
        <p class="about-hero-v2__desc" style="max-width:760px;">
            SRK University is proud to hold comprehensive recognition and accreditation from India's leading regulatory bodies. These approvals reflect our unwavering commitment to academic excellence, quality assurance, and ethical practice across all our programmes.
        </p>
        <div class="d-flex flex-wrap gap-3">
            <a href="<?php echo BASE_URL; ?>admission-enquiry.php" class="btn-hero-yellow">Apply Now</a>
            <a href="<?php echo BASE_URL; ?>assets/uploads/2026/07/Recognition-Approval.pdf" target="_blank" class="btn-hero-outline"><i class="fas fa-file-pdf me-1 text-warning"></i> View Approval PDF</a>
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

<!-- 11 STATUTORY APPROVALS SECTION -->
<section class="py-5 bg-light">
    <div class="container-xl py-3">
        <div class="text-center max-w-700 mx-auto mb-5">
            <span class="section-subtitle"><i class="fas fa-certificate text-danger me-1"></i> OFFICIAL RECOGNITIONS</span>
            <h2 class="section-title">11 Statutory <span>Regulatory Approvals</span> &amp; Accreditations</h2>
            <p class="text-muted small mb-0">
                Sarvepalli Radhakrishnan University is duly recognized and accredited by the apex regulatory commissions and statutory councils of the Government of India and Government of Madhya Pradesh.
            </p>
        </div>

        <?php
        $approvals = [
            ['code' => 'UGC', 'name' => 'University Grants Commission', 'domain' => 'Govt. of India', 'desc' => 'Statutory recognition under Section 2(f) of the UGC Act 1956, Government of India, empowering degree-granting authority.'],
            ['code' => 'NMC', 'name' => 'National Medical Commission', 'domain' => 'Medical Education', 'desc' => 'Approved for MBBS, MD/MS, and Postgraduate Medical clinical specialties matching national clinical standards.'],
            ['code' => 'NCISM', 'name' => 'National Commission for Indian System of Medicine', 'domain' => 'Ayurvedic Medicine', 'desc' => 'Approved for BAMS (Bachelor of Ayurvedic Medicine & Surgery) and Ayurvedic clinical hospital practice.'],
            ['code' => 'NCH', 'name' => 'National Commission for Homoeopathy', 'domain' => 'Homoeopathic Medicine', 'desc' => 'Approved for BHMS and MD (Homoeopathy) programmes ensuring high healthcare education standards.'],
            ['code' => 'NDC', 'name' => 'National Dental Commission', 'domain' => 'Dental Surgery', 'desc' => 'Approved for BDS and MDS dental surgery programmes across 8 specialized clinical departments.'],
            ['code' => 'PCI', 'name' => 'Pharmacy Council of India', 'domain' => 'Pharmaceutical Sciences', 'desc' => 'Approved for D.Pharm, B.Pharm, and M.Pharm degrees across all constituent pharmacy colleges.'],
            ['code' => 'INC', 'name' => 'Indian Nursing Council', 'domain' => 'Nursing Sciences', 'desc' => 'Approved for GNM, B.Sc. Nursing, P.B.B.Sc., M.Sc. Nursing, and NPCC clinical training.'],
            ['code' => 'MPPMC', 'name' => 'M.P. Paramedical Council', 'domain' => 'Paramedical Health', 'desc' => 'Recognized for DMLT, BMLT, MMLT, BPT, MPT, Radiography, Dialysis, and Paramedical Diplomas.'],
            ['code' => 'AICTE', 'name' => 'All India Council for Technical Education', 'domain' => 'Engineering & Management', 'desc' => 'Approved for Engineering Diploma, B.Tech., M.Tech., MCA, and MBA professional programmes.'],
            ['code' => 'BCI', 'name' => 'Bar Council of India', 'domain' => 'Legal Education', 'desc' => 'Approved for B.A. LL.B. (Hons.), LL.B. (3 Years), and LL.M. professional legal education.'],
            ['code' => 'MPPURC', 'name' => 'M.P. Private University Regulatory Commission', 'domain' => 'State Regulatory Council', 'desc' => 'Established under Madhya Pradesh Niji Vishwavidyalaya Adhiniyam 2007 (Act No. 17 of 2007).']
        ];
        ?>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 g-4">
            <?php foreach ($approvals as $ap): ?>
                <div class="col">
                    <div class="accred-approval-card h-100 d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-center gap-2 mb-2">
                            <span class="accred-dept-pill"><?php echo sanitize($ap['domain']); ?></span>
                            <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill accred-status-badge">
                                <i class="fas fa-check-circle me-1"></i> Recognized
                            </span>
                        </div>
                        <div class="accred-code"><?php echo sanitize($ap['code']); ?></div>
                        <div class="accred-full-name"><?php echo sanitize($ap['name']); ?></div>
                        <p class="accred-desc mt-auto"><?php echo sanitize($ap['desc']); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- CONSTITUENT INSTITUTES & SEALS -->
<section class="py-5 bg-white">
    <div class="container-xl py-3">
        <div class="text-center max-w-700 mx-auto mb-5">
            <span class="section-subtitle"><i class="fas fa-university text-danger me-1"></i> ACADEMIC EXCELLENCE</span>
            <h2 class="section-title">Official Constituent <span>Colleges &amp; Seals</span></h2>
            <p class="text-muted small mb-0">
                Our distinguished constituent institutes operate under the statutory framework of SRK University, delivering benchmarked professional education across disciplines.
            </p>
        </div>

        <?php
        $constituentLogos = [
            ['name' => 'RKDF Medical College Hospital & Research Centre', 'img' => 'logo-rkdf-medical.png', 'est' => '2014', 'slug' => 'rkdf-medical-college'],
            ['name' => 'SRK College of Ayurveda Hospital', 'img' => 'logo-srk-ayurveda.png', 'est' => '2021', 'slug' => 'sarvepalli-radhakrishnan-college-of-ayurveda'],
            ['name' => 'RKDF Homoeopathic Medical College', 'img' => 'logo-rkdf-homoeopathy.png', 'est' => '2000', 'slug' => 'rkdf-homoeopathic-medical-college'],
            ['name' => 'RKDF Dental College & Research Centre', 'img' => 'logo-rkdf-dental.png', 'est' => '2003', 'slug' => 'rkdf-dental-college'],
            ['name' => 'RKDF College of Pharmacy', 'img' => 'logo-rkdf-pharmacy.png', 'est' => '1995', 'slug' => 'rkdf-college-of-pharmacy'],
            ['name' => 'RKDF College of Nursing', 'img' => 'logo-rkdf-nursing.png', 'est' => '2003', 'slug' => 'rkdf-college-of-nursing'],
            ['name' => 'SRK College of Allied & Healthcare Sciences', 'img' => 'logo-allied-healthcare.png', 'est' => '2019', 'slug' => 'department-of-paramedical-sciences'],
            ['name' => 'RKDF Institute of Science & Technology', 'img' => 'logo-rkdf-science-tech.png', 'est' => '1995', 'slug' => 'rkdf-institute-of-science-and-technology'],
            ['name' => 'SRK College of Law', 'img' => 'logo-srk-law.png', 'est' => '2019', 'slug' => 'faculty-of-law'],
            ['name' => 'RKDF Institute of Business Management', 'img' => 'logo-rkdf-management.png', 'est' => '2006', 'slug' => 'rkdf-institute-of-business-management'],
            ['name' => 'Faculty of Agriculture, SRKU', 'img' => 'logo-srk-agriculture.png', 'est' => '2018', 'slug' => 'faculty-of-agriculture']
        ];
        ?>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 justify-content-center">
            <?php foreach ($constituentLogos as $cl): ?>
                <div class="col">
                    <div class="constituent-seal-card h-100 d-flex flex-column">
                        <div class="constituent-seal-logo-wrap">
                            <img src="<?php echo BASE_URL; ?>assets/images/constituent-logos/<?php echo $cl['img']; ?>" 
                                 onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/SRK-logo.webp';"
                                 alt="<?php echo sanitize($cl['name']); ?>" 
                                 class="img-fluid" style="max-height: 68px; width: auto; object-fit: contain;">
                        </div>
                        <h4 class="constituent-seal-title"><?php echo sanitize($cl['name']); ?></h4>
                        
                        <div class="d-flex justify-content-center align-items-center gap-2 mb-3 mt-auto">
                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2.5 py-1 rounded-pill small fw-bold">
                                Constituent Unit
                            </span>
                            <span class="badge bg-light text-dark border px-2.5 py-1 rounded-pill small fw-semibold">
                                <i class="far fa-calendar-alt text-warning me-1"></i> Est. <?php echo $cl['est']; ?>
                            </span>
                        </div>

                        <a href="<?php echo BASE_URL . $cl['slug']; ?>" class="btn btn-sm btn-outline-danger rounded-pill fw-bold py-1.5">
                            Explore College <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- CAMPUS GALLERY -->
<?php
$accGalleryImages = [
    ['path' => 'assets/uploads/2026/08/welcome-srku-campus.jpeg', 'alt' => 'SRK University Main Building'],
    ['path' => 'assets/uploads/2026/08/srku-main-gate.jpeg', 'alt' => 'SRK University Main Gate'],
    ['path' => 'assets/uploads/2026/08/srku-academic-block.jpeg', 'alt' => 'SRK University Academic Block'],
    ['path' => 'assets/uploads/2026/08/srku-rkdf-building.jpeg', 'alt' => 'RKDF Group Campus Building'],
    ['path' => 'assets/uploads/2026/08/srku-campus-block.jpeg', 'alt' => 'SRK University Campus Block'],
    ['path' => 'assets/uploads/2026/07/Gallary-slider-07.webp', 'alt' => 'Students in the University Library'],
    ['path' => 'assets/uploads/2026/07/Gallary-slider-06.webp', 'alt' => 'Clinical Training at SRK University'],
    ['path' => 'assets/uploads/2026/07/Gallary-slider-10.webp', 'alt' => 'SRK University Faculty Group'],
    ['path' => 'assets/uploads/2026/07/5.png', 'alt' => 'Student Life at SRK University']
];
?>
<section class="py-5 text-center text-white" style="background: linear-gradient(135deg, var(--srku-maroon), var(--srku-navy));">
    <div class="container-xl py-2 reveal">
        <span class="section-subtitle text-warning">CAMPUS GALLERY</span>
        <h2 class="fw-bold mb-0">A Glimpse Into Life at SRK University</h2>
    </div>
</section>
<section class="auto-gallery" id="gallery">
    <div class="auto-gallery__viewport" id="accGalleryViewport">
        <div class="auto-gallery__track" id="accGalleryTrack">
            <?php foreach ($accGalleryImages as $image): ?>
                <div class="auto-gallery__item">
                    <img src="<?php echo BASE_URL . sanitize($image['path']); ?>"
                         onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';"
                         alt="<?php echo sanitize($image['alt']); ?>">
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="auto-gallery__dots" id="accGalleryDots"></div>
    <div class="text-center mt-4">
        <a href="<?php echo BASE_URL; ?>gallery.php?category=Campus" class="btn btn-srku-gold">
            <i class="fas fa-images me-2"></i>View More Photos
        </a>
    </div>
</section>
<script>
(function () {
    var track = document.getElementById('accGalleryTrack');
    var viewport = document.getElementById('accGalleryViewport');
    var dotsWrap = document.getElementById('accGalleryDots');
    if (!track || !viewport || !dotsWrap) return;

    var originalItems = Array.prototype.slice.call(track.children);
    var total = originalItems.length;
    var index = 0;
    var dots = [];
    var timer;

    originalItems.slice(0, Math.min(4, total)).forEach(function (item) {
        track.appendChild(item.cloneNode(true));
    });

    function setPosition(withTransition) {
        var itemWidth = track.children[0].getBoundingClientRect().width;
        var styles = getComputedStyle(track);
        var gap = parseFloat(styles.columnGap || styles.gap || 0);
        track.style.transition = withTransition === false ? 'none' : '';
        track.style.transform = 'translateX(-' + (index * (itemWidth + gap)) + 'px)';
    }

    function updateDots() {
        dots.forEach(function (dot, dotIndex) {
            var active = dotIndex === (index % total);
            dot.classList.toggle('active', active);
            dot.setAttribute('aria-current', active ? 'true' : 'false');
        });
    }

    function goTo(nextIndex) {
        index = nextIndex;
        setPosition(true);
        updateDots();
    }

    function next() {
        index++;
        setPosition(true);
        updateDots();
        if (index >= total) {
            window.setTimeout(function () {
                index = 0;
                setPosition(false);
                updateDots();
            }, 600);
        }
    }

    function startAutoScroll() {
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
        window.clearInterval(timer);
        timer = window.setInterval(next, 3000);
    }

    originalItems.forEach(function (_, dotIndex) {
        var dot = document.createElement('button');
        dot.type = 'button';
        dot.className = 'auto-gallery__dot' + (dotIndex === 0 ? ' active' : '');
        dot.setAttribute('aria-label', 'Show gallery photo ' + (dotIndex + 1));
        dot.setAttribute('aria-current', dotIndex === 0 ? 'true' : 'false');
        dot.addEventListener('click', function () {
            goTo(dotIndex);
            startAutoScroll();
        });
        dotsWrap.appendChild(dot);
        dots.push(dot);
    });

    viewport.addEventListener('mouseenter', function () { window.clearInterval(timer); });
    viewport.addEventListener('mouseleave', startAutoScroll);
    window.addEventListener('resize', function () { setPosition(false); });

    setPosition(false);
    startAutoScroll();
})();
</script>

<!-- FAQ -->
<section class="py-5 text-center text-white" style="background: linear-gradient(135deg, var(--srku-maroon), var(--srku-navy));">
    <div class="container-xl py-2">
        <span class="section-subtitle text-warning">FAQS</span>
        <h2 class="fw-bold mb-4">Answers before you ask.</h2>
        <div class="accordion mx-auto reveal" id="accredFaq" style="max-width:760px;">
            <div class="accordion-item">
                <h3 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1" aria-expanded="true" aria-controls="faq1">
                        Is SRK University UGC approved?
                    </button>
                </h3>
                <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#accredFaq">
                    <div class="accordion-body text-start">
                        Yes, SRK University is UGC recognised under Section 2(f) of the UGC Act, confirming our status as a legitimate, quality-assured higher education institution.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h3 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2" aria-expanded="false" aria-controls="faq2">
                        Are SRK's medical and dental programmes recognised by the government?
                    </button>
                </h3>
                <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#accredFaq">
                    <div class="accordion-body text-start">
                        Yes. Our MBBS and MD programmes are NMC approved. Our BDS and MDS programmes are DCI approved, ensuring they meet national standards and graduates can practise across India.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h3 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3" aria-expanded="false" aria-controls="faq3">
                        Will my degree from SRK University be recognised if I pursue a degree abroad?
                    </button>
                </h3>
                <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#accredFaq">
                    <div class="accordion-body text-start">
                        Our UGC recognition and programme-specific regulatory approvals ensure your degree has standing in India. International recognition depends on the country and institution; many international universities recognise UGC-recognised Indian degrees, particularly from NAAC-accredited institutions.
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
            <a href="<?php echo BASE_URL; ?>contact.php#apply" class="btn btn-srku-outline px-4 py-2">Recognition Approval</a>
            <a href="tel:07554700983" class="btn btn-srku-outline px-4 py-2">Talk to Counsellor</a>
        </div>
    </div>
</section>

<script src="<?php echo BASE_URL; ?>assets/js/reveal.js" defer></script>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
