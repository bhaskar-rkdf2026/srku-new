<?php
require_once __DIR__ . '/header.php';
$pdo = getDBConnection();
$error = '';

// Handle Delete
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $delId = (int)$_GET['id'];
    try {
        $stmt = $pdo->prepare("DELETE FROM incubation_members WHERE id = :id");
        $stmt->execute([':id' => $delId]);
        setFlashMsg('success', 'Incubation member removed successfully.');
    } catch (Exception $e) {
        setFlashMsg('danger', 'Error removing member: ' . $e->getMessage());
    }
    header("Location: manage_incubation.php");
    exit;
}

// Handle Status Toggle
if (isset($_GET['action']) && $_GET['action'] === 'toggle' && isset($_GET['id'])) {
    $toggleId = (int)$_GET['id'];
    try {
        $stmt = $pdo->prepare("UPDATE incubation_members SET status = CASE WHEN status = 'active' THEN 'inactive' ELSE 'active' END WHERE id = :id");
        $stmt->execute([':id' => $toggleId]);
        setFlashMsg('success', 'Member status updated successfully.');
    } catch (Exception $e) {
        setFlashMsg('danger', 'Error updating status: ' . $e->getMessage());
    }
    header("Location: manage_incubation.php");
    exit;
}

// Handle Add / Edit Form Submission
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['save_incubation_member'])) {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $name = trim($_POST['name'] ?? '');
    $role = trim($_POST['role'] ?? 'Member');
    $highlight = isset($_POST['highlight']) ? 1 : 0;
    $sortOrder = (int)($_POST['sort_order'] ?? 0);
    $status = in_array($_POST['status'] ?? '', ['active', 'inactive']) ? $_POST['status'] : 'active';

    if (empty($name)) {
        $error = 'Please enter Member Name.';
    } else {
        try {
            if ($id > 0) {
                $stmt = $pdo->prepare("UPDATE incubation_members SET name = :n, role = :r, highlight = :h, sort_order = :so, status = :st WHERE id = :id");
                $stmt->execute([
                    ':n' => $name,
                    ':r' => $role,
                    ':h' => $highlight,
                    ':so' => $sortOrder,
                    ':st' => $status,
                    ':id' => $id
                ]);
                setFlashMsg('success', 'Incubation member updated successfully.');
            } else {
                $stmt = $pdo->prepare("INSERT INTO incubation_members (name, role, highlight, sort_order, status) VALUES (:n, :r, :h, :so, :st)");
                $stmt->execute([
                    ':n' => $name,
                    ':r' => $role,
                    ':h' => $highlight,
                    ':so' => $sortOrder,
                    ':st' => $status
                ]);
                setFlashMsg('success', 'New incubation committee member added successfully.');
            }
            header("Location: manage_incubation.php");
            exit;
        } catch (Exception $e) {
            $error = 'Database error: ' . $e->getMessage();
        }
    }
}

// Fetch single record for editing
$editItem = null;
if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
    $editId = (int)$_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM incubation_members WHERE id = :id");
    $stmt->execute([':id' => $editId]);
    $editItem = $stmt->fetch();
}

$members = [];
try {
    $stmt = $pdo->query("SELECT * FROM incubation_members ORDER BY sort_order ASC, id ASC");
    $members = $stmt->fetchAll();
} catch (Exception $e) {
    $error = 'Unable to fetch incubation members: ' . $e->getMessage();
}
?>

<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
    <div>
        <h3 class="h4 fw-bold text-navy mb-1"><i class="fas fa-lightbulb text-warning me-2"></i> Incubation Centre Committee &amp; Advisors</h3>
        <p class="text-muted small mb-0">Manage startup advisory board, faculty mentors, coordinators, and entrepreneurship cell officers.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?php echo BASE_URL; ?>incubation-center.php" target="_blank" class="btn btn-outline-danger btn-sm rounded-pill fw-semibold px-3">
            <i class="fas fa-external-link-alt me-1"></i> Live Incubation Page
        </a>
        <a href="manage_incubation.php#entry-form" class="btn btn-danger btn-sm rounded-pill fw-semibold px-3">
            <i class="fas fa-plus me-1"></i> Add Member
        </a>
    </div>
</div>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-1"></i> <?php echo htmlspecialchars($error); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="row g-4 mb-5">
    
    <!-- Left Column: Add / Edit Form -->
    <div class="col-12 col-lg-5" id="entry-form">
        <div class="card border-0 shadow-sm rounded-4 p-4 sticky-lg-top" style="top: 80px; z-index: 10;">
            <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                <h5 class="fw-bold text-navy mb-0">
                    <i class="fas <?php echo $editItem ? 'fa-edit text-primary' : 'fa-plus-circle text-success'; ?> me-2"></i>
                    <?php echo $editItem ? 'Edit Incubation Member' : 'Add Incubation Committee Member'; ?>
                </h5>
                <?php if ($editItem): ?>
                    <a href="manage_incubation.php" class="btn btn-sm btn-outline-secondary rounded-pill px-2 py-0">Cancel</a>
                <?php endif; ?>
            </div>

            <form action="manage_incubation.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $editItem['id'] ?? 0; ?>">

                <div class="mb-3">
                    <label class="form-label fw-bold small text-dark">Member Full Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control form-control-sm" required
                           value="<?php echo htmlspecialchars($editItem['name'] ?? ''); ?>"
                           placeholder="e.g. Dr. Sushil Singh">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small text-dark">Role / Position <span class="text-danger">*</span></label>
                    <input type="text" name="role" class="form-control form-control-sm" required
                           value="<?php echo htmlspecialchars($editItem['role'] ?? 'Member'); ?>"
                           placeholder="e.g. Centre Co-ordinator, Member">
                </div>

                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="highlight" id="highlightCheck" <?php echo !empty($editItem['highlight']) ? 'checked' : ''; ?>>
                        <label class="form-check-label fw-bold small text-dark" for="highlightCheck">Highlight as Key Coordinator (Red Card)</label>
                    </div>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-dark">Display Order</label>
                        <input type="number" name="sort_order" class="form-control form-control-sm"
                               value="<?php echo htmlspecialchars($editItem['sort_order'] ?? 0); ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-dark">Status</label>
                        <select name="status" class="form-select form-select-sm">
                            <option value="active" <?php echo (($editItem['status'] ?? 'active') === 'active') ? 'selected' : ''; ?>>Active</option>
                            <option value="inactive" <?php echo (($editItem['status'] ?? '') === 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                        </select>
                    </div>
                </div>

                <button type="submit" name="save_incubation_member" class="btn btn-danger btn-sm w-100 rounded-pill py-2 fw-bold">
                    <i class="fas fa-save me-1"></i> <?php echo $editItem ? 'Update Member' : 'Save Member'; ?>
                </button>
            </form>
        </div>
    </div>

    <!-- Right Column: Members List -->
    <div class="col-12 col-lg-7">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h5 class="fw-bold text-navy mb-3">Incubation Cell Committee Members (<?php echo count($members); ?>)</h5>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size: 0.88rem;">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 5%;">#</th>
                            <th style="width: 45%;">Name</th>
                            <th style="width: 25%;">Role</th>
                            <th style="width: 10%;">Status</th>
                            <th style="width: 15%;" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($members)): ?>
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    No members found.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($members as $idx => $m): ?>
                                <tr>
                                    <td class="text-muted fw-bold"><?php echo $m['sort_order'] ?: ($idx + 1); ?></td>
                                    <td>
                                        <div class="fw-bold text-navy"><?php echo htmlspecialchars($m['name']); ?></div>
                                    </td>
                                    <td>
                                        <span class="badge <?php echo !empty($m['highlight']) ? 'bg-danger' : 'bg-light text-dark border'; ?> rounded-pill">
                                            <?php echo htmlspecialchars($m['role']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="manage_incubation.php?action=toggle&id=<?php echo $m['id']; ?>" class="badge rounded-pill text-decoration-none <?php echo $m['status'] === 'active' ? 'bg-success' : 'bg-secondary'; ?>">
                                            <?php echo ucfirst($m['status']); ?>
                                        </a>
                                    </td>
                                    <td class="text-end">
                                        <a href="manage_incubation.php?action=edit&id=<?php echo $m['id']; ?>#entry-form" class="btn btn-sm btn-outline-primary rounded-pill px-2 py-1" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="manage_incubation.php?action=delete&id=<?php echo $m['id']; ?>" class="btn btn-sm btn-outline-danger rounded-pill px-2 py-1 ms-1" onclick="return confirm('Are you sure you want to delete this member?');" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>

<?php require_once __DIR__ . '/footer.php'; ?>
