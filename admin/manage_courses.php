<?php
require_once __DIR__ . '/header.php';
$pdo = getDBConnection();

// Delete Action
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM courses WHERE id = :id");
    $stmt->execute([':id' => $id]);
    setFlashMsg('success', 'Course removed successfully.');
    header("Location: manage_courses.php");
    exit;
}

// Add/Edit Save
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_course'])) {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $dept = sanitize($_POST['department'] ?? '');
    $name = sanitize($_POST['course_name'] ?? '');
    $duration = sanitize($_POST['duration'] ?? '');
    $eligibility = sanitize($_POST['eligibility'] ?? '');
    $fees = sanitize($_POST['fees'] ?? '');

    if ($id > 0) {
        $stmt = $pdo->prepare("UPDATE courses SET department = :d, course_name = :n, duration = :dur, eligibility = :e, fees = :f WHERE id = :id");
        $stmt->execute([':d' => $dept, ':n' => $name, ':dur' => $duration, ':e' => $eligibility, ':f' => $fees, ':id' => $id]);
        setFlashMsg('success', 'Course updated successfully.');
    } else {
        $stmt = $pdo->prepare("INSERT INTO courses (department, course_name, duration, eligibility, fees) VALUES (:d, :n, :dur, :e, :f)");
        $stmt->execute([':d' => $dept, ':n' => $name, ':dur' => $duration, ':e' => $eligibility, ':f' => $fees]);
        setFlashMsg('success', 'New course added successfully.');
    }
    header("Location: manage_courses.php");
    exit;
}

$editCourse = null;
if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM courses WHERE id = :id LIMIT 1");
    $stmt->execute([':id' => $id]);
    $editCourse = $stmt->fetch();
}

$courses = $pdo->query("SELECT * FROM courses ORDER BY department ASC, course_name ASC")->fetchAll();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="h4 fw-bold text-navy mb-0">Manage Courses &amp; Academic Departments</h3>
    <?php if (isset($_GET['action'])): ?>
        <a href="manage_courses.php" class="btn btn-outline-secondary btn-sm">&larr; Back to List</a>
    <?php else: ?>
        <a href="manage_courses.php?action=add" class="btn btn-danger btn-sm"><i class="fas fa-plus me-1"></i> Add New Course</a>
    <?php endif; ?>
</div>

<?php if (isset($_GET['action']) && ($_GET['action'] === 'add' || $_GET['action'] === 'edit')): ?>
    <div class="card border-0 shadow-sm rounded-4 p-4">
        <h4 class="h5 fw-bold text-navy mb-4"><?php echo $editCourse ? 'Edit Course Details' : 'Add New Academic Course'; ?></h4>
        
        <form action="manage_courses.php" method="POST">
            <?php if ($editCourse): ?>
                <input type="hidden" name="id" value="<?php echo $editCourse['id']; ?>">
            <?php endif; ?>

            <div class="mb-3">
                <label class="form-label fw-bold text-dark small">Department / Institute *</label>
                <input type="text" name="department" class="form-control" placeholder="e.g. Department of Engineering" value="<?php echo sanitize($editCourse['department'] ?? ''); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold text-dark small">Course Name *</label>
                <input type="text" name="course_name" class="form-control" placeholder="e.g. B.Tech Computer Science Engineering" value="<?php echo sanitize($editCourse['course_name'] ?? ''); ?>" required>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark small">Duration</label>
                    <input type="text" name="duration" class="form-control" placeholder="e.g. 4 Years" value="<?php echo sanitize($editCourse['duration'] ?? ''); ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark small">Annual Fees</label>
                    <input type="text" name="fees" class="form-control" placeholder="e.g. ₹65,000 / Year" value="<?php echo sanitize($editCourse['fees'] ?? ''); ?>">
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold text-dark small">Eligibility Criteria</label>
                <textarea name="eligibility" class="form-control" rows="3" placeholder="e.g. 10+2 with Physics, Math (50%)"><?php echo sanitize($editCourse['eligibility'] ?? ''); ?></textarea>
            </div>

            <button type="submit" name="save_course" class="btn btn-danger px-4">
                <i class="fas fa-save me-1"></i> Save Course
            </button>
        </form>
    </div>
<?php else: ?>
    <div class="card border-0 shadow-sm rounded-4 p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Department</th>
                        <th>Course Name</th>
                        <th>Duration</th>
                        <th>Fees</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($courses)): ?>
                        <?php foreach ($courses as $c): ?>
                            <tr>
                                <td><span class="badge bg-light text-dark border"><?php echo sanitize($c['department']); ?></span></td>
                                <td class="fw-semibold text-navy"><?php echo sanitize($c['course_name']); ?></td>
                                <td><?php echo sanitize($c['duration']); ?></td>
                                <td><?php echo sanitize($c['fees']); ?></td>
                                <td>
                                    <a href="manage_courses.php?action=edit&id=<?php echo $c['id']; ?>" class="btn btn-sm btn-outline-navy me-1">Edit</a>
                                    <a href="manage_courses.php?action=delete&id=<?php echo $c['id']; ?>" onclick="return confirm('Delete this course?');" class="btn btn-sm btn-danger">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="text-center text-muted py-4">No courses found. Click Add New Course to add one.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/footer.php'; ?>
