<?php
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/header_menu_render.php';
$helpline = getSetting('header_topbar_phone', getSetting('helpline', '0755 - 4911204'));
$email = getSetting('header_topbar_email', getSetting('email', 'exam@srku.edu.in'));
$erpLink = getSetting('header_topbar_erp_link', 'https://erp.srku.edu.in/');
$aicteLink = getSetting('header_topbar_aicte_link', 'https://sarswati.aicte.gov.in/');
$logoUrl = getSetting('header_logo_url', 'assets/uploads/2026/07/SRK-logo.webp');
$ctaText = getSetting('header_cta_text', 'Contact Us');
$ctaLink = getSetting('header_cta_link', 'contact.php');
$webmailLink = getSetting('header_topbar_webmail_link', 'http://email.godaddy.com/');
$customHeadCode = getSetting('header_custom_head_code', '');

// Dynamic SEO & Meta Manager Resolution
$protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http");
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$reqUri = $_SERVER['REQUEST_URI'] ?? '/';
$currentFullUrl = "$protocol://$host$reqUri";

$currentScriptName = basename($_SERVER['PHP_SELF'] ?? 'index.php');
$currentQueryString = $_SERVER['QUERY_STRING'] ?? '';
$pageIdCandidate = !empty($pageIdentifier) ? $pageIdentifier : (!empty($currentQueryString) ? ($currentScriptName . '?' . $currentQueryString) : $currentScriptName);

$seoResolved = getSeoMetadata(
    $pageIdCandidate,
    isset($pageTitle) ? $pageTitle : '',
    isset($pageDesc) ? $pageDesc : (isset($metaDesc) ? $metaDesc : ''),
    isset($pageKeywords) ? $pageKeywords : '',
    isset($pageImage) ? $pageImage : ''
);

$seoTitle = sanitize($seoResolved['title']);
$seoDesc = sanitize($seoResolved['description']);
$seoKeywords = sanitize($seoResolved['keywords']);
$seoRobots = $seoResolved['robots'];
$canonicalUrl = !empty($pageCanonical) ? $pageCanonical : (!empty($seoResolved['canonical']) ? $seoResolved['canonical'] : $currentFullUrl);
$ogTitle = sanitize($seoResolved['og_title']);
$ogDesc = sanitize($seoResolved['og_description']);
$rawOgImage = !empty($seoResolved['og_image']) ? $seoResolved['og_image'] : $logoUrl;
$seoImage = (strpos($rawOgImage, 'http') === 0) ? $rawOgImage : (BASE_URL . ltrim($rawOgImage, '/'));
$twitterCard = $seoResolved['twitter_card'] ?? 'summary_large_image';
$customSchemaJson = $seoResolved['schema_json'] ?? '';
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
    <meta name="robots" content="<?php echo htmlspecialchars($seoRobots); ?>">
    <meta name="author" content="Sarvepalli Radhakrishnan University, Bhopal">
    <link rel="canonical" href="<?php echo htmlspecialchars($canonicalUrl); ?>">

    <!-- Geographic & Regional Meta Tags (Local SEO & AEO) -->
    <meta name="geo.region" content="IN-MP">
    <meta name="geo.placename" content="Bhopal, Madhya Pradesh">
    <meta name="geo.position" content="23.1685;77.4682">
    <meta name="ICBM" content="23.1685, 77.4682">

    <!-- Open Graph Protocol (Facebook, LinkedIn, WhatsApp & AI Engines) -->
    <meta property="og:locale" content="en_IN">
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?php echo $ogTitle; ?>">
    <meta property="og:description" content="<?php echo $ogDesc; ?>">
    <meta property="og:url" content="<?php echo htmlspecialchars($canonicalUrl); ?>">
    <meta property="og:site_name" content="Sarvepalli Radhakrishnan University (SRKU)">
    <meta property="og:image" content="<?php echo htmlspecialchars($seoImage); ?>">
    <meta property="og:image:alt" content="Sarvepalli Radhakrishnan University Campus">

    <!-- Twitter Cards (Social & Conversational Search) -->
    <meta name="twitter:card" content="<?php echo htmlspecialchars($twitterCard); ?>">
    <meta name="twitter:title" content="<?php echo $ogTitle; ?>">
    <meta name="twitter:description" content="<?php echo $ogDesc; ?>">
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
    <?php if (!empty($customSchemaJson)): ?>
    <!-- Custom Page JSON-LD Structured Data Override (Configured via Dynamic SEO Manager) -->
    <script type="application/ld+json">
    <?php echo $customSchemaJson; ?>
    </script>
    <?php endif; ?>

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
                <?php
                $activeTopbarLinks = getTopbarLinks();
                foreach ($activeTopbarLinks as $tbl):
                    $tbUrl = $tbl['url'] ?? '';
                    if ($tbUrl !== '' && strpos($tbUrl, 'http') !== 0 && strpos($tbUrl, 'mailto:') !== 0 && strpos($tbUrl, 'tel:') !== 0 && strpos($tbUrl, '#') !== 0) {
                        $tbUrl = BASE_URL . ltrim($tbUrl, '/');
                    }
                    $tbTarget = !empty($tbl['target']) ? $tbl['target'] : '_self';
                    $tbIcon = !empty($tbl['icon']) ? $tbl['icon'] : 'fas fa-link text-warning';
                ?>
                <a href="<?php echo sanitize($tbUrl); ?>" target="<?php echo sanitize($tbTarget); ?>" class="topbar-link">
                    <i class="<?php echo sanitize($tbIcon); ?> me-1"></i> <?php echo sanitize($tbl['label'] ?? ''); ?>
                </a>
                <?php endforeach; ?>
            </div>
            <div class="d-flex align-items-center gap-3 ms-auto ms-md-0">
                <span class="topbar-info"><i class="fas fa-phone-alt me-1 text-warning"></i> <?php echo sanitize($helpline); ?></span>
                <a href="mailto:<?php echo sanitize($email); ?>" class="topbar-info d-none d-sm-inline"><i class="fas fa-envelope me-1 text-warning"></i> <?php echo sanitize($email); ?></a>
                <a href="<?php echo sanitize($webmailLink); ?>" target="_blank" class="topbar-link text-warning fw-bold"><i class="fas fa-envelope-open-text me-1"></i> Webmail</a>
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
                <?php renderHeaderNavigationMenu($activeNav ?? ''); ?>
                
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
