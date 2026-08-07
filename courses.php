<?php
$pageTitle = "Courses & Programmes";
$activeNav = "courses";
require_once __DIR__ . '/includes/header.php';

$pdo = getDBConnection();
$selectedDept = sanitize($_GET['dept'] ?? '');

$query = "SELECT * FROM courses WHERE status = 'active'";
$params = [];

if ($selectedDept) {
    $query .= " AND department LIKE :dept";
    $params[':dept'] = '%' . $selectedDept . '%';
}

$query .= " ORDER BY department ASC, course_name ASC";
$stmt = $pdo->prepare($query);
$stmt->execute($params);
$courses = $stmt->fetchAll();
?>

<div style="background: linear-gradient(135deg, var(--dark-navy), var(--primary-maroon)); color: #ffffff; padding: 60px 20px; text-align: center;">
    <div class="container">
        <h1 style="font-family: var(--font-heading); font-size: 2.8rem; font-weight: 800;">Academic Programmes & Courses</h1>
        <p style="color: var(--accent-gold); font-size: 1.1rem; font-weight: 600; margin-top: 10px;">Diploma, Undergraduate, Postgraduate & Doctoral Degrees</p>
    </div>
</div>

<section class="section">
    <div class="container">
        <!-- FILTER BAR -->
        <div style="display: flex; gap: 10px; flex-wrap: wrap; justify-content: center; margin-bottom: 40px;">
            <a href="courses.php" class="btn-primary" style="<?php echo empty($selectedDept) ? '' : 'background: #cbd5e1; color: var(--dark-navy); border: none;'; ?>">All Programmes</a>
            <a href="courses.php?dept=Engineering" class="btn-primary" style="<?php echo $selectedDept == 'Engineering' ? '' : 'background: #cbd5e1; color: var(--dark-navy); border: none;'; ?>">Engineering</a>
            <a href="courses.php?dept=Pharmacy" class="btn-primary" style="<?php echo $selectedDept == 'Pharmacy' ? '' : 'background: #cbd5e1; color: var(--dark-navy); border: none;'; ?>">Pharmacy</a>
            <a href="courses.php?dept=Computer" class="btn-primary" style="<?php echo $selectedDept == 'Computer' ? '' : 'background: #cbd5e1; color: var(--dark-navy); border: none;'; ?>">Computer Science</a>
            <a href="courses.php?dept=Management" class="btn-primary" style="<?php echo $selectedDept == 'Management' ? '' : 'background: #cbd5e1; color: var(--dark-navy); border: none;'; ?>">Management</a>
            <a href="courses.php?dept=Nursing" class="btn-primary" style="<?php echo $selectedDept == 'Nursing' ? '' : 'background: #cbd5e1; color: var(--dark-navy); border: none;'; ?>">Nursing</a>
        </div>

        <div class="grid-3">
            <?php if (!empty($courses)): ?>
                <?php foreach ($courses as $c): ?>
                    <div class="card">
                        <span style="font-size: 0.75rem; background: rgba(128,0,0,0.1); color: var(--primary-maroon); padding: 4px 10px; border-radius: 12px; font-weight: 700; width: fit-content; margin-bottom: 12px;">
                            <?php echo sanitize($c['department']); ?>
                        </span>
                        <h3 class="card-title"><?php echo sanitize($c['course_name']); ?></h3>
                        <p class="card-text">
                            <strong><i class="far fa-clock"></i> Duration:</strong> <?php echo sanitize($c['duration']); ?><br>
                            <strong><i class="fas fa-graduation-cap"></i> Eligibility:</strong> <?php echo sanitize($c['eligibility']); ?><br>
                            <strong><i class="fas fa-rupee-sign"></i> Fees:</strong> <?php echo sanitize($c['fees']); ?>
                        </p>
                        <a href="contact.php?course=<?php echo urlencode($c['course_name']); ?>" class="btn-primary" style="text-align: center; font-size: 0.88rem; padding: 10px;">Apply / Enquiry</a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div style="grid-column: 1 / -1; text-align: center; padding: 50px;">
                    <i class="fas fa-folder-open" style="font-size: 3rem; color: #cbd5e1; margin-bottom: 15px;"></i>
                    <p style="font-size: 1.1rem; color: var(--text-muted);">No courses found matching this category.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
