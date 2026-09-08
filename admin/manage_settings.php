<?php
require_once __DIR__ . '/header.php';
$pdo = getDBConnection();

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['save_settings'])) {
    $videoUrl = normalizeMediaPath($_POST['hero_video_url'] ?? '', 'assets/images/concept2-hero.mp4');
    $fallbackImg = normalizeMediaPath($_POST['hero_fallback_image'] ?? '', 'assets/uploads/2026/08/srku-rkdf-building.jpeg');

    // Handle Video File Upload
    if (isset($_FILES['video_file']) && $_FILES['video_file']['error'] === UPLOAD_ERR_OK) {
        $allowedVideoExts = ['mp4', 'webm', 'ogg', 'mov'];
        $ext = strtolower(pathinfo($_FILES['video_file']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, $allowedVideoExts)) {
            $uploadDir = __DIR__ . '/../assets/uploads/2026/08/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $newFileName = 'hero_video_' . time() . '.' . $ext;
            $targetPath = $uploadDir . $newFileName;
            if (move_uploaded_file($_FILES['video_file']['tmp_name'], $targetPath)) {
                $videoUrl = 'assets/uploads/2026/08/' . $newFileName;
            }
        }
    }

    // Handle Fallback Image Upload
    if (isset($_FILES['fallback_img_file']) && $_FILES['fallback_img_file']['error'] === UPLOAD_ERR_OK) {
        $allowedImgExts = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        $ext = strtolower(pathinfo($_FILES['fallback_img_file']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, $allowedImgExts)) {
            $uploadDir = __DIR__ . '/../assets/uploads/2026/08/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $newFileName = 'hero_fallback_' . time() . '.' . $ext;
            $targetPath = $uploadDir . $newFileName;
            if (move_uploaded_file($_FILES['fallback_img_file']['tmp_name'], $targetPath)) {
                $fallbackImg = 'assets/uploads/2026/08/' . $newFileName;
            }
        }
    }

    // Handle PDF Uploads for Official Documents & Policies
    $pdfFields = [
        'calendar_odd_pdf_file' => 'calendar_odd_pdf',
        'calendar_even_pdf_file' => 'calendar_even_pdf',
        'exam_rules_ordinance_pdf_file' => 'exam_rules_ordinance_pdf',
        'exam_reval_pdf_file' => 'exam_reval_pdf',
        'exam_degree_pdf_file' => 'exam_degree_pdf',
        'incubation_policy_pdf_file' => 'incubation_policy_pdf',
        'incubation_application_pdf_file' => 'incubation_application_pdf',
        'phd_application_pdf_file' => 'phd_application_pdf',
        'phd_entrance_pdf_file' => 'phd_entrance_pdf',
        'phd_synopsis_pdf_file' => 'phd_synopsis_pdf',
    ];

    $uploadedPdfs = [];
    foreach ($pdfFields as $fileInput => $settingKey) {
        if (isset($_FILES[$fileInput]) && $_FILES[$fileInput]['error'] === UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($_FILES[$fileInput]['name'], PATHINFO_EXTENSION));
            if ($ext === 'pdf') {
                $pdfDir = __DIR__ . '/../assets/uploads/pdf/';
                if (!is_dir($pdfDir)) {
                    mkdir($pdfDir, 0777, true);
                }
                $baseName = preg_replace('/[^a-zA-Z0-9_-]/', '_', pathinfo($_FILES[$fileInput]['name'], PATHINFO_FILENAME));
                $targetName = $baseName . '_' . time() . '.pdf';
                if (move_uploaded_file($_FILES[$fileInput]['tmp_name'], $pdfDir . $targetName)) {
                    $uploadedPdfs[$settingKey] = 'assets/uploads/pdf/' . $targetName;
                }
            }
        }
    }

    $settingsToUpdate = [
        // Section 1: Hero
        'hero_title' => sanitize($_POST['hero_title'] ?? 'SRK University, Bhopal'),
        'hero_subtitle' => sanitize($_POST['hero_subtitle'] ?? 'UGC-Recognized University in MP'),
        'hero_desc' => $_POST['hero_desc'] ?? '',
        'hero_video_url' => $videoUrl ?: 'assets/images/concept2-hero.mp4',
        'hero_fallback_image' => $fallbackImg ?: 'assets/uploads/2026/08/srku-rkdf-building.jpeg',

        // Section 2: Chancellor & VC
        'chancellor_name' => sanitize($_POST['chancellor_name'] ?? 'Mrs. Janak Kapoor'),
        'chancellor_title' => sanitize($_POST['chancellor_title'] ?? 'Chancellor'),
        'chancellor_msg' => $_POST['chancellor_msg'] ?? '',
        'vc_name' => sanitize($_POST['vc_name'] ?? 'Prof. (Dr.) Brijendra Singh'),
        'vc_title' => sanitize($_POST['vc_title'] ?? 'Vice Chancellor'),
        'vc_msg' => $_POST['vc_msg'] ?? '',

        // Section 3: Coordinates
        'helpline' => sanitize($_POST['helpline'] ?? ''),
        'email' => sanitize($_POST['email'] ?? ''),
        'admissions_phone' => sanitize($_POST['admissions_phone'] ?? ''),
        'address' => sanitize($_POST['address'] ?? ''),

        // Section 4: Ticker & Quick Metrics
        'ticker_text' => sanitize($_POST['ticker_text'] ?? ''),
        'highest_package' => sanitize($_POST['highest_package'] ?? '12 LPA'),
        'placement_record' => sanitize($_POST['placement_record'] ?? '94%'),
        'recruiting_partners' => sanitize($_POST['recruiting_partners'] ?? '120+'),
        'total_labs' => sanitize($_POST['total_labs'] ?? '42+'),
        'total_alumni' => sanitize($_POST['total_alumni'] ?? '15,000+'),

        // Section 5: Social Media
        'facebook_url' => sanitize($_POST['facebook_url'] ?? ''),
        'instagram_url' => sanitize($_POST['instagram_url'] ?? ''),
        'youtube_url' => sanitize($_POST['youtube_url'] ?? ''),
        'linkedin_url' => sanitize($_POST['linkedin_url'] ?? ''),

        // Section 6: Standardized Core Metrics
        'stat_students' => sanitize($_POST['stat_students'] ?? '20,000+'),
        'stat_faculty' => sanitize($_POST['stat_faculty'] ?? '1,200+'),
        'stat_alumni' => sanitize($_POST['stat_alumni'] ?? '1,10,000+'),
        'stat_programs' => sanitize($_POST['stat_programs'] ?? '100+'),
        'stat_papers' => sanitize($_POST['stat_papers'] ?? '5,000+'),
        'stat_partners' => sanitize($_POST['stat_partners'] ?? '150+'),
        'stat_placements' => sanitize($_POST['stat_placements'] ?? '94%'),
        'stat_years' => sanitize($_POST['stat_years'] ?? '28+'),
        'stat_campus_acres' => sanitize($_POST['stat_campus_acres'] ?? '100+'),
        'stat_hospital_beds' => sanitize($_POST['stat_hospital_beds'] ?? '350+'),
        'stat_patents' => sanitize($_POST['stat_patents'] ?? '50+'),

        // Section 7: Founder Chairman & Vision
        'chairman_name' => sanitize($_POST['chairman_name'] ?? 'Late Er. Sunil Kapoor'),
        'chairman_title' => sanitize($_POST['chairman_title'] ?? 'Hon’ble Founder Chairman'),
        'chairman_story_quote' => $_POST['chairman_story_quote'] ?? '',
        'vision_quote' => $_POST['vision_quote'] ?? '',
        'vision_text' => $_POST['vision_text'] ?? '',

        // Section 8: Downloadable Documents & PDFs
        'calendar_odd_pdf' => $uploadedPdfs['calendar_odd_pdf'] ?? sanitize($_POST['calendar_odd_pdf'] ?? 'assets/uploads/pdf/academic-calendar-odd-2026.pdf'),
        'calendar_even_pdf' => $uploadedPdfs['calendar_even_pdf'] ?? sanitize($_POST['calendar_even_pdf'] ?? 'assets/uploads/pdf/academic-calendar-even-2026.pdf'),
        'exam_rules_ordinance_pdf' => $uploadedPdfs['exam_rules_ordinance_pdf'] ?? sanitize($_POST['exam_rules_ordinance_pdf'] ?? 'assets/uploads/pdf/exam-ordinance-2026.pdf'),
        'exam_reval_pdf' => $uploadedPdfs['exam_reval_pdf'] ?? sanitize($_POST['exam_reval_pdf'] ?? 'assets/uploads/pdf/exam-revaluation-form.pdf'),
        'exam_degree_pdf' => $uploadedPdfs['exam_degree_pdf'] ?? sanitize($_POST['exam_degree_pdf'] ?? 'assets/uploads/pdf/degree-application-form.pdf'),
        'incubation_policy_pdf' => $uploadedPdfs['incubation_policy_pdf'] ?? sanitize($_POST['incubation_policy_pdf'] ?? 'assets/uploads/pdf/incubation-policy.pdf'),
        'incubation_application_pdf' => $uploadedPdfs['incubation_application_pdf'] ?? sanitize($_POST['incubation_application_pdf'] ?? 'assets/uploads/pdf/incubation-application-form.pdf'),
        'phd_application_pdf' => $uploadedPdfs['phd_application_pdf'] ?? sanitize($_POST['phd_application_pdf'] ?? 'assets/uploads/pdf/phd-application-form.pdf'),
        'phd_entrance_pdf' => $uploadedPdfs['phd_entrance_pdf'] ?? sanitize($_POST['phd_entrance_pdf'] ?? 'assets/uploads/pdf/phd-entrance-form.pdf'),
        'phd_synopsis_pdf' => $uploadedPdfs['phd_synopsis_pdf'] ?? sanitize($_POST['phd_synopsis_pdf'] ?? 'assets/uploads/pdf/phd-synopsis-format.pdf'),

        // Section 9: Hostels & Facilities
        'hostel_boys_fee' => sanitize($_POST['hostel_boys_fee'] ?? '₹65,000'),
        'hostel_girls_fee' => sanitize($_POST['hostel_girls_fee'] ?? '₹70,000'),
        'hostel_contact_phone' => sanitize($_POST['hostel_contact_phone'] ?? '0755 - 4911204'),
        'hostel_contact_email' => sanitize($_POST['hostel_contact_email'] ?? 'hostel@srku.edu.in'),
        'facilities_desc' => $_POST['facilities_desc'] ?? '',
    ];

    $driver = $pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
    if ($driver === 'sqlite') {
        $stmt = $pdo->prepare("INSERT INTO settings (setting_key, setting_value) VALUES (:k, :v) ON CONFLICT(setting_key) DO UPDATE SET setting_value = excluded.setting_value");
    } else {
        $stmt = $pdo->prepare("INSERT INTO settings (setting_key, setting_value) VALUES (:k, :v) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)");
    }

    foreach ($settingsToUpdate as $key => $value) {
        $stmt->execute([':k' => $key, ':v' => $value]);
    }

    setFlashMsg('success', 'Global site settings updated successfully.');
    header("Location: manage_settings.php");
    exit;
}

// Section 1: Hero
$heroTitle = getSetting('hero_title', 'SRK University, Bhopal');
$heroSubtitle = getSetting('hero_subtitle', 'UGC-Recognized University in MP');
$heroDesc = getSetting('hero_desc', 'Welcome to SRK University, a premier technical and academic ecosystem designed for global industry leadership. If you are looking for the best placement university in MP, our rigorous research, multi-disciplinary collaboration, and industry-aligned pedagogy deliver unmatched career growth.');
$heroVideo = getSetting('hero_video_url', 'assets/images/concept2-hero.mp4');
$heroFallbackImg = getSetting('hero_fallback_image', 'assets/uploads/2026/08/srku-rkdf-building.jpeg');

// Section 2: Leadership
$chancellorName = getSetting('chancellor_name', 'Mrs. Janak Kapoor');
$chancellorTitle = getSetting('chancellor_title', 'Founder Chairman & Chancellor');
$chancellorMsg = getSetting('chancellor_msg', 'At Sarvepalli Radhakrishnan University, our mission is to foster an academic environment that cultivates critical thinking, research innovation, and professional integrity. We empower our students to become technology leaders, healthcare pioneers, and responsible global citizens.');
$vcName = getSetting('vc_name', 'Prof. (Dr.) Brijendra Singh');
$vcTitle = getSetting('vc_title', 'Vice Chancellor');
$vcMsg = getSetting('vc_msg', 'At SRK University, we foster innovation, high-impact research, and multi-disciplinary excellence. Our state-of-the-art infrastructure and faculty mentorship ensure every graduate is prepared for global careers.');

// Section 3: Coordinates
$helpline = getSetting('helpline', '0755 - 4911204');
$email = getSetting('email', 'exam@srku.edu.in');
$admissionsPhone = getSetting('admissions_phone', '+91 755 4911204');
$address = getSetting('address', 'NH-12, Hoshangabad Road, Misrod, Bhopal, Madhya Pradesh - 462026, India');

// Section 4: Live Ticker & Placement Rates
$ticker = getSetting('ticker_text', 'Admissions Open 2026-27 | UGC Recognized Premier University in MP | Apply Now for Engineering, Pharmacy, Nursing, Management & Medicine | 94% Placement Record');
$highestPackage = getSetting('highest_package', '12 LPA');
$placementRecord = getSetting('placement_record', '94%');
$recruitingPartners = getSetting('recruiting_partners', '120+');
$totalLabs = getSetting('total_labs', '42+');
$totalAlumni = getSetting('total_alumni', '15,000+');

// Section 5: Social Media
$facebookUrl = getSetting('facebook_url', 'https://facebook.com');
$instagramUrl = getSetting('instagram_url', 'https://instagram.com');
$youtubeUrl = getSetting('youtube_url', 'https://youtube.com');
$linkedinUrl = getSetting('linkedin_url', 'https://linkedin.com');

// Section 6: Standardized Core Metrics
$statStudents = getSetting('stat_students', '20,000+');
$statFaculty = getSetting('stat_faculty', '1,200+');
$statAlumni = getSetting('stat_alumni', '1,10,000+');
$statPrograms = getSetting('stat_programs', '100+');
$statPapers = getSetting('stat_papers', '5,000+');
$statPartners = getSetting('stat_partners', '150+');
$statPlacements = getSetting('stat_placements', '94%');
$statYears = getSetting('stat_years', '28+');
$statCampusAcres = getSetting('stat_campus_acres', '100+');
$statHospitalBeds = getSetting('stat_hospital_beds', '350+');
$statPatents = getSetting('stat_patents', '50+');

// Section 7: Founder Chairman & Vision
$chairmanName = getSetting('chairman_name', 'Late Er. Sunil Kapoor');
$chairmanTitle = getSetting('chairman_title', 'Hon’ble Founder Chairman');
$chairmanStoryQuote = getSetting('chairman_story_quote', 'The journey of RKDF and Sarvepalli Radhakrishnan University began with a simple yet profound conviction: every young mind in central India deserves access to world-class technical education, modern healthcare training, and unbounded opportunities.');
$visionQuote = getSetting('vision_quote', 'Education is not just about academic instruction; it is about character building, ethical leadership, and empowering communities to solve humanity’s grandest challenges.');
$visionText = getSetting('vision_text', 'To become a globally acclaimed center of academic and research excellence, empowering diverse learners with cutting-edge skills, ethical integrity, and social responsibility to lead sustainable transformation.');

// Section 8: Downloadable Documents & PDFs
$calendarOddPdf = getSetting('calendar_odd_pdf', 'assets/uploads/pdf/academic-calendar-odd-2026.pdf');
$calendarEvenPdf = getSetting('calendar_even_pdf', 'assets/uploads/pdf/academic-calendar-even-2026.pdf');
$examRulesOrdinancePdf = getSetting('exam_rules_ordinance_pdf', 'assets/uploads/pdf/exam-ordinance-2026.pdf');
$examRevalPdf = getSetting('exam_reval_pdf', 'assets/uploads/pdf/exam-revaluation-form.pdf');
$examDegreePdf = getSetting('exam_degree_pdf', 'assets/uploads/pdf/degree-application-form.pdf');
$incubationPolicyPdf = getSetting('incubation_policy_pdf', 'assets/uploads/pdf/incubation-policy.pdf');
$incubationAppPdf = getSetting('incubation_application_pdf', 'assets/uploads/pdf/incubation-application-form.pdf');
$phdAppPdf = getSetting('phd_application_pdf', 'assets/uploads/pdf/phd-application-form.pdf');
$phdEntrancePdf = getSetting('phd_entrance_pdf', 'assets/uploads/pdf/phd-entrance-form.pdf');
$phdSynopsisPdf = getSetting('phd_synopsis_pdf', 'assets/uploads/pdf/phd-synopsis-format.pdf');

// Section 9: Hostels & Facilities
$hostelBoysFee = getSetting('hostel_boys_fee', '₹65,000');
$hostelGirlsFee = getSetting('hostel_girls_fee', '₹70,000');
$hostelContactPhone = getSetting('hostel_contact_phone', '0755 - 4911204');
$hostelContactEmail = getSetting('hostel_contact_email', 'hostel@srku.edu.in');
$facilitiesDesc = getSetting('facilities_desc', 'Sarvepalli Radhakrishnan University (SRKU) provides world-class infrastructure and holistic amenities designed to enrich student learning, research innovation, physical fitness, and community living.');
?>

<div class="mb-4">
    <h3 class="h4 fw-bold text-navy mb-1">Global Website &amp; University Settings</h3>
    <p class="text-muted small mb-0">Configure site identity, leadership quotes, standardized institutional metrics, PDF downloads, and hostel/facility information.</p>
</div>

<div style="max-width: 980px;">
    <form action="manage_settings.php" method="POST" enctype="multipart/form-data">
        
        <!-- SECTION 1: Homepage Hero Video, Fallback Image & Content -->
        <div class="admin-form-section">
            <div class="admin-form-section-title">
                <i class="fas fa-video text-danger"></i> Section 1: Homepage Hero Video &amp; Fallback Poster Background
            </div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark small">Hero Heading Main Title</label>
                    <input type="text" name="hero_title" class="form-control" value="<?php echo sanitize($heroTitle); ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark small">Hero Gold Subtitle</label>
                    <input type="text" name="hero_subtitle" class="form-control" value="<?php echo sanitize($heroSubtitle); ?>">
                </div>
                <div class="col-12">
                    <label class="form-label fw-bold text-dark small">Hero Lead Paragraph</label>
                    <textarea name="hero_desc" class="form-control" rows="2"><?php echo sanitize($heroDesc); ?></textarea>
                </div>
                
                <!-- Video Controls -->
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3 border">
                        <label class="form-label fw-bold text-navy small mb-1"><i class="fas fa-film text-danger me-1"></i> Hero Video URL / Path</label>
                        <input type="text" name="hero_video_url" class="form-control form-control-sm mb-2" value="<?php echo sanitize($heroVideo); ?>">
                        <label class="form-label small text-muted mb-1">OR Upload New Video File</label>
                        <input type="file" name="video_file" class="form-control form-control-sm" accept="video/mp4,video/webm">
                    </div>
                </div>

                <!-- Fallback Image Controls -->
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3 border">
                        <label class="form-label fw-bold text-navy small mb-1"><i class="fas fa-image text-success me-1"></i> Fallback Poster Image</label>
                        <input type="text" name="hero_fallback_image" class="form-control form-control-sm mb-2" value="<?php echo sanitize($heroFallbackImg); ?>">
                        <label class="form-label small text-muted mb-1">OR Upload New Image</label>
                        <input type="file" name="fallback_img_file" class="form-control form-control-sm" accept="image/*">
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 2: Leadership Messages with CKEditor -->
        <div class="admin-form-section">
            <div class="admin-form-section-title">
                <i class="fas fa-user-tie text-warning"></i> Section 2: Chancellor &amp; Vice-Chancellor Messages (CKEditor)
            </div>
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark small">Chancellor Name</label>
                    <input type="text" name="chancellor_name" class="form-control" value="<?php echo sanitize($chancellorName); ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark small">Chancellor Title / Designation</label>
                    <input type="text" name="chancellor_title" class="form-control" value="<?php echo sanitize($chancellorTitle); ?>">
                </div>
                <div class="col-12">
                    <label class="form-label fw-bold text-dark small mb-2">Chancellor's Desk Quote (CKEditor)</label>
                    <textarea name="chancellor_msg" class="form-control rich-editor" rows="6"><?php echo htmlspecialchars($chancellorMsg); ?></textarea>
                </div>
            </div>
            
            <hr class="my-4">

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark small">Vice Chancellor Name</label>
                    <input type="text" name="vc_name" class="form-control" value="<?php echo sanitize($vcName); ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark small">Vice Chancellor Title</label>
                    <input type="text" name="vc_title" class="form-control" value="<?php echo sanitize($vcTitle); ?>">
                </div>
                <div class="col-12">
                    <label class="form-label fw-bold text-dark small mb-2">Vice Chancellor's Message (CKEditor)</label>
                    <textarea name="vc_msg" class="form-control rich-editor" rows="6"><?php echo htmlspecialchars($vcMsg); ?></textarea>
                </div>
            </div>
        </div>

        <!-- SECTION 3: Helplines & Campus Coordinates -->
        <div class="admin-form-section">
            <div class="admin-form-section-title">
                <i class="fas fa-phone-alt text-primary"></i> Section 3: Helplines &amp; Campus Coordinates
            </div>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold text-dark small">Helpline Phone Number</label>
                    <input type="text" name="helpline" class="form-control" value="<?php echo sanitize($helpline); ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold text-dark small">Official Email Address</label>
                    <input type="email" name="email" class="form-control" value="<?php echo sanitize($email); ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold text-dark small">Admissions Direct Phone</label>
                    <input type="text" name="admissions_phone" class="form-control" value="<?php echo sanitize($admissionsPhone); ?>">
                </div>
                <div class="col-12">
                    <label class="form-label fw-bold text-dark small">Full Campus Address</label>
                    <textarea name="address" class="form-control" rows="2"><?php echo sanitize($address); ?></textarea>
                </div>
            </div>
        </div>

        <!-- SECTION 4: Live Ticker & Institutional Metrics -->
        <div class="admin-form-section">
            <div class="admin-form-section-title">
                <i class="fas fa-chart-line text-success"></i> Section 4: Live Ticker &amp; Homepage Metrics
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold text-dark small">Live Announcement Ticker Text</label>
                <input type="text" name="ticker_text" class="form-control" value="<?php echo sanitize($ticker); ?>">
            </div>
            <div class="row g-3">
                <div class="col-6 col-md-3">
                    <label class="form-label fw-bold text-dark small">Highest Package</label>
                    <input type="text" name="highest_package" class="form-control" value="<?php echo sanitize($highestPackage); ?>">
                </div>
                <div class="col-6 col-md-3">
                    <label class="form-label fw-bold text-dark small">Placement Rate</label>
                    <input type="text" name="placement_record" class="form-control" value="<?php echo sanitize($placementRecord); ?>">
                </div>
                <div class="col-6 col-md-3">
                    <label class="form-label fw-bold text-dark small">Recruiting Partners</label>
                    <input type="text" name="recruiting_partners" class="form-control" value="<?php echo sanitize($recruitingPartners); ?>">
                </div>
                <div class="col-6 col-md-3">
                    <label class="form-label fw-bold text-dark small">Total High-Tech Labs</label>
                    <input type="text" name="total_labs" class="form-control" value="<?php echo sanitize($totalLabs); ?>">
                </div>
            </div>
        </div>

        <!-- SECTION 5: Social Media Handles -->
        <div class="admin-form-section">
            <div class="admin-form-section-title">
                <i class="fas fa-share-alt text-info"></i> Section 5: Official Social Media Links
            </div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark small">Facebook URL</label>
                    <input type="url" name="facebook_url" class="form-control" value="<?php echo sanitize($facebookUrl); ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark small">Instagram URL</label>
                    <input type="url" name="instagram_url" class="form-control" value="<?php echo sanitize($instagramUrl); ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark small">YouTube Channel URL</label>
                    <input type="url" name="youtube_url" class="form-control" value="<?php echo sanitize($youtubeUrl); ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark small">LinkedIn Page URL</label>
                    <input type="url" name="linkedin_url" class="form-control" value="<?php echo sanitize($linkedinUrl); ?>">
                </div>
            </div>
        </div>

        <!-- SECTION 6: Standardized Core Institutional Statistics -->
        <div class="admin-form-section">
            <div class="admin-form-section-title">
                <i class="fas fa-calculator text-danger"></i> Section 6: Standardized University Statistics (Synchronized Across All Pages)
            </div>
            <p class="text-muted small mb-3">
                These numbers automatically update throughout the website (About Us, Why SRKU, Accreditation, Board of Management, Facilities, etc.) ensuring complete numerical consistency.
            </p>
            <div class="row g-3">
                <div class="col-6 col-md-3">
                    <label class="form-label fw-bold text-dark small">Total Students Enrolled</label>
                    <input type="text" name="stat_students" class="form-control" value="<?php echo sanitize($statStudents); ?>" placeholder="e.g. 20,000+">
                </div>
                <div class="col-6 col-md-3">
                    <label class="form-label fw-bold text-dark small">Faculty Members</label>
                    <input type="text" name="stat_faculty" class="form-control" value="<?php echo sanitize($statFaculty); ?>" placeholder="e.g. 1,200+">
                </div>
                <div class="col-6 col-md-3">
                    <label class="form-label fw-bold text-dark small">Global Alumni Network</label>
                    <input type="text" name="stat_alumni" class="form-control" value="<?php echo sanitize($statAlumni); ?>" placeholder="e.g. 1,10,000+">
                </div>
                <div class="col-6 col-md-3">
                    <label class="form-label fw-bold text-dark small">Degree Programs Offered</label>
                    <input type="text" name="stat_programs" class="form-control" value="<?php echo sanitize($statPrograms); ?>" placeholder="e.g. 100+">
                </div>
                <div class="col-6 col-md-3">
                    <label class="form-label fw-bold text-dark small">Research Papers Published</label>
                    <input type="text" name="stat_papers" class="form-control" value="<?php echo sanitize($statPapers); ?>" placeholder="e.g. 5,000+">
                </div>
                <div class="col-6 col-md-3">
                    <label class="form-label fw-bold text-dark small">Corporate Hiring Partners</label>
                    <input type="text" name="stat_partners" class="form-control" value="<?php echo sanitize($statPartners); ?>" placeholder="e.g. 150+">
                </div>
                <div class="col-6 col-md-3">
                    <label class="form-label fw-bold text-dark small">Average Placement Rate</label>
                    <input type="text" name="stat_placements" class="form-control" value="<?php echo sanitize($statPlacements); ?>" placeholder="e.g. 94%">
                </div>
                <div class="col-6 col-md-3">
                    <label class="form-label fw-bold text-dark small">Academic Legacy Years</label>
                    <input type="text" name="stat_years" class="form-control" value="<?php echo sanitize($statYears); ?>" placeholder="e.g. 28+">
                </div>
                <div class="col-6 col-md-4">
                    <label class="form-label fw-bold text-dark small">Campus Area (Acres)</label>
                    <input type="text" name="stat_campus_acres" class="form-control" value="<?php echo sanitize($statCampusAcres); ?>" placeholder="e.g. 100+">
                </div>
                <div class="col-6 col-md-4">
                    <label class="form-label fw-bold text-dark small">Multi-Specialty Hospital Beds</label>
                    <input type="text" name="stat_hospital_beds" class="form-control" value="<?php echo sanitize($statHospitalBeds); ?>" placeholder="e.g. 350+">
                </div>
                <div class="col-6 col-md-4">
                    <label class="form-label fw-bold text-dark small">Patents Filed &amp; Published</label>
                    <input type="text" name="stat_patents" class="form-control" value="<?php echo sanitize($statPatents); ?>" placeholder="e.g. 50+">
                </div>
            </div>
        </div>

        <!-- SECTION 7: Founder Chairman Story & University Vision -->
        <div class="admin-form-section">
            <div class="admin-form-section-title">
                <i class="fas fa-landmark text-warning"></i> Section 7: Founder Chairman Legacy &amp; University Vision
            </div>
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark small">Founder Chairman Name</label>
                    <input type="text" name="chairman_name" class="form-control" value="<?php echo sanitize($chairmanName); ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark small">Founder Chairman Title</label>
                    <input type="text" name="chairman_title" class="form-control" value="<?php echo sanitize($chairmanTitle); ?>">
                </div>
                <div class="col-12">
                    <label class="form-label fw-bold text-dark small mb-1">Founder Chairman Story Quote (Featured on Board &amp; About Pages)</label>
                    <textarea name="chairman_story_quote" class="form-control" rows="3"><?php echo htmlspecialchars($chairmanStoryQuote); ?></textarea>
                </div>
                <div class="col-12">
                    <label class="form-label fw-bold text-dark small mb-1">University Vision Quote (Featured Callout)</label>
                    <textarea name="vision_quote" class="form-control" rows="2"><?php echo htmlspecialchars($visionQuote); ?></textarea>
                </div>
                <div class="col-12">
                    <label class="form-label fw-bold text-dark small mb-1">University Vision Statement Body</label>
                    <textarea name="vision_text" class="form-control" rows="3"><?php echo htmlspecialchars($visionText); ?></textarea>
                </div>
            </div>
        </div>

        <!-- SECTION 8: Official Downloadable Documents & Policy PDFs -->
        <div class="admin-form-section">
            <div class="admin-form-section-title">
                <i class="fas fa-file-pdf text-danger"></i> Section 8: Downloadable Documents &amp; Policy PDFs
            </div>
            <p class="text-muted small mb-3">
                Specify relative URL paths or upload new PDF files directly. The links will update automatically across Academic Calendar, Examination Rules, Incubation, and Ph.D. forms.
            </p>
            <div class="row g-3">
                <!-- Academic Calendar Odd -->
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3 border">
                        <label class="form-label fw-bold text-navy small mb-1"><i class="fas fa-calendar-alt text-danger me-1"></i> Academic Calendar (Odd Sem) PDF</label>
                        <input type="text" name="calendar_odd_pdf" class="form-control form-control-sm mb-2" value="<?php echo sanitize($calendarOddPdf); ?>">
                        <label class="form-label small text-muted mb-1">Upload New PDF</label>
                        <input type="file" name="calendar_odd_pdf_file" class="form-control form-control-sm" accept="application/pdf">
                    </div>
                </div>
                <!-- Academic Calendar Even -->
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3 border">
                        <label class="form-label fw-bold text-navy small mb-1"><i class="fas fa-calendar-alt text-danger me-1"></i> Academic Calendar (Even Sem) PDF</label>
                        <input type="text" name="calendar_even_pdf" class="form-control form-control-sm mb-2" value="<?php echo sanitize($calendarEvenPdf); ?>">
                        <label class="form-label small text-muted mb-1">Upload New PDF</label>
                        <input type="file" name="calendar_even_pdf_file" class="form-control form-control-sm" accept="application/pdf">
                    </div>
                </div>

                <!-- Exam Rules Ordinance -->
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3 border">
                        <label class="form-label fw-bold text-navy small mb-1"><i class="fas fa-gavel text-warning me-1"></i> Exam Rules &amp; Ordinance PDF</label>
                        <input type="text" name="exam_rules_ordinance_pdf" class="form-control form-control-sm mb-2" value="<?php echo sanitize($examRulesOrdinancePdf); ?>">
                        <label class="form-label small text-muted mb-1">Upload New PDF</label>
                        <input type="file" name="exam_rules_ordinance_pdf_file" class="form-control form-control-sm" accept="application/pdf">
                    </div>
                </div>
                <!-- Exam Revaluation Form -->
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3 border">
                        <label class="form-label fw-bold text-navy small mb-1"><i class="fas fa-redo text-info me-1"></i> Exam Revaluation Form PDF</label>
                        <input type="text" name="exam_reval_pdf" class="form-control form-control-sm mb-2" value="<?php echo sanitize($examRevalPdf); ?>">
                        <label class="form-label small text-muted mb-1">Upload New PDF</label>
                        <input type="file" name="exam_reval_pdf_file" class="form-control form-control-sm" accept="application/pdf">
                    </div>
                </div>

                <!-- Incubation Policy -->
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3 border">
                        <label class="form-label fw-bold text-navy small mb-1"><i class="fas fa-lightbulb text-warning me-1"></i> Incubation Policy Circular PDF</label>
                        <input type="text" name="incubation_policy_pdf" class="form-control form-control-sm mb-2" value="<?php echo sanitize($incubationPolicyPdf); ?>">
                        <label class="form-label small text-muted mb-1">Upload New PDF</label>
                        <input type="file" name="incubation_policy_pdf_file" class="form-control form-control-sm" accept="application/pdf">
                    </div>
                </div>
                <!-- Incubation Application Form -->
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3 border">
                        <label class="form-label fw-bold text-navy small mb-1"><i class="fas fa-file-signature text-success me-1"></i> Incubation Application Form PDF</label>
                        <input type="text" name="incubation_application_pdf" class="form-control form-control-sm mb-2" value="<?php echo sanitize($incubationAppPdf); ?>">
                        <label class="form-label small text-muted mb-1">Upload New PDF</label>
                        <input type="file" name="incubation_application_pdf_file" class="form-control form-control-sm" accept="application/pdf">
                    </div>
                </div>

                <!-- Ph.D. Application Form -->
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3 border">
                        <label class="form-label fw-bold text-navy small mb-1"><i class="fas fa-file-alt text-danger me-1"></i> Ph.D. Application Form PDF</label>
                        <input type="text" name="phd_application_pdf" class="form-control form-control-sm mb-2" value="<?php echo sanitize($phdAppPdf); ?>">
                        <label class="form-label small text-muted mb-1">Upload New PDF</label>
                        <input type="file" name="phd_application_pdf_file" class="form-control form-control-sm" accept="application/pdf">
                    </div>
                </div>
                <!-- Ph.D. Entrance Exam Form -->
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3 border">
                        <label class="form-label fw-bold text-navy small mb-1"><i class="fas fa-id-card text-primary me-1"></i> Ph.D. Entrance Examination (DET) Form PDF</label>
                        <input type="text" name="phd_entrance_pdf" class="form-control form-control-sm mb-2" value="<?php echo sanitize($phdEntrancePdf); ?>">
                        <label class="form-label small text-muted mb-1">Upload New PDF</label>
                        <input type="file" name="phd_entrance_pdf_file" class="form-control form-control-sm" accept="application/pdf">
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 9: Hostel & Campus Facilities Overview -->
        <div class="admin-form-section">
            <div class="admin-form-section-title">
                <i class="fas fa-hotel text-primary"></i> Section 9: Hostel &amp; Campus Facilities
            </div>
            <div class="row g-3">
                <div class="col-6 col-md-3">
                    <label class="form-label fw-bold text-dark small">Boys Hostel Annual Fee</label>
                    <input type="text" name="hostel_boys_fee" class="form-control" value="<?php echo sanitize($hostelBoysFee); ?>" placeholder="e.g. ₹65,000">
                </div>
                <div class="col-6 col-md-3">
                    <label class="form-label fw-bold text-dark small">Girls Hostel Annual Fee</label>
                    <input type="text" name="hostel_girls_fee" class="form-control" value="<?php echo sanitize($hostelGirlsFee); ?>" placeholder="e.g. ₹70,000">
                </div>
                <div class="col-6 col-md-3">
                    <label class="form-label fw-bold text-dark small">Hostel Desk Helpline</label>
                    <input type="text" name="hostel_contact_phone" class="form-control" value="<?php echo sanitize($hostelContactPhone); ?>">
                </div>
                <div class="col-6 col-md-3">
                    <label class="form-label fw-bold text-dark small">Hostel Desk Email</label>
                    <input type="email" name="hostel_contact_email" class="form-control" value="<?php echo sanitize($hostelContactEmail); ?>">
                </div>
                <div class="col-12">
                    <label class="form-label fw-bold text-dark small">Facilities Overview Lead Description</label>
                    <textarea name="facilities_desc" class="form-control" rows="3"><?php echo htmlspecialchars($facilitiesDesc); ?></textarea>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end mb-5">
            <button type="submit" name="save_settings" class="btn btn-danger btn-lg fw-bold px-5 shadow">
                <i class="fas fa-save me-1"></i> Save All Global Settings
            </button>
        </div>

    </form>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
