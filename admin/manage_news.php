<?php
require_once __DIR__ . '/header.php';
$pdo = getDBConnection();

if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM news WHERE id = :id");
    $stmt->execute([':id' => $id]);
    setFlashMsg('success', 'News item removed successfully.');
    header("Location: manage_news.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_news'])) {
    $title = sanitize($_POST['title'] ?? '');
    $category = sanitize($_POST['category'] ?? 'Announcement');
    $content = sanitize($_POST['content'] ?? '');
    $publish_date = $_POST['publish_date'] ?? date('Y-m-d');

    $stmt = $pdo->prepare("INSERT INTO news (title, category, content, publish_date) VALUES (:t, :cat, :c, :d)");
    $stmt->execute([':t' => $title, ':cat' => $category, ':c' => $content, ':d' => $publish_date]);
    setFlashMsg('success', 'News item added successfully.');
    header("Location: manage_news.php");
    exit;
}

$news = $pdo->query("SELECT * FROM news ORDER BY id DESC")->fetchAll();
?>

<div class="mb-4">
    <h3 class="h4 fw-bold text-navy mb-0">Campus News &amp; Announcements</h3>
</div>

<div class="row g-4">
    
    <!-- Add News Form -->
    <div class="col-12 col-lg-5">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h4 class="h5 fw-bold text-navy mb-4">Add Announcement / Circular</h4>
            <form action="manage_news.php" method="POST">
                <div class="mb-3">
                    <label class="form-label fw-bold text-dark small">Title *</label>
                    <input type="text" name="title" class="form-control py-2" placeholder="Admissions Open 2026-27" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold text-dark small">Category</label>
                    <select name="category" class="form-select py-2">
                        <option value="Admission">Admission</option>
                        <option value="Placement">Placement Drive</option>
                        <option value="Examination">Examination</option>
                        <option value="Announcement">General Circular</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold text-dark small">Date</label>
                    <input type="date" name="publish_date" class="form-control py-2" value="<?php echo date('Y-m-d'); ?>">
                </div>
                <div class="mb-4">
                    <label class="form-label fw-bold text-dark small">Summary Content</label>
                    <textarea name="content" class="form-control py-2" rows="4" placeholder="Write notice details..."></textarea>
                </div>
                <button type="submit" name="save_news" class="btn btn-danger w-100 py-2">
                    <i class="fas fa-plus-circle me-1"></i> Publish News
                </button>
            </form>
        </div>
    </div>

    <!-- Published News List -->
    <div class="col-12 col-lg-7">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h4 class="h5 fw-bold text-navy mb-4">Published News &amp; Notices</h4>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Category</th>
                            <th>Title &amp; Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($news)): ?>
                            <?php foreach ($news as $n): ?>
                                <tr>
                                    <td><span class="badge bg-dark text-warning"><?php echo sanitize($n['category']); ?></span></td>
                                    <td>
                                        <strong class="text-navy d-block"><?php echo sanitize($n['title']); ?></strong>
                                        <small class="text-muted"><i class="far fa-calendar me-1"></i><?php echo sanitize($n['publish_date']); ?></small>
                                    </td>
                                    <td>
                                        <a href="manage_news.php?action=delete&id=<?php echo $n['id']; ?>" onclick="return confirm('Delete this news notice?');" class="btn btn-sm btn-danger">Delete</a>
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
