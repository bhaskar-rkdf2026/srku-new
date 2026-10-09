<?php
require_once __DIR__ . '/header.php';
$pdo = getDBConnection();

$activeTab = sanitize($_GET['tab'] ?? 'vision-mission');

// Helper to save settings in DB
function savePageSetting($pdo, $key, $value) {
    $driver = $pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
    if ($driver === 'sqlite') {
        $stmt = $pdo->prepare("INSERT INTO settings (setting_key, setting_value) VALUES (:k, :v) ON CONFLICT(setting_key) DO UPDATE SET setting_value = excluded.setting_value");
    } else {
        $stmt = $pdo->prepare("INSERT INTO settings (setting_key, setting_value) VALUES (:k, :v) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)");
    }
    $stmt->execute([':k' => $key, ':v' => $value]);
}

// Handle Form Submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_page_content'])) {
    $tab = sanitize($_POST['current_tab'] ?? 'vision-mission');

    // Handle File Uploads (Images and PDFs)
    $uploadDirImg = __DIR__ . '/../assets/uploads/2026/08/';
    $uploadDirPdf = __DIR__ . '/../assets/uploads/pdf/';
    if (!is_dir($uploadDirImg)) @mkdir($uploadDirImg, 0777, true);
    if (!is_dir($uploadDirPdf)) @mkdir($uploadDirPdf, 0777, true);

    // Process all POST fields (except save buttons/tokens)
    foreach ($_POST as $k => $v) {
        if (in_array($k, ['save_page_content', 'current_tab'])) continue;
        savePageSetting($pdo, $k, $v);
    }

    // Process file uploads
    foreach ($_FILES as $inputName => $fileData) {
        if ($fileData['error'] === UPLOAD_ERR_OK && !empty($fileData['name'])) {
            $ext = strtolower(pathinfo($fileData['name'], PATHINFO_EXTENSION));
            $base = preg_replace('/[^a-zA-Z0-9_-]/', '_', pathinfo($fileData['name'], PATHINFO_FILENAME));
            
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'svg'])) {
                $targetFile = 'upload_' . $base . '_' . time() . '.' . $ext;
                if (move_uploaded_file($fileData['tmp_name'], $uploadDirImg . $targetFile)) {
                    $settingKey = str_replace('_file', '', $inputName);
                    savePageSetting($pdo, $settingKey, 'assets/uploads/2026/08/' . $targetFile);
                }
            } elseif ($ext === 'pdf') {
                $targetFile = $base . '_' . time() . '.pdf';
                if (move_uploaded_file($fileData['tmp_name'], $uploadDirPdf . $targetFile)) {
                    $settingKey = str_replace('_file', '', $inputName);
                    savePageSetting($pdo, $settingKey, 'assets/uploads/pdf/' . $targetFile);
                }
            }
        }
    }

    setFlashMsg('success', 'Page content updated successfully! All changes are live on the website.');
    header("Location: manage_page_contents.php?tab=" . urlencode($tab));
    exit;
}
?>

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h3 class="h4 fw-bold text-navy mb-0"><i class="fas fa-edit text-danger me-2"></i> Institutional Pages Content CMS</h3>
        <p class="text-muted small mb-0">Manage dedicated text, headings, policies, and files for all core institutional pages.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?php echo BASE_URL . $activeTab . '.php'; ?>" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-3">
            <i class="fas fa-external-link-alt me-1"></i> Preview Live Page
        </a>
    </div>
</div>

<!-- Section Navigation Tabs -->
<div class="card border-0 shadow-sm rounded-4 p-2 mb-4 bg-white">
    <div class="srku-filter-row">
        <a href="manage_page_contents.php?tab=vision-mission" class="srku-filter-btn <?php echo $activeTab === 'vision-mission' ? 'active' : ''; ?>">
            <i class="fas fa-bullseye"></i> 1. Vision &amp; Mission
        </a>
        <a href="manage_page_contents.php?tab=academic-calendar" class="srku-filter-btn <?php echo $activeTab === 'academic-calendar' ? 'active' : ''; ?>">
            <i class="fas fa-calendar-alt"></i> 2. Academic Calendar
        </a>
        <a href="manage_page_contents.php?tab=exam-rules" class="srku-filter-btn <?php echo $activeTab === 'exam-rules' ? 'active' : ''; ?>">
            <i class="fas fa-clipboard-check"></i> 3. Exam Rules &amp; Ordinances
        </a>
        <a href="manage_page_contents.php?tab=research-innovation" class="srku-filter-btn <?php echo $activeTab === 'research-innovation' ? 'active' : ''; ?>">
            <i class="fas fa-flask"></i> 4. Research &amp; Innovation
        </a>
        <a href="manage_page_contents.php?tab=phd-admission" class="srku-filter-btn <?php echo $activeTab === 'phd-admission' ? 'active' : ''; ?>">
            <i class="fas fa-user-graduate"></i> 5. Ph.D. Admissions
        </a>
        <a href="manage_page_contents.php?tab=founder-story" class="srku-filter-btn <?php echo $activeTab === 'founder-story' ? 'active' : ''; ?>">
            <i class="fas fa-award"></i> 6. Founder's Story
        </a>
        <a href="manage_page_contents.php?tab=hostel" class="srku-filter-btn <?php echo $activeTab === 'hostel' ? 'active' : ''; ?>">
            <i class="fas fa-bed"></i> 7. Hostels Living
        </a>
    </div>
</div>

<form action="manage_page_contents.php?tab=<?php echo urlencode($activeTab); ?>" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="save_page_content" value="1">
    <input type="hidden" name="current_tab" value="<?php echo htmlspecialchars($activeTab); ?>">

    <!-- ═══════════════════════════════════════════════════════
         TAB 1: VISION & MISSION
    ═══════════════════════════════════════════════════════ -->
    <?php if ($activeTab === 'vision-mission'): ?>
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-4 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                <h4 class="fw-bold text-navy mb-0"><i class="fas fa-bullseye text-danger me-2"></i> Vision &amp; Mission Page Content</h4>
                <a href="<?php echo BASE_URL; ?>vision-mission.php" target="_blank" class="btn btn-outline-secondary btn-sm"><i class="fas fa-external-link-alt me-1"></i> View Live</a>
            </div>

            <div class="admin-form-section">
                <div class="admin-form-section-title"><i class="fas fa-heading text-danger"></i> 1. Top Hero Banner</div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Hero Banner Title</label>
                        <input type="text" name="vm_hero_title" class="form-control" value="<?php echo htmlspecialchars(getSetting('vm_hero_title', "Our <span>Vision, Mission & Core Values</span> &ndash; Guiding Principles for Excellence")); ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Hero Subtitle / Description</label>
                        <textarea name="vm_hero_desc" class="form-control" rows="2"><?php echo htmlspecialchars(getSetting('vm_hero_desc', "SRK University's foundation rests on three pillars: an ambitious Vision for the future, a clear Mission in the present, and Core Values that guide every decision we make. These principles ensure that we remain committed to excellence, integrity, and student success.")); ?></textarea>
                    </div>
                </div>
            </div>

            <div class="admin-form-section">
                <div class="admin-form-section-title"><i class="fas fa-eye text-primary"></i> 2. Our Vision Section</div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Vision Subtitle</label>
                        <input type="text" name="vm_vision_subtitle" class="form-control" value="<?php echo htmlspecialchars(getSetting('vm_vision_subtitle', 'OUR VISION')); ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Vision Heading</label>
                        <input type="text" name="vm_vision_title" class="form-control" value="<?php echo htmlspecialchars(getSetting('vm_vision_title', "An <span>ecosystem</span> for tomorrow's leaders.")); ?>">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold small">Vision Motto Quote</label>
                        <input type="text" name="vm_vision_motto" class="form-control" value="<?php echo htmlspecialchars(getSetting('vm_vision_motto', 'LEARN ABOUT EDUCATION THAT HELPS SOCIETY')); ?>">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold small">Vision Detailed Description</label>
                        <textarea name="vm_vision_desc" class="form-control" rows="4"><?php echo htmlspecialchars(getSetting('vm_vision_desc', "Sarvepalli Radhakrishnan University is an academic fraternity of individuals dedicated to the motto, “Learn about education that helps society.” To emerge as a World – Class University in creating and disseminating knowledge, and in providing students with a unique learning experience in Science, Technology, Medicine, Management, and other areas of life that will best serve the world and the betterment of society. To create a knowledge-based society with scientific temper, team spirit, and dignity of labour to face global competitive challenges.")); ?></textarea>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label fw-bold small">Vision Section Image</label>
                        <input type="text" name="vm_vision_image" class="form-control" value="<?php echo htmlspecialchars(getSetting('vm_vision_image', 'assets/uploads/2026/08/Pi7_image_tool.jpeg')); ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold small">Upload New Vision Image</label>
                        <input type="file" name="vm_vision_image_file" class="form-control" accept="image/*">
                    </div>
                </div>
            </div>

            <div class="admin-form-section">
                <div class="admin-form-section-title"><i class="fas fa-flag-checkered text-success"></i> 3. Our Mission Section</div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Mission Subtitle</label>
                        <input type="text" name="vm_mission_subtitle" class="form-control" value="<?php echo htmlspecialchars(getSetting('vm_mission_subtitle', 'OUR MISSION')); ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Mission Heading</label>
                        <input type="text" name="vm_mission_title" class="form-control" value="<?php echo htmlspecialchars(getSetting('vm_mission_title', "Empowering <span>minds to shape</span> a better tomorrow.")); ?>">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold small">Mission Points (One per line)</label>
                        <textarea name="vm_mission_points" class="form-control" rows="6"><?php echo htmlspecialchars(getSetting('vm_mission_points', "Sarvepalli Radhakrishnan University is a nurturing ground for an individual's holistic growth, making an effective contribution to society in a dynamic environment. To evolve and develop skill-based systems for the effective delivery of knowledge so as to equip young professionals with dedication and commitment to excellence in all spheres of life and society.\nFacilitate intellectual stimulation to generate, maintain, and disseminate knowledge.\nEmpower participants to meet the challenges of a collaborative and competitive globalised environment.\nSynergise excellence amongst aspirants through a world-class ambience.\nInstitute a culture of inclusiveness and provide wide access to higher education opportunities.\nFoster a sustainable environmental attitude.\nInitiate trends which impact global higher education policies and practices.\nWe treasure our ethos and our character.")); ?></textarea>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label fw-bold small">Mission Section Image</label>
                        <input type="text" name="vm_mission_image" class="form-control" value="<?php echo htmlspecialchars(getSetting('vm_mission_image', 'assets/uploads/2026/08/Pi7_image_tool-1.jpeg')); ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold small">Upload New Mission Image</label>
                        <input type="file" name="vm_mission_image_file" class="form-control" accept="image/*">
                    </div>
                </div>
            </div>

            <div class="admin-form-section">
                <div class="admin-form-section-title"><i class="fas fa-question-circle text-warning"></i> 4. FAQs on Vision &amp; Mission Page</div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">FAQ 1 Question</label>
                        <input type="text" name="vm_faq1_q" class="form-control" value="<?php echo htmlspecialchars(getSetting('vm_faq1_q', 'What does SRK University stand for?')); ?>">
                        <label class="form-label fw-bold small mt-2">FAQ 1 Answer</label>
                        <textarea name="vm_faq1_a" class="form-control" rows="3"><?php echo htmlspecialchars(getSetting('vm_faq1_a', "SRK University is named after Dr. Sarvepalli Radhakrishnan, India's First Vice President, a renowned philosopher and educator. We embody his ideals of intellectual excellence and humanistic education.")); ?></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">FAQ 2 Question</label>
                        <input type="text" name="vm_faq2_q" class="form-control" value="<?php echo htmlspecialchars(getSetting('vm_faq2_q', 'How does SRK University support diversity and inclusion?')); ?>">
                        <label class="form-label fw-bold small mt-2">FAQ 2 Answer</label>
                        <textarea name="vm_faq2_a" class="form-control" rows="3"><?php echo htmlspecialchars(getSetting('vm_faq2_a', "Our core value of tolerance and inclusivity means we actively recruit and support students from diverse backgrounds. We offer scholarships, mentorship, and campus organisations that celebrate cultural diversity.")); ?></textarea>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- ═══════════════════════════════════════════════════════
         TAB 2: ACADEMIC CALENDAR
    ═══════════════════════════════════════════════════════ -->
    <?php if ($activeTab === 'academic-calendar'): ?>
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-4 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                <h4 class="fw-bold text-navy mb-0"><i class="fas fa-calendar-alt text-danger me-2"></i> Academic Calendar Content &amp; Milestones</h4>
                <a href="<?php echo BASE_URL; ?>academic-calendar.php" target="_blank" class="btn btn-outline-secondary btn-sm"><i class="fas fa-external-link-alt me-1"></i> View Live</a>
            </div>

            <div class="admin-form-section">
                <div class="admin-form-section-title"><i class="fas fa-heading text-danger"></i> 1. Top Hero Banner &amp; Statistics</div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Hero Banner Title</label>
                        <input type="text" name="acad_hero_title" class="form-control" value="<?php echo htmlspecialchars(getSetting('acad_hero_title', "Academic Calendar <span>2026&ndash;2027</span>")); ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Hero Subtitle / Description</label>
                        <textarea name="acad_hero_desc" class="form-control" rows="2"><?php echo htmlspecialchars(getSetting('acad_hero_desc', "Comprehensive semester roadmap, teaching schedules, internal assessments, continuous evaluations, university examinations, cultural festivals, and gazetted holiday schedules.")); ?></textarea>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold small">Teaching Days / Year</label>
                        <input type="text" name="stat_teaching_days" class="form-control" value="<?php echo htmlspecialchars(getSetting('stat_teaching_days', '180+')); ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold small">Days / Semester</label>
                        <input type="text" name="stat_days_semester" class="form-control" value="<?php echo htmlspecialchars(getSetting('stat_days_semester', '90')); ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold small">Mid-Term CIA Tests Count</label>
                        <input type="text" name="stat_cia_tests" class="form-control" value="<?php echo htmlspecialchars(getSetting('stat_cia_tests', '2')); ?>">
                    </div>
                    <div class="col-md-8">
                        <label class="form-label fw-bold small">Official Calendar PDF Path</label>
                        <input type="text" name="academic_calendar_pdf" class="form-control" value="<?php echo htmlspecialchars(getSetting('academic_calendar_pdf', 'assets/uploads/2026/07/Academic-Calendar.pdf')); ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold small">Upload New PDF File</label>
                        <input type="file" name="academic_calendar_pdf_file" class="form-control" accept="application/pdf">
                    </div>
                </div>
            </div>

            <div class="admin-form-section">
                <div class="admin-form-section-title"><i class="fas fa-sun text-warning"></i> 2. Odd Semester Schedule Details</div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Odd Semester Title</label>
                        <input type="text" name="acad_odd_title" class="form-control" value="<?php echo htmlspecialchars(getSetting('acad_odd_title', 'Odd Semester (Sem I, III, V, VII)')); ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Odd Semester Timeline Badge</label>
                        <input type="text" name="acad_odd_dates" class="form-control" value="<?php echo htmlspecialchars(getSetting('acad_odd_dates', 'July – Dec 2026')); ?>">
                    </div>
                </div>
            </div>

            <div class="admin-form-section">
                <div class="admin-form-section-title"><i class="fas fa-snowflake text-info"></i> 3. Even Semester Schedule Details</div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Even Semester Title</label>
                        <input type="text" name="acad_even_title" class="form-control" value="<?php echo htmlspecialchars(getSetting('acad_even_title', 'Even Semester (Sem II, IV, VI, VIII)')); ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Even Semester Timeline Badge</label>
                        <input type="text" name="acad_even_dates" class="form-control" value="<?php echo htmlspecialchars(getSetting('acad_even_dates', 'Jan – June 2027')); ?>">
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- ═══════════════════════════════════════════════════════
         TAB 3: EXAMINATION RULES & GUIDELINES
    ═══════════════════════════════════════════════════════ -->
    <?php if ($activeTab === 'exam-rules'): ?>
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-4 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                <h4 class="fw-bold text-navy mb-0"><i class="fas fa-clipboard-check text-danger me-2"></i> Examination Rules &amp; Evaluation Ordinances</h4>
                <a href="<?php echo BASE_URL; ?>exam-rules.php" target="_blank" class="btn btn-outline-secondary btn-sm"><i class="fas fa-external-link-alt me-1"></i> View Live</a>
            </div>

            <div class="admin-form-section">
                <div class="admin-form-section-title"><i class="fas fa-heading text-danger"></i> 1. Top Hero Banner</div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Hero Banner Title</label>
                        <input type="text" name="exam_hero_title" class="form-control" value="<?php echo htmlspecialchars(getSetting('exam_hero_title', "Examination Rules & <span>Evaluation Guidelines</span>")); ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Hero Subtitle</label>
                        <textarea name="exam_hero_desc" class="form-control" rows="2"><?php echo htmlspecialchars(getSetting('exam_hero_desc', "Comprehensive academic ordinances governing internal assessments, final examinations, attendance prerequisites, 10-point CBCS grading system, ATKT rules, and grievance redressal.")); ?></textarea>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label fw-bold small">Examination Statutes PDF Path</label>
                        <input type="text" name="exam_rules_pdf" class="form-control" value="<?php echo htmlspecialchars(getSetting('exam_rules_pdf', 'assets/uploads/2026/07/statutes-ordinances-pertaining-to-academics-examination.pdf')); ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold small">Upload New Statutes PDF</label>
                        <input type="file" name="exam_rules_pdf_file" class="form-control" accept="application/pdf">
                    </div>
                </div>
            </div>

            <div class="admin-form-section">
                <div class="admin-form-section-title"><i class="fas fa-user-clock text-danger"></i> 2. Attendance &amp; Statutory Rule 1</div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold small">Min Attendance Threshold</label>
                        <input type="text" name="stat_min_attendance" class="form-control" value="<?php echo htmlspecialchars(getSetting('stat_min_attendance', '75%')); ?>">
                    </div>
                    <div class="col-md-8">
                        <label class="form-label fw-bold small">Attendance Rule Title</label>
                        <input type="text" name="exam_att_title" class="form-control" value="<?php echo htmlspecialchars(getSetting('exam_att_title', '75% Mandatory Attendance Rule')); ?>">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold small">Attendance Ordinance Description</label>
                        <textarea name="exam_att_desc" class="form-control" rows="3"><?php echo htmlspecialchars(getSetting('exam_att_desc', "In accordance with UGC regulations and statutory council directives (AICTE, NMC, PCI, BCI, INC), a student must have registered a minimum aggregate attendance of 75% in all lectures, tutorials, and practical laboratory sessions conducted during the semester to be eligible to appear for the End Semester University Examinations.")); ?></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Medical Condonation Policy</label>
                        <textarea name="exam_att_medical" class="form-control" rows="3"><?php echo htmlspecialchars(getSetting('exam_att_medical', "Condonation of up to 10% attendance may be granted by the Vice Chancellor on valid medical grounds, provided authentic registered medical certificates are submitted within 7 days of illness.")); ?></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Sports &amp; Cultural Concession</label>
                        <textarea name="exam_att_sports" class="form-control" rows="3"><?php echo htmlspecialchars(getSetting('exam_att_sports', "Attendance concession up to 10% is granted to students officially deputed to represent the university in AIU, state, or national championships and academic conferences.")); ?></textarea>
                    </div>
                </div>
            </div>

            <div class="admin-form-section">
                <div class="admin-form-section-title"><i class="fas fa-calculator text-primary"></i> 3. CBCS Grading System &amp; ATKT Rules</div>
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label fw-bold small">10-Point CBCS Description</label>
                        <textarea name="exam_cbcs_desc" class="form-control" rows="2"><?php echo htmlspecialchars(getSetting('exam_cbcs_desc', "The university follows the UGC standardized 10-Point Letter Grading System. Performance in each course is evaluated on continuous internal assessments (CIA: 30% / 40%) and end semester examinations (ESE: 70% / 60%).")); ?></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Revaluation &amp; Scrutiny Description</label>
                        <textarea name="exam_reval_desc" class="form-control" rows="3"><?php echo htmlspecialchars(getSetting('exam_reval_desc', "Students dissatisfied with their evaluated theory answer books may apply for Re-totaling / Revaluation within 15 days of declaration of results by submitting the prescribed fee through the examination portal.")); ?></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">UFM (Unfair Means) Policy</label>
                        <textarea name="exam_ufm_desc" class="form-control" rows="3"><?php echo htmlspecialchars(getSetting('exam_ufm_desc', "Carrying mobile phones, smartwatches, chits, or unauthorized materials into examination halls is strictly prohibited. Instances of cheating are referred to the University UFM Disciplinary Committee and attract cancellation of examination or debarment.")); ?></textarea>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- ═══════════════════════════════════════════════════════
         TAB 4: RESEARCH & INNOVATION
    ═══════════════════════════════════════════════════════ -->
    <?php if ($activeTab === 'research-innovation'): ?>
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-4 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                <h4 class="fw-bold text-navy mb-0"><i class="fas fa-flask text-danger me-2"></i> Research &amp; Innovation Cell Content</h4>
                <a href="<?php echo BASE_URL; ?>research-innovation.php" target="_blank" class="btn btn-outline-secondary btn-sm"><i class="fas fa-external-link-alt me-1"></i> View Live</a>
            </div>

            <div class="admin-form-section">
                <div class="admin-form-section-title"><i class="fas fa-heading text-danger"></i> 1. Top Banner</div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Banner Title</label>
                        <input type="text" name="research_banner_title" class="form-control" value="<?php echo htmlspecialchars(getSetting('research_banner_title', 'Research & Innovation Cell')); ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Banner Subtitle</label>
                        <input type="text" name="research_banner_subtitle" class="form-control" value="<?php echo htmlspecialchars(getSetting('research_banner_subtitle', 'Fostering Groundbreaking Discoveries, Patents & Interdisciplinary Science')); ?>">
                    </div>
                </div>
            </div>

            <div class="admin-form-section">
                <div class="admin-form-section-title"><i class="fas fa-lightbulb text-warning"></i> 2. Pioneering Solutions Section</div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Section Heading</label>
                        <input type="text" name="research_pioneering_title" class="form-control" value="<?php echo htmlspecialchars(getSetting('research_pioneering_title', "Pioneering Solutions for <span>Global Challenges</span>")); ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Section Subtitle</label>
                        <input type="text" name="research_pioneering_subtitle" class="form-control" value="<?php echo htmlspecialchars(getSetting('research_pioneering_subtitle', 'DISCOVERY & EXCELLENCE')); ?>">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold small">Description Paragraph 1</label>
                        <textarea name="research_pioneering_desc1" class="form-control" rows="2"><?php echo htmlspecialchars(getSetting('research_pioneering_desc1', "Research at Sarvepalli Radhakrishnan University is driven by a deep commitment to addressing pressing societal, medical, environmental, and technological challenges through cutting-edge inquiry and translational research.")); ?></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold small">Description Paragraph 2</label>
                        <textarea name="research_pioneering_desc2" class="form-control" rows="2"><?php echo htmlspecialchars(getSetting('research_pioneering_desc2', "Our faculty and doctoral scholars actively publish in prestigious high-impact peer-reviewed journals indexed in Scopus, Web of Science, and PubMed, securing national and international patents across nanomedicine, artificial intelligence, renewable energy, and agricultural biotechnology.")); ?></textarea>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label fw-bold small">Featured Lab &amp; Research Image</label>
                        <input type="text" name="research_image" class="form-control" value="<?php echo htmlspecialchars(getSetting('research_image', 'assets/uploads/2026/07/lab-and-research.webp')); ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold small">Upload New Lab Image</label>
                        <input type="file" name="research_image_file" class="form-control" accept="image/*">
                    </div>
                </div>
            </div>

            <div class="admin-form-section">
                <div class="admin-form-section-title"><i class="fas fa-file-pdf text-danger"></i> 3. Ph.D. Forms Box on Research Page</div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Box Title</label>
                        <input type="text" name="research_phd_box_title" class="form-control" value="<?php echo htmlspecialchars(getSetting('research_phd_box_title', 'Ph.D. Admission 2026 & Official Forms')); ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Box Description</label>
                        <textarea name="research_phd_box_desc" class="form-control" rows="2"><?php echo htmlspecialchars(getSetting('research_phd_box_desc', "Download the official prescribed application and entrance examination forms for Ph.D. admissions across Engineering, Pharmacy, Management, Computer Applications, Medical, and Science.")); ?></textarea>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- ═══════════════════════════════════════════════════════
         TAB 5: PH.D. ADMISSIONS
    ═══════════════════════════════════════════════════════ -->
    <?php if ($activeTab === 'phd-admission'): ?>
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-4 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                <h4 class="fw-bold text-navy mb-0"><i class="fas fa-user-graduate text-danger me-2"></i> Doctor of Philosophy (Ph.D.) Portal Content</h4>
                <a href="<?php echo BASE_URL; ?>phd-admission.php" target="_blank" class="btn btn-outline-secondary btn-sm"><i class="fas fa-external-link-alt me-1"></i> View Live</a>
            </div>

            <div class="admin-form-section">
                <div class="admin-form-section-title"><i class="fas fa-heading text-danger"></i> 1. Top Banner</div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Banner Title</label>
                        <input type="text" name="phd_banner_title" class="form-control" value="<?php echo htmlspecialchars(getSetting('phd_banner_title', 'Doctor of Philosophy (Ph.D.) Admissions 2026')); ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Banner Subtitle</label>
                        <input type="text" name="phd_banner_subtitle" class="form-control" value="<?php echo htmlspecialchars(getSetting('phd_banner_subtitle', 'UGC Recognized Doctoral Research Programmes Across Engineering, Pharmacy, Management, Medical, Science & Law')); ?>">
                    </div>
                </div>
            </div>

            <div class="admin-form-section">
                <div class="admin-form-section-title"><i class="fas fa-file-pdf text-danger"></i> 2. Official PDF Forms &amp; Downloads</div>
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label fw-bold small">Ph.D. Application Form PDF Path</label>
                        <input type="text" name="phd_application_pdf" class="form-control" value="<?php echo htmlspecialchars(getSetting('phd_application_pdf', 'assets/uploads/pdf/phd-application-form.pdf')); ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold small">Upload Application PDF</label>
                        <input type="file" name="phd_application_pdf_file" class="form-control" accept="application/pdf">
                    </div>
                    <div class="col-md-8">
                        <label class="form-label fw-bold small">Ph.D. Entrance Examination Form PDF Path</label>
                        <input type="text" name="phd_entrance_pdf" class="form-control" value="<?php echo htmlspecialchars(getSetting('phd_entrance_pdf', 'assets/uploads/pdf/phd-entrance-form.pdf')); ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold small">Upload Entrance PDF</label>
                        <input type="file" name="phd_entrance_pdf_file" class="form-control" accept="application/pdf">
                    </div>
                    <div class="col-md-8">
                        <label class="form-label fw-bold small">Ph.D. Synopsis Format PDF Path</label>
                        <input type="text" name="phd_synopsis_pdf" class="form-control" value="<?php echo htmlspecialchars(getSetting('phd_synopsis_pdf', 'assets/uploads/pdf/phd-synopsis-format.pdf')); ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold small">Upload Synopsis PDF</label>
                        <input type="file" name="phd_synopsis_pdf_file" class="form-control" accept="application/pdf">
                    </div>
                </div>
            </div>

            <div class="admin-form-section">
                <div class="admin-form-section-title"><i class="fas fa-check-circle text-success"></i> 3. Eligibility &amp; Exemption Criteria</div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">General Eligibility (55%)</label>
                        <textarea name="phd_eligibility_gen" class="form-control" rows="3"><?php echo htmlspecialchars(getSetting('phd_eligibility_gen', "Master's Degree with minimum 55% marks (or equivalent grade) from a recognized university in the relevant or allied discipline.")); ?></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Reserved Category Relaxation (50%)</label>
                        <textarea name="phd_eligibility_res" class="form-control" rows="3"><?php echo htmlspecialchars(getSetting('phd_eligibility_res', "5% marks relaxation (Min 50%) for SC / ST / OBC (non-creamy layer) / Differently-abled candidates as per UGC guidelines.")); ?></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold small">Entrance Test Exemption Guidelines</label>
                        <textarea name="phd_exemption_rules" class="form-control" rows="3"><?php echo htmlspecialchars(getSetting('phd_exemption_rules', "Candidates who have qualified UGC-NET / CSIR-NET / GATE / SLET / GPAT / Teacher Fellowship holders or have completed regular M.Phil. degree are exempted from appearing in the Entrance Test and directly eligible for Research Proposal Interview.")); ?></textarea>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- ═══════════════════════════════════════════════════════
         TAB 6: FOUNDER'S STORY
    ═══════════════════════════════════════════════════════ -->
    <?php if ($activeTab === 'founder-story'): ?>
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-4 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                <h4 class="fw-bold text-navy mb-0"><i class="fas fa-award text-warning me-2"></i> Founder's Story &amp; Leadership Address</h4>
                <a href="<?php echo BASE_URL; ?>founder-story.php" target="_blank" class="btn btn-outline-secondary btn-sm"><i class="fas fa-external-link-alt me-1"></i> View Live</a>
            </div>

            <div class="admin-form-section">
                <div class="admin-form-section-title"><i class="fas fa-user-tie text-primary"></i> 1. Founder &amp; Chairman Profile</div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Founder Chairman Name</label>
                        <input type="text" name="chairman_name" class="form-control" value="<?php echo htmlspecialchars(getSetting('chairman_name', 'Dr. Sunil Kapoor')); ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Chairman Title / Designation</label>
                        <input type="text" name="chairman_title" class="form-control" value="<?php echo htmlspecialchars(getSetting('chairman_title', 'Chairman & Founder Patron')); ?>">
                    </div>
                    <div class="col-md-8">
                        <label class="form-label fw-bold small">Chairman Official Portrait Photo</label>
                        <input type="text" name="chairman_photo" class="form-control" value="<?php echo htmlspecialchars(getSetting('chairman_photo', 'assets/uploads/2026/08/dr-sunil-kapoor.jpeg')); ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold small">Upload New Portrait</label>
                        <input type="file" name="chairman_photo_file" class="form-control" accept="image/*">
                    </div>
                </div>
            </div>

            <div class="admin-form-section">
                <div class="admin-form-section-title"><i class="fas fa-quote-left text-danger"></i> 2. Quotes &amp; Philosophy</div>
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label fw-bold small">Hero Banner Quote</label>
                        <input type="text" name="chairman_hero_quote" class="form-control" value="<?php echo htmlspecialchars(getSetting('chairman_hero_quote', 'Transforming society through the twin pillars of quality education and accessible healthcare—nurturing ethical innovators, skilled professionals, and future-ready leaders.')); ?>">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold small">Chairman's Featured Story Quote</label>
                        <textarea name="chairman_story_quote" class="form-control" rows="4"><?php echo htmlspecialchars(getSetting('chairman_story_quote', "Modern education demands far more than mere classroom instruction. A student needs an empowering blend of cutting-edge knowledge, practical skill mastery, innovative thinking, and deeply rooted ethical values. At SRK University, our lifelong commitment is to build multidisciplinary institutions that democratize healthcare and higher learning for the betterment of society.")); ?></textarea>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- ═══════════════════════════════════════════════════════
         TAB 7: HOSTEL DETAILS
    ═══════════════════════════════════════════════════════ -->
    <?php if ($activeTab === 'hostel'): ?>
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-4 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                <h4 class="fw-bold text-navy mb-0"><i class="fas fa-bed text-danger me-2"></i> On-Campus Hostels &amp; Living Accommodations</h4>
                <a href="<?php echo BASE_URL; ?>hostel.php" target="_blank" class="btn btn-outline-secondary btn-sm"><i class="fas fa-external-link-alt me-1"></i> View Live</a>
            </div>

            <div class="admin-form-section">
                <div class="admin-form-section-title"><i class="fas fa-home text-primary"></i> 1. Overview &amp; Fee Structure</div>
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label fw-bold small">Hostels Overview Description</label>
                        <textarea name="hostel_desc" class="form-control" rows="3"><?php echo htmlspecialchars(getSetting('hostel_desc', 'A home away from home: separate modern residential hostel blocks for boys and girls with 24/7 biometric security, nutritious dining mess, high-speed Wi-Fi, sports, and hospital healthcare.')); ?></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Boys Hostel Annual Fee</label>
                        <input type="text" name="hostel_boys_fee" class="form-control" value="<?php echo htmlspecialchars(getSetting('hostel_boys_fee', '₹65,000 / Year')); ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Girls Hostel Annual Fee</label>
                        <input type="text" name="hostel_girls_fee" class="form-control" value="<?php echo htmlspecialchars(getSetting('hostel_girls_fee', '₹70,000 / Year')); ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Hostel Office Phone</label>
                        <input type="text" name="hostel_contact_phone" class="form-control" value="<?php echo htmlspecialchars(getSetting('hostel_contact_phone', '0755 - 4911204')); ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Hostel Office Email</label>
                        <input type="text" name="hostel_contact_email" class="form-control" value="<?php echo htmlspecialchars(getSetting('hostel_contact_email', 'hostel@srku.edu.in')); ?>">
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Bottom Sticky Save Bar -->
    <div class="d-flex justify-content-end align-items-center gap-3 p-3 bg-white border shadow-sm rounded-4 position-sticky bottom-0 z-3">
        <a href="manage_page_contents.php?tab=<?php echo urlencode($activeTab); ?>" class="btn btn-outline-secondary px-4">Discard Changes</a>
        <button type="submit" class="btn btn-danger px-4 fw-bold shadow-sm">
            <i class="fas fa-save me-1"></i> Save Changes to Live Website
        </button>
    </div>
</form>

<?php require_once __DIR__ . '/footer.php'; ?>
