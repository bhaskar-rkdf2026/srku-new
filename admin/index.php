<?php
require_once __DIR__ . '/header.php';
$pdo = getDBConnection();

$totalDepts = (int)$pdo->query("SELECT COUNT(*) FROM departments")->fetchColumn();
$totalFaculty = (int)$pdo->query("SELECT COUNT(*) FROM faculty")->fetchColumn();
$totalCourses = (int)$pdo->query("SELECT COUNT(*) FROM courses")->fetchColumn();
$totalNews = (int)$pdo->query("SELECT COUNT(*) FROM news")->fetchColumn();
try {
    $totalBlogs = (int)$pdo->query("SELECT COUNT(*) FROM blogs")->fetchColumn();
} catch(Exception $e) { $totalBlogs = 0; }

$totalEnquiries = (int)$pdo->query("SELECT COUNT(*) FROM enquiries")->fetchColumn();
$newEnquiries = (int)$pdo->query("SELECT COUNT(*) FROM enquiries WHERE status = 'New' OR status IS NULL")->fetchColumn();
$contactedEnquiries = (int)$pdo->query("SELECT COUNT(*) FROM enquiries WHERE status = 'Contacted'")->fetchColumn();
$enrolledEnquiries = (int)$pdo->query("SELECT COUNT(*) FROM enquiries WHERE status = 'Enrolled'")->fetchColumn();

$recentEnquiries = $pdo->query("SELECT * FROM enquiries ORDER BY id DESC LIMIT 6")->fetchAll();
?>

<!-- ═══════════════════════════════════════════════════════
     EXECUTIVE WELCOME BANNER
═══════════════════════════════════════════════════════ -->
<div class="card border-0 shadow-sm rounded-4 p-4 mb-4 text-white position-relative overflow-hidden" style="background: linear-gradient(135deg, #101438 0%, #1e245a 50%, #7a0b0d 100%);">
    <div class="row align-items-center position-relative" style="z-index: 2;">
        <div class="col-12 col-lg-8">
            <span class="badge bg-warning text-dark fw-bold px-3 py-1 mb-2 text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.5px;">
                <i class="fas fa-shield-alt me-1"></i> SRKU Central CMS v2.0
            </span>
            <h2 class="h3 fw-bold text-white mb-2">Welcome back, <?php echo sanitize($_SESSION['admin_user'] ?? 'Administrator'); ?>!</h2>
            <p class="text-white-50 mb-0 small" style="max-width: 650px; line-height: 1.6;">
                Unified management console for academic departments, degree programmes, student admission leads, media assets, dynamic pages, and university configurations.
            </p>
        </div>
        <div class="col-12 col-lg-4 text-lg-end mt-3 mt-lg-0">
            <div class="d-inline-flex flex-wrap gap-2">
                <a href="<?php echo BASE_URL; ?>" target="_blank" class="btn btn-light fw-bold px-3 py-2 text-navy shadow-sm rounded-pill small">
                    <i class="fas fa-external-link-alt me-1 text-danger"></i> View Live Site
                </a>
                <a href="manage_enquiries.php" class="btn btn-outline-light fw-bold px-3 py-2 shadow-sm rounded-pill small">
                    <i class="fas fa-user-graduate me-1 text-warning"></i> Leads (<?php echo $totalEnquiries; ?>)
                </a>
            </div>
        </div>
    </div>
</div>

<!-- ═══════════════════════════════════════════════════════
     PRIMARY METRIC STAT CARDS (Responsive Balanced Grid)
═══════════════════════════════════════════════════════ -->
<div class="row g-3 g-xl-4 mb-4">
    
    <!-- 1. Departments -->
    <div class="col-12 col-sm-6 col-lg-4 col-xxl-2">
        <div class="card border-0 shadow-sm rounded-4 p-3 h-100 bg-white hover-lift" style="transition: transform 0.25s ease, box-shadow 0.25s ease; border-left: 4px solid #7a0b0d !important;">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-muted fw-bold text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.5px;">Departments</span>
                <div class="rounded-3 bg-danger-subtle text-danger d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                    <i class="fas fa-university"></i>
                </div>
            </div>
            <div class="h2 fw-bold text-navy mb-1" style="font-size: 1.75rem;"><?php echo $totalDepts; ?></div>
            <a href="manage_departments.php" class="text-danger fw-semibold text-decoration-none small d-inline-flex align-items-center gap-1">
                Manage <i class="fas fa-arrow-right fa-xs"></i>
            </a>
        </div>
    </div>

    <!-- 2. Programmes -->
    <div class="col-12 col-sm-6 col-lg-4 col-xxl-2">
        <div class="card border-0 shadow-sm rounded-4 p-3 h-100 bg-white hover-lift" style="transition: transform 0.25s ease, box-shadow 0.25s ease; border-left: 4px solid #d97706 !important;">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-muted fw-bold text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.5px;">Programmes</span>
                <div class="rounded-3 bg-warning-subtle text-warning d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                    <i class="fas fa-graduation-cap"></i>
                </div>
            </div>
            <div class="h2 fw-bold text-navy mb-1" style="font-size: 1.75rem;"><?php echo $totalCourses; ?></div>
            <a href="manage_courses.php" class="text-warning fw-semibold text-decoration-none small d-inline-flex align-items-center gap-1" style="color: #b45309 !important;">
                Courses <i class="fas fa-arrow-right fa-xs"></i>
            </a>
        </div>
    </div>

    <!-- 3. Faculty Directory -->
    <div class="col-12 col-sm-6 col-lg-4 col-xxl-2">
        <div class="card border-0 shadow-sm rounded-4 p-3 h-100 bg-white hover-lift" style="transition: transform 0.25s ease, box-shadow 0.25s ease; border-left: 4px solid #2563eb !important;">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-muted fw-bold text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.5px;">Faculty</span>
                <div class="rounded-3 bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
            </div>
            <div class="h2 fw-bold text-navy mb-1" style="font-size: 1.75rem;"><?php echo $totalFaculty ?: '1,000+'; ?></div>
            <a href="manage_faculty.php" class="text-primary fw-semibold text-decoration-none small d-inline-flex align-items-center gap-1">
                Directory <i class="fas fa-arrow-right fa-xs"></i>
            </a>
        </div>
    </div>

    <!-- 4. Blogs & Articles -->
    <div class="col-12 col-sm-6 col-lg-4 col-xxl-2">
        <div class="card border-0 shadow-sm rounded-4 p-3 h-100 bg-white hover-lift" style="transition: transform 0.25s ease, box-shadow 0.25s ease; border-left: 4px solid #0891b2 !important;">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-muted fw-bold text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.5px;">Articles</span>
                <div class="rounded-3 bg-info-subtle text-info d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                    <i class="fas fa-newspaper"></i>
                </div>
            </div>
            <div class="h2 fw-bold text-navy mb-1" style="font-size: 1.75rem;"><?php echo $totalBlogs; ?></div>
            <a href="manage_blogs.php" class="text-info fw-semibold text-decoration-none small d-inline-flex align-items-center gap-1" style="color: #0891b2 !important;">
                Articles <i class="fas fa-arrow-right fa-xs"></i>
            </a>
        </div>
    </div>

    <!-- 5. News & Circulars -->
    <div class="col-12 col-sm-6 col-lg-4 col-xxl-2">
        <div class="card border-0 shadow-sm rounded-4 p-3 h-100 bg-white hover-lift" style="transition: transform 0.25s ease, box-shadow 0.25s ease; border-left: 4px solid #64748b !important;">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-muted fw-bold text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.5px;">Notices</span>
                <div class="rounded-3 bg-secondary-subtle text-secondary d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                    <i class="fas fa-bullhorn"></i>
                </div>
            </div>
            <div class="h2 fw-bold text-navy mb-1" style="font-size: 1.75rem;"><?php echo $totalNews; ?></div>
            <a href="manage_news.php" class="text-secondary fw-semibold text-decoration-none small d-inline-flex align-items-center gap-1">
                Circulars <i class="fas fa-arrow-right fa-xs"></i>
            </a>
        </div>
    </div>

    <!-- 6. Admission Leads -->
    <div class="col-12 col-sm-6 col-lg-4 col-xxl-2">
        <div class="card border-0 shadow-sm rounded-4 p-3 h-100 bg-white hover-lift" style="transition: transform 0.25s ease, box-shadow 0.25s ease; border-left: 4px solid #059669 !important;">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-muted fw-bold text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.5px;">Total Leads</span>
                <div class="rounded-3 bg-success-subtle text-success d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                    <i class="fas fa-user-graduate"></i>
                </div>
            </div>
            <div class="h2 fw-bold text-success mb-1" style="font-size: 1.75rem;"><?php echo $totalEnquiries; ?></div>
            <a href="manage_enquiries.php" class="text-success fw-semibold text-decoration-none small d-inline-flex align-items-center gap-1">
                View Leads <i class="fas fa-arrow-right fa-xs"></i>
            </a>
        </div>
    </div>

</div>

<!-- ═══════════════════════════════════════════════════════
     QUICK MANAGEMENT SHORTCUTS
═══════════════════════════════════════════════════════ -->
<div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
    <h5 class="fw-bold text-navy mb-3 small text-uppercase" style="letter-spacing: 0.5px;">
        <i class="fas fa-bolt text-warning me-2"></i> Quick Management Shortcuts
    </h5>
    <div class="row g-3">
        <div class="col-12 col-sm-6 col-lg-3">
            <a href="manage_courses.php?action=add" class="card h-100 p-3 rounded-4 text-decoration-none border bg-light hover-shadow" style="transition: all 0.2s ease;">
                <div class="d-flex align-items-center gap-3">
                    <div class="p-2 rounded-circle bg-danger text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; flex-shrink: 0;">
                        <i class="fas fa-plus"></i>
                    </div>
                    <div>
                        <strong class="d-block text-navy" style="font-size: 0.92rem;">Add New Course</strong>
                        <small class="text-muted" style="font-size: 0.75rem;">Create degree programme</small>
                    </div>
                </div>
            </a>
        </div>
        
        <div class="col-12 col-sm-6 col-lg-3">
            <a href="manage_media.php" class="card h-100 p-3 rounded-4 text-decoration-none border bg-light hover-shadow" style="transition: all 0.2s ease;">
                <div class="d-flex align-items-center gap-3">
                    <div class="p-2 rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; flex-shrink: 0;">
                        <i class="fas fa-cloud-upload-alt"></i>
                    </div>
                    <div>
                        <strong class="d-block text-navy" style="font-size: 0.92rem;">Upload Media Asset</strong>
                        <small class="text-muted" style="font-size: 0.75rem;">Images, banners &amp; PDFs</small>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-12 col-sm-6 col-lg-3">
            <a href="manage_header_footer.php" class="card h-100 p-3 rounded-4 text-decoration-none border bg-light hover-shadow" style="transition: all 0.2s ease;">
                <div class="d-flex align-items-center gap-3">
                    <div class="p-2 rounded-circle bg-dark text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; flex-shrink: 0;">
                        <i class="fas fa-heading"></i>
                    </div>
                    <div>
                        <strong class="d-block text-navy" style="font-size: 0.92rem;">Header &amp; Footer</strong>
                        <small class="text-muted" style="font-size: 0.75rem;">Navigation &amp; quick links</small>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-12 col-sm-6 col-lg-3">
            <a href="manage_enquiries.php?action=export" class="card h-100 p-3 rounded-4 text-decoration-none border bg-light hover-shadow" style="transition: all 0.2s ease;">
                <div class="d-flex align-items-center gap-3">
                    <div class="p-2 rounded-circle bg-success text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; flex-shrink: 0;">
                        <i class="fas fa-file-excel"></i>
                    </div>
                    <div>
                        <strong class="d-block text-navy" style="font-size: 0.92rem;">Export Leads (CSV)</strong>
                        <small class="text-muted" style="font-size: 0.75rem;">Download applicant data</small>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

<!-- ═══════════════════════════════════════════════════════
     RECENT STUDENT ADMISSION LEADS
═══════════════════════════════════════════════════════ -->
<div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-2 pb-3 border-bottom">
        <div>
            <h4 class="h5 fw-bold text-navy mb-1"><i class="fas fa-user-clock text-danger me-2"></i> Recent Student Admission Leads</h4>
            <small class="text-muted">Direct enquiries submitted via homepage, contact page, and course enquiry forms.</small>
        </div>
        <div>
            <a href="manage_enquiries.php" class="btn btn-sm btn-danger fw-bold px-3 rounded-pill shadow-sm">
                <i class="fas fa-list me-1"></i> Manage All Leads (<?php echo $totalEnquiries; ?>)
            </a>
        </div>
    </div>
    
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width: 80px;">#ID</th>
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
                                <strong class="text-navy d-block" style="font-size: 0.95rem;"><?php echo sanitize($eq['name']); ?></strong>
                                <div class="d-flex flex-wrap gap-2 mt-1">
                                    <small class="text-muted"><i class="fas fa-envelope text-danger me-1"></i><?php echo sanitize($eq['email']); ?></small>
                                    <small class="text-muted"><i class="fas fa-phone text-success me-1"></i><?php echo sanitize($eq['phone']); ?></small>
                                </div>
                            </td>
                            <td><span class="badge bg-light text-dark border px-2 py-1 rounded-pill"><?php echo sanitize($eq['course']); ?></span></td>
                            <td><span class="badge <?php echo $badgeClass; ?> px-2 py-1 rounded-pill"><?php echo sanitize($st); ?></span></td>
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
