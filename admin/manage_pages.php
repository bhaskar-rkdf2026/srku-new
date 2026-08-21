<?php
require_once __DIR__ . '/header.php';
$pdo = getDBConnection();

// Ensure banner columns exist in pages table
try {
    $pdo->exec("ALTER TABLE pages ADD COLUMN banner_title VARCHAR(255) DEFAULT NULL");
    $pdo->exec("ALTER TABLE pages ADD COLUMN banner_subtitle VARCHAR(255) DEFAULT NULL");
    $pdo->exec("ALTER TABLE pages ADD COLUMN banner_img VARCHAR(255) DEFAULT NULL");
} catch (Exception $e) {}

// Handle Delete
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM pages WHERE id = :id");
    $stmt->execute([':id' => $id]);
    setFlashMsg('success', 'Page deleted successfully.');
    header("Location: manage_pages.php");
    exit;
}

// Handle Add/Edit Form
$editPage = null;
if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM pages WHERE id = :id LIMIT 1");
    $stmt->execute([':id' => $id]);
    $editPage = $stmt->fetch();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_page'])) {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $title = sanitize($_POST['title'] ?? '');
    $slug = sanitize($_POST['slug'] ?? '');
    $banner_title = sanitize($_POST['banner_title'] ?? '');
    $banner_subtitle = sanitize($_POST['banner_subtitle'] ?? '');
    $banner_img = sanitize($_POST['banner_img'] ?? '');
    $content = $_POST['content'] ?? '';
    $meta_desc = sanitize($_POST['meta_description'] ?? '');

    if (empty($slug)) {
        $slug = generateSlug($title);
    } else {
        $slug = generateSlug($slug);
    }

    if ($id > 0) {
        $stmt = $pdo->prepare("UPDATE pages SET title = :t, slug = :s, banner_title = :bt, banner_subtitle = :bs, banner_img = :bi, content = :c, meta_description = :m WHERE id = :id");
        $stmt->execute([':t' => $title, ':s' => $slug, ':bt' => $banner_title, ':bs' => $banner_subtitle, ':bi' => $banner_img, ':c' => $content, ':m' => $meta_desc, ':id' => $id]);
        setFlashMsg('success', 'Page updated successfully.');
    } else {
        $stmt = $pdo->prepare("INSERT INTO pages (title, slug, banner_title, banner_subtitle, banner_img, content, meta_description) VALUES (:t, :s, :bt, :bs, :bi, :c, :m)");
        $stmt->execute([':t' => $title, ':s' => $slug, ':bt' => $banner_title, ':bs' => $banner_subtitle, ':bi' => $banner_img, ':c' => $content, ':m' => $meta_desc]);
        setFlashMsg('success', 'New page created successfully.');
    }
    header("Location: manage_pages.php");
    exit;
}

$pages = $pdo->query("SELECT * FROM pages ORDER BY id ASC")->fetchAll();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="h4 fw-bold text-navy mb-0">Dynamic Page &amp; Content CMS</h3>
        <p class="text-muted small mb-0">Manage rich formatted page articles, headers, and banners with CKEditor.</p>
    </div>
    <?php if (isset($_GET['action'])): ?>
        <a href="manage_pages.php" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i> Back to Pages List</a>
    <?php else: ?>
        <a href="manage_pages.php?action=add" class="btn btn-danger btn-sm"><i class="fas fa-plus me-1"></i> Create New Page</a>
    <?php endif; ?>
</div>

<?php if (isset($_GET['action']) && ($_GET['action'] === 'add' || $_GET['action'] === 'edit')): ?>
    <div style="max-width: 960px;">
        <form action="manage_pages.php" method="POST">
            <?php if ($editPage): ?>
                <input type="hidden" name="id" value="<?php echo $editPage['id']; ?>">
            <?php endif; ?>

            <!-- SECTION 1: Page Identity & Route -->
            <div class="admin-form-section">
                <div class="admin-form-section-title">
                    <i class="fas fa-file-alt text-danger"></i> Section 1: Page Identity &amp; URL Settings
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-dark small">Page Title *</label>
                        <input type="text" name="title" class="form-control" value="<?php echo sanitize($editPage['title'] ?? ''); ?>" placeholder="e.g. Why SRK University" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-dark small">URL Slug *</label>
                        <input type="text" name="slug" class="form-control" value="<?php echo sanitize($editPage['slug'] ?? ''); ?>" placeholder="e.g. why-srk (auto-generated if blank)" required>
                    </div>
                </div>
            </div>

            <!-- SECTION 2: Top Banner Settings -->
            <div class="admin-form-section">
                <div class="admin-form-section-title">
                    <i class="fas fa-image text-warning"></i> Section 2: Page Top Banner Customizer
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-dark small">Banner Heading Title</label>
                        <input type="text" name="banner_title" class="form-control" value="<?php echo sanitize($editPage['banner_title'] ?? ''); ?>" placeholder="e.g. Why Choose SRKU">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-dark small">Banner Subtitle / Tagline</label>
                        <input type="text" name="banner_subtitle" class="form-control" value="<?php echo sanitize($editPage['banner_subtitle'] ?? ''); ?>" placeholder="e.g. Excellence in Higher Education &amp; Research">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark small">Banner Background Image Path (Optional)</label>
                        <input type="text" name="banner_img" class="form-control" value="<?php echo sanitize($editPage['banner_img'] ?? ''); ?>" placeholder="assets/images/campus-1.webp">
                        <small class="text-muted">Leave empty to use brand navy-red gradient.</small>
                    </div>
                </div>
            </div>

            <!-- SECTION 3: Rich Body Content with CKEditor -->
            <div class="admin-form-section">
                <div class="admin-form-section-title">
                    <i class="fas fa-edit text-primary"></i> Section 3: Rich Body Content (CKEditor)
                </div>
                <div class="mb-2">
                    <label class="form-label fw-bold text-dark small mb-2">Full Page Body Content (HTML &amp; Formatting Supported) *</label>
                    <textarea name="content" class="form-control rich-editor" rows="14" placeholder="Write full formatted content here..."><?php echo htmlspecialchars($editPage['content'] ?? ''); ?></textarea>
                </div>
            </div>

            <!-- SECTION 4: SEO & Meta Data -->
            <div class="admin-form-section">
                <div class="admin-form-section-title">
                    <i class="fas fa-search text-success"></i> Section 4: Search Engine Optimization (SEO)
                </div>
                <div>
                    <label class="form-label fw-bold text-dark small">Meta Description</label>
                    <textarea name="meta_description" class="form-control" rows="2" placeholder="Brief summary of the page for Google search results..."><?php echo sanitize($editPage['meta_description'] ?? ''); ?></textarea>
                </div>
            </div>

            <div class="d-flex gap-3 justify-content-end mb-5">
                <a href="manage_pages.php" class="btn btn-outline-secondary px-4">Cancel</a>
                <button type="submit" name="save_page" class="btn btn-danger fw-bold px-5">
                    <i class="fas fa-save me-1"></i> <?php echo $editPage ? 'Save Page Changes' : 'Publish New Page'; ?>
                </button>
            </div>
        </form>
    </div>

<?php else: ?>
    <!-- Pages List Table -->
    <div class="card border-0 shadow-sm rounded-4 p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width:60px;">#ID</th>
                        <th>Page Title</th>
                        <th>URL Slug</th>
                        <th>Banner Header</th>
                        <th>Last Modified</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($pages)): ?>
                        <?php foreach ($pages as $p): ?>
                            <tr>
                                <td class="fw-bold text-muted">#<?php echo $p['id']; ?></td>
                                <td>
                                    <strong class="text-navy d-block"><?php echo sanitize($p['title']); ?></strong>
                                    <small class="text-muted"><?php echo substr(strip_tags($p['content'] ?? ''), 0, 70) . '...'; ?></small>
                                </td>
                                <td><code>/<?php echo sanitize($p['slug']); ?></code></td>
                                <td>
                                    <small class="text-dark fw-semibold d-block"><?php echo sanitize($p['banner_title'] ?: $p['title']); ?></small>
                                    <?php if ($p['banner_img']): ?>
                                        <span class="badge bg-info-subtle text-info border">Custom Image</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary-subtle text-secondary border">Default Gradient</span>
                                    <?php endif; ?>
                                </td>
                                <td><small class="text-muted"><?php echo sanitize($p['created_at'] ?? 'N/A'); ?></small></td>
                                <td class="text-end text-nowrap">
                                    <div class="action-btn-group">
                                        <a href="<?php echo BASE_URL . $p['slug']; ?>" target="_blank" class="btn btn-sm btn-outline-primary" title="View Page Live"><i class="fas fa-external-link-alt"></i></a>
                                        <a href="manage_pages.php?action=edit&id=<?php echo $p['id']; ?>" class="btn btn-sm btn-outline-warning" title="Edit in CKEditor"><i class="fas fa-edit"></i></a>
                                        <a href="manage_pages.php?action=delete&id=<?php echo $p['id']; ?>" onclick="return confirm('Delete page <?php echo sanitize($p['title']); ?>?');" class="btn btn-sm btn-outline-danger" title="Delete"><i class="fas fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6" class="text-center text-muted py-4">No pages found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/footer.php'; ?>
