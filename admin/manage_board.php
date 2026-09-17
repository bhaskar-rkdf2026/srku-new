<?php
require_once __DIR__ . '/header.php';
$pdo = getDBConnection();
$error = '';

// Handle Delete
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $delId = (int)$_GET['id'];
    try {
        $stmt = $pdo->prepare("DELETE FROM board_members WHERE id = :id");
        $stmt->execute([':id' => $delId]);
        setFlashMsg('success', 'Board member removed successfully.');
    } catch (Exception $e) {
        setFlashMsg('danger', 'Error removing member: ' . $e->getMessage());
    }
    header("Location: manage_board.php");
    exit;
}

// Handle Status Toggle
if (isset($_GET['action']) && $_GET['action'] === 'toggle' && isset($_GET['id'])) {
    $toggleId = (int)$_GET['id'];
    try {
        $stmt = $pdo->prepare("UPDATE board_members SET status = CASE WHEN status = 'active' THEN 'inactive' ELSE 'active' END WHERE id = :id");
        $stmt->execute([':id' => $toggleId]);
        setFlashMsg('success', 'Board member status updated successfully.');
    } catch (Exception $e) {
        setFlashMsg('danger', 'Error updating status: ' . $e->getMessage());
    }
    header("Location: manage_board.php");
    exit;
}

// Handle Add / Edit
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['save_board_member'])) {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $name = trim($_POST['name'] ?? '');
    $designation = trim($_POST['designation'] ?? '');
    $role = trim($_POST['role'] ?? 'Member');
    $category = in_array($_POST['category'] ?? '', ['leadership', 'sponsoring', 'academic', 'administration']) ? $_POST['category'] : 'academic';
    $representation = trim($_POST['representation'] ?? '');
    $sortOrder = (int)($_POST['sort_order'] ?? 0);
    $status = in_array($_POST['status'] ?? '', ['active', 'inactive']) ? $_POST['status'] : 'active';
    $bio = trim($_POST['bio'] ?? '');
    $photo = trim($_POST['photo'] ?? '');

    // Handle File Upload
    if (isset($_FILES['photo_file']) && $_FILES['photo_file']['error'] === UPLOAD_ERR_OK) {
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        $ext = strtolower(pathinfo($_FILES['photo_file']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, $allowed)) {
            $uploadDir = __DIR__ . '/../assets/uploads/2026/08/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $fn = 'board_' . time() . '_' . rand(100, 999) . '.' . $ext;
            if (move_uploaded_file($_FILES['photo_file']['tmp_name'], $uploadDir . $fn)) {
                $photo = 'assets/uploads/2026/08/' . $fn;
            }
        }
    }

    if (empty($name) || empty($designation)) {
        $error = 'Please fill in both Name and Designation fields.';
    } else {
        try {
            if ($id > 0) {
                $stmt = $pdo->prepare("UPDATE board_members SET name = :n, designation = :des, role = :r, representation = :rep, category = :cat, photo = :p, bio = :b, sort_order = :s, status = :st WHERE id = :id");
                $stmt->execute([
                    ':n' => $name,
                    ':des' => $designation,
                    ':r' => $role,
                    ':rep' => $representation,
                    ':cat' => $category,
                    ':p' => $photo,
                    ':b' => $bio,
                    ':s' => $sortOrder,
                    ':st' => $status,
                    ':id' => $id
                ]);
                setFlashMsg('success', 'Board member updated successfully.');
            } else {
                $stmt = $pdo->prepare("INSERT INTO board_members (name, designation, role, representation, category, photo, bio, sort_order, status) VALUES (:n, :des, :r, :rep, :cat, :p, :b, :s, :st)");
                $stmt->execute([
                    ':n' => $name,
                    ':des' => $designation,
                    ':r' => $role,
                    ':rep' => $representation,
                    ':cat' => $category,
                    ':p' => $photo,
                    ':b' => $bio,
                    ':s' => $sortOrder,
                    ':st' => $status
                ]);
                setFlashMsg('success', 'New board member added successfully.');
            }
            header("Location: manage_board.php");
            exit;
        } catch (Exception $e) {
            $error = 'Database error: ' . $e->getMessage();
        }
    }
}

// Fetch edit target
$editMember = null;
if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
    $editId = (int)$_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM board_members WHERE id = :id");
    $stmt->execute([':id' => $editId]);
    $editMember = $stmt->fetch();
}

// Fetch all board members
$members = [];
try {
    $stmt = $pdo->query("SELECT * FROM board_members ORDER BY sort_order ASC, id ASC");
    $members = $stmt->fetchAll();
} catch (Exception $e) {
    $error = 'Unable to fetch members: ' . $e->getMessage();
}
?>

<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
    <div>
        <h3 class="h4 fw-bold text-navy mb-1"><i class="fas fa-users-cog text-warning me-2"></i> Board of Management Governance</h3>
        <p class="text-muted small mb-0">Manage university trustees, governing council officers, academic leaders and member roles.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?php echo BASE_URL; ?>board-of-management.php" target="_blank" class="btn btn-outline-danger btn-sm rounded-pill fw-semibold px-3">
            <i class="fas fa-external-link-alt me-1"></i> View Live Board Page
        </a>
        <a href="manage_board.php#member-form" class="btn btn-danger btn-sm rounded-pill fw-semibold px-3">
            <i class="fas fa-plus me-1"></i> Add Board Member
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
    
    <!-- Left Column: Add / Edit Member Form -->
    <div class="col-12 col-lg-5" id="member-form">
        <div class="card border-0 shadow-sm rounded-4 p-4 sticky-lg-top" style="top: 80px; z-index: 10;">
            <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                <h5 class="fw-bold text-navy mb-0">
                    <i class="fas <?php echo $editMember ? 'fa-user-edit text-primary' : 'fa-user-plus text-success'; ?> me-2"></i>
                    <?php echo $editMember ? 'Edit Board Member' : 'Add New Board Member'; ?>
                </h5>
                <?php if ($editMember): ?>
                    <a href="manage_board.php" class="btn btn-sm btn-outline-secondary rounded-pill px-2 py-0">Cancel</a>
                <?php endif; ?>
            </div>

            <form action="manage_board.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $editMember['id'] ?? 0; ?>">

                <div class="mb-3">
                    <label class="form-label fw-bold small text-dark">Full Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control form-control-sm" required
                           value="<?php echo htmlspecialchars($editMember['name'] ?? ''); ?>"
                           placeholder="e.g. Dr. Priyanka Jaiswal">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small text-dark">Designation &amp; Affiliation <span class="text-danger">*</span></label>
                    <input type="text" name="designation" class="form-control form-control-sm" required
                           value="<?php echo htmlspecialchars($editMember['designation'] ?? ''); ?>"
                           placeholder="e.g. Vice Chancellor, Sarvepalli Radhakrishnan University">
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-dark">Directory Category <span class="text-danger">*</span></label>
                        <select name="category" class="form-select form-select-sm" required>
                            <option value="leadership" <?php echo (($editMember['category'] ?? '') === 'leadership') ? 'selected' : ''; ?>>University Leadership</option>
                            <option value="sponsoring" <?php echo (($editMember['category'] ?? '') === 'sponsoring') ? 'selected' : ''; ?>>Sponsoring Body</option>
                            <option value="academic" <?php echo (($editMember['category'] ?? 'academic') === 'academic') ? 'selected' : ''; ?>>Academic Leaders</option>
                            <option value="administration" <?php echo (($editMember['category'] ?? '') === 'administration') ? 'selected' : ''; ?>>Administration</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-dark">Representation / Board Role</label>
                        <input type="text" name="representation" class="form-control form-control-sm"
                               value="<?php echo htmlspecialchars($editMember['representation'] ?? ''); ?>"
                               placeholder="e.g. Sponsoring Body / Academician">
                    </div>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-md-7">
                        <label class="form-label fw-bold small text-dark">Governance Role</label>
                        <input type="text" name="role" class="form-control form-control-sm"
                               value="<?php echo htmlspecialchars($editMember['role'] ?? 'Member'); ?>"
                               placeholder="e.g. Chairperson, Member Secretary, Member">
                    </div>
                    <div class="col-md-5">
                        <label class="form-label fw-bold small text-dark">Display Order</label>
                        <input type="number" name="sort_order" class="form-control form-control-sm"
                               value="<?php echo (int)($editMember['sort_order'] ?? (count($members) + 1)); ?>" min="0">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small text-dark">Status</label>
                    <select name="status" class="form-select form-select-sm">
                        <option value="active" <?php echo ($editMember['status'] ?? 'active') === 'active' ? 'selected' : ''; ?>>Active (Visible on public site)</option>
                        <option value="inactive" <?php echo ($editMember['status'] ?? '') === 'inactive' ? 'selected' : ''; ?>>Inactive (Hidden)</option>
                    </select>
                </div>

                <div class="mb-3 p-3 bg-light rounded-3 border">
                    <label class="form-label fw-bold text-navy small mb-1"><i class="fas fa-camera text-danger me-1"></i> Member Photo</label>
                    <?php if (!empty($editMember['photo'])): ?>
                        <div class="d-flex align-items-center gap-2 mb-2 p-2 bg-white rounded border">
                            <img src="<?php echo BASE_URL . $editMember['photo']; ?>" alt="Preview" style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%;">
                            <span class="small text-truncate text-muted"><?php echo htmlspecialchars($editMember['photo']); ?></span>
                        </div>
                    <?php endif; ?>
                    <input type="text" name="photo" class="form-control form-control-sm mb-2"
                           value="<?php echo htmlspecialchars($editMember['photo'] ?? ''); ?>"
                           placeholder="assets/uploads/... or paste full URL">
                    <label class="form-label small text-muted mb-1">OR Upload Photo File</label>
                    <input type="file" name="photo_file" class="form-control form-control-sm" accept="image/*">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small text-dark">Brief Bio / Profile Description</label>
                    <textarea name="bio" class="form-control form-control-sm" rows="3"
                              placeholder="Brief background, achievements or portfolio..."><?php echo htmlspecialchars($editMember['bio'] ?? ''); ?></textarea>
                </div>

                <div class="d-grid">
                    <button type="submit" name="save_board_member" class="btn btn-danger fw-bold py-2 shadow-sm">
                        <i class="fas fa-save me-1"></i> <?php echo $editMember ? 'Save Member Changes' : 'Add Board Member'; ?>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Right Column: Current Board Members Table -->
    <div class="col-12 col-lg-7">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-header bg-white py-3 px-4 border-bottom d-flex justify-content-between align-items-center">
                <h5 class="fw-bold text-navy mb-0">Active Board Members (<?php echo count($members); ?>)</h5>
                <span class="badge bg-danger-subtle text-danger rounded-pill fw-semibold px-3">Official Directory</span>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light small text-uppercase fw-bold text-muted">
                        <tr>
                            <th style="width: 50px;" class="text-center">Order</th>
                            <th style="width: 60px;">Photo</th>
                            <th>Member Details</th>
                            <th>Role</th>
                            <th class="text-center">Status</th>
                            <th class="text-end pe-4" style="width: 110px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($members)): ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">
                                    <i class="fas fa-users fa-3x mb-3 text-secondary opacity-50 d-block"></i>
                                    No board members found. Click "Add Board Member" to populate.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($members as $m): ?>
                                <tr>
                                    <td class="text-center fw-bold text-muted small">
                                        #<?php echo (int)$m['sort_order']; ?>
                                    </td>
                                    <td>
                                        <div class="rounded-circle overflow-hidden bg-light border d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                                            <?php 
                                            $mPhoto = trim($m['photo'] ?? '');
                                            $adminAvatar = BASE_URL . 'assets/images/default-avatar.svg';
                                            $mSrc = (!empty($mPhoto) && file_exists(__DIR__ . '/../' . ltrim($mPhoto, '/\\'))) ? (BASE_URL . ltrim($mPhoto, '/\\')) : $adminAvatar;
                                            ?>
                                            <img src="<?php echo $mSrc; ?>"
                                                 onerror="this.onerror=null; this.src='<?php echo $adminAvatar; ?>';"
                                                 alt="<?php echo htmlspecialchars($m['name']); ?>"
                                                 style="width: 100%; height: 100%; object-fit: cover;">
                                        </div>
                                    </td>
                                    <td>
                                        <strong class="text-navy d-block" style="font-size: 0.95rem;">
                                            <?php echo htmlspecialchars($m['name']); ?>
                                        </strong>
                                        <small class="text-muted d-block" style="font-size: 0.82rem;">
                                            <?php echo htmlspecialchars($m['designation']); ?>
                                        </small>
                                        <div class="d-flex flex-wrap gap-1 mt-1">
                                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-2 py-0 small fw-semibold">
                                                <i class="fas fa-tag me-1"></i><?php echo htmlspecialchars(ucfirst($m['category'] ?? 'academic')); ?>
                                            </span>
                                            <?php if (!empty($m['representation'])): ?>
                                                <span class="badge bg-light text-dark border rounded-pill px-2 py-0 small">
                                                    <?php echo htmlspecialchars($m['representation']); ?>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        <?php if (!empty($m['bio'])): ?>
                                            <p class="text-secondary small mb-0 mt-1 text-truncate" style="max-width: 260px; font-size: 0.78rem;">
                                                <?php echo htmlspecialchars($m['bio']); ?>
                                            </p>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php
                                        $roleBadge = 'bg-secondary';
                                        $roleText = $m['role'] ?? 'Member';
                                        if (stripos($roleText, 'Chair') !== false) {
                                            $roleBadge = 'bg-warning text-dark';
                                        } elseif (stripos($roleText, 'Secretary') !== false || stripos($roleText, 'Registrar') !== false) {
                                            $roleBadge = 'bg-info text-dark';
                                        } elseif (stripos($roleText, 'Member') !== false) {
                                            $roleBadge = 'bg-danger-subtle text-danger';
                                        }
                                        ?>
                                        <span class="badge <?php echo $roleBadge; ?> rounded-pill px-2 py-1 fw-bold" style="font-size: 0.75rem;">
                                            <?php echo htmlspecialchars($roleText); ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="manage_board.php?action=toggle&id=<?php echo $m['id']; ?>"
                                           class="badge rounded-pill text-decoration-none px-3 py-1 <?php echo $m['status'] === 'active' ? 'bg-success text-white' : 'bg-secondary text-white'; ?>"
                                           title="Click to toggle active/inactive status">
                                            <?php echo ucfirst($m['status']); ?>
                                        </a>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="action-btn-group">
                                            <a href="manage_board.php?action=edit&id=<?php echo $m['id']; ?>#member-form"
                                               class="btn btn-sm btn-outline-primary" title="Edit Member">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="manage_board.php?action=delete&id=<?php echo $m['id']; ?>"
                                               class="btn btn-sm btn-outline-danger"
                                               onclick="return confirm('Are you sure you want to remove <?php echo addslashes($m['name']); ?> from the Board of Management?');"
                                               title="Delete Member">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </div>
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
