<?php
require_once __DIR__ . '/header.php';

$pdo = getDBConnection();

$totalDepts = $pdo->query("SELECT COUNT(*) FROM departments")->fetchColumn();
$totalPages = $pdo->query("SELECT COUNT(*) FROM pages")->fetchColumn();
$totalCourses = $pdo->query("SELECT COUNT(*) FROM courses")->fetchColumn();
$totalNews = $pdo->query("SELECT COUNT(*) FROM news")->fetchColumn();
$totalEnquiries = $pdo->query("SELECT COUNT(*) FROM enquiries")->fetchColumn();

$recentEnquiries = $pdo->query("SELECT * FROM enquiries ORDER BY id DESC LIMIT 5")->fetchAll();
?>

<!-- Stats Grid (Bootstrap 5-col) -->
<div class="row row-cols-1 row-cols-sm-2 row-cols-lg-5 g-3 mb-4">
    
    <div class="col">
        <div class="card h-100 border-0 border-start border-4 border-danger shadow-sm p-3">
            <div class="text-uppercase text-muted fw-bold small">Faculties</div>
            <div class="display-6 fw-bold text-navy my-2"><?php echo $totalDepts; ?></div>
            <a href="manage_departments.php" class="text-danger fw-semibold text-decoration-none small">Departments &rarr;</a>
        </div>
    </div>

    <div class="col">
        <div class="card h-100 border-0 border-start border-4 border-warning shadow-sm p-3">
            <div class="text-uppercase text-muted fw-bold small">Active Courses</div>
            <div class="display-6 fw-bold text-navy my-2"><?php echo $totalCourses; ?></div>
            <a href="manage_courses.php" class="text-danger fw-semibold text-decoration-none small">Manage Courses &rarr;</a>
        </div>
    </div>

    <div class="col">
        <div class="card h-100 border-0 border-start border-4 border-primary shadow-sm p-3">
            <div class="text-uppercase text-muted fw-bold small">CMS Pages</div>
            <div class="display-6 fw-bold text-navy my-2"><?php echo $totalPages; ?></div>
            <a href="manage_pages.php" class="text-danger fw-semibold text-decoration-none small">Manage Pages &rarr;</a>
        </div>
    </div>

    <div class="col">
        <div class="card h-100 border-0 border-start border-4 border-info shadow-sm p-3">
            <div class="text-uppercase text-muted fw-bold small">News &amp; Notices</div>
            <div class="display-6 fw-bold text-navy my-2"><?php echo $totalNews; ?></div>
            <a href="manage_news.php" class="text-danger fw-semibold text-decoration-none small">Manage News &rarr;</a>
        </div>
    </div>

    <div class="col">
        <div class="card h-100 border-0 border-start border-4 border-success shadow-sm p-3">
            <div class="text-uppercase text-muted fw-bold small">Admission Leads</div>
            <div class="display-6 fw-bold text-navy my-2"><?php echo $totalEnquiries; ?></div>
            <a href="manage_enquiries.php" class="text-danger fw-semibold text-decoration-none small">View Leads &rarr;</a>
        </div>
    </div>

</div>

<!-- Recent Leads Table -->
<div class="card border-0 shadow-sm rounded-4 p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="h5 fw-bold text-navy mb-0">Recent Admission Enquiries &amp; Leads</h4>
        <a href="manage_enquiries.php" class="btn btn-sm btn-outline-danger">View All Leads</a>
    </div>
    
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Programme</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($recentEnquiries)): ?>
                    <?php foreach ($recentEnquiries as $eq): ?>
                        <tr>
                            <td class="fw-bold">#<?php echo $eq['id']; ?></td>
                            <td class="fw-semibold text-navy"><?php echo sanitize($eq['name']); ?></td>
                            <td><?php echo sanitize($eq['email']); ?></td>
                            <td><?php echo sanitize($eq['phone']); ?></td>
                            <td><span class="badge bg-light text-dark border"><?php echo sanitize($eq['course']); ?></span></td>
                            <td><span class="badge bg-warning-subtle text-warning border"><?php echo sanitize($eq['status'] ?? 'New'); ?></span></td>
                            <td><small class="text-muted"><?php echo sanitize($eq['created_at']); ?></small></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">No admission enquiries received yet.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
