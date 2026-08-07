<?php
require_once __DIR__ . '/header.php';
$pdo = getDBConnection();

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
    $content = $_POST['content'] ?? '';
    $meta_desc = sanitize($_POST['meta_description'] ?? '');

    if (empty($slug)) {
        $slug = generateSlug($title);
    } else {
        $slug = generateSlug($slug);
    }

    if ($id > 0) {
        $stmt = $pdo->prepare("UPDATE pages SET title = :t, slug = :s, content = :c, meta_description = :m WHERE id = :id");
        $stmt->execute([':t' => $title, ':s' => $slug, ':c' => $content, ':m' => $meta_desc, ':id' => $id]);
        setFlashMsg('success', 'Page updated successfully.');
    } else {
        $stmt = $pdo->prepare("INSERT INTO pages (title, slug, content, meta_description) VALUES (:t, :s, :c, :m)");
        $stmt->execute([':t' => $title, ':s' => $slug, ':c' => $content, ':m' => $meta_desc]);
        setFlashMsg('success', 'New page created successfully.');
    }
    header("Location: manage_pages.php");
    exit;
}

$pages = $pdo->query("SELECT * FROM pages ORDER BY id DESC")->fetchAll();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="h4 fw-bold text-navy mb-0">Dynamic Page CMS</h3>
    <?php if (isset($_GET['action'])): ?>
        <a href="manage_pages.php" class="btn btn-outline-secondary btn-sm">&larr; Back to List</a>
    <?php else: ?>
        <a href="manage_pages.php?action=add" class="btn btn-danger btn-sm"><i class="fas fa-plus me-1"></i> Create New Page</a>
    <?php endif; ?>
</div>

<?php if (isset($_GET['action']) && ($_GET['action'] === 'add' || $_GET['action'] === 'edit')): ?>
    <div class="card border-0 shadow-sm rounded-4 p-4">
        <h4 class="h5 fw-bold text-navy mb-4"><?php echo $editPage ? 'Edit Page' : 'Add New Page'; ?></h4>
        
        <form action="manage_pages.php" method="POST">
            <?php if ($editPage): ?>
                <input type="hidden" name="id" value="<?php echo $editPage['id']; ?>">
            <?php endif; ?>

            <div class="mb-3">
                <label class="form-label fw-bold text-dark small">Page Title *</label>
                <input type="text" name="title" class="form-control" value="<?php echo sanitize($editPage['title'] ?? ''); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold text-dark small">URL Slug (e.g. <code>why-srk</code>)</label>
                <input type="text" name="slug" class="form-control" value="<?php echo sanitize($editPage['slug'] ?? ''); ?>" placeholder="Auto generated if empty">
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold text-dark small">Page Content (HTML Allowed)</label>
                <textarea name="content" class="form-control" rows="12" placeholder="Write full HTML or rich content here..."><?php echo htmlspecialchars($editPage['content'] ?? ''); ?></textarea>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold text-dark small">Meta Description (SEO)</label>
                <input type="text" name="meta_description" class="form-control" value="<?php echo sanitize($editPage['meta_description'] ?? ''); ?>">
            </div>

            <button type="submit" name="save_page" class="btn btn-danger px-4">
                <i class="fas fa-save me-1"></i> Save Page
            </button>
        </form>
    </div>
<?php else: ?>
    <div class="card border-0 shadow-sm rounded-4 p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#ID</th>
                        <th>Title</th>
                        <th>Slug</th>
                        <th>View Link</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($pages)): ?>
                        <?php foreach ($pages as $p): ?>
                            <tr>
                                <td class="fw-bold">#<?php echo $p['id']; ?></td>
                                <td class="fw-semibold text-navy"><?php echo sanitize($p['title']); ?></td>
                                <td><code><?php echo sanitize($p['slug']); ?></code></td>
                                <td>
                                    <a href="<?php echo BASE_URL . 'page.php?slug=' . urlencode($p['slug']); ?>" target="_blank" class="text-danger small fw-semibold">
                                        <i class="fas fa-external-link-alt me-1"></i> Preview
                                    </a>
                                </td>
                                <td>
                                    <a href="manage_pages.php?action=edit&id=<?php echo $p['id']; ?>" class="btn btn-sm btn-outline-navy me-1">Edit</a>
                                    <a href="manage_pages.php?action=delete&id=<?php echo $p['id']; ?>" onclick="return confirm('Are you sure you want to delete this page?');" class="btn btn-sm btn-danger">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="text-center text-muted py-4">No custom pages created yet.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/footer.php'; ?>
