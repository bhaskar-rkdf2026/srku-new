<?php
require_once __DIR__ . '/functions.php';
$helpline = getSetting('header_topbar_phone', getSetting('helpline', '0755 - 4911204'));
$email = getSetting('header_topbar_email', getSetting('email', 'exam@srku.edu.in'));
$erpLink = getSetting('header_topbar_erp_link', 'https://erp.srku.edu.in/');
$aicteLink = getSetting('header_topbar_aicte_link', 'https://sarswati.aicte.gov.in/');
$logoUrl = getSetting('header_logo_url', 'assets/uploads/2026/07/SRK-logo.webp');
$ctaText = getSetting('header_cta_text', 'Contact Us');
$ctaLink = getSetting('header_cta_link', 'contact.php');
$customHeadCode = getSetting('header_custom_head_code', '');
// SEO & AEO Canonical & Meta Defaults
$protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http");
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$reqUri = $_SERVER['REQUEST_URI'] ?? '/';
$currentFullUrl = "$protocol://$host$reqUri";
$canonicalUrl = isset($pageCanonical) ? $pageCanonical : $currentFullUrl;

$seoTitle = isset($pageTitle) ? sanitize($pageTitle) : "Sarvepalli Radhakrishnan University (SRKU), Bhopal | Official Portal";
$seoDesc = isset($pageDesc) ? sanitize($pageDesc) : (isset($metaDesc) ? sanitize($metaDesc) : 'Sarvepalli Radhakrishnan University (SRKU) Bhopal is a premier multidisciplinary private university in Madhya Pradesh recognized under Section 2(f) of UGC Act 1956, offering UGC, AICTE, NMC, PCI, BCI approved programmes across Engineering, Medicine, Pharmacy, Law, Nursing, Agriculture and Management.');
$seoKeywords = isset($pageKeywords) ? sanitize($pageKeywords) : "SRK University, Sarvepalli Radhakrishnan University, SRKU Bhopal, Admissions 2026-27, UGC Approved University MP, AICTE Approved Engineering College, NMC Approved Medical College Bhopal, RKDF Group, MP Private University";
$seoImage = isset($pageImage) ? $pageImage : (strpos($logoUrl, 'http') === 0 ? $logoUrl : BASE_URL . $logoUrl);
?>
<!DOCTYPE html>
<html lang="en" itemscope itemtype="https://schema.org/CollegeOrUniversity">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $seoTitle; ?></title>
    
    <!-- Core SEO & Search Engine Directives -->
    <meta name="description" content="<?php echo $seoDesc; ?>">
    <meta name="keywords" content="<?php echo $seoKeywords; ?>">
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    <meta name="author" content="Sarvepalli Radhakrishnan University, Bhopal">
    <link rel="canonical" href="<?php echo htmlspecialchars($canonicalUrl); ?>">

    <!-- Geographic & Regional Meta Tags (Local SEO & AEO) -->
    <meta name="geo.region" content="IN-MP">
    <meta name="geo.placename" content="Bhopal, Madhya Pradesh">
    <meta name="geo.position" content="23.1685;77.4682">
    <meta name="ICBM" content="23.1685, 77.4682">

    <!-- Open Graph Protocol (Facebook, LinkedIn, AI Search Engines) -->
    <meta property="og:locale" content="en_IN">
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?php echo $seoTitle; ?>">
    <meta property="og:description" content="<?php echo $seoDesc; ?>">
    <meta property="og:url" content="<?php echo htmlspecialchars($canonicalUrl); ?>">
    <meta property="og:site_name" content="Sarvepalli Radhakrishnan University (SRKU)">
    <meta property="og:image" content="<?php echo htmlspecialchars($seoImage); ?>">
    <meta property="og:image:alt" content="Sarvepalli Radhakrishnan University Campus">

    <!-- Twitter Cards (Social & Conversational Search) -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo $seoTitle; ?>">
    <meta name="twitter:description" content="<?php echo $seoDesc; ?>">
    <meta name="twitter:image" content="<?php echo htmlspecialchars($seoImage); ?>">

    <!-- Schema.org Comprehensive Structured Data (AEO: Google SGE, Perplexity, Gemini, ChatGPT, Bing Copilot) -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "CollegeOrUniversity",
      "@id": "https://srku.edu.in/#university",
      "name": "Sarvepalli Radhakrishnan University",
      "alternateName": ["SRKU", "SRK University", "SRKU Bhopal"],
      "url": "https://srku.edu.in/",
      "logo": "https://srku.edu.in/assets/uploads/2026/07/SRK-logo.webp",
      "image": "https://srku.edu.in/assets/uploads/2026/07/campus-1.webp",
      "description": "Sarvepalli Radhakrishnan University (SRKU), Bhopal is a statutory multidisciplinary private university established under Section 2(f) of the UGC Act 1956 and MP Niji Vishwavidyalaya Adhiniyam 2007 (Act No. 17 of 2007).",
      "foundingDate": "1995",
      "parentOrganization": {
        "@type": "EducationalOrganization",
        "name": "RKDF Education Society"
      },
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "NH-12, Hoshangabad Road, Jatkhedi, Misrod",
        "addressLocality": "Bhopal",
        "addressRegion": "Madhya Pradesh",
        "postalCode": "462026",
        "addressCountry": "IN"
      },
      "geo": {
        "@type": "GeoCoordinates",
        "latitude": "23.1685",
        "longitude": "77.4682"
      },
      "telephone": "+91-755-4911204",
      "email": "info@srku.edu.in",
      "contactPoint": [
        {
          "@type": "ContactPoint",
          "telephone": "+91-7024144981",
          "contactType": "Admissions Desk",
          "areaServed": "IN",
          "availableLanguage": ["en", "hi"]
        },
        {
          "@type": "ContactPoint",
          "telephone": "+91-755-4911204",
          "contactType": "Examination Support",
          "email": "exam@srku.edu.in",
          "areaServed": "IN"
        },
        {
          "@type": "ContactPoint",
          "telephone": "+91-755-4700982",
          "contactType": "Academic Affairs",
          "areaServed": "IN"
        },
        {
          "@type": "ContactPoint",
          "email": "registrar@srku.edu.in",
          "contactType": "Registrar Office",
          "areaServed": "IN"
        }
      ],
      "sameAs": [
        "https://www.facebook.com/",
        "https://www.instagram.com/",
        "https://www.linkedin.com/",
        "https://www.youtube.com/"
      ]
    }
    </script>

    <!-- Favicon & Brand Icons -->
    <link rel="icon" type="image/png" href="<?php echo BASE_URL; ?>assets/images/favicon.png?v=<?php echo @filemtime(__DIR__ . '/../assets/images/favicon.png') ?: time(); ?>">
    <link rel="shortcut icon" type="image/png" href="<?php echo BASE_URL; ?>assets/images/favicon.png?v=<?php echo @filemtime(__DIR__ . '/../assets/images/favicon.png') ?: time(); ?>">
    <link rel="apple-touch-icon" href="<?php echo BASE_URL; ?>assets/images/favicon.png?v=<?php echo @filemtime(__DIR__ . '/../assets/images/favicon.png') ?: time(); ?>">

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;500;600;700;800;900&family=Roboto+Slab:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Custom SRKU Styles -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css?v=<?php echo @filemtime(__DIR__ . '/../assets/css/style.css') ?: time(); ?>">
    <?php if ($customHeadCode): echo $customHeadCode; endif; ?>
</head>
<body>

<!-- ═══════ TOP BAR ═══════ -->
<div class="srku-topbar">
    <div class="container-xl">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-none d-md-flex gap-3">
                <a href="<?php echo sanitize($erpLink); ?>" target="_blank" class="topbar-link"><i class="fas fa-user-graduate me-1 text-warning"></i> STUDENT PORTAL</a>
                <a href="<?php echo BASE_URL; ?>faculties.php" class="topbar-link"><i class="fas fa-chalkboard-teacher me-1 text-warning"></i> FACULTIES</a>
                <a href="<?php echo BASE_URL; ?>alumni.php" class="topbar-link"><i class="fas fa-users me-1 text-warning"></i> ALUMNI</a>
                <a href="<?php echo BASE_URL; ?>career.php" class="topbar-link"><i class="fas fa-briefcase me-1 text-warning"></i> CAREERS</a>
                <a href="<?php echo BASE_URL; ?>grievance.php" class="topbar-link"><i class="fas fa-balance-scale me-1 text-warning"></i> GRIEVANCE CELL</a>
                <a href="<?php echo sanitize($aicteLink); ?>" target="_blank" class="topbar-link"><i class="fas fa-award me-1 text-warning"></i> AICTE SCHOLARSHIP</a>
                <a href="<?php echo BASE_URL; ?>document/nirf-2026" class="topbar-link text-warning fw-bold"><i class="fas fa-file-contract me-1"></i> NIRF 2026</a>
            </div>
            <div class="d-flex align-items-center gap-3 ms-auto ms-md-0">
                <span class="topbar-info"><i class="fas fa-phone-alt me-1 text-warning"></i> <?php echo sanitize($helpline); ?></span>
                <a href="mailto:<?php echo sanitize($email); ?>" class="topbar-info d-none d-sm-inline"><i class="fas fa-envelope me-1 text-warning"></i> <?php echo sanitize($email); ?></a>
                <a href="<?php echo BASE_URL; ?>admin/login.php" class="topbar-link text-warning fw-bold"><i class="fas fa-lock me-1"></i> Admin</a>
            </div>
        </div>
    </div>
</div>

<!-- ═══════ ORIGINAL STATIC SITE HEADER & NAVBAR (Exact 1:1 Match) ═══════ -->
<header class="site-header-static">
    <!-- Mobile overlay (tap to close) -->
    <div class="static-nav-overlay" id="staticNavOverlay"></div>

    <div class="static-nav-wrapper">
        <div class="static-nav-container">
            <a href="<?php echo BASE_URL; ?>" class="static-nav-logo">
                <img src="<?php echo (strpos($logoUrl, 'http') === 0) ? $logoUrl : BASE_URL . $logoUrl; ?>" alt="Sarvepalli Radhakrishnan University" onerror="this.onerror=null; this.src='<?php echo BASE_URL; ?>assets/images/SRK-logo.webp';" loading="lazy" decoding="async">
            </a>

            <button class="static-mobile-toggle" id="staticMenuToggle" aria-label="Toggle Navigation" aria-expanded="false">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <ul class="static-menu-list" id="staticMenuList">
                <!-- 1. Home -->
                <li class="static-menu-item <?php echo (!isset($activeNav) || $activeNav == 'home') ? 'active' : ''; ?>">
                    <a href="<?php echo BASE_URL; ?>" class="static-menu-link">Home</a>
                </li>

                <!-- 2. About H.E.I. -->
                <li class="static-menu-item <?php echo (isset($activeNav) && in_array($activeNav, ['about', 'about-hei'])) ? 'active' : ''; ?>">
                    <a href="<?php echo BASE_URL; ?>about.php" class="static-menu-link">
                        About H.E.I. <span class="static-dropdown-arrow"></span>
                    </a>
                    <ul class="static-dropdown-panel">
                        <!-- About Srk University (With Level-3 Submenu) -->
                        <li class="static-dropdown-item">
                            <a href="<?php echo BASE_URL; ?>about.php" class="static-dropdown-link fw-semibold text-danger">
                                <i class="fas fa-university text-danger me-1"></i> About Srk University <span class="static-dropdown-arrow static-sub-arrow"></span>
                            </a>
                            <ul class="static-dropdown-panel static-sub-dropdown">
                                <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>about.php" class="static-dropdown-link"><i class="fas fa-info-circle me-1 text-primary"></i> University Overview</a></li>
                                <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/act-statutes" class="static-dropdown-link">Act &amp; Statutes</a></li>
                                <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/institutional-development-plan" class="static-dropdown-link">Institutional Development Plan</a></li>
                                <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>about/constituent-unit" class="static-dropdown-link">Constituent Units</a></li>
                                <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>about/accreditation" class="static-dropdown-link">Accreditation &amp; Ranking</a></li>
                                <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/recognition-approval" class="static-dropdown-link">Recognition Approval</a></li>
                                <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/recognition-approval" class="static-dropdown-link">Annual Report 2024-25</a></li>
                                <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>about/board-of-management" class="static-dropdown-link">Details of Sponsoring Body</a></li>
                            </ul>
                        </li>

                        <!-- All Committee (With Level-3 Submenu) -->
                        <li class="static-dropdown-item">
                            <a href="#" class="static-dropdown-link fw-semibold">
                                <i class="fas fa-users-cog text-warning me-1"></i> All Committee <span class="static-dropdown-arrow static-sub-arrow"></span>
                            </a>
                            <ul class="static-dropdown-panel static-sub-dropdown">
                                <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>grievance.php" class="static-dropdown-link fw-bold text-danger"><i class="fas fa-balance-scale me-1"></i> Student Grievance Portal</a></li>
                                <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/student-grievance-committee" class="static-dropdown-link">Student Grievance Committee</a></li>
                                <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/anti-ragging" class="static-dropdown-link">Anti Ragging Committee</a></li>
                                <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/obc-minority" class="static-dropdown-link">OBC &amp; Minority Committee</a></li>
                                <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/women-grievance-committee" class="static-dropdown-link">Women Grievance Committee</a></li>
                                <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/sc-st-grievance-committee" class="static-dropdown-link">SC &amp; ST Committee</a></li>
                                <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/equal-opportunity-cell" class="static-dropdown-link">Equal Opportunity Cell</a></li>
                            </ul>
                        </li>

                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/council-of-technical-education" class="static-dropdown-link">Council Of technical education</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>about/srk-university-vision-and-mission" class="static-dropdown-link">Vision &amp; Mission</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>facilities" class="static-dropdown-link">FACILITIES</a></li>

                        <!-- University Ordinance (With Level-3 Submenu) -->
                        <li class="static-dropdown-item">
                            <a href="#" class="static-dropdown-link">
                                University Ordinance <span class="static-dropdown-arrow static-sub-arrow"></span>
                            </a>
                            <ul class="static-dropdown-panel static-sub-dropdown">
                                <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/university-ordinance" class="static-dropdown-link">Ordinance 1 to 92</a></li>
                                <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/ordinance-93-100" class="static-dropdown-link">Subsequent Ordinance 93-100</a></li>
                            </ul>
                        </li>

                        <li class="static-dropdown-item"><a href="http://www.srku.edu.in/wp-content/uploads/2023/05/annexure-I-UGCinfo.pdf" target="_blank" class="static-dropdown-link">UGC Information</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>chancellor-message.php" class="static-dropdown-link fw-semibold text-danger"><i class="fas fa-crown text-warning me-1"></i> Chancellor's Message</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>vice-chancellor-message.php" class="static-dropdown-link fw-semibold text-navy"><i class="fas fa-user-tie text-primary me-1"></i> Vice Chancellor's Message</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>gallery.php" class="static-dropdown-link fw-semibold text-danger"><i class="fas fa-camera-retro text-danger me-1"></i> Picture Gallery</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/nirf-2026" class="static-dropdown-link fw-bold text-primary"><i class="fas fa-award text-warning me-1"></i> NIRF 2026</a></li>
                    </ul>
                </li>

                <!-- 3. Administration -->
                <li class="static-menu-item <?php echo (isset($activeNav) && $activeNav == 'administration') ? 'active' : ''; ?>">
                    <a href="#" class="static-menu-link">
                        Administration <span class="static-dropdown-arrow"></span>
                    </a>
                    <ul class="static-dropdown-panel">
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/officers-of-university" class="static-dropdown-link">Officers of University</a></li>
                        
                        <!-- Authority Of University -->
                        <li class="static-dropdown-item">
                            <a href="#" class="static-dropdown-link">
                                Authority Of University <span class="static-dropdown-arrow static-sub-arrow"></span>
                            </a>
                            <ul class="static-dropdown-panel static-sub-dropdown">
                                <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/governing-body" class="static-dropdown-link">Governing Body</a></li>
                                <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/board-of-management" class="static-dropdown-link">Board of Management</a></li>
                                <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/finance-committee" class="static-dropdown-link">Finance Committee</a></li>
                                <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/academic-councils" class="static-dropdown-link">Academic Councils</a></li>
                                <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/board-of-studies" class="static-dropdown-link">Board Of Studies</a></li>
                            </ul>
                        </li>

                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/internal-complaint-committee" class="static-dropdown-link">Internal Complaint Committee</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/academic-leadership" class="static-dropdown-link">Academic Leadership</a></li>
                    </ul>
                </li>

                <!-- 4. Syllabus & Courses -->
                <li class="static-menu-item static-menu-item-syllabus <?php echo (isset($activeNav) && in_array($activeNav, ['courses', 'syllabus'])) ? 'active' : ''; ?>">
                    <a href="<?php echo BASE_URL; ?>courses" class="static-menu-link">
                        Syllabus &amp; Courses <span class="static-dropdown-arrow"></span>
                    </a>
                    <div class="static-dropdown-panel syllabus-megamenu-panel shadow-lg">
                        <!-- Top Header Bar: All Academic Courses & View All Syllabi -->
                        <div class="d-flex align-items-center justify-content-between pb-2 mb-2 border-bottom px-2">
                            <a href="<?php echo BASE_URL; ?>courses" class="fw-bold text-navy text-decoration-none d-flex align-items-center gap-2" style="font-size: 13px;">
                                <i class="fas fa-graduation-cap text-primary"></i> All Academic Courses (90+ Degrees)
                            </a>
                            <a href="<?php echo BASE_URL; ?>syllabus" class="small fw-bold text-danger text-decoration-none" style="font-size: 11.5px;">
                                <i class="fas fa-file-pdf me-1"></i> View All Syllabus / Scheme &rarr;
                            </a>
                        </div>
                        <!-- Section Label -->
                        <div class="px-2 pb-1 mb-1 d-flex align-items-center justify-content-between text-muted" style="font-size: 11px; letter-spacing: .5px; text-transform: uppercase; font-weight: 700;">
                            <span><i class="fas fa-book-open text-danger me-1"></i> Course Schemes &amp; Syllabus:</span>
                        </div>
                        <!-- 19 Syllabus Categories Grid (Direct 2-Column Links) -->
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

                <!-- 5. Academics -->
                <li class="static-menu-item <?php echo (isset($activeNav) && $activeNav == 'academics') ? 'active' : ''; ?>">
                    <a href="#" class="static-menu-link">
                        Academics <span class="static-dropdown-arrow"></span>
                    </a>
                    <ul class="static-dropdown-panel">
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>academic-calendar.php" class="static-dropdown-link fw-semibold text-danger"><i class="fas fa-calendar-alt text-warning me-1"></i> Academic Calendar 2026-27</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>exam-rules.php" class="static-dropdown-link fw-semibold text-navy"><i class="fas fa-clipboard-check text-primary me-1"></i> Examination Rules &amp; Ordinances</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/details-of-academic-programmes" class="static-dropdown-link">Details of Academic Programmes</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/statutes-ordinances-academics-examination" class="static-dropdown-link">Statutes Ordinances</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/constituent-units-departments" class="static-dropdown-link">School/ Department/ Centres</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/department-wise-faculty-details" class="static-dropdown-link">Faculty/ Staff Details</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/iqac" class="static-dropdown-link">Internal Quality Assurance Cell</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/university-library" class="static-dropdown-link">Library</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>hostel.php" class="static-dropdown-link"><i class="fas fa-bed text-warning me-1"></i> Hostel Accommodation</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>facilities" class="static-dropdown-link">Facilities</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>placements" class="static-dropdown-link">Placements</a></li>
                    </ul>
                </li>

                <!-- 6. Admission & Fee -->
                <li class="static-menu-item <?php echo (isset($activeNav) && in_array($activeNav, ['admission', 'admission-fee'])) ? 'active' : ''; ?>">
                    <a href="<?php echo BASE_URL; ?>admission-enquiry.php" class="static-menu-link">
                        Admission &amp; Fee <span class="static-dropdown-arrow"></span>
                    </a>
                    <ul class="static-dropdown-panel">
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>admission-enquiry.php" class="static-dropdown-link fw-bold text-danger"><i class="fas fa-edit text-danger me-1"></i> Online Admission Form 2026-27</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>phd-admission.php" class="static-dropdown-link fw-bold text-danger"><i class="fas fa-graduation-cap text-danger me-1"></i> Ph.D. Admission 2026</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>phd-application-form.php" class="static-dropdown-link">Ph.D. Application Form</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>phd-entrance-form.php" class="static-dropdown-link">Ph.D. Entrance Exam Form</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/prospectus" class="static-dropdown-link">Prospectus</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/admission-process-guidelines" class="static-dropdown-link">Admission Process Guidelines</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/fee-refund-policy" class="static-dropdown-link">Fee Refund Policy</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>contact.php" class="static-dropdown-link">International Students Admission</a></li>
                    </ul>
                </li>

                <!-- 7. Research -->
                <li class="static-menu-item <?php echo (isset($activeNav) && $activeNav == 'research') ? 'active' : ''; ?>">
                    <a href="<?php echo BASE_URL; ?>research-innovation" class="static-menu-link">
                        Research <span class="static-dropdown-arrow"></span>
                    </a>
                    <ul class="static-dropdown-panel">
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>phd-admission.php" class="static-dropdown-link fw-bold text-danger"><i class="fas fa-microscope text-danger me-1"></i> Ph.D. Admissions &amp; Guidelines</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>phd-application-form.php" class="static-dropdown-link">Ph.D. Application Form</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>phd-entrance-form.php" class="static-dropdown-link">Ph.D. Entrance Exam Form</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/phd-admission-policy" class="static-dropdown-link">Admission Policy for Ph.D. Programme</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>incubation-center" class="static-dropdown-link">Incubation Centre</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/research-development-cell" class="static-dropdown-link">Research &amp; Development Cell</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/university-research-policy" class="static-dropdown-link">Research Policy</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/central-facilities-research" class="static-dropdown-link">Central Facilities for Research and Development</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/ethics-board" class="static-dropdown-link">Ethics Board to Maintain Research Integrity</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/consultancy-projects" class="static-dropdown-link">Consultancy Projects</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/phd-scholars-pursuing" class="static-dropdown-link">Ph.D. Scholars Currently Enrolled</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/phd-scholars-completed" class="static-dropdown-link">Ph.D. Awarded Scholars List</a></li>
                    </ul>
                </li>

                <!-- 8. Departments & Constituent Units (Comprehensive Megamenu) -->
                <li class="static-menu-item static-menu-item-departments <?php echo (isset($activeNav) && $activeNav == 'departments') ? 'active' : ''; ?>">
                    <a href="<?php echo BASE_URL; ?>departments.php" class="static-menu-link">
                        Departments <span class="static-dropdown-arrow"></span>
                    </a>
                    <div class="static-dropdown-panel static-megamenu-panel shadow-lg">
                        <div class="static-megamenu-grid">
                            
                            <!-- COL 1: Engineering, IT, Management & Commerce -->
                            <div>
                                <div class="static-megamenu-col-title">
                                    <i class="fas fa-microchip"></i> Engg, IT &amp; Management
                                </div>
                                <a href="<?php echo BASE_URL; ?>rkdf-institute-of-science-and-technology" class="static-megamenu-link">
                                    <span class="name">RKDF Inst. of Science &amp; Technology</span>
                                    <span class="badge-yr">1995</span>
                                    <i class="fas fa-angle-right"></i>
                                </a>
                                <a href="<?php echo BASE_URL; ?>rkdf-institute-science-technology-mca" class="static-megamenu-link">
                                    <span class="name">RKDF IST - MCA</span>
                                    <span class="badge-yr">1999</span>
                                    <i class="fas fa-angle-right"></i>
                                </a>
                                <a href="<?php echo BASE_URL; ?>faculty-of-computer-application" class="static-megamenu-link">
                                    <span class="name">Faculty of Computer Application</span>
                                    <i class="fas fa-angle-right"></i>
                                </a>
                                <a href="<?php echo BASE_URL; ?>rkdf-institute-of-management" class="static-megamenu-link">
                                    <span class="name">RKDF Institute of Management</span>
                                    <span class="badge-yr">2003</span>
                                    <i class="fas fa-angle-right"></i>
                                </a>
                                <a href="<?php echo BASE_URL; ?>rkdf-institute-of-business-management" class="static-megamenu-link">
                                    <span class="name">RKDF Inst. of Business Management</span>
                                    <span class="badge-yr">2006</span>
                                    <i class="fas fa-angle-right"></i>
                                </a>
                                <a href="<?php echo BASE_URL; ?>department-of-management" class="static-megamenu-link">
                                    <span class="name">Dept. of Management (Logistics)</span>
                                    <i class="fas fa-angle-right"></i>
                                </a>
                                <a href="<?php echo BASE_URL; ?>faculty-of-commerce" class="static-megamenu-link">
                                    <span class="name">Faculty of Commerce</span>
                                    <i class="fas fa-angle-right"></i>
                                </a>
                            </div>

                            <!-- COL 2: Pharmacy Institutes (6 Colleges) & Nursing -->
                            <div>
                                <div class="static-megamenu-col-title">
                                    <i class="fas fa-pills"></i> Pharmacy &amp; Nursing
                                </div>
                                <a href="<?php echo BASE_URL; ?>rkdf-college-of-pharmacy" class="static-megamenu-link">
                                    <span class="name">RKDF College of Pharmacy</span>
                                    <span class="badge-yr">1995</span>
                                    <i class="fas fa-angle-right"></i>
                                </a>
                                <a href="<?php echo BASE_URL; ?>sarvepalli-radhakrishnan-college-of-pharmacy" class="static-megamenu-link">
                                    <span class="name">SRK College of Pharmacy</span>
                                    <span class="badge-yr">2018</span>
                                    <i class="fas fa-angle-right"></i>
                                </a>
                                <a href="<?php echo BASE_URL; ?>dr-apj-abdul-kalam-college-of-pharmacy" class="static-megamenu-link">
                                    <span class="name">Dr. APJ Abdul Kalam Pharmacy</span>
                                    <span class="badge-yr">2018</span>
                                    <i class="fas fa-angle-right"></i>
                                </a>
                                <a href="<?php echo BASE_URL; ?>sri-sai-college-of-pharmacy" class="static-megamenu-link">
                                    <span class="name">Sri Sai College of Pharmacy</span>
                                    <span class="badge-yr">2019</span>
                                    <i class="fas fa-angle-right"></i>
                                </a>
                                <a href="<?php echo BASE_URL; ?>sarvepalli-radhakrishnan-institute-of-pharmaceutical-science" class="static-megamenu-link">
                                    <span class="name">SRK Inst. of Pharmaceutical Sci.</span>
                                    <span class="badge-yr">2023</span>
                                    <i class="fas fa-angle-right"></i>
                                </a>
                                <a href="<?php echo BASE_URL; ?>r-n-kapoor-memorial-institute-of-pharmaceutical-science" class="static-megamenu-link">
                                    <span class="name">R. N. Kapoor Memorial Pharmacy</span>
                                    <span class="badge-yr">2023</span>
                                    <i class="fas fa-angle-right"></i>
                                </a>
                                <a href="<?php echo BASE_URL; ?>rkdf-college-of-nursing" class="static-megamenu-link">
                                    <span class="name">RKDF College of Nursing</span>
                                    <span class="badge-yr">2003</span>
                                    <i class="fas fa-angle-right"></i>
                                </a>
                            </div>

                            <!-- COL 3: Medical, Dental, Ayush, Law & Allied Sciences -->
                            <div>
                                <div class="static-megamenu-col-title">
                                    <i class="fas fa-stethoscope"></i> Medical, Law &amp; Allied
                                </div>
                                <a href="<?php echo BASE_URL; ?>rkdf-medical-college" class="static-megamenu-link">
                                    <span class="name">RKDF Medical College &amp; Hospital</span>
                                    <span class="badge-yr">2014</span>
                                    <i class="fas fa-angle-right"></i>
                                </a>
                                <a href="<?php echo BASE_URL; ?>sarvepalli-radhakrishnan-college-of-ayurveda" class="static-megamenu-link">
                                    <span class="name">SRK College of Ayurveda</span>
                                    <span class="badge-yr">2021</span>
                                    <i class="fas fa-angle-right"></i>
                                </a>
                                <a href="<?php echo BASE_URL; ?>rkdf-homoeopathic-medical-college" class="static-megamenu-link">
                                    <span class="name">RKDF Homoeopathic Medical Coll.</span>
                                    <span class="badge-yr">2000</span>
                                    <i class="fas fa-angle-right"></i>
                                </a>
                                <a href="<?php echo BASE_URL; ?>rkdf-dental-college" class="static-megamenu-link">
                                    <span class="name">RKDF Dental College &amp; Hospital</span>
                                    <span class="badge-yr">2003</span>
                                    <i class="fas fa-angle-right"></i>
                                </a>
                                <a href="<?php echo BASE_URL; ?>department-of-paramedical-sciences" class="static-megamenu-link">
                                    <span class="name">Dept. of Paramedical Sciences</span>
                                    <i class="fas fa-angle-right"></i>
                                </a>
                                <a href="<?php echo BASE_URL; ?>sarvepalli-radhakrishnan-college-of-law" class="static-megamenu-link">
                                    <span class="name">SRK College of Law</span>
                                    <span class="badge-yr">2019</span>
                                    <i class="fas fa-angle-right"></i>
                                </a>
                                <a href="<?php echo BASE_URL; ?>faculty-of-agriculture" class="static-megamenu-link">
                                    <span class="name">Faculty of Agriculture</span>
                                    <i class="fas fa-angle-right"></i>
                                </a>
                                <a href="<?php echo BASE_URL; ?>allied-sciences" class="static-megamenu-link">
                                    <span class="name">Allied Sciences</span>
                                    <i class="fas fa-angle-right"></i>
                                </a>
                            </div>

                        </div>

                        <!-- Megamenu Footer Action Bar -->
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

                <!-- 9. Student Life -->
                <li class="static-menu-item <?php echo (isset($activeNav) && in_array($activeNav, ['student-life', 'life', 'blogs'])) ? 'active' : ''; ?>">
                    <a href="<?php echo BASE_URL; ?>student-life" class="static-menu-link">
                        Student Life <span class="static-dropdown-arrow"></span>
                    </a>
                    <ul class="static-dropdown-panel">
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/sports-facilities" class="static-dropdown-link"><i class="fas fa-dumbbell text-primary me-1"></i> Sports Facilities</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/ncc-nss" class="static-dropdown-link"><i class="fas fa-medal text-warning me-1"></i> NCC &amp; NSS</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>hostel.php" class="static-dropdown-link"><i class="fas fa-bed text-warning me-1"></i> Hostel Details</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>placements" class="static-dropdown-link"><i class="fas fa-briefcase text-success me-1"></i> Placement Cell</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/student-grievance-committee" class="static-dropdown-link">Student Grievance Committee</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/ombudsman" class="static-dropdown-link">Ombudsman</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/health-facility" class="static-dropdown-link"><i class="fas fa-heartbeat text-danger me-1"></i> Health Facility</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/internal-complaint-committee" class="static-dropdown-link">Internal Complaint Committee</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/anti-ragging" class="static-dropdown-link">Anti Ragging Committee</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/equal-opportunity-cell" class="static-dropdown-link">Equal Opportunity Cell</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/sedg-cell" class="static-dropdown-link">Socio Economically Disadvantaged Groups Cell (SEDG)</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>document/differently-abled-facilities" class="static-dropdown-link">Facilities For Differently Abled Students</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>blogs" class="static-dropdown-link"><i class="fas fa-newspaper text-info me-1"></i> News, Events &amp; Blogs</a></li>
                    </ul>
                </li>
                
                <!-- Mobile: Contact Us at bottom of drawer -->
                <li class="static-menu-list-footer">
                    <a href="<?php echo (strpos($ctaLink, 'http') === 0) ? $ctaLink : BASE_URL . $ctaLink; ?>" class="static-contact-btn-mobile"><?php echo sanitize($ctaText); ?></a>
                </li>
            </ul>

            <!-- Contact Us Button -->
            <a href="<?php echo (strpos($ctaLink, 'http') === 0) ? $ctaLink : BASE_URL . $ctaLink; ?>" class="static-contact-btn"><?php echo sanitize($ctaText); ?></a>
        </div>
    </div>

    <!-- Exact Vanilla JS for Mobile Drawer, Accordion & Resize Handling -->
    <script>
    (function(){
        var overlay = document.getElementById('staticNavOverlay');
        var menu = document.getElementById('staticMenuList');
        var toggle = document.getElementById('staticMenuToggle');
        var bodyScrollY = 0;

        function lockScroll(){
            bodyScrollY = window.scrollY;
            document.body.style.position = 'fixed';
            document.body.style.top = '-' + bodyScrollY + 'px';
            document.body.style.width = '100%';
            document.body.style.overflow = 'hidden';
        }

        function unlockScroll(){
            document.body.style.position = '';
            document.body.style.top = '';
            document.body.style.width = '';
            document.body.style.overflow = '';
            window.scrollTo(0, bodyScrollY);
        }

        function openMenu(){
            if(!menu || !toggle) return;
            menu.classList.add('active');
            toggle.classList.add('is-open');
            if(overlay) overlay.classList.add('active');
            lockScroll();
            toggle.setAttribute('aria-expanded', 'true');
        }

        function closeMenu(){
            if(!menu || !toggle) return;
            menu.classList.remove('active');
            toggle.classList.remove('is-open');
            if(overlay) overlay.classList.remove('active');
            unlockScroll();
            toggle.setAttribute('aria-expanded', 'false');
        }

        function toggleMenu(){
            if(!menu) return;
            menu.classList.contains('active') ? closeMenu() : openMenu();
        }

        if(toggle) toggle.addEventListener('click', toggleMenu);
        if(overlay) overlay.addEventListener('click', closeMenu);

        document.addEventListener('keydown', function(e){
            if(e.key === 'Escape') closeMenu();
        });

        function closeAllOpen(container){
            if(!container) return;
            container.querySelectorAll('.static-menu-item.open, .static-dropdown-item.open').forEach(function(el){
                el.classList.remove('open');
            });
        }

        document.querySelectorAll('.static-menu-item > .static-menu-link, .static-dropdown-item > .static-dropdown-link').forEach(function(link){
            link.addEventListener('click', function(e){
                if(window.innerWidth > 1024) return;
                var parent = link.parentElement;
                if(!parent) return;
                var hasSub = parent.querySelector(':scope > .static-dropdown-panel, :scope > .static-sub-dropdown');
                if(!hasSub) return;
                e.preventDefault();
                e.stopPropagation();
                var isAlreadyOpen = parent.classList.contains('open');
                if(parent.parentElement){
                    var siblings = parent.parentElement.children;
                    for(var i = 0; i < siblings.length; i++){
                        var sib = siblings[i];
                        if(sib !== parent){
                            closeAllOpen(sib);
                            sib.classList.remove('open');
                        }
                    }
                }
                if(isAlreadyOpen){
                    closeAllOpen(parent);
                    parent.classList.remove('open');
                } else {
                    parent.classList.add('open');
                }
            });
        });

        var navWrapper = document.querySelector('.static-nav-wrapper');
        function handleScroll(){
            if(!navWrapper) return;
            if(window.pageYOffset > 25 || window.scrollY > 25){
                navWrapper.classList.add('is-scrolled');
            } else {
                navWrapper.classList.remove('is-scrolled');
            }
        }
        window.addEventListener('scroll', handleScroll, { passive: true });
        handleScroll();

        window.addEventListener('resize', function(){
            if(window.innerWidth > 1024){
                closeMenu();
                closeAllOpen(menu);
            }
        });
    })();
    </script>
</header>
