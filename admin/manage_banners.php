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

<div class="mb-4">
    <h3 class="h4 fw-bold text-navy mb-0">Manage Home Hero Banners</h3>
</div>

<div class="row g-4">
    <div class="col-12 col-lg-5">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h4 class="h5 fw-bold text-navy mb-4">Add New Hero Banner</h4>
            <form action="manage_banners.php" method="POST">
                <div class="mb-3">
                    <label class="form-label fw-bold text-dark small">Main Headline *</label>
                    <input type="text" name="title" class="form-control py-2" placeholder="Welcome to SRK University" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold text-dark small">Subtitle / Description</label>
                    <textarea name="subtitle" class="form-control py-2" rows="2" placeholder="Premier Technical &amp; Academic Ecosystem"></textarea>
                </div>
                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <label class="form-label fw-bold text-dark small">Button Text</label>
                        <input type="text" name="btn_text" class="form-control py-2" placeholder="Apply Now">
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-bold text-dark small">Button Link</label>
                        <input type="text" name="btn_link" class="form-control py-2" placeholder="contact.php#apply">
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-bold text-dark small">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control py-2" value="0">
                </div>
                <button type="submit" name="save_banner" class="btn btn-danger w-100 py-2">
                    <i class="fas fa-plus-circle me-1"></i> Save Banner
                </button>
            </form>
        </div>
    </div>

    <div class="col-12 col-lg-7">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h4 class="h5 fw-bold text-navy mb-4">Existing Banners</h4>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Order</th>
                            <th>Title &amp; Subtitle</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($banners)): ?>
                            <?php foreach ($banners as $b): ?>
                                <tr>
                                    <td class="fw-bold">#<?php echo $b['sort_order']; ?></td>
                                    <td>
                                        <strong class="text-navy d-block"><?php echo sanitize($b['title']); ?></strong>
                                        <small class="text-muted"><?php echo sanitize($b['subtitle']); ?></small>
                                    </td>
                                    <td>
                                        <a href="manage_banners.php?action=delete&id=<?php echo $b['id']; ?>" onclick="return confirm('Remove banner?');" class="btn btn-sm btn-danger">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="3" class="text-center text-muted py-4">No custom banners created. Default hero display active.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
