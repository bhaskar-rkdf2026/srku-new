<?php
require_once __DIR__ . '/header.php';
$pdo = getDBConnection();

if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM enquiries WHERE id = :id");
    $stmt->execute([':id' => $id]);
    setFlashMsg('success', 'Enquiry lead deleted.');
    header("Location: manage_enquiries.php");
    exit;
}

$enquiries = $pdo->query("SELECT * FROM enquiries ORDER BY id DESC")->fetchAll();
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h3 style="font-family: var(--font-heading); color: var(--dark-navy);">Admission Leads & Student Enquiries</h3>
    <small style="color: var(--text-muted); font-weight: 600;">Total Leads: <?php echo count($enquiries); ?></small>
</div>

<div style="background: #ffffff; padding: 25px; border-radius: var(--radius-md); box-shadow: var(--shadow-sm); border: 1px solid var(--border-color);">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Student Details</th>
                <th>Course Interested</th>
                <th>Message / Query</th>
                <th>Received Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($enquiries)): ?>
                <?php foreach ($enquiries as $eq): ?>
                    <tr>
                        <td>#<?php echo $eq['id']; ?></td>
                        <td>
                            <strong style="color: var(--primary-maroon);"><?php echo sanitize($eq['name']); ?></strong><br>
                            <small style="color: var(--text-muted);"><i class="fas fa-envelope"></i> <?php echo sanitize($eq['email']); ?></small><br>
                            <small style="color: var(--text-muted);"><i class="fas fa-phone"></i> <?php echo sanitize($eq['phone']); ?></small>
                        </td>
                        <td><span style="background: var(--light-bg); padding: 4px 8px; border-radius: 4px; font-weight: 600; font-size: 0.85rem; color: var(--dark-navy);"><?php echo sanitize($eq['course']); ?></span></td>
                        <td><p style="font-size: 0.88rem; max-width: 300px; color: var(--text-dark);"><?php echo sanitize($eq['message']); ?></p></td>
                        <td><small><?php echo sanitize($eq['created_at']); ?></small></td>
                        <td>
                            <a href="manage_enquiries.php?action=delete&id=<?php echo $eq['id']; ?>" onclick="return confirm('Delete lead #<?php echo $eq['id']; ?>?');" class="btn-primary" style="padding: 5px 10px; font-size: 0.8rem; background: #dc2626;">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="6" style="text-align: center; color: var(--text-muted);">No student enquiries submitted yet.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
