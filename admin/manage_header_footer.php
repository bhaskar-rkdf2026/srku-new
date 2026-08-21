<?php
require_once __DIR__ . '/header.php';
$pdo = getDBConnection();

// Handle Logo / Media Upload for Header/Footer
$uploadedLogoUrl = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['logo_upload']) && $_FILES['logo_upload']['error'] === UPLOAD_ERR_OK) {
    $file = $_FILES['logo_upload'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'webp', 'svg'];
    if (in_array($ext, $allowed)) {
        $targetDir = __DIR__ . '/../assets/images/';
        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
        $fileName = 'logo_' . time() . '.' . $ext;
        if (move_uploaded_file($file['tmp_name'], $targetDir . $fileName)) {
            $uploadedLogoUrl = 'assets/images/' . $fileName;
            // Update setting directly
            $stmt = $pdo->prepare("INSERT INTO settings (setting_key, setting_value) VALUES ('header_logo_url', :v) ON DUPLICATE KEY UPDATE setting_value = :v");
            $stmt->execute([':v' => $uploadedLogoUrl]);
            setFlashMsg('success', "New logo uploaded and set successfully! URL: " . BASE_URL . $uploadedLogoUrl);
        }
    }
}

// Handle Form Save
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_header_footer'])) {
    $settingsData = [
        // Header & Topbar
        'header_topbar_phone' => sanitize($_POST['header_topbar_phone'] ?? '0755 - 4911204'),
        'header_topbar_email' => sanitize($_POST['header_topbar_email'] ?? 'exam@srku.edu.in'),
        'header_topbar_erp_link' => sanitize($_POST['header_topbar_erp_link'] ?? 'https://erp.srku.edu.in/'),
        'header_topbar_aicte_link' => sanitize($_POST['header_topbar_aicte_link'] ?? 'https://sarswati.aicte.gov.in/'),
        'header_logo_url' => sanitize($_POST['header_logo_url'] ?? 'assets/images/logo.png'),
        'header_cta_text' => sanitize($_POST['header_cta_text'] ?? 'Contact Us'),
        'header_cta_link' => sanitize($_POST['header_cta_link'] ?? 'contact.php'),
        'header_custom_head_code' => $_POST['header_custom_head_code'] ?? '',

        // Footer
        'footer_about_heading' => sanitize($_POST['footer_about_heading'] ?? 'Sarvepalli Radhakrishnan University'),
        'footer_about_text' => $_POST['footer_about_text'] ?? '',
        'footer_address' => sanitize($_POST['footer_address'] ?? 'NH-12, Hoshangabad Road, Misrod, Bhopal, MP - 462026'),
        'footer_phone' => sanitize($_POST['footer_phone'] ?? '0755 - 4911204'),
        'footer_email' => sanitize($_POST['footer_email'] ?? 'exam@srku.edu.in'),
        'footer_ugc_text' => sanitize($_POST['footer_ugc_text'] ?? 'Recognized under Section 2(f) of UGC Act 1956'),
        'footer_copyright_text' => sanitize($_POST['footer_copyright_text'] ?? '© 2026 Sarvepalli Radhakrishnan University (SRKU), Bhopal. All Rights Reserved.'),
        'footer_custom_scripts' => $_POST['footer_custom_scripts'] ?? '',

        // Floating Widgets
        'enable_whatsapp_float' => isset($_POST['enable_whatsapp_float']) ? '1' : '0',
        'whatsapp_float_number' => sanitize($_POST['whatsapp_float_number'] ?? '917554911204'),
        'whatsapp_float_msg' => sanitize($_POST['whatsapp_float_msg'] ?? 'Hello SRKU, I am interested in Admission Details.'),
        'enable_enquiry_tab' => isset($_POST['enable_enquiry_tab']) ? '1' : '0',
        'enquiry_tab_text' => sanitize($_POST['enquiry_tab_text'] ?? 'Admissions 2026-27'),
        'enquiry_tab_link' => sanitize($_POST['enquiry_tab_link'] ?? '#apply'),
        'enable_back_to_top' => isset($_POST['enable_back_to_top']) ? '1' : '0'
    ];

    foreach ($settingsData as $key => $val) {
        $stmt = $pdo->prepare("INSERT INTO settings (setting_key, setting_value) VALUES (:k, :v) ON DUPLICATE KEY UPDATE setting_value = :v");
        $stmt->execute([':k' => $key, ':v' => $val]);
    }

    setFlashMsg('success', 'Header and Footer customizations updated successfully.');
    header("Location: manage_header_footer.php");
    exit;
}

// Fetch current values
$topbarPhone = getSetting('header_topbar_phone', getSetting('helpline', '0755 - 4911204'));
$topbarEmail = getSetting('header_topbar_email', getSetting('email', 'exam@srku.edu.in'));
$erpLink = getSetting('header_topbar_erp_link', 'https://erp.srku.edu.in/');
$aicteLink = getSetting('header_topbar_aicte_link', 'https://sarswati.aicte.gov.in/');
$logoUrl = getSetting('header_logo_url', 'assets/images/logo.png');
$ctaText = getSetting('header_cta_text', 'Contact Us');
$ctaLink = getSetting('header_cta_link', 'contact.php');
$customHeadCode = getSetting('header_custom_head_code', '');

$footerHeading = getSetting('footer_about_heading', 'Sarvepalli Radhakrishnan University');
$footerAbout = getSetting('footer_about_text', 'SRK University Bhopal is a premier educational ecosystem delivering world-class technical, medical, management, agricultural, and scientific education with state-of-the-art infrastructure and 94% placement record.');
$footerAddress = getSetting('footer_address', getSetting('address', 'NH-12, Hoshangabad Road, Misrod, Bhopal, MP - 462026'));
$footerPhone = getSetting('footer_phone', getSetting('helpline', '0755 - 4911204'));
$footerEmail = getSetting('footer_email', getSetting('email', 'exam@srku.edu.in'));
$footerUgc = getSetting('footer_ugc_text', 'Recognized under Section 2(f) of UGC Act 1956');
$footerCopyright = getSetting('footer_copyright_text', '© ' . date('Y') . ' Sarvepalli Radhakrishnan University (SRKU), Bhopal. All Rights Reserved.');
$footerCustomScripts = getSetting('footer_custom_scripts', '');

$enableWhatsapp = getSetting('enable_whatsapp_float', '1');
$whatsappNumber = getSetting('whatsapp_float_number', '917554911204');
$whatsappMsg = getSetting('whatsapp_float_msg', 'Hello SRKU, I am interested in Admission Details.');
$enableEnquiryTab = getSetting('enable_enquiry_tab', '1');
$enquiryTabText = getSetting('enquiry_tab_text', 'Admissions 2026-27');
$enquiryTabLink = getSetting('enquiry_tab_link', '#apply');
$enableBackToTop = getSetting('enable_back_to_top', '1');
?>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
    <div>
        <h3 class="h4 fw-bold text-navy mb-1"><i class="fas fa-heading text-danger me-2"></i> Header &amp; Footer CMS Customizer</h3>
        <p class="text-muted small mb-0">Control navbar brand logo, topbar helplines, quick links, footer columns, and floating action buttons.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="manage_media.php" class="btn btn-outline-primary btn-sm"><i class="fas fa-photo-video me-1"></i> Media Library</a>
        <a href="<?php echo BASE_URL; ?>" target="_blank" class="btn btn-danger btn-sm"><i class="fas fa-eye me-1"></i> View Live Site</a>
    </div>
</div>

<div style="max-width: 1000px;">

    <!-- SECTION 1: Brand Logo Uploader Box -->
    <div class="admin-form-section">
        <div class="admin-form-section-title">
            <i class="fas fa-image text-danger"></i> Section 1: University Brand Logo &amp; Asset URL
        </div>
        <div class="row g-4 align-items-center">
            <div class="col-12 col-md-4 text-center">
                <div class="p-3 bg-light rounded-3 border">
                    <small class="text-muted d-block mb-2 fw-bold">CURRENT ACTIVE LOGO</small>
                    <img src="<?php echo (strpos($logoUrl, 'http') === 0) ? $logoUrl : BASE_URL . $logoUrl; ?>" alt="SRKU Logo" style="max-height: 70px; max-width: 100%; object-fit: contain;" class="mb-2">
                    <div class="mt-2">
                        <span class="badge bg-success-subtle text-success border">Active on Navbar</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-8">
                <!-- Direct Logo Upload Form -->
                <form action="manage_header_footer.php" method="POST" enctype="multipart/form-data" class="mb-3">
                    <label class="form-label fw-bold text-dark small">Upload New Logo (PNG, WebP, SVG)</label>
                    <div class="input-group mb-1">
                        <input type="file" name="logo_upload" class="form-control" accept=".png,.webp,.svg,.jpg,.jpeg" required>
                        <button type="submit" class="btn btn-danger fw-bold"><i class="fas fa-cloud-upload-alt me-1"></i> Upload &amp; Set</button>
                    </div>
                    <small class="text-muted">Recommended: Transparent PNG or SVG with approx. 320x80 px resolution.</small>
                </form>

                <!-- Full Public URL Display with 1-click Copy -->
                <div class="mt-2">
                    <label class="form-label fw-bold text-dark small mb-1">Logo Public URL (Auto-Generated)</label>
                    <div class="input-group">
                        <input type="text" id="logoFullUrlInput" class="form-control bg-light" value="<?php echo (strpos($logoUrl, 'http') === 0) ? $logoUrl : BASE_URL . $logoUrl; ?>" readonly>
                        <button type="button" class="btn btn-outline-primary" onclick="copyLogoUrl()"><i class="fas fa-copy me-1"></i> Copy URL</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN HEADER & FOOTER CUSTOMIZER FORM -->
    <form action="manage_header_footer.php" method="POST">

        <!-- SECTION 2: Top Bar & Navbar Settings -->
        <div class="admin-form-section">
            <div class="admin-form-section-title">
                <i class="fas fa-desktop text-warning"></i> Section 2: Header Top Bar &amp; Navbar Navigation
            </div>
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark small">Topbar Helpline Phone</label>
                    <input type="text" name="header_topbar_phone" class="form-control" value="<?php echo sanitize($topbarPhone); ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark small">Topbar Official Email</label>
                    <input type="email" name="header_topbar_email" class="form-control" value="<?php echo sanitize($topbarEmail); ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark small">Student ERP Portal Link</label>
                    <input type="text" name="header_topbar_erp_link" class="form-control" value="<?php echo sanitize($erpLink); ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark small">AICTE Scholarship Link</label>
                    <input type="text" name="header_topbar_aicte_link" class="form-control" value="<?php echo sanitize($aicteLink); ?>">
                </div>
            </div>

            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold text-dark small">Logo Relative Path or Full URL</label>
                    <input type="text" name="header_logo_url" class="form-control" value="<?php echo sanitize($logoUrl); ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold text-dark small">Header CTA Button Text</label>
                    <input type="text" name="header_cta_text" class="form-control" value="<?php echo sanitize($ctaText); ?>" placeholder="Contact Us">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold text-dark small">Header CTA Button Link</label>
                    <input type="text" name="header_cta_link" class="form-control" value="<?php echo sanitize($ctaLink); ?>" placeholder="contact.php">
                </div>
            </div>
        </div>

        <!-- SECTION 3: Footer Customizer (CKEditor) -->
        <div class="admin-form-section">
            <div class="admin-form-section-title">
                <i class="fas fa-shoe-prints text-primary"></i> Section 3: Footer Columns &amp; Content (CKEditor)
            </div>
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark small">Footer Column 1 Title</label>
                    <input type="text" name="footer_about_heading" class="form-control" value="<?php echo sanitize($footerHeading); ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark small">Footer Accreditation Text</label>
                    <input type="text" name="footer_ugc_text" class="form-control" value="<?php echo sanitize($footerUgc); ?>">
                </div>
                <div class="col-12">
                    <label class="form-label fw-bold text-dark small mb-2">Footer About / University Summary (CKEditor)</label>
                    <textarea name="footer_about_text" class="form-control rich-editor" rows="6"><?php echo htmlspecialchars($footerAbout); ?></textarea>
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark small">Footer Helpline Phone</label>
                    <input type="text" name="footer_phone" class="form-control" value="<?php echo sanitize($footerPhone); ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark small">Footer Email Address</label>
                    <input type="email" name="footer_email" class="form-control" value="<?php echo sanitize($footerEmail); ?>">
                </div>
                <div class="col-12">
                    <label class="form-label fw-bold text-dark small">Footer Campus Address</label>
                    <textarea name="footer_address" class="form-control" rows="2"><?php echo sanitize($footerAddress); ?></textarea>
                </div>
                <div class="col-12">
                    <label class="form-label fw-bold text-dark small">Footer Bottom Copyright Notice</label>
                    <input type="text" name="footer_copyright_text" class="form-control" value="<?php echo sanitize($footerCopyright); ?>">
                </div>
            </div>
        </div>

        <!-- SECTION 4: Floating Interactive Widgets -->
        <div class="admin-form-section">
            <div class="admin-form-section-title">
                <i class="fas fa-comment-dots text-success"></i> Section 4: Floating Quick Action Widgets
            </div>
            
            <!-- WhatsApp Floating Button -->
            <div class="p-3 bg-light rounded-3 mb-3 border">
                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" name="enable_whatsapp_float" id="enableWhatsapp" <?php echo $enableWhatsapp === '1' ? 'checked' : ''; ?>>
                    <label class="form-check-label fw-bold text-dark" for="enableWhatsapp">Enable Floating WhatsApp Direct Chat Bubble (Bottom-Left)</label>
                </div>
                <div class="row g-2 mt-1">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-muted">WhatsApp Helpline (with country code, e.g. 917554911204)</label>
                        <input type="text" name="whatsapp_float_number" class="form-control form-control-sm" value="<?php echo sanitize($whatsappNumber); ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-muted">Pre-filled Chat Message</label>
                        <input type="text" name="whatsapp_float_msg" class="form-control form-control-sm" value="<?php echo sanitize($whatsappMsg); ?>">
                    </div>
                </div>
            </div>

            <!-- Floating Admission Tab -->
            <div class="p-3 bg-light rounded-3 mb-3 border">
                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" name="enable_enquiry_tab" id="enableEnquiry" <?php echo $enableEnquiryTab === '1' ? 'checked' : ''; ?>>
                    <label class="form-check-label fw-bold text-dark" for="enableEnquiry">Enable Floating Quick Admission Enquiry Tab (Right Edge)</label>
                </div>
                <div class="row g-2 mt-1">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-muted">Tab Label Text</label>
                        <input type="text" name="enquiry_tab_text" class="form-control form-control-sm" value="<?php echo sanitize($enquiryTabText); ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-muted">Target Link / Anchor</label>
                        <input type="text" name="enquiry_tab_link" class="form-control form-control-sm" value="<?php echo sanitize($enquiryTabLink); ?>">
                    </div>
                </div>
            </div>

            <!-- Back to Top Button -->
            <div class="p-3 bg-light rounded-3 border">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="enable_back_to_top" id="enableBackToTop" <?php echo $enableBackToTop === '1' ? 'checked' : ''; ?>>
                    <label class="form-check-label fw-bold text-dark" for="enableBackToTop">Enable Smooth Back-To-Top Button (Bottom-Right)</label>
                </div>
            </div>
        </div>

        <!-- SECTION 5: Custom Analytics & Tracking Code -->
        <div class="admin-form-section">
            <div class="admin-form-section-title">
                <i class="fas fa-code text-info"></i> Section 5: Custom Scripts &amp; Tracking Codes
            </div>
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label fw-bold text-dark small">Header Custom Code (Injected into <code>&lt;head&gt;</code> — e.g. Google Tag Manager, Meta Pixel)</label>
                    <textarea name="header_custom_head_code" class="form-control font-monospace" rows="4" placeholder="<!-- Paste <script> or <meta> tags here -->"><?php echo htmlspecialchars($customHeadCode); ?></textarea>
                </div>
                <div class="col-12">
                    <label class="form-label fw-bold text-dark small">Footer Custom Code (Injected before <code>&lt;/body&gt;</code> — e.g. Live Chat Widget, Analytics)</label>
                    <textarea name="footer_custom_scripts" class="form-control font-monospace" rows="4" placeholder="<!-- Paste custom JS tracking scripts here -->"><?php echo htmlspecialchars($footerCustomScripts); ?></textarea>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end mb-5">
            <button type="submit" name="save_header_footer" class="btn btn-danger btn-lg fw-bold px-5">
                <i class="fas fa-save me-1"></i> Save Header &amp; Footer Customizations
            </button>
        </div>

    </form>
</div>

<script>
function copyLogoUrl() {
    const input = document.getElementById('logoFullUrlInput');
    input.select();
    input.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(input.value).then(() => {
        alert('Active Logo URL copied to clipboard: ' + input.value);
    });
}
</script>

<?php require_once __DIR__ . '/footer.php'; ?>
