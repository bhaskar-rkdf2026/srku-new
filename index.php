<?php
$pageTitle = "Sarvepalli Radhakrishnan University (SRKU) Bhopal | Admissions 2026-27 | UGC Approved Private University in MP";
$pageDesc = "Sarvepalli Radhakrishnan University (SRKU), Bhopal is a premier UGC-recognized multidisciplinary private university in Madhya Pradesh offering 120+ UG, PG, and Ph.D. programmes in Medical, Engineering, Pharmacy, Nursing, Law, Agriculture & Management.";
$pageKeywords = "Sarvepalli Radhakrishnan University, SRKU Bhopal, SRK University, Admissions 2026-27, Best Private University in MP, UGC Approved University Bhopal, MBBS Admission Bhopal, BTech College Bhopal, Pharmacy College MP, RKDF Group";
$activeNav = "home";
require_once __DIR__ . '/includes/header.php';

$pdo = getDBConnection();
$tickerText = getSetting('ticker_text', 'Admissions Open 2026-27 | UGC Recognized Premier University in MP | Apply Now for Engineering, Pharmacy, Nursing, Management & Medicine | 94% Placement Record');
$totalLabs = getSetting('total_labs', '42+');
$placementRecord = getSetting('placement_record', '94%');
$highestPackage = getSetting('highest_package', '12 LPA');
$recruitingPartners = getSetting('recruiting_partners', '120+');
$totalAlumni = getSetting('total_alumni', '15,000+');
$heroTitle = getSetting('hero_title', 'SRK University, Bhopal');
$heroSubtitle = getSetting('hero_subtitle', 'UGC-Recognized University in MP');
$heroDesc = getSetting('hero_desc', 'Welcome to SRK University, a premier technical and academic ecosystem designed for global industry leadership. If you are looking for the best placement university in MP, our rigorous research, multi-disciplinary collaboration, and industry-aligned pedagogy deliver unmatched career growth.');
$heroVideo = getSetting('hero_video_url', 'assets/images/concept2-hero.mp4');
$heroFallbackImg = getSetting('hero_fallback_image', 'assets/uploads/2026/08/srku-rkdf-building.jpeg');
$heroVideoSrc = resolveMediaUrl($heroVideo, 'assets/images/concept2-hero.mp4');
$heroFallbackPoster = resolveMediaUrl($heroFallbackImg, 'assets/uploads/2026/08/srku-rkdf-building.jpeg');

$welcomeSubtitle = getSetting('welcome_subtitle', 'WELCOME TO SRK UNIVERSITY');
$welcomeTitle = getSetting('welcome_title', 'Committed Towards Your Better Future Through Academic Excellence');
$welcomeBody1 = getSetting('welcome_body_1', 'The SRK University is a multidisciplinary university known for its high standards in teaching and research, and attracts eminent scholars to its faculty across the academic spectrum.');
$welcomeBody2 = getSetting('welcome_body_2', 'The group was established in 1995 under the flagship of the RKDF Group. Ever since its inception, a strong commitment to excellence in teaching and research has made the group a role-model and path-setter for other institutions. Its rich academic tradition has always attracted the most talented students, who later go on to make important contributions to society.');
$welcomePhoto = getSetting('welcome_photo', 'assets/uploads/2026/08/welcome-srku-campus.jpeg');
$welcomePhotoSrc = resolveMediaUrl($welcomePhoto, 'assets/uploads/2026/08/welcome-srku-campus.jpeg');

$chancellorName = getSetting('chancellor_name', 'Mrs. Janak Kapoor');
$chancellorTitle = getSetting('chancellor_title', 'Chancellor');
$chancellorPhoto = getSetting('chancellor_photo', 'assets/uploads/2026/08/chancellor.jpeg');
$chancellorPhotoSrc = resolveMediaUrl($chancellorPhoto, 'assets/uploads/2026/08/chancellor.jpeg');
$chancellorHeading = getSetting('chancellor_heading', 'A Legacy of Excellence, A Vision for Tomorrow');
$chancellorMsg = getSetting('chancellor_msg', 'It is a matter of great joy that the notification for the establishment of Sarvepalli Radhakrishnan University, Bhopal, has been issued by the State Government.');
$chancellorMsg2 = getSetting('chancellor_msg2', "In order to maintain quality in the field of higher education in the state, it is an important responsibility of private universities, alongside government universities, to bring about change in research and exploration. It is hoped that Sarvepalli Radhakrishnan University will, in the future, deliver unprecedented performance on quality standards and establish itself as the state's foremost institution of education.");

$vcName = getSetting('vc_name', 'Ms. Priyanka Jaiswal');
$vcTitle = getSetting('vc_title', 'Vice Chancellor');
$vcPhoto = getSetting('vc_photo', 'assets/uploads/2026/07/ruchichaubey.webp');
$vcPhotoSrc = resolveMediaUrl($vcPhoto, 'assets/uploads/2026/07/ruchichaubey.webp');
$vcHeading = getSetting('vc_heading', 'Pioneering Excellence, Empowering Future Leaders');
$vcMsg = getSetting('vc_msg', 'At SRK University, our mission is to transform ambitious learners into visionary global leaders through outcome-based education and cutting-edge research.');
$vcMsg2 = getSetting('vc_msg2', 'We foster innovation, high-impact research, and multi-disciplinary excellence. Our state-of-the-art infrastructure and faculty mentorship ensure every graduate is prepared for global careers.');

// Handle Form Submission for Enquiry
$enquirySuccess = false;
$enquiryErr = '';
$enquiryMsg = '';
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['submit_enquiry'])) {
    $res = saveEnquiryLead(
        $_POST['name'] ?? '',
        $_POST['email'] ?? '',
        $_POST['phone'] ?? '',
        $_POST['course'] ?? '',
        $_POST['message'] ?? '',
        'Homepage Admission Section',
        $_POST['father_name'] ?? '',
        $_POST['city'] ?? '',
        $_POST['state'] ?? '',
        $_POST['college'] ?? ''
    );
    if ($res['success']) {
        $enquirySuccess = true;
        $enquiryMsg = $res['message'];
    } else {
        $enquiryErr = $res['error'];
    }
}
?>

<!-- ═══════════════════════════════════════════════════════
     HERO SECTION — 100% FULLSCREEN HTML5 VIDEO & FALLBACK POSTER
═══════════════════════════════════════════════════════ -->
<section class="hero-section position-relative" style="background: #0b1120 url('<?php echo $heroFallbackPoster; ?>') center/cover no-repeat;">

    <video class="hero-bg-video" id="heroBgVideo" autoplay muted loop playsinline preload="auto" poster="<?php echo $heroFallbackPoster; ?>">
        <source src="<?php echo $heroVideoSrc; ?>" type="video/mp4">
        <!-- Direct Fallback Image if Video Cannot Play -->
        <img src="<?php echo $heroFallbackPoster; ?>" alt="<?php echo sanitize($heroTitle); ?>" class="hero-bg-video object-fit-cover">
    </video>

    <div class="hero-overlay"></div>

    <script>
    (function() {
        function initHeroVideo() {
            var v = document.getElementById('heroBgVideo');
            if (!v) return;
            v.muted = true;
            v.defaultMuted = true;
            v.playsInline = true;
            var playPromise = v.play();
            if (playPromise !== undefined) {
                playPromise.catch(function(err) {
                    var startPlayback = function() {
                        v.play().catch(function(){});
                        ['click', 'touchstart', 'scroll', 'keydown', 'mousemove'].forEach(function(e) {
                            window.removeEventListener(e, startPlayback);
                        });
                    };
                    ['click', 'touchstart', 'scroll', 'keydown', 'mousemove'].forEach(function(e) {
                        window.addEventListener(e, startPlayback, { passive: true, once: true });
                    });
                });
            }
        }
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initHeroVideo);
        } else {
            initHeroVideo();
        }
    })();
    </script>

    <div class="container-fluid px-4 px-lg-5 position-relative z-3">
        <div class="hero-content px-0">
            <h1 class="hero-h1">
                <?php echo sanitize($heroTitle); ?><br>
                <span class="gold-line"><?php echo sanitize($heroSubtitle); ?></span>
            </h1>
            <p class="hero-desc my-3">
                <?php echo sanitize($heroDesc); ?>
            </p>
            <div class="d-flex flex-wrap gap-3 mt-4">
                <a href="#apply" class="btn-hero-yellow">Apply for Admission <i class="fas fa-arrow-right ms-2"></i></a>
                <a href="<?php echo BASE_URL; ?>courses.php" class="btn-hero-outline">Explore Programmes <i class="fas fa-arrow-right ms-2"></i></a>
            </div>
        </div>
    </div>

    <!-- Hero Floating Stats Stack (Uniform Flex Container) -->
    <div class="hero-stats-floating d-none d-xl-flex">
        <!-- Stat Card 1 — White Glass -->
        <div class="hero-stat-card hero-stat-card-white">
            <div class="icon-box">
                <i class="fas fa-microscope"></i>
            </div>
            <div class="stat-info">
                <h3 class="stat-num mb-0"><?php echo sanitize($totalLabs); ?></h3>
                <p class="stat-lbl mb-0">HIGH-TECH LABS</p>
            </div>
        </div>

        <!-- Stat Card 2 — Brand Red -->
        <div class="hero-stat-card hero-stat-card-red">
            <div class="icon-box">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stat-info">
                <h3 class="stat-num mb-0"><?php echo sanitize($placementRecord); ?></h3>
                <p class="stat-lbl mb-0">PLACEMENT RECORD</p>
            </div>
        </div>
    </div>

    <!-- Live ticker pinned to bottom of hero -->
    <?php $tickerNews = getNews(null, 10); ?>
    <div class="hero-ticker">
        <div class="hero-ticker-label"><i class="fas fa-bolt me-1"></i> LIVE UPDATES</div>
        <div class="hero-ticker-track">
            <span class="hero-ticker-content">
                <?php if (!empty($tickerNews)): ?>
                    <?php foreach ($tickerNews as $tn): ?>
                        <a href="<?php echo BASE_URL; ?>news-detail.php?id=<?php echo (int)$tn['id']; ?>" class="ticker-news-link">
                            <span class="badge bg-danger me-1 small px-2 py-0.5"><?php echo sanitize($tn['category'] ?? 'Notice'); ?></span>
                            <?php echo sanitize($tn['title']); ?>
                        </a>
                        <span class="ticker-separator">&nbsp;&nbsp;&bull;&nbsp;&nbsp;</span>
                    <?php endforeach; ?>
                <?php else: ?>
                    <?php echo sanitize($tickerText); ?> &nbsp;&bull;&nbsp;
                    Highest Package: <?php echo sanitize($highestPackage); ?> &nbsp;&bull;&nbsp;
                    <?php echo sanitize($recruitingPartners); ?> Corporate Recruitment Partners &nbsp;&bull;&nbsp;
                    UGC Recognized &amp; AICTE Approved Premier University in Madhya Pradesh &nbsp;&bull;&nbsp;
                <?php endif; ?>
            </span>
        </div>
    </div>

</section>

<!-- ═══════════════════════════════════════════════════════
     STATS STRIP (Bootstrap Row)
═══════════════════════════════════════════════════════ -->
<div class="stats-strip py-2">
    <div class="container-xl">
        <div class="row row-cols-2 row-cols-md-5 g-0 text-center">
            <div class="col stat-box">
                <div class="stat-val"><?php echo sanitize($totalLabs); ?></div>
                <div class="stat-txt">High-Tech Labs</div>
            </div>
            <div class="col stat-box">
                <div class="stat-val"><?php echo sanitize($placementRecord); ?></div>
                <div class="stat-txt">Placement Record</div>
            </div>
            <div class="col stat-box">
                <div class="stat-val"><?php echo sanitize($recruitingPartners); ?></div>
                <div class="stat-txt">Corporate Recruiters</div>
            </div>
            <div class="col stat-box">
                <div class="stat-val">15,000+</div>
                <div class="stat-txt">Global Alumni</div>
            </div>
            <div class="col stat-box">
                <div class="stat-val">25+</div>
                <div class="stat-txt">Years of Excellence</div>
            </div>
        </div>
    </div>
</div>

<!-- ═══════════════════════════════════════════════════════
     WELCOME SECTION (Bootstrap 2-col Grid)
═══════════════════════════════════════════════════════ -->
<section class="py-5">
    <div class="container-xl py-3">
        <div class="row align-items-center g-4 g-lg-5">
            
            <div class="col-12 col-lg-6">
                <span class="section-subtitle"><?php echo sanitize($welcomeSubtitle); ?></span>
                <h2 class="section-title mb-3"><?php echo $welcomeTitle; ?></h2>
                <p class="text-dark mb-3" style="line-height:1.8; font-size:0.95rem;">
                    <?php echo $welcomeBody1; ?>
                </p>
                <p class="text-muted mb-4" style="line-height:1.8; font-size:0.93rem;">
                    <?php echo $welcomeBody2; ?>
                </p>
                <div class="d-flex gap-3">
                    <a href="<?php echo BASE_URL; ?>about.php" class="btn btn-srku"><i class="fas fa-arrow-right me-1"></i> Read More</a>
                    <a href="<?php echo BASE_URL; ?>why-srk.php" class="btn btn-srku-outline-maroon"><span class="btn-icon-badge"><i class="fas fa-star"></i></span> Why Choose SRKU</a>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="position-relative">
                    <img src="<?php echo $welcomePhotoSrc; ?>"
                         onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/08/welcome-srku-campus.jpeg';"
                         alt="SRKU Main Campus" class="welcome-img">
                    <div class="row g-2 mt-3 text-center">
                        <div class="col-4">
                            <div class="welcome-badge"><strong><?php echo sanitize($totalLabs); ?></strong><small>HIGH-TECH LABS</small></div>
                        </div>
                        <div class="col-4">
                            <div class="welcome-badge"><strong><?php echo sanitize($placementRecord); ?></strong><small>Placement Rate</small></div>
                        </div>
                        <div class="col-4">
                            <div class="welcome-badge"><strong>2026-27</strong><small>Admissions Open</small></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     STATUTORY APPROVALS & CONSTITUENT LOGOS CAROUSEL (After Welcome)
═══════════════════════════════════════════════════════ -->
<section class="py-4 border-top border-bottom bg-light overflow-hidden">
    <div class="container-fluid px-3 px-lg-5 mb-3" style="max-width: 1560px;">
        <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-xl-nowrap overflow-x-auto pb-1" style="scrollbar-width: none; -ms-overflow-style: none;">
            <!-- Stacked Heading -->
            <div class="d-flex flex-column text-nowrap flex-shrink-0">
                <div>
                    <span class="badge bg-danger text-white px-2 py-1 rounded-pill fw-bold" style="font-size: 0.68rem; letter-spacing: 0.5px;"><i class="fas fa-shield-alt me-1"></i> RECOGNITIONS</span>
                </div>
                <span class="fw-bold text-navy small mt-1">Approved &amp; Recognized by:</span>
            </div>

            <!-- All 11 Apex Councils in ONE Single Row -->
            <div class="d-flex align-items-center gap-2 flex-nowrap overflow-x-auto flex-grow-1 justify-content-start justify-content-xl-center" style="scrollbar-width: none; -ms-overflow-style: none;">
                <span class="badge bg-white text-dark border px-2 py-1 fw-bold shadow-xs text-nowrap"><i class="fas fa-check-circle text-success me-1"></i> UGC</span>
                <span class="badge bg-white text-dark border px-2 py-1 fw-bold shadow-xs text-nowrap"><i class="fas fa-check-circle text-success me-1"></i> NMC</span>
                <span class="badge bg-white text-dark border px-2 py-1 fw-bold shadow-xs text-nowrap"><i class="fas fa-check-circle text-success me-1"></i> NCISM</span>
                <span class="badge bg-white text-dark border px-2 py-1 fw-bold shadow-xs text-nowrap"><i class="fas fa-check-circle text-success me-1"></i> NCH</span>
                <span class="badge bg-white text-dark border px-2 py-1 fw-bold shadow-xs text-nowrap"><i class="fas fa-check-circle text-success me-1"></i> NDC</span>
                <span class="badge bg-white text-dark border px-2 py-1 fw-bold shadow-xs text-nowrap"><i class="fas fa-check-circle text-success me-1"></i> PCI</span>
                <span class="badge bg-white text-dark border px-2 py-1 fw-bold shadow-xs text-nowrap"><i class="fas fa-check-circle text-success me-1"></i> INC</span>
                <span class="badge bg-white text-dark border px-2 py-1 fw-bold shadow-xs text-nowrap"><i class="fas fa-check-circle text-success me-1"></i> MPPMC</span>
                <span class="badge bg-white text-dark border px-2 py-1 fw-bold shadow-xs text-nowrap"><i class="fas fa-check-circle text-success me-1"></i> AICTE</span>
                <span class="badge bg-white text-dark border px-2 py-1 fw-bold shadow-xs text-nowrap"><i class="fas fa-check-circle text-success me-1"></i> BCI</span>
                <span class="badge bg-white text-dark border px-2 py-1 fw-bold shadow-xs text-nowrap"><i class="fas fa-check-circle text-success me-1"></i> MPPURC</span>
            </div>

            <!-- Link to details -->
            <a href="<?php echo BASE_URL; ?>accreditation.php" class="small fw-bold text-danger text-nowrap text-decoration-none flex-shrink-0 hover-underline ms-auto">
                View All Accreditations <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>
    </div>

    <!-- Infinite Smooth Scrolling Constituent Institutes Seals Carousel -->
    <div class="constituent-carousel-container pt-3 border-top position-relative">
        <div class="constituent-marquee-track">
            <?php
            $sealsList = [
                ['name' => 'RKDF Medical College & Research Centre', 'img' => 'logo-rkdf-medical.png', 'slug' => 'rkdf-medical-college-hospital-research-center-2014'],
                ['name' => 'SRK College of Ayurveda Hospital', 'img' => 'logo-srk-ayurveda.png', 'slug' => 'sarvepalli-radhakrishnan-college-of-ayurveda-hospital-research-center-2021'],
                ['name' => 'RKDF Homoeopathic Medical College', 'img' => 'logo-rkdf-homoeopathy.png', 'slug' => 'rkdf-homoeopathic-medical-college-hospital-research-center-2000'],
                ['name' => 'RKDF Dental College & Research Centre', 'img' => 'logo-rkdf-dental.png', 'slug' => 'rkdf-dental-college-research-center-2003'],
                ['name' => 'RKDF College of Pharmacy (1995)', 'img' => 'logo-rkdf-pharmacy.png', 'slug' => 'rkdf-college-of-pharmacy-1995'],
                ['name' => 'RKDF College of Nursing (2003)', 'img' => 'logo-rkdf-nursing.png', 'slug' => 'rkdf-college-of-nursing-2003'],
                ['name' => 'SRK College of Allied & Healthcare', 'img' => 'logo-allied-healthcare.png', 'slug' => 'department-of-allied-health-care-sciences'],
                ['name' => 'RKDF Institute of Science & Technology', 'img' => 'logo-rkdf-science-tech.png', 'slug' => 'rkdf-institute-of-science-technology'],
                ['name' => 'Sarvepalli Radhakrishnan College of Law', 'img' => 'logo-srk-law.png', 'slug' => 'sarvepalli-radhakrishnan-college-of-law'],
                ['name' => 'RKDF Institute of Business Management', 'img' => 'logo-rkdf-management.png', 'slug' => 'rkdf-institute-of-business-management'],
                ['name' => 'Faculty of Agriculture, SRKU', 'img' => 'logo-srk-agriculture.png', 'slug' => 'faculty-of-agriculture']
            ];
            // Render 2 sets for seamless infinite loop
            $loopSeals = array_merge($sealsList, $sealsList);
            foreach ($loopSeals as $s):
            ?>
                <a href="<?php echo BASE_URL; ?>departments.php" class="seal-item text-decoration-none" title="<?php echo $s['name']; ?>">
                    <div class="seal-card bg-white p-2 rounded-4 shadow-xs border d-flex align-items-center gap-2">
                        <img src="<?php echo BASE_URL; ?>assets/images/constituent-logos/<?php echo $s['img']; ?>" alt="<?php echo $s['name']; ?>" class="seal-img flex-shrink-0" style="width: 58px; height: 58px; object-fit: contain;">
                        <div class="seal-info pe-2">
                            <span class="d-block fw-bold text-navy text-nowrap" style="font-size: 0.82rem;"><?php echo $s['name']; ?></span>
                            <span class="small text-muted" style="font-size: 0.72rem;">Constituent Institute</span>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>




<!-- ═══════════════════════════════════════════════════════
     EXPLORE PROGRAMMES SECTION (Bootstrap 4-col Grid)
═══════════════════════════════════════════════════════ -->
<section class="py-5 bg-cream">
    <div class="container-xl py-3">

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-4 gap-2">
            <div>
                <span class="section-subtitle">CONSTITUENT UNITS</span>
                <h2 class="section-title mb-0">A Guide to the University's <span>Constituent Units</span></h2>
            </div>
            <a href="<?php echo BASE_URL; ?>departments.php" class="btn-card-apply fs-6">View all Constituent Units <i class="fas fa-arrow-right ms-1"></i></a>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
            <?php
            $topUnits = $pdo->query("SELECT * FROM departments WHERE status = 'active' ORDER BY established_year ASC, id ASC LIMIT 8")->fetchAll();
            if (empty($topUnits)) {
                $topUnits = $pdo->query("SELECT * FROM departments ORDER BY id ASC LIMIT 8")->fetchAll();
            }
            foreach ($topUnits as $u):
                $uImg = !empty($u['image']) ? $u['image'] : (!empty($u['banner_img']) ? $u['banner_img'] : '');
                if (empty($uImg) || !file_exists(__DIR__ . '/' . ltrim(str_replace('\\', '/', $uImg), '/'))) {
                    $cand = 'assets/uploads/constituent-units/' . ($u['slug'] ?? '') . '.webp';
                    if (file_exists(__DIR__ . '/' . $cand)) {
                        $uImg = $cand;
                    } else {
                        $uImg = 'assets/uploads/2026/07/001.webp';
                    }
                }
                $uImgSrc = resolveMediaUrl($uImg, 'assets/uploads/2026/07/001.webp');
                $uDesc = !empty($u['description']) ? strip_tags($u['description']) : 'Premier academic and research constituent unit at SRK University.';
                if (mb_strlen($uDesc) > 95) {
                    $uDesc = mb_substr($uDesc, 0, 92) . '...';
                }
            ?>
                <div class="col">
                    <div class="prog-card d-flex flex-column h-100">
                        <img src="<?php echo $uImgSrc; ?>" class="prog-img" alt="<?php echo sanitize($u['name']); ?>"
                             onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';">
                        <div class="prog-body d-flex flex-column flex-grow-1">
                            <h3 class="prog-title mb-2">
                                <?php echo sanitize($u['name']); ?>
                                <?php if (!empty($u['established_year'])): ?>
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle fw-bold ms-1" style="font-size:0.75rem;"><?php echo sanitize($u['established_year']); ?></span>
                                <?php endif; ?>
                            </h3>
                            <p class="prog-desc text-muted small mb-3"><?php echo sanitize($uDesc); ?></p>
                            <a href="<?php echo BASE_URL; ?>department-detail.php?slug=<?php echo urlencode($u['slug']); ?>" class="btn-card-apply mt-auto">Explore &rarr;</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     PROMINENT INSTITUTES / FACULTIES (Bootstrap Grid)
═══════════════════════════════════════════════════════ -->
<section class="py-5">
    <div class="container-xl py-3">
        <div class="text-center mb-4">
            <span class="section-subtitle">WHY CHOOSE SRKU</span>
            <h2 class="section-title">Foundations of Academic <span>Excellence</span> in Central India</h2>
            <p class="text-muted small mb-0">Discover why we are consistently ranked among the top engineering colleges in MP and premier management hubs.</p>
        </div>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-3">
            <div class="col"><a href="<?php echo BASE_URL; ?>department-detail.php?slug=rkdf-institute-of-science-and-technology" class="text-decoration-none"><div class="faculty-card"><div class="faculty-icon"><i class="fas fa-cogs"></i></div><div class="faculty-info"><h4>Faculty of Engineering</h4></div></div></a></div>
            <div class="col"><a href="<?php echo BASE_URL; ?>department-detail.php?slug=rkdf-medical-college" class="text-decoration-none"><div class="faculty-card"><div class="faculty-icon"><i class="fas fa-stethoscope"></i></div><div class="faculty-info"><h4>Faculty of Medicine</h4></div></div></a></div>
            <div class="col"><a href="<?php echo BASE_URL; ?>department-detail.php?slug=rkdf-institute-of-management" class="text-decoration-none"><div class="faculty-card"><div class="faculty-icon"><i class="fas fa-chart-bar"></i></div><div class="faculty-info"><h4>Business &amp; Management</h4></div></div></a></div>
            <div class="col"><a href="<?php echo BASE_URL; ?>department-detail.php?slug=department-of-paramedical-sciences" class="text-decoration-none"><div class="faculty-card"><div class="faculty-icon"><i class="fas fa-user-md"></i></div><div class="faculty-info"><h4>Paramedical Sciences</h4></div></div></a></div>
            <div class="col"><a href="<?php echo BASE_URL; ?>department-detail.php?slug=sarvepalli-radhakrishnan-college-of-law" class="text-decoration-none"><div class="faculty-card"><div class="faculty-icon"><i class="fas fa-balance-scale"></i></div><div class="faculty-info"><h4>Law &amp; Governance</h4></div></div></a></div>
            <div class="col"><a href="<?php echo BASE_URL; ?>department-detail.php?slug=faculty-of-science" class="text-decoration-none"><div class="faculty-card"><div class="faculty-icon"><i class="fas fa-atom"></i></div><div class="faculty-info"><h4>Allied Science &amp; Humanities</h4></div></div></a></div>
            <div class="col"><a href="<?php echo BASE_URL; ?>department-detail.php?slug=faculty-of-agriculture" class="text-decoration-none"><div class="faculty-card"><div class="faculty-icon"><i class="fas fa-seedling"></i></div><div class="faculty-info"><h4>Faculty of Agriculture</h4></div></div></a></div>
            <div class="col"><a href="<?php echo BASE_URL; ?>department-detail.php?slug=faculty-of-computer-application" class="text-decoration-none"><div class="faculty-card"><div class="faculty-icon"><i class="fas fa-laptop-code"></i></div><div class="faculty-info"><h4>Computer Application</h4></div></div></a></div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     ADMISSION PATHWAYS (UG / PG / PhD / Diploma)
═══════════════════════════════════════════════════════ -->
<section class="py-5 bg-light">
    <div class="container-xl py-3">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-4 gap-2">
            <div>
                <span class="section-subtitle">COURSES &amp; PROGRAMMES</span>
                <h2 class="section-title mb-0">How to Get Admission in <span>SRK University</span>, Bhopal?</h2>
                <p class="text-muted small mb-0">Choose your trajectory from our meticulously designed programmes and find the pathway that fits your goals.</p>
            </div>
            <a href="<?php echo BASE_URL; ?>courses.php" class="btn-card-apply fs-6">View All Programmes <i class="fas fa-arrow-right ms-1"></i></a>
        </div>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4">
            <div class="col">
                <div class="admission-type-card">
                    <div class="admission-type-icon"><i class="fas fa-user-graduate"></i></div>
                    <h3>UG</h3>
                    <p>B.Tech, BCA, BBA, B.Pharm, BA LL.B, MBBS &amp; more foundation degree programmes.</p>
                </div>
            </div>
            <div class="col">
                <div class="admission-type-card">
                    <div class="admission-type-icon"><i class="fas fa-user-tie"></i></div>
                    <h3>PG</h3>
                    <p>M.Tech, MBA, MCA, M.Pharm, LL.M &amp; specialized postgraduate degrees.</p>
                </div>
            </div>
            <div class="col">
                <div class="admission-type-card">
                    <div class="admission-type-icon"><i class="fas fa-microscope"></i></div>
                    <h3>PHD</h3>
                    <p>Doctoral Research across Engineering, Pharmacy, Management &amp; Sciences.</p>
                </div>
            </div>
            <div class="col">
                <div class="admission-type-card">
                    <div class="admission-type-icon"><i class="fas fa-certificate"></i></div>
                    <h3>Diploma &amp; Certificate</h3>
                    <p>Professional Development and short-term certification programmes.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     CHANCELLOR'S MESSAGE SECTION (Luxury Theme Design)
═══════════════════════════════════════════════════════ -->
<section class="chancellor-desk-section py-5 position-relative overflow-hidden">
    <div class="container-xl py-lg-4">
        <div class="row align-items-center g-4 g-lg-5">
            
            <!-- Left: Framed Portrait & Name Plate -->
            <div class="col-12 col-lg-5">
                <div class="chancellor-portrait-wrap position-relative">
                    <div class="chancellor-photo-frame shadow-lg">
                        <img src="<?php echo $chancellorPhotoSrc; ?>"
                             onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/08/chancellor.jpeg';"
                             alt="<?php echo sanitize($chancellorName); ?>, Chancellor of SRK University, Bhopal"
                             class="chancellor-photo img-fluid">
                    </div>
                    
                    <!-- Floating Official Designation Badge -->
                    <div class="chancellor-badge-card shadow-lg">
                        <div class="d-flex align-items-center gap-3">
                            <div class="chancellor-badge-icon">
                                <i class="fas fa-university"></i>
                            </div>
                            <div>
                                <h4 class="chancellor-badge-name mb-0"><?php echo sanitize($chancellorName); ?></h4>
                                <span class="chancellor-badge-role"><?php echo sanitize($chancellorTitle); ?>, SRK University</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Visionary Statement & Accreditations -->
            <div class="col-12 col-lg-7">
                <div class="chancellor-content ps-lg-3">
                    <span class="section-subtitle">
                        <i class="fas fa-quote-left text-danger me-1"></i> CHANCELLOR&rsquo;S DESK
                    </span>
                    <h2 class="section-title mb-3">
                        <?php echo $chancellorHeading; ?>
                    </h2>
                    
                    <div class="chancellor-quote-lead mb-3">
                        <p class="mb-0"><?php echo sanitize($chancellorMsg); ?></p>
                    </div>
                    
                    <p class="text-muted mb-4" style="line-height: 1.85; font-size: 0.96rem;">
                        <?php echo $chancellorMsg2; ?>
                    </p>

                    <!-- Call to Action Buttons -->
                    <div class="d-flex flex-wrap align-items-center gap-3 mb-4">
                        <a href="<?php echo BASE_URL; ?>chancellor-message.php" class="btn btn-danger rounded-pill px-4 py-2 fw-bold d-inline-flex align-items-center gap-2 shadow-sm">
                            <i class="fas fa-crown text-warning"></i> Read Full Chancellor's Message &rarr;
                        </a>
                        <a href="<?php echo BASE_URL; ?>vice-chancellor-message.php" class="btn btn-outline-dark rounded-pill px-3 py-2 fw-semibold d-inline-flex align-items-center gap-2">
                            <i class="fas fa-user-tie text-danger"></i> VC's Message
                        </a>
                    </div>

                    <!-- Trust & Accreditations Pill Row -->
                    <div class="d-flex flex-wrap gap-3 pt-3 border-top">
                        <div class="chancellor-accred-box">
                            <div class="accred-logo"><i class="fas fa-check-circle text-danger"></i> UGC</div>
                            <span class="accred-sub">Recognized</span>
                        </div>
                        <div class="chancellor-accred-box">
                            <div class="accred-logo"><i class="fas fa-award text-warning"></i> NAAC</div>
                            <span class="accred-sub">A+ Grade</span>
                        </div>
                        <div class="chancellor-accred-box">
                            <div class="accred-logo"><i class="fas fa-shield-alt text-success"></i> AICTE</div>
                            <span class="accred-sub">Approved</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     CAMPUS FACILITIES (Bootstrap 3-col Grid)
═══════════════════════════════════════════════════════ -->
<section class="py-5 bg-light">
    <div class="container-xl py-3">
        <div class="text-center mb-4">
            <span class="section-subtitle">CAMPUS LIFE &amp; INFRASTRUCTURE</span>
            <h2 class="section-title">World-Class Campus <span>Facilities</span></h2>
            <p class="text-muted small">Equipped with state-of-the-art infrastructure for learning, living, and innovating.</p>
        </div>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <div class="col">
                <div class="prog-card">
                    <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/library.webp" class="prog-img" alt="Library"
                         onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';">
                    <div class="prog-body"><h3 class="prog-title">Central Digital Library</h3><p class="prog-desc mb-0">50,000+ books, international journals, e-books, and 24/7 digital resource access.</p></div>
                </div>
            </div>
            <div class="col">
                <div class="prog-card">
                    <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/lab-and-research.webp" class="prog-img" alt="Labs"
                         onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';">
                    <div class="prog-body"><h3 class="prog-title">42+ Advanced Research Labs</h3><p class="prog-desc mb-0">High-performance computing, Robotics, Pharmaceutics testing, and AI innovation units.</p></div>
                </div>
            </div>
            <div class="col">
                <div class="prog-card">
                    <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/Operation-Theatre.webp" class="prog-img" alt="Lecture Halls"
                         onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';">
                    <div class="prog-body"><h3 class="prog-title">Air-Conditioned Auditoriums</h3><p class="prog-desc mb-0">Smart audio-visual lecture halls hosting national seminars, workshops, and guest lectures.</p></div>
                </div>
            </div>
            <div class="col">
                <div class="prog-card">
                    <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/sports.webp" class="prog-img" alt="Sports"
                         onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';">
                    <div class="prog-body"><h3 class="prog-title">Sports Complex &amp; Gymnasium</h3><p class="prog-desc mb-0">Cricket ground, basketball courts, indoor badminton arenas, and modern fitness gym.</p></div>
                </div>
            </div>
            <div class="col">
                <div class="prog-card">
                    <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/hostel.webp" class="prog-img" alt="Hostel"
                         onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';">
                    <div class="prog-body"><h3 class="prog-title">Hostels &amp; Hygienic Dining</h3><p class="prog-desc mb-0">Secured hostels for boys &amp; girls with Wi-Fi, 24/7 security, and nutritious dining.</p></div>
                </div>
            </div>
            <div class="col">
                <div class="prog-card">
                    <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/INFRA-STRUCTURE-SRKU-05.webp" class="prog-img" alt="Healthcare"
                         onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';">
                    <div class="prog-body"><h3 class="prog-title">Medical &amp; Healthcare Center</h3><p class="prog-desc mb-0">On-campus 750+ bed hospital providing round-the-clock emergency care, pharmacy, and check-ups.</p></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     LABS DRIVING INDUSTRY INNOVATION
═══════════════════════════════════════════════════════ -->
<section class="py-5 bg-light">
    <div class="container-xl py-3">
        <div class="row align-items-center g-4 g-lg-5">
            <div class="col-12 col-lg-6 order-lg-2">
                <span class="section-subtitle">INNOVATION &amp; RESEARCH</span>
                <h2 class="section-title mb-3">Labs <span style="font-style:italic;">Driving</span> Industry Innovation.</h2>
                <div class="row row-cols-3 g-3 mb-4">
                    <div class="col"><div class="labs-stat-box"><span class="num">42+</span><span class="lbl">Active Clubs</span></div></div>
                    <div class="col"><div class="labs-stat-box"><span class="num">120+</span><span class="lbl">Patents Filed</span></div></div>
                    <div class="col"><div class="labs-stat-box"><span class="num">&#8377;12Cr</span><span class="lbl">Annual Grants</span></div></div>
                </div>
                <p class="text-dark mb-4" style="line-height:1.8; font-size:0.94rem;">
                    From AI/ML and IoT to biomedical instrumentation, our research labs are supported by industry partnerships and produce industry-ready innovations&mdash;not just research papers.
                </p>
                <a href="<?php echo BASE_URL; ?>research-innovation.php" class="btn btn-srku"><i class="fas fa-flask me-1"></i> Research &amp; Innovation</a>
            </div>
            <div class="col-12 col-lg-6 order-lg-1">
                <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/lab-and-research.webp"
                     onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';"
                     alt="Labs Driving Industry Innovation" class="img-fluid rounded-4 shadow">
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     PLACEMENT & TOP RECRUITERS
═══════════════════════════════════════════════════════ -->
<section class="placement-v2">
    <div class="container-xl py-3">
        <div class="text-center mb-5">
            <span class="section-subtitle">DISCOVER SUCCESS</span>
            <h2 class="section-title mb-0">A direct pipeline to <span>industry leadership</span></h2>
        </div>
        <div class="row align-items-center g-4 g-lg-5">
            <div class="col-12 col-lg-6">
                <p class="text-dark mb-4" style="line-height:1.8; font-size:0.94rem;">
                    Our dedicated Corporate Relations Cell conducts year-round campus recruitment drives, soft skills training, mock interviews, and industry internships, connecting students to 500+ top national and global MNCs.
                </p>
                <div class="row row-cols-3 g-2 mb-4">
                    <div class="col"><div class="labs-stat-box labs-stat-box--sm"><span class="num">&#8377;42 LPA</span><span class="lbl">Highest Package</span></div></div>
                    <div class="col"><div class="labs-stat-box labs-stat-box--sm"><span class="num">500+</span><span class="lbl">Corporate Partners</span></div></div>
                    <div class="col"><div class="labs-stat-box labs-stat-box--sm"><span class="num">15,000+</span><span class="lbl">Alumni Leaders</span></div></div>
                </div>
                <div class="d-flex flex-wrap gap-3">
                    <a href="<?php echo BASE_URL; ?>placements.php" class="btn btn-srku"><i class="fas fa-chart-line me-1"></i> View Full Placement Report</a>
                    <a href="<?php echo BASE_URL; ?>placements.php" class="btn btn-srku-outline-maroon"><span class="btn-icon-badge"><i class="fas fa-users"></i></span> Explore Recruiters</a>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="placement-v2__media placement-v2__media--compact">
                    <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/placement-hero-DCAhDTqD.jpg"
                         onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/graduates.webp';"
                         alt="Campus Placement">
                    <div class="placement-v2__badge">
                        <span class="placement-v2__badge-num">94%</span>
                        <span class="placement-v2__badge-lbl">Placement Record</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Our Recruiting Partners — infinite auto-scrolling logo marquee -->
    <?php
    $recruiterLogos = [
        ['file' => '1.webp', 'alt' => 'TATA'],
        ['file' => '2.webp', 'alt' => 'Infosys'],
        ['file' => '6.webp', 'alt' => 'Amazon'],
        ['file' => '4.webp', 'alt' => 'Wipro'],
        ['file' => '3.webp', 'alt' => 'Cognizant'],
        ['file' => '2.webp', 'alt' => 'Infosys'],
    ];
    ?>
    <div class="recruiter-marquee">
        <p class="recruiter-marquee__label">Our Recruiting Partners</p>
        <div class="recruiter-marquee__viewport">
            <div class="recruiter-marquee__track">
                <?php for ($r = 0; $r < 4; $r++): ?>
                    <?php foreach ($recruiterLogos as $logo): ?>
                        <div class="recruiter-marquee__item">
                            <img src="<?php echo BASE_URL . 'assets/uploads/2026/07/' . rawurlencode($logo['file']); ?>"
                                 alt="<?php echo sanitize($logo['alt']); ?>" loading="eager" decoding="async">
                        </div>
                    <?php endforeach; ?>
                <?php endfor; ?>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     STUDENT LIFE AT SRK (matches live srku.edu.in design)
═══════════════════════════════════════════════════════ -->
<section class="student-life-v2">
    <div class="student-life-v2__inner">
        <p class="student-life-v2__eyebrow">Student Life at SRK</p>
        <h2 class="student-life-v2__title">Experience <em>an Unmatched University</em><br>Campus Life in Bhopal</h2>
        <p class="student-life-v2__desc">A campus that thinks, builds, and celebrates together.<br>200 lush acres, 120+ active student clubs, and 18 annual fests create an unforgettable student journey.</p>

        <div class="student-life-v2__row">
            <div class="student-life-v2__media">
                <img src="<?php echo BASE_URL; ?>assets/uploads/2026/07/alumni-hero-TzGn9_DY-3.jpg"
                     onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';"
                     alt="Annual Cultural Fest at SRK University">
                <div class="student-life-v2__badge">
                    <span class="student-life-v2__badge-tag">Featured</span>
                    <span class="student-life-v2__badge-title">Annual Cultural Fest</span>
                </div>
            </div>
            <div class="student-life-v2__grid">
                <div class="student-life-v2__box student-life-v2__box--maroon">
                    <i class="fas fa-star"></i>
                    <h3>42+</h3>
                    <p>Active Clubs</p>
                </div>
                <div class="student-life-v2__box student-life-v2__box--gray">
                    <i class="fas fa-trophy"></i>
                    <h3>120+</h3>
                    <p>Sports</p>
                </div>
                <div class="student-life-v2__box student-life-v2__box--cream">
                    <i class="fas fa-bed"></i>
                    <h3>4,500+</h3>
                    <p>Hostel Beds</p>
                </div>
                <div class="student-life-v2__box student-life-v2__box--maroon">
                    <i class="fas fa-music"></i>
                    <h3>18</h3>
                    <p>Annual Fests</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     GALLERY SECTION (Bootstrap 5-col Grid) — DB Connected
═══════════════════════════════════════════════════════ -->
<?php $homeGridGallery = getGalleryImages('Campus', 10); ?>
<section class="py-5 bg-cream">
    <div class="container-xl py-2">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <span class="section-subtitle">CAMPUS LIFE</span>
                <h2 class="section-title mb-0">Life at <span>SRK University</span></h2>
            </div>
            <a href="<?php echo BASE_URL; ?>gallery.php" class="btn-card-apply">View Full Gallery &rarr;</a>
        </div>
        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-5 g-2">
            <?php foreach (array_slice($homeGridGallery, 0, 10) as $i => $gimg): ?>
            <div class="col">
                <img src="<?php echo resolveMediaUrl($gimg['image_url'] ?? $gimg['image_path'] ?? '', 'assets/uploads/2026/07/001.webp'); ?>" 
                     class="gallery-img" 
                     alt="SRK University Campus <?php echo $i + 1; ?>"
                     loading="lazy"
                     onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';">
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     INCUBATION & STARTUPS + LATEST NEWS
═══════════════════════════════════════════════════════ -->
<?php $incubationNews = getNews(null, 3); ?>
<section class="py-5 bg-cream">
    <div class="container-xl py-3">
        <div class="row g-4 align-items-stretch">
            <div class="col-12 col-lg-6">
                <div class="incubation-panel h-100">
                    <span class="incubation-panel__eyebrow">Incubation &amp; Startups</span>
                    <h2 class="incubation-panel__title">Build Your Venture On Campus.</h2>
                    <p class="incubation-panel__desc">The university has established an incubation center for promoting new ideas and startups in the region. The center will incubate business ideas with relevance and fitment to local expertise, uniqueness, and market demands. Initially, the center will provide training and support for startups related to handmade soaps &amp; sanitizers and mobile apps.</p>
                    <a href="<?php echo BASE_URL; ?>incubation-center.php" class="incubation-panel__btn">View More &rarr;</a>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="latest-news-panel h-100">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="latest-news-panel__eyebrow mb-0">Latest News &amp; Circulars</span>
                        <a href="<?php echo BASE_URL; ?>news.php" class="small text-danger fw-bold text-decoration-none">View All Notices &rarr;</a>
                    </div>
                    <?php if (!empty($incubationNews)): ?>
                        <?php foreach ($incubationNews as $n): ?>
                            <div class="latest-news-item">
                                <img src="<?php echo !empty($n['image_url']) ? BASE_URL . sanitize($n['image_url']) : BASE_URL . 'assets/uploads/2026/07/001.webp'; ?>"
                                     onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';"
                                     alt="<?php echo sanitize($n['title']); ?>">
                                <div class="latest-news-item__body">
                                    <h4><?php echo sanitize($n['title']); ?></h4>
                                    <span class="latest-news-item__date"><?php echo date('F j, Y', strtotime($n['publish_date'] ?: $n['created_at'])); ?></span>
                                    <a href="<?php echo BASE_URL; ?>news-detail.php?id=<?php echo $n['id']; ?>">Read Circular &raquo;</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-muted small mb-0">No circulars published yet.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     ADMISSION FORM SECTION (Redesigned with Dependent College & Course Dropdowns)
═══════════════════════════════════════════════════════ -->
<?php
$rawColleges = getDepartments(true);
$homeCourses = getCourses();

// Build map of college slug -> courses for instant JS filtering
$deptCoursesMap = [];
foreach ($rawColleges as $col) {
    $deptCoursesMap[$col['slug']] = [];
}

foreach ($homeCourses as $course) {
    $slug = $course['dept_slug'] ?? '';
    if (isset($deptCoursesMap[$slug])) {
        $deptCoursesMap[$slug][] = [
            'name'     => $course['course_name'],
            'level'    => $course['level'] ?? '',
            'duration' => $course['duration'] ?? '',
        ];
    } else {
        foreach ($rawColleges as $col) {
            if ($col['name'] === ($course['department'] ?? '')) {
                $deptCoursesMap[$col['slug']][] = [
                    'name'     => $course['course_name'],
                    'level'    => $course['level'] ?? '',
                    'duration' => $course['duration'] ?? '',
                ];
                break;
            }
        }
    }
}

// Build clean list of constituent colleges (omitting items with 0 courses)
$collegeList = [];
foreach ($rawColleges as $col) {
    $slug = $col['slug'];
    $coursesCount = count($deptCoursesMap[$slug] ?? []);
    if ($coursesCount === 0) continue;

    $nameLower = strtolower($col['name']);
    $catLower  = strtolower($col['category'] ?? '');

    $icon = 'fas fa-university';
    if (strpos($nameLower, 'pharmacy') !== false || strpos($catLower, 'pharmacy') !== false) {
        $icon = 'fas fa-pills';
    } elseif (strpos($nameLower, 'nursing') !== false || strpos($catLower, 'nursing') !== false) {
        $icon = 'fas fa-user-nurse';
    } elseif (strpos($nameLower, 'dental') !== false) {
        $icon = 'fas fa-tooth';
    } elseif (strpos($nameLower, 'medical') !== false || strpos($catLower, 'medical') !== false) {
        $icon = 'fas fa-stethoscope';
    } elseif (strpos($nameLower, 'ayurveda') !== false || strpos($nameLower, 'homoeopathic') !== false || strpos($catLower, 'ayush') !== false) {
        $icon = 'fas fa-leaf';
    } elseif (strpos($nameLower, 'law') !== false || strpos($catLower, 'law') !== false) {
        $icon = 'fas fa-scale-balanced';
    } elseif (strpos($nameLower, 'management') !== false || strpos($nameLower, 'business') !== false || strpos($catLower, 'management') !== false) {
        $icon = 'fas fa-chart-line';
    } elseif (strpos($nameLower, 'technology') !== false || strpos($nameLower, 'engineering') !== false || strpos($catLower, 'engineering') !== false) {
        $icon = 'fas fa-cogs';
    } elseif (strpos($nameLower, 'computer') !== false || strpos($nameLower, 'mca') !== false || strpos($catLower, 'computer') !== false) {
        $icon = 'fas fa-laptop-code';
    } elseif (strpos($nameLower, 'agriculture') !== false || strpos($catLower, 'agriculture') !== false) {
        $icon = 'fas fa-seedling';
    } elseif (strpos($nameLower, 'paramedical') !== false || strpos($catLower, 'paramedical') !== false) {
        $icon = 'fas fa-heartbeat';
    }

    $col['icon'] = $icon;
    $collegeList[] = $col;
    // Also alias by college name so lookups work regardless of key
    $deptCoursesMap[$col['name']] = $deptCoursesMap[$slug];
}

$postedCollege = sanitize($_POST['college'] ?? '');
$postedCourse = sanitize($_POST['course'] ?? ($_GET['course'] ?? ''));
?>
<section class="enquiry-section py-5 position-relative" id="apply">
    <div class="container-xl py-4">
        <div class="row align-items-center g-4 g-lg-5">
            
            <!-- Left Info Column -->
            <div class="col-12 col-lg-5 text-white">
                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold text-uppercase mb-3 shadow-sm">
                    <i class="fas fa-award me-1"></i> ADMISSION SESSION 2026-27
                </span>
                <h2 class="text-white fw-bold mb-3 display-6" style="line-height:1.2;">
                    Apply For <span class="text-warning">Admissions 2026</span>
                </h2>
                <p class="text-white-50 mb-4" style="line-height:1.75; font-size:1.02rem;">
                    Step into an ecosystem of innovation, world-class labs, and 94% placement track record. Select your preferred college to discover all approved degree &amp; diploma programmes.
                </p>

                <div class="d-flex flex-column gap-3 mb-4">
                    <div class="d-flex align-items-start gap-3 p-3 rounded-4" style="background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.12); backdrop-filter: blur(8px);">
                        <div class="text-warning fs-4 mt-1"><i class="fas fa-university"></i></div>
                        <div>
                            <h6 class="text-white fw-bold mb-1">26+ Constituent Colleges &amp; Faculties</h6>
                            <p class="text-white-50 small mb-0">UGC Recognized under Section 2(f) &bull; AICTE, PCI, NMC, DCI, INC, BCI, ICAR Approved</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-start gap-3 p-3 rounded-4" style="background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.12); backdrop-filter: blur(8px);">
                        <div class="text-warning fs-4 mt-1"><i class="fas fa-chart-line"></i></div>
                        <div>
                            <h6 class="text-white fw-bold mb-1">94% Campus Placements</h6>
                            <p class="text-white-50 small mb-0">12 LPA Highest Package &bull; 120+ Corporate Recruitment Partners</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-start gap-3 p-3 rounded-4" style="background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.12); backdrop-filter: blur(8px);">
                        <div class="text-warning fs-4 mt-1"><i class="fas fa-hand-holding-usd"></i></div>
                        <div>
                            <h6 class="text-white fw-bold mb-1">Scholarships &amp; Fee Concessions</h6>
                            <p class="text-white-50 small mb-0">Merit scholarships, sports awards &amp; government welfare assistance schemes</p>
                        </div>
                    </div>
                </div>

                <!-- Direct Counseling Helpline -->
                <div class="p-3 rounded-4" style="background: rgba(245, 158, 11, 0.14); border: 1.5px dashed rgba(245, 158, 11, 0.5);">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width:48px;height:48px; min-width:48px;">
                            <i class="fas fa-headset fa-lg"></i>
                        </div>
                        <div>
                            <div class="text-warning small fw-bold text-uppercase" style="letter-spacing:0.5px;">Admissions Helpline Desk</div>
                            <a href="tel:07554700983" class="text-white fw-bold fs-5 text-decoration-none">0755-4700983 / 7024144981</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Form Column -->
            <div class="col-12 col-lg-7">
                <div class="enquiry-form-box">
                    
                    <!-- Form Header Inside Card -->
                    <div class="d-flex flex-wrap align-items-center justify-content-between mb-3 pb-3 border-bottom gap-2">
                        <div>
                            <span class="srku-badge-live">
                                <span class="srku-pulse-dot"></span> Admissions Open 2026-27
                            </span>
                            <h3 class="h4 fw-bold text-dark mt-2 mb-1" style="letter-spacing:-0.3px;">Direct Admission &amp; Counseling</h3>
                            <p class="text-muted small mb-0">Fill out your details below to get instant fee structures, eligibility &amp; scholarship assistance.</p>
                        </div>
                    </div>

                    <?php if ($enquirySuccess): ?>
                        <div class="alert alert-success d-flex align-items-center gap-3 p-3 rounded-3 mb-4 shadow-sm">
                            <i class="fas fa-check-circle fa-2x text-success"></i>
                            <div>
                                <strong class="d-block text-success">Application Received Successfully!</strong>
                                <span class="small text-dark"><?php echo sanitize($enquiryMsg); ?></span>
                            </div>
                        </div>
                    <?php elseif ($enquiryErr): ?>
                        <div class="alert alert-danger d-flex align-items-center gap-2 p-3 rounded-3 mb-4">
                            <i class="fas fa-exclamation-circle text-danger"></i>
                            <span><?php echo sanitize($enquiryErr); ?></span>
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo BASE_URL; ?>#apply" method="POST" id="homeAdmissionForm">
                        
                        <!-- Row 1: Name & Father's Name -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="srku-label" for="homeEnquiryName">
                                    Your Full Name <span class="req-star">*</span>
                                </label>
                                <div class="srku-input-wrap">
                                    <i class="fas fa-user srku-field-icon"></i>
                                    <input type="text" id="homeEnquiryName" name="name" class="srku-input" placeholder="Enter your full name" minlength="2" maxlength="80" pattern="^[A-Za-z\s\.\']{2,80}$" title="Name must contain only alphabets and spaces (no numbers or symbols)." autocomplete="name" value="<?php echo $enquirySuccess ? '' : sanitize($_POST['name'] ?? ''); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="srku-label" for="homeEnquiryFatherName">
                                    Father's Name
                                </label>
                                <div class="srku-input-wrap">
                                    <i class="fas fa-user-tie srku-field-icon"></i>
                                    <input type="text" id="homeEnquiryFatherName" name="father_name" class="srku-input" placeholder="Enter father's name" maxlength="80" pattern="^[A-Za-z\s\.\']{2,80}$" title="Father's Name must contain only alphabets and spaces (no numbers)." autocomplete="off" value="<?php echo $enquirySuccess ? '' : sanitize($_POST['father_name'] ?? ''); ?>">
                                </div>
                            </div>
                        </div>

                        <!-- Row 2: College Dropdown & Dependent Course Dropdown -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="srku-label" for="homeEnquiryCollege">
                                    Select College <span class="req-star">*</span>
                                </label>
                                <div class="srku-input-wrap">
                                    <i class="fas fa-university srku-field-icon"></i>
                                    <!-- Custom Searchable Dropdown: College -->
                                    <div class="srku-dd-wrap" id="homeCollegeDDWrap">
                                        <button type="button" class="srku-dd-trigger" id="homeCollegeTrigger" aria-haspopup="listbox" aria-expanded="false">
                                            <span class="srku-dd-label srku-dd-placeholder">Select College</span>
                                            <svg class="srku-dd-chevron" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                                        </button>
                                        <div class="srku-dd-panel" id="homeCollegePanel">
                                            <div class="srku-dd-search-wrap">
                                                <i class="fas fa-search srku-dd-search-icon"></i>
                                                <input type="text" class="srku-dd-search" id="homeCollegeSearch" placeholder="Search college..." autocomplete="off">
                                            </div>
                                            <div class="srku-dd-list" id="homeCollegeList">
                                                <?php foreach ($collegeList as $col): 
                                                    $cCount = count($deptCoursesMap[$col['slug']] ?? []);
                                                ?>
                                                    <div class="srku-dd-option"
                                                         data-value="<?php echo sanitize($col['name']); ?>"
                                                         data-slug="<?php echo sanitize($col['slug']); ?>"
                                                         <?php echo (($postedCollege === $col['name'] || $postedCollege === $col['slug']) ? 'data-preselected="1"' : ''); ?>>
                                                        <span class="srku-dd-opt-text"><?php echo sanitize($col['name']); ?></span>
                                                    </div>
                                                <?php endforeach; ?>
                                                <div class="srku-dd-empty">No colleges found</div>
                                            </div>
                                        </div>
                                        <!-- Hidden native select for form submission -->
                                        <select name="college" id="homeEnquiryCollege" class="srku-dd-native" required>
                                            <option value="">-- Choose College --</option>
                                            <?php foreach ($collegeList as $col): ?>
                                                <option value="<?php echo sanitize($col['name']); ?>"
                                                        data-slug="<?php echo sanitize($col['slug']); ?>"
                                                        <?php echo (($postedCollege === $col['name'] || $postedCollege === $col['slug']) ? 'selected' : ''); ?>>
                                                    <?php echo sanitize($col['name']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="srku-label" for="homeEnquiryCourse">
                                    Course <span class="req-star">*</span>
                                </label>
                                <div class="srku-input-wrap">
                                    <i class="fas fa-graduation-cap srku-field-icon"></i>
                                    <!-- Custom Searchable Dropdown: Course -->
                                    <div class="srku-dd-wrap" id="homeCourseDDWrap">
                                        <button type="button" class="srku-dd-trigger" id="homeCourseTrigger" aria-haspopup="listbox" aria-expanded="false">
                                            <span class="srku-dd-label srku-dd-placeholder">Select Course</span>
                                            <svg class="srku-dd-chevron" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                                        </button>
                                        <div class="srku-dd-panel" id="homeCoursePanel">
                                            <div class="srku-dd-search-wrap">
                                                <i class="fas fa-search srku-dd-search-icon"></i>
                                                <input type="text" class="srku-dd-search" id="homeCourseSearch" placeholder="Search course..." autocomplete="off">
                                            </div>
                                            <div class="srku-dd-list" id="homeCourseList">
                                                <div class="srku-dd-empty visible">Please select a college first to see available courses</div>
                                            </div>
                                        </div>
                                        <!-- Hidden native select for form submission -->
                                        <select name="course" id="homeEnquiryCourse" class="srku-dd-native" required>
                                            <option value="">-- Please Choose a College First --</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Row 3: Email ID & Mobile Number -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="srku-label" for="homeEnquiryEmail">
                                    Email Address <span class="req-star">*</span>
                                </label>
                                <div class="srku-input-wrap">
                                    <i class="fas fa-envelope srku-field-icon"></i>
                                    <input type="email" id="homeEnquiryEmail" name="email" class="srku-input" placeholder="e.g. yourname@gmail.com" pattern="[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}$" title="Please enter a valid email address (e.g. name@domain.com)." value="<?php echo $enquirySuccess ? '' : sanitize($_POST['email'] ?? ''); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="srku-label" for="homeEnquiryPhone">
                                    Mobile Number <span class="req-star">*</span>
                                </label>
                                <div class="srku-input-wrap">
                                    <span class="srku-phone-prefix">+91</span>
                                    <input type="tel" id="homeEnquiryPhone" name="phone" class="srku-input srku-phone-input" placeholder="10-digit mobile number" pattern="[6-9][0-9]{9}" minlength="10" maxlength="10" inputmode="numeric" title="Please enter a valid 10-digit mobile number starting with 6, 7, 8 or 9." value="<?php echo $enquirySuccess ? '' : sanitize($_POST['phone'] ?? ''); ?>" required>
                                </div>
                            </div>
                        </div>

                        <!-- Row 4: City & State -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="srku-label" for="homeEnquiryCity">
                                    City / District
                                </label>
                                <div class="srku-input-wrap">
                                    <i class="fas fa-map-marker-alt srku-field-icon"></i>
                                    <input type="text" id="homeEnquiryCity" name="city" class="srku-input" placeholder="Enter your city (e.g. Bhopal)" maxlength="60" pattern="^[A-Za-z\s\.\-]{2,60}$" title="City name must contain only alphabets and spaces." value="<?php echo $enquirySuccess ? '' : sanitize($_POST['city'] ?? ''); ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="srku-label" for="homeEnquiryState">
                                    State
                                </label>
                                <div class="srku-input-wrap">
                                    <i class="fas fa-globe-asia srku-field-icon"></i>
                                    <input type="text" id="homeEnquiryState" name="state" class="srku-input" placeholder="Enter your state (e.g. Madhya Pradesh)" maxlength="60" pattern="^[A-Za-z\s\.\-]{2,60}$" title="State name must contain only alphabets and spaces." value="<?php echo $enquirySuccess ? '' : sanitize($_POST['state'] ?? ''); ?>">
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" name="submit_enquiry" id="homeEnquirySubmitBtn" class="btn-srku-submit-v2">
                            <i class="fas fa-paper-plane"></i> <span>Submit Admission Enquiry</span> <i class="fas fa-arrow-right btn-arrow-icon"></i>
                        </button>

                        <!-- Trust & Privacy Assurance -->
                        <div class="srku-trust-strip">
                            <span class="srku-trust-item"><i class="fas fa-shield-alt text-success"></i> Official University Portal</span>
                            <span class="srku-trust-item"><i class="fas fa-bolt text-warning"></i> Call-back within 24 Hours</span>
                            <span class="srku-trust-item"><i class="fas fa-lock text-primary"></i> 100% Privacy Protected</span>
                        </div>
                    </form>

                    <!-- Searchable Dropdown Engine -->
                    <script>
                    (function() {
                        'use strict';

                        const deptCoursesMap = <?php echo json_encode($deptCoursesMap, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
                        const preselectedCourse = <?php echo json_encode($postedCourse ?? ''); ?>;
                        const levelLabels = {
                            'UG': 'Undergraduate Programmes (UG)',
                            'PG': 'Postgraduate Programmes (PG)',
                            'Diploma': 'Diploma & Certificate Programmes',
                            'Doctorate': 'Doctoral (Ph.D.) Research'
                        };
                        const levelsOrder = ['UG', 'PG', 'Diploma', 'Doctorate'];

                        /* ── Generic Searchable Dropdown ── */
                        function initDropdown(cfg) {
                            const trigger  = document.getElementById(cfg.triggerId);
                            const panel    = document.getElementById(cfg.panelId);
                            const search   = document.getElementById(cfg.searchId);
                            const list     = document.getElementById(cfg.listId);
                            const native   = document.getElementById(cfg.nativeId);
                            if (!trigger || !panel || !list || !native) return;

                            let isOpen = false;

                            function getLabelEl() { return trigger.querySelector('.srku-dd-label'); }
                            function getEmptyEl() { return list.querySelector('.srku-dd-empty'); }

                            function open() {
                                isOpen = true;
                                trigger.classList.add('open');
                                panel.classList.add('open');
                                trigger.setAttribute('aria-expanded', 'true');
                                if (search) { search.value = ''; filterOptions(''); search.focus(); }
                            }

                            function close() {
                                isOpen = false;
                                trigger.classList.remove('open');
                                panel.classList.remove('open');
                                trigger.setAttribute('aria-expanded', 'false');
                            }

                            trigger.addEventListener('click', function(e) {
                                e.stopPropagation();
                                isOpen ? close() : open();
                            });

                            // Close on outside click
                            document.addEventListener('click', function(e) {
                                if (!trigger.contains(e.target) && !panel.contains(e.target)) close();
                            });

                            // Search filter
                            if (search) {
                                search.addEventListener('input', function() { filterOptions(this.value.trim()); });
                                search.addEventListener('click', function(e) { e.stopPropagation(); });
                            }

                            function filterOptions(query) {
                                const q = query.toLowerCase();
                                const options = list.querySelectorAll('.srku-dd-option');
                                const groups  = list.querySelectorAll('.srku-dd-group');
                                let anyVisible = false;

                                // Show/hide options
                                options.forEach(function(opt) {
                                    const textEl = opt.querySelector('.srku-dd-opt-text');
                                    const text = (textEl ? textEl.textContent : (opt.dataset.value || opt.textContent)).toLowerCase();
                                    const match = !q || text.includes(q);
                                    opt.classList.toggle('hidden', !match);
                                    if (match) anyVisible = true;
                                });

                                // Hide groups that have no visible children
                                groups.forEach(function(grp) {
                                    let sib = grp.nextElementSibling;
                                    let hasVisible = false;
                                    while (sib && !sib.classList.contains('srku-dd-group') && !sib.classList.contains('srku-dd-empty')) {
                                        if (!sib.classList.contains('hidden')) hasVisible = true;
                                        sib = sib.nextElementSibling;
                                    }
                                    grp.classList.toggle('hidden', !hasVisible);
                                });

                                const emptyEl = getEmptyEl();
                                if (emptyEl) emptyEl.classList.toggle('visible', !anyVisible);
                            }

                            // Option click
                            list.addEventListener('click', function(e) {
                                const opt = e.target.closest('.srku-dd-option');
                                if (!opt) return;
                                const val = opt.dataset.value || '';
                                const textEl = opt.querySelector('.srku-dd-opt-text');
                                const label = textEl ? textEl.textContent.trim() : (val || opt.textContent.trim());
                                selectOption(val, opt.dataset.slug || '', label);
                                close();
                                if (cfg.onChange) cfg.onChange(val, opt.dataset.slug || '');
                            });

                            function selectOption(value, slug, label) {
                                // Update trigger label
                                getLabelEl().textContent = label;
                                getLabelEl().classList.remove('srku-dd-placeholder');
                                trigger.classList.add('has-value');

                                // Mark selected in list
                                list.querySelectorAll('.srku-dd-option').forEach(function(o) {
                                    o.classList.toggle('selected', o.dataset.value === value);
                                });

                                // Update hidden native select
                                native.value = value;
                                // Trigger change on native select for any other listeners
                                native.dispatchEvent(new Event('change', { bubbles: true }));
                            }

                            // Public API
                            cfg._selectOption = selectOption;
                            cfg._open = open;
                            cfg._close = close;
                            cfg._rebuildList = rebuildList;

                            function rebuildList(groups, restoreValue) {
                                // groups: [{label, options: [{value, slug, text, data}]}]
                                list.innerHTML = '';
                                let hasOptions = false;
                                groups.forEach(function(g) {
                                    if (g.label) {
                                        const grpEl = document.createElement('div');
                                        grpEl.className = 'srku-dd-group';

                                        let iconClass = 'fas fa-graduation-cap';
                                        const lblLower = g.label.toLowerCase();
                                        if (lblLower.includes('undergraduate') || lblLower.includes('ug')) iconClass = 'fas fa-user-graduate';
                                        else if (lblLower.includes('postgraduate') || lblLower.includes('pg')) iconClass = 'fas fa-award';
                                        else if (lblLower.includes('diploma')) iconClass = 'fas fa-certificate';
                                        else if (lblLower.includes('ph.d') || lblLower.includes('doctorate')) iconClass = 'fas fa-microscope';

                                        grpEl.innerHTML = '<span class="srku-dd-group-title">' + g.label + '</span>';
                                        list.appendChild(grpEl);
                                    }
                                    g.options.forEach(function(o) {
                                        const optEl = document.createElement('div');
                                        optEl.className = 'srku-dd-option';
                                        optEl.dataset.value = o.value;
                                        if (o.slug) optEl.dataset.slug = o.slug;
                                        optEl.innerHTML = '<span class="srku-dd-opt-text">' + o.text + '</span>';
                                        list.appendChild(optEl);
                                        hasOptions = true;
                                    });
                                });

                                // Empty message
                                const emptyEl = document.createElement('div');
                                emptyEl.className = 'srku-dd-empty';
                                if (!hasOptions) emptyEl.classList.add('visible');
                                list.appendChild(emptyEl);

                                // Restore selection
                                if (restoreValue) {
                                    const matchEl = list.querySelector('.srku-dd-option[data-value="' + CSS.escape(restoreValue) + '"]') ||
                                                    Array.from(list.querySelectorAll('.srku-dd-option')).find(function(el) {
                                                        return el.dataset.value.toLowerCase() === restoreValue.toLowerCase();
                                                    });
                                    if (matchEl) {
                                        const textEl = matchEl.querySelector('.srku-dd-opt-text');
                                        const label = textEl ? textEl.textContent.trim() : matchEl.dataset.value;
                                        selectOption(matchEl.dataset.value, matchEl.dataset.slug || '', label);
                                    }
                                } else {
                                    // Reset trigger
                                    getLabelEl().textContent = cfg.placeholder || '-- Select --';
                                    getLabelEl().classList.add('srku-dd-placeholder');
                                    trigger.classList.remove('has-value');
                                }

                                // Update native select options
                                while (native.options.length > 1) native.remove(1);
                                groups.forEach(function(g) {
                                    g.options.forEach(function(o) {
                                        const nOpt = document.createElement('option');
                                        nOpt.value = o.value;
                                        nOpt.textContent = o.text;
                                        if (o.slug) nOpt.dataset.slug = o.slug;
                                        native.appendChild(nOpt);
                                    });
                                });
                                if (restoreValue) native.value = restoreValue;
                            }

                            return cfg;
                        }

                        /* ── College Dropdown ── */
                        const collegeCfg = initDropdown({
                            triggerId : 'homeCollegeTrigger',
                            panelId   : 'homeCollegePanel',
                            searchId  : 'homeCollegeSearch',
                            listId    : 'homeCollegeList',
                            nativeId  : 'homeEnquiryCollege',
                            placeholder: '-- Choose College --',
                            onChange  : function(value, slug) { populateCourses(slug, ''); }
                        });

                        /* ── Course Dropdown ── */
                        const courseCfg = initDropdown({
                            triggerId : 'homeCourseTrigger',
                            panelId   : 'homeCoursePanel',
                            searchId  : 'homeCourseSearch',
                            listId    : 'homeCourseList',
                            nativeId  : 'homeEnquiryCourse',
                            placeholder: '-- Please Choose a College First --'
                        });

                        /* ── Populate course list based on selected college ── */
                        function populateCourses(slug, restoreCourse) {
                            const courseTrigger = document.getElementById('homeCourseTrigger');
                            const courseLabelEl = courseTrigger ? courseTrigger.querySelector('.srku-dd-label') : null;

                            if (!slug || !deptCoursesMap[slug]) {
                                if (courseCfg && courseCfg._rebuildList) {
                                    courseCfg._rebuildList([{ label: '', options: [] }], '');
                                    if (courseLabelEl) {
                                        courseLabelEl.textContent = 'Select Course';
                                        courseLabelEl.classList.add('srku-dd-placeholder');
                                    }
                                }
                                return;
                            }

                            const courses = deptCoursesMap[slug];
                            if (!courses || courses.length === 0) {
                                if (courseCfg && courseCfg._rebuildList) {
                                    courseCfg._rebuildList([{ label: '', options: [{ value: 'General Admission Enquiry', text: 'General Admission Enquiry' }] }], restoreCourse);
                                }
                                return;
                            }

                            const grouped = {};
                            courses.forEach(function(c) {
                                const lvl = c.level || 'Other';
                                if (!grouped[lvl]) grouped[lvl] = [];
                                grouped[lvl].push(c);
                            });

                            const sortedLevels = [
                                ...levelsOrder.filter(function(l) { return grouped[l]; }),
                                ...Object.keys(grouped).filter(function(l) { return !levelsOrder.includes(l); })
                            ];

                            const flatOptions = [];
                            sortedLevels.forEach(function(lvl) {
                                grouped[lvl].forEach(function(c) {
                                    flatOptions.push({
                                        value: c.name,
                                        text : c.name + (c.duration ? ' (' + c.duration + ')' : '')
                                    });
                                });
                            });

                            if (courseCfg && courseCfg._rebuildList) {
                                courseCfg._rebuildList([{ label: '', options: flatOptions }], restoreCourse);
                                if (courseLabelEl && !restoreCourse) {
                                    courseLabelEl.textContent = 'Select Course';
                                    courseLabelEl.classList.add('srku-dd-placeholder');
                                }
                            }
                        }

                        /* ── On-load: restore postback selections ── */
                        (function restorePostback() {
                            const collegeList   = document.getElementById('homeCollegeList');
                            const collegeTrigger= document.getElementById('homeCollegeTrigger');
                            if (!collegeList || !collegeTrigger) return;

                            const preselectedOpt = collegeList.querySelector('.srku-dd-option[data-preselected="1"]');
                            if (preselectedOpt) {
                                const textEl = preselectedOpt.querySelector('.srku-dd-opt-text');
                                const label = textEl ? textEl.textContent.trim() : preselectedOpt.dataset.value;
                                const labelEl = collegeTrigger.querySelector('.srku-dd-label');
                                if (labelEl) labelEl.textContent = label;
                                collegeTrigger.classList.add('has-value');
                                preselectedOpt.classList.add('selected');
                                const nativeCollege = document.getElementById('homeEnquiryCollege');
                                if (nativeCollege) nativeCollege.value = preselectedOpt.dataset.value;

                                // Then populate courses
                                const slug = preselectedOpt.dataset.slug || '';
                                populateCourses(slug, preselectedCourse);
                            }
                        })();

                    })();
                    </script>

                </div>
            </div>

        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     RECENT NEWS & BLOGS
═══════════════════════════════════════════════════════ -->
<?php $homeBlogs = getBlogs(null, 3); ?>
<?php if (!empty($homeBlogs)): ?>
<section class="py-5 bg-cream">
    <div class="container-xl py-3">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-4 gap-2">
            <div>
                <span class="section-subtitle">RECENT BLOGS &amp; ARTICLES</span>
                <h2 class="section-title mb-0">Insights &amp; Stories from <span>SRK University</span></h2>
            </div>
            <a href="<?php echo BASE_URL; ?>blogs.php" class="btn-card-apply fs-6">View All Articles <i class="fas fa-arrow-right ms-1"></i></a>
        </div>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php foreach ($homeBlogs as $b): ?>
                <div class="col">
                    <div class="prog-card h-100 d-flex flex-column">
                        <img src="<?php echo !empty($b['image_url']) ? BASE_URL . sanitize($b['image_url']) : BASE_URL . 'assets/uploads/2026/07/001.webp'; ?>"
                             onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';"
                             class="prog-img" alt="<?php echo sanitize($b['title']); ?>">
                        <div class="prog-body d-flex flex-column flex-grow-1">
                            <div class="d-flex justify-content-between small text-muted mb-1">
                                <span class="badge bg-danger-subtle text-danger"><?php echo sanitize($b['category']); ?></span>
                                <span><i class="far fa-calendar-alt me-1"></i> <?php echo date('d M Y', strtotime($b['publish_date'] ?: $b['created_at'])); ?></span>
                            </div>
                            <h3 class="prog-title mt-2"><?php echo sanitize($b['title']); ?></h3>
                            <p class="prog-desc flex-grow-1"><?php 
                                $bdesc = !empty($b['short_description']) ? $b['short_description'] : strip_tags($b['content']);
                                echo substr($bdesc, 0, 110) . '...'; 
                            ?></p>
                            <a href="<?php echo BASE_URL; ?>blog-detail.php?slug=<?php echo urlencode($b['slug'] ?: $b['id']); ?>" class="btn-card-apply mt-auto align-self-start">Read Article &rarr;</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ═══════════════════════════════════════════════════════
     TESTIMONIALS (matches live srku.edu.in design)
═══════════════════════════════════════════════════════ -->
<?php
$homeTestimonials = [
    [
        'name' => 'Ravi Gupta',
        'dept' => 'B.Tech (Computer Science & Engg.)',
        'city' => 'Bhopal',
        'initials' => 'RG',
        'text' => 'Graduated from SRKU with valuable technical skills, modern lab exposure, and industry internship experiences that helped me build a rewarding engineering career. The faculty mentorship and career services provided exceptional support.',
    ],
    [
        'name' => 'Nitish Rai',
        'dept' => 'Faculty of Engineering & Technology',
        'city' => 'Bhopal',
        'initials' => 'NR',
        'text' => 'The professors at Sarvepalli Radhakrishnan University are some of the most knowledgeable mentors in their domains. I benefited greatly from the practical project training, advanced workshops, and academic guidance.',
    ],
    [
        'name' => 'Manish Nigam',
        'dept' => 'Faculty of Management Studies (MBA)',
        'city' => 'Bhopal',
        'initials' => 'MN',
        'text' => 'Attending SRKU for my management degree was a transformative decision. The corporate seminars, live case studies, and dynamic campus environment helped me develop strong leadership and strategic thinking skills.',
    ],
    [
        'name' => 'Pooja Sharma',
        'dept' => 'Faculty of Pharmacy',
        'city' => 'Indore',
        'initials' => 'PS',
        'text' => 'The pharmaceutical research facilities and faculty mentorship at SRKU provided me with deep practical exposure. The dedicated placement guidance helped me secure an excellent role in the healthcare industry.',
    ],
    [
        'name' => 'Aman Verma',
        'dept' => 'Faculty of Agriculture',
        'city' => 'Sehore',
        'initials' => 'AV',
        'text' => 'The agricultural research farms, modern agronomy labs, and field training offered at SRKU provided deep hands-on learning. The teachers are always ready to guide students towards career excellence.',
    ],
    [
        'name' => 'Neha Chouhan',
        'dept' => 'Faculty of Paramedical & Nursing',
        'city' => 'Bhopal',
        'initials' => 'NC',
        'text' => 'The clinical rotations at the university teaching hospital gave me great professional confidence. The supportive faculty and disciplined academic environment made my learning journey memorable.',
    ],
];
$testimonialSlides = array_chunk($homeTestimonials, 2);
?>
<section class="testimonial-v2">
    <div class="container-xl" style="max-width: 1140px;">
        <div class="text-center mb-4">
            <span class="testimonial-v2__eyebrow">
                <i class="fas fa-quote-left text-danger me-1"></i> Real Stories &amp; Student Experiences
            </span>
            <h2 class="testimonial-v2__title mb-2">What our <em>Students say</em> about the university</h2>
            <p class="text-muted small mx-auto" style="max-width: 650px;">
                Discover firsthand experiences, academic highlights, and career journeys shared by our students and alumni across diverse faculties.
            </p>
        </div>

        <div class="testimonial-v2__carousel" id="testimonialCarousel">
            <?php foreach ($testimonialSlides as $sIdx => $pair): ?>
                <div class="testimonial-v2__slide<?php echo $sIdx === 0 ? ' active' : ''; ?>">
                    <div class="row g-4">
                        <?php foreach ($pair as $t): ?>
                            <div class="col-12 col-md-6">
                                <div class="testimonial-v2__card">
                                    <i class="fas fa-quote-right testimonial-v2__quote-icon" aria-hidden="true"></i>
                                    <div class="testimonial-v2__stars">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <p class="testimonial-v2__text">&ldquo;<?php echo sanitize($t['text']); ?>&rdquo;</p>
                                    <div class="testimonial-v2__author">
                                        <div class="testimonial-v2__avatar">
                                            <?php echo sanitize($t['initials']); ?>
                                        </div>
                                        <div>
                                            <h4 class="testimonial-v2__name"><?php echo sanitize($t['name']); ?></h4>
                                            <p class="testimonial-v2__city">
                                                <span><?php echo sanitize($t['dept']); ?></span> &bull; <span><?php echo sanitize($t['city']); ?></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="testimonial-v2__nav-wrap">
            <button type="button" class="testimonial-v2__nav-btn" id="prevTestimonial" aria-label="Previous Testimonial">
                <i class="fas fa-chevron-left"></i>
            </button>
            <div class="testimonial-v2__dots" id="testimonialDots">
                <?php foreach ($testimonialSlides as $sIdx => $pair): ?>
                    <span class="testimonial-v2__dot<?php echo $sIdx === 0 ? ' active' : ''; ?>" data-index="<?php echo $sIdx; ?>" title="Slide <?php echo ($sIdx + 1); ?>"></span>
                <?php endforeach; ?>
            </div>
            <button type="button" class="testimonial-v2__nav-btn" id="nextTestimonial" aria-label="Next Testimonial">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>
</section>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var carousel = document.getElementById('testimonialCarousel');
    var slides = document.querySelectorAll('#testimonialCarousel .testimonial-v2__slide');
    var dots = document.querySelectorAll('#testimonialDots .testimonial-v2__dot');
    var prevBtn = document.getElementById('prevTestimonial');
    var nextBtn = document.getElementById('nextTestimonial');

    if (!slides.length) return;
    var current = 0;
    var timer = null;

    function showSlide(index) {
        if (index < 0) {
            current = slides.length - 1;
        } else if (index >= slides.length) {
            current = 0;
        } else {
            current = index;
        }

        slides.forEach(function (slide, i) {
            if (i === current) {
                slide.classList.add('active');
            } else {
                slide.classList.remove('active');
            }
        });

        dots.forEach(function (dot, i) {
            if (i === current) {
                dot.classList.add('active');
            } else {
                dot.classList.remove('active');
            }
        });
    }

    function startAutoPlay() {
        stopAutoPlay();
        timer = setInterval(function () {
            showSlide(current + 1);
        }, 5000);
    }

    function stopAutoPlay() {
        if (timer) {
            clearInterval(timer);
            timer = null;
        }
    }

    if (prevBtn) {
        prevBtn.addEventListener('click', function (e) {
            e.preventDefault();
            showSlide(current - 1);
            startAutoPlay();
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', function (e) {
            e.preventDefault();
            showSlide(current + 1);
            startAutoPlay();
        });
    }

    dots.forEach(function (dot) {
        dot.addEventListener('click', function (e) {
            e.preventDefault();
            var targetIdx = parseInt(this.getAttribute('data-index'), 10);
            if (!isNaN(targetIdx)) {
                showSlide(targetIdx);
                startAutoPlay();
            }
        });
    });

    if (carousel) {
        carousel.addEventListener('mouseenter', stopAutoPlay);
        carousel.addEventListener('mouseleave', startAutoPlay);

        // Touch Swipe Support for Mobile Devices
        var touchStartX = 0;
        var touchEndX = 0;

        carousel.addEventListener('touchstart', function (e) {
            touchStartX = e.changedTouches[0].screenX;
            stopAutoPlay();
        }, { passive: true });

        carousel.addEventListener('touchend', function (e) {
            touchEndX = e.changedTouches[0].screenX;
            var swipeDiff = touchEndX - touchStartX;
            if (Math.abs(swipeDiff) > 40) {
                if (swipeDiff < 0) {
                    showSlide(current + 1); // Swiped Left -> Next
                } else {
                    showSlide(current - 1); // Swiped Right -> Prev
                }
            }
            startAutoPlay();
        }, { passive: true });
    }

    startAutoPlay();
});
</script>

<!-- ═══════════════════════════════════════════════════════
     EVENTS GALLERY (auto-scrolling, matches live srku.edu.in design)
═══════════════════════════════════════════════════════ -->
<?php
$eventsGalleryImages = [
    ['file' => 'Gallary-slider-10.webp', 'alt' => 'Faculty Group Event'],
    ['file' => 'Gallary-slider-07.webp', 'alt' => 'Library Session'],
    ['file' => 'Gallary-slider-06.webp', 'alt' => 'Clinical Training Event'],
    ['file' => 'Gallary-slider-03.webp', 'alt' => 'MRI Lab Tour'],
    ['file' => '2.png', 'alt' => 'Cultural Dance Event'],
    ['file' => 'Gallary-slider-01.webp', 'alt' => 'Hospital Ward Visit'],
    ['file' => '7.png', 'alt' => 'Award Ceremony'],
    ['file' => '6.png', 'alt' => 'University Event'],
    ['file' => '5.png', 'alt' => 'University Event'],
    ['file' => '4.png', 'alt' => 'University Event'],
];
?>
<section class="py-5">
    <div class="container-xl py-2 text-center">
        <span class="section-subtitle">OUR EVENTS GALLERY</span>
        <h2 class="section-title mb-4">Events <span>at SRK</span> University</h2>
    </div>
    <div class="auto-gallery__viewport" id="eventsGalleryViewport">
        <div class="auto-gallery__track auto-gallery__track--3up" id="eventsGalleryTrack">
            <?php foreach ($eventsGalleryImages as $img): ?>
                <div class="auto-gallery__item auto-gallery__item--3up">
                    <img src="<?php echo BASE_URL . 'assets/uploads/2026/07/' . rawurlencode($img['file']); ?>"
                         onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';"
                         alt="<?php echo sanitize($img['alt']); ?>">
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="auto-gallery__dots" id="eventsGalleryDots"></div>
    <div class="text-center mt-4">
        <a href="<?php echo BASE_URL; ?>gallery.php" class="btn btn-srku-gold">
            <i class="fas fa-images me-2"></i>View Full Gallery
        </a>
    </div>
</section>
<script>
(function () {
    var track = document.getElementById('eventsGalleryTrack');
    var viewport = document.getElementById('eventsGalleryViewport');
    var dotsWrap = document.getElementById('eventsGalleryDots');
    if (!track || !viewport || !dotsWrap) return;

    var originalItems = Array.prototype.slice.call(track.children);
    var total = originalItems.length;

    function perView() {
        var w = window.innerWidth;
        if (w < 576) return 1;
        if (w < 900) return 2;
        return 3;
    }

    var visible = perView();
    originalItems.slice(0, visible).forEach(function (node) {
        track.appendChild(node.cloneNode(true));
    });

    var index = 0;
    var dots = [];
    dotsWrap.innerHTML = '';
    for (var i = 0; i < total; i++) {
        var dot = document.createElement('span');
        dot.className = 'auto-gallery__dot' + (i === 0 ? ' active' : '');
        (function (idx) {
            dot.addEventListener('click', function () { goTo(idx); });
        })(i);
        dotsWrap.appendChild(dot);
        dots.push(dot);
    }

    function setPosition(withTransition) {
        var itemWidth = track.children[0].getBoundingClientRect().width;
        var gap = parseFloat(getComputedStyle(track).columnGap || getComputedStyle(track).gap || 0);
        track.style.transition = withTransition === false ? 'none' : '';
        track.style.transform = 'translateX(-' + (index * (itemWidth + gap)) + 'px)';
    }

    function updateDots() {
        dots.forEach(function (d, i) { d.classList.toggle('active', i === (index % total)); });
    }

    function goTo(i) {
        index = i;
        setPosition(true);
        updateDots();
    }

    function next() {
        index++;
        setPosition(true);
        updateDots();
        if (index >= total) {
            setTimeout(function () {
                index = 0;
                setPosition(false);
            }, 500);
        }
    }

    window.addEventListener('resize', function () {
        visible = perView();
        setPosition(false);
    });

    setPosition(false);
    setInterval(next, 2500);
})();
</script>

<!-- ═══════════════════════════════════════════════════════
     CTA BANNER
═══════════════════════════════════════════════════════ -->
<section class="py-5 text-center text-white" style="background: linear-gradient(135deg, var(--srku-navy), var(--srku-dark));">
    <div class="container-xl py-2">
        <h2 class="fw-bold mb-2">Admissions Open for Academic Session 2026-27</h2>
        <p class="text-white-50 mb-4" style="font-size:1.05rem;">Take the first step towards a rewarding global career with SRK University Bhopal.</p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="#apply" class="btn btn-srku-gold px-4 py-2"><i class="fas fa-edit me-1"></i> Apply Now</a>
            <a href="tel:<?php echo preg_replace('/[^0-9]/', '', getSetting('helpline')); ?>" class="btn btn-srku-outline px-4 py-2"><i class="fas fa-phone-alt me-1"></i> Call Helpline</a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
