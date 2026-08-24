<?php
require_once __DIR__ . '/header.php';
$pdo = getDBConnection();

$departments = $pdo->query("SELECT * FROM departments ORDER BY name ASC")->fetchAll();

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
    $deptSlug = generateSlug($dept);
    $name = sanitize($_POST['course_name'] ?? '');
    $slug = sanitize($_POST['slug'] ?? '');
    if (empty($slug)) $slug = generateSlug($name);
    $level = sanitize($_POST['level'] ?? 'UG');
    $duration = sanitize($_POST['duration'] ?? '');
    $eligibility = sanitize($_POST['eligibility'] ?? '');
    $fees = sanitize($_POST['fees'] ?? '');
    $specs = sanitize($_POST['specializations'] ?? '');
    $desc = $_POST['description'] ?? '';
    $career = $_POST['career_scope'] ?? '';
    $schemeUrl = sanitize($_POST['scheme_url'] ?? '');
    $syllabusUrl = sanitize($_POST['syllabus_url'] ?? '');
    $status = sanitize($_POST['status'] ?? 'active');

    if ($id > 0) {
        $stmt = $pdo->prepare("UPDATE courses SET department = :d, dept_slug = :ds, course_name = :n, slug = :s, level = :l, duration = :dur, eligibility = :e, fees = :f, specializations = :sp, description = :desc, career_scope = :c, scheme_url = :sch, syllabus_url = :syl, status = :st WHERE id = :id");
        $stmt->execute([
            ':d' => $dept,
            ':ds' => $deptSlug,
            ':n' => $name,
            ':s' => $slug,
            ':l' => $level,
            ':dur' => $duration,
            ':e' => $eligibility,
            ':f' => $fees,
            ':sp' => $specs,
            ':desc' => $desc,
            ':c' => $career,
            ':sch' => $schemeUrl,
            ':syl' => $syllabusUrl,
            ':st' => $status,
            ':id' => $id
        ]);
        setFlashMsg('success', 'Course updated successfully.');
    } else {
        $stmt = $pdo->prepare("INSERT INTO courses (department, dept_slug, course_name, slug, level, duration, eligibility, fees, specializations, description, career_scope, scheme_url, syllabus_url, status) VALUES (:d, :ds, :n, :s, :l, :dur, :e, :f, :sp, :desc, :c, :sch, :syl, :st)");
        $stmt->execute([
            ':d' => $dept,
            ':ds' => $deptSlug,
            ':n' => $name,
            ':s' => $slug,
            ':l' => $level,
            ':dur' => $duration,
            ':e' => $eligibility,
            ':f' => $fees,
            ':sp' => $specs,
            ':desc' => $desc,
            ':c' => $career,
            ':sch' => $schemeUrl,
            ':syl' => $syllabusUrl,
            ':st' => $status
        ]);
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
    <div>
        <h3 class="h4 fw-bold text-navy mb-0">Manage Academic Courses &amp; Programmes</h3>
        <p class="text-muted small mb-0">Manage degrees, eligibility criteria, fees structure, and syllabus descriptions with CKEditor.</p>
    </div>
    <?php if (isset($_GET['action'])): ?>
        <a href="manage_courses.php" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i> Back to List</a>
    <?php else: ?>
        <a href="manage_courses.php?action=add" class="btn btn-danger btn-sm"><i class="fas fa-plus me-1"></i> Add New Course</a>
    <?php endif; ?>
</div>

<?php if (isset($_GET['action']) && ($_GET['action'] === 'add' || $_GET['action'] === 'edit')): ?>
    <div style="max-width: 960px;">
        <form action="manage_courses.php" method="POST">
            <?php if ($editCourse): ?>
                <input type="hidden" name="id" value="<?php echo $editCourse['id']; ?>">
            <?php endif; ?>

            <!-- SECTION 1: Course Identity & Department -->
            <div class="admin-form-section">
                <div class="admin-form-section-title">
                    <i class="fas fa-graduation-cap text-danger"></i> Section 1: Course Identity &amp; Affiliation
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-dark small">Department / Faculty *</label>
                        <input list="deptList" name="department" class="form-control" placeholder="Select or type department" value="<?php echo sanitize($editCourse['department'] ?? ''); ?>" required>
                        <datalist id="deptList">
                            <?php foreach ($departments as $d): ?>
                                <option value="<?php echo sanitize($d['name']); ?>">
                            <?php endforeach; ?>
                        </datalist>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold text-dark small">Degree Level</label>
                        <select name="level" class="form-select">
                            <option value="UG" <?php echo ($editCourse['level'] ?? '') === 'UG' ? 'selected' : ''; ?>>Undergraduate (UG)</option>
                            <option value="PG" <?php echo ($editCourse['level'] ?? '') === 'PG' ? 'selected' : ''; ?>>Postgraduate (PG)</option>
                            <option value="Diploma" <?php echo ($editCourse['level'] ?? '') === 'Diploma' ? 'selected' : ''; ?>>Diploma / Polytechnic</option>
                            <option value="PhD" <?php echo ($editCourse['level'] ?? '') === 'PhD' ? 'selected' : ''; ?>>Ph.D. Doctoral</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold text-dark small">Display Status</label>
                        <select name="status" class="form-select">
                            <option value="active" <?php echo ($editCourse['status'] ?? '') === 'active' ? 'selected' : ''; ?>>Active</option>
                            <option value="inactive" <?php echo ($editCourse['status'] ?? '') === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label fw-bold text-dark small">Course Name *</label>
                        <input type="text" name="course_name" class="form-control" placeholder="e.g. B.Tech in Computer Science & Engineering" value="<?php echo sanitize($editCourse['course_name'] ?? ''); ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-dark small">URL Slug</label>
                        <input type="text" name="slug" class="form-control" placeholder="e.g. b-tech-computer-science" value="<?php echo sanitize($editCourse['slug'] ?? ''); ?>">
                    </div>
                </div>
            </div>

            <!-- SECTION 2: Duration, Fees & Eligibility -->
            <div class="admin-form-section">
                <div class="admin-form-section-title">
                    <i class="fas fa-info-circle text-warning"></i> Section 2: Duration, Fees &amp; Eligibility
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-dark small">Duration</label>
                        <input type="text" name="duration" class="form-control" placeholder="e.g. 4 Years (8 Semesters)" value="<?php echo sanitize($editCourse['duration'] ?? ''); ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-dark small">Annual Fees</label>
                        <input type="text" name="fees" class="form-control" placeholder="e.g. ₹65,000 / Year" value="<?php echo sanitize($editCourse['fees'] ?? ''); ?>">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark small">Disciplines / Specializations (Comma Separated)</label>
                        <input type="text" name="specializations" class="form-control" placeholder="e.g. Civil Engineering, Computer Science & Engineering, Electrical Engineering" value="<?php echo sanitize($editCourse['specializations'] ?? ''); ?>">
                        <small class="text-muted">Separate multiple streams / disciplines with commas to render interactive badges on course &amp; department pages.</small>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold text-dark small">Eligibility Criteria</label>
                        <textarea name="eligibility" class="form-control" rows="2" placeholder="e.g. 10+2 with Physics, Mathematics & Chemistry (Min 50%)"><?php echo sanitize($editCourse['eligibility'] ?? ''); ?></textarea>
                    </div>
                </div>
            </div>

            <!-- SECTION 3: Program Overview (CKEditor) -->
            <div class="admin-form-section">
                <div class="admin-form-section-title">
                    <i class="fas fa-book-open text-primary"></i> Section 3: Detailed Programme Overview (CKEditor)
                </div>
                <div class="mb-2">
                    <label class="form-label fw-bold text-dark small mb-2">Curriculum Highlights &amp; Syllabus Details</label>
                    <textarea name="description" class="form-control rich-editor" rows="10" placeholder="Overview of the programme..."><?php echo htmlspecialchars($editCourse['description'] ?? ''); ?></textarea>
                </div>
            </div>

            <!-- SECTION 4: Career Scope (CKEditor) -->
            <div class="admin-form-section">
                <div class="admin-form-section-title">
                    <i class="fas fa-briefcase text-success"></i> Section 4: Career Scope &amp; Placements (CKEditor)
                </div>
                <div class="mb-2">
                    <label class="form-label fw-bold text-dark small mb-2">Job Profiles &amp; Higher Studies Opportunities</label>
                    <textarea name="career_scope" class="form-control rich-editor" rows="8" placeholder="Career options after this degree..."><?php echo htmlspecialchars($editCourse['career_scope'] ?? ''); ?></textarea>
                </div>
            </div>

            <!-- SECTION 5: Scheme & Syllabus Documents (PDF URLs) -->
            <div class="admin-form-section">
                <div class="admin-form-section-title">
                    <i class="fas fa-file-pdf text-danger"></i> Section 5: Official Curriculum Scheme &amp; Syllabus (PDF Links)
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-dark small">Scheme PDF URL</label>
                        <input type="url" name="scheme_url" class="form-control" placeholder="https://www.srku.edu.in/.../Scheme.pdf" value="<?php echo sanitize($editCourse['scheme_url'] ?? ''); ?>">
                        <small class="text-muted">Direct URL to semester-wise scheme of examination document.</small>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-dark small">Syllabus PDF URL</label>
                        <input type="url" name="syllabus_url" class="form-control" placeholder="https://www.srku.edu.in/.../Syllabus.pdf" value="<?php echo sanitize($editCourse['syllabus_url'] ?? ''); ?>">
                        <small class="text-muted">Direct URL to complete course structure &amp; syllabus PDF document.</small>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-3 justify-content-end mb-5">
                <a href="manage_courses.php" class="btn btn-outline-secondary px-4">Cancel</a>
                <button type="submit" name="save_course" class="btn btn-danger fw-bold px-5">
                    <i class="fas fa-save me-1"></i> <?php echo $editCourse ? 'Save Course Changes' : 'Create Course'; ?>
                </button>
            </div>
        </form>
    </div>

<?php else: ?>
    <!-- Table View -->
    <div class="card border-0 shadow-sm rounded-4 p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width:60px;">Level</th>
                        <th>Course / Programme Name</th>
                        <th>Department</th>
                        <th>Duration</th>
                        <th>Annual Fees</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($courses)): ?>
                        <?php foreach ($courses as $c): ?>
                            <tr>
                                <td><span class="badge bg-navy text-white"><?php echo sanitize($c['level']); ?></span></td>
                                <td>
                                    <strong class="text-navy d-block"><?php echo sanitize($c['course_name']); ?></strong>
                                    <div class="d-flex align-items-center gap-2 mt-1">
                                        <small class="text-muted"><code>/courses/<?php echo sanitize($c['slug']); ?></code></small>
                                        <?php if (!empty($c['scheme_url']) || !empty($c['syllabus_url'])): ?>
                                            <span class="badge bg-danger-subtle text-danger small"><i class="fas fa-file-pdf me-1"></i>PDF Linked</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td><span class="badge bg-light text-dark border"><?php echo sanitize($c['department']); ?></span></td>
                                <td><small class="text-dark fw-semibold"><?php echo sanitize($c['duration'] ?: 'N/A'); ?></small></td>
                                <td><span class="badge bg-success-subtle text-success border"><?php echo sanitize($c['fees'] ?: 'Contact'); ?></span></td>
                                <td>
                                    <span class="badge bg-<?php echo ($c['status'] ?? 'active') === 'active' ? 'success' : 'secondary'; ?>">
                                        <?php echo ucfirst($c['status'] ?? 'active'); ?>
                                    </span>
                                </td>
                                <td class="text-end text-nowrap">
                                    <div class="action-btn-group">
                                        <a href="<?php echo BASE_URL . 'courses/' . $c['slug']; ?>" target="_blank" class="btn btn-sm btn-outline-primary" title="View Live"><i class="fas fa-external-link-alt"></i></a>
                                        <a href="manage_courses.php?action=edit&id=<?php echo $c['id']; ?>" class="btn btn-sm btn-outline-warning" title="Edit in CKEditor"><i class="fas fa-edit"></i></a>
                                        <a href="manage_courses.php?action=delete&id=<?php echo $c['id']; ?>" onclick="return confirm('Delete course: <?php echo sanitize($c['course_name']); ?>?');" class="btn btn-sm btn-outline-danger" title="Delete"><i class="fas fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="7" class="text-center text-muted py-4">No courses registered yet.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/footer.php'; ?>
