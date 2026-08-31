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
    $image = trim((string)($_POST['image'] ?? 'assets/uploads/2026/07/001.webp'));
    $dean = sanitize($_POST['dean_name'] ?? '');
    $deanDesignation = sanitize($_POST['dean_designation'] ?? 'Dean & Principal');
    $deanPhoto = trim((string)($_POST['dean_photo'] ?? ''));
    $deanMessage = $_POST['dean_message'] ?? '';
    $contact = sanitize($_POST['contact_no'] ?? '0755-4700983, 7024144981');
    $approvals = sanitize($_POST['approvals'] ?? 'UGC');
    $year = sanitize($_POST['established_year'] ?? '2015');
    $desc = $_POST['description'] ?? '';
    $status = sanitize($_POST['status'] ?? 'active');

    // Handle Department Campus Image Upload
    if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        $ext = strtolower(pathinfo($_FILES['image_file']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, $allowed)) {
            $uploadDir = __DIR__ . '/../assets/uploads/2026/07/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
            $fn = 'dept_' . time() . '.' . $ext;
            if (move_uploaded_file($_FILES['image_file']['tmp_name'], $uploadDir . $fn)) {
                $image = 'assets/uploads/2026/07/' . $fn;
            }
        }
    }

    // Handle Dean / Principal Photo Upload
    if (isset($_FILES['dean_photo_file']) && $_FILES['dean_photo_file']['error'] === UPLOAD_ERR_OK) {
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        $ext = strtolower(pathinfo($_FILES['dean_photo_file']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, $allowed)) {
            $uploadDir = __DIR__ . '/../assets/uploads/2026/08/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
            $fn = 'dean_' . time() . '.' . $ext;
            if (move_uploaded_file($_FILES['dean_photo_file']['tmp_name'], $uploadDir . $fn)) {
                $deanPhoto = 'assets/uploads/2026/08/' . $fn;
            }
        }
    }

    if (empty($slug)) {
        $slug = generateSlug($name);
    } else {
        $slug = generateSlug($slug);
    }

    if ($editId > 0) {
        $stmt = $pdo->prepare("UPDATE departments SET name = :n, category = :cat, slug = :s, icon = :i, image = :img, banner_img = :bimg, dean_name = :d, dean_designation = :dd, dean_photo = :dp, dean_message = :dm, contact_no = :con, approvals = :app, established_year = :y, description = :desc, status = :st WHERE id = :id");
        $stmt->execute([
            ':n' => $name,
            ':cat' => $category,
            ':s' => $slug,
            ':i' => $icon,
            ':img' => $image,
            ':bimg' => $image,
            ':d' => $dean,
            ':dd' => $deanDesignation,
            ':dp' => $deanPhoto,
            ':dm' => $deanMessage,
            ':con' => $contact,
            ':app' => $approvals,
            ':y' => $year,
            ':desc' => $desc,
            ':st' => $status,
            ':id' => $editId
        ]);
        setFlashMsg('success', 'Department updated successfully.');
    } else {
        $stmt = $pdo->prepare("INSERT INTO departments (name, category, slug, icon, image, banner_img, dean_name, dean_designation, dean_photo, dean_message, contact_no, approvals, established_year, description, status) VALUES (:n, :cat, :s, :i, :img, :bimg, :d, :dd, :dp, :dm, :con, :app, :y, :desc, :st)");
        $stmt->execute([
            ':n' => $name,
            ':cat' => $category,
            ':s' => $slug,
            ':i' => $icon,
            ':img' => $image,
            ':bimg' => $image,
            ':d' => $dean,
            ':dd' => $deanDesignation,
            ':dp' => $deanPhoto,
            ':dm' => $deanMessage,
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

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h3 class="fw-bold text-navy mb-0">Manage Constituent Units &amp; Academic Departments <span class="badge bg-danger-subtle text-danger fs-6 rounded-pill ms-2"><?php echo count($departments); ?> Units</span></h3>
        <p class="text-muted small mb-0">Configure all 26 constituent colleges, faculties, dean profiles, and campus images.</p>
    </div>
    <?php if ($action === 'edit' || $action === 'add'): ?>
        <a href="manage_departments.php" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i> Back to List</a>
    <?php else: ?>
        <a href="manage_departments.php?action=add" class="btn btn-danger btn-sm"><i class="fas fa-plus me-1"></i> Add New Department</a>
    <?php endif; ?>
</div>

<?php if ($action === 'add' || $action === 'edit'): ?>
    <div style="max-width: 960px;">
        <form action="manage_departments.php<?php echo $editId ? '?action=edit&id=' . $editId : ''; ?>" method="POST" enctype="multipart/form-data">
            
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

            <!-- SECTION 2: Image & Media -->
            <div class="admin-form-section">
                <div class="admin-form-section-title">
                    <i class="fas fa-image text-danger"></i> Section 2: Department Campus / Building Image
                </div>
                <div class="row g-3 align-items-center">
                    <div class="col-12 col-md-3 text-center">
                        <?php 
                        $deptImg = !empty($editItem['image']) ? $editItem['image'] : (!empty($editItem['banner_img']) ? $editItem['banner_img'] : '');
                        if (empty($deptImg) || !file_exists(__DIR__ . '/../' . ltrim(str_replace('\\', '/', $deptImg), '/'))) {
                            $cand = 'assets/uploads/constituent-units/' . ($editItem['slug'] ?? '') . '.webp';
                            if (!empty($editItem['slug']) && file_exists(__DIR__ . '/../' . $cand)) {
                                $deptImg = $cand;
                            } else {
                                $deptImg = 'assets/uploads/2026/07/001.webp';
                            }
                        }
                        $deptImgSrc = resolveMediaUrl($deptImg, 'assets/uploads/2026/07/001.webp');
                        ?>
                        <div class="rounded-3 overflow-hidden border shadow-xs bg-light p-1" style="height: 120px;">
                            <img src="<?php echo $deptImgSrc; ?>" 
                                 onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';"
                                 alt="Preview" class="w-100 h-100 rounded-2" style="object-fit: cover;">
                        </div>
                    </div>
                    <div class="col-12 col-md-9">
                        <div class="mb-2">
                            <label class="form-label fw-bold text-dark small">Image Relative Path or URL</label>
                            <input type="text" name="image" class="form-control form-control-sm" value="<?php echo sanitize($editItem['image'] ?? 'assets/uploads/2026/07/001.webp'); ?>" placeholder="e.g. assets/uploads/2026/07/001.webp">
                        </div>
                        <div>
                            <label class="form-label fw-bold text-dark small">OR Upload New Image</label>
                            <input type="file" name="image_file" class="form-control form-control-sm" accept="image/*">
                            <small class="text-muted">High resolution campus/building photo (WebP/JPG/PNG).</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION 3: Leadership Profile -->
            <div class="admin-form-section">
                <div class="admin-form-section-title">
                    <i class="fas fa-user-tie text-warning"></i> Section 3: Dean / Principal Leadership &amp; Message
                </div>
                <div class="row g-3 align-items-start">
                    <div class="col-12 col-md-6">
                        <label class="form-label fw-bold text-dark small">Dean / Principal / Head Name</label>
                        <input type="text" name="dean_name" class="form-control" value="<?php echo sanitize($editItem['dean_name'] ?? ''); ?>" placeholder="e.g. Prof. (Dr.) A. K. Sharma">
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label fw-bold text-dark small">Designation / Role Title</label>
                        <input type="text" name="dean_designation" class="form-control" list="designationList" value="<?php echo sanitize($editItem['dean_designation'] ?? 'Dean & Principal'); ?>" placeholder="e.g. Dean, Principal, Director">
                        <datalist id="designationList">
                            <option value="Dean &amp; Principal">
                            <option value="Principal">
                            <option value="Dean">
                            <option value="Director">
                            <option value="Head of Department">
                            <option value="Principal &amp; Medical Superintendent">
                        </datalist>
                    </div>

                    <!-- Dean Photo -->
                    <div class="col-12 col-md-4">
                        <div class="p-3 bg-light rounded-3 border text-center">
                            <label class="form-label fw-bold text-navy small mb-2"><i class="fas fa-camera text-primary me-1"></i> Dean / Principal Photo</label>
                            <div class="mx-auto rounded-circle overflow-hidden mb-2 shadow-xs bg-white border p-1" style="width: 100px; height: 100px;">
                                <?php 
                                $dPhoto = $editItem['dean_photo'] ?? '';
                                if (!empty($dPhoto)): 
                                    $dPhotoSrc = (strpos($dPhoto, 'http') === 0) ? $dPhoto : BASE_URL . $dPhoto;
                                ?>
                                    <img src="<?php echo $dPhotoSrc; ?>" alt="Dean" class="w-100 h-100 rounded-circle object-fit-cover">
                                <?php else: ?>
                                    <div class="w-100 h-100 rounded-circle bg-light d-flex flex-column align-items-center justify-content-center text-muted">
                                        <i class="fas fa-user-tie text-primary fs-3"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <input type="text" name="dean_photo" class="form-control form-control-sm mb-2" value="<?php echo sanitize($editItem['dean_photo'] ?? ''); ?>" placeholder="Photo path or empty">
                            <input type="file" name="dean_photo_file" class="form-control form-control-sm" accept="image/*">
                            <small class="text-muted" style="font-size:0.72rem;">Upload portrait photo (JPG/PNG/WebP).</small>
                        </div>
                    </div>

                    <!-- Dean Welcome Message / Desk Note -->
                    <div class="col-12 col-md-8">
                        <label class="form-label fw-bold text-dark small"><i class="fas fa-comment-alt text-danger me-1"></i> Message from Dean / Principal's Desk</label>
                        <textarea name="dean_message" class="form-control" rows="6" placeholder="Welcome to our college. We are committed to fostering academic excellence, clinical precision, research innovation, and ethical leadership..."><?php echo htmlspecialchars($editItem['dean_message'] ?? ''); ?></textarea>
                        <small class="text-muted">This message and leadership profile will be featured prominently on this constituent unit's detail page.</small>
                    </div>
                </div>
            </div>

            <!-- SECTION 4: Rich Overview Content with CKEditor -->
            <div class="admin-form-section">
                <div class="admin-form-section-title">
                    <i class="fas fa-edit text-primary"></i> Section 4: Detailed Department Overview (CKEditor)
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
                        <th style="width:60px;">Image</th>
                        <th>Department / Faculty Name</th>
                        <th>URL Slug</th>
                        <th>Dean / Principal</th>
                        <th>Est.</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($departments as $d): 
                        $dImg = !empty($d['image']) ? $d['image'] : (!empty($d['banner_img']) ? $d['banner_img'] : '');
                        if (empty($dImg) || !file_exists(__DIR__ . '/../' . ltrim(str_replace('\\', '/', $dImg), '/'))) {
                            $cand = 'assets/uploads/constituent-units/' . ($d['slug'] ?? '') . '.webp';
                            if (file_exists(__DIR__ . '/../' . $cand)) {
                                $dImg = $cand;
                            } else {
                                $dImg = 'assets/uploads/2026/07/001.webp';
                            }
                        }
                        $dImgSrc = resolveMediaUrl($dImg, 'assets/uploads/2026/07/001.webp');
                    ?>
                        <tr>
                            <td>
                                <div class="rounded-3 overflow-hidden border shadow-xs bg-light" style="width:50px; height:40px;">
                                    <img src="<?php echo $dImgSrc; ?>" 
                                         onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/uploads/2026/07/001.webp';"
                                         alt="<?php echo sanitize($d['name']); ?>" class="w-100 h-100 object-fit-cover">
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
