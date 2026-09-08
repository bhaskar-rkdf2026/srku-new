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

// Group departments by academic category
$deptsByCategory = [];
foreach ($allDepartments as $d) {
    $cat = $d['category'] ?: 'Constituent Institutes';
    if (!isset($deptsByCategory[$cat])) {
        $deptsByCategory[$cat] = [];
    }
    $deptsByCategory[$cat][] = $d;
}

// Build map of dept slug -> courses
$deptCoursesMap = [];
foreach ($allDepartments as $d) {
    $deptCoursesMap[$d['slug']] = [];
}
foreach ($allCourses as $c) {
    $s = $c['dept_slug'] ?? '';
    if (isset($deptCoursesMap[$s])) {
        $deptCoursesMap[$s][] = [
            'name' => $c['course_name'],
            'level' => $c['level'] ?? '',
            'duration' => $c['duration'] ?? '',
        ];
    } else {
        foreach ($allDepartments as $d) {
            if ($d['name'] === ($c['department'] ?? '')) {
                $deptCoursesMap[$d['slug']][] = [
                    'name' => $c['course_name'],
                    'level' => $c['level'] ?? '',
                    'duration' => $c['duration'] ?? '',
                ];
                break;
            }
        }
    }
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
                                    <input type="text" id="admissionName" name="name" class="srku-input" placeholder="Enter candidate's full name" value="<?php echo $enquirySuccess ? '' : sanitize($_POST['name'] ?? ''); ?>" minlength="2" maxlength="80" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="srku-label" for="admissionFatherName">Father's / Guardian's Name</label>
                                <div class="srku-input-wrap">
                                    <i class="fas fa-user-tie srku-field-icon"></i>
                                    <input type="text" id="admissionFatherName" name="father_name" class="srku-input" placeholder="Enter father's / guardian's name" value="<?php echo $enquirySuccess ? '' : sanitize($_POST['father_name'] ?? ''); ?>" maxlength="80">
                                </div>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="srku-label" for="admissionPhone">Mobile Number (WhatsApp) <span class="req-star">*</span></label>
                                <div class="srku-input-wrap">
                                    <span class="srku-phone-prefix">+91</span>
                                    <input type="tel" id="admissionPhone" name="phone" class="srku-input srku-phone-input" placeholder="10-digit mobile number" value="<?php echo $enquirySuccess ? '' : sanitize($_POST['phone'] ?? ''); ?>" pattern="[0-9]{10}" maxlength="10" title="Please enter a valid 10-digit mobile number" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="srku-label" for="admissionEmail">Email Address <span class="req-star">*</span></label>
                                <div class="srku-input-wrap">
                                    <i class="fas fa-envelope srku-field-icon"></i>
                                    <input type="email" id="admissionEmail" name="email" class="srku-input" placeholder="yourname@gmail.com" value="<?php echo $enquirySuccess ? '' : sanitize($_POST['email'] ?? ''); ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="srku-label" for="admissionCollege">Select College / Department <span class="req-star">*</span></label>
                                <div class="srku-input-wrap">
                                    <i class="fas fa-university srku-field-icon"></i>
                                    <div class="srku-dd-wrap" id="admCollegeDDWrap">
                                        <button type="button" class="srku-dd-trigger" id="admCollegeTrigger" aria-haspopup="listbox" aria-expanded="false">
                                            <span class="srku-dd-label srku-dd-placeholder">Select College / Department</span>
                                            <svg class="srku-dd-chevron" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                                        </button>
                                        <div class="srku-dd-panel" id="admCollegePanel">
                                            <div class="srku-dd-search-wrap">
                                                <i class="fas fa-search srku-dd-search-icon"></i>
                                                <input type="text" class="srku-dd-search" id="admCollegeSearch" placeholder="Search college or department..." autocomplete="off">
                                            </div>
                                            <div class="srku-dd-list" id="admCollegeList">
                                                <?php foreach ($deptsByCategory as $catName => $catDepts): ?>
                                                    <div class="srku-dd-group"><?php echo sanitize($catName); ?></div>
                                                    <?php foreach ($catDepts as $dept): ?>
                                                        <div class="srku-dd-option"
                                                             data-value="<?php echo sanitize($dept['name']); ?>"
                                                             data-slug="<?php echo sanitize($dept['slug']); ?>"
                                                             <?php echo (($postedCollege === $dept['name'] || $postedCollege === $dept['slug']) ? 'data-preselected="1"' : ''); ?>>
                                                            <?php echo sanitize($dept['name']); ?>
                                                        </div>
                                                    <?php endforeach; ?>
                                                <?php endforeach; ?>
                                                <div class="srku-dd-empty">No results found</div>
                                            </div>
                                        </div>
                                        <select name="college" id="admissionCollege" class="srku-dd-native" required>
                                            <option value="">-- Choose College / Constituent Unit --</option>
                                            <?php foreach ($deptsByCategory as $catName => $catDepts): ?>
                                                <?php foreach ($catDepts as $dept): ?>
                                                    <option value="<?php echo sanitize($dept['name']); ?>"
                                                            data-slug="<?php echo sanitize($dept['slug']); ?>"
                                                            <?php echo (($postedCollege === $dept['name'] || $postedCollege === $dept['slug']) ? 'selected' : ''); ?>>
                                                        <?php echo sanitize($dept['name']); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="srku-label" for="admissionCourse">Select Program / Course of Interest <span class="req-star">*</span></label>
                                <div class="srku-input-wrap">
                                    <i class="fas fa-graduation-cap srku-field-icon"></i>
                                    <div class="srku-dd-wrap" id="admCourseDDWrap">
                                        <button type="button" class="srku-dd-trigger" id="admCourseTrigger" aria-haspopup="listbox" aria-expanded="false">
                                            <span class="srku-dd-label srku-dd-placeholder">Select Course / Programme</span>
                                            <svg class="srku-dd-chevron" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                                        </button>
                                        <div class="srku-dd-panel" id="admCoursePanel">
                                            <div class="srku-dd-search-wrap">
                                                <i class="fas fa-search srku-dd-search-icon"></i>
                                                <input type="text" class="srku-dd-search" id="admCourseSearch" placeholder="Search course or programme..." autocomplete="off">
                                            </div>
                                            <div class="srku-dd-list" id="admCourseList">
                                                <div class="srku-dd-empty visible">Please select a college first to see available courses</div>
                                            </div>
                                        </div>
                                        <select name="course" id="admissionCourse" class="srku-dd-native" required>
                                            <option value="">-- Please Choose a College First --</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="srku-label" for="admissionCity">City / District</label>
                                <div class="srku-input-wrap">
                                    <i class="fas fa-map-marker-alt srku-field-icon"></i>
                                    <input type="text" id="admissionCity" name="city" class="srku-input" placeholder="e.g. Bhopal, Indore, Patna, etc." value="<?php echo $enquirySuccess ? '' : sanitize($_POST['city'] ?? ''); ?>" maxlength="100">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="srku-label" for="admissionState">State</label>
                                <div class="srku-input-wrap">
                                    <i class="fas fa-globe-asia srku-field-icon"></i>
                                    <input type="text" id="admissionState" name="state" class="srku-input" placeholder="e.g. Madhya Pradesh, Bihar, UP" value="<?php echo $enquirySuccess ? '' : sanitize($_POST['state'] ?? ''); ?>" maxlength="100">
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

                        const deptCoursesMap = <?php echo json_encode($deptCoursesMap, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
                        const preselectedCourse = <?php echo json_encode($selectedCourseParam ?? ''); ?>;
                        const levelLabels = {
                            'UG': 'Undergraduate Programmes (UG)',
                            'PG': 'Postgraduate Programmes (PG)',
                            'Diploma': 'Diploma & Certificate Programmes',
                            'Doctorate': 'Doctoral (Ph.D.) Research'
                        };
                        const levelsOrder = ['UG', 'PG', 'Diploma', 'Doctorate'];

                        function initDropdown(cfg) {
                            const trigger = document.getElementById(cfg.triggerId);
                            const panel   = document.getElementById(cfg.panelId);
                            const search  = document.getElementById(cfg.searchId);
                            const list    = document.getElementById(cfg.listId);
                            const native  = document.getElementById(cfg.nativeId);
                            if (!trigger || !panel || !list || !native) return;

                            let isOpen = false;
                            function getLabelEl() { return trigger.querySelector('.srku-dd-label'); }
                            function getEmptyEl() { return list.querySelector('.srku-dd-empty'); }

                            function open() {
                                isOpen = true;
                                trigger.classList.add('open'); panel.classList.add('open');
                                trigger.setAttribute('aria-expanded', 'true');
                                if (search) { search.value = ''; filterOptions(''); search.focus(); }
                            }
                            function close() {
                                isOpen = false;
                                trigger.classList.remove('open'); panel.classList.remove('open');
                                trigger.setAttribute('aria-expanded', 'false');
                            }

                            trigger.addEventListener('click', function(e) { e.stopPropagation(); isOpen ? close() : open(); });
                            document.addEventListener('click', function(e) { if (!trigger.contains(e.target) && !panel.contains(e.target)) close(); });

                            if (search) {
                                search.addEventListener('input', function() { filterOptions(this.value.trim()); });
                                search.addEventListener('click', function(e) { e.stopPropagation(); });
                            }

                            function filterOptions(query) {
                                const q = query.toLowerCase();
                                const opts = list.querySelectorAll('.srku-dd-option');
                                const grps = list.querySelectorAll('.srku-dd-group');
                                let anyVisible = false;
                                opts.forEach(function(opt) {
                                    const match = !q || opt.textContent.toLowerCase().includes(q);
                                    opt.classList.toggle('hidden', !match);
                                    if (match) anyVisible = true;
                                });
                                grps.forEach(function(grp) {
                                    let sib = grp.nextElementSibling, hasVis = false;
                                    while (sib && !sib.classList.contains('srku-dd-group') && !sib.classList.contains('srku-dd-empty')) {
                                        if (!sib.classList.contains('hidden')) hasVis = true;
                                        sib = sib.nextElementSibling;
                                    }
                                    grp.classList.toggle('hidden', !hasVis);
                                });
                                const em = getEmptyEl(); if (em) em.classList.toggle('visible', !anyVisible);
                            }

                            list.addEventListener('click', function(e) {
                                const opt = e.target.closest('.srku-dd-option'); if (!opt) return;
                                selectOption(opt.dataset.value, opt.dataset.slug || '', opt.textContent.trim());
                                close();
                                if (cfg.onChange) cfg.onChange(opt.dataset.value, opt.dataset.slug || '');
                            });

                            function selectOption(value, slug, label) {
                                getLabelEl().textContent = label;
                                getLabelEl().classList.remove('srku-dd-placeholder');
                                trigger.classList.add('has-value');
                                list.querySelectorAll('.srku-dd-option').forEach(function(o) { o.classList.toggle('selected', o.dataset.value === value); });
                                native.value = value;
                                native.dispatchEvent(new Event('change', { bubbles: true }));
                            }

                            cfg._selectOption = selectOption;
                            cfg._rebuildList = rebuildList;

                            function rebuildList(groups, restoreValue) {
                                list.innerHTML = '';
                                let hasOptions = false;
                                groups.forEach(function(g) {
                                    if (g.label) { const el = document.createElement('div'); el.className = 'srku-dd-group'; el.textContent = g.label; list.appendChild(el); }
                                    g.options.forEach(function(o) {
                                        const el = document.createElement('div'); el.className = 'srku-dd-option';
                                        el.dataset.value = o.value; if (o.slug) el.dataset.slug = o.slug;
                                        el.textContent = o.text; list.appendChild(el); hasOptions = true;
                                    });
                                });
                                const emEl = document.createElement('div'); emEl.className = 'srku-dd-empty';
                                if (!hasOptions) emEl.classList.add('visible'); list.appendChild(emEl);

                                if (restoreValue) {
                                    const matchEl = Array.from(list.querySelectorAll('.srku-dd-option')).find(function(el) { return el.dataset.value.toLowerCase() === restoreValue.toLowerCase(); });
                                    if (matchEl) selectOption(matchEl.dataset.value, matchEl.dataset.slug || '', matchEl.textContent.trim());
                                } else {
                                    getLabelEl().textContent = cfg.placeholder || '-- Select --';
                                    getLabelEl().classList.add('srku-dd-placeholder');
                                    trigger.classList.remove('has-value');
                                }
                                while (native.options.length > 1) native.remove(1);
                                groups.forEach(function(g) { g.options.forEach(function(o) { const n = document.createElement('option'); n.value = o.value; n.textContent = o.text; native.appendChild(n); }); });
                                if (restoreValue) native.value = restoreValue;
                            }
                            return cfg;
                        }

                        const collegeCfg = initDropdown({
                            triggerId: 'admCollegeTrigger', panelId: 'admCollegePanel',
                            searchId: 'admCollegeSearch', listId: 'admCollegeList',
                            nativeId: 'admissionCollege',
                            placeholder: '-- Choose College / Constituent Unit --',
                            onChange: function(value, slug) { populateCourses(slug, ''); }
                        });

                        const courseCfg = initDropdown({
                            triggerId: 'admCourseTrigger', panelId: 'admCoursePanel',
                            searchId: 'admCourseSearch', listId: 'admCourseList',
                            nativeId: 'admissionCourse',
                            placeholder: '-- Please Choose a College First --'
                        });

                        function populateCourses(slug, restoreCourse) {
                            const lbl = document.querySelector('#admCourseTrigger .srku-dd-label');
                            if (!slug || !deptCoursesMap[slug] || deptCoursesMap[slug].length === 0) {
                                if (courseCfg && courseCfg._rebuildList) {
                                    const opts = (!slug || !deptCoursesMap[slug]) ? [] : [{ value: 'General Admission Enquiry', text: 'General Admission Enquiry' }];
                                    courseCfg._rebuildList([{ label: '', options: opts }], restoreCourse);
                                    if (lbl && !opts.length) {
                                        lbl.textContent = 'Select Course / Programme';
                                        lbl.classList.add('srku-dd-placeholder');
                                    }
                                }
                                return;
                            }
                            const courses = deptCoursesMap[slug];
                            const grouped = {};
                            courses.forEach(function(c) { const l = c.level || 'Other'; if (!grouped[l]) grouped[l] = []; grouped[l].push(c); });
                            const sortedLevels = [...levelsOrder.filter(function(l) { return grouped[l]; }), ...Object.keys(grouped).filter(function(l) { return !levelsOrder.includes(l); })];
                            const groups = sortedLevels.map(function(lvl) {
                                return { label: levelLabels[lvl] || lvl, options: grouped[lvl].map(function(c) { return { value: c.name, text: c.name + (c.duration ? ' (' + c.duration + ')' : '') }; }) };
                            });
                            if (courseCfg && courseCfg._rebuildList) {
                                courseCfg._rebuildList(groups, restoreCourse);
                                if (lbl && !restoreCourse) {
                                    lbl.textContent = 'Choose Course (' + courses.length + ' Available)';
                                    lbl.classList.remove('srku-dd-placeholder');
                                }
                            }
                        }

                        // Restore postback
                        (function() {
                            const list = document.getElementById('admCollegeList');
                            const trig = document.getElementById('admCollegeTrigger');
                            if (!list || !trig) return;
                            const pre = list.querySelector('.srku-dd-option[data-preselected="1"]');
                            if (pre) {
                                const lbl = trig.querySelector('.srku-dd-label');
                                if (lbl) lbl.textContent = pre.textContent.trim();
                                trig.classList.add('has-value');
                                pre.classList.add('selected');
                                const nat = document.getElementById('admissionCollege');
                                if (nat) nat.value = pre.dataset.value;
                                populateCourses(pre.dataset.slug || '', preselectedCourse);
                            }
                        })();

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

                <!-- Download Brochure & Prospectus -->
                <div class="card p-4 border-0 shadow-sm rounded-4 bg-light border">
                    <h5 class="h6 fw-bold text-navy mb-2"><i class="fas fa-file-pdf text-danger me-2"></i> Official Prospectus</h5>
                    <p class="text-muted small mb-3">Download the comprehensive university academic brochure and admission guidelines.</p>
                    <a href="<?php echo BASE_URL; ?>assets/uploads/2026/07/Prospectus.pdf" target="_blank" class="btn btn-sm btn-outline-danger fw-semibold d-flex align-items-center justify-content-center gap-1">
                        <i class="fas fa-download"></i> <span>Download Prospectus (PDF)</span>
                    </a>
                </div>

            </div>

        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
