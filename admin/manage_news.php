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

<div style="margin-bottom: 20px;">
    <h3 style="font-family: var(--font-heading); color: var(--dark-navy);">Campus News & Announcements</h3>
</div>

<div style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 30px;">
    <div style="background: #ffffff; padding: 25px; border-radius: var(--radius-md); box-shadow: var(--shadow-sm); border: 1px solid var(--border-color); height: fit-content;">
        <h4 style="font-family: var(--font-heading); margin-bottom: 20px;">Add Announcement / Circular</h4>
        <form action="manage_news.php" method="POST">
            <div class="form-group">
                <label>Title *</label>
                <input type="text" name="title" class="form-control" placeholder="Admissions Open 2026-27" required>
            </div>
            <div class="form-group">
                <label>Category</label>
                <select name="category" class="form-control">
                    <option value="Admission">Admission</option>
                    <option value="Placement">Placement Drive</option>
                    <option value="Examination">Examination</option>
                    <option value="Announcement">General Circular</option>
                </select>
            </div>
            <div class="form-group">
                <label>Date</label>
                <input type="date" name="publish_date" class="form-control" value="<?php echo date('Y-m-d'); ?>">
            </div>
            <div class="form-group">
                <label>Summary Content</label>
                <textarea name="content" class="form-control" rows="4" placeholder="Write notice details..."></textarea>
            </div>
            <button type="submit" name="save_news" class="btn-primary" style="width: 100%; border: none; cursor: pointer;">
                <i class="fas fa-plus-circle"></i> Publish News
            </button>
        </form>
    </div>

    <div style="background: #ffffff; padding: 25px; border-radius: var(--radius-md); box-shadow: var(--shadow-sm); border: 1px solid var(--border-color);">
        <h4 style="font-family: var(--font-heading); margin-bottom: 20px;">Published News & Notices</h4>
        <table class="table">
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Title & Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($news)): ?>
                    <?php foreach ($news as $n): ?>
                        <tr>
                            <td><span style="background: var(--dark-navy); color: var(--accent-gold); padding: 3px 6px; border-radius: 4px; font-size: 0.75rem; font-weight: 700;"><?php echo sanitize($n['category']); ?></span></td>
                            <td>
                                <strong><?php echo sanitize($n['title']); ?></strong><br>
                                <small style="color: var(--text-muted);"><i class="far fa-calendar"></i> <?php echo sanitize($n['publish_date']); ?></small>
                            </td>
                            <td>
                                <a href="manage_news.php?action=delete&id=<?php echo $n['id']; ?>" onclick="return confirm('Delete this news notice?');" class="btn-primary" style="padding: 4px 8px; font-size: 0.78rem; background: #dc2626;">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="3" style="text-align: center;">No news notices recorded yet.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
