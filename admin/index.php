<?php
require_once __DIR__ . '/header.php';
$pdo = getDBConnection();

$totalDepts = (int)$pdo->query("SELECT COUNT(*) FROM departments")->fetchColumn();
$totalPages = (int)$pdo->query("SELECT COUNT(*) FROM pages")->fetchColumn();
$totalCourses = (int)$pdo->query("SELECT COUNT(*) FROM courses")->fetchColumn();
$totalNews = (int)$pdo->query("SELECT COUNT(*) FROM news")->fetchColumn();
$totalBanners = (int)$pdo->query("SELECT COUNT(*) FROM banners")->fetchColumn();

$totalEnquiries = (int)$pdo->query("SELECT COUNT(*) FROM enquiries")->fetchColumn();
$newEnquiries = (int)$pdo->query("SELECT COUNT(*) FROM enquiries WHERE status = 'New' OR status IS NULL")->fetchColumn();
$contactedEnquiries = (int)$pdo->query("SELECT COUNT(*) FROM enquiries WHERE status = 'Contacted'")->fetchColumn();
$enrolledEnquiries = (int)$pdo->query("SELECT COUNT(*) FROM enquiries WHERE status = 'Enrolled'")->fetchColumn();

$recentEnquiries = $pdo->query("SELECT * FROM enquiries ORDER BY id DESC LIMIT 6")->fetchAll();
?>

<!-- Welcome Banner -->
<div class="card border-0 shadow-sm rounded-4 p-4 mb-4 text-white position-relative overflow-hidden" style="background: linear-gradient(135deg, #18183d 0%, #3e3e93 60%, #a30407 100%);">
    <div class="row align-items-center position-relative" style="z-index: 2;">
        <div class="col-md-8">
            <span class="badge bg-warning text-dark fw-bold px-3 py-1 mb-2 text-uppercase">SRKU Institutional Administration</span>
            <h2 class="h3 fw-bold text-white mb-2">Welcome back, <?php echo sanitize($_SESSION['admin_user'] ?? 'Administrator'); ?>!</h2>
            <p class="text-white-50 mb-0" style="max-width: 600px;">
                Manage university faculties, academic courses, student admission leads, media assets, dynamic pages, and website settings from one centralized console.
            </p>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <a href="<?php echo BASE_URL; ?>" target="_blank" class="btn btn-light fw-bold px-4 py-2 text-navy shadow-sm">
                <i class="fas fa-external-link-alt me-1 text-danger"></i> View Live Portal
            </a>
        </div>
    </div>
</div>

<!-- Primary Stats Grid -->
<div class="row g-3 mb-4">
    
    <!-- Faculties -->
    <div class="col-6 col-md-4 col-xl-2">
        <div class="admin-stat-card h-100 p-3 border-0 border-start border-4 border-danger">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <small class="text-muted fw-bold text-uppercase" style="font-size:0.7rem;">Departments</small>
                <div class="rounded-circle bg-danger-subtle p-2 text-danger d-flex align-items-center justify-content-center" style="width:32px; height:32px;">
                    <i class="fas fa-university fa-sm"></i>
                </div>
            </div>
            <div class="h3 fw-bold text-navy mb-1"><?php echo $totalDepts; ?></div>
            <a href="manage_departments.php" class="text-danger fw-semibold text-decoration-none small">Manage &rarr;</a>
        </div>
    </div>

    <!-- Courses -->
    <div class="col-6 col-md-4 col-xl-2">
        <div class="admin-stat-card h-100 p-3 border-0 border-start border-4 border-warning">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <small class="text-muted fw-bold text-uppercase" style="font-size:0.7rem;">Programmes</small>
                <div class="rounded-circle bg-warning-subtle p-2 text-warning d-flex align-items-center justify-content-center" style="width:32px; height:32px;">
                    <i class="fas fa-graduation-cap fa-sm"></i>
                </div>
            </div>
            <div class="h3 fw-bold text-navy mb-1"><?php echo $totalCourses; ?></div>
            <a href="manage_courses.php" class="text-danger fw-semibold text-decoration-none small">Courses &rarr;</a>
        </div>
    </div>

    <!-- Dynamic Pages -->
    <div class="col-6 col-md-4 col-xl-2">
        <div class="admin-stat-card h-100 p-3 border-0 border-start border-4 border-primary">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <small class="text-muted fw-bold text-uppercase" style="font-size:0.7rem;">CMS Pages</small>
                <div class="rounded-circle bg-primary-subtle p-2 text-primary d-flex align-items-center justify-content-center" style="width:32px; height:32px;">
                    <i class="fas fa-file-alt fa-sm"></i>
                </div>
            </div>
            <div class="h3 fw-bold text-navy mb-1"><?php echo $totalPages; ?></div>
            <a href="manage_pages.php" class="text-primary fw-semibold text-decoration-none small">Pages &rarr;</a>
        </div>
    </div>

    <!-- Banners -->
    <div class="col-6 col-md-4 col-xl-2">
        <div class="admin-stat-card h-100 p-3 border-0 border-start border-4 border-info">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <small class="text-muted fw-bold text-uppercase" style="font-size:0.7rem;">Banners</small>
                <div class="rounded-circle bg-info-subtle p-2 text-info d-flex align-items-center justify-content-center" style="width:32px; height:32px;">
                    <i class="fas fa-images fa-sm"></i>
                </div>
            </div>
            <div class="h3 fw-bold text-navy mb-1"><?php echo $totalBanners; ?></div>
            <a href="manage_banners.php" class="text-info fw-semibold text-decoration-none small">Banners &rarr;</a>
        </div>
    </div>

    <!-- News & Circulars -->
    <div class="col-6 col-md-4 col-xl-2">
        <div class="admin-stat-card h-100 p-3 border-0 border-start border-4 border-secondary">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <small class="text-muted fw-bold text-uppercase" style="font-size:0.7rem;">Notices</small>
                <div class="rounded-circle bg-secondary-subtle p-2 text-secondary d-flex align-items-center justify-content-center" style="width:32px; height:32px;">
                    <i class="fas fa-bullhorn fa-sm"></i>
                </div>
            </div>
            <div class="h3 fw-bold text-navy mb-1"><?php echo $totalNews; ?></div>
            <a href="manage_news.php" class="text-secondary fw-semibold text-decoration-none small">Circulars &rarr;</a>
        </div>
    </div>

    <!-- Admission Leads -->
    <div class="col-6 col-md-4 col-xl-2">
        <div class="admin-stat-card h-100 p-3 border-0 border-start border-4 border-success">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <small class="text-muted fw-bold text-uppercase" style="font-size:0.7rem;">Total Leads</small>
                <div class="rounded-circle bg-success-subtle p-2 text-success d-flex align-items-center justify-content-center" style="width:32px; height:32px;">
                    <i class="fas fa-users fa-sm"></i>
                </div>
            </div>
            <div class="h3 fw-bold text-success mb-1"><?php echo $totalEnquiries; ?></div>
            <a href="manage_enquiries.php" class="text-success fw-semibold text-decoration-none small">View Leads &rarr;</a>
        </div>
    </div>

</div>

<!-- Quick Actions Strip -->
<div class="admin-form-section mb-4">
    <div class="admin-form-section-title mb-3">
        <i class="fas fa-bolt text-warning"></i> Quick Management Shortcuts
    </div>
    <div class="row g-2">
        <div class="col-6 col-md-3">
            <a href="manage_courses.php?action=add" class="btn btn-outline-danger w-100 py-2 text-start fw-bold d-flex align-items-center gap-2">
                <i class="fas fa-plus-circle text-danger"></i> Add New Course
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="manage_media.php" class="btn btn-outline-primary w-100 py-2 text-start fw-bold d-flex align-items-center gap-2">
                <i class="fas fa-cloud-upload-alt text-primary"></i> Upload Media Asset
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="manage_header_footer.php" class="btn btn-outline-dark w-100 py-2 text-start fw-bold d-flex align-items-center gap-2">
                <i class="fas fa-heading text-dark"></i> Customize Header/Footer
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="manage_enquiries.php?action=export" class="btn btn-outline-success w-100 py-2 text-start fw-bold d-flex align-items-center gap-2">
                <i class="fas fa-file-excel text-success"></i> Export Leads (CSV)
            </a>
        </div>
    </div>
</div>

<!-- Recent Leads Section -->
<div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-2">
        <div>
            <h4 class="h5 fw-bold text-navy mb-1"><i class="fas fa-user-clock text-danger me-2"></i> Recent Student Admission Leads</h4>
            <small class="text-muted">Direct enquiries submitted via homepage, contact page, and course enquiry forms.</small>
        </div>
        <div>
            <a href="manage_enquiries.php" class="btn btn-sm btn-danger fw-bold px-3">
                <i class="fas fa-list me-1"></i> Manage All Leads (<?php echo $totalEnquiries; ?>)
            </a>
        </div>
    </div>
    
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#ID</th>
                    <th>Candidate Details</th>
                    <th>Programme of Interest</th>
                    <th>Status</th>
                    <th>Received Date</th>
                    <th class="text-end">Quick Contact</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($recentEnquiries)): ?>
                    <?php foreach ($recentEnquiries as $eq): 
                        $st = $eq['status'] ?? 'New';
                        $badgeClass = 'bg-secondary';
                        if ($st === 'New') $badgeClass = 'bg-warning text-dark';
                        elseif ($st === 'Contacted') $badgeClass = 'bg-info text-white';
                        elseif ($st === 'Enrolled') $badgeClass = 'bg-success text-white';
                        elseif ($st === 'Closed') $badgeClass = 'bg-dark text-white';
                        
                        $cleanPhone = preg_replace('/[^0-9]/', '', $eq['phone']);
                    ?>
                        <tr>
                            <td class="fw-bold text-muted">#<?php echo $eq['id']; ?></td>
                            <td>
                                <strong class="text-navy d-block"><?php echo sanitize($eq['name']); ?></strong>
                                <small class="text-muted d-block"><i class="fas fa-envelope text-danger me-1"></i><?php echo sanitize($eq['email']); ?></small>
                                <small class="text-muted d-block"><i class="fas fa-phone text-success me-1"></i><?php echo sanitize($eq['phone']); ?></small>
                            </td>
                            <td><span class="badge bg-light text-dark border px-2 py-1"><?php echo sanitize($eq['course']); ?></span></td>
                            <td><span class="badge <?php echo $badgeClass; ?> px-2 py-1"><?php echo sanitize($st); ?></span></td>
                            <td><small class="text-muted"><?php echo date('M d, Y h:i A', strtotime($eq['created_at'])); ?></small></td>
                            <td class="text-end text-nowrap">
                                <div class="action-btn-group">
                                    <?php if ($cleanPhone): ?>
                                        <a href="https://api.whatsapp.com/send?phone=91<?php echo $cleanPhone; ?>&text=Hello%20<?php echo urlencode($eq['name']); ?>,%20greetings%20from%20SRK%20University%20Admissions." target="_blank" class="btn btn-sm btn-outline-success" title="WhatsApp Candidate">
                                            <i class="fab fa-whatsapp"></i>
                                        </a>
                                        <a href="tel:<?php echo $cleanPhone; ?>" class="btn btn-sm btn-outline-primary" title="Call Candidate">
                                            <i class="fas fa-phone"></i>
                                        </a>
                                    <?php endif; ?>
                                    <a href="manage_enquiries.php" class="btn btn-sm btn-outline-secondary" title="View in Leads Panel">
                                        <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5">
                            <i class="fas fa-inbox fa-3x opacity-50 mb-3 d-block"></i>
                            No admission enquiries received yet.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
