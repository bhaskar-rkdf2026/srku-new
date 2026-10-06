<?php
require_once __DIR__ . '/header.php';
$pdo = getDBConnection();
$reqMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';

// Ensure settings table has LONGTEXT for large JSON menus
try {
    $driver = $pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
    if ($driver !== 'sqlite') {
        $pdo->exec("ALTER TABLE `settings` MODIFY COLUMN `setting_value` LONGTEXT");
    }
} catch (Exception $e) {}

// Helper to save setting
function saveSettingValue($pdo, $key, $val) {
    $stmt = $pdo->prepare("INSERT INTO settings (setting_key, setting_value) VALUES (:k, :v) ON DUPLICATE KEY UPDATE setting_value = :v");
    $stmt->execute([':k' => $key, ':v' => $val]);
}

// Handle Logo / Media Upload
$uploadedLogoUrl = '';
if ($reqMethod === 'POST' && isset($_FILES['logo_upload']) && $_FILES['logo_upload']['error'] === UPLOAD_ERR_OK) {
    $file = $_FILES['logo_upload'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'webp', 'svg'];
    if (in_array($ext, $allowed)) {
        $targetDir = __DIR__ . '/../assets/images/';
        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
        $fileName = 'logo_' . time() . '.' . $ext;
        if (move_uploaded_file($file['tmp_name'], $targetDir . $fileName)) {
            $uploadedLogoUrl = 'assets/images/' . $fileName;
            saveSettingValue($pdo, 'header_logo_url', $uploadedLogoUrl);
            setFlashMsg('success', "New University Logo uploaded and set successfully! URL: " . BASE_URL . $uploadedLogoUrl);
            header("Location: manage_header_footer.php#tab-brand");
            exit;
        }
    }
}

// Handle Tab 1: Save Main Menu
if ($reqMethod === 'POST' && isset($_POST['save_main_menu'])) {
    $mainMenuJson = $_POST['main_menu_json'] ?? '';
    if (!empty($mainMenuJson)) {
        $decoded = json_decode($mainMenuJson, true);
        if (is_array($decoded)) {
            saveSettingValue($pdo, 'header_main_menu', json_encode($decoded, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
            setFlashMsg('success', 'Main Navigation Menu updated successfully! All changes are live on the website header.');
        } else {
            setFlashMsg('danger', 'Invalid JSON payload received for Main Navigation.');
        }
    }
    header("Location: manage_header_footer.php#tab-mainnav");
    exit;
}

// Reset Main Menu to Default
if ($reqMethod === 'POST' && isset($_POST['reset_main_menu'])) {
    saveSettingValue($pdo, 'header_main_menu', json_encode(getDefaultMainMenu(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    setFlashMsg('success', 'Main Navigation Menu has been reset to default standard SRKU structure.');
    header("Location: manage_header_footer.php#tab-mainnav");
    exit;
}

// Handle Tab 2: Save Topbar Links
if ($reqMethod === 'POST' && isset($_POST['save_topbar_links'])) {
    $topbarJson = $_POST['topbar_links_json'] ?? '';
    if (!empty($topbarJson)) {
        $decoded = json_decode($topbarJson, true);
        if (is_array($decoded)) {
            saveSettingValue($pdo, 'header_topbar_links', json_encode($decoded, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
            setFlashMsg('success', 'Header Topbar Quick Links updated successfully!');
        }
    }
    header("Location: manage_header_footer.php#tab-topbar");
    exit;
}

// Reset Topbar Links
if ($reqMethod === 'POST' && isset($_POST['reset_topbar_links'])) {
    saveSettingValue($pdo, 'header_topbar_links', json_encode(getDefaultTopbarLinks(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    setFlashMsg('success', 'Topbar Quick Links reset to default.');
    header("Location: manage_header_footer.php#tab-topbar");
    exit;
}

// Handle Tab 3: Save ERP Links
if ($reqMethod === 'POST' && isset($_POST['save_erp_links'])) {
    $erpJson = $_POST['erp_links_json'] ?? '';
    if (!empty($erpJson)) {
        $decoded = json_decode($erpJson, true);
        if (is_array($decoded)) {
            saveSettingValue($pdo, 'header_erp_links', json_encode($decoded, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
            setFlashMsg('success', 'ERP Logins and Portals updated successfully!');
        }
    }
    header("Location: manage_header_footer.php#tab-erp");
    exit;
}

// Reset ERP Links
if ($reqMethod === 'POST' && isset($_POST['reset_erp_links'])) {
    saveSettingValue($pdo, 'header_erp_links', json_encode(getDefaultErpLinks(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    setFlashMsg('success', 'ERP Logins reset to default.');
    header("Location: manage_header_footer.php#tab-erp");
    exit;
}

// Handle Tab 4: Save Brand & Buttons
if ($reqMethod === 'POST' && isset($_POST['save_brand_settings'])) {
    $brandData = [
        'header_logo_url' => sanitize($_POST['header_logo_url'] ?? 'assets/images/logo.png'),
        'header_cta_text' => sanitize($_POST['header_cta_text'] ?? 'Contact Us'),
        'header_cta_link' => sanitize($_POST['header_cta_link'] ?? 'contact.php'),
        'header_custom_head_code' => $_POST['header_custom_head_code'] ?? '',
        'footer_custom_scripts' => $_POST['footer_custom_scripts'] ?? '',
        'enable_whatsapp_float' => isset($_POST['enable_whatsapp_float']) ? '1' : '0',
        'whatsapp_float_number' => sanitize($_POST['whatsapp_float_number'] ?? '917554911204'),
        'whatsapp_float_msg' => sanitize($_POST['whatsapp_float_msg'] ?? 'Hello SRKU, I am interested in Admission Details.'),
        'enable_enquiry_tab' => isset($_POST['enable_enquiry_tab']) ? '1' : '0',
        'enquiry_tab_text' => sanitize($_POST['enquiry_tab_text'] ?? 'Admissions 2026-27'),
        'enquiry_tab_link' => sanitize($_POST['enquiry_tab_link'] ?? '#apply'),
        'enable_back_to_top' => isset($_POST['enable_back_to_top']) ? '1' : '0'
    ];
    foreach ($brandData as $k => $v) {
        saveSettingValue($pdo, $k, $v);
    }
    setFlashMsg('success', 'Brand Logo, CTA Button, and Floating action widgets saved successfully!');
    header("Location: manage_header_footer.php#tab-brand");
    exit;
}

// Handle Tab 5: Save Footer & Social Media & Quick Links
if ($reqMethod === 'POST' && isset($_POST['save_footer_settings'])) {
    // 1. Footer Quick Links JSON
    if (isset($_POST['footer_quick_links_json'])) {
        $fql = json_decode($_POST['footer_quick_links_json'], true);
        if (is_array($fql)) {
            saveSettingValue($pdo, 'footer_quick_links', json_encode($fql, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        }
    }
    // 2. Footer Units JSON
    if (isset($_POST['footer_units_links_json'])) {
        $ful = json_decode($_POST['footer_units_links_json'], true);
        if (is_array($ful)) {
            saveSettingValue($pdo, 'footer_units_links', json_encode($ful, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        }
    }
    // 3. Footer text & contacts
    $footerFields = [
        'footer_about_heading' => sanitize($_POST['footer_about_heading'] ?? 'Sarvepalli Radhakrishnan University'),
        'footer_about_text' => $_POST['footer_about_text'] ?? '',
        'footer_address' => sanitize($_POST['footer_address'] ?? 'NH-12, Hoshangabad Road, Misrod, Bhopal, MP - 462026'),
        'footer_phone' => sanitize($_POST['footer_phone'] ?? '0755 - 4911204'),
        'footer_email' => sanitize($_POST['footer_email'] ?? 'exam@srku.edu.in'),
        'footer_ugc_text' => sanitize($_POST['footer_ugc_text'] ?? 'Recognized under Section 2(f) of UGC Act 1956'),
        'footer_copyright_text' => sanitize($_POST['footer_copyright_text'] ?? '© 2026 Sarvepalli Radhakrishnan University (SRKU), Bhopal. All Rights Reserved.'),
        'facebook_url' => sanitize($_POST['facebook_url'] ?? '#'),
        'instagram_url' => sanitize($_POST['instagram_url'] ?? '#'),
        'youtube_url' => sanitize($_POST['youtube_url'] ?? '#'),
        'linkedin_url' => sanitize($_POST['linkedin_url'] ?? '#')
    ];
    foreach ($footerFields as $k => $v) {
        saveSettingValue($pdo, $k, $v);
    }
    setFlashMsg('success', 'Footer Quick Links, Constituent Units, and Contact Info updated successfully!');
    header("Location: manage_header_footer.php#tab-footer");
    exit;
}

// Reset Footer Links
if ($reqMethod === 'POST' && isset($_POST['reset_footer_links'])) {
    saveSettingValue($pdo, 'footer_quick_links', json_encode(getDefaultFooterLinks(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    saveSettingValue($pdo, 'footer_units_links', json_encode(getDefaultFooterUnits(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    setFlashMsg('success', 'Footer Quick Links & Constituent Units reset to standard defaults.');
    header("Location: manage_header_footer.php#tab-footer");
    exit;
}

// Fetch current values
$currentMainMenu = getMainNavigationMenu();
$currentTopbarLinks = getTopbarLinks();
$currentErpLinks = getErpLinks();
$currentFooterQuickLinks = getFooterQuickLinks();
$currentFooterUnitsLinks = getFooterUnitsLinks();

$logoUrl = getSetting('header_logo_url', 'assets/images/logo.png');
$ctaText = getSetting('header_cta_text', 'Contact Us');
$ctaLink = getSetting('header_cta_link', 'contact.php');
$customHeadCode = getSetting('header_custom_head_code', '');
$footerCustomScripts = getSetting('footer_custom_scripts', '');

$enableWhatsapp = getSetting('enable_whatsapp_float', '1');
$whatsappNumber = getSetting('whatsapp_float_number', '917554911204');
$whatsappMsg = getSetting('whatsapp_float_msg', 'Hello SRKU, I am interested in Admission Details.');
$enableEnquiryTab = getSetting('enable_enquiry_tab', '1');
$enquiryTabText = getSetting('enquiry_tab_text', 'Admissions 2026-27');
$enquiryTabLink = getSetting('enquiry_tab_link', '#apply');
$enableBackToTop = getSetting('enable_back_to_top', '1');

$footerHeading = getSetting('footer_about_heading', 'Sarvepalli Radhakrishnan University');
$footerAbout = getSetting('footer_about_text', 'SRK University Bhopal is a premier educational ecosystem delivering world-class technical, medical, management, agricultural, and scientific education with state-of-the-art infrastructure and 94% placement record.');
$footerAddress = getSetting('footer_address', getSetting('address', 'NH-12, Hoshangabad Road, Misrod, Bhopal, MP - 462026'));
$footerPhone = getSetting('footer_phone', getSetting('helpline', '0755 - 4911204'));
$footerEmail = getSetting('footer_email', getSetting('email', 'exam@srku.edu.in'));
$footerUgc = getSetting('footer_ugc_text', 'Recognized under Section 2(f) of UGC Act 1956');
$footerCopyright = getSetting('footer_copyright_text', '© ' . date('Y') . ' Sarvepalli Radhakrishnan University (SRKU), Bhopal. All Rights Reserved.');
$fbUrl = getSetting('facebook_url', '#');
$instaUrl = getSetting('instagram_url', '#');
$ytUrl = getSetting('youtube_url', '#');
$liUrl = getSetting('linkedin_url', '#');
?>

<style>
/* Modern Drag & Drop Navigation Visual Manager Styles */
.menu-nav-tabs {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    background: #f8fafc;
    padding: 10px;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    margin-bottom: 24px;
}
.menu-nav-tab {
    padding: 10px 18px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.92rem;
    color: #475569;
    background: transparent;
    border: 1px solid transparent;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}
.menu-nav-tab:hover {
    color: #0f172a;
    background: #e2e8f0;
}
.menu-nav-tab.active {
    background: #0b1f44;
    color: #ffffff;
    box-shadow: 0 4px 12px rgba(11, 31, 68, 0.18);
}
.tab-content-panel {
    display: none;
}
.tab-content-panel.active {
    display: block;
}

/* Card item list */
.menu-item-card {
    background: #ffffff;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    margin-bottom: 10px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    transition: all 0.2s ease;
    user-select: none;
}
.menu-item-card.is-dragging {
    opacity: 0.4;
    border: 2px dashed #dc2626;
    background: #fef2f2;
}
.menu-item-card.drag-over {
    border-top: 3px solid #dc2626;
}
.menu-item-header {
    padding: 12px 16px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    cursor: pointer;
    background: #ffffff;
    border-radius: 8px;
}
.menu-item-header:hover {
    background: #f8fafc;
}
.menu-item-drag-handle {
    cursor: grab;
    color: #94a3b8;
    margin-right: 12px;
    font-size: 1.1rem;
    display: flex;
    align-items: center;
}
.menu-item-drag-handle:active {
    cursor: grabbing;
}
.menu-item-title {
    font-weight: 600;
    color: #1e293b;
    font-size: 0.95rem;
    display: flex;
    align-items: center;
    gap: 10px;
}
.menu-item-tag {
    font-size: 0.75rem;
    padding: 2px 8px;
    border-radius: 4px;
    font-weight: 600;
}
.menu-item-actions {
    display: flex;
    align-items: center;
    gap: 6px;
}
.menu-btn-icon {
    width: 32px;
    height: 32px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    background: #ffffff;
    color: #64748b;
    cursor: pointer;
    transition: all 0.15s ease;
}
.menu-btn-icon:hover {
    background: #f1f5f9;
    color: #0f172a;
    border-color: #cbd5e1;
}
.menu-item-body {
    display: none;
    padding: 16px;
    background: #f8fafc;
    border-top: 1px solid #e2e8f0;
    border-bottom-left-radius: 8px;
    border-bottom-right-radius: 8px;
}
.menu-item-card.expanded .menu-item-body {
    display: block;
}
.menu-item-card.expanded .menu-btn-toggle i {
    transform: rotate(180deg);
}

/* Preset Pill buttons */
.preset-badge-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    margin: 4px;
    background: #ffffff;
    border: 1px solid #cbd5e1;
    border-radius: 20px;
    font-size: 0.82rem;
    font-weight: 600;
    color: #334155;
    cursor: pointer;
    transition: all 0.15s ease;
}
.preset-badge-btn:hover {
    background: #dc2626;
    color: #ffffff;
    border-color: #dc2626;
}

/* Nested subitem manager */
.submenu-list {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    padding: 8px;
    margin-top: 8px;
    max-height: 280px;
    overflow-y: auto;
}
.submenu-item-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 6px 10px;
    border-bottom: 1px solid #f1f5f9;
    font-size: 0.85rem;
}
.submenu-item-row:last-child {
    border-bottom: none;
}
</style>

<div class="mb-4">
    <!-- Top Hero Card Matching User Reference -->
    <div class="bg-navy p-4 rounded-4 shadow-sm text-white mb-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3" style="background: linear-gradient(135deg, #0b1f44 0%, #1e3a8a 100%);">
        <div>
            <h2 class="h4 fw-bold mb-1 text-white"><i class="fas fa-sitemap text-warning me-2"></i> Header &amp; Menu Drag &amp; Drop Visual Manager</h2>
            <p class="text-white-50 small mb-0">Add, edit, delete, and drag &amp; drop to reorder Main Navigation Tabs, Top Quick Links, ERP Logins, and Footer Columns like WordPress.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="<?php echo BASE_URL; ?>" target="_blank" class="btn btn-outline-light btn-sm fw-bold px-3">
                <i class="fas fa-eye me-1"></i> View Live Website
            </a>
        </div>
    </div>

    <!-- 5 Tab Pill Navigation -->
    <div class="menu-nav-tabs" id="managerTabs">
        <button type="button" class="menu-nav-tab active" data-tab="tab-mainnav">
            <i class="fas fa-bars"></i> 1. Main Navigation Menu
        </button>
        <button type="button" class="menu-nav-tab" data-tab="tab-topbar">
            <i class="fas fa-ellipsis-h"></i> 2. Top Bar Quick Links
        </button>
        <button type="button" class="menu-nav-tab" data-tab="tab-erp">
            <i class="fas fa-key"></i> 3. ERP Logins Dropdown
        </button>
        <button type="button" class="menu-nav-tab" data-tab="tab-brand">
            <i class="fas fa-gem"></i> 4. Brand &amp; Apply Buttons
        </button>
        <button type="button" class="menu-nav-tab" data-tab="tab-footer">
            <i class="fas fa-shoe-prints"></i> 5. Footer &amp; Quick Links
        </button>
    </div>

    <!-- WordPress Sync Notice Bar -->
    <div class="alert alert-info border-0 shadow-sm d-flex justify-content-between align-items-center py-2 px-3 mb-4 rounded-3" style="background-color: #e0f2fe; color: #0369a1;">
        <div class="small fw-semibold d-flex align-items-center gap-2">
            <i class="fas fa-info-circle fa-lg"></i>
            <span><strong>WordPress Menu System:</strong> Drag and drop any item below to change its sequence on the header. Click an item to edit label, target route, or delete it.</span>
        </div>
        <span class="badge bg-danger text-white px-2 py-1 small fw-bold">Dynamic Header Sync</span>
    </div>

    <!-- ══════════════════════════════════════════════════════════════════════ -->
    <!-- TAB 1: MAIN NAVIGATION MENU (WordPress Drag & Drop Visual Tree) -->
    <!-- ══════════════════════════════════════════════════════════════════════ -->
    <div class="tab-content-panel active" id="panel-tab-mainnav">
        <div class="row g-4">
            
            <!-- Left Column: Add Custom Link & Presets -->
            <div class="col-12 col-lg-4">
                
                <!-- Add Custom Link Card -->
                <div class="card border rounded-3 shadow-sm mb-4">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h6 class="mb-0 fw-bold text-dark"><i class="fas fa-link text-danger me-2"></i> Add Custom Link</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Link URL / Route</label>
                            <input type="text" id="addMenuUrl" class="form-control form-control-sm" placeholder="https://... or page.php?id=10">
                            <small class="text-muted" style="font-size: 11px;">Relative (e.g. <code>convocation.php</code>) or full URL.</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Navigation Label</label>
                            <input type="text" id="addMenuLabel" class="form-control form-control-sm" placeholder="e.g. Convocation 2026">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Target Window</label>
                            <select id="addMenuTarget" class="form-select form-select-sm">
                                <option value="_self">Same Window (_self)</option>
                                <option value="_blank">New Window (_blank)</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Menu Behavior</label>
                            <select id="addMenuType" class="form-select form-select-sm">
                                <option value="link">Direct Link (No dropdown)</option>
                                <option value="dropdown">Standard Dropdown (Add sub-items)</option>
                            </select>
                        </div>
                        <button type="button" class="btn btn-danger btn-sm w-100 fw-bold" onclick="addCustomMenuItem()">
                            <i class="fas fa-plus me-1"></i> Add to Menu
                        </button>
                    </div>
                </div>

                <!-- Built-in Mega Dropdown Presets Card -->
                <div class="card border rounded-3 shadow-sm mb-4">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h6 class="mb-0 fw-bold text-dark"><i class="fas fa-th-large text-primary me-2"></i> Built-in Mega Dropdowns</h6>
                    </div>
                    <div class="card-body">
                        <p class="text-muted small mb-2">Quickly re-add any standard multi-column mega menu:</p>
                        <div class="d-flex flex-wrap">
                            <button type="button" class="preset-badge-btn" onclick="addPresetMenu('home', 'Home', '')"><i class="fas fa-home text-danger"></i> Home</button>
                            <button type="button" class="preset-badge-btn" onclick="addPresetMenu('about', 'About H.E.I.', 'about.php')"><i class="fas fa-university text-danger"></i> About H.E.I.</button>
                            <button type="button" class="preset-badge-btn" onclick="addPresetMenu('syllabus', 'Syllabus & Courses', 'courses')"><i class="fas fa-book-open text-danger"></i> Syllabus &amp; Courses</button>
                            <button type="button" class="preset-badge-btn" onclick="addPresetMenu('academics', 'Academics', 'academic-calendar.php')"><i class="fas fa-graduation-cap text-danger"></i> Academics</button>
                            <button type="button" class="preset-badge-btn" onclick="addPresetMenu('admission', 'Admission & Fee', 'admission-enquiry.php')"><i class="fas fa-user-edit text-danger"></i> Admission &amp; Fee</button>
                            <button type="button" class="preset-badge-btn" onclick="addPresetMenu('research', 'Research', 'research-innovation')"><i class="fas fa-microscope text-danger"></i> Research</button>
                            <button type="button" class="preset-badge-btn" onclick="addPresetMenu('departments', 'Departments', 'departments.php')"><i class="fas fa-building text-danger"></i> Departments</button>
                            <button type="button" class="preset-badge-btn" onclick="addPresetMenu('student-life', 'Student Life', 'student-life')"><i class="fas fa-running text-danger"></i> Student Life</button>
                            <button type="button" class="preset-badge-btn" onclick="addPresetMenu('alumni', 'Alumni', 'alumni')"><i class="fas fa-user-friends text-danger"></i> Alumni</button>
                            <button type="button" class="preset-badge-btn" onclick="addPresetMenu('info-corner', 'Info Corner', '#')"><i class="fas fa-info text-danger"></i> Info Corner</button>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right Column: Main Navigation Structure (Reorderable List) -->
            <div class="col-12 col-lg-8">
                <div class="card border rounded-3 shadow-sm">
                    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1 fw-bold text-dark"><i class="fas fa-stream text-danger me-2"></i> Main Navigation Structure</h6>
                            <small class="text-muted">Drag items or use the Up/Down buttons to reorder.</small>
                        </div>
                        <span class="badge bg-secondary rounded-pill" id="mainMenuCountBadge">10 items</span>
                    </div>
                    <div class="card-body p-3">
                        
                        <!-- Form to save menu -->
                        <form id="mainMenuForm" action="manage_header_footer.php" method="POST">
                            <input type="hidden" name="main_menu_json" id="mainMenuJsonInput" value="">
                            
                            <!-- Container where draggable cards render -->
                            <div id="mainMenuItemsContainer" class="mb-4">
                                <!-- Rendered dynamically by JS -->
                            </div>

                            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 pt-3 border-top">
                                <button type="submit" name="reset_main_menu" class="btn btn-outline-secondary btn-sm" onclick="return confirm('Reset all navigation tabs back to the original standard SRKU hierarchy?');">
                                    <i class="fas fa-undo me-1"></i> Reset to Default Hierarchy
                                </button>
                                <button type="button" class="btn btn-danger fw-bold px-4" onclick="saveMainMenuForm()">
                                    <i class="fas fa-save me-1"></i> Save Main Navigation Menu
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- ══════════════════════════════════════════════════════════════════════ -->
    <!-- TAB 2: TOP BAR QUICK LINKS -->
    <!-- ══════════════════════════════════════════════════════════════════════ -->
    <div class="tab-content-panel" id="panel-tab-topbar">
        <div class="row g-4">
            
            <div class="col-12 col-lg-4">
                <div class="card border rounded-3 shadow-sm">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h6 class="mb-0 fw-bold text-dark"><i class="fas fa-plus-circle text-warning me-2"></i> Add Top Bar Link</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Link Label</label>
                            <input type="text" id="addTopLabel" class="form-control form-control-sm" placeholder="e.g. Exam Time Table">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Link URL / Route</label>
                            <input type="text" id="addTopUrl" class="form-control form-control-sm" placeholder="exam-time-table.php or https://...">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Icon Class (FontAwesome)</label>
                            <input type="text" id="addTopIcon" class="form-control form-control-sm" placeholder="fas fa-calendar-alt text-warning" value="fas fa-link text-warning">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Target Window</label>
                            <select id="addTopTarget" class="form-select form-select-sm">
                                <option value="_self">Same Window (_self)</option>
                                <option value="_blank">New Window (_blank)</option>
                            </select>
                        </div>
                        <button type="button" class="btn btn-warning btn-sm w-100 fw-bold text-dark" onclick="addTopbarItem()">
                            <i class="fas fa-plus me-1"></i> Add to Topbar
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-8">
                <div class="card border rounded-3 shadow-sm">
                    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1 fw-bold text-dark"><i class="fas fa-stream text-warning me-2"></i> Topbar Quick Links Structure</h6>
                            <small class="text-muted">Reorder or edit links appearing in the uppermost dark blue top strip.</small>
                        </div>
                        <span class="badge bg-secondary rounded-pill" id="topbarCountBadge">8 items</span>
                    </div>
                    <div class="card-body p-3">
                        <form id="topbarForm" action="manage_header_footer.php" method="POST">
                            <input type="hidden" name="topbar_links_json" id="topbarLinksJsonInput" value="">
                            
                            <div id="topbarItemsContainer" class="mb-4">
                                <!-- Rendered dynamically by JS -->
                            </div>

                            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 pt-3 border-top">
                                <button type="submit" name="reset_topbar_links" class="btn btn-outline-secondary btn-sm" onclick="return confirm('Reset Topbar links to default?');">
                                    <i class="fas fa-undo me-1"></i> Reset Defaults
                                </button>
                                <button type="button" class="btn btn-warning fw-bold text-dark px-4" onclick="saveTopbarForm()">
                                    <i class="fas fa-save me-1"></i> Save Topbar Links
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- ══════════════════════════════════════════════════════════════════════ -->
    <!-- TAB 3: ERP LOGINS DROPDOWN -->
    <!-- ══════════════════════════════════════════════════════════════════════ -->
    <div class="tab-content-panel" id="panel-tab-erp">
        <div class="row g-4">
            
            <div class="col-12 col-lg-4">
                <div class="card border rounded-3 shadow-sm">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h6 class="mb-0 fw-bold text-dark"><i class="fas fa-key text-success me-2"></i> Add ERP Login Portal</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Portal Label</label>
                            <input type="text" id="addErpLabel" class="form-control form-control-sm" placeholder="e.g. Student ERP Portal">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Portal URL</label>
                            <input type="text" id="addErpUrl" class="form-control form-control-sm" placeholder="https://erp.srku.edu.in/">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Icon Class</label>
                            <input type="text" id="addErpIcon" class="form-control form-control-sm" placeholder="fas fa-user-graduate" value="fas fa-user-shield">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Target Window</label>
                            <select id="addErpTarget" class="form-select form-select-sm">
                                <option value="_blank">New Window (_blank)</option>
                                <option value="_self">Same Window (_self)</option>
                            </select>
                        </div>
                        <button type="button" class="btn btn-success btn-sm w-100 fw-bold" onclick="addErpItem()">
                            <i class="fas fa-plus me-1"></i> Add ERP Link
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-8">
                <div class="card border rounded-3 shadow-sm">
                    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1 fw-bold text-dark"><i class="fas fa-user-lock text-success me-2"></i> ERP Portals &amp; Login Destinations</h6>
                            <small class="text-muted">Direct URLs for student, faculty, and administrative portals.</small>
                        </div>
                        <span class="badge bg-secondary rounded-pill" id="erpCountBadge">4 items</span>
                    </div>
                    <div class="card-body p-3">
                        <form id="erpForm" action="manage_header_footer.php" method="POST">
                            <input type="hidden" name="erp_links_json" id="erpLinksJsonInput" value="">
                            
                            <div id="erpItemsContainer" class="mb-4">
                                <!-- Rendered dynamically by JS -->
                            </div>

                            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 pt-3 border-top">
                                <button type="submit" name="reset_erp_links" class="btn btn-outline-secondary btn-sm" onclick="return confirm('Reset ERP links to default?');">
                                    <i class="fas fa-undo me-1"></i> Reset Defaults
                                </button>
                                <button type="button" class="btn btn-success fw-bold px-4" onclick="saveErpForm()">
                                    <i class="fas fa-save me-1"></i> Save ERP Portals
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- ══════════════════════════════════════════════════════════════════════ -->
    <!-- TAB 4: BRAND & APPLY BUTTONS -->
    <!-- ══════════════════════════════════════════════════════════════════════ -->
    <div class="tab-content-panel" id="panel-tab-brand">
        <div style="max-width: 900px;">
            
            <!-- Brand Logo Upload Card -->
            <div class="card border rounded-3 shadow-sm mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h6 class="mb-0 fw-bold text-dark"><i class="fas fa-image text-danger me-2"></i> University Brand Logo Uploader</h6>
                </div>
                <div class="card-body">
                    <div class="row g-4 align-items-center">
                        <div class="col-12 col-md-4 text-center">
                            <div class="p-3 bg-light rounded-3 border">
                                <small class="text-muted d-block mb-2 fw-bold">ACTIVE LOGO PREVIEW</small>
                                <img src="<?php echo (strpos($logoUrl, 'http') === 0) ? $logoUrl : BASE_URL . $logoUrl; ?>" alt="SRKU Logo" style="max-height: 75px; max-width: 100%; object-fit: contain;" class="mb-2">
                                <div>
                                    <span class="badge bg-success-subtle text-success border">Active on Navbar &amp; Footer</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-8">
                            <form action="manage_header_footer.php" method="POST" enctype="multipart/form-data" class="mb-3">
                                <label class="form-label fw-bold text-dark small">Upload New Logo (PNG, WebP, SVG, JPG)</label>
                                <div class="input-group mb-1">
                                    <input type="file" name="logo_upload" class="form-control" accept=".png,.webp,.svg,.jpg,.jpeg" required>
                                    <button type="submit" class="btn btn-danger fw-bold"><i class="fas fa-cloud-upload-alt me-1"></i> Upload &amp; Set</button>
                                </div>
                                <small class="text-muted">Recommended: Transparent PNG or SVG with approx. 320x80 px resolution.</small>
                            </form>
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
            </div>

            <!-- Header CTA & Floating Widgets Form -->
            <form action="manage_header_footer.php" method="POST">
                <input type="hidden" name="header_logo_url" value="<?php echo sanitize($logoUrl); ?>">

                <!-- Header CTA Button -->
                <div class="card border rounded-3 shadow-sm mb-4">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h6 class="mb-0 fw-bold text-dark"><i class="fas fa-hand-pointer text-danger me-2"></i> Header Action Button (Far Right of Navbar)</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Button Label Text</label>
                                <input type="text" name="header_cta_text" class="form-control" value="<?php echo sanitize($ctaText); ?>" placeholder="Contact Us">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Button Destination Link</label>
                                <input type="text" name="header_cta_link" class="form-control" value="<?php echo sanitize($ctaLink); ?>" placeholder="contact.php">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Floating Quick Actions (WhatsApp, Admission Tab, Back to Top) -->
                <div class="card border rounded-3 shadow-sm mb-4">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h6 class="mb-0 fw-bold text-dark"><i class="fas fa-comment-dots text-success me-2"></i> Floating Quick Action Widgets</h6>
                    </div>
                    <div class="card-body">
                        
                        <!-- WhatsApp Chat Bubble -->
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
                </div>

                <!-- Custom Header & Footer Tracking Code -->
                <div class="card border rounded-3 shadow-sm mb-4">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h6 class="mb-0 fw-bold text-dark"><i class="fas fa-code text-info me-2"></i> Custom Scripts &amp; Tracking Codes</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark small">Header Custom Code (Injected into <code>&lt;head&gt;</code> — e.g. Google Tag Manager, Meta Pixel)</label>
                            <textarea name="header_custom_head_code" class="form-control font-monospace" rows="4" placeholder="<!-- Paste <script> or <meta> tags here -->"><?php echo htmlspecialchars($customHeadCode); ?></textarea>
                        </div>
                        <div>
                            <label class="form-label fw-bold text-dark small">Footer Custom Code (Injected before <code>&lt;/body&gt;</code> — e.g. Live Chat Widget, Analytics)</label>
                            <textarea name="footer_custom_scripts" class="form-control font-monospace" rows="4" placeholder="<!-- Paste custom JS tracking scripts here -->"><?php echo htmlspecialchars($footerCustomScripts); ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end mb-4">
                    <button type="submit" name="save_brand_settings" class="btn btn-danger btn-lg fw-bold px-5">
                        <i class="fas fa-save me-1"></i> Save Brand &amp; Button Customizations
                    </button>
                </div>
            </form>

        </div>
    </div>

    <!-- ══════════════════════════════════════════════════════════════════════ -->
    <!-- TAB 5: FOOTER & QUICK LINKS MANAGER -->
    <!-- ══════════════════════════════════════════════════════════════════════ -->
    <div class="tab-content-panel" id="panel-tab-footer">
        
        <form id="footerMasterForm" action="manage_header_footer.php" method="POST">
            <input type="hidden" name="footer_quick_links_json" id="footerQuickLinksJsonInput" value="">
            <input type="hidden" name="footer_units_links_json" id="footerUnitsLinksJsonInput" value="">
            
            <div class="row g-4 mb-4">
                
                <!-- Sub-Col 1: Footer Column 2 Quick Links Builder -->
                <div class="col-12 col-lg-6">
                    <div class="card border rounded-3 shadow-sm h-100">
                        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1 fw-bold text-dark"><i class="fas fa-list-ul text-warning me-2"></i> Footer Column 2: Quick Links</h6>
                                <small class="text-muted">Reorder, add, or edit links under "Quick Links".</small>
                            </div>
                            <span class="badge bg-secondary rounded-pill" id="footerQuickCountBadge">13 items</span>
                        </div>
                        <div class="card-body">
                            
                            <!-- Add link row -->
                            <div class="p-2 bg-light rounded-3 border mb-3">
                                <small class="fw-bold text-muted d-block mb-1">Add Quick Link</small>
                                <div class="row g-2">
                                    <div class="col-md-5">
                                        <input type="text" id="addFqlLabel" class="form-control form-control-sm" placeholder="Label, e.g. Photo Gallery">
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" id="addFqlUrl" class="form-control form-control-sm" placeholder="URL, e.g. gallery.php">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-warning btn-sm w-100 fw-bold text-dark" onclick="addFooterQuickItem()">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div id="footerQuickItemsContainer">
                                <!-- Rendered dynamically by JS -->
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Sub-Col 2: Footer Column 3 Constituent Units Builder -->
                <div class="col-12 col-lg-6">
                    <div class="card border rounded-3 shadow-sm h-100">
                        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1 fw-bold text-dark"><i class="fas fa-university text-danger me-2"></i> Footer Column 3: Constituent Units</h6>
                                <small class="text-muted">Reorder, add, or edit constituent unit links.</small>
                            </div>
                            <span class="badge bg-secondary rounded-pill" id="footerUnitsCountBadge">11 items</span>
                        </div>
                        <div class="card-body">
                            
                            <!-- Add unit row -->
                            <div class="p-2 bg-light rounded-3 border mb-3">
                                <small class="fw-bold text-muted d-block mb-1">Add Constituent Unit Link</small>
                                <div class="row g-2">
                                    <div class="col-md-5">
                                        <input type="text" id="addFcuLabel" class="form-control form-control-sm" placeholder="Label, e.g. RKDF Dental">
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" id="addFcuUrl" class="form-control form-control-sm" placeholder="URL, e.g. https://...">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-danger btn-sm w-100 fw-bold" onclick="addFooterUnitItem()">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div id="footerUnitsItemsContainer">
                                <!-- Rendered dynamically by JS -->
                            </div>

                        </div>
                    </div>
                </div>

            </div>

            <!-- Footer Text & Social Details -->
            <div class="card border rounded-3 shadow-sm mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h6 class="mb-0 fw-bold text-dark"><i class="fas fa-info-circle text-primary me-2"></i> Footer Column 1: About, Social &amp; Legal Notices</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small">Footer Column 1 Title</label>
                            <input type="text" name="footer_about_heading" class="form-control" value="<?php echo sanitize($footerHeading); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small">Footer UGC Accreditation Text</label>
                            <input type="text" name="footer_ugc_text" class="form-control" value="<?php echo sanitize($footerUgc); ?>">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold text-dark small mb-1">Footer About / University Summary (Rich Editor)</label>
                            <textarea name="footer_about_text" class="form-control rich-editor" rows="5"><?php echo htmlspecialchars($footerAbout); ?></textarea>
                        </div>
                    </div>

                    <!-- Social Media Links -->
                    <h6 class="fw-bold text-dark mt-4 mb-2 small text-uppercase">Official Social Media Profiles</h6>
                    <div class="row g-3 mb-3">
                        <div class="col-md-3">
                            <label class="form-label small text-muted"><i class="fab fa-facebook text-primary me-1"></i> Facebook Page</label>
                            <input type="text" name="facebook_url" class="form-control form-control-sm" value="<?php echo sanitize($fbUrl); ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small text-muted"><i class="fab fa-instagram text-danger me-1"></i> Instagram Profile</label>
                            <input type="text" name="instagram_url" class="form-control form-control-sm" value="<?php echo sanitize($instaUrl); ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small text-muted"><i class="fab fa-youtube text-danger me-1"></i> YouTube Channel</label>
                            <input type="text" name="youtube_url" class="form-control form-control-sm" value="<?php echo sanitize($ytUrl); ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small text-muted"><i class="fab fa-linkedin text-info me-1"></i> LinkedIn Page</label>
                            <input type="text" name="linkedin_url" class="form-control form-control-sm" value="<?php echo sanitize($liUrl); ?>">
                        </div>
                    </div>

                    <!-- Campus Contact Information -->
                    <h6 class="fw-bold text-dark mt-4 mb-2 small text-uppercase">Campus Contact &amp; Copyright Details</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Helpline Phone</label>
                            <input type="text" name="footer_phone" class="form-control form-control-sm" value="<?php echo sanitize($footerPhone); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Official Email Address</label>
                            <input type="email" name="footer_email" class="form-control form-control-sm" value="<?php echo sanitize($footerEmail); ?>">
                        </div>
                        <div class="col-12">
                            <label class="form-label small text-muted">Campus Address</label>
                            <textarea name="footer_address" class="form-control form-control-sm" rows="2"><?php echo sanitize($footerAddress); ?></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label small text-muted">Bottom Copyright Notice</label>
                            <input type="text" name="footer_copyright_text" class="form-control form-control-sm" value="<?php echo sanitize($footerCopyright); ?>">
                        </div>
                    </div>

                </div>
            </div>

            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-5">
                <button type="submit" name="reset_footer_links" class="btn btn-outline-secondary btn-sm" onclick="return confirm('Reset footer quick links and constituent units to defaults?');">
                    <i class="fas fa-undo me-1"></i> Reset Footer Columns to Defaults
                </button>
                <button type="button" class="btn btn-danger btn-lg fw-bold px-5" onclick="saveFooterMasterForm()">
                    <i class="fas fa-save me-1"></i> Save Footer &amp; Quick Links Customizations
                </button>
            </div>

        </form>

    </div>

</div>

<!-- Data injection into JavaScript -->
<script>
// Initial Data loaded from PHP
var mainMenuItems = <?php echo json_encode($currentMainMenu, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?> || [];
var topbarItems = <?php echo json_encode($currentTopbarLinks, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?> || [];
var erpItems = <?php echo json_encode($currentErpLinks, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?> || [];
var footerQuickItems = <?php echo json_encode($currentFooterQuickLinks, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?> || [];
var footerUnitsItems = <?php echo json_encode($currentFooterUnitsLinks, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?> || [];

// Copy Logo URL helper
function copyLogoUrl() {
    const input = document.getElementById('logoFullUrlInput');
    input.select();
    input.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(input.value).then(() => {
        alert('Active Logo URL copied to clipboard: ' + input.value);
    });
}

// ─────────────────────────────────────────────────────────────────────────────
// TAB SWITCHING WITH HASH SUPPORT
// ─────────────────────────────────────────────────────────────────────────────
function initTabs() {
    const tabButtons = document.querySelectorAll('.menu-nav-tab');
    const tabPanels = document.querySelectorAll('.tab-content-panel');

    function activateTab(tabId) {
        tabButtons.forEach(btn => {
            btn.classList.toggle('active', btn.getAttribute('data-tab') === tabId);
        });
        tabPanels.forEach(p => {
            p.classList.toggle('active', p.id === 'panel-' + tabId);
        });
    }

    tabButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const tabId = this.getAttribute('data-tab');
            window.location.hash = tabId;
            activateTab(tabId);
        });
    });

    // Check hash on load
    const currentHash = window.location.hash.replace('#', '');
    if (currentHash && document.getElementById('panel-' + currentHash)) {
        activateTab(currentHash);
    }
}

// ─────────────────────────────────────────────────────────────────────────────
// 1. MAIN NAVIGATION MENU BUILDER
// ─────────────────────────────────────────────────────────────────────────────
function renderMainMenu() {
    const container = document.getElementById('mainMenuItemsContainer');
    const countBadge = document.getElementById('mainMenuCountBadge');
    container.innerHTML = '';
    countBadge.innerText = mainMenuItems.length + ' items';

    if (mainMenuItems.length === 0) {
        container.innerHTML = '<div class="alert alert-warning text-center py-4">No navigation items found. Click "+ Add to Menu" or select a preset from the left panel to begin.</div>';
        return;
    }

    mainMenuItems.forEach((item, index) => {
        const card = document.createElement('div');
        card.className = 'menu-item-card';
        card.id = 'menu_card_' + index;
        card.draggable = true;

        // Tag label
        let tagText = 'Custom Link';
        let tagBadgeClass = 'bg-secondary-subtle text-secondary';
        if (item.preset) {
            tagText = 'Mega Menu: ' + item.preset.toUpperCase();
            tagBadgeClass = 'bg-danger-subtle text-danger border border-danger-subtle';
        } else if (item.type === 'dropdown') {
            tagText = 'Dropdown Menu';
            tagBadgeClass = 'bg-primary-subtle text-primary border border-primary-subtle';
        }

        // Subitems list if standard dropdown
        let subitemsHtml = '';
        if (item.type === 'dropdown' || (!item.preset && item.items && item.items.length > 0)) {
            const subs = item.items || [];
            let rowsHtml = '';
            subs.forEach((sub, sIndex) => {
                rowsHtml += `
                    <div class="submenu-item-row">
                        <div>
                            <strong>${escapeHtml(sub.label)}</strong>
                            <small class="text-muted ms-2">${escapeHtml(sub.url || '')}</small>
                        </div>
                        <div class="d-flex gap-1">
                            <button type="button" class="btn btn-outline-danger btn-xs py-0 px-1" onclick="deleteSubItem(${index}, ${sIndex})"><i class="fas fa-times"></i></button>
                        </div>
                    </div>
                `;
            });

            subitemsHtml = `
                <div class="mt-3 pt-3 border-top">
                    <label class="form-label small fw-bold text-dark d-flex justify-content-between">
                        <span><i class="fas fa-level-down-alt me-1 text-primary"></i> Submenu Links (${subs.length})</span>
                    </label>
                    <div class="p-2 bg-white rounded border mb-2">
                        <div class="row g-1">
                            <div class="col-5"><input type="text" id="sub_label_${index}" class="form-control form-control-sm" placeholder="Sub link label"></div>
                            <div class="col-5"><input type="text" id="sub_url_${index}" class="form-control form-control-sm" placeholder="Sub link route / URL"></div>
                            <div class="col-2"><button type="button" class="btn btn-primary btn-sm w-100" onclick="addSubItem(${index})"><i class="fas fa-plus"></i></button></div>
                        </div>
                    </div>
                    <div class="submenu-list">
                        ${rowsHtml || '<div class="text-muted small text-center py-2">No sub-items added yet.</div>'}
                    </div>
                </div>
            `;
        }

        card.innerHTML = `
            <div class="menu-item-header" onclick="toggleMenuCard(${index}, event)">
                <div class="d-flex align-items-center">
                    <span class="menu-item-drag-handle" title="Drag to reorder"><i class="fas fa-grip-vertical"></i></span>
                    <span class="menu-item-title">
                        <span>${escapeHtml(item.label)}</span>
                        <span class="menu-item-tag ${tagBadgeClass}">${tagText}</span>
                    </span>
                </div>
                <div class="menu-item-actions">
                    <button type="button" class="menu-btn-icon menu-btn-move" title="Move Up" onclick="moveMenuItem(${index}, -1, event)"><i class="fas fa-arrow-up"></i></button>
                    <button type="button" class="menu-btn-icon menu-btn-move" title="Move Down" onclick="moveMenuItem(${index}, 1, event)"><i class="fas fa-arrow-down"></i></button>
                    <button type="button" class="menu-btn-icon menu-btn-toggle" title="Edit details" onclick="toggleMenuCard(${index}, event)"><i class="fas fa-chevron-down"></i></button>
                </div>
            </div>
            <div class="menu-item-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-muted">Navigation Label</label>
                        <input type="text" class="form-control form-control-sm" value="${escapeHtml(item.label)}" onchange="updateMenuItemProp(${index}, 'label', this.value)">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-muted">Link URL / Route</label>
                        <input type="text" class="form-control form-control-sm" value="${escapeHtml(item.url || '')}" onchange="updateMenuItemProp(${index}, 'url', this.value)">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-muted">Target Window</label>
                        <select class="form-select form-select-sm" onchange="updateMenuItemProp(${index}, 'target', this.value)">
                            <option value="_self" ${item.target === '_self' ? 'selected' : ''}>Same Window (_self)</option>
                            <option value="_blank" ${item.target === '_blank' ? 'selected' : ''}>New Window (_blank)</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-muted">Badge / Pill Text (Optional)</label>
                        <input type="text" class="form-control form-control-sm" placeholder="e.g. New" value="${escapeHtml(item.badge || '')}" onchange="updateMenuItemProp(${index}, 'badge', this.value)">
                    </div>
                </div>

                ${subitemsHtml}

                <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                    <button type="button" class="btn btn-link text-danger btn-sm p-0 text-decoration-none fw-semibold" onclick="deleteMenuItem(${index})">
                        <i class="fas fa-trash-alt me-1"></i> Remove Item from Menu
                    </button>
                    <button type="button" class="btn btn-outline-secondary btn-sm btn-close-editor" onclick="toggleMenuCard(${index}, event)">Close Editor</button>
                </div>
            </div>
        `;

        // Setup Drag & Drop Handlers
        card.addEventListener('dragstart', (e) => {
            card.classList.add('is-dragging');
            e.dataTransfer.setData('text/plain', index);
        });
        card.addEventListener('dragend', () => {
            card.classList.remove('is-dragging');
            document.querySelectorAll('.menu-item-card').forEach(c => c.classList.remove('drag-over'));
        });
        card.addEventListener('dragover', (e) => {
            e.preventDefault();
            card.classList.add('drag-over');
        });
        card.addEventListener('dragleave', () => {
            card.classList.remove('drag-over');
        });
        card.addEventListener('drop', (e) => {
            e.preventDefault();
            card.classList.remove('drag-over');
            const fromIndex = parseInt(e.dataTransfer.getData('text/plain'), 10);
            const toIndex = index;
            if (!isNaN(fromIndex) && fromIndex !== toIndex) {
                const moved = mainMenuItems.splice(fromIndex, 1)[0];
                mainMenuItems.splice(toIndex, 0, moved);
                renderMainMenu();
            }
        });

        container.appendChild(card);
    });
}

function toggleMenuCard(index, event) {
    if (event) {
        // Stop propagation so multiple nested triggers don't conflict
        event.stopPropagation();
        
        // If clicking on Move Up/Down button, do NOT toggle
        if (event.target.closest('.menu-btn-move')) {
            return;
        }

        // If clicking inside the body (inputs, selects, buttons inside body), do not toggle UNLESS it's the Close Editor button
        if (event.target.closest('.menu-item-body')) {
            if (!event.target.closest('.btn-close-editor')) {
                return;
            }
        }
    }
    const card = document.getElementById('menu_card_' + index);
    if (card) {
        card.classList.toggle('expanded');
    }
}

function moveMenuItem(index, delta, event) {
    if (event) event.stopPropagation();
    const newIndex = index + delta;
    if (newIndex < 0 || newIndex >= mainMenuItems.length) return;
    const item = mainMenuItems.splice(index, 1)[0];
    mainMenuItems.splice(newIndex, 0, item);
    renderMainMenu();
}

function updateMenuItemProp(index, prop, value) {
    if (mainMenuItems[index]) {
        mainMenuItems[index][prop] = value;
    }
}

function deleteMenuItem(index) {
    if (confirm('Are you sure you want to delete "' + mainMenuItems[index].label + '" from the menu?')) {
        mainMenuItems.splice(index, 1);
        renderMainMenu();
    }
}

function addCustomMenuItem() {
    const label = document.getElementById('addMenuLabel').value.trim();
    const url = document.getElementById('addMenuUrl').value.trim();
    const target = document.getElementById('addMenuTarget').value;
    const type = document.getElementById('addMenuType').value;

    if (!label) {
        alert('Please enter a Navigation Label.');
        return;
    }

    const newItem = {
        id: 'menu_custom_' + Date.now(),
        label: label,
        url: url,
        target: target,
        type: type,
        preset: '',
        badge: '',
        items: []
    };

    mainMenuItems.push(newItem);
    document.getElementById('addMenuLabel').value = '';
    document.getElementById('addMenuUrl').value = '';
    renderMainMenu();
    
    // Auto-expand newly added item
    setTimeout(() => {
        const lastIdx = mainMenuItems.length - 1;
        const card = document.getElementById('menu_card_' + lastIdx);
        if (card) card.classList.add('expanded');
    }, 50);
}

function addPresetMenu(presetKey, defaultLabel, defaultUrl) {
    // Check if preset already exists
    const exists = mainMenuItems.some(m => m.preset === presetKey);
    if (exists && !confirm('The preset "' + defaultLabel + '" already exists in your menu. Add another one anyway?')) {
        return;
    }

    const newItem = {
        id: 'menu_' + presetKey + '_' + Date.now(),
        label: defaultLabel,
        url: defaultUrl,
        target: '_self',
        type: (presetKey === 'home') ? 'link' : ((presetKey === 'departments' || presetKey === 'syllabus' || presetKey === 'about') ? 'megamenu' : 'dropdown'),
        preset: presetKey,
        badge: '',
        items: []
    };

    mainMenuItems.push(newItem);
    renderMainMenu();
}

function addSubItem(parentIndex) {
    const labelInput = document.getElementById('sub_label_' + parentIndex);
    const urlInput = document.getElementById('sub_url_' + parentIndex);
    const label = labelInput.value.trim();
    const url = urlInput.value.trim();

    if (!label) {
        alert('Please enter a sub-link label.');
        return;
    }

    if (!mainMenuItems[parentIndex].items) {
        mainMenuItems[parentIndex].items = [];
    }

    mainMenuItems[parentIndex].items.push({
        label: label,
        url: url,
        target: '_self'
    });

    labelInput.value = '';
    urlInput.value = '';
    renderMainMenu();

    setTimeout(() => {
        const card = document.getElementById('menu_card_' + parentIndex);
        if (card) card.classList.add('expanded');
    }, 50);
}

function deleteSubItem(parentIndex, subIndex) {
    if (mainMenuItems[parentIndex] && mainMenuItems[parentIndex].items) {
        mainMenuItems[parentIndex].items.splice(subIndex, 1);
        renderMainMenu();
        setTimeout(() => {
            const card = document.getElementById('menu_card_' + parentIndex);
            if (card) card.classList.add('expanded');
        }, 50);
    }
}

function saveMainMenuForm() {
    document.getElementById('mainMenuJsonInput').value = JSON.stringify(mainMenuItems);
    document.getElementById('mainMenuForm').submit();
}

// ─────────────────────────────────────────────────────────────────────────────
// 2. TOPBAR QUICK LINKS BUILDER
// ─────────────────────────────────────────────────────────────────────────────
function renderTopbar() {
    const container = document.getElementById('topbarItemsContainer');
    const badge = document.getElementById('topbarCountBadge');
    container.innerHTML = '';
    badge.innerText = topbarItems.length + ' items';

    topbarItems.forEach((item, index) => {
        const row = document.createElement('div');
        row.className = 'menu-item-card p-2 px-3 d-flex align-items-center justify-content-between';
        row.draggable = true;
        row.innerHTML = `
            <div class="d-flex align-items-center gap-2">
                <span class="menu-item-drag-handle"><i class="fas fa-grip-vertical"></i></span>
                <i class="${escapeHtml(item.icon || 'fas fa-link')}"></i>
                <strong>${escapeHtml(item.label)}</strong>
                <small class="text-muted ms-2">(${escapeHtml(item.url)})</small>
            </div>
            <div class="d-flex align-items-center gap-1">
                <button type="button" class="menu-btn-icon" onclick="moveTopbarItem(${index}, -1)"><i class="fas fa-arrow-up"></i></button>
                <button type="button" class="menu-btn-icon" onclick="moveTopbarItem(${index}, 1)"><i class="fas fa-arrow-down"></i></button>
                <button type="button" class="menu-btn-icon text-danger" onclick="deleteTopbarItem(${index})"><i class="fas fa-trash-alt"></i></button>
            </div>
        `;

        row.addEventListener('dragstart', (e) => { e.dataTransfer.setData('text/plain', index); });
        row.addEventListener('dragover', (e) => { e.preventDefault(); });
        row.addEventListener('drop', (e) => {
            e.preventDefault();
            const from = parseInt(e.dataTransfer.getData('text/plain'), 10);
            if (!isNaN(from) && from !== index) {
                const moved = topbarItems.splice(from, 1)[0];
                topbarItems.splice(index, 0, moved);
                renderTopbar();
            }
        });

        container.appendChild(row);
    });
}

function addTopbarItem() {
    const label = document.getElementById('addTopLabel').value.trim();
    const url = document.getElementById('addTopUrl').value.trim();
    const icon = document.getElementById('addTopIcon').value.trim();
    const target = document.getElementById('addTopTarget').value;

    if (!label) { alert('Enter topbar label.'); return; }
    topbarItems.push({
        id: 'top_' + Date.now(),
        label: label,
        url: url,
        icon: icon || 'fas fa-link text-warning',
        target: target
    });
    document.getElementById('addTopLabel').value = '';
    document.getElementById('addTopUrl').value = '';
    renderTopbar();
}

function moveTopbarItem(idx, delta) {
    const n = idx + delta;
    if (n < 0 || n >= topbarItems.length) return;
    const item = topbarItems.splice(idx, 1)[0];
    topbarItems.splice(n, 0, item);
    renderTopbar();
}

function deleteTopbarItem(idx) {
    if (confirm('Delete topbar link: ' + topbarItems[idx].label + '?')) {
        topbarItems.splice(idx, 1);
        renderTopbar();
    }
}

function saveTopbarForm() {
    document.getElementById('topbarLinksJsonInput').value = JSON.stringify(topbarItems);
    document.getElementById('topbarForm').submit();
}

// ─────────────────────────────────────────────────────────────────────────────
// 3. ERP LOGINS BUILDER
// ─────────────────────────────────────────────────────────────────────────────
function renderErp() {
    const container = document.getElementById('erpItemsContainer');
    const badge = document.getElementById('erpCountBadge');
    container.innerHTML = '';
    badge.innerText = erpItems.length + ' items';

    erpItems.forEach((item, index) => {
        const row = document.createElement('div');
        row.className = 'menu-item-card p-2 px-3 d-flex align-items-center justify-content-between';
        row.draggable = true;
        row.innerHTML = `
            <div class="d-flex align-items-center gap-2">
                <span class="menu-item-drag-handle"><i class="fas fa-grip-vertical"></i></span>
                <i class="${escapeHtml(item.icon || 'fas fa-key text-success')}"></i>
                <strong>${escapeHtml(item.label)}</strong>
                <small class="text-muted ms-2">(${escapeHtml(item.url)})</small>
            </div>
            <div class="d-flex align-items-center gap-1">
                <button type="button" class="menu-btn-icon" onclick="moveErpItem(${index}, -1)"><i class="fas fa-arrow-up"></i></button>
                <button type="button" class="menu-btn-icon" onclick="moveErpItem(${index}, 1)"><i class="fas fa-arrow-down"></i></button>
                <button type="button" class="menu-btn-icon text-danger" onclick="deleteErpItem(${index})"><i class="fas fa-trash-alt"></i></button>
            </div>
        `;
        row.addEventListener('dragstart', (e) => { e.dataTransfer.setData('text/plain', index); });
        row.addEventListener('dragover', (e) => { e.preventDefault(); });
        row.addEventListener('drop', (e) => {
            e.preventDefault();
            const from = parseInt(e.dataTransfer.getData('text/plain'), 10);
            if (!isNaN(from) && from !== index) {
                const moved = erpItems.splice(from, 1)[0];
                erpItems.splice(index, 0, moved);
                renderErp();
            }
        });
        container.appendChild(row);
    });
}

function addErpItem() {
    const label = document.getElementById('addErpLabel').value.trim();
    const url = document.getElementById('addErpUrl').value.trim();
    const icon = document.getElementById('addErpIcon').value.trim();
    const target = document.getElementById('addErpTarget').value;
    if (!label) { alert('Enter ERP label.'); return; }
    erpItems.push({
        id: 'erp_' + Date.now(),
        label: label,
        url: url,
        icon: icon || 'fas fa-user-shield',
        target: target
    });
    document.getElementById('addErpLabel').value = '';
    document.getElementById('addErpUrl').value = '';
    renderErp();
}

function moveErpItem(idx, delta) {
    const n = idx + delta;
    if (n < 0 || n >= erpItems.length) return;
    const it = erpItems.splice(idx, 1)[0];
    erpItems.splice(n, 0, it);
    renderErp();
}

function deleteErpItem(idx) {
    if (confirm('Delete ERP link: ' + erpItems[idx].label + '?')) {
        erpItems.splice(idx, 1);
        renderErp();
    }
}

function saveErpForm() {
    document.getElementById('erpLinksJsonInput').value = JSON.stringify(erpItems);
    document.getElementById('erpForm').submit();
}

// ─────────────────────────────────────────────────────────────────────────────
// 5. FOOTER QUICK LINKS & UNITS BUILDER
// ─────────────────────────────────────────────────────────────────────────────
function renderFooterQuick() {
    const container = document.getElementById('footerQuickItemsContainer');
    const badge = document.getElementById('footerQuickCountBadge');
    container.innerHTML = '';
    badge.innerText = footerQuickItems.length + ' items';

    footerQuickItems.forEach((item, index) => {
        const row = document.createElement('div');
        row.className = 'menu-item-card p-2 px-3 d-flex align-items-center justify-content-between mb-2';
        row.draggable = true;
        row.innerHTML = `
            <div class="d-flex align-items-center gap-2">
                <span class="menu-item-drag-handle"><i class="fas fa-grip-vertical"></i></span>
                <strong>${escapeHtml(item.label)}</strong>
                <small class="text-muted">(${escapeHtml(item.url)})</small>
            </div>
            <div class="d-flex align-items-center gap-1">
                <button type="button" class="menu-btn-icon" onclick="moveFooterQuickItem(${index}, -1)"><i class="fas fa-arrow-up"></i></button>
                <button type="button" class="menu-btn-icon" onclick="moveFooterQuickItem(${index}, 1)"><i class="fas fa-arrow-down"></i></button>
                <button type="button" class="menu-btn-icon text-danger" onclick="deleteFooterQuickItem(${index})"><i class="fas fa-trash-alt"></i></button>
            </div>
        `;
        row.addEventListener('dragstart', (e) => { e.dataTransfer.setData('text/plain', index); });
        row.addEventListener('dragover', (e) => { e.preventDefault(); });
        row.addEventListener('drop', (e) => {
            e.preventDefault();
            const from = parseInt(e.dataTransfer.getData('text/plain'), 10);
            if (!isNaN(from) && from !== index) {
                const moved = footerQuickItems.splice(from, 1)[0];
                footerQuickItems.splice(index, 0, moved);
                renderFooterQuick();
            }
        });
        container.appendChild(row);
    });
}

function addFooterQuickItem() {
    const label = document.getElementById('addFqlLabel').value.trim();
    const url = document.getElementById('addFqlUrl').value.trim();
    if (!label) { alert('Enter quick link label.'); return; }
    footerQuickItems.push({
        id: 'fql_' + Date.now(),
        label: label,
        url: url,
        target: '_self'
    });
    document.getElementById('addFqlLabel').value = '';
    document.getElementById('addFqlUrl').value = '';
    renderFooterQuick();
}

function moveFooterQuickItem(idx, delta) {
    const n = idx + delta;
    if (n < 0 || n >= footerQuickItems.length) return;
    const it = footerQuickItems.splice(idx, 1)[0];
    footerQuickItems.splice(n, 0, it);
    renderFooterQuick();
}

function deleteFooterQuickItem(idx) {
    if (confirm('Delete footer quick link: ' + footerQuickItems[idx].label + '?')) {
        footerQuickItems.splice(idx, 1);
        renderFooterQuick();
    }
}

function renderFooterUnits() {
    const container = document.getElementById('footerUnitsItemsContainer');
    const badge = document.getElementById('footerUnitsCountBadge');
    container.innerHTML = '';
    badge.innerText = footerUnitsItems.length + ' items';

    footerUnitsItems.forEach((item, index) => {
        const row = document.createElement('div');
        row.className = 'menu-item-card p-2 px-3 d-flex align-items-center justify-content-between mb-2';
        row.draggable = true;
        row.innerHTML = `
            <div class="d-flex align-items-center gap-2">
                <span class="menu-item-drag-handle"><i class="fas fa-grip-vertical"></i></span>
                <strong>${escapeHtml(item.label)}</strong>
                <small class="text-muted">(${escapeHtml(item.url)})</small>
            </div>
            <div class="d-flex align-items-center gap-1">
                <button type="button" class="menu-btn-icon" onclick="moveFooterUnitItem(${index}, -1)"><i class="fas fa-arrow-up"></i></button>
                <button type="button" class="menu-btn-icon" onclick="moveFooterUnitItem(${index}, 1)"><i class="fas fa-arrow-down"></i></button>
                <button type="button" class="menu-btn-icon text-danger" onclick="deleteFooterUnitItem(${index})"><i class="fas fa-trash-alt"></i></button>
            </div>
        `;
        row.addEventListener('dragstart', (e) => { e.dataTransfer.setData('text/plain', index); });
        row.addEventListener('dragover', (e) => { e.preventDefault(); });
        row.addEventListener('drop', (e) => {
            e.preventDefault();
            const from = parseInt(e.dataTransfer.getData('text/plain'), 10);
            if (!isNaN(from) && from !== index) {
                const moved = footerUnitsItems.splice(from, 1)[0];
                footerUnitsItems.splice(index, 0, moved);
                renderFooterUnits();
            }
        });
        container.appendChild(row);
    });
}

function addFooterUnitItem() {
    const label = document.getElementById('addFcuLabel').value.trim();
    const url = document.getElementById('addFcuUrl').value.trim();
    if (!label) { alert('Enter constituent unit label.'); return; }
    footerUnitsItems.push({
        id: 'fcu_' + Date.now(),
        label: label,
        url: url,
        target: (url.indexOf('http') === 0) ? '_blank' : '_self'
    });
    document.getElementById('addFcuLabel').value = '';
    document.getElementById('addFcuUrl').value = '';
    renderFooterUnits();
}

function moveFooterUnitItem(idx, delta) {
    const n = idx + delta;
    if (n < 0 || n >= footerUnitsItems.length) return;
    const it = footerUnitsItems.splice(idx, 1)[0];
    footerUnitsItems.splice(n, 0, it);
    renderFooterUnits();
}

function deleteFooterUnitItem(idx) {
    if (confirm('Delete unit link: ' + footerUnitsItems[idx].label + '?')) {
        footerUnitsItems.splice(idx, 1);
        renderFooterUnits();
    }
}

function saveFooterMasterForm() {
    document.getElementById('footerQuickLinksJsonInput').value = JSON.stringify(footerQuickItems);
    document.getElementById('footerUnitsLinksJsonInput').value = JSON.stringify(footerUnitsItems);
    
    // Add input flag so PHP recognizes save_footer_settings
    let hiddenSave = document.getElementById('saveFooterFlag');
    if (!hiddenSave) {
        hiddenSave = document.createElement('input');
        hiddenSave.type = 'hidden';
        hiddenSave.id = 'saveFooterFlag';
        hiddenSave.name = 'save_footer_settings';
        hiddenSave.value = '1';
        document.getElementById('footerMasterForm').appendChild(hiddenSave);
    }
    document.getElementById('footerMasterForm').submit();
}

// Utility HTML escape
function escapeHtml(text) {
    if (!text) return '';
    return text.toString()
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

// Initialize on DOM Ready
document.addEventListener('DOMContentLoaded', function() {
    initTabs();
    renderMainMenu();
    renderTopbar();
    renderErp();
    renderFooterQuick();
    renderFooterUnits();
});
</script>

<?php require_once __DIR__ . '/footer.php'; ?>
