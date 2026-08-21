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
    $page_slug = sanitize($_POST['page_slug'] ?? 'home');
    $title = sanitize($_POST['title'] ?? '');
    $subtitle = sanitize($_POST['subtitle'] ?? '');
    $image_url = sanitize($_POST['image_url'] ?? '');
    $btn_text = sanitize($_POST['btn_text'] ?? '');
    $btn_link = sanitize($_POST['btn_link'] ?? '');
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
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="h4 fw-bold text-navy mb-0">Manage Page Banners &amp; Sliders</h3>
    <?php if (isset($_GET['action'])): ?>
        <a href="manage_banners.php" class="btn btn-outline-secondary btn-sm">&larr; Back to Banners List</a>
    <?php endif; ?>
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
