<?php
/**
 * Dynamic Header Navigation Menu Renderer
 * Renders main navigation tabs dynamically based on admin drag & drop configuration
 */

function renderHeaderNavigationMenu($activeNav = '') {
    $mainNavItems = getMainNavigationMenu();
    foreach ($mainNavItems as $mItem) {
        $mPreset = $mItem['preset'] ?? '';
        $mLabel = $mItem['label'] ?? '';
        $mUrl = $mItem['url'] ?? '';
        if ($mUrl !== '' && strpos($mUrl, 'http') !== 0 && strpos($mUrl, '#') !== 0 && strpos($mUrl, 'javascript:') !== 0) {
            $mUrl = BASE_URL . ltrim($mUrl, '/');
        } elseif ($mUrl === '') {
            $mUrl = BASE_URL;
        }
        $mTarget = !empty($mItem['target']) ? $mItem['target'] : '_self';
        $mBadge = $mItem['badge'] ?? '';
        $mSubItems = $mItem['items'] ?? [];

        switch ($mPreset) {
            case 'home':
                $isActive = (!isset($activeNav) || empty($activeNav) || $activeNav === 'home') ? 'active' : '';
                ?>
                <!-- 1. Home -->
                <li class="static-menu-item <?php echo $isActive; ?>">
                    <a href="<?php echo sanitize($mUrl); ?>" target="<?php echo sanitize($mTarget); ?>" class="static-menu-link">
                        <?php echo sanitize($mLabel); ?>
                        <?php if ($mBadge): ?><span class="badge bg-danger ms-1"><?php echo sanitize($mBadge); ?></span><?php endif; ?>
                    </a>
                </li>
                <?php
                break;

            case 'about':
                $isActive = (isset($activeNav) && in_array($activeNav, ['about', 'about-hei'])) ? 'active' : '';
                ?>
                <!-- 2. About H.E.I. -->
                <li class="static-menu-item <?php echo $isActive; ?>">
                    <a href="<?php echo sanitize($mUrl); ?>" target="<?php echo sanitize($mTarget); ?>" class="static-menu-link">
                        <?php echo sanitize($mLabel); ?> <span class="static-dropdown-arrow"></span>
                        <?php if ($mBadge): ?><span class="badge bg-danger ms-1"><?php echo sanitize($mBadge); ?></span><?php endif; ?>
                    </a>
                    <ul class="static-dropdown-panel">
                        <!-- About Srk University (With Level-3 Submenu) -->
                        <li class="static-dropdown-item">
                            <a href="<?php echo BASE_URL; ?>about.php" class="static-dropdown-link fw-semibold text-danger">
                                <i class="fas fa-university text-danger me-1"></i> About Srk University <span class="static-dropdown-arrow static-sub-arrow"></span>
                            </a>
                            <ul class="static-dropdown-panel static-sub-dropdown">
                                <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>about.php" class="static-dropdown-link"><i class="fas fa-info-circle me-1 text-primary"></i> University Overview</a></li>
                                <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/act-statutes" class="static-dropdown-link"><i class="fas fa-balance-scale text-danger me-1"></i> Act &amp; Statutes</a></li>
                                <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/institutional-development-plan" class="static-dropdown-link"><i class="fas fa-chart-line text-success me-1"></i> Institutional Development Plan</a></li>
                                <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/constituent-units" class="static-dropdown-link"><i class="fas fa-sitemap text-primary me-1"></i> Constituent Units</a></li>
                                <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/accreditation-ranking" class="static-dropdown-link"><i class="fas fa-award text-warning me-1"></i> Accreditation &amp; Ranking</a></li>
                                <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/recognition-approval" class="static-dropdown-link"><i class="fas fa-stamp text-info me-1"></i> Recognition Approval</a></li>
                                <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/annual-report" class="static-dropdown-link"><i class="fas fa-file-invoice text-secondary me-1"></i> Annual Report 2024-25</a></li>
                                <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/details-of-sponsoring-body" class="static-dropdown-link"><i class="fas fa-hand-holding-heart text-danger me-1"></i> Details of Sponsoring Body</a></li>
                            </ul>
                        </li>

                        <!-- All Committee (With Level-3 Submenu) -->
                        <li class="static-dropdown-item">
                            <a href="#" class="static-dropdown-link fw-semibold text-danger">
                                <i class="fas fa-users-cog text-warning me-1"></i> All Committee <span class="static-dropdown-arrow static-sub-arrow"></span>
                            </a>
                            <ul class="static-dropdown-panel static-sub-dropdown">
                                <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/board-of-management" class="static-dropdown-link fw-semibold text-navy"><i class="fas fa-landmark text-primary me-1"></i> Board of Management</a></li>
                                <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/student-grievance-committee" class="static-dropdown-link"><i class="fas fa-user-shield text-primary me-1"></i> Student Grievance Committee</a></li>
                                <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/internal-complaint-committee" class="static-dropdown-link"><i class="fas fa-shield-alt text-danger me-1"></i> Internal Complaint Committee (ICC)</a></li>
                                <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/anti-ragging" class="static-dropdown-link"><i class="fas fa-ban text-danger me-1"></i> Anti Ragging Committee &amp; Squad</a></li>
                                <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/obc-minority" class="static-dropdown-link"><i class="fas fa-users text-info me-1"></i> OBC &amp; Minority Committee</a></li>
                                <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/women-grievance-committee" class="static-dropdown-link"><i class="fas fa-female text-danger me-1"></i> Women Grievance Committee</a></li>
                                <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/sc-st-grievance-committee" class="static-dropdown-link"><i class="fas fa-hands-helping text-warning me-1"></i> SC &amp; ST Committee</a></li>
                                <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/equal-opportunity-cell" class="static-dropdown-link"><i class="fas fa-universal-access text-success me-1"></i> Equal Opportunity Cell</a></li>
                                <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/sedg-cell" class="static-dropdown-link"><i class="fas fa-hand-holding-heart text-info me-1"></i> SEDG Cell</a></li>
                                <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/ombudsman" class="static-dropdown-link"><i class="fas fa-gavel text-warning me-1"></i> Ombudsman</a></li>
                                <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/alumni-committee" class="static-dropdown-link"><i class="fas fa-user-friends text-primary me-1"></i> Alumni Committee</a></li>
                                <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/constitution-of-research-advisory-committee" class="static-dropdown-link"><i class="fas fa-microscope text-success me-1"></i> Research Advisory Committee</a></li>
                            </ul>
                        </li>

                        <!-- Authority Of University (With Level-3 Submenu) -->
                        <li class="static-dropdown-item">
                            <a href="#" class="static-dropdown-link">
                                <i class="fas fa-landmark text-danger me-1"></i> Authority Of University <span class="static-dropdown-arrow static-sub-arrow"></span>
                            </a>
                            <ul class="static-dropdown-panel static-sub-dropdown">
                                <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/governing-body" class="static-dropdown-link"><i class="fas fa-crown text-warning me-1"></i> Governing Body</a></li>
                                <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/finance-committee" class="static-dropdown-link"><i class="fas fa-coins text-success me-1"></i> Finance Committee</a></li>
                                <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/academic-councils" class="static-dropdown-link"><i class="fas fa-graduation-cap text-danger me-1"></i> Academic Councils</a></li>
                                <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/board-of-studies" class="static-dropdown-link"><i class="fas fa-book-reader text-info me-1"></i> Board Of Studies</a></li>
                            </ul>
                        </li>

                        <!-- University Policies (Level-3 Submenu) -->
                        <li class="static-dropdown-item">
                            <a href="#" class="static-dropdown-link fw-semibold text-danger">
                                <i class="fas fa-file-contract text-danger me-1"></i> Institutional Policies <span class="static-dropdown-arrow static-sub-arrow"></span>
                            </a>
                            <ul class="static-dropdown-panel static-sub-dropdown">
                                <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/welfare-policy" class="static-dropdown-link"><i class="fas fa-heart text-danger me-1"></i> Welfare Policy</a></li>
                                <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/university-research-policy" class="static-dropdown-link"><i class="fas fa-microscope text-primary me-1"></i> University Research Policy</a></li>
                                <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/sports-and-cultural-policy" class="static-dropdown-link"><i class="fas fa-running text-success me-1"></i> Sports &amp; Cultural Policy</a></li>
                                <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/policy-for-consultancy" class="static-dropdown-link"><i class="fas fa-handshake text-warning me-1"></i> Policy for Consultancy</a></li>
                                <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/meritorious-scheme-policy" class="static-dropdown-link"><i class="fas fa-award text-warning me-1"></i> Meritorious Scheme Policy</a></li>
                                <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/inhouse-scheme-policy" class="static-dropdown-link"><i class="fas fa-hand-holding-usd text-info me-1"></i> Inhouse Scheme Policy</a></li>
                                <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/clean-green-campus-policy" class="static-dropdown-link"><i class="fas fa-leaf text-success me-1"></i> Clean &amp; Green Campus Policy</a></li>
                                <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/plastic-ban-policy" class="static-dropdown-link"><i class="fas fa-ban text-danger me-1"></i> Plastic Ban Policy</a></li>
                                <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/differently-abled-facilities" class="static-dropdown-link"><i class="fas fa-wheelchair text-primary me-1"></i> Barrier Free &amp; Disabled Friendly</a></li>
                                <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/it-policy" class="static-dropdown-link"><i class="fas fa-laptop-code text-info me-1"></i> IT &amp; Cyber Security Policy</a></li>
                                <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/hr-policy" class="static-dropdown-link"><i class="fas fa-user-tie text-warning me-1"></i> Human Resource (HR) Policy</a></li>
                                <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/maintenance-policy" class="static-dropdown-link"><i class="fas fa-tools text-secondary me-1"></i> Campus Maintenance Policy</a></li>
                                <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/performance-appraisal-policy" class="static-dropdown-link"><i class="fas fa-chart-line text-success me-1"></i> Performance Appraisal Policy</a></li>
                            </ul>
                        </li>

                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/officers-of-university" class="static-dropdown-link"><i class="fas fa-users-cog text-primary me-1"></i> Officers of University</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/academic-leadership" class="static-dropdown-link"><i class="fas fa-user-tie text-navy me-1"></i> Academic Leadership</a></li>

                        <!-- AICTE Approvals 2026-27 (With Level-3 Submenu) -->
                        <li class="static-dropdown-item">
                            <a href="<?php echo BASE_URL; ?>document/council-of-technical-education" class="static-dropdown-link">
                                <i class="fas fa-cogs text-primary me-1"></i> AICTE Approvals 2026-27 <span class="static-dropdown-arrow static-sub-arrow"></span>
                            </a>
                            <ul class="static-dropdown-panel static-sub-dropdown">
                                <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/aicte-approval-rkdfibm" class="static-dropdown-link"><i class="fas fa-file-pdf text-danger me-1"></i> RKDFIBM</a></li>
                                <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/aicte-approval-rkdfim" class="static-dropdown-link"><i class="fas fa-file-pdf text-danger me-1"></i> RKDFIM</a></li>
                                <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/aicte-approval-rkdfist" class="static-dropdown-link"><i class="fas fa-file-pdf text-danger me-1"></i> RKDFIST</a></li>
                                <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/aicte-approval-rkdfist-mca" class="static-dropdown-link"><i class="fas fa-file-pdf text-danger me-1"></i> RKDFIST(MCA)</a></li>
                            </ul>
                        </li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>about/srk-university-vision-and-mission" class="static-dropdown-link"><i class="fas fa-bullseye text-danger me-1"></i> Vision &amp; Mission</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>facilities" class="static-dropdown-link"><i class="fas fa-building text-info me-1"></i> FACILITIES</a></li>

                        <!-- University Ordinance (With Level-3 Submenu) -->
                        <li class="static-dropdown-item">
                            <a href="#" class="static-dropdown-link">
                                <i class="fas fa-scroll text-warning me-1"></i> University Ordinance <span class="static-dropdown-arrow static-sub-arrow"></span>
                            </a>
                            <ul class="static-dropdown-panel static-sub-dropdown">
                                <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/university-ordinance" class="static-dropdown-link"><i class="fas fa-book text-danger me-1"></i> Ordinance 1 to 92</a></li>
                                <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/ordinance-93-100" class="static-dropdown-link"><i class="fas fa-bookmark text-primary me-1"></i> Subsequent Ordinance 93-100</a></li>
                            </ul>
                        </li>

                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/ugc-information" class="static-dropdown-link"><i class="fas fa-certificate text-success me-1"></i> UGC Information</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>founder-story.php" class="static-dropdown-link fw-semibold text-danger"><i class="fas fa-feather-alt text-warning me-1"></i> Founder's Story &amp; Vision</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>chancellor-message.php" class="static-dropdown-link fw-semibold text-danger"><i class="fas fa-crown text-warning me-1"></i> Chancellor's Message</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>vice-chancellor-message.php" class="static-dropdown-link fw-semibold text-navy"><i class="fas fa-user-tie text-primary me-1"></i> Vice Chancellor's Message</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>gallery.php" class="static-dropdown-link fw-semibold text-danger"><i class="fas fa-camera-retro text-danger me-1"></i> Picture Gallery</a></li>
                    </ul>
                </li>
                <?php
                break;

            case 'syllabus':
                $isActive = (isset($activeNav) && in_array($activeNav, ['courses', 'syllabus'])) ? 'active' : '';
                ?>
                <!-- 3. Syllabus & Courses -->
                <li class="static-menu-item static-menu-item-syllabus <?php echo $isActive; ?>">
                    <a href="<?php echo sanitize($mUrl); ?>" target="<?php echo sanitize($mTarget); ?>" class="static-menu-link">
                        <?php echo sanitize($mLabel); ?> <span class="static-dropdown-arrow"></span>
                        <?php if ($mBadge): ?><span class="badge bg-danger ms-1"><?php echo sanitize($mBadge); ?></span><?php endif; ?>
                    </a>
                    <div class="static-dropdown-panel syllabus-megamenu-panel shadow-lg">
                        <div class="d-flex align-items-center justify-content-between pb-2 mb-2 border-bottom px-2">
                            <a href="<?php echo BASE_URL; ?>courses" class="fw-bold text-navy text-decoration-none d-flex align-items-center gap-2" style="font-size: 13px;">
                                <i class="fas fa-graduation-cap text-primary"></i> All Academic Courses (90+ Degrees)
                            </a>
                            <a href="<?php echo BASE_URL; ?>syllabus" class="small fw-bold text-danger text-decoration-none" style="font-size: 11.5px;">
                                <i class="fas fa-file-pdf me-1"></i> View All Syllabus / Scheme &rarr;
                            </a>
                        </div>
                        <div class="px-2 pb-1 mb-1 d-flex align-items-center justify-content-between text-muted" style="font-size: 11px; letter-spacing: .5px; text-transform: uppercase; font-weight: 700;">
                            <span><i class="fas fa-book-open text-danger me-1"></i> Course Schemes &amp; Syllabus:</span>
                        </div>
                        <div class="syllabus-grid">
                            <a title="BA LLB (HONS.)" href="<?php echo BASE_URL; ?>syllabus?course=ba-llb" class="static-dropdown-link"><i class="fas fa-gavel text-danger me-1"></i> BA LLB (HONS.)</a>
                            <a title="BJMC Syllabus &amp; Scheme" href="<?php echo BASE_URL; ?>syllabus?course=bjmc" class="static-dropdown-link"><i class="fas fa-newspaper text-danger me-1"></i> BJMC Syllabus &amp; Scheme</a>
                            <a title="LLB." href="<?php echo BASE_URL; ?>syllabus?course=llb" class="static-dropdown-link"><i class="fas fa-balance-scale text-danger me-1"></i> LLB.</a>
                            <a title="LLM" href="<?php echo BASE_URL; ?>syllabus?course=llm" class="static-dropdown-link"><i class="fas fa-graduation-cap text-danger me-1"></i> LLM</a>
                            <a title="B.pharmacy" href="<?php echo BASE_URL; ?>syllabus?course=b-pharmacy" class="static-dropdown-link"><i class="fas fa-pills text-danger me-1"></i> B.pharmacy</a>
                            <a title="D.Pharmacy" href="<?php echo BASE_URL; ?>syllabus?course=d-pharmacy" class="static-dropdown-link"><i class="fas fa-capsules text-danger me-1"></i> D.Pharmacy</a>
                            <a title="M.Pharma" href="<?php echo BASE_URL; ?>syllabus?course=m-pharma" class="static-dropdown-link"><i class="fas fa-prescription text-danger me-1"></i> M.Pharma</a>
                            <a title="Nursing" href="<?php echo BASE_URL; ?>syllabus?course=nursing" class="static-dropdown-link"><i class="fas fa-user-nurse text-danger me-1"></i> Nursing</a>
                            <a title="Polytechnic Engineering" href="<?php echo BASE_URL; ?>syllabus?course=polytechnic-engineering" class="static-dropdown-link"><i class="fas fa-tools text-danger me-1"></i> Polytechnic Engineering</a>
                            <a title="Agriculture Courses" href="<?php echo BASE_URL; ?>syllabus?course=agriculture-courses" class="static-dropdown-link"><i class="fas fa-seedling text-danger me-1"></i> Agriculture Courses</a>
                            <a title="Paramedical" href="<?php echo BASE_URL; ?>syllabus?course=paramedical" class="static-dropdown-link"><i class="fas fa-stethoscope text-danger me-1"></i> Paramedical</a>
                            <a title="B.E. / B.Tech" href="<?php echo BASE_URL; ?>syllabus?course=be-btech" class="static-dropdown-link"><i class="fas fa-laptop-code text-danger me-1"></i> B.E. / B.Tech</a>
                            <a title="M.Tech" href="<?php echo BASE_URL; ?>syllabus?course=m-tech" class="static-dropdown-link"><i class="fas fa-microchip text-danger me-1"></i> M.Tech</a>
                            <a title="MBA" href="<?php echo BASE_URL; ?>syllabus?course=mba" class="static-dropdown-link"><i class="fas fa-briefcase text-danger me-1"></i> MBA</a>
                            <a title="BCA" href="<?php echo BASE_URL; ?>syllabus?course=bca" class="static-dropdown-link"><i class="fas fa-desktop text-danger me-1"></i> BCA</a>
                            <a title="MCA" href="<?php echo BASE_URL; ?>syllabus?course=mca" class="static-dropdown-link"><i class="fas fa-network-wired text-danger me-1"></i> MCA</a>
                            <a title="Library Course" href="<?php echo BASE_URL; ?>syllabus?course=library-course" class="static-dropdown-link"><i class="fas fa-book-reader text-danger me-1"></i> Library Course</a>
                            <a title="Computer Science" href="<?php echo BASE_URL; ?>syllabus?course=computer-science" class="static-dropdown-link"><i class="fas fa-code text-danger me-1"></i> Computer Science</a>
                            <a title="Allied Courses" href="<?php echo BASE_URL; ?>syllabus?course=allied-courses" class="static-dropdown-link"><i class="fas fa-atom text-danger me-1"></i> Allied Courses</a>
                        </div>
                    </div>
                </li>
                <?php
                break;

            case 'academics':
                $isActive = (isset($activeNav) && $activeNav === 'academics') ? 'active' : '';
                ?>
                <!-- 4. Academics -->
                <li class="static-menu-item <?php echo $isActive; ?>">
                    <a href="<?php echo sanitize($mUrl); ?>" target="<?php echo sanitize($mTarget); ?>" class="static-menu-link">
                        <?php echo sanitize($mLabel); ?> <span class="static-dropdown-arrow"></span>
                        <?php if ($mBadge): ?><span class="badge bg-danger ms-1"><?php echo sanitize($mBadge); ?></span><?php endif; ?>
                    </a>
                    <ul class="static-dropdown-panel">
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>academic-calendar.php" class="static-dropdown-link fw-semibold text-danger"><i class="fas fa-calendar-alt text-warning me-1"></i> Academic Calendar 2026-27</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>exam-rules.php" class="static-dropdown-link fw-semibold text-navy"><i class="fas fa-clipboard-check text-primary me-1"></i> Examination Rules &amp; Ordinances</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/details-of-academic-programmes" class="static-dropdown-link"><i class="fas fa-th-list text-danger me-1"></i> Details of Academic Programmes</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/statutes-ordinances-academics-examination" class="static-dropdown-link"><i class="fas fa-scroll text-secondary me-1"></i> Statutes Ordinances</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/constituent-units-departments" class="static-dropdown-link"><i class="fas fa-sitemap text-success me-1"></i> School/ Department/ Centres</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/department-wise-faculty-details" class="static-dropdown-link"><i class="fas fa-chalkboard-teacher text-info me-1"></i> Faculty/ Staff Details</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/iqac" class="static-dropdown-link"><i class="fas fa-check-double text-warning me-1"></i> Internal Quality Assurance Cell</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/university-library" class="static-dropdown-link"><i class="fas fa-book-reader text-danger me-1"></i> Library</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>placements" class="static-dropdown-link"><i class="fas fa-briefcase text-success me-1"></i> Placements</a></li>
                    </ul>
                </li>
                <?php
                break;

            case 'admission':
                $isActive = (isset($activeNav) && in_array($activeNav, ['admission', 'admission-fee'])) ? 'active' : '';
                ?>
                <!-- 5. Admission & Fee -->
                <li class="static-menu-item <?php echo $isActive; ?>">
                    <a href="<?php echo sanitize($mUrl); ?>" target="<?php echo sanitize($mTarget); ?>" class="static-menu-link">
                        <?php echo sanitize($mLabel); ?> <span class="static-dropdown-arrow"></span>
                        <?php if ($mBadge): ?><span class="badge bg-danger ms-1"><?php echo sanitize($mBadge); ?></span><?php endif; ?>
                    </a>
                    <ul class="static-dropdown-panel">
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>admission-enquiry.php" class="static-dropdown-link fw-bold text-danger"><i class="fas fa-edit text-danger me-1"></i> Online Admission Form 2026-27</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/fees-2026-27" class="static-dropdown-link fw-bold text-success"><i class="fas fa-file-invoice-dollar text-success me-1"></i> Fee Structure 2026-27</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>phd-admission.php" class="static-dropdown-link fw-bold text-danger"><i class="fas fa-graduation-cap text-danger me-1"></i> Ph.D. Admission 2026</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>phd-application-form.php" class="static-dropdown-link"><i class="fas fa-file-signature text-primary me-1"></i> Ph.D. Application Form</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>phd-entrance-form.php" class="static-dropdown-link"><i class="fas fa-file-alt text-success me-1"></i> Ph.D. Entrance Exam Form</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/meritorious-scheme-policy" class="static-dropdown-link"><i class="fas fa-award text-warning me-1"></i> Meritorious Scheme &amp; Scholarship</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/inhouse-scheme-policy" class="static-dropdown-link"><i class="fas fa-hand-holding-usd text-info me-1"></i> In-House Scheme Policy</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/prospectus" class="static-dropdown-link"><i class="fas fa-book-open text-danger me-1"></i> Prospectus</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/admission-process-guidelines" class="static-dropdown-link"><i class="fas fa-tasks text-warning me-1"></i> Admission Process Guidelines</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/fee-refund-policy" class="static-dropdown-link"><i class="fas fa-receipt text-info me-1"></i> Fee Refund Policy</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>contact.php" class="static-dropdown-link"><i class="fas fa-globe-americas text-primary me-1"></i> International Students Admission</a></li>
                    </ul>
                </li>
                <?php
                break;

            case 'research':
                $isActive = (isset($activeNav) && $activeNav === 'research') ? 'active' : '';
                ?>
                <!-- 6. Research -->
                <li class="static-menu-item <?php echo $isActive; ?>">
                    <a href="<?php echo sanitize($mUrl); ?>" target="<?php echo sanitize($mTarget); ?>" class="static-menu-link">
                        <?php echo sanitize($mLabel); ?> <span class="static-dropdown-arrow"></span>
                        <?php if ($mBadge): ?><span class="badge bg-danger ms-1"><?php echo sanitize($mBadge); ?></span><?php endif; ?>
                    </a>
                    <ul class="static-dropdown-panel">
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/phd-admission-policy" class="static-dropdown-link fw-bold text-danger"><i class="fas fa-stamp text-danger me-1"></i> Admission Policy &amp; Guidelines for Ph.D.</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>incubation-center" class="static-dropdown-link"><i class="fas fa-lightbulb text-warning me-1"></i> Incubation Centre</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/university-research-policy" class="static-dropdown-link"><i class="fas fa-file-contract text-info me-1"></i> University Research Policy</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/seed-money-research-policy" class="static-dropdown-link"><i class="fas fa-seedling text-success me-1"></i> Seed Money Research Projects Policy</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/consultancy-projects" class="static-dropdown-link"><i class="fas fa-project-diagram text-primary me-1"></i> Policy for Consultancy &amp; Projects</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/central-facilities-research" class="static-dropdown-link"><i class="fas fa-atom text-success me-1"></i> Central Facilities for R&amp;D</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/ethics-board" class="static-dropdown-link"><i class="fas fa-balance-scale text-warning me-1"></i> Ethics Board to Maintain Research Integrity</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/research-development-cell" class="static-dropdown-link"><i class="fas fa-flask text-primary me-1"></i> Research &amp; Development Cell</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/phd-scholars-pursuing" class="static-dropdown-link"><i class="fas fa-user-graduate text-info me-1"></i> Ph.D. Scholars Currently Enrolled</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/phd-scholars-completed" class="static-dropdown-link"><i class="fas fa-award text-success me-1"></i> Ph.D. Awarded Scholars List</a></li>
                    </ul>
                </li>
                <?php
                break;

            case 'departments':
                $isActive = (isset($activeNav) && $activeNav === 'departments') ? 'active' : '';
                ?>
                <!-- 7. Departments & Constituent Units -->
                <li class="static-menu-item static-menu-item-departments <?php echo $isActive; ?>">
                    <a href="<?php echo sanitize($mUrl); ?>" target="<?php echo sanitize($mTarget); ?>" class="static-menu-link">
                        <?php echo sanitize($mLabel); ?> <span class="static-dropdown-arrow"></span>
                        <?php if ($mBadge): ?><span class="badge bg-danger ms-1"><?php echo sanitize($mBadge); ?></span><?php endif; ?>
                    </a>
                    <div class="static-dropdown-panel static-megamenu-panel shadow-lg">
                        <div class="static-megamenu-grid">
                            <!-- COL 1 -->
                            <div>
                                <div class="static-megamenu-col-title"><i class="fas fa-microchip"></i> Engg, IT &amp; Management</div>
                                <a href="<?php echo BASE_URL; ?>rkdf-institute-of-science-and-technology" class="static-megamenu-link"><span class="name">RKDF Inst. of Science &amp; Technology</span><span class="badge-yr">1995</span><i class="fas fa-angle-right"></i></a>
                                <a href="<?php echo BASE_URL; ?>rkdf-institute-science-technology-mca" class="static-megamenu-link"><span class="name">RKDF IST - MCA</span><span class="badge-yr">1999</span><i class="fas fa-angle-right"></i></a>
                                <a href="<?php echo BASE_URL; ?>faculty-of-computer-application" class="static-megamenu-link"><span class="name">Faculty of Computer Application</span><i class="fas fa-angle-right"></i></a>
                                <a href="<?php echo BASE_URL; ?>rkdf-institute-of-management" class="static-megamenu-link"><span class="name">RKDF Institute of Management</span><span class="badge-yr">2003</span><i class="fas fa-angle-right"></i></a>
                                <a href="<?php echo BASE_URL; ?>rkdf-institute-of-business-management" class="static-megamenu-link"><span class="name">RKDF Inst. of Business Management</span><span class="badge-yr">2006</span><i class="fas fa-angle-right"></i></a>
                                <a href="<?php echo BASE_URL; ?>faculty-of-management" class="static-megamenu-link"><span class="name">Faculty of Management</span><i class="fas fa-angle-right"></i></a>
                                <a href="<?php echo BASE_URL; ?>faculty-of-commerce" class="static-megamenu-link"><span class="name">Faculty of Commerce</span><i class="fas fa-angle-right"></i></a>
                            </div>
                            <!-- COL 2 -->
                            <div>
                                <div class="static-megamenu-col-title"><i class="fas fa-pills"></i> Pharmacy &amp; Nursing</div>
                                <a href="<?php echo BASE_URL; ?>rkdf-college-of-pharmacy" class="static-megamenu-link"><span class="name">RKDF College of Pharmacy</span><span class="badge-yr">2003</span><i class="fas fa-angle-right"></i></a>
                                <a href="<?php echo BASE_URL; ?>sri-sai-institute-of-pharmacy" class="static-megamenu-link"><span class="name">Sri Sai Institute of Pharmacy</span><span class="badge-yr">2007</span><i class="fas fa-angle-right"></i></a>
                                <a href="<?php echo BASE_URL; ?>faculty-of-pharmacy" class="static-megamenu-link"><span class="name">Faculty of Pharmacy</span><i class="fas fa-angle-right"></i></a>
                                <a href="<?php echo BASE_URL; ?>rkdf-college-of-nursing" class="static-megamenu-link"><span class="name">RKDF College of Nursing</span><span class="badge-yr">2004</span><i class="fas fa-angle-right"></i></a>
                                <a href="<?php echo BASE_URL; ?>sarvepalli-radhakrishnan-college-of-nursing" class="static-megamenu-link"><span class="name">SRK College of Nursing</span><span class="badge-yr">2018</span><i class="fas fa-angle-right"></i></a>
                                <a href="<?php echo BASE_URL; ?>faculty-of-nursing" class="static-megamenu-link"><span class="name">Faculty of Nursing</span><i class="fas fa-angle-right"></i></a>
                            </div>
                            <!-- COL 3 -->
                            <div>
                                <div class="static-megamenu-col-title"><i class="fas fa-hospital-user"></i> Medical, Dental &amp; AYUSH</div>
                                <a href="<?php echo BASE_URL; ?>rkdf-medical-college-hospital-and-research-centre" class="static-megamenu-link"><span class="name">RKDF Medical College &amp; Hospital</span><span class="badge-yr">2014</span><i class="fas fa-angle-right"></i></a>
                                <a href="<?php echo BASE_URL; ?>rkdf-dental-college-and-research-centre" class="static-megamenu-link"><span class="name">RKDF Dental College &amp; Hospital</span><span class="badge-yr">2003</span><i class="fas fa-angle-right"></i></a>
                                <a href="<?php echo BASE_URL; ?>rkdf-homoeopathic-medical-college-and-hospital" class="static-megamenu-link"><span class="name">RKDF Homoeopathic Medical College</span><span class="badge-yr">2002</span><i class="fas fa-angle-right"></i></a>
                                <a href="<?php echo BASE_URL; ?>sarvepalli-radhakrishnan-college-of-ayurved-and-hospital" class="static-megamenu-link"><span class="name">SRK College of Ayurved &amp; Hospital</span><span class="badge-yr">2018</span><i class="fas fa-angle-right"></i></a>
                                <a href="<?php echo BASE_URL; ?>faculty-of-paramedical" class="static-megamenu-link"><span class="name">Faculty of Paramedical</span><i class="fas fa-angle-right"></i></a>
                            </div>
                            <!-- COL 4 -->
                            <div>
                                <div class="static-megamenu-col-title"><i class="fas fa-balance-scale"></i> Law, Education &amp; Sciences</div>
                                <a href="<?php echo BASE_URL; ?>faculty-of-education" class="static-megamenu-link"><span class="name">Faculty of Education</span><span class="badge-yr">2004</span><i class="fas fa-angle-right"></i></a>
                                <a href="<?php echo BASE_URL; ?>sarvepalli-radhakrishnan-college-of-law" class="static-megamenu-link"><span class="name">SRK College of Law</span><span class="badge-yr">2019</span><i class="fas fa-angle-right"></i></a>
                                <a href="<?php echo BASE_URL; ?>faculty-of-agriculture" class="static-megamenu-link"><span class="name">Faculty of Agriculture</span><i class="fas fa-angle-right"></i></a>
                                <a href="<?php echo BASE_URL; ?>allied-sciences" class="static-megamenu-link"><span class="name">Allied Sciences</span><i class="fas fa-angle-right"></i></a>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center pt-3 mt-3 border-top">
                            <a href="<?php echo BASE_URL; ?>departments.php" class="small fw-bold text-danger text-decoration-none d-flex align-items-center gap-1">
                                <i class="fas fa-th-large"></i> Explore All Constituent Units &amp; Faculties &rarr;
                            </a>
                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle small fw-semibold">
                                Constituent Units &amp; Colleges
                            </span>
                        </div>
                    </div>
                </li>
                <?php
                break;

            case 'student-life':
                $isActive = (isset($activeNav) && in_array($activeNav, ['student-life', 'life', 'blogs'])) ? 'active' : '';
                ?>
                <!-- 8. Student Life -->
                <li class="static-menu-item <?php echo $isActive; ?>">
                    <a href="<?php echo sanitize($mUrl); ?>" target="<?php echo sanitize($mTarget); ?>" class="static-menu-link">
                        <?php echo sanitize($mLabel); ?> <span class="static-dropdown-arrow"></span>
                        <?php if ($mBadge): ?><span class="badge bg-danger ms-1"><?php echo sanitize($mBadge); ?></span><?php endif; ?>
                    </a>
                    <ul class="static-dropdown-panel">
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/sports-facilities" class="static-dropdown-link"><i class="fas fa-dumbbell text-primary me-1"></i> Sports Facilities</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/ncc-nss" class="static-dropdown-link"><i class="fas fa-medal text-warning me-1"></i> NCC &amp; NSS</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>hostel.php" class="static-dropdown-link"><i class="fas fa-bed text-warning me-1"></i> Hostel Accommodation</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/placement-cell" class="static-dropdown-link"><i class="fas fa-briefcase text-success me-1"></i> Placement Cell</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/health-facility" class="static-dropdown-link"><i class="fas fa-heartbeat text-danger me-1"></i> Health Facility</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/differently-abled-facilities" class="static-dropdown-link"><i class="fas fa-wheelchair text-primary me-1"></i> Facilities For Differently Abled Students</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>blogs" class="static-dropdown-link"><i class="fas fa-newspaper text-info me-1"></i> News, Events &amp; Blogs</a></li>
                    </ul>
                </li>
                <?php
                break;

            case 'alumni':
                $isActive = (isset($activeNav) && $activeNav === 'alumni') ? 'active' : '';
                ?>
                <!-- 9. Alumni -->
                <li class="static-menu-item <?php echo $isActive; ?>">
                    <a href="<?php echo sanitize($mUrl); ?>" target="<?php echo sanitize($mTarget); ?>" class="static-menu-link">
                        <?php echo sanitize($mLabel); ?> <span class="static-dropdown-arrow"></span>
                        <?php if ($mBadge): ?><span class="badge bg-danger ms-1"><?php echo sanitize($mBadge); ?></span><?php endif; ?>
                    </a>
                    <ul class="static-dropdown-panel">
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/alumni-registration-certificate" class="static-dropdown-link"><i class="fas fa-certificate text-primary me-1"></i> Alumni Registration Certificate</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/alumni-bylaws" class="static-dropdown-link"><i class="fas fa-book text-warning me-1"></i> Alumni Bylaws</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>alumni" class="static-dropdown-link fw-semibold text-danger"><i class="fas fa-user-graduate me-1"></i> Alumni Portal</a></li>
                    </ul>
                </li>
                <?php
                break;

            case 'info-corner':
                $isActive = (isset($activeNav) && in_array($activeNav, ['information corner', 'info', 'rti'])) ? 'active' : '';
                ?>
                <!-- 10. Information Corner -->
                <li class="static-menu-item <?php echo $isActive; ?>">
                    <a href="<?php echo sanitize($mUrl); ?>" target="<?php echo sanitize($mTarget); ?>" class="static-menu-link">
                        <?php echo sanitize($mLabel); ?> <span class="static-dropdown-arrow"></span>
                        <?php if ($mBadge): ?><span class="badge bg-danger ms-1"><?php echo sanitize($mBadge); ?></span><?php endif; ?>
                    </a>
                    <ul class="static-dropdown-panel">
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/rti" class="static-dropdown-link"><i class="fas fa-balance-scale text-primary me-1"></i> Right to Information (RTI)</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/vacancy" class="static-dropdown-link"><i class="fas fa-briefcase text-success me-1"></i> Job Openings / Vacancy</a></li>
                    </ul>
                </li>
                <?php
                break;

            default:
                // Custom Navigation Tab (Direct link or custom submenu)
                if (!empty($mSubItems) && is_array($mSubItems)) {
                    ?>
                    <li class="static-menu-item">
                        <a href="<?php echo sanitize($mUrl); ?>" target="<?php echo sanitize($mTarget); ?>" class="static-menu-link">
                            <?php echo sanitize($mLabel); ?> <span class="static-dropdown-arrow"></span>
                            <?php if ($mBadge): ?><span class="badge bg-danger ms-1"><?php echo sanitize($mBadge); ?></span><?php endif; ?>
                        </a>
                        <ul class="static-dropdown-panel">
                            <?php foreach ($mSubItems as $sub):
                                $subUrl = $sub['url'] ?? '#';
                                if ($subUrl !== '#' && strpos($subUrl, 'http') !== 0 && strpos($subUrl, '#') !== 0 && strpos($subUrl, 'javascript:') !== 0) {
                                    $subUrl = BASE_URL . ltrim($subUrl, '/');
                                }
                            ?>
                            <li class="static-dropdown-item">
                                <a href="<?php echo sanitize($subUrl); ?>" target="<?php echo sanitize($sub['target'] ?? '_self'); ?>" class="static-dropdown-link">
                                    <i class="<?php echo sanitize($sub['icon'] ?? 'fas fa-angle-right text-danger'); ?> me-1"></i>
                                    <?php echo sanitize($sub['label'] ?? ''); ?>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                    <?php
                } else {
                    ?>
                    <li class="static-menu-item">
                        <a href="<?php echo sanitize($mUrl); ?>" target="<?php echo sanitize($mTarget); ?>" class="static-menu-link">
                            <?php echo sanitize($mLabel); ?>
                            <?php if ($mBadge): ?><span class="badge bg-danger ms-1"><?php echo sanitize($mBadge); ?></span><?php endif; ?>
                        </a>
                    </li>
                    <?php
                }
                break;
        }
    }
}
