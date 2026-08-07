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

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h3 style="font-family: var(--font-heading); color: var(--dark-navy);">Manage Courses & Academic Departments</h3>
    <?php if (isset($_GET['action'])): ?>
        <a href="manage_courses.php" class="btn-secondary" style="color: var(--dark-navy);">&larr; Back to List</a>
    <?php else: ?>
        <a href="manage_courses.php?action=add" class="btn-primary"><i class="fas fa-plus"></i> Add New Course</a>
    <?php endif; ?>
</div>

<?php if (isset($_GET['action']) && ($_GET['action'] === 'add' || $_GET['action'] === 'edit')): ?>
    <div style="background: #ffffff; padding: 30px; border-radius: var(--radius-md); box-shadow: var(--shadow-sm); border: 1px solid var(--border-color);">
        <h4 style="font-family: var(--font-heading); margin-bottom: 20px;"><?php echo $editCourse ? 'Edit Course Details' : 'Add New Academic Course'; ?></h4>
        
        <form action="manage_courses.php" method="POST">
            <?php if ($editCourse): ?>
                <input type="hidden" name="id" value="<?php echo $editCourse['id']; ?>">
            <?php endif; ?>

            <div class="form-group">
                <label>Department / Institute *</label>
                <input type="text" name="department" class="form-control" placeholder="e.g. Department of Engineering" value="<?php echo sanitize($editCourse['department'] ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label>Course Name *</label>
                <input type="text" name="course_name" class="form-control" placeholder="e.g. B.Tech Computer Science Engineering" value="<?php echo sanitize($editCourse['course_name'] ?? ''); ?>" required>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label>Duration</label>
                    <input type="text" name="duration" class="form-control" placeholder="e.g. 4 Years" value="<?php echo sanitize($editCourse['duration'] ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label>Annual Fees</label>
                    <input type="text" name="fees" class="form-control" placeholder="e.g. ₹65,000 / Year" value="<?php echo sanitize($editCourse['fees'] ?? ''); ?>">
                </div>
            </div>

            <div class="form-group">
                <label>Eligibility Criteria</label>
                <textarea name="eligibility" class="form-control" rows="3" placeholder="e.g. 10+2 with Physics, Math (50%)"><?php echo sanitize($editCourse['eligibility'] ?? ''); ?></textarea>
            </div>

            <button type="submit" name="save_course" class="btn-primary" style="border: none; cursor: pointer;">
                <i class="fas fa-save"></i> Save Course
            </button>
        </form>
    </div>
<?php else: ?>
    <div style="background: #ffffff; padding: 25px; border-radius: var(--radius-md); box-shadow: var(--shadow-sm); border: 1px solid var(--border-color);">
        <table class="table">
            <thead>
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
                            <td><span style="background: var(--light-bg); padding: 4px 8px; border-radius: 4px; font-weight: 600; font-size: 0.85rem;"><?php echo sanitize($c['department']); ?></span></td>
                            <td><strong><?php echo sanitize($c['course_name']); ?></strong></td>
                            <td><?php echo sanitize($c['duration']); ?></td>
                            <td><?php echo sanitize($c['fees']); ?></td>
                            <td>
                                <a href="manage_courses.php?action=edit&id=<?php echo $c['id']; ?>" class="btn-secondary" style="padding: 5px 10px; font-size: 0.8rem; color: var(--dark-navy);">Edit</a>
                                <a href="manage_courses.php?action=delete&id=<?php echo $c['id']; ?>" onclick="return confirm('Delete this course?');" class="btn-primary" style="padding: 5px 10px; font-size: 0.8rem; background: #dc2626;">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="5" style="text-align: center;">No courses found. Click Add New Course to add one.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/footer.php'; ?>
