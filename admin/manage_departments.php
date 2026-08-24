<?php
require_once __DIR__ . '/header.php';
$pdo = getDBConnection();

$action = $_GET['action'] ?? 'list';
$editId = (int)($_GET['id'] ?? 0);

// Handle Delete
if ($action === 'delete' && $editId > 0) {
    $stmt = $pdo->prepare("DELETE FROM departments WHERE id = :id");
    $stmt->execute([':id' => $editId]);
    setFlashMsg('success', 'Department deleted successfully.');
    header("Location: manage_departments.php");
    exit;
}

// Handle Add / Edit Form Submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($_POST['name'] ?? '');
    $category = sanitize($_POST['category'] ?? 'General');
    $slug = sanitize($_POST['slug'] ?? '');
    $icon = sanitize($_POST['icon'] ?? 'fas fa-graduation-cap');
    $dean = sanitize($_POST['dean_name'] ?? '');
    $contact = sanitize($_POST['contact_no'] ?? '0755-4700983, 7024144981');
    $approvals = sanitize($_POST['approvals'] ?? 'UGC');
    $year = sanitize($_POST['established_year'] ?? '2015');
    $desc = $_POST['description'] ?? '';
    $status = sanitize($_POST['status'] ?? 'active');

    if (empty($slug)) {
        $slug = generateSlug($name);
    } else {
        $slug = generateSlug($slug);
    }

    if ($editId > 0) {
        $stmt = $pdo->prepare("UPDATE departments SET name = :n, category = :cat, slug = :s, icon = :i, dean_name = :d, contact_no = :con, approvals = :app, established_year = :y, description = :desc, status = :st WHERE id = :id");
        $stmt->execute([
            ':n' => $name,
            ':cat' => $category,
            ':s' => $slug,
            ':i' => $icon,
            ':d' => $dean,
            ':con' => $contact,
            ':app' => $approvals,
            ':y' => $year,
            ':desc' => $desc,
            ':st' => $status,
            ':id' => $editId
        ]);
        setFlashMsg('success', 'Department updated successfully.');
    } else {
        $stmt = $pdo->prepare("INSERT INTO departments (name, category, slug, icon, dean_name, contact_no, approvals, established_year, description, status) VALUES (:n, :cat, :s, :i, :d, :con, :app, :y, :desc, :st)");
        $stmt->execute([
            ':n' => $name,
            ':cat' => $category,
            ':s' => $slug,
            ':i' => $icon,
            ':d' => $dean,
            ':con' => $contact,
            ':app' => $approvals,
            ':y' => $year,
            ':desc' => $desc,
            ':st' => $status
        ]);
        setFlashMsg('success', 'Department added successfully.');
    }
    header("Location: manage_departments.php");
    exit;
}

// Fetch single item for edit
$editItem = null;
if ($action === 'edit' && $editId > 0) {
    $stmt = $pdo->prepare("SELECT * FROM departments WHERE id = :id");
    $stmt->execute([':id' => $editId]);
    $editItem = $stmt->fetch();
}

$departments = $pdo->query("SELECT * FROM departments ORDER BY name ASC")->fetchAll();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-navy mb-0">Manage Academic Departments &amp; Institutes</h3>
        <p class="text-muted small mb-0">Configure constituent colleges, faculties, dean profiles, and descriptions.</p>
    </div>
    <?php if ($action === 'edit' || $action === 'add'): ?>
        <a href="manage_departments.php" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i> Back to List</a>
    <?php else: ?>
        <a href="manage_departments.php?action=add" class="btn btn-danger btn-sm"><i class="fas fa-plus me-1"></i> Add New Department</a>
    <?php endif; ?>
</div>

<?php if ($action === 'add' || $action === 'edit'): ?>
    <div style="max-width: 960px;">
        <form action="manage_departments.php<?php echo $editId ? '?action=edit&id=' . $editId : ''; ?>" method="POST">
            
            <!-- SECTION 1: Identity & Meta -->
            <div class="admin-form-section">
                <div class="admin-form-section-title">
                    <i class="fas fa-university text-danger"></i> Section 1: Department Identity &amp; Status
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-dark small">Department / Institute Name *</label>
                        <input type="text" name="name" class="form-control" required value="<?php echo sanitize($editItem['name'] ?? ''); ?>" placeholder="e.g. Department of Engineering">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-dark small">URL Slug</label>
                        <input type="text" name="slug" class="form-control" value="<?php echo sanitize($editItem['slug'] ?? ''); ?>" placeholder="Auto-generated if empty">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-dark small">Faculty / Stream Category</label>
                        <input type="text" name="category" class="form-control" value="<?php echo sanitize($editItem['category'] ?? 'General'); ?>" placeholder="e.g. Engineering & Technology, Pharmacy, Medical">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-dark small">Admission Desk Phone</label>
                        <input type="text" name="contact_no" class="form-control" value="<?php echo sanitize($editItem['contact_no'] ?? '0755-4700983, 7024144981'); ?>" placeholder="e.g. 0755-4700983, 7024144981">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-dark small">Apex Approvals (AICTE, PCI, NMC, etc.)</label>
                        <input type="text" name="approvals" class="form-control" value="<?php echo sanitize($editItem['approvals'] ?? 'UGC'); ?>" placeholder="e.g. AICTE, PCI, UGC">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-dark small">FontAwesome Icon Class</label>
                        <input type="text" name="icon" class="form-control" value="<?php echo sanitize($editItem['icon'] ?? 'fas fa-graduation-cap'); ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-dark small">Established Year</label>
                        <input type="text" name="established_year" class="form-control" value="<?php echo sanitize($editItem['established_year'] ?? '2015'); ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-dark small">Display Status</label>
                        <select name="status" class="form-select">
                            <option value="active" <?php echo ($editItem['status'] ?? '') === 'active' ? 'selected' : ''; ?>>Active (Visible)</option>
                            <option value="inactive" <?php echo ($editItem['status'] ?? '') === 'inactive' ? 'selected' : ''; ?>>Inactive (Hidden)</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- SECTION 2: Leadership -->
            <div class="admin-form-section">
                <div class="admin-form-section-title">
                    <i class="fas fa-user-tie text-warning"></i> Section 2: Dean &amp; Leadership Profile
                </div>
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark small">Dean / Principal Name</label>
                        <input type="text" name="dean_name" class="form-control" value="<?php echo sanitize($editItem['dean_name'] ?? ''); ?>" placeholder="e.g. Prof. (Dr.) A. K. Sharma">
                    </div>
                </div>
            </div>

            <!-- SECTION 3: Rich Overview Content with CKEditor -->
            <div class="admin-form-section">
                <div class="admin-form-section-title">
                    <i class="fas fa-edit text-primary"></i> Section 3: Detailed Department Overview (CKEditor)
                </div>
                <div class="mb-2">
                    <label class="form-label fw-bold text-dark small mb-2">Faculty Description &amp; Infrastructure Details</label>
                    <textarea name="description" class="form-control rich-editor" rows="10" placeholder="Write full department profile..."><?php echo htmlspecialchars($editItem['description'] ?? ''); ?></textarea>
                </div>
            </div>

            <div class="d-flex gap-3 justify-content-end mb-5">
                <a href="manage_departments.php" class="btn btn-outline-secondary px-4">Cancel</a>
                <button type="submit" class="btn btn-danger fw-bold px-5">
                    <i class="fas fa-save me-1"></i> <?php echo $action === 'edit' ? 'Update Department' : 'Save Department'; ?>
                </button>
            </div>
        </form>
    </div>

<?php else: ?>
    <!-- Table of Departments -->
    <div class="card p-4 border-0 shadow-sm rounded-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width:50px;">Icon</th>
                        <th>Department / Faculty Name</th>
                        <th>URL Slug</th>
                        <th>Dean / Principal</th>
                        <th>Est.</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($departments as $d): ?>
                        <tr>
                            <td>
                                <div class="bg-light rounded p-2 text-center text-danger" style="width:36px; height:36px; display:inline-flex; align-items:center; justify-content:center;">
                                    <i class="<?php echo sanitize($d['icon'] ?: 'fas fa-graduation-cap'); ?>"></i>
                                </div>
                            </td>
                            <td>
                                <strong class="text-navy d-block"><?php echo sanitize($d['name']); ?></strong>
                                <small class="text-muted"><?php echo substr(strip_tags($d['description'] ?? ''), 0, 60) . '...'; ?></small>
                            </td>
                            <td><code>/<?php echo sanitize($d['slug']); ?></code></td>
                            <td><span class="text-dark small fw-semibold"><?php echo sanitize($d['dean_name'] ?: 'N/A'); ?></span></td>
                            <td><small class="badge bg-light text-dark border"><?php echo sanitize($d['established_year'] ?: '2015'); ?></small></td>
                            <td>
                                <span class="badge bg-<?php echo ($d['status'] ?? 'active') === 'active' ? 'success' : 'secondary'; ?>">
                                    <?php echo ucfirst($d['status'] ?? 'active'); ?>
                                </span>
                            </td>
                            <td class="text-end text-nowrap">
                                <div class="action-btn-group">
                                    <a href="<?php echo BASE_URL . $d['slug']; ?>" target="_blank" class="btn btn-sm btn-outline-primary" title="View Live"><i class="fas fa-external-link-alt"></i></a>
                                    <a href="manage_departments.php?action=edit&id=<?php echo $d['id']; ?>" class="btn btn-sm btn-outline-warning" title="Edit in CKEditor"><i class="fas fa-edit"></i></a>
                                    <a href="manage_departments.php?action=delete&id=<?php echo $d['id']; ?>" onclick="return confirm('Delete department: <?php echo sanitize($d['name']); ?>?');" class="btn btn-sm btn-outline-danger" title="Delete"><i class="fas fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/footer.php'; ?>
