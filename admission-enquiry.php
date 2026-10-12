<?php
require_once __DIR__ . '/includes/functions.php';

$pageTitle = "Online Admission Enquiry 2026-27 | UG, PG & PhD Programs | SRKU Bhopal";
$pageDesc = "Apply online for Academic Session 2026-27 at Sarvepalli Radhakrishnan University (SRKU), Bhopal. Direct online enquiry for Engineering, Pharmacy, Nursing, Law, Agriculture and Medical degrees.";
$pageKeywords = "SRKU Admission 2026, Online Admission Form, University Admission Bhopal, Direct Admission Enquiry MP";
$activeNav = "admission";

$enquirySuccess = false;
$enquiryErr = '';
$enquiryMsg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_enquiry'])) {
    $res = saveEnquiryLead(
        $_POST['name'] ?? '',
        $_POST['email'] ?? '',
        $_POST['phone'] ?? '',
        $_POST['course'] ?? '',
        $_POST['message'] ?? '',
        'Online Admission Form',
        $_POST['father_name'] ?? '',
        $_POST['city'] ?? '',
        $_POST['state'] ?? '',
        $_POST['college'] ?? ''
    );
    if ($res['success']) {
        $enquirySuccess = true;
        $enquiryMsg = $res['message'];
    } else {
        $enquiryErr = $res['error'];
    }
}

// Fetch all database courses & departments
$allCourses = getCourses();
$allDepartments = getDepartments(true);
$selectedCourseParam = sanitize($_GET['course'] ?? ($_POST['course'] ?? ''));
$postedCollege = sanitize($_POST['college'] ?? '');

$levelOrder = ['UG', 'PG', 'Diploma', 'Doctorate'];
$levelLabels = [
    'UG'        => 'Undergraduate Programmes (UG)',
    'PG'        => 'Postgraduate Programmes (PG)',
    'Diploma'   => 'Diploma & Certificate Programmes',
    'Doctorate' => 'Doctoral (Ph.D.) Research'
];
$levelIcons = [
    'UG'        => 'fas fa-user-graduate',
    'PG'        => 'fas fa-award',
    'Diploma'   => 'fas fa-certificate',
    'Doctorate' => 'fas fa-microscope'
];

$groupedCourses = [
    'UG'        => [],
    'PG'        => [],
    'Diploma'   => [],
    'Doctorate' => []
];

foreach ($allCourses as $c) {
    $lvl = $c['level'] ?? 'UG';
    if (!isset($groupedCourses[$lvl])) {
        $groupedCourses[$lvl] = [];
    }
    $groupedCourses[$lvl][] = $c;
}

// Build map of college slug -> courses for instant JS filtering
$deptCoursesMap = [];
foreach ($allDepartments as $col) {
    $deptCoursesMap[$col['slug']] = [];
}

foreach ($allCourses as $course) {
    $slug = $course['dept_slug'] ?? '';
    if (isset($deptCoursesMap[$slug])) {
        $deptCoursesMap[$slug][] = [
            'name'     => $course['course_name'],
            'level'    => $course['level'] ?? '',
            'duration' => $course['duration'] ?? '',
        ];
    } else {
        foreach ($allDepartments as $col) {
            if ($col['name'] === ($course['department'] ?? '')) {
                $deptCoursesMap[$col['slug']][] = [
                    'name'     => $course['course_name'],
                    'level'    => $course['level'] ?? '',
                    'duration' => $course['duration'] ?? '',
                ];
                break;
            }
        }
    }
}

// Build clean list of constituent colleges (omitting items with 0 courses)
$collegeList = [];
foreach ($allDepartments as $col) {
    $slug = $col['slug'];
    $coursesCount = count($deptCoursesMap[$slug] ?? []);
    if ($coursesCount === 0) continue;

    $nameLower = strtolower($col['name']);
    $catLower  = strtolower($col['category'] ?? '');

    $icon = 'fas fa-university';
    if (strpos($nameLower, 'pharmacy') !== false || strpos($catLower, 'pharmacy') !== false) {
        $icon = 'fas fa-pills';
    } elseif (strpos($nameLower, 'nursing') !== false || strpos($catLower, 'nursing') !== false) {
        $icon = 'fas fa-user-nurse';
    } elseif (strpos($nameLower, 'dental') !== false) {
        $icon = 'fas fa-tooth';
    } elseif (strpos($nameLower, 'medical') !== false || strpos($catLower, 'medical') !== false) {
        $icon = 'fas fa-stethoscope';
    } elseif (strpos($nameLower, 'ayurveda') !== false || strpos($nameLower, 'homoeopathic') !== false || strpos($catLower, 'ayush') !== false) {
        $icon = 'fas fa-leaf';
    } elseif (strpos($nameLower, 'law') !== false || strpos($catLower, 'law') !== false) {
        $icon = 'fas fa-scale-balanced';
    } elseif (strpos($nameLower, 'management') !== false || strpos($nameLower, 'business') !== false || strpos($catLower, 'management') !== false) {
        $icon = 'fas fa-chart-line';
    } elseif (strpos($nameLower, 'technology') !== false || strpos($nameLower, 'engineering') !== false || strpos($catLower, 'engineering') !== false) {
        $icon = 'fas fa-cogs';
    } elseif (strpos($nameLower, 'computer') !== false || strpos($nameLower, 'mca') !== false || strpos($catLower, 'computer') !== false) {
        $icon = 'fas fa-laptop-code';
    } elseif (strpos($nameLower, 'agriculture') !== false || strpos($catLower, 'agriculture') !== false) {
        $icon = 'fas fa-seedling';
    } elseif (strpos($nameLower, 'paramedical') !== false || strpos($catLower, 'paramedical') !== false) {
        $icon = 'fas fa-heartbeat';
    }

    $col['icon'] = $icon;
    $collegeList[] = $col;
    // Also alias by college name so lookups work regardless of key
    $deptCoursesMap[$col['name']] = $deptCoursesMap[$slug];
}

$address = getSetting('address', 'NH-12 Hoshangabad Road, Misrod, Bhopal, MP - 462026');
$helpline = getSetting('helpline', '0755 - 4700983, 7024144981');
$email = getSetting('email', 'info@srku.edu.in');

require_once __DIR__ . '/includes/header.php';
?>

<!-- Dynamic Banner Header -->
<?php renderPageBanner('admission-enquiry', 'Online Admission Enquiry 2026-27', 'Begin your academic journey at Sarvepalli Radhakrishnan University, Bhopal'); ?>

<section class="py-5 bg-light">
    <div class="container-xl py-3">
        <div class="row g-4 g-lg-5">
            
            <!-- Left Form Column -->
            <div class="col-12 col-lg-8" id="apply">
                <div class="card p-4 p-md-5 border-0 shadow rounded-4 bg-white">
                    <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-3">
                        <div>
                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-1 rounded-pill fw-bold text-uppercase" style="font-size:0.75rem;">
                                <i class="fas fa-graduation-cap me-1"></i> Admissions Open 2026-27
                            </span>
                            <h2 class="h3 fw-bold text-navy mt-2 mb-0">Admission <span>Registration &amp; Enquiry</span></h2>
                        </div>
                        <div class="d-none d-sm-block text-end">
                            <span class="badge bg-navy text-white px-3 py-2 fw-semibold">UGC Approved</span>
                        </div>
                    </div>

                    <p class="text-muted small mb-4">
                        Please provide your contact and academic preferences below. Our central university counseling desk will reach out within 24 hours with eligibility, fee structures, and scholarship details.
                    </p>

                    <?php if ($enquirySuccess): ?>
                        <div class="alert alert-success d-flex align-items-center gap-3 p-3 rounded-3 mb-4 shadow-sm">
                            <i class="fas fa-check-circle fa-2x text-success"></i>
                            <div>
                                <strong class="d-block text-success">Application Received Successfully!</strong>
                                <span class="small text-dark"><?php echo sanitize($enquiryMsg); ?></span>
                            </div>
                        </div>
                    <?php elseif ($enquiryErr): ?>
                        <div class="alert alert-danger d-flex align-items-center gap-2 p-3 rounded-3 mb-4">
                            <i class="fas fa-exclamation-circle text-danger"></i>
                            <span><?php echo sanitize($enquiryErr); ?></span>
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo BASE_URL; ?>admission-enquiry.php#apply" method="POST">
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="srku-label" for="admissionName">Candidate Full Name <span class="req-star">*</span></label>
                                <div class="srku-input-wrap">
                                    <i class="fas fa-user srku-field-icon"></i>
                                    <input type="text" id="admissionName" name="name" class="srku-input" placeholder="Enter candidate's full name" value="<?php echo $enquirySuccess ? '' : sanitize($_POST['name'] ?? ''); ?>" minlength="2" maxlength="80" pattern="^[A-Za-z\s\.\']{2,80}$" title="Name must contain only alphabets and spaces (no numbers or symbols)." autocomplete="name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="srku-label" for="admissionFatherName">Father's / Guardian's Name</label>
                                <div class="srku-input-wrap">
                                    <i class="fas fa-user-tie srku-field-icon"></i>
                                    <input type="text" id="admissionFatherName" name="father_name" class="srku-input" placeholder="Enter father's / guardian's name" value="<?php echo $enquirySuccess ? '' : sanitize($_POST['father_name'] ?? ''); ?>" maxlength="80" pattern="^[A-Za-z\s\.\']{2,80}$" title="Father's Name must contain only alphabets and spaces (no numbers)." autocomplete="off">
                                </div>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="srku-label" for="admissionPhone">Mobile Number (WhatsApp) <span class="req-star">*</span></label>
                                <div class="srku-input-wrap">
                                    <span class="srku-phone-prefix">+91</span>
                                    <input type="tel" id="admissionPhone" name="phone" class="srku-input srku-phone-input" placeholder="10-digit mobile number" value="<?php echo $enquirySuccess ? '' : sanitize($_POST['phone'] ?? ''); ?>" pattern="[6-9][0-9]{9}" minlength="10" maxlength="10" inputmode="numeric" title="Please enter a valid 10-digit mobile number starting with 6, 7, 8 or 9." required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="srku-label" for="admissionEmail">Email Address <span class="req-star">*</span></label>
                                <div class="srku-input-wrap">
                                    <i class="fas fa-envelope srku-field-icon"></i>
                                    <input type="email" id="admissionEmail" name="email" class="srku-input" placeholder="yourname@gmail.com" value="<?php echo $enquirySuccess ? '' : sanitize($_POST['email'] ?? ''); ?>" pattern="[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}$" title="Please enter a valid email address (e.g. name@domain.com)." required>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-12">
                                <label class="srku-label" for="admissionCourse">Select Course / Programme <span class="req-star">*</span></label>
                                <div class="srku-input-wrap">
                                    <i class="fas fa-graduation-cap srku-field-icon"></i>
                                    <div class="srku-dd-wrap" id="admCourseDDWrap">
                                        <button type="button" class="srku-dd-trigger" id="admCourseTrigger" aria-haspopup="listbox" aria-expanded="false">
                                            <span class="srku-dd-label srku-dd-placeholder">Search &amp; Select Course (e.g. B.Tech, MBA, MBBS, B.Pharma, BCA...)</span>
                                            <svg class="srku-dd-chevron" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                                        </button>
                                        <div class="srku-dd-panel" id="admCoursePanel">
                                            <div class="srku-dd-search-wrap">
                                                <i class="fas fa-search srku-dd-search-icon"></i>
                                                <input type="text" class="srku-dd-search" id="admCourseSearch" placeholder="Type course or faculty name to search..." autocomplete="off">
                                            </div>
                                            <div class="srku-dd-list" id="admCourseList">
                                                <?php foreach ($levelOrder as $lvl): 
                                                    if (empty($groupedCourses[$lvl])) continue;
                                                ?>
                                                    <div class="srku-dd-group">
                                                        <div class="srku-dd-group-left">
                                                            <span class="srku-dd-group-icon"><i class="<?php echo $levelIcons[$lvl] ?? 'fas fa-graduation-cap'; ?>"></i></span>
                                                            <span class="srku-dd-group-title"><?php echo $levelLabels[$lvl] ?? $lvl; ?></span>
                                                        </div>
                                                        <span class="srku-dd-group-badge"><?php echo count($groupedCourses[$lvl]); ?> Courses</span>
                                                    </div>
                                                    <?php foreach ($groupedCourses[$lvl] as $c): 
                                                        $cName = $c['course_name'] ?? $c['name'] ?? '';
                                                        $cDur = !empty($c['duration']) ? " ({$c['duration']})" : '';
                                                        $cDept = $c['department'] ?? '';
                                                        $isPreselected = (!empty($selectedCourseParam) && ($selectedCourseParam === $cName || strcasecmp($selectedCourseParam, $cName) === 0));
                                                    ?>
                                                        <div class="srku-dd-option<?php echo $isPreselected ? ' selected' : ''; ?>"
                                                             data-value="<?php echo sanitize($cName); ?>"
                                                             data-college="<?php echo sanitize($cDept); ?>"
                                                             <?php echo $isPreselected ? 'data-preselected="1"' : ''; ?>>
                                                            <span class="srku-dd-opt-text"><?php echo sanitize($cName . $cDur); ?></span>
                                                            <?php if (!empty($cDept)): ?>
                                                                <span class="srku-dd-dept-badge"><?php echo sanitize($cDept); ?></span>
                                                            <?php endif; ?>
                                                        </div>
                                                    <?php endforeach; ?>
                                                <?php endforeach; ?>
                                                <div class="srku-dd-empty">No matching courses found</div>
                                            </div>
                                        </div>
                                        <select name="course" id="admissionCourse" class="srku-dd-native" required>
                                            <option value="">-- Choose Course --</option>
                                            <?php foreach ($levelOrder as $lvl): 
                                                if (empty($groupedCourses[$lvl])) continue;
                                                foreach ($groupedCourses[$lvl] as $c): 
                                                    $cName = $c['course_name'] ?? $c['name'] ?? '';
                                                    $cDur = !empty($c['duration']) ? " ({$c['duration']})" : '';
                                                    $cDept = $c['department'] ?? '';
                                                    $isPreselected = (!empty($selectedCourseParam) && ($selectedCourseParam === $cName || strcasecmp($selectedCourseParam, $cName) === 0));
                                            ?>
                                                <option value="<?php echo sanitize($cName); ?>" data-college="<?php echo sanitize($cDept); ?>" <?php echo $isPreselected ? 'selected' : ''; ?>>
                                                    <?php echo sanitize($cName . $cDur); ?>
                                                </option>
                                            <?php endforeach; endforeach; ?>
                                        </select>
                                        <input type="hidden" name="college" id="admissionCollege" value="<?php echo sanitize($postedCollege); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="srku-label" for="admissionCity">City / District</label>
                                <div class="srku-input-wrap">
                                    <i class="fas fa-map-marker-alt srku-field-icon"></i>
                                    <input type="text" id="admissionCity" name="city" class="srku-input" placeholder="e.g. Bhopal, Indore, Patna, etc." value="<?php echo $enquirySuccess ? '' : sanitize($_POST['city'] ?? ''); ?>" maxlength="60" pattern="^[A-Za-z\s\.\-]{2,60}$" title="City name must contain only alphabets and spaces.">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="srku-label" for="admissionState">State</label>
                                <div class="srku-input-wrap">
                                    <i class="fas fa-globe-asia srku-field-icon"></i>
                                    <input type="text" id="admissionState" name="state" class="srku-input" placeholder="e.g. Madhya Pradesh, Bihar, UP" value="<?php echo $enquirySuccess ? '' : sanitize($_POST['state'] ?? ''); ?>" maxlength="60" pattern="^[A-Za-z\s\.\-]{2,60}$" title="State name must contain only alphabets and spaces.">
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="srku-label" for="admissionMessage">Specific Query / Academic Background (Optional)</label>
                            <textarea id="admissionMessage" name="message" class="form-control p-3" rows="3" style="border-radius:14px; border:1.5px solid #e2e8f0; font-size:0.94rem; background:#f8fafc;" placeholder="Enter any specific queries regarding fee installments, hostel accommodation, bus transport, or direct counseling..."><?php echo $enquirySuccess ? '' : sanitize($_POST['message'] ?? ''); ?></textarea>
                        </div>

                        <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3">
                            <button type="submit" name="submit_enquiry" class="btn-srku-submit-v2" style="max-width:320px;">
                                <i class="fas fa-paper-plane"></i> <span>Submit Admission Form</span> <i class="fas fa-arrow-right btn-arrow-icon"></i>
                            </button>
                            <span class="text-muted small"><i class="fas fa-lock text-success me-1"></i> Your details are 100% confidential.</span>
                        </div>
                    </form>

                    <script>
                    (function() {
                        'use strict';

                        const trigger  = document.getElementById('admCourseTrigger');
                        const panel    = document.getElementById('admCoursePanel');
                        const search   = document.getElementById('admCourseSearch');
                        const list     = document.getElementById('admCourseList');
                        const native   = document.getElementById('admissionCourse');
                        const hiddenCol= document.getElementById('admissionCollege');

                        if (!trigger || !panel || !list || !native) return;

                        let isOpen = false;
                        const labelEl = trigger.querySelector('.srku-dd-label');
                        const emptyEl = list.querySelector('.srku-dd-empty');

                        function open() {
                            isOpen = true;
                            trigger.classList.add('open');
                            panel.classList.add('open');
                            trigger.setAttribute('aria-expanded', 'true');
                            if (search) {
                                search.value = '';
                                filterOptions('');
                                search.focus();
                            }
                        }

                        function close() {
                            isOpen = false;
                            trigger.classList.remove('open');
                            panel.classList.remove('open');
                            trigger.setAttribute('aria-expanded', 'false');
                        }

                        trigger.addEventListener('click', function(e) {
                            e.stopPropagation();
                            isOpen ? close() : open();
                        });

                        document.addEventListener('click', function(e) {
                            if (!trigger.contains(e.target) && !panel.contains(e.target)) close();
                        });

                        if (search) {
                            search.addEventListener('input', function() { filterOptions(this.value.trim()); });
                            search.addEventListener('click', function(e) { e.stopPropagation(); });
                        }

                        function filterOptions(query) {
                            const q = query.toLowerCase();
                            const options = list.querySelectorAll('.srku-dd-option');
                            const groups  = list.querySelectorAll('.srku-dd-group');
                            let anyVisible = false;

                            options.forEach(function(opt) {
                                const textEl = opt.querySelector('.srku-dd-opt-text');
                                const deptEl = opt.querySelector('.srku-dd-dept-badge');
                                const text = (textEl ? textEl.textContent : (opt.dataset.value || opt.textContent)).toLowerCase();
                                const dept = deptEl ? deptEl.textContent.toLowerCase() : '';
                                const match = !q || text.includes(q) || dept.includes(q);
                                opt.classList.toggle('hidden', !match);
                                if (match) anyVisible = true;
                            });

                            groups.forEach(function(grp) {
                                let sib = grp.nextElementSibling;
                                let hasVisible = false;
                                while (sib && !sib.classList.contains('srku-dd-group') && !sib.classList.contains('srku-dd-empty')) {
                                    if (!sib.classList.contains('hidden')) hasVisible = true;
                                    sib = sib.nextElementSibling;
                                }
                                grp.classList.toggle('hidden', !hasVisible);
                            });

                            if (emptyEl) emptyEl.classList.toggle('visible', !anyVisible);
                        }

                        function selectOption(value, college, label) {
                            if (labelEl) {
                                labelEl.textContent = label;
                                labelEl.classList.remove('srku-dd-placeholder');
                            }
                            trigger.classList.add('has-value');

                            list.querySelectorAll('.srku-dd-option').forEach(function(o) {
                                o.classList.toggle('selected', o.dataset.value === value);
                            });

                            native.value = value;
                            if (hiddenCol) hiddenCol.value = college || '';
                            native.dispatchEvent(new Event('change', { bubbles: true }));
                        }

                        list.addEventListener('click', function(e) {
                            const opt = e.target.closest('.srku-dd-option');
                            if (!opt) return;
                            const val = opt.dataset.value || '';
                            const col = opt.dataset.college || '';
                            const textEl = opt.querySelector('.srku-dd-opt-text');
                            const label = textEl ? textEl.textContent.trim() : (val || opt.textContent.trim());
                            selectOption(val, col, label);
                            close();
                        });

                        // Restore preselected option on page load
                        const preselectedOpt = list.querySelector('.srku-dd-option[data-preselected="1"]');
                        if (preselectedOpt) {
                            const textEl = preselectedOpt.querySelector('.srku-dd-opt-text');
                            const label = textEl ? textEl.textContent.trim() : preselectedOpt.dataset.value;
                            selectOption(preselectedOpt.dataset.value, preselectedOpt.dataset.college || '', label);
                        }
                    })();
                    </script>

                </div>
            </div>

            <!-- Right Sidebar Column -->
            <div class="col-12 col-lg-4">
                
                <!-- Direct Helpline Card -->
                <div class="card p-4 border-0 shadow-sm rounded-4 mb-4 bg-navy text-white">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center p-2" style="width:48px; height:48px;">
                            <i class="fas fa-headset fa-lg"></i>
                        </div>
                        <div>
                            <h4 class="h6 fw-bold text-warning mb-0">Admission Helpdesk</h4>
                            <small class="text-white-50">Direct Counselor Support</small>
                        </div>
                    </div>

                    <div class="p-3 bg-white bg-opacity-10 rounded-3 mb-3 small">
                        <div class="mb-2">
                            <i class="fas fa-phone-alt text-warning me-2"></i>
                            <strong>Toll-Free / Landline:</strong><br>
                            <span class="text-white-50 ps-4">0755-4700983, 0755-4700980</span>
                        </div>
                        <div class="mb-2">
                            <i class="fas fa-mobile-alt text-warning me-2"></i>
                            <strong>Direct Mobile Helpline:</strong><br>
                            <span class="text-white-50 ps-4">7024144981, 7024144982, 7024144983, 7024144984, 7024144986</span>
                        </div>
                        <div>
                            <i class="fas fa-envelope text-warning me-2"></i>
                            <strong>Official Email:</strong><br>
                            <span class="text-white-50 ps-4">info@srku.edu.in, admissions@srku.edu.in</span>
                        </div>
                    </div>

                    <div class="small text-white-50">
                        <i class="far fa-clock text-warning me-1"></i> <strong>Office Hours:</strong> Mon &ndash; Sat: 9:00 AM &ndash; 5:30 PM
                    </div>
                </div>

                <!-- Why Apply at SRKU Box -->
                <div class="card p-4 border-0 shadow-sm rounded-4 mb-4 bg-white border">
                    <h4 class="h6 fw-bold text-navy mb-3"><i class="fas fa-star text-warning me-2"></i> Why Choose SRK University?</h4>
                    <ul class="list-unstyled small text-muted mb-0 d-flex flex-column gap-2">
                        <li class="d-flex align-items-start gap-2">
                            <i class="fas fa-check-circle text-success mt-1"></i>
                            <span><strong>30+ Years Legacy</strong> in professional, medical, technical &amp; legal education.</span>
                        </li>
                        <li class="d-flex align-items-start gap-2">
                            <i class="fas fa-check-circle text-success mt-1"></i>
                            <span><strong>26 Constituent Units</strong> with comprehensive multidisciplinary campus.</span>
                        </li>
                        <li class="d-flex align-items-start gap-2">
                            <i class="fas fa-check-circle text-success mt-1"></i>
                            <span><strong>750+ Bed Teaching Hospital</strong> for live clinical and healthcare internships.</span>
                        </li>
                        <li class="d-flex align-items-start gap-2">
                            <i class="fas fa-check-circle text-success mt-1"></i>
                            <span><strong>Central Placement Cell</strong> with 500+ corporate recruiters.</span>
                        </li>
                    </ul>
                </div>

                <!-- Download Official Admission Documents -->
                <div class="card p-4 border-0 shadow-sm rounded-4 bg-light border">
                    <h5 class="h6 fw-bold text-navy mb-2"><i class="fas fa-file-pdf text-danger me-2"></i> Admission &amp; Fee Documents</h5>
                    <p class="text-muted small mb-3">Download approved university fee schedules, scholarship criteria, and official prospectus:</p>
                    <div class="d-flex flex-column gap-2">
                        <a href="<?php echo BASE_URL; ?>document/fees-2026-27" class="btn btn-sm btn-success fw-semibold d-flex align-items-center justify-content-between p-2 px-3">
                            <span><i class="fas fa-file-invoice-dollar me-2"></i> Fee Structure 2026-27</span>
                            <i class="fas fa-external-link-alt small"></i>
                        </a>
                        <a href="<?php echo BASE_URL; ?>document/meritorious-scheme-policy" class="btn btn-sm btn-outline-warning text-dark fw-semibold d-flex align-items-center justify-content-between p-2 px-3 bg-white">
                            <span><i class="fas fa-award text-warning me-2"></i> Meritorious Scholarship Policy</span>
                            <i class="fas fa-external-link-alt small"></i>
                        </a>
                        <a href="<?php echo BASE_URL; ?>document/inhouse-scheme-policy" class="btn btn-sm btn-outline-primary fw-semibold d-flex align-items-center justify-content-between p-2 px-3 bg-white">
                            <span><i class="fas fa-hand-holding-usd text-primary me-2"></i> In-House Scheme Policy</span>
                            <i class="fas fa-external-link-alt small"></i>
                        </a>
                        <a href="<?php echo BASE_URL; ?>document/prospectus" class="btn btn-sm btn-outline-danger fw-semibold d-flex align-items-center justify-content-between p-2 px-3 bg-white">
                            <span><i class="fas fa-book-open text-danger me-2"></i> University Prospectus</span>
                            <i class="fas fa-external-link-alt small"></i>
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
