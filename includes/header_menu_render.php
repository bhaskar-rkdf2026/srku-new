<?php
/**
 * Dynamic Header Navigation Menu Renderer
 * Renders main navigation tabs dynamically based on admin drag & drop configuration
 */

if (!function_exists('formatSubMenuUrl')) {
    function formatSubMenuUrl($url) {
        if (empty($url) || $url === '#') return '#';
        if (strpos($url, 'http') === 0 || strpos($url, 'javascript:') === 0 || strpos($url, '#') === 0) {
            return $url;
        }
        return BASE_URL . ltrim($url, '/');
    }
}

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

                // Categorization keywords for multi-level hierarchical submenus
                $grpUnivKeys = ['about.php', 'act-statutes', 'institutional-development-plan', 'constituent-units', 'accreditation-ranking', 'recognition-approval', 'annual-report', 'details-of-sponsoring-body'];
                $grpCommKeys = ['board-of-management', 'student-grievance', 'internal-complaint', 'anti-ragging', 'obc-minority', 'women-grievance', 'sc-st', 'equal-opportunity', 'sedg', 'ombudsman', 'alumni-committee', 'research-advisory'];
                $grpAuthKeys = ['governing-body', 'finance-committee', 'academic-councils', 'board-of-studies'];
                $grpPolKeys  = ['policy', 'differently-abled-facilities'];
                $grpAicteKeys = ['aicte', 'council-of-technical-education'];
                $grpOrdKeys   = ['ordinance'];

                $listUniv = [];
                $listComm = [];
                $listAuth = [];
                $listPol  = [];
                $listAicte = [];
                $listOrd   = [];
                $listStandalone = [];

                if (!empty($mSubItems) && is_array($mSubItems)) {
                    foreach ($mSubItems as $sub) {
                        $sUrl = strtolower($sub['url'] ?? '');
                        
                        $matched = false;
                        foreach ($grpUnivKeys as $k) {
                            if (strpos($sUrl, $k) !== false) { $listUniv[] = $sub; $matched = true; break; }
                        }
                        if ($matched) continue;

                        foreach ($grpCommKeys as $k) {
                            if (strpos($sUrl, $k) !== false) { $listComm[] = $sub; $matched = true; break; }
                        }
                        if ($matched) continue;

                        foreach ($grpAuthKeys as $k) {
                            if (strpos($sUrl, $k) !== false) { $listAuth[] = $sub; $matched = true; break; }
                        }
                        if ($matched) continue;

                        foreach ($grpPolKeys as $k) {
                            if (strpos($sUrl, $k) !== false) { $listPol[] = $sub; $matched = true; break; }
                        }
                        if ($matched) continue;

                        foreach ($grpAicteKeys as $k) {
                            if (strpos($sUrl, $k) !== false) { $listAicte[] = $sub; $matched = true; break; }
                        }
                        if ($matched) continue;

                        foreach ($grpOrdKeys as $k) {
                            if (strpos($sUrl, $k) !== false) { $listOrd[] = $sub; $matched = true; break; }
                        }
                        if ($matched) continue;

                        $listStandalone[] = $sub;
                    }
                }
                ?>
                <!-- 2. About H.E.I. -->
                <li class="static-menu-item <?php echo $isActive; ?>">
                    <a href="<?php echo sanitize($mUrl); ?>" target="<?php echo sanitize($mTarget); ?>" class="static-menu-link">
                        <?php echo sanitize($mLabel); ?> <span class="static-dropdown-arrow"></span>
                        <?php if ($mBadge): ?><span class="badge bg-danger ms-1"><?php echo sanitize($mBadge); ?></span><?php endif; ?>
                    </a>
                    <ul class="static-dropdown-panel">
                        <?php if (!empty($listUniv)): ?>
                        <!-- About Srk University (With Level-3 Submenu) -->
                        <li class="static-dropdown-item">
                            <a href="<?php echo BASE_URL; ?>about.php" class="static-dropdown-link fw-semibold text-danger">
                                <i class="fas fa-university text-danger me-1"></i> About Srk University <span class="static-dropdown-arrow static-sub-arrow"></span>
                            </a>
                            <ul class="static-dropdown-panel static-sub-dropdown">
                                <?php foreach ($listUniv as $sub): 
                                    $sUrl = formatSubMenuUrl($sub['url'] ?? '');
                                ?>
                                <li class="static-dropdown-item"><a href="<?php echo sanitize($sUrl); ?>" target="<?php echo sanitize($sub['target'] ?? '_self'); ?>" class="static-dropdown-link"><i class="<?php echo sanitize($sub['icon'] ?? 'fas fa-info-circle text-primary'); ?> me-1"></i> <?php echo sanitize($sub['label']); ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                        <?php endif; ?>

                        <?php if (!empty($listComm)): ?>
                        <!-- All Committee (With Level-3 Submenu) -->
                        <li class="static-dropdown-item">
                            <a href="#" class="static-dropdown-link fw-semibold text-danger">
                                <i class="fas fa-users-cog text-warning me-1"></i> All Committee <span class="static-dropdown-arrow static-sub-arrow"></span>
                            </a>
                            <ul class="static-dropdown-panel static-sub-dropdown">
                                <?php foreach ($listComm as $sub): 
                                    $sUrl = formatSubMenuUrl($sub['url'] ?? '');
                                ?>
                                <li class="static-dropdown-item"><a href="<?php echo sanitize($sUrl); ?>" target="<?php echo sanitize($sub['target'] ?? '_self'); ?>" class="static-dropdown-link"><i class="<?php echo sanitize($sub['icon'] ?? 'fas fa-landmark text-primary'); ?> me-1"></i> <?php echo sanitize($sub['label']); ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                        <?php endif; ?>

                        <?php if (!empty($listAuth)): ?>
                        <!-- Authority Of University (With Level-3 Submenu) -->
                        <li class="static-dropdown-item">
                            <a href="#" class="static-dropdown-link">
                                <i class="fas fa-landmark text-danger me-1"></i> Authority Of University <span class="static-dropdown-arrow static-sub-arrow"></span>
                            </a>
                            <ul class="static-dropdown-panel static-sub-dropdown">
                                <?php foreach ($listAuth as $sub): 
                                    $sUrl = formatSubMenuUrl($sub['url'] ?? '');
                                ?>
                                <li class="static-dropdown-item"><a href="<?php echo sanitize($sUrl); ?>" target="<?php echo sanitize($sub['target'] ?? '_self'); ?>" class="static-dropdown-link"><i class="<?php echo sanitize($sub['icon'] ?? 'fas fa-crown text-warning'); ?> me-1"></i> <?php echo sanitize($sub['label']); ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                        <?php endif; ?>

                        <?php if (!empty($listPol)): ?>
                        <!-- University Policies (Level-3 Submenu) -->
                        <li class="static-dropdown-item">
                            <a href="#" class="static-dropdown-link fw-semibold text-danger">
                                <i class="fas fa-file-contract text-danger me-1"></i> Institutional Policies <span class="static-dropdown-arrow static-sub-arrow"></span>
                            </a>
                            <ul class="static-dropdown-panel static-sub-dropdown">
                                <?php foreach ($listPol as $sub): 
                                    $sUrl = formatSubMenuUrl($sub['url'] ?? '');
                                ?>
                                <li class="static-dropdown-item"><a href="<?php echo sanitize($sUrl); ?>" target="<?php echo sanitize($sub['target'] ?? '_self'); ?>" class="static-dropdown-link"><i class="<?php echo sanitize($sub['icon'] ?? 'fas fa-file-contract text-danger'); ?> me-1"></i> <?php echo sanitize($sub['label']); ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                        <?php endif; ?>

                        <?php if (!empty($listAicte)): ?>
                        <!-- AICTE Approvals (With Level-3 Submenu) -->
                        <li class="static-dropdown-item">
                            <a href="<?php echo BASE_URL; ?>document/council-of-technical-education" class="static-dropdown-link">
                                <i class="fas fa-cogs text-primary me-1"></i> AICTE Approvals 2026-27 <span class="static-dropdown-arrow static-sub-arrow"></span>
                            </a>
                            <ul class="static-dropdown-panel static-sub-dropdown">
                                <?php foreach ($listAicte as $sub): 
                                    $sUrl = formatSubMenuUrl($sub['url'] ?? '');
                                ?>
                                <li class="static-dropdown-item"><a href="<?php echo sanitize($sUrl); ?>" target="<?php echo sanitize($sub['target'] ?? '_self'); ?>" class="static-dropdown-link"><i class="<?php echo sanitize($sub['icon'] ?? 'fas fa-file-pdf text-danger'); ?> me-1"></i> <?php echo sanitize($sub['label']); ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                        <?php endif; ?>

                        <?php if (!empty($listOrd)): ?>
                        <!-- University Ordinance (With Level-3 Submenu) -->
                        <li class="static-dropdown-item">
                            <a href="#" class="static-dropdown-link">
                                <i class="fas fa-scroll text-warning me-1"></i> University Ordinance <span class="static-dropdown-arrow static-sub-arrow"></span>
                            </a>
                            <ul class="static-dropdown-panel static-sub-dropdown">
                                <?php foreach ($listOrd as $sub): 
                                    $sUrl = formatSubMenuUrl($sub['url'] ?? '');
                                ?>
                                <li class="static-dropdown-item"><a href="<?php echo sanitize($sUrl); ?>" target="<?php echo sanitize($sub['target'] ?? '_self'); ?>" class="static-dropdown-link"><i class="<?php echo sanitize($sub['icon'] ?? 'fas fa-scroll text-warning'); ?> me-1"></i> <?php echo sanitize($sub['label']); ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                        <?php endif; ?>

                        <?php if (!empty($listStandalone)): ?>
                            <?php foreach ($listStandalone as $sub): 
                                $sUrl = formatSubMenuUrl($sub['url'] ?? '');
                            ?>
                            <li class="static-dropdown-item"><a href="<?php echo sanitize($sUrl); ?>" target="<?php echo sanitize($sub['target'] ?? '_self'); ?>" class="static-dropdown-link"><i class="<?php echo sanitize($sub['icon'] ?? 'fas fa-angle-right text-danger'); ?> me-1"></i> <?php echo sanitize($sub['label']); ?></a></li>
                            <?php endforeach; ?>
                        <?php endif; ?>
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
                            <?php foreach ($mSubItems as $sub): 
                                $sUrl = formatSubMenuUrl($sub['url'] ?? '');
                            ?>
                            <a title="<?php echo sanitize($sub['label']); ?>" href="<?php echo sanitize($sUrl); ?>" target="<?php echo sanitize($sub['target'] ?? '_self'); ?>" class="static-dropdown-link"><i class="<?php echo sanitize($sub['icon'] ?? 'fas fa-book-open text-danger'); ?> me-1"></i> <?php echo sanitize($sub['label']); ?></a>
                            <?php endforeach; ?>
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
                        <?php foreach ($mSubItems as $sub): 
                            $sUrl = formatSubMenuUrl($sub['url'] ?? '');
                        ?>
                        <li class="static-dropdown-item"><a href="<?php echo sanitize($sUrl); ?>" target="<?php echo sanitize($sub['target'] ?? '_self'); ?>" class="static-dropdown-link"><i class="<?php echo sanitize($sub['icon'] ?? 'fas fa-angle-right text-danger'); ?> me-1"></i> <?php echo sanitize($sub['label']); ?></a></li>
                        <?php endforeach; ?>
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
                        <?php foreach ($mSubItems as $sub): 
                            $sUrl = formatSubMenuUrl($sub['url'] ?? '');
                        ?>
                        <li class="static-dropdown-item"><a href="<?php echo sanitize($sUrl); ?>" target="<?php echo sanitize($sub['target'] ?? '_self'); ?>" class="static-dropdown-link"><i class="<?php echo sanitize($sub['icon'] ?? 'fas fa-angle-right text-danger'); ?> me-1"></i> <?php echo sanitize($sub['label']); ?></a></li>
                        <?php endforeach; ?>
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
                        <?php foreach ($mSubItems as $sub): 
                            $sUrl = formatSubMenuUrl($sub['url'] ?? '');
                        ?>
                        <li class="static-dropdown-item"><a href="<?php echo sanitize($sUrl); ?>" target="<?php echo sanitize($sub['target'] ?? '_self'); ?>" class="static-dropdown-link"><i class="<?php echo sanitize($sub['icon'] ?? 'fas fa-angle-right text-danger'); ?> me-1"></i> <?php echo sanitize($sub['label']); ?></a></li>
                        <?php endforeach; ?>
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
                        <?php foreach ($mSubItems as $sub): 
                            $sUrl = formatSubMenuUrl($sub['url'] ?? '');
                        ?>
                        <li class="static-dropdown-item"><a href="<?php echo sanitize($sUrl); ?>" target="<?php echo sanitize($sub['target'] ?? '_self'); ?>" class="static-dropdown-link"><i class="<?php echo sanitize($sub['icon'] ?? 'fas fa-angle-right text-danger'); ?> me-1"></i> <?php echo sanitize($sub['label']); ?></a></li>
                        <?php endforeach; ?>
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
                        <?php foreach ($mSubItems as $sub): 
                            $sUrl = formatSubMenuUrl($sub['url'] ?? '');
                        ?>
                        <li class="static-dropdown-item"><a href="<?php echo sanitize($sUrl); ?>" target="<?php echo sanitize($sub['target'] ?? '_self'); ?>" class="static-dropdown-link"><i class="<?php echo sanitize($sub['icon'] ?? 'fas fa-angle-right text-danger'); ?> me-1"></i> <?php echo sanitize($sub['label']); ?></a></li>
                        <?php endforeach; ?>
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
                        <?php foreach ($mSubItems as $sub): 
                            $sUrl = formatSubMenuUrl($sub['url'] ?? '');
                        ?>
                        <li class="static-dropdown-item"><a href="<?php echo sanitize($sUrl); ?>" target="<?php echo sanitize($sub['target'] ?? '_self'); ?>" class="static-dropdown-link"><i class="<?php echo sanitize($sub['icon'] ?? 'fas fa-angle-right text-danger'); ?> me-1"></i> <?php echo sanitize($sub['label']); ?></a></li>
                        <?php endforeach; ?>
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
