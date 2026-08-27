<?php
require_once __DIR__ . '/header.php';
$pdo = getDBConnection();

// Ensure page_slug column exists in banners
try {
    $pdo->exec("ALTER TABLE banners ADD COLUMN page_slug VARCHAR(100) DEFAULT 'home'");
} catch (Exception $e) {}

// Handle Delete
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM banners WHERE id = :id");
    $stmt->execute([':id' => $id]);
    setFlashMsg('success', 'Banner removed successfully.');
    header("Location: manage_banners.php");
    exit;
}

// Handle Edit Fetch
$editBanner = null;
if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM banners WHERE id = :id LIMIT 1");
    $stmt->execute([':id' => $id]);
    $editBanner = $stmt->fetch();
}

// Handle Add / Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_banner'])) {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $page_slug = trim((string)($_POST['page_slug'] ?? 'home'));
    $title = trim((string)($_POST['title'] ?? ''));
    $subtitle = trim((string)($_POST['subtitle'] ?? ''));
    $image_url = trim((string)($_POST['image_url'] ?? ''));
    $btn_text = trim((string)($_POST['btn_text'] ?? ''));
    $btn_link = trim((string)($_POST['btn_link'] ?? ''));
    $sort_order = (int)($_POST['sort_order'] ?? 0);

    if ($id > 0) {
        $stmt = $pdo->prepare("UPDATE banners SET page_slug = :ps, title = :t, subtitle = :s, image_url = :img, btn_text = :bt, btn_link = :bl, sort_order = :so WHERE id = :id");
        $stmt->execute([':ps' => $page_slug, ':t' => $title, ':s' => $subtitle, ':img' => $image_url, ':bt' => $btn_text, ':bl' => $btn_link, ':so' => $sort_order, ':id' => $id]);
        setFlashMsg('success', 'Banner updated successfully.');
    } else {
        $stmt = $pdo->prepare("INSERT INTO banners (page_slug, title, subtitle, image_url, btn_text, btn_link, sort_order) VALUES (:ps, :t, :s, :img, :bt, :bl, :so)");
        $stmt->execute([':ps' => $page_slug, ':t' => $title, ':s' => $subtitle, ':img' => $image_url, ':bt' => $btn_text, ':bl' => $btn_link, ':so' => $sort_order]);
        setFlashMsg('success', 'Banner created successfully.');
    }
    header("Location: manage_banners.php");
    exit;
}

$pageOptions = [
    'home' => 'Homepage',
    'about' => 'About Us (about.php)',
    'why-srk' => 'Why SRK University',
    'vision-mission' => 'Vision & Mission',
    'accreditation' => 'Accreditation & Approvals',
    'board-of-management' => 'Board of Management',
    'constituent-unit' => 'Constituent Units & Colleges',
    'admission' => 'Admission Guidelines',
    'departments' => 'All Departments / Faculties',
    'courses' => 'Course Directory (courses.php)',
    'syllabus' => 'Scheme & Syllabus (syllabus.php)',
    'placements' => 'Campus Placements (placements.php)',
    'facilities' => 'Campus Facilities (facilities.php)',
    'research-innovation' => 'Research & Innovation',
    'incubation-center' => 'Startup Incubation Centre',
    'student-life' => 'Student Life & Culture',
    'gallery' => 'Photo & Video Gallery',
    'alumni' => 'Alumni Network',
    'career' => 'Careers & Recruitment',
    'blogs' => 'News & Blogs Portal',
    'contact' => 'Contact Us (contact.php)'
];

$banners = $pdo->query("SELECT * FROM banners ORDER BY page_slug ASC, sort_order ASC, id DESC")->fetchAll();

// Handle Homepage Hero Video & Fallback Image Save
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_hero_video'])) {
    $videoUrl = normalizeMediaPath($_POST['hero_video_url'] ?? '', 'assets/images/concept2-hero.mp4');
    $fallbackImg = normalizeMediaPath($_POST['hero_fallback_image'] ?? '', 'assets/uploads/2026/08/srku-rkdf-building.jpeg');
    $heroTitle = trim((string)($_POST['hero_title'] ?? 'SRK University, Bhopal'));
    $heroSubtitle = trim((string)($_POST['hero_subtitle'] ?? 'UGC-Recognized University in MP'));
    $heroDesc = trim((string)($_POST['hero_desc'] ?? ''));

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

    $heroSettings = [
        'hero_video_url' => $videoUrl ?: 'assets/images/concept2-hero.mp4',
        'hero_fallback_image' => $fallbackImg ?: 'assets/uploads/2026/08/srku-rkdf-building.jpeg',
        'hero_title' => $heroTitle,
        'hero_subtitle' => $heroSubtitle,
        'hero_desc' => $heroDesc
    ];

    foreach ($heroSettings as $key => $val) {
        $stmt = $pdo->prepare("INSERT INTO settings (setting_key, setting_value) VALUES (:k, :v) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)");
        $stmt->execute([':k' => $key, ':v' => $val]);
    }

    setFlashMsg('success', 'Homepage Hero Video & Fallback Image settings updated successfully.');
    header("Location: manage_banners.php");
    exit;
}

$currHeroVideo = getSetting('hero_video_url', 'assets/images/concept2-hero.mp4');
$currHeroFallback = getSetting('hero_fallback_image', 'assets/uploads/2026/08/srku-rkdf-building.jpeg');
$currHeroTitle = getSetting('hero_title', 'SRK University, Bhopal');
$currHeroSubtitle = getSetting('hero_subtitle', 'UGC-Recognized University in MP');
$currHeroDesc = getSetting('hero_desc', 'Welcome to SRK University, a premier technical and academic ecosystem designed for global industry leadership. If you are looking for the best placement university in MP, our rigorous research, multi-disciplinary collaboration, and industry-aligned pedagogy deliver unmatched career growth.');
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="h4 fw-bold text-navy mb-1">Manage Page Banners &amp; Sliders</h3>
        <p class="text-muted small mb-0">Control the Homepage Hero Fullscreen Video, Fallback Poster Image, and Page Top Banners.</p>
    </div>
    <?php if (isset($_GET['action'])): ?>
        <a href="manage_banners.php" class="btn btn-outline-secondary btn-sm">&larr; Back to Banners List</a>
    <?php endif; ?>
</div>

<!-- ═══════════════════════════════════════════════════════
     SECTION: HOMEPAGE HERO VIDEO & FALLBACK POSTER MANAGER
═══════════════════════════════════════════════════════ -->
<div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-5 bg-white">
    <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom flex-wrap gap-2">
        <div class="d-flex align-items-center gap-3">
            <div class="p-3 rounded-circle bg-danger-subtle text-danger" style="font-size: 1.4rem;">
                <i class="fas fa-video"></i>
            </div>
            <div>
                <span class="badge bg-danger text-white px-3 py-1 rounded-pill small fw-bold">Live Banner Engine</span>
                <h4 class="fw-bold text-navy mb-0 mt-1">Homepage Hero Video &amp; Fallback Background</h4>
            </div>
        </div>
        <a href="<?php echo BASE_URL; ?>" target="_blank" class="btn btn-sm btn-outline-danger rounded-pill px-3">
            <i class="fas fa-external-link-alt me-1"></i> Preview Live Homepage
        </a>
    </div>

    <form action="manage_banners.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="save_hero_video" value="1">
        
        <div class="row g-4 align-items-start">
            
            <!-- Left: Current Live Video & Fallback Preview Player -->
            <div class="col-12 col-lg-5">
                <div class="p-3 rounded-4 bg-dark text-white shadow-sm">
                    <div class="d-flex justify-content-between align-items-center mb-2 px-1">
                        <span class="small fw-bold text-warning"><i class="fas fa-play-circle me-1"></i> Current Video Player</span>
                        <span class="badge bg-success text-white small">Live Active</span>
                    </div>
                    
                    <div class="position-relative rounded-3 overflow-hidden" style="max-height: 220px; background: #000;">
                        <video class="w-100 h-100 object-fit-cover" controls autoplay muted loop playsinline 
                               poster="<?php echo resolveMediaUrl($currHeroFallback, 'assets/uploads/2026/08/srku-rkdf-building.jpeg'); ?>">
                            <source src="<?php echo resolveMediaUrl($currHeroVideo, 'assets/images/concept2-hero.mp4'); ?>" type="video/mp4">
                            Your browser does not support HTML5 video.
                        </video>
                    </div>

                    <div class="mt-3 pt-2 border-top border-secondary small text-white-50">
                        <div class="text-truncate mb-1"><i class="fas fa-film text-info me-1"></i> <strong>Video:</strong> <?php echo sanitize($currHeroVideo); ?></div>
                        <div class="text-truncate"><i class="fas fa-image text-success me-1"></i> <strong>Poster:</strong> <?php echo sanitize($currHeroFallback); ?></div>
                    </div>
                </div>

                <!-- Fallback Image Dedicated Preview -->
                <div class="mt-3 p-3 rounded-4 bg-light border">
                    <span class="small fw-bold text-navy d-block mb-2"><i class="fas fa-shield-alt text-success me-1"></i> Fallback Image Preview (If Video Fails / Mobile Data Save)</span>
                    <div class="rounded-3 overflow-hidden" style="height: 120px;">
                        <img src="<?php echo resolveMediaUrl($currHeroFallback, 'assets/uploads/2026/08/srku-rkdf-building.jpeg'); ?>" 
                             onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/08/srku-rkdf-building.jpeg';"
                             alt="Hero Fallback" 
                             class="w-100 h-100 object-fit-cover">
                    </div>
                </div>
            </div>

            <!-- Right: Video & Image Controls -->
            <div class="col-12 col-lg-7">
                
                <!-- 1. Hero Video Config -->
                <div class="mb-4 p-3 rounded-3 bg-light border">
                    <h6 class="fw-bold text-navy mb-2"><i class="fas fa-film text-danger me-1"></i> 1. Hero Background Video (MP4 / WebM)</h6>
                    <div class="row g-2">
                        <div class="col-12 col-md-7">
                            <label class="form-label small text-muted mb-1">Video Relative Path or URL</label>
                            <input type="text" name="hero_video_url" class="form-control form-control-sm" value="<?php echo sanitize($currHeroVideo); ?>" placeholder="assets/images/SRK-Hero-Section.mp4">
                        </div>
                        <div class="col-12 col-md-5">
                            <label class="form-label small text-muted mb-1">OR Upload New Video</label>
                            <input type="file" name="video_file" class="form-control form-control-sm" accept="video/mp4,video/webm,video/ogg,video/quicktime">
                        </div>
                    </div>
                    <small class="text-muted d-block mt-1">Recommended format: 1080p MP4 (H.264), optimized under 20MB for fast load.</small>
                </div>

                <!-- 2. Fallback Image Config -->
                <div class="mb-4 p-3 rounded-3 bg-light border">
                    <h6 class="fw-bold text-navy mb-2"><i class="fas fa-image text-primary me-1"></i> 2. Fallback Poster Image (Zero-Fail Safety)</h6>
                    <div class="row g-2">
                        <div class="col-12 col-md-7">
                            <label class="form-label small text-muted mb-1">Image Relative Path or URL</label>
                            <input type="text" name="hero_fallback_image" class="form-control form-control-sm" value="<?php echo sanitize($currHeroFallback); ?>" placeholder="assets/uploads/2026/08/srku-rkdf-building.jpeg">
                        </div>
                        <div class="col-12 col-md-5">
                            <label class="form-label small text-muted mb-1">OR Upload New Image</label>
                            <input type="file" name="fallback_img_file" class="form-control form-control-sm" accept="image/jpeg,image/png,image/webp,image/jpg">
                        </div>
                    </div>
                    <small class="text-muted d-block mt-1">Default: <code>assets/uploads/2026/08/srku-rkdf-building.jpeg</code> (High-resolution campus building).</small>
                </div>

                <!-- 3. Hero Text Overlays -->
                <div class="row g-2 mb-3">
                    <div class="col-12 col-md-6">
                        <label class="form-label small fw-bold text-navy mb-1">Hero Main Title</label>
                        <input type="text" name="hero_title" class="form-control form-control-sm" value="<?php echo sanitize($currHeroTitle); ?>">
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label small fw-bold text-navy mb-1">Hero Golden Subtitle</label>
                        <input type="text" name="hero_subtitle" class="form-control form-control-sm" value="<?php echo sanitize($currHeroSubtitle); ?>">
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-bold text-navy mb-1">Hero Lead Description</label>
                        <textarea name="hero_desc" class="form-control form-control-sm" rows="2"><?php echo sanitize($currHeroDesc); ?></textarea>
                    </div>
                </div>

                <div class="text-end pt-2">
                    <button type="submit" class="btn btn-danger px-4 py-2 rounded-pill fw-bold shadow-sm">
                        <i class="fas fa-save me-1"></i> Save Hero Video &amp; Fallback Settings
                    </button>
                </div>

            </div>
        </div>
    </form>
</div>

<div class="row g-4">
    <!-- Form Col -->
    <div class="col-12 col-lg-5">
        <div class="card border-0 shadow-sm rounded-4 p-4 sticky-top" style="top: 20px;">
            <h4 class="h5 fw-bold text-navy mb-3">
                <?php echo $editBanner ? '<i class="fas fa-edit text-warning me-1"></i> Edit Banner' : '<i class="fas fa-plus-circle text-danger me-1"></i> Add Page Banner'; ?>
            </h4>
            
            <form action="manage_banners.php" method="POST">
                <?php if ($editBanner): ?>
                    <input type="hidden" name="id" value="<?php echo $editBanner['id']; ?>">
                <?php endif; ?>

                <!-- SECTION 1: Page Association -->
                <div class="admin-form-section">
                    <div class="admin-form-section-title">
                        <i class="fas fa-link text-danger"></i> Section 1: Page Association
                    </div>
                    <div class="mb-2">
                        <label class="form-label fw-bold text-dark small">Select Target Page *</label>
                        <select name="page_slug" class="form-select form-select-sm" required>
                            <?php foreach ($pageOptions as $slug => $label): ?>
                                <option value="<?php echo $slug; ?>" <?php echo (($editBanner['page_slug'] ?? '') === $slug) ? 'selected' : ''; ?>>
                                    <?php echo $label; ?> (<code><?php echo $slug; ?></code>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <!-- SECTION 2: Banner Content & Visuals -->
                <div class="admin-form-section">
                    <div class="admin-form-section-title">
                        <i class="fas fa-image text-warning"></i> Section 2: Banner Heading &amp; Background
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark small">Banner Heading / Title *</label>
                        <input type="text" name="title" class="form-control form-control-sm" value="<?php echo sanitize($editBanner['title'] ?? ''); ?>" placeholder="e.g. World-Class Campus Facilities" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark small">Banner Subtitle / Tagline</label>
                        <textarea name="subtitle" class="form-control form-control-sm" rows="2" placeholder="e.g. Excellence in Higher Education &amp; Research Innovation"><?php echo sanitize($editBanner['subtitle'] ?? ''); ?></textarea>
                    </div>
                    <div class="mb-2">
                        <label class="form-label fw-bold text-dark small">Background Image Path</label>
                        <input type="text" name="image_url" class="form-control form-control-sm" value="<?php echo sanitize($editBanner['image_url'] ?? ''); ?>" placeholder="assets/images/campus-1.webp">
                        <small class="text-muted" style="font-size:0.75rem;">Leave empty for brand blue-red gradient.</small>
                    </div>
                </div>

                <!-- SECTION 3: Call to Action & Order -->
                <div class="admin-form-section">
                    <div class="admin-form-section-title">
                        <i class="fas fa-mouse-pointer text-primary"></i> Section 3: Call to Action (CTA) &amp; Priority
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-bold text-dark small">Button Text</label>
                            <input type="text" name="btn_text" class="form-control form-control-sm" value="<?php echo sanitize($editBanner['btn_text'] ?? ''); ?>" placeholder="Apply Now">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold text-dark small">Button Link</label>
                            <input type="text" name="btn_link" class="form-control form-control-sm" value="<?php echo sanitize($editBanner['btn_link'] ?? ''); ?>" placeholder="contact.php">
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="form-label fw-bold text-dark small">Display Priority / Sort Order</label>
                        <input type="number" name="sort_order" class="form-control form-control-sm" value="<?php echo (int)($editBanner['sort_order'] ?? 0); ?>">
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" name="save_banner" class="btn btn-danger btn-sm px-4 fw-bold">
                        <i class="fas fa-save me-1"></i> <?php echo $editBanner ? 'Update Banner' : 'Save Banner'; ?>
                    </button>
                    <?php if ($editBanner): ?>
                        <a href="manage_banners.php" class="btn btn-light btn-sm">Cancel</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <!-- Table Col -->
    <div class="col-12 col-lg-7">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h4 class="h5 fw-bold text-navy mb-3">Active Page Banners (<?php echo count($banners); ?>)</h4>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Page Target</th>
                            <th>Banner Details</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($banners)): ?>
                            <?php foreach ($banners as $b): ?>
                                <tr>
                                    <td>
                                        <span class="badge bg-navy text-white px-2 py-1"><?php echo sanitize($pageOptions[$b['page_slug']] ?? $b['page_slug']); ?></span>
                                    </td>
                                    <td>
                                        <strong class="text-dark d-block"><?php echo sanitize($b['title']); ?></strong>
                                        <?php if (!empty($b['subtitle'])): ?>
                                            <small class="text-muted d-block"><?php echo sanitize(substr($b['subtitle'], 0, 50)) . '...'; ?></small>
                                        <?php endif; ?>
                                        <?php if (!empty($b['image_url'])): ?>
                                            <span class="badge bg-light text-secondary border mt-1"><i class="fas fa-image me-1"></i> Custom BG</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-end text-nowrap">
                                        <div class="action-btn-group">
                                            <a href="manage_banners.php?action=edit&id=<?php echo $b['id']; ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="manage_banners.php?action=delete&id=<?php echo $b['id']; ?>" onclick="return confirm('Delete this banner?');" class="btn btn-sm btn-outline-danger" title="Delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="3" class="text-center text-muted py-4">No custom banners created yet. Default gradient active on all pages.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
