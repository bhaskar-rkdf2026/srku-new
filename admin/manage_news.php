<?php
require_once __DIR__ . '/header.php';
$pdo = getDBConnection();

// Delete News Item
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM news WHERE id = :id");
    $stmt->execute([':id' => $id]);
    setFlashMsg('success', 'News notice removed successfully.');
    header("Location: manage_news.php");
    exit;
}

// Save or Update News Item
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_news'])) {
    $id = (int)($_POST['id'] ?? 0);
    $title = sanitize($_POST['title'] ?? '');
    $slug = trim($_POST['slug'] ?? '');
    if (empty($slug)) {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
    }
    $category = sanitize($_POST['category'] ?? 'Announcement');
    $content = $_POST['content'] ?? '';
    $publish_date = $_POST['publish_date'] ?? date('Y-m-d');
    $image_url = sanitize($_POST['image_url'] ?? '');
    $is_ticker = isset($_POST['is_ticker']) ? 1 : 0;

    if ($id > 0) {
        $stmt = $pdo->prepare("UPDATE news SET title = :t, slug = :s, category = :cat, content = :c, publish_date = :d, image_url = :img, is_ticker = :tick WHERE id = :id");
        $stmt->execute([
            ':t' => $title,
            ':s' => $slug,
            ':cat' => $category,
            ':c' => $content,
            ':d' => $publish_date,
            ':img' => $image_url,
            ':tick' => $is_ticker,
            ':id' => $id
        ]);
        setFlashMsg('success', 'News notice updated successfully.');
    } else {
        $stmt = $pdo->prepare("INSERT INTO news (title, slug, category, content, publish_date, image_url, is_ticker) VALUES (:t, :s, :cat, :c, :d, :img, :tick)");
        $stmt->execute([
            ':t' => $title,
            ':s' => $slug,
            ':cat' => $category,
            ':c' => $content,
            ':d' => $publish_date,
            ':img' => $image_url,
            ':tick' => $is_ticker
        ]);
        setFlashMsg('success', 'New notice published successfully.');
    }
    header("Location: manage_news.php");
    exit;
}

// Fetch single news for edit
$editNews = null;
if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM news WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $editNews = $stmt->fetch();
}

$news = $pdo->query("SELECT * FROM news ORDER BY id DESC")->fetchAll();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="h4 fw-bold text-navy mb-0">Campus News &amp; Announcements</h3>
        <p class="text-muted small mb-0">Publish, edit, view and manage official university notifications, circulars and notices.</p>
    </div>
    <?php if ($editNews): ?>
        <a href="manage_news.php" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-plus me-1"></i> Add New Announcement
        </a>
    <?php endif; ?>
</div>

<div class="row g-4">
    
    <!-- Add / Edit News Form -->
    <div class="col-12 col-lg-5">
        <form action="manage_news.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $editNews ? (int)$editNews['id'] : 0; ?>">
            
            <div class="admin-form-section">
                <div class="admin-form-section-title d-flex justify-content-between align-items-center">
                    <span>
                        <i class="fas <?php echo $editNews ? 'fa-edit text-warning' : 'fa-bullhorn text-danger'; ?>"></i> 
                        <?php echo $editNews ? 'Edit Notice #' . $editNews['id'] : 'Section 1: Notice Classification'; ?>
                    </span>
                    <?php if ($editNews): ?>
                        <a href="manage_news.php" class="badge bg-secondary text-white text-decoration-none small">Cancel</a>
                    <?php endif; ?>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold text-dark small">Notice Title *</label>
                    <input type="text" name="title" class="form-control" placeholder="e.g. Admissions Open 2026-27" value="<?php echo $editNews ? sanitize($editNews['title']) : ''; ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold text-dark small">URL Slug (Optional)</label>
                    <input type="text" name="slug" class="form-control" placeholder="e.g. admissions-open-2026-27" value="<?php echo $editNews ? sanitize($editNews['slug'] ?? '') : ''; ?>">
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <label class="form-label fw-bold text-dark small">Category</label>
                        <select name="category" class="form-select">
                            <?php 
                            $categories = [
                                'Admission' => 'Admission',
                                'Placement' => 'Placement Drive',
                                'Examination' => 'Examination',
                                'Event' => 'Event',
                                'Campus Life' => 'Campus Life',
                                'Announcement' => 'General Circular'
                            ];
                            $currCat = $editNews['category'] ?? 'Announcement';
                            foreach ($categories as $catKey => $catLabel):
                            ?>
                                <option value="<?php echo $catKey; ?>" <?php echo ($currCat === $catKey) ? 'selected' : ''; ?>>
                                    <?php echo $catLabel; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-bold text-dark small">Publish Date</label>
                        <input type="date" name="publish_date" class="form-control" value="<?php echo $editNews ? $editNews['publish_date'] : date('Y-m-d'); ?>">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold text-dark small">Featured Image URL (Optional)</label>
                    <input type="text" name="image_url" class="form-control" placeholder="assets/uploads/... or full URL" value="<?php echo $editNews ? sanitize($editNews['image_url'] ?? '') : ''; ?>">
                </div>
            </div>

            <div class="admin-form-section">
                <div class="admin-form-section-title">
                    <i class="fas fa-edit text-primary"></i> Section 2: Full Circular Content (CKEditor)
                </div>
                <div class="mb-2">
                    <label class="form-label fw-bold text-dark small mb-2">Notice Body &amp; Instructions</label>
                    <textarea name="content" class="form-control rich-editor" rows="6" placeholder="Write notice details..."><?php echo $editNews ? htmlspecialchars($editNews['content'] ?? '') : ''; ?></textarea>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" name="save_news" class="btn <?php echo $editNews ? 'btn-warning text-dark fw-bold' : 'btn-danger text-white fw-bold'; ?> flex-grow-1 py-2">
                    <i class="fas <?php echo $editNews ? 'fa-save' : 'fa-paper-plane'; ?> me-1"></i> 
                    <?php echo $editNews ? 'Update Notice' : 'Publish Announcement'; ?>
                </button>
                <?php if ($editNews): ?>
                    <a href="manage_news.php" class="btn btn-outline-secondary py-2 px-3">Cancel</a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- Published News List -->
    <div class="col-12 col-lg-7">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="h5 fw-bold text-navy mb-0">Published News &amp; Notices (<?php echo count($news); ?>)</h4>
                <a href="<?php echo BASE_URL; ?>news.php" target="_blank" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-external-link-alt me-1"></i> View Notice Board
                </a>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Category</th>
                            <th>Title &amp; Date</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($news)): ?>
                            <?php foreach ($news as $n): ?>
                                <tr class="<?php echo ($editNews && $editNews['id'] == $n['id']) ? 'table-warning' : ''; ?>">
                                    <td>
                                        <span class="badge bg-dark text-warning"><?php echo sanitize($n['category']); ?></span>
                                    </td>
                                    <td>
                                        <strong class="text-navy d-block mb-1"><?php echo sanitize($n['title']); ?></strong>
                                        <small class="text-muted d-block mb-1"><?php echo substr(strip_tags($n['content'] ?? ''), 0, 75) . '...'; ?></small>
                                        <small class="text-muted"><i class="far fa-calendar me-1 text-primary"></i><?php echo sanitize($n['publish_date']); ?></small>
                                    </td>
                                    <td class="text-end text-nowrap">
                                        <div class="action-btn-group d-flex justify-content-end gap-1">
                                            <!-- View Live on Frontend -->
                                            <a href="<?php echo BASE_URL; ?>news-detail.php?id=<?php echo $n['id']; ?>" target="_blank" class="btn btn-sm btn-outline-primary" title="View Notice on Frontend">
                                                <i class="fas fa-external-link-alt"></i>
                                            </a>
                                            <!-- Edit Notice -->
                                            <a href="manage_news.php?action=edit&id=<?php echo $n['id']; ?>" class="btn btn-sm btn-outline-warning text-dark" title="Edit Notice">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <!-- Delete Notice -->
                                            <a href="manage_news.php?action=delete&id=<?php echo $n['id']; ?>" onclick="return confirm('Are you sure you want to delete this notice?');" class="btn btn-sm btn-outline-danger" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="3" class="text-center text-muted py-4">No news notices recorded yet.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<?php require_once __DIR__ . '/footer.php'; ?>
