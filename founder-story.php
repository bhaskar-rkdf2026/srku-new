<?php
require_once __DIR__ . '/includes/functions.php';

$chairmanName = getSetting('chairman_name', 'Dr. Sunil Kapoor');
$chairmanTitle = getSetting('chairman_title', 'Chairman & Founder Patron');
$chairmanPhoto = getSetting('chairman_photo', 'assets/uploads/2026/08/dr-sunil-kapoor.jpeg');
$chairmanPhotoSrc = (strpos($chairmanPhoto, 'http') === 0) ? $chairmanPhoto : BASE_URL . $chairmanPhoto;

$pageTitle = "Founder's Story & Vision | " . $chairmanName . " | SRKU Bhopal";
$pageDesc = "Discover the inspiring founder story, vision, and institutional leadership of " . $chairmanName . ", Founder & Chairman of RKDF Group and Sarvepalli Radhakrishnan University (SRKU), Bhopal.";
$pageKeywords = "Dr Sunil Kapoor Bhopal, Dr Sunil Kapoor SRKU, Founder Story RKDF, Chairman Sunil Kapoor, SRK University Founder, Educationist Madhya Pradesh";
$activeNav = "about";
require_once __DIR__ . '/includes/header.php';
?>

<!-- ═══════════════════════════════════════════════════════
     HERO — AURORA MESH
═══════════════════════════════════════════════════════ -->
<section class="about-hero-v2">
    <div class="about-hero-v2__blob about-hero-v2__blob--1"></div>
    <div class="about-hero-v2__blob about-hero-v2__blob--2"></div>
    <div class="about-hero-v2__blob about-hero-v2__blob--3"></div>
    <div class="about-hero-v2__grid"></div>

    <div class="container-xl about-hero-v2__inner">
        <div class="row align-items-center g-5">
            <div class="col-12 col-lg-8">
                <nav aria-label="breadcrumb" class="mb-3">
                    <ol class="breadcrumb mb-0 small">
                        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>" class="text-decoration-none text-warning"><i class="fas fa-home me-1"></i> Home</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>about.php" class="text-decoration-none text-white-50">About</a></li>
                        <li class="breadcrumb-item active" aria-current="page" style="color: rgba(255,255,255,0.85);">Founder's Story</li>
                    </ol>
                </nav>
                <span class="about-hero-v2__eyebrow"><i class="fas fa-award text-warning"></i> Institutional Founder &amp; Chief Patron</span>
                <h1 class="about-hero-v2__title">Founder's Story &amp; <span>Vision</span></h1>
                <p class="about-hero-v2__desc">
                    "Transforming society through the twin pillars of quality education and accessible healthcare—nurturing ethical innovators, skilled professionals, and future-ready leaders."
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="<?php echo BASE_URL; ?>courses" class="btn-hero-yellow">
                        <i class="fas fa-graduation-cap me-1"></i> Explore 120+ Programs
                    </a>
                    <a href="<?php echo BASE_URL; ?>about.php#leadership" class="btn-hero-outline">
                        <i class="fas fa-users-cog me-1"></i> University Leadership
                    </a>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="about-hero-v2__cards">
                    <div class="about-hero-v2__card about-hero-v2__card--float1">
                        <i class="fas fa-university"></i>
                        <span class="num">1995</span>
                        <span class="lbl">Founded Legacy</span>
                    </div>
                    <div class="about-hero-v2__card about-hero-v2__card--float2">
                        <i class="fas fa-user-graduate"></i>
                        <span class="num">1,10,000+</span>
                        <span class="lbl">Alumni Worldwide</span>
                    </div>
                    <div class="about-hero-v2__card about-hero-v2__card--float3">
                        <i class="fas fa-hospital"></i>
                        <span class="num">750+</span>
                        <span class="lbl">Hospital Beds</span>
                    </div>
                    <div class="about-hero-v2__card about-hero-v2__card--float4">
                        <i class="fas fa-lightbulb"></i>
                        <span class="num">160+</span>
                        <span class="lbl">Patents Filed</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     MAIN FOUNDER STORY & VISION CONTENT
═══════════════════════════════════════════════════════ -->
<section class="py-5 bg-light position-relative">
    <div class="container-xl py-4">
        <div class="row g-5">
            
            <!-- Left: Founder Sticky Profile Card -->
            <div class="col-12 col-lg-4 position-relative">
                <div class="card border-0 shadow rounded-4 overflow-hidden sticky-profile-sidebar">
                    <div class="bg-gradient-maroon text-white p-4 text-center" style="background: linear-gradient(135deg, #7A0B0D 0%, #0F1E3B 100%);">
                        <div class="mx-auto mb-3 bg-white p-1 rounded-4 shadow" style="width: 100%; max-width: 220px; height: 250px; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                            <img src="<?php echo $chairmanPhotoSrc; ?>"
                                 onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';"
                                 alt="<?php echo sanitize($chairmanName); ?>, Founder &amp; Chairman"
                                 class="w-100 h-100 rounded-3 shadow-sm"
                                 style="object-fit: cover; object-position: top center;">
                        </div>
                        <h4 class="fw-bold mb-1 text-white"><?php echo sanitize($chairmanName); ?></h4>
                        <p class="text-warning small mb-1 fw-semibold"><?php echo sanitize($chairmanTitle); ?></p>
                        <small class="text-white-50 d-block">Sarvepalli Radhakrishnan University &amp; RKDF Group</small>
                    </div>

                    <div class="card-body p-4 bg-white">
                        <!-- Academic Qualifications -->
                        <h6 class="fw-bold text-navy mb-3 text-uppercase small" style="letter-spacing: 0.5px;">
                            <i class="fas fa-user-graduate text-danger me-1"></i> Academic &amp; Professional Qualifications
                        </h6>
                        <ul class="list-unstyled mb-4 small text-secondary d-flex flex-column gap-2 border-bottom pb-3">
                            <li class="d-flex align-items-start gap-2">
                                <i class="fas fa-check-circle text-success mt-1"></i>
                                <span><strong>M.B.B.S.</strong> — Bachelor of Medicine &amp; Surgery</span>
                            </li>
                            <li class="d-flex align-items-start gap-2">
                                <i class="fas fa-check-circle text-success mt-1"></i>
                                <span><strong>DCH</strong> — Diploma in Child Health</span>
                            </li>
                            <li class="d-flex align-items-start gap-2">
                                <i class="fas fa-check-circle text-success mt-1"></i>
                                <span><strong>MIAP &amp; PCMS</strong> — Member of Indian Academy of Pediatrics</span>
                            </li>
                            <li class="d-flex align-items-start gap-2">
                                <i class="fas fa-check-circle text-success mt-1"></i>
                                <span><strong>PGDBM (Finance)</strong> — Postgraduate in Business Management</span>
                            </li>
                            <li class="d-flex align-items-start gap-2">
                                <i class="fas fa-check-circle text-success mt-1"></i>
                                <span><strong>Ph.D. in Financial Management</strong> (United Kingdom)</span>
                            </li>
                        </ul>

                        <!-- Institutional & Public Leadership Roles -->
                        <h6 class="fw-bold text-navy mb-3 text-uppercase small" style="letter-spacing: 0.5px;">
                            <i class="fas fa-landmark text-primary me-1"></i> Notable Institutional Engagements
                        </h6>
                        <ul class="list-unstyled mb-4 small text-secondary d-flex flex-column gap-2 border-bottom pb-3">
                            <li class="d-flex align-items-start gap-2">
                                <i class="fas fa-briefcase text-primary mt-1"></i>
                                <span>Founder &amp; Chief Patron, RKDF Education Society (Est. 1995)</span>
                            </li>
                            <li class="d-flex align-items-start gap-2">
                                <i class="fas fa-microchip text-primary mt-1"></i>
                                <span>Leadership associations with <strong>MPSEDC</strong> (MP State Electronics Development Corp.)</span>
                            </li>
                            <li class="d-flex align-items-start gap-2">
                                <i class="fas fa-satellite-dish text-primary mt-1"></i>
                                <span>Advisory &amp; strategic role with <strong>Optel Telecommunications</strong></span>
                            </li>
                            <li class="d-flex align-items-start gap-2">
                                <i class="fas fa-globe text-primary mt-1"></i>
                                <span>Indo-Japanese collaboration between <strong>Fujitsu Japan</strong> &amp; Govt. of Madhya Pradesh</span>
                            </li>
                        </ul>

                        <!-- Quick Navigation Links -->
                        <h6 class="fw-bold text-navy mb-3 text-uppercase small" style="letter-spacing: 0.5px;">
                            <i class="fas fa-link text-warning me-1"></i> University Governance
                        </h6>
                        <div class="d-flex flex-column gap-2">
                            <a href="<?php echo BASE_URL; ?>chancellor-message.php" class="btn btn-sm btn-outline-danger w-100 rounded-pill py-2 fw-semibold d-flex align-items-center justify-content-center gap-2">
                                <i class="fas fa-crown text-warning"></i>
                                <span>Chancellor's Desk</span>
                            </a>
                            <a href="<?php echo BASE_URL; ?>vice-chancellor-message.php" class="btn btn-sm btn-outline-navy w-100 rounded-pill py-2 fw-semibold d-flex align-items-center justify-content-center gap-2">
                                <i class="fas fa-comment-dots text-primary"></i>
                                <span>Vice Chancellor's Message</span>
                            </a>
                            <a href="<?php echo BASE_URL; ?>board-of-management.php" class="btn btn-sm btn-outline-secondary w-100 rounded-pill py-2 fw-semibold d-flex align-items-center justify-content-center gap-2">
                                <i class="fas fa-landmark text-secondary"></i>
                                <span>Board of Management</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Founder Story & Narrative -->
            <div class="col-12 col-lg-8">
                <div class="bg-white p-4 p-md-5 rounded-4 shadow-sm">
                    
                    <span class="badge bg-gold-soft text-navy fw-bold px-3 py-1 rounded-pill mb-2">
                        <i class="fas fa-feather-alt text-warning me-1"></i> THE FOUNDER'S JOURNEY
                    </span>
                    <h2 class="h3 fw-bold text-navy mb-3">
                        A Visionary in Education, Healthcare &amp; Institutional Excellence
                    </h2>
                    
                    <!-- Quote Callout -->
                    <div class="p-4 rounded-4 mb-4" style="background: linear-gradient(135deg, #fff9f0 0%, #fff 100%); border-left: 5px solid #d97706; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
                        <i class="fas fa-quote-left text-warning fs-3 mb-2 d-block"></i>
                        <p class="lead fst-italic text-dark mb-0" style="line-height:1.75; font-size:1.05rem;">
                            &ldquo;Modern education demands much more than mere classroom learning. A student today requires knowledge, practical skills, communication fluency, technological agility, and an uncompromising ethical foundation. When institutions are built with empathy and vision, they do not just educate individuals—they transform entire generations.&rdquo;
                        </p>
                        <div class="text-end mt-2">
                            <span class="fw-bold text-navy">— <?php echo sanitize($chairmanName); ?></span>
                        </div>
                    </div>

                    <!-- Story Pillar 1 -->
                    <div class="mb-4">
                        <h4 class="h5 fw-bold text-navy d-flex align-items-center gap-2 mb-2">
                            <span class="rounded-circle bg-navy text-white d-inline-flex align-items-center justify-content-center" style="width:32px; height:32px; font-size:0.9rem;">1</span>
                            Pioneering Institution Building Since 1995
                        </h4>
                        <p class="text-secondary" style="line-height:1.85; font-size:0.95rem;">
                            In Madhya Pradesh and across Central India, <strong><?php echo sanitize($chairmanName); ?></strong> is a name synonymous with visionary education, public health, leadership, and youth development. In 1995, RKDF Education Society was established with a singular mission: to democratize high-caliber technical, medical, and professional education so that young aspirants from every walk of life could access world-class training right in their home state.
                        </p>
                        <p class="text-secondary" style="line-height:1.85; font-size:0.95rem;">
                            Under his stewardship, what began as pioneer professional institutes evolved into <strong>Sarvepalli Radhakrishnan University (SRKU)</strong>—a sprawling multidisciplinary educational powerhouse comprising 14 constituent colleges, over 120 undergraduate, postgraduate, and doctoral degree programs, and an expansive 100+ acre state-of-the-art campus in Bhopal.
                        </p>
                    </div>

                    <!-- Story Pillar 2 -->
                    <div class="mb-4">
                        <h4 class="h5 fw-bold text-navy d-flex align-items-center gap-2 mb-2">
                            <span class="rounded-circle bg-maroon text-white d-inline-flex align-items-center justify-content-center" style="width:32px; height:32px; font-size:0.9rem; background:#7A0B0D;">2</span>
                            Multidisciplinary Expertise: Medicine, Management &amp; Global Finance
                        </h4>
                        <p class="text-secondary" style="line-height:1.85; font-size:0.95rem;">
                            What sets Dr. Sunil Kapoor's leadership apart is a rare and formidable combination of academic mastery across diverse domains. Holding medical degrees including <strong>M.B.B.S.</strong> and <strong>DCH</strong>, alongside fellowship credentials in pediatrics (MIAP, PCMS), he brings an innate humanitarian perspective to institutional planning.
                        </p>
                        <p class="text-secondary" style="line-height:1.85; font-size:0.95rem;">
                            Simultaneously, his advanced postgraduate studies in business management (<strong>PGDBM in Finance</strong>) and a <strong>Doctorate (Ph.D.) in Financial Management from the United Kingdom</strong> have endowed him with deep executive acumen, strategic governance skills, and global financial expertise. This multifaceted background enables him to navigate the complex intersections of academic excellence, healthcare administration, and cutting-edge technology.
                        </p>
                    </div>

                    <!-- Story Pillar 3 -->
                    <div class="mb-4">
                        <h4 class="h5 fw-bold text-navy d-flex align-items-center gap-2 mb-2">
                            <span class="rounded-circle bg-warning text-dark d-inline-flex align-items-center justify-content-center" style="width:32px; height:32px; font-size:0.9rem;">3</span>
                            Public Leadership, Governance &amp; Technology Collaborations
                        </h4>
                        <p class="text-secondary" style="line-height:1.85; font-size:0.95rem;">
                            Beyond the academic sphere, Dr. Sunil Kapoor has played instrumental roles in public development, technology modernization, and state advisory initiatives. His public record highlights strategic responsibilities with key statutory agencies and industrial leaders, including:
                        </p>
                        <div class="row g-3 my-2">
                            <div class="col-md-6">
                                <div class="p-3 border rounded-3 bg-light h-100">
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <i class="fas fa-microchip text-primary"></i>
                                        <strong class="text-navy small">MPSEDC Initiatives</strong>
                                    </div>
                                    <p class="text-muted small mb-0">Advising on state electronics development, digital governance frameworks, and technology-driven infrastructure.</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 border rounded-3 bg-light h-100">
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <i class="fas fa-globe-asia text-danger"></i>
                                        <strong class="text-navy small">Indo-Japanese Fujitsu Partnership</strong>
                                    </div>
                                    <p class="text-muted small mb-0">Fostering high-level technological collaboration between Fujitsu Japan and the Government of Madhya Pradesh.</p>
                                </div>
                            </div>
                        </div>
                        <p class="text-secondary" style="line-height:1.85; font-size:0.95rem;">
                            His contributions with organizations like <strong>Optel Telecommunications</strong> reflect an enduring commitment to industrial innovation, telecommunications development, and public-private synergy.
                        </p>
                    </div>

                    <!-- Story Pillar 4 -->
                    <div class="mb-4">
                        <h4 class="h5 fw-bold text-navy d-flex align-items-center gap-2 mb-2">
                            <span class="rounded-circle bg-success text-white d-inline-flex align-items-center justify-content-center" style="width:32px; height:32px; font-size:0.9rem;">4</span>
                            Healthcare Excellence &amp; Community-First Medical Innovation
                        </h4>
                        <p class="text-secondary" style="line-height:1.85; font-size:0.95rem;">
                            Healthcare has always been a central pillar of Dr. Sunil Kapoor's institutional philosophy. Under his guidance, SRK University has developed an integrated healthcare ecosystem encompassing:
                        </p>
                        <ul class="text-secondary small mb-3 d-flex flex-column gap-2" style="line-height:1.7;">
                            <li><i class="fas fa-hospital text-danger me-2"></i><strong>750+ Bed Multispecialty Hospital:</strong> Delivering accessible, subsidized, and top-tier clinical care to underprivileged urban and rural populations.</li>
                            <li><i class="fas fa-user-md text-primary me-2"></i><strong>Full Spectrum Medical Education:</strong> Constituent institutions in MBBS (Allopathy), Dental Surgery (BDS &amp; MDS), Pharmacy (B.Pharm, M.Pharm, Pharm.D), Homeopathy, Ayurveda, and Allied Health Sciences.</li>
                            <li><i class="fas fa-laptop-medical text-success me-2"></i><strong>Digital Health &amp; Patient-Centric Innovation:</strong> Harnessing tele-medicine, modernized operation theaters, advanced pathology, and digital medical diagnostics to elevate patient outcomes.</li>
                        </ul>
                        <p class="text-secondary" style="line-height:1.85; font-size:0.95rem;">
                            He firmly believes that the future of healthcare depends on seamless collaboration among clinical practitioners, researchers, biomedical engineers, and visionary administrators.
                        </p>
                    </div>

                    <!-- Story Pillar 5 -->
                    <div class="mb-4">
                        <h4 class="h5 fw-bold text-navy d-flex align-items-center gap-2 mb-2">
                            <span class="rounded-circle bg-info text-white d-inline-flex align-items-center justify-content-center" style="width:32px; height:32px; font-size:0.9rem;">5</span>
                            Empowering the Next Generation: Research, Incubation &amp; NEP 2020
                        </h4>
                        <p class="text-secondary" style="line-height:1.85; font-size:0.95rem;">
                            Recognizing that industries are undergoing seismic shifts driven by Artificial Intelligence, robotics, and global green transitions, Dr. Sunil Kapoor has steered SRKU toward a research-intensive, skill-first paradigm. With over <strong>160 filed patents</strong>, an active on-campus <strong>Incubation Centre</strong>, and 42+ corporate partnerships, SRKU students are nurtured as creators and problem-solvers rather than passive consumers of information.
                        </p>
                    </div>

                    <!-- Visual Summary Highlights -->
                    <div class="row g-3 py-3 my-2 border-top border-bottom">
                        <div class="col-6 col-md-3 text-center">
                            <div class="h3 fw-bold text-maroon mb-0" style="color:#7A0B0D;">31+</div>
                            <span class="text-muted small">Years of Educational Impact</span>
                        </div>
                        <div class="col-6 col-md-3 text-center">
                            <div class="h3 fw-bold text-navy mb-0">14</div>
                            <span class="text-muted small">Constituent Colleges</span>
                        </div>
                        <div class="col-6 col-md-3 text-center">
                            <div class="h3 fw-bold text-danger mb-0">1,10,000+</div>
                            <span class="text-muted small">Global Alumni Network</span>
                        </div>
                        <div class="col-6 col-md-3 text-center">
                            <div class="h3 fw-bold text-success mb-0">160+</div>
                            <span class="text-muted small">Research Patents</span>
                        </div>
                    </div>

                    <!-- Closing & Salutation -->
                    <div class="pt-4">
                        <h5 class="fw-bold text-navy mb-2">A Message to Every Aspiring Mind:</h5>
                        <p class="text-secondary mb-4" style="line-height:1.85; font-size:0.95rem;">
                            &ldquo;To every student joining our university family: remember that challenges are the stepping stones to true innovation. Dare to dream boldly, pursue knowledge with unrelenting curiosity, and above all, dedicate your skills to the upliftment of humanity. At Sarvepalli Radhakrishnan University, we are honored to stand with you at every step of your journey.&rdquo;
                        </p>

                        <div class="d-flex align-items-center gap-3 pt-2">
                            <div class="rounded-circle overflow-hidden border shadow-sm" style="width:60px; height:60px; flex-shrink:0;">
                                <img src="<?php echo $chairmanPhotoSrc; ?>" alt="<?php echo sanitize($chairmanName); ?>" style="width:100%; height:100%; object-fit:cover; object-position:top;">
                            </div>
                            <div>
                                <h6 class="fw-bold text-navy mb-0"><?php echo sanitize($chairmanName); ?></h6>
                                <span class="text-danger small fw-semibold"><?php echo sanitize($chairmanTitle); ?></span><br>
                                <small class="text-muted">Sarvepalli Radhakrishnan University (SRKU), Bhopal</small>
                            </div>
                        </div>
                    </div>

                    <!-- Action Banner -->
                    <div class="mt-5 p-4 rounded-4 bg-navy text-white text-center text-md-start d-md-flex align-items-center justify-content-between gap-4" style="background: linear-gradient(135deg, #0F1E3B 0%, #1e3a8a 100%);">
                        <div>
                            <h5 class="fw-bold text-white mb-1">Begin Your Academic Journey at SRKU</h5>
                            <p class="text-white-50 small mb-0">Explore undergraduate, postgraduate, and doctoral admissions for 2026-27.</p>
                        </div>
                        <div class="mt-3 mt-md-0 flex-shrink-0">
                            <a href="<?php echo BASE_URL; ?>admission-enquiry.php" class="btn btn-warning fw-bold px-4 py-2 rounded-pill shadow-sm">
                                <i class="fas fa-paper-plane me-1"></i> Apply for Admission
                            </a>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
