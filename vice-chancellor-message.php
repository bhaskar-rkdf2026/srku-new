<?php
require_once __DIR__ . '/includes/functions.php';

$vcName = getSetting('vc_name', 'Ms. Priyanka Jaiswal');
$vcTitle = getSetting('vc_title', 'Vice Chancellor');
$vcPhoto = getSetting('vc_photo', '');
if (strpos($vcPhoto, 'ruchichaubey') !== false) { $vcPhoto = ''; }
$vcPhotoSrc = (strpos($vcPhoto, 'http') === 0) ? $vcPhoto : BASE_URL . $vcPhoto;
$vcEmail = getSetting('vc_email', 'vc@srku.edu.in');
$vcGoalsRaw = getSetting('vc_goals', "Choice Based Credit System (CBCS)\nIndustry-Integrated Curriculum & Internships\nInterdisciplinary Research Publications\nGlobal Academic Partnerships & MOUs");
$vcGoals = array_filter(array_map('trim', explode("\n", $vcGoalsRaw)));
$vcHeading = getSetting('vc_heading', 'Empowering Minds for a Knowledge Economy');
$vcSalutation = getSetting('vc_salutation', 'Dear Students, Scholars, Faculty Colleagues, and Visitors,');
$vcMsg = getSetting('vc_msg', 'It is my distinct honor and privilege to welcome you to Sarvepalli Radhakrishnan University (SRKU), Bhopal. As Vice Chancellor, my primary commitment is to create an inspiring, inclusive, and forward-looking academic ecosystem where intellectual rigor meets societal responsibility.');
$vcMsg2 = getSetting('vc_msg2', 'Higher education today is experiencing unprecedented transformation. The rapid advancements in Artificial Intelligence, medical biotechnology, renewable energy, smart manufacturing, and digital jurisprudence require universities to reinvent their pedagogical frameworks. At SRKU, our curriculum is strictly benchmarked with National Education Policy (NEP) guidelines and continuously updated in consultation with apex academic bodies and Fortune 500 industry leaders.');
$vcMsg3 = getSetting('vc_msg3', 'Our 1,000+ distinguished faculty members—including experienced professors, medical surgeons, scientists, and legal scholars—serve not just as teachers, but as dedicated mentors who nurture the unique talents of each individual student. Through continuous faculty development and active research initiatives, we maintain the highest standards of academic delivery.');
$vcMsg4 = getSetting('vc_msg4', 'To all our learners: SRKU is your canvas. Strive for excellence, question conventional thinking, embrace multidisciplinary perspectives, and lead with empathy. Together, let us contribute meaningfully to the advancement of knowledge, human welfare, and the nation.');
$vcFullPage = getSetting('vc_full_page_msg', '');

$pageTitle = "Vice Chancellor's Message | " . $vcName . " | SRKU Bhopal";
$pageDesc = "Read the official address and academic vision from " . $vcName . ", " . $vcTitle . " of Sarvepalli Radhakrishnan University (SRKU), Bhopal.";
$pageKeywords = "Vice Chancellor Message SRKU, " . $vcName . " VC, SRKU Academic Leadership, Vice Chancellor Bhopal";
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
                        <li class="breadcrumb-item active" aria-current="page" style="color: rgba(255,255,255,0.85);">Vice Chancellor's Message</li>
                    </ol>
                </nav>
                <span class="about-hero-v2__eyebrow"><i class="fas fa-graduation-cap"></i> Academic Leadership &amp; Innovation</span>
                <h1 class="about-hero-v2__title">Message from the <span>Vice Chancellor</span></h1>
                <p class="about-hero-v2__desc">
                    "Fostering experiential learning, multidisciplinary innovation, and global competence aligned with National Education Policy (NEP) 2020."
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="<?php echo BASE_URL; ?>courses.php" class="btn-hero-yellow">
                        <i class="fas fa-book-open me-1"></i> Explore 120+ Programmes
                    </a>
                    <a href="<?php echo BASE_URL; ?>chancellor-message.php" class="btn-hero-outline">
                        <i class="fas fa-crown me-1"></i> Chancellor's Message
                    </a>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="about-hero-v2__cards">
                    <div class="about-hero-v2__card about-hero-v2__card--float1">
                        <i class="fas fa-book-reader"></i>
                        <span class="num">120+</span>
                        <span class="lbl">UG / PG Programmes</span>
                    </div>
                    <div class="about-hero-v2__card about-hero-v2__card--float2">
                        <i class="fas fa-flask"></i>
                        <span class="num">1,400+</span>
                        <span class="lbl">Research Papers</span>
                    </div>
                    <div class="about-hero-v2__card about-hero-v2__card--float3">
                        <i class="fas fa-briefcase"></i>
                        <span class="num">94%</span>
                        <span class="lbl">Placement Record</span>
                    </div>
                    <div class="about-hero-v2__card about-hero-v2__card--float4">
                        <i class="fas fa-layer-group"></i>
                        <span class="num">14</span>
                        <span class="lbl">Academic Faculties</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main Vice Chancellor Message Content -->
<section class="py-5 bg-light position-relative">
    <div class="container-xl py-4">
        <div class="row g-5">
            
            <!-- Left: VC Profile Card (Sticky) -->
            <div class="col-12 col-lg-4 position-relative">
                <div class="card border-0 shadow rounded-4 overflow-hidden sticky-profile-sidebar">
                    <div class="bg-gradient-navy text-white p-4 text-center" style="background: linear-gradient(135deg, #0F1E3B 0%, #1e3a8a 100%);">
                        <div class="mx-auto mb-3 bg-white p-1 rounded-4 shadow" style="width: 100%; max-width: 220px; height: 250px; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                            <?php if (strpos($vcPhoto, 'ruchichaubey') === false && !empty($vcPhoto)): ?>
                                <img src="<?php echo $vcPhotoSrc; ?>" alt="<?php echo sanitize($vcName); ?>" class="w-100 h-100 rounded-3 shadow-sm" style="object-fit: cover; object-position: top center;">
                            <?php else: ?>
                                <div class="rounded-3 bg-light text-navy d-flex align-items-center justify-content-center w-100 h-100 shadow-sm" style="color: #0F1E3B; font-size: 4.5rem;">
                                    <i class="fas fa-user-graduate"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        <h4 class="fw-bold mb-1 text-white"><?php echo sanitize($vcName); ?></h4>
                        <p class="text-warning small mb-0 fw-semibold"><?php echo sanitize($vcTitle); ?></p>
                        <small class="text-white-50">Sarvepalli Radhakrishnan University, Bhopal</small>
                    </div>

                    <div class="card-body p-4 bg-white">
                        <h6 class="fw-bold text-navy mb-3 text-uppercase small" style="letter-spacing: 0.5px;">Academic Strategic Goals</h6>
                        <ul class="list-unstyled mb-4 small text-secondary d-flex flex-column gap-2">
                            <?php foreach ($vcGoals as $goal): ?>
                                <li class="d-flex align-items-center gap-2">
                                    <i class="fas fa-check-circle text-primary"></i> <?php echo sanitize($goal); ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>

                        <div class="border-top pt-3 text-center">
                            <a href="mailto:<?php echo sanitize($vcEmail); ?>" class="btn btn-outline-primary btn-sm w-100 rounded-pill fw-semibold py-2">
                                <i class="fas fa-envelope me-1"></i> <?php echo sanitize($vcEmail); ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: VC Message Letter -->
            <div class="col-12 col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white">
                    <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom">
                        <div class="p-3 rounded-circle bg-primary-subtle text-primary" style="font-size: 1.5rem;">
                            <i class="fas fa-quote-left"></i>
                        </div>
                        <div>
                            <span class="badge bg-navy text-white px-3 py-1 rounded-pill small fw-bold" style="background-color: #0F1E3B;">Vice Chancellor's Vision</span>
                            <h2 class="h3 fw-bold text-navy mb-0 mt-1"><?php echo sanitize($vcHeading); ?></h2>
                        </div>
                    </div>

                    <?php if (!empty($vcSalutation)): ?>
                        <div class="lead text-secondary mb-4" style="line-height: 1.8; font-size: 1.05rem;">
                            <?php echo sanitize($vcSalutation); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($vcMsg)): ?>
                        <p class="text-secondary" style="line-height: 1.85; font-size: 1.02rem;">
                            <?php echo nl2br(sanitize($vcMsg)); ?>
                        </p>
                    <?php endif; ?>

                    <?php if (!empty($vcMsg2)): ?>
                        <p class="text-secondary" style="line-height: 1.85; font-size: 1.02rem;">
                            <?php echo nl2br(sanitize($vcMsg2)); ?>
                        </p>
                    <?php endif; ?>

                    <div class="row g-3 my-3">
                        <div class="col-12 col-md-6">
                            <div class="p-3 bg-light rounded-3 border">
                                <h6 class="fw-bold text-navy mb-1"><i class="fas fa-laptop-code text-primary me-2"></i> Experiential Pedagogy</h6>
                                <p class="text-muted small mb-0">Project-based learning, simulation labs, industry internships, and live clinical exposure for all students.</p>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="p-3 bg-light rounded-3 border">
                                <h6 class="fw-bold text-navy mb-1"><i class="fas fa-microscope text-primary me-2"></i> Research First Mindset</h6>
                                <p class="text-muted small mb-0">Encouraging undergraduate and doctoral research, patent filing, seed funding, and indexed journal publications.</p>
                            </div>
                        </div>
                    </div>

                    <?php if (!empty($vcMsg3)): ?>
                        <p class="text-secondary" style="line-height: 1.85; font-size: 1.02rem;">
                            <?php echo nl2br(sanitize($vcMsg3)); ?>
                        </p>
                    <?php endif; ?>

                    <?php if (!empty($vcMsg4)): ?>
                        <p class="text-secondary" style="line-height: 1.85; font-size: 1.02rem;">
                            <?php echo nl2br(sanitize($vcMsg4)); ?>
                        </p>
                    <?php endif; ?>

                    <div class="mt-5 pt-4 border-top d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
                        <div>
                            <h5 class="fw-bold text-navy mb-0"><?php echo sanitize($vcName); ?></h5>
                            <p class="text-primary small mb-0 fw-semibold"><?php echo sanitize($vcTitle); ?></p>
                            <small class="text-muted">Sarvepalli Radhakrishnan University, Bhopal</small>
                        </div>
                        <div class="text-sm-end">
                            <a href="mailto:<?php echo sanitize($vcEmail); ?>" class="badge bg-light text-secondary border px-3 py-2 rounded-pill small text-decoration-none">
                                <i class="fas fa-envelope text-primary me-1"></i> <?php echo sanitize($vcEmail); ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
