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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? sanitize($pageTitle) : "Home - Sarvepalli Radhakrishnan University, Bhopal"; ?></title>
    <meta name="description" content="<?php echo isset($metaDesc) ? sanitize($metaDesc) : 'SRK University, Bhopal - UGC-Recognized Premier University in MP offering Engineering, Pharmacy, Nursing, Management, Law, Agriculture & Medical Sciences.'; ?>">

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
    <style>
        *,*::before,*::after{box-sizing:border-box}
        .static-nav-wrapper{background-color:#fff;box-shadow:0 2px 12px rgba(0,0,0,0.09);font-family:'Inter','Segoe UI',Arial,sans-serif;position:sticky;top:0;z-index:9999;width:100%}
        .static-nav-container{max-width:1320px;margin:0 auto;padding:0 24px;display:flex;align-items:center;justify-content:space-between;gap:8px;min-height:76px}
        .static-nav-logo{display:flex;align-items:center;flex-shrink:0}
        .static-nav-logo img{max-height:58px;width:auto;display:block}
        .static-menu-list{list-style:none;margin:0;padding:0;display:flex;align-items:center;flex-wrap:nowrap;gap:1px;flex:1;justify-content:center}
        .static-menu-item{position:relative}
        .static-menu-link{display:flex;align-items:center;gap:4px;padding:10px 10px;color:#1e293b;text-decoration:none;font-size:13.5px;font-weight:600;letter-spacing:.1px;white-space:nowrap;transition:color 0.2s ease}
        .static-menu-link:hover,.static-menu-item.active>.static-menu-link{color:#7a0b0d}
        .static-dropdown-arrow{display:inline-block;border-left:4px solid transparent;border-right:4px solid transparent;border-top:5px solid currentColor;margin-left:3px;transition:transform 0.25s ease;flex-shrink:0}
        .static-menu-item.open>.static-menu-link .static-dropdown-arrow,.static-dropdown-item.open>.static-dropdown-link .static-dropdown-arrow{transform:rotate(180deg)}
        .static-dropdown-panel{position:absolute;top:calc(100% + 4px);left:0;background:#fff;min-width:255px;box-shadow:0 12px 36px rgba(0,0,0,0.13);border-radius:8px;border:1px solid #eef0f4;padding:6px 0;list-style:none;margin:0;opacity:0;visibility:hidden;transform:translateY(8px);transition:opacity 0.22s ease,transform 0.22s ease,visibility 0.22s;z-index:2000}
        .static-menu-item:hover>.static-dropdown-panel{opacity:1;visibility:visible;transform:translateY(0)}
        .static-menu-item:nth-last-child(2) .static-dropdown-panel,
        .static-menu-item:nth-last-child(3) .static-dropdown-panel{left:auto;right:0}
        .static-dropdown-item{position:relative}
        .static-dropdown-link{display:flex;align-items:center;justify-content:flex-start;gap:8px;padding:8px 18px;color:#334155;text-decoration:none;font-size:13px;font-weight:500;line-height:1.4;transition:all 0.18s ease;white-space:nowrap;text-align:left}
        .static-dropdown-link:hover{background-color:#fef9f0;color:#7a0b0d;padding-left:22px}
        .static-dropdown-link .static-sub-arrow{margin-left:auto}
        .static-sub-dropdown{left:100%;top:-6px;margin-top:0}
        .static-menu-item:nth-last-child(2) .static-sub-dropdown,
        .static-menu-item:nth-last-child(3) .static-sub-dropdown{left:auto;right:100%}
        .static-dropdown-item:hover>.static-sub-dropdown{opacity:1;visibility:visible;transform:translateY(0)}
        .static-sub-arrow{border-top:4px solid transparent;border-bottom:4px solid transparent;border-left:5px solid currentColor;border-right:0;flex-shrink:0}
        .static-megamenu-panel{width:880px;padding:20px 24px;left:-160px;border-radius:10px}
        .static-megamenu-grid{display:grid;grid-template-columns:1fr 1fr 1fr;gap:14px 20px}
        .static-megamenu-col-title{font-size:11px;font-weight:800;color:#7a0b0d;text-transform:uppercase;letter-spacing:.6px;margin-bottom:8px;padding-bottom:5px;border-bottom:2px solid #f0e6e6;display:flex;align-items:center;gap:6px}
        .static-megamenu-link{display:flex;align-items:center;justify-content:space-between;gap:6px;padding:6px 8px;color:#334155;text-decoration:none;font-size:12px;font-weight:500;border-radius:5px;transition:all 0.18s ease;line-height:1.35}
        .static-megamenu-link:hover{background-color:#fef9f0;color:#7a0b0d;padding-left:11px}
        .static-megamenu-link span.name{flex:1;white-space:normal}
        .static-megamenu-link span.badge-yr{font-size:9.5px;color:#64748b;background:#f1f5f9;padding:1px 5px;border-radius:4px;border:1px solid #e2e8f0;flex-shrink:0}
        .static-megamenu-link i.fa-angle-right{font-size:10px;color:#cbd5e1;flex-shrink:0}
        .static-megamenu-link:hover i.fa-angle-right{color:#7a0b0d}
        .static-menu-list-footer{display:none}
        .static-contact-btn-mobile{display:none}
        .static-contact-btn{display:inline-flex;align-items:center;flex-shrink:0;background:#7a0b0d;color:#ffffff!important;font-size:13.5px;font-weight:700;padding:10px 22px;border-radius:30px;text-decoration:none;box-shadow:0 3px 12px rgba(236,51,55,0.3);transition:background 0.2s ease,box-shadow 0.2s ease,transform 0.2s ease;white-space:nowrap;letter-spacing:.2px}
        .static-contact-btn:hover{background:#d62529;box-shadow:0 5px 18px rgba(236,51,55,0.45);color:#ffffff!important;transform:translateY(-1px)}
        .static-mobile-toggle{display:none;flex-direction:column;justify-content:center;gap:5px;background:transparent;border:none;cursor:pointer;padding:8px 6px;z-index:10001;flex-shrink:0}
        .static-mobile-toggle span{display:block;width:26px;height:2.5px;background-color:#1e293b;border-radius:3px;transition:all 0.32s cubic-bezier(.4,0,.2,1);transform-origin:center}
        .static-mobile-toggle.is-open span:nth-child(1){transform:translateY(7.5px) rotate(45deg)}
        .static-mobile-toggle.is-open span:nth-child(2){opacity:0;transform:scaleX(0)}
        .static-mobile-toggle.is-open span:nth-child(3){transform:translateY(-7.5px) rotate(-45deg)}
        .static-nav-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,0.45);z-index:9998;opacity:0;transition:opacity 0.3s ease}
        .static-nav-overlay.active{display:block;opacity:1}
        @media (max-width:1199px){
            .static-nav-container{padding:0 16px;gap:6px}
            .static-menu-link{font-size:12.5px;padding:10px 8px}
            .static-megamenu-panel{width:720px;left:-100px}
            .static-contact-btn{padding:9px 18px;font-size:13px}
        }
        @media (max-width:1024px){
            .static-nav-wrapper{position:fixed!important;top:0;left:0;right:0;width:100%}
            .site-header-static+*{margin-top:76px}
            .static-mobile-toggle{display:flex}
            .static-menu-list{position:fixed;top:0;left:-100%;width:300px;max-width:85vw;height:100vh;background:#fff;flex-direction:column;align-items:stretch;padding:76px 0 30px;overflow-y:auto;overflow-x:hidden;-webkit-overflow-scrolling:touch;overscroll-behavior:contain;box-shadow:5px 0 24px rgba(0,0,0,0.18);transition:left 0.33s cubic-bezier(.4,0,.2,1);gap:0;z-index:9999}
            .static-menu-list.active{left:0}
            .static-menu-list::before{content:'Menu';display:block;position:absolute;top:0;left:0;right:0;padding:22px 20px 18px;font-size:15px;font-weight:700;color:#7a0b0d;border-bottom:1px solid #f0f0f0;background:#fff;letter-spacing:.5px;text-transform:uppercase}
            .static-menu-item{border-bottom:1px solid #f5f5f5}
            .static-menu-link{padding:13px 20px;font-size:14px;justify-content:space-between;width:100%;border-radius:0}
            .static-dropdown-panel{position:static!important;opacity:1!important;visibility:visible!important;transform:none!important;box-shadow:none!important;border:none!important;border-radius:0!important;display:none;padding:0;padding-left:0;min-width:100%;width:100%!important;background:#fafafa;transition:none!important}
            .static-menu-item.open>.static-dropdown-panel,.static-dropdown-item.open>.static-sub-dropdown{display:block}
            .static-dropdown-link{padding:10px 20px 10px 30px;font-size:13px;white-space:normal;border-bottom:1px solid #eee;justify-content:space-between}
            .static-dropdown-link:hover{padding-left:30px}
            .static-sub-dropdown{left:0!important;top:0!important;margin-top:0;background:#f3f3f3}
            .static-sub-dropdown .static-dropdown-link{padding-left:42px}
            .static-sub-dropdown .static-dropdown-link:hover{padding-left:42px}
            .static-megamenu-panel{width:100%!important;padding:0}
            .static-megamenu-grid{grid-template-columns:1fr;gap:0}
            .static-megamenu-link{padding:10px 20px 10px 30px;font-size:13px;border-radius:0;border-bottom:1px solid #eee}
            .static-menu-list-footer{display:block;padding:20px;margin-top:auto}
            .static-contact-btn-mobile{display:flex;justify-content:center;background:#7a0b0d;color:#ffffff!important;text-decoration:none;padding:12px 24px;border-radius:30px;font-weight:700;font-size:14px;text-align:center;box-shadow:0 3px 12px rgba(236,51,55,0.3)}
            .static-contact-btn{display:none!important}
        }
    </style>

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
                <!-- Home -->
                <li class="static-menu-item <?php echo (!isset($activeNav) || $activeNav == 'home') ? 'active' : ''; ?>">
                    <a href="<?php echo BASE_URL; ?>" class="static-menu-link">Home</a>
                </li>

                <!-- About -->
                <li class="static-menu-item <?php echo (isset($activeNav) && $activeNav == 'about') ? 'active' : ''; ?>">
                    <a href="<?php echo BASE_URL; ?>about.php" class="static-menu-link">
                        About <span class="static-dropdown-arrow"></span>
                    </a>
                    <ul class="static-dropdown-panel">
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>about/why-srk" class="static-dropdown-link">Why SRK</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>about/srk-university-vision-and-mission" class="static-dropdown-link">Vision &amp; Mission</a></li>
                        
                        <!-- Accreditation -->
                        <li class="static-dropdown-item">
                            <a href="<?php echo BASE_URL; ?>about/accreditation" class="static-dropdown-link">
                                Accreditation <span class="static-dropdown-arrow static-sub-arrow"></span>
                            </a>
                            <ul class="static-dropdown-panel static-sub-dropdown">
                                <li class="static-dropdown-item"><a target="_blank" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/NIRF-2026.pdf" class="static-dropdown-link">NIRF 2026</a></li>
                                <li class="static-dropdown-item"><a target="_blank" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/Recognition-Approval.pdf" class="static-dropdown-link">Recognition &amp; Approval</a></li>
                            </ul>
                        </li>

                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>about/board-of-management" class="static-dropdown-link">Board of Management</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>about/constituent-unit" class="static-dropdown-link">Constituent Unit</a></li>

                        <!-- All Committee -->
                        <li class="static-dropdown-item">
                            <a href="#" class="static-dropdown-link">
                                All Committee <span class="static-dropdown-arrow static-sub-arrow"></span>
                            </a>
                            <ul class="static-dropdown-panel static-sub-dropdown">
                                <li class="static-dropdown-item"><a target="_blank" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/Institutional-Development-Plan.pdf" class="static-dropdown-link">Institutional Development Plan</a></li>
                                <li class="static-dropdown-item"><a target="_blank" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/EOA_Report_2020-21-1.pdf" class="static-dropdown-link">Council Of Technical Education</a></li>
                            </ul>
                        </li>

                        <!-- Act & Statutes -->
                        <li class="static-dropdown-item">
                            <a href="#" class="static-dropdown-link">
                                Act &amp; Statutes <span class="static-dropdown-arrow static-sub-arrow"></span>
                            </a>
                            <ul class="static-dropdown-panel static-sub-dropdown">
                                <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>grievance.php" class="static-dropdown-link fw-bold text-danger"><i class="fas fa-balance-scale me-1"></i> Student Grievance Portal</a></li>
                                <li class="static-dropdown-item"><a target="_blank" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/Student_Grievance_Committee.pdf" class="static-dropdown-link">Student Grievance Committee</a></li>
                                <li class="static-dropdown-item"><a target="_blank" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/AntiRagging.pdf" class="static-dropdown-link">Anti Ragging</a></li>
                                <li class="static-dropdown-item"><a target="_blank" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/SC_ST_Grievance_committee.pdf" class="static-dropdown-link">SC-ST Grievance Committee</a></li>
                                <li class="static-dropdown-item"><a target="_blank" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/OBC-Minority.pdf" class="static-dropdown-link">OBC Minority</a></li>
                                <li class="static-dropdown-item"><a target="_blank" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/women-grievance-committee.pdf" class="static-dropdown-link">Women Grievance Committee</a></li>
                                <li class="static-dropdown-item"><a target="_blank" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/EqualOppurtunityCell.pdf" class="static-dropdown-link">Equal Oppurtunity Cell</a></li>
                            </ul>
                        </li>

                        <!-- University Ordinance -->
                        <li class="static-dropdown-item">
                            <a href="#" class="static-dropdown-link">
                                University Ordinance <span class="static-dropdown-arrow static-sub-arrow"></span>
                            </a>
                            <ul class="static-dropdown-panel static-sub-dropdown">
                                <li class="static-dropdown-item"><a target="_blank" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/university-ordinance.pdf" class="static-dropdown-link">University Ordinance</a></li>
                                <li class="static-dropdown-item"><a target="_blank" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/ordinance-93-100.pdf" class="static-dropdown-link">Subsequent Ordinance 93-100</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>

                <!-- Departments & Constituent Units (Comprehensive Megamenu) -->
                <li class="static-menu-item <?php echo (isset($activeNav) && $activeNav == 'departments') ? 'active' : ''; ?>">
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
                                <a href="<?php echo BASE_URL; ?>faculty-of-science" class="static-megamenu-link">
                                    <span class="name">Faculty of Science / Arts / Yoga</span>
                                    <i class="fas fa-angle-right"></i>
                                </a>
                            </div>

                        </div>

                        <!-- Megamenu Footer Action Bar -->
                        <div class="d-flex justify-content-between align-items-center pt-3 mt-3 border-top">
                            <a href="<?php echo BASE_URL; ?>departments.php" class="small fw-bold text-danger text-decoration-none d-flex align-items-center gap-1">
                                <i class="fas fa-th-large"></i> Explore All 26 Constituent Units &amp; Faculties &rarr;
                            </a>
                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle small fw-semibold">
                                26+ Constituent Units
                            </span>
                        </div>

                    </div>
                </li>

                <!-- Courses -->
                <li class="static-menu-item <?php echo (isset($activeNav) && $activeNav == 'courses') ? 'active' : ''; ?>">
                    <a href="<?php echo BASE_URL; ?>courses" class="static-menu-link">
                        Courses <span class="static-dropdown-arrow"></span>
                    </a>
                    <ul class="static-dropdown-panel">
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>courses" class="static-dropdown-link">All Academic Courses</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>syllabus" class="static-dropdown-link">Scheme &amp; Syllabus</a></li>
                    </ul>
                </li>

                <!-- Academics -->
                <li class="static-menu-item">
                    <a href="#" class="static-menu-link">
                        Academics <span class="static-dropdown-arrow"></span>
                    </a>
                    <ul class="static-dropdown-panel">
                        <li class="static-dropdown-item"><a target="_blank" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/Details-of-Academic-Programmes.pdf" class="static-dropdown-link">Details of Academic Programmes</a></li>
                        <li class="static-dropdown-item"><a target="_blank" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/Academic-Calendar.pdf" class="static-dropdown-link">Academic Calendar</a></li>
                        <li class="static-dropdown-item"><a target="_blank" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/statutes-ordinances-pertaining-to-academics-examination.pdf" class="static-dropdown-link">Statutes Ordinances</a></li>
                        <li class="static-dropdown-item"><a target="_blank" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/Constituent-unitsDepartment.pdf" class="static-dropdown-link">School/ Department/ Centres</a></li>
                        <li class="static-dropdown-item"><a target="_blank" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/department-wise-faculty-details.pdf" class="static-dropdown-link">Faculty/ Staff Details</a></li>
                        <li class="static-dropdown-item"><a target="_blank" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/IQAC.pdf" class="static-dropdown-link">Internal Quality Assurance Cell</a></li>
                        <li class="static-dropdown-item"><a target="_blank" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/UniversityLibrary.pdf" class="static-dropdown-link">Library</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>facilities" class="static-dropdown-link">Facilities</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>placements" class="static-dropdown-link">Placements</a></li>
                    </ul>
                </li>

                <!-- Admission -->
                <li class="static-menu-item <?php echo (isset($activeNav) && $activeNav == 'admission') ? 'active' : ''; ?>">
                    <a href="<?php echo BASE_URL; ?>admission-enquiry.php" class="static-menu-link">
                        Admission <span class="static-dropdown-arrow"></span>
                    </a>
                    <ul class="static-dropdown-panel">
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>admission-enquiry.php" class="static-dropdown-link fw-bold text-danger">Online Admission Form 2026-27</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>phd-admission.php" class="static-dropdown-link fw-bold text-danger">Ph.D. Admission 2026</a></li>
                        <li class="static-dropdown-item"><a target="_blank" href="<?php echo BASE_URL; ?>assets/uploads/pdf/phd-application-form.pdf" class="static-dropdown-link">Ph.D. Application Form (PDF)</a></li>
                        <li class="static-dropdown-item"><a target="_blank" href="<?php echo BASE_URL; ?>assets/uploads/pdf/phd-entrance-form.pdf" class="static-dropdown-link">Ph.D. Entrance Exam Form (PDF)</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>student-life" class="static-dropdown-link">Student Life</a></li>
                        <li class="static-dropdown-item"><a target="_blank" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/Prospectus.pdf" class="static-dropdown-link">Prospectus</a></li>
                        <li class="static-dropdown-item"><a target="_blank" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/Admission-ProcessGuidelines.pdf" class="static-dropdown-link">Admission Process Guidelines</a></li>
                        <li class="static-dropdown-item"><a target="_blank" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/Fee-Refund-Policy-2024-25.pdf" class="static-dropdown-link">Fee Refund Policy 2024-25</a></li>
                    </ul>
                </li>

                <!-- Administration -->
                <li class="static-menu-item">
                    <a href="#" class="static-menu-link">
                        Administration <span class="static-dropdown-arrow"></span>
                    </a>
                    <ul class="static-dropdown-panel">
                        <li class="static-dropdown-item"><a target="_blank" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/OfficersofUniversity.pdf" class="static-dropdown-link">Officers of University</a></li>
                        
                        <!-- Authority Of University -->
                        <li class="static-dropdown-item">
                            <a href="#" class="static-dropdown-link">
                                Authority Of University <span class="static-dropdown-arrow static-sub-arrow"></span>
                            </a>
                            <ul class="static-dropdown-panel static-sub-dropdown">
                                <li class="static-dropdown-item"><a target="_blank" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/Governing-Body.pdf" class="static-dropdown-link">Governing Body</a></li>
                                <li class="static-dropdown-item"><a target="_blank" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/Board-of-Management.pdf" class="static-dropdown-link">Board of Management</a></li>
                                <li class="static-dropdown-item"><a target="_blank" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/Finance-Committee.pdf" class="static-dropdown-link">Finance Committee</a></li>
                                <li class="static-dropdown-item"><a target="_blank" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/ACADEMIC-COUNCIL-20.pdf.pdf" class="static-dropdown-link">Academic Councils</a></li>
                                <li class="static-dropdown-item"><a target="_blank" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/BoardofStudies.pdf" class="static-dropdown-link">Board Of Studies</a></li>
                            </ul>
                        </li>

                        <li class="static-dropdown-item"><a target="_blank" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/Internal-Complaint-Committee.pdf" class="static-dropdown-link">Internal Complaint Committee</a></li>
                        <li class="static-dropdown-item"><a target="_blank" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/AcademicLeadership.pdf" class="static-dropdown-link">Academic Leadership</a></li>
                    </ul>
                </li>

                <!-- Research -->
                <li class="static-menu-item <?php echo (isset($activeNav) && $activeNav == 'research') ? 'active' : ''; ?>">
                    <a href="<?php echo BASE_URL; ?>research-innovation" class="static-menu-link">
                        Research <span class="static-dropdown-arrow"></span>
                    </a>
                    <ul class="static-dropdown-panel">
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>phd-admission.php" class="static-dropdown-link fw-bold text-danger">Ph.D. Admissions &amp; Forms</a></li>
                        <li class="static-dropdown-item"><a target="_blank" href="<?php echo BASE_URL; ?>assets/uploads/pdf/phd-application-form.pdf" class="static-dropdown-link">Ph.D. Application Form (PDF)</a></li>
                        <li class="static-dropdown-item"><a target="_blank" href="<?php echo BASE_URL; ?>assets/uploads/pdf/phd-entrance-form.pdf" class="static-dropdown-link">Ph.D. Entrance Exam Form (PDF)</a></li>
                        <li class="static-dropdown-item"><a target="_blank" href="<?php echo BASE_URL; ?>assets/uploads/pdf/phd-admission-policy.pdf" class="static-dropdown-link">Admission Policy for Ph.D. Programme</a></li>
                        <li class="static-dropdown-item"><a href="<?php echo BASE_URL; ?>incubation-center" class="static-dropdown-link">Incubation Centre</a></li>
                        <li class="static-dropdown-item"><a target="_blank" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/researchdevelopmentcell.pdf" class="static-dropdown-link">Research &amp; Development Cell</a></li>
                        <li class="static-dropdown-item"><a target="_blank" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/university_research_policy.pdf" class="static-dropdown-link">Research Policy</a></li>
                        <li class="static-dropdown-item"><a target="_blank" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/Central-Facilities-for-Research-and-Development.pdf" class="static-dropdown-link">Central Facilities for Research and Development</a></li>
                        <li class="static-dropdown-item"><a target="_blank" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/Constitution-of-Ethics-Board.pdf" class="static-dropdown-link">Ethics Board to Maintain Research Integrity</a></li>
                        <li class="static-dropdown-item"><a target="_blank" href="<?php echo BASE_URL; ?>assets/uploads/2026/07/consultancy-projects.pdf" class="static-dropdown-link">Consultancy Projects</a></li>
                        <li class="static-dropdown-item"><a target="_blank" href="<?php echo BASE_URL; ?>assets/uploads/pdf/phd-scholars-pursuing.pdf" class="static-dropdown-link">Ph.D. Scholars Currently Enrolled</a></li>
                        <li class="static-dropdown-item"><a target="_blank" href="<?php echo BASE_URL; ?>assets/uploads/pdf/phd-scholars-completed.pdf" class="static-dropdown-link">Ph.D. Awarded Scholars List</a></li>
                    </ul>
                </li>

                <!-- Blogs -->
                <li class="static-menu-item <?php echo (isset($activeNav) && $activeNav == 'blogs') ? 'active' : ''; ?>">
                    <a href="<?php echo BASE_URL; ?>blogs" class="static-menu-link">Blogs</a>
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
                var parent = this.parentElement;
                var hasSub = parent.querySelector(':scope > .static-dropdown-panel');
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

        window.addEventListener('resize', function(){
            if(window.innerWidth > 1024){
                closeMenu();
                closeAllOpen(menu);
            }
        });
    })();
    </script>
</header>
