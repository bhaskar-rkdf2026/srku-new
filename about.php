<?php
$pageTitle = "About Us - Sarvepalli Radhakrishnan University, Bhopal";
$activeNav = "about";
require_once __DIR__ . '/includes/header.php';
?>

<!-- ═══════════════════════════════════════════════════════
     HERO BANNER
═══════════════════════════════════════════════════════ -->
<section class="position-relative text-white py-5" style="background: linear-gradient(100deg, rgba(61,10,9,0.62) 0%, rgba(8,16,32,0.6) 100%), url('<?php echo BASE_URL; ?>assets/uploads/2026/07/campus-1.webp') center/cover no-repeat;">
    <div class="container-xl py-4 position-relative z-2">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>" class="text-decoration-none text-warning">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page" style="color: rgba(255,255,255,0.85);">About</li>
            </ol>
        </nav>
        <h1 class="fw-bold display-6 mb-3" style="text-shadow: 0 2px 12px rgba(0,0,0,0.45);">Discover SRK University &ndash; Bhopal's Premier Multidisciplinary Private University</h1>
        <p class="mb-4" style="max-width:760px; line-height:1.8; color: rgba(255,255,255,0.9); text-shadow: 0 1px 6px rgba(0,0,0,0.4);">
            Welcome to Sarvepalli Radhakrishnan University, commonly known as SRK University, one of Madhya Pradesh's leading private universities. Named after Dr. Sarvepalli Radhakrishnan, India's First Vice President, our institution embodies excellence, innovation, and commitment to holistic education.
        </p>
        <div class="d-flex flex-wrap gap-3">
            <a href="<?php echo BASE_URL; ?>contact.php#apply" class="btn-hero-yellow">Apply Now</a>
            <a href="<?php echo BASE_URL; ?>page.php?slug=board-of-management" class="btn-hero-outline">Meet the Leadership</a>
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

<!-- WHO WE ARE / UNIVERSITY OVERVIEW -->
<section class="py-5" id="overview">
    <div class="container-xl py-3">
        <div class="row align-items-center g-4 g-lg-5">
            <div class="col-12 col-lg-5 reveal">
                <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/campus-1.webp"
                     onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';"
                     class="welcome-img" alt="SRK University Campus">
            </div>
            <div class="col-12 col-lg-7 reveal">
                <span class="section-subtitle">UNIVERSITY OVERVIEW</span>
                <h2 class="section-title mb-3">Who <span>We Are</span></h2>
                <p class="text-dark mb-4" style="line-height:1.8; font-size:0.96rem;">
                    Established under the Madhya Pradesh Niji Vishwavidyalaya (Sthapana Avam Sanchalan) Adhiniyam 2007, as amended by the Dwitiya Sanshodhan Adhiniyam 2014, and sponsored by RKDF Education Society Bhopal, SRK University stands as a beacon of academic excellence in central India.
                </p>
                <ul class="list-unstyled row row-cols-1 row-cols-sm-2 g-2 mb-0">
                    <li class="col fw-semibold"><i class="fas fa-check-square text-danger me-2"></i> UGC (University Grants Commission) &ndash; Section 2(f)</li>
                    <li class="col fw-semibold"><i class="fas fa-check-square text-danger me-2"></i> AICTE (All India Council for Technical Education)</li>
                    <li class="col fw-semibold"><i class="fas fa-check-square text-danger me-2"></i> NMC (National Medical Commission) &ndash; MBBS &amp; MD programmes</li>
                    <li class="col fw-semibold"><i class="fas fa-check-square text-danger me-2"></i> DCI (Dental Council of India) &ndash; BDS &amp; MDS programmes</li>
                    <li class="col fw-semibold"><i class="fas fa-check-square text-danger me-2"></i> PCI (Pharmacy Council of India) &ndash; Pharmacy programmes</li>
                    <li class="col fw-semibold"><i class="fas fa-check-square text-danger me-2"></i> INC (Indian Nursing Council) &ndash; Nursing programmes</li>
                    <li class="col fw-semibold"><i class="fas fa-check-square text-danger me-2"></i> CCH &amp; NCISM (Central Council for Homeopathy)</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- VISION & MISSION -->
<section class="py-5 bg-cream" id="vision">
    <div class="container-xl py-3">
        <div class="text-center mb-4">
            <span class="section-subtitle">OUR COMMITMENT</span>
            <h2 class="section-title">Our <span>Vision</span> &amp; <span>Mission</span></h2>
        </div>

        <div class="vm-tabs reveal" id="vmTabs" role="tablist">
            <button type="button" class="vm-tab active" data-target="vm-panel-vision" role="tab" aria-selected="true">
                <i class="fas fa-eye me-2"></i> Our Vision
            </button>
            <button type="button" class="vm-tab" data-target="vm-panel-mission" role="tab" aria-selected="false">
                <i class="fas fa-bullseye me-2"></i> Our Mission
            </button>
        </div>

        <div class="vm-panel-wrap reveal">
            <div class="vm-panel active" id="vm-panel-vision" role="tabpanel">
                <p class="vm-panel__text">
                    To be a leading institution of higher education known for innovative teaching, research, and exceptional faculty, students, and staff of diverse social, cultural, religious, economic, and tribal backgrounds, prepared to tackle the challenges of the 21st century.
                </p>
            </div>
            <div class="vm-panel" id="vm-panel-mission" role="tabpanel">
                <p class="vm-panel__text">
                    To provide world-class education to our students, create and disseminate knowledge through cutting-edge research, and engage with communities to better understand and solve their most pressing challenges.
                </p>
            </div>
        </div>
    </div>
</section>
<script>
(function () {
    var tabs = document.querySelectorAll('#vmTabs .vm-tab');
    var panels = document.querySelectorAll('.vm-panel-wrap .vm-panel');
    tabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
            tabs.forEach(function (t) { t.classList.remove('active'); t.setAttribute('aria-selected', 'false'); });
            panels.forEach(function (p) { p.classList.remove('active'); });
            tab.classList.add('active');
            tab.setAttribute('aria-selected', 'true');
            document.getElementById(tab.dataset.target).classList.add('active');
        });
    });
})();
</script>

<!-- WHY CHOOSE SRK UNIVERSITY -->
<section class="py-5" id="why">
    <div class="container-xl py-3">
        <div class="text-center mb-5">
            <span class="section-subtitle">WHY SRKU</span>
            <h2 class="section-title">Why Choose <span>SRK University?</span></h2>
        </div>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <div class="col">
                <div class="card h-100 p-4 border-0 shadow-sm rounded-4 reveal">
                    <div class="about-num-badge">01</div>
                    <h4 class="h5 fw-bold text-navy mb-2">Multidisciplinary Education</h4>
                    <p class="text-muted small mb-0" style="line-height:1.75;">We offer over 50 diverse programmes spanning Medical, Dental, Nursing, Engineering, Management, Law, Commerce, Agriculture, Science, and Humanities. Students choose courses aligned with their aspirations and the National Education Policy 2020.</p>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 p-4 border-0 shadow-sm rounded-4 reveal">
                    <div class="about-num-badge">02</div>
                    <h4 class="h5 fw-bold text-navy mb-2">State-of-the-Art Infrastructure</h4>
                    <p class="text-muted small mb-0" style="line-height:1.75;">Our lush green campus spans a cosmopolitan setting with modern laboratories, interactive learning spaces, high-tech medical facilities, and libraries equipped with the latest technology and resources.</p>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 p-4 border-0 shadow-sm rounded-4 reveal">
                    <div class="about-num-badge">03</div>
                    <h4 class="h5 fw-bold text-navy mb-2">NAAC-Graded Excellence</h4>
                    <p class="text-muted small mb-0" style="line-height:1.75;">SRK University is NAAC-accredited, ensuring quality education meets international standards. Our commitment to continuous improvement and academic rigor sets us apart from other private universities in Bhopal.</p>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 p-4 border-0 shadow-sm rounded-4 reveal">
                    <div class="about-num-badge">04</div>
                    <h4 class="h5 fw-bold text-navy mb-2">Industry &amp; Research Partnerships</h4>
                    <p class="text-muted small mb-0" style="line-height:1.75;">We foster strong collaborations with leading industries for internships, placements, and research initiatives, ensuring students gain hands-on experience and are job-ready upon graduation.</p>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 p-4 border-0 shadow-sm rounded-4 reveal">
                    <div class="about-num-badge">05</div>
                    <h4 class="h5 fw-bold text-navy mb-2">Diverse Student Community</h4>
                    <p class="text-muted small mb-0" style="line-height:1.75;">Our campus welcomes students from all corners of India, creating a multicultural environment that enriches learning and promotes cross-cultural understanding.</p>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 p-4 border-0 shadow-sm rounded-4 reveal">
                    <div class="about-num-badge">06</div>
                    <h4 class="h5 fw-bold text-navy mb-2">Holistic Student Development</h4>
                    <p class="text-muted small mb-0" style="line-height:1.75;">At SRK University, students grow beyond academics through sports, cultural activities, leadership programs, innovation, and community engagement, building confidence, teamwork, and essential life skills for future success.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- RECOGNITIONS / ACCREDITATION -->
<section class="py-5 bg-cream" id="accred">
    <div class="container-xl py-3">
        <div class="text-center mb-5">
            <span class="section-subtitle">RECOGNITIONS</span>
            <h2 class="section-title">Accredited. <span>Recognized.</span> Trusted.</h2>
        </div>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4">
            <div class="col">
                <div class="card h-100 p-4 text-center border-0 shadow-sm rounded-4 reveal">
                    <div class="bg-danger-subtle text-danger rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3" style="width:60px; height:60px; font-size:1.5rem;">
                        <i class="fas fa-award"></i>
                    </div>
                    <h3 class="h5 fw-bold text-navy mb-2">UGC</h3>
                    <p class="text-muted small mb-0">Recognized under Section 2(f) of the UGC Act, 1956.</p>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 p-4 text-center border-0 shadow-sm rounded-4 reveal">
                    <div class="bg-danger-subtle text-danger rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3" style="width:60px; height:60px; font-size:1.5rem;">
                        <i class="fas fa-award"></i>
                    </div>
                    <h3 class="h5 fw-bold text-navy mb-2">NAAC A+</h3>
                    <p class="text-muted small mb-0">Accredited by the National Assessment and Accreditation Council.</p>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 p-4 text-center border-0 shadow-sm rounded-4 reveal">
                    <div class="bg-danger-subtle text-danger rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3" style="width:60px; height:60px; font-size:1.5rem;">
                        <i class="fas fa-award"></i>
                    </div>
                    <h3 class="h5 fw-bold text-navy mb-2">AICTE</h3>
                    <p class="text-muted small mb-0">All technical programs approved by the All India Council for Technical Education.</p>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 p-4 text-center border-0 shadow-sm rounded-4 reveal">
                    <div class="bg-danger-subtle text-danger rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3" style="width:60px; height:60px; font-size:1.5rem;">
                        <i class="fas fa-award"></i>
                    </div>
                    <h3 class="h5 fw-bold text-navy mb-2">PCI &amp; INC</h3>
                    <p class="text-muted small mb-0">Pharmacy and Nursing programs approved by the respective national councils.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CAMPUS GALLERY (title band + image grid, kept together) -->
<section class="py-5 text-center text-white" style="background: linear-gradient(135deg, var(--srku-maroon), var(--srku-navy));">
    <div class="container-xl py-2 reveal">
        <span class="section-subtitle text-warning">CAMPUS GALLERY</span>
        <h2 class="fw-bold mb-0">A Glimpse Into Life at SRK University</h2>
    </div>
</section>
<section class="py-5" id="gallery">
    <div class="container-xl py-2">
        <div class="row row-cols-2 row-cols-md-4 g-2">
            <div class="col reveal"><img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/Gallary-slider-07.webp" class="gallery-img" alt="SRK University Campus Gallery 1" onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';"></div>
            <div class="col reveal"><img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/Gallary-slider-06.webp" class="gallery-img" alt="SRK University Campus Gallery 2" onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';"></div>
            <div class="col reveal"><img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/Gallary-slider-10.webp" class="gallery-img" alt="SRK University Campus Gallery 3" onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';"></div>
            <div class="col reveal"><img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/5.png" class="gallery-img" alt="SRK University Campus Gallery 4" onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';"></div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-5 text-center text-white" style="background: linear-gradient(135deg, var(--srku-navy), var(--srku-maroon));">
    <div class="container-xl py-2 reveal">
        <h2 class="fw-bold mb-4">Ready to write your chapter<br>at SRK University?</h2>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="<?php echo BASE_URL; ?>contact.php#apply" class="btn btn-srku-gold px-4 py-2">Apply Now</a>
            <a href="<?php echo BASE_URL; ?>contact.php#apply" class="btn btn-srku-outline px-4 py-2">Schedule a Visit</a>
            <a href="tel:07554700983" class="btn btn-srku-outline px-4 py-2">Talk to Counsellor</a>
        </div>
    </div>
</section>

<script src="<?php echo BASE_URL; ?>assets/js/reveal.js" defer></script>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
