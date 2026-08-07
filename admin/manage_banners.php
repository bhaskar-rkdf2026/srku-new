<?php
require_once __DIR__ . '/header.php';
$pdo = getDBConnection();

if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM banners WHERE id = :id");
    $stmt->execute([':id' => $id]);
    setFlashMsg('success', 'Banner removed successfully.');
    header("Location: manage_banners.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_banner'])) {
    $title = sanitize($_POST['title'] ?? '');
    $subtitle = sanitize($_POST['subtitle'] ?? '');
    $btn_text = sanitize($_POST['btn_text'] ?? '');
    $btn_link = sanitize($_POST['btn_link'] ?? '');
    $sort_order = (int)($_POST['sort_order'] ?? 0);

    $stmt = $pdo->prepare("INSERT INTO banners (title, subtitle, btn_text, btn_link, sort_order) VALUES (:t, :s, :bt, :bl, :so)");
    $stmt->execute([':t' => $title, ':s' => $subtitle, ':bt' => $btn_text, ':bl' => $btn_link, ':so' => $sort_order]);
    setFlashMsg('success', 'Banner added successfully.');
    header("Location: manage_banners.php");
    exit;
}

$banners = $pdo->query("SELECT * FROM banners ORDER BY sort_order ASC, id DESC")->fetchAll();
?>

<div style="margin-bottom: 20px;">
    <h3 style="font-family: var(--font-heading); color: var(--dark-navy);">Manage Home Hero Banners</h3>
</div>

<div style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 30px;">
    <div style="background: #ffffff; padding: 25px; border-radius: var(--radius-md); box-shadow: var(--shadow-sm); border: 1px solid var(--border-color); height: fit-content;">
        <h4 style="font-family: var(--font-heading); margin-bottom: 20px;">Add New Hero Banner</h4>
        <form action="manage_banners.php" method="POST">
            <div class="form-group">
                <label>Main Headline *</label>
                <input type="text" name="title" class="form-control" placeholder="Welcome to SRK University" required>
            </div>
            <div class="form-group">
                <label>Subtitle / Description</label>
                <textarea name="subtitle" class="form-control" rows="2" placeholder="Premier Technical & Academic Ecosystem"></textarea>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div class="form-group">
                    <label>Button Text</label>
                    <input type="text" name="btn_text" class="form-control" placeholder="Apply Now">
                </div>
                <div class="form-group">
                    <label>Button Link</label>
                    <input type="text" name="btn_link" class="form-control" placeholder="contact.php#apply">
                </div>
            </div>
            <div class="form-group">
                <label>Sort Order</label>
                <input type="number" name="sort_order" class="form-control" value="0">
            </div>
            <button type="submit" name="save_banner" class="btn-primary" style="width: 100%; border: none; cursor: pointer;">
                <i class="fas fa-plus-circle"></i> Save Banner
            </button>
        </form>
    </div>

    <div style="background: #ffffff; padding: 25px; border-radius: var(--radius-md); box-shadow: var(--shadow-sm); border: 1px solid var(--border-color);">
        <h4 style="font-family: var(--font-heading); margin-bottom: 20px;">Existing Banners</h4>
        <table class="table">
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Title & Subtitle</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($banners)): ?>
                    <?php foreach ($banners as $b): ?>
                        <tr>
                            <td>#<?php echo $b['sort_order']; ?></td>
                            <td>
                                <strong><?php echo sanitize($b['title']); ?></strong><br>
                                <small style="color: var(--text-muted);"><?php echo sanitize($b['subtitle']); ?></small>
                            </td>
                            <td>
                                <a href="manage_banners.php?action=delete&id=<?php echo $b['id']; ?>" onclick="return confirm('Remove banner?');" class="btn-primary" style="padding: 4px 8px; font-size: 0.78rem; background: #dc2626;">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="3" style="text-align: center;">No custom banners created. Default hero display active.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
