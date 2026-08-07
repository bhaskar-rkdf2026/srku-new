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

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="h4 fw-bold text-navy mb-0">Admission Leads &amp; Student Enquiries</h3>
    <span class="badge bg-secondary">Total Leads: <?php echo count($enquiries); ?></span>
</div>

<div class="card border-0 shadow-sm rounded-4 p-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#ID</th>
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
                            <td class="fw-bold">#<?php echo $eq['id']; ?></td>
                            <td>
                                <strong class="text-danger d-block"><?php echo sanitize($eq['name']); ?></strong>
                                <small class="text-muted d-block"><i class="fas fa-envelope me-1"></i><?php echo sanitize($eq['email']); ?></small>
                                <small class="text-muted d-block"><i class="fas fa-phone me-1"></i><?php echo sanitize($eq['phone']); ?></small>
                            </td>
                            <td><span class="badge bg-light text-dark border"><?php echo sanitize($eq['course']); ?></span></td>
                            <td><p class="small text-secondary mb-0" style="max-width:300px;"><?php echo sanitize($eq['message']); ?></p></td>
                            <td><small class="text-muted"><?php echo sanitize($eq['created_at']); ?></small></td>
                            <td>
                                <a href="manage_enquiries.php?action=delete&id=<?php echo $eq['id']; ?>" onclick="return confirm('Delete lead #<?php echo $eq['id']; ?>?');" class="btn btn-sm btn-danger">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6" class="text-center text-muted py-4">No student enquiries submitted yet.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
