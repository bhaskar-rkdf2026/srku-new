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

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h3 style="font-family: var(--font-heading); color: var(--dark-navy);">Dynamic Page CMS</h3>
    <?php if (isset($_GET['action'])): ?>
        <a href="manage_pages.php" class="btn-secondary" style="color: var(--dark-navy);">&larr; Back to List</a>
    <?php else: ?>
        <a href="manage_pages.php?action=add" class="btn-primary"><i class="fas fa-plus"></i> Create New Page</a>
    <?php endif; ?>
</div>

<?php if (isset($_GET['action']) && ($_GET['action'] === 'add' || $_GET['action'] === 'edit')): ?>
    <div style="background: #ffffff; padding: 30px; border-radius: var(--radius-md); box-shadow: var(--shadow-sm); border: 1px solid var(--border-color);">
        <h4 style="font-family: var(--font-heading); margin-bottom: 20px;"><?php echo $editPage ? 'Edit Page' : 'Add New Page'; ?></h4>
        
        <form action="manage_pages.php" method="POST">
            <?php if ($editPage): ?>
                <input type="hidden" name="id" value="<?php echo $editPage['id']; ?>">
            <?php endif; ?>

            <div class="form-group">
                <label>Page Title *</label>
                <input type="text" name="title" class="form-control" value="<?php echo sanitize($editPage['title'] ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label>URL Slug (e.g. <code>why-srk</code>)</label>
                <input type="text" name="slug" class="form-control" value="<?php echo sanitize($editPage['slug'] ?? ''); ?>" placeholder="Auto generated if empty">
            </div>

            <div class="form-group">
                <label>Page Content (HTML Allowed)</label>
                <textarea name="content" class="form-control" rows="12" placeholder="Write full HTML or rich content here..."><?php echo htmlspecialchars($editPage['content'] ?? ''); ?></textarea>
            </div>

            <div class="form-group">
                <label>Meta Description (SEO)</label>
                <input type="text" name="meta_description" class="form-control" value="<?php echo sanitize($editPage['meta_description'] ?? ''); ?>">
            </div>

            <button type="submit" name="save_page" class="btn-primary" style="border: none; cursor: pointer;">
                <i class="fas fa-save"></i> Save Page
            </button>
        </form>
    </div>
<?php else: ?>
    <div style="background: #ffffff; padding: 25px; border-radius: var(--radius-md); box-shadow: var(--shadow-sm); border: 1px solid var(--border-color);">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
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
                            <td>#<?php echo $p['id']; ?></td>
                            <td><strong><?php echo sanitize($p['title']); ?></strong></td>
                            <td><code><?php echo sanitize($p['slug']); ?></code></td>
                            <td>
                                <a href="<?php echo BASE_URL . 'page.php?slug=' . urlencode($p['slug']); ?>" target="_blank" style="color: var(--primary-maroon);">
                                    <i class="fas fa-external-link-alt"></i> Preview
                                </a>
                            </td>
                            <td>
                                <a href="manage_pages.php?action=edit&id=<?php echo $p['id']; ?>" class="btn-secondary" style="padding: 5px 10px; font-size: 0.8rem; color: var(--dark-navy);">Edit</a>
                                <a href="manage_pages.php?action=delete&id=<?php echo $p['id']; ?>" onclick="return confirm('Are you sure you want to delete this page?');" class="btn-primary" style="padding: 5px 10px; font-size: 0.8rem; background: #dc2626;">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="5" style="text-align: center;">No custom pages created yet.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/footer.php'; ?>
