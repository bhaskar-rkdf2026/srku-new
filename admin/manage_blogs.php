<?php
require_once __DIR__ . '/header.php';
$pdo = getDBConnection();

// Ensure blogs table exists
$pdo->exec("CREATE TABLE IF NOT EXISTS blogs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(191) UNIQUE NOT NULL,
    author VARCHAR(100) NOT NULL DEFAULT 'SRKU Editorial Board',
    category VARCHAR(100) NOT NULL DEFAULT 'Campus Life',
    short_description TEXT NULL,
    content LONGTEXT NOT NULL,
    image_url VARCHAR(255) NULL,
    publish_date DATE NULL,
    views INT NOT NULL DEFAULT 0,
    status VARCHAR(20) NOT NULL DEFAULT 'published',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

// Delete Blog
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM blogs WHERE id = :id");
    $stmt->execute([':id' => $id]);
    setFlashMsg('success', 'Blog article deleted successfully.');
    header("Location: manage_blogs.php");
    exit;
}

// Toggle Status
if (isset($_GET['action']) && $_GET['action'] === 'toggle_status' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $pdo->prepare("UPDATE blogs SET status = IF(status = 'published', 'draft', 'published') WHERE id = :id");
    $stmt->execute([':id' => $id]);
    setFlashMsg('success', 'Blog status updated.');
    header("Location: manage_blogs.php");
    exit;
}

// Save / Update Blog
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_blog'])) {
    $id = (int)($_POST['id'] ?? 0);
    $title = trim($_POST['title'] ?? '');
    $slug = trim($_POST['slug'] ?? '');
    if (empty($slug)) {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
    }
    $author = sanitize($_POST['author'] ?? 'SRKU Editorial Board');
    $category = sanitize($_POST['category'] ?? 'Campus Life');
    $short_description = trim($_POST['short_description'] ?? '');
    $content = $_POST['content'] ?? '';
    $image_url = sanitize($_POST['image_url'] ?? '');
    $publish_date = $_POST['publish_date'] ?? date('Y-m-d');
    $status = sanitize($_POST['status'] ?? 'published');

    if ($id > 0) {
        $stmt = $pdo->prepare("UPDATE blogs SET title = :t, slug = :s, author = :a, category = :c, short_description = :sd, content = :cnt, image_url = :img, publish_date = :pd, status = :st WHERE id = :id");
        $stmt->execute([
            ':t' => $title,
            ':s' => $slug,
            ':a' => $author,
            ':c' => $category,
            ':sd' => $short_description,
            ':cnt' => $content,
            ':img' => $image_url,
            ':pd' => $publish_date,
            ':st' => $status,
            ':id' => $id
        ]);
        setFlashMsg('success', 'Blog article updated successfully.');
    } else {
        $stmt = $pdo->prepare("INSERT INTO blogs (title, slug, author, category, short_description, content, image_url, publish_date, status) VALUES (:t, :s, :a, :c, :sd, :cnt, :img, :pd, :st)");
        $stmt->execute([
            ':t' => $title,
            ':s' => $slug,
            ':a' => $author,
            ':c' => $category,
            ':sd' => $short_description,
            ':cnt' => $content,
            ':img' => $image_url,
            ':pd' => $publish_date,
            ':st' => $status
        ]);
        setFlashMsg('success', 'New blog article published successfully.');
    }
    header("Location: manage_blogs.php");
    exit;
}

// Fetch single blog for edit
$editBlog = null;
if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM blogs WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $editBlog = $stmt->fetch();
}

$blogs = $pdo->query("SELECT * FROM blogs ORDER BY id DESC")->fetchAll();
?>

<!-- Header Section -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
    <div>
        <h3 class="h4 fw-bold text-navy mb-1"><i class="fas fa-newspaper text-danger me-2"></i> University Blogs &amp; Thought Leadership Articles</h3>
        <p class="text-muted small mb-0">Create, edit, and publish rich editorial articles, research highlights, and campus life stories.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?php echo BASE_URL; ?>blogs.php" target="_blank" class="btn btn-outline-danger shadow-sm">
            <i class="fas fa-external-link-alt me-1"></i> View Live Blogs Portal
        </a>
        <a href="#blogFormCard" class="btn btn-srku fw-bold shadow-sm">
            <i class="fas fa-plus me-1"></i> Write New Article
        </a>
    </div>
</div>

<div class="row g-4">
    
    <!-- Left Column: Add / Edit Blog Form -->
    <div class="col-12 col-xl-5" id="blogFormCard">
        <div class="card p-4 border-0 shadow-sm rounded-4 bg-white sticky-top" style="top: 20px; z-index: 10;">
            <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                <h5 class="fw-bold text-navy mb-0">
                    <i class="fas <?php echo $editBlog ? 'fa-edit text-warning' : 'fa-feather-alt text-danger'; ?> me-2"></i>
                    <?php echo $editBlog ? 'Edit Article #' . $editBlog['id'] : 'Write New Article'; ?>
                </h5>
                <?php if ($editBlog): ?>
                    <a href="manage_blogs.php" class="btn btn-sm btn-outline-secondary rounded-pill">Cancel Edit</a>
                <?php endif; ?>
            </div>

            <form action="manage_blogs.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $editBlog['id'] ?? 0; ?>">

                <div class="mb-3">
                    <label class="form-label fw-bold text-dark small">Article Title *</label>
                    <input type="text" name="title" id="blogTitleInput" class="form-control" placeholder="e.g. Advancements in AI & Robotics 2026" value="<?php echo sanitize($editBlog['title'] ?? ''); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold text-dark small">URL Slug (Auto-generated if empty)</label>
                    <input type="text" name="slug" id="blogSlugInput" class="form-control font-monospace" placeholder="e.g. advancements-in-ai-robotics-2026" value="<?php echo sanitize($editBlog['slug'] ?? ''); ?>">
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <label class="form-label fw-bold text-dark small">Category</label>
                        <select name="category" class="form-select">
                            <?php 
                            $cats = ['Campus Life', 'Research & Tech', 'Placements', 'Admissions', 'Medical & Health', 'Agriculture & Bio', 'Student Achievements', 'Career Guidance'];
                            $currentCat = $editBlog['category'] ?? 'Campus Life';
                            foreach ($cats as $c):
                            ?>
                                <option value="<?php echo $c; ?>" <?php echo $currentCat === $c ? 'selected' : ''; ?>><?php echo $c; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-bold text-dark small">Author / Department</label>
                        <input type="text" name="author" class="form-control" placeholder="e.g. Faculty of Pharmacy" value="<?php echo sanitize($editBlog['author'] ?? 'SRKU Editorial Board'); ?>">
                    </div>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <label class="form-label fw-bold text-dark small">Publish Date</label>
                        <input type="date" name="publish_date" class="form-control" value="<?php echo $editBlog['publish_date'] ?? date('Y-m-d'); ?>">
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-bold text-dark small">Publication Status</label>
                        <select name="status" class="form-select">
                            <option value="published" <?php echo ($editBlog['status'] ?? 'published') === 'published' ? 'selected' : ''; ?>>🟢 Published (Live)</option>
                            <option value="draft" <?php echo ($editBlog['status'] ?? '') === 'draft' ? 'selected' : ''; ?>>🟡 Draft (Hidden)</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold text-dark small">Featured Cover Image URL</label>
                    <input type="text" name="image_url" class="form-control" placeholder="assets/uploads/2026/07/001.webp" value="<?php echo sanitize($editBlog['image_url'] ?? 'assets/uploads/2026/07/001.webp'); ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold text-dark small">Short Teaser Summary</label>
                    <textarea name="short_description" class="form-control" rows="2" placeholder="Brief 1-2 sentence preview for directory cards..."><?php echo sanitize($editBlog['short_description'] ?? ''); ?></textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold text-dark small">Full Article Content (Rich Text) *</label>
                    <textarea name="content" id="editor" class="form-control" rows="8"><?php echo $editBlog['content'] ?? ''; ?></textarea>
                </div>

                <button type="submit" name="save_blog" class="btn btn-srku w-100 py-3 fw-bold shadow">
                    <i class="fas fa-save me-1"></i> <?php echo $editBlog ? 'Update Article' : 'Publish Article'; ?>
                </button>
            </form>
        </div>
    </div>

    <!-- Right Column: Articles Directory Table -->
    <div class="col-12 col-xl-7">
        <div class="card p-4 border-0 shadow-sm rounded-4 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold text-navy mb-0">Published Articles (<?php echo count($blogs); ?>)</h5>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 50px;">#ID</th>
                            <th>Cover &amp; Title</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($blogs)): ?>
                            <?php foreach ($blogs as $b): ?>
                                <tr>
                                    <td class="fw-bold text-muted">#<?php echo $b['id']; ?></td>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <img src="<?php echo BASE_URL . sanitize($b['image_url'] ?: 'assets/uploads/2026/07/001.webp'); ?>" 
                                                 onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';"
                                                 class="rounded-3 object-fit-cover shadow-sm flex-shrink-0" style="width: 50px; height: 42px;" alt="">
                                            <div>
                                                <strong class="text-navy d-block" style="font-size: 0.92rem; line-height: 1.3;">
                                                    <a href="<?php echo BASE_URL; ?>blog-detail.php?slug=<?php echo urlencode($b['slug'] ?: $b['id']); ?>" target="_blank" class="text-navy text-decoration-none hover-text-danger">
                                                        <?php echo sanitize($b['title']); ?>
                                                    </a>
                                                </strong>
                                                <small class="text-muted"><i class="far fa-user me-1"></i><?php echo sanitize($b['author']); ?> &bull; <i class="far fa-eye ms-1"></i> <?php echo (int)$b['views']; ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border"><?php echo sanitize($b['category']); ?></span>
                                    </td>
                                    <td>
                                        <a href="manage_blogs.php?action=toggle_status&id=<?php echo $b['id']; ?>" class="badge <?php echo $b['status'] === 'published' ? 'bg-success' : 'bg-warning text-dark'; ?> text-decoration-none" title="Click to toggle status">
                                            <?php echo ucfirst($b['status']); ?>
                                        </a>
                                    </td>
                                    <td>
                                        <small class="text-muted text-nowrap"><?php echo date('M d, Y', strtotime($b['publish_date'] ?: $b['created_at'])); ?></small>
                                    </td>
                                    <td class="text-end text-nowrap">
                                        <div class="action-btn-group">
                                            <a href="<?php echo BASE_URL; ?>blog-detail.php?slug=<?php echo urlencode($b['slug'] ?: $b['id']); ?>" target="_blank" class="btn btn-sm btn-outline-info" title="Preview Article">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="manage_blogs.php?action=edit&id=<?php echo $b['id']; ?>#blogFormCard" class="btn btn-sm btn-outline-primary" title="Edit Article">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="manage_blogs.php?action=delete&id=<?php echo $b['id']; ?>" onclick="return confirm('Are you sure you want to delete this blog article?');" class="btn btn-sm btn-outline-danger" title="Delete Article">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">No blog articles found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto generate slug from title if empty
    const titleInput = document.getElementById('blogTitleInput');
    const slugInput = document.getElementById('blogSlugInput');
    if (titleInput && slugInput) {
        titleInput.addEventListener('keyup', function() {
            if (!slugInput.dataset.manualEdited) {
                slugInput.value = this.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)+/g, '');
            }
        });
        slugInput.addEventListener('input', function() {
            slugInput.dataset.manualEdited = true;
        });
    }

    // Initialize CKEditor 5
    if (document.querySelector('#editor')) {
        ClassicEditor
            .create(document.querySelector('#editor'), {
                toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', '|', 'undo', 'redo']
            })
            .catch(error => {
                console.error(error);
            });
    }
});
</script>

<?php require_once __DIR__ . '/footer.php'; ?>
