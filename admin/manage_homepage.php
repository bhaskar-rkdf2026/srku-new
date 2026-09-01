<?php
require_once __DIR__ . '/header.php';
$pdo = getDBConnection();

// Active Tab
$tab = sanitize($_GET['tab'] ?? 'hero');

// Handle Save Homepage Sections
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_homepage_sections'])) {
    
    $heroVideo = normalizeMediaPath($_POST['hero_video_url'] ?? '', 'assets/images/concept2-hero.mp4');
    $heroFallback = normalizeMediaPath($_POST['hero_fallback_image'] ?? '', 'assets/uploads/2026/08/srku-rkdf-building.jpeg');
    $chancellorPhoto = normalizeMediaPath($_POST['chancellor_photo'] ?? '', 'assets/uploads/2026/08/chancellor.jpeg');
    $vcPhoto = normalizeMediaPath($_POST['vc_photo'] ?? '', 'assets/uploads/2026/07/ruchichaubey.webp');
    $welcomePhoto = normalizeMediaPath($_POST['welcome_photo'] ?? '', 'assets/uploads/2026/08/welcome-srku-campus.jpeg');

    $uploadDir = __DIR__ . '/../assets/uploads/2026/08/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

    // Video Upload
    if (isset($_FILES['video_file']) && $_FILES['video_file']['error'] === UPLOAD_ERR_OK) {
        $allowed = ['mp4', 'webm', 'ogg', 'mov'];
        $ext = strtolower(pathinfo($_FILES['video_file']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, $allowed)) {
            $fn = 'hero_video_' . time() . '.' . $ext;
            if (move_uploaded_file($_FILES['video_file']['tmp_name'], $uploadDir . $fn)) {
                $heroVideo = 'assets/uploads/2026/08/' . $fn;
            }
        }
    }

    // Fallback Image Upload
    if (isset($_FILES['fallback_img_file']) && $_FILES['fallback_img_file']['error'] === UPLOAD_ERR_OK) {
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        $ext = strtolower(pathinfo($_FILES['fallback_img_file']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, $allowed)) {
            $fn = 'hero_fallback_' . time() . '.' . $ext;
            if (move_uploaded_file($_FILES['fallback_img_file']['tmp_name'], $uploadDir . $fn)) {
                $heroFallback = 'assets/uploads/2026/08/' . $fn;
            }
        }
    }

    // Chancellor Photo Upload
    if (isset($_FILES['chancellor_photo_file']) && $_FILES['chancellor_photo_file']['error'] === UPLOAD_ERR_OK) {
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        $ext = strtolower(pathinfo($_FILES['chancellor_photo_file']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, $allowed)) {
            $fn = 'chancellor_' . time() . '.' . $ext;
            if (move_uploaded_file($_FILES['chancellor_photo_file']['tmp_name'], $uploadDir . $fn)) {
                $chancellorPhoto = 'assets/uploads/2026/08/' . $fn;
            }
        }
    }

    // VC Photo Upload
    if (isset($_FILES['vc_photo_file']) && $_FILES['vc_photo_file']['error'] === UPLOAD_ERR_OK) {
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        $ext = strtolower(pathinfo($_FILES['vc_photo_file']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, $allowed)) {
            $fn = 'vc_' . time() . '.' . $ext;
            if (move_uploaded_file($_FILES['vc_photo_file']['tmp_name'], $uploadDir . $fn)) {
                $vcPhoto = 'assets/uploads/2026/08/' . $fn;
            }
        }
    }

    // Welcome Photo Upload
    if (isset($_FILES['welcome_photo_file']) && $_FILES['welcome_photo_file']['error'] === UPLOAD_ERR_OK) {
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        $ext = strtolower(pathinfo($_FILES['welcome_photo_file']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, $allowed)) {
            $fn = 'welcome_' . time() . '.' . $ext;
            if (move_uploaded_file($_FILES['welcome_photo_file']['tmp_name'], $uploadDir . $fn)) {
                $welcomePhoto = 'assets/uploads/2026/08/' . $fn;
            }
        }
    }

    $settingsToSave = [
        // Section 1: Hero
        'hero_title' => sanitize($_POST['hero_title'] ?? 'SRK University, Bhopal'),
        'hero_subtitle' => sanitize($_POST['hero_subtitle'] ?? 'UGC-Recognized University in MP'),
        'hero_desc' => $_POST['hero_desc'] ?? '',
        'hero_video_url' => $heroVideo,
        'hero_fallback_image' => $heroFallback,

        // Section 2: Stats Strip
        'total_labs' => sanitize($_POST['total_labs'] ?? '42+'),
        'placement_record' => sanitize($_POST['placement_record'] ?? '94%'),
        'recruiting_partners' => sanitize($_POST['recruiting_partners'] ?? '120+'),
        'total_alumni' => sanitize($_POST['total_alumni'] ?? '15,000+'),

        // Section 3: Live Ticker
        'ticker_text' => sanitize($_POST['ticker_text'] ?? ''),
        'highest_package' => sanitize($_POST['highest_package'] ?? '12 LPA'),

        // Section 4: Welcome Section
        'welcome_subtitle' => sanitize($_POST['welcome_subtitle'] ?? 'WELCOME TO SRK UNIVERSITY'),
        'welcome_title' => sanitize($_POST['welcome_title'] ?? 'Committed Towards Your Better Future Through Academic Excellence'),
        'welcome_body_1' => $_POST['welcome_body_1'] ?? '',
        'welcome_body_2' => $_POST['welcome_body_2'] ?? '',
        'welcome_photo' => $welcomePhoto,

        // Section 5: Chancellor
        'chancellor_name' => sanitize($_POST['chancellor_name'] ?? 'Mrs. Janak Kapoor'),
        'chancellor_title' => sanitize($_POST['chancellor_title'] ?? 'Chancellor'),
        'chancellor_photo' => $chancellorPhoto,
        'chancellor_heading' => sanitize($_POST['chancellor_heading'] ?? 'A Legacy of Excellence, A Vision for Tomorrow'),
        'chancellor_msg' => $_POST['chancellor_msg'] ?? '',
        'chancellor_msg2' => $_POST['chancellor_msg2'] ?? '',
        'chancellor_msg_hindi' => $_POST['chancellor_msg_hindi'] ?? '',
        'chancellor_full_page_msg' => $_POST['chancellor_full_page_msg'] ?? '',

        // Section 6: Vice Chancellor
        'vc_name' => sanitize($_POST['vc_name'] ?? 'Ms. Priyanka Jaiswal'),
        'vc_title' => sanitize($_POST['vc_title'] ?? 'Vice Chancellor'),
        'vc_photo' => $vcPhoto,
        'vc_email' => sanitize($_POST['vc_email'] ?? 'vc@srku.edu.in'),
        'vc_goals' => $_POST['vc_goals'] ?? '',
        'vc_heading' => sanitize($_POST['vc_heading'] ?? 'Empowering Minds for a Knowledge Economy'),
        'vc_salutation' => sanitize($_POST['vc_salutation'] ?? 'Dear Students, Scholars, Faculty Colleagues, and Visitors,'),
        'vc_msg' => $_POST['vc_msg'] ?? '',
        'vc_msg2' => $_POST['vc_msg2'] ?? '',
        'vc_msg3' => $_POST['vc_msg3'] ?? '',
        'vc_msg4' => $_POST['vc_msg4'] ?? '',
        'vc_full_page_msg' => $_POST['vc_full_page_msg'] ?? ''
    ];

    foreach ($settingsToSave as $key => $val) {
        $stmt = $pdo->prepare("INSERT INTO settings (setting_key, setting_value) VALUES (:k, :v) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)");
        $stmt->execute([':k' => $key, ':v' => $val]);
    }

    setFlashMsg('success', 'Homepage & Leadership sections updated successfully.');
    header("Location: manage_homepage.php?tab=" . urlencode($tab));
    exit;
}

// Current Values
$heroTitle = getSetting('hero_title', 'SRK University, Bhopal');
$heroSubtitle = getSetting('hero_subtitle', 'UGC-Recognized University in MP');
$heroDesc = getSetting('hero_desc', 'Welcome to SRK University, a premier technical and academic ecosystem designed for global industry leadership.');
$heroVideo = getSetting('hero_video_url', 'assets/images/SRK-Hero-Section.mp4');
$heroFallback = getSetting('hero_fallback_image', 'assets/uploads/2026/08/srku-rkdf-building.jpeg');

$totalLabs = getSetting('total_labs', '42+');
$placementRecord = getSetting('placement_record', '94%');
$recruitingPartners = getSetting('recruiting_partners', '120+');
$totalAlumni = getSetting('total_alumni', '15,000+');

$tickerText = getSetting('ticker_text', 'Admissions Open 2026-27 | UGC Recognized Premier University in MP | Apply Now for Engineering, Pharmacy, Nursing, Management & Medicine | 94% Placement Record');
$highestPackage = getSetting('highest_package', '12 LPA');

$welcomeSubtitle = getSetting('welcome_subtitle', 'WELCOME TO SRK UNIVERSITY');
$welcomeTitle = getSetting('welcome_title', 'Committed Towards Your Better Future Through Academic Excellence');
$welcomeBody1 = getSetting('welcome_body_1', 'The SRK University is a multidisciplinary university known for its high standards in teaching and research, and attracts eminent scholars to its faculty across the academic spectrum.');
$welcomeBody2 = getSetting('welcome_body_2', 'The group was established in 1995 under the flagship of the RKDF Group. Ever since its inception, a strong commitment to excellence in teaching and research has made the group a role-model and path-setter for other institutions.');
$welcomePhoto = getSetting('welcome_photo', 'assets/uploads/2026/08/welcome-srku-campus.jpeg');

$chancellorName = getSetting('chancellor_name', 'Mrs. Janak Kapoor');
$chancellorTitle = getSetting('chancellor_title', 'Chancellor');
$chancellorPhoto = getSetting('chancellor_photo', 'assets/uploads/2026/08/chancellor.jpeg');
$chancellorHeading = getSetting('chancellor_heading', 'A Legacy of Excellence, A Vision for Tomorrow');
$chancellorMsg = getSetting('chancellor_msg', 'It is a matter of great joy that the notification for the establishment of Sarvepalli Radhakrishnan University, Bhopal, has been issued by the State Government.');
$chancellorMsg2 = getSetting('chancellor_msg2', "In order to maintain quality in the field of higher education in the state, it is an important responsibility of private universities, alongside government universities, to bring about change in research and exploration. It is hoped that Sarvepalli Radhakrishnan University will, in the future, deliver unprecedented performance on quality standards and establish itself as the state's foremost institution of education.");
$chancellorMsgHindi = getSetting('chancellor_msg_hindi', 'यह अत्यंत हर्ष का विषय है कि सर्वपल्ली राधाकृष्णन विश्वविद्यालय भोपाल की स्थापना की अधिसूचना राज्य शासन द्वारा जारी की गई है। प्रदेश में उच्च शिक्षा के क्षेत्र में गुणवत्ता बनाये रखने हेतु शासकीय विश्वविद्यालय के साथ-साथ निजी विश्वविद्यालय की भी अहम जिम्मेदारी है कि रिसर्च और अन्वेषण में परिवर्तन लावें। आशा है कि सर्वपल्ली राधाकृष्णन विश्वविद्यालय भविष्य में गुणवत्ता के पैमाने पर अभूतपूर्व प्रदर्शन कर, राज्य के सर्वश्रेष्ठ शिक्षा संस्थान के रूप में अपना स्थान बना सकेगा।');
$chancellorFullPage = getSetting('chancellor_full_page_msg', '');

$vcName = getSetting('vc_name', 'Ms. Priyanka Jaiswal');
$vcTitle = getSetting('vc_title', 'Vice Chancellor');
$vcPhoto = getSetting('vc_photo', '');
if (strpos($vcPhoto, 'ruchichaubey') !== false) { $vcPhoto = ''; }
$vcEmail = getSetting('vc_email', 'vc@srku.edu.in');
$vcGoals = getSetting('vc_goals', "Choice Based Credit System (CBCS)\nIndustry-Integrated Curriculum & Internships\nInterdisciplinary Research Publications\nGlobal Academic Partnerships & MOUs");
$vcHeading = getSetting('vc_heading', 'Empowering Minds for a Knowledge Economy');
$vcSalutation = getSetting('vc_salutation', 'Dear Students, Scholars, Faculty Colleagues, and Visitors,');
$vcMsg = getSetting('vc_msg', 'It is my distinct honor and privilege to welcome you to Sarvepalli Radhakrishnan University (SRKU), Bhopal. As Vice Chancellor, my primary commitment is to create an inspiring, inclusive, and forward-looking academic ecosystem where intellectual rigor meets societal responsibility.');
$vcMsg2 = getSetting('vc_msg2', 'Higher education today is experiencing unprecedented transformation. The rapid advancements in Artificial Intelligence, medical biotechnology, renewable energy, smart manufacturing, and digital jurisprudence require universities to reinvent their pedagogical frameworks. At SRKU, our curriculum is strictly benchmarked with National Education Policy (NEP) guidelines and continuously updated in consultation with apex academic bodies and Fortune 500 industry leaders.');
$vcMsg3 = getSetting('vc_msg3', 'Our 1,000+ distinguished faculty members—including experienced professors, medical surgeons, scientists, and legal scholars—serve not just as teachers, but as dedicated mentors who nurture the unique talents of each individual student. Through continuous faculty development and active research initiatives, we maintain the highest standards of academic delivery.');
$vcMsg4 = getSetting('vc_msg4', 'To all our learners: SRKU is your canvas. Strive for excellence, question conventional thinking, embrace multidisciplinary perspectives, and lead with empathy. Together, let us contribute meaningfully to the advancement of knowledge, human welfare, and the nation.');
$vcFullPage = getSetting('vc_full_page_msg', '');
?>

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h3 class="h4 fw-bold text-navy mb-1"><i class="fas fa-home text-danger me-2"></i> Homepage &amp; Leadership Manager</h3>
        <p class="text-muted small mb-0">Control Homepage Hero Video, Stats Strip, Welcome Section, Chancellor Desk, and VC Messages.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?php echo BASE_URL; ?>" target="_blank" class="btn btn-sm btn-outline-danger px-3 rounded-pill shadow-sm">
            <i class="fas fa-external-link-alt me-1"></i> Preview Homepage
        </a>
        <a href="<?php echo BASE_URL; ?>chancellor-message.php" target="_blank" class="btn btn-sm btn-outline-dark px-3 rounded-pill shadow-sm">
            <i class="fas fa-crown me-1 text-warning"></i> Chancellor Page
        </a>
        <a href="<?php echo BASE_URL; ?>vice-chancellor-message.php" target="_blank" class="btn btn-sm btn-outline-primary px-3 rounded-pill shadow-sm">
            <i class="fas fa-user-tie me-1"></i> VC Page
        </a>
    </div>
</div>

<!-- Section Navigation Tabs -->
<div class="card border-0 shadow-sm rounded-4 p-2 mb-4 bg-white">
    <div class="srku-filter-row">
        <a href="manage_homepage.php?tab=hero" class="srku-filter-btn <?php echo $tab === 'hero' ? 'active' : ''; ?>">
            <i class="fas fa-video"></i> 1. Hero Video
        </a>
        <a href="manage_homepage.php?tab=welcome" class="srku-filter-btn <?php echo $tab === 'welcome' ? 'active' : ''; ?>">
            <i class="fas fa-university"></i> 2. Welcome Section
        </a>
        <a href="manage_homepage.php?tab=stats" class="srku-filter-btn <?php echo $tab === 'stats' ? 'active' : ''; ?>">
            <i class="fas fa-chart-pie"></i> 3. Stats Strip
        </a>
        <a href="manage_homepage.php?tab=chancellor" class="srku-filter-btn <?php echo $tab === 'chancellor' ? 'active' : ''; ?>">
            <i class="fas fa-crown text-warning"></i> 4. Chancellor Desk
        </a>
        <a href="manage_homepage.php?tab=vc" class="srku-filter-btn <?php echo $tab === 'vc' ? 'active' : ''; ?>">
            <i class="fas fa-user-tie text-primary"></i> 5. Vice Chancellor Desk
        </a>
    </div>
</div>

<form action="manage_homepage.php?tab=<?php echo urlencode($tab); ?>" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="save_homepage_sections" value="1">

    <!-- TAB 1: HERO VIDEO & FALLBACK -->
    <?php if ($tab === 'hero'): ?>
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-4 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom flex-wrap gap-2">
                <div class="d-flex align-items-center gap-3">
                    <div class="p-3 rounded-circle bg-danger-subtle text-danger" style="font-size: 1.3rem;">
                        <i class="fas fa-video"></i>
                    </div>
                    <div>
                        <span class="badge bg-danger text-white px-3 py-1 rounded-pill small fw-bold">Section 1</span>
                        <h4 class="fw-bold text-navy mb-0 mt-1">Homepage Hero Video &amp; Fallback Background</h4>
                    </div>
                </div>
            </div>

            <?php
            $availableVideos = getAvailableVideos();
            $resolvedHeroVideo = resolveMediaUrl($heroVideo, 'assets/images/concept2-hero.mp4');
            $resolvedHeroPoster = resolveMediaUrl($heroFallback, 'assets/uploads/2026/08/srku-rkdf-building.jpeg');
            ?>
            <div class="row g-4 align-items-start">
                <!-- Preview Player -->
                <div class="col-12 col-lg-5">
                    <div class="p-3 rounded-4 bg-dark text-white shadow-sm">
                        <div class="d-flex justify-content-between align-items-center mb-2 px-1">
                            <span class="small fw-bold text-warning"><i class="fas fa-play-circle me-1"></i> Live Video Preview</span>
                            <span class="badge bg-success text-white small" id="videoStatusBadge">Ready &amp; Active</span>
                        </div>
                        
                        <div class="position-relative rounded-3 overflow-hidden" style="min-height: 220px; background: #000;">
                            <video id="adminHeroPreview" class="w-100 h-100 object-fit-cover" controls autoplay muted loop playsinline 
                                   poster="<?php echo $resolvedHeroPoster; ?>">
                                <source id="adminHeroPreviewSrc" src="<?php echo $resolvedHeroVideo; ?>" type="video/mp4">
                            </video>
                        </div>

                        <div class="mt-3 pt-2 border-top border-secondary small text-white-50">
                            <div class="text-truncate mb-1"><i class="fas fa-film text-info me-1"></i> <strong>Current Video:</strong> <span id="currentVideoLabel" class="text-white"><?php echo sanitize($heroVideo); ?></span></div>
                            <div class="text-truncate"><i class="fas fa-image text-success me-1"></i> <strong>Resolved URL:</strong> <span class="text-warning small"><?php echo $resolvedHeroVideo; ?></span></div>
                        </div>
                    </div>

                    <div class="mt-3 p-3 rounded-4 bg-light border">
                        <span class="small fw-bold text-navy d-block mb-2"><i class="fas fa-shield-alt text-success me-1"></i> Fallback Image Preview</span>
                        <div class="rounded-3 overflow-hidden" style="height: 110px;">
                            <img id="adminPosterPreview" src="<?php echo $resolvedHeroPoster; ?>" 
                                 onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/08/srku-rkdf-building.jpeg';"
                                 alt="Fallback Poster" class="w-100 h-100 object-fit-cover">
                        </div>
                    </div>
                </div>

                <!-- Inputs -->
                <div class="col-12 col-lg-7">
                    <!-- Video URL/Upload -->
                    <div class="mb-4 p-3 rounded-3 bg-light border">
                        <h6 class="fw-bold text-navy mb-2"><i class="fas fa-film text-danger me-1"></i> 1. Hero Background Video</h6>
                        
                        <!-- Quick Pick Existing Video -->
                        <?php if (!empty($availableVideos)): ?>
                        <div class="mb-2">
                            <label class="form-label small fw-bold text-dark mb-1"><i class="fas fa-list text-primary me-1"></i> Quick Select from Server Videos</label>
                            <select id="quickVideoPicker" class="form-select form-select-sm mb-2" onchange="onQuickVideoSelect(this)">
                                <option value="">-- Choose an Existing Campus Video --</option>
                                <?php foreach ($availableVideos as $v): ?>
                                    <option value="<?php echo sanitize($v['path']); ?>" <?php echo ($heroVideo === $v['path'] || $heroVideo === $v['name'] || stripos($heroVideo, $v['name']) !== false) ? 'selected' : ''; ?>>
                                        <?php echo sanitize($v['label']); ?> (<?php echo sanitize($v['size']); ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <?php endif; ?>

                        <div class="row g-2">
                            <div class="col-12 col-md-7">
                                <label class="form-label small text-muted mb-1">Video Relative Path or URL</label>
                                <input type="text" id="heroVideoInput" name="hero_video_url" class="form-control form-control-sm" value="<?php echo sanitize($heroVideo); ?>" placeholder="assets/images/concept2-hero.mp4" oninput="onVideoInputManual(this.value)">
                                <div class="form-text text-muted" style="font-size: 0.75rem;">Example: <code>assets/images/concept2-hero.mp4</code> or just filename <code>concept2-hero.mp4</code> (auto-resolved).</div>
                            </div>
                            <div class="col-12 col-md-5">
                                <label class="form-label small text-muted mb-1">OR Upload MP4 Video</label>
                                <input type="file" name="video_file" class="form-control form-control-sm" accept="video/mp4,video/webm">
                            </div>
                        </div>
                    </div>

                    <!-- Fallback Image -->
                    <div class="mb-4 p-3 rounded-3 bg-light border">
                        <h6 class="fw-bold text-navy mb-2"><i class="fas fa-image text-primary me-1"></i> 2. Fallback Poster Image</h6>
                        <div class="row g-2">
                            <div class="col-12 col-md-7">
                                <label class="form-label small text-muted mb-1">Image Relative Path or URL</label>
                                <input type="text" id="heroFallbackInput" name="hero_fallback_image" class="form-control form-control-sm" value="<?php echo sanitize($heroFallback); ?>" oninput="onPosterInputManual(this.value)">
                            </div>
                            <div class="col-12 col-md-5">
                                <label class="form-label small text-muted mb-1">OR Upload Poster</label>
                                <input type="file" name="fallback_img_file" class="form-control form-control-sm" accept="image/*">
                            </div>
                        </div>
                    </div>

                    <!-- Hero Text Overlays -->
                    <div class="row g-2 mb-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold text-navy mb-1">Hero Main Title</label>
                            <input type="text" name="hero_title" class="form-control form-control-sm" value="<?php echo sanitize($heroTitle); ?>">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold text-navy mb-1">Hero Golden Subtitle</label>
                            <input type="text" name="hero_subtitle" class="form-control form-control-sm" value="<?php echo sanitize($heroSubtitle); ?>">
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold text-navy mb-1">Hero Lead Description</label>
                            <textarea name="hero_desc" class="form-control form-control-sm" rows="2"><?php echo sanitize($heroDesc); ?></textarea>
                        </div>
                    </div>

                    <div class="text-end pt-2">
                        <button type="submit" class="btn btn-danger px-4 py-2 rounded-pill fw-bold shadow-sm">
                            <i class="fas fa-save me-1"></i> Save Hero Section
                        </button>
                    </div>
                </div>
            </div>

            <script>
            function onQuickVideoSelect(selectEl) {
                var val = selectEl.value;
                if (!val) return;
                var input = document.getElementById('heroVideoInput');
                input.value = val;
                updateVideoPreview(val);
            }

            function onVideoInputManual(val) {
                updateVideoPreview(val);
            }

            function updateVideoPreview(val) {
                if (!val) return;
                var baseUrl = '<?php echo BASE_URL; ?>';
                var finalUrl = val;
                if (!val.startsWith('http://') && !val.startsWith('https://')) {
                    var clean = val.replace(/^\/+/, '');
                    if (!clean.startsWith('assets/')) {
                        clean = 'assets/images/' + clean;
                    }
                    finalUrl = baseUrl + clean;
                }
                var vid = document.getElementById('adminHeroPreview');
                var src = document.getElementById('adminHeroPreviewSrc');
                if (vid && src) {
                    src.src = finalUrl;
                    vid.load();
                    vid.play().catch(function(){});
                }
                var lbl = document.getElementById('currentVideoLabel');
                if (lbl) lbl.textContent = val;
            }

            function onPosterInputManual(val) {
                if (!val) return;
                var baseUrl = '<?php echo BASE_URL; ?>';
                var finalUrl = (val.startsWith('http://') || val.startsWith('https://')) ? val : baseUrl + val.replace(/^\/+/, '');
                var img = document.getElementById('adminPosterPreview');
                if (img) img.src = finalUrl;
                var vid = document.getElementById('adminHeroPreview');
                if (vid) vid.poster = finalUrl;
            }
            </script>
        </div>
    <?php endif; ?>

    <!-- TAB 2: WELCOME SECTION -->
    <?php if ($tab === 'welcome'): ?>
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-4 bg-white">
            <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom">
                <div class="p-3 rounded-circle bg-danger-subtle text-danger" style="font-size: 1.3rem;">
                    <i class="fas fa-university"></i>
                </div>
                <div>
                    <span class="badge bg-danger text-white px-3 py-1 rounded-pill small fw-bold">Section 2</span>
                    <h4 class="fw-bold text-navy mb-0 mt-1">Homepage Welcome Section (Top Overview)</h4>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-12 col-lg-8">
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold text-navy mb-1">Section Subtitle / Eyebrow</label>
                            <input type="text" name="welcome_subtitle" class="form-control" value="<?php echo sanitize($welcomeSubtitle); ?>">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold text-navy mb-1">Main Heading</label>
                            <input type="text" name="welcome_title" class="form-control" value="<?php echo sanitize($welcomeTitle); ?>">
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold text-navy mb-1">Paragraph 1 (Bold Highlight)</label>
                            <textarea name="welcome_body_1" class="form-control" rows="3"><?php echo sanitize($welcomeBody1); ?></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold text-navy mb-1">Paragraph 2 (Historical Context &amp; RKDF Legacy)</label>
                            <textarea name="welcome_body_2" class="form-control" rows="4"><?php echo sanitize($welcomeBody2); ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-4">
                    <div class="p-3 bg-light rounded-4 border">
                        <label class="form-label small fw-bold text-navy mb-2"><i class="fas fa-image text-danger me-1"></i> Welcome Campus Image</label>
                        <div class="rounded-3 overflow-hidden mb-2" style="height: 180px;">
                            <img src="<?php echo (strpos($welcomePhoto, 'http') === 0) ? $welcomePhoto : BASE_URL . $welcomePhoto; ?>" 
                                 onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/08/welcome-srku-campus.jpeg';"
                                 alt="Welcome Image" class="w-100 h-100 object-fit-cover">
                        </div>
                        <input type="text" name="welcome_photo" class="form-control form-control-sm mb-2" value="<?php echo sanitize($welcomePhoto); ?>">
                        <input type="file" name="welcome_photo_file" class="form-control form-control-sm" accept="image/*">
                    </div>
                </div>
            </div>

            <div class="text-end pt-4 mt-3 border-top">
                <button type="submit" class="btn btn-danger px-4 py-2 rounded-pill fw-bold shadow-sm">
                    <i class="fas fa-save me-1"></i> Save Welcome Section
                </button>
            </div>
        </div>
    <?php endif; ?>

    <!-- TAB 3: KEY STATS STRIP -->
    <?php if ($tab === 'stats'): ?>
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-4 bg-white">
            <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom">
                <div class="p-3 rounded-circle bg-warning-subtle text-warning" style="font-size: 1.3rem;">
                    <i class="fas fa-chart-pie"></i>
                </div>
                <div>
                    <span class="badge bg-warning text-dark px-3 py-1 rounded-pill small fw-bold">Section 3</span>
                    <h4 class="fw-bold text-navy mb-0 mt-1">Homepage Key Stats Strip Numbers</h4>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="p-3 bg-light rounded-4 border text-center">
                        <label class="form-label fw-bold text-navy small mb-1"><i class="fas fa-microscope text-danger me-1"></i> High-Tech Labs</label>
                        <input type="text" name="total_labs" class="form-control text-center fw-bold fs-5 text-danger" value="<?php echo sanitize($totalLabs); ?>">
                        <small class="text-muted">Displayed under Hero</small>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-3">
                    <div class="p-3 bg-light rounded-4 border text-center">
                        <label class="form-label fw-bold text-navy small mb-1"><i class="fas fa-chart-line text-success me-1"></i> Placement Record</label>
                        <input type="text" name="placement_record" class="form-control text-center fw-bold fs-5 text-success" value="<?php echo sanitize($placementRecord); ?>">
                        <small class="text-muted">Placement % Rate</small>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-3">
                    <div class="p-3 bg-light rounded-4 border text-center">
                        <label class="form-label fw-bold text-navy small mb-1"><i class="fas fa-handshake text-primary me-1"></i> Corporate Recruiters</label>
                        <input type="text" name="recruiting_partners" class="form-control text-center fw-bold fs-5 text-primary" value="<?php echo sanitize($recruitingPartners); ?>">
                        <small class="text-muted">Hiring Partners</small>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-3">
                    <div class="p-3 bg-light rounded-4 border text-center">
                        <label class="form-label fw-bold text-navy small mb-1"><i class="fas fa-user-graduate text-info me-1"></i> Global Alumni</label>
                        <input type="text" name="total_alumni" class="form-control text-center fw-bold fs-5 text-info" value="<?php echo sanitize($totalAlumni); ?>">
                        <small class="text-muted">Alumni Base</small>
                    </div>
                </div>
            </div>

            <div class="text-end pt-4 mt-3 border-top">
                <button type="submit" class="btn btn-danger px-4 py-2 rounded-pill fw-bold shadow-sm">
                    <i class="fas fa-save me-1"></i> Save Stats Strip
                </button>
            </div>
        </div>
    <?php endif; ?>

    <!-- TAB 4: CHANCELLOR DESK (HOMEPAGE + FULL PAGE) -->
    <?php if ($tab === 'chancellor'): ?>
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-4 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom flex-wrap gap-2">
                <div class="d-flex align-items-center gap-3">
                    <div class="p-3 rounded-circle bg-danger-subtle text-danger" style="font-size: 1.3rem;">
                        <i class="fas fa-crown text-warning"></i>
                    </div>
                    <div>
                        <span class="badge bg-danger text-white px-3 py-1 rounded-pill small fw-bold">Section 4</span>
                        <h4 class="fw-bold text-navy mb-0 mt-1">Chancellor's Desk (Homepage &amp; Chancellor Message Page)</h4>
                    </div>
                </div>
                <a href="<?php echo BASE_URL; ?>chancellor-message.php" target="_blank" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                    <i class="fas fa-external-link-alt me-1"></i> View Full Chancellor Page
                </a>
            </div>

            <div class="row g-4">
                
                <!-- Left: Photo Uploader & Profile -->
                <div class="col-12 col-lg-4">
                    <div class="p-3 bg-light rounded-4 border text-center">
                        <label class="form-label small fw-bold text-navy mb-2"><i class="fas fa-portrait text-danger me-1"></i> Chancellor Official Portrait</label>
                        <div class="mx-auto rounded-3 overflow-hidden mb-3 shadow-sm bg-white p-1" style="width: 200px; height: 230px;">
                            <img src="<?php echo (strpos($chancellorPhoto, 'http') === 0) ? $chancellorPhoto : BASE_URL . $chancellorPhoto; ?>" 
                                 onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/08/chancellor.jpeg';"
                                 alt="Chancellor Photo" class="w-100 h-100 rounded-2" style="object-fit: cover; object-position: top center;">
                        </div>
                        <input type="text" name="chancellor_photo" class="form-control form-control-sm mb-2" value="<?php echo sanitize($chancellorPhoto); ?>">
                        <input type="file" name="chancellor_photo_file" class="form-control form-control-sm" accept="image/*">
                        <small class="text-muted d-block mt-1">Upload high-res portrait (WebP/JPG/PNG).</small>
                    </div>

                    <div class="mt-3 p-3 bg-light rounded-4 border">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-navy mb-1">Chancellor Full Name</label>
                            <input type="text" name="chancellor_name" class="form-control form-control-sm" value="<?php echo sanitize($chancellorName); ?>">
                        </div>
                        <div>
                            <label class="form-label small fw-bold text-navy mb-1">Official Designation</label>
                            <input type="text" name="chancellor_title" class="form-control form-control-sm" value="<?php echo sanitize($chancellorTitle); ?>">
                        </div>
                    </div>
                </div>

                <!-- Right: Homepage Section Content -->
                <div class="col-12 col-lg-8">
                    
                    <!-- 1. Homepage Section Heading -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-navy mb-1">Homepage Section Main Title</label>
                        <input type="text" name="chancellor_heading" class="form-control" value="<?php echo sanitize($chancellorHeading); ?>">
                    </div>

                    <!-- 2. Highlight Quote Box -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-navy mb-1">
                            <i class="fas fa-quote-left text-danger me-1"></i> Homepage Highlight Box Text (Bold Callout)
                        </label>
                        <textarea name="chancellor_msg" class="form-control" rows="3"><?php echo sanitize($chancellorMsg); ?></textarea>
                        <small class="text-muted">Appears in the bordered highlight card on the homepage.</small>
                    </div>

                    <!-- 3. Main Extended Paragraph -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-navy mb-1">
                            <i class="fas fa-paragraph text-primary me-1"></i> Homepage Main Paragraph Body
                        </label>
                        <textarea name="chancellor_msg2" class="form-control" rows="4"><?php echo sanitize($chancellorMsg2); ?></textarea>
                        <small class="text-muted">Appears under the highlight box on the homepage.</small>
                    </div>

                    <!-- 4. Original Hindi Address (मूल संदेश) -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-navy mb-1">
                            <i class="fas fa-language text-danger me-1"></i> Original Hindi Message (मूल संदेश - Chancellor's Page)
                        </label>
                        <textarea name="chancellor_msg_hindi" class="form-control" rows="4"><?php echo sanitize($chancellorMsgHindi); ?></textarea>
                        <small class="text-muted">Appears in the &ldquo;Original Address &bull; मूल संदेश&rdquo; card on the Chancellor's Message page.</small>
                    </div>

                    <div class="text-end pt-3 border-top mt-4">
                        <button type="submit" class="btn btn-danger px-4 py-2 rounded-pill fw-bold shadow-sm">
                            <i class="fas fa-save me-1"></i> Save Chancellor Settings
                        </button>
                    </div>

                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- TAB 5: VICE CHANCELLOR DESK (HOMEPAGE + FULL PAGE) -->
    <?php if ($tab === 'vc'): ?>
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-4 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom flex-wrap gap-2">
                <div class="d-flex align-items-center gap-3">
                    <div class="p-3 rounded-circle bg-primary-subtle text-primary" style="font-size: 1.3rem;">
                        <i class="fas fa-user-tie text-primary"></i>
                    </div>
                    <div>
                        <span class="badge bg-primary text-white px-3 py-1 rounded-pill small fw-bold">Section 5</span>
                        <h4 class="fw-bold text-navy mb-0 mt-1">Vice Chancellor's Desk (Homepage &amp; VC Message Page)</h4>
                    </div>
                </div>
                <a href="<?php echo BASE_URL; ?>vice-chancellor-message.php" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                    <i class="fas fa-external-link-alt me-1"></i> View Full VC Page
                </a>
            </div>

            <div class="row g-4">
                
                <!-- Left: Photo Uploader & Profile -->
                <div class="col-12 col-lg-4">
                    <div class="p-3 bg-light rounded-4 border text-center">
                        <label class="form-label small fw-bold text-navy mb-2"><i class="fas fa-portrait text-primary me-1"></i> Vice Chancellor Official Photo</label>
                        <div class="mx-auto rounded-3 overflow-hidden mb-3 shadow-sm bg-white p-1" style="width: 200px; height: 230px;">
                            <?php if (!empty($vcPhoto) && strpos($vcPhoto, 'ruchichaubey') === false): ?>
                                <img src="<?php echo (strpos($vcPhoto, 'http') === 0) ? $vcPhoto : BASE_URL . $vcPhoto; ?>" 
                                     alt="VC Photo" class="w-100 h-100 rounded-2" style="object-fit: cover; object-position: top center;">
                            <?php else: ?>
                                <div class="w-100 h-100 rounded-2 bg-light d-flex flex-column align-items-center justify-content-center text-muted">
                                    <i class="fas fa-user-graduate text-primary mb-2" style="font-size: 3rem;"></i>
                                    <small class="fw-bold text-dark" style="font-size: 0.78rem;">Academic Avatar Active</small>
                                    <span class="text-muted" style="font-size: 0.68rem;">(No photo uploaded)</span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <input type="text" name="vc_photo" class="form-control form-control-sm mb-2" value="<?php echo sanitize($vcPhoto); ?>" placeholder="Enter photo path or leave empty">
                        <input type="file" name="vc_photo_file" class="form-control form-control-sm" accept="image/*">
                        <small class="text-muted d-block mt-1">Upload portrait image when available (WebP/JPG/PNG).</small>
                    </div>

                    <div class="mt-3 p-3 bg-light rounded-4 border">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-navy mb-1">Vice Chancellor Name</label>
                            <input type="text" name="vc_name" class="form-control form-control-sm" value="<?php echo sanitize($vcName); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-navy mb-1">Official Designation</label>
                            <input type="text" name="vc_title" class="form-control form-control-sm" value="<?php echo sanitize($vcTitle); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-navy mb-1">
                                <i class="fas fa-envelope text-primary me-1"></i> Official Email
                            </label>
                            <input type="text" name="vc_email" class="form-control form-control-sm" value="<?php echo sanitize($vcEmail); ?>" placeholder="vc@srku.edu.in">
                        </div>
                        <div>
                            <label class="form-label small fw-bold text-navy mb-1">
                                <i class="fas fa-check-circle text-primary me-1"></i> Academic Strategic Goals
                            </label>
                            <textarea name="vc_goals" class="form-control form-control-sm" rows="4" placeholder="One goal per line"><?php echo sanitize($vcGoals); ?></textarea>
                            <small class="text-muted" style="font-size:0.75rem;">Enter one goal per line for the left sidebar.</small>
                        </div>
                    </div>
                </div>

                <!-- Right: Section Content -->
                <div class="col-12 col-lg-8">
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-navy mb-1">VC Section &amp; Page Main Title</label>
                        <input type="text" name="vc_heading" class="form-control" value="<?php echo sanitize($vcHeading); ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-navy mb-1">
                            <i class="fas fa-handshake text-secondary me-1"></i> Welcome Salutation
                        </label>
                        <input type="text" name="vc_salutation" class="form-control" value="<?php echo sanitize($vcSalutation); ?>" placeholder="Dear Students, Scholars, Faculty Colleagues, and Visitors,">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-navy mb-1">
                            <i class="fas fa-quote-left text-primary me-1"></i> Paragraph 1: Welcome &amp; Primary Academic Commitment
                        </label>
                        <textarea name="vc_msg" class="form-control" rows="3"><?php echo sanitize($vcMsg); ?></textarea>
                        <small class="text-muted">Appears in the opening highlight paragraph.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-navy mb-1">
                            <i class="fas fa-graduation-cap text-info me-1"></i> Paragraph 2: NEP 2020 &amp; Higher Education Vision
                        </label>
                        <textarea name="vc_msg2" class="form-control" rows="4"><?php echo sanitize($vcMsg2); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-navy mb-1">
                            <i class="fas fa-chalkboard-teacher text-success me-1"></i> Paragraph 3: Faculty Mentorship &amp; Research Culture
                        </label>
                        <textarea name="vc_msg3" class="form-control" rows="3"><?php echo sanitize($vcMsg3); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-navy mb-1">
                            <i class="fas fa-bullhorn text-warning me-1"></i> Paragraph 4: Concluding Call to Learners
                        </label>
                        <textarea name="vc_msg4" class="form-control" rows="3"><?php echo sanitize($vcMsg4); ?></textarea>
                    </div>

                    <div class="text-end pt-3 border-top mt-4">
                        <button type="submit" class="btn btn-primary px-4 py-2 rounded-pill fw-bold shadow-sm">
                            <i class="fas fa-save me-1"></i> Save VC Settings
                        </button>
                    </div>

                </div>
            </div>
        </div>
    <?php endif; ?>

</form>

<?php require_once __DIR__ . '/footer.php'; ?>
