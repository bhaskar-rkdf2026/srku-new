<?php
require_once __DIR__ . '/header.php';
$pdo = getDBConnection();

// Active Tab
$tab = sanitize($_GET['tab'] ?? 'hero');

// Handle Save Homepage Sections (Tab-scoped so saving one tab never overwrites another)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_homepage_sections'])) {
    $submittedTab = sanitize($_POST['section_tab'] ?? $_GET['tab'] ?? $tab ?? 'hero');
    
    $uploadDir = __DIR__ . '/../assets/uploads/2026/08/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

    $settingsToSave = [];

    if ($submittedTab === 'hero') {
        $heroVideo = normalizeMediaPath($_POST['hero_video_url'] ?? '', 'https://vimeo.com/1231542657?share=copy&fl=sv&fe=ci');
        $heroFallback = normalizeMediaPath($_POST['hero_fallback_image'] ?? '', 'assets/uploads/2026/08/srku-rkdf-building.jpeg');

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

        $settingsToSave = [
            'hero_title' => sanitize($_POST['hero_title'] ?? 'SRK University, Bhopal'),
            'hero_subtitle' => sanitize($_POST['hero_subtitle'] ?? 'UGC-Recognized University in MP'),
            'hero_desc' => $_POST['hero_desc'] ?? '',
            'hero_video_url' => $heroVideo,
            'hero_fallback_image' => $heroFallback,
        ];
    } elseif ($submittedTab === 'welcome') {
        $welcomePhoto = normalizeMediaPath($_POST['welcome_photo'] ?? '', 'assets/uploads/2026/08/welcome-srku-campus.jpeg');
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
            'welcome_subtitle' => sanitize($_POST['welcome_subtitle'] ?? 'WELCOME TO SRK UNIVERSITY'),
            'welcome_title' => sanitize($_POST['welcome_title'] ?? 'Committed Towards Your Better Future Through Academic Excellence'),
            'welcome_body_1' => $_POST['welcome_body_1'] ?? '',
            'welcome_body_2' => $_POST['welcome_body_2'] ?? '',
            'welcome_photo' => $welcomePhoto,
        ];
    } elseif ($submittedTab === 'stats') {
        $settingsToSave = [
            'stat_years' => sanitize($_POST['stat_years'] ?? '31st'),
            'stat_placements' => sanitize($_POST['stat_placements'] ?? '35,000+'),
            'stat_alumni' => sanitize($_POST['stat_alumni'] ?? '1,10,000+'),
            'stat_faculty' => sanitize($_POST['stat_faculty'] ?? '1,000+'),
            'recruiting_partners' => sanitize($_POST['recruiting_partners'] ?? '300+'),
            'total_labs' => sanitize($_POST['total_labs'] ?? '42+'),
            'placement_record' => sanitize($_POST['placement_record'] ?? '94%'),
            'total_alumni' => sanitize($_POST['stat_alumni'] ?? '1,10,000+'),
        ];
        if (isset($_POST['ticker_text'])) {
            $settingsToSave['ticker_text'] = sanitize($_POST['ticker_text']);
        }
        if (isset($_POST['highest_package'])) {
            $settingsToSave['highest_package'] = sanitize($_POST['highest_package']);
        }
    } elseif ($submittedTab === 'chancellor') {
        $chancellorPhoto = normalizeMediaPath($_POST['chancellor_photo'] ?? '', 'assets/uploads/2026/08/chancellor.jpeg');
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

        $settingsToSave = [
            'chancellor_name' => sanitize($_POST['chancellor_name'] ?? 'Mrs. Janak Kapoor'),
            'chancellor_title' => sanitize($_POST['chancellor_title'] ?? 'Chancellor'),
            'chancellor_photo' => $chancellorPhoto,
            'chancellor_heading' => sanitize($_POST['chancellor_heading'] ?? 'A Legacy of Excellence, A Vision for Tomorrow'),
            'chancellor_msg' => $_POST['chancellor_msg'] ?? '',
            'chancellor_msg2' => $_POST['chancellor_msg2'] ?? '',
            'chancellor_msg_hindi' => $_POST['chancellor_msg_hindi'] ?? '',
            'chancellor_full_page_msg' => $_POST['chancellor_full_page_msg'] ?? '',
        ];
    } elseif ($submittedTab === 'vc') {
        $vcPhoto = normalizeMediaPath($_POST['vc_photo'] ?? '', 'assets/uploads/2026/07/ruchichaubey.webp');
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

        $settingsToSave = [
            'vc_name' => sanitize($_POST['vc_name'] ?? 'Dr. Priyanka Jaiswal'),
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
            'vc_full_page_msg' => $_POST['vc_full_page_msg'] ?? '',
        ];
    } elseif ($submittedTab === 'popup') {
        $popupImage = normalizeMediaPath($_POST['popup_event_image'] ?? '', 'assets/images/news4.jpg');
        if (isset($_FILES['popup_image_file']) && $_FILES['popup_image_file']['error'] === UPLOAD_ERR_OK) {
            $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
            $ext = strtolower(pathinfo($_FILES['popup_image_file']['name'], PATHINFO_EXTENSION));
            if (in_array($ext, $allowed)) {
                $fn = 'popup_event_' . time() . '.' . $ext;
                if (move_uploaded_file($_FILES['popup_image_file']['tmp_name'], $uploadDir . $fn)) {
                    $popupImage = 'assets/uploads/2026/08/' . $fn;
                }
            }
        }

        $settingsToSave = [
            'popup_enabled' => (isset($_POST['popup_enabled']) && $_POST['popup_enabled'] === '1') ? '1' : '0',
            'popup_header_title' => sanitize($_POST['popup_header_title'] ?? 'Campus Bulletin & Alerts'),
            'popup_header_subtitle' => sanitize($_POST['popup_header_subtitle'] ?? 'Sarvepalli Radhakrishnan University (SRKU)'),
            'popup_event_title' => sanitize($_POST['popup_event_title'] ?? ''),
            'popup_event_image' => $popupImage,
            'popup_event_link' => sanitize($_POST['popup_event_link'] ?? ''),
            'popup_event_date' => sanitize($_POST['popup_event_date'] ?? date('Y-m-d')),
            'popup_event_category' => sanitize($_POST['popup_event_category'] ?? 'Campus Life'),
            'popup_delay_sec' => sanitize($_POST['popup_delay_sec'] ?? '1.2'),
            'popup_default_tab' => sanitize($_POST['popup_default_tab'] ?? 'events'),
            'popup_show_once_day' => isset($_POST['popup_show_once_day']) ? '1' : '0'
        ];
    }

    if (!empty($settingsToSave)) {
        foreach ($settingsToSave as $key => $val) {
            $stmt = $pdo->prepare("INSERT INTO settings (setting_key, setting_value) VALUES (:k, :v) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)");
            $stmt->execute([':k' => $key, ':v' => $val]);
        }
    }

    setFlashMsg('success', 'Section settings updated successfully.');
    header("Location: manage_homepage.php?tab=" . urlencode($submittedTab));
    exit;
}

// Current Values
$heroTitle = getSetting('hero_title', 'SRK University, Bhopal');
$heroSubtitle = getSetting('hero_subtitle', 'UGC-Recognized University in MP');
$heroDesc = getSetting('hero_desc', 'Welcome to SRK University, a premier technical and academic ecosystem designed for global industry leadership.');
$heroVideo = getSetting('hero_video_url', 'https://vimeo.com/1231542657?share=copy&fl=sv&fe=ci');
$heroFallback = getSetting('hero_fallback_image', 'assets/uploads/2026/08/srku-rkdf-building.jpeg');

$statYears = getSetting('stat_years', '31st');
$statPlacements = getSetting('stat_placements', '35,000+');
$statAlumni = getSetting('stat_alumni', '1,10,000+');
$statFaculty = getSetting('stat_faculty', '1,000+');
$recruitingPartners = getSetting('recruiting_partners', '300+');
$totalLabs = getSetting('total_labs', '42+');
$placementRecord = getSetting('placement_record', '94%');
$totalAlumni = getSetting('total_alumni', '1,10,000+');

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

$vcName = getSetting('vc_name', 'Dr. Priyanka Jaiswal');
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

// Popup Settings Values
$popupEnabled = getSetting('popup_enabled', '1');
$popupHeaderTitle = getSetting('popup_header_title', 'Campus Bulletin & Alerts');
$popupHeaderSubtitle = getSetting('popup_header_subtitle', 'Sarvepalli Radhakrishnan University (SRKU)');
$popupEventTitle = getSetting('popup_event_title', 'Tarang 2026 - Annual Inter-University Sports & Cultural Fest Announced');
$popupEventImage = getSetting('popup_event_image', 'assets/images/news4.jpg');
$popupEventLink = getSetting('popup_event_link', 'news-detail.php?slug=tarang-annual-fest-2026');
$popupEventDate = getSetting('popup_event_date', '2026-08-15');
$popupEventCategory = getSetting('popup_event_category', 'Campus Life');
$popupDelaySec = getSetting('popup_delay_sec', '1.2');
$popupDefaultTab = getSetting('popup_default_tab', 'events');
$popupShowOnceDay = getSetting('popup_show_once_day', '1');

$recentEventsForPicker = [];
try {
    $stmtPicker = $pdo->query("SELECT id, title, slug, category, publish_date, image_url FROM news ORDER BY publish_date DESC, id DESC LIMIT 25");
    $recentEventsForPicker = $stmtPicker->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {}
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
        <a href="manage_homepage.php?tab=popup" class="srku-filter-btn <?php echo $tab === 'popup' ? 'active' : ''; ?>">
            <i class="fas fa-bullhorn text-danger"></i> 6. Campus Popup &amp; Alerts
        </a>
    </div>
</div>

<form action="manage_homepage.php?tab=<?php echo urlencode($tab); ?>" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="save_homepage_sections" value="1">
    <input type="hidden" name="section_tab" value="<?php echo sanitize($tab); ?>">

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
            $heroVideoParsed = parseVideoUrl($heroVideo);
            $resolvedHeroPoster = resolveMediaUrl($heroFallback, 'assets/uploads/2026/08/srku-rkdf-building.jpeg');
            ?>
            <div class="row g-4 align-items-start">
                <!-- Preview Player -->
                <div class="col-12 col-lg-5">
                    <div class="p-3 rounded-4 bg-dark text-white shadow-sm">
                        <div class="d-flex justify-content-between align-items-center mb-2 px-1">
                            <span class="small fw-bold text-warning"><i class="fas fa-play-circle me-1"></i> Live Video Preview</span>
                            <span class="badge bg-danger text-white small" id="videoStatusBadge">
                                <i class="fas fa-video me-1"></i> <?php echo sanitize($heroVideoParsed['provider']); ?>
                            </span>
                        </div>
                        
                        <!-- Dynamic Preview Container -->
                        <div class="position-relative rounded-3 overflow-hidden" id="adminPreviewContainer" style="min-height: 220px; background: #000;">
                            <?php if ($heroVideoParsed['type'] === 'vimeo'): ?>
                                <iframe id="adminHeroIframe" src="<?php echo $heroVideoParsed['preview_url']; ?>" class="w-100" style="height: 220px; border: 0;" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
                            <?php elseif ($heroVideoParsed['type'] === 'youtube'): ?>
                                <iframe id="adminHeroIframe" src="<?php echo $heroVideoParsed['preview_url']; ?>" class="w-100" style="height: 220px; border: 0;" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope" allowfullscreen></iframe>
                            <?php else: ?>
                                <video id="adminHeroPreview" class="w-100 h-100 object-fit-cover" controls autoplay muted loop playsinline poster="<?php echo $resolvedHeroPoster; ?>">
                                    <source id="adminHeroPreviewSrc" src="<?php echo $heroVideoParsed['src']; ?>" type="video/mp4">
                                </video>
                            <?php endif; ?>
                        </div>

                        <div class="mt-3 pt-2 border-top border-secondary small text-white-50">
                            <div class="text-truncate mb-1"><i class="fas fa-film text-info me-1"></i> <strong>Current Input:</strong> <span id="currentVideoLabel" class="text-white"><?php echo sanitize($heroVideo); ?></span></div>
                            <div class="text-truncate"><i class="fas fa-tag text-success me-1"></i> <strong>Detected Type:</strong> <span id="detectedTypeLabel" class="text-warning small"><?php echo sanitize($heroVideoParsed['provider']); ?></span></div>
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
                        <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap gap-1">
                            <h6 class="fw-bold text-navy mb-0"><i class="fas fa-film text-danger me-1"></i> 1. Hero Background Video URL</h6>
                            <div class="d-flex gap-1">
                                <span class="badge bg-info text-dark small"><i class="fab fa-vimeo-v me-1"></i> Vimeo</span>
                                <span class="badge bg-danger text-white small"><i class="fab fa-youtube me-1"></i> YouTube</span>
                                <span class="badge bg-secondary text-white small"><i class="fas fa-file-video me-1"></i> MP4 / WebM</span>
                            </div>
                        </div>
                        
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
                            <div class="col-12">
                                <label class="form-label small text-muted mb-1">Vimeo Link, YouTube Link, or Video Path</label>
                                <input type="text" id="heroVideoInput" name="hero_video_url" class="form-control form-control-sm" value="<?php echo sanitize($heroVideo); ?>" placeholder="https://vimeo.com/1231542657 or https://youtube.com/watch?v=... or assets/images/hero.mp4" oninput="onVideoInputManual(this.value)">
                                <div class="form-text text-muted" style="font-size: 0.78rem;">
                                    <strong>Supported Formats:</strong>
                                    <ul class="mb-0 ps-3 mt-1 text-secondary">
                                        <li><strong>Vimeo:</strong> <code>https://vimeo.com/1231542657?share=copy</code> or <code>https://vimeo.com/1231542657</code></li>
                                        <li><strong>YouTube:</strong> <code>https://www.youtube.com/watch?v=...</code> or <code>https://youtu.be/...</code></li>
                                        <li><strong>Local MP4:</strong> <code>assets/images/concept2-hero.mp4</code> or upload an MP4 below.</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-12 mt-2">
                                <label class="form-label small text-muted mb-1">OR Upload New MP4 Video File</label>
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
                var container = document.getElementById('adminPreviewContainer');
                var statusBadge = document.getElementById('videoStatusBadge');
                var currentLabel = document.getElementById('currentVideoLabel');
                var detectedLabel = document.getElementById('detectedTypeLabel');

                if (currentLabel) currentLabel.textContent = val;

                // Test Vimeo
                var vimeoMatch = val.match(/(?:vimeo\.com\/(?:video\/|channels\/(?:\w+\/)?|groups\/[^\/]+\/videos\/|album\/\d+\/video\/|))(\d+)/i);
                if (vimeoMatch && vimeoMatch[1]) {
                    var vId = vimeoMatch[1];
                    if (statusBadge) statusBadge.innerHTML = '<i class="fab fa-vimeo-v me-1"></i> Vimeo Video';
                    if (detectedLabel) detectedLabel.textContent = 'Vimeo (ID: ' + vId + ')';
                    if (container) {
                        container.innerHTML = '<iframe src="https://player.vimeo.com/video/' + vId + '?autoplay=1&muted=1&loop=1&autopause=0" class="w-100" style="height: 220px; border: 0;" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>';
                    }
                    return;
                }

                // Test YouTube
                var ytMatch = val.match(/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/|youtube\.com\/shorts\/)([^"&?\/ ]{11})/i);
                if (ytMatch && ytMatch[1]) {
                    var ytId = ytMatch[1];
                    if (statusBadge) statusBadge.innerHTML = '<i class="fab fa-youtube me-1"></i> YouTube Video';
                    if (detectedLabel) detectedLabel.textContent = 'YouTube (ID: ' + ytId + ')';
                    if (container) {
                        container.innerHTML = '<iframe src="https://www.youtube.com/embed/' + ytId + '?autoplay=1&mute=1&loop=1&controls=1" class="w-100" style="height: 220px; border: 0;" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope" allowfullscreen></iframe>';
                    }
                    return;
                }

                // Local MP4
                if (statusBadge) statusBadge.innerHTML = '<i class="fas fa-file-video me-1"></i> Local Video File';
                if (detectedLabel) detectedLabel.textContent = 'Local MP4 File';
                var baseUrl = '<?php echo BASE_URL; ?>';
                var finalUrl = val;
                if (!val.startsWith('http://') && !val.startsWith('https://')) {
                    var clean = val.replace(/^\/+/, '');
                    if (!clean.startsWith('assets/')) {
                        clean = 'assets/images/' + clean;
                    }
                    finalUrl = baseUrl + clean;
                }
                var poster = document.getElementById('adminPosterPreview') ? document.getElementById('adminPosterPreview').src : '';
                if (container) {
                    container.innerHTML = '<video class="w-100 h-100 object-fit-cover" controls autoplay muted loop playsinline poster="' + poster + '"><source src="' + finalUrl + '" type="video/mp4"></video>';
                }
            }

            function onPosterInputManual(val) {
                if (!val) return;
                var baseUrl = '<?php echo BASE_URL; ?>';
                var finalUrl = (val.startsWith('http://') || val.startsWith('https://')) ? val : baseUrl + val.replace(/^\/+/, '');
                var img = document.getElementById('adminPosterPreview');
                if (img) img.src = finalUrl;
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

            <div class="row g-4 mb-4">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="p-3 bg-light rounded-4 border text-center">
                        <label class="form-label fw-bold text-navy small mb-1"><i class="fas fa-award text-warning me-1"></i> Point 1: Years of Excellence</label>
                        <input type="text" name="stat_years" class="form-control text-center fw-bold fs-5 text-warning" value="<?php echo sanitize($statYears); ?>" placeholder="31st">
                        <small class="text-muted">e.g. 31st or 31+</small>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="p-3 bg-light rounded-4 border text-center">
                        <label class="form-label fw-bold text-navy small mb-1"><i class="fas fa-briefcase text-success me-1"></i> Point 2: Placements</label>
                        <input type="text" name="stat_placements" class="form-control text-center fw-bold fs-5 text-success" value="<?php echo sanitize($statPlacements); ?>" placeholder="35,000+">
                        <small class="text-muted">Total Placements achieved</small>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="p-3 bg-light rounded-4 border text-center">
                        <label class="form-label fw-bold text-navy small mb-1"><i class="fas fa-user-graduate text-info me-1"></i> Point 3: Alumni</label>
                        <input type="text" name="stat_alumni" class="form-control text-center fw-bold fs-5 text-info" value="<?php echo sanitize($statAlumni); ?>" placeholder="1,10,000+">
                        <small class="text-muted">Global Alumni network</small>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="p-3 bg-light rounded-4 border text-center">
                        <label class="form-label fw-bold text-navy small mb-1"><i class="fas fa-chalkboard-teacher text-danger me-1"></i> Point 4: Faculty</label>
                        <input type="text" name="stat_faculty" class="form-control text-center fw-bold fs-5 text-danger" value="<?php echo sanitize($statFaculty); ?>" placeholder="1,000+">
                        <small class="text-muted">Expert Faculty members</small>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="p-3 bg-light rounded-4 border text-center">
                        <label class="form-label fw-bold text-navy small mb-1"><i class="fas fa-handshake text-primary me-1"></i> Point 5: Corporate Recruiters</label>
                        <input type="text" name="recruiting_partners" class="form-control text-center fw-bold fs-5 text-primary" value="<?php echo sanitize($recruitingPartners); ?>" placeholder="300+">
                        <small class="text-muted">Hiring Corporate Partners</small>
                    </div>
                </div>
            </div>

            <h5 class="fw-bold text-navy mb-3"><i class="fas fa-layer-group text-danger me-1"></i> Hero Floating Badges</h5>
            <div class="row g-4">
                <div class="col-12 col-md-6">
                    <div class="p-3 bg-light rounded-4 border text-center">
                        <label class="form-label fw-bold text-navy small mb-1"><i class="fas fa-microscope text-danger me-1"></i> High-Tech Labs (Hero Card)</label>
                        <input type="text" name="total_labs" class="form-control text-center fw-bold fs-5 text-danger" value="<?php echo sanitize($totalLabs); ?>">
                        <small class="text-muted">Floating White Card on Hero</small>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="p-3 bg-light rounded-4 border text-center">
                        <label class="form-label fw-bold text-navy small mb-1"><i class="fas fa-chart-line text-success me-1"></i> Placement Record (Hero Card)</label>
                        <input type="text" name="placement_record" class="form-control text-center fw-bold fs-5 text-success" value="<?php echo sanitize($placementRecord); ?>">
                        <small class="text-muted">Floating Red Card on Hero</small>
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

    <!-- TAB 6: CAMPUS POPUP & NOTIFICATIONS MODAL -->
    <?php if ($tab === 'popup'): ?>
    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-4 bg-white">
        <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom flex-wrap gap-2">
            <div class="d-flex align-items-center gap-3">
                <div class="p-3 rounded-circle bg-danger-subtle text-danger" style="font-size: 1.3rem;">
                    <i class="fas fa-bullhorn"></i>
                </div>
                <div>
                    <span class="badge bg-danger text-white px-3 py-1 rounded-pill small fw-bold">Section 6</span>
                    <h4 class="fw-bold text-navy mb-0 mt-1">Campus Bulletin &amp; Alerts Popup Manager</h4>
                </div>
            </div>
            <div>
                <?php if ($popupEnabled === '1'): ?>
                    <span class="badge bg-success bg-opacity-10 text-success border border-success-subtle px-3 py-2 rounded-pill fs-6">
                        <i class="fas fa-check-circle me-1"></i> Status: Active on Website
                    </span>
                <?php else: ?>
                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger-subtle px-3 py-2 rounded-pill fs-6">
                        <i class="fas fa-eye-slash me-1"></i> Status: Disabled (Hidden)
                    </span>
                <?php endif; ?>
            </div>
        </div>

        <style>
        .default-tab-card {
            transition: all 0.22s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .default-tab-card:hover {
            background-color: #ffffff !important;
            border-color: #94a3b8 !important;
            box-shadow: 0 4px 12px rgba(15, 30, 59, 0.06);
            transform: translateY(-1px);
        }
        .status-pill-btn {
            transition: all 0.2s ease;
        }
        .status-pill-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }
        </style>

        <div class="row g-4 align-items-start">
            <!-- Left Column: Live Visual Preview Card -->
            <div class="col-12 col-lg-5">
                <div class="p-3 rounded-4 bg-light border shadow-sm">
                    <div class="d-flex justify-content-between align-items-center mb-2 px-1">
                        <span class="small fw-bold text-navy"><i class="fas fa-eye me-1 text-danger"></i> Live Modal Event Card Preview</span>
                        <span class="badge bg-secondary rounded-pill small" id="previewCategoryBadge">
                            <?php echo sanitize($popupEventCategory ?: 'Campus Life'); ?>
                        </span>
                    </div>

                    <!-- Event Preview Box (Matches Front-End Popup) -->
                    <div class="rounded-3 overflow-hidden shadow-sm border bg-white p-2">
                        <div class="position-relative rounded-3 overflow-hidden mb-2" style="background:#0F1E3B;">
                            <?php 
                            $resolvedPopupImg = resolveMediaUrl($popupEventImage, 'assets/images/news4.jpg');
                            $previewTs = !empty($popupEventDate) ? strtotime($popupEventDate) : time();
                            ?>
                            <img id="adminPopupPosterPreview" 
                                 src="<?php echo $resolvedPopupImg; ?>" 
                                 alt="Event Poster Preview" 
                                 class="w-100 object-fit-cover" 
                                 style="height: 200px; display:block;"
                                 onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/images/news4.jpg';">

                            <!-- Floating Date Tag -->
                            <div class="position-absolute top-0 start-0 m-2 text-center rounded-2 overflow-hidden shadow" style="min-width:38px; border:1px solid rgba(255,255,255,0.9);">
                                <div id="previewMonthTag" class="bg-danger text-white px-2 py-0.5 fw-bold text-uppercase" style="font-size: 0.6rem; letter-spacing: 0.5px;">
                                    <?php echo strtoupper(date('M', $previewTs)); ?>
                                </div>
                                <div id="previewDayTag" class="bg-white text-dark px-2 py-0.5 fw-bold fs-6 lh-1">
                                    <?php echo date('d', $previewTs); ?>
                                </div>
                            </div>

                            <!-- Category Badge -->
                            <div class="position-absolute top-0 end-0 m-2">
                                <span class="badge bg-dark bg-opacity-75 text-white backdrop-blur rounded-pill px-2 py-1" style="font-size: 0.68rem;">
                                    <i class="fas fa-star text-warning me-1"></i><span id="previewCategoryTag"><?php echo sanitize($popupEventCategory ?: 'Campus Life'); ?></span>
                                </span>
                            </div>
                        </div>

                        <div class="px-1 py-1">
                            <h6 id="previewTitleText" class="fw-bold text-navy mb-2" style="font-size: 0.95rem; line-height: 1.35;">
                                <?php echo sanitize($popupEventTitle ?: 'Event Title'); ?>
                            </h6>
                            <div class="d-flex align-items-center justify-content-between pt-2 border-top">
                                <span class="small text-muted" style="font-size: 0.72rem;">
                                    <i class="far fa-calendar-alt text-danger me-1"></i> Date: <span id="previewDateText"><?php echo date('d M, Y', $previewTs); ?></span>
                                </span>
                                <span class="btn btn-xs btn-danger rounded-pill px-2.5 py-1 fw-bold shadow-xs disabled" style="font-size: 0.75rem;">
                                    <span>View Event Details</span> <i class="fas fa-arrow-right ms-1"></i>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3 p-2.5 rounded-3 bg-white border small text-muted">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <span><i class="fas fa-link text-primary me-1"></i> <strong>Target Redirection:</strong></span>
                            <span class="text-truncate text-navy fw-semibold" id="previewLinkText" style="max-width: 170px;">
                                <?php echo sanitize($popupEventLink); ?>
                            </span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <span><i class="fas fa-clock text-warning me-1"></i> <strong>Delay:</strong> <span id="previewDelayText"><?php echo sanitize($popupDelaySec); ?>s</span></span>
                            <span><i class="fas fa-folder-open text-info me-1"></i> <strong>Default Tab:</strong> <span id="previewDefaultTabText" class="badge bg-primary text-white"><?php echo ($popupDefaultTab === 'notices') ? 'Notices' : (($popupDefaultTab === 'admissions') ? 'Admissions 2026' : 'Events'); ?></span></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Settings & Edit Form -->
            <div class="col-12 col-lg-7">
                
                <!-- 1. Active / Disable Switch -->
                <div class="p-4 mb-4 rounded-4 border <?php echo $popupEnabled === '1' ? 'bg-success-subtle border-success' : 'bg-danger-subtle border-danger'; ?>">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label class="form-label fw-bold text-navy mb-0" style="font-size: 0.98rem;">
                            <i class="fas fa-power-off me-2 <?php echo $popupEnabled === '1' ? 'text-success' : 'text-danger'; ?>"></i> Popup Status (Enable / Disable)
                        </label>
                        <span class="badge <?php echo $popupEnabled === '1' ? 'bg-success' : 'bg-danger'; ?> px-2.5 py-1">
                            <?php echo $popupEnabled === '1' ? 'Active on Website' : 'Disabled'; ?>
                        </span>
                    </div>
                    <p class="small text-muted mb-3">Control whether the alert popup displays automatically when visitors land on the website.</p>
                    <div class="d-flex flex-wrap gap-3">
                        <label class="px-4 py-2.5 rounded-3 border bg-white cursor-pointer d-flex align-items-center gap-2 shadow-xs" for="statusActive" style="cursor: pointer;">
                            <input class="form-check-input m-0" type="radio" name="popup_enabled" id="statusActive" value="1" <?php echo $popupEnabled === '1' ? 'checked' : ''; ?>>
                            <span class="fw-bold text-success small"><i class="fas fa-check-circle me-1"></i> Active (Show on Website)</span>
                        </label>
                        <label class="px-4 py-2.5 rounded-3 border bg-white cursor-pointer d-flex align-items-center gap-2 shadow-xs" for="statusDisabled" style="cursor: pointer;">
                            <input class="form-check-input m-0" type="radio" name="popup_enabled" id="statusDisabled" value="0" <?php echo $popupEnabled !== '1' ? 'checked' : ''; ?>>
                            <span class="fw-bold text-danger small"><i class="fas fa-times-circle me-1"></i> Disabled (Hide from Website)</span>
                        </label>
                    </div>
                </div>

                <!-- 2. Priority Default Open Tab Selector -->
                <div class="p-4 mb-4 rounded-4 bg-white border shadow-sm">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label class="form-label fw-bold text-navy mb-0" style="font-size: 0.98rem;">
                            <i class="fas fa-layer-group text-primary me-2"></i> Default Open Tab (Visitor ko pehle kaun sa tab dikhega?)
                        </label>
                        <span class="badge bg-primary text-white fw-semibold px-2.5 py-1">Priority View</span>
                    </div>
                    <p class="small text-muted mb-3">Choose which content tab opens first by default when visitors open or see the popup modal.</p>
                    
                    <div class="d-flex flex-column gap-2.5">
                        <!-- Option 1: Events Showcase -->
                        <label class="default-tab-card d-flex align-items-center justify-content-between p-3 px-3.5 rounded-3 border cursor-pointer transition-all <?php echo $popupDefaultTab === 'events' ? 'border-primary bg-primary-subtle shadow-xs' : 'bg-light'; ?>" for="defaultTabEvents" style="cursor: pointer;">
                            <div class="d-flex align-items-center gap-3">
                                <input class="form-check-input m-0 flex-shrink-0" type="radio" name="popup_default_tab" id="defaultTabEvents" value="events" <?php echo $popupDefaultTab === 'events' ? 'checked' : ''; ?> onchange="onDefaultTabChanged('events')">
                                <div class="rounded-circle bg-warning-subtle text-warning d-flex align-items-center justify-content-center flex-shrink-0" style="width: 38px; height: 38px;">
                                    <i class="fas fa-calendar-star fs-6"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-navy small">1. Events Showcase</div>
                                    <small class="text-muted d-block" style="font-size: 0.78rem;">Creative Event Poster &amp; Direct Redirection Button</small>
                                </div>
                            </div>
                            <span class="badge bg-warning text-dark px-2.5 py-1 small fw-semibold d-none d-sm-inline-block">Poster View</span>
                        </label>

                        <!-- Option 2: Official Notices -->
                        <label class="default-tab-card d-flex align-items-center justify-content-between p-3 px-3.5 rounded-3 border cursor-pointer transition-all <?php echo $popupDefaultTab === 'notices' ? 'border-primary bg-primary-subtle shadow-xs' : 'bg-light'; ?>" for="defaultTabNotices" style="cursor: pointer;">
                            <div class="d-flex align-items-center gap-3">
                                <input class="form-check-input m-0 flex-shrink-0" type="radio" name="popup_default_tab" id="defaultTabNotices" value="notices" <?php echo $popupDefaultTab === 'notices' ? 'checked' : ''; ?> onchange="onDefaultTabChanged('notices')">
                                <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center flex-shrink-0" style="width: 38px; height: 38px;">
                                    <i class="fas fa-bell fs-6"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-navy small">2. Official Notices</div>
                                    <small class="text-muted d-block" style="font-size: 0.78rem;">University Circulars, Orders &amp; PDF Downloads List</small>
                                </div>
                            </div>
                            <span class="badge bg-primary text-white px-2.5 py-1 small fw-semibold d-none d-sm-inline-block">Notices List</span>
                        </label>

                        <!-- Option 3: Admissions 2026 -->
                        <label class="default-tab-card d-flex align-items-center justify-content-between p-3 px-3.5 rounded-3 border cursor-pointer transition-all <?php echo $popupDefaultTab === 'admissions' ? 'border-primary bg-primary-subtle shadow-xs' : 'bg-light'; ?>" for="defaultTabAdmissions" style="cursor: pointer;">
                            <div class="d-flex align-items-center gap-3">
                                <input class="form-check-input m-0 flex-shrink-0" type="radio" name="popup_default_tab" id="defaultTabAdmissions" value="admissions" <?php echo $popupDefaultTab === 'admissions' ? 'checked' : ''; ?> onchange="onDefaultTabChanged('admissions')">
                                <div class="rounded-circle bg-success-subtle text-success d-flex align-items-center justify-content-center flex-shrink-0" style="width: 38px; height: 38px;">
                                    <i class="fas fa-graduation-cap fs-6"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-navy small">3. Admissions 2026</div>
                                    <small class="text-muted d-block" style="font-size: 0.78rem;">Admissions 2026 Programs, Forms &amp; Prospectus</small>
                                </div>
                            </div>
                            <span class="badge bg-success text-white px-2.5 py-1 small fw-semibold d-none d-sm-inline-block">Admissions View</span>
                        </label>
                    </div>
                </div>

                <!-- 3. Quick Pick from Existing Events -->
                <?php if (!empty($recentEventsForPicker)): ?>
                <div class="mb-3 p-3 rounded-3 bg-light border">
                    <label class="form-label small fw-bold text-navy mb-1">
                        <i class="fas fa-magic text-warning me-1"></i> Quick Select from Existing Events / News
                    </label>
                    <select id="quickEventSelect" class="form-select form-select-sm" onchange="onQuickEventPicked(this)">
                        <option value="">-- Choose an event from database to auto-fill --</option>
                        <?php foreach ($recentEventsForPicker as $ep): 
                            $epSlug = !empty($ep['slug']) ? $ep['slug'] : $ep['id'];
                            $epLink = 'news-detail.php?slug=' . urlencode($epSlug);
                            $epDate = !empty($ep['publish_date']) ? date('Y-m-d', strtotime($ep['publish_date'])) : date('Y-m-d');
                        ?>
                            <option value="<?php echo $ep['id']; ?>"
                                    data-title="<?php echo htmlspecialchars($ep['title'], ENT_QUOTES); ?>"
                                    data-image="<?php echo htmlspecialchars($ep['image_url'] ?? '', ENT_QUOTES); ?>"
                                    data-link="<?php echo htmlspecialchars($epLink, ENT_QUOTES); ?>"
                                    data-date="<?php echo htmlspecialchars($epDate, ENT_QUOTES); ?>"
                                    data-category="<?php echo htmlspecialchars($ep['category'] ?? 'Campus Event', ENT_QUOTES); ?>">
                                <?php echo date('d M Y', strtotime($epDate)); ?> — <?php echo sanitize(mb_substr($ep['title'], 0, 48)) . '...'; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <small class="text-muted" style="font-size:0.75rem;">Selecting an event will auto-fill the title, poster, date, category and redirection link below.</small>
                </div>
                <?php endif; ?>

                <!-- 4. Creative Event Poster (Upload or Path) -->
                <div class="mb-3 p-3 rounded-3 bg-light border">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label class="form-label small fw-bold text-navy mb-0">
                            <i class="fas fa-image text-danger me-1"></i> Creative Event Poster Image
                        </label>
                        <span class="badge bg-secondary small">Landscape / Creative Poster</span>
                    </div>
                    <div class="row g-2 mt-1">
                        <div class="col-12 col-md-7">
                            <input type="text" id="popupImageInput" name="popup_event_image" class="form-control form-control-sm" value="<?php echo sanitize($popupEventImage); ?>" placeholder="assets/images/news4.jpg or uploads/..." oninput="onPopupPosterChanged(this.value)">
                        </div>
                        <div class="col-12 col-md-5">
                            <input type="file" name="popup_image_file" class="form-control form-control-sm" accept="image/*" onchange="previewUploadedFile(this)">
                        </div>
                    </div>
                    <small class="text-muted" style="font-size:0.75rem;">You can paste an existing path/URL or upload a brand-new promotional creative poster.</small>
                </div>

                <!-- 5. Event Title & Redirection Link -->
                <div class="mb-3">
                    <label class="form-label small fw-bold text-navy mb-1">
                        <i class="fas fa-heading text-primary me-1"></i> Event Title / Headline
                    </label>
                    <input type="text" id="popupTitleInput" name="popup_event_title" class="form-control" value="<?php echo sanitize($popupEventTitle); ?>" placeholder="e.g. Tarang 2026 - Annual Sports & Cultural Fest" oninput="onPopupTitleChanged(this.value)" required>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold text-navy mb-1">
                        <i class="fas fa-external-link-alt text-success me-1"></i> Redirection Link (Where clicking image / button goes)
                    </label>
                    <input type="text" id="popupLinkInput" name="popup_event_link" class="form-control" value="<?php echo sanitize($popupEventLink); ?>" placeholder="news-detail.php?slug=tarang-annual-fest-2026 or https://..." oninput="onPopupLinkChanged(this.value)" required>
                    <small class="text-muted" style="font-size:0.75rem;">Visitors will be redirected to this link when clicking the poster image or "View Event Details" button.</small>
                </div>

                <!-- 6. Event Date & Category -->
                <div class="row g-2 mb-3">
                    <div class="col-12 col-md-6">
                        <label class="form-label small fw-bold text-navy mb-1">
                            <i class="far fa-calendar-alt text-danger me-1"></i> Event Date
                        </label>
                        <input type="date" id="popupDateInput" name="popup_event_date" class="form-control" value="<?php echo sanitize($popupEventDate); ?>" onchange="onPopupDateChanged(this.value)">
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label small fw-bold text-navy mb-1">
                            <i class="fas fa-tag text-info me-1"></i> Category Tag
                        </label>
                        <input type="text" id="popupCategoryInput" name="popup_event_category" class="form-control" value="<?php echo sanitize($popupEventCategory); ?>" placeholder="e.g. Campus Life, Admissions, Fest" oninput="onPopupCategoryChanged(this.value)">
                    </div>
                </div>

                <!-- 7. Modal Settings: Title, Subtitle, Delay -->
                <div class="p-3 mb-3 rounded-3 bg-light border">
                    <h6 class="fw-bold text-navy small mb-2"><i class="fas fa-sliders-h text-secondary me-1"></i> Modal Display &amp; Behavior Settings</h6>
                    <div class="row g-2">
                        <div class="col-12 col-md-6">
                            <label class="form-label small text-muted mb-1">Modal Header Title</label>
                            <input type="text" name="popup_header_title" class="form-control form-control-sm" value="<?php echo sanitize($popupHeaderTitle); ?>">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small text-muted mb-1">Modal Header Subtitle</label>
                            <input type="text" name="popup_header_subtitle" class="form-control form-control-sm" value="<?php echo sanitize($popupHeaderSubtitle); ?>">
                        </div>
                        <div class="col-12 col-md-6 mt-2">
                            <label class="form-label small text-muted mb-1">Popup Delay (Seconds)</label>
                            <input type="number" step="0.1" min="0" max="10" name="popup_delay_sec" class="form-control form-control-sm" value="<?php echo sanitize($popupDelaySec); ?>" oninput="onPopupDelayChanged(this.value)">
                        </div>
                        <div class="col-12 col-md-6 mt-2 d-flex align-items-center pt-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="popup_show_once_day" id="showOnceDayCheck" value="1" <?php echo $popupShowOnceDay === '1' ? 'checked' : ''; ?>>
                                <label class="form-check-label small" for="showOnceDayCheck">
                                    "Don't show again today" feature
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-end pt-3 border-top mt-4">
                    <button type="submit" class="btn btn-danger px-4 py-2 rounded-pill fw-bold shadow-sm">
                        <i class="fas fa-save me-1"></i> Save Popup Settings
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!-- Live Preview Interactive Script -->
    <script>
    function onQuickEventPicked(sel) {
        const opt = sel.options[sel.selectedIndex];
        if (!opt || !opt.value) return;

        const title = opt.getAttribute('data-title');
        const img = opt.getAttribute('data-image');
        const link = opt.getAttribute('data-link');
        const date = opt.getAttribute('data-date');
        const cat = opt.getAttribute('data-category');

        if (title) {
            document.getElementById('popupTitleInput').value = title;
            onPopupTitleChanged(title);
        }
        if (img) {
            document.getElementById('popupImageInput').value = img;
            onPopupPosterChanged(img);
        }
        if (link) {
            document.getElementById('popupLinkInput').value = link;
            onPopupLinkChanged(link);
        }
        if (date) {
            document.getElementById('popupDateInput').value = date;
            onPopupDateChanged(date);
        }
        if (cat) {
            document.getElementById('popupCategoryInput').value = cat;
            onPopupCategoryChanged(cat);
        }
    }

    function onPopupTitleChanged(val) {
        document.getElementById('previewTitleText').innerText = val || 'Event Title';
    }

    function onPopupPosterChanged(val) {
        if (!val) return;
        const imgEl = document.getElementById('adminPopupPosterPreview');
        if (val.startsWith('http://') || val.startsWith('https://')) {
            imgEl.src = val;
        } else {
            imgEl.src = '<?php echo BASE_URL; ?>' + val.replace(/^\/+/, '');
        }
    }

    function previewUploadedFile(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('adminPopupPosterPreview').src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function onPopupLinkChanged(val) {
        document.getElementById('previewLinkText').innerText = val || 'news-detail.php?slug=...';
    }

    function onPopupDateChanged(val) {
        if (!val) return;
        const d = new Date(val);
        if (!isNaN(d.getTime())) {
            const months = ['JAN','FEB','MAR','APR','MAY','JUN','JUL','AUG','SEP','OCT','NOV','DEC'];
            const fullMonths = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
            const day = String(d.getDate()).padStart(2, '0');
            const monthStr = months[d.getMonth()];
            const fullMonthStr = fullMonths[d.getMonth()];
            const year = d.getFullYear();

            document.getElementById('previewMonthTag').innerText = monthStr;
            document.getElementById('previewDayTag').innerText = day;
            document.getElementById('previewDateText').innerText = day + ' ' + fullMonthStr + ', ' + year;
        }
    }

    function onPopupCategoryChanged(val) {
        document.getElementById('previewCategoryBadge').innerText = val || 'Campus Event';
        document.getElementById('previewCategoryTag').innerText = val || 'Campus Event';
    }

    function onDefaultTabChanged(val) {
        const textMap = {
            'events': 'Events',
            'notices': 'Notices',
            'admissions': 'Admissions 2026'
        };
        const el = document.getElementById('previewDefaultTabText');
        if (el) el.innerText = textMap[val] || val;

        document.querySelectorAll('.default-tab-card').forEach(card => {
            card.classList.remove('border-primary', 'bg-primary-subtle', 'shadow-xs');
            card.classList.add('bg-light');
        });
        const selectedRadio = document.querySelector('input[name="popup_default_tab"][value="' + val + '"]');
        if (selectedRadio) {
            const parentLabel = selectedRadio.closest('.default-tab-card');
            if (parentLabel) {
                parentLabel.classList.remove('bg-light');
                parentLabel.classList.add('border-primary', 'bg-primary-subtle', 'shadow-xs');
            }
        }
    }

    function onPopupDelayChanged(val) {
        const el = document.getElementById('previewDelayText');
        if (el) el.innerText = val ? val + 's' : '1.2s';
    }
    </script>
    <?php endif; ?>

</form>

<?php require_once __DIR__ . '/footer.php'; ?>
