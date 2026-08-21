<?php
require_once __DIR__ . '/header.php';
$pdo = getDBConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_settings'])) {
    $settingsToUpdate = [
        'hero_title' => sanitize($_POST['hero_title'] ?? 'SRK University, Bhopal'),
        'hero_subtitle' => sanitize($_POST['hero_subtitle'] ?? 'UGC-Recognized University in MP'),
        'hero_desc' => $_POST['hero_desc'] ?? '',
        'chancellor_name' => sanitize($_POST['chancellor_name'] ?? 'Dr. Sunil Kapoor'),
        'chancellor_title' => sanitize($_POST['chancellor_title'] ?? 'Founder Chairman & Chancellor'),
        'chancellor_msg' => $_POST['chancellor_msg'] ?? '',
        'vc_name' => sanitize($_POST['vc_name'] ?? 'Prof. (Dr.) Brijendra Singh'),
        'vc_title' => sanitize($_POST['vc_title'] ?? 'Vice Chancellor'),
        'vc_msg' => $_POST['vc_msg'] ?? '',
        'helpline' => sanitize($_POST['helpline'] ?? ''),
        'email' => sanitize($_POST['email'] ?? ''),
        'admissions_phone' => sanitize($_POST['admissions_phone'] ?? ''),
        'address' => sanitize($_POST['address'] ?? ''),
        'ticker_text' => sanitize($_POST['ticker_text'] ?? ''),
        'highest_package' => sanitize($_POST['highest_package'] ?? '12 LPA'),
        'placement_record' => sanitize($_POST['placement_record'] ?? '94%'),
        'recruiting_partners' => sanitize($_POST['recruiting_partners'] ?? '120+'),
        'total_labs' => sanitize($_POST['total_labs'] ?? '42+'),
        'total_alumni' => sanitize($_POST['total_alumni'] ?? '15,000+'),
        'facebook_url' => sanitize($_POST['facebook_url'] ?? ''),
        'instagram_url' => sanitize($_POST['instagram_url'] ?? ''),
        'youtube_url' => sanitize($_POST['youtube_url'] ?? ''),
        'linkedin_url' => sanitize($_POST['linkedin_url'] ?? '')
    ];

    foreach ($settingsToUpdate as $key => $value) {
        $stmt = $pdo->prepare("INSERT INTO settings (setting_key, setting_value) VALUES (:k, :v) ON DUPLICATE KEY UPDATE setting_value = :v");
        $stmt->execute([':k' => $key, ':v' => $value]);
    }

    setFlashMsg('success', 'Global site settings updated successfully.');
    header("Location: manage_settings.php");
    exit;
}

$heroTitle = getSetting('hero_title', 'SRK University, Bhopal');
$heroSubtitle = getSetting('hero_subtitle', 'UGC-Recognized University in MP');
$heroDesc = getSetting('hero_desc', 'Welcome to SRK University, a premier technical and academic ecosystem designed for global industry leadership. If you are looking for the best placement university in MP, our rigorous research, multi-disciplinary collaboration, and industry-aligned pedagogy deliver unmatched career growth.');
$chancellorName = getSetting('chancellor_name', 'Dr. Sunil Kapoor');
$chancellorTitle = getSetting('chancellor_title', 'Founder Chairman & Chancellor');
$chancellorMsg = getSetting('chancellor_msg', 'At Sarvepalli Radhakrishnan University, our mission is to foster an academic environment that cultivates critical thinking, research innovation, and professional integrity. We empower our students to become technology leaders, healthcare pioneers, and responsible global citizens.');
$vcName = getSetting('vc_name', 'Prof. (Dr.) Brijendra Singh');
$vcTitle = getSetting('vc_title', 'Vice Chancellor');
$vcMsg = getSetting('vc_msg', 'At SRK University, we foster innovation, high-impact research, and multi-disciplinary excellence. Our state-of-the-art infrastructure and faculty mentorship ensure every graduate is prepared for global careers.');
$helpline = getSetting('helpline', '0755 - 4911204');
$email = getSetting('email', 'exam@srku.edu.in');
$admissionsPhone = getSetting('admissions_phone', '+91 755 4911204');
$address = getSetting('address', 'NH-12, Hoshangabad Road, Misrod, Bhopal, Madhya Pradesh - 462026, India');
$ticker = getSetting('ticker_text', 'Admissions Open 2026-27 | UGC Recognized Premier University in MP | Apply Now for Engineering, Pharmacy, Nursing, Management & Medicine | 94% Placement Record');
$highestPackage = getSetting('highest_package', '12 LPA');
$placementRecord = getSetting('placement_record', '94%');
$recruitingPartners = getSetting('recruiting_partners', '120+');
$totalLabs = getSetting('total_labs', '42+');
$totalAlumni = getSetting('total_alumni', '15,000+');
$facebookUrl = getSetting('facebook_url', 'https://facebook.com');
$instagramUrl = getSetting('instagram_url', 'https://instagram.com');
$youtubeUrl = getSetting('youtube_url', 'https://youtube.com');
$linkedinUrl = getSetting('linkedin_url', 'https://linkedin.com');
?>

<div class="mb-4">
    <h3 class="h4 fw-bold text-navy mb-1">Global Website &amp; University Settings</h3>
    <p class="text-muted small mb-0">Configure site identity, leadership quotes, helpline contacts, live tickers, and social media handles.</p>
</div>

<div style="max-width: 960px;">
    <form action="manage_settings.php" method="POST">
        
        <!-- SECTION 1: Homepage Hero -->
        <div class="admin-form-section">
            <div class="admin-form-section-title">
                <i class="fas fa-home text-danger"></i> Section 1: Homepage Hero Section
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
                    <textarea name="hero_desc" class="form-control" rows="3"><?php echo sanitize($heroDesc); ?></textarea>
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
                <i class="fas fa-chart-line text-success"></i> Section 4: Live Ticker &amp; Key Metrics
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

        <div class="d-flex justify-content-end mb-5">
            <button type="submit" name="save_settings" class="btn btn-danger btn-lg fw-bold px-5">
                <i class="fas fa-save me-1"></i> Save All Global Settings
            </button>
        </div>

    </form>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
