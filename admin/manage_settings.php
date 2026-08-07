<?php
require_once __DIR__ . '/header.php';
$pdo = getDBConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_settings'])) {
    $settingsToUpdate = [
        'helpline' => sanitize($_POST['helpline'] ?? ''),
        'email' => sanitize($_POST['email'] ?? ''),
        'address' => sanitize($_POST['address'] ?? ''),
        'ticker_text' => sanitize($_POST['ticker_text'] ?? '')
    ];

    foreach ($settingsToUpdate as $key => $value) {
        $stmt = $pdo->prepare("INSERT INTO settings (setting_key, setting_value) VALUES (:k, :v) ON DUPLICATE KEY UPDATE setting_value = :v");
        $stmt->execute([':k' => $key, ':v' => $value]);
    }

    setFlashMsg('success', 'Global site settings updated successfully.');
    header("Location: manage_settings.php");
    exit;
}

$helpline = getSetting('helpline');
$email = getSetting('email');
$address = getSetting('address');
$ticker = getSetting('ticker_text');
?>

<div class="mb-4">
    <h3 class="h4 fw-bold text-navy mb-0">Global Website Settings</h3>
</div>

<div class="card border-0 shadow-sm rounded-4 p-4" style="max-width: 800px;">
    <form action="manage_settings.php" method="POST">
        <div class="mb-3">
            <label class="form-label fw-bold text-dark small">Helpline Phone Number</label>
            <input type="text" name="helpline" class="form-control py-2" value="<?php echo sanitize($helpline); ?>" placeholder="0755 - 4911204">
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold text-dark small">Official Email Address</label>
            <input type="email" name="email" class="form-control py-2" value="<?php echo sanitize($email); ?>" placeholder="exam@srku.edu.in">
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold text-dark small">Campus Physical Address</label>
            <textarea name="address" class="form-control py-2" rows="2"><?php echo sanitize($address); ?></textarea>
        </div>

        <div class="mb-4">
            <label class="form-label fw-bold text-dark small">Top Announcement Ticker Bar Text</label>
            <textarea name="ticker_text" class="form-control py-2" rows="3"><?php echo sanitize($ticker); ?></textarea>
        </div>

        <button type="submit" name="save_settings" class="btn btn-danger px-4">
            <i class="fas fa-save me-1"></i> Save Global Settings
        </button>
    </form>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
