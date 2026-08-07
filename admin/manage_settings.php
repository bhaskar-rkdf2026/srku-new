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

<div style="margin-bottom: 20px;">
    <h3 style="font-family: var(--font-heading); color: var(--dark-navy);">Global Website Settings</h3>
</div>

<div style="background: #ffffff; padding: 30px; border-radius: var(--radius-md); box-shadow: var(--shadow-sm); border: 1px solid var(--border-color); max-width: 800px;">
    <form action="manage_settings.php" method="POST">
        <div class="form-group">
            <label>Helpline Phone Number</label>
            <input type="text" name="helpline" class="form-control" value="<?php echo sanitize($helpline); ?>" placeholder="0755 - 4911204">
        </div>

        <div class="form-group">
            <label>Official Email Address</label>
            <input type="email" name="email" class="form-control" value="<?php echo sanitize($email); ?>" placeholder="exam@srku.edu.in">
        </div>

        <div class="form-group">
            <label>Campus Physical Address</label>
            <textarea name="address" class="form-control" rows="2"><?php echo sanitize($address); ?></textarea>
        </div>

        <div class="form-group">
            <label>Top Announcement Ticker Bar Text</label>
            <textarea name="ticker_text" class="form-control" rows="3"><?php echo sanitize($ticker); ?></textarea>
        </div>

        <button type="submit" name="save_settings" class="btn-primary" style="border: none; cursor: pointer;">
            <i class="fas fa-save"></i> Save Global Settings
        </button>
    </form>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
