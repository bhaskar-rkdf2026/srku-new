<?php
require_once __DIR__ . '/../includes/functions.php';
checkAdminLogin();

$pdo = getDBConnection();
$error = '';
$success = '';

// Handle Delete
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $delId = (int)$_GET['id'];
    try {
        $stmt = $pdo->prepare("DELETE FROM faculty WHERE id = :id");
        $stmt->execute([':id' => $delId]);
        setFlashMsg('success', 'Faculty record deleted successfully.');
    } catch (Exception $e) {
        setFlashMsg('danger', 'Error deleting faculty: ' . $e->getMessage());
    }
    header("Location: manage_faculty.php");
    exit;
}

// Handle Add / Edit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_faculty'])) {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $deptName = trim($_POST['department_name'] ?? '');
    $name = trim($_POST['name'] ?? '');
    $designation = trim($_POST['designation'] ?? '');
    $qualification = trim($_POST['qualification'] ?? '');
    $experience = trim($_POST['experience'] ?? '');
    $status = $_POST['status'] ?? 'active';

    if (empty($name) || empty($deptName) || empty($designation)) {
        $error = 'Please fill in all required fields (Name, Department, Designation).';
    } else {
        $deptSlug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $deptName)));
        try {
            if ($id > 0) {
                $stmt = $pdo->prepare("UPDATE faculty SET department_name = :d, dept_slug = :ds, name = :n, designation = :des, qualification = :q, experience = :e, status = :st WHERE id = :id");
                $stmt->execute([
                    ':d' => $deptName,
                    ':ds' => $deptSlug,
                    ':n' => $name,
                    ':des' => $designation,
                    ':q' => $qualification,
                    ':e' => $experience,
                    ':st' => $status,
                    ':id' => $id
                ]);
                setFlashMsg('success', 'Faculty details updated successfully.');
            } else {
                $stmt = $pdo->prepare("INSERT INTO faculty (department_name, dept_slug, name, designation, qualification, experience, status) VALUES (:d, :ds, :n, :des, :q, :e, :st)");
                $stmt->execute([
                    ':d' => $deptName,
                    ':ds' => $deptSlug,
                    ':n' => $name,
                    ':des' => $designation,
                    ':q' => $qualification,
                    ':e' => $experience,
                    ':st' => $status
                ]);
                setFlashMsg('success', 'New faculty member added successfully.');
            }
            header("Location: manage_faculty.php");
            exit;
        } catch (Exception $e) {
            $error = 'Database error: ' . $e->getMessage();
        }
    }
}

// Fetch edit target
$editFaculty = null;
if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])) {
    $editId = (int)$_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM faculty WHERE id = :id");
    $stmt->execute([':id' => $editId]);
    $editFaculty = $stmt->fetch();
}

// Filter and Pagination params
$filterDept = $_GET['dept'] ?? '';
$filterDesig = $_GET['desig'] ?? '';
$search = trim($_GET['search'] ?? '');
$page = isset($_GET['p']) ? max(1, (int)$_GET['p']) : 1;
$perPage = 50;
$offset = ($page - 1) * $perPage;

// Build query
$where = ["1=1"];
$params = [];

if ($filterDept) {
    $where[] = "dept_slug = :fdept";
    $params[':fdept'] = $filterDept;
}
if ($filterDesig) {
    if ($filterDesig === 'dean_principal') {
        $where[] = "(designation LIKE '%Dean%' OR designation LIKE '%Principal%' OR designation LIKE '%Director%')";
    } elseif ($filterDesig === 'professor') {
        $where[] = "(designation LIKE '%Professor%' AND designation NOT LIKE '%Associate%' AND designation NOT LIKE '%Assistant%' AND designation NOT LIKE '%Dean%' AND designation NOT LIKE '%Principal%' AND designation NOT LIKE '%Director%')";
    } elseif ($filterDesig === 'associate_professor') {
        $where[] = "(designation LIKE '%Associate Professor%' OR designation LIKE '%Reader%')";
    } elseif ($filterDesig === 'assistant_professor') {
        $where[] = "(designation LIKE '%Assistant Professor%' OR designation LIKE '%Lecturer%')";
    } elseif ($filterDesig === 'resident') {
        $where[] = "(designation LIKE '%Resident%')";
    } elseif ($filterDesig === 'tutor') {
        $where[] = "(designation LIKE '%Tutor%' OR designation LIKE '%CMO%')";
    }
}
if ($search) {
    $where[] = "(name LIKE :s OR department_name LIKE :s OR qualification LIKE :s OR designation LIKE :s)";
    $params[':s'] = "%" . $search . "%";
}

$whereClause = implode(" AND ", $where);

// Total Count
$countStmt = $pdo->prepare("SELECT COUNT(*) FROM faculty WHERE $whereClause");
$countStmt->execute($params);
$totalRecords = $countStmt->fetchColumn();
$totalPages = ceil($totalRecords / $perPage);

// Fetch Paginated List
$dataStmt = $pdo->prepare("SELECT * FROM faculty WHERE $whereClause ORDER BY id ASC LIMIT $perPage OFFSET $offset");
$dataStmt->execute($params);
$facultyList = $dataStmt->fetchAll();

// Overall Stats
$stats = getFacultyStats();
$departments = getFacultyDepartments();

$pageTitle = "Manage Faculty Directory";
require_once __DIR__ . '/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h3 class="fw-bold text-navy mb-1"><i class="fas fa-chalkboard-teacher text-danger me-2"></i> University Faculty Directory</h3>
        <p class="text-muted small mb-0">Manage teachers, professors, clinical doctors, and deans across all 15 university institutes.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?php echo BASE_URL; ?>faculties.php" target="_blank" class="btn btn-outline-dark btn-sm">
            <i class="fas fa-external-link-alt me-1"></i> View Live Directory
        </a>
        <a href="manage_faculty.php?action=add" class="btn btn-danger btn-sm fw-bold">
            <i class="fas fa-user-plus me-1"></i> Add Faculty Member
        </a>
    </div>
</div>

<?php displayFlashMsg(); ?>

<?php if ($error): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php echo $error; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<!-- Summary KPI Row -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="p-3 bg-white border rounded-3 shadow-xs text-center">
            <h4 class="fw-bold text-navy mb-0"><?php echo number_format($stats['total']); ?></h4>
            <small class="text-muted fw-semibold">Total Faculty Members</small>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="p-3 bg-white border rounded-3 shadow-xs text-center">
            <h4 class="fw-bold text-primary mb-0"><?php echo $stats['departments']; ?></h4>
            <small class="text-muted fw-semibold">Institutes &amp; Colleges</small>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="p-3 bg-white border rounded-3 shadow-xs text-center">
            <h4 class="fw-bold text-danger mb-0"><?php echo number_format($stats['professors']); ?></h4>
            <small class="text-muted fw-semibold">Professors &amp; Deans</small>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="p-3 bg-white border rounded-3 shadow-xs text-center">
            <h4 class="fw-bold text-success mb-0"><?php echo number_format($stats['phd_md_count']); ?></h4>
            <small class="text-muted fw-semibold">MD / MS / PhD Mentors</small>
        </div>
    </div>
</div>

<?php if (isset($_GET['action']) && ($_GET['action'] == 'add' || $_GET['action'] == 'edit')): ?>
    <!-- Add / Edit Form Card -->
    <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
        <h5 class="fw-bold text-navy mb-3 pb-2 border-bottom">
            <i class="fas fa-<?php echo $editFaculty ? 'edit text-primary' : 'user-plus text-danger'; ?> me-2"></i>
            <?php echo $editFaculty ? 'Edit Faculty Record: ' . sanitize($editFaculty['name']) : 'Add New Faculty Member'; ?>
        </h5>

        <form method="POST" action="manage_faculty.php">
            <input type="hidden" name="id" value="<?php echo $editFaculty['id'] ?? 0; ?>">

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold small">Teacher / Doctor Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" placeholder="e.g. Dr. Rakesh Kumar Pandey" value="<?php echo sanitize($editFaculty['name'] ?? ''); ?>" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold small">Department / Constituent College <span class="text-danger">*</span></label>
                    <input type="text" name="department_name" class="form-control" list="deptList" placeholder="e.g. RKDF Dental College & Research Centre" value="<?php echo sanitize($editFaculty['department_name'] ?? ''); ?>" required>
                    <datalist id="deptList">
                        <?php foreach ($departments as $d): ?>
                            <option value="<?php echo sanitize($d['department_name']); ?>">
                        <?php endforeach; ?>
                    </datalist>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-bold small">Designation / Role <span class="text-danger">*</span></label>
                    <input type="text" name="designation" class="form-control" placeholder="e.g. Professor & HOD / Associate Professor" value="<?php echo sanitize($editFaculty['designation'] ?? ''); ?>" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-bold small">Highest Qualification</label>
                    <input type="text" name="qualification" class="form-control" placeholder="e.g. MD, MS / MDS / M.Pharm, PhD" value="<?php echo sanitize($editFaculty['qualification'] ?? ''); ?>">
                </div>

                <div class="col-md-2">
                    <label class="form-label fw-bold small">Teaching Experience</label>
                    <input type="text" name="experience" class="form-control" placeholder="e.g. 12 Years 4 Months" value="<?php echo sanitize($editFaculty['experience'] ?? ''); ?>">
                </div>

                <div class="col-md-2">
                    <label class="form-label fw-bold small">Status</label>
                    <select name="status" class="form-select">
                        <option value="active" <?php echo ($editFaculty['status'] ?? '') === 'active' ? 'selected' : ''; ?>>Active</option>
                        <option value="inactive" <?php echo ($editFaculty['status'] ?? '') === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                    </select>
                </div>
            </div>

            <div class="d-flex gap-2 justify-content-end mt-4 pt-3 border-top">
                <a href="manage_faculty.php" class="btn btn-outline-secondary px-4">Cancel</a>
                <button type="submit" name="save_faculty" class="btn btn-danger px-4 fw-bold">
                    <i class="fas fa-save me-1"></i> <?php echo $editFaculty ? 'Update Faculty' : 'Save Faculty'; ?>
                </button>
            </div>
        </form>
    </div>
<?php endif; ?>

<!-- Filter & Search Bar Card -->
<div class="card border-0 shadow-sm rounded-4 p-3 mb-4 bg-white">
    <form method="GET" action="manage_faculty.php" class="row g-2 align-items-center">
        <div class="col-12 col-md-4">
            <div class="input-group input-group-sm">
                <span class="input-group-text bg-light"><i class="fas fa-search"></i></span>
                <input type="text" name="search" class="form-control" placeholder="Search by name, qualification..." value="<?php echo sanitize($search); ?>">
            </div>
        </div>

        <div class="col-12 col-md-4">
            <select name="dept" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="">All Constituent Institutes (15)</option>
                <?php foreach ($departments as $d): ?>
                    <option value="<?php echo sanitize($d['dept_slug']); ?>" <?php echo $filterDept === $d['dept_slug'] ? 'selected' : ''; ?>>
                        <?php echo sanitize($d['department_name']); ?> (<?php echo $d['count']; ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-12 col-md-3">
            <select name="desig" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="">All Academic Roles (1,047)</option>
                <option value="dean_principal" <?php echo $filterDesig === 'dean_principal' ? 'selected' : ''; ?>>Deans &amp; Principals</option>
                <option value="professor" <?php echo $filterDesig === 'professor' ? 'selected' : ''; ?>>Professors &amp; HODs</option>
                <option value="associate_professor" <?php echo $filterDesig === 'associate_professor' ? 'selected' : ''; ?>>Associate Professors &amp; Readers</option>
                <option value="assistant_professor" <?php echo $filterDesig === 'assistant_professor' ? 'selected' : ''; ?>>Assistant Professors &amp; Lecturers</option>
                <option value="resident" <?php echo $filterDesig === 'resident' ? 'selected' : ''; ?>>Senior &amp; Junior Residents</option>
                <option value="tutor" <?php echo $filterDesig === 'tutor' ? 'selected' : ''; ?>>Clinical Tutors &amp; Instructors</option>
            </select>
        </div>

        <div class="col-12 col-md-1 d-flex gap-1">
            <button type="submit" class="btn btn-danger btn-sm w-100 fw-bold">Filter</button>
            <?php if ($filterDept || $filterDesig || $search): ?>
                <a href="manage_faculty.php" class="btn btn-outline-secondary btn-sm" title="Clear Filters"><i class="fas fa-times"></i></a>
            <?php endif; ?>
        </div>
    </form>
</div>

<!-- Faculty Directory Table -->
<div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-dark text-white">
                <tr>
                    <th style="width: 5%;">#</th>
                    <th style="width: 25%;">Teacher / Doctor Name</th>
                    <th style="width: 25%;">Department / College</th>
                    <th style="width: 18%;">Designation</th>
                    <th style="width: 12%;">Qualification</th>
                    <th style="width: 10%;">Experience</th>
                    <th style="width: 5%;" class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($facultyList)): ?>
                    <?php 
                    $rowIdx = $offset;
                    foreach ($facultyList as $fac): 
                        $rowIdx++;
                    ?>
                        <tr>
                            <td class="text-muted small"><?php echo $rowIdx; ?></td>
                            <td>
                                <div class="fw-bold text-navy"><?php echo sanitize($fac['name']); ?></div>
                                <small class="text-muted">ID: #<?php echo $fac['id']; ?></small>
                            </td>
                            <td>
                                <div class="small fw-semibold text-secondary"><?php echo sanitize($fac['department_name']); ?></div>
                            </td>
                            <td>
                                <span class="badge bg-primary-subtle text-primary border px-2 py-1 small"><?php echo sanitize($fac['designation']); ?></span>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border px-2 py-1 small"><?php echo sanitize($fac['qualification'] ?: '-'); ?></span>
                            </td>
                            <td class="text-success fw-semibold small">
                                <?php echo sanitize($fac['experience'] ?: '-'); ?>
                            </td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <a href="manage_faculty.php?action=edit&id=<?php echo $fac['id']; ?>" class="btn btn-outline-primary" title="Edit"><i class="fas fa-edit"></i></a>
                                    <a href="manage_faculty.php?action=delete&id=<?php echo $fac['id']; ?>" class="btn btn-outline-danger" onclick="return confirm('Delete faculty member: <?php echo sanitize($fac['name']); ?>?');" title="Delete"><i class="fas fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">No faculty members found matching your search.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <?php if ($totalPages > 1): ?>
        <div class="card-footer bg-white border-top py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <small class="text-muted">
                Showing <?php echo min($totalRecords, $offset + 1); ?> to <?php echo min($totalRecords, $offset + count($facultyList)); ?> of <?php echo number_format($totalRecords); ?> records
            </small>

            <ul class="pagination pagination-sm mb-0">
                <?php 
                $baseUrlParams = "manage_faculty.php?dept=" . urlencode($filterDept) . "&desig=" . urlencode($filterDesig) . "&search=" . urlencode($search);
                ?>
                <li class="page-item <?php echo $page <= 1 ? 'disabled' : ''; ?>">
                    <a class="page-link" href="<?php echo $baseUrlParams; ?>&p=<?php echo $page - 1; ?>">&laquo; Prev</a>
                </li>
                <?php 
                $startP = max(1, $page - 3);
                $endP = min($totalPages, $page + 3);
                for ($p = $startP; $p <= $endP; $p++):
                ?>
                    <li class="page-item <?php echo $p === $page ? 'active' : ''; ?>">
                        <a class="page-link <?php echo $p === $page ? 'bg-danger border-danger' : ''; ?>" href="<?php echo $baseUrlParams; ?>&p=<?php echo $p; ?>"><?php echo $p; ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item <?php echo $page >= $totalPages ? 'disabled' : ''; ?>">
                    <a class="page-link" href="<?php echo $baseUrlParams; ?>&p=<?php echo $page + 1; ?>">Next &raquo;</a>
                </li>
            </ul>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
